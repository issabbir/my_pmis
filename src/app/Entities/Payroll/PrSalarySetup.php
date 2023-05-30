<?php
namespace App\Entities\Payroll;

use Illuminate\Database\Eloquent\Model;

class PrSalarySetup extends Model
{
    protected $table = "pr_salary_setup";
    protected $primaryKey = null;
    protected $appends = ['text', 'value'];
    protected $with = ['pr_months','salary_heads'];

    protected function getTextAttribute() {
        return $this->address_type;
    }

    protected function getValueAttribute() {
        return $this->address_type_id;
    }

    public function pr_months()
    {
        return $this->belongsTo(PrMonths::class, 'pr_month_id');
    }
    public function  salary_heads()
    {
        return $this->belongsTo(PrSalaryHeads::class, 'salary_head_id');
    }
}
