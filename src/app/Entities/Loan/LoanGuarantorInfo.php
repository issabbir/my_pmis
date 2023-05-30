<?php

namespace App\Entities\Loan;

use Illuminate\Database\Eloquent\Model;

class LoanGuarantorInfo extends Model
{
    protected $table = 'LOAN_GUARANTOR_INFO';
    protected $primaryKey = 'GUAR_INFO_ID';
}
