<?php

namespace App\Http\Controllers\Api\V1\Payroll;

use App\Entities\Admin\LPrBillStatus;
use App\Entities\Payroll\PrBillState;
use App\Contracts\Payroll\PayrollContract;
use App\Http\Controllers\Controller;
use App\Managers\Payroll\PayrollManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DepuEmpBillStatusController extends Controller
{
    /** @var PayrollContract|PayrollManager */
    private $payrollManager;

    public function __construct(PayrollContract $payrollManager)
    {
        $this->payrollManager = $payrollManager;
    }

    /**
     * Bill Status
     *
     * @param $billCode
     * @param PrBillState $billState
     * @return mixed
     */
    public function get($billCode, $monthId, PrBillState $billState, LPrBillStatus $billStatus) {
        return $this->getStates($billCode,$monthId,$billState, $billStatus);
    }

    public function post($billCode,$monthId,Request $request, PrBillState $billState, LPrBillStatus $billStatus) {
        $params = $this->payroll_pr_approval_state_entry($request);
        if ($params['o_status_code'] ==1) {
            return $this->getStates($billCode, $monthId, $billState, $billStatus);
        }
        return $params;
    }

    public function getBonus($billCode, $monthId,$head, PrBillState $billState, LPrBillStatus $billStatus) {
        return $this->getBonusStates($billCode,$monthId,$head,$billState, $billStatus);
    }

    public function postBonus($billCode,$monthId,$head,Request $request, PrBillState $billState, LPrBillStatus $billStatus) {
        $params = $this->bonus_pr_approval_state_entry($request);
        if ($params['o_status_code'] ==1) {
            return $this->getBonusStates($billCode, $monthId,$head, $billState, $billStatus);
        }
        return $params;
    }


    public function getStates($billCode, $monthId, PrBillState $billState, LPrBillStatus $billStatus) {
        $sql = "select
       pbs.INSERT_DATE as pbs_insert_date,
       pbs.BILL_STATE_ID,
       emp.EMP_NAME,
       d.DESIGNATION,
       lbs.*,
       pbsc.NOTE,
       pbsc.INSERT_BY as commented_by
from pmis.PR_BILL_STATES pbs
        left join pmis.PR_BILL_STATE_COMMENTS pbsc
            on (pbsc.BILL_STATE_ID = pbs.BILL_STATE_ID)
        left join pmis.L_PR_BILL_STATUS lbs
            on (pbs.PR_BILL_STATUS_ID=lbs.PR_BILL_STATUS_ID)
        left join CPA_SECURITY.SEC_USERS u
            on (u.USER_ID = pbs.INSERT_BY)
        left join pmis.EMPLOYEE emp
            on (emp.emp_id = u.emp_id)
        left join pmis.L_DESIGNATION d
            on (emp.DESIGNATION_ID = d.DESIGNATION_ID)
where (pbs.MONTH_ID = :month_id and pbs.BILL_CODE=:bill_code) order by pbs.INSERT_DATE desc, lbs.PROCESS_STEP desc";

        $billStates = DB::select($sql, ['month_id' => $monthId, 'bill_code' => $billCode]);
        $billStepPosition = 1;
        $currentSate = '';
        foreach ($billStates as $bstate) {
            $billStepPosition = $bstate->process_step+1;
            $currentSate = $bstate;
            break;
        }
        $billStatus = $billStatus->where('process_step',$billStepPosition)->orderBy('process_step', 'asc')->first();
        $options = [];

        $backwardStatus = array();
        if ($billStatus) {
            $backwardStatus = $billStatus->where('process_step', '<', $currentSate->process_step)->orderBy('process_step', 'asc')->get();
        }

        foreach ($backwardStatus as $bstatus) {
            $options[] =[
                "value" => $bstatus->pr_bill_status_id,
                "text" => $bstatus->status_name
            ];
        }

        if ($currentSate) {
            $options[] = [
                "value" => $currentSate->pr_bill_status_id,
                "text" => $currentSate->status_name,
                'disabled' => true
            ];
        }


        if ($billStatus) {
            $options[] =[
                "value" => $billStatus->pr_bill_status_id,
                "text" => $billStatus->status_name
            ];
        }
        return [
            'bill_status' => $billStates,
            'next_status'=>$billStatus,
            'current_status' => $currentSate,
            'pos' => $billStepPosition,
            'options' => $options
        ];
    }

    public function getBonusStates($billCode, $monthId,$head,PrBillState $billState, LPrBillStatus $billStatus) {
        $sql = "select
       pbs.INSERT_DATE as pbs_insert_date,
       pbs.BILL_STATE_ID,
       pbs.salary_head_id,
       emp.EMP_NAME,
       d.DESIGNATION,
       lbs.*,
       pbsc.NOTE,
       pbsc.INSERT_BY as commented_by,
       psh.salary_head
from pmis.PR_DEPU_BILL_STATES pbs
        left join pmis.PR_DEPUT_BILL_STATE_COMM pbsc
            on (pbsc.BILL_STATE_ID = pbs.BILL_STATE_ID)
        left join pmis.L_PR_BILL_STATUS lbs
            on (pbs.PR_BILL_STATUS_ID=lbs.PR_BILL_STATUS_ID)
        left join CPA_SECURITY.SEC_USERS u
            on (u.USER_ID = pbs.INSERT_BY)
        left join pmis.EMPLOYEE_DEPU emp
            on (emp.emp_id = u.emp_id)
        left join pmis.L_DESIGNATION d
            on (emp.DESIGNATION_ID = d.DESIGNATION_ID)
        left join pmis.pr_salary_heads psh
            on (psh.salary_head_id=pbs.salary_head_id)
        and pbs.is_bonus_yn='Y'
        and pbs.salary_head_id is not null
where (pbs.MONTH_ID = :month_id and pbs.BILL_CODE=:bill_code and pbs.salary_head_id=:head) order by emp.emp_code asc";
//where (pbs.MONTH_ID = :month_id and pbs.BILL_CODE=:bill_code and pbs.salary_head_id=:head) order by  pbs.INSERT_DATE desc, lbs.PROCESS_STEP desc";

        $billStates = DB::select($sql, ['month_id' => $monthId, 'bill_code' => $billCode,'head'=>$head]);
        $billStepPosition = 1;
        $currentSate = '';
        foreach ($billStates as $bstate) {
            $billStepPosition = $bstate->process_step+1;
            $currentSate = $bstate;
            break;
        }
        $billStatus = $billStatus->where('process_step',$billStepPosition)->orderBy('process_step', 'asc')->first();
        $options = [];

        $backwardStatus = array();
        if ($billStatus) {
            $backwardStatus = $billStatus->where('process_step', '<', $currentSate->process_step)->orderBy('process_step', 'asc')->get();
        }

        foreach ($backwardStatus as $bstatus) {
            $options[] =[
                "value" => $bstatus->pr_bill_status_id,
                "text" => $bstatus->status_name
            ];
        }

        if ($currentSate) {
            $options[] = [
                "value" => $currentSate->pr_bill_status_id,
                "text" => $currentSate->status_name,
                'disabled' => true
            ];
        }


        if ($billStatus) {
            $options[] =[
                "value" => $billStatus->pr_bill_status_id,
                "text" => $billStatus->status_name
            ];
        }
        return [
            'bill_status' => $billStates,
            'next_status'=>$billStatus,
            'current_status' => $currentSate,
            'pos' => $billStepPosition,
            'options' => $options
        ];
    }


    public function payroll_pr_approval_state_entry(Request $request, $note = ' ')
    {

        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_month_id" => $request->get("month_id"),
                "p_bill_code" => $request->get("bill_code"),
                "p_status_id" => $request->get("pr_bill_status_id"),
                "p_insert_by" => auth()->id(),
                "p_note" => $request->get("note")?:$note,
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PAYROLL.PR_APPROVAL_STATE_ENTRY", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code"=>99, "o_status_message" => $e->getMessage()];
        }
        return $params;
    }


    public function bonus_pr_approval_state_entry(Request $request, $note = ' ')
    {
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_month_id" => $request->get("month_id"),
                "p_bill_code" => $request->get("bill_code"),
                "p_status_id" => $request->get("pr_bill_status_id"),
                "p_insert_by" => auth()->id(),
                "p_note" => $request->get("note")?:$note,
                "p_salary_head_id" => $request->get("head"),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PAYROLL.PR_DEPU_BONUS_ST_ENTRY", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code"=>99, "o_status_message" => $e->getMessage()];
        }
        return $params;
    }

    public function disbursement(Request $request,  PrBillState $billState, LPrBillStatus $billStatus) {
        $params = $this->PAYROLL_PAYROLL_DISBURSE($request);

        if ($params['o_status_code'] == 1) {
            $param = $this->payroll_pr_approval_state_entry($request, "Bill disbursement is done");
            if ($param['o_status_code'] == 1) {
                return $this->getStates($request->get("bill_code"), $request->get("month_id"), $billState, $billStatus);
            }
            return $param;
        }

        return $params;
    }


    public function bonusDisbursement(Request $request,  PrBillState $billState, LPrBillStatus $billStatus) {
        $params = $this->PAYROLL_BONUS_DISBURSE($request);

        if ($params['o_status_code'] == 1) {
            $param = $this->bonus_pr_approval_state_entry($request, "Bill disbursement is done");
            if ($param['o_status_code'] == 1) {
                return $this->getBonusStates($request->get("bill_code"), $request->get("month_id"), $request->get("head"),$billState, $billStatus);
            }
            return $param;
        }

        return $params;
    }

    /**
     *
     * @param Request $request
     * @return array
     */
    public function PAYROLL_PAYROLL_DISBURSE(Request $request)
    {
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_pr_month_id" => $request->get('month_id'),
                "p_bill_code" => $request->get('bill_code'),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PAYROLL.PAYROLL_DISBURSE", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
        return $params;
    }

    /**
     *
     * @param Request $request
     * @return array
     */
    public function PAYROLL_BONUS_DISBURSE(Request $request)
    {
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_pr_month_id" => $request->get('month_id'),
                "p_bill_code" => $request->get('bill_code'),
                "p_salary_head_id" => $request->get('head'),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PAYROLL.DEPU_BONUS_DISBURSE", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
        return $params;
    }

    public function getCurrentStatus($fYear, $prMonth, $billCode) {
        $sql = "select
        pbs.INSERT_DATE as pbs_insert_date,
        pbs.INSERT_DATE,
        pbs.BILL_STATE_ID,
        emp.EMP_NAME,
        d.DESIGNATION,
        lbs.*,
        pbsc.NOTE,
        pbsc.INSERT_BY as commented_by
from pmis.PR_BILL_STATES pbs
        left join pmis.PR_BILL_STATE_COMMENTS pbsc
            on (pbsc.BILL_STATE_ID = pbs.BILL_STATE_ID)
        left join pmis.L_PR_BILL_STATUS lbs
            on (pbs.PR_BILL_STATUS_ID=lbs.PR_BILL_STATUS_ID)
        left join CPA_SECURITY.SEC_USERS u
            on (u.USER_ID = pbs.INSERT_BY)
        left join pmis.EMPLOYEE emp
            on (emp.emp_id = u.emp_id)
        left join pmis.L_DESIGNATION d
            on (emp.DESIGNATION_ID = d.DESIGNATION_ID)
where (pbs.MONTH_ID = :month_id and pbs.BILL_CODE=:bill_code) order by pbs.INSERT_DATE desc, lbs.PROCESS_STEP desc";
        $data =  DB::selectOne($sql, ['month_id' => $prMonth, 'bill_code' => $billCode]);

        return ["state" => $data];
    }

    public function getCurrentBonusStatus($fYear, $prMonth,$head,$billCode) {
        $sql = "select
        pbs.INSERT_DATE as pbs_insert_date,
        pbs.INSERT_DATE,
        pbs.BILL_STATE_ID,
        pbs.salary_head_id,
        emp.EMP_NAME,
        d.DESIGNATION,
        lbs.*,
        pbsc.NOTE,
        pbsc.INSERT_BY as commented_by,
        psh.salary_head
from pmis.PR_DEPU_BILL_STATES pbs
        left join pmis.PR_DEPUT_BILL_STATE_COMM pbsc
            on (pbsc.BILL_STATE_ID = pbs.BILL_STATE_ID)
        left join pmis.L_PR_BILL_STATUS lbs
            on (pbs.PR_BILL_STATUS_ID=lbs.PR_BILL_STATUS_ID)
        left join CPA_SECURITY.SEC_USERS u
            on (u.USER_ID = pbs.INSERT_BY)
        left join pmis.EMPLOYEE_DEPU emp
            on (emp.emp_id = u.emp_id)
        left join pmis.L_DESIGNATION d
            on (emp.DESIGNATION_ID = d.DESIGNATION_ID)
       left join pmis.pr_salary_heads psh
            on (psh.salary_head_id=pbs.salary_head_id)
where (pbs.MONTH_ID = :month_id and pbs.BILL_CODE=:bill_code and pbs.salary_head_id=:head)
AND PBS.IS_BONUS_YN='Y'
AND PBS.SALARY_HEAD_ID IS not NULL
order by pbs.INSERT_DATE desc, lbs.PROCESS_STEP desc";
        $data =  DB::selectOne($sql, ['month_id' => $prMonth, 'bill_code' => $billCode,'head' => $head]);
        return ["state" => $data];
    }

}
