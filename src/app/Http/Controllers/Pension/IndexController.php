<?php

namespace App\Http\Controllers\Pension;

use App\Entities\Admin\LModule;
use App\Entities\Security\Menu;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $access_menus = [5];
        if ($auth->user()->hasGrantAll()) {
            $menus = Menu::orderBy('menu_order_no')->get();
        } else {
            $menus = $auth->user()->getRoleMenus();
        }
        return view('pension.index', ['menus' => $menus,'access_menus' => $access_menus]);
    }

   public function showAttachments($id){

       $sql = ("SELECT attachment_type_id, ATTACHMENT_ID, TITLE, filename, file_content
                FROM pension_attachments
                where ATTACHMENT_ID = :id");


       $attachment = DB::selectOne($sql, ['id' => $id]);

       $fileContent = $attachment->file_content;

       if (preg_match('/^data:([^;]+);base64,(.+)/', $fileContent, $matches)) {
           return response(base64_decode($matches[2]))->header('Content-Type', $matches[1]);
       }
       return "ERROR IN FILE FORMAT";
   }
}
