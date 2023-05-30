<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LExamResultType extends Model
{
    protected $table = "l_exam_result_type";
    protected $primaryKey = "exam_result_type_id";

    protected $appends = ['text', 'value'];

    public function getTextAttribute() {
        return $this->exam_result_type;
    }

    public function getValueAttribute() {
        return $this->exam_result_type_id;
    }
}
