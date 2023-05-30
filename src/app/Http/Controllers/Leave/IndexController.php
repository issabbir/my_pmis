<?php

namespace App\Http\Controllers\Leave;

use App\Entities\Admin\LModule;
use App\Entities\Security\Menu;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index(Guard $auth) {
        $access_menus = [10];
        if ($auth->user()->hasGrantAll()) {
            $menus = Menu::orderBy('menu_order_no')->get();
        } else {
            $menus = $auth->user()->getRoleMenus();
        }
        return view('leave.index', ['menus' => $menus,  'access_menus' => $access_menus]);
    }
}
