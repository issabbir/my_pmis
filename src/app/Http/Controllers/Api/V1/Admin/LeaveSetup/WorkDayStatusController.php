<?php

namespace App\Http\Controllers\Api\V1\Admin\LeaveSetup;

use App\Entities\Admin\HrWorkDayStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkDayStatusController extends Controller
{
    public function __construct()
    {
        // Dependency injection
    }

    public function index(Request $request)
    {
        return HrWorkDayStatus::all();
    }

    public function dropdown(Request $request)
    {
        $hrWorkDayStatuses = HrWorkDayStatus::all();
        $statuses = [];

        foreach($hrWorkDayStatuses as $key => $status) {
            $statuses[$key]['value'] = $status->status_id;
            $statuses[$key]['text'] = $status->status;
        }

        return response()->json(['hrWorkDaySatauses' => $statuses]);
    }
}
