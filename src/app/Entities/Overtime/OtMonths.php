<?php


namespace App\Entities\Overtime;


use Illuminate\Database\Eloquent\Model;

class OtMonths extends Model
{
    protected $table = 'ot_months';
    protected $primaryKey = 'ot_month_id';

    protected $appends = ['text', 'value', 'monthlabel'];


    protected function getTextAttribute() {
        return $this->ot_month;
    }

    protected function getValueAttribute() {
        return $this->ot_month_id;
    }

    protected function getMonthlabelAttribute()
    {
        $ot_month = (int) $this->ot_month;

        $yearMonth = "{$this->ot_year}-{$ot_month}-01";

        return date('Y-F', strtotime($yearMonth));
    }
}
