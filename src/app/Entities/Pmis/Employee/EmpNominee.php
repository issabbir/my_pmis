<?php

namespace App\Entities\Pmis\Employee;

use App\Entities\Admin\LBank;
use App\Entities\Admin\LBranch;
use App\Entities\Admin\LGender;
use App\Entities\Admin\LGeoDistrict;
use App\Entities\Admin\LMaritalStatus;
use App\Entities\Admin\LNomineeFor;
use App\Entities\Admin\LRelationType;
use App\Entities\Security\User;
use Illuminate\Database\Eloquent\Model;

class EmpNominee extends Model
{
    protected $table = 'emp_nominee';
    protected $primaryKey = 'nominee_id';
    protected $with = ['gender', 'marital_status', 'relationship', 'district', 'nominee_for', 'bank', 'branch', 'emp_family'];

    protected $appends = ['edit_yn','last_updated_by'];

    public $timestamps = false;

    public function gender()
    {
        return $this->belongsTo(LGender::class, 'nominee_gender_id');
    }

    public function marital_status()
    {
        return $this->belongsTo(LMaritalStatus::class, 'nominee_marital_status_id');
    }

    public function nominee_for()
    {
        return $this->belongsTo(LNomineeFor::class, 'nominee_for_id');
    }

    public function emp_family()
    {
        return $this->belongsTo(EmpFamily::class, 'emp_family_id', 'emp_family_id');
    }

    public function relationship()
    {
        return $this->belongsTo(LRelationType::class, 'relationship_id');
    }

    public function district()
    {
        return $this->belongsTo(LGeoDistrict::class, 'district_id');
    }

    public function bank()
    {
        return $this->belongsTo(LBank::class, 'bank_id');
    }

    public function branch()
    {
        return $this->belongsTo(LBranch::class, 'branch_id');
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
    public function getEditYnAttribute() {
        return "N";
    }
}
