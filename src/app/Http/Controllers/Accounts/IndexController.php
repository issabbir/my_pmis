<?php

namespace App\Http\Controllers\Accounts;

use App\Entities\Security\Menu;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index() {
        if (auth()->user()->hasGrantAll()) {
            $menus = Menu::orderBy('menu_order_no')->get();
        } else {
            $menus = auth()->user()->getRoleMenus();
        }
        return view('accounts.index',['menus' => $menus]);
    }
}
