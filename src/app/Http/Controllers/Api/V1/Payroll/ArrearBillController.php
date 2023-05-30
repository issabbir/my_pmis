<?php


namespace App\Http\Controllers\Api\V1\Payroll;


use App\Entities\Admin\WorkFlowProcess;
use App\Entities\Admin\WorkFlowStep;
use App\Entities\Payroll\BillMasterInfo;
use App\Entities\Payroll\PrBillCodeMapping;
use App\Entities\Pmis\Employee\Employee;
use App\Enums\Pmis\Employee\Statuses;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArrearBillController extends Controller
{
    protected $employee;
    protected $auth;

    public function __construct(Employee $employee, Guard $auth)
    {
        $this->employee = $employee;
        $this->auth = $auth;
    }

    public function searchEmployee($name){
        return $this->employee->select('emp_id','emp_code',DB::raw("emp_code||' '||emp_name AS option_name"),'emp_name','designation_id','dpt_department_id','section_id','bill_code','dpt_division_id','biller_code')
            ->where('employee.approved_yn','=', 'Y')
            ->whereIn('bill_code', DB::table('pr_bill_code_mapping')->where('biller_emp_id', Auth::user()->emp_id)->pluck('emp_bill_code')->toArray())
            ->where(function($query) use ($name){
                $query->where(DB::raw('LOWER(emp_name)'),'like',strtolower('%'.trim($name).'%'))
                    ->orWhere('emp_code', 'like', '%'.trim($name)."%" );
            })
            ->groupBy('emp_id','emp_code','emp_name','designation_id','dpt_department_id','section_id','bill_code','dpt_division_id','biller_code')
            ->limit(20)
            ->get();
    }

    public function searchAllEmployee($emp_code){
        return $this->employee->select('emp_id','emp_code',DB::raw("emp_code||' '||emp_name AS option_name"),'emp_name','designation_id','dpt_department_id','section_id','bill_code','dpt_division_id','biller_code','emp_tin_no')
            ->where('employee.approved_yn','=', 'Y')
            ->where(function($query) use ($emp_code){
                $query->where(DB::raw('LOWER(emp_name)'),'like',strtolower('%'.trim($emp_code).'%'))
                    ->orWhere('emp_code', 'like', '%'.trim($emp_code)."%" );
            })
            ->groupBy('emp_id','emp_code','emp_name','designation_id','dpt_department_id','section_id','bill_code','dpt_division_id','biller_code','emp_tin_no')
            ->get();
    }

    public function searchEmployeeDpt($dpt,$name){
        return $this->employee->select('emp_id','emp_code',DB::raw("emp_code||' '||emp_name AS option_name"),'emp_name','designation_id','dpt_department_id','section_id','bill_code','dpt_division_id','biller_code','emp_tin_no')
            ->where('employee.approved_yn','=', 'Y')
            ->whereIn('dpt_department_id', [$dpt,20])
//            ->whereIn('bill_code', DB::table('pr_bill_code_mapping')->where('biller_emp_id', Auth::user()->emp_id)->pluck('emp_bill_code')->toArray())
            ->where(function($query) use ($name){
                $query->where(DB::raw('LOWER(emp_name)'),'like',strtolower('%'.trim($name).'%'))
                    ->orWhere('emp_code', 'like', '%'.trim($name)."%" );
            })
            ->whereIn('employee.emp_status_id', [Statuses::ON_ROLL, 13])
            ->groupBy('emp_id','emp_code','emp_name','designation_id','dpt_department_id','section_id','bill_code','dpt_division_id','biller_code','emp_tin_no')
            ->limit(20)
            ->get();
    }

    public function fyList(){
        $SQL = "SELECT FY_ID, FY_NAME AS PR_YEAR, CURRENT_YN
    FROM PR_FISCAL_YEAR
GROUP BY FY_ID, FY_NAME, CURRENT_YN
ORDER BY FY_NAME";
        return DB::select($SQL);
    }

    public function prMonthList($id) {
        $SQL = "SELECT PR_MONTH,
         (CASE
             WHEN PR_MONTH = 1 THEN 'JULY'
             WHEN PR_MONTH = 2 THEN 'AUGUST'
             WHEN PR_MONTH = 3 THEN 'SEPTEMBER'
             WHEN PR_MONTH = 4 THEN 'OCTOBER'
             WHEN PR_MONTH = 5 THEN 'NOVEMBER'
             WHEN PR_MONTH = 6 THEN 'DECEMBER'
             WHEN PR_MONTH = 7 THEN 'JANUARY'
             WHEN PR_MONTH = 8 THEN 'FEBRUARY'
             WHEN PR_MONTH = 9 THEN 'MARCH'
             WHEN PR_MONTH = 10 THEN 'APRIL'
             WHEN PR_MONTH = 11 THEN 'MAY'
             WHEN PR_MONTH = 12 THEN 'JUNE'
             ELSE 'INVALID MONTH'
          END)
            PR_MONTH_NAME
    FROM PR_MONTHS
   WHERE FY_ID = :id
GROUP BY PR_MONTH
ORDER BY PR_MONTH";
        return DB::select($SQL, ['id'=>$id]);
    }

    public function getPrMonthId($fyId, $monthId){
        $SQL = "SELECT PR_MONTH_ID
  FROM PR_MONTHS
 WHERE FY_ID = :fyId AND PR_MONTH = :monthId";
        return DB::select($SQL, ['fyId'=>$fyId, 'monthId' => $monthId]);
    }

    public function billTypeList() {
        $SQL = "SELECT BILL_TYPE_ID, BILL_TYPE_NAME FROM L_BILL_TYPE";
        return DB::select($SQL);
    }

    public function billStatusList() {
        $SQL = "SELECT BILL_STATUS_ID, STATUS_NAME
  FROM L_ARREAR_BILL_STATUS
 WHERE ACTIVE_YN = 'Y'";
        return DB::select($SQL);
    }

    public function billHeadList() {
        $SQL = "SELECT SALARY_HEAD_ID AS BILL_HEAD_ID,
         SALARY_HEAD AS BILL_HEAD_NAME,
         SALARY_HEAD_ID,
         SALARY_HEAD,
         COA_CODE,
         DEDUCTION_YN,
         (CASE
             WHEN DEDUCTION_YN = 'Y' THEN 'Yes'
             WHEN DEDUCTION_YN = 'N' THEN 'No'
          END)
            AS DEDUCTION
    FROM PR_SALARY_HEADS
   WHERE BONUS_YN = 'N'
ORDER BY SALARY_HEAD
";
        return DB::select($SQL);
    }

    public function arrearDetailsList(Request $request){
        if($request->get('emp_id')==null){
            return BillMasterInfo::all();
        } else {
            return BillMasterInfo::where('emp_id', '=', $request->get('emp_id'))->get();
        }
    }

    public function updateProcessId(Request $request){
        try {
            $o_status_code = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');
            $params = [
                'p_workflow_process_id' => $request->get('workflow_process_id'),
                'p_bill_master_id' => $request->get('bill_master_id'),
                'p_insert_by' => Auth::id(),
                'o_status_code' => &$o_status_code,
                'o_status_message' => &$o_status_message,
            ];
            DB::executeProcedure('ARREARBILL.master_workflow_process_upd', $params);
            return $params;
        } catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
    }

    public function disburse($workflowId, $objectId, Request $request){
        try {
            $o_status_code = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');
            $params = [
                'p_bill_master_id' => $objectId,
                'p_insert_by' => Auth::id(),
                'o_status_code' => &$o_status_code,
                'o_status_message' => &$o_status_message,
            ];
            DB::executeProcedure('ARREARBILL.bill_master_info_approve', $params);

            if($params['o_status_code'] == '1') {
                $status_code = sprintf("%4000s", "");
                $status_message = sprintf("%4000s", "");
                $params = [
                    "p_workflow_process_id" => $request->get("workflow_process_id"),
                    "p_workflow_object_id" => $objectId,
                    "p_workflow_step_id" => $request->get("workflow_step_id"),
                    "p_note" => $request->get("note"),
                    "p_insert_by" => auth()->id(),
                    "o_status_code" => &$status_code,
                    "o_status_message" => &$status_message,
                ];
                DB::executeProcedure("workflow_Process_entry", $params);
                return $this->status($workflowId, $objectId);
            }
        } catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        return $params;
    }


    public function status($workflowId,$object_id) {
        $current_step = [];
        $previous_step = [];
        $workflowProcess = WorkFlowProcess::with('workflowStep')->where('workflow_object_id',$object_id)->orderBy('workflow_process_id', 'DESC')->get();


        //dd($workflowProcess);
        $option = [];
        if (!count($workflowProcess)){
            $next_step = WorkFlowStep::where('approval_workflow_id',$workflowId)->orderBy('process_step', 'asc')->first();
        }else{
            //dd($workflowProcess);
            if ($workflowProcess) {
                $current_step = $workflowProcess[0]->workflowStep;
                $sql = 'select e.emp_code, e.emp_name, d.designation
                       from cpa_security.sec_users u
                         inner join pmis.employee e on (e.emp_id = u.emp_id)
                         left join pmis.L_DESIGNATION d  on (d.designation_id = e.designation_id)
                         where user_id=:userId';
                $user = db::selectOne($sql,['userId' => $workflowProcess[0]->insert_by]);
                $current_step->user = $user;
                $current_step->note = $workflowProcess[0]->note;
            }
            //dd($current_step);

            $next_step = WorkFlowStep::where('approval_workflow_id',$workflowId)->where('process_step','>', $current_step->process_step)->orderBy('process_step', 'asc')->first();
            $previous_step = WorkFlowStep::where('approval_workflow_id',$workflowId)->where('process_step','<', $current_step->process_step)->orderBy('process_step', 'asc')->get();
        }

        if (!empty($previous_step)){
            foreach ($previous_step as $previous) {
                $option[] = [
                    'text' => "Backward ".$previous->workflow,
                    'value' => $previous->workflow_step_id,
                ];
            }
        }

        if (!empty($current_step)){
            $option[] = [
                'text' => 'Forwarded ' . $current_step->workflow,
                'value' => $current_step->workflow_step_id,
                'disabled' => true
            ];
        }

        if (!empty($next_step)){
            $option[] = [
                'text' => 'Forward ' . $next_step->workflow,
                'value' => $next_step->workflow_step_id,
            ];
        }


        $process = [];
        foreach ($workflowProcess as $wp) {
            $sql = 'select e.emp_code, e.emp_name, d.designation
                       from cpa_security.sec_users u
                         inner join pmis.employee e on (e.emp_id = u.emp_id)
                         left join pmis.L_DESIGNATION d  on (d.designation_id = e.designation_id)
                         where user_id=:userId';
            $user = db::selectOne($sql,['userId' => $wp->insert_by]);
            $wp->user = $user;
            $process[] = $wp;
        }

        return  response(
            [
                'workflowProcess' => $process,
                'next_step' => $next_step,
                'previous_step' => $previous_step,
                'current_step' => $current_step,
                'options' => $option,
            ]
        );
    }

    public function arrearMasterByBillNo($billNo){
        $SQL = "SELECT BMI.*,
       PM.FY_ID,
       PM.PR_MONTH,
       E.EMP_CODE || ' ' || E.EMP_NAME AS OPTION_NAME,
       D.DESIGNATION,
       DP.DEPARTMENT_NAME,
       DV.DPT_DIVISION_NAME,
       S.DPT_SECTION
  FROM BILL_MASTER_INFO BMI
       LEFT JOIN PR_MONTHS PM ON PM.PR_MONTH_ID = BMI.PR_MONTH_ID
       LEFT JOIN EMPLOYEE E ON E.EMP_ID = BMI.EMP_ID
       LEFT JOIN L_DESIGNATION D ON D.DESIGNATION_ID = E.DESIGNATION_ID
       LEFT JOIN L_DEPARTMENT DP ON DP.DEPARTMENT_ID = E.DPT_DEPARTMENT_ID
       LEFT JOIN L_DPT_DIVISION DV ON DV.DPT_DIVISION_ID = E.DPT_DIVISION_ID
       LEFT JOIN L_DPT_SECTION S ON S.DPT_SECTION_ID = E.SECTION_ID
 WHERE BILL_NO = :billNo";
        return DB::select($SQL, ['billNo'=>$billNo]);
    }

    public function  store(Request $request){
        $status_code = sprintf("%4000s","");
        $status_message = sprintf("%4000s","");
        try {
            $masterData = $request->get("masterData");
            $detailsData = $request->get("detailsData");
            $bill_master_id = $masterData["bill_master_id"];

            $masterParams = [
                "bill_master_id" => [
                    "value" => &$bill_master_id,
                    "type" => \PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                "bill_no" => $masterData["bill_no"],
                "bill_description" => $masterData["bill_description"],
                "pr_month_id" => $masterData["pr_month_id"],
                "go_no" => $masterData["go_no"],
                "go_date" => $masterData["go_date"],
                "bill_date" => $masterData["bill_date"],
                "bill_type_id" => $masterData["bill_type_id"],
                "bill_code" => $masterData["bill_code"],
                "emp_id" => $masterData["emp_id"],
                "emp_code" => $masterData["emp_code"],
                "dpt_division_id" => $masterData["dpt_division_id"],
                "department_id" => $masterData["department_id"],
                "bill_status_id" => $masterData["bill_status_id"],
                "active_yn" => $masterData["active_yn"],
                "deputation_yn" => $masterData["deputation_yn"],
                "remarks" => $masterData["remarks"],
                "pay_advice_no" => $masterData["pay_advice_no"],
                "pay_advice_date" => $masterData["pay_advice_date"]==null?"":date("Y-m-d", strtotime($masterData["pay_advice_date"])),
                "bill_from_date" => $masterData["bill_from_date"],
                "bill_to_date" => $masterData["bill_to_date"],
                "insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message
            ];
            DB::executeProcedure("arrearbill.bill_master_info_entry", $masterParams);

            if($masterParams["o_status_code"]==1){
                $detailsData["bill_master_id"] = $masterParams["bill_master_id"]['value'];
                $this->detailsStore($detailsData);
            } else{
                DB::rollBack();
            }

        }
        catch (\Exception $e) {
            return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $e->getMessage()];
        }

        return $masterParams;
    }

    public function detailsStore($detailsData){
        $status_code = sprintf("%4000s","");
        $status_message = sprintf("%4000s","");
        try {
            $bill_details_id = $detailsData["bill_details_id"];
            $detailsParams = [
                "bill_details_id" => [
                    "value" => &$bill_details_id,
                    "type" => \PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                "bill_master_id" => $detailsData["bill_master_id"],
                "bill_head_id" => $detailsData["bill_head_id"],
                "line_status_yn" => $detailsData["line_status_yn"],
                "line_description" => $detailsData["line_description"],
                "coa_code" => $detailsData["coa_code"],
                "amount" => $detailsData["amount"],
                "deduction_yn" => $detailsData["deduction_yn"],
                "active_yn" => $detailsData["active_yn"],
                "remarks" => $detailsData["remarks"],
                "addition_yn" => 'Y',
                "insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message
            ];
            DB::executeProcedure("arrearbill.bill_details_info_entry", $detailsParams);
        }
        catch (\Exception $e){
            return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $e->getMessage()];
        }
    }
}
