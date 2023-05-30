<?php

namespace App\Http\Controllers\Api\V1\Pmis\Operations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    public function __construct()
    {
        // Dependency injection
    }

    public function index(Request $request)
    {
        die(__CLASS__.'::index');
        //TODO: Default template for action.
    }

    public function view(Request $request, $id)
    {
        $sql = "select order_attachment
from pmis.emp_promotions
where promotion_id = $id";
        return response()->json(DB::selectOne($sql));
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
