<?php


namespace App\Http\Controllers\Api\V1\Payroll;

use App\Contracts\Admin\AdminContract;
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

class SearchEmpWiseSalaryController extends Controller
{
    private $employeeManager;
    private  $payrollManager;


    public function __construct(PayrollContract $payrollManager,AdminContract $employeeManager) {
        $this->payrollManager = $payrollManager;
        $this->employeeManager=$employeeManager;
    }

    public function index(Request $request)
    {
        return [
            'departments' => $this->employeeManager->findDepartments()
        ];

    }

    public function search(Request $request){
        try {
            $department = $request->get("department");
            $activation_status    = $request->get("activation_status");
            $emp_id=$request->get("emp_id");

            $query = "SELECT * FROM 
            (SELECT A.*,L_DEPARTMENT.DEPARTMENT_NAME,L_DESIGNATION.DESIGNATION FROM 
            (select EMP_SALARY_APPLICABLE.SALARY_HEAD_ID ,
            EMP_SALARY_APPLICABLE.SALARY_HEAD_NAME,
            EMP_SALARY_APPLICABLE.EMP_ID,
            EMPLOYEE.EMP_CODE,
            EMPLOYEE.EMP_NAME,EMPLOYEE.DPT_DEPARTMENT_ID,EMPLOYEE.DESIGNATION_ID,
            EMP_SALARY_APPLICABLE.DESCRIPTION,
            EMP_SALARY_APPLICABLE.DEDUCTION_YN DEDUCTION_YN,EMP_SALARY_APPLICABLE.ACTIVE_YN ACTIVE_YN,
            DECODE(EMP_SALARY_APPLICABLE.DEDUCTION_YN,'Y','ACTIVE','N','INACTIVE')DEDUCTION_status,
            DECODE(EMP_SALARY_APPLICABLE.ACTIVE_YN,'Y','ACTIVE','N','INACTIVE')ACTIVE_status
            from EMP_SALARY_APPLICABLE,EMPLOYEE
            WHERE EMP_SALARY_APPLICABLE.EMP_ID=EMPLOYEE.EMP_ID)A
            left join L_DEPARTMENT on L_DEPARTMENT.DEPARTMENT_ID = A.DPT_DEPARTMENT_ID
            left join L_DESIGNATION on L_DESIGNATION.DESIGNATION_ID = A.DESIGNATION_ID
            Where EMP_CODE is not null ";

            if($department){
                $query .= " and DPT_DEPARTMENT_ID= '".$department."' ";
            }
            if($emp_id){
                $query .= " and EMP_ID = '".$emp_id."' ";
            }
            if($activation_status){
                $query .= " and ACTIVE_YN = '".$activation_status."' ";
            }
            $query .= ") order by DEPARTMENT_NAME asc,EMP_NAME asc";
            $salAllocation = DB::select($query);

            return [
                "salAllocation"    => $salAllocation
            ];
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

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






}
