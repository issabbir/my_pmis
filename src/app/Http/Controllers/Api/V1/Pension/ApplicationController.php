<?php


namespace App\Http\Controllers\Api\V1\Pension;

use App\Contracts\Admin\AdminContract;
use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Admin\WorkFlowStep;
use App\Entities\Payroll\PrMonths;
use App\Http\Controllers\Controller;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function formData(AdminContract $adminManager) {
        return ['branches' => $adminManager->findBranches()->where('bank_id', 37)];
    }



    public function empSearch($searchParam)
    {
        $sql = "select pension.emp_search(:param) from dual";
        return $list = DB::select($sql, ['param' => $searchParam]);
    }

    public function departmentWisEmpSearch($searchParam, $department_id=null)
    {
        $dept_id = Auth::user()->employee->current_department_id;
        $dpt = \auth()->user()->user_name == 'admin'? null : $dept_id;
        $sql = "select pension.department_wise_emp_search(:param, :department_id) from dual";
        return $list = DB::select($sql, ['param' => $searchParam, 'department_id' => $dpt]);
    }

    public function searchEmployees($searchParam) {
        $sql = "select pension.emp_search_for_pension_list(:param) from dual";
        return $list = DB::select($sql, ['param' => $searchParam]);
    }

    public function searchEmployeesForFifteenYears($searchParam) {
        $sql = "select pension.emp_search_pension_rec_list(:param) from dual";
        return $list = DB::select($sql, ['param' => $searchParam]);
    }
    public function monthsByYearId($year) {
        $salaryHeads = [];
        if($year){
            $months = new PrMonths();
//            $salaryYear =$months->where('fy_id', $year)->where('current_yn', 'Y')->where('open_yn', 'O')C->get();
            $salaryYear =$months->where('fy_id', $year)->where('open_yn', 'O')->orderBy("pr_month", 'asc')->get();
            // print_r($salaryYear); die();
            $salaryHeads[] = ["value" => null, 'text' => 'Select Month'];
            $months = ['','July','August','September','October','November','December','January','February','March','April','May','June'];
            foreach ($salaryYear as $key=>$items) {
                $salaryHeads[] = ["text" => $months[$items->pr_month], 'value' => $items->pr_month_id];
            }
        }
        return $salaryHeads;
    }
    public function EmployeesForFifteenYears() {
        $sql = "SELECT pe.emp_id,
       pe.emp_code || ' - ' || pe.emp_name AS option_name,
       pe.emp_code,
       pe.emp_name,
       pe.dpt_department_id,
       ld.department_name,
       pe.designation_id,
       dg.designation,
       ADD_MONTHS (
          pe.emp_dob,
          CASE WHEN pe.emp_quota_id IN (2, 10, 11) THEN 60 ELSE 59 END * 12)
          AS emp_lpr_date,
         ADD_MONTHS (
            pe.emp_dob,
            CASE WHEN pe.emp_quota_id IN (2, 10, 11) THEN 60 ELSE 59 END * 12)
       + CASE
            WHEN (SELECT   TRUNC ( (TRUNC (SYSDATE) - emp_join_date) / 11)
                         + (  TRUNC ( (TRUNC (SYSDATE) - emp_join_date) / 12)
                            / 2)
                    FROM employee
                   WHERE emp_id = pe.emp_id) > 365
            THEN
               365
            ELSE
               (SELECT   TRUNC ( (TRUNC (SYSDATE) - emp_join_date) / 11)
                       + (TRUNC ( (TRUNC (SYSDATE) - emp_join_date) / 12) / 2)
                  FROM employee
                 WHERE emp_id = pe.emp_id)
         END
       - 1
          AS permanent_retirement_date,
       pe.bank_acc_no AS account_number,
       NULL account_type_id,
       NULL account_type,
       pe.branch_id,
       (SELECT branch_name
          FROM l_branch
         WHERE bank_id = pe.bank_id AND branch_id = pe.branch_id)
          AS branch_name,
          TRUNC (MONTHS_BETWEEN (pe.emp_lpr_date, pe.emp_join_date) / 12)
       || ' Years '
       || MOD (TRUNC (MONTHS_BETWEEN (pe.emp_lpr_date, pe.emp_join_date)),
               12)
       || ' Months '
       || (  pe.emp_lpr_date
           - ADD_MONTHS (
                pe.emp_join_date,
                TRUNC (MONTHS_BETWEEN (pe.emp_lpr_date, pe.emp_join_date))))
       || ' Days'
          AS service_period,
       (SELECT SUM (remaining_balance)
          FROM emp_leave_summary
         WHERE emp_id = pe.emp_id AND leave_type_id IN (1, 5))
          AS available_days,
       pe.emp_status,
          (SELECT bank_name
             FROM l_banks
            WHERE bank_id = pe.bank_id)
       || ' - '
       || (SELECT branch_name
             FROM l_branch
            WHERE bank_id = pe.bank_id AND branch_id = pe.branch_id)
       || ' - '
       || pe.BANK_ACC_NO
          AS bank_info
  FROM pension_employee pe, l_department ld, l_designation dg
 WHERE     pe.dpt_department_id = ld.department_id(+)
       AND pe.designation_id = dg.designation_id(+)
       AND ADD_MONTHS (pe.retirement_date, 180) <= TRUNC (SYSDATE)
       AND NOT EXISTS
              (SELECT emp_id
                 FROM emp_pension_app ep
                WHERE pe.emp_id = ep.emp_id)";
        return $list = DB::select($sql);

    }


    public function reContinuationTypeList(){
        $sql = " SELECT lookup_code AS pass_value, meaning AS show_value
    FROM l_lookups
   WHERE lookup_type = 'PENSIONRECONTINUE'
ORDER BY short_by, show_value";
        return DB::select($sql);
    }

    public function searchEmployeesControllerWise($searchParam) {
        $controlling_officer_id = Auth::user()->employee->emp_id;
        $sql = "select pension.emp_pension_list_controller(:param, :emp_id) from dual";
        return $list = DB::select($sql, ['param' => $searchParam, 'emp_id'=> $controlling_officer_id]);
    }

    public function getDuration($searchParam, $date) {

        $sql = "select pension.emp_service_period(:empId,:ddate) from dual";
        $params = ['empId' => $searchParam, 'ddate' => date("Y-m-d", strtotime($date))];
        $list = DB::selectOne($sql, $params);

        return response()->json($list);

    }
    public function createApplication(Request $request) {
        return $this->pension_emp_pension_apps_ins($request);
    }
    public function getPension(Request $request) {
        $sql = "select pension.EMP_PENSION_SEARCH(:name) from dual";
        return DB::select($sql, ['name' => $request->get('name')]);
    }
    public function getPensionControllerWise(Request $request) {
        $controlling_officer_id = Auth::user()->employee->emp_id;
        $sql = "select pension.EMP_PENSION_SEARCH_CONTROLLER(:name, :emp_id) from dual";
        return DB::select($sql, ['name' => $request->get('name'), 'emp_id'=> $controlling_officer_id]);
    }

    public function openForClearance(Request $request, $id){
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_APPS_ID" => $id,
                "p_CLEARANCE_OPEN_YN" => 'Y',
                "p_CLEARANCE_OPEN_BY" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PENSION.EMP_PENSION_APP_UPD", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
        return $params;
    }


    public function getPensionNominees($id){
        $sql = "select pension.emp_pension_nominee_list(:id) from dual";
        return $list = DB::select($sql, ['id' => $id]);
    }

    public function updateApplication($id, Request $request) {
        //todo: update applications
    }

    public  function searchPensionEmployeeCode($id){
        $sql = "select pension.EMP_PENSION_SEARCH(:id) from dual";
        return DB::select($sql, ['id' => $id]);
    }

    public  function getEmpPensionSearchData(Request $request){
        $sql = "select pension.emp_search_for_pension_grid (:empId,:dptId) from dual";
        return DB::select($sql, ['empId' => $request->get('emp_id'),'dptId' => $request->get('department_id')]);
    }

    public  function getEmpPensionCalculatedData(Request $request){
        $sql = "select pension.emp_src_for_pension_calc(:empId,:dptId) from dual";
        return DB::select($sql, ['empId' => $request->get('emp_id'),'dptId' => $request->get('department_id')]);
    }

    public  function getEmpPensionSettlementData(Request $request){

        $sql = "select pension.emp_settlement_for_grid (:empId,:dptId) from dual";
        return DB::select($sql, ['empId' => $request->get('emp_id'),'dptId' => $request->get('department_id')]);
    }

    public  function getEmpPensionSettlementDataList(Request $request){

        $sql = "select pension.emp_settlement_for_grid_list (:empId,:dptId, :status) from dual";
        return DB::select($sql, ['empId' => $request->get('emp_id'),'dptId' => $request->get('department_id'), 'status'=>$request->get('status')]);
    }



    public  function getPensionClearanceStatus($id){
        $sql = "select pension.emp_pension_clearance_status (:id) from dual";
        return DB::select($sql, ['id' => $id]);
    }


    //new function for get attachments
    public function getAttachments($id)
    {
        $sql = "SELECT attachment_type_id, ATTACHMENT_ID, TITLE, filename, file_content FROM pension_attachments WHERE PENSION_EMP_ID = :id";
        return DB::select($sql, ['id' => $id]);
    }


    public function storePensionSettlement(Request $request)
    {

        try {

            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_pension_calculation_id" => $request->get("pension_calculation_id"),
                "p_apps_id" => $request->get("apps_id"),
                "p_emp_id" =>  $request->get("emp_id"),
                "p_settlement_yn" => $request->get("settlement_yn"),
                "p_adjust_amount"=>$request->get("adjust_amount"),
                "p_comment"=>$request->get("comment"),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];

            DB::executeProcedure("PENSION.emp_pension_app_settlement", $params);
//            dd($params);

        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
        return $params;
    }

    public function pension_emp_pension_apps_ins(Request $request)
    {
        try {
            $status_code = sprintf("%4000s","");
            $apps_id = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_emp_id" => $request->get("emp_id"),
                "p_application_date" => date("Y-m-d", strtotime($request->get("application_date"))),
                "p_lpr_date" => date("Y-m-d", strtotime($request->get("lpr_date"))),
                "p_perm_retd_date" => date("Y-m-d", strtotime($request->get("perm_retd_date"))),
                "p_bank_id" => $request->get("bank_id"),
                "p_branch_id" => $request->get("branch_id"),
                "p_emp_bank_acc_no" => $request->get("emp_bank_acc_no"),
                "p_insert_by" => Auth::id(),
                "o_apps_id" => &$apps_id,
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PENSION.EMP_PENSION_APPS_INS", $params);
            if(count($request->get('attachments'))>0 && $params['o_status_code'] == 1){
                foreach ($request->get('attachments') as $attachment){
                    if($attachment['filename']){
                        $o_status_code = sprintf("%4000s","");
                        $o_status_message = sprintf("%4000s","");
                        $attachmentParams = [
                            "p_FILENAME" => $attachment['filename'],
                            "p_FILE_CONTENT" => [
                                'value' => $attachment['file_content'],
                                'type' => SQLT_CLOB,
                            ],
                            "p_FILESYSTEM_YN" => 'N',
                            "p_FILE_PATH" => '',
                            "p_ACTIVE_YN" => 'Y',
                            "p_FILESIZE" => '',
                            "p_PENSION_EMP_ID" => $attachment['pension_emp_id'],
                            "p_TITLE" => $attachment['title'],
                            "p_TITLE_BN" => '',
                            "p_FILE_EXTENSION" => $attachment['file_extension'],
                            "p_EMP_CODE" => $attachment['emp_code'],
                            "p_insert_by" => Auth::id(),
                            "o_status_code" => &$o_status_code,
                            "o_status_message" => &$o_status_message,
                        ];
                        DB::executeProcedure("PENSION.PENSION_ATTACHMENTS_INS", $attachmentParams);
                    }
                }
            }
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }


    public function updateWorkflowId(Request $request, $id){
        DB::table('emp_pension_calculation')
            ->where('pension_calculation_id', $id)
            ->update(['approval_workflow_id' => $request->get('approval_workflow_id')]);
        $response=$this->systemAutoCompleteStep($request,$id);
        return ['data'=>$response];
    }


    private function systemAutoCompleteStep($request=[],$id){
        $firstWorkflowStep=WorkFlowStep::where('approval_workflow_id',$request->get('approval_workflow_id'))
            ->orderBy('PROCESS_STEP')
            ->first();
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $object_id = $request->get('pension_calculation_id') ? $request->get('pension_calculation_id') :
                ($request->get('settlement_id') ? $request->get('settlement_id') :
                    ($request->get('application_id') ?$request->get('application_id') : ''));
            $params = [
                "p_workflow_process_id" => '',
                "p_workflow_object_id" => $object_id,
                "p_workflow_step_id" => $firstWorkflowStep->workflow_step_id,
                "p_note" => 'System Assigned',
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("workflow_Process_entry", $params);
        }catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
        return $params;

    }
}
