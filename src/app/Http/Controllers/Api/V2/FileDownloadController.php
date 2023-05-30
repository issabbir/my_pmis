<?php

namespace App\Http\Controllers\Api\V2;


use App\Contracts\Authorization\AuthContact;
use App\Entities\Payroll\PrMonths;
use App\Entities\Pmis\Employee\Employee;
use App\Enums\YesNoFlag;
use App\Http\Controllers\Controller;
use App\Managers\Authorization\AuthorizationManager;
use App\Services\Report\OraclePublisher;
use App\Entities\Payroll\PrSalaryProcess;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Entities\Security\Report;
use Tymon\JWTAuth\Exceptions\JWTException;

class FileDownloadController extends Controller
{


    /** @var OraclePublisher  */
    private $oraclePublisher;

    /**
     * @var AuthContact|AuthorizationManager
     */
    protected $authManager;


    /**
     * OraclePublisherController constructor.
     * @param OraclePublisher $oraclePublisher
     */
    public function __construct(OraclePublisher $oraclePublisher,AuthContact $authManager)
    {
        $this->oraclePublisher = $oraclePublisher;
        $this->authManager = $authManager;
    }

    /**
     * @OA\Get(
     * path="/api/get-bill-month",
     * summary="Bill Month",
     * description="Login by user, password",
     * operationId="authLogin",
     * tags={"billMonth"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function bill_month(Request $request)
    {
        // $credentials['is_verified'] = 1;

        try {

           // $yr =  $request->get('fiscal_year_id');
              $yr = "";

              $user_id  = Auth::id();

              $user = $this->authManager->get_user_by_user_id($user_id);

              $emp_id = $user->emp_id;

              $emp_id = "2010300100334458"; //BILLER EMP ID
         /*   $prMonth = new PrMonths();
            $prMonths = $prMonth->orderBy('calculation_start_date', 'asc')->get([DB::raw("to_char(calculation_start_date, 'FMMonth-YYYY') as pr_month" ), 'pr_month_id']);*/

           // $data =  DB::select($query);

            $sql  = "select distinct pm.PR_MONTH_ID as value, to_char(pm.CALCULATION_START_DATE, 'fmMonth - YYYY') as text
from PR_BILL_STATES pbs
         inner join L_PR_BILL_STATUS lps on (lps.PR_BILL_STATUS_ID = pbs.PR_BILL_STATUS_ID)
         inner join PR_MONTHS pm on (pbs.MONTH_ID = pm.PR_MONTH_ID)
where pbs.BILL_CODE in (select EMP_BILL_CODE from PR_BILL_CODE_MAPPING where BILLER_EMP_ID = :empId)
  and pm.FY_ID = nvl(:year,pm.FY_ID) and lps.STATUS_KEY='BILL_DISBURSED'
order by pm.PR_MONTH_ID" ;

            $data =  DB::select($sql,['year' => $yr, 'empId' => $emp_id]);

