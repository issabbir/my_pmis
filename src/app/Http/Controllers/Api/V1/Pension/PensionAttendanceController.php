<?php


namespace App\Http\Controllers\Api\V1\Pension;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PensionAttendanceController extends Controller
{
    public function store(Request $request){
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_attendance_id"=>$request->get('attendance_id')==null ? '':$request->get('attendance_id'),
                "p_emp_id"=>$request->get('emp_id'),
                "p_attendance_date" => $request->get("attendance_date"),
                "p_pension_nominee_id" => $request->get("nominee_id"),
                "p_remarks" => $request->get("remarks"),
                "p_approve_status" => $request->get("approve_status"),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PENSION.pension_emp_attendance", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }


    public function employee_search($id){
        $sql = "select pension.emp_search_pension(:id) from dual";
        return DB::select($sql, ['id' => $id]);
    }

    public function pension_nominee($id){
        $sql = "select NOMINEE_ID, NOMINEE_NAME from EMP_NOMINEE WHERE EMP_ID = $id";
        return DB::select($sql);
    }

    public function all_attendance_data(){
        $sql = "SELECT E.EMP_NAME,
       E.EMP_CODE || ' - ' || E.EMP_NAME AS OPTION_NAME,
       E.EMP_STATUS,
       PA.*,
       PN.NOMINEE_NAME,
       PN.NOMINEE_ID
  FROM EMP_PENSION_ATTENDANCE PA
       JOIN PENSION_EMPLOYEE E ON E.EMP_ID = PA.EMP_ID
       LEFT JOIN EMP_NOMINEE PN ON PN.EMP_ID = E.EMP_ID
 WHERE PA.PENSION_NOMINEE_ID = PN.NOMINEE_ID";
        return DB::select($sql);
    }
}
