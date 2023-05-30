<?php


namespace App\Entities\Overtime;


use App\Entities\Admin\LDepartment;
use App\Entities\Admin\LDesignation;
use App\Entities\Admin\LDptDivision;
use App\Entities\Pmis\Employee\EmpLeave;
use App\Entities\Pmis\Employee\Employee;
use Illuminate\Database\Eloquent\Model;

class OtRosterGroup extends Model
{
    protected $table = 'ot_roster_group';
    protected $primaryKey = 'group_id';

    protected $appends = ['text', 'value', 'emp_name'];
    protected $with = ['dptDivision','department','designation'];

    public function dptDivision()
    {
        return $this->belongsTo(LDptDivision::class, 'dpt_division_id');
    }

    public function department()
    {
        return $this->belongsTo(LDepartment::class, 'dpt_department_id');
    }


    public function designation()
    {
        return $this->belongsTo(LDesignation::class, 'designation_id');
    }


    protected function getTextAttribute() {
        return $this->group_name;
    }

    protected function getValueAttribute() {
        return $this->group_id;
    }

    protected function employee() {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
    protected function getEmpNameAttribute() {
        $employee = $this->employee()->first('emp_name');
        if ($employee)
        return $employee->emp_name;

        return "";
    }


}
