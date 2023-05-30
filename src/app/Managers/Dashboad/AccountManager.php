<?php


namespace App\Managers\Dashboad;


use Illuminate\Support\Facades\DB;

class AccountManager
{
    public function getData()
    {
        $sql = "SELECT CPAACC.fas_dashboard_report.balance_sheet_summary()
            FROM dual";
       return DB::select($sql);
    }
}
