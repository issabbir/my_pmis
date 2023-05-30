<?php


namespace App\Http\Controllers\Api\V1\Pension;

use App\Contracts\Admin\AdminContract;
use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Admin\WorkFlowStep;
use App\Entities\Payroll\PrBillCodeMapping;
use App\Entities\Payroll\PrSalaryProcess;
use App\Entities\Pension\PensionProcess;
use App\Entities\Pension\PensionProcessApproval;
use App\Http\Controllers\Controller;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Self_;

class PensionProcessController extends Controller
{


    public function calculation(Request $request)
    {
        return $this->pensionCalculation($request);
    }

    public function getMonthlyPensionProcessData(Request $request)
    {
        $sql = "select pension.monthly_pen_process_grid_data(:fy_id,:pr_month_id,:department_id,:p_bonus_yn,:emp_id,:pension_cat,:emp_type) from dual";
        $pension_data= DB::select($sql, ['fy_id' => $request->get('fy_id'),
            'pr_month_id' => $request->get('pr_month_id'),
            'department_id' => $request->get('department_id'),
            'p_bonus_yn' => 'N',
            'emp_id' => $request->get('emp_id'),
            'pension_cat' => $request->get('pensionCat'),
            'emp_type' => $request->get('empType')
        ]);

        $process_data=$this->getPensionProcessRecord($request->get('pr_month_id'),'N',$request->get('pensionCat'));
        return ['data'=>$pension_data,
                'process_data'=>$process_data];

    }

    public function getEmployeeDetailsByCode($code){
       // dd($code);
        $sql= "SELECT E.EMP_ID,
       E.EMP_CODE,
       E.EMP_NAME,
       E.EMP_NAME_BNG,
       (SELECT LISTAGG (EMP_CONTACT_INFO, ', ')
                   WITHIN GROUP (ORDER BY EMP_CONTACT_TYPE_ID)
          FROM EMP_CONTACTS
         WHERE EMP_ID = E.EMP_ID AND EMP_CONTACT_TYPE_ID = 2 AND ROWNUM = 1)
           EMP_CONTACT_NO,
       --E.EMP_EMERGENCY_CONTACT_MOBILE,
       E.EMP_FATHER_NAME,
       E.EMP_FATHER_NAME_BNG,
       E.EMP_MOTHER_NAME,
       E.EMP_MOTHER_NAME_BNG,
       E.EMP_DOB,
       E.EMP_JOIN_DATE,
       E.EMP_LPR_DATE,
       E.EMP_GENDER_ID,
       E.EMP_GENDER_NAME,
       E.EMP_GENDER_NAME_BNG,
       E.EMP_RELIGION_ID,
       E.EMP_RELIGION_NAME,
       E.DPT_DEPARTMENT_ID,
       D.DEPARTMENT_NAME,
       D.DEPARTMENT_NAME_BNG,
       E.DESIGNATION_ID,
       DG.DESIGNATION,
       DG.DESIGNATION_BNG,
       E.BANK_ID,
       E.EMP_BANK_ACC_NO as bank_acc_no,
       B.BANK_NAME,
       B.BANK_NAME_BNG,
       E.BRANCH_ID,
       BR.BRANCH_NAME,
       BR.BRANCH_NAME_BNG,
       E.DPT_DIVISION_ID,
       DV.DPT_DIVISION_NAME,
       DV.DPT_DIVISION_NAME_BNG,
       E.SECTION_ID,
       S.DPT_SECTION,
       S.DPT_SECTION_BNG,
       E.EMP_CLASS,
       E.EMP_TYPE_ID,
       T.EMP_TYPE_NAME,
       T.EMP_TYPE_BNG,
       E.EMP_BLOOD_GROUP_ID,
       BG.BLOOD_GROUP,
       BG.BLOOD_GROUP_BNG,
       E.EMP_NATIONALITY_ID,
       N.NATIONALITY,
       N.NATIONALITY_BNG,
       E.EMP_QUOTA_ID,
       Q.QUOTA_NAME,
       Q.QUOTA_NAME_BNG,
       E.EMP_MEDICAL_BOOK_ID ,
       E.IDENTITY_SYMBOL,
       E.IDENTITY_SYMBOL_BNG,
       E.EMP_GRADE_ID,
       G.GRADE_RANGE,
       G.EMP_GRADE_BNG,
       E.DEAD_DATE,
       E.TRIBAL_YN,
       E.NID_NO
           AS EMP_NID_NO,
       E.ON_PENSION_YN
  --ES.EMP_STATUS_ID

  FROM EMPLOYEE        E,
       L_BANKS         B,
       L_BLOOD_GROUP   BG,
       L_DEPARTMENT    D,
       L_DESIGNATION   DG,
       L_DPT_DIVISION  DV,
       L_EMP_GRADE     G,
       L_DPT_SECTION   S,
       L_EMP_TYPE      T,
       --L_GENDER          GN,
       L_NATIONALITY   N,
       --L_RELIGION        R,
       L_QUOTA         Q,
       L_BRANCH        BR,
       EMP_CONTACTS    C
 --L_EMP_STATUS ES
       WHERE     E.EMP_CODE = :P_EMP_CODE
       AND E.DPT_DEPARTMENT_ID = D.DEPARTMENT_ID(+)
       AND E.DESIGNATION_ID = DG.DESIGNATION_ID(+)
       AND E.BANK_ID = B.BANK_ID(+)
       AND E.BRANCH_ID = BR.BRANCH_ID(+)
       AND E.DPT_DIVISION_ID = DV.DPT_DIVISION_ID(+)
       AND E.SECTION_ID = S.DPT_SECTION_ID(+)
       AND E.EMP_TYPE_ID = T.EMP_TYPE_ID(+)
       AND E.EMP_BLOOD_GROUP_ID = BG.BLOOD_GROUP_ID(+)
       AND E.EMP_NATIONALITY_ID = N.NATIONALITY_ID(+)
       AND E.EMP_QUOTA_ID = Q.QUOTA_ID(+)
       AND E.EMP_GRADE_ID = G.EMP_GRADE_ID(+)
       AND E.EMP_ID = C.EMP_ID(+)
       AND E.EMP_STATUS_ID = 5
       ";
        $data = DB::selectOne($sql,['p_emp_code' => $code]);
        return ['data' => $data];
    }

