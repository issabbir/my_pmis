<?php


namespace App\Managers\Dashboad;


use Illuminate\Support\Facades\DB;

class FinanceManager
{
    public function budgetPosition(){

        $header_sql = "select cpaacc.fas_dashboard_report.budget_summary_header from dual";
        $header = DB::selectOne($header_sql);

        $data_sql = "select cpaacc.fas_dashboard_report.budget_summary_report from dual";
        $data = DB::select($data_sql);

        return ['header' => $header, 'data' => $data ];
    }

    public function accounts_receivable_summary(){
        $sql = "select cpaacc.fas_dashboard_report.account_receivable_summary from dual";
        return $data = DB::select($sql);
    }

    public function accounts_payable_summary(){
        $sql = "select cpaacc.fas_dashboard_report.account_payable_summary from dual";
        return $data = DB::select($sql);
    }

}
