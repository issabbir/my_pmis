<?php


namespace App\Http\Controllers\Api\V1\Pmis;


use App\Entities\Pmis\Employee\EmpAddressTemp;
use App\Entities\Pmis\Employee\EmpContactTemp;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmpNominee;
use App\Entities\Pmis\Employee\EmpTourTemp;
use App\Entities\Security\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TourApprovalController extends Controller
{
    public function unapprovedTourList(Request $request){
        $sql = "SELECT ET.TOUR_ID,
               E.EMP_ID,
               E.EMP_CODE,
               E.EMP_NAME,
               LT.TOUR_TYPE,
               LC.COUNTRY,
               ET.TOUR_NAME,
               ET.TOUR_PURPOSE,
               ET.INSERT_DATE,
               ET.RETURN_DATE,
               ET.TOUR_DURATION,
               ET.SPONSOR,
               ET.APPROVED_YN,
               case
       when ET.update_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=ET.update_by)
       when ET.insert_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=ET.insert_by)
       else '' end last_updated_by
        FROM EMP_TOURS ET
                 JOIN EMPLOYEE E ON ET.EMP_ID = E.EMP_ID
                 LEFT JOIN L_TOUR_TYPE LT
                           ON LT.TOUR_TYPE_ID = ET.TOUR_TYPE_ID
                 LEFT JOIN L_GEO_COUNTRY LC
                           ON LC.COUNTRY_ID = ET.COUNTRY_ID
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

            DB::executeProcedure('employees.emp_tour_hold_entry', $params);

        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        return $params;
    }

    public function approveTour(Request $request){
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
                DB::executeProcedure('employees.emp_tour_approve', $params);

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
                $insert_by = EmpTourTemp::where('tour_id', $item['tour_id'])->value('insert_by');
                if($user_id != $insert_by){
                    $emp_name = Employee::where('emp_id', $item['emp_id'])->value('emp_name');
                    $operator_notification = [
                        "p_notification_to" => $insert_by,
                        "p_insert_by" => Auth::id(),
                        "p_note" => 'New contact has been approved for '.$emp_name.'.',
                        "p_priority" => null,
                        "p_module_id" => 1,
                        "p_target_url" => "pmis#/employee/tour/".$item['emp_id']
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
