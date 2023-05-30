<?php


namespace App\Http\Controllers\Api\V1\Report;

use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Admin\LDptSection;
use App\Entities\Admin\LEmpType;
use App\Entities\Loan\LoanApplication;
use App\Entities\Payroll\PrFiscalYear;
use App\Entities\Payroll\PrMonths;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Security\Report;
use App\Managers\Admin\AdminManager;
use App\Managers\Pmis\Employee\EmployeeManager;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Contracts\Payroll\PayrollContract;
use App\Entities\Payroll\EmpSalaryApplicable;
use App\Http\Controllers\Controller;
use App\Managers\Payroll\PayrollManager;
use Illuminate\Http\Request;

class PensionParameterController extends Controller
{
    private $payrollManager;
    private $adminManager;
    private $report;


    public function __construct(PayrollContract $payrollManager, AdminManager $adminManager, Report $report)
    {
        $this->payrollManager = $payrollManager;
        $this->adminManager = $adminManager;
        $this->report = $report;
    }

    public function index(Request $request)
    {
        $module = 5;
        if (auth()->user()->hasGrantAll()) {
            $reports = $this->report->where('module_id', $module)->orderBy('report_name', 'ASC')->get();
        } else {
            $roles = auth()->user()->getRoles();
            $reports = array();
            foreach ($roles as $role) {
                $rpts = $role->reports->where('module_id', $module);
                foreach ($rpts as $report) {
                    $reports[$report->report_id] = $report;
                }
            }
        }
        $employeeType = LEmpType::orderBy('emp_type_id','ASC')->get();

        $adminManager = $this->adminManager;
        return [
            "billcodes" => $this->getEmployeeBillCodes(),
            "departments" => $adminManager->findDepartments(),
            "departmentsfs" => $adminManager->findDepartmentsFS(),
            "pension_heads" => $adminManager->findPensionHeads(),
            "prMonths" => $this->getPrMonthsByCurrentFiscalYear(),
            'prFiscalYears' => $this->payrollManager->findPrFiscalYears(),
            "loanNumbers" => $this->getLoanNo(),
//            "empTypes" => $employeeType,
            "empTypes" => $adminManager->findEmployeeTypes(),
            'reports' => $reports
        ];
    }

    public function findPrFiscalYears($id = null)
    {
        $fiscalYears = new PrFiscalYear();
        $data = $fiscalYears->get();
        if ($id) {
            return $fiscalYears->find($id);
        }

        return $fiscalYears->where('current_yn', 'Y')->orderBy('fy_id', 'asc')->get();
    }

    private function getEmployeeBillCodes()
    {
        return $this->payrollManager->getEmployeeBillCodes();
    }

    private function getPrMonths()
    {
        $prMonth = new PrMonths();
        $prMonths = $prMonth->orderBy('calculation_start_date', 'asc')->get([DB::raw("to_char(calculation_start_date, 'FMMonth-YYYY') as pr_month"), 'pr_month_id']);

        $prMonths_option = array();
        foreach ($prMonths as $item) {
            $prMonths_option[] = ["text" => $item->pr_month,
                'value' => $item->pr_month_id];
        }
        return $prMonths_option;
    }

    private function getCurrentFiscalYear()
    {
        $data = $this->payrollManager->findPrFiscalYears();
        foreach ($data as $fiscalYear) {
            $fyId = $fiscalYear->fy_id;
            //dd($fyId);
            return $fyId;
        }
    }

    private function getPrMonthsByCurrentFiscalYear()
    {
        $currentFiscalYearID = $this->getCurrentFiscalYear();
        //dd($currentFiscalYear);

        $prMonth = new PrMonths();
        $prMonths = $prMonth->orderBy('calculation_start_date', 'asc')
                            ->where('fy_id', '=', $currentFiscalYearID)
                            ->get([DB::raw("to_char(calculation_start_date, 'FMMonth-YYYY') as pr_month"), 'pr_month_id']);

        $prMonths_option = array();
        foreach ($prMonths as $item) {
            $prMonths_option[] = ["text" => $item->pr_month,
                'value' => $item->pr_month_id];
        }
        return $prMonths_option;
    }

