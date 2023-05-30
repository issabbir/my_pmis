<?php

namespace App\Http\Controllers\Api\V1\Payroll;

use App\Contracts\Admin\AdminContract;
use App\Contracts\Payroll\PayrollContract;
use App\Entities\Payroll\PrSalaryHeads;
use App\Entities\Pmis\Employee\EmpFamily;
use App\Entities\Pmis\Employee\EmpFamilyTemp;
use App\Entities\Payroll\PrMonths;
use App\Entities\Payroll\PrSalarySetup;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;

class SallerySetupController extends Controller
{
    private $payrollManager;

    public function __construct(PayrollContract $payrollManager)
    {
        $this->payrollManager = $payrollManager;
    }

    public function index(Request $request)
    {
        return $this->getData();
    }

    public function yearList(Request $request)
    {
        return $this->yearDetails();
    }

    public function specific(Request $request, $id)
    {
        $salarySetup = new PrSalarySetup();
         return [
            "months"=> $this->months(),
            "salaryHeads" => $this->salaryHeads(),
            "data" => $salarySetup->where('month_id', $id)->get()
        ];
    }

    public function getData() {
         return [
             "years"=> $this->years(),
        ];
    }

    public function noMonthSalaryHead($id){
        $salarySetup = new PrSalarySetup();
         $setups =  $salarySetup->where('pr_month_id',$id)->get();
         $salaryHeads = [];
         foreach ($setups as $setup){
             if($setup->salary_heads['every_month_yn'] == 'Y'){
                    continue;
             }
            $salaryHeads[] = $setup;
         }


        $salaryHead = $this->payrollManager->findPrSalaryHeadsBasic();
        $salaryHeadArr = [];
        foreach ($salaryHead as $head){
            $salaryHeadArr[] = [
                'salaryHead' => [
                    'name' => $head['salary_head'],
                    'value' => $head['salary_head_id'],
                    'deduction_yn' => $head['deduction_yn'],
                ]
            ];
        };

        return [
            'salary_head' =>$salaryHeads,
            "salaryHeads" => $this->salaryHeadsByMonthId($id),
            "salaryHeadBasic" => $salaryHeadArr
        ];
    }

    public function view($id, Request $request)
    {
       $empFamily = new EmpFamilyTemp();
       return $empFamily->find($id);
    }

