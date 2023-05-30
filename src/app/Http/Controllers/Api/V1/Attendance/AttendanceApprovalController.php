<?php

namespace App\Http\Controllers\Api\V1\Attendance;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\LRosterShift;
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

class AttendanceApprovalController extends Controller {

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
        $employeeId = $request->get('emp_id');
        $monthYear = $request->get('month_year');
        $startDate = '';
        $endDate = '';

        if($monthYear) {
            $startDateTime = new \DateTime("first day of $monthYear");
            $startDate = $startDateTime->format('Y-m-d');

            $endDateTime = new \DateTime("last day of $monthYear");
            $endDateTime = $endDateTime->modify( '+1 day' ); //Need to create date range.

            $endDate = $endDateTime->format('Y-m-d');

            $employeeAttendanceTempEntity = new EmpAttendance();
//            $employeeAttendancesTemp = $employeeAttendanceTempEntity->where(
//                [
//                    ['emp_id', '=', $employeeId],
//                    ['approve_status', '=', '0'],
//                    ['roster_date', '>=',$startDate],
//                    ['roster_date', '<=',$endDate],
//                ]
//            )->orderBy('roster_date')->get();
            $employeeAttendancesTemp = DB::select('select ATTENDANCE.individual_atten_approval(:p_emp_id,:p_date_from,:p_date_to) from dual', ['p_emp_id' => $employeeId,'p_date_from' => $startDate,'p_date_to' => $endDate]);

             return $employeeAttendancesTemp;
        }

        return [];
    }

    public function departmentSearch(Request $request)
    {
//        dd($request->all());
        $department_id = $request->get('department_id');
        $roster_date = $request->get('roster_date');
        $startDate = '';
        $endDate = '';

        if($roster_date) {

//            $employeeAttendanceTempEntity = new EmpAttendance();
//            $employeeAttendancesTemp = $employeeAttendanceTempEntity->where(
//                [
//                    ['department_id', '=', $department_id],
//                    ['approve_status', '=', '0'],
////                    ['roster_date', '>=',date('Y-m-d',strtotime($date))],
//                    ['roster_date', '=',date('Y-m-d',strtotime($date))],
//                ]
//            )->orderBy('roster_date')->get();
            $employeeAttendancesTemp = DB::select('select ATTENDANCE.department_wise_atten_approval(:p_roster_date,:p_department_id) from dual', ['p_roster_date' => date('Y-m-d',strtotime($roster_date)),  'p_department_id' => $department_id]);

           // dd($employeeAttendancesTemp);
            return $employeeAttendancesTemp;
        }

        return [];
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {
            $attendances = $request->all();
            $totalAttendenceRowUpdated = 0;
            if($attendances) {
                foreach($attendances as $attendance) {
                    $params = [];
                    if($attendance['approve_status'] != '0') {
                        $status_code = sprintf("%4000s","");
                        $status_message = sprintf("%4000s","");
                        $params = [
                            'p_attendance_id' => $attendance['attendance_id'],
                            'p_comments' => $attendance['comments'],
                            'p_approve_status' => $attendance['approve_status'],
                            'p_in_time' => $attendance['in_time'],
                            'p_out_time' => $attendance['out_time'],
                            'p_update_by' => auth()->id(),
                            'o_status_code' => &$status_code,
                            'o_status_message' => &$status_message
                        ];
                        //dd($params);
                        DB::executeProcedure("attendance.emp_attendance_approve", $params);

                        if ($params['o_status_code'] != 1) {
                            DB::rollBack();
                            return $params;
                        }
                        $totalAttendenceRowUpdated++;
                    }
                }

                if($totalAttendenceRowUpdated) {
                    DB::commit();
                    return ['o_status_code' => 1, 'o_status_message' =>"$totalAttendenceRowUpdated attendance approved successfully."];
                }
            }
        } catch(\Exception $exception) {
            DB::rollBack();
            return ['o_status_code' => 1, 'o_status_message' =>$exception->getMessage()];
        }
    }

    private function loadData()
    {
        return [
            'months_years_options' => $this->createMonthYearOptions(),
        ];
    }

    private function createMonthYearOptions()
    {
        $currentMonthYear = [
            'value' => date('Y-m').'',
            'text' => date('Y-M').''
        ];

        $previousMonthYear = [
            'value' => date('Y-m', strtotime(date('d-m-Y').' -1 month')).'',
            'text' => date('Y-M', strtotime(date('d-m-Y').' -1 month')).''
        ];

        $monthsYears = [
            $currentMonthYear,
            $previousMonthYear
        ];

        return $monthsYears;
    }
}
