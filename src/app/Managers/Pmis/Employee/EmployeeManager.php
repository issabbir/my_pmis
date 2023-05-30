<?php

namespace App\Managers\Pmis\Employee;


use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmployeeTemp;
use App\Entities\Security\Role;
use App\Entities\Security\UserRole;
use App\Enums\Pmis\Employee\Statuses;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeManager implements EmployeeContract
{
    protected $employee;
    protected $auth;

    public function __construct(Employee $employee, Guard $auth)
    {
        $this->employee = $employee;
        $this->auth = $auth;
    }

    /**
     * Employee options, can be used wherever its needed.
     *
     * @param $name
     * @return mixed
     */
    public function otEmployeeOption($name)
    {
        return $this->employee->select('employee.emp_id', 'employee.emp_code', DB::raw("emp_code||' '||emp_name AS option_name"), 'emp_name', 'designation_id', 'dpt_department_id', 'section_id') //
        ->join('l_emp_grade', function ($join) {
            $join->on('l_emp_grade.emp_grade_id', '=', 'employee.emp_grade_id')
                ->where('l_emp_grade.ot_yn', '=', 'Y');
        })
            ->where('employee.emp_status_id', '=', Statuses::ON_ROLL)
            ->where(function ($query) use ($name) {
                $query->where(DB::raw('LOWER(employee.emp_name)'), 'like', strtolower('%' . trim($name) . '%'))
                    ->orWhere('employee.emp_code', 'like', '%' . trim($name) . "%");
            })
            ->groupBy('employee.emp_id', 'employee.emp_code', 'employee.emp_name', 'employee.designation_id', 'employee.dpt_department_id', 'employee.section_id')
            ->limit(20)
            ->get();
    }


    /**
     * Employee options, can be used wherever its needed same data as ot roster.
     *
     * @param $name
     * @return mixed
     */
    public function otEmployeeOptionToSearchRegisteredEmployee($name, $dept_id)
    {
        return $this->employee->select('employee.emp_id', 'employee.emp_code',
            DB::raw("employee.emp_code||' '||employee.emp_name AS option_name"), 'employee.emp_name',
            'employee.designation_id', 'employee.dpt_department_id', 'employee.section_id')
            ->join('ot_roster_group_dtl', function ($join) {
                $join->on('ot_roster_group_dtl.emp_id', '=', 'employee.emp_id');
            })
            ->join('l_emp_grade', function ($join) {
                $join->on('l_emp_grade.emp_grade_id', '=', 'employee.emp_grade_id')
                    ->where('l_emp_grade.ot_yn', '=', 'Y');
            })
            ->where('employee.emp_status_id', '=', Statuses::ON_ROLL)
            //->whereNotIn('employee.emp_id', $rosterEmployee)
            ->where(function ($query) use ($name) {
                $query->where(DB::raw('LOWER(employee.emp_name)'), 'like', strtolower('%' . $name . '%'))
                    ->orWhere('employee.emp_code', 'like', '%' . $name . "%");
            })
            ->where('employee.DPT_DEPARTMENT_ID', '=', $dept_id)
            ->groupBy('employee.emp_id', 'employee.emp_code', 'employee.emp_name', 'employee.designation_id', 'employee.dpt_department_id', 'employee.section_id')
            ->limit(20)
            ->get();
    }

    /**
     * Employee options, can be used wherever its needed same data as ot roster.
     *
     * @param $name
     * @return mixed
     */
    public function unRegisteredOtEmployeeOptionToEntryNewEmployee($name, $dept_id)
    {
        $hasPermission = Auth()->user()->hasPermission('CAN_SEE_ALL_DEPARTMENT');

        $query = "SELECT od.emp_id,
         ev.emp_code,
         ev.emp_code || ' ' || ev.emp_name       AS option_name,
         ev.emp_name,
         ev.dpt_department_id,
         ev.department_name,
         ev.designation_id,
         ev.designation,
         ev.section_id,
         ev.dpt_section,
         MIN (TRUNC (od.roster_date))             date_from, --MIN (od.roster_date)                  date_from,
        MAX (TRUNC (od.roster_date))     date_to
    FROM ot_roster_group_dtl od
         LEFT JOIN ot_register_temp ot ON (od.emp_id = ot.emp_id)
         LEFT JOIN employee_info_vu ev ON (od.emp_id = ev.emp_id)
   WHERE     ev.emp_type_id = 2
         AND ev.emp_status_id = 1
        AND (ev.emp_code LIKE '%" . $name . "%' OR lower(ev.emp_name) LIKE '%" . strtolower($name) . "%' )
        AND od.roster_date >
                    (SELECT NVL (MAX (date_to), TRUNC (SYSDATE) - 3650)
                       FROM ot_register_temp t
                      WHERE     t.emp_id =
                                   od.emp_id
                            AND t.approve_status <> -1)";

        if (!$hasPermission)
            $query = $query . " AND ev.current_department_id = $dept_id";

        $query = $query . " AND LAST_DAY ((SELECT NVL (MAX (date_to), TO_DATE ('1-jan-2010'))
                          FROM ot_register
                         WHERE emp_id = od.emp_id )) > (SELECT NVL (MAX (date_to), TO_DATE ('1-jan-2010'))
                    FROM ot_register
                        WHERE emp_id = od.emp_id)
                        GROUP BY od.emp_id,
                         ot.emp_id,
                         ev.emp_code,
                         ev.emp_name,
                         ev.dpt_department_id,
                         ev.department_name,
                         ev.designation_id,
                         ev.designation,
                         ev.section_id,
                         ev.dpt_section";
        //HAVING MAX (od.roster_date) > MAX (ot.date_to) OR ot.emp_id IS NULL
        return DB::select($query);
    }

    /**
     * Employee options, can be used wherever its needed same data as ot roster.
     *
     * @param $name
     * @return mixed
     */
    public function otEmployeeOptionSameAsRoster($name)
    {
        return $this->employee->select('employee.emp_id', 'employee.emp_code',
            DB::raw("employee.emp_code||' '||employee.emp_name AS option_name"), 'employee.emp_name',
            'employee.designation_id', 'employee.dpt_department_id', 'employee.section_id')
            ->join('ot_roster_group_dtl', function ($join) {
                $join->on('ot_roster_group_dtl.emp_id', '=', 'employee.emp_id');
            })
            ->join('l_emp_grade', function ($join) {
                $join->on('l_emp_grade.emp_grade_id', '=', 'employee.emp_grade_id')
                    ->where('l_emp_grade.ot_yn', '=', 'Y');
            })
            ->where('employee.emp_status_id', '=', Statuses::ON_ROLL)
            ->where(function ($query) use ($name) {
                $query->where(DB::raw('LOWER(employee.emp_name)'), 'like', strtolower('%' . trim($name) . '%'))
                    ->orWhere('employee.emp_code', 'like', '%' . trim($name) . "%");
            })
            ->groupBy('employee.emp_id', 'employee.emp_code', 'employee.emp_name', 'employee.designation_id', 'employee.dpt_department_id', 'employee.section_id')
            ->limit(20)
            ->get();
    }

    public function otEmployeeOptionSameAsRosterByDept($name, $dept_id)
    {
        return $this->employee->select('employee.emp_id', 'employee.emp_code',
            DB::raw("employee.emp_code||' '||employee.emp_name AS option_name"), 'employee.emp_name',
            'employee.designation_id', 'employee.dpt_department_id', 'employee.section_id')
            ->join('ot_register', function ($join) {
                $join->on('ot_register.emp_id', '=', 'employee.emp_id');
            })
            ->where('employee.emp_status_id', '=', Statuses::ON_ROLL)
            ->Where('ot_register.process_flag', '=', 0)
            ->whereRaw("employee.dpt_department_id=nvl($dept_id,employee.dpt_department_id)")
            ->where(function ($query) use ($name) {
                $query->where(DB::raw('LOWER(employee.emp_name)'), 'like', strtolower('%' . trim($name) . '%'))
                    ->orWhere('employee.emp_code', 'like', '%' . trim($name) . "%");
            })
            ->groupBy('employee.emp_id', 'employee.emp_code', 'employee.emp_name', 'employee.designation_id', 'employee.dpt_department_id', 'employee.section_id')
            ->limit(20)
            ->get();
    }

    public function gpfEmployees($search, $option)
    {
        if(Auth::user()->hasPermission('CAN_APPLY_GPF_LOAN_APPLICATION_FOR_ALL')){
            $sql = "select PFPROCESS.gpf_employee_search_all(:search, :opt,:auth) from dual";
        }else{
            $sql = "select PFPROCESS.gpf_employee_search(:search, :opt,:auth) from dual";
        }

        return DB::select($sql, ['search' => $search, 'opt' => $option, 'auth' => auth()->id()]);
    }

    public function gpfEmployeeSelf($search, $option)
    {
        $sql = "select PFPROCESS.gpf_employee_self(:search, :opt) from dual";
        return DB::select($sql, ['search' => $search, 'opt' => $option]);
    }

    public function nonGpfEmployees($search)
    {
        $role_id = Role::where('role_key', 'Manage_All_GPF_Application')->value('role_id');
        $user_roles = UserRole::where('role_id', $role_id)->where('user_id', auth()->id())->get();

            if(count($user_roles) > 0 || Auth::user()->hasPermission('CAN_APPLY_GPF_LOAN_APPLICATION_FOR_ALL')){
                if(Auth::user()->hasPermission('CAN_APPLY_GPF_APPLICATION_FOR_ALL')){
                    $sql = "select PFPROCESS.new_gpf_employee_search_for_all(:search) from dual";
                    return DB::select($sql, ['search' => $search]);
                }
                $sql = "select PFPROCESS.new_gpf_employee_search_all(:search) from dual";
                return DB::select($sql, ['search' => $search]);
            }else{
                $hasPermission = Auth()->user()->hasPermission('CAN_SEE_ALL_DEPARTMENT');
                if (!$hasPermission) {
                    $department_id = Auth::user()->employee->dpt_department_id;
                } else {
                    $department_id = '';
                }
                $sql = "select PFPROCESS.new_gpf_employee_search(:search, :department_id,:auth) from dual";
                return DB::select($sql, ['search' => $search,
                    'department_id' => $department_id,
                    'auth' => auth()->id()]);
            }


    }

    /**
     * Employee options, can be used wherever its needed.
     *
     * @param $name
     * @return mixed
     */
    public function employeeOption($name)
    {
        return $this->employee->select('emp_id', 'emp_code', DB::raw("emp_code||' '||emp_name AS option_name"), 'emp_name', 'designation_id', 'dpt_department_id', 'section_id', 'bill_code', 'dpt_division_id')
            ->whereIn('employee.emp_status_id', [Statuses::ON_ROLL, 13]) //Only on roll employee 13 = deputation
            ->where(function ($query) use ($name) {
                $query->where(DB::raw('LOWER(emp_name)'), 'like', strtolower('%' . trim($name) . '%'))
                    ->orWhere('emp_code', 'like', '%' . trim($name) . "%");
            })
            ->groupBy('emp_id', 'emp_code', 'emp_name', 'designation_id', 'dpt_department_id', 'section_id', 'bill_code', 'dpt_division_id')
            ->limit(20)
            ->get();
    }

    public function securityEmployeeOption($name, $userId)
    {
        return $this->employee->select('emp_id', 'emp_code', DB::raw("emp_code||' '||emp_name AS option_name"), 'emp_name', 'designation_id', 'dpt_department_id', 'section_id', 'bill_code', 'dpt_division_id')
            ->whereIn('employee.emp_status_id', [Statuses::ON_ROLL, 13]) //Only on roll employee 13 = deputation
            ->where(function ($query) use ($name) {
                $query->where(DB::raw('LOWER(emp_name)'), 'like', strtolower('%' . trim($name) . '%'))
                    ->orWhere('emp_code', 'like', '%' . trim($name) . "%");
            })
            ->whereNotIn('emp_id', $userId)
            ->groupBy('emp_id', 'emp_code', 'emp_name', 'designation_id', 'dpt_department_id', 'section_id', 'bill_code', 'dpt_division_id')
            ->limit(20)
            ->get();
    }

    public function chargeBaseEmployeeOption($name)
    {
        if (Auth::user()->hasPermission('CAN_SEE_ONLY_SELF_DEPARTMENT') && !Auth::user()->hasRole('SUPER_ADMIN')) {
//            $department_id = Auth::user()->employee->dpt_department_id;
            $department_id = Auth::user()->employee->current_department_id;
//dd($department_id);
            return $this->employee->select('emp_id', 'emp_code', DB::raw("emp_code||' '||emp_name AS option_name"), 'emp_name', 'designation_id', 'dpt_department_id', 'section_id', 'emp_grade_id', 'dpt_division_id', 'emp_join_date')
                ->where(function ($query) use ($name) {
                    $query->where(DB::raw('LOWER(emp_name)'), 'like', strtolower('%' . trim($name) . '%'))
                        ->orWhere('emp_code', 'like', '%' . trim($name) . "%");
                })
                ->where('employee.dpt_department_id', '=', $department_id)
                ->groupBy('emp_id', 'emp_code', 'emp_name', 'designation_id', 'dpt_department_id', 'section_id', 'emp_grade_id', 'dpt_division_id', 'emp_join_date')
                ->limit(20)
                ->get();

        } else {
            return $this->employee->select('emp_id', 'emp_code', DB::raw("emp_code||' '||emp_name AS option_name"), 'emp_name', 'designation_id', 'dpt_department_id', 'section_id', 'emp_grade_id', 'dpt_division_id', 'emp_join_date')
                ->where(function ($query) use ($name) {
                    $query->where(DB::raw('LOWER(emp_name)'), 'like', strtolower('%' . trim($name) . '%'))
                        ->orWhere('emp_code', 'like', '%' . trim($name) . "%");
                })
                ->groupBy('emp_id', 'emp_code', 'emp_name', 'designation_id', 'dpt_department_id', 'section_id', 'emp_grade_id', 'dpt_division_id', 'emp_join_date')
                ->limit(20)
                ->get();

        }

    }

    public function dptBasedEmployeeOption($name, $dptId)
    {
        return $this->employee->select('emp_id', 'emp_code', DB::raw("emp_code||' '||emp_name AS option_name"), 'emp_name', 'designation_id', 'dpt_department_id', 'section_id')
            ->where('emp_status_id', '=', Statuses::ON_ROLL)
            ->Where('dpt_department_id', '=', $dptId)
            ->where(function ($query) use ($name) {
                $query->where(DB::raw('LOWER(emp_name)'), 'like', strtolower('%' . trim($name) . '%'))
                    ->orWhere('emp_code', 'like', '%' . trim($name) . "%");
            })
            ->groupBy('emp_id', 'emp_code', 'emp_name', 'designation_id', 'dpt_department_id', 'section_id')
            ->limit(20)
            ->get();
    }

    public function billerOption($name)
    {
        return $this->employee->select('employee.emp_id', 'emp_code', DB::raw("emp_code||' '||emp_name||' | '||employee.bill_code AS option2"), 'emp_name', 'designation_id', 'dpt_department_id', 'section_id', 'employee.bill_code')
            ->join('pr_process_users', 'pr_process_users.emp_id', '=', 'employee.emp_id')
            ->where('pr_process_users.active_yn', '=', 'Y')
            ->where('employee.emp_status_id', '=', Statuses::ON_ROLL)
            ->where(function ($q) use ($name) {
                $q->where('emp_name', 'like', strtoupper('%' . $name . '%'))
                    ->orWhere('emp_code', 'like', '%' . trim($name) . '%')->orWhere('employee.bill_code', 'like', '%' . trim($name) . '%');
            })
            ->limit(20)
            ->get();
    }


    public function unapprovedEmployeeOption($name)
    {
//        return DB::table('employee_temp')
        return EmployeeTemp::select('emp_id', 'emp_code', DB::raw("emp_code||' '||emp_name AS option_name"), 'emp_name', 'designation_id', 'dpt_department_id', 'section_id', 'bill_code', 'dpt_division_id')
            ->where('employee_temp.approved_yn', '=', 'N')
            ->where(function ($query) use ($name) {
                $query->where(DB::raw('LOWER(emp_name)'), 'like', strtolower('%' . trim($name) . '%'))
                    ->orWhere('emp_code', 'like', '%' . trim($name) . "%");
            })
            ->groupBy('emp_id', 'emp_code', 'emp_name', 'designation_id', 'dpt_department_id', 'section_id', 'bill_code', 'dpt_division_id')
            ->limit(20)
            ->get();
    }

    public function unapprovedEmployee()
    {

        if (Auth::user()->hasRole('all_approval')) {
            $whereDepartment = '';
        } else {
            $department_id = Auth::user()->employee->dpt_department_id;
            $whereDepartment = "AND E.DPT_DEPARTMENT_ID = $department_id";
        }


        $sql = "SELECT D.DESIGNATION, DP.DEPARTMENT_NAME, DV.DPT_DIVISION_NAME, E.EMP_ID, E.EMP_CODE, E.EMP_NAME, E.EMP_HOLD_YN, TO_CHAR(E.UPDATE_DATE, 'DD-MM-YYYY HH24:MM') MODIFY_DATE,
case
       when E.update_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=E.update_by)
       when E.insert_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=E.insert_by)
       else '' end last_updated_by
FROM EMPLOYEE_TEMP E
JOIN L_DESIGNATION D ON D.DESIGNATION_ID = E.DESIGNATION_ID
JOIN L_DEPARTMENT DP ON DP.DEPARTMENT_ID = E.DPT_DEPARTMENT_ID
JOIN L_DPT_DIVISION DV ON DV.DPT_DIVISION_ID = E.DPT_DIVISION_ID
WHERE  E.APPROVED_YN = 'N' $whereDepartment
ORDER BY E.UPDATE_DATE ASC ";
        return DB::select($sql);
    }

    public function getAuthRole($role_key)
    {
        $role = [];
        foreach (auth()->user()->roles as $role_name) {
            $role[] = $role_name->role_key;
            if ($role_name->role_key == $role_key) {
                return true;
            }
        }
        return false;
    }
}