            return response()->json(['success' => true, 'data' => ['bill_month' => $data]], 200);

        } catch (\Exception $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }


    }

    /**
     * @OA\Post(
     * path="/api/payslip/details",
     * summary="Payslip details",
     * description="Payslip details",
     * operationId="PayslipDetails",
     * tags={"file"},
     * security={{ "apiAuth": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Payrol details",
     *    @OA\JsonContent(
     *       required={"pr_month","bill_code"},
     *       @OA\Property(property="pr_month", type="string", format="pr_month", example="2011191002736595"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success"
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Returns when user is not authenticated",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Not authorized"),
     *    )
     * )
     * )
     */
   /* public function payslip_details(Request $request)
    {
      try{
          $pr_month = $request->get('pr_month');

          $rules = [
              'pr_month' => 'required',
          ];
          $validator = \Validator::make($request->all(), $rules);

          if ($validator->fails()) {
              return response()->json(['success' => false, 'error' => $validator->messages()->first()], 401);
          }

          $user_id  = Auth::id();
          $user = $this->authManager->get_user_by_user_id($user_id);
          $emp_id = $user->emp_id;


          $employee = Employee::with([])->where('emp_id', '=',$emp_id)->first();

          $emp_code = $employee->emp_code;
          $where = [];
          if($emp_code != "") {
              $where[] =['pr_salary_process.emp_code','=',$emp_code];
          }
          if($pr_month > 0) {
          }

          $query = <<<QUERY

  SELECT SALARY_HEAD,
       AMOUNT,
       PR_MONTH_ID,
       BILL_CODE,
       PR_YEAR,
       EMP_CODE
  FROM PR_SALARY_PROCESS
 WHERE EMP_CODE = :emp_code AND PR_MONTH_ID = :pr_month

QUERY;


          $salaries=DB::select($query,['emp_code' => $emp_code, 'pr_month' => $pr_month]);



          return response()->json(['success' => true, 'data' => ['salaries' => $salaries]], 200);

          //return ;
      }catch (\Exception $e){
          return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
      }

    }*/

    public function payslip_details(Request $params)
    {

//        $prProcess = new PrSalaryProcess();
//        $prProcess = $prProcess->select(
//            DB::raw("SUM(CASE WHEN deduction_yn='N' THEN amount ELSE 0 END) as sum_allowance"),
//            DB::raw("SUM(CASE WHEN deduction_yn='Y' THEN amount ELSE 0 END) as sum_deduction"),
//            DB::raw("SUM(CASE WHEN deduction_yn='N' THEN amount ELSE 0 END) - SUM(CASE WHEN deduction_yn='Y' THEN amount ELSE 0 END) as salary"),
//            'emp_code', 'emp_name','pr_year', 'pr_month', 'pr_month_id', 'bill_code')
//            ->groupBy('emp_code')
//            ->groupBy('emp_name')
//            ->groupBy('pr_year')
//            ->groupBy('pr_month')
//            ->groupBy('pr_month_id')
//            ->groupBy('bill_code')
//            ->orderBy('pr_month_id', 'desc');
//        $where = [];
//        if ($fYear = $params->get("fy_id")) {
//            $where[] = ['pr_year', '=', $fYear];
//        }
//        if ($prMonth = $params->get('pr_month')) {
//            $where[] = ['pr_month_id', '=', $prMonth];
//        }
//        if (Auth::user()->employee->emp_code){
//            $where[] = ['emp_code', '=', Auth::user()->employee->emp_code];
//        }
//        $where[] = ['disburse_yn', '=', 'Y'];
//        $where[] = ['EVERY_MONTH_YN', '=', 'Y'];
//        dd($params);
        $fYear = $params->get("fy_id");
        $prMonth = $params->get('pr_month');
        $emp_code = Auth::user()->employee->emp_code;
        $prProcess = <<<QUERY
WITH g
     AS (  SELECT SUM (CASE WHEN S.deduction_yn = 'N' THEN S.amount ELSE 0 END)
                     AS sum_allowance,
                  SUM (CASE WHEN S.deduction_yn = 'Y' THEN S.amount ELSE 0 END)
                     AS sum_deduction,
                    SUM (
                       CASE WHEN S.deduction_yn = 'N' THEN S.amount ELSE 0 END)
                  - SUM (
                       CASE WHEN S.deduction_yn = 'Y' THEN S.amount ELSE 0 END)
                     AS salary,
                  SUM (CASE WHEN S.BONUS_YN = 'Y' THEN S.amount ELSE 0 END)
                     AS bonus_amount,
                  f_words (
                       SUM (
                          CASE
                             WHEN S.deduction_yn = 'N' THEN S.amount
                             ELSE 0
                          END)
                     - SUM (
                          CASE
                             WHEN S.deduction_yn = 'Y' THEN S.amount
                             ELSE 0
                          END))
                     AS words,
                  S."EMP_CODE",
                  S."EMP_NAME",
                  S."PR_YEAR",
                  S."PR_MONTH_ID",
                  S."BILL_CODE",
                  D."DESIGNATION" AS DESIGNATION,
                  TO_CHAR(PRM.CALCULATION_START_DATE, 'MON-YYYY') AS FORMATTED_MONTH,
                  DECODE (S."DEPUTATION_YN",  'Y', 'YES',  'N', 'NO',  'NO')
                     AS DEPUTATION,
                  (SELECT EMP_STATUS
                     FROM l_emp_status
                    WHERE EMP_STATUS_ID = S.EMP_STATUS_ID)
                     AS EMP_STATUS
             FROM "PMIS"."PR_SALARY_PROCESS" S
                  LEFT JOIN "PMIS"."L_DESIGNATION" D
                     ON (S."DESIGNATION_ID" = D."DESIGNATION_ID")
                  LEFT JOIN PMIS.PR_MONTHS PRM
                     ON (S.PR_MONTH_ID = PRM.PR_MONTH_ID)
            WHERE (    S."PR_MONTH_ID" = $prMonth
                   AND S.emp_code = NVL ( $emp_code, S.emp_code)
                   AND S.BONUS_YN = 'N'
                   AND S.DISBURSE_YN = 'Y'
                   AND NVL (S.EMP_ACTIVE_YN, 'N') = 'Y'
                   AND S.EMP_STATUS_ID <> 5)
         GROUP BY S."EMP_CODE",
                  S."EMP_NAME",
                  S."PR_YEAR",
                  S."PR_MONTH_ID",
                  S."BILL_CODE",
                  D."DESIGNATION",
                  S."DEPUTATION_YN",
                  S.EMP_STATUS_ID,
                  PRM.CALCULATION_START_DATE
         ORDER BY S."EMP_CODE")
SELECT ROWNUM, g.*
  FROM g
 WHERE g.Salary > 0
QUERY;
        return DB::select($prProcess);

//        return $prProcess->with( ['pr_months'=> function($q) {
//           return $q->orderBy('calculation_start_date', 'desc');
//        }])->where($where)->get();
    }

    public function bonus_payslip_details(Request $params)
    {
//dd($params);
//        $prProcess = new PrSalaryProcess();
//        $prProcess = $prProcess->select(
//            DB::raw("SUM(CASE WHEN deduction_yn='N' THEN amount ELSE 0 END) as sum_allowance"),
//            DB::raw("SUM(CASE WHEN deduction_yn='Y' THEN amount ELSE 0 END) as sum_deduction"),
//            DB::raw("SUM(CASE WHEN deduction_yn='N' THEN amount ELSE 0 END) - SUM(CASE WHEN deduction_yn='Y' THEN amount ELSE 0 END) as salary"),
//            'emp_code', 'emp_name','pr_year', 'pr_month', 'pr_month_id', 'bill_code')
//            ->groupBy('emp_code')
//            ->groupBy('emp_name')
//            ->groupBy('pr_year')
//            ->groupBy('pr_month')
//            ->groupBy('pr_month_id')
//            ->groupBy('bill_code')
//            ->orderBy('pr_month_id', 'desc');
//        $where = [];
//        if ($fYear = $params->get("fy_id")) {
//            $where[] = ['pr_year', '=', $fYear];
//        }
//        if ($prMonth = $params->get('pr_month')) {
//            $where[] = ['pr_month_id', '=', $prMonth];
//        }
//        if (Auth::user()->employee->emp_code){
//            $where[] = ['emp_code', '=', Auth::user()->employee->emp_code];
//        }
//        $where[] = ['disburse_yn', '=', 'Y'];
//        $where[] = ['EVERY_MONTH_YN', '=', 'Y'];
//        dd($params);
        $fYear = $params->get("fy_id");
        $prMonth = $params->get('pr_month');
        $salary_head = $params->get('bonus_type');
        $emp_code = Auth::user()->employee->emp_code;
        $prProcess = <<<QUERY
WITH g
     AS (  SELECT SUM (CASE WHEN S.deduction_yn = 'N' THEN S.amount ELSE 0 END)
                     AS sum_allowance,
                  SUM (CASE WHEN S.deduction_yn = 'Y' THEN S.amount ELSE 0 END)
                     AS sum_deduction,
                    SUM (
                       CASE WHEN S.deduction_yn = 'N' THEN S.amount ELSE 0 END)
                  - SUM (
                       CASE WHEN S.deduction_yn = 'Y' THEN S.amount ELSE 0 END)
                     AS salary,
                  SUM (CASE WHEN S.BONUS_YN = 'Y' THEN S.amount ELSE 0 END)
                     AS bonus_amount,
                  f_words (
                       SUM (
                          CASE
                             WHEN S.deduction_yn = 'N' THEN S.amount
                             ELSE 0
                          END)
                     - SUM (
                          CASE
                             WHEN S.deduction_yn = 'Y' THEN S.amount
                             ELSE 0
                          END))
                     AS words,
                  S."EMP_CODE",
                  S."EMP_NAME",
                  S."PR_YEAR",
                  S."PR_MONTH_ID",
                  S."BILL_CODE",
                  D."DESIGNATION" AS DESIGNATION,
                  TO_CHAR(PRM.CALCULATION_START_DATE, 'MON-YYYY') AS FORMATTED_MONTH,
                  DECODE (S."DEPUTATION_YN",  'Y', 'YES',  'N', 'NO',  'NO')
                     AS DEPUTATION,
                  (SELECT EMP_STATUS
                     FROM l_emp_status
                    WHERE EMP_STATUS_ID = S.EMP_STATUS_ID)
                     AS EMP_STATUS
             FROM "PMIS"."PR_SALARY_PROCESS" S
                  LEFT JOIN "PMIS"."L_DESIGNATION" D ON (S."DESIGNATION_ID" = D."DESIGNATION_ID")
                  LEFT JOIN PMIS.PR_MONTHS PRM ON (S.PR_MONTH_ID = PRM.PR_MONTH_ID)
                  LEFT JOIN PR_SALARY_HEADS PSH ON (S.SALARY_HEAD_ID = PSH.SALARY_HEAD_ID)
            WHERE (    S."PR_MONTH_ID" = $prMonth
                   AND S.emp_code = NVL ( $emp_code, S.emp_code)
                   AND PSH.SALARY_HEAD_ID = NVL ( $salary_head, PSH.SALARY_HEAD_ID)
                   AND S.BONUS_YN = 'Y'
                   AND S.DISBURSE_YN = 'Y'
                   AND NVL (S.EMP_ACTIVE_YN, 'N') = 'Y'
                   AND S.EMP_STATUS_ID <> 5)
         GROUP BY S."EMP_CODE",
                  S."EMP_NAME",
                  S."PR_YEAR",
                  S."PR_MONTH_ID",
                  S."BILL_CODE",
                  D."DESIGNATION",
                  S."DEPUTATION_YN",
                  S.EMP_STATUS_ID,
                  PRM.CALCULATION_START_DATE
         ORDER BY S."EMP_CODE")
SELECT ROWNUM, g.*
  FROM g
 WHERE g.Salary > 0
QUERY;
        return DB::select($prProcess);

//        return $prProcess->with( ['pr_months'=> function($q) {
//           return $q->orderBy('calculation_start_date', 'desc');
//        }])->where($where)->get();
    }


    public function get_bonus_type()
    {
        $sql  = "SELECT PSH.SALARY_HEAD AS TEXT, PSH.SALARY_HEAD_ID AS VALUE
  FROM PR_SALARY_HEADS PSH
 WHERE PSH.BONUS_YN = 'Y'" ;
        return DB::select($sql);
    }

    /**
     * Render pdf
     *
     * @param $reportContent
     * @return \Illuminate\Http\Response
     */
    private function renderPdf($filename,$reportContent) {
        //$filename = $this->fileName?:'file'.".pdf";

        return response()->make($reportContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }
//DB::raw("SUM(CASE WHEN deduction_yn='N' THEN amount ELSE 0 END) as sum_allowance"),
//DB::raw("SUM(CASE WHEN deduction_yn='Y' THEN amount ELSE 0 END) as sum_deduction"),
//DB::raw("SUM(CASE WHEN deduction_yn='N' THEN amount ELSE 0 END) - SUM(CASE WHEN deduction_yn='Y' THEN amount ELSE 0 END) as salary"),
//'emp_code', 'emp_name','pr_year', 'pr_month', 'pr_month_id', 'bill_code', 'disburse_yn')
//->groupBy('emp_code')
//->groupBy('emp_name')
//->groupBy('pr_year')
//->groupBy('disburse_yn')
//->groupBy('pr_month')
//->groupBy('pr_month_id')
//->groupBy('bill_code')
//->orderBy('pr_month_id', 'desc');


   //http://192.168.78.38/api/payslip/download-by-employee-id?emp_id=2101041409754306&pr_month=2011191002736595
    /**
     * @OA\Get(
     * path="/api/payslip/download-by-employee-id",
     * summary="Payslip downlaod by get",
     * description="Payslip downlaod link get",
     * operationId="PayslipDownload",
     * tags={"PayslipDownload"},
     * security={{ "apiAuth": {} }},

     * @OA\Response(
     *    response=200,
     *    description="Success"
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Returns when user is not authenticated",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Not authorized"),
     *    )
     * )
     * )
     */
    public function payslip_download_by_emp_id(Request $request)
    {
        try{

            $rules = [
                'pr_month' => 'required',
                'emp_id' => 'required',
            ];
            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'error' => $validator->messages()->first()], 401);
            }

            $pr_month = $request->get('pr_month');
            $emp_id = $request->get('emp_id');


          //  $credentials = $request->only('user_name', 'user_pass');




            $employee = Employee::with([])->where('emp_id', '=',$emp_id)->first();

            $emp_code = $employee->emp_code;

            $bill_code = $employee->bill_code;

            // $emp_code = '033333';

            $reportObject = new Report();

            $module = 2;

            $report = $reportObject->where('module_id', $module)->where('report_name','Employee Pay slip')->orderBy('report_name', 'ASC')->first();


            if(!$report){
                return response()->json(['success' => false, 'error' => 'No report found!'], 401);
            }

            $xdo = $report->report_xdo_path;

            $type = 'pdf';

            $filename = "EmployeePaySlip.".$type;

            $pr_month_param_name = $report->params[0]['param_name'];
            $bill_code_param_name = $report->params[1]['param_name'];
            $emp_code_param_name = $report->params[2]['param_name'];

            $params = array();
            $params['report'] = $report->report_id;
            $params['rid'] = $report->report_id;
            $params[$pr_month_param_name] = $pr_month; //pr_month
            $params[$bill_code_param_name] = $bill_code; //bill_code
            $params[$emp_code_param_name] = $emp_code; //emp_code
            //$params['filename'] = $filename;

            $reportContent = $this->oraclePublisher
                ->setXdo($xdo)
                ->setType($type)
                ->setParams($params)->generate();
            return $this->renderPdf($filename,$reportContent);
        }catch (\Exception $e){
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }

    }


}
