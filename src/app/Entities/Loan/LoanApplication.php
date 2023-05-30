<?php


namespace App\Entities\Loan;

use App\Entities\Pmis\Employee\Employee;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    protected $table = 'loan_application';
    protected $primaryKey = 'application_id';
    protected $with = ['employee'];

    public  function employee() {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
}
