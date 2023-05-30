<?php


namespace App\Http\Controllers\Api\V1\Pmis;


use App\Entities\Pmis\Employee\EmpAddressTemp;
use App\Entities\Pmis\Employee\EmpContactTemp;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmpNominee;
use App\Entities\Pmis\Employee\EmpTrainingTemp;
use App\Entities\Security\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TraningApprovalController extends Controller
{
    public function unapprovedTraningList(Request $request){
        $sql = "SELECT ET.TRAINING_ID,
               E.EMP_ID,
               E.EMP_CODE,
               E.EMP_NAME,
               LT.TRAINING_TYPE,
               LC.COUNTRY,
               ET.TRAINING_NAME,
               ET.TRAINING_INSTITUTE,
               ET.TRAINING_ACHEIVMENT,
               ET.TRAINING_DURATION,
               ET.TRAINING_COMPLETION_DATE,
               ET.TRAINING_START_DATE,
               ET.APPROVED_YN,
               case
       when ET.update_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=ET.update_by)
       when ET.insert_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=ET.insert_by)
       else '' end last_updated_by
        FROM EMP_TRAINING_TEMP ET
                 JOIN EMPLOYEE E ON ET.EMP_ID = E.EMP_ID
                 LEFT JOIN L_TRAINING_TYPE LT
                           ON LT.TRAINING_TYPE_ID = ET.TRAINING_TYPE_ID
                 LEFT JOIN L_GEO_COUNTRY LC
                           ON LC.COUNTRY_ID = ET.TRAINIG_COUNTRY_ID
        WHERE ET.APPROVED_YN = 'N' AND E.APPROVED_YN = 'Y' AND E.EMP_ID = NVL (:id, E.EMP_ID)
        ORDER BY E.EMP_NAME";
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

            DB::executeProcedure('employees.emp_training_hold_entry', $params);

        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        return $params;
    }

    public function approveTraning(Request $request){
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
                DB::executeProcedure('employees.emp_training_approve', $params);

                if($item['emp_id'] != null ){
                    $user_id = User::where('emp_id', $item['emp_id'])->value('user_id');
                    $user_notification = [
                        "p_notification_to" => $user_id,
                        "p_insert_by" => Auth::id(),
                        "p_note" => 'Your new contact has been approved.',
                        "p_priority" => null,
                        "p_module_id" => 1,
                        "p_target_url" => "my-account#/training"
                    ];
                    DB::executeProcedure("cpa_security.cpa_general.notify_add", $user_notification);
                }
                $insert_by = EmpTrainingTemp::where('training_id', $item['training_id'])->value('insert_by');
                if($user_id != $insert_by){
                    $emp_name = Employee::where('emp_id', $item['emp_id'])->value('emp_name');
                    $operator_notification = [
                        "p_notification_to" => $insert_by,
                        "p_insert_by" => Auth::id(),
                        "p_note" => 'New contact has been approved for '.$emp_name.'.',
                        "p_priority" => null,
                        "p_module_id" => 1,
                        "p_target_url" => "pmis#/employee/training/".$item['emp_id']
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
