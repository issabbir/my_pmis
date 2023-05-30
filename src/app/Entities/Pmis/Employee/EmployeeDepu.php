<?php

namespace App\Entities\Pmis\Employee;

use App\Entities\Admin\LBloodGroup;
use App\Entities\Admin\LDepartment;
use App\Entities\Admin\LDesignation;
use App\Entities\Admin\LDptDivision;
use App\Entities\Admin\LDptSection;
use App\Entities\Admin\LEmpGrade;
use App\Entities\Admin\LGender;
use App\Entities\Admin\LLocation;
use App\Entities\Admin\LOtCategory;
use App\Entities\Admin\LReligion;
use App\Entities\Admin\LSalutation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class EmployeeDepu extends Model
{
    protected $table = 'employee_depu';
    protected $primaryKey = 'emp_id';
    public $incrementing = false;
    protected $with = ['dptDivision','department','designation','emp_gender_id','emp_religion_id', 'section','grade','location','emp_blood_group_id'];

//    protected $casts = [
//        'emp_lpr_date'  => 'date:d-m-Y',
//        'emp_join_date' => 'date:d-m-Y',
//    ];
    protected $appends=['joindate','lprdate'];

    public  function  getJoindateAttribute() {
        return  Carbon::parse($this->emp_join_date)->format('d/m/Y');
    }
    public  function  getLprdateAttribute() {
        return  Carbon::parse($this->emp_lpr_date)->format('d/m/Y');
    }
    public function dptDivision()
    {
        return $this->belongsTo(LDptDivision::class, 'dpt_division_id');
    }
    public function designation()
    {
        return $this->belongsTo(LDesignation::class, 'designation_id');
    }

    public function department()
    {
        return $this->belongsTo(LDepartment::class, 'dpt_department_id');
    }

    public function emp_gender_id()
    {
        return $this->belongsTo(LGender::class, 'emp_gender_id');
    }

    public function emp_religion_id()
    {
        return $this->belongsTo(LReligion::class, 'emp_religion_id');
    }

    public function section()
    {
        return $this->belongsTo(LDptSection::class, 'section_id');
    }

    public function grade()
    {
        return $this->belongsTo(LEmpGrade::class, 'grade_id');
    }
    public function  location(){
        return $this->belongsTo(LLocation::class,'location_id');
    }
    public  function emp_blood_group_id(){
        return $this->belongsTo(LBloodGroup::class,'emp_blood_group_id');
    }
}
