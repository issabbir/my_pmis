<?php

namespace App\Entities\Loan;

use Illuminate\Database\Eloquent\Model;

class LoanDocuments extends Model
{
    protected $table = 'LOAN_DOCUMENTS';
    protected $primaryKey = 'LOAN_DOC_ID';
}
