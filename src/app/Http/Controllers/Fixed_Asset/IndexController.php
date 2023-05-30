<?php

namespace App\Http\Controllers\Fixed_Asset;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index() {
        return view('fixed_asset.index');
    }
}
