<?php

namespace App\Contracts\Payroll;


interface PayrollContract
{
    public function findPrYears($id = null);
    public function findFinYears();
    public function findPrMonths($id = null);
    public function findPrMonthsByYear($year = null, $bonusApplicable='N');
    public function findPrMonthsByYearId($id = null);
    public function findPrSalaryHeadsBasic($id = null);
    public function findPrSalaryHeads($id = null);

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
