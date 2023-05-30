<?php

namespace App\Entities\Payroll;

use App\Entities\Admin\LDesignation;
use Illuminate\Database\Eloquent\Model;

class PrSalaryProcess extends Model
{
    protected $table = 'pr_salary_process';
    protected $primaryKey = 'pr_process_id';

    protected $appends = ['formatted_salary', 'formatted_sum_allowance', 'formatted_sum_deduction','formatted_bonus'];

    protected $hidden = ['calculation'];

    protected $with = ['designation'];


    public function getFormattedSalaryAttribute() {
        if ($this->salary)
        return number_format($this->salary,2);

        return 0;
    }

    public function getFormattedBonusAttribute() {
        if ($this->bonus)
            return number_format($this->bonus,2);

        return 0;
    }

    public function getFormattedSumAllowanceAttribute() {
        if ($this->sum_allowance)
            return number_format($this->sum_allowance,2);

        return 0;
    }

    public function getFormattedSumDeductionAttribute() {
        if ($this->sum_deduction)
            return number_format($this->sum_deduction,2);

        return 0;
    }

    public function designation() {
        return $this->belongsTo(LDesignation::class, 'designation_id');
    }

    public function pr_months() {
        return $this->belongsTo(PrMonths::class, 'pr_month_id','pr_month_id');
    }

}
