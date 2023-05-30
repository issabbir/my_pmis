<?php


namespace App\Http\Controllers\Api\V1\Pension;

use App\Contracts\Admin\AdminContract;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PrlLeaveApplicationController extends Controller
{

    public function getLeaveBalance($id)
    {
        $sql = "select pension.emp_leave_type_balance (:id) from dual";
        return DB::select($sql, ['id' => $id]);
    }

    public function getPrlData()
    {
        $sql = "select pension.prl_application_data  from dual";
        return DB::select($sql);
    }

    public function departmentWisePrlData($department_id)
    {
        $dept_id = Auth::user()->employee->current_department_id;
        $dpt = \auth()->user()->user_name == 'admin'? null : $department_id;
        $sql = "select pension.department_wise_prl_data(:department_id) from dual";
        return DB::select($sql, ['department_id' => $dpt]);
    }

    public  function searchPrlUnApprovalList(Request $request){
        $sql = "select pension.prl_application_unapprove_list(:dptId,:empId) from dual";
        return DB::select($sql, ['dptId' => $request->get('department_id'),'empId' => $request->get('emp_id')]);
    }

    public function store(Request $request)
    {
        $application_date = $request->get("application_date") == null ? '': date("Y-m-d", strtotime($request->get("application_date")));
        $approve_date = $request->get("approve_date") == null ? '': date("Y-m-d", strtotime($request->get("approve_date")));
        $lap_start_date = $request->get("lap_start_date") == null ? '' : date("Y-m-d", strtotime($request->get("lap_start_date")));
        $lap_end_date = $request->get("lap_end_date") == null ? '' : date("Y-m-d", strtotime($request->get("lap_end_date")));
        $lhap_start_date = $request->get("lhap_start_date") == null ? '' : date("Y-m-d", strtotime($request->get("lhap_start_date")));
        $lhap_end_date = $request->get("lhap_end_date") == null ? '' : date("Y-m-d", strtotime($request->get("lhap_end_date")));


        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [

                "p_emp_id" => $request->get("emp_id"),
                "p_leave_type_id" => $request->get("leave_type_id"),
                "p_application_date" => $application_date,
                "p_approve_status" =>  $request->get("approve_status"),
                "p_approve_date" => $approve_date,
                "p_approve_by_emp_id" => $request->get("approve_by_emp_id"),
                "p_approve_remarks"=>$request->get("approve_remarks"),
                "p_lap_start_date" => $lap_start_date,
                "p_lap_end_date" => $lap_end_date,
                "p_lap_days" => $request->get("lap_leave_days"),
                "p_lhap_start_date" => $lhap_start_date,
                "p_lhap_end_date" => $lhap_end_date,
                "p_lhap_days" => $request->get("lhap_leave_days"),
                "p_full_pay_yn" => $request->get("full_pay_yn"),
                "p_leave_id" => $request->get("leave_id"),
                "p_leave_approve_ref_no" => $request->get("leave_approve_ref_no"),
                "p_leave_reason" => $request->get("leave_reason"),
                "p_emergency_num" => $request->get("emergency_num"),
                "p_attachment" => [
                    'value' => $request->post('attachment'),
                    'type' => SQLT_CLOB,
                ],
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("pension.emp_prl_leave_application", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    public function prlApproval(Request $request)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [

                "p_leave_id" => $request->get("leave_id"),
                "p_approve_status" => $request->get("approve_status"),
                "p_leave_reason" =>$request->get("leave_reason"),
                "p_approve_remarks" =>$request->get("approve_remarks"),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            //print_r ($params);
            //die();
            DB::executeProcedure("pension.prl_leave_approval  ", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;

    }

}
