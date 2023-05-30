<?php


namespace App\Entities\Payroll;

use Illuminate\Database\Eloquent\Model;

class PrMonths extends Model
{
    protected $table = "pr_months";
    protected $primaryKey = 'pr_month_id';
    protected $appends = ['text', 'value', 'formatted_month'];
    public $with  = ['fiscal_year'];
    protected function getTextAttribute() {
        return $this->pr_month;
    }

    protected function getValueAttribute() {
        return $this->pr_month_id;
    }

    public function fiscal_year()
    {
        return $this->belongsTo(PrFiscalYear::class, 'fy_id');
    }

    protected function getFormattedMonthAttribute() {
        return date('M-Y', strtotime($this->calculation_start_date));
    }


}
