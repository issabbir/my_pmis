<?php


namespace App\Entities\Overtime;


use Illuminate\Database\Eloquent\Model;

class LOTCategory extends Model
{
    protected $table = 'L_OT_CATEGORY';
    protected $primaryKey = 'OT_CATEGORY_ID';

    protected $appends = ['text', 'value'];


    protected function getTextAttribute() {
        return $this->ot_category;
    }

    protected function getValueAttribute() {
        return $this->ot_category_id;
    }
}
