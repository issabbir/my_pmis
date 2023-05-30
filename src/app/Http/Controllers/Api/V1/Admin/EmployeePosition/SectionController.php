<?php

namespace App\Http\Controllers\Api\V1\Admin\EmployeePosition;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\HrDepartment;
use App\Entities\Admin\HrSection;
use App\Entities\Admin\LDptSection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    /**
     * @var AdminContract
     */
    private $employeeSection;

    public function __construct(AdminContract $employeeSection)
    {
        // Dependency injection
        $this->employeeSection = $employeeSection;
    }

    public function index(Request $request)
    {
        return [
            "sections" => $this->getSections(),
        ];
    }

    private function getSections()
    {
        $sql = "select administration.dpt_section_grid_data from dual";
        $sections = DB::select($sql);
        return $sections;

    }

    public function  getSectionsByBptId($id)
    {
        $sql = "select administration.dpt_section_grid_data(:p1) from dual";
        $sections = DB::select($sql,['p1'=>$id]);
        return $sections;
    }

    public function view(Request $request,$id)
    {

    }

    public function store(Request $request)
    {
        try {

            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [

                "p_dpt_section_id" => $request->get("dpt_section_id"),
                "p_dpt_section" => $request->get("dpt_section"),
                "p_dpt_section_bng" => $request->get("dpt_section_bng"),
                "p_department_id" => $request->get("department_id"),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("administration.lookup_dpt_section_ins", $params);
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


}
