<?php


namespace App\Http\Controllers\Api\V1\Pension;

use App\Entities\Admin\WorkFlowStep;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NomineeController extends Controller
{
    public function store(){

    }

    public function allNominee(){

    }

    public function pensionNominee($id){
        $sql = "select pension.emp_nominee_list(:id, 2) from dual";
        return $list = DB::select($sql, ['id' => $id]);
    }

    public function pensionApplication(Request $request)
    {
        try {
            $status_code = sprintf("%4000s","");
            $out_apps_id = sprintf("%4000s","");
            $apps_id = $request->get('apps_id');
            $status_message = sprintf("%4000s","");
            /*$params = [
                "p_recontinue_app_id" => $request->get("recontinue_app_id"),
                "p_application_type" => $request->get('application_type'),
                "p_emp_id" => $request->get("emp_id"),
                "p_nominee_id" => $request->get("nominee_id"),
                "p_application_date" => date("Y-m-d", strtotime($request->get("application_date"))),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PENSION.pension_recontinue_app_create", $params);*/


            $params = [
                "p_apps_id" => $apps_id,
                "p_emp_id" => $request->get("emp_id"),
                "p_nominee_id" => $request->get("nominee_id"),
                "p_application_date" => date("Y-m-d", strtotime($request->get("application_date"))),
                "p_lpr_date" => date("Y-m-d", strtotime($request->get("lpr_date"))),
                "p_perm_retd_date" => date("Y-m-d", strtotime($request->get("permanent_retirement_date"))),
                "p_bank_id" => $request->get("bank_id"),
                "p_branch_id" => $request->get("branch_id"),
                "p_emp_bank_acc_no" => $request->get("account_number"),
                "p_application_type" => $request->get('application_type'),
                "p_insert_by" => Auth::id(),
                "o_apps_id" => &$out_apps_id,
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PENSION.death_emp_pension_apps_ins", $params);


            if(count($request->get('attachments'))>0){
                foreach ($request->get('attachments') as $attachment){
                    if($attachment['file_content']){
                        $status_code_attachment = sprintf("%4000s","");
                        $status_message_attachment = sprintf("%4000s","");
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
                            "o_status_code" => &$status_code_attachment,
                            "o_status_message" => &$status_message_attachment,
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

    public function allPensionApplication(){
       /* $sql = "SELECT PRA.RECONTINUE_APP_ID,
       PE.EMP_STATUS,
       PRA.APPLICATION_TYPE,
       PRA.APPLICATION_DATE,
       PRA.NOMINEE_ID,
       PRA.NOMINEE_NAME,
       E.EMP_CODE || ' - ' || E.EMP_NAME AS OPTION_NAME,
       E.EMP_CODE,
       E.EMP_NAME,
       E.EMP_ID,
       E.EMP_LPR_DATE,
       E.EMP_BANK_ACC_NO AS ACCOUNT_NUMBER,
       D.DEPARTMENT_ID,
       D.DEPARTMENT_NAME,
       DES.DESIGNATION_ID,
       DES.DESIGNATION,
       BK.BANK_ID,
       BK.BANK_NAME,
       BR.BRANCH_ID,
       BR.BRANCH_NAME,
         ADD_MONTHS (
            E.EMP_DOB,
            CASE WHEN E.EMP_QUOTA_ID IN (2, 10, 11) THEN 60 ELSE 59 END * 12)
       + CASE
            WHEN   TRUNC ( (TRUNC (SYSDATE) - E.EMP_JOIN_DATE) / 11)
                 + (TRUNC ( (TRUNC (SYSDATE) - E.EMP_JOIN_DATE) / 12) / 2) >
                    365
            THEN
               365
            ELSE
                 TRUNC ( (TRUNC (SYSDATE) - E.EMP_JOIN_DATE) / 11)
               + (TRUNC ( (TRUNC (SYSDATE) - E.EMP_JOIN_DATE) / 12) / 2)
         END
       - 1
          AS PERMANENT_RETIREMENT_DATE,
          TRUNC (MONTHS_BETWEEN (E.EMP_LPR_DATE, E.EMP_JOIN_DATE) / 12)
       || ' Years '
       || MOD (TRUNC (MONTHS_BETWEEN (E.EMP_LPR_DATE, E.EMP_JOIN_DATE)), 12)
       || ' Months '
       || (  E.EMP_LPR_DATE
           - ADD_MONTHS (
                E.EMP_JOIN_DATE,
                TRUNC (MONTHS_BETWEEN (E.EMP_LPR_DATE, E.EMP_JOIN_DATE))))
       || ' Days'
          AS SERVICE_PERIOD
  FROM PENSION_RECONTINUE_APP PRA
       JOIN EMPLOYEE E ON E.EMP_ID = PRA.EMP_ID
       LEFT JOIN PENSION_EMPLOYEE PE ON PE.EMP_ID = E.EMP_ID
       JOIN L_DEPARTMENT D ON D.DEPARTMENT_ID = E.DPT_DEPARTMENT_ID
       JOIN L_DESIGNATION DES ON DES.DESIGNATION_ID = E.DESIGNATION_ID
       JOIN L_BANKS BK ON BK.BANK_ID = E.BANK_ID
       JOIN L_BRANCH BR ON BR.BRANCH_ID = E.BRANCH_ID
 WHERE PRA.APPLICATION_TYPE = 'AFD' AND E.BANK_ID = BR.BANK_ID";*/
        $sql = "select pension.emp_for_nominee_pension_apps_grid from dual";
        return DB::select($sql);
    }

    public function allPensionContinuationApplication(){
        $sql = "SELECT PRA.RECONTINUE_APP_ID,
       ES.EMP_STATUS,
       PRA.APPLICATION_TYPE,
       PRA.APPLICATION_DATE,
       PRA.NOMINEE_ID,
       PRA.NOMINEE_NAME,
       E.EMP_CODE || ' - ' || E.EMP_NAME AS OPTION_NAME,
       E.EMP_CODE,
       E.EMP_NAME,
       E.EMP_ID,
       E.EMP_LPR_DATE,
       E.EMP_BANK_ACC_NO AS ACCOUNT_NUMBER,
       D.DEPARTMENT_ID,
       D.DEPARTMENT_NAME,
       DES.DESIGNATION_ID,
       DES.DESIGNATION,
       BK.BANK_ID,
       BK.BANK_NAME,
       BR.BRANCH_ID,
       BR.BRANCH_NAME,
         ADD_MONTHS (
            E.EMP_DOB,
            CASE WHEN E.EMP_QUOTA_ID IN (2, 10, 11) THEN 60 ELSE 59 END * 12)
       + CASE
            WHEN   TRUNC ( (TRUNC (SYSDATE) - E.EMP_JOIN_DATE) / 11)
                 + (TRUNC ( (TRUNC (SYSDATE) - E.EMP_JOIN_DATE) / 12) / 2) >
                    365
            THEN
               365
            ELSE
                 TRUNC ( (TRUNC (SYSDATE) - E.EMP_JOIN_DATE) / 11)
               + (TRUNC ( (TRUNC (SYSDATE) - E.EMP_JOIN_DATE) / 12) / 2)
         END
       - 1
          AS PERMANENT_RETIREMENT_DATE,
          TRUNC (MONTHS_BETWEEN (E.EMP_LPR_DATE, E.EMP_JOIN_DATE) / 12)
       || ' Years '
       || MOD (TRUNC (MONTHS_BETWEEN (E.EMP_LPR_DATE, E.EMP_JOIN_DATE)), 12)
       || ' Months '
       || (  E.EMP_LPR_DATE
           - ADD_MONTHS (
                E.EMP_JOIN_DATE,
                TRUNC (MONTHS_BETWEEN (E.EMP_LPR_DATE, E.EMP_JOIN_DATE))))
       || ' Days'
          AS SERVICE_PERIOD,
          pra.APPROVED_YN,
          pra.APPROVAL_WORKFLOW_ID,
          pra.WORKFLOW_PROCESS_ID
  FROM PENSION_RECONTINUE_APP PRA
       JOIN EMPLOYEE E ON E.EMP_ID = PRA.EMP_ID
       JOIN PENSION_EMPLOYEE PE ON PE.EMP_ID = E.EMP_ID
       JOIN L_DEPARTMENT D ON D.DEPARTMENT_ID = E.DPT_DEPARTMENT_ID
       JOIN L_DESIGNATION DES ON DES.DESIGNATION_ID = E.DESIGNATION_ID
       JOIN L_BANKS BK ON BK.BANK_ID = E.BANK_ID
       JOIN L_BRANCH BR ON BR.BRANCH_ID = E.BRANCH_ID
       JOIN L_EMP_STATUS ES ON ES.EMP_STATUS_ID = E.EMP_STATUS_ID
 WHERE  E.BANK_ID = BR.BANK_ID";
//        AND PRA.APPLICATION_TYPE = 'REC'
        return DB::select($sql);
    }

    public function employeeList($searchParam){
        $sql = "select pension.emp_for_nominee_pension_list(:param) from dual";
        return $list = DB::select($sql, ['param' => $searchParam]);
    }

    public function updatePensionRecontinueWorkflow(Request $request, $id){
        DB::table('pension_recontinue_app')
            ->where('recontinue_app_id', $id)
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
            $object_id = $request->get('recontinue_app_id');
            $params = [
                "p_workflow_process_id" => '',
                "p_workflow_object_id" => 'PENRCON'.$object_id,
                "p_workflow_step_id" => ($firstWorkflowStep)?$firstWorkflowStep->workflow_step_id:'',
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
