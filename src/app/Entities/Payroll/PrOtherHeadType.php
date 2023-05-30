<?php


namespace App\Entities\Payroll;

use Illuminate\Database\Eloquent\Model;

class PrOtherHeadType extends Model
{
    protected $table = "pr_other_head_type";
    protected $primaryKey = 'other_head_type_id';
    protected $appends = ['text', 'value'];

    protected function getTextAttribute() {
        return $this->other_head_type;
    }

    protected function getValueAttribute() {
        return $this->other_head_type_id;
    }
}
