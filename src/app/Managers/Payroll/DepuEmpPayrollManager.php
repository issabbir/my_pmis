<?php

namespace App\Managers\Payroll;

use App\Contracts\Payroll\DepuEmpPayrollContract;
use App\Entities\Payroll\PrBillCodeMapping;
use App\Entities\Payroll\PrEmployeeDepu;
use App\Entities\Payroll\PrFiscalYear;
use App\Entities\Payroll\PrMonths;
use App\Entities\Payroll\PrSalaryHeads;
use DB;

class DepuEmpPayrollManager implements DepuEmpPayrollContract
{

    /**
     * Get one or more division based on parameter
     *
     * @param null $id
     * @return mixed
     */
    public function findPrYears($id = null)
    {
        $months = new PrMonths();
        if ($id)
            return $months->find($id);

        return $months->groupBy('pr_year')->get(['pr_year']);
    }

    public function findFinYears()
    {
        $finYears = new PrFiscalYear();
        return $finYears->orderBy('fy_id', 'desc')->get(['fy_id', 'fy_name']);
    }

    /**
     * Get one or more division based on parameter
     *
     * @param null $id
     * @return mixed
     */
    public function findPrMonths($id = null)
    {
        $months = new PrMonths();
        if ($id)
            return $months->find($id);

        return $months->orderBy("pr_month_id", 'asc')->get();
    }

    /**
     * Get one or more division based on parameter
     *
     * @param null $id
     * @return mixed
     */
    public function findPrMonthsByYear($year = null)
    {
        $months = new PrMonths();
        if ($year)
            return $months->where('pr_year', $year)->where('current_yn', 'Y')->where('open_yn', 'O')->orderBy("pr_month", 'asc')->get();
    }

    /**
     * Get one or more division based on parameter
     *
     * @param null $id
     * @return mixed
     */
    public function findPrMonthsByYearId($id = null)
    {
        $months = new PrMonths();
        if ($id)
            return $months->where('fy_id', $id)->where('current_yn', 'Y')->where('open_yn', 'O')->orderBy("pr_month", 'asc')->get();
    }

    /**
     * Get one or more division based on parameter
     *
     * @param null $id
     * @return mixed
     */
    public function findPrSalaryHeads($id = null,$emp_id=null)
    {

            $heads = DB::table('pr_salary_heads')
//                ->leftJoin('pr_employee_depu', 'pr_employee_depu.salary_head_id', '=', 'pr_salary_heads.salary_head_id')
////                ->whereExists(function ($query,$emp_id) {
////                    $query->select(DB::raw('pr_employee_depu.salary_head_id'))
////                        ->from('pr_employee_depu')
////                        ->whereRaw('pr_employee_depu.emp_id','=',$emp_id);
////                })
                ->where('bonus_yn','N')
                ->orderBy('pr_salary_heads.salary_head','asc')
                ->get(['pr_salary_heads.salary_head_id','pr_salary_heads.salary_head','pr_salary_heads.default_value','pr_salary_heads.deduction_yn']);
            return $heads;
    }

    public function getEmpSalaryAllocatedHead($id)
    {
        return PrEmployeeDepu::where('emp_id',$id)
                              ->orderBy('salary_head', 'desc')
                              ->get();

    }

    /**
     * Get one or more division based on parameter
     *
     * @param null $id
     * @return mixed
     */
    public function findPrSalaryHeadsBasic($id = null)
    {
        $salaryHeads = new PrSalaryHeads();
        if ($id)
            return $salaryHeads->find($id);

        return $salaryHeads->where('every_month_yn', 'Y')->where('active_yn', 'Y')->orderBy("salary_head", 'asc')->get();
    }

    public function findPrFiscalYears($id = null)
    {
        $fiscalYears = new PrFiscalYear();
        $data = $fiscalYears->get();
        if ($id) {
            return $fiscalYears->find($id);
        }

        return $fiscalYears->orderBy('fy_id', 'asc')->get();
    }

    public function findSalaryHeadsForAllocation($id = null)
    {

        $allocationheads = new PrSalaryHeads();
        if ($id) {
            return $allocationheads->find($id);
        }
        return $allocationheads->where('every_month_yn', 'N')
            ->orderby('salary_head_id', 'asc')->get();

    }

    public function findEmpCods($id = null)
    {
        $empcodes = new Employee();
        // if($id){
        // return $empcodes->find($id);
        // }
        return $empcodes->select('emp_id', 'emp_code', DB::raw("CONCAT(emp_code,,emp_name) AS display_name"), 'emp_name', 'designation_id', 'dpt_department_id', 'section_id')
            ->where('emp_code', 'like', '%' . $id . '%')
            ->orWhere('emp_name', 'like', '%' . $id . '%')
            ->limit(20)->get();


    }

    /**
     * Get Employee billedCodes
     *
     * @param $empId
     * @return mixed
     */
    public function getEmployeeSalaryProcessBilledCodes($empId)
    {
        return PrBillCodeMapping::
        where('biller_emp_id', $empId)
            ->where('activation_flag', 'Y')
            ->distinct()->get(['emp_bill_code', 'activation_flag']); //Bill code instead of biller code.
        // ->distinct()->get(['biller_bill_code','activation_flag']); //Bill code instead of biller code.
    }

    public function getEmployeeBillCodes()
    {
        $billcodes_option = [];
        if (auth()->user()->hasGrantAll()) {
            $query = "select bill_code from EMPLOYEE where BILL_CODE IS NOT NULL group by bill_code  order by BILL_CODE asc";
            $billcods = \Illuminate\Support\Facades\DB::select($query);
            foreach ($billcods as $item) {
                $billcodes_option[] = $item->bill_code;
            }
        } else {
            if (auth()->user()->emp_id) {
                $options = $this->getEmployeeSalaryProcessBilledCodes(auth()->user()->emp_id);
                foreach ($options as $option) {
                    $billcodes_option[] = $option->emp_bill_code;
                }
            }
        }
        sort($billcodes_option);
        return $billcodes_option;
    }
}
