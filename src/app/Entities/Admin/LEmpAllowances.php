<?php


namespace App\Entities\Admin;


use Illuminate\Database\Eloquent\Model;

class LEmpAllowances extends Model
{
    protected $table = "l_emp_allowances";
    protected $primaryKey = "id";
    protected $appends = ['text', 'value'];

    public function getTextAttribute() {
        return $this->amount;
    }

    public function getValueAttribute() {
        return $this->id;
    }
}
