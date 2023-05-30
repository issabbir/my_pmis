<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class WorkFlowProcess extends Model
{
    protected $table = "workflow_process";
    protected $primaryKey = "workflow_process_id";

    protected $fillable = ['workflow_object_id','workflow_step_id','note'];
    protected $with = ['workflowStep'];

    public function workflowStep(){
        return $this->belongsTo(WorkFlowStep::class, 'workflow_step_id');
    }
}
