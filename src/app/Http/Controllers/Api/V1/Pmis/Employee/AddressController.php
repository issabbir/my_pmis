<?php

namespace App\Http\Controllers\Api\V1\Pmis\Employee;
use App\Contracts\Admin\AdminContract;
use App\Managers\Admin\AdminManager;
use App\Entities\Pmis\Employee\EmpAddressTemp;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;


class AddressController extends Controller
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
        $address = new EmpAddressTemp();
        $adminManager = $this->adminManager;
        $addresses = $address
            ->select('address_type_id', 'post_code', 'thana_id', 'district_id', 'division_id', 'emp_address_id')
            ->where('emp_id', $id)
            ->orderBy('emp_address_id', 'desc')->get();

        return [
            "address_type_ids"=>$adminManager->findAddressType(),
            "division_ids" => $adminManager->findGeoDivision(),
            "district_ids"=>$adminManager->findGeoDistrict(),
            'thana_ids' => $adminManager->findGeoThana(),
            "data" => $addresses
        ];
    }

    public function accommodation()
    {
        $sql = "SELECT a.emp_id,
         a.ALLOT_ID,
         h.HOUSE_NAME,
         ht.HOUSE_TYPE,
         b.BUILDING_NAME,
         b.BUILDING_NO,
         b.BUILDING_ROAD_NO,
         f.FLAT_NAME,
         h.DORMITORY_BOOKED_SEAT,
         h.FLOOR_NUMBER,
         CASE WHEN h.DOUBLE_GAS_YN = 'Y' THEN 'Yes' ELSE 'No' END DOUBLE_GAS_YN,
         a.TAKE_OVER_DATE,
         h.HOUSE_SIZE,
         CASE WHEN h.PARKING_YN = 'Y' THEN 'Yes' ELSE 'No' END PARKING_YN,
         h.WATER_TAP,
         h.ELECTRIC_METER_NUMBER,
         CASE WHEN h.BTCL_CONNECTION_YN = 'Y' THEN 'Yes' ELSE 'No' END
            BTCL_CONNECTION_YN,
         h.BTCL_NUMBER,
         h.HOUSE_NAME_BNG,
         CASE WHEN h.INTERCOM_YN = 'Y' THEN 'Yes' ELSE 'No' END INTERCOM_YN,
         h.INTERCOM_NO,
         CASE WHEN a.RENT_YN = 'Y' THEN 'Yes' ELSE 'No' END RENT_YN,
         CASE WHEN a.RENT_FROM_BASIC = 'Y' THEN 'Yes' ELSE 'No' END
            RENT_FROM_BASIC,
         a.RENT_MONTHLY,
         c.COLONY_NAME,
         c.COLONY_NAME_BNG,
         C.COLONY_ADDRESS,
         C.COLONY_ADDRESS_BNG,
         ct.COLONY_TYPE
    FROM HAS.HOUSE_ALLOTTMENT a
         JOIN HAS.HOUSE_LIST h ON a.house_id = h.house_id
         LEFT JOIN HAS.BUILDING_LIST b ON b.building_id = h.building_id
         LEFT JOIN has.l_house_type ht ON ht.HOUSE_TYPE_ID = h.HOUSE_TYPE_ID
         LEFT JOIN HAS.L_FLAT_NAME f ON f.flat_name_id = h.FLAT_NAME_ID
         LEFT JOIN has.l_colony c ON c.colony_id = h.Colony_id
         LEFT JOIN has.l_colony_type ct ON ct.COLONY_TYPE_ID = c.COLONY_TYPE_ID
 WHERE a.emp_id = :emp_id and a.Allot_yn = 'Y'";
        return DB::select($sql,['emp_id'=>Auth::user()->emp_id]);
    }

    public function getData() {
        $address = new EmpAddressTemp();
        $adminManager = $this->adminManager;

        return [
            "address_type_ids"=>$adminManager->findAddressType(),
            "division_ids" => $adminManager->findGeoDivision(),
            "district_ids"=>$adminManager->findGeoDistrict(),
            'thana_ids' => $adminManager->findGeoThana()
        ];
    }

    public function view(Request $request)
    {
        $address = new EmpAddressTemp();

        return $address->find($request->id);
    }

    public function store(Request $request)
    {
        try {
            $o_status_code = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');
            $emp_address_id = '';
            $params = [
                'emp_address_id' => [
                    'value' => &$emp_address_id,
                    "type" => PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                'emp_id' => $request->get('emp_id'),
                'address_type_id' => $request->post('address_type_id'),
                'address_line_1' => $request->post('address_line_1'),
                'address_line_1_bng' => $request->post('address_line_1_bng'),
                'address_line_2' => $request->post('address_line_2'),
                'address_line_2_bng'=>$request->post('address_line_2_bng'),
                'post_code' => $request->post('post_code'),
                'thana_id' => $request->post('thana_id'),
                'district_id' => $request->post('district_id'),
                'division_id' => $request->post('division_id'),
                'approved_yn' => $request->get('approved_yn'),
                'same_as' => $request->get('same_as'),
                'insert_by' => auth()->id(),
                'update_by' => auth()->id(),
                'o_status_code' => &$o_status_code,
                'o_status_message' => &$o_status_message,
            ];

            DB::executeProcedure('employees.create_new_address', $params);

            return $params;
        } catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
    }

    public function update(Request $request, $id)
    {
        if($id > 0) {
            try {
                $o_status_code = sprintf('%4000s', '');
                $o_status_message = sprintf('%4000s', '');
                $emp_address_id = $id;

                $params = [
                    'emp_address_id' => [
                        'value' => &$emp_address_id,
                        "type" => PDO::PARAM_INPUT_OUTPUT,
                        "length" => 255
                    ],
                    'emp_id' => $request->get('emp_id'),
                    'address_type_id' => $request->post('address_type_id'),
                    'address_line_1' => $request->post('address_line_1'),
                    'address_line_1_bng' => $request->post('address_line_1_bng'),
                    'address_line_2' => $request->post('address_line_2'),
                    'address_line_2_bng'=>$request->post('address_line_2_bng'),
                    'post_code' => $request->post('post_code'),
                    'thana_id' => $request->post('thana_id'),
                    'district_id' => $request->post('district_id'),
                    'division_id' => $request->post('division_id'),
                    'approved_yn' => $request->get('approved_yn'),
                    'same_as' => $request->get('same_as'),
                    'insert_by' => auth()->id(),
                    'update_by' => auth()->id(),
                    'o_status_code' => &$o_status_code,
                    'o_status_message' => &$o_status_message,
                ];

                DB::executeProcedure('employees.create_new_address', $params);

                return $params;
            }
            catch (Exception $e) {
                return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
            }
        } else {
            return ["exception" => false, 'status' => false, 'message' => 'Not updated!'];
        }
    }

    public function remove(Request $request,$id)
    {
        if($id > 0) {
            try {
                $o_status_code = sprintf('%4000s', '');
                $o_status_message = sprintf('%4000s', '');
                $emp_address_id = $id;

                $params = [
                    'emp_address_id' => [
                        'value' => &$emp_address_id,
                        "type" => PDO::PARAM_INPUT_OUTPUT,
                        "length" => 255
                    ],
                    'o_status_code' => &$o_status_code,
                    'o_status_message' => &$o_status_message,
                ];

                DB::executeProcedure('employees.delete_new_address', $params);
                return $params;
            }
            catch (Exception $e) {
                return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
            }
        } else {
            return ["exception" => false, 'status' => false, 'message' => 'Not deleted!'];
        }
    }
}
