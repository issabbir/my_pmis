<?php


namespace App\Entities\Admin;


use Illuminate\Database\Eloquent\Model;

class LBillType extends Model
{
    protected $table = "l_bill_type";
    protected $primaryKey = "bill_type_id";

    protected $with=['approval_workflows'];

    public function approval_workflows(){
        return $this->belongsTo(LApprovalWorkflows::class, 'approval_workflow_id');
    }
}
