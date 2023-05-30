<?php

namespace App\Http\Controllers\Payroll;

use App\Contracts\Payroll\PayrollContract;
use App\Entities\Admin\LModule;
use App\Entities\Security\Menu;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    protected $payrollContract;

    public function __construct(PayrollContract $payrollContract)
    {
        $this->payrollContract = $payrollContract;
    }

    public function index() {
        $access_menus = [11];
        if (auth()->user()->hasGrantAll()) {
            $menus = Menu::orderBy('menu_order_no')->get();
        } else {
            $menus = auth()->user()->getRoleMenus();
        }
        return view('payroll.index', ['menus' => $menus, 'access_menus' => $access_menus]);
     }
}
