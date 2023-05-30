<?php


namespace App\Http\Controllers\Api\V1\Operation;

use App\Contracts\Admin\AdminContract;
use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /** @var AdminContract|AdminManager  */
    protected $adminManager;
    public function __construct(AdminContract $adminManager )
    {
        $this->adminManager = $adminManager;
    }
    public function formData(AdminContract $adminManager)
    {
        return [
            'departments' => $adminManager->findDepartments(),
            'designations' => $adminManager->findDesignations(),
            'grades' => $adminManager->findEmpGrads(),
            'locationType'=>$adminManager->findLocationTypeList(),
        ];
    }

    public  function  getDesignationByDepartment($id,AdminContract $adminManager){
        return [
            'designations' => $adminManager->findDepartmentWiseDesignation($id),
        ];
    }

    public  function  getDesignationByGrade($id,$emp_grade_id,AdminContract $adminManager){
        return [
            'designations' => $adminManager->getDesignationByGrade($id,$emp_grade_id),
        ];
    }

    public  function  getLocationByType($id,AdminContract $adminManager){
        return [
            'locations' => $adminManager->findLocationList($id),
        ];
    }
    public  function  getEmployeePromotionGrade($id,AdminContract $adminManager){
        return [
            'promotiongrades' => $adminManager->findEmployeePromotionGrade($id),
            'actualGrads' => $this->empActualGrads()
        ];
    }
    /**
     * @return array
     */
    private function empActualGrads() {
        $grades = [];
        $grades[] = ["value" => null, 'text' => 'Select Grade'];
        foreach ($this->adminManager->findEmpGrads() as $item) {
            $grades[] = ["text" => 'Grade '.$item->emp_grade_id.' ('.$item->grade_range.') ', 'value' => $item->emp_grade_id];
        }
        return $grades;
    }
    public function searchIncrementEmployees($searchParam) {
        $sql = "select OPERATIONS.emp_search_promotion_increment(:param) from dual";
        return $list = DB::select($sql, ['param' => $searchParam]);
    }

    public function searchEmployees($searchParam)
    {
        //            $department_id = Auth::user()->employee->dpt_department_id;
        $user = Auth::user();
        if ($user->user_type_id === 1 || (Auth::user()->hasPermission('CAN_SEE_ONLY_SELF_DEPARTMENT') && !Auth::user()->hasRole('SUPER_ADMIN'))) {
            $department_id = Auth::user()->employee->current_department_id;
            if(Auth::user()->hasPermission('CAN_SEE_ONLY_SELF_DEPARTMENT') && !Auth::user()->hasRole('SUPER_ADMIN')){
                $sql = "select OPERATIONS.emp_search_by_self_dept(:param,:department) from dual";
                return $list = DB::select($sql, ['param' => $searchParam,'department'=>$department_id]);
            }else{
                $sql = "select OPERATIONS.emp_search(:param) from dual";
                return $list = DB::select($sql, ['param' => $searchParam]);
            }
        }else{
            $sql = "select OPERATIONS.emp_search(:param) from dual";
            return $list = DB::select($sql, ['param' => $searchParam]);
        }


    }

    public function searchAllEmployees($searchParam)
    {
            $sql = "select OPERATIONS.emp_search(:param) from dual";
            return $list = DB::select($sql, ['param' => $searchParam]);
    }

    public function searchSettlementCalculationEmployees($searchParam)
    {
        if(Auth::user()->hasPermission('CAN_SEE_ONLY_SELF_DEPARTMENT') && !Auth::user()->hasRole('SUPER_ADMIN')){
            $department_id = Auth::user()->employee->current_department_id;
        }else{
            $department_id = null;
        }
        $sql = "SELECT e.emp_id,
         e.emp_id AS \"value\",
         e.emp_code,
         e.emp_code AS \"text\",
         '(' || e.emp_code || ') - ' || e.emp_name AS \"option_name\"
    FROM pmis.pension_employee e
   WHERE     UPPER (e.emp_code || e.emp_name) LIKE
                             '%' || TRIM (UPPER (:param)) || '%'
              AND e.dpt_department_id = nvl(:department_id, e.dpt_department_id)
ORDER BY e.emp_name ASC";
        return DB::select($sql, ['param'=>$searchParam, 'department_id'=>$department_id]);
//        a.pension_status IN ('S', 'C')
//    AND
//        JOIN pmis.emp_pension_app a ON a.emp_id = e.EMP_ID
    }

    public function searchRetiredDeadEmployees($searchParam)
    {
        $sql = "SELECT e.emp_name,
       e.emp_id,
       e.emp_code,
       e.emp_name AS \"text\",
       e.EMP_ID AS \"value\",
       '(' || e.emp_code || ') ' || e.emp_name AS \"option_name\"
  FROM employee e
 WHERE e.emp_status_id = 7 AND e.prev_emp_status_id = 5
 AND  UPPER (e.emp_code || e.emp_name) LIKE
                             '%' || TRIM (UPPER (:param)) || '%'
                             ORDER BY e.emp_name ASC";

        return DB::select($sql, ['param'=>$searchParam]);

    }


    public function searchPensionApplicationEmployees($searchParam)
    {
        $sql = "SELECT e.emp_name,
         e.emp_id,
          e.emp_code,
         e.emp_name AS \"text\",
         e.EMP_ID AS \"value\",
         '(' || e.emp_code || ') ' || e.emp_name AS \"option_name\"
    FROM pmis.employee e JOIN pmis.emp_pension_app a ON a.emp_id = e.emp_id
   WHERE UPPER (e.emp_code || e.emp_name) LIKE
            '%' || TRIM (UPPER ( :param)) || '%'
ORDER BY e.emp_name ASC";

        return DB::select($sql, ['param'=>$searchParam]);

    }


    public function searchPensionClearanceEmployees($searchParam)
    {
        $sql = "SELECT e.emp_name,
         e.emp_id,
          e.emp_code,
         e.emp_name AS \"text\",
         e.EMP_ID AS \"value\",
         '(' || e.emp_code || ') ' || e.emp_name AS \"option_name\"
    FROM pmis.employee e JOIN pmis.pension_dept_acknowledgement a ON a.emp_id = e.emp_id
   WHERE UPPER (e.emp_code || e.emp_name) LIKE
            '%' || TRIM (UPPER ( :param)) || '%'

            group by e.emp_name,
         e.emp_id,
         e.emp_name,
         e.emp_code
ORDER BY e.emp_name ASC";

        return DB::select($sql, ['param'=>$searchParam]);

    }

    public function searchControllingOfficer($searchParam, $department_id = null)
    {
        $sql = "SELECT e.emp_id,
         e.emp_name,
         e.emp_code,
         e.emp_id \"VALUE\",
         e.emp_name \"TEXT\",
         '(' || e.emp_code || ') - ' || e.emp_name \"OPTION_NAME\"
    FROM employee e
         JOIN employee co ON e.emp_id = co.reporting_officer_id
         JOIN CPA_SECURITY.SEC_USERS u ON e.emp_id = u.emp_id
         JOIN CPA_SECURITY.SEC_USER_ROLES r ON r.user_id = u.user_id
   WHERE r.role_id = 118 AND e.dpt_department_id = nvl(:department_id, e.dpt_department_id) AND UPPER (e.emp_code || e.emp_name) LIKE
                             '%' || UPPER (:param) || '%'
                     AND ROWNUM <= 20
GROUP BY e.emp_id, e.emp_name, e.emp_code";



        return $list = DB::select($sql, ['param' => $searchParam, 'department_id'=> $department_id]);
    }

    public function controllingOfficerWiseEmployee($searchParam, $reporting_officer_id = null)
    {
        $user = Auth::user();
        if ($user->user_type_id === 1 ) {
            $sql = "SELECT emp_code,
       emp_id,
       emp_name,
       emp_code || ' - ' || emp_name option_name
  FROM employee e
 WHERE     reporting_officer_id =
              NVL ( :reporting_officer_id, reporting_officer_id)
       AND UPPER (e.emp_code || e.emp_name) LIKE
              '%' || UPPER ( :param) || '%'
       AND ROWNUM <= 20";
            return $list = DB::select($sql, ['param' => $searchParam, 'reporting_officer_id'=> $reporting_officer_id]);
        }else{
            $sql = "select OPERATIONS.emp_search(:param) from dual";
            return $list = DB::select($sql, ['param' => $searchParam]);
        }
    }

    public function academicEmployee()
    {
        $sql = "SELECT emp_code,
       emp_id,
       emp_name,
       emp_code || ' - ' || emp_name option_name
  FROM employee e
 WHERE     E.ACADEMIC_YN = 'Y'";
        return $list = DB::select($sql);
    }

    public function getlookupData(AdminContract $adminManager, $p_type)
    {
        return [
            'punishments' => $adminManager->findCommonLookups($p_type),
        ];
    }

    public function get(Request $request)
    {
        $department_id = Auth::user()->employee->current_department_id;
        if(Auth::user()->hasPermission('CAN_SEE_ONLY_SELF_DEPARTMENT') && !Auth::user()->hasRole('SUPER_ADMIN')) {
            $sql = "select operations.PROMOTIONS_LIST(:p1) from dual";
            return DB::select($sql, ['p1' => $department_id]);
        }else{
            $sql = "select operations.PROMOTIONS_LIST(:p1) from dual";
            return DB::select($sql, ['p1' => $request->get('department_id')]);
        }

    }

    public function post(Request $request)
    {
        return $this->operations_emp_promotions_ins($request);
    }

    public function put($id, Request $request)
    {
        return $this->operations_emp_promotions_ins($request);
    }

    public function del($id)
    {
        return $this->operations_EMP_PROMOTIONS_DELETE($id);
    }

    public function process(Request $request)
    {
        return $this->operations_EMP_PROMOTIONS_PROCESS($request);
    }

    public function operations_emp_promotions_ins(Request $request)
    {
        try {

            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [

                "p_promotion_id" => $request->get("promotion_id"),
                "p_emp_id" => $request->get("emp_id"),
                "p_division_id_from" => $request->get("division_id_from"),
                "p_department_id_from" => $request->get("department_id_from"),
                "p_designation_id_from" => $request->get("designation_id_from"),
                "p_grad_id_from" => $request->get("grad_id_from"),
                "p_grade_step_id_from" => $request->get("grade_step_id_from"),
                "p_division_id_to" => $request->get("division_id_to"),
                "p_department_id_to" => $request->get("department_id_to"),
                "p_designation_id_to" => $request->get("designation_id_to"),
                "p_grad_id_to" => $request->get("grad_id_to"),
                "p_grade_step_id_to" => $request->get("grade_step_id_to"),
                "p_order_no" => $request->get("order_no"),
                "p_order_date" => date("Y-m-d", strtotime($request->get("order_date"))),
                "p_effective_date" => date("Y-m-d", strtotime($request->get("effective_date"))),
                "p_promotion_grad_type" => $request->get("promotion_grad_type"),
                "p_order_attachment" => [
                    'value' => $request->post('order_attachment'),
                    'type' => SQLT_CLOB,
                ],
                "p_note" => $request->get("note"),
                "p_actual_grade_id" => $request->get("actual_grade_id"),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.EMP_PROMOTIONS_INS", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function operations_EMP_PROMOTIONS_PROCESS(Request $request)
    {
        try {

            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [

                "p_promotion_id" => $request->get("promotion_id"),
                "p_process_yn" => "Y",
                "p_note" => $request->get('note'),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.EMP_PROMOTIONS_PROCESS", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function operations_EMP_PROMOTIONS_DELETE($id)
    {
        try {

            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [

                "p_promotion_id" => $id,
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.EMP_PROMOTIONS_DELETE", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 999, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }


    public function employeeForStatus($name){
        if(Auth::user()->hasPermission('CAN_SEE_ONLY_SELF_DEPARTMENT') && !Auth::user()->hasRole('SUPER_ADMIN')){
//            $department_id = Auth::user()->employee->dpt_department_id;
            $department_id = Auth::user()->employee->current_department_id;
            return DB::table('employee')
                ->join('l_department', 'employee.dpt_department_id', '=', 'l_department.department_id')
                ->join('l_designation', 'employee.designation_id', '=', 'l_designation.designation_id')
                ->join('l_dpt_division', 'employee.dpt_division_id', '=', 'l_dpt_division.dpt_division_id')
                ->join('l_emp_status', 'employee.emp_status_id', '=', 'l_emp_status.emp_status_id')
                ->select('emp_id',
                    'emp_code',
                    DB::raw("emp_code||' '||emp_name AS option_name"),
                    'emp_name',
                    'employee.emp_status_id',
                    'l_emp_status.emp_status',
                    'employee.designation_id',
                    'l_designation.designation',
                    'employee.dpt_department_id',
                    'l_department.department_name',
                    'employee.dpt_division_id',
                    'l_dpt_division.dpt_division_name')
                ->where('employee.approved_yn','=', 'Y')
                ->where('employee.emp_status_id','!=', 9)
                ->where('employee.dpt_department_id','=', $department_id)
                ->where(function($query) use ($name){
                    $query->where(DB::raw('LOWER(emp_name)'),'like',strtolower('%'.trim($name).'%'))
                        ->orWhere('emp_code', 'like', '%'.trim($name)."%" );
                })
                ->groupBy(
                    'emp_id',
                    'emp_code',
                    'emp_name',
                    'employee.emp_status_id',
                    'l_emp_status.emp_status',
                    'employee.designation_id',
                    'l_designation.designation',
                    'employee.dpt_department_id',
                    'l_department.department_name',
                    'employee.dpt_division_id',
                    'l_dpt_division.dpt_division_name')
                ->limit(20)
                ->get();
        }else{
            return DB::table('employee')
                ->join('l_department', 'employee.dpt_department_id', '=', 'l_department.department_id')
                ->join('l_designation', 'employee.designation_id', '=', 'l_designation.designation_id')
                ->join('l_dpt_division', 'employee.dpt_division_id', '=', 'l_dpt_division.dpt_division_id')
                ->join('l_emp_status', 'employee.emp_status_id', '=', 'l_emp_status.emp_status_id')
                ->select('emp_id',
                    'emp_code',
                    DB::raw("emp_code||' '||emp_name AS option_name"),
                    'emp_name',
                    'employee.emp_status_id',
                    'l_emp_status.emp_status',
                    'employee.designation_id',
                    'l_designation.designation',
                    'employee.dpt_department_id',
                    'l_department.department_name',
                    'employee.dpt_division_id',
                    'l_dpt_division.dpt_division_name')
                ->where('employee.approved_yn','=', 'Y')
                ->where('employee.emp_status_id','!=', 9)
                ->where(function($query) use ($name){
                    $query->where(DB::raw('LOWER(emp_name)'),'like',strtolower('%'.trim($name).'%'))
                        ->orWhere('emp_code', 'like', '%'.trim($name)."%" );
                })
                ->groupBy(
                    'emp_id',
                    'emp_code',
                    'emp_name',
                    'employee.emp_status_id',
                    'l_emp_status.emp_status',
                    'employee.designation_id',
                    'l_designation.designation',
                    'employee.dpt_department_id',
                    'l_department.department_name',
                    'employee.dpt_division_id',
                    'l_dpt_division.dpt_division_name')
                ->limit(20)
                ->get();
        }

    }
}
