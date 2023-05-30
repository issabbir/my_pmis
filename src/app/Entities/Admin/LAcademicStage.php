<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LAcademicStage extends Model
{
    protected $table = "l_academic_stage";
    protected $primaryKey = "stage_id";

     protected $appends = ['text', 'value'];

    public function getTextAttribute() {
        return $this->stage_name;
    }

    public function getValueAttribute() {
        return $this->stage_id;
    }
}
