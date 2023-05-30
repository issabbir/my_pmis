<?php


namespace App\Http\Controllers\Api\V1\Pmis;


use App\Entities\Pmis\Employee\EmpFamilyTemp;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Security\Role;
use App\Entities\Security\User;
use App\Entities\Security\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FamiliesApprovalController extends Controller
{
    public function unapprovedFamilyList(Request $request){
        if(Auth::user()->hasRole('all_approval')){
            $whereDepartment = '';
        }else{
            $department_id = Auth::user()->employee->dpt_department_id;
            $whereDepartment = "AND E.DPT_DEPARTMENT_ID = $department_id";
        }
        $sql = "SELECT F.EMP_MEMBER_NAME,
       F.EMP_MEMBER_NAME_BNG,
       F.RELATION_TYPE_ID,
       F.ADDRESS_LINE_1,
       F.EMP_MEMBER_DOB,
       F.EMP_MEMBER_MOBILE,
       F.AUTH_DOC_TYPE_ID,
       F.EMP_MEMBER_MEDICAL_ID,
       F.GENDER_ID,
       F.FAMILY_MEMBER_STATUS_ID,
       F.EMP_MEMBER_ALLOWANCE_YN,
       F.INSERT_BY,
       F.INSERT_DATE,
       F.UPDATE_DATE,
       F.UPDATE_BY,
       F.EMP_FAMILY_ID,
       F.AUTH_ID,
       F.ADDRESS_LINE_2,
       F.DISTRICT_ID,
       F.THANA_ID,
       F.POST_CODE,
       F.IS_NOMINEE_YN,
       F.APPROVED_YN,
       F.PERCENTAGE,
       F.HOLD_YN,
       F.MARITAL_STATUS_ID,
       F.AUTH_ATTACH_FILE_TYPE,
       F.AUTH_ATTACH_FILE_NAME,
       F.PHOTO_FILE_TYPE,
       F.PHOTO_FILE_NAME,
       E.EMP_ID,
       E.EMP_CODE,
       E.EMP_NAME,
       RT.RELATION_TYPE,
       G.GENDER_NAME,
       FMS.FAMILY_MEMBER_STATUS,
       case
       when f.update_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=f.update_by)
       when f.insert_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=f.insert_by)
       else '' end last_updated_by,
       CASE
          WHEN F.EMP_MEMBER_ALLOWANCE_YN = 'N' THEN 'NO'
          WHEN F.EMP_MEMBER_ALLOWANCE_YN = 'Y' THEN 'YES'
          ELSE ''
       END
          AS EMP_MEMBER_ALLOWANCE,
       DS.GEO_DISTRICT_NAME,
       TH.GEO_THANA_NAME,
       DT.AUTH_DOC_TYPE_NAME,
       MS.MARITIAL_STATUS
  FROM EMP_FAMILY_TEMP F
       JOIN EMPLOYEE E ON F.EMP_ID = E.EMP_ID
       LEFT JOIN L_RELATION_TYPE RT
          ON RT.RELATION_TYPE_ID = F.RELATION_TYPE_ID
       LEFT JOIN L_GENDER G ON G.GENDER_ID = F.GENDER_ID
       LEFT JOIN L_FAMILY_MEMBER_STATUS FMS
          ON FMS.FAMILY_MEMBER_STATUS_ID = F.FAMILY_MEMBER_STATUS_ID
       LEFT JOIN L_GEO_DISTRICT DS ON DS.GEO_DISTRICT_ID = F.DISTRICT_ID
       LEFT JOIN L_GEO_THANA TH ON TH.GEO_THANA_ID = F.THANA_ID
       LEFT JOIN L_AUTH_DOC_TYPE DT
          ON DT.AUTH_DOC_TYPE_ID = F.AUTH_DOC_TYPE_ID
       LEFT JOIN L_MARITIAL_STATUS MS
          ON MS.MARITIAL_STATUS_ID = F.MARITAL_STATUS_ID

 WHERE     F.APPROVED_YN = 'N'
       AND E.APPROVED_YN = 'Y'
       AND E.EMP_ID = NVL ( :ID, E.EMP_ID) $whereDepartment
