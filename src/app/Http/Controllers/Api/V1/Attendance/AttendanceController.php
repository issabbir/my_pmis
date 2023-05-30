<?php

namespace App\Http\Controllers\Api\V1\Attendance;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\LRosterShift;
use App\Entities\Overtime\OtMonths;
use App\Entities\Pmis\Employee\EmpAcademicHolidayDuty;
use App\Entities\Pmis\Employee\EmpAttendance;
use App\Entities\Pmis\Employee\EmpAttendanceTemp;
use App\Entities\Pmis\Employee\EmpLeave;
use App\Entities\Pmis\Employee\Employee;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;
use PDO;

class AttendanceController extends Controller {

    protected $adminManager;

    public function __construct(AdminContract $adminManager) {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        return $this->loadData();
    }

    public function search(Request $request)
    {

        $department_id = null;
//        if(Auth::user()->hasPermission('CAN_SEE_ONLY_SELF_DEPARTMENT')){
//            $department_id = Auth::user()->employee->dpt_department_id;
//        }
        // dd($department_id);
        $employeeId = $request->get('emp_id');
        $monthYear = $request->get('month_year');
        $data = DB::select('select ATTENDANCE.PER_EMP_MONTHLY_ATTEN_DTL(:empId, :month,:department_id) from dual', ['empId' => $employeeId, 'month' => $monthYear, 'department_id' => $department_id]);
        return $data;
    }

    public function calHour(Request $request) {
        try {
            $data = DB::select('select ATTENDANCE.TIME_DURATION(:p_in_time,:p_out_time,:p_roster_date,:p_shift_id,:p_show_format) as work_hours from dual',
                [
                    'p_in_time' => $request->get('in_time'),
                    'p_out_time' => $request->get('out_time'),
                    'p_roster_date' => $request->get('roster_date'),
                    'p_shift_id' => $request->get('shift_id'),
                    'p_show_format' => 'T'
                ]
            );
        }
        catch (\Exception $e) {
            return [['o_status_code' => 99, 'o_status_message' => "Hour must be between 0 and 23"]];
        }

        return $data;
    }

    public function academicStatus(Request $request) {
        try {
           // dd(date('Y-m-d',strtotime($request->get('roster_date'))));
            if ($request->get('in_time')){
                $data = EmpAcademicHolidayDuty::where('emp_code',$request->get('emp_code'))
                    ->where('duty_start_date',date('Y-m-d',strtotime($request->get('roster_date'))))
                    ->where('approve_yn','Y')
                    ->first();
              //  dd($data);
                if (filled($data)){
                    return ['o_status_code' => 1,'remarks'=>'On Duty'];
                }
                return ['o_status_code' => 99,'o_status_message'=>'Not approve for duty'];
            }
            return ['o_status_code' => 99,'o_status_message'=>'In time  not found'];
        }
        catch (\Exception $e) {
            return ['o_status_code' => 99, 'o_status_message' => "No data found"];
        }


    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {
            $attendances = $request->all();
            $totalAttendenceRowUpdated = 0;
            if($attendances) {

                foreach($attendances as $attendance) {
                    $params = [];
                    if($attendance['is_disabled'] == 0) {
                        $work_hours = $attendance['work_hours'];
                        $work_hoursArr = explode(':',$work_hours);
                        $work_hour = $work_hoursArr[0].'.'.$work_hoursArr[1];
                        $status_code = sprintf("%4000s","");
                        $status_message = sprintf("%4000s","");
                        $params = [
                            'p_attendance_id' => $attendance['attendance_id'],
                            'p_roster_date' => date('Y-m-d',strtotime($attendance['roster_date'])),
                            'p_emp_id' => $attendance['emp_id'],
                            'p_in_time' => $attendance['in_time'],
                            'p_out_time' =>$attendance['out_time'],
                            'p_remarks' => $attendance['remarks'],
                            'p_academic_remarks' => isset($attendance['academic_remarks']) ? $attendance['academic_remarks'] : '',
                            'p_comments' => isset($attendance['comments']) ? $attendance['comments'] : '',
                            'p_work_hours' => (float)$work_hour,
                            'p_insert_by' => auth()->id(),
                            'o_status_code' => &$status_code,
                            'o_status_message' => &$status_message
                        ];

                        DB::executeProcedure("ATTENDANCE.EMP_ATTENDANCE_INS", $params);
                        if ($params['o_status_code'] != 1) {
                            DB::rollBack();
                            return $params;
                        }
                        $totalAttendenceRowUpdated++;
                   }
                }

                if($totalAttendenceRowUpdated) {
                    DB::commit();
                    return ['o_status_code' => 1, 'o_status_message' =>"$totalAttendenceRowUpdated attendance saved successfully."];
                }
            }
        } catch(\Exception $exception) {
            DB::rollBack();
            return ['o_status_code' => 1, 'o_status_message' =>$exception->getMessage()];
        }
    }

    private function getHoursMinutes($interval)
    {
        $format = '%02s:%02s';
        $hours = $interval->h;
        $hours = $hours + ($interval->days*24);

        return sprintf($format, $hours, $interval->i);

    }

