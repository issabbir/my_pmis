<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LOtCategory extends Model
{
    protected $table = "l_ot_category";
    protected $primaryKey = "ot_category_id";

    protected $appends = ['text', 'value'];

    public function getTextAttribute() {
        return $this->ot_category;
    }

    public function getValueAttribute() {
        return $this->ot_category_id;
    }
}
