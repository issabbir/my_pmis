<?php


namespace App\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class WorkFlowStep extends Model
{
    protected $table = "workflow_steps";
    protected $primaryKey = "workflow_step_id";
    protected $fillable = ['approval_workflow_id','workflow','workflow_key','user_role','process_step','enabled_yn','insert_date'];
    protected $appends = ['edit_yn'];
    public $timestamps = false;
    public $sequence = 'SEQ_WORKFLOW_STEP';


    public function getEditYnAttribute() {
        return "N";
    }
}
