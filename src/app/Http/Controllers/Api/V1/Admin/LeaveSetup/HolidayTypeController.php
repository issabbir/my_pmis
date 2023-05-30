<?php

namespace App\Http\Controllers\Api\V1\Admin\LeaveSetup;

use App\Entities\Admin\HrHolidayType;
use App\Entities\Admin\HrWorkDayStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HolidayTypeController extends Controller
{
    public function __construct()
    {
        // Dependency injection
    }

    public function index(Request $request)
    {
        return HrHolidayType::all();
    }

    public function dropdown(Request $request)
    {
        $hrHolidayTypes = HrHolidayType::all();
        $holidayTypes = [];

        foreach($hrHolidayTypes as $key => $holidayType) {
            $holidayTypes[$key]['value'] = $holidayType->holiday_type_id;
            $holidayTypes[$key]['text'] = $holidayType->holiday_type;
        }

        return response()->json(['hrHolidayTypes' => $holidayTypes]);
    }
}
