<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LExamBody extends Model
{
    protected $table = "l_exam_body";
    protected $primaryKey = "exam_body_id";

    protected $appends = ['text', 'value'];

    protected $fillable = ['exam_name', 'exam_name_bng', 'public_yn','insert_date'];

    public function getTextAttribute()
    {
        return $this->exam_body_name;
    }

    public function getValueAttribute()
    {
        return $this->exam_body_id;
    }

    public function institutes()
    {
        return $this->belongsToMany(LInstitute::class, 'l_exam_body_institute_mapping', 'exam_body_id', 'institute_id');
    }
}
