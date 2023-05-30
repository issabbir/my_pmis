<?php


namespace App\Http\Controllers\Api\V1\Operation;

use App\Contracts\Admin\AdminContract;
use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Http\Controllers\Controller;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class IncrementController extends Controller
{
    public function formData(AdminContract $adminManager) {
        return [
            'departments' => $adminManager->findDepartments(),
            'designations' => $adminManager->findDesignations(),
            'grads' => $adminManager->findEmpGrads()
        ];
    }

    public  function  getGradeSteps(AdminContract $adminManager,$id){
        return [
            'grads_steps' => $adminManager->findAllGradeSteps($id)
        ];
    }

    /**
     * Search Employee
     *
     * @param $searchParam
     * @return array
     */
    public function searchEmployees($searchParam) {
        $sql = "select opration.emp_search(:param) from dual";
        return $list = DB::select($sql, ['param' => $searchParam]);
    }


    /**
     *
     * @param Request $request
     * @return array
     */
    public function get(Request $request) {
//        $department_id = Auth::user()->employee->dpt_department_id;
        $department_id = Auth::user()->employee->current_department_id;

        if(Auth::user()->hasPermission('CAN_SEE_ONLY_SELF_DEPARTMENT') && !Auth::user()->hasRole('SUPER_ADMIN')) {
            $sql = "select operations.INCREMENTS_LIST(:p1) from dual";
            return DB::select($sql, ['p1' => $department_id]);
        }else {
            $sql = "select operations.INCREMENTS_LIST(:p1) from dual";
            return DB::select($sql, ['p1' => $request->get('department_id')]);
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function post(Request $request){
        return $this->operations_emp_increments_ins($request);
    }

    public function put($id, Request $request) {
        return $this->operations_emp_increments_ins($request);
    }

    public function del($id) {
        return $this->operations_EMP_INCREMENTS_DELETE($id);
    }

    public function process(Request $request) {
        return $this->operations_EMP_INCREMENTS_PROCESS($request);
    }

    public function operations_emp_increments_ins(Request $request)
    {

        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [

                "p_increment_id" => $request->get("increment_id"),
                "p_emp_id" => $request->get("emp_id"),
                "p_grad_id_from" => $request->get("grad_id_from"),
                "p_grad_id_to" => $request->get("grad_id_to"),
                "p_grade_step_id_from" => $request->get("grade_step_id_from"),
                "p_grade_step_id_to" => $request->get("grade_step_id_to"),
                "p_basic_from" => $request->get("basic_from"),
                "p_basic_to" => $request->get("basic_to"),
                "p_reference_number" => $request->get("reference_number"),
                "p_order_date" => date("Y-m-d", strtotime($request->get("order_date"))),
                "p_effective_date" => date("Y-m-d", strtotime($request->get("effective_date"))),
                "p_attachment" => [
                    'value' => $request->post('attachment'),
                    'type' => SQLT_CLOB,
                ],
                "p_process_yn" => "N",
                "p_note" => $request->get("note"),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.EMP_INCREMENTS_INS", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 999, "status" => false, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function operations_EMP_INCREMENTS_PROCESS(Request $request)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_increment_id" => $request->get("increment_id"),
                "p_process_yn" => 'Y',
                "p_note" => $request->get('note'),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.EMP_INCREMENTS_PROCESS", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function operations_EMP_INCREMENTS_DELETE($id)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [

                "p_increment_id" => $id,
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.EMP_INCREMENTS_DELETE", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    public function delIncrementTmp() {
        return $this->operations_onload_increments_temp_delete();
    }

    public function addIncrementTmp(Request $request) {
        return $this->operations_add_to_process_increment($request);
    }

    public function pauseIncrementTmp($tmpId,$status) {
        return $this->operations_emp_increments_temp_hold($tmpId,$status);
    }

    public function getIncrementTmp(AdminContract $adminManager) {
        $data =  DB::select('select OPERATIONS.increments_add_data(:userId) from dual',
            ['userId' => Auth::id()]);

        return [
            'data' => $data,
            'departments' => $adminManager->findDepartments(),
        ];
    }

    public function processIncrement() {
        return $this->operations_emp_bulk_increments_process();
    }

    /**
     * Search Employee
     *
     * @param $searchParam
     * @return array
     */
    public function incrementEmployees($searchParam) {
        $sql = "select opration.emp_increments_search(:param) from dual";
        return $list = DB::select($sql, ['param' => $searchParam]);
    }

    public function operations_onload_increments_temp_delete()
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [

                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.ONLOAD_INCREMENTS_TEMP_DELETE", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }
    public function operations_emp_bulk_increments_process()
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [

                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.EMP_BULK_INCREMENTS_PROCESS", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    public function operations_emp_increments_temp_hold($tmpId,$status)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [

                "p_increment_temp_id" => $tmpId,
                "p_hold_yn" => $status,
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.EMP_INCREMENTS_TEMP_HOLD", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    public function operations_add_to_process_increment(Request $request)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [

                "p_department_id" => $request->get("department_id"),
                "p_emp_id" => $request->get("emp_id"),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.ADD_TO_PROCESS_INCREMENT", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }
}
