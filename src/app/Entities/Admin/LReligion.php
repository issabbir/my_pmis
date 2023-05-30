<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LReligion extends Model
{
    protected $table = "l_religion";
    protected $primaryKey = "religion_id";

    protected $appends = ['text', 'value'];


    protected function getTextAttribute() {
        return $this->religion;
    }

    protected function getValueAttribute() {
        return $this->religion_id;
    }

}
