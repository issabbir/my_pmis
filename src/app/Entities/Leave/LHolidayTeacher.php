<?php


namespace App\Entities\Leave;


class LHolidayTeacher
{
    protected $table = 'l_holiday_teacher';
    protected $primaryKey = 'holiday_id';
    //public $incrementing = false;
    protected $fillable = ['holiday_id','holiday', 'holiday_bng', 'date_from', 'date_to','description', 'active_yn'];
}
