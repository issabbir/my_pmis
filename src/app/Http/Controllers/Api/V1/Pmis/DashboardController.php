<?php

namespace App\Http\Controllers\Api\V1\Pmis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Dependency injection
    }

    public function index()
    {
        die(__CLASS__.'::index');
        //TODO: Default template for action.
    }
}
