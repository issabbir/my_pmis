<?php


namespace App\Http\Controllers\Api\V1\Operation;

use App\Contracts\Admin\AdminContract;
use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Admin\LDesignation;
use App\Entities\Admin\LSanctionedPost;
use App\Entities\Admin\PrBillCodeMaster;
use App\Http\Controllers\Controller;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function formData(AdminContract $adminManager) {
        $pr = new PrBillCodeMaster();
        return [
            'departments' => $adminManager->findDepartments(),
            'designations' => $adminManager->findDesignations(),
            'grads' => $adminManager->findEmpGrads(),
            'sections' => $adminManager->findSections(),
            'bill_codes' => $pr->where('activation_flag', 'Y')->orderby('bill_code')->get()
        ];
    }
    public function getBillCodes(Request $request) {
        $designation = LSanctionedPost::where('DESIGNATION_ID',$request->designation_id_to)->first();
        $pr = new PrBillCodeMaster();
        if ($request->current_department_id_to || $request->department_id_to){
            $pr = $pr->whereIn('dpt_department_id',[$request->current_department_id_to,$request->department_id_to]);
        }
        if ($designation){
            $pr = $pr->where('emp_type_id',$designation->emp_type_id);
        }
        $data = $pr->orderby('bill_code')->get();
       // dd($designation);
        return [
            'bill_codes' => $data
        ];
    }

    public function searchEmployees($searchParam) {
        $sql = "select opration.emp_search(:param) from dual";
        return $list = DB::select($sql, ['param' => $searchParam]);
    }

    public function get(Request $request) {
//        $department_id = Auth::user()->employee->dpt_department_id;
        $department_id = Auth::user()->employee->current_department_id;

        if(Auth::user()->hasPermission('CAN_SEE_ONLY_SELF_DEPARTMENT') && !Auth::user()->hasRole('SUPER_ADMIN')) {
            $sql = "select operations.TRANSFERS_LIST(:p1) from dual";
            return DB::select($sql, ['p1' => $department_id]);
        }else {
            $sql = "select operations.TRANSFERS_LIST(:p1) from dual";
            return DB::select($sql, ['p1' => $request->get('department_id')]);
        }
    }

    public function post(Request $request) {
        return $this->operations_EMP_TRANSFERS_INS($request);
    }

    public function put($id, Request $request) {
        return $this->operations_EMP_TRANSFERS_INS($request);
    }

    public function del($id) {
        return $this->operations_EMP_TRANSFERS_DELETE($id);
    }

    public function process(Request $request) {
        return $this->operations_EMP_TRANSFERS_PROCESS($request);
    }

    public function operations_EMP_TRANSFERS_INS(Request $request)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_transfer_id" => $request->get("transfer_id"),
                "p_emp_id" => $request->get("emp_id"),
                "p_division_id_from" => $request->get("department_id_from"),
                "p_department_id_from" => $request->get("department_id_from"),
                "p_section_id_from" => $request->get("section_id_from"),
                "p_designation_id_from" => $request->get("designation_id_from"),
                "p_bill_no_from" => $request->get("bill_no_from"),
                "p_bill_operator_from" => $request->get("bill_operator_from"),
                "p_location_type_id_from" => $request->get("location_type_id_from"),
                "p_location_id_from" => $request->get("location_id_from"),
                "p_transfer_type" => $request->get("transfer_type"),
                "p_external_org" => $request->get("external_org"),
                "p_division_id_to" => $request->get("division_id_to"),
                "p_department_id_to" => $request->get("department_id_to"),
                "p_section_id_to" => $request->get("section_id_to"),
                "p_designation_id_to" => $request->get("designation_id_to"),
                "p_bill_no" => $request->get("bill_no"),
                "p_bill_operator_to" => $request->get("bill_operator_to"),
                "p_location_type_id_to" => $request->get("location_type_id_to"),
                "p_location_id_to" => $request->get("location_id_to"),
                "p_join_date" => date("Y-m-d", strtotime($request->get("join_date"))),
                "p_release_date" => date("Y-m-d", strtotime($request->get("release_date"))),
                "p_process_yn" => $request->get("process_yn"),
                "p_note" => $request->get("note"),
                "p_attachment" => [
                    'value' => $request->post('attachment'),
                    'type' => SQLT_CLOB,
                ],
                "p_current_department_id" => $request->get("current_department_id_to"),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.EMP_TRANSFERS_INS", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" =>99,  "status" => false, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function operations_EMP_TRANSFERS_PROCESS(Request $request)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_transfer_id" => $request->get("transfer_id"),
                "p_process_yn" => "Y",
                "p_note" => $request->get('note'),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.EMP_TRANSFERS_PROCESS", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99,  "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function operations_EMP_TRANSFERS_DELETE($id)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_transfer_id" => $id,
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.EMP_TRANSFERS_DELETE", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    public function department_wise_employee($emp_name, $department_id){
        $sql = "select * from (SELECT e.emp_id,
         e.emp_code,
         e.emp_name,
         '(' || e.emp_code || ') ' || e.emp_name AS option_name
    FROM employee e
   WHERE     UPPER (e.emp_code || e.emp_name) LIKE
                '%' || UPPER ( :emp_name) || '%'
         AND E.DPT_DEPARTMENT_ID = nvl($department_id, E.DPT_DEPARTMENT_ID)
ORDER BY e.emp_name) where rownum <=20";
        return DB::select($sql, ['emp_name'=>$emp_name]);
    }

    public function departmentWiseEmployees($department_id){
        $sql = "select * from (SELECT e.emp_id, E.DPT_DEPARTMENT_ID,
         e.emp_code,
         e.emp_name,
         '(' || e.emp_code || ') ' || e.emp_name AS option_name
    FROM pension_employee e
   WHERE    E.DPT_DEPARTMENT_ID = nvl(:department_id, E.DPT_DEPARTMENT_ID)
ORDER BY e.emp_name)";

        return DB::select($sql, ['department_id'=>$department_id]);
    }

    public function employeeInformation($emp_code){

        $data = DB::selectOne("SELECT *
  FROM (  SELECT E.PENSION_PCT,
                 E.EMP_TYPE_ID,
                 e.emp_name,
                 '(' || e.emp_code || ') ' || e.emp_name AS option_name
            FROM pension_employee e
           WHERE E.EMP_CODE = '$emp_code' --NVL (:emp_code, E.EMP_CODE)
        ORDER BY e.emp_name)");

        return response()->json([
            'data'=>$data
        ], 200);
    }
}
