<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LGeoThana extends Model
{
    protected $table = "l_geo_thana";
    protected $primaryKey = "geo_thana_id";
    protected $appends = ['text', 'value'];
    public $with = ['district'];

    protected function getTextAttribute() {
        return $this->geo_thana_name;
    }

    protected function getValueAttribute() {
        return $this->geo_thana_id;
    }

    public function district(){
        return $this->belongsTo(LGeoDistrict::class, 'geo_district_id');
    }
}
