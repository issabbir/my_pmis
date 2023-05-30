<?php

namespace App\Http\Controllers\Api\V1\Admin\SystemSetup;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\SecIpAllowed;
use App\Entities\Admin\SecUser;
use App\Entities\Pmis\Employee\EmpEducationTemp;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmployeeTemp;
use App\Entities\Security\IpAllowed;
use App\Entities\Security\User;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;

class UserIpAssignController extends Controller
{
    protected $adminManager;

    public function __construct(AdminContract $adminManager) {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {

    }
    public function getData() {
        $getUserData = new EmployeeTemp();

        $adminManager = $this->adminManager;
        return [
            "data" => $getUserData->get(),

        ];
    }

    public function view($id, Request $request) {
       $user = new User();
       $user = $user->where('emp_id',$id)->first();
        return [
            "data" => $user->allowedIPs()->get()
        ];
    }

    public function getAssignUserData(Request $request,$id, User $user, IpAllowed $ipAllowed)
    {
          return [
            'user' => $user->with('employee')->find($id),
            'ipList' => $ipAllowed->with('user')->where('user_id',$id)->get()
         ];

    }

    public function store(Request $request)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");

            $params = [

                "p_USER_ID" => $request->get("user_id"),
                "p_ALLOWED_IP" => $request->get("allowed_ip"),
                "p_INSERT_BY" => Auth::id(),
                "o_STATUS_CODE" => &$status_code,
                "o_STATUS_MESSAGE" => &$status_message,
            ];
            DB::executeProcedure("CPA_SECURITY.SECURITY.users_allowed_ip", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_STATUS_CODE" => 999, "o_STATUS_MESSAGE" => $e->getMessage()];
        }

        return $params;
    }

    public function update(Request $request)
    {

    }

    public function remove(Request $request,$id,$ip)
    {
        if ($id > 0) {
            try {
                $o_status_code = sprintf('%4000s', '');
                $o_status_message = sprintf('%4000s', '');
                $user_id = $id;
                $allowed_ip=$ip;
                $params = [
                    "p_USER_ID" => $user_id,
                    "p_ALLOWED_IP" => $allowed_ip,
                    'o_STATUS_CODE' => &$o_status_code,
                    'o_STATUS_MESSAGE' => &$o_status_message,
                ];
                DB::executeProcedure("CPA_SECURITY.SECURITY.user_delete_ip", $params);
                return $params;
            } catch (Exception $e) {
                return ["exception" => true, 'o_STATUS_CODE' => 999, 'o_STATUS_MESSAGE' => $e->getMessage()];
            }
        } else {
            return ["exception" => false, 'o_STATUS_CODE' => 999, 'o_STATUS_MESSAGE' => 'Not deleted!'];
        }

        return $this->getData();
    }
}
