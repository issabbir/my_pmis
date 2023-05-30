<?php


namespace App\Entities\Overtime;


use Illuminate\Database\Eloquent\Model;

class OtGroupMst extends Model
{
    protected $table = 'ot_group_mst';
    protected $primaryKey = 'ot_group_id';

    protected $appends = ['text', 'value'];


    protected function getTextAttribute() {
        return $this->group_name;
    }

    protected function getValueAttribute() {
        return $this->ot_group_id;
    }
}
