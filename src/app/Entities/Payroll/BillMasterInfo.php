<?php


namespace App\Entities\Payroll;


use App\Entities\Admin\LBillType;
use App\Entities\Admin\WorkFlowProcess;
use App\Entities\Pmis\Employee\Employee;
use Illuminate\Database\Eloquent\Model;

class BillMasterInfo extends Model
{
    protected $table = "bill_master_info";
    protected $primaryKey = "bill_master_id";
    protected $with=['employee','details', 'pr_months', 'bill_type', 'bill_status', 'workflow_process'];
    protected $appends=['FormattedTotalAmount'];
    public function details()
    {
        return $this->hasMany(BillDetailsInfo::class, 'bill_master_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }

    public function pr_months()
    {
        return $this->belongsTo(PrMonths::class, 'pr_month_id');
    }

    public function bill_type()
    {
        return $this->belongsTo(LBillType::class, 'bill_type_id');
    }

    public function bill_status()
    {
        return $this->belongsTo(LArrearBillStatus::class, 'bill_status_id');
    }

    public function workflow_process()
    {
        return $this->belongsTo(WorkFlowProcess::class, 'workflow_process_id');
    }

    public function getFormattedTotalAmountAttribute()
    {
        return number_format($this->total_amount,'2');
    }
}
