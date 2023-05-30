<?php


namespace App\Http\Controllers\Api\V1\ProvidentFund\Application;

use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Security\User;
use App\Http\Controllers\Controller;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PfWithdraw extends Controller
{

    public function store(Request $request)
    {

        try {
            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [
                "p_application_id" => $request->get("settlement_id"),
                "p_settlement_no" => $request->get("voucher_no"),
                "p_settlement_types" => $request->get("settlement_types"),
                "p_emp_id" => $request->get("emp_id"),
                "p_applicant_name" => $request->get("applicant_name"),
                "p_relationship_id" => $request->get("relationship_id"),
                "p_application_date" => date("Y-m-d", strtotime($request->get("application_date"))),
                "p_applicant_type" => $request->get("applicant_type"),
                "p_attachment" => [
                    'value' => $request->post('attachment'),
                    'type' => SQLT_CLOB,
                ],
                "p_file_type" => $request->get("file_type"),
                "p_file_name" => $request->get("file_name"),
                "p_settlement_amt" => $request->get("settlement_amt"),
                "p_pf_sub_amount" => $request->get("pf_amount"),
                "p_pf_sub_interest" => $request->get("pf_interest"),
                "p_total_loan_amt" => $request->get("total_loan_amount"),
                "p_loan_due_amount" => $request->get("pf_loan_amount_due"),
                "p_loan_int_due_amount" => $request->get("pf_loan_interest_due"),
                "p_loan_pardon_amt" => null,
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PFPROCESS.emp_settlement_app_entry", $params);
           // dd($params);
            if($params['o_status_code'] == 1) {
                $reporting_officer_id = Employee::where('emp_id', $request->get("emp_id"))->value('reporting_officer_id');
                $emp_name = Employee::where('emp_id', $request->get("emp_id"))->value('emp_name');
                if($reporting_officer_id != null ){
                    $controller_user_id = User::where('emp_id', $reporting_officer_id)->value('user_id');
                    $controller_user_notification = [
                        "p_notification_to" => $controller_user_id,
                        "p_insert_by" => Auth::id(),
                        "p_note" => 'GPF settlement application submitted by '.$emp_name.'',
                        "p_priority" => null,
                        "p_module_id" => 4,
                        "p_target_url" => "pmis/provident-fund#/pf-settlement"
                    ];
                    DB::executeProcedure("cpa_security.cpa_general.notify_add", $controller_user_notification);
                }
            }
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function get(Request $request) {
        $sql = "select PFPROCESS.emp_settlement_list(:p1) from dual";
        return DB::select($sql, ['p1' => auth()->id()]);
    }
    public function getSelf(Request $request) {
        $sql = "select PFPROCESS.emp_settlement_list_self(:p1) from dual";
        return DB::select($sql, ['p1' => Auth::user()->emp_id]);
    }

    public function put(Request $request) {
        return $this->store($request);
    }

    public function searchEmployees($searchParam) {
        if(Auth::user()->hasPermission('CAN_APPLY_GPF_LOAN_APPLICATION_FOR_ALL')){
            $sql = "select PFPROCESS.emp_search_for_pf_settelment_all(:auth,:param) from dual";
            return $list = DB::select($sql, ['auth' => auth()->id(),
                'param' => $searchParam]);
        }else{
            $sql = "select PFPROCESS.emp_search_for_pf_settelment(:auth,:param) from dual";
            return $list = DB::select($sql, ['auth' => auth()->id(),
                'param' => $searchParam]);
        }

    }

    public function searchEmployeesSelf($searchParam) {
        $sql = "select PFPROCESS.emp_for_pf_settelment_self(:auth,:param) from dual";
        return $list = DB::select($sql, ['auth' => Auth::user()->emp_id,
            'param' => $searchParam]);
    }

}
