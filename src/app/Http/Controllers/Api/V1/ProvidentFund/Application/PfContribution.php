<?php


namespace App\Http\Controllers\Api\V1\ProvidentFund\Application;

use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Admin\WorkFlowProcess;
use App\Entities\Admin\WorkFlowStep;
use App\Entities\Pf\GpfEmployee;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Security\Role;
use App\Entities\Security\User;
use App\Entities\Security\UserRole;
use App\Http\Controllers\Controller;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PfContribution extends Controller
{

    public function formData()
    {
        $sql = "select PFPROCESS.FINANCIAL_YEAR_LIST() from dual";
        $fyears = DB::select($sql);
        return [
            "fyears" => $fyears
        ];
    }

    /**
     * @param Request $request
     * @param $id
     * @param EmployeeContract|EmployeeManager $employeeManager
     * @return array
     */
    public function getempinfo(Request $request, $id, EmployeeContract $employeeManager)
    {
        // $adminManager = $this->adminManager;
        return [
            "empcodeList" => $employeeManager->employeeOption($id)
        ];
    }

    public function employee(Request $request, $id, $option, EmployeeContract $employeeManager)
    {

        return $employeeManager->gpfEmployees($id, $option);
    }

    public function employeeSelf(Request $request, $id, $option, EmployeeContract $employeeManager)
    {

        return $employeeManager->gpfEmployeeSelf($id, $option);
    }

    public function searchEmployee(Request $request, $search, $dpt, EmployeeContract $employeeManager)
    {
        $role_id = Role::where('role_key', 'Manage_All_GPF_Application')->value('role_id');
        $user_roles = UserRole::where('role_id', $role_id)->where('user_id', auth()->id())->get();
        if (count($user_roles) > 0) {
            if (Auth::user()->hasPermission('CAN_APPLY_GPF_APPLICATION_FOR_ALL') /*&& !Auth::user()->hasRole('Manage_All_GPF_Application')*/) {
                $sql = "select PFPROCESS.GPF_EMPLOYEE_CODE_LIST_FOR_ALL(:search) from dual";
                return DB::select($sql, [
                    "search" => $search]);
            }else{//dd('2');
                $sql = "select PFPROCESS.GPF_EMPLOYEE_CODE_LIST_ALL(:search) from dual";
                return DB::select($sql, [
                    "search" => $search]);
            }

        } else {
            $sql = "select PFPROCESS.GPF_EMPLOYEE_CODE_LIST(:search,:dtp,:auth) from dual";
            return DB::select($sql, ['dtp' => $dpt,
                "search" => $search,
                'auth' => auth()->id()]);
        }

    }

    public function searchEmployeeDpt(Request $request, $search, $dpt, EmployeeContract $employeeManager)
    {
        if ($dpt == 'null') {
            $dpt = null;
        }
        $sql = "select PFPROCESS.gpf_employee_dpt(:search,:dtp) from dual";
        return DB::select($sql, ['dtp' => $dpt,
            "search" => $search]);
    }

    public function nonEmployee(Request $request, $search, EmployeeContract $employeeManager)
    {
        return $employeeManager->nonGpfEmployees($search);
    }

    public function addNew(Request $request)
    {
        return $this->GPF_APPLICATION_ENTRY($request);
    }

    public function GPF_APPLICATION_ENTRY(Request $request)
    {
        try {

            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $app_id = $request->get("app_id") ? $request->get("app_id") : '';
            $params = [
                "p_gpf_id" => $request->get("gpf_id"),
                "p_gpf_app_id" => $app_id,
                "p_emp_id" => (int)$request->get("emp_id"),
                "p_gpf_pct" => $request->get("percent"),
                "p_office_order_no" => $request->get("officeOrderNo") ? $request->get("officeOrderNo") : '',
                "p_office_order_date" => $request->get("officeOrderDate") != 'Invalid date' ? date("d-m-Y", strtotime($request->get("officeOrderDate"))) : '',
                "p_gpf_status" => $request->get("status"),
                "p_gpf_amount" => $request->get("amount"),
                "on_gpf_interest_yn" => $request->get("on_gpf_interest_yn"),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PFPROCESS.GPF_APPLICATION_ENTRY", $params);
            //dd($params);
            if ($params['o_status_code'] == 1) {
                $reporting_officer_id = Employee::where('emp_id', $request->get("emp_id"))->value('reporting_officer_id');
                $emp_name = Employee::where('emp_id', $request->get("emp_id"))->value('emp_name');
                if ($reporting_officer_id != null) {
                    $controller_user_id = User::where('emp_id', $reporting_officer_id)->value('user_id');
                    $controller_user_notification = [
                        "p_notification_to" => $controller_user_id,
                        "p_insert_by" => Auth::id(),
                        "p_note" => 'GPF application submitted by ' . $emp_name . '',
                        "p_priority" => null,
                        "p_module_id" => 4,
                        "p_target_url" => "pmis/provident-fund#/gpf-application"
                    ];
                    DB::executeProcedure("cpa_security.cpa_general.notify_add", $controller_user_notification);
                }
            }
        } catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }

    public function searchPfEmployees(Request $request)
    {
        try {
            $emp_code = $request->get("emp_code");
            $status = $request->get("status");
            $role_id = Role::where('role_key', 'Manage_All_GPF_Application')->value('role_id');
            $user_roles = UserRole::where('role_id', $role_id)->where('user_id', auth()->id())->get();
            if (count($user_roles) > 0) {
                $sql = "select PFPROCESS.GPF_EMPLOYEE_GRID_ALL(:empId, :status) from dual";
                $list = DB::select($sql, [
                    'empId' => $emp_code,
                    'status' => $status]);
            } else {
                $department = $request->get("department");
                $section = $request->get("section");
                $sql = "select PFPROCESS.GPF_EMPLOYEE_GRID(:dtp,:sct, :empId, :status,:auth) from dual";
                $list = DB::select($sql, ['dtp' => $department,
                    "sct" => $section ?: null,
                    'empId' => $emp_code,
                    'status' => $status,
                    'auth' => auth()->id()]);
            }
            return [
                "status" => true,
                "pfEmployees" => $list
            ];

        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

    }

    public function getPfOpeningEmployeeInfo($id)
    {
        $query = "SELECT em.emp_id emp_id,
         em.emp_code emp_code,
         em.emp_name emp_name,
         dpt.department_name department_name,
         dsg.designation designation,
         gp.gpf_id,
         gp.gpf_pct,
         gp.gpf_status,
         gp.acc_no,
         gs.basic_amt,
         em.dpt_department_id
    FROM employee em,
         l_department dpt,
         l_designation dsg,
         gpf_employee gp,
         l_grade_steps gs
   WHERE     em.dpt_department_id = dpt.department_id
         AND em.designation_id = dsg.designation_id
          AND em.emp_status_id = 1
         AND em.emp_active_yn = 'Y'
         AND em.grade_step_id = gs.grade_steps_id
         AND em.emp_grade_id = gs.grade_id
         AND gp.emp_code(+) = em.emp_code
         AND em.emp_id =$id
GROUP BY em.emp_id,
         em.emp_code,
         em.emp_name,
         dpt.department_name,
         dsg.designation,
         gp.gpf_id,
         gp.gpf_pct,
         gp.gpf_status,
         gp.acc_no,
         gs.basic_amt,
         em.dpt_department_id";
        $PfOpeningEmployeeInfo = DB::select($query);

        return [
            "pfOpeningEmployeeInfo" => $PfOpeningEmployeeInfo
        ];

    }

    public function store(Request $request)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            if ($request) {
                $emp_id = $request->get("emp_id");
                $sql = <<<QUERY
select dpt_department_id from employee
where emp_id=:emp_id

QUERY;
                $emp_id = DB::selectOne($sql,
                    ['emp_id' => $emp_id]
                );
                if ($emp_id) {
                    $dptId = $emp_id->dpt_department_id;
                }
                $params = [

                    "p_GPF_ID" => $request->get("cpf_gpf_no"),
                    "p_EMP_ID" => $request->get("emp_id"),
                    "p_GPF_PCT" => $request->gEMPLOYEESet("new_pf"),
                    "p_GPF_STATUS" => $request->get("status"),
                    "p_insert_by" => auth()->id(),
                    "o_status_code" => &$status_code,
                    "o_status_message" => &$status_message,
                ];
                DB::executeProcedure("pfprocess.pf_application_entry", $params);
                $params['dpt_department_id'] = $dptId;
            }

        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    /**
     * @param $search
     * @return array
     */
    public function gpfEmployees($search)
    {
        return DB::select("select PFPROCESS.EMP_GPF_SUMMARY_CODE_LIST(:search) from dual", ['search' => $search]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function gpfSearch(Request $request)
    {

        $empCode = $request->get('emp_code');
        $gpfId = $request->get('gpf_id');
        $yearFrom = $request->get('year_from');
        $monthFrom = $request->get('month_from');
        $yearTo = $request->get('year_to');
        $monthTo = $request->get('month_to');
        $query = "select PFPROCESS.EMP_GPF_SUMMARY_DATA(:p1,:p2,:p3,:p4,:p5,:p6) from dual";
        return DB::select($query, ['p1' => $empCode, 'p2' => $gpfId, 'p3' => $yearFrom, 'p4' => $monthFrom, 'p5' => $yearTo, 'p6' => $monthTo]);
    }

    /**
     * Pf statement listing
     *
     * @param $empId
     * @param $date
     * @return array
     */
    public function statementList($empId, $fid)
    {
        $sql = "select PFPROCESS.EMP_GPF_STATEMENT_DATA(:p1,:p2) from dual";
        return DB::select($sql, ['p1' => $empId, 'p2' => $fid]);
    }

    public function updateWorkflowId(Request $request, $id)
    {
        DB::table('gpf_employee')
            ->where('gpf_id', $id)
            ->update(['approval_workflow_id' => $request->get('approval_workflow_id')]);
        $response = $this->systemAutoCompleteStep($request, $id);
        return ['data' => $response];
    }

    public function updateLoanWorkflow(Request $request, $id)
    {
        DB::table('loan_application')
            ->where('application_id', $id)
            ->update(['approval_workflow_id' => $request->get('approval_workflow_id')]);

        $response = $this->systemAutoCompleteStep($request, $id);
        return ['data' => $response];
    }

    public function getGpfSettlementData()
    {
        $sql = "select PFPROCESS.get_pf_settelment_data(:p1) from dual";
        return DB::select($sql, ['p1' => auth()->id()]);
    }

    public function updateSettlementWorkflow(Request $request, $id)
    {
        DB::table('settlement_application')
            ->where('settlement_id', $id)
            ->update(['approval_workflow_id' => $request->get('approval_workflow_id')]);

        $response = $this->systemAutoCompleteStep($request, $id);
        return ['data' => $response];


    }

    private function systemAutoCompleteStep($request = [], $id)
    {
        $firstWorkflowStep = WorkFlowStep::where('approval_workflow_id', $request->get('approval_workflow_id'))
            ->orderBy('PROCESS_STEP')
            ->first();
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $object_id = $request->get('gpf_id') ? $request->get('gpf_id') :
                ($request->get('settlement_id') ? $request->get('settlement_id') :
                    ($request->get('application_id') ? $request->get('application_id') : ''));
            $params = [
                "p_workflow_process_id" => '',
                "p_workflow_object_id" => $object_id,
                "p_workflow_step_id" => $firstWorkflowStep->workflow_step_id,
                "p_note" => 'System Assigned',
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("workflow_Process_entry", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
        return $params;

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function storeGpfSettlement(Request $request)
    {

        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_settlement_id" => $request->get("settlement_id"),
                "p_settlement_amt" => $request->get("settlement_amt"),
                "p_pf_sub_amount" => $request->get("pf_amount"),
                "p_pf_sub_interest" => $request->get("pf_interest"),
                "p_total_loan_amt" => $request->get("total_loan_amount"),
                "P_loan_due_amount" => $request->get("pf_loan_amount_due"),
                "p_loan_int_due_amount" => $request->get("pf_loan_interest_due"),
                "p_loan_pardon_amt" => 0,
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PFPROCESS.emp_settlement_entry", $params);

        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }
}
