<?php


namespace App\Entities\Pmis\Employee;


use App\Entities\Admin\LDepartment;
use App\Entities\Admin\LDesignation;
use App\Entities\Admin\LDptDivision;
use App\Entities\Admin\LEmpGrade;
use App\Entities\Admin\LEmpStatus;
use App\Entities\Admin\LGradeSteps;
use Illuminate\Database\Eloquent\Model;

class EmpPromotions extends Model
{
    protected $table = 'emp_promotions';
    protected $primaryKey = 'promotion_id';
    protected $with = [
        'employee',
        'division_from',
        'division_to',
        'department_from',
        'department_to',
        'designation_from',
        'designation_to',
        'grade_from',
        'grade_to',
        'grade_step_from',
        'grade_step_to',
        'actual_grade'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }

    public function division_from()
    {
        return $this->belongsTo(LDptDivision::class, 'division_id_from','dpt_division_id');
    }

    public function division_to()
    {
        return $this->belongsTo(LDptDivision::class, 'division_id_to','dpt_division_id');
    }

    public function department_from()
    {
        return $this->belongsTo(LDepartment::class, 'department_id_from','department_id');
    }

    public function department_to()
    {
        return $this->belongsTo(LDepartment::class, 'department_id_to','department_id');
    }

    public function designation_from()
    {
        return $this->belongsTo(LDesignation::class, 'designation_id_from','designation_id');
    }

    public function designation_to()
    {
        return $this->belongsTo(LDesignation::class, 'designation_id_to','designation_id');
    }

    public function grade_from()
    {
        return $this->belongsTo(LEmpGrade::class, 'grade_id_from','emp_grade_id');
    }

    public function grade_to()
    {
        return $this->belongsTo(LEmpGrade::class, 'grade_id_to','emp_grade_id');
    }

    public function grade_step_from()
    {
        return $this->belongsTo(LGradeSteps::class, 'grade_step_id_from','grade_steps_id');
    }

    public function grade_step_to()
    {
        return $this->belongsTo(LGradeSteps::class, 'grade_step_id_to','grade_steps_id');
    }

    public function actual_grade()
    {
        return $this->belongsTo(LEmpGrade::class, 'actual_grade_id','emp_grade_id');
    }
}
