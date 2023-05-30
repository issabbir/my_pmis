<?php


namespace App\Http\Controllers\Api\V1\Operation\Approval;

use App\Contracts\Admin\AdminContract;
use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Http\Controllers\Controller;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PunishmentApprovalController extends Controller
{
    public function get(Request $request) {
//        $department_id = Auth::user()->employee->dpt_department_id;
        $department_id = Auth::user()->employee->current_department_id;
        if(Auth::user()->hasPermission('CAN_SEE_ONLY_SELF_DEPARTMENT') && !Auth::user()->hasRole('SUPER_ADMIN')) {
            $sql = "SELECT P.PUNISHMENT_ID,
       P.EMP_ID,
       E.EMP_CODE,
       E.EMP_NAME,
       P.PUNISHMENT_TYPE_ID,
       L.MEANING AS PUNISHMENT_TYPE,
       P.ORDER_REF_NUMBER,
       P.ORDER_DATE,
       P.START_DATE,
       P.END_DATE,
       P.NOTE,
       P.PROCESS_YN,
       P.APPROVE_NOTE,
       P.END_ORDER_REF_NO,
       P.END_ORDER_DATE,
         case
       when P.update_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=P.update_by)
       when P.insert_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=P.insert_by)
       else '' end last_updated_by
  FROM EMP_PUNISHMENT P
       JOIN EMPLOYEE E ON E.EMP_ID = P.EMP_ID
       JOIN L_LOOKUPS L
          ON (    L.LOOKUP_CODE = P.PUNISHMENT_TYPE_ID
              AND L.LOOKUP_TYPE = 'PUNISHMENT')
 WHERE P.PROCESS_YN = 'N'
 AND E.DPT_DEPARTMENT_ID = $department_id";
            return DB::select($sql);
        }else {
            $sql = "SELECT P.PUNISHMENT_ID,
       P.EMP_ID,
       E.EMP_CODE,
       E.EMP_NAME,
       P.PUNISHMENT_TYPE_ID,
       L.MEANING AS PUNISHMENT_TYPE,
       P.ORDER_REF_NUMBER,
       P.ORDER_DATE,
       P.START_DATE,
       P.END_DATE,
       P.NOTE,
       P.PROCESS_YN,
       P.APPROVE_NOTE,
       P.END_ORDER_REF_NO,
       P.END_ORDER_DATE,
         case
       when E.update_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=E.update_by)
       when E.insert_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=E.insert_by)
       else '' end last_updated_by
  FROM EMP_PUNISHMENT P
       JOIN EMPLOYEE E ON E.EMP_ID = P.EMP_ID
       JOIN L_LOOKUPS L
          ON (    L.LOOKUP_CODE = P.PUNISHMENT_TYPE_ID
              AND L.LOOKUP_TYPE = 'PUNISHMENT')
 WHERE P.PROCESS_YN = 'N'";
            return DB::select($sql);
        }

    }

    public function store(Request $request){
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_punishment_id" => $request->get("punishment_id"),
                "p_process_yn" => $request->get("process_yn"),
                "p_approve_note" => $request->get('approve_note'),
                "p_approve_status" => $request->get('approve_status'),
                "p_approve_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.EMP_PUNISHMENT_PROCESS", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }
}
