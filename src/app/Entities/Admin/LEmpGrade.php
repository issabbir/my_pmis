<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LEmpGrade extends Model
{
    protected $table = "l_emp_grade";
    protected $primaryKey = "emp_grade_id";

   protected $appends = ['text', 'value'];

    public function getTextAttribute() {
        $format = $this->emp_grade_id.' ('.$this->grade_range.')';
        return $format;
    }

    public function getValueAttribute() {
        return $this->emp_grade_id;
    }
}
