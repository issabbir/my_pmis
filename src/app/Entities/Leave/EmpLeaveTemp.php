<?php

namespace App\Entities\Leave;


use App\Entities\Admin\LLeaveType;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmployeeTemp;
use Illuminate\Database\Eloquent\Model;

class EmpLeaveTemp extends Model
{
    protected $table = 'emp_leave_temp';
    protected $primaryKey = 'leave_id';
    protected $fillable = ['emp_id', 'leave_type_id', 'application_date', 'approve_date', 'approve_by_emp_id','leave_start_date', 'leave_end_date','leave_days', 'leave_id', 'leave_approve_ref_no','leave_reason'];
    public $incrementing = false;
    protected $with = ['leavetype'];

    public function leavetype()
    {
        return $this->belongsTo(LLeaveType::class, 'leave_type_id');
    }

    public function employee() {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
}
