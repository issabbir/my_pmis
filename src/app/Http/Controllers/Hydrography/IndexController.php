<?php

namespace App\Http\Controllers\Hydrography;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index() {
        return view('hydrography.index');
    }
}
