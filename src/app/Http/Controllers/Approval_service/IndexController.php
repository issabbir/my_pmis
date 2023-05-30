<?php

namespace App\Http\Controllers\Approval_service;

use App\Entities\Security\Menu;
use App\Http\Controllers\Controller;
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
        return view('approval_service.index',['menus' => $menus]);
    }
}
