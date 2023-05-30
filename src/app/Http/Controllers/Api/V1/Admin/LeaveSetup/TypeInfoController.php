<?php

namespace App\Http\Controllers\Api\V1\Admin\LeaveSetup;

use App\Entities\Admin\HrLeaveTypeInfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TypeInfoController extends Controller
{
    public function __construct()
    {
        // Dependency injection
    }

    public function index(Request $request)
    {
        return HrLeaveTypeInfo::all();
    }

    public function view(Request $request, $id)
    {
        return HrLeaveTypeInfo::find($id);
    }

    public function fetch(Request $request, $id)
    {
        $hrLeaveTypeInfo = HrLeaveTypeInfo::find($id);

        return [
            'hrLeaveTypeInfo' => [
                'leavecode' => $hrLeaveTypeInfo->leavecode,
                'leavetype' => $hrLeaveTypeInfo->leavetype,
                'description' => $hrLeaveTypeInfo->description,
                'leaveday' => $hrLeaveTypeInfo->leaveday,
                'emp_type_id' => $hrLeaveTypeInfo->emp_type_id,
                'gender_id' => $hrLeaveTypeInfo->gender_id,
            ]
        ];
    }

    public function store(Request $request)
    {
        $leaveTypeInfo = new HrLeaveTypeInfo();
        $leaveTypeInfo->setConnection('cpa_pmis');
        $leaveTypeInfo->fill($request->all());
        $leaveTypeInfo->created_by = auth()->ID();
        $leaveTypeInfo->save();
    }

    public function update(Request $request, $id)
    {
        $leaveTypeInfo = HrLeaveTypeInfo::find($id);
        $leaveTypeInfo->setConnection('cpa_pmis');
        $leaveTypeInfo->fill($request->all());
        $leaveTypeInfo->created_by = auth()->ID();
        $leaveTypeInfo->update();
    }

    public function remove(Request $request, $id)
    {
        if(HrLeaveTypeInfo::destroy($id)) {
            return ['deleted' => true];
        }

        return ['deleted' => false];
    }
}
