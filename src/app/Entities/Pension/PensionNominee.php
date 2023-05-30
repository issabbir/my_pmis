<?php


namespace App\Entities\Pension;

use App\Entities\Admin\LDepartment;
use App\Entities\Admin\LDesignation;
use App\Entities\Admin\LEmpGrade;
use App\Entities\Admin\LGender;
use App\Entities\Admin\LRelationType;
use App\Entities\Admin\LReligion;
use Illuminate\Database\Eloquent\Model;

class PensionNominee extends Model
{
    protected $table = "pmis.pension_nominee";
    protected $primaryKey = "nominee_id";
    protected $with = ["gender", "religion", "grade", "designation", "department","relations"];
    public $timestamps = false;

    public function gender()
    {
        return $this->belongsTo(LGender::class, 'emp_gender_id');
    }

    public function religion()
    {
        return $this->belongsTo(LReligion::class, 'emp_religion_id');
    }

    public function relations()
    {
        return $this->belongsTo(LRelationType::class, 'relationship_id');
    }

    public function grade()
    {
        return $this->belongsTo(LEmpGrade::class, 'emp_grade_id');
    }

    public function designation()
    {
        return $this->belongsTo(LDesignation::class, 'designation_id');
    }

    public function department()
    {
        return $this->belongsTo(LDepartment::class, 'dpt_department_id');
    }

}
