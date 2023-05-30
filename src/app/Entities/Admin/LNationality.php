<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LNationality extends Model
{
    protected $table = "l_nationality";
    protected $primaryKey = "nationality_id";

    protected $appends = ['text', 'value'];

    public function getTextAttribute() {
        return $this->nationality;
    }

    public function getValueAttribute() {
        return $this->nationality_id;
    }

}
