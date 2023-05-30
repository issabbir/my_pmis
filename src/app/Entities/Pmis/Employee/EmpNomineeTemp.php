<?php

namespace App\Entities\Pmis\Employee;

use App\Entities\Admin\LGender;
use App\Entities\Admin\LGeoDistrict;
use App\Entities\Admin\LMaritalStatus;
use App\Entities\Admin\LRelationType;
use App\Entities\Admin\LBank;
use App\Entities\Admin\LBranch;
use App\Entities\Admin\LNomineeFor;
use Illuminate\Database\Eloquent\Model;

class EmpNomineeTemp extends Model
{
    protected $table = 'emp_nominee_temp';
    protected $primaryKey = 'nominee_id';
    public $incrementing = false;


    protected $with = ['gender', 'marital_status', 'relationship', 'district', 'nominee_for', 'bank', 'branch'];

    protected $appends = ['edit_yn'];

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

    public function getEditYnAttribute() {
        return "N";
    }
}
