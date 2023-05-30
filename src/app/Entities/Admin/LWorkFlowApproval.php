<?php


namespace App\Entities\Admin;

use App\Entities\Security\Module;
use App\Entities\Security\Permission;
use Illuminate\Database\Eloquent\Model;

class LWorkFlowApproval extends Model
{
    protected $table = "l_approval_workflows";
    protected $primaryKey = "approval_workflow_id";
    public $sequence = "SEQ_WORKFLOW";
    protected $fillable = ['work_flow_name','work_flow_key'];
    public function module() {
        return $this->belongsTo(Module::class, 'module_id','module_id');
    }
    public function department() {
        return $this->belongsTo(LDepartment::class, 'department_id','department_id');
    }

}
