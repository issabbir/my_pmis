<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LPrBillStatus extends Model
{
    protected $table = "l_pr_bill_status";
    protected $primaryKey = "pr_bill_status_id";

    protected $appends = ['text', 'value'];


    protected function getTextAttribute() {
        return $this->status_name;
    }

    protected function getValueAttribute() {
        return $this->pr_bill_status_id;
    }
}