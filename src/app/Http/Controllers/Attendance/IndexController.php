<?php

namespace App\Http\Controllers\Attendance;

use App\Entities\Admin\LModule;
use App\Entities\Security\Menu;
use App\Http\Controllers\Controller;
use App\Models\AttendanceImport;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Expr\List_;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class IndexController extends Controller
{
    //
    public function index(Guard $auth)
    {   $access_menus = [12];
        if ($auth->user()->hasGrantAll()) {
            $menus = Menu::orderBy('menu_order_no')->get();
        } else {
            $menus = $auth->user()->getRoleMenus();
        }
        return view('attendance.index', ['menus' => $menus,'access_menus' => $access_menus]);
    }

    public function upload(Request $request)
    {

        ini_set('upload_max_filesize', '10M');
        ini_set('post_max_size', '10M');
        ini_set('max_input_time', 300);
        ini_set('max_execution_time', 300);

        $auth = auth();
        $access_menus = [12];
        if ($auth->user()->hasGrantAll()) {
            $menus = Menu::orderBy('menu_order_no')->get();
        } else {
            $menus = $auth->user()->getRoleMenus();
        }

        try {
            $validator = Validator::make(
                [
                    'file'      => $request->file,
                    'extension' => strtolower($request->file->getClientOriginalExtension()),
                ],
                [
                    'file'          => 'required',
                    'extension'      => 'required|in:csv,xlsx,xls',
                ]
            );

            if (!$validator->fails()) {
                $file = $request->file('file');
                // File Details
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $tempPath = $file->getRealPath();
                $fileSize = $file->getSize();
                //$mimeType = $file->getMimeType();
                // File upload location
                $location = 'uploads';
                // Upload file
                $file->move($location, $filename);
                $filepath = public_path($location . "/" . $filename);
                $edxl = Excel::import(new AttendanceImport(), $filepath);
                $message =  "Successfully imported";
                $success = true;
            }
            else {
                $message = "Invalid file type, Please check your file type and try again";
                $success = false;
            }
        }
        catch (\Exception $e) {
            $message = $e->getMessage();// "Something went wrong! Please Check date format than try again";
            $success = false;
        }
        return view('attendance.import', ['message' => $message, 'success' => $success, 'menus' => $menus,'access_menus' =>$access_menus]);
    }
}
