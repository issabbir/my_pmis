<?php

namespace App\Http\Controllers\Api\V1\Payroll;

use Illuminate\Support\Facades\DB;
use App\Contracts\Payroll\PayrollContract;
use App\Entities\Payroll\PrFiscalYear;
use App\Entities\Payroll\PrMonths;
use App\Enums\Payroll\Period\FiscalMonths;
use App\Http\Controllers\Controller;
use App\Managers\Payroll\PayrollManager;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    /** @var PayrollContract|PayrollManager */
    private $payrollManager;

    public function __construct(PayrollContract $payrollManager)
    {
        $this->payrollManager = $payrollManager;
    }

    public function index(Request $request)
    {
        return $this->getData();
    }

    public function searchFiscalYear(Request $request, $fiscalYear)
    {
        if($fiscalYear) {
            $prMonths = new PrMonths();
            $prMonths = $prMonths->where('fy_id', $fiscalYear)->orderBy('pr_month')->get();
            $prMonthsProcessedData = [];
            $index = 0;

            foreach($prMonths as $prMonth) {
                $prMonthsProcessedData[$index]['pr_month_id'] = $prMonth->pr_month_id;
                $prMonthsProcessedData[$index]['fy_id'] = $prMonth->fy_id;
                $prMonthsProcessedData[$index]['pr_year'] = $prMonth->pr_year;
                $prMonthsProcessedData[$index]['pr_month'] = FiscalMonths::getFicalMonthNameById($prMonth->pr_month);
                $prMonthsProcessedData[$index]['calculation_start_date'] = $prMonth->calculation_start_date;
                $prMonthsProcessedData[$index]['calculation_end_date'] = $prMonth->calculation_end_date;
                $prMonthsProcessedData[$index]['current_yn'] = FiscalMonths::getCurrentMonthStatusById($prMonth->current_yn);
                $prMonthsProcessedData[$index]['open_yn'] = FiscalMonths::getStatusById($prMonth->open_yn);
                $prMonthsProcessedData[$index]['permited_emp_id'] = $prMonth->permited_emp_id;
                $prMonthsProcessedData[$index]['permited_date'] = $prMonth->permited_date;
                $prMonthsProcessedData[$index]['bonus_applicable_yn'] = $prMonth->bonus_applicable_yn;
                $prMonthsProcessedData[$index]['insert_by'] = $prMonth->insert_by;
                $prMonthsProcessedData[$index]['insert_date'] = $prMonth->insert_date;
                $prMonthsProcessedData[$index]['update_date'] = $prMonth->update_date;
                $prMonthsProcessedData[$index]['update_by'] = $prMonth->update_by;
                $index++;
            }

            return [
                'fiscal_months' => FiscalMonths::getFiscalMonths(),
                'pr_months' => $prMonthsProcessedData
            ];
        }

        return [];
    }

    public function specific(Request $request, $id)
    {
        //TODO: Default template for action.
    }

    public function getData()
    {
        $payrollManager = $this->payrollManager;
        return [
            'fecialYearList'=>$payrollManager->findPrFiscalYearsAll(),
        ];
    }

    public function view(Request $request, $id)
    {
        $prFiscalYear = new PrMonths();

        return $prFiscalYear->find($id);
    }

    public function store(Request $request)
    {
        $params = $this->create_pr_months($request);

        return $params;
    }

    public function create_pr_months(Request $request)
    {
        $currentMonth = ($request->get("current_yn") === 'Y') ? 'Y' : 'N';
        try {
            $o_status_code = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');
            $pr_month_id = '';
            $params = [
                'pr_month_id' => [
                    'value' => &$pr_month_id,
                    "type" => \PDO::PARAM_INT
                ],
                'pr_month_id' => $request->get("pr_month_id"),
                'fy_id' => $request->get("fy_id"),
                'pr_year' => $request->get("pr_year"),
                'pr_month' => $request->get('pr_month'),
                'calculation_start_date' => date("Y-m-d", strtotime($request->get("calculation_start_date"))),
                'calculation_end_date' => date("Y-m-d", strtotime($request->get("calculation_end_date"))),
                'current_yn' => $currentMonth,
                'open_yn' => $request->get("open_yn"),
                'permited_emp_id' => '',
                'permited_date' => '',
                'bonus_applicable_yn' => $request->get('bonus_applicable_yn'),
                'insert_by' => auth()->id(),
                'update_by' => auth()->id(),
                'o_status_code' => &$o_status_code,
                'o_status_message' => &$o_status_message,
            ];

            DB::executeProcedure("payroll.pr_period", $params);

            return $params;
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }
}
