<?php


namespace App\Http\Controllers\Api\V1\Pension;

use App\Entities\Pension\PensionDeptAckmentSetup;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NocSetupController extends Controller
{

    public function getPensionDepartmentSetgrid (){
        $emp_department_id = Auth::user()->user_name == 'admin' ? null :  Auth::user()->employee->dpt_department_id;
       /* $sql = "select pension.pension_department_set_grid  (:auth_id)  from dual";*/
        $sql = "SELECT DS.EMP_DEPARTMENT_ID, ELD.DEPARTMENT_NAME AS EMP_DEPARTMENT_NAME
    FROM PMIS.PENSION_DEPT_ACKMENT_SETUP DS, PMIS.L_DEPARTMENT LD, PMIS.L_DEPARTMENT ELD
   WHERE     DS.NOC_DEPARTMENT = LD.DEPARTMENT_ID
         AND DS.EMP_DEPARTMENT_ID = ELD.DEPARTMENT_ID(+)
         AND DS.EMP_DEPARTMENT_ID = nvl(:department_id, DS.EMP_DEPARTMENT_ID)
GROUP BY DS.EMP_DEPARTMENT_ID, ELD.DEPARTMENT_NAME";
        return DB::select($sql, ['department_id'=>$emp_department_id]);
    }

    public function update(Request $request){
        $lists = $request->all();
        foreach ($lists as  $list){
            $response = PensionDeptAckmentSetup::where('ackment_setup_id', $list['ackment_setup_id'])->update(['active_yn' => $list['active_yn']]);
        }
        return response()->json($response);
    }

    public function pensionNocDepartmentDetail($department_id)
    {
        $sql = "SELECT DS.ACKMENT_SETUP_ID,
       DS.NOC_DEPARTMENT,
       LD.DEPARTMENT_NAME,
       DS.NOC_SECTION_ID,
       (SELECT LS.DPT_SECTION
          FROM L_DPT_SECTION LS
         WHERE     LD.DEPARTMENT_ID = LS.DEPARTMENT_ID
               AND DS.NOC_SECTION_ID = LS.DPT_SECTION_ID)
          AS DPT_SECTION,
       DS.ACTIVE_YN,
       CASE WHEN DS.ACTIVE_YN = 'Y' THEN 'Active' ELSE 'Inactive' END
          AS ACTIVE_INACTIVE,
       DS.EMP_DEPARTMENT_ID,
       ELD.DEPARTMENT_NAME AS EMP_DEPARTMENT_NAME
  FROM PENSION_DEPT_ACKMENT_SETUP DS, L_DEPARTMENT LD, L_DEPARTMENT ELD
 WHERE     DS.NOC_DEPARTMENT = LD.DEPARTMENT_ID
       AND DS.EMP_DEPARTMENT_ID = ELD.DEPARTMENT_ID(+)
       AND DS.EMP_DEPARTMENT_ID = :DEPARTMENT_ID";
        return DB::select($sql, ['department_id'=>$department_id]);
    }


    public function getDepartmentSetSearchData()
    {
        $sql = "select pension.pension_department_set_search (:auth_id)  from dual";
        return DB::select($sql,['auth_id' => Auth::id()]);
    }

    public function store(Request $request){
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_ackment_setup_id"=>$request->get('ackment_setup_id'),
                "p_noc_department" => $request->get("noc_department"),
                "p_section_id" => $request->get("section_id"),
                "p_active_yn" => $request->get("active_yn"),
                "p_emp_department_id" => $request->get("emp_department_id"),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PENSION.dept_ackment_setup_ins", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function delete(Request $request){
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_ackment_setup_id"=>$request->get('ackment_setup_id'),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PENSION.dept_ackment_setup_del", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }


}
