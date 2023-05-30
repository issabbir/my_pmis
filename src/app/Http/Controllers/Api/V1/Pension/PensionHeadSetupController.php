<?php


namespace App\Http\Controllers\Api\V1\Pension;

use App\Contracts\Payroll\PayrollContract;
use App\Contracts\Admin\AdminContract;
use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Payroll\PrMonths;
use App\Enums\Payroll\Period\FiscalMonths;
use App\Http\Controllers\Controller;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PensionHeadSetupController extends Controller
{
    private $payrollManager;
    public function __construct(PayrollContract $payrollManager)
    {
        $this->payrollManager = $payrollManager;
    }

    public function getPensionHeads()
    {
        $sql = "select pension.pension_head_list from dual";
        return DB::select($sql);
    }

    public function getBonusHeads(){
        $payrollManager = $this->payrollManager;
        $bonusHeads=DB::table('pension_heads')->where('bonus_yn','Y')->get();
        //dd($payrollManager->findPrFiscalYearsAll());
        $prFiscalYear = new PrMonths();
        return[
            'bonusHeads'=>$bonusHeads,
            'fiscal_months' => FiscalMonths::getFiscalMonths(),
            'fecialYearList' => $payrollManager->findPrFiscalYears(),
        ];

    }

    public function getPensionHeadData(Request $request)
    {
        $sql = "select pension.monthly_pension_head_list(:pr_month_id)  from dual";
        return DB::select($sql,['pr_month_id' => $request->get('pr_month_id')]);
    }

    Public function pensionHeadSetup(Request $request)
    {
        try {

            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_pr_month_id" => $request->get("pr_month_id"),
                "p_pension_head_id" => $request->get("pension_head_id"),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("pension.pension_head_setup", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    Public function deletePensionHead(Request $request)
    {
        try {

            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_pr_month_id" => $request->get("pr_month_id"),
                "p_pension_head_id" => $request->get("pension_head_id"),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("pension.pension_head_setup_del", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }


}
