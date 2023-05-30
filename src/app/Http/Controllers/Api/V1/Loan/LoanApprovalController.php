<?php


namespace App\Http\Controllers\Api\V1\Loan;

use App\Entities\Admin\LDptSection;
use App\Entities\Loan\LoanApplication;
use App\Entities\Loan\LoanDocuments;
use App\Entities\Loan\LoanGuarantorInfo;
use App\Entities\Loan\LoanType;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoanApprovalController extends Controller
{
    public function index(Request $request,LoanType $loanType)
    {

        $emp_id = Auth::user()->employee->emp_id;

        $sql = "  SELECT lookup_code AS pass_value, NVL (meaning_bn, meaning) AS show_value
    FROM l_lookups
   WHERE     lookup_type = 'LOAN_APPROVE_FOR'
         AND active_yn = 'Y'
ORDER BY short_by";


        $loan_application_type = DB::select($sql);
//        $loan_application_type = DB::select($sql,[
//            'p_emp_department_id' => $department_id,
//            'p_emp_section_id' => $section_id,
//            'p_emp_id' => $emp_id,
//        ]);

        return [
            'loan_application_type' => $loan_application_type,
            'loanTypes' => $this->getLoanTypes($loanType),
        ];
    }
    private function getLoanTypes(LoanType $loanType) {
        return $loanType->get();
    }

    public function applicationChangeData($id)
    {
        if ($id == 'LA'){
            $data = $this->getApplicationLoans();
        }
        if ($id == 'LG'){
            $data = $this->getApplicationGuarantor();
        }
        if ($id == 'LD'){
            $data = $this->getDisbursementApprovals();
        }if ($id == 'PI'){
            $data = $this->getPayInstructionApprovals();
        }if ($id == 'LP'){
            $data = $this->getPaymentApprovals();
        }
        return $data;
    }

    private function getApplicationLoans()
    {
        $sql = "select loan.loan_approve_application_data(:param) from dual";
        return DB::select($sql, ['param' => auth()->id()]);
    }
  private function getApplicationGuarantor()
    {
        $sql = "select loan.loan_approve_guarantor_data(:param) from dual";

        return DB::select($sql, ['param' => auth()->id()]);
    }

    private function getDisbursementApprovals()
    {

        $sql = "select loan.loan_approve_disbursed_data(:param) from dual";
        return DB::select($sql, ['param' => auth()->id()]);
    }

    private function getPaymentApprovals()
    {

        $sql = "select loan.loan_approve_payment_data(:param) from dual";
        return DB::select($sql, ['param' => auth()->id()]);
     }

    private function getPayInstructionApprovals()
    {
        $sql = "select loan.loan_approve_payinstrac_data(:param) from dual";
        return DB::select($sql, ['param' => auth()->id()]);
     }

    public function store(Request $request)
    {
        try {
            $approval_id = $request->get("approval_id") ? $request->get("approval_id") : null;
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_approval_id" => $approval_id,
                "p_approval_for" => $request->get("application_page_id"),
                "p_emp_id" => $request->get("emp_id"),
                "p_loan_no" => $request->get("loan_no"),
                "p_loan_type_id" => (int)$request->get("loan_type_id"),
                "p_approval_status" => $request->get("approval_status"),
                "p_approval_comment" => $request->get("comment_status"),
                "p_reference_id" => $request->get("reference_id"),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("loan.loan_approval_process", $params);
            //dd($params);
        } catch (\Exception $e) {
            return ["exception" => true, 'o_status_code' => 99, "status" => false, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function sectionByDepartment($id)
    {
        return LDptSection::where('department_id', $id)->get();
    }

    public function departmentByEmployee($section_id, $searchParam)
    {
        $sql = "select loan.emp_search(:param,:id) from dual";
        return DB::select($sql, ['param' => $searchParam, 'id' => $section_id]);
    }

}
