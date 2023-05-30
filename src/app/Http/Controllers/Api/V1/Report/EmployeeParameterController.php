<?php


namespace App\Http\Controllers\Api\V1\Report;

use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Admin\LDptSection;
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

class EmployeeParameterController extends Controller
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
        $module = 1; //Employee
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
        return[
            "billcodes" => $this->getEmployeeBillCodes(),
            "departments" => $adminManager->findDepartments(),
            "designations" => $adminManager->findDesignations(),
            "emp_status" => $adminManager->findEmpStatus(),
            "prMonths"=> $this->getPrMonths(),
            'prFiscalYears' => $this->payrollManager->findPrFiscalYears(),
            'monthYears'=>$this->getReportingmonts(),
            'empGrades'=>$adminManager->findEmpGrads(),
            'empClass'=>$adminManager->findEmpClass(),
            'empSections'=>$adminManager->findSections(),
            'empTypes'=>$adminManager->findEmpTypes(),
            "division_ids" => $adminManager->findGeoDivision(),
            "gender" => $adminManager->findGenders(),
            "religion" => $adminManager->findReligion(),
            "district_ids"=>$adminManager->findGeoDistrict(),
            'thana_ids' => $adminManager->findGeoThana(),
            'quota' => $adminManager->findQuota(),
            'reports' => $reports
        ];
    }

    private function getEmployeeBillCodes() {
        return $this->payrollManager->getEmployeeBillCodes();
    }




    private function getPrMonths(){

        $prMonth = new PrMonths();
        $prMonths = $prMonth->orderBy('calculation_start_date', 'asc')->get([DB::raw("to_char(calculation_start_date, 'FMMonth-YYYY') as pr_month" ), 'pr_month_id']);

        $prMonths_option = array();
        foreach ($prMonths as $item) {
            $prMonths_option[] = ["text" => $item->pr_month,
                'value' => $item->pr_month_id];
        }
        return $prMonths_option;
    }
    private function getReportingmonts(){
        $startYear = date("Y");
        $endYear =1960;
        $months=array('JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEP','OCT','NOV','DEC');
        $int=0;
        $monthYears = [];
        $data = array();
        for ($int = $startYear; $int >= $endYear; $int--) {
            foreach($months as $i){
                $data[] =$i.'-'.$int;
            }
        }

            foreach ($data as $item) {
                $monthYears[] = ["text" => $item, 'value' => $item];
            }
        return $monthYears;
    }

}