    public function getMonthlyPensionBonusData(Request $request)
    {
        $sql = "select pension.pension_bonus_process_grid_data(:p_fy_id,:p_pr_month_id,:p_department_id,:p_pension_head_id,:p_bonus_yn,:p_emp_id,:p_pension_pct, :p_emp_type_id ) from dual";
        $bonus_data=DB::select($sql, ['p_fy_id' => $request->get('fy_id'),
            'p_pr_month_id' => $request->get('pr_month_id'),
            'p_department_id' => $request->get('department_id'),
            'p_pension_head_id' => $request->get('bonus_head'),
            'p_bonus_yn' => 'Y',
            'p_emp_id' => $request->get('emp_id'),
            'p_pension_pct' => $request->get('pensionCat'),
            'p_emp_type_id' => $request->get('p_emp_type_id'),
        ]);
            $process_data=$this->getPensionProcessRecord($request->get('pr_month_id'),'Y',$request->get('pensionCat'));
            return ['data'=>$bonus_data,
                    'process_data'=>$process_data];

    }


    public function searchPensionPayableEmployee($searchParam)
    {
        $sql = "select pension.emp_search_pension (:param) from dual";
        return $list = DB::select($sql, ['param' => $searchParam]);
    }

    private function pensionCalculation(Request $request)
    {
        try {


            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_pension_calculation_id" => $request->get("pension_calculation_id"),
                "p_apps_id" => $request->get("apps_id"),
                "p_emp_id" => $request->get("emp_id"),
                "p_comment" => $request->get("comment"),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("pension.emp_pension_app_process", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }


    public function monthlyPensionProcess(Request $request)
    {
        try {

            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_pr_month_id" => $request->get("pr_month_id"),
                "p_pension_percentage" => $request->get("pension_cat"),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("pension.monthly_pension_process", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }


    public function pensionBonusProcess(Request $request)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_pr_month_id" => $request->get("months"),
                "p_bonus_head_id" => $request->get("bonus_head"),
                "p_pension_percentage" => $request->get('pension_percentage'),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("pension.pension_bonus_process", $params);
//            dd($params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
        return $params;
    }

    public function pensionBonusDisbursement(Request $request){


    }

    public function monthlyPensionDisbursement(Request $request){


    }

    private function getPensionProcessRecord($month_id,$bonus_yn,$pension_ptc){

       return  PensionProcessApproval::where('month_id',$month_id)
            ->where('bonus_yn',$bonus_yn)
            ->where('PENSION_PCT',$pension_ptc)
            ->first();

    }

    public function updatePensionApprovalWorkflow(Request $request, $id){

        $approval = DB::table('pension_process_approvals')
            ->where('pension_process_approval_id', $id)
            ->where('pension_pct', $request->get('pension_cat'))
            ->Where('pension_head_id', $request->get('pension_head_id'))
            ->update(['approval_workflow_id' => $request->get('approval_workflow_id')]);
        if ($approval){
            $response=$this->systemAutoCompleteStep($request,$id);
            return ['data'=>$response];
        }
        return ['data'=>'Data Not Found'];
    }

    private function systemAutoCompleteStep($request=[],$id){
        $firstWorkflowStep=WorkFlowStep::where('approval_workflow_id',$request->get('approval_workflow_id'))
            ->orderBy('PROCESS_STEP')
            ->first();
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $object_id = $request->get('pension_process_approval_id');
            $params = [
                "p_workflow_process_id" => '',
                "p_workflow_object_id" => 'pen_prc_'.$object_id,
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
