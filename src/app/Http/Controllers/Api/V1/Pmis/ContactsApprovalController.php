<?php


namespace App\Http\Controllers\Api\V1\Pmis;


use App\Entities\Pmis\Employee\EmpContactTemp;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmpNominee;
use App\Entities\Security\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContactsApprovalController extends Controller
{
    public function unapprovedContactList(Request $request){
        $sql = "SELECT C.EMP_CONTACTS_ID,
         E.EMP_ID,
         E.EMP_CODE,
         E.EMP_NAME,
         C.EMP_CONTACT_INFO,
         CT.EMP_CONTACT_TYPE,
         C.HOLD_YN,
           case
       when C.update_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=C.update_by)
       when C.insert_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=C.insert_by)
       else '' end last_updated_by
    FROM EMP_CONTACTS_TEMP C
         JOIN EMPLOYEE E ON C.EMP_ID = E.EMP_ID
         LEFT JOIN L_CONTACT_TYPE CT
            ON CT.EMP_CONTACT_TYPE_ID = C.EMP_CONTACT_TYPE_ID
   WHERE C.APPROVED_YN = 'N' AND E.APPROVED_YN = 'Y' AND E.EMP_ID = NVL (:id, E.EMP_ID)
ORDER BY EMP_NAME, CT.EMP_CONTACT_TYPE";
        return DB::select($sql, ['id'=>$request->get('emp_id')]);
    }

    public function updateContactTemp($id, $holdYN){
        try {
            $statusCode = sprintf('%20f', '');
            $statusMessage = sprintf('%4000s', '');
            $params = [
                'p_emp_contacts_id' => $id,
                'p_hold_yn' => $holdYN,
                'p_insert_by' => Auth::id(),
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage
            ];

            DB::executeProcedure('employees.emp_contact_hold_entry', $params);

        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        return $params;
    }

    public function approveContact(Request $request){
        try {

            foreach ($request->get('items') as $item) {
                $statusCode = sprintf('%20f', '');
                $statusMessage = sprintf('%4000s', '');
                $params = [
                    'p_emp_id' => $item['emp_id'],
                    'p_insert_by' => Auth::id(),
                    'o_status_code' => &$statusCode,
                    'o_status_message' => &$statusMessage
                ];
 //               dd($item);
                DB::executeProcedure('employees.emp_contact_approve', $params);



                if($item['emp_id'] != null ){
                    $user_id = User::where('emp_id', $item['emp_id'])->value('user_id');
                    $user_notification = [
                        "p_notification_to" => $user_id,
                        "p_insert_by" => Auth::id(),
                        "p_note" => 'Your new contact has been approved.',
                        "p_priority" => null,
                        "p_module_id" => 1,
                        "p_target_url" => "my-account#/contact"
                    ];
                    DB::executeProcedure("cpa_security.cpa_general.notify_add", $user_notification);
                }
                $insert_by = EmpContactTemp::where('emp_contacts_id', $item['emp_contacts_id'])->value('insert_by');
                if($user_id != $insert_by){
                    $emp_name = Employee::where('emp_id', $item['emp_id'])->value('emp_name');
                    $operator_notification = [
                        "p_notification_to" => $insert_by,
                        "p_insert_by" => Auth::id(),
                        "p_note" => 'New contact has been approved for '.$emp_name.'.',
                        "p_priority" => null,
                        "p_module_id" => 1,
                        "p_target_url" => "pmis#/employee/contacts/".$item['emp_id']
                    ];
                    DB::executeProcedure("cpa_security.cpa_general.notify_add", $operator_notification);
                }
            }
        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        return $params;
    }
}