    public function store(Request $request)
    {
         $salaryHeadBasic = $request->get('salaryHeadBasic');
         $SalaryHeadInputs = [$request->get('SalaryHeadInputs')];
        // dd(count($SalaryHeadInputs));
         if(!empty($SalaryHeadInputs[0]) && count($SalaryHeadInputs) > 0 && $SalaryHeadInputs[0]['salaryHead']['value'] != null){
              $totalHead = array_merge($salaryHeadBasic,$SalaryHeadInputs);
         }else{
              $totalHead = $request->get('salaryHeadBasic');
          }
         $months = $request->get('months');
         $salarySetup = new PrSalarySetup();
        try {
            $o_status_code = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');
            $params = '';
            foreach ($totalHead as $salaryHead){
                 $existSalary = $salarySetup->where('salary_head_id',$salaryHead['salaryHead']['value'])->first();
                 //dd($existSalary);
                if($existSalary && $existSalary['pr_month_id'] == $months){
                            continue;
                    }

            $params = [
                'p_pr_month_id' => [
                    'value' => &$months,
                    "type" => PDO::PARAM_INT,
                    "length" => 255
                ],
                'p_salary_head_id' => [
                    'value' => $salaryHead['salaryHead']['value'],
                    "type" => PDO::PARAM_INT,
                    "length" => 255
                ],
                'p_inserted_by' => Auth::id(),
                'p_updated_by' => Auth::id(),
                'o_status_code' => &$o_status_code,
                'o_status_message' => &$o_status_message,
            ];
             DB::executeProcedure("PAYROLL.PR_MONTHLY_SALARY_SETUP", $params);
            //return $this->employees_create_new_family($request);
             }
            return $params;

         }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'o_status_code' => 0, 'o_status_message' => $e->getMessage()];
        }
       return $this->getData();

    }

    public function update(Request $request)
    {
        //TODO: Default template for action.
    }

    public function remove($id,$month_id, Request $request)
    {
      try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_pr_month_id" => $month_id,
                "p_salary_head_id" => $id,
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PAYROLL.delete_salary_setup", $params);
        }
        catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }


     /**
     * @return array
     */
    private function salaryHeads() {
        $salaryHeads = [];
        $salaryHeadsList = new PrSalaryHeads();
        $existHeads = DB::table('pr_salary_setup')->select('salary_head_id')->get();
        $data = [];
        foreach ($existHeads as $head) {
            if ($head->salary_head_id)
            $data[] = $head->salary_head_id;
        }
         $othersHeads = $salaryHeadsList->where('every_month_yn','N')->where('active_yn','Y')->whereNotIn('salary_head_id', $data)->orderBy("salary_head", 'asc')->get();
         foreach ($othersHeads as $item) {
            $salaryHeads[] = ["name" => $item->salary_head, 'value' => $item->salary_head_id];
        }
         return $salaryHeads;
    }

    private function salaryHeadsByMonthId($id) {
        $salaryHeads = [];
        $salaryHeadsList = new PrSalaryHeads();
        $existHeads = DB::table('pr_salary_setup')->where('pr_month_id', $id)->select('salary_head_id')->get();
        $data = [];
        foreach ($existHeads as $head) {
            if ($head->salary_head_id)
                $data[] = $head->salary_head_id;
        }
        $othersHeads = $salaryHeadsList->where('every_month_yn','N')->where('active_yn','Y')->whereNotIn('salary_head_id', $data)->orderBy("salary_head", 'asc')->get();
        foreach ($othersHeads as $item) {
            $salaryHeads[] = ["name" => $item->salary_head, 'value' => $item->salary_head_id];
        }
        return $salaryHeads;
    }
    /**
     * @return array
     */
    private function years() {
        $salaryHeads = [];
        $salaryHeads[] = [ "id"=>null, 'text' => 'Select Year', "value" => null, 'current_yn' => ''];
          foreach ($this->payrollManager->findPrYears() as $item) {
            $salaryHeads[] = [
                "id" => $item->fy_id,
                "text" => $item->pr_year,
                'value' => $item->pr_year,
                'current_yn' => $item->current_yn
            ];
        }
         return $salaryHeads;
    }

    private function yearDetails() {
        $salaryHeads = [];
        $salaryHeads[] = [ "id"=>null, 'text' => 'Select Year', "value" => null, 'current_yn' => ''];
        foreach ($this->payrollManager->findFinYears() as $item) {
            $salaryHeads[] = [
                "id" => $item->fy_id,
                "text" => $item->fy_name,
                'value' => $item->fy_id,
                'current_yn' => $item->current_yn
            ];
        }
        return $salaryHeads;
    }


    private function finYear(){
        $finYear=[];
        $finYear[]=["value"=>null,"text"=>'Select Year'];
        foreach ($this->payrollManager->findFinYears() as $item){
            $finYear[]=["text"=>$item->fy_name,'value'=>$item->fy_id];
        }
        return $finYear;
    }
    /**
     * @return array
     */
    public function months($year, Request $request) {
        $salaryHeads = [];
        if($year){
            $salaryYear = $this->payrollManager->findPrMonthsByYear($year, ($request->get('p')=='b')?'Y':'N');

           // print_r($salaryYear); die();
            $salaryHeads[] = ["value" => null, 'text' => 'Select Month'];
            $months = ['','July','August','September','October','November','December','January','February','March','April','May','June'];
             foreach ($salaryYear as $key=>$items) {
                $salaryHeads[] = ["text" => $months[$items->pr_month], 'value' => $items->pr_month_id];
            }
       }
         return $salaryHeads;
    }
    public function monthsByYearId($year) {
        $salaryHeads = [];
        if($year){
            $salaryYear = $this->payrollManager->findPrMonthsByCurrentYearId($year);
            // print_r($salaryYear); die();
            $salaryHeads[] = ["value" => null, 'text' => 'Select Month'];
            $months = ['','July','August','September','October','November','December','January','February','March','April','May','June'];
            foreach ($salaryYear as $key=>$items) {
                $salaryHeads[] = ["text" => $months[$items->pr_month], 'value' => $items->pr_month_id];
            }
        }
        return $salaryHeads;
    }

    public function getBillCodes($yid, $mid) {
        //echo auth()->user()->emp_id;
        $sql  = "select distinct pbs.BILL_CODE
from PR_BILL_STATES pbs
where pbs.BILL_CODE in (select EMP_BILL_CODE from PR_BILL_CODE_MAPPING where BILLER_EMP_ID = :empId and  ACTIVATION_FLAG = 'Y')
  and  pbs.month_id=:mid
order by pbs.bill_code" ;
        $billCodes = DB::select($sql,['mid' => $mid, 'empId' => auth()->user()->emp_id]);
        $arr = [];
        foreach ( $billCodes as $item) {
            $arr[] = $item->bill_code;
        }

        return $arr;
    }


    public function getBonusBillCodes($yid, $mid) {
        //echo auth()->user()->emp_id;
        $sql  = "SELECT DISTINCT pbs.BILL_CODE
    FROM PR_BONUS_STATES pbs
   WHERE     pbs.BILL_CODE IN
                (SELECT EMP_BILL_CODE
                   FROM PR_BILL_CODE_MAPPING
                  WHERE BILLER_EMP_ID = :empId AND ACTIVATION_FLAG = 'Y')
         AND pbs.month_id = :mid
ORDER BY pbs.bill_code" ;
        $billCodes = DB::select($sql,['mid' => $mid, 'empId' => auth()->user()->emp_id]);
        $arr = [];
        foreach ( $billCodes as $item) {
            $arr[] = $item->bill_code;
        }

        return $arr;
    }

    public function getDepuBonusBillCodes($yid, $mid) {
        //echo auth()->user()->emp_id;
        $sql  = "select distinct pbs.BILL_CODE
from PR_DEPU_BILL_STATES pbs
where pbs.BILL_CODE in (select EMP_BILL_CODE from PR_BILL_CODE_MAPPING where BILLER_EMP_ID = :empId)
  and  pbs.month_id=:mid
  and pbs.is_bonus_yn='Y'
  and pbs.salary_head_id is not null
order by pbs.bill_code" ;
        $billCodes = DB::select($sql,['mid' => $mid, 'empId' => auth()->user()->emp_id]);
        $arr = [];
        foreach ( $billCodes as $item) {
            $arr[] = $item->bill_code;
        }

        return $arr;
    }

    /**
     * @return array
     */
    public function getMonthsById($id) {
        $sql  = "select distinct pm.PR_MONTH_ID as value, to_char(pm.CALCULATION_START_DATE, 'fmMonth') as text
from PR_BILL_STATES pbs
         inner join L_PR_BILL_STATUS lps on (lps.PR_BILL_STATUS_ID = pbs.PR_BILL_STATUS_ID)
         inner join PR_MONTHS pm on (pbs.MONTH_ID = pm.PR_MONTH_ID)
where pbs.BILL_CODE in (select EMP_BILL_CODE from PR_BILL_CODE_MAPPING where BILLER_EMP_ID = :empId)
  and pm.FY_ID = :year
order by pm.PR_MONTH_ID" ;

        return DB::select($sql,['year' => $id, 'empId' => auth()->user()->emp_id]);
    }

    public function getBonusMonthsById($id) {
        $sql  = "select distinct pm.PR_MONTH_ID as value, to_char(pm.CALCULATION_START_DATE, 'fmMonth') as text
from PR_BONUS_STATES pbs
         inner join L_PR_BILL_STATUS lps on (lps.PR_BILL_STATUS_ID = pbs.PR_BILL_STATUS_ID)
         inner join PR_MONTHS pm on (pbs.MONTH_ID = pm.PR_MONTH_ID)
where pbs.BILL_CODE in (select EMP_BILL_CODE from PR_BILL_CODE_MAPPING where BILLER_EMP_ID = :empId)
  and pm.FY_ID = :year
order by pm.PR_MONTH_ID" ;

        return DB::select($sql,['year' => $id, 'empId' => auth()->user()->emp_id]);
    }

    //getting bonus month for deputation employee
    public function getDepuBonusMonthsById($id) {
        $sql  = "select distinct pm.PR_MONTH_ID as value, to_char(pm.CALCULATION_START_DATE, 'fmMonth') as text
from PR_DEPU_BILL_STATES pbs
         inner join L_PR_BILL_STATUS lps on (lps.PR_BILL_STATUS_ID = pbs.PR_BILL_STATUS_ID)
         inner join PR_MONTHS pm on (pbs.MONTH_ID = pm.PR_MONTH_ID)
where pbs.BILL_CODE in (select EMP_BILL_CODE from PR_BILL_CODE_MAPPING where BILLER_EMP_ID = :empId)
  and pm.FY_ID = :year
  and pbs.is_bonus_yn='Y'
  and pbs.salary_head_id is not null
order by pm.PR_MONTH_ID" ;
        return DB::select($sql,['year' => $id, 'empId' => auth()->user()->emp_id]);
    }
}
