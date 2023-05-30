<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LBloodGroup extends Model
{
    protected $table = "l_blood_group";
    protected $primaryKey = "blood_group_id";

    protected $appends = ['text', 'value'];


    protected function getTextAttribute() {
        return $this->blood_group;
    }

    protected function getValueAttribute() {
        return $this->blood_group_id;
    }
}
