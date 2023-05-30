<?php

namespace App\Entities\Loan;

use App\Entities\Admin\LLookups;
use App\Entities\Admin\LUserLookups;
use Illuminate\Database\Eloquent\Model;

class LoanTransaction extends Model
{
    protected $table = 'LOAN_TRANSACTIONS';
    protected $primaryKey = 'TRANSACTIONS_NO';
    public $with  = ['transaction_type'];
    public function transaction_type()
    {
        return $this->belongsTo(LLookups::class, 'transactions_type', 'lookup_code')->where('lookup_type','TRANSACTIONS_TYPE');
    }
}
