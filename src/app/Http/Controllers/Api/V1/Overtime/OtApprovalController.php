<?php

namespace App\Http\Controllers\Api\V1\Overtime;

use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Overtime\OtGroupMst;
use App\Entities\Overtime\OtMonths;
use App\Entities\Overtime\OtRegisterTemp;
use App\Http\Controllers\Controller;
use App\Entities\Pmis\Employee\Employee;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class OtApprovalController extends Controller
{
    protected $adminManager;

    public function __construct(AdminManager $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        return [
            'departments' => $this->adminManager->findDepartments(),
            'sections' => $this->adminManager->findDptSections(),
            'otGroups' => OtGroupMst::all(),
            'months' => $this->otMonth(),
            'employee' => Auth::user()->employee(),
        ];

    }
    private function otMonth()
    {
        $query = "SELECT ot_month_id, TO_CHAR (TO_DATE (ot_year || ot_month, 'RRRRMM'), 'RRRR-fmMonth') as show_value FROM ot_months WHERE open_yn = 'O'";
        $monthList = \Illuminate\Support\Facades\DB::Select($query);
        $otMonth = [];
        foreach ($monthList as $item) {
            $otMonth[] = ["text" => $item->show_value, 'value' => $item->ot_month_id];
        }
        return $otMonth;
    }
    public function getGroupByMonth($department,$month,$section=null)
    {
        $groups = OtGroupMst::where('department_id',$department)->where('ot_month_id',$month);
        if ($section != 'null'){
            $groups = $groups->where('section_id', $section);
        }
        $data = $groups->get();
        return [
            'otGroups' => $data
        ];
    }
    public function getEmpInfo(Request $request, $id, EmployeeContract $employeeManager)
    {
        $adminManager = $this->adminManager;
        return [
            "empcodeList" => $employeeManager->otEmployeeOptionSameAsRoster($id)
        ];
    }
        //  "empcodeList" => $employeeManager->otEmployeeOption($id)

    public function search(Request $request)
    {

        try {
            $department = $request->get("department");
            $section = $request->get("section");
            $approval_status = $request->get("approval_status") ? $request->get("approval_status") : 0;
            $otGroup = $request->get("otGroup");
            $monthId = $request->get("month");
            $fromDate = $request->get("fromDate");
            $endDate = $request->get("endDate");
            $emp_code = $request->get("emp_code");
            $effective_start_date = '';
            $effective_end_date = '';
            if ($monthId){
                $monthDate = OtMonths::find($monthId);
                $effective_start_date = date('Y-m-d',strtotime($monthDate->effective_start_date));
                $effective_end_date = date('Y-m-d',strtotime($monthDate->effective_end_date));
            }

            $query = " SELECT ROWNUM rn,
         ot_register_id,
         emp_id,
         emp_code,
         emp_name,
         remarks,
         insert_date,
         approve_hour,
         approve_hour_offday,
         approve_status,
         approve_edit_status,
         designation,
         designation_id,
         department_name,
         dpt_section,
         dpt_division_id,
         section_id,
         date_from,
         date_to,
         register_hour,
         offdyreg_hour,
          group_name
    FROM (SELECT rt.ot_register_id,
                 rt.emp_id,
                 rt.emp_code,
                 rt.emp_name,
                 rt.remarks,
                 TRUNC (rt.insert_date) insert_date,
                 CASE
                    WHEN rt.approve_hour IS NULL THEN rt.register_hour
                    ELSE rt.approve_hour
                 END
                    approve_hour,
                 CASE
                    WHEN rt.offdyapp_hour IS NULL THEN rt.offdyreg_hour
                    ELSE rt.offdyapp_hour
                 END
                    approve_hour_offday,
                 NVL (rt.approve_status, 0) approve_status,
                 NVL (rt.approve_status, 0) approve_edit_status,
                 dg.designation,
                 rt.designation_id,
                 ld.department_name,
                 ds.dpt_section,
                 rt.dpt_division_id,
                 rt.section_id,
                 rt.date_from,
                 rt.date_to,
                 rt.register_hour,
                 rt.offdyreg_hour,
                 gm.group_name
            FROM ot_register_temp rt,
                 ot_group_mst gm,
                 l_department ld,
                 l_designation dg,
                 l_dpt_section ds
           --         ot_roster_group_dtl rd
           WHERE     ld.department_id = rt.dpt_department_id
                 AND rt.ot_group_id = gm.ot_group_id
                 AND dg.designation_id (+)= rt.designation_id
                 AND ds.dpt_section_id (+)= rt.section_id
                 --         AND (    rt.emp_id = rd.emp_id
                 --              AND rd.roster_date BETWEEN rt.date_from AND rt.date_to)
                 AND rt.emp_code IS NOT NULL";
//                 AND rt.approve_status != -1

            if ($emp_code) {
                $query .= " and rt.EMP_CODE = '" . $emp_code . "' ";
            }

            if ($department) {
                $query .= " and ld.department_id = '" . $department . "' ";
            }
            if ($section) {
                $query .= " and ds.dpt_section_id = '" . $section . "' ";
            }
            if (isset($approval_status)) {
                $query .= " and nvl(rt.APPROVE_STATUS,0) = '" . $approval_status . "' ";
            }
            if (isset($otGroup)) {
                $query .= " and NVL(rt.ot_group_id,0) = '" . $otGroup . "' ";
            }
            if (!empty($effective_start_date) && !empty($effective_end_date)) {
                $query .= " and rt.DATE_FROM  >= TO_DATE('" . $effective_start_date . "', 'YYYY/MM/DD')
                and rt.DATE_TO <=TO_DATE('" . $effective_end_date . "', 'YYYY/MM/DD')";
            }
            $query .= ") ORDER BY emp_id, date_from, insert_date DESC";

            $otRegister = DB::select($query);

            return [
                "status" => true,
                "otRegister" => $otRegister //->all()
            ];
            //return $otRegister;
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

    }

    public function view(Request $request)
    {
        //TODO: Default template for action.
    }

    public function store(Request $request)
    {
        $status_code = 0;
        $unProcessedOvertimeApprovals = $request->post();
        $counter = 0;
        $message = "";
        $status_message = "no rows update";
        $params = ["o_status_message" => $status_message, "o_status_code" => $status_code];
        if ($unProcessedOvertimeApprovals) {
            foreach ($unProcessedOvertimeApprovals as $unProcessedOvertimeApproval) {

                $ot_register_id = $unProcessedOvertimeApproval['ot_register_id'];
                $ot_emp_id = $unProcessedOvertimeApproval['emp_id'];
                $remarks = $unProcessedOvertimeApproval['remarks'];
                $approve_ot_hour = $unProcessedOvertimeApproval['approve_hour'];
                $approve_ot_hour_offday = $unProcessedOvertimeApproval['approve_hour_offday'];
                $approve_edit_status = $unProcessedOvertimeApproval['approve_edit_status'];
                $approve_status = $unProcessedOvertimeApproval['approve_status'];

                if ($approve_status == $approve_edit_status || $approve_ot_hour < 0) {
                    continue;
                } else {

                    try {

                        $status_code = sprintf("%4000s", "");
                        $status_message = sprintf("%4000s", "");
                        $params = [

                            "p_ot_register_id" => $ot_register_id,
                            "p_emp_id" => $ot_emp_id,
                            "p_remarks" => $remarks,
                            "p_approve_hour" => $approve_ot_hour,
                            'p_app_off_hr' => $approve_ot_hour_offday,
                            "p_approve_status" => $approve_edit_status,
                            "p_update_by" => auth()->id(),
                            "o_status_code" => &$status_code,
                            "o_status_message" => &$status_message,
                        ];
                        DB::executeProcedure("OVERTIME.OT_REGISTER_APPROVE", $params);
                        $status_code = 1;
                        $counter = $counter + 1;
                        $status_message = 'Successfully update ' . $counter . ' records';
                    } catch (\Exception $e) {
                        return ["exception" => true, "status" => false, 'o_status_code' => 99,  "o_status_message" => $status_message];
                    }

                }

            }
        }

        return $params;

    }

    public function update(Request $request)
    {

    }

    public function remove(Request $request)
    {
        //TODO: Default template for action.
    }
}
