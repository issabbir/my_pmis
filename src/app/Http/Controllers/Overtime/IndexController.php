<?php

namespace App\Http\Controllers\Overtime;

use App\Entities\Admin\LModule;
use App\Entities\Security\Menu;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index() {
        $access_menus = [6];
        if (auth()->user()->hasGrantAll()) {
            $menus = Menu::orderBy('menu_order_no')->get();
        } else {
            $menus = auth()->user()->getRoleMenus();
        }
        return view('overtime.index', ['menus' => $menus,'access_menus' => $access_menus]);
     }

    public function report(Guard $auth) {
        if ($auth->user()->hasGrantAll()) {
            $menus = Menu::orderBy('menu_order_no')->get();
        } else {
            $menus = $auth->user()->getRoleMenus();
        }
        return view('overtime.report', ['menus' => $menus]);
    }
}
