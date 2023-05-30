<?php

namespace App\Http\Controllers\Api\V1\Admin\LocationSetup;

use App\Entities\Admin\HrLocDistrict;
use App\Entities\Admin\HrLocDivision;
use App\Entities\Admin\LGeoDistrict;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Security\Role;
use App\Entities\Security\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DistrictController extends Controller
{
    public function __construct()
    {
        // Dependency injection
    }

    public function index(Request $request)
    {
        $districtsList = LGeoDistrict::all();
        $districts = [];
        $districts[] = ["value" => null, 'text' => 'Select  District','geo_division_name' => null];
        foreach ($districtsList as $item) {
            $districts[] = ["text" => $item->geo_district_name, 'value' => $item->geo_district_id, 'geo_division_name' => $item->division->geo_division_name];
        }
        return $districts;

    }

    public function all_districts(){
        $districtsList = LGeoDistrict::orderBy('geo_district_name')->get();
        return response()->json($districtsList);
    }

    public function dropdown($divisionId)
    {
        $hrDistrict = LGeoDistrict::where('division_id', $divisionId)->get();
        $districts = [];

        foreach($hrDistrict as $key => $district) {
            $districts[$key]['value'] = $district->district_id;
            $districts[$key]['text'] = $district->district_name;
        }

        array_unshift($districts, ['value' => '', 'text' => 'Please select']);

        return $districts;
    }

    public function view(Request $request)
    {

        //TODO: Default template for action.
    }

    public function store(Request $request)
    {
        try {
            $geo_district_id = $request->get('geo_district_id');
            $statusCode = sprintf('%20f', '');
            $statusMessage = sprintf('%4000s', '');

            $params = [
                'p_geo_district_id' => [
                    'value' => &$geo_district_id,
                    "type" => \PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                'geo_district_name' => strtoupper($request->get('geo_district_name')),
                'geo_district_name_bng' => strtoupper($request->get('geo_district_name_bng')),
                'geo_division_id' => $request->get('geo_division_id'),
                'insert_by' => Auth::id(),
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage,
            ];
            DB::executeProcedure('administration.geo_district_entry', $params);
        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        return $params;
    }

    public function update(Request $request)
    {
        //TODO: Default template for action.
    }

    public function remove(Request $request)
    {
        //TODO: Default template for action.
    }
}
