<?php


namespace App\Entities\Pension;


use Illuminate\Database\Eloquent\Model;

class EmpPensionDeathReg extends Model
{
    protected $table = "emp_pension_death_reg";
    protected $primaryKey = "register_id";
    protected $fillable = ['approve_status','approve_reject_comment'];
    public $timestamps = false;
}
