<?php

namespace App\Contracts\Pmis\Employee;


interface EmployeeContract
{
    public function employeeOption($name);
    public function unapprovedEmployee();
    public function UnapprovedEmployeeOption($name);
    public function securityEmployeeOption($name,$userId);
    public function chargeBaseEmployeeOption($name);
    public function dptBasedEmployeeOption($name,$dptId);
    public function billerOption($name);
    public function otEmployeeOption($name);
    public function otEmployeeOptionSameAsRoster($name);
    public function otEmployeeOptionSameAsRosterByDept($name,$dept_id);
    public function unRegisteredOtEmployeeOptionToEntryNewEmployee($name,$dept_id);
    public function otEmployeeOptionToSearchRegisteredEmployee($name,$dept_id);
    public function gpfEmployees($search, $option);
    public function gpfEmployeeSelf($search, $option);
    public function nonGpfEmployees($search);
}
