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
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoanSetupController extends Controller
{
    public function index(Request $request)
    {
        $sql = "SELECT lookup_code AS pass_value, NVL (meaning_bn, meaning) AS show_value
    FROM l_lookups
   WHERE lookup_type = 'LOAN_APPROVE_FOR'
   AND ACTIVE_YN = 'Y'
ORDER BY short_by";

        $loan_application_type = DB::select($sql);

        $sql2 = "SELECT approval_setup_id,
         approval_for,
        approval_for_department  as  approval_for_department_id,
         (SELECT department_name
            FROM l_department
           WHERE department_id = approval_for_department)
            AS approval_for_department,
         approval_for_section,
         (SELECT dpt_section
            FROM l_dpt_section
           WHERE     department_id = approval_department
                 AND dpt_section_id = approval_for_section)
            AS approval_for_section_name,
         priority_sequence,
         priority_type,
         ll.meaning AS approval_for_name,
         approval_department,
         (SELECT department_name
            FROM l_department
           WHERE department_id = approval_department)
            AS approval_department_name,
         approval_section,
         (SELECT dpt_section
            FROM l_dpt_section
           WHERE     department_id = approval_department
                 AND dpt_section_id = approval_section)
            AS approval_section_name,
         approval_emp_id,
         (SELECT emp_name
            FROM employee
           WHERE emp_id = approval_emp_id)
            emp_name,
         (SELECT emp_code
            FROM employee
           WHERE emp_id = approval_emp_id)
            emp_code
    FROM loan_approval_setup la, l_lookups ll
   WHERE     la.approval_for = ll.lookup_code
         AND ll.lookup_type = 'LOAN_APPROVE_FOR'
         AND ll.active_yn = 'Y'
ORDER BY approval_for,
         approval_for_department,
         approval_department,
         approval_section,
         priority_sequence";

        $approvalSetup = DB::select($sql2);

        return [
            'loan_application_type' => $loan_application_type,
            'approvalSetup' => $approvalSetup,
        ];
    }
    public function approvalType(Request $request, AdminManager $adminManager)
    {
        return [
            'departments' => $adminManager->findDepartments(),
            'sections' => $adminManager->findSections()
        ];
    }

    public function store(Request $request){
         try {
            $setup_id = $request->get("approval_setup_id") ? $request->get("approval_setup_id") : null;
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_approval_setup_id" => $setup_id,
                "p_approval_for" => $request->get("application_page_id"),
                "p_approval_for_department" => $request->get("approval_for_department_id"),
                "p_approval_department" => $request->get("department_id"),
                "p_approval_section" => $request->get("section_id"),
                "p_approval_emp_id" =>  $request->get("emp_id") ? (int)$request->get("emp_id") : null,
                "p_priority_type" => 'S',
                "p_priority_sequence" => $request->get("priority_sequence"),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];

            DB::executeProcedure("loan.loan_approval_setup_create", $params);
            // dd($params);
          }
        catch (\Exception $e) {
            return ["exception" => true, 'o_status_code' => 99,  "status" => false, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function sectionByDepartment($id){
         return LDptSection::where('department_id',$id)->get();
    }
    public function approveForDepartment($approval_for,$approval_for_department){
        //echo $approval_for;
       // echo $approval_for_department;
        $sql = "SELECT NVL (MAX (priority_sequence), 0) + 1 as priority_sequence
  FROM loan_approval_setup
 WHERE     approval_for = :p_approval_for
       AND approval_for_department = :p_approval_for_department";

         $priority_sequence = DB::selectOne($sql, ['p_approval_for' => $approval_for,'p_approval_for_department' => $approval_for_department]);
           //dd($priority_sequence);
         if (isset($priority_sequence)){
            return response(['priority_sequence' => $priority_sequence->priority_sequence]);
        }else{
            return response(['priority_sequence' => 1]);
        }

    }
    public function departmentByEmployee($department_id,$section_id,$searchParam){
        if ($section_id == null)
            $section_id = 0;

        $sql = "select loan.loan_app_setup_emp_search(:department_id,:section_id,:param) from dual";
        return  DB::select($sql, ['department_id' => $department_id,'section_id' => $section_id,'param' => $searchParam]);
    }


}
