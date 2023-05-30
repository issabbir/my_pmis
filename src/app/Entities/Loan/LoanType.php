<?php

namespace App\Entities\Loan;

use Illuminate\Database\Eloquent\Model;

class LoanType extends Model
{
    protected $table = 'loan_type';
    protected $primaryKey = 'loan_type_id';
}