ORDER BY E.EMP_NAME, F.EMP_MEMBER_NAME, RT.RELATION_TYPE";
        return DB::select($sql, ['id'=>$request->get('emp_id')]);
    }

    public function updateFamilyTemp($id, $holdYN){
        try {
            $statusCode = sprintf('%20f', '');
            $statusMessage = sprintf('%4000s', '');
            $params = [
                'p_emp_family_id' => $id,
                'p_hold_yn' => $holdYN,
                'p_insert_by' => Auth::id(),
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage
            ];

            DB::executeProcedure('employees.emp_family_hold_entry', $params);

        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        return $params;
    }


    public function approveFamily(Request $request){
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
                DB::executeProcedure('employees.emp_family_approve', $params);

                if($item['emp_id'] != null ){
                    $user_id = User::where('emp_id', $item['emp_id'])->value('user_id');
                    if($user_id){
                        $user_notification = [
                            "p_notification_to" => $user_id,
                            "p_insert_by" => Auth::id(),
                            "p_note" => 'Your new family member has been approved.',
                            "p_priority" => null,
                            "p_module_id" => 1,
                            "p_target_url" => "my-account#/family"
                        ];
                        DB::executeProcedure("cpa_security.cpa_general.notify_add", $user_notification);
                    }
                }
                $insert_by = EmpFamilyTemp::where('emp_family_id', $item['emp_family_id'])->value('insert_by');
                if($user_id != $insert_by){
                    if($insert_by){
                        $emp_name = Employee::where('emp_id', $item['emp_id'])->value('emp_name');
                        $operator_notification = [
                            "p_notification_to" => $insert_by,
                            "p_insert_by" => Auth::id(),
                            "p_note" => 'New family member approved for '.$emp_name.'.',
                            "p_priority" => null,
                            "p_module_id" => 1,
                            "p_target_url" => "pmis#/employee/family/".$item['emp_id']
                        ];
                        DB::executeProcedure("cpa_security.cpa_general.notify_add", $operator_notification);
                    }
                }
            }
        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        return $params;
    }
    public function approveSingleFamily(Request $request){
       // dd($request->all());
        try {
                $statusCode = sprintf('%20f', '');
                $statusMessage = sprintf('%4000s', '');
                $params = [
                    'p_emp_id' => $request->get('emp_id'),
                    'p_insert_by' => Auth::id(),
                    'o_status_code' => &$statusCode,
                    'o_status_message' => &$statusMessage
                ];
                DB::executeProcedure('employees.emp_family_approve', $params);

                if($request->get('emp_id') != null ){
                    $user_id = User::where('emp_id', $request->get('emp_id'))->value('user_id');
                    if($user_id){
                        $user_notification = [
                            "p_notification_to" => $user_id,
                            "p_insert_by" => Auth::id(),
                            "p_note" => 'Your new family member has been approved.',
                            "p_priority" => null,
                            "p_module_id" => 1,
                            "p_target_url" => "my-account#/family"
                        ];
                        DB::executeProcedure("cpa_security.cpa_general.notify_add", $user_notification);
                    }
                }
                $insert_by = EmpFamilyTemp::where('emp_family_id', $request->get('emp_family_id'))->value('insert_by');
                if($user_id != $insert_by){
                    if($insert_by){
                        $emp_name = Employee::where('emp_id', $request->get('emp_id'))->value('emp_name');
                        $operator_notification = [
                            "p_notification_to" => $insert_by,
                            "p_insert_by" => Auth::id(),
                            "p_note" => 'New family member approved for '.$emp_name.'.',
                            "p_priority" => null,
                            "p_module_id" => 1,
                            "p_target_url" => "pmis#/employee/family/".$request->get('emp_id')
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
