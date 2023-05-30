<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LAppointmentType extends Model
{
    protected $table = "l_appoinment_type";
    protected $primaryKey = "appoinment_type_id";

    protected $appends = ['text', 'value'];

    public function getTextAttribute() {
        return $this->appoinment_type;
    }

    public function getValueAttribute() {
        return $this->appoinment_type_id;
    }
}
