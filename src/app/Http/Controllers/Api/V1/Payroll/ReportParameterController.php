<?php


namespace App\Http\Controllers\Api\V1\Payroll;

use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Admin\LDptSection;
use App\Entities\Admin\LEmpStatus;
use App\Entities\Admin\LEmpType;
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

class ReportParameterController extends Controller
{
    private $payrollManager;
    private  $adminManager;
    private  $report;


    public function __construct(PayrollContract $payrollManager,AdminManager $adminManager, Report $report) {
        $this->payrollManager = $payrollManager;
        $this->adminManager=$adminManager;
        $this->report =  $report;
    }

    public function index(Request $request, $module=2)
    {
        $module = 2;
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
            "prMonths"=> $this->getMonthsById(),
            "prMonthsAll"=> $this->getMonths(),
            "billMonths"=> $this->getBillMonth(),
            "prBonusMonths"=> $this->getBonusMonthsById(),
            'prFiscalYears' => $this->payrollManager->findPrFiscalYears(),
            'empType' => LEmpType::all(),
            'empStatus' => LEmpStatus::all(),
            'reports' => $reports
        ];
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


    public function getBillCodes($mid) {
         $sql  = "select distinct pbs.BILL_CODE as vaue, pbs.BILL_CODE as text
from PR_BILL_STATES pbs
inner join L_PR_BILL_STATUS lpbs on (lpbs.PR_BILL_STATUS_ID = pbs.PR_BILL_STATUS_ID)
where pbs.BILL_CODE in (select EMP_BILL_CODE from PR_BILL_CODE_MAPPING where BILLER_EMP_ID = :empId and  ACTIVATION_FLAG = 'Y')
  and  pbs.month_id=:mid and lpbs.STATUS_KEY='BILL_DISBURSED'
order by pbs.bill_code" ;
        return $billCodes = DB::select($sql,['mid' => $mid, 'empId' => auth()->user()->emp_id]);
    }


    /**
     * @return array
     */
//    public function getMonths($yr=null) {
//        $sql  = "select distinct pm.PR_MONTH_ID as value, to_char(pm.CALCULATION_START_DATE, 'fmMonth - YYYY') as text
//from PR_BILL_STATES pbs
//         inner join L_PR_BILL_STATUS lps on (lps.PR_BILL_STATUS_ID = pbs.PR_BILL_STATUS_ID)
//         inner join PR_MONTHS pm on (pbs.MONTH_ID = pm.PR_MONTH_ID)
//where pbs.BILL_CODE in (select EMP_BILL_CODE from PR_BILL_CODE_MAPPING)
//  and pm.FY_ID = nvl(:year,pm.FY_ID) and lps.STATUS_KEY='BILL_DISBURSED'
//order by pm.PR_MONTH_ID" ;
//        return DB::select($sql,['year' => $yr]);
//    }
    public function getMonths($yr=null) {
        $sql  = "select distinct pm.PR_MONTH_ID as value, to_char(pm.CALCULATION_START_DATE, 'fmMonth - YYYY') as text
from PR_BILL_STATES pbs
         inner join L_PR_BILL_STATUS lps on (lps.PR_BILL_STATUS_ID = pbs.PR_BILL_STATUS_ID)
         inner join PR_MONTHS pm on (pbs.MONTH_ID = pm.PR_MONTH_ID)
where pbs.BILL_CODE in (select EMP_BILL_CODE from PR_BILL_CODE_MAPPING)
  and pm.FY_ID = nvl(:year,pm.FY_ID) and lps.STATUS_KEY='BILL_DISBURSED' and pm.open_yn = 'O'
order by pm.PR_MONTH_ID" ;
        return DB::select($sql,['year' => $yr]);
    }
    /**
     * @return array
     */
    public function getMonthsById($yr=null) {
        $sql  = "select distinct pm.PR_MONTH_ID as value, to_char(pm.CALCULATION_START_DATE, 'fmMonth - YYYY') as text
from PR_BILL_STATES pbs
         inner join L_PR_BILL_STATUS lps on (lps.PR_BILL_STATUS_ID = pbs.PR_BILL_STATUS_ID)
         inner join PR_MONTHS pm on (pbs.MONTH_ID = pm.PR_MONTH_ID)
where pbs.BILL_CODE in (select EMP_BILL_CODE from PR_BILL_CODE_MAPPING where BILLER_EMP_ID = :empId)
  and pm.FY_ID = nvl(:year,pm.FY_ID) and lps.STATUS_KEY='BILL_DISBURSED'
order by pm.PR_MONTH_ID" ;
        return DB::select($sql,['year' => $yr, 'empId' => auth()->user()->emp_id]);
    }

    public function getBillMonth($yr=null) {
        $sql  = "select distinct pm.PR_MONTH_ID as value, to_char(pm.CALCULATION_START_DATE, 'fmMonth - YYYY') as text
from PR_BILL_STATES pbs
         inner join L_PR_BILL_STATUS lps on (lps.PR_BILL_STATUS_ID = pbs.PR_BILL_STATUS_ID)
         inner join PR_MONTHS pm on (pbs.MONTH_ID = pm.PR_MONTH_ID) where pm.open_yn = 'O'
order by to_date(text, 'fmMonth - YYYY') DESC" ;
        return DB::select($sql);
    }

    /**
     * @return array
     */
    public function getBonusMonthsById($yr=null) {
        $sql  = "select distinct pm.PR_MONTH_ID as value, to_char(pm.CALCULATION_START_DATE, 'fmMonth - YYYY') as text
from PR_BONUS_STATES pbs
         inner join L_PR_BILL_STATUS lps on (lps.PR_BILL_STATUS_ID = pbs.PR_BILL_STATUS_ID)
         inner join PR_MONTHS pm on (pbs.MONTH_ID = pm.PR_MONTH_ID)
where pbs.BILL_CODE in (select EMP_BILL_CODE from PR_BILL_CODE_MAPPING where BILLER_EMP_ID = :empId and  ACTIVATION_FLAG = 'Y')
  and pm.FY_ID = nvl(:year,pm.FY_ID) and lps.STATUS_KEY='BILL_DISBURSED'
order by pm.PR_MONTH_ID" ;
        return DB::select($sql,['year' => $yr, 'empId' => auth()->user()->emp_id]);
    }
}
