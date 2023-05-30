<?php


namespace App\Http\Controllers\Api\V1\Pension;

use App\Entities\Pension\EmpPensionDeathReg;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DeathRegistrationController extends Controller
{
    public function store(Request $request){
        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_register_id"=>$request->get('register_id')==null ? '':$request->get('register_id'),
                "p_emp_id"=>$request->get('emp_id'),
                "p_death_date" => $request->get("death_date"),
                "p_death_nature" => $request->get("death_nature"),
                "p_attachment" => ['value'=> $request->get("attachment"), 'type'=>SQLT_CLOB],
                "p_attachment_type" => $request->get("attachment_type"),
                "p_attachment_file_name" => $request->get("attachment_file_name"),
                "p_remarks" => $request->get("remarks"),
                "p_informer_name" => $request->get("informer_name"),
                "p_approve_status" => $request->get("approve_status"),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PENSION.emp_death_register", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function deathRegistrationApproval(Request $request, $id){
        EmpPensionDeathReg::where('register_id', $id)
            ->update(['approve_status' => $request->get('approve_status'), 'approve_reject_comment'=>$request->get('approve_reject_comment')]);
       /* $reg = EmpPensionDeathReg::find($id);
        $reg->approve_status = $request->get('approve_status');
        $reg->approve_reject_comment = $request->get('approve_reject_comment');
        $reg->save();*/
    }

    public function death_nature(){
        $sql = "SELECT lookup_code AS pass_value, meaning AS show_value
                FROM l_lookups
                WHERE lookup_type = 'DEATH_NATURE'
                ORDER BY short_by";
        return DB::select($sql);
    }

    public function death_registration_list(){
        $sql = "SELECT E.EMP_ID, E.EMP_NAME, E.EMP_CODE, E.EMP_CODE||' - '||E.EMP_NAME AS OPTION_NAME, D.DEATH_DATE, D.INFORMER_NAME, D.APPROVE_STATUS, D.DEATH_NATURE, D.REMARKS ,D.REGISTER_ID
                FROM EMP_PENSION_DEATH_REG D
                JOIN EMPLOYEE E ON D.EMP_ID = E.EMP_ID
                LEFT JOIN L_LOOKUPS L ON (L.LOOKUP_CODE = D.DEATH_NATURE AND L.LOOKUP_TYPE = 'DEATH_NATURE')
                ORDER BY D.INSERT_DATE DESC";
        return DB::select($sql);
    }

    public function unapproved_death_registration_list(){
        $sql = "SELECT D.ATTACHMENT, E.EMP_ID, E.EMP_NAME, E.EMP_CODE, E.EMP_CODE||' - '||E.EMP_NAME AS OPTION_NAME, D.DEATH_DATE, D.INFORMER_NAME, D.APPROVE_STATUS, D.DEATH_NATURE, D.REMARKS ,D.REGISTER_ID
                FROM EMP_PENSION_DEATH_REG D
                JOIN EMPLOYEE E ON D.EMP_ID = E.EMP_ID
                LEFT JOIN L_LOOKUPS L ON (L.LOOKUP_CODE = D.DEATH_NATURE AND L.LOOKUP_TYPE = 'DEATH_NATURE')
                WHERE D.approve_status = 0
                ORDER BY D.INSERT_DATE DESC";
        return DB::select($sql);
    }


    public function employee_search($searchParam){
        $sql = "select pension.emp_for_death_registration(:param) from dual";
        return $list = DB::select($sql, ['param' => $searchParam]);
    }
}
