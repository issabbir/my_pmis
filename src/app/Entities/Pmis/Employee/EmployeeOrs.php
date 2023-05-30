<?php

namespace App\Entities\Pmis\Employee;

use Illuminate\Database\Eloquent\Model;

class EmployeeOrs extends Model
{
    protected $table = 'employee_ors';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
}
