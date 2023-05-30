<?php

namespace App\Http\Controllers\Api\V1\Pmis\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;


class PfLoanController extends Controller
{
    public function __construct()
    {
        // Dependency injection
    }

    public function index(Request $request)
    {
        die(__CLASS__.'::index');
        //TODO: Default template for action.
    }

    public function specific (Request $request,$id)
    {
        $sql = 'select employees.emp_pf_loan_data(:emp_id) from dual';
        $pf_loan_data = DB::selectOne($sql, [
            'emp_id' => $id,
        ]);
        return [
            'pf_loan_data' => $pf_loan_data,
        ];
    }

    public function view(Request $request,$id)
    {

    }

    public function store(Request $request)
    {
        //TODO: Default template for action.
    }

    public function update(Request $request)
    {
        //TODO: Default template for action.
    }

    public function remove(Request $request)
    {
        //TODO: Default template for action.
    }
}
