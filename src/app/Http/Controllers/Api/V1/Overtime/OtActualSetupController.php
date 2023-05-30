<?php

namespace App\Http\Controllers\Api\V1\Overtime;

use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Overtime\OtRegisterTemp;
use App\Http\Controllers\Controller;
use App\Entities\Pmis\Employee\Employee;
use App\Managers\Admin\AdminManager;
use App\Traits\Security\HasPermission;
use Illuminate\Http\Request;
use DB;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class OtActualSetupController extends Controller
{
    protected $adminManager;
    use HasPermission;

    public function __construct(AdminManager $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        return [
            'departments' => $this->adminManager->findCurrentDepartments(),
            'sections' => $this->adminManager->findDptSections(),
            'otmonths' => $this->gteOTMonths()

        ];

    }

    private function gteOTMonths()
    {
        $query = "SELECT ot_month_id AS pass_value,
         TO_CHAR (EFFECTIVE_START_DATE, 'fmYYYY - Month')
          AS show_value
         FROM ot_months
        WHERE open_yn = 'O' order  by EFFECTIVE_START_DATE desc";
        $otMonths = DB::select($query);
        $otMonth_option = [];
        foreach ($otMonths as $item) {
            $otMonth_option[] = ["text" => $item->show_value,
                'value' => $item->pass_value];
        }
        return $otMonth_option;
    }

    public function getEmpInfo(Request $request, $id, $dptId, EmployeeContract $employeeManager)
    {
        $adminManager = $this->adminManager;
//        print_r($employeeManager->otEmployeeOptionSameAsRosterByDept($id,$dptId));
//        die();
        return [
            "empcodeList" => $employeeManager->otEmployeeOptionSameAsRosterByDept($id,$dptId)
        ];
    }

    //"empcodeList" => $employeeManager->otEmployeeOption($id, $dptId)
    public function search(Request $request)
    {

        try {
            $department = $request->get("department");
            $section_id = $request->get("section_id");
            $section = $request->get("section");
            $otMonth = $request->get("otMonth");
            $emp_code = $request->get("emp_code");
            $otStatus = $request->get("otStatus");
            $query = "select * from
            (select rownum rn,
            ot_register.ot_register_id,
            ot_register.emp_id,
            ot_register.emp_code,
            ot_register.emp_name,
            ot_group_mst.group_name group_name,
            ot_register.remarks remarks,
            nvl(ot_register.actual_hour,0)actual_hour,
             nvl(ot_register.actual_hour,0)edit_actual_hour,
            trunc(ot_register.insert_date)insert_date,
            decode(ot_register.approve_hour,null,ot_register.register_hour,ot_register.approve_hour)approve_hour,
            nvl(ot_register.approve_status,0)approve_status,
            nvl(ot_register.approve_status,0)approve_edit_status,
            nvl(ot_register.ot_status,0)ot_status,
            nvl(ot_register.ot_status,0)edit_ot_status,
            l_designation.designation,
            ot_register.designation_id,
            l_department.department_name,
            l_dpt_section.dpt_section,
            ot_register.dpt_division_id,
            ot_register.section_id,
            ot_register.date_from,
            ot_register.date_to,
            ot_register.register_hour
            from ot_register
            left join l_department on l_department.department_id = ot_register.dpt_department_id
            left join l_designation on l_designation.designation_id = ot_register.designation_id
            left join l_dpt_section on l_dpt_section.dpt_section_id = ot_register.section_id
            left join ot_group_mst on (ot_register.ot_group_id=ot_group_mst.ot_group_id)
            where process_flag=0";

            if ($emp_code) {
                $query .= " and ot_register.emp_code = '" . $emp_code . "' ";
            }

            if ($section_id) {
                $query .= " and ot_register.section_id = '" . $section_id . "' ";
            }
            if ($department) {
                $query .= " and ot_register.dpt_department_id = '" . $department . "' ";
            }
            if ($section) {
                $query .= " and ot_register.section_id = '" . $section . "' ";
            }
            if ($otMonth) {
                $query .= " and ot_register.ot_month_id ='" . $otMonth . "'";
            }
            if (isset($otStatus)) {
                $query .= " and ot_register.ot_status ='" . $otStatus . "'";
            }
            $query .= ") order by insert_date desc";
//            echo $query;
            $otRegister = DB::select($query);

            return [
                "status" => true,
                "otRegister" => $otRegister //->all()
            ];

        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

    }

    public function updateOtActualStatus(Request $request)
    {
        $unProcessedOvertimeApprovals = $request->post();
        $counter = 0;
        $otMonthId = null;

        if ($unProcessedOvertimeApprovals) {
            DB::beginTransaction();
            try {
                foreach ($unProcessedOvertimeApprovals as $unProcessedOvertimeApproval) {
                    $ot_register_id = $unProcessedOvertimeApproval['ot_register_id'];
                    $edit_ot_status = $unProcessedOvertimeApproval['edit_ot_status'];
                    $ot_status = $unProcessedOvertimeApproval['ot_status'];
                    if ($ot_status == $edit_ot_status) {
                        continue;
                    } else {
                        $status_code = sprintf("%4000s", "");
                        $status_message = sprintf("%4000s", "");
                        $params = [
                            "p_ot_register_id" => $ot_register_id,
                            "p_ot_status" => $edit_ot_status,
                            "p_update_by" => auth()->id(),
                            "o_status_code" => &$status_code,
                            "o_status_message" => &$status_message,
                        ];
                        DB::executeProcedure("overtime.ot_register_status_set", $params);
                        if ($params['o_status_code'] != 1) {
                            throw new Oci8Exception($params['o_status_message'], $params['o_status_code']);
                        }
                    }
                    $counter++;
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return ["exception" => true, "status" => false, 'o_status_code' => $e->getCode(), "o_status_message" => $e->getMessage()];
            }
            if ($counter == 0) {
                $params['o_status_message'] = "No rows update!";
            } else {
                $params['o_status_message'] = "Successfully updated ${counter} records!";
            }
        }
        return $params;
    }


    public function store(Request $request)
    {
        $status_code = 0;
        $hasPermission = auth()->user()->hasPermission("CAN_OT_ACTUAL_DEPT_HEAD");
        $unProcessedOvertimeApprovals = $request->post();
        $counter = 0;
        $message = "";
        $otMonthId = null;
        $status_message = "no rows update";
        $params = ["o_status_message" => $status_message, "o_status_code" => $status_code];
        if ($unProcessedOvertimeApprovals) {
            if ($unProcessedOvertimeApprovals[0]) {
                $tempOvertimeToPickData = $unProcessedOvertimeApprovals[0];
                if ($tempOvertimeToPickData && $tempOvertimeToPickData['roster_date']) {
                    $rosterDate = $tempOvertimeToPickData['roster_date'];
                    $otYear = date('Y', strtotime($rosterDate));
                    $otMonth = date('m', strtotime($rosterDate));
                    $sql = <<<QUERY
select ot_month_id from ot_months
where ot_year=:ot_year
and ot_month=:ot_month

QUERY;
                    $otMonth = DB::selectOne($sql,
                        ['ot_year' => $otYear, 'ot_month' => $otMonth]
                    );
                    if ($otMonth) {
                        $otMonthId = $otMonth->ot_month_id;
                    }
                }
            }

            //$counter = 0;

            DB::beginTransaction();

            try {
                foreach ($unProcessedOvertimeApprovals as $unProcessedOvertimeApproval) {
                    $ot_register_dtl_id = $unProcessedOvertimeApproval['ot_register_dtl_id'];
                    $edit_actual_hour = $unProcessedOvertimeApproval['edit_actual_hour'];
                    $edit_special_hour = $unProcessedOvertimeApproval['edit_special_hour'];
                    $special_hour = $unProcessedOvertimeApproval['special_hour'];
                    $actual_hour = $unProcessedOvertimeApproval['actual_hour'];
                    $edit_ot_status = $unProcessedOvertimeApproval['edit_ot_status'];
                    $ot_status = $unProcessedOvertimeApproval['ot_status'];
                    $reconsider_flag = $unProcessedOvertimeApproval['reconsider_flag'];
                    $reconsider_flag = $unProcessedOvertimeApproval['reconsider_flag'];
                    $remarks = $unProcessedOvertimeApproval['remarks'];
                    $edit_remarks = $unProcessedOvertimeApproval['edit_remarks'];
                    $edit_reconsider_flag = $unProcessedOvertimeApproval['edit_reconsider_flag'];
                    if ($hasPermission) {
                        if ($special_hour == $edit_special_hour && $ot_status == $edit_ot_status && $remarks == $edit_remarks && $reconsider_flag == $edit_reconsider_flag) {
                            continue;
                        } else {
                            $status_code = sprintf("%4000s", "");
                            $status_message = sprintf("%4000s", "");
                            $params = [
                                "p_ot_register_dtl_id" => $ot_register_dtl_id,
                                "p_actual_hour" => $edit_actual_hour,
                                "p_special_flag" => $reconsider_flag,
                                "p_special_hour" => $edit_special_hour,
                                "p_ot_status" => $edit_ot_status,
                                "p_remarks" => $remarks,
                                "p_update_by" => auth()->id(),
                                "o_status_code" => &$status_code,
                                "o_status_message" => &$status_message,
                            ];
                        }
                    } else {
                        if ($reconsider_flag == $edit_reconsider_flag && $remarks == $edit_remarks) {
                            continue;
                        } else {
                            $status_code = sprintf("%4000s", "");
                            $status_message = sprintf("%4000s", "");
                            $params = [
                                "p_ot_register_dtl_id" => $ot_register_dtl_id,
                                "p_actual_hour" => $edit_actual_hour,
                                "p_special_flag" => $reconsider_flag,
                                "p_special_hour" => $edit_special_hour,
                                "p_ot_status" => $edit_ot_status,
                                "p_remarks" => $remarks,
                                "p_update_by" => auth()->id(),
                                "o_status_code" => &$status_code,
                                "o_status_message" => &$status_message,
                            ];
                        }

                    }
                    DB::executeProcedure("OVERTIME.ot_reg_actual_hour_set", $params);
                    if ($params['o_status_code'] != 1) {
                        throw new Oci8Exception($params['o_status_message'], $params['o_status_code']);
                    }
                    $params['ot_month_id'] = $otMonthId;
                    $counter++;
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                return ["exception" => true, "status" => false, 'o_status_code' => $e->getCode(), "o_status_message" => $e->getMessage()];
            }
            if ($counter == 0) {
                $params['o_status_message'] = "No rows update!";
            } else {
                $params['o_status_message'] = "Successfully updated ${counter} records!";
            }
        }
        return $params;

    }

    public function getActualOvertimeEmployeeInfo($otRegisterId)
    {

        $query = "select a.emp_code,a.emp_name,a.register_hour,a.approve_hour,b.department_name,b.designation,A.ot_month_id,A.dpt_department_id,
                decode(a.ot_status,'1','Hold','0','On Process','-1','Reject')ot_status,
                to_char(A.DATE_FROM,'dd/mm/yyyy')||' - '||to_char(A.DATE_TO,'dd/mm/yyyy')roster_date_range
                  from ot_register a,employee_info_vu b
                  where a.emp_id=b.emp_id
                  and a.ot_register_id=$otRegisterId";

        $actualTimeEmpInfo = DB::select($query);

        return [
            "actualTimeEmpInfo" => $actualTimeEmpInfo
        ];

    }

    public function getActualTimeSlab($otRegisterId)
    {
        //ROUND ( ( (ea.out_time - ea.in_time) * 24), 2) attendence_hour,

       $query = "SELECT rd.emp_id,
       rd.emp_code,
       rd.roster_date,
       TO_CHAR (rd.roster_date, 'fmDay') wday,
       rd.approve_hour,
       pmis.overtime.attendance_time(rd.emp_id,rd.roster_date,'T') as attendence_hour,
       overtime.ot_time (rd.emp_id, rd.roster_date, 'T') ot_hour,
       nvl(SPECIAL_FLAG,0) reconsider_flag,
       nvl(SPECIAL_FLAG,0) edit_reconsider_flag,
       rd.special_hour,
       rd.remarks,
       rd.remarks edit_remarks,
       rd.ot_register_dtl_id,
       rd.ot_register_id,
       rd.off_day_yn,
       rd.holiday_yn,
       NVL (rd.actual_hour, 0) actual_hour,
       NVL (rd.actual_hour, 0) edit_actual_hour,
       rd.special_hour edit_special_hour,
       NVL (rd.ot_status, 0) ot_status,
       NVL (rd.ot_status, 0) edit_ot_status,
       rs.SHIFT_CODE || ' ('||rs.SHIFT_START_TIME || '-' || rs.SHIFT_END_TIME || ')' as shift
  FROM ot_register_dtl rd, emp_attendance ea, OT_ROSTER_GROUP_DTL otg, L_ROSTER_SHIFT rs
 WHERE     rd.ot_register_id = :otId
       AND rd.emp_id = ea.emp_id(+)
       AND rd.roster_date = ea.roster_date(+)
       AND (rd.emp_id = otg.emp_id AND rd.ROSTER_DATE = otg.ROSTER_DATE)
       AND (otg.SHIFT_ID = rs.SHIFT_ID)
       ORDER BY rd.roster_date ASC";

        $actualSlab = DB::select($query, ['otId' => $otRegisterId]);
        return [
            "actualSlab" => $actualSlab
        ];
    }
}
