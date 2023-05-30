<?php


namespace App\Http\Controllers\Api\V1\Operation;

use App\Contracts\Admin\AdminContract;
use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Http\Controllers\Controller;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PunishmentController extends Controller
{
    public function formData(AdminContract $adminManager) {
        return [
            'departments' => $adminManager->findDepartments(),
            'designations' => $adminManager->findDesignations(),
            'grads' => $adminManager->findEmpGrads(),
            'punishment_types' => $this->getPunishmentTypes()
        ];
    }

    public function getPunishmentTypes() {
        $sql = "select COMMON_LOOKUPS_LIST(:param) from dual";
        return $list = DB::select($sql, ['param' => 'PUNISHMENT']);
    }

    public function searchEmployees($searchParam) {
        $sql = "select opration.emp_search(:param) from dual";
        return $list = DB::select($sql, ['param' => $searchParam]);
    }

    public function get(Request $request) {
//        $department_id = Auth::user()->employee->dpt_department_id;
        $department_id = Auth::user()->employee->current_department_id;

        if(Auth::user()->hasPermission('CAN_SEE_ONLY_SELF_DEPARTMENT') && !Auth::user()->hasRole('SUPER_ADMIN')) {
            $sql = "select operations.PUNISHMENT_LIST(:p1, :p2) from dual";
            return DB::select($sql, ['p1' => $department_id, 'p2' => $request->get('approve_status')]);
        }else{
            $sql = "select operations.PUNISHMENT_LIST(:p1, :p2) from dual";
            return DB::select($sql, ['p1' => $request->get('department_id'), 'p2' => $request->get('approve_status')]);
        }
    }

    public function post(Request $request) {
        return $this->operations_EMP_PUNISHMENT_INS($request);
    }

    public function put($id, Request $request) {
        return $this->operations_EMP_PUNISHMENT_INS($request);
    }

    public function del($id) {
        return $this->operations_EMP_PUNISHMENT_DELETE($id);
    }

    public function process(Request $request) {
        return $this->operations_EMP_PUNISHMENT_PROCESS($request);
    }

    public function operations_EMP_PUNISHMENT_INS(Request $request)
    {
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_punishment_id" => $request->get("punishment_id"),
                "p_emp_id" => $request->get("emp_id"),
                "p_punishment_type_id" => $request->get("punishment_type_id"),
                "p_order_ref_number" => $request->get("order_ref_number"),
                "p_order_date" => date("Y-m-d", strtotime($request->get("order_date"))),
                "p_start_date" => date("Y-m-d", strtotime($request->get("start_date"))),
                "p_end_date" =>
                    !empty($request->get("end_date"))
                        ? date("Y-m-d", strtotime($request->get("end_date")))
                        :'',
                "p_note" => $request->get("note"),
                "p_process_yn" => 'N',
                "p_attachment" => [
                    'value' => $request->post('attachment'),
                    'type' => SQLT_CLOB,
                ],
                "p_end_order_ref_no" => $request->get("end_order_ref_no"),
                "p_end_order_date" =>
                    !empty($request->get("end_order_date"))
                        ? date("Y-m-d", strtotime($request->get("end_order_date")))
                        :'',
                "p_end_note" => $request->get("end_note"),
                "p_end_attachment" => [
                    'value' => $request->post('end_attachment'),
                    'type' => SQLT_CLOB,
                ],
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.EMP_PUNISHMENT_INS", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, 'o_status_code' =>99,  "status" => false, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function operations_EMP_PUNISHMENT_PROCESS(Request $request)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_punishment_id" => $request->get("punishment_id"),
                "p_process_yn" => "Y",
                "p_note" => $request->get('note'),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.EMP_PUNISHMENT_PROCESS", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function operations_EMP_PUNISHMENT_DELETE($id)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [

                "p_punishment_id" => $id,
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.EMP_PUNISHMENT_DELETE", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 999, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

}
