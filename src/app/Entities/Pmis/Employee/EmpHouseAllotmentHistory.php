<?php

namespace App\Entities\Pmis\Employee;

use App\Entities\Admin\LBuildingType;
use Illuminate\Database\Eloquent\Model;

class EmpHouseAllotmentHistory extends Model
{
    protected $table = 'emp_house_allotement_history';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $with = ['building_type'];

    public function building_type()
    {
        return $this->belongsTo(LBuildingType::class, 'building_type_id');
    }
}
