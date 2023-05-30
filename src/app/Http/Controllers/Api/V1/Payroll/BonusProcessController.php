<?php


namespace App\Http\Controllers\Api\V1\Payroll;
use App\Contracts\Payroll\PayrollContract;
use App\Entities\Payroll\PrBillCodeMapping;
use App\Entities\Payroll\PrMonths;
use App\Entities\Payroll\PrSalaryHeads;
use App\Entities\Payroll\PrSalaryProcess;
use App\Enums\Payroll\Period\FiscalMonths;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class BonusProcessController extends Controller
{
    private $payrollManager;

    public function __construct(PayrollContract $payrollManager)
    {
        $this->payrollManager = $payrollManager;
    }

    public function index(Request $request)
    {
        $payrollManager = $this->payrollManager;
        //$billCodes = $payrollManager->getEmployeeBillCodes();
        $prFiscalYear = new PrMonths();
        return [
            'fiscal_months' => FiscalMonths::getFiscalMonths(),
            'fecialYearList' => $payrollManager->findPrFiscalYears(),
            'billCodes' => [],
            'pr_months' => $prFiscalYear->get(),
        ];
    }

    public function getBonusHeads(){
        $bonusHeads=DB::table('pr_salary_heads')->where('bonus_yn','Y')->get();
        return[
            'bonusHeads'=>$bonusHeads
        ];

    }

    public function loadHeads($deductionYn, Request $request, PrSalaryHeads $salaryHead)
    {
        return $this->getUnUsedHeads($deductionYn,$request,$salaryHead);
    }

    public function addHead($deductionYn, Request $request, PrSalaryHeads $salaryHead)
    {
        $amount = 0;
        $sHead = "";
        if ($deductionYn == "N") {
            if ($request->get('allowance')) {
                $amount = isset($request->get('allowance')['amount'])?$request->get('allowance')['amount']:"";
                $sHead = isset($request->get('allowance')['salary_head'])?$request->get('allowance')['salary_head']:"";
            }
        }
        if ($deductionYn == "Y") {
            if ($request->get('deduction')) {
                $amount = isset($request->get('deduction')['amount'])?$request->get('deduction')['amount']:"";
                $sHead = isset($request->get('deduction')['salary_head'])?$request->get('deduction')['salary_head']:0;
            }
        }
        $params = $this->emp_sal_process_addition_head($deductionYn, $sHead, $amount, $request);
        if ($params['o_status_code'] == 1)
        return ['params' => $params,'prSalaryHeads' => $this->getUnUsedHeads($deductionYn,$request,$salaryHead), 'salaryHeads' => $this->bonusAllHeads($request), 'salary' => $this->getEmployeeSalary($request->all())];

        if (!$params['o_status_message'])
            $params['o_status_message'] = "Something went wrong!!";

        return ['params' => $params];
    }

    public function bonusHeads(Request $request)
    {
        return $this->bonusAllHeads($request);
    }

    public function bonusHeadsUpdate(Request $request) {
        $bonuses = $request->get('bonuses');
        $bonus_data = $request->get('bonus');
        foreach ($bonuses as $bonus) {
                    $p['pr_process_id'] = $bonus['pr_process_id'];
                    $p['amount'] = $bonus['amount'];
                    $p['remarks'] = $bonus_data['remarks'];
                    $params = $this->updateBonusHeads($p);
                    if ($params['o_status_code'] != 1){
                        return $params;
                    }
        }
        return ['o_status_code' => 1, 'o_status_message' => 'Updated successfully', 'bonus' => $this->getEmployeeBonus($bonus_data)];
    }

    /**
     * Delete specific head based on payroll salary head
     *
     * @param Request $request
     * @param PrSalaryHeads $salaryHead
     * @return array
     */
    public function deleteBonusHead(Request $request, PrSalaryHeads $salaryHead) {
        $params = $this->payroll_emp_sal_delete_head($request);
        if ($params['o_status_code'] == 1)
            return ['params' => $params,'prSalaryHeads' => $this->getUnUsedHeads($request->get('deduction_yn'),$request,$salaryHead), 'salaryHeads' => $this->bonusAllHeads($request), 'bonus' => $this->getEmployeeBonus($request->all())];

        return ["params" => $params];
    }

    /**
     * Delete salary head by procedure
     *
     * @param Request $request
     * @return array
     */
    public function payroll_emp_sal_delete_head(Request $request)
    {
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [

                "p_pr_process_id" => $request->get("pr_process_id"),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PAYROLL.EMP_SAL_DELETE_HEAD", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    /**
     * List of payroll based on generated salary
     *
     * @param $fYear
     * @param $prMonth
     * @param $billCode
     * @param Request $request
     * @return DataTableCollectionResource
     */
    public function list($fYear, $prMonth, $head,$billCode,Request $request) {
        //DB::enableQueryLog();
        $prProcess = new PrSalaryProcess();
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');
        $prProcess = $prProcess->select(
            'emp_code', 'emp_name','pr_year', 'pr_month_id', 'bill_code', 'designation_id','salary_head_id','remarks','salary_head','amount as bonus') //Bill code instead of biller code.
            ->where('deputation_yn','N')
            ->groupBy('emp_code')
            ->groupBy('emp_name')
            ->groupBy('pr_year')
            ->groupBy('pr_month_id')
            ->groupBy('bill_code')
            ->groupBy('designation_id')
            ->groupBy('salary_head_id')
            ->groupBy('salary_head')
            ->groupBy('amount')
            ->groupBy('remarks')
            ->orderBy("emp_code", 'asc');
        $where = [];
        $orWhere = [];
        if ($fYear) {
            $where[] = ['pr_year', '=', $fYear];
        }
        if ($prMonth) {
            $where[] = ['pr_month_id', '=', $prMonth];
        }
        if ($head) {
            $where[] = ['salary_head_id', '=', $head];
        }
        if ($billCode) {
            $where[] = ['bill_code', '=', $billCode]; //Bill code instead of biller code.
        }
        if ($searchValue) {
            $where[] = ['emp_code', 'like', "%".trim($searchValue)."%"];
            $orWhere[] = ['emp_name', 'like', "%".trim($searchValue)."%"];
        }
        $data = $prProcess->where($where)->orWhere($orWhere)->paginate($length);
        return new DataTableCollectionResource($data);
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function update($id, Request $request) {
        $prProcessId = $request->get("pr_process_id");
        $params = $this->payroll_pr_emp_salary_update($request);
        if (isset($params['o_status_code']) && $params['o_status_code'] == 1) {
            $prProcess = new PrSalaryProcess();
            $params['pr']=$prProcess->find($prProcessId);
        }

        return $params;
    }

    public function search(Request $request)
    {
        $bill_code = trim($request->post('bill_code')); //Bill code instead of biller code.
        $emp_code = trim($request->post('emp_code'));
        $fiscalYear = trim($request->post('fiscalYear'));
        $pr_month = trim($request->post('pr_month'));


        $where = [];
        if($emp_code != "") {
            //$where[] =['pr_salary_process.emp_code','=',$emp_code];
        }
        if($pr_month > 0) {
            //$where[] =['pr_salary_process.pr_month','=',$pr_month];
        }
        $where[] = ['open_yn','!=','C'];
        $employees = DB::table('pr_salary_process')
            ->distinct()
            ->select(
                'pr_salary_process.emp_name',
                'pr_salary_process.emp_code',
                'pr_salary_process.emp_id')
            ->where($where)
            ->get('emp_code');
        $records = DB::table('pr_salary_process')
            ->select(
                'pr_salary_process.emp_id','salary_head_id', 'amount')
            ->where($where)
            ->get();

        $salaryHeads = DB::table('pr_salary_process')
            ->distinct()->select(
                'pr_salary_process.salary_head_id',
                'pr_salary_process.salary_head_short_name')
            ->where($where)
            ->orderBy('salary_head_id', 'asc')
            ->get('salary_head_id');


        return [
            "employees" => $employees,
            "salaryHeads" => $salaryHeads,
            "records" => $records
        ];
    }

    private function updateBonusHeads($p) {
       // dd($p);
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_pr_process_id" => $p["pr_process_id"],
                "p_bonus_amount" => $p["amount"],
                "p_remarks" => $p['remarks'],
                "p_update_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];

            DB::executeProcedure("PAYROLL.pr_emp_bonus_update", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    public function payroll_pr_emp_salary_update(Request $request)
    {
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_pr_process_id" => $request->get("pr_process_id"),
                "p_salary_amount" => $request->get("amount"),
                "p_remarks" => $request->get("remarks"),
                "p_update_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PAYROLL.PR_EMP_SALARY_UPDATE", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 999, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }


    public function monthlyProcess(Request $request) {
       $pr_month_id=$request->get("months");
       $pr_bonus_head=$request->get("bonus_head");
       $pr_bill_code=PrBillCodeMapping::where('biller_emp_id',(int)Auth::user()->emp_id)->get('emp_bill_code');
       $bill_code=array();
       foreach ($pr_bill_code as $data){
           $bill_code[]=$data->emp_bill_code;
       }
       $bonus_process_data=PrSalaryProcess::where('PR_MONTH_ID',$pr_month_id)
                          ->where('salary_head_id',$pr_bonus_head)
                          ->where('deputation_yn','N')
                          ->whereIn('bill_code',$bill_code)->first();
//       if($bonus_process_data){
//           return ["exception" => true, "o_status_code" => 99, "o_status_message" => "SORRY! THIS BONUS ALREADY PROCESS"];
//       }else{
           return $this->EMPLOYEE_PR_PROCESS($request);
       //}
    }

    public function EMPLOYEE_PR_PROCESS(Request $request)
    {
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_pr_month_id" => $request->get("months"),
                "p_process_by_emp_id" => (int)Auth::user()->emp_id,
                "P_SALARY_HEAD_ID" => $request->get("bonus_head"),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("EMPLOYEE_BONUS_PROCESS", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    /**
     * Load unused heads to adding into the payroll
     *
     * Todo: to move manager if  multiple uses
     * @param $deductionYn
     * @param Request $request
     * @param PrSalaryHeads $salaryHead
     * @return mixed
     */
    private function getUnUsedHeads($deductionYn, Request $request, PrSalaryHeads $salaryHead) {
        $where[] = ['pr_year', '=', $request->get('pr_year')];
        $where[] = ['pr_month_id', '=', $request->get('pr_month_id')];
        $where[] = ['bill_code', '=', $request->get('bill_code')]; //Bill code instead of biller code.
        $where[] = ['emp_code', '=', $request->get('emp_code')];
        $where[] = ['deduction_yn', strtoupper($deductionYn)];
        $existHeads = DB::table('pr_salary_process')->select('salary_head_id')
                                                          ->where($where)->orderBy('salary_head', 'ASC')->get();

        $data = [];
        foreach ($existHeads as $head) {
            if ($head->salary_head_id)
            $data[] = $head->salary_head_id;
        }
        //$where2[] = ['every_month_yn', 'N'];
        $where2[] = ['deduction_yn', strtoupper($deductionYn)];
        return $salaryHead->where($where2)
                          ->where('bonus_yn','Y')
                          ->whereNotIn('salary_head_id', $data)
                          ->orderBy("salary_head", 'asc')->get();
    }

    /**
     * Get payroll all heads based on generated pr process
     * Todo: to move manager if  multiple uses
     *
     * @param Request $request
     * @return array
     */
    private function bonusAllHeads(Request $request) {
        $prProcess = new PrSalaryProcess();
        $where[] = ['pr_year', '=', $request->get('pr_year')];
        $where[] = ['pr_month_id', '=', $request->get('pr_month_id')];
        $where[] = ['bill_code', '=', $request->get('bill_code')]; //Bill code instead of biller code.
        $where[] = ['emp_code', '=', $request->get('emp_code')];
        $where[] = ['bonus_yn', '=', 'Y'];
        $where[] = ['salary_head_id', '=', $request->get('salary_head_id')];
        $heads= DB::table('pr_salary_process')->select('editable_yn','every_month_yn','emp_code', 'pr_month_id', 'emp_name','designation_id','bill_code',
            'pr_process_id', 'salary_head', 'deduction_yn','remarks', 'pr_year',DB::raw('to_char(amount,99999.99) as amount'))
//            ->whereIn('salary_head_id',[3, 23,24,25,26,27, 72, 78])
           ->where($where)
           ->orderBy('every_month_yn', 'DESC')
           ->orderBy('salary_head', 'ASC')
           ->get(); //
        $groups= [];
        foreach ($heads as $head) {
            $group = ($head->deduction_yn == "N")?'bonuses':"";
            $groups[$group][] = $head;
        }

        return $groups;
    }

    public function emp_sal_process_addition_head($isDeduction, $salleryHead,$amount, Request $request)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_emp_code" => $request->get("emp_code"),
                "p_pr_month_id" => $request->get("pr_month_id"),
                "p_pr_year_id" => $request->get("pr_year"),
                "p_biller_code" => $request->get("bill_code"), //Bill code instead of biller code.
                "p_deduction_yn" => $isDeduction,
                "p_salary_head_id" => $salleryHead,
                "p_amount" => $amount,
                "p_remarks" => ' ',
                "p_insert_by" => Auth()->Id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("EMP_SAL_PROCESS_ADDITION_HEAD", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    private function getEmployeeBonus($params) {
        $prProcess = new PrSalaryProcess();
        $prProcess = $prProcess->select(
            'emp_code', 'emp_name','pr_year', 'pr_month_id', 'bill_code', 'designation_id','salary_head_id','remarks','salary_head','amount as bonus') //Bill code instead of biller code.
            ->groupBy('emp_code')
            ->groupBy('emp_name')
            ->groupBy('pr_year')
            ->groupBy('pr_month_id')
            ->groupBy('bill_code')
            ->groupBy('designation_id')
            ->groupBy('salary_head_id')
            ->groupBy('salary_head')
            ->groupBy('amount')
            ->groupBy('remarks')
            ->orderBy("emp_name", 'asc');
        $where = [];
        $orWhere = [];
        if ($fYear = $params["pr_year"]) {
            $where[] = ['pr_year', '=', $fYear];
        }
        if ($prMonth = $params["pr_month_id"]) {
            $where[] = ['pr_month_id', '=', $prMonth];
        }
        if ($billCode = $params["bill_code"]) { //Bill code instead of biller code.
            $where[] = ['bill_code', '=', $billCode]; //Bill code instead of biller code.
        }
        if ($emp_code = $params["emp_code"]) {
            $where[] = ['emp_code', '=', $emp_code];
        }
        return  $prProcess->where($where)->orWhere($orWhere)->first();
    }

    public function salaryDispatch(Request $request)
    {
        return $this->employeePfDisburse($request);
    }

    public function employeePfDisburse(Request $request)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [

                "p_pr_month_id" => $request->get("pr_month_id"),
                "p_insert_by" => $request->get("insert_by"),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("EMPLOYEE_PF_DISBURSE", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code"=>999, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }
}
