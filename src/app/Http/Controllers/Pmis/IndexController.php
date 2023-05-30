<?php

namespace App\Http\Controllers\Pmis;

use App\Entities\Admin\LModule;
use App\Entities\Security\Menu;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IndexController extends Controller
{
    protected $adminManager;

    public function __construct(AdminManager $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    /**
     * Pmis module action based on backend
     *
     * @param Guard $auth
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Guard $auth) {
        //dd(auth()->user()->hasPermission('CAN_CREATE_USER'));
        $access_menus = [1];
        if ($auth->user()->hasGrantAll()) {
            $menus = Menu::orderBy('menu_order_no')->get();
        } else {
            $menus = $auth->user()->getRoleMenus();
        }
        return view('pmis.index', ['menus' => $menus,'access_menus' => $access_menus]);
    }

    /**
     * Pmis operation sub module action based on backend
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function operations() {
        $access_menus = [1];
        if (auth()->user()->hasGrantAll()) {
            $menus = Menu::orderBy('menu_order_no')->get();
        } else {
            $menus = auth()->user()->getRoleMenus();
        }

        return view('pmis.operations.index', ['menus' => $menus,'access_menus' => $access_menus]);
    }

    public function acr() {
        return view('pmis.acr.index');
    }

    public function provident_fund() {
        $access_menus = [4];
        if (auth()->user()->hasGrantAll()) {
            $menus = Menu::orderBy('menu_order_no')->get();
        } else {
            $menus = auth()->user()->getRoleMenus();
        }
        return view('pmis.provident_fund.index',['menus' => $menus,'access_menus' => $access_menus]);
    }

    public function change_password() {
        if (auth()->user()->hasGrantAll()) {
            $menus = Menu::orderBy('menu_order_no')->get();
        } else {
            $menus = auth()->user()->getRoleMenus();
        }
        return view('pmis.change_password' ,['menus' => $menus]);
    }
}
