<?php


namespace App\Entities\Pension;


use Illuminate\Database\Eloquent\Model;

class PensionDeptAckmentSetup extends Model
{
    protected $table = "pmis.pension_dept_ackment_setup";
    public $primaryKey = 'ackment_setup_id';
    public $timestamps = false;
}
