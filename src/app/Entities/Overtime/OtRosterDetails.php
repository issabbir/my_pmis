<?php


namespace App\Entities\Overtime;


use App\Entities\Admin\LDepartment;
use App\Entities\Admin\LDesignation;
use App\Entities\Admin\LDptSection;
use App\Entities\Admin\LOtCategory;
use App\Entities\Admin\LRosterShift;
use Illuminate\Database\Eloquent\Model;

class OtRosterDetails extends Model
{
    protected $table = 'ot_roster_details';
    protected $primaryKey = 'roster_id';
    protected $with = ['shift', 'designation', 'department', 'section', 'ot_category'];

    public function shift() {
        return $this->belongsTo(LRosterShift::class, "shift_id");
    }

    public function designation() {
        return $this->belongsTo(LDesignation::class, "designation_id");
    }

    public function department()
    {
        return $this->belongsTo(LDepartment::class, "department_id");
    }

    public function section()
    {
        return $this->belongsTo(LDptSection::class, "section_id");
    }

    public function ot_category()
    {
        return $this->belongsTo(LOtCategory::class, "ot_category_id");
    }
}
