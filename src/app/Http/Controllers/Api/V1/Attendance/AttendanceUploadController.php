<?php

namespace App\Http\Controllers\Api\V1\Attendance;

use App\Contracts\Admin\AdminContract;
use App\Entities\Pmis\Employee\EmpAttendance;
use App\Entities\Pmis\Employee\EmpAttendanceTemp;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use PDO;

class AttendanceUploadController extends Controller {

    protected $adminManager;

    public function __construct(AdminContract $adminManager) {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {

    }

    public function store(Request $request) {
        $file = $request->file('file');

        // File Details
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        echo $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();

       exit;
    }

}
