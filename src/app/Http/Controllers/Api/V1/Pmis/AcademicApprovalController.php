<?php


namespace App\Http\Controllers\Api\V1\Pmis;


use App\Entities\Pmis\Employee\EmpAcademicTemp;
use App\Entities\Pmis\Employee\EmpAddressTemp;
use App\Entities\Pmis\Employee\EmpContactTemp;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmpNominee;
use App\Entities\Security\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AcademicApprovalController extends Controller
{
    public function unapprovedAcademicList(Request $request){
        $sql = "SELECT ED.EMP_EDUCATION_ID,
               E.EMP_ID,
               E.EMP_CODE,
               E.EMP_NAME,
               E.UPDATE_DATE,
               LD.EXAM_BODY_NAME,
               LE.EXAM_RESULT_TYPE,
               LER.EXAM_RESULT,
               ED.INSTITUTE_NAME,
               ED.EXAM_RESULT,
               ED.PASSING_YEAR,
               ED.RESULT_TYPE,
               ED.SUBJECT,
               ED.APPROVED_YN,
               case
       when ED.update_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=ED.update_by)
       when ED.insert_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=ED.insert_by)
       else '' end last_updated_by
        FROM EMP_EDUCATION_TEMP ED
                 JOIN EMPLOYEE E ON ED.EMP_ID = E.EMP_ID
                 LEFT JOIN L_EXAM_BODY LD
                           ON LD.EXAM_BODY_ID = ED.EXAM_BODY_ID
                 LEFT JOIN L_EXAM_RESULT_TYPE LE
                           ON LE.EXAM_RESULT_TYPE_ID = ED.EXAM_RESULT_TYPE_ID
                 LEFT JOIN L_EXAM_RESULT LER
                           ON LER.EXAM_RESULT_ID = ED.EXAM_RESULT_ID
        WHERE ED.APPROVED_YN = 'N' AND E.APPROVED_YN = 'Y' AND E.EMP_ID = NVL (:id, E.EMP_ID)
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

            DB::executeProcedure('employees.emp_education_hold_entry', $params);

        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        return $params;
    }

    public function approveAcademic(Request $request){
        $params = [];
        // dd($request->get('items'));
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
 //               dd($params);
                DB::executeProcedure('employees.emp_education_approve', $params);


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
                $insert_by = EmpAcademicTemp::where('emp_education_id', $item['emp_education_id'])->value('insert_by');
                if($user_id != $insert_by){
                    $emp_name = Employee::where('emp_id', $item['emp_id'])->value('emp_name');
                    $operator_notification = [
                        "p_notification_to" => $insert_by,
                        "p_insert_by" => Auth::id(),
                        "p_note" => 'New contact has been approved for '.$emp_name.'.',
                        "p_priority" => null,
                        "p_module_id" => 1,
                        "p_target_url" => "pmis#/employee/education/".$item['emp_id']
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
