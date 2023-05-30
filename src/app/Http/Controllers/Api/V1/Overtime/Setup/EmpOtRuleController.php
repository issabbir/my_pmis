<?php

namespace App\Http\Controllers\Api\V1\Overtime\Setup;

use App\Contracts\Overtime\OvertimeContract;
use App\Entities\Admin\LRosterShift;
use App\Entities\Overtime\LOTCategory;
use App\Entities\Overtime\OtGroupMst;
use App\Entities\Overtime\OtMonths;
use App\Entities\Overtime\OtMonthsDetail;
use App\Entities\Overtime\OtRosterDetails;
use App\Entities\Overtime\OtRosterGroup;
use App\Entities\Pmis\Employee\Employee;
use App\Http\Controllers\Controller;
use App\Contracts\Admin\AdminContract;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Contracts\Pmis\Employee\EmployeeContract;
use SebastianBergmann\Environment\Console;

class EmpOtRuleController extends Controller
{

    protected $adminManager;
    protected $overtimeManager;

    public function __construct(AdminContract $adminManager, OvertimeContract $overtimeManager)
    {
        // Dependency injection
        $this->adminManager = $adminManager;
        $this->overtimeManager = $overtimeManager;
    }

    public function index(Request $request)
    {
        return $this->getPreloadInfo();
    }


