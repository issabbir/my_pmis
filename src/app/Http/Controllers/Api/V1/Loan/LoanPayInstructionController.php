<?php


namespace App\Http\Controllers\Api\V1\Loan;

use App\Entities\Loan\LoanApplication;
use App\Entities\Loan\LoanDocuments;
use App\Entities\Loan\LoanGuarantorInfo;
use App\Entities\Loan\LoanType;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoanPayInstructionController extends Controller
{
    public function index(Request $request,LoanApplication $loanApplication, LoanType $loanType) {
        return $this->formData($request, $loanApplication, $loanType);
    }
    public function approvalType(Request $request, AdminManager $adminManager)
    {
        return [
            'departments' => $adminManager->findDepartments(),
            'sections' => $adminManager->findSections()
        ];
    }
    public function store(Request $request)
    {

        $params = [];
        $statusCode = 0;
        $statusMessage = '';
      //dd($request->all());
        try {
            foreach ($request->get('listItems') as $listItems) {
                $payment_instr_id = isset($listItems['payment_instr_id']) ? $listItems['payment_instr_id'] : null;

                $statusCode = sprintf("%4000s", "");
                $statusMessage = sprintf('%4000s', '');
                $params = [
                    "p_payment_instr_id" => $payment_instr_id,
                    "p_emp_id" => $listItems['emp_id'],
                    "p_emp_code" => $listItems['emp_code'],
                    "p_loan_no" =>  $listItems['loan_no'],
                    "p_loan_type_id" => $listItems['loan_type_id'],
                    "p_instr_month" => $request->get('month'),
                    "p_instr_on" => '',
                    "p_instr_priencipal_amt" => $listItems['instr_priencipal_amt'],
                    "p_instr_interest_amt" => $listItems['instr_interest_amt'],
                    "p_approval_status" => '',
                    "p_insert_by" => Auth()->ID(),
                    'o_status_code' => &$statusCode,
                    'o_status_message' => &$statusMessage
                ];

                DB::executeProcedure('loan.loan_payment_instr_create', $params);


                if ($params['o_status_code'] != 1) {
                    DB::rollBack();
                    return $params;
                }
            }
           // dd($params);

            if ($statusCode == 1)
                DB::commit();

            return $params;// ["table_info" => $this->load_ot_tmp_data(),  "params" =>$params]; //
        } catch (\Exception $e) {
             return ["table_info" => $params, "exception" => true, "o_status_code" => false, "o_status_message" => $e->getMessage()];
        }

    }
    private function getLoanTypes(LoanType $loanType) {
        return $loanType->get();
    }

    public function getPayInstructionLoans(Request $request, LoanApplication $loanApplication) {

        $loanType = $request->get("loan_type_id");
        $month = date('Y-m-d',strtotime($request->get("month")));
        $loan_no = $request->get("loan_no");
        //dd($loan_no);

        if ($loanType && $month){
            $sql = "SELECT lp.payment_instr_id AS payment_instr_id,
       ev.emp_name,
       ev.emp_id,
       ev.emp_code,
       ev.designation,
       la.loan_no,
       la.loan_type_id,
       lt.loan_name AS loan_type_name,
       la.loan_amount AS loan_amount,
       la.remaining_principal,
       la.remaining_interest,
       lp.instr_priencipal_amt,
       lp.instr_interest_amt,
         CASE
          WHEN lp.approval_status = 'Y' THEN 'Approved'
          ELSE 'Not Approved'
       END
          approval_status
  FROM employee_info_vu ev,
       loan_type lt,
       loans la,
       loan_payment_instruction lp
 WHERE     la.emp_id = ev.emp_id
       AND la.loan_type_id = lt.loan_type_id
       AND lp.loan_no(+) = la.loan_no
       AND la.loan_type_id = '$loanType'
       AND la.loan_no = NVL ( '$loan_no', la.loan_no)
       AND TRUNC (lp.instr_for_date(+), 'MM') =
                         TRUNC (TO_DATE ( '$month', 'RRRR-MM-DD'), 'MM') AND la.loan_status = 'ACT'";
//            echo $sql;
             return DB::select($sql);
        }
    }
    private function formData(Request $request, LoanApplication $loanApplication, LoanType $loanType) {
    $sql = "SELECT TO_CHAR (ADD_MONTHS (SYSDATE, ROWNUM - 1), 'fmMonth, RRRR')
              AS show_value,
           TRUNC (ADD_MONTHS (SYSDATE, ROWNUM - 1)) pass_value
      FROM DUAL
CONNECT BY LEVEL <= 12";
    $monthYear = DB::select($sql);

        return [
            'loanTypes' => $this->getLoanTypes($loanType),
            'loans' => $this->getPayInstructionLoans($request, $loanApplication),
            'monthYear' => $monthYear
        ];
    }
}
