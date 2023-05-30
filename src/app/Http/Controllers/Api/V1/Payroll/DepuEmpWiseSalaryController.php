<?php


namespace App\Http\Controllers\Api\V1\Payroll;

use App\Contracts\Payroll\DepuEmpPayrollContract;
use App\Contracts\Pmis\Employee\DepuEmpBasicInfoContract;
use App\Entities\Admin\LDptSection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDO;

class DepuEmpWiseSalaryController extends Controller
{
    private $depuEmpPayrollManager;
    private $depuEmployeeManager;


    public function __construct(DepuEmpPayrollContract $depuEmpPayrollManager,DepuEmpBasicInfoContract $depuEmployeeManager) {
        $this->depuEmpPayrollManager = $depuEmpPayrollManager;
        $this->depuEmployeeManager = $depuEmployeeManager;
    }

    public function getDeputationEmp(Request $request,$id)
    {
        return[
            "data" => $this->depuEmployeeManager->getDeputationEmpInfo($id),
            ];
    }

    public function getEmpWiseSalaryHeads(Request $request,$id=null,$emp_id=null){

        return[
            "data" => $this->depuEmpPayrollManager->findPrSalaryHeads($id,$emp_id)
        ];

    }

    public function getAllocatedSalaryHead(Request $request,$id){
        return[
            "allocatedHeadData" => $this->depuEmpPayrollManager->getEmpSalaryAllocatedHead($id)
        ];
    }


    public function view(Request $request,$id,$emp_id)
    {

    }
    public function store(Request $request)
    {
            try {
                $pr_emp_depu_id = $request->get('pr_emp_depu_id');
                $status_code = sprintf("%4000s","");
                $status_message = sprintf("%4000s","");
                $params = [
                    'p_PR_EMP_DEPU_ID' => [
                        'value' => &$pr_emp_depu_id,
                        "type" => PDO::PARAM_INPUT_OUTPUT,
                        "length" => 255],
                    "p_EMP_ID" => $request->get("emp_id"),
                    "p_salary_head_id" => $request->get("salary_head_id"),
                    "p_AMOUNT"=>$request->get('emp_salary_head_amt'),
                    "p_REMARKS"=>$request->get('remarks'),
                    "p_active_yn" => $request->get("active_yn"),
                    "p_insert_by" =>auth()->id(),
                    "o_status_code" => &$status_code,
                    "o_status_message" => &$status_message,
                ];
                DB::executeProcedure("payroll.pr_emp_depu_entry", $params);
            }
            catch (\Exception $e) {
                return ["exception" => true, "status" => false, "message" => $e->getMessage()];
            }

            return $params;
    }


}
