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

class AttendanceDetailsController extends Controller {

    protected $adminManager;

    public function __construct(AdminContract $adminManager) {
        $this->adminManager = $adminManager;
    }

    public function index()
    {
        return [
             "departments" => $this->adminManager->findDepartments(),
             "sections" => $this->adminManager->findDptSections(),
             "leave_types" => $this->adminManager->findLeaveType()
        ];
    }

    public function searchAttendanceDetails(Request $request){
         //dd($request->all());
        $department_id = $request->get('department_id');
        $dpt_section_id = $request->get('dpt_section_id');
        $emp_id = $request->get('selectedEmployee')['emp_id'];
        $type = $request->get('type');
        $from_date =  date('Y-m-d', strtotime($request->get('from_date')));
        $to_date =  date('Y-m-d', strtotime($request->get('to_date')));

        $query = "Select attendance.emp_monthly_attendence_summary(".$department_id.",'".$dpt_section_id."','".$from_date."','".$to_date."','".$emp_id."','".$type."') a from dual";
        $details = DB::Select($query);
        //dd($details);
        return [
            'details' => $details
        ];
     }

     public function attendanceDetails($emp_id,$fromDate,$toDate,$type){
        $employee = new Employee();
        return [
            'employee_details' => $employee->find($emp_id),
            'attendance' => $this->attendance($emp_id,$fromDate,$toDate,$type),
        ];
     }

     private function attendance($emp_id,$fromDate,$toDate,$type){
        $from_date =  date('Y-m-d', strtotime($fromDate));
        $to_date =  date('Y-m-d', strtotime($toDate));
        $leave_type = empty($type) ? null : $type;
         $sql = "select attendance.emp_monthly_attendence_details(:p_emp_id,:p_date_from,:p_date_to,:p_leave_type_id) from dual";
         return $query = DB::select($sql, ['p_emp_id' => $emp_id,
             'p_date_from' => $from_date,
             'p_date_to' => $to_date,
             'p_leave_type_id' => $leave_type]);

     }
}
