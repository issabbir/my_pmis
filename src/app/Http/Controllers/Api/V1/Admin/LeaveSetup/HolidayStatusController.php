<?php

namespace App\Http\Controllers\Api\V1\Admin\LeaveSetup;

use App\Entities\Admin\HrHolidayStatus;
use App\Entities\Admin\HrWorkDayStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HolidayStatusController extends Controller
{
    public function __construct()
    {
        // Dependency injection
    }

    public function index(Request $request)
    {
        return HrHolidayStatus::all();
    }

    public function dropdown(Request $request)
    {
        $hrHolidayStatus = HrHolidayStatus::all();
        $holidayStatuses = [];

        foreach($hrHolidayStatus as $key => $holidayStatus) {
            $holidayStatuses[$key]['value'] = $holidayStatus->holiday_status_id;
            $holidayStatuses[$key]['text'] = $holidayStatus->holiday_status;
        }

        return response()->json(['hrHolidayStatuses' => $holidayStatuses]);
    }
}
