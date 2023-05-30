<?php

namespace App\Entities\Pmis\Employee;

use App\Entities\Admin\LFamilyMemberStatus;
use App\Entities\Admin\LGender;
use App\Entities\Admin\LAuthDocType;
use App\Entities\Admin\LGeoDistrict;
use App\Entities\Admin\LGeoThana;
use App\Entities\Admin\LMaritalStatus;
use App\Entities\Admin\LRelationType;
use App\Entities\Security\User;
use Illuminate\Database\Eloquent\Model;

class EmpFamilyTemp extends Model
{
    protected $table = 'emp_family_temp';
    protected $fillable = [ 'emp_id','emp_member_name','emp_member_name_bng','emp_member_relation','emp_member_address','emp_member_dob','emp_member_mobile','emp_member_auth_id',
        'emp_member_medical_id',
        'emp_member_gender_id' ,
        'emp_member_status_id',
        'emp_member_allowance_yn'
    ];
    public $timestamps = false;
    protected $primaryKey = "emp_family_id";
    public $incrementing = false;

    protected $appends = ['last_updated_by'];

    protected $with = ['gender', 'relation', 'family_status','nominee_info', 'auth_doc_type','district', 'thana','marital_status'];

    public function gender() {
        return $this->belongsTo(LGender::class, 'gender_id');
    }

    public function relation() {
        return $this->belongsTo(LRelationType::class, 'relation_type_id');
    }

    public function family_status() {
        return $this->belongsTo(LFamilyMemberStatus::class, 'family_member_status_id');
    }

    public function nominee_info(){
        return $this->belongsTo(EmpNomineeTemp::class,'emp_family_id','emp_family_id');
    }

    public function auth_doc_type(){
        return $this->belongsTo(LAuthDocType::class,'auth_doc_type_id');
    }

    public function district()
    {
        return $this->belongsTo(LGeoDistrict::class, 'district_id');
    }

    public function thana()
    {
        return $this->belongsTo(LGeoThana::class, 'thana_id');
    }
    public function marital_status()
    {
        return $this->belongsTo(LMaritalStatus::class, 'marital_status_id');
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


