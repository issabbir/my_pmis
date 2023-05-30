<?php

namespace App\Http\Controllers\Api\V1\Overtime;

use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Overtime\OtRegisterTemp;
use App\Http\Controllers\Controller;
use App\Entities\Pmis\Employee\Employee;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use DB;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class OtIrregularController extends Controller
{
    protected $adminManager;

    public function __construct(AdminManager $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request, $ot_month_id)
    {
        return [
            'departments' => $this->adminManager->findDepartments(),
            'otmonths' => $this->getOTMonths()

        ];

    }

    private function getOTMonths()
    {
        $query = "SELECT ot_month_id AS pass_value,
          ot_year
       || '-'
       || TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE, 'YYYY'), ot_month - 1),
                   'fmMonth')
          AS show_value
         FROM ot_months
        WHERE open_yn = 'O'
        ORDER BY  ot_year asc, ot_month asc";
        $otMonths = DB::select($query);
        $otMonth_option = [];
        foreach ($otMonths as $item) {
            $otMonth_option[] = ["text" => $item->show_value,
                'value' => $item->pass_value];
        }
        return $otMonth_option;
    }

    public function getOTMontSlab($ot_month_id, $dpt_id)
    {

        //$slugs = $this->adminManager->findDepartments()->pluck('department_id');

        $query = "SELECT a.ot_month_detail_id AS ret_val,
                TO_CHAR (a.effective_start_date, 'yyyy-mm-dd')
             || ' -- '
             || TO_CHAR (a.effective_end_date, 'yyyy-mm-dd')
             || '('
             || b.department_name
             || ')'
                AS show_value
                FROM ot_months_detail a, l_department b
                WHERE a.ot_month_id = $ot_month_id AND a.department_id = b.department_id
                and a.DEPARTMENT_ID = :dptId
                ORDER BY   b.department_name, TO_CHAR (a.effective_start_date, 'yyyy-mm-dd')
                     || '-'
                     || TO_CHAR (a.effective_end_date, 'yyyy-mm-dd')";
        $otMonthSlab = DB::select($query, ['dptId' => $dpt_id]);
        $otMonthSlab_option = [];
        foreach ($otMonthSlab as $item) {
            $otMonthSlab_option[] = ["text" => $item->show_value,
                'value' => $item->ret_val];
        }
        return ["otMontSlabs" => $otMonthSlab_option];

    }

    public function getEmpInfo(Request $request, $id, $dptId, EmployeeContract $employeeManager)
    {
        $adminManager = $this->adminManager;
        return [
            "empcodeList" => $employeeManager->otEmployeeOptionSameAsRoster($id)
        ];
    }

    //"empcodeList" => $employeeManager->otEmployeeOption($id, $dptId)

    public function search(Request $request)
    {

        try {
            $department = $request->get("department");
            $otMonthSlab = $request->get("otMonthSlab");
            $emp_id = $request->get("emp_id");
            $query = "select * from
                    (select ea.roster_date,
               ev.emp_code,
               ev.emp_name,
               ev.designation,
               ea.in_time,
               ea.out_time,
               ea.emp_id,
               rs.shift_code,
               md.ot_month_detail_id,
               md.ot_month_id,
               ea.attendance_id,
               overtime.ot_time (ea.emp_id,
                        ea.roster_date,'T') as ot_hour
               from emp_attendance ea, employee_info_vu ev, ot_months_detail md,
               l_roster_shift rs, ot_roster_group_dtl rg
               where     ea.emp_id = ev.emp_id
               and ea.roster_date between md.effective_start_date
                                      and md.effective_end_date
               and (ea.out_time - ea.in_time) * 24 > 9
               and ev.emp_type_id=2
               and (ea.emp_id, ea.roster_date) not in
                      (select emp_id,roster_date
                         from ot_register_dtl
                        where roster_date between md.effective_start_date
                                              and md.effective_end_date)
                                              AND ea.emp_id = rg.emp_id
               AND ea.roster_date = rg.roster_date
               AND md.department_id = NVL (ev.current_department_id, ev.dpt_department_id)
               AND ea.emp_id NOT IN
                (SELECT emp_id
                   FROM ot_register_temp
                  WHERE ea.roster_date BETWEEN date_from AND date_to)
               AND rg.shift_id = rs.shift_id";

            if ($emp_id) {
                $query .= " and ea.emp_id = '" . $emp_id . "' ";
            }
            if ($otMonthSlab) {
                $query .= " and md.ot_month_detail_id = '" . $otMonthSlab . "' ";
            }

            if ($department) {
                $query .= " and ea.department_id = '" . $department . "' ";
            }
            $query .= ") order by emp_name,roster_date desc";
            $otUnregister = DB::select($query);

            return [
                "status" => true,
                "otUnregister" => $otUnregister
            ];

        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

    }


    public function store(Request $request)
    {
        $status_code = 0;
        $unRegisteredOT = $request->get('items');
        $counter = 0;
        $status_message = "no rows update";
        $params = ["o_status_message" => $status_message, "o_status_code" => $status_code];
        if ($unRegisteredOT) {
            DB::beginTransaction();
            try {
                foreach ($unRegisteredOT as $data) {
                    $status_code = sprintf("%4000s", "");
                    $status_message = sprintf("%4000s", "");
                    $params = [
                        "p_emp_id" => isset($data['emp_id']) ? $data['emp_id'] : '',
                        "p_roster_date" => date("Y-m-d", strtotime(isset($data['roster_date']) ? $data['roster_date'] : '')),
                        "p_ot_month_id" => isset($data['ot_month_id']) ? $data['ot_month_id'] : '',
                        "p_ot_month_detail_id" => isset($data['ot_month_detail_id']) ? $data['ot_month_detail_id'] : '',
                        "p_insert_by" => auth()->id(),
                        "o_status_code" => &$status_code,
                        "o_status_message" => &$status_message,
                    ];
                    DB::executeProcedure("OVERTIME.unregistered_ot_entry", $params);
                    if ($params['o_status_code'] != 1) {
                        throw new Oci8Exception($params['o_status_message'], $params['o_status_code']);
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

}
