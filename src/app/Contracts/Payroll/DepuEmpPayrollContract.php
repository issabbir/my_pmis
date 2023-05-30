<?php

namespace App\Contracts\Payroll;


interface DepuEmpPayrollContract
{
    public function findPrYears($id = null);
    public function findFinYears();
    public function findPrMonths($id = null);
    public function findPrMonthsByYear($year = null);
    public function findPrMonthsByYearId($id = null);
    public function findPrSalaryHeadsBasic($id = null);
    public function findPrSalaryHeads($id = null,$emp_id=null);
    public function getEmpSalaryAllocatedHead($id);

    /**
     * Get Employee billedCodes
     *
     * @param $empId
     * @return mixed
     */
    public function getEmployeeSalaryProcessBilledCodes($empId);

    /**
     * Employee bill codes
     * @return mixed
     */
    public function getEmployeeBillCodes();
 }
