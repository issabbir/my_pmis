<?php


namespace App\Http\Controllers\Api\V1\Pension;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NocAcknowledgmentController extends Controller
{

    const  EXCEPT_DEPARTMENT = [8,9];
    public function getAcknowledgmentData (){
        if(in_array(Auth::user()->employee->department->department_id,self::EXCEPT_DEPARTMENT)){
            $sql = "select pension.emp_dept_ackment_grid(:auth_id)  from dual";
            return DB::select($sql, ['auth_id' => Auth::id()]);
        } else {
            $sql = "select pension.emp_dept_ackment_grid(:auth_id)  from dual";
            return DB::select($sql,['auth_id' => Auth::id()]);
        }
    }


    public function empSearchForClearance ($id){
        $sql = "select pension.pension_clear_emp_search(:id,:auth_id) from dual";
        return DB::select($sql, ['id' => $id,'auth_id' => Auth::id()]);
    }


    public function store(Request $request){

        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_dept_ackment_id"=>$request->get("dept_ackment_id"),
                "p_emp_id" => $request->get("emp_id"),
                "p_dependency_yn" => $request->get("dependency_yn"),
                "p_personal_debt_remarks" => $request->get("personal_debt_remarks"),
                "p_personal_debt"=>$request->get("personal_debt"),
                "p_personal_debt_attachment" => [
                    'value' => $request->post('personal_debt_attachment'),
                    'type' => SQLT_CLOB,
                ],
                "p_institutional_debt_remarks" => $request->get("institutional_debt_remarks"),
                "p_institutional_debt"=>$request->get("institutional_debt"),
                "p_institutional_debt_attach" => [
                    'value' => $request->post('institutional_debt_attachment'),
                    'type' => SQLT_CLOB,
                ],
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];

            DB::executeProcedure("PENSION.emp_pension_ackment_ins", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
        return $params;
    }



}
