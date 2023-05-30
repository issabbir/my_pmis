<?php

namespace App\Entities\Pmis\Employee;

use App\Entities\Admin\LAddressType;
use App\Entities\Admin\LGeoDistrict;
use App\Entities\Admin\LGeoDivision;
use App\Entities\Admin\LGeoThana;
use App\Entities\Security\User;
use Illuminate\Database\Eloquent\Model;

class EmpAddressTemp extends Model
{
    protected $table = 'emp_addresses_temp';
    protected $primaryKey = 'emp_address_id';
    public $incrementing = false;

    protected $with = ['address_type', 'geo_division', 'geo_district', 'geo_thana'];

    protected $appends = ['last_updated_by'];

    public function address_type()
    {
        return $this->belongsTo(LAddressType::class, 'address_type_id');
    }

    public function geo_division()
    {
        return $this->belongsTo(LGeoDivision::class, 'division_id');
    }
    public function geo_district()
    {
        return $this->belongsTo(LGeoDistrict::class, 'district_id');
    }
    public function geo_thana()
    {
        return $this->belongsTo(LGeoThana::class, 'thana_id');
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
