<?php


namespace App\Http\Controllers\Api\V1\Dashboard;

use App\Contracts\Admin\AdminContract;
use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Http\Controllers\Controller;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function formData() {
        return [];
    }
}
