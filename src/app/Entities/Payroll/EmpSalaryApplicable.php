<?php

namespace App\Entities\Payroll;
use App\Entities\Pmis\Employee\Employee;
use Illuminate\Database\Eloquent\Model;

class EmpSalaryApplicable extends Model
{
    protected $table = 'emp_salary_applicable';
    protected $primaryKey = 'applicable_id';
    protected $fillable = ['emp_id','salary_head_id','salary_head_name', 'active_yn', 'description'];
    public $incrementing = false;
    protected $with = ['salaryheadtype'];

    public function salaryheadtype()
    {
        return $this->belongsTo(PrSalaryHeads::class, 'salary_head_id');
    }

    public function employee() {
        return $this->belongsTo(Employee::class, 'emp_id');
    }

}
