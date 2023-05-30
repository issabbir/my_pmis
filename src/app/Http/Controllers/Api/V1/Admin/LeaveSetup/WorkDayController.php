<?php

namespace App\Http\Controllers\Api\V1\Admin\LeaveSetup;

use App\Entities\Admin\HrWorkDay;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkDayController extends Controller
{
    public function __construct()
    {
        // Dependency injection
    }

    public function index(Request $request)
    {
        return HrWorkDay::all();
    }

    public function view(Request $request, $id)
    {
        return HrWorkDay::find($id);
    }

    public function fetch(Request $request, $id)
    {
        $hrWorkDay = HrWorkDay::find($id);

        return [
            'hrWorkDay' => [
                'day' => $hrWorkDay->day,
                'work_day_status_id' => $hrWorkDay->status->status_id
            ]
        ];
    }

    public function store(Request $request)
    {
        $workDay = new HrWorkDay();
        $workDay->setConnection('cpa_pmis');
        $workDay->fill($request->all());
        $workDay->created_by = auth()->ID();
        $workDay->save();
    }

    public function update(Request $request, $id)
    {
        $workDay = HrWorkDay::find($id);
        $workDay->setConnection('cpa_pmis');
        $workDay->fill($request->all());
        $workDay->created_by = auth()->ID();
        $workDay->update();
    }

    public function remove(Request $request, $id)
    {
        if(HrWorkDay::destroy($id)) {
            return ['deleted' => true];
        }

        return ['deleted' => false];
    }
}
