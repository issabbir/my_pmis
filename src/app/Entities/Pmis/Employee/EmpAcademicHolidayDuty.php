<?php

namespace App\Entities\Pmis\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpAcademicHolidayDuty extends Model
{
    protected $table = 'EMP_ACADEMIC_HOLIDAY_DUTY';
    protected $primaryKey = 'emp_id';
    protected $sequence = 'emp_academic_id_seq';
    public $incrementing = false;

    public $timestamps = false;

    protected $with = ['employee'];

    public function employee() {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
}
