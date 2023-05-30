<?php

namespace App\Http\Controllers\Online_Vessel_Billing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index() {
        return view('online_vessel_billing.index');
    }
}
