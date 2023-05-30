<?php


namespace App\Entities\Payroll;

use App\Entities\Admin\LDepartment;
use Illuminate\Database\Eloquent\Model;

class PrEmpOtherAllowance extends Model
{
    protected $table = "pr_emp_other_allowance";
    protected $primaryKey = 'emp_other_allwoance_id';
    public $sequence = 'pr_process_id_seq';

    public $timestamps = false;

    public function headType(){
        return $this->belongsTo(PrOtherHeadType::class,'other_head_type_id');
    }
    public function other_allowance_details(){
        return $this->hasMany(PrEmpOtherAllowanceDetails::class,'other_allowance_id');
    }
    public function department(){
        return $this->belongsTo(LDepartment::class,'department_id');
    }
    public function pr_month(){
        return $this->belongsTo(PrMonths::class,'pr_month_id');
    }
}
