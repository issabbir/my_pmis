<?php

namespace App\Http\Controllers\Api\V1\Admin\EmployeePosition;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\HrDepartment;
use App\Entities\Admin\HrDivision;
use App\Entities\Admin\LDepartment;
use App\Entities\Admin\LDptDivision;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{


    /** @var AdminContract|AdminManager  */
    private $adminManager;

    /**
     * DepartmentController constructor.
     * @param AdminContract | AdminManager $adminManager
     */
    public function __construct(AdminContract $adminManager)
    {        // Dependency injection
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        $department_id = Auth::user()->employee->dpt_department_id;

        if(Auth::user()->hasPermission('CAN_SEE_ONLY_SELF_DEPARTMENT') && !Auth::user()->hasRole('SUPER_ADMIN')) {
            $sql = "select administration.department_grid_data_self(:p_department_id) from dual";
            return $departments = DB::select($sql,['p_department_id'=>$department_id]);
        }else{
            $sql = "select administration.department_grid_data from dual";
            return $departments = DB::select($sql);
        }
    }

//    public function view(Request $request, $id)
//    {
//////      dd($id);
////        $departmentNameByID = $this->getDepartmentNameandSanctionPost($id);
//////        dd($departmentNameByID);
//        $department=LDepartment::find($id);
////        dd($department);
//        return [
//            'department' => [
//                'p_department_id'         => $department->department_id,
//                'p_department_name'       => $department->department_name,
//                'p_department_name_bng'   => $department->department_name_bng,
//                'p_dpt_division_id'       => $department->dpt_division_id,
//                'p_shift_yn'              => $department->shift_yn,
//                "p_emp_type_name"         => $department->emp_type_name,
//
//            ]
//        ];
//    }

    public function store(Request $request)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_department_id" => $request->get("department_id"),
                "p_department_name" => $request->get("department_name"),
                "p_department_name_bng" => $request->get("department_name_bng"),
                "p_dpt_division_id" => $request->get("dpt_division_id"),
                "p_shift_yn" => $request->get("shift_yn"),
                "p_fin_code" => $request->get("fin_code"),
                "p_dept_short_name" => $request->get("dept_short_name"),
                "p_insert_by" => Auth()->ID(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];

            DB::executeProcedure('administration.lookup_department_ins', $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
        return $params;
    }

    public function update(Request $request,$id)
    {

    }

    public function remove($id)
    {

    }

    public function  deptBasedDesignationMapping(Request $request)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_department_id" => $request->get("department_id"),
                "p_designation_id" => $request->get("designation_id"),
                "p_sanctioned_post" => $request->get("sanctioned_post"),
                "p_execution_mod" => $request->get("execution_mode"),  //N for new and M for Modification
                "p_insert_by" => Auth()->ID(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];

            DB::executeProcedure('administration.map_dept_designation_ins', $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
        return $params;

    }

    public function getDesinationMapping(Request $request)
    {
        $sql = "select administration.map_dept_designation_grid_data (:p1) from dual";
        return [
            'deptDesingations' => DB::select($sql, ['p1' => $request->get('department_id')]),
            'sanctionedPost' => DB::selectOne("Select sum(sanctioned_post) as sanctioned_total  from L_SANCTIONED_POST")->sanctioned_total
        ];
    }

}
