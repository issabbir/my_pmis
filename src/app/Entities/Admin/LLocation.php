<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LLocation extends Model
{
    protected $table = "l_location";
    protected $primaryKey = "location_id";
    protected $appends = ['text', 'value'];
    public function getTextAttribute() {
        return $this->working_location;
    }

    public function getValueAttribute() {
        return $this->location_id;
    }
}
