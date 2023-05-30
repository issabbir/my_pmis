<?php

namespace App\Http\Controllers\Api\V1\Admin\LeaveSetup;

use App\Entities\Admin\HrEmpType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicableEmployeeTypeController extends Controller
{
    public function __construct()
    {
        // Dependency injection
    }

    public function index(Request $request)
    {
        return HrEmpType::all();
    }

    public function dropdown(Request $request)
    {
        $hrEmpTypes = HrEmpType::all();

        $empTypes = [];

        foreach($hrEmpTypes as $key => $empType) {
            $empTypes[$key]['value'] = $empType->emp_type_id;
            $empTypes[$key]['text'] = $empType->type;
        }

        return response()->json(['hrEmpTypes' => $empTypes]);
    }
}
