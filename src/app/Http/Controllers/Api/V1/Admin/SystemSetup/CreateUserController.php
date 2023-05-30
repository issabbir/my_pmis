<?php

namespace App\Http\Controllers\Api\V1\Admin\SystemSetup;

use App\Contracts\Admin\AdminContract;
use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Admin\LEmpType;
use App\Entities\Pmis\Employee\EmpExperienceTemp;
use App\Entities\Pmis\Employee\EmployeeTemp;
use App\Entities\Security\Role;
use App\Entities\Security\User;
use App\Entities\Security\UserType;
use App\Enums\Pmis\Employee\Statuses;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\Admin\SecIpAllowed;
use App\Entities\Pmis\Employee\EmpEducationTemp;
use App\Entities\Pmis\Employee\Employee;
use App\Managers\Admin\AdminManager;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;

class CreateUserController extends Controller
{
    protected $adminManager;

    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request, Role $role)
    {

        $userType = new UserType();
        return [
            'roles' =>  $role->where("active_yn", 'Y')->get(),
            'userTypes' => $this->userType(),
            "departments" =>  $this->adminManager->findDepartments(),
            "references" =>  $this->adminManager->findUserLookups(),
        ];
    }

    public function getUpdateUserInfo($id, User $user, Employee $employee, Role $role){
       // $user = $user->where('emp_id',$id)->first();
        $user = $user->where('user_id',$id)->first();
        return [
           "employee" =>  $employee->find($user->emp_id),
           "user" => $user,
           "roles" => $user->getRoles(),
           "users" =>  $user->with('employee')->get(),
           "userTypes" => $this->userType(),
           "rolesList" => $role->where("active_yn", 'Y')->get(),
        ];
    }

    public function view($id, User $user, Employee $employee, Role $role)
    {
        $user = $user->with(['bank', 'branch'])->where('user_id',$id)->first();
        //dd();
        return [
           "employee" =>  $employee->find($user->emp_id),
           "user" => $user,
           "roles" => $user->getRoles(),
           "rolesList" => $role->where("active_yn", 'Y')->get(),
        ];
    }


    public function store(Request $request)
    {
        return $this->setUserPassword($request);
    }

    public function updateUser(Request $request)
    {
        DB::beginTransaction();
         try {
            $o_status_code = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');
            $user_id = $request->get('user_id');

            $params = [
                'p_USER_ID' => $user_id,
                'p_USER_TYPE_ID' => $request->get('userType'),
                'p_IS_ACTIVE' => $request->get('status'),
                'p_EMAIL' => $request->get('email'),
                'p_BANK_ID' => $request->get('bank_id'),
                'p_BRANCH_ID' => $request->get('branch_id'),
                "p_SIGNATURE" => [
                    'value' => $request->post('signature'),
                    'type' => SQLT_CLOB,
                ],
                'p_SIGNATURE_TYPE' => $request->get('signature_type'),
                'p_INSERT_BY' => Auth::id(),
                'o_STATUS_CODE' => &$o_status_code,
                'o_STATUS_MESSAGE' => &$o_status_message,
            ];
            //dd($params);
             DB::executeProcedure('cpa_security.security.SEC_USERS_UPD', $params);
           DB::commit();
            return $params;
        } catch (Exception $e) {
      DB::rollback();
            return ["exception" => true, 'o_STATUS_CODE' => 999, 'o_STATUS_MESSAGE' => $e->getMessage()];
        }
    }

    public function updateUserPassword(Request $request)
    {
          try{
             $role_o_status_code = sprintf('%4000s', '');
             $role_o_status_message = sprintf('%4000s', '');

                    $param = [
                    'p_USER_ID' => $request->get('user_id'),
                    'p_NEW_PASSWORD' => $request->get('confirmPassword'),
                    'o_STATUS_CODE' => &$role_o_status_code,
                    'o_STATUS_MESSAGE' => &$role_o_status_message
                 ];
               DB::executeProcedure('cpa_security.SECURITY.user_reset_password', $param);
               return $param;
         }catch (Exception $e){
             return ["exception" => true, 'o_STATUS_CODE' => 999, 'o_STATUS_MESSAGE' => $e->getMessage()];
         }

    }
    public function remove(Request $request)
    {
        //TODO: Default template for action.
    }

    public function getUserData(Request $request, $id, Employee $employee, User $user, Role $role)
    {
        return [
             "employees" =>  $employee->find($id),
             "users" =>  $user->with('employee')->get(),
             "userTypes" => $this->userType(),
             "userRoles" => $role->where("active_yn", 'Y')->get()
        ];
    }
    public function userType(){
                $emp_type = new UserType();
                $emp_types = [];
//                $emp_types[] = ["text" => 'Select User Type', 'value' => null];
                 foreach ($emp_type->all() as $item) {
                    $emp_types[] = ["text" => $item->user_type_name, 'value' => $item->user_type_id];
                }
                 return $emp_types;
        }
    private function setUserPassword(Request $request)
    {
      // dd($request->all());
         try {
            $o_status_code = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');
            $o_user_id = sprintf('%4000s', '');

            $params = [
                'p_USER_NAME' => $request->get('user_name'),
                'p_USER_PASS' => $request->get('RetypePassword'),
                'p_USER_TYPE_ID' => $request->get('userType'),
                'p_INSERT_BY' => Auth::id(),
                'p_IS_ACTIVE' => $request->get('status'),
                'p_USER_REFERENCE_ID' => $request->get('referenceId'),
                'p_REFERENCE' => $request->get('reference'),
                'p_EMAIL' => $request->get('email'),
                'p_BANK_ID' => $request->get('bank_id'),
                'p_BRANCH_ID' => $request->get('branch_id'),
                "p_SIGNATURE" => [
                    'value' => $request->post('signature'),
                    'type' => SQLT_CLOB,
                ],
                'p_SIGNATURE_TYPE' => $request->get('signature_type'),
                'o_USER_ID' => [
                      "value" => &$o_user_id,
                      "type" => \PDO::PARAM_INT,
                      "length" => 255
                  ],
                'o_STATUS_CODE' => &$o_status_code,
                'o_STATUS_MESSAGE' => &$o_status_message,
            ];
            //dd($params);
             DB::executeProcedure('cpa_security.security.SEC_USERS_INS', $params);
            //dd($request->get('userRole'));

            return $params;
        } catch (Exception $e) {
            return ["exception" => true, 'o_STATUS_CODE' => 999, 'o_STATUS_MESSAGE' => $e->getMessage()];
        }
    }
    public function createUserRoleAssign(Request $request)
    {
       // dd($request->all());
         DB::beginTransaction();
        try {
            //dd($request->get('userRole'));
                $user_id = $request->get('user_id');
                foreach ($request->all() as $userRole){
                    $role_o_status_code = sprintf('%4000s', '');
                    $role_o_status_message = sprintf('%4000s', '');
                     $o_userRole_id = sprintf('%4000s', '');
                     $fromDate = $userRole['fromDate'] ? date("d-m-Y", strtotime($userRole['fromDate'])) : '';
                     $toDate = $userRole['toDate'] ? date("d-m-Y", strtotime($userRole['toDate'])) : '';
                    $roleMap = [
                    'p_USER_ROLE_ID' =>  null,
                    'p_USER_ID' => '2001110118',
                    'p_ROLE_ID' => $userRole['userRole']['role_id'],
                    'p_ACTIVATE_FROM' => $fromDate,  //$userRole['fromDate'],
                    'p_ACTIVATE_TO' => $toDate, //$userRole['toDate'],
                    'p_ACTIVE_YN' => 'Y',
                    'p_INSERT_BY' => Auth::id(),
                    'o_STATUS_CODE' => &$role_o_status_code,
                    'o_STATUS_MESSAGE' => &$role_o_status_message
                 ];

                   //dd($roleMap);
                   DB::executeProcedure('cpa_security.authorization.user_role_mapping', $roleMap);

                  if(!$roleMap['o_STATUS_CODE'] == 1){
                       DB::rollback();
                  }
              }

            DB::commit();
            return $roleMap;
        } catch (Exception $e) {
            DB::rollback();
            return ["exception" => true, 'o_STATUS_CODE' => 999, 'o_STATUS_MESSAGE' => $e->getMessage()];
        }
    }
    public function getEmpInfo(Request $request, $id,EmployeeContract $employeeContract, User $user)
    {
       /* $userId = [];
        $users = $user->all();
        foreach ($users as $employee){
            if ($employee->emp_id == null){
                    continue;
            }
            $userId[] = $employee->emp_id;
        }*/


        $data = DB::select("SELECT e.emp_id,
         e.emp_code,
         e.emp_code || ' ' || emp_name AS option_name,
         e.emp_name,
         e.designation_id,
         e.dpt_department_id,
         e.section_id,
         e.bill_code,
         e.dpt_division_id,
         u.email,
         d.department_name,
         dv.dpt_division_name,
         dg.designation,
         s.dpt_section,
         u.user_name
    FROM employee e
         LEFT JOIN cpa_security.sec_users u ON u.emp_id = e.emp_id
         LEFT JOIN l_department d ON e.dpt_department_id = d.DEPARTMENT_ID
         LEFT JOIN l_dpt_division dv ON e.dpt_division_id = dv.DPT_DIVISION_ID
         LEFT JOIN l_designation dg ON dg.DESIGNATION_ID = e.designation_id
         LEFT JOIN l_dpt_section s ON s.DPT_SECTION_ID = e.section_id
   WHERE     u.emp_id IS NULL
         AND (   LOWER (emp_name) LIKE
                    LOWER ('%' || NVL ( :name, emp_name) || '%')
              OR emp_code LIKE '%' || NVL ( :name, emp_code) || '%')
         AND ROWNUM <= 20
ORDER BY emp_name",['name'=>$id]);




        return [
            "empcodeList" =>  $data
        ];
/*
          return [
            "empcodeList" =>  $employeeContract->securityEmployeeOption($id,$userId)
        ];*/
    }

}
