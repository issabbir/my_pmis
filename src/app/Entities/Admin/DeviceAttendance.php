<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class DeviceAttendance extends Model
{
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
    protected $table = "attandance_device_data";
    protected $fillable = ['sl_no', 'device_name', 'access_time', 'access_mode', 'emp_code', 'access_date_time'];
}
