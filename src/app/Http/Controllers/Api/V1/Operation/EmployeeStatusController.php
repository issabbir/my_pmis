<?php


namespace App\Http\Controllers\Api\V1\Operation;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EmployeeStatusController extends Controller
{
    public function get($searchParam){

        $sql = "SELECT EMP_STATUS_ID, EMP_STATUS FROM L_EMP_STATUS WHERE EMP_STATUS_ID IN(1, 9, 10) AND EMP_STATUS_ID != :param";
        return DB::select($sql, ['param' => $searchParam]);
    }

    public function store(Request $request){
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_emp_operation_id" => $request->get("emp_operation_id"),
                "p_emp_id" => $request->get("emp_id"),
                "p_curr_emp_status_id" => $request->get("curr_emp_status_id"),
                "p_change_emp_status_id" => $request->get("change_emp_status_id"),
                "p_application_no" => $request->get("application_no"),
                "p_application_date" =>
                    !empty($request->get("application_date"))
                        ? date("Y-m-d", strtotime($request->get("application_date")))
                        :'',
                "p_app_attachment" => [
                    'value' => $request->post('app_attachment'),
                    'type' => SQLT_CLOB,
                ],
                "p_approved_by" => $request->get("approved_by"),
                "p_approved_date" =>
                    !empty($request->get("approved_date"))
                    ? date("Y-m-d", strtotime($request->get("approved_date")))
                    :'',
                "p_approved_yn" => $request->get("approved_yn"),
                "p_order_no" => $request->get("order_no"),
                "p_order_date" =>
                    !empty($request->get("order_date"))
                    ? date("Y-m-d", strtotime($request->get("order_date")))
                    :'',
                "p_effective_date" => date("Y-m-d", strtotime($request->get("effective_date"))),
                "p_remarks" => $request->get("remarks"),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.EMP_OPERATIONS_INSERT", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 999, "status" => false, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function datatable(){
        $current_department_id = Auth::user()->employee->current_department_id;
        $sql = "SELECT O.EMP_OPERATION_ID,
       O.EMP_ID,
       E.EMP_NAME,
       E.EMP_CODE,
       O.CURR_EMP_STATUS_ID,
       CRS.EMP_STATUS AS CURR_EMP_STATUS,
       O.CHANGE_EMP_STATUS_ID,
       CHS.EMP_STATUS AS CHANGE_EMP_STATUS,
       O.EFFECTIVE_DATE,
       O.ORDER_DATE,
       O.ORDER_NO
  FROM EMP_OPERATIONS O
       JOIN EMPLOYEE E ON E.EMP_ID = O.EMP_ID
       JOIN L_EMP_STATUS CRS ON CRS.EMP_STATUS_ID = O.CURR_EMP_STATUS_ID
       JOIN L_EMP_STATUS CHS ON CHS.EMP_STATUS_ID = O.CHANGE_EMP_STATUS_ID
       WHERE E.CURRENT_DEPARTMENT_ID = $current_department_id";
        return DB::select($sql);
    }

    public function employeeStatusChange(){
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_app_yn" => 'Y'
            ];
            DB::executeProcedure("PMIS.prl_status_change_job", $params);
            return [ "status" => true, "o_status_code" => 200, "o_status_message" => 'success'];
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 999, "status" => false, "o_status_message" => $e->getMessage()];
        }
    }
}
