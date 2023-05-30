<?php


namespace App\Http\Controllers\Api\V1\Overtime;


use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\LRosterShift;
use App\Entities\Overtime\OtMonths;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OtRosterDetailsController extends Controller
{
    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        $LRosterShift = new LRosterShift();
        $shift = $LRosterShift->get();
        $OtMonths = new OtMonths();
        $month = $OtMonths->get();
        //$OtRosterGroup =
    }
}
