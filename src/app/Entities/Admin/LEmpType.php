<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LEmpType extends Model
{
    protected $table = "l_emp_type";
    protected $primaryKey = "emp_type_id";

    protected $appends = ['text', 'value'];

    public function getTextAttribute() {
        return $this->emp_type_name;
    }

    public function getValueAttribute() {
        return $this->emp_type_id;
    }
}
