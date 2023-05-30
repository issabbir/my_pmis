<?php

namespace App\Http\Controllers\Api\V1\Admin\EmployeePosition;

use App\Contracts\Admin\AdminContract;
//use App\Entities\Admin\HrDivision;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//use DB;

class DivisionController extends Controller
{
    /** @var AdminContract|AdminManager  */
    private $adminManager;

     /**
     * DivisionController constructor.
     *
     * @param AdminManager|AdminContract $adminContract
     */
    public function __construct(AdminContract $adminManager)
    {
       $this->adminManager = $adminManager;
    }
    /**
     * Initial list of divisions
     *
     * @return array
     */
    public function index()
    {
        $sql = "select administration.dpt_division_grid_data from dual";
        return $divisions = DB::select($sql);
    }

    public function view(Request $request, $id)
    {

    }

    public function store(Request $request)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_dpt_division_id" =>  $request->get("dpt_division_id"),
                "p_dpt_division_name" =>$request->get("dpt_division_name"),
                "p_dpt_division_name_bng" => $request->get("dpt_division_name_bng"),
                "p_insert_by" => Auth()->ID(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure('administration.lookup_dpt_division_ins', $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
        return $params;
    }

    public function update(Request $request, $id)
    {

     }

     /**
     * Remove action
     * @param Request $id
     */
    public function remove($id)
    {

    }

}
