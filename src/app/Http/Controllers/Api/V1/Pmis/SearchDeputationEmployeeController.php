<?php

namespace App\Http\Controllers\Api\V1\Pmis;

use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmployeeDepu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\Admin\AdminContract;
use App\Managers\Admin\AdminManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class SearchDeputationEmployeeController extends Controller
{
    private $adminManager;

    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        $employee = new EmployeeDepu();
        $adminManager = $this->adminManager;
        $codes = [27,36,400,401,402,403,404,405,406,407,408,500,501,502,503,505,506,507,508,509,510];
        sort($codes);
        $billCodes = [];
        $billCodes[] = ['text' => 'Select One', 'value' => ''];
        foreach ($codes as $code) {
            $billCodes[] = ['text' => $code, "value" => $code];
        }
        return [
            "departments" => $adminManager->findDepartments(),
            "sections" => $adminManager->findDptSections(),
            "bill_codes" => $billCodes
        ];
    }

    public function searchEmployeeByBillcode($bill_code = '', $empCode = '', Request $request)
    {

        $employees = new Employee();
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = trim($request->input('search'));
        if (is_numeric($bill_code)) {
            $employees = $employees->where('bill_code', '=', $bill_code);
        }

        if ($empCode) {
            $employees = $employees->where('emp_code', '=', trim($empCode));
        }

        if ($searchValue) {
            $searchValue = strtolower($searchValue);
            $employees = $employees->where(DB::raw('LOWER(emp_name)'), 'like', "%" . $searchValue . "%");
        }

        $employees = $employees->orderBy("emp_name", 'asc')->orderBy("emp_code", 'asc');
        $data = $employees->paginate($length);
        return new DataTableCollectionResource($data);
    }

    public function search($departmentId = '', $sectionId = '', $empCode = '', Request $request)
    {

        $employees = new EmployeeDepu();
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = trim($request->input('search'));
        if (is_numeric($departmentId)) {
            $employees = $employees->where('dpt_department_id', '=', $departmentId);
        }

        if (is_numeric($sectionId)) {
            $employees = $employees->where('section_id', '=', $sectionId);
        }

        if ($empCode) {
            $employees = $employees->where('emp_code', '=', trim($empCode));
        }

        if ($searchValue) {
            $searchValue = strtolower($searchValue);
            $employees = $employees->where(DB::raw('LOWER(emp_name)'), 'like', "%" . $searchValue . "%");
        }

        $employees = $employees->orderBy("emp_name", 'asc')->orderBy("emp_code", 'asc');
        $data = $employees->paginate($length);
        return new DataTableCollectionResource($data);
    }

}
