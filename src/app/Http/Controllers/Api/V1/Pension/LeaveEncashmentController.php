<?php


namespace App\Http\Controllers\Api\V1\Pension;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LeaveEncashmentController extends Controller
{

    public function getEmpLeaveBalance($empid, $leaveTypeId)
    {
        $sql = "select pension.emp_leave_balance(:empId,:leave_type_Id) from dual";
        $balance= DB::select($sql, ['empId' => $empid, 'leave_type_Id' => $leaveTypeId]);
        return $balance;
    }

    public function getEncashmentApplicationData(Request $request){
        $sql = "select pension.encashment_appl_grid_data(:department_id,:emp_id) from dual";
        return DB::select($sql, ['department_id' => $request->get('department_id'),
            'emp_id' => $request->get('emp_id')]);
    }
    public function encashmentEmpSearch($searchParam)
    {
        $sql = "select pension.emp_search_encashment(:param) from dual";
        return $list = DB::select($sql, ['param' => $searchParam]);
    }

    public function searchEncashmentData(Request $request)
    {
        $sql = "select pension.encashment_unapprove_list(:department_id,:emp_id) from dual";
        return DB::select($sql, ['department_id' => $request->get('department_id'),
            'emp_id' => $request->get('emp_id')]);
    }

    Public function store(Request $request)
    {
        try {

            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_encashment_app_id" => $request->get("encashment_app_id"),
                "p_emp_id" => $request->get("emp_id"),
                "p_leave_type_id" => $request->get("leave_type_id"),
                "p_encashment_days" => $request->get("encashment_days"),
                "p_amount" => $request->get("amount"),
                "p_approve_status" => $request->get("approval_status"),
                "p_approve_remarks"=> $request->get("approve_remarks"),
                "p_approve_by_emp_id" => $request->get("approval_status") == 1 ? Auth::user()->emp_id : '',
                "p_lap_encashment_days_consumed" => $request->get("lap_encashment_days_consumed"),
                "p_lap_encashment_days" => $request->get("lap_encashment_days"),
                "p_lap_encashment_amount" => $request->get("lap_encashment_amount"),
                "p_lhap_encashment_days_consumed" => $request->get("lhap_encashment_days_consumed"),
                "p_lhap_encashment_days" => $request->get("lhap_encashment_days"),
                "p_lhap_encashment_amount" => $request->get("lhap_encashment_amount"),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("pension.leave_encash_application", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
        return $params;
    }
}
