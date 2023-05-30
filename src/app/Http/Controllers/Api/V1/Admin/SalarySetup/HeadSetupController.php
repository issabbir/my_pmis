<?php

namespace App\Http\Controllers\Api\V1\Admin\SalarySetup;

use App\Entities\Admin\HrSalaryHeadSetup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HeadSetupController extends Controller
{
    public function __construct()
    {
        // Dependency injection
    }

    public function index(Request $request)
    {
        $salaryHead = new HrSalaryHeadSetup();
        $salaryHead->setConnection('cpa_pmis');
        return $salaryHead->get();
    }

    public function view(Request $request)
    {
        //TODO: Default template for action.
    }

    public function store(Request $request)
    {
        $salaryHead = new HrSalaryHeadSetup();
        $salaryHead->setConnection('cpa_pmis');
        $salaryHead->fill($request->all());
        $salaryHead->created_by = auth()->ID();
        //dd($request->all());die();
        $salaryHead->save();
        return $salaryHead->get();
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
