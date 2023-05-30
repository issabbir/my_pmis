<?php


namespace App\Entities\Admin;


use Illuminate\Database\Eloquent\Model;

class LExamSubject extends Model
{
    protected $table = "l_exam_subject";
    protected $primaryKey = "exam_subject_id";
    protected $fillable = ['exam_subject_id','exam_subject_name','exam_subject_name_bng'];
    public $sequence = "ID_FACTORY";
    public $timestamps = false;

    protected $appends = ['text', 'value'];

    public function getTextAttribute() {
        return $this->exam_subject_name;
    }

    public function getValueAttribute() {
        return $this->exam_subject_id;
    }
}
