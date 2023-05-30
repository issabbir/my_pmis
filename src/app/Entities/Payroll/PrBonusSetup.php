<?php
namespace App\Entities\Payroll;

use Illuminate\Database\Eloquent\Model;

class PrBonusSetup extends Model
{
    protected $table = "pr_bonus_setup";
    protected $primaryKey = 'bonus_setup_id';
    protected $with = ['pr_months','salary_heads'];

    public function pr_months()
    {
        return $this->belongsTo(PrMonths::class, 'pr_month_id');
    }
    public function  salary_heads()
    {
        return $this->belongsTo(PrSalaryHeads::class, 'salary_head_id');
    }
}
