<?php

namespace App\Entities\Pmis\Employee;

use App\Entities\Security\User;
use Illuminate\Database\Eloquent\Model;
use App\Entities\Admin\LContactType;
class EmpContactTemp extends Model
{
    protected $table = 'emp_contacts_temp';
    protected $primaryKey = 'emp_contacts_id';
    public $incrementing = false;

    protected $with = ['contact_type'];

    protected $appends = ['last_updated_by'];

    public function contact_type() {
        return $this->belongsTo(LContactType::class, 'emp_contact_type_id');
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
