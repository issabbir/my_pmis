<?php


namespace App\Http\Controllers\Api\V1\Admin\SystemSetup;


use App\Contracts\Admin\AdminContract;
use App\Entities\Security\Menu;
use App\Entities\Security\Module;
use App\Entities\Security\Permission;
use App\Entities\Security\Report;
use App\Entities\Security\Role;
use App\Entities\Security\Submenu;
use App\Entities\Security\User;
use App\Entities\Security\UserRole;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use App\Traits\Security\HasUserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoleMenuMapController extends Controller
{
    protected $adminManager;

    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    private $module = 'MODULE#';
    private $menu = 'MENU#';
    private $submenu = 'SUBMENU#';
    private $subsubmenu = 'SUBSUBMENU#';

    public function index($roleId, Request $request)
    {
        $menus = [];
        return [
            'menus'  => $menus,
            'permission'  => [],
            'report'  => [],
            'users' => [],
        ];
    }

    /**
     * ACL
     *
     * @param $roleId
     * @param Role $role
     * @return array
     */
    public function acl($roleId, Role  $role, Module $module) {
        $role = $role->find($roleId);
        $roleMenus = $role->menus;
        $subMenus = [];
        $menus = [];
        foreach ($roleMenus as $menu) {
            $subMenus[$menu->menu_id] = isset($subMenus[$menu->menu_id]) ? array_merge($subMenus[$menu->menu_id], json_decode($menu->pivot->submenus)) : json_decode($menu->pivot->submenus);
            $menu->role_submenus = $subMenus[$menu->menu_id];
            $menus[$menu->menu_id] = $menu;
        }
        $allMenus = Menu::orderBy('menu_order_no')->get();
        $resources = [];
        foreach ($allMenus as $amenu) {
            if (isset($menus[$amenu->menu_id])) {
                $amenu->permitted = true;
            }

            $submenus = [];
            foreach($amenu->sub_menus as $submenu) {
                if (isset($menus[$amenu->menu_id]) && in_array($submenu->submenu_id, $menus[$amenu->menu_id]->role_submenus)) {
                    $submenu->permitted = true;
                }
                if (count($submenu->submenus) > 0) {
                    $sub_submenus = [];
                    foreach ($submenu->submenus as $smenu) {
                        if (isset($menus[$amenu->menu_id]) && in_array($smenu->submenu_id, $menus[$amenu->menu_id]->role_submenus)) {
                            $smenu->permitted = true;
                        }
                        $sub_submenus[] = $smenu;
                    }
                }
                $submenus[] = $submenu;
            }

            $resources[] = $amenu;
        }

        $users = [];

        $exceptRoles = ['HA APPLICANT', 'MY_ACCOUNT'];
        if (!in_array(strtoupper($role->role_key), $exceptRoles)) {
            foreach ($role->users as $user) {
                /*if ($user && $user->employee) {
                    $user->makeHidden(['signature'])->employee->makeHidden(['auth_document', 'emp_photo']);
                }*/
                if ($user) {
                    $user->makeHidden(['signature']);
                    if($user->employee){
                        $user->makeHidden(['signature'])->employee->makeHidden(['auth_document', 'emp_photo']);
                    }
                    $users[] = $user;
                }
            }
        }
//        $role->users->chunk(100, function($users_data){
//            dd($users_data);
//            foreach ($users_data as $user) {
//                $user->employee;
//                $users[] = $user;
//            }
//        });
        return [
            'resources' => $resources,
            "permissions" => $this->permissions($role, $module),
            "reports" => $this->reports($role, $module),
            "users" => $users
        ];
    }
    private  function permissions(Role  $role, Module $module) {
        $_modules = $module->get();

        $_permissions = $role->permissions;
        $mappedPermissions = [];
        foreach ($_permissions as $permission) {
            $mappedPermissions[$permission->permission_id] = $permission->permission_id;
        }
        $modules = [];
        foreach ($_modules as $module) {
            if (count($module->permissions) > 0 && $_permissions = $module->permissions  ) {
                foreach ($_permissions as $permission) {
                    //Condition based on already assigned
                    if (isset($mappedPermissions[$permission->permission_id]))
                    $permission->permitted = true;
                }
                $modules[] = $module;
            }
        }

        return $modules;
    }

    private  function reports(Role  $role, Module $module) {
        $_modules = $module->get();

        $_reports = $role->reports;
        $mappedReports = [];
        foreach ($_reports as $reports) {
            $mappedReports[$reports->report_id] = $reports->report_id;
        }
        $modules = [];
        foreach ($_modules as $module) {
            if (count($module->reports) > 0 && $_reports = $module->reports  ) {
                foreach ($_reports as $report) {
                    //Condition based on already assigned
                    if (isset($mappedReports[$report->report_id]))
                        $report->permitted = true;
                }
                $modules[] = $module;
            }
        }

        return $modules;
    }

    /**
     * Assigning menu resources access
     *
     * @param $roleId
     * @param Request $request
     * @return array
     */
    public function postAcl($roleId, Request $request) {
        DB::beginTransaction();
        $menus = $request->all();
        $status_code = sprintf("%4000s","");
        $status_message = sprintf("%4000s","");
        $params = [
            "p_ROLE_ID" => $roleId,
            "p_insert_by" => auth()->id(),
            "o_status_code" => &$status_code,
            "o_status_message" => &$status_message
        ];
        DB::executeProcedure("cpa_security.authorization.sec_role_menu_del", $params);
        if ($params['o_status_code'] == 1) {
            foreach ($menus as $menu) {
                if (isset($menu['permitted']) && $menu['permitted']) {
                    $psmenu = [];
                    if ($sub_menus = $menu['sub_menus']) {
                        foreach ($sub_menus as $sub_menu) {
                            if (isset($sub_menu['permitted']) && $sub_menu['permitted']) {
                                $psmenu[] = $sub_menu['submenu_id'];
                                if ($submenus = $sub_menu['submenus']) {
                                    foreach ($submenus as $submenu) {
                                        if (isset($submenu['permitted']) && $submenu['permitted']) {
                                            $psmenu[] = $submenu['submenu_id'];
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $params = $this->saveResources($roleId, $menu['menu_id'], json_encode($psmenu));
                    if (!($params && $params['o_status_code'] == 1)) {
                        DB::rollBack();
                        return $params;
                    }
                }
            }
            DB::commit();
            return ['o_status_code' => 1, 'o_status_message' =>"Assigned success"];
        }
        DB::rollBack();
        return $params;
    }

    public function postReportAcl($roleId, Request $request) {
        DB::beginTransaction();
        try {
            $modules = $request->all();

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_ROLE_ID" => $roleId,
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message
            ];
            DB::executeProcedure("cpa_security.authorization.role_report_del", $params);
            if ($params['o_status_code'] == 1) {
                foreach($modules as $module) {
                    $reports = $module['reports'];
                    foreach($reports as $report) {
                        if(isset($report['permitted']) && $report['permitted']) {
                            $params = $this->saveReportPermission($roleId, $report['report_id']);
                            if (!($params && $params['o_status_code'] == 1)) {
                                DB::rollBack();
                                return $params;
                            }
                        }

                    }
                }
                DB::commit();
                return ['o_status_code' => 1, 'o_status_message' =>"Assigned success"];
            }

        } catch(\Exception $exception) {
            DB::rollBack();
            return $params;
        }

    }

    private function saveReportPermission($roleId, $reportId)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_ROLE_ID" => $roleId,
                'p_REPORT_ID' => $reportId,
                'p_ACTIVE_YN' => "Y",
                'p_insert_by' => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message
            ];
            DB::executeProcedure("cpa_security.authorization.role_report_mapping", $params);
            return $params;
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" =>99, 'o_status_message' => "Something went wrong", 'exception_message' => $e->getMessage()];
        }
    }

    public function postPermissionAcl($roleId, Request $request) {
        DB::beginTransaction();
        try {
            $modules = $request->all();

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_ROLE_ID" => $roleId,
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message
            ];
            DB::executeProcedure("cpa_security.authorization.role_permission_del", $params);
            if ($params['o_status_code'] == 1) {
                foreach($modules as $module) {
                    $permissions = $module['permissions'];
                    foreach($permissions as $permission) {
                        if(isset($permission['permitted']) && $permission['permitted']) {
                            $params = $this->savePermission($roleId, $permission['permission_id']);
                            if (!($params && $params['o_status_code'] == 1)) {
                                DB::rollBack();
                                return $params;
                            }
                        }

                    }
                }
                DB::commit();
                return ['o_status_code' => 1, 'o_status_message' =>"Assigned success"];
            }
        } catch(\Exception $exception) {
            DB::rollBack();
            return $params;
        }
    }

    private function savePermission($roleId, $permissionId)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_ROLE_ID" => $roleId,
                'p_PERMISSION_ID' => $permissionId,
                'p_insert_by' => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message
            ];
            DB::executeProcedure("cpa_security.authorization.role_permission_mapping", $params);
            return $params;
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" =>99, 'o_status_message' => "Something went wrong", 'exception_message' => $e->getMessage()];
        }
    }

    /**
     * Save
     * @param $roleId
     * @param $menuId
     * @param $submenus
     * @return array
     */
    private function saveResources($roleId, $menuId, $submenus) {
            try {
                    $status_code = sprintf("%4000s", "");
                    $status_message = sprintf("%4000s", "");
                    $params = [
                        "p_ROLE_ID" => $roleId,
                        'p_menu_id' => $menuId,
                        'p_active_yn' => "Y",
                        'p_insert_by' => auth()->id(),
                        'p_submenu' => $submenus,
                        "o_status_code" => &$status_code,
                        "o_status_message" => &$status_message
                    ];
                    DB::executeProcedure("cpa_security.authorization.sec_role_menu_entry", $params);
                    return $params;
            }
            catch (\Exception $e) {
                return ["exception" => true, "status" => false, "o_status_code" =>99, 'o_status_message' => "Something went wrong", 'exception_message' => $e->getMessage()];
            }
    }

    public function roles(Request $request){
        $roles = Role::where("active_yn", 'Y')->orderby("role_name","asc")->get();
        $roleData=[];
        foreach ($roles as $role) {
            $roleOtions = [];
            $roleOtions['text'] = $role->role_name;
            $roleOtions['value'] = $role;
            $roleData[] = $roleOtions;
        }
        return [
            'roles' => $roleData
        ];
    }
    public function roleSave(Request $request)
    {
        //dd($request->post());
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $p_role_id = '';
            $params = [
                "p_role_id" => $p_role_id,
                "p_role_name"        => $request->get("role_name"),
                "p_active_yn"        => 'Y',
                "p_insert_by"        => auth()->id(),
                "p_role_key"         => $request->get("role_key"),
                "p_grant_all_yn"     => 'N',
                "o_status_code"      => &$status_code,
                "o_status_message"   => &$status_message,
            ];
            DB::executeProcedure("CPA_SECURITY.AUTHORIZATION.sec_role_entry", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    /** For user role mapping */
    public function searchUser(Request $request, $name)
    {
        $user = new User();
        $userList = $user->select('user_id', 'user_name', 'user_name as option_name')->where(DB::raw('LOWER(user_name)'),'like',strtolower('%'.$name.'%'))->where('is_active', 'Y')->where('is_blocked', 'N')->limit(20)->get();

        return $userList;
    }

    public function fetchRoles(Request $request)
    {
        $roles = Role::where("active_yn", 'Y')->get();

        return $roles;
    }

    public function fetchUserRoles(Request $request, $userId)
    {
        $user = User::where('user_id', $userId)->first();

        $userRoles = $user->getRoles();
        $userRoleIds = [];
        $roles = Role::where("active_yn", 'Y')->get();

        if($userRoles) {
            foreach($userRoles as $userRole) {
                $userRoleIds[] = $userRole->role_id;
            }
        }

        return [
            'roles' => $roles,
            'userRoles' => $userRoles,
            'selectedUserRoles' => $userRoleIds,
            'employee' => $user->employee
        ];
    }

    public function saveUserRoles(Request $request)
    {
        $userId = $request->get('user_id');
        $user = User::find($userId);

        if ($userId) {
            DB::beginTransaction();

            try {
                $role_delete_o_status_code = sprintf('%4000s', '');
                $role_delete_o_status_message = sprintf('%4000s', '');
                $roleDelete = [
                    'p_USER_ID' => $userId,
                    'p_insert_by' => auth()->id(),
                    'o_STATUS_CODE' => &$role_delete_o_status_code,
                    'o_STATUS_MESSAGE' => &$role_delete_o_status_message
                ];

                DB::executeProcedure('cpa_security.authorization.user_role_mapp_del', $roleDelete);

                if ($roleDelete['o_STATUS_CODE'] == 1) {
                    $userRoles = $request->get('roles');

                    foreach ($userRoles as $userRole) {
                        $role_o_status_code = sprintf('%4000s', '');
                        $role_o_status_message = sprintf('%4000s', '');

                        $roleMap = [
                            'p_USER_ID' => $userId,
                            'p_ROLE_ID' => $userRole,
                            'p_ACTIVE_YN' => 'Y',
                            'p_inserted_BY' => Auth::Id(),
                            'o_STATUS_CODE' => &$role_o_status_code,
                            'o_STATUS_MESSAGE' => &$role_o_status_message
                        ];
                        DB::executeProcedure('cpa_security.authorization.user_role_mapping', $roleMap);

                        if (!$roleMap['o_STATUS_CODE'] == 1) {
                            DB::rollback();
                            return $roleMap;
                        }
                    }

                    DB::commit();
                    $user = User::find($userId);

                    return ['o_STATUS_CODE'=>1, 'o_STATUS_MESSAGE' => $roleMap['o_STATUS_MESSAGE'], 'roles' => $user->getRoles()];
                } else {
                    $user = User::find($userId);

                    DB::rollback();
                    return ["exception" => true, 'o_STATUS_CODE' => 999, 'o_STATUS_MESSAGE' => $roleDelete['o_STATUS_MESSAGE'], 'roles' => $user->getRoles()];
                }
            } catch (Exception $e) {
                DB::rollback();

                return ["exception" => true, 'o_STATUS_CODE' => 999, 'o_STATUS_MESSAGE' => $e->getMessage(), 'roles' => $user->getRoles()];
            }
        }
    }

    public function unAssignUserRole($role_id,$user_id) {

        $user = User::find($user_id);
        if ($user) {
            $userRole = $user->roles()->detach($role_id);
        }
        if($userRole) {
            $response = ['o_status_code' => 1, 'o_status_message' => 'USER ROLE UNASSIGN SUCCESSFULLY DONE'];
        }else{
            $response = ['o_status_code' => 99, 'o_status_message' => 'USER ROLE NOT FOUND'];
        }

        return $response;
    }
}
