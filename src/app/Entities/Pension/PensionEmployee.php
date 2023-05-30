<?php


namespace App\Entities\Pension;


use App\Entities\Admin\LBloodGroup;
use App\Entities\Admin\LDepartment;
use App\Entities\Admin\LDesignation;
use App\Entities\Admin\LDptDivision;
use App\Entities\Admin\LDptSection;
use App\Entities\Admin\LEmpGrade;
use App\Entities\Admin\LEmpStatus;
use App\Entities\Admin\LEmpType;
use App\Entities\Admin\LGender;
use App\Entities\Admin\LNationality;
use App\Entities\Admin\LQuota;
use App\Entities\Admin\LRelationType;
use App\Entities\Admin\LReligion;
use Illuminate\Database\Eloquent\Model;

class PensionEmployee extends Model
{
    protected $table = "pmis.pension_employee";
    protected $appends = ['pension_status',"monthly_amount",'pension_amt_pct'];
    protected $with = ["gender", "religion", "bloodGroup", "quota", "grade", "designation", "department","relations","empType"];

    public function gender()
    {
        return $this->belongsTo(LGender::class, 'emp_gender_id');
    }

    public function religion()
    {
        return $this->belongsTo(LReligion::class, 'emp_religion_id');
    }

    public function bloodGroup()
    {
        return $this->belongsTo(LBloodGroup::class, 'emp_blood_group_id');
    }

    public function quota()
    {
        return $this->belongsTo(LQuota::class, 'emp_quota_id');
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
    public function empType()
    {
        return $this->belongsTo(LEmpType::class, 'emp_type_id');
    }

    public function getPensionStatusAttribute($value)
    {
        if ($this->on_pension_yn === 'Y') {
            return 'YES';
        }

        return 'NO';
    }
    public function getMonthlyAmountAttribute($value)
    {

        if ($this->pension_pct == 100) {
            $pension_amt = 0;
        }else{
            $pension_amt = $this->pension_amt;
        }
        $totall = number_format($this->medical_allow + $pension_amt,2);

        return $totall;
    }
    public function getPensionAmtPctAttribute($value)
    {
        if ($this->pension_pct == 100) {
            return 0;
        }

        return $this->pension_amt;
    }
}
