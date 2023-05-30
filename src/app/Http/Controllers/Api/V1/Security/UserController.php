<?php

namespace App\Http\Controllers\Api\V1\Security;

use App\Entities\Pmis\Employee\Employee;
use App\Entities\Security\Submenu;
use App\Entities\Security\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getPermissions(Submenu $submenu)
    {
        $user = auth()->user();
        $reportingOfficerId = '';
        if ($user->emp_id) {
            $employee = Employee::find($user->emp_id);
            $reportingOfficerId = $employee->reporting_officer_id;
        }

        $menus = array();
        $userRoleMenus = $user->getRoleMenus();

        if ($userRoleMenus) {
            foreach ($userRoleMenus as $menu) {
                $_submenus = $submenu->find($menu->role_submenus);
                if ($_submenus) {
                    foreach ($_submenus as $submenu) {
                        $menus[] = $submenu->action_name;
                    }
                }
            }
        }

        $dpt_department_id = isset($user->employee) && $user->employee ? $user->employee->dpt_department_id : '';

        return [
            "user_roles"        => $user->getRoles(),
            "user_permissions"  => array_values( $user->getPermissions()),
            "user_menus"        => $menus,
            "user_reports"      => $user->getReports(),
            'grant_access'      => $user->hasGrantAll(),
            'reporting_empId'   => $reportingOfficerId,
            'user' => ['user_name' => $user->user_name, 'emp_id' => $user->emp_id, 'department_id' => $dpt_department_id]
        ];
    }
}
