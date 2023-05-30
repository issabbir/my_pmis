<?php


namespace App\Http\Controllers\Api\V1\Report;

use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Admin\LDptSection;
use App\Entities\Loan\LoanApplication;
use App\Entities\Payroll\PrFiscalYear;
use App\Entities\Payroll\PrMonths;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Security\Report;
use App\Managers\Admin\AdminManager;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\DB;
use App\Contracts\Payroll\PayrollContract;
use App\Entities\Payroll\EmpSalaryApplicable;
use App\Http\Controllers\Controller;
use App\Managers\Payroll\PayrollManager;
use Illuminate\Http\Request;

class LoanParameterController extends Controller
{
    private $payrollManager;
    private  $adminManager;
    private  $report;


    public function __construct(PayrollContract $payrollManager,AdminManager $adminManager, Report $report) {
        $this->payrollManager = $payrollManager;
        $this->adminManager=$adminManager;
        $this->report =  $report;
    }

    public function index(Request $request)
    {
        $module = 16;
        if (auth()->user()->hasGrantAll()) {
            $reports = $this->report->where('module_id', $module)->orderBy('report_name', 'ASC')->get();
        }
        else {
            $roles = auth()->user()->getRoles();
            $reports = array();
            foreach ($roles as $role) {
                $rpts = $role->reports->where('module_id', $module);
                foreach ($rpts as $report) {
                    $reports[$report->report_id] = $report;
                }
            }
        }

        $adminManager=$this->adminManager;
        return[
            "billcodes" => $this->getEmployeeBillCodes(),
            "departments" => $adminManager->findDepartments(),
            "prMonths"=> $this->getPrMonths(),
            'prFiscalYears' => $this->payrollManager->findPrFiscalYears(),
            "loanNumbers"=>$this->getLoanNo(),
            'reports' => $reports
        ];
    }
    public function activeFinancialYear(Request $request)
    {

        return[
            "prMonths"=> $this->getPrMonths(),
            'prFiscalYears' => PrFiscalYear::where('current_yn','Y')->get(),
        ];
    }
    public function getMonthsLoan($yr=null) {
        $sql  = "select pm.PR_MONTH_ID as value, to_char(pm.CALCULATION_START_DATE, 'fmMonth - YYYY') as text
            from PR_MONTHS  pm where  pm.FY_ID = nvl(:year,pm.FY_ID) and pm.current_yn='Y'
            order by pm.PR_MONTH_ID" ;
         return DB::select($sql,['year' => $yr]);
     }
    private function getEmployeeBillCodes() {
        return $this->payrollManager->getEmployeeBillCodes();
    }

    private function getPrMonths(){

        $prMonth = new PrMonths();
        $prMonths = $prMonth->orderBy('calculation_start_date', 'asc')->get([DB::raw("to_char(calculation_start_date, 'FMMonth-YYYY') as pr_month" ), 'pr_month_id']);

        $prMonths_option = array();
        foreach ($prMonths as $item) {
            $prMonths_option[] = ["text" => $item->pr_month,
                'value' => $item->pr_month_id];
        }
        return $prMonths_option;
    }

    private function getLoanNo(){
        $loans=new LoanApplication();
        $loanNo=$loans->orderBy('loan_no','asc')->get('loan_no');
        $loanNo_option=array();
        foreach ($loanNo as $item){
            $loanNo_option[]=["text"=>$item->loan_no,"value"=>$item->loan_no];
        }
        return $loanNo_option;
    }
}
