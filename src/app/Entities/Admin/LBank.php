<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LBank extends Model
{
    protected $table = "l_banks";
    protected $primaryKey = "bank_id";
    public $timestamps = false;
    public $sequence = "bank_sequence";
    protected $appends = ['text', 'value'];


    protected function getTextAttribute() {
        return $this->bank_name;
    }

    protected function getValueAttribute() {
        return $this->bank_id;
    }
}