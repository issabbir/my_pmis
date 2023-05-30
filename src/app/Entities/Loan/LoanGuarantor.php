<?php

namespace App\Entities\Loan;

use App\Entities\Pmis\Employee\Employee;
use Illuminate\Database\Eloquent\Model;

class LoanGuarantor extends Model
{
    protected $table = 'LOAN_GUARANTOR';
    protected $primaryKey = 'LOAN_GUARANTOR_ID';
    public function guar_info() {
        return $this->belongsTo(LoanGuarantorInfo::class, 'guar_info_id', 'guar_info_id');
    }
}
