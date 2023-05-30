<?php


namespace App\Http\Controllers\Api\V1\Loan;

use App\Entities\Loan\LoanApplication;
use App\Entities\Loan\LoanDocuments;
use App\Entities\Loan\LoanGuarantorInfo;
use App\Entities\Loan\LoanTransaction;
use App\Entities\Loan\LoanType;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoanPaymentController extends Controller
{
    public function index(Request $request,  LoanApplication $loanApplication, LoanType $loanType)
    {
       return $this->formData($request, $loanApplication, $loanType);
    }
    public function searchEmp($searchParam){
        $sql = "SELECT ev.emp_name AS employee_name,
       ev.designation AS designation,
       ev.department_name AS department,
       ev.dpt_section AS section,
       la.application_id,
       la.sanction_id,
       la.emp_id,
       la.emp_code,
       la.application_date,
       la.loan_no,
       la.loan_type_id,
       la.description,
       la.reason,
       nvl(la.paid_installment_no,0)+1 as paid_installment_no,
       la.rate_of_interest,
       la.application_amt AS loan_amount,
       la.remaining_principal AS remaining_principle_amount,
       la.remaining_interest AS remaining_interest_amount,
       la.installment_no AS number_of_installment
  FROM loan_application la, employee_info_vu ev
 WHERE     la.emp_id = ev.emp_id
       AND UPPER (la.loan_no || ev.emp_name) LIKE
              '%' || UPPER ( :p_loan_no_name) || '%'";
        return DB::select($sql, ['p_loan_no_name' => $searchParam]);
    }
    public function searchLoan($loan_type_id=null,$searchParam=null){
        if ($loan_type_id == 'null')
            $loan_type_id = null;

        if ($searchParam == 'null')
            $searchParam = null;

        $sql = "SELECT ev.emp_name AS employee_name,
       ev.designation AS designation,
       ev.department_name AS department,
       ev.dpt_section AS section,
       la.loan_id AS application_id,
       la.sanction_id,
       la.emp_id,
       la.emp_code,
       la.emp_code || '-' || ev.emp_name
                         AS option_name,
       la.open_date AS application_date,
       la.loan_no,
       la.loan_type_id,
       la.description,
       la.reason,
       NVL (la.paid_installment_no, 0) + 1 AS paid_installment_no,
       la.rate_of_interest,
       la.loan_amount AS loan_amount,
       la.remaining_principal AS remaining_principle_amount,
       la.remaining_interest AS remaining_interest_amount,
       la.installment_no AS number_of_installment
  FROM loans la, employee_info_vu ev
 WHERE     la.emp_id = ev.emp_id
       AND UPPER (la.loan_no || ev.emp_name || la.emp_code) LIKE
              '%' || UPPER ( :p_loan_no_name) || '%'
       AND la.loan_type_id = NVL ( :p_loan_type_id, la.loan_type_id)
       AND la.approval_status = 'Y'
       AND (   NVL (la.remaining_principal, 0) > 0
            OR NVL (la.remaining_interest, 0) > 0)
       AND la.loan_amount >
              (SELECT NVL (SUM (transaction_amt), 0)
                 FROM loan_transactions lt
                WHERE lt.loan_no = la.loan_no AND transactions_type IN (3, 4))
       AND ROWNUM <= 20";

        return DB::select($sql, ['p_loan_no_name' => $searchParam,'p_loan_type_id' => $loan_type_id]);
    }
    public function searchLoanByEmpCode($loan_type_id=null,$searchParam=null){
        if ($loan_type_id == 'null')
            $loan_type_id = null;

        if ($searchParam == 'null')
            $searchParam = null;

        $sql = "SELECT ev.emp_name AS employee_name,
       ev.designation AS designation,
       ev.department_name AS department,
       ev.dpt_section AS section,
       la.loan_id AS application_id,
       la.sanction_id,
       la.emp_id,
       la.emp_code,
       la.open_date AS application_date,
       la.loan_no,
       la.loan_type_id,
       la.description,
       la.reason,
       NVL (la.paid_installment_no, 0) + 1 AS paid_installment_no,
       la.rate_of_interest,
       la.loan_amount AS loan_amount,
       la.remaining_principal AS remaining_principle_amount,
       la.remaining_interest AS remaining_interest_amount,
       la.installment_no AS number_of_installment
  FROM loans la, employee_info_vu ev
 WHERE     la.emp_id = ev.emp_id
       AND UPPER (la.loan_no || ev.emp_name || la.emp_code) LIKE
              '%' || UPPER ( :p_loan_no_name) || '%'
       AND la.loan_type_id = NVL ( :p_loan_type_id, la.loan_type_id)
       AND la.approval_status = 'Y'
       AND (   NVL (la.remaining_principal, 0) > 0
            OR NVL (la.remaining_interest, 0) > 0)
       AND la.loan_amount >
              (SELECT NVL (SUM (transaction_amt), 0)
                 FROM loan_transactions lt
                WHERE lt.loan_no = la.loan_no AND transactions_type IN (3, 4))
       AND ROWNUM <= 20";

        return DB::select($sql, ['p_loan_no_name' => $searchParam,'p_loan_type_id' => $loan_type_id]);
    }
    public function searchLoanDisbursement($loan_type_id = null,$searchParam = null){
        if ($loan_type_id == 'null')
            $loan_type_id = null;

        if ($searchParam == 'null')
            $searchParam = null;

        $sql = "select loan.loan_disbursement_loan_no_list(:p_loan_no_name,:p_loan_type_id) from dual";

        return DB::select($sql, ['p_loan_no_name' => $searchParam,'p_loan_type_id' => $loan_type_id]);
    }
    public function getLoan(Request $request, AdminManager $adminManager)
    {
        $sql = "SELECT ev.emp_name AS employee_name,
       ev.designation AS designation,
       ev.department_name AS department,
       ev.dpt_section AS section,
       la.application_amt AS loan_amount,
       la.remaining_principal AS remaining_principle_amount,
       la.remaining_interest AS remaining_interest_amount,
       la.installment_no AS number_of_installment
  FROM loan_application la, employee_info_vu ev
 WHERE la.emp_id = ev.emp_id AND la.application_id = :p_loan_id";
        $loan = DB::select($sql);
        return [
            'loan' => $loan
        ];
    }
    public function paymentStore(Request $request){
//        dd($request->all());
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_loan_no" => $request->get("loan_no"),
                "p_loan_type_id" => $request->get("loan_type_id"),
                "p_no_of_installment" => (int)$request->get("number_of_installment"),
                "p_transaction_amt" => $request->get("challan_amount"),
                "p_trans_amt_prpal" => $request->get("payment_interest_amount"),
                "p_trans_amt_intr" => $request->get("payment_priciple_interest"),
                "p_description" => $request->get("note"),
                "p_attachment_doc_no" => $request->get("challan_number"),
                "p_doc_date" => $request->get("doc_date")? date("Y-m-d", strtotime($request->get('doc_date'))) : '',
                "p_attachment" => [
                    'value' => $request->get("attachment"),
                    'type' => SQLT_CLOB
                ],
                "p_attachment_file_name" => $request->get("attachment_file_name"),
                "p_bank_deposit_date" => $request->get("bank_deposit_date")? date("Y-m-d", strtotime($request->get('bank_deposit_date'))) : '',
                "p_pr_month_id" => $request->get("prMonths"),
                "p_challan_yn" => 'Y',
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("loan.loan_payment", $params);

        }
        catch (\Exception $e) {
            return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }
    private function getLoanTypes(LoanType $loanType) {
        return $loanType->get();
    }

    private function getPayments(Request $request, LoanApplication $loanApplication) {
        $loan_transactions = new LoanTransaction();
        if ($request->get('filter') != 'null') {
            $loan_transactions = $loan_transactions
                ->where('transactions_no', 'like', "%".$request->get('filter')."%")
                ->orWhereHas('transaction_type', function($q) use ($request) {
                    if ($request->get('filter')) {
                        $q->where('meaning', 'like', "%".$request->get('filter')."%");
                    }
                });;
        }
       $loan_transactions = $loan_transactions->select(DB::raw('(SUM (transaction_amt)
                          OVER (PARTITION BY transactions_type
                                ORDER BY transaction_amt))  AS due_amount'),DB::raw(' (SUM (installment_no)
                          OVER (PARTITION BY transactions_type
                                ORDER BY installment_no))
                         AS due_installment_no'), 'transactions_no','transaction_date','transactions_type','transaction_amt','description','installment_no','approval_status');
        return $loan_transactions->paginate($request->get('size'));

    }
    private function formData(Request $request, LoanApplication $loanApplication, LoanType $loanType) {
        $sql = "SELECT lookup_code AS pass_value, NVL (meaning_bn, meaning) AS show_value
    FROM l_lookups
   WHERE lookup_type = 'LOAN_APPROVE_FOR'
ORDER BY short_by";
        $loan_application_type = DB::select($sql);
        return [
            'loanTypes' => $this->getLoanTypes($loanType),
            'payments' => $this->getPayments($request, $loanApplication),
            'loan_application_type' => $loan_application_type
        ];
    }
}
