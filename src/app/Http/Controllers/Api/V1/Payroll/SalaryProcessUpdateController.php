<?php


namespace App\Http\Controllers\Api\V1\Payroll;


use App\Contracts\Payroll\PayrollContract;
use App\Entities\Pmis\Employee\EmployeeTemp;
use App\Entities\Payroll\PrMonths;
use App\Enums\Payroll\Period\FiscalMonths;
use App\Http\Controllers\Controller;
use App\Managers\Payroll\PayrollManager;
use Illuminate\Http\Request;
use App\Entities\Pmis\Employee\Employee;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;

class SalaryProcessUpdateController extends Controller
{
    private $payrollManager;

    public function __construct(PayrollContract $payrollManager)
    {
        $this->payrollManager = $payrollManager;
    }

    public function index(Request $request)
    {
        $payrollManager = $this->payrollManager;
        $prFiscalYear = new PrMonths();
        return [
            'fiscal_months' => FiscalMonths::getFiscalMonths(),
            'fecialYearList'=> $payrollManager->findPrFiscalYears(),
            'pr_months' => $prFiscalYear->get()
        ];
    }

    public function search(Request $request)
    {
        $emp_id = 0;
        $hasError = 1;
        $pr_month = trim($request->post('pr_month'));
        $pr_year = trim($request->post('pr_year'));
        $bill_code = trim($request->post('bill_code'));
        $emp_code = trim($request->post('emp_code'));
        $where = [];
        if($pr_month != "") {
            $where[] =['pr_process.pr_month','=',$pr_month];
        }
        if($pr_year != "") {
            $where[] =['pr_process.pr_year','=',$pr_year];
        }
        if($bill_code != "") {
            $where[] =['pr_process.bill_code','=',$bill_code];
        }
        $employee = DB::table('employee')
            ->leftJoin('l_designation', 'l_designation.designation_id', '=', 'employee.designation_id')
            ->select('employee.emp_id',
                'employee.emp_name',
                'employee.emp_code',
                'employee.emp_photo',
                'l_designation.designation')
            ->where('employee.emp_code','=',$emp_code)
            ->first();
        if(!empty($employee)){
            $emp_id = $employee->emp_id;
            $hasError = 0;
        }
        $where[] =['pr_process.emp_id','=',$emp_id];
        $where[] =['pr_process.open_yn','=','Y'];

        $prprocess = DB::table('pr_process')
            ->leftJoin('pr_salary_heads', 'pr_salary_heads.salary_head_id', '=', 'pr_process.salary_head_id')
            ->select('pr_process.salary_head_id',
                'pr_process.amount',
                'pr_salary_heads.salary_head',
                'pr_process.pr_process_id',
                'pr_salary_heads.salary_head_short_name')
            ->where($where)
            ->get();
        return [
            "prprocess" => $prprocess,
            "employee" => $employee,
            "hasError" => $hasError
        ];
    }
}
