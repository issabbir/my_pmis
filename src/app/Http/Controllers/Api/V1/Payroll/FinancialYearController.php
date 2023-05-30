<?php

namespace App\Http\Controllers\Api\V1\Payroll;

use Illuminate\Support\Facades\DB;
use App\Contracts\Payroll\PayrollContract;
use App\Entities\Payroll\PrFiscalYear;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinancialYearController extends Controller
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

    public function getData()
    {
        $payrollManager = $this->payrollManager;
        return [
            'data'=>$payrollManager->findPrFiscalYearsAll(),
        ];
    }

    public function view(Request $request, $id)
    {
        $prFiscalYear=new PrFiscalYear();
        return $prFiscalYear->find($id);
    }

    public function store(Request $request)
    {
        $params = $this->create_financial_year($request);

        return $params;
    }

    public function create_financial_year(Request $request)
    {
//        dd($request->all());
        try {
            $o_status_code = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');
            $fy_id = '';
            $params = [
                'p_FY_ID' => [
                    'value' => &$fy_id,
                    "type" => \PDO::PARAM_INT
                ],
                'p_FY_ID' => $request->get("fy_id"),
                'p_FY_NAME' => $request->get("fy_name"),
                'p_FY_NAME_BNG' => $request->get('fy_name_bng'),
                'p_START_DATE' => date("Y-m-d", strtotime($request->get("start_date"))),
                'p_END_DATE' => date("Y-m-d", strtotime($request->get("end_date"))),
                'p_CURRENT_YN' => $request->get('current_yn'),
                'insert_by' => auth()->id(),
                'o_status_code' => &$o_status_code,
                'o_status_message' => &$o_status_message,
            ];

            DB::executeProcedure("payroll.fiscal_year_entry", $params);

            return $params;
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }
}
