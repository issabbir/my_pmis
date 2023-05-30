<?php


namespace App\Http\Controllers\Api\V1\Payroll;

use App\Entities\Admin\WorkFlowStep;
use App\Entities\Payroll\BillDetailsInfo;
use App\Entities\Payroll\BillMasterInfo;
use App\Entities\Payroll\PrBillCodeMapping;
use App\Entities\Payroll\PrFiscalYear;
use App\Entities\Payroll\PrMonths;
use App\Entities\Payroll\PrSalaryHeads;
use App\Entities\Payroll\PrSalaryProcess;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmployeeDepu;
use App\Enums\Payroll\Period\FiscalMonths;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ArrearBillSettlementController extends Controller
{
    protected $employee;
    protected $auth;

    public function __construct(Employee $employee, Guard $auth)
    {
        $this->employee = $employee;
        $this->auth = $auth;
    }

    public function getFiscalYears(){
        $pr_month_ids = BillMasterInfo::select('pr_month_id')->where('manual_bill_yn', 'N')->pluck('pr_month_id');
        /*PrMonths::whereIn('pr_month_id',$pr_month_ids)->get();*/
        $fy_ids = PrMonths::select('fy_id')->whereIn('pr_month_id',$pr_month_ids)->pluck('fy_id');
        return PrFiscalYear::whereIn('fy_id', $fy_ids)->get();
    }

    public function getActiveFiscalYears(){
        $pr_month_ids = BillMasterInfo::select('pr_month_id')->where('manual_bill_yn', 'N')->pluck('pr_month_id');
        /*PrMonths::whereIn('pr_month_id',$pr_month_ids)->get();*/
        $fy_ids = PrMonths::select('fy_id')->whereIn('pr_month_id',$pr_month_ids)->pluck('fy_id');
        return PrFiscalYear::where('current_yn', '=', 'Y')->whereIn('fy_id', $fy_ids)->get();
    }

    public function getPrMonths($fy_id){
        $pr_month_ids = BillMasterInfo::select('pr_month_id')->where('manual_bill_yn', 'N')->pluck('pr_month_id');
        return PrMonths::whereIn('pr_month_id',$pr_month_ids)->where('fy_id', $fy_id)->get();
    }

    public function getActivePrMonths($fy_id){
        $pr_month_ids = BillMasterInfo::select('pr_month_id')->where('manual_bill_yn', 'N')->pluck('pr_month_id');
        return PrMonths::where('current_yn', '=', 'Y')->where('open_yn', '=', 'O')->whereIn('pr_month_id',$pr_month_ids)->where('fy_id', $fy_id)->get();
    }

    public function activePrMonths($fy_id){
        $pr_month_ids = BillMasterInfo::select('pr_month_id')->where('manual_bill_yn', 'N')->pluck('pr_month_id');
        return PrMonths::where('open_yn', '=', 'O')->whereIn('pr_month_id',$pr_month_ids)->where('fy_id', $fy_id)->get();
    }

    public function getBillCodes($pr_month_id){
        return BillMasterInfo::where('pr_month_id', $pr_month_id)->groupBy('bill_code')->pluck('bill_code');
    }

    public function arrearDetailsList(Request $request){

        $emp_bill_codes = PrBillCodeMapping::select('emp_bill_code')->where('biller_emp_id', auth()->user()->emp_id)->pluck('emp_bill_code');


        $arr = array_filter(auth()->user()->roles->all(), function($obj){
           if (isset($obj)) {
               if($obj->role_key == 'BILL_CLARK')
                return true;
            }
            return false;
        });

        $emp_id = $request->get('emp_id');
        $bill_code = $request->get('bill_code');
        if($emp_id == '' && $bill_code == ''){
            $condition = ['pr_month_id' => $request->get('pr_month'), 'manual_bill_yn' => 'N'];
        } else if($emp_id != '' && $bill_code == ''){
            $condition = ['pr_month_id' => $request->get('pr_month'), 'manual_bill_yn' => 'N', 'emp_id' => $emp_id];
        } else if($emp_id == '' && $bill_code != ''){
            $condition = ['pr_month_id' => $request->get('pr_month'), 'manual_bill_yn' => 'N', 'bill_code' => $bill_code];
        } else {
            $condition = ['pr_month_id' => $request->get('pr_month'), 'manual_bill_yn' => 'N', 'bill_code' => $bill_code, 'emp_id'=>$emp_id];
        }

        if($arr){
            return BillMasterInfo::where($condition)->whereIn('bill_code', $emp_bill_codes)->orderBy('update_date', 'desc')->get();
            /*return BillMasterInfo::where($condition)->orderBy('update_date', 'desc')->get();*/
        } else {
            return BillMasterInfo::where($condition)->where('go_no','!=', null)->whereIn('bill_code', $emp_bill_codes)->orderBy('update_date', 'desc')->get();
            /*return BillMasterInfo::where($condition)->where('go_no','!=', null)->orderBy('update_date', 'desc')->get();*/
        }

    }

    public function getWorkFlowSteps($id){
        return WorkFlowStep::where('approval_workflow_id', $id)->get();
    }

    public function addBillDetails(Request $request)
    {
        $status_code = sprintf("%4000s","");
        $status_message = sprintf("%4000s","");
        try {
            $bill_details_id = $request->get('bill_details_id');
            $params = [
                "bill_details_id" => [
                    "value" => &$bill_details_id,
                    "type" => \PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                "bill_master_id" => $request->get('bill_master_id'),
                "bill_head_id" => $request->get('bill_head_id'),
                "line_status_yn" => $request->get('line_status_yn'),
                "line_description" => $request->get('line_description'),
                "coa_code" => $request->get('coa_code'),
                "amount" => $request->get('amount'),
                "deduction_yn" => $request->get('deduction_yn'),
                "active_yn" => $request->get('active_yn'),
                "remarks" => $request->get('remarks'),
                "addition_yn" => 'Y',
                "insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message
            ];
            DB::executeProcedure("arrearbill.bill_details_info_entry", $params);
        }
        catch (\Exception $e){
            return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $e->getMessage()];
        }

        $bill_details = BillDetailsInfo::where('bill_details_id', $params["bill_details_id"]["value"])->get();
        return $params;
    }

    public function updateBillDetails(Request $request){

        $details = $request->get('details');
        try {
            foreach ($details as $detail){
                $status_code = sprintf("%4000s","");
                $status_message = sprintf("%4000s","");

                $params = [
                    "bill_details_id" => $detail['bill_details_id'],
                    "go_no" => $request->get('go_no'),
                    "go_date" => $request->get('go_date') == null?"":date("Y-m-d", strtotime($request->get('go_date'))),
                    "pay_advice_no" => $request->get('pay_advice_no'),
                    "pay_advice_date" => $request->get('pay_advice_date') == null?"":date("Y-m-d", strtotime($request->get('pay_advice_date'))),
                    "amount" => $detail['amount_amendment'],
                    "remarks" => $request->get('remarks'),
                    "insert_by" => auth()->id(),
                    "o_status_code" => &$status_code,
                    "o_status_message" => &$status_message
                ];

                DB::executeProcedure("arrearbill.bill_details_update", $params);
            }

        }
        catch (\Exception $e){
            return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $e->getMessage()];
        }
        return $params;
    }

    public function deleteBillDetails($id) {
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "bill_details_id" => $id,
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("arrearbill.bill_details_delete", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }
}
