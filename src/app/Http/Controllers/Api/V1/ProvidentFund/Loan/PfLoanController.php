<?php


namespace App\Http\Controllers\Api\V1\ProvidentFund\Loan;

use App\Entities\Loan\LoanApplication;
use App\Entities\Loan\LoanType;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Security\User;
use App\Http\Controllers\Controller;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PfLoanController extends Controller
{
    public function post(Request $request) {
        return $this->PFPROCESS_LOAN_APPLICATION_ENTRY($request);
    }

    public function get(Request $request, LoanApplication $loanApplication, LoanType $loanType) {
        return $this->formData($request, $loanApplication, $loanType);
    }

    public function getSelf(Request $request, LoanApplication $loanApplication, LoanType $loanType) {
        return $this->formDataSelf($request, $loanApplication, $loanType);
    }

    public function put($id,Request $request) {
        return $this->PFPROCESS_LOAN_APPLICATION_ENTRY($request, $id);
    }

    public function PFPROCESS_LOAN_APPLICATION_ENTRY(Request $request, $id=null)
    {
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_application_id" => $request->get("application_id"),
                "p_emp_id" => $request->get("emp_id"),
                "p_cgpf_no" => $request->get("gpf_id"),
                "p_loan_type_id" => $request->get("loan_type_id"),
                "p_application_amt" => $request->get("application_amt"),
                "p_description" => $request->get("description"),
                "p_reason" => $request->get("reason"),
                "p_rate_of_interest" => $request->get("rate_of_interest"),
                "p_installment_no" => $request->get("installment_no"),
                "p_comment_status_1" => $request->get("comment_status_1"),
                "p_approval_status_1" => $request->get("approval_status_1"),
                "p_comment_status_2" => $request->get("comment_status_2"),
                "p_approval_status_2" => $request->get("approval_status_2"),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PFPROCESS.LOAN_APPLICATION_ENTRY", $params);
            if($params['o_status_code'] == 1) {
                $reporting_officer_id = Employee::where('emp_id', $request->get("emp_id"))->value('reporting_officer_id');
                $emp_name = Employee::where('emp_id', $request->get("emp_id"))->value('emp_name');
                if($reporting_officer_id != null ){
                    $controller_user_id = User::where('emp_id', $reporting_officer_id)->value('user_id');
                    $controller_user_notification = [
                        "p_notification_to" => $controller_user_id,
                        "p_insert_by" => Auth::id(),
                        "p_note" => 'GPF loan application submitted by '.$emp_name.'',
                        "p_priority" => null,
                        "p_module_id" => 4,
                        "p_target_url" => "pmis/provident-fund#/pf-loan-application"
                    ];
                    DB::executeProcedure("cpa_security.cpa_general.notify_add", $controller_user_notification);
                }
            }


        }
        catch (\Exception $e) {
            return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }


    private function getLoanTypes(LoanType $loanType) {
        return $loanType->get();
    }

    private function getApplicationLoans(Request $request, LoanApplication $loanApplication) {
        $loanType=$request->get("loanType");
        if(Auth::user()->hasPermission('CAN_APPLY_GPF_LOAN_APPLICATION_FOR_ALL')){
            return DB::select('select PFPROCESS.EMP_GPF_LOAN_DATA_ALL(:loanType,:auth) from dual',
                ['loanType' => $loanType,'auth'=>auth()->id()]);
        }else{
            return DB::select('select PFPROCESS.EMP_GPF_LOAN_DATA(:loanType,:auth) from dual',
                ['loanType' => $loanType,'auth'=>auth()->id()]);
        }

    }

    private function getApplicationLoansSelf(Request $request, LoanApplication $loanApplication) {
        $loanType=$request->get("loanType");
        return DB::select('select PFPROCESS.EMP_GPF_LOAN_DATA_SELF(:loanType,:auth) from dual',
            ['loanType' => $loanType,'auth'=>Auth::user()->emp_id]);
    }

    private function formData(Request $request, LoanApplication $loanApplication, LoanType $loanType) {
        return [
            'loanTypes' => $this->getLoanTypes($loanType),
            'pfLoans' => $this->getApplicationLoans($request, $loanApplication)
        ];
    }

    private function formDataSelf(Request $request, LoanApplication $loanApplication, LoanType $loanType) {
        return [
            'loanTypes' => $this->getLoanTypes($loanType),
            'pfLoans' => $this->getApplicationLoansSelf($request, $loanApplication)
        ];
    }


}
