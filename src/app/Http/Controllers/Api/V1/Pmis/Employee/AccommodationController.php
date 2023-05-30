<?php

namespace App\Http\Controllers\Api\V1\Pmis\Employee;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\LBuildingType;
use App\Entities\Pmis\Employee\EmpHouseAllotment;
use App\Entities\Pmis\Employee\EmpHouseAllotmentHistory;
use App\Entities\Pmis\Employee\EmpHouseAllotmentTemp;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;

class AccommodationController extends Controller
{
    private $adminManager;

    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        return $this->getData();
    }

    public function specific(Request $request, $id)
    {
        $sql = "SELECT A.UPDATE_DATE,
       A.UPDATE_DATE,
       A.TAKE_OVER_DATE,
       A.SPECIAL_YN,
       A.SPECIAL_REMARKS,
       A.NO_OF_TAP,
       A.NO_OF_BURNER,
       A.HAND_OVER_DATE,
       A.EMP_ID,
       A.ELECTRICITY_BILL,
       A.DORMITORY_YN,
       A.BUILDING_TYPE_ID,
       A.ACTIVE_YN,
       B.BUILDING_TYPE_NAME,      
       A.HOUSE_ALLOTEMENT_ID
  FROM PMIS.EMP_HOUSE_ALLOTEMENT A, PMIS.L_BUILDING_TYPE B
 WHERE B.BUILDING_ID = A.BUILDING_TYPE_ID AND A.EMP_ID = :emp_id";

       // $accommodation = new EmpHouseAllotmentHistory();
        $accommodation = DB::select($sql, ['emp_id' => $id]);
        $LBuildingType = new LBuildingType();
        $building = $LBuildingType->where('active_yn','=','Y')->get();
        return [
            "data" => $accommodation,
            "building" => $building
        ];
    }

    public function getData() {
        return [];
    }

    public function view(Request $request, $id) {
        $accommodation = new EmpHouseAllotmentTemp();
        return $accommodation->find($id);
    }

    public function store(Request $request)
    {
        /*dd($request->all());*/
        try {
            $o_status_code = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');
            $house_allotement_id = $request->get('house_allotement_id');

            $params = [
                'p_house_allotement_id' => [
                    'value' => &$house_allotement_id,
                    "type" => PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                'p_emp_id' => $request->get('emp_id'),
                'p_building_type_id' => $request->get('building_type_id'),
                'p_no_of_tap' => $request->get('no_of_tap'),
                'p_no_of_burner' => $request->get('no_of_burner'),
                'p_take_over_date' => $request->get("take_over_date")==null?"":date("Y-m-d", strtotime($request->get("take_over_date"))),
                'p_hand_over_date' => $request->get("hand_over_date")==null?"":date("Y-m-d", strtotime($request->get("hand_over_date"))),
                'p_active_yn' => $request->get('active_yn'),
                'p_insert_by' => auth()->id(),
                'p_update_by' => auth()->id(),
                'o_status_code' => &$o_status_code,
                'o_status_message' => &$o_status_message,
            ];

            DB::executeProcedure('employees.create_new_houseallotment', $params);
            return $params;
        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
    }

    public function remove(Request $request, $id)
    {
        if ($id > 0) {
            try {
                $o_status_code = sprintf('%4000s', '');
                $o_status_message = sprintf('%4000s', '');
                $house_allotement_id = $id;
                $params = [
                    'emp_educationl_id' => [
                        'value' => &$house_allotement_id,
                        "type" => PDO::PARAM_INPUT_OUTPUT,
                        "length" => 255],
                    'o_status_code' => &$o_status_code,
                    'o_status_message' => &$o_status_message,
                ];

                DB::executeProcedure('employees.delete_new_houseallotment', $params);
                return $params;
            } catch (Exception $e) {
                return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
            }
        } else {
            return ["exception" => false, 'status' => false, 'message' => 'Not deleted!'];
        }
    }
}
