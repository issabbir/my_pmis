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

class AttendanceApprovalController extends Controller {

    protected $adminManager;

    public function __construct(AdminContract $adminManager) {
        $this->adminManager = $adminManager;
    }
    public function index() {
        return [
             "departments" => $this->adminManager->findDepartments()
        ];
    }
    public function search(Request $request) {
        $emp_id = $request->get('selectedEmployee')['emp_id'] ? $request->get('selectedEmployee')['emp_id'] : null;
        $dpt = \auth()->user()->user_name == 'admin'? null : $request->get('department_id');
        $reporting_employee_id = auth()->user()->employee->emp_id;
             $query = "Select leave.emp_leave_approval_specific(:department_id,:emp_id,:reporting_employee_id) a from dual";
             $leaves = DB::Select($query,['department_id'=>$dpt,'emp_id'=>$emp_id,'reporting_employee_id' => $reporting_employee_id]);
         return [
             "leaveData" => $leaves
        ];
    }

    public function leaveSummery(Request $request) {
       // dd($request->all());
        $year = date('Y',strtotime($request->get('leave_start_date')));
        $query = 'select leave.emp_leave_summary_list(:leave_type_id, :year, :emp_code ) from dual';
        $summery = DB::selectOne($query, ['leave_type_id'=>$request->get('leave_type_id'), 'year' => $year, 'emp_code' => $request->get('emp_code')]);

        return [
            "summery" => $summery,
        ];
    }

    public function singleApproveReject(Request $request) {
        DB::beginTransaction();
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
                    $params = [
                        "p_leave_id" => $request->get('leave_id'),
                        "p_approve_status" => $request->get('approve_status_edit'),
                        "p_leave_reason" => '',
                        "p_update_by" => auth()->id(),
                        "o_status_code" => &$status_code,
                        "o_status_message" => &$status_message,
                    ];
                    DB::executeProcedure("leave.emp_leave_approval", $params);
            //dd($params);
                    if (!$params['o_status_code'] == 1) {
                        DB::rollback();
                    }
            DB::commit();
            return ["exception" => true, "o_status_code" => 1, "o_status_message" => 'Sucessfully Updated'];

        } catch (\Exception $e) {
            DB::rollback();
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
    }
    public function approve(Request $request) {
        DB::beginTransaction();
         try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            foreach ($request->all() as $leave){
                if (isset($leave['submit']) && $leave['submit']) {
                    $params = [
                        "p_leave_id" => $leave['leave_id'],
                        "p_approve_status" => $leave['approve_status_edit'],
                        "p_leave_reason" => '',
                        "p_update_by" => auth()->id(),
                        "o_status_code" => &$status_code,
                        "o_status_message" => &$status_message,
                    ];

                    DB::executeProcedure("leave.emp_leave_approval", $params);

                    if (!$params['o_status_code'] == 1) {
                        DB::rollback();
                    }
                }
            }
             DB::commit();
             return ["exception" => true, "o_status_code" => 1, "o_status_message" => 'Sucessfully Updated'];

        } catch (\Exception $e) {
            DB::rollback();
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }


    }
    public function reject($id) {

        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $leave_id = $id;
            $params = [
                "p_leave_id" => $leave_id,
                "p_approve_status" => '-1',
                "p_leave_reason" => '',
                "p_update_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("leave.emp_leave_approval", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

          return ["exception" => true, "o_status_code" => 1, "o_status_message" => 'Sucessfully Rejected 1 RECORD'];;
    }

}
