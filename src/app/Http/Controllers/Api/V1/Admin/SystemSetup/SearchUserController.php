<?php

namespace App\Http\Controllers\Api\V1\Admin\SystemSetup;

use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmployeeTemp;
use App\Entities\Security\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\Admin\AdminContract;
use App\Managers\Admin\AdminManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchUserController extends Controller
{
    protected $adminManager;
    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        $employee = new Employee();
        $adminManager = $this->adminManager;
        return [
            "departments" => $adminManager->findDepartments(),
            "sections" => $adminManager->findDptSections()
        ];
    }



    public function searchEmployee(Request $request) {
            $department_id = $request->get('department_id');
             $dpt_section_id = $request->get('dpt_section_id');
             $emp_code = trim($request->get('emp_code'));

            $query = "SELECT E.EMP_ID,
                   E.EMP_CODE,
                   E.EMP_NAME,
                   E.DESIGNATION_ID,
                   D.DESIGNATION,
                   E.DPT_DEPARTMENT_ID,
                   DPT.DEPARTMENT_NAME,
                   E.SECTION_ID,
                   S.DPT_SECTION
              FROM employee e,
                   l_designation d,
                   l_department dpt,
                   L_DPT_SECTION s
             WHERE     E.DESIGNATION_ID = D.DESIGNATION_ID
                   AND E.DPT_DEPARTMENT_ID = DPT.DEPARTMENT_ID
                   AND E.SECTION_ID = S.DPT_SECTION_ID(+)
                   AND e.emp_status_id = 1
                   AND E.EMP_ACTIVE_YN = 'Y'
                   AND E.EMP_ID NOT IN (SELECT EMP_ID
                                          FROM CPA_SECURITY.SEC_USERS u
                                         WHERE EMP_ID = e.EMP_ID)";
            if($department_id  != ""){
                $query.= " AND (E.DPT_DEPARTMENT_ID = '$department_id'
            OR '$department_id' IS NULL)";
            }
            if($dpt_section_id != ""){
                 $query.= " AND (E.SECTION_ID = '$dpt_section_id' OR '$dpt_section_id' IS NULL)";
             }
             if($emp_code  != "" ){
                 $query .= " AND (E.EMP_CODE = '$emp_code' OR '$emp_code' IS NULL)";
             }
            //echo $query;
              $employees = DB::select($query);
             //die();
             return [
                "employees" => $employees
            ];
    }

     public function searchUser(Request $request, User $user) {
            $userName = $request->get('userName');
            $userType = $request->get('userType');
            $status = $request->get('status');
            $department = $request->get('department');
         /*   $users = $user->all();*/
                $query = "select u.user_id,
       u.user_name,
       u.signature,
       u.signature_type,
       u.is_active,
       ut.user_type_name,
       e.emp_name,
       u.email,
       e.dpt_department_id,
       e.designation_id,
       ds.designation,
       d.department_name
  from cpa_security.sec_users u,
       cpa_security.sec_user_types ut,
       pmis.employee e,
       pmis.l_department d,
       pmis.l_designation ds
 where     u.emp_id = e.emp_id(+)
       and u.user_type_id = ut.user_type_id(+)
       and e.dpt_department_id = d.department_id(+)
       and e.designation_id = ds.designation_id(+)";

        if($userName){
                $query .= " and (lower (user_name) = lower ('$userName') or lower ('$userName') is null)";
            }
        if($userType){
                $query .= " and (u.user_type_id = '$userType' or '$userType' is null)";
            }
        if($status){
                $query .= " and (lower (is_active) = lower ('$status') or lower ('$status') is null)";
            }
        if($department){
                $query .= " and (e.dpt_department_id = '$department' or '$department' is null)";
            }
   $users = DB::select($query);
     //$users = $user->where('user_name', $userName)->get();
            return [
                "users" => $users
            ];
     }

}
