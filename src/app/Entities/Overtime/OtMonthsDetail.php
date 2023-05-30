<?php


namespace App\Entities\Overtime;


use Illuminate\Database\Eloquent\Model;

class OtMonthsDetail extends Model
{
    protected $table = 'ot_months_detail';
    protected $primaryKey = 'ot_month_detail_id';

    protected $appends = ['text', 'value'];

    protected function getTextAttribute() {
        $effective_start_date = date('d-m-Y', strtotime($this->effective_start_date));
        $effective_end_date = date('d-m-Y', strtotime($this->effective_end_date));

        return "{$effective_start_date} - {$effective_end_date}";
    }

    protected function getValueAttribute() {
        return $this->ot_month_detail_id;
    }
}
