<?php


namespace App\Http\Controllers\Api\V1\Payroll;
use App\Contracts\Payroll\PayrollContract;
use App\Entities\Payroll\PrMonths;
use App\Entities\Payroll\PrSalaryHeads;
use App\Entities\Payroll\PrSalaryProcess;
use App\Enums\Payroll\Period\FiscalMonths;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class DepuEmpSalaryProcessController extends Controller
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
            'pr_months' => $prFiscalYear->get()
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
        return ['params' => $params,'prSalaryHeads' => $this->getUnUsedHeads($deductionYn,$request,$salaryHead), 'salaryHeads' => $this->payrollAllHeads($request), 'salary' => $this->getEmployeeSalary($request->all())];

        if (!$params['o_status_message'])
            $params['o_status_message'] = "Something went wrong!!";

        return ['params' => $params];
    }

    public function payrollHeads(Request $request)
    {
        return $this->payrollAllHeads($request);
    }

    public function payrollHeadsUpdate(Request $request) {
        $allowances = $request->get('allowances');
        $deductions = $request->get('deductions');
        $salary = $request->get('salary');

        //updates allowances
        foreach ($allowances as $allowance) {
            if ($allowance['editable_yn'] == "Y") {
                    $p['pr_process_id'] = $allowance['pr_process_id'];
                    $p['amount'] = $allowance['amount'];
                    $p['remarks'] = '';
                    $params = $this->updatePayrollHeads($p);
                    if ($params['o_status_code'] != 1){
                        return $params;
                    }
            }
        }

        //Updates deductions

           foreach ($deductions as $deduction) {
               if ( $deduction['editable_yn'] == "Y") {
                   $p['pr_process_id'] = $deduction['pr_process_id'];
                   $p['amount'] = $deduction['amount'];
                   $p['remarks'] = '';
                   $params = $this->updatePayrollHeads($p);
                   if ($params['o_status_code'] != 1){
                       return $params;
                   }
               }
           }

        return ['o_status_code' => 1, 'o_status_message' => 'Updated successfully', 'salary' => $this->getEmployeeSalary($salary)];
    }

    /**
     * Delete specific head based on payroll salary head
     *
     * @param Request $request
     * @param PrSalaryHeads $salaryHead
     * @return array
     */
    public function deletePayrollHead(Request $request, PrSalaryHeads $salaryHead) {
        $params = $this->payroll_emp_sal_delete_head($request);
        if ($params['o_status_code'] == 1)
            return ['params' => $params,'prSalaryHeads' => $this->getUnUsedHeads($request->get('deduction_yn'),$request,$salaryHead), 'salaryHeads' => $this->payrollAllHeads($request), 'salary' => $this->getEmployeeSalary($request->all())];

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
    public function list($fYear, $prMonth, $billCode,Request $request) {
        //DB::enableQueryLog();
        $prProcess = new PrSalaryProcess();
        $bonus_head=new PrSalaryHeads();
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');
        $prProcess = $prProcess->select(
            DB::raw("SUM(CASE WHEN pr_salary_process.deduction_yn='N' THEN pr_salary_process.amount ELSE 0 END) as sum_allowance"),
            DB::raw("SUM(CASE WHEN pr_salary_process.deduction_yn='Y' THEN pr_salary_process.amount ELSE 0 END) as sum_deduction"),
            DB::raw("SUM(CASE WHEN pr_salary_process.deduction_yn='N' THEN pr_salary_process.amount ELSE 0 END)- SUM(CASE WHEN pr_salary_process.deduction_yn='Y' THEN pr_salary_process.amount ELSE 0 END) as salary"),
            'pr_salary_process.emp_code', 'pr_salary_process.emp_name','pr_salary_process.pr_year', 'pr_salary_process.pr_month_id', 'pr_salary_process.bill_code', 'pr_salary_process.designation_id') //Bill code instead of biller code.
            ->groupBy('pr_salary_process.emp_code')
            ->groupBy('pr_salary_process.emp_name')
            ->groupBy('pr_salary_process.pr_year')
            ->groupBy('pr_salary_process.pr_month_id')
            ->groupBy('pr_salary_process.bill_code') //Bill code instead of biller code.
            ->groupBy('pr_salary_process.designation_id')
            ->orderBy("pr_salary_process.emp_name", 'asc');
        $where = [];
        $orWhere = [];
        if ($fYear) {
            $where[] = ['pr_salary_process.pr_year', '=', $fYear];
        }
        if ($prMonth) {
            $where[] = ['pr_salary_process.pr_month_id', '=', $prMonth];
        }
        if ($billCode) {
            $where[] = ['pr_salary_process.bill_code', '=', $billCode]; //Bill code instead of biller code.
        }
        if ($searchValue) {
            $where[] = ['pr_salary_process.emp_code', 'like', "%".trim($searchValue)."%"];
            $orWhere[] = ['pr_salary_process.emp_name', 'like', "%".trim($searchValue)."%"];
        }
        $prProcess=$prProcess->join('pr_salary_heads', function ($join) {
                $join->on('pr_salary_heads.salary_head_id', '=', 'pr_salary_process.salary_head_id')
                    ->where('pr_salary_heads.bonus_yn', '=', 'N');
            });
        $data = $prProcess->where($where)->orWhere($orWhere)->paginate($length);
        //dd(DB::getQueryLog());

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

    private function updatePayrollHeads($p) {
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_pr_process_id" => $p["pr_process_id"],
                "p_salary_amount" => $p["amount"],
                "p_remarks" => $p['remarks'],
                "p_update_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PAYROLL.PR_EMP_SALARY_UPDATE", $params);
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
        return $this->EMPLOYEE_PR_PROCESS($request);
    }

    public function EMPLOYEE_PR_PROCESS(Request $request)
    {

        try {
            //dd(Auth::user());
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_pr_month_id" => $request->get("months"),
                "p_process_by_emp_id" => (int)Auth::user()->emp_id,
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            //dd($params); die();
            DB::executeProcedure("EMPLOYEE_PR_PROCESS", $params);
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
        $existHeads = DB::table('pr_salary_process')->select('salary_head_id')->where($where)->orderBy('salary_head', 'ASC')->get();
        $data = [];
        foreach ($existHeads as $head) {
            if ($head->salary_head_id)
            $data[] = $head->salary_head_id;
        }
        //$where2[] = ['every_month_yn', 'N'];
        $where2[] = ['deduction_yn', strtoupper($deductionYn)];
        return $salaryHead->where($where2)
            ->whereNotIn('salary_head_id', $data)
            ->where('bonus_yn','N')
            ->orderBy("salary_head", 'asc')
            ->get();
    }

    /**
     * Get payroll all heads based on generated pr process
     * Todo: to move manager if  multiple uses
     *
     * @param Request $request
     * @return array
     */
    private function payrollAllHeads(Request $request) {
        $prProcess = new PrSalaryProcess();
        $where[] = ['pr_year', '=', $request->get('pr_year')];
        $where[] = ['pr_month_id', '=', $request->get('pr_month_id')];
        $where[] = ['bill_code', '=', $request->get('bill_code')]; //Bill code instead of biller code.
        $where[] = ['emp_code', '=', $request->get('emp_code')];
        $heads= DB::table('pr_salary_process')
            ->select('pr_salary_process.editable_yn','pr_salary_process.every_month_yn','pr_salary_process.emp_code', 'pr_salary_process.pr_month_id', 'pr_salary_process.emp_name','pr_salary_process.designation_id','pr_salary_process.bill_code',
            'pr_salary_process.pr_process_id', 'pr_salary_process.salary_head', 'pr_salary_process.deduction_yn', 'pr_salary_process.pr_year',DB::raw('to_char(pr_salary_process.amount,99999.99) as amount'))
            ->join('pr_salary_heads', function ($join) {
                $join->on('pr_salary_heads.salary_head_id', '=', 'pr_salary_process.salary_head_id')
                    ->where('pr_salary_heads.bonus_yn', '=', 'N');
            })
           ->where($where)
           ->orderBy('pr_salary_process.every_month_yn', 'DESC')
           ->orderBy('pr_salary_process.salary_head', 'ASC')
           ->get(); //
        $groups= [];
        foreach ($heads as $head) {
            $group = ($head->deduction_yn == "Y")?'deductions':"allowances";
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

    private function getEmployeeSalary($params) {
        $prProcess = new PrSalaryProcess();
        $prProcess = $prProcess->select(
            DB::raw("SUM(CASE WHEN deduction_yn='N' THEN amount ELSE 0 END) as sum_allowance"),
            DB::raw("SUM(CASE WHEN deduction_yn='Y' THEN amount ELSE 0 END) as sum_deduction"),
            DB::raw("SUM(CASE WHEN deduction_yn='N' THEN amount ELSE 0 END)- SUM(CASE WHEN deduction_yn='Y' THEN amount ELSE 0 END) as salary"),
            'emp_code', 'emp_name','pr_year', 'pr_month_id', 'bill_code', 'designation_id') //Bill code instead of biller code.
            ->groupBy('emp_code')
            ->groupBy('emp_name')
            ->groupBy('pr_year')
            ->groupBy('pr_month_id')
            ->groupBy('bill_code') //Bill code instead of biller code.
            ->groupBy('designation_id')
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
