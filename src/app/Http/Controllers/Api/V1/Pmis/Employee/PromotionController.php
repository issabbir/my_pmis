<?php

namespace App\Http\Controllers\Api\V1\Pmis\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    public function __construct()
    {
        // Dependency injection
    }

    public function specific(Request $request, $id)
    {
        $sql = "select employees.emp_promotions_history_list(:id) from dual";
        return $list = DB::select($sql, ['id' => $id]);
    }

    public function index(Request $request)
    {
        die(__CLASS__.'::index');
        //TODO: Default template for action.
    }

    public function view(Request $request)
    {
        //TODO: Default template for action.
    }

    public function store(Request $request)
    {
        //TODO: Default template for action.
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
