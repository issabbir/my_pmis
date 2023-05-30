<?php

namespace App\Entities\Overtime;
use App\Entities\Pmis\Employee\Employee;
use Illuminate\Database\Eloquent\Model;

class OtCalProcess extends Model
{
    protected $table = 'ot_cal_process';
    protected $primaryKey = '';

    protected $with = ['employee','division','designation'];

    public function employee() {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
    public function division() {
        return $this->belongsTo(Employee::class, 'DPT_DIVISION_ID');
    }
    public function designation() {
        return $this->belongsTo(Employee::class, 'DESIGNATION_ID');
    }



}
