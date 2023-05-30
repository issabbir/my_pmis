<?php

namespace App\Entities\Pmis\Employee;

use App\Entities\Admin\LChargeType;
use App\Entities\Admin\LDepartment;
use App\Entities\Admin\LEmpGrade;
use App\Entities\Pmis\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use App\Entities\Admin\LDesignation;
use App\Entities\Admin\LDptDivision;
use App\Entities\Admin\LDptSection;
use App\Entities\Admin\LEmpType;

class ChargeEntry extends Model
{
    protected $table = 'charge_entry';
    protected $primaryKey = 'charge_entry_id';
    protected $with = [
        'chargeType',
        'employee',
        'division',
        'charge_division',
        'department',
        'charge_department',
        'section',
        'charge_section',
        'designation',
        'charge_designation',
        'employeeGrade',
        'charge_employeeGrade'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }

    public function chargeType()
    {
        return $this->belongsTo(LChargeType::class, 'charge_type_id');
    }
    public function division()
    {
        return $this->belongsTo(LDptDivision::class, 'dpt_division_id');
    }

    public function charge_division()
    {
        return $this->belongsTo(LDptDivision::class, 'charge_dpt_division_id');
    }

    public function dptDivision()
    {
        return $this->belongsTo(LDptDivision::class, 'dpt_division_id');
    }

    public function department()
    {
        return $this->belongsTo(LDepartment::class, 'dpt_department_id');
    }
    public function charge_department()
    {
        return $this->belongsTo(LDepartment::class, 'charge_dpt_department_id');
    }

    public function section()
    {
        return $this->belongsTo(LDptSection::class, 'section_id');
    }

    public function charge_section()
    {
        return $this->belongsTo(LDptSection::class, 'charge_section_id');
    }

    public function designation()
    {
        return $this->belongsTo(LDesignation::class, 'designation_id');
    }

    public function charge_designation()
    {
        return $this->belongsTo(LDesignation::class, 'charge_designation_id');
    }

    public function employeeGrade()
    {
        return $this->belongsTo(LEmpGrade::class, 'emp_grade_id');
    }

    public function charge_employeeGrade()
    {
        return $this->belongsTo(LEmpGrade::class, 'charge_emp_grade_id');
    }

    public function empGrade()
    {
        return $this->belongsTo(LEmpGrade::class, 'emp_grade_id');
    }

    public function chargeDptDivision(){
        return $this->belongsTo(LDptDivision::class,'charge_dpt_division_id');
    }
    public function chargeDepartment(){
        return $this->belongsTo(LDepartment::class,'charge_dpt_department_id');
    }
    public function chargeDesignation(){
        return $this->belongsTo(LDesignation::class,'charge_designation_id');
    }

}
