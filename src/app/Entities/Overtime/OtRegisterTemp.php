<?php

namespace App\Entities\Overtime;
use App\Entities\Pmis\Employee\Employee;
use Illuminate\Database\Eloquent\Model;

class OtRegisterTemp extends Model
{
    protected $table = 'ot_register_temp';
    protected $primaryKey = '';

    public function employee() {
        return $this->belongsTo(Employee::class, 'emp_id');
    }





}
