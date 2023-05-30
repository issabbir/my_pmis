<?php

namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LInstitute extends Model
{
    protected $table = "l_institute";
    protected $primaryKey = "institute_id";
    protected $fillable = ['institute_id','institute_name','institute_name_bng'];
    public $sequence = "ID_FACTORY";
    public $timestamps = false;

    protected $appends = ['text', 'value'];

    protected function getTextAttribute() {
        return $this->institute_name;
    }

    protected function getValueAttribute() {
        return $this->institute_id;
    }
}
