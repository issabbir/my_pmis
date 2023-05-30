<?php


namespace App\Entities\Payroll;


use App\Entities\Pmis\Employee\Employee;
use Illuminate\Database\Eloquent\Model;

class PrBillCodeMapping extends Model
{
    protected $table = "pr_bill_code_mapping";
    protected $primaryKey = 'bill_mapping_id';
    public $with  = ['employee'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'biller_emp_id');
    }
}