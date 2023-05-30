<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LGeoDistrict extends Model
{
    protected $table = "l_geo_district";
    protected $primaryKey = "geo_district_id";

    protected $appends = ['text', 'value'];
    public $with = ['division'];

    protected function getTextAttribute() {
        return $this->geo_district_name;
    }

    protected function getValueAttribute() {
        return $this->geo_district_id;
    }
    public function division(){
        return $this->belongsTo(LGeoDivision::class, 'geo_division_id');
    }
}
