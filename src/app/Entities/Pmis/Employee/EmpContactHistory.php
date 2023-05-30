<?php

namespace App\Entities\Pmis\Employee;

use Illuminate\Database\Eloquent\Model;

class EmpContactHistory extends Model
{
    protected $table = 'emp_contacts_history';
    protected $primaryKey = null;
    public $incrementing = false;
}
