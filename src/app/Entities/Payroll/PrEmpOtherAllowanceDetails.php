<?php


namespace App\Entities\Payroll;

use App\Entities\Admin\LDepartment;
use App\Entities\Pmis\Employee\Employee;
use Illuminate\Database\Eloquent\Model;

class PrEmpOtherAllowanceDetails extends Model
{
    protected $table = "pr_other_allowance_dtl";
    protected $primaryKey = 'other_allowance_dtl_id';
    public $sequence = 'pr_process_id_seq';

    public $with = ['employee'];
    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id');
    }
}
