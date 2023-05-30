<?php

namespace App\Http\Controllers\Api\V2;

use App\Contracts\Authorization\AuthContact;
use App\Entities\Loan\LoanApplication;
use App\Entities\Loan\Loans;
use App\Entities\Loan\LoanType;
use App\Entities\Pmis\Employee\Employee;
use App\Enums\Auth\UserParams;
use App\Enums\YesNoFlag;
use App\Managers\Authorization\AuthorizationManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTFactory;
//use Tymon\JWTAuth\JWTAuth;
use Validator;
use JWTAuth;
use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;


class LoanController extends Controller
{
    protected $authManager;

    public function __construct(AuthContact $authManager)
    {
        $this->authManager = $authManager;
    }


    /**
     * @OA\Post(
     * path="/api/employee-loans",
     * summary="Loans",
     * description="Login by user, password",
     * operationId="authLogin",
     * tags={"Loans"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"loan_type_id","loan_id","fiscal_year_from","fiscal_year_to","month_from","month_to"},
     *       @OA\Property(property="loan_no", type="string", format="loan_no", example="L-MRN-HB000001"),
     *       @OA\Property(property="loan_type_id", type="string", format="loan_type_id", example="2"),
     *       @OA\Property(property="year_from", type="string", format="year_from", example="2020"),
     *       @OA\Property(property="year_to", type="string", format="year_to", example="2021"),
     *       @OA\Property(property="month_from", type="string", format="emp_id", example="12"),
     *       @OA\Property(property="month_to", type="string", format="emp_id", example="1"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function employee_loan(Request $request)
    {

        // $credentials['is_verified'] = 1;

        try {
            $user_id  = Auth::id();

            $user = $this->authManager->get_user_by_user_id($user_id);

            $emp_id = $user->emp_id;

           // $emp_id = '2010300105334300';
            $employee = Employee::with([])->where('emp_id', '=',$emp_id)->first();

            $emp_code = $employee->emp_code;


            $loan_no = $request->get('loan_no');
            $loan_type_id = $request->get("loan_type_id");
            $year_from = $request->get("year_from");
            $month_from = $request->get("month_from");
            $year_to = $request->get("year_to");
            $month_to = $request->get("month_to");
            $sql = "SELECT ev.gpf_id,
       ev.emp_id,
       ev.emp_code,
       ev.emp_name,
       ev.designation_id,
       ev.designation,
       ev.dpt_department_id,
       ev.department_name,
       ev.grade_range AS pay_scale,
       TO_CHAR (ev.basic_amt, 'fm9999,999,99,99,990.00') basic_amt,
       TO_CHAR (ev.emp_lpr_date, 'DD-fmMon-RRRR') emp_lpr_date,
       TO_CHAR (ev.emp_join_date, 'DD-fmMon-RRRR') emp_join_date,
       qu.loan_id,
       qu.loan_no,
       TO_CHAR (qu.opening, 'fm9999,999,99,99,990.00') AS opening,
       TO_CHAR (qu.installment_amount, 'fm9999,999,99,99,990.00')
          AS installment_amount,
       TO_CHAR (qu.interest_rate, 'fm9999,999,99,99,990.00') AS interest_rate,
       TO_CHAR (qu.loan, 'fm9999,999,99,99,990.00') AS loan,
       qu.total_installment AS total_installment,
       qu.total_paid_installment AS total_paid_installment,
       TO_CHAR (qu.loan_repay_amount, 'fm9999,999,99,99,990.00')
          AS loan_repay_amount,
       TO_CHAR (qu.loan_interest_paid, 'fm9999,999,99,99,990.00')
          AS loan_interest_paid,
       TO_CHAR ( (qu.loan - qu.loan_repay_amount), 'fm9999,999,99,99,990.00')
          AS loan_balance
  FROM employee_info_vu ev,
       (  SELECT la.emp_id,
                 la.application_id AS loan_id,
                 la.loan_no,
                 0 AS opening,
                 ROUND ( (la.application_amt / la.installment_no), 2)
                    AS installment_amount,
                 la.rate_of_interest AS interest_rate,
                 la.application_amt AS loan,
                 la.installment_no AS total_installment,
                 SUM (CASE WHEN lt.transactions_type = 3 THEN 1 ELSE 0 END)
                    AS total_paid_installment,
                 SUM (
                    CASE
                       WHEN lt.transactions_type = 3 THEN lt.transaction_amt
                       ELSE 0
                    END)
                    AS loan_repay_amount,
                 SUM (
                    CASE
                       WHEN lt.transactions_type = 4 THEN lt.transaction_amt
                       ELSE 0
                    END)
                    AS loan_interest_paid
            FROM loan_transactions lt, loan_application la
           WHERE     lt.loan_type_id(+) = la.loan_type_id
                 AND lt.loan_no(+) = la.loan_no
                 AND la.emp_code = :p1
                 AND lt.approval_status = 'Y'
        GROUP BY la.emp_id,
                 la.application_id,
                 la.loan_no,
                 0,
                 ROUND ( (la.application_amt / la.installment_no), 2),
                 la.rate_of_interest,
                 la.application_amt,
                 la.installment_no,
                 NVL (la.paid_installment_no, 0)) qu
 WHERE ev.emp_id = qu.emp_id";
            $list = DB::select($sql, ['p1' => $emp_code]);


            return response()->json(['success' => true, 'data' => ['loan' => $list]], 200);

        } catch (\Exception $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }


    }

    public function loaNumbers(){

    }


}
