<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LExam extends Model
{
    protected $table = "l_exam";
    protected $primaryKey = "exam_id";
    protected $appends = ['text', 'value'];
    public $sequence = "ID_FACTORY";



    public $timestamps =false;

    protected $fillable = ['exam_name'];
    public function getTextAttribute() {
        return $this->exam_name;
    }

    public function getValueAttribute() {
        return $this->exam_id;
    }

    public function exam_bodies() {
        return $this->belongsToMany(LExamBody::class, 'l_exam_body_mapping', 'exam_id','exam_body_id' );
    }

    public function exam_subjects() {
        return $this->belongsToMany(LExamSubject::class, 'l_exam_subject_mapping', 'exam_id','exam_subject_id' );
    }

    public function exam_result_types() {
        return $this->belongsToMany(LExamResultType::class, 'l_exam_result_type_mapping', 'exam_id','exam_result_type_id' );
    }
}
