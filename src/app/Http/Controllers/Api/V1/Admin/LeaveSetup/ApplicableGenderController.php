<?php

namespace App\Http\Controllers\Api\V1\Admin\LeaveSetup;

use App\Entities\Admin\HrGender;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicableGenderController extends Controller
{
    public function __construct()
    {
        // Dependency injection
    }

    public function index(Request $request)
    {
        return HrGender::all();
    }

    public function dropdown(Request $request)
    {
        $hrGenders = HrGender::all();
        $genders = [];

        foreach($hrGenders as $key => $gender) {
            $genders[$key]['value'] = $gender->gender_id;
            $genders[$key]['text'] = $gender->name;
        }

        return response()->json(['hrGenders' => $genders]);
    }
}
