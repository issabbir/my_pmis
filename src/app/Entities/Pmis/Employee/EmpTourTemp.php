<?php

namespace App\Entities\Pmis\Employee;

use App\Entities\Admin\LFamilyMemberStatus;
use App\Entities\Admin\LGender;
use App\Entities\Admin\LGeoCountry;
use App\Entities\Admin\LRelationType;
use App\Entities\Admin\LTourType;
use Illuminate\Database\Eloquent\Model;

class EmpTourTemp extends Model
{
    protected $table = 'emp_tours';
     protected $fillable = [ 'emp_id','tour_name','tour_name_bng','tour_type_id','country_id','note','travel_date','return_date',
        'tour_duration',
        'sponsor' ,
        'sponsor_bng'
    ];
    public $timestamps = false;
    protected $primaryKey = "tour_id";
    public $incrementing = false;

    protected $with = ['tour_type', 'country'];

    public function tour_type() {
        return $this->belongsTo(LTourType::class, 'tour_type_id');
    }

    public function country()
    {
        return $this->belongsTo(LGeoCountry::class, 'country_id');
    }
}
