<?php


namespace App\Http\Controllers\Api\V1\Report;

use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Admin\LDptSection;
use App\Entities\Overtime\OtMonths;
use App\Entities\Payroll\PrMonths;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Security\Report;
use App\Managers\Admin\AdminManager;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\DB;
use App\Contracts\Payroll\PayrollContract;
use App\Entities\Payroll\EmpSalaryApplicable;
use App\Http\Controllers\Controller;
use App\Managers\Payroll\PayrollManager;
use Illuminate\Http\Request;

class AttendanceParameterController extends Controller
{
    private $payrollManager;
    private  $adminManager;
    private  $report;


    public function __construct(PayrollContract $payrollManager,AdminManager $adminManager, Report $report) {
        $this->payrollManager = $payrollManager;
        $this->adminManager=$adminManager;
        $this->report =  $report;
    }

    public function index(Request $request)
    {
        $module = 6; //Attendance
        if (auth()->user()->hasGrantAll()) {
            $reports = $this->report->where('module_id', $module)->orderBy('report_name', 'ASC')->get();
        }
        else {
            $roles = auth()->user()->getRoles();
            $reports = array();
            foreach ($roles as $role) {
                $rpts = $role->reports->where('module_id', $module);
                foreach ($rpts as $report) {
                    $reports[$report->report_id] = $report;
                }
            }
        }

        $adminManager=$this->adminManager;

        return [
            "billcodes" => $this->getEmployeeBillCodes(),
            "departments" => $adminManager->findDepartments(),
            "designations" => $adminManager->findDesignations(),
            'empTypes'=> $adminManager->findEmpTypes(),
            "empSections" => $adminManager->findSectionsForExternalUser(),
            "months"=> $this->getMonth(),
            "attendanceStatus" => $this->getAttendanceStatus(),
            'prFiscalYears' => $this->payrollManager->findPrFiscalYears(),
            'reports' => $reports
        ];
    }

    private function getEmployeeBillCodes() {
        return $this->payrollManager->getEmployeeBillCodes();
    }

    private function getPrMonths(){

        $prMonth = new PrMonths();
        $prMonths = $prMonth->get([DB::raw("to_char(calculation_start_date, 'FMMonth-YYYY') as pr_month" ), 'pr_month_id']);

        $prMonths_option = array();
        foreach ($prMonths as $item) {
            $prMonths_option[] = ["text" => $item->pr_month,
                'value' => $item->pr_month_id];
        }
        return $prMonths_option;
    }

    private function getMonth(){

        $prMonth = new OtMonths();
        $prMonths = $prMonth->orderBy('effective_start_date', 'asc')->get([DB::raw("to_char(effective_start_date, 'FMMonth-YYYY') as month" ), 'ot_month_id']);

        $prMonths_option = array();
        foreach ($prMonths as $item) {
            $prMonths_option[] = ["text" => $item->month,
                'value' => $item->ot_month_id];
        }
        return $prMonths_option;
    }

    private function getAttendanceStatus(){
        $sql = "select pmis.common_lookups_list('ATTENDANCESTATUS') from dual";
        return DB::select($sql);
    }

}
