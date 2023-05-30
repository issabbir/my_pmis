<?php

namespace App\Http\Controllers\Overtime\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index() {
        return view('payroll.reports.overtime');
    }
}
