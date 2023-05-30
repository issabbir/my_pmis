<?php


namespace App\Http\Controllers\Api\V1\Payroll;

use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Admin\LDptSection;
use App\Entities\Pmis\Employee\Employee;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\DB;
use App\Contracts\Payroll\PayrollContract;
use App\Entities\Payroll\EmpSalaryApplicable;
use App\Http\Controllers\Controller;
use App\Managers\Payroll\PayrollManager;
use Illuminate\Http\Request;

class EmpWiseSalaryController extends Controller
{
    private $payrollManager;


    public function __construct(PayrollContract $payrollManager) {
        $this->payrollManager = $payrollManager;
    }

    public function index(Request $request)

    {
        $payrollManager = $this->payrollManager;
        $allocateddata = DB::table('emp_salary_applicable')
            ->join('employee', 'emp_salary_applicable.emp_id', '=', 'employee.emp_id')
            ->leftjoin('l_department', 'l_department.department_id', '=', 'employee.dpt_department_id')
            ->leftjoin('l_designation', 'l_designation.designation_id', '=', 'employee.designation_id')
            ->select('emp_salary_applicable.*','employee.emp_code', 'employee.emp_name', 'l_department.department_name','l_designation.designation')
            ->orderBy('emp_salary_applicable.applicable_id','desc')
            ->limit(10)->get();

        return[
            "allocationsalaryheads" => $payrollManager->findSalaryHeadsForAllocation(),
            "allocateddata"=>$allocateddata
            ];
    }


    public function getEmpWiseSalaryHeads(Request $request,$emp_id){
        $payrollManager = $this->payrollManager;
        return[
            "allocationsalaryheads" => $payrollManager->findSalaryHeadsForAllocation($emp_id)
        ];

    }

    /**
     * @param Request $request
     * @param $id
     * @param EmployeeContract|EmployeeManager $employeeManager
     * @return array
     */
    public function getempinfo(Request $request,$id, EmployeeContract $employeeManager){
       // $adminManager = $this->adminManager;
        return[
            "empcodeList" => $employeeManager->employeeOption($id)
        ];
    }


    public function search_emp_salary_allocation_record(Request $request,$id){


    }

    public function view(Request $request,$id)
    {
       $salaryapplicabledata = new EmpSalaryApplicable();
        $salaryapplicabledata = $salaryapplicabledata->find($id);
        $salaryapplicabledata->employee;
        return $salaryapplicabledata;
    }
    public function store(Request $request)
    {
            try {

                $status_code = sprintf("%4000s","");
                $status_message = sprintf("%4000s","");
                $params = [
                    "p_application_id" =>$request->get("applicable_id"),
                    "p_salary_head_id" => $request->get("salary_head_id"),
                    "p_salary_head_name" => $request->get("salary_head_name"),
                    "p_emp_id" => $request->get("emp_id"),
                    "p_insert_by" =>auth()->id(),
                    "p_update_by" =>'',
                    "p_active_yn" => $request->get("active_yn"),
                    "p_description" => $request->get("description"),
                    "o_status_code" => &$status_code,
                    "o_status_message" => &$status_message,
                ];
                DB::executeProcedure("PR_SAL_EX_SETUP", $params);
            }
            catch (\Exception $e) {
                return ["exception" => true, "status" => false, "message" => $e->getMessage()];
            }

            return $params;
    }

    public function update(Request $request)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_application_id" =>$request->get("applicable_id"),
                "p_salary_head_id" => $request->get("salary_head_id"),
                "p_salary_head_name" => $request->get("salary_head_name"),
                "p_emp_id" => $request->get("emp_id"),
                "p_insert_by" =>'',
                "p_update_by" =>auth()->id(),
                "p_active_yn" => $request->get("active_yn"),
                "p_description" => $request->get("description"),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PR_SAL_EX_SETUP", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }


}
