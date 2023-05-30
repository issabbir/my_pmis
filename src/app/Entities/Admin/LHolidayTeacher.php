<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class LHolidayTeacher extends Model
{
    protected $table = "l_holiday_teacher";
    protected $primaryKey = "holiday_id";
    protected $fillable = ['holiday_id','holiday', 'holiday_bng', 'date_from', 'date_to','description'];


}
