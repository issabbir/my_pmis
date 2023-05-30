<?php


namespace App\Http\Controllers\Api\V1\Operation;

use App\Contracts\Admin\AdminContract;
use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Http\Controllers\Controller;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function formData(AdminContract $adminManager) {
        return [
            'departments' => $adminManager->findDepartments(),
            'designations' => $adminManager->findDesignations(),
            'grads' => $adminManager->findEmpGrads(),
            'countries' => $adminManager->findGeoCountries()
        ];
    }

    public function searchEmployees($searchParam) {
        $sql = "select opration.emp_search(:param) from dual";
        return $list = DB::select($sql, ['param' => $searchParam]);
    }

    public function get(Request $request) {
        //Todo: list of promotion
//        $department_id = Auth::user()->employee->dpt_department_id;
        $department_id = Auth::user()->employee->current_department_id;

        if(Auth::user()->hasPermission('CAN_SEE_ONLY_SELF_DEPARTMENT') && !Auth::user()->hasRole('SUPER_ADMIN')) {
            $sql = "select operations.TOURS_LIST(:p1) from dual";
            return DB::select($sql, ['p1' => $department_id]);
        }else {
            $sql = "select operations.TOURS_LIST(:p1) from dual";
            return DB::select($sql, ['p1' => $request->get('department_id')]);
        }
    }

    public function post(Request $request) {
        return $this->operations_EMP_TOURS_INS($request);
    }

    public function put($id, Request $request) {
        return $this->operations_EMP_TOURS_INS($request);
    }

    public function del($id) {
        return $this->operations_EMP_TOURS_DELETE($id);
    }

    public function process(Request $request) {
        return $this->operations_EMP_TOURS_PROCESS($request);
    }

    public function operations_EMP_TOURS_INS(Request $request)
    {
        //dd($request->all());

        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [

                "p_tour_id" => $request->get("tour_id"),
                "p_emp_id" => $request->get("emp_id"),
                "p_department_id" => $request->get("department_id"),
                "p_designation_id" => $request->get("designation_id"),
                "p_tour_purpose" => $request->get("tour_purpose"),
                "p_travel_date" => date("Y-m-d", strtotime($request->get("travel_date"))),
                "p_return_date" => date("Y-m-d", strtotime($request->get("return_date"))),
                "p_country" => $request->get("country_id"),
                "p_sponsor" => $request->get("sponsor"),
                "p_remarks" => $request->get("note"),
                "p_order_no" => $request->get("order_no"),
                "p_attachment" => [
                    'value' => $request->post('attachment'),
                    'type' => SQLT_CLOB,
                ],
                "p_process_yn" => "N",
                "p_tour_name" => $request->get('tour_name'),
                "p_tour_name_bng" => $request->get('tour_name_bng'),
                "p_tour_type_id" => $request->get('tour_type_id'),
                "p_sponsor_bng" => $request->get('sponsor_bng'),
                "p_tour_duration" => $request->get('tour_duration'),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];

            DB::executeProcedure("OPERATIONS.EMP_TOURS_INS", $params);

        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function operations_EMP_TOURS_PROCESS(Request $request)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_tour_id" => $request->get("tour_id"),
                "p_process_yn" => "Y",
                "p_note" => $request->get('note'),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.EMP_TOURS_PROCESS", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function operations_EMP_TOURS_DELETE($id)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_tour_id" => $id,
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OPERATIONS.EMP_TOURS_DELETE", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }
}
