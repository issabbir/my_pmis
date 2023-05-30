<?php

namespace App\Entities\Pmis\Employee;

use App\Entities\Admin\LBloodGroup;
use App\Entities\Admin\LDepartment;
use App\Entities\Admin\LDesignation;
use App\Entities\Admin\LDptDivision;
use App\Entities\Admin\LDptSection;
use App\Entities\Admin\LEmpGrade;
use App\Entities\Admin\LEmpStatus;
use App\Entities\Admin\LGender;
use App\Entities\Admin\LLocation;
use App\Entities\Admin\LOtCategory;
use App\Entities\Admin\LReligion;
use App\Entities\Admin\LSalutation;
use App\Entities\Security\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class EmployeeTemp extends Model
{
    protected $table = 'employee_temp';
    protected $primaryKey = 'emp_id';
    public $incrementing = false;
    protected $with = ['dptDivision','department','current_department','designation', 'salutation_id','emp_gender_id','ot_category_id','emp_religion_id', 'section','grade','actualGrade','joiningGrade','location','emp_status','emp_blood_group_id'];

//    protected $casts = [
//        'emp_lpr_date'  => 'date:d-m-Y',
//        'emp_join_date' => 'date:d-m-Y',
//    ];
    protected $appends=['joindate','lprdate','last_updated_by'];

    public  function  getJoindateAttribute() {
        return  Carbon::parse($this->emp_join_date)->format('d/m/Y');
    }
    public function emp_status()
    {
        return $this->belongsTo(LEmpStatus::class, 'emp_status_id');
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

    public function current_department()
    {
        return $this->belongsTo(LDepartment::class, 'current_department_id');
    }

    public function salutation_id()
    {
        return $this->belongsTo(LSalutation::class, 'salutation_id','salutation_id');
    }

    public function emp_gender_id()
    {
        return $this->belongsTo(LGender::class, 'emp_gender_id');
    }

    public function emp_religion_id()
    {
        return $this->belongsTo(LReligion::class, 'emp_religion_id');
    }
    public function ot_category_id()
    {
        return $this->belongsTo(LOtCategory::class, 'ot_category_id');
    }

    public function section()
    {
        return $this->belongsTo(LDptSection::class, 'section_id');
    }

    public function grade()
    {
        return $this->belongsTo(LEmpGrade::class, 'emp_grade_id');
    }
    public function actualGrade()
    {
        return $this->belongsTo(LEmpGrade::class, 'actual_grade_id');
    }
    public function joiningGrade()
    {
        return $this->belongsTo(LEmpGrade::class, 'joining_grade_id');
    }
    public function  location(){
        return $this->belongsTo(LLocation::class,'location_id');
    }
    public  function emp_blood_group_id(){
        return $this->belongsTo(LBloodGroup::class,'emp_blood_group_id');
    }
    public function insertBy()
    {
        return $this->belongsTo(User::class, 'insert_by');
    }

    public function updateBy()
    {
        return $this->belongsTo(User::class, 'update_by');
    }

    public function getLastUpdatedByAttribute() {
        $emp_name = '';
        if (isset($this->updateBy) && $this->updateBy->emp_id){
            $emp_name =  Employee::where('emp_id',$this->updateBy->emp_id)->pluck('emp_name')->first();
        }
        if (isset($this->insertBy) && $this->insertBy->emp_id)
        {
            $emp_name =  Employee::where('emp_id',$this->insertBy->emp_id)->pluck('emp_name')->first();
        }

        return $emp_name;
    }
}
