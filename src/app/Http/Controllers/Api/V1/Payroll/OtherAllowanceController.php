<?php


namespace App\Http\Controllers\Api\V1\Payroll;


use App\Entities\Admin\WorkFlowProcess;
use App\Entities\Admin\WorkFlowStep;
use App\Entities\Payroll\BillMasterInfo;
use App\Entities\Payroll\PrBillCodeMapping;
use App\Entities\Payroll\PrEmpOtherAllowance;
use App\Entities\Payroll\PrEmpOtherAllowanceDetails;
use App\Entities\Payroll\PrOtherHeadType;
use App\Entities\Pmis\Employee\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OtherAllowanceController extends Controller
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


    public function otherAllowanceTypeList(Request $request){
        return PrOtherHeadType::where('active_yn','Y')->get();
    }
    public function allowanceList(Request $request){
        return PrEmpOtherAllowance::with('headType','other_allowance_details','department','pr_month')->where('insert_by',Auth::id())->get();
    }

    public function hold(Request $request){
        try {
            $postData = $request->all();

            $emp_other_allwoance_id = $postData["emp_other_allwoance_id"] ? $postData["emp_other_allwoance_id"] : '';
           // dd($emp_other_allwoance_id);
            PrEmpOtherAllowance::where('emp_other_allwoance_id',$emp_other_allwoance_id)->update([
                "hold_yn" => $postData["hold_yn"]
            ]);
            return ['o_status_code' => 1,  "status" => false, "o_status_message" => 'Successfully Updated'];
        } catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
    }
    public function approve(Request $request){
        try {
            $postData = $request->all();
            $emp_other_allwoance_id = $postData["emp_other_allwoance_id"] ? $postData["emp_other_allwoance_id"] : '';
            PrEmpOtherAllowance::where('emp_other_allwoance_id',$emp_other_allwoance_id)->update([
                "approve_yn" => 'Y',
                "approve_by" => auth()->id(),
                "approve_date" => date('Y-m-d H:i:s')
            ]);
            return ['o_status_code' => 1,  "status" => false, "o_status_message" => 'Successfully Updated'];
        } catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
    }
    public function disburse(Request $request){
        try {
            $postData = $request->all();
            $o_status_codeApprove = sprintf('%4000s', '');
            $o_status_messageApprove = sprintf('%4000s', '');
            $emp_other_allwoance_id = $postData["emp_other_allwoance_id"] ? $postData["emp_other_allwoance_id"] : '';
            $params = [
                "p_emp_other_allwoance_id" => [
                    "value" => &$emp_other_allwoance_id,
                    "type" => \PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                "p_emp_id" => $postData["emp_id"],
                "p_emp_code" => $postData["emp_code"],
                "p_department_id" => $postData["department_id"],
                "p_other_head_type_id" => $postData["other_head_type_id"],
                "p_pr_month_id" => $postData["pr_month_id"],
                "p_amount" => $postData["amount"],
                "p_hold_yn" => '',
                "p_insert_by" => '',
                "p_approve_yn" => 'Y',
                "p_approve_by" => auth()->id(),
                "p_approve_date" => date('Y-m-d H:i:s'),
                "o_status_code" => &$o_status_codeApprove,
                "o_status_message" => &$o_status_messageApprove
            ];
            DB::executeProcedure("payroll.emp_other_allowance_entry", $params);
            return $params;
        } catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
    }



    public function storeOld(Request $request){
        $postData = $request->all();
        $status_code = sprintf("%4000s","");
        $status_message = sprintf("%4000s","");
        try {
            $emp_other_allwoance_id = $postData["emp_other_allwoance_id"] ? $postData["emp_other_allwoance_id"] : '';
            $params = [
                "p_emp_other_allwoance_id" => [
                    "value" => &$emp_other_allwoance_id,
                    "type" => \PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                "p_emp_id" => $postData["emp_id"],
                "p_emp_code" => $postData["emp_code"],
                "p_department_id" => $postData["department_id"],
                "p_other_head_type_id" => $postData["other_head_type_id"],
                "p_pr_month_id" => $postData["pr_month_id"],
                "p_amount" => $postData["amount"],
                "p_hold_yn" => $postData["hold_yn"],
                "p_insert_by" => auth()->id(),
                "p_approve_yn" => 'N',
                "p_approve_by" => '',
                "p_approve_date" => '',
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message
            ];
            DB::executeProcedure("payroll.emp_other_allowance_entry", $params);

          //  dd($params);
            return $params;
        }
        catch (\Exception $e){
            return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $e->getMessage()];
        }
    }

    public function store(Request $request){
        $postData = $request->all();

       // dd($postData);

        DB::beginTransaction();
        try {
            $otherAllowance = new PrEmpOtherAllowance();
            if ($request->emp_other_allwoance_id){
                $otherAllowance->exists =true;
                $otherAllowance->emp_other_allwoance_id = $request->emp_other_allwoance_id;
            }
           $otherAllowance->department_id = $postData["department_id"];
           $otherAllowance->other_head_type_id = $postData["other_head_type_id"];
           $otherAllowance->pr_month_id = $postData["pr_month_id"];
           $otherAllowance->amount = $postData["amount"];
           $otherAllowance->hold_yn = $postData["hold_yn"];
           $otherAllowance->insert_by = Auth::id();
           $otherAllowance->tax_amount = $postData["tax_amount"];
           $otherAllowance->trans_date = date('Y-m-d',strtotime($postData["trans_date"]));
           $otherAllowance->trans_purpose = $postData["trans_purpose"];
           $otherAllowance->po_date = date('Y-m-d',strtotime($postData["po_date"]));
           $otherAllowance->po_no =  $postData["po_no"];
           $otherAllowance->no_of_emp = $postData["no_of_emp"];
           $otherAllowance->remarks = $postData["remarks"];
           $allowanceData = $otherAllowance->save();

           if ($allowanceData){
               $detailsData = 0;
               if (isset($postData["other_allowance_details"])){
//                   if (!$request->emp_other_allwoance_id) {
//                       $arrayAmount = array_filter($postData["other_allowance_details"]["amount"]);
//                       $arrayTax = array_filter($postData["other_allowance_details"]["tax_amount"]);
//                       $arrayEmployee = array_filter($postData["other_allowance_details"]['employee']);
//                       foreach ($arrayEmployee as $key => $employee) {
//                           // dd($detail);
//                           $otherAllowanceDetails = new PrEmpOtherAllowanceDetails();
//                           $otherAllowanceDetails->other_allowance_id = $otherAllowance->emp_other_allwoance_id;
//                           $otherAllowanceDetails->emp_id = isset($employee['emp_id']) ? $employee['emp_id'] : '';
//                           $otherAllowanceDetails->emp_code = isset($employee["emp_code"]) ? $employee['emp_code'] : '';
//                           $otherAllowanceDetails->amount = $arrayAmount[$key];
//                           $otherAllowanceDetails->tax = $arrayTax[$key];
//                           $otherAllowanceDetails->created_by = Auth::id();
//                           $detailsData = $otherAllowanceDetails->save();
//                           //Log::info($otherAllowanceDetails);
//                           // dd($otherAllowanceDetails);
//                       }
//                       if ($detailsData){
//                           DB::commit();
//                           return ['o_status_code' => 1,  "status" => false, "o_status_message" => 'Successfully Inserted'];
//                       }
//                   }else{

                   if ($request->emp_other_allwoance_id) {
                       $other_allowance_details = PrEmpOtherAllowanceDetails::where('other_allowance_id', $request->emp_other_allwoance_id)->get();
                       foreach ($other_allowance_details as $detail){
                           $detail->delete();
                       }
                   }

                       foreach ($postData["other_allowance_details"] as $key => $detail) {
                           //dd($detail['employee']['emp_id']);
                           $otherAllowanceDetails = new PrEmpOtherAllowanceDetails();
                           if ($request->emp_other_allwoance_id){
//                               $otherAllowance->exists =true;
//                               $otherAllowance->other_allowance_dtl_id = $detail->other_allowance_dtl_id;
                               $message = 'Successfully Updated';
                           }else{
                               $message = 'Successfully Inserted';
                           }
                           $otherAllowanceDetails->other_allowance_id = $otherAllowance->emp_other_allwoance_id;
                           $otherAllowanceDetails->emp_id = isset($detail['employee']['emp_id']) ? $detail['employee']['emp_id'] : '';
                           $otherAllowanceDetails->emp_code = isset($detail['employee']["emp_code"]) ? $detail['employee']['emp_code'] : '';
                           $otherAllowanceDetails->amount = $detail['amount'];
                           $otherAllowanceDetails->tax = $detail['tax'];
                           $otherAllowanceDetails->created_by = Auth::id();
                           $detailsData = $otherAllowanceDetails->save();

                       }
                       if ($detailsData){
                           DB::commit();
                           return ['o_status_code' => 1,  "status" => false, "o_status_message" => $message];
                       }
                   }

              // }

           }
            DB::rollBack();
            return [ 'o_status_code' => 99,  "status" => false, "o_status_message" => 'Not Successfully Inserted'];
        }
        catch (\Exception $e){
            DB::rollBack();
            return ["exception" => false, 'o_status_code' => 99,  "status" => false, "o_status_message" => $e->getMessage()];
        }
    }
}