    private function getLoanNo()
    {
        $loans = new LoanApplication();
        $loanNo = $loans->orderBy('loan_no', 'asc')->get('loan_no');
        $loanNo_option = array();
        foreach ($loanNo as $item) {
            $loanNo_option[] = ["text" => $item->loan_no, "value" => $item->loan_no];
        }
        return $loanNo_option;
    }

    public function pensionSettlement(Request $request)
    {
        try {
            $emp_code = $request->get('emp_code');
            $basic_info = DB::select('select e.emp_code,
       e.emp_name,
       e.emp_father_name,
       e.emp_mother_name,
       to_char(e.emp_dob,\'DD-MON-RRRR\')emp_dob,
       e.emp_gender_name,
       e.emp_religion_name,
       e.nid_no,
       e.emp_type,
       e.contract,
       e.emp_grade_id,
       e.emp_status,
       e.grade_step_id,
       e.grade_range,
       e.present_address,
       e.permanent_address,
       e.department_name,
       e.designation,
       to_char (e.emp_join_date, \'DD-MON-RRRR\') joining_date,
       to_char (e.emp_lpr_date, \'DD-MON-RRRR\') prl_date,
       p.bill_code,
       e.division_name,
       e.dpt_section,
       p.last_grade_id,
       p.last_payscale,
       b.bank_name,
       p.bank_acc_no,
       e.branch_name,
       nvl(p.gratuity_time,0)gratuity_time,
       \'Proposed Basic Pension\' ||\'(\'||nvl(p.pension_rate,0)||\'%\'||\')\'pension_rate,
       nvl(p.adjust_amount,0) as Total_deduction,
       to_char(p.last_basic,\'fm99,99,999,99,99,990.00\') as last_basic,
       TO_CHAR(p.proposed_basic_pension,\'fm99,99,999,99,99,990.00\') as proposed_basic_pension,
       to_char(((p.proposed_basic_pension / 2 ) + p.medical_allow),\'fm99,99,999,99,99,990.00\') as proposed_monthly_pension,
       to_char(p.pension_amt,\'fm99,99,999,99,99,990.00\') as pension_amt,
       to_char(p.pension_allow,\'fm99,99,999,99,99,990.00\') as pension_allow,
       to_char(p.medical_allow,\'fm99,99,999,99,99,990.00\') as medical_allow,
       to_char(nvl(p.pension_amt,0)-nvl(p.adjust_amount,0),\'fm99,99,999,99,99,990.00\') as Net_Settlement
  from emp_pension_calculation p, employee_info_vu e, l_banks b,emp_pension_app pa
 where     e.emp_id = p.emp_id
 and  p.apps_id = pa.apps_id
       and p.bank_id = b.bank_id
       and p.emp_code = nvl ( :p_emp_code, p.emp_code)',['p_emp_code'=>$emp_code]);

            $nominee = DB::select('select rownum sl,n.nominee_name,
       to_char (n.nominee_dob, \'dd-MON-RRRR\') as nominee_dob,
       r.relation_type,
       n.percentage,
       m.maritial_status,e.emp_code,e.emp_id
  from emp_nominee n, employee e, l_relation_type r,l_maritial_status m,emp_pension_app pa
 where     e.emp_id = n.emp_id
 and pa.emp_code=e.emp_code
       and n.relationship_id = r.relation_type_id
       and n.nominee_marital_status_id=m.maritial_status_id(+)
       and n.percentage is not null
       and pa.emp_code =nvl ( :p_emp_code, pa.emp_code)',['p_emp_code'=>$emp_code]);

            $emp_leave = DB::select('SELECT qu.emp_code,
       lt.leave_type,
       (SELECT SUM (leave_days)
          FROM emp_leave
         WHERE     emp_id = :p_emp_code
               AND leave_type_id IN (1,
                                     2,
                                     3,
                                     4,
                                     5,
                                     6,
                                     8,
                                     9,
                                     10,
                                     11,
                                     12,
                                     13,
                                     15,
                                     16,
                                     17,
                                     18,
                                     19))
          AS leave_enjoy,
       (SELECT TRUNC (SYSDATE) - emp_join_date
          FROM employee
         WHERE emp_code = :p_emp_code)
          AS v_job_duration,
       TRUNC (  (  (SELECT TRUNC (SYSDATE) - emp_join_date
                      FROM employee
                     WHERE emp_code = :p_emp_code)
                 - NVL ( (SELECT SUM (leave_days)
                            FROM emp_leave
                           WHERE     emp_id = (select emp_id from employee where emp_code = :p_emp_code)
                                 AND leave_type_id IN (1,
                                                       2,
                                                       3,
                                                       4,
                                                       5,
                                                       6,
                                                       8,
                                                       9,
                                                       10,
                                                       11,
                                                       12,
                                                       13,
                                                       15,
                                                       16,
                                                       17,
                                                       18,
                                                       19)),
                        0))
              / 11)
          remaining_balance,
          --NVL (qu.leave_enjoy, 0) AS leave_enjoy,
          --NVL (qu.remaining_balance, 0) AS remaining_balance,
          TRUNC (qu.remaining_balance / 30)
       || \' Months \'
       || MOD (qu.remaining_balance, 30)
       || \' days\'
          monday
  FROM (  SELECT ev.emp_id,
                 ev.emp_code,
                 ev.salutation_id,
                 ev.salutation,
                 ls.leave_type_id,
                 SUM (ls.leave_enjoy) AS leave_enjoy,
                 SUM (ls.remaining_balance) AS remaining_balance
            FROM employee_info_vu ev, emp_leave_summary ls
           WHERE ev.emp_id = ls.emp_id(+) AND ev.emp_code = :p_emp_code
        GROUP BY ev.emp_id,
                 ev.emp_code,
                 ev.salutation_id,
                 ev.salutation,
                 ls.leave_type_id) qu,
       l_leave_type lt
 WHERE qu.leave_type_id(+) = lt.leave_type_id AND lt.leave_type_id IN (1, 5)',['p_emp_code'=>$emp_code]);

            $file_content = DB::select('SELECT E.DESIGNATION AS DESIGNATION, E.EMP_CODE AS EMP_CODE, A.FILE_CONTENT
    FROM EMP_ATTACHMENTS A,
         WORKFLOW_STEPS WS,
         EMP_PENSION_CALCULATION P,
         EMPLOYEE_INFO_VU E
   WHERE     A.EMP_CODE = WS.USER_NAME
         AND P.APPROVAL_WORKFLOW_ID = WS.APPROVAL_WORKFLOW_ID
         AND WS.USER_NAME = E.EMP_CODE
         AND P.EMP_CODE = NVL ( :p_emp_code, P.EMP_CODE)
         AND A.ATTACHMENT_TYPE_ID = 3
ORDER BY E.DESIGNATION DESC',['p_emp_code'=>$emp_code]);
            $print_time = Carbon::now();
//        $print_time->format('Y-mon-d');
            $logo = public_path('images/cnsLogo.png');
            $pdf = Pdf::loadView('pension.report.pension_cal_settle', compact('print_time', 'basic_info', 'nominee', 'emp_leave', 'file_content', 'logo'))->setPaper('legal', 'portrait');
            $pdf->output();
            $dom_pdf = $pdf->getDomPDF();
            $canvas = $dom_pdf->get_canvas();
            $canvas->page_text(40, 115, "{PAGE_NUM} / {PAGE_COUNT}", null, 10, array(0, 0, 0));
            return $canvas->stream('pension_cal_settle.pdf');

        }catch (\Exception $e){
//            dd($e);
            return back()->withError($e->getMessage())->withInput();
        }


    }
}
