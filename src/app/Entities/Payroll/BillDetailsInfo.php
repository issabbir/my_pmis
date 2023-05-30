<?php


namespace App\Entities\Payroll;


use Illuminate\Database\Eloquent\Model;

class BillDetailsInfo extends Model
{
    protected $table = "bill_details_info";
    protected $primaryKey = "bill_details_id";
    protected $with = ['bill_head'];

    public function master()
    {
        return $this->belongsTo(BillMasterInfo::class, 'bill_master_id');
    }

    public function bill_head()
    {
        return $this->belongsTo(PrSalaryHeads::class, 'bill_head_id');
    }
}
