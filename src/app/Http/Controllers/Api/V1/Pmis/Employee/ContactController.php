<?php

namespace App\Http\Controllers\Api\V1\Pmis\Employee;

use App\Entities\Pmis\Employee\EmpFamilyTemp;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Security\Role;
use App\Entities\Security\User;
use App\Entities\Security\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\Pmis\Employee\EmpContactTemp;
use Exception;
use App\Contracts\Admin\AdminContract;
use App\Managers\Admin\AdminManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;

class ContactController extends Controller
{
    /** @var AdminManager */
    private $adminManager;

    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        return $this->getData();
    }
    public function holdContact($id, $holdYN){

        try {
            $family = new EmpContactTemp();
            $family->exists = true;
            $family->emp_contacts_id = $id;
            $family->hold_yn = $holdYN;
            $family->save();
        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'o_status_message' => $e->getMessage()];
        }
        return [
            'status' => true,
            'o_status_message' => 'Nominee status changes successfully',
            'nominee' => $family
        ];
    }

    public function approveContact(Request $request){
        try {
            $statusCode = sprintf('%20f', '');
            $statusMessage = sprintf('%4000s', '');
            $params = [
                'p_emp_id' => $request->get('emp_id'),
                'p_insert_by' => Auth::id(),
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage
            ];
            dd($params);

            DB::executeProcedure('employees.emp_contact_approve', $params);

        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        return $params;
    }
    public function unapprovedContact(Request $request) {

        $empId = $request->get('emp_id');
        $sql = "select * from emp_contacts_temp where EMP_ID = nvl(:empId, EMP_ID) AND APPROVED_YN='N'";
        return $list = DB::select($sql, ['empId' => $empId]);
    }

    public function specific(Request $request, $id)
    {
        $contact = new EmpContactTemp();
        $adminManager = $this->adminManager;
        $contacts = $contact
            ->select('emp_contacts_id', 'emp_contact_type_id', 'emp_contact_info','insert_by','update_by','approved_yn')
            ->where('emp_id', $id)
            ->orderBy('emp_contacts_id', 'desc')->get();

        return [
            'contact' => $adminManager->findContactType(),
            'data' => $contacts
        ];
    }

    public function getData()
    {
        $adminManager = $this->adminManager;

        return [
            'contact' => $adminManager->findContactType()
        ];
    }

    public function view(Request $request)
    {
        $contact = new EmpContactTemp();

        return $contact->find($request->id);
    }

    public function store(Request $request)
    {
        return $this->employees_create_new_contact($request);
    }

    public function update(Request $request, $id)
    {
        if ($id > 0) {
            return $this->employees_create_new_contact($request, $id);
        } else {
            return ["exception" => false, 'status' => false, 'message' => 'Not updated!'];
        }
    }

    public function remove(Request $request, $id)
    {
        if ($id > 0) {
            return $this->employees_delete_new_contact($request, $id);
        } else {
            return ["exception" => false, 'status' => false, 'message' => 'Not deleted!'];
        }
    }

    public function employees_create_new_contact(Request $request)
    {
        try {
            $emp_contacts_id = $request->get("emp_contacts_id");
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");

            $params = [
                "emp_contacts_id" => [
                    "value" => &$emp_contacts_id,
                    "type" => \PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                "emp_id" => $request->get('emp_id'),
                "emp_contact_type_id" => $request->get("emp_contact_type_id"),
                "emp_contact_info" => $request->get("emp_contact_info"),
                "effective_yn" => '',
                'approved_yn' => $request->get('approved_yn'),
                "insert_by" => Auth::id(),
                "update_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];

            DB::executeProcedure("EMPLOYEES.CREATE_NEW_CONTACT", $params);

            if($request->get('emp_id') != null ){
                $user_id = User::where('emp_id', $request->get('emp_id'))->value('user_id');
                $user_notification = [
                    "p_notification_to" => $user_id,
                    "p_insert_by" => Auth::id(),
                    "p_note" => 'Your new contact has been sent for approval.',
                    "p_priority" => null,
                    "p_module_id" => 1,
                    "p_target_url" => "my-account#/contact"
                ];
                DB::executeProcedure("cpa_security.cpa_general.notify_add", $user_notification);
            }

            $role_id = Role::where('role_key', 'PMIS APPROVAL')->value('role_id');
            $user_roles = UserRole::where('role_id', $role_id)->get();
            $emp_name = Employee::where('emp_id', $request->get('emp_id'))->value('emp_name');
            foreach ($user_roles as $user_role){
                $operator_notification = [
                    "p_notification_to" => $user_role->user_id,
                    "p_insert_by" => Auth::id(),
                    "p_note" => 'New contact enlisted for '.$emp_name.'. Your approval require.',
                    "p_priority" => null,
                    "p_module_id" => 1,
                    "p_target_url" => "pmis#/contact-approval"
                ];
                DB::executeProcedure("cpa_security.cpa_general.notify_add", $operator_notification);
            }
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    public function employees_delete_new_contact(Request $request, $id)
    {
        if ($id > 0) {
            try {
                $o_status_code = sprintf('%4000s', '');
                $o_status_message = sprintf('%4000s', '');
                $emp_contacts_id = $id;

                $params = [
                    'emp_contacts_id' => [
                        'value' => &$emp_contacts_id,
                        "type" => PDO::PARAM_INPUT_OUTPUT,
                        "length" => 255
                    ],
                    'o_status_code' => &$o_status_code,
                    'o_status_message' => &$o_status_message,
                ];

                DB::executeProcedure('EMPLOYEES.DELETE_NEW_CONTACT', $params);
                return $params;
            } catch (Exception $e) {
                return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
            }
        } else {
            return ["exception" => false, 'status' => false, 'message' => 'Not deleted!'];
        }
    }
}