    /*private function createAbstractAttendanceTable($startDateString, $endDateString, $empId, $obtainedAttendanceTableData)
    {
        $abstractAttendanceTable = [];
        $begin = new \DateTime($startDateString);
        $end = new \DateTime($endDateString);
        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);

        foreach ($period as $key => $date) {
            $dateTimeFormat = $date->format('Y-m-d 00:00:00');

            $indexOfObtainedAttendanceTableData = array_search($dateTimeFormat, array_column($obtainedAttendanceTableData, 'roster_date'));

            if($indexOfObtainedAttendanceTableData !== false) {
                $obtainedAttendanceRow = $obtainedAttendanceTableData[$indexOfObtainedAttendanceTableData];

                $abstractAttendanceTable[$key]['attendance_id'] = $obtainedAttendanceRow['attendance_id'];
                $abstractAttendanceTable[$key]['roster_date'] = $date->format('Y-m-d');
                $abstractAttendanceTable[$key]['emp_id'] = $obtainedAttendanceRow['emp_id'];
                $abstractAttendanceTable[$key]['in_time'] = $obtainedAttendanceRow['in_time'];
                $abstractAttendanceTable[$key]['out_time'] = $obtainedAttendanceRow['out_time'];

                $inTime = new \DateTime($obtainedAttendanceRow['in_time']);
                $outTime = new \DateTime($obtainedAttendanceRow['out_time']);
                $interval = $outTime->diff($inTime);

                $abstractAttendanceTable[$key]['work_hours'] = $this->getHoursMinutes($interval);
                $abstractAttendanceTable[$key]['remarks'] = $obtainedAttendanceRow['remarks'];
                $abstractAttendanceTable[$key]['disabled'] = true;
                $abstractAttendanceTable[$key]['edited'] = false;
            } else {
                $abstractAttendanceTable[$key]['attendance_id'] = '';
                $abstractAttendanceTable[$key]['roster_date'] = $date->format('Y-m-d');
                $abstractAttendanceTable[$key]['emp_id'] = $empId;
                $abstractAttendanceTable[$key]['in_time'] = '';
                $abstractAttendanceTable[$key]['out_time'] = '';
                $abstractAttendanceTable[$key]['work_hours'] = '';
                $abstractAttendanceTable[$key]['remarks'] = '';
                $abstractAttendanceTable[$key]['disabled'] = true;
                $abstractAttendanceTable[$key]['edited'] = false;
            }
        }

        return $abstractAttendanceTable;
    }*/


    private function createAbstractAttendanceTable($obtainedAttendanceTableData)
    {
        if($obtainedAttendanceTableData) {
            foreach($obtainedAttendanceTableData as $key => $obtainedAttendanceRow) {
                $inTime = new \DateTime($obtainedAttendanceRow['in_time']);
                $outTime = new \DateTime($obtainedAttendanceRow['out_time']);
                $interval = $outTime->diff($inTime);

                $obtainedAttendanceTableData[$key]['work_hours'] = $this->getHoursMinutes($interval);
                $obtainedAttendanceTableData[$key]['disabled'] = true;
                $obtainedAttendanceTableData[$key]['edited'] = false;
            }
        }

        return $obtainedAttendanceTableData;
    }

    private function loadData()
    {
        return [
            'months_years_options' => $this->createMonthYearOptions(),
        ];
    }

    private function createMonthYearOptions()
    {
        $otMonth = new OtMonths();
        $otMonths = $otMonth->where('open_yn', 'O')->get([DB::raw("to_char(effective_start_date, 'yyyy-mm') as month" ), DB::raw("to_char(effective_start_date, 'yyyy-Month') as ot_month")]);

        $monthsOptions = array();
        foreach ($otMonths as $item) {
            $monthsOptions[] = ["text" => $item->ot_month,
                'value' => $item->month];
        }
        return $monthsOptions;
    }

    /**
     * Get Month action
     *
     * @return array
     */
    public function getMonthAction() {
        $otMonth = new OtMonths();
        $otMonths = $otMonth->where('open_yn', 'O')->get(['ot_month_id', DB::raw("to_char(effective_start_date, 'yyyy-Month') as ot_month")]);

        $monthsOptions = array();
        foreach ($otMonths as $item) {
            $monthsOptions[] = ["text" => $item->ot_month,
                'value' => $item->ot_month_id];
        }
        return [
            'months_years_options' => $monthsOptions
        ];
    }

    public function processAttendance(Request $request) {
        return $this->ATTENDANCE_EMP_ATTENDANCE_UPDATE_PROCESS($request);
    }

    private function ATTENDANCE_EMP_ATTENDANCE_UPDATE_PROCESS(Request $request)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [

                "p_month_id" => $request->get("month_id"),
                "p_update_by" => \auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("ATTENDANCE.EMP_ATTENDANCE_UPDATE_PROCESS", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, 'o_status_code' => 999, "status" => false, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }
}
