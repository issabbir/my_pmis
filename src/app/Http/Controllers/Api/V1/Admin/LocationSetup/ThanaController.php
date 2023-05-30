<?php

namespace App\Http\Controllers\Api\V1\Admin\LocationSetup;
use App\Entities\Admin\HrLocThana;
use App\Entities\Admin\LGeoThana;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThanaController extends Controller
{
    public function __construct()
    {
        // Dependency injection
    }

    public function index(Request $request)
    {
        return LGeoThana::all();
    }

    public function view(Request $request)
    {
        //TODO: Default template for action.
    }

    public function store(Request $request)
    {
        try {
            $geo_thana_id = $request->get('geo_thana_id');
            $statusCode = sprintf('%20f', '');
            $statusMessage = sprintf('%4000s', '');

            $params = [
                'p_geo_thana_id' => [
                    'value' => &$geo_thana_id,
                    "type" => \PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                'geo_thana_name' => strtoupper($request->get('geo_thana_name')),
                'geo_thana_name_bng' => strtoupper($request->get('geo_thana_name_bng')),
                'geo_district_id' => $request->get('geo_district_id'),
                'insert_by' => Auth::id(),
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage,
            ];
            DB::executeProcedure('administration.geo_thana_entry', $params);
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
