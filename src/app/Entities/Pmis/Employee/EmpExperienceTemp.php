<?php

namespace App\Entities\Pmis\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpExperienceTemp extends Model
{
    protected $table = 'emp_experience_temp';
    protected $primaryKey = 'experience_id';
    public $incrementing = false;
}
