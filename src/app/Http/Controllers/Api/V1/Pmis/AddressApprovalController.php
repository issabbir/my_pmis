<?php


namespace App\Http\Controllers\Api\V1\Pmis;


use App\Entities\Pmis\Employee\EmpAddressTemp;
use App\Entities\Pmis\Employee\EmpContactTemp;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmpNominee;
use App\Entities\Security\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddressApprovalController extends Controller
{
    public function unapprovedAddressList(Request $request){
        $sql = "SELECT A.EMP_ADDRESS_ID,
               E.EMP_ID,
               E.EMP_CODE,
               E.EMP_NAME,
               A.ADDRESS_LINE_1,
               A.POST_CODE,
               A.HOLD_YN,
               AT.ADDRESS_TYPE,
               DV.GEO_DIVISION_NAME,
               GD.GEO_DISTRICT_NAME,
               TH.GEO_THANA_NAME,
               case
       when A.update_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=A.update_by)
       when A.insert_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=A.insert_by)
       else '' end last_updated_by
        FROM EMP_ADDRESSES_TEMP A
                 JOIN EMPLOYEE E ON A.EMP_ID = E.EMP_ID
                 LEFT JOIN L_ADDRESS_TYPE AT
                           ON AT.ADDRESS_TYPE_ID = A.ADDRESS_TYPE_ID
                 LEFT JOIN L_GEO_DIVISION DV
                           ON DV.GEO_DIVISION_ID = A.DIVISION_ID
                 LEFT JOIN L_GEO_DISTRICT GD
                           ON GD.GEO_DISTRICT_ID = A.DISTRICT_ID
                 LEFT JOIN L_GEO_THANA TH
                           ON TH.GEO_THANA_ID = A.THANA_ID
        WHERE A.APPROVED_YN = 'N' AND E.APPROVED_YN = 'Y' AND E.EMP_ID = NVL (:id, E.EMP_ID)
        ORDER BY E.EMP_NAME, AT.ADDRESS_TYPE";
        return DB::select($sql, ['id'=>$request->get('emp_id')]);
    }

    public function updateAddressTemp($id, $holdYN){
        try {
            $statusCode = sprintf('%20f', '');
            $statusMessage = sprintf('%4000s', '');
            $params = [
                'p_emp_address_id' => $id,
                'p_hold_yn' => $holdYN,
                'p_insert_by' => Auth::id(),
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage
            ];

            DB::executeProcedure('employees.emp_address_hold_entry', $params);

        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        return $params;
    }

    public function approveAddress(Request $request){
        $params = [];
        //dd($request->get('items'));
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
                DB::executeProcedure('employees.emp_address_approve', $params);

                if($item['emp_id'] != null ){
                    $user_id = User::where('emp_id', $item['emp_id'])->value('user_id');
                    $user_notification = [
                        "p_notification_to" => $user_id,
                        "p_insert_by" => Auth::id(),
                        "p_note" => 'Your new contact has been approved.',
                        "p_priority" => null,
                        "p_module_id" => 1,
                        "p_target_url" => "my-account#/address"
                    ];
                    DB::executeProcedure("cpa_security.cpa_general.notify_add", $user_notification);
                }
                $insert_by = EmpAddressTemp::where('emp_address_id', $item['emp_address_id'])->value('insert_by');
                if($user_id != $insert_by){
                    $emp_name = Employee::where('emp_id', $item['emp_id'])->value('emp_name');
                    $operator_notification = [
                        "p_notification_to" => $insert_by,
                        "p_insert_by" => Auth::id(),
                        "p_note" => 'New contact has been approved for '.$emp_name.'.',
                        "p_priority" => null,
                        "p_module_id" => 1,
                        "p_target_url" => "pmis#/employee/address/".$item['emp_id']
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