    public function getPreloadInfo()
    {
         $empRules = DB::select("SELECT ev.dpt_department_id,
         ev.department_name,
         cat.ot_category_id,
         cat.ot_category     AS ot_category_name,
         COUNT (emp_id)      AS emp_count
    FROM employee_info_vu ev
         LEFT JOIN l_ot_category cat
             ON (cat.ot_category_id = ev.ot_category_id)
   WHERE ev.emp_status_id = 1 AND ev.emp_type_id = 2
GROUP BY ev.dpt_department_id,
         ev.department_name,
         cat.ot_category_id,
         cat.ot_category
ORDER BY ev.department_name");

        return [
            "departmentList" => $this->adminManager->findDepartments(),
            "rules" => LOTCategory::all(),
            'shifts' => $this->overtimeManager->findShifts(),
            "empRules" => $empRules
        ];


    }

    private function otMonth()
    {
        $query = "SELECT ot_month_id,
         TO_CHAR (TO_DATE (ot_year || ot_month, 'RRRRMM'), 'RRRR-fmMonth')
            AS show_value
    FROM ot_months
   WHERE open_yn = 'O'
ORDER BY effective_start_date DESC";
        $monthList = DB::Select($query);
        $otMonth = [];
        foreach ($monthList as $item) {
            $otMonth[] = ["text" => $item->show_value, 'value' => $item->ot_month_id];
        }
        return $otMonth;
    }

    public function view($data)
    {
        // dd($data);
        $rosterGroups = new OtRosterGroup();
        return $rosterGroups->all();
    }

    public function ruleDetails(Request $request)
    {
        $ot_category_id = $request->get('ot_category_id');
        $dpt_department_id = $request->get('dpt_department_id');
        $employeeList = DB::select("SELECT distinct ev.emp_id,
                   ev.emp_code,
                   ev.emp_type_id,
                   ev.emp_name || ' (' || ev.emp_type || ')' as emp_name,
                   ev.designation,
                   ev.designation_id,
                   ev.dpt_department_id,
                   ev.department_name,
                   ev.ot_category_name,
                   ev.ot_category_id rule,
                   ev.dpt_division_id,
                   ev.section_id
                FROM employee_info_vu ev
                    WHERE     ev.dpt_department_id = '$dpt_department_id'
                    AND ev.ot_category_id = '$ot_category_id'
                        AND ev.emp_status_id = 1 AND ev.emp_type_id = 2"
        );
        return [
            'employeeList' => $employeeList,
        ];
    }

    private function roster_details($request)
    {
        $group_name = $request->get('group_name') ? $request->get('group_name') : '';
        $department_id = $request->get('department_id') ? $request->get('department_id') : '';
        $ot_year = $request->get('ot_year') ? $request->get('ot_year') : '';
        $ot_month = $request->get('ot_month') ? $request->get('ot_month') : '';

        $details = DB::Select("SELECT
            ev.department_name, rg.group_id,
            rg.emp_id,rg.emp_code, rg.off_day,
            rg.reff_value,
            rg.division_id,
             rg.approve_yn,
            rg.department_id,ev.designation,
             l_emp_type.emp_type_id,
            ev.emp_name || ' (' || l_emp_type.emp_type_name || ')' as emp_name
  FROM ot_roster_group rg, employee_info_vu ev left join l_emp_type on (l_emp_type.emp_type_id = ev.emp_type_id)
 WHERE     rg.emp_id = ev.emp_id
       AND rg.group_name = '$group_name'
       AND rg.ot_year = '$ot_year'
       AND rg.ot_month = '$ot_month'
       AND ev.dpt_department_id = '$department_id'");

        return $details;
    }

    // Employee search
    public function searchResult(Request $request)
    {
        //try {
        $emps = [];
        $department_id = $request->get('department_id');
        if (isset($request)) {
            $employeeList = DB::select("SELECT distinct ev.emp_id,
                   ev.emp_code,
                   et.emp_type_id,
                   ev.emp_name || ' (' || et.emp_type_name || ')' as emp_name,
                   ev.designation,
                   ev.designation_id,
                   ev.dpt_department_id,
                   ev.department_name,
                   ev.dpt_division_id,
                   ev.section_id
                FROM employee_info_vu ev
                left join l_emp_type et on (et.emp_type_id = ev.emp_type_id)
                    WHERE     ev.dpt_department_id = '$department_id'
                        AND ev.emp_status_id = 1 AND ev.emp_type_id = 2");

             //dd($employeeList);
            foreach ($employeeList as $emp) {
                $sql = "select OT_MONTH_ID from OT_ROSTER_GROUP where EMP_ID = :empId";
                $_otMonths = DB::select($sql, ['empId' => $emp->emp_id]);
                $ot_month_id = [];
                foreach ($_otMonths as $otMonth) {
                    $ot_month_id[] = $otMonth->ot_month_id;
                }
                $emp->ot_month_id = $ot_month_id;
                $emps[] = $emp;
            }
            //$employeeList = $employees->where('dpt_department_id',$request->get('department_id'))->get();
        }

        return [
            "status" => true,
            "employees" => $emps
        ];

//        }
//        catch (\Exception $e) {
//            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
//        }
    }

    // Rule Department search
    public function searchRuleResult(Request $request)
    {
        $ot_category_id = $request->get('rule') ? $request->get('rule') : '';
        $dpt_department_id = $request->get('department_id') ? $request->get('department_id') : '';
        $query =  "SELECT ev.dpt_department_id,
         ev.department_name,
         cat.ot_category_id,
         cat.ot_category     AS ot_category_name,
         COUNT (emp_id)      AS emp_count
    FROM employee_info_vu ev
         LEFT JOIN l_ot_category cat
             ON (cat.ot_category_id = ev.ot_category_id)
   WHERE     ev.emp_status_id = 1
         AND ev.emp_type_id = 2
         AND NVL (ev.current_department_id, ev.dpt_department_id) =
             NVL ( '$dpt_department_id',
                  NVL (ev.current_department_id, ev.dpt_department_id))
         AND cat.ot_category_id = NVL ( '$ot_category_id', cat.ot_category_id)
GROUP BY ev.dpt_department_id,
         ev.department_name,
         cat.ot_category_id,
         cat.ot_category
ORDER BY ev.department_name";
        return ["employeeRuleList" => DB::select($query)];
    }

    public function findGroupByMonths($monthId)
    {
        $rosterGroups = new OtRosterGroup();
        $months = new OtMonths();
        $month = $months->where('ot_month_id', $monthId)->first();
        $ot_year = $month['ot_year'];
        $ot_month = $month['ot_month'];
        return [
            'groups' => $this->otMonthGroup($ot_year, $ot_month)
        ];
    }

    private function otMonthGroup($year, $month)
    {
        $query = "SELECT DISTINCT group_name
  FROM ot_roster_group
 WHERE ot_year = '$year' AND ot_month = '$month'";
        $groupList = DB::Select($query);
        $otGroup = [];
        foreach ($groupList as $item) {
            $otGroup[] = ["text" => $item->group_name, 'value' => $item->group_name];
        }
        return $otGroup;
    }

    public function store(Request $request)
    {
         $params = [];
         try {
            foreach ($request->get('items') as $otRosterGroup) {
                $ot_category_id = isset($otRosterGroup['rule']) ? $otRosterGroup['rule'] : '';
                $emp_id = isset($otRosterGroup['emp_id']) ? $otRosterGroup['emp_id'] : '';
                $statusCode = sprintf("%4000s", "");
                $statusMessage = sprintf('%4000s', '');
                $params = [
                    "p_emp_id" => $emp_id,
                    "p_ot_category_id" => $ot_category_id,
                    "p_update_by" => Auth()->ID(),
                    'o_status_code' => &$statusCode,
                    'o_status_message' => &$statusMessage
                ];
                //dd($params);
                DB::executeProcedure('OVERTIME.emp_ot_rule_define', $params);

                if ($params['o_status_code'] != 1) {
                     return $params;
                }
            }

            return $params;// ["table_info" => $this->load_ot_tmp_data(),  "params" =>$params]; //
        } catch (\Exception $e) {
            return ["table_info" => $params, "exception" => true, "o_status_code" => false, "o_status_message" => $e->getMessage()];
        }

    }

    public function update(Request $request, $id)
    {
        //TODO: Default template for action.
        $params = [];
        try {
            //$m_emp_id = $request->get("emp_id");
            $p_ot_register_id = $request->get('ot_register_id');
            $statusCode = sprintf("%4000s", "");
            $statusMessage = sprintf('%4000s', '');
            $params = [
                "p_ot_register_id" => $p_ot_register_id,
                "p_emp_id" => $request->get("m_emp_id"),
                "p_date_from" => date("Y-m-d", strtotime($request->get("fromDate"))),
                "p_date_to" => date("Y-m-d", strtotime($request->get("endDate"))),
                "p_register_hour" => $request->get("m_ot_hour"),
                "p_remarks" => $request->get("remarks"),
                "p_approve_status" => $request->get("registerApproval"),
                //"p_insert_by"           => '',
                "p_update_by" => Auth()->ID(),
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage
            ];
            DB::executeProcedure('OVERTIME.ot_register_entry_update', $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
        return $params;

    }

    public function remove($id, $empId)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [

                "p_group_id" => $id,
                "p_empId" => $empId,
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OVERTIME.ot_group_emp_delete", $params);
        } catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    /**
     * @param Request $request
     * @param $id
     * @param EmployeeContract|EmployeeManager $employeeManager
     * @return array
     */
    public function getEmpInfo(Request $request, $id, EmployeeContract $employeeManager)
    {

        return [
            "empcodeList" => $employeeManager->otEmployeeOption($id)
        ];
    }
    //employeeOption
    //otEmployeeOption($id)
}
