<?php

namespace App\Http\Controllers\Api\V1\Leave;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\LLeaveType;
use App\Entities\Admin\LRosterShift;
use App\Entities\Leave\EmpLeaveTemp;
use App\Entities\Pmis\Employee\EmpAttendance;
use App\Entities\Pmis\Employee\EmpAttendanceTemp;
use App\Entities\Pmis\Employee\EmpLeave;
use App\Entities\Pmis\Employee\Employee;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
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
    public function load(Request $request) {
        $empLeave = new EmpLeave();

        if ($empId = $request->get('emp_id'))
            $empLeave = $empLeave->where('emp_id', $empId);

        return [
            "leaves" => $empLeave->get(),
            "departments" => $this->adminManager->findDepartments()
        ];
    }
    public function loadAll(Request $request) {
        $shifts = new LRosterShift();
        $shifts = $shifts->get();
        $shiftData=[];
        foreach ($shifts as $shift) {
            $shiftOtions = [];
            $shiftOtions['text'] = $shift->shift_code;
            $shiftOtions['value'] = $shift;
            $shiftData[] = $shiftOtions;
        }
        $employeeAttendanceTemp = new EmpAttendanceTemp();
        $records = $employeeAttendanceTemp->where('approve_status','=','0')->get();
        return [
            "shifts" => $shiftData,
            "records" => $records
        ];
    }

    public function approved(Request $request){
        $status_code = sprintf("%4000s", "");
        $status_message = sprintf("%4000s", "");
        foreach($request->post() as $data)
        {
            if(isset($data['registerApproval'])){
                $params = [
                    "p_attendance_id" => $data["attendance_id"],
                    "p_remarks" => '',
                    "p_approve_status" => $data["registerApproval"],
                    "p_update_by" => auth()->id(),
                    "o_status_code" => &$status_code,
                    "o_status_message" => &$status_message,
                ];
                DB::executeProcedure("attendance.emp_attendance_approve", $params);
            }
        }
        return $params;
    }

    public function approvalList(Request $request){
        $department = $request->get("department");
        $section = $request->get("section");
        $roster_date = $request->get("roster_date");
        $emp_id = $request->get("emp_id");
        $where = [];
        if($section > 0) {
            $where[] =['employee.section_id','=',$section];
        }
        if($department > 0) {
            $where[] = ['emp_attendance_temp.department_id','=',$department];
        }
        if($emp_id > 0) {
            $where[] = ['emp_attendance_temp.emp_id','=',$emp_id];
        }
        if ($roster_date = $request->get('roster_date')) {
            $where[] = ['emp_attendance_temp.roster_date','=',$roster_date];
        }
        $where[] = ['emp_attendance_temp.approve_status','=','0'];

        $query = DB::table('emp_attendance_temp')
            ->leftJoin('employee', function ($join) {
                $join->on('employee.emp_id', '=', 'emp_attendance_temp.emp_id');
            })
            ->leftJoin('l_department', function ($join) {
                $join->on('employee.dpt_department_id', '=', 'l_department.department_id');
            })
            ->leftJoin('l_dpt_section', function ($join) {
                $join->on('employee.section_id', '=', 'l_dpt_section.dpt_section_id');
            })
            ->leftJoin('l_designation', function ($join) {
                $join->on('employee.designation_id', '=', 'l_designation.designation_id');
            })
            ->leftJoin('l_roster_shift', function ($join) {
                $join->on('l_roster_shift.shift_id', '=', 'employee.shift_id');
            })
            ->where($where)
            ->select(
                'employee.emp_name',
                'employee.emp_code',
                'l_designation.designation',
                'l_roster_shift.*',
                'l_department.department_name',
                'l_dpt_section.dpt_section',
                'emp_attendance_temp.*'
            )->get();
        return $query;
    }

    public function save(Request $request){
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $attendance_id = $request->get("attendance_id");
            $params = [
                "p_attendance_id" => $attendance_id,
                "p_roster_date" => date("Y-m-d", strtotime($request->get("roster_date"))),
                "p_emp_id" => $request->get("emp_id"),
                "p_shift_id" => $request->get("shift")['shift_id'],
                "p_in_time" => date("Y-m-d H:i", strtotime($request->get("in_time"))),
                "p_out_time" => date("Y-m-d H:i", strtotime($request->get("out_time"))),
                "p_off_day_yn" => $request->get("off_day_yn"),
                "p_holiday_yn" => $request->get("holiday_yn"),
                "p_leave_id" => $request->get("leave_id"),
                "p_onleave_yn" => 'N',
                "p_department_id" => $request->get("department_id"),
                "p_remarks" => $request->get("remarks"),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("attendance.emp_attendance_temp_ins", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }
    public function getTempAttendance(Request $request) {
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $orderBy = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $query = DB::table('employee')
            ->join('emp_attendance_temp', function ($join) use ($request) {
                $join->on('employee.emp_id', '=', 'emp_attendance_temp.emp_id');
            })
            ->leftJoin('l_designation', function ($join) {
                $join->on('employee.designation_id', '=', 'l_designation.designation_id');
            })
            ->select(
                'employee.emp_name',
                'employee.emp_code',
                'l_designation.designation',
                'l_designation.designation_bng',
                'emp_attendance_temp.*'
            );
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    public function update(Request $request) {

    }

    public function index(Request $request) {
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $orderBy = $request->input('dir', 'asc');
        $searchValue = $request->input('search');
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $department_id = $request->get('department_id');
        $dpt_section_id = $request->get('dpt_section_id');
        $where = [];
        if($dpt_section_id > 0) {
            $where[] =['employee.section_id','=',$dpt_section_id];
        }
        if($department_id > 0) {
            $where[] = ['emp_attendance.department_id','=',$department_id];
        }
        if ($emp_name = $request->get('emp_name')) {
            $where[] = ['employee.emp_name','like',"%".$emp_name."%"];
        }
        if ($emp_code = $request->get('emp_code')) {
            $where[] = ['employee.emp_code','=',$emp_code];
        }

        $query = DB::table('employee')
            ->join('emp_attendance', function ($join) use ($request) {
                $where = [];
                $date = ($request->get('date'))?$request->get('date'):date("Y-m-d");
                if ($date) {
                    $startAt = date("Y-m-d 00:00:00", strtotime($date));
                    $endAt = date("Y-m-d 23:59:59", strtotime($date));
                    $where[] = ['emp_attendance.roster_date','>=',$startAt];
                    $where[] = ['emp_attendance.roster_date','<',$endAt];
                }
                $join->on('employee.emp_id', '=', 'emp_attendance.emp_id')->where($where);
            })
            ->leftJoin('l_designation', function ($join) {
                $join->on('employee.designation_id', '=', 'l_designation.designation_id');
            })->where($where)
            ->select(
                'employee.emp_name',
                'employee.emp_code',
                'l_designation.designation',
                'l_designation.designation_bng',
                'emp_attendance.*'
            );


        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function view($id) {
        $attendance = new EmpAttendance();
        return $attendance->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function viewData($id) {
        $attendanceTemp = new EmpAttendanceTemp();
        $attendanceTemp = $attendanceTemp->find($id);
        $attendanceTemp->employee;
        return $attendanceTemp;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function post(Request $request) {
        return $this->emp_attendance_temp_ins($request);
    }

    public function emp_attendance_temp_ins(Request $request)
    {
        try {

            /**
             * emp_attendance_temp_ins (
            p_attendance_id    IN     NUMBER DEFAULT NULL,
            p_roster_date      IN     DATE,
            p_emp_id           IN     NUMBER,
            p_shift_id         IN     NUMBER,
            p_in_time          IN     DATE,
            p_out_time         IN     DATE,
            p_off_day_yn       IN     VARCHAR2,
            p_holiday_yn       IN     VARCHAR2,
            p_leave_id         IN     NUMBER,
            p_onleave_yn       IN     VARCHAR2,
            p_department_id    IN     NUMBER,
            p_insert_by        IN     NUMBER,
            o_status_code         OUT NUMBER,
            o_status_message      OUT VARCHAR)
             */
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $attendance_id = $request->get("attendance_id");
            $params = [
                "p_attendance_id" => $attendance_id,
                "p_roster_date" => date("Y-m-d", strtotime($request->get("roster_date"))),
                "p_emp_id" => $request->get("emp_id"),
                "p_shift_id" => $request->get("shift_id"),
                "p_in_time" => date("Y-m-d H:i", strtotime($request->get("in_time"))),
                "p_out_time" => date("Y-m-d H:i", strtotime($request->get("out_time"))),
                "p_off_day_yn" => $request->get("off_day_yn"),
                "p_holiday_yn" => $request->get("holiday_yn"),
                "p_leave_id" => $request->get("leave_id"),
                "p_onleave_yn" => $request->get("onleave_yn"),
                "p_department_id" => $request->get("department_id"),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("attendance.emp_attendance_temp_ins", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }
}
