<?php

namespace App\Http\Controllers\Api\V1\Overtime\Setup;

use App\Contracts\Overtime\OvertimeContract;
use App\Entities\Admin\LRosterShift;
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

class OtRosterGroupController extends Controller
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

    public function otRosterGroups(Request $request)
    {
        $monthId = $request->get('month_id');
        $groupId = $request->get('group_id');
        $departmentId = $request->get('department_id');
        $shiftId = $request->get('shift_id');

        $sql = <<<QUERY
SELECT rg.ot_month ot_month, rg.group_id group_id, rg.emp_id, e.emp_name emp_name, rg.department_id department_id, ld.department_name department_name, lds.DPT_SECTION section_name, rg.emp_code, rg.off_day off_day
  FROM ot_months om, ot_roster_group rg
  INNER JOIN employee e ON e.emp_id = rg.emp_id
  LEFT JOIN l_department ld ON ld.department_id =  rg.department_id
  LEFT JOIN l_dpt_section lds ON lds.dpt_section_id = e.section_id
 WHERE     rg.ot_month_id = :ot_month_id
       AND rg.ot_group_id = :group_id
       AND rg.department_Id = :department_id
       AND om.ot_year = rg.ot_year
       AND om.ot_month = rg.ot_month
       AND om.open_yn = 'O'
       AND rg.approve_yn = 'Y'
QUERY;

        $rosterGroups = DB::select($sql,
            [
                'ot_month_id' => $monthId,
                'group_id' => $groupId,
                'department_id' => $departmentId
            ]
        );

        /** FIXME: JUST TO GET THE SHIFT_ID I HAVE TO DO THIS AS QUICK FIX. Adding ot_month_detail_id in roster_detail table
         * as foreign key constrain and add condition, "AND rd.month_slab_id = md.ot_month_detail_id" may solve this issue!
         * ot_month_detail_id in roster_detail will contain month_slab_id from form.
         */
        if ($rosterGroups) {
            foreach ($rosterGroups as $key => $rosterGroup) {
                $sql = <<<QUERY
SELECT
       rd.shift_id, md.effective_start_date, md.effective_end_date,rd.OT_MONTH_DETAIL_ID
  FROM ot_months om,
       ot_roster_group rg,
       employee e,
       ot_months_detail md,
       ot_roster_details rd
 WHERE md.ot_month_id = om.ot_month_id
       AND om.ot_year = rg.ot_year
       AND om.ot_month = rg.ot_month
       AND rg.emp_id = e.emp_id
       AND md.ot_month_id = om.ot_month_id
       AND rg.department_Id = :department_id
       AND e.emp_id = rd.emp_id
       AND om.open_yn = 'O'
       AND rd.emp_id = :emp_id
       AND rd.ot_month_detail_id = md.ot_month_detail_id
       AND rd.shift_id = :shift_id
QUERY;

                $rosterDetailData = DB::selectOne($sql,
                    [
                        'emp_id' => $rosterGroup->emp_id,
                        'department_id' => $departmentId,
                        'shift_id' => $shiftId
                    ]
                );

                if ($rosterDetailData) {
                    $shift = LRosterShift::find($rosterDetailData->shift_id);
                    $shift_name = $shift->shift_code . " ($shift->shift_start_time - $shift->shift_end_time)";
                    $rosterGroups[$key]->shift_name = $shift_name;
                    $effectiveStartDate = date('d-m-Y', strtotime($rosterDetailData->effective_start_date));
                    $effectiveEndDate = date('d-m-Y', strtotime($rosterDetailData->effective_end_date));


                    $rosterGroups[$key]->month_slab = "$effectiveStartDate - $effectiveEndDate";
                    $rosterGroups[$key]->month_slab_id = $rosterDetailData->ot_month_detail_id;

                } else {
                    $rosterGroups[$key]->shift_name = '';
                    $rosterGroups[$key]->month_slab = '';
                    $rosterGroups[$key]->month_slab_id = '';
                }
            }
        }

        $rosterDetails = OtRosterDetails::where(
            [
                ['ot_month_id', '=', $monthId],
                ['group_id', '=', $groupId],
                'department_id' => $departmentId
            ]
        )->distinct()->get([
            'ot_month_id',
            'ot_month_detail_id',
            'group_id',
            'shift_id',
        ]);

        $rosterDetailsArray = [];

        foreach ($rosterDetails as $key => $rosterDetail) {
            $rosterGroup = OtGroupMst::find($rosterDetail->group_id);
            $rosterMonth = OtMonths::find($rosterDetail->ot_month_id);
            $rosterMonthDetail = OtMonthsDetail::find($rosterDetail->ot_month_detail_id);
            $shift = LRosterShift::find($rosterDetail->shift_id);

            $rosterDetailsArray[$key]['roster_id'] = $rosterDetail->roster_id;
            $rosterDetailsArray[$key]['roster_month'] = $rosterMonth ? $rosterMonth : '';
            $rosterDetailsArray[$key]['roster_group'] = $rosterGroup ? $rosterGroup : '';
            $rosterDetailsArray[$key]['ot_months_detail'] = $rosterMonthDetail ? $rosterMonthDetail : '';
            $rosterDetailsArray[$key]['shift'] = $shift ? $shift : '';
        }

        $monthSlabs = $this->overtimeManager->findMonthSlabs($monthId, $departmentId);

        return [
            'roster_groups' => $rosterGroups,
            'roster_details' => $rosterDetailsArray,
            'month_slabs' => $monthSlabs
        ];
    }

    public function getPreloadInfo()
    {
        $slugs = $this->adminManager->findCurrentDepartments()->pluck('department_id');
        $rosterGroups = DB::select("SELECT rg.group_name,
         rg.department_id,
         rg.shift_id,
         ld.department_name,
         ot_year,
         ot_month,
         ot_month_id,
         TO_CHAR (TO_DATE (ot_year || ot_month, 'RRRRMM'), 'RRRR-fmMonth')
            AS year_month,
         COUNT (*) as total,
         COUNT (CASE WHEN approve_yn = 'Y' THEN approve_yn END) AS approved
    FROM ot_roster_group rg, l_department ld
   WHERE rg.department_id = ld.department_id
   --and rg.DEPARTMENT_ID in (:dptIds)
GROUP BY rg.group_name,
         rg.department_id,
         ld.department_name,
         ot_year,
         ot_month,
         ot_month_id,
         shift_id,
         TO_CHAR (TO_DATE (ot_year || ot_month, 'RRRRMM'), 'RRRR-fmMonth')");

        return [
            "departmentList" => $this->adminManager->findCurrentDepartments(),
            "months" => $this->otMonth(),
            'shifts' => $this->overtimeManager->findShifts(),
            "rosterGroup" => [],// $rosterGroups
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
    public function previousGroupData(Request $request)
    {
        // dd($group);
//        $group_name = $group->group_name;
//        $month = OtMonths::find($group->ot_month_id);
//       // dd($month);
//        $ot_year = $month->ot_year;
//        $ot_month = $month->ot_month;;
//        $group = OtGroupMst::find($request->get('group'));
        $department_id = $request->get('department_id');
        $group = $request->get('group');
        $month = $request->get('month');

        $whereMonth = " AND ev.emp_id NOT IN
                                (SELECT emp_id
                                FROM ot_roster_group org
                                WHERE ot_month_id = $month  AND org.department_id = $department_id )";

          $sql = "SELECT
            ev.department_name,
            rg.emp_id,rg.emp_code, rg.off_day,
            rg.reff_value,
            rg.division_id,
            rg.department_id,ev.designation,
             l_emp_type.emp_type_id,
            ev.emp_name || ' (' || l_emp_type.emp_type_name || ')' as emp_name
  FROM ot_roster_group rg, employee_info_vu ev left join l_emp_type on (l_emp_type.emp_type_id = ev.emp_type_id)
 WHERE     rg.emp_id = ev.emp_id $whereMonth
         AND rg.ot_group_id = '$group' AND rg.department_id = $department_id";
        $details = DB::Select($sql);
        // dd($details);
        return [
            'employees' => $details,
        ];
    }
    public function groupDetails(Request $request)
    {
        $month = new OtMonths();
        $rosterGroups = new OtRosterGroup();
//         $where = [];
//         if($request->get('group_name')){
//            $where[] = ['group_name',$request->get('group_name')];
//         }
//         if($request->get('department_id')){
//            $where[] = ['department_id',$request->get('department_id')];
//         }
//         if($request->get('ot_year')){
//            $where[] = ['ot_year',$request->get('ot_year')];
//         }
//         if($request->get('ot_month')){
//            $where[] = ['ot_month',$request->get('ot_month')];
//         }

        $monthId = $month->where('ot_year', $request->get('ot_year'))->where('ot_month', $request->get('ot_month'))->first();
        return [
            'group_name' => $request->get('group_name'),
            'month' => $monthId['ot_month_id'],
            'month_slabs' => $request->get('ot_month_detail_id'),
            'shift' => $request->get('shift_id'),
            'departmentId' => $request->get('department_id'),
            'section_id' => $request->get('section_id'),
//             'designation' => isset($employee['designation']),
//             'department_name' => $request->get('department_name'),
            'rosterDetails' => $this->roster_details($request),
        ];
    }

    private function roster_details($request)
    {
        $group_name = $request->get('group_name') ? $request->get('group_name') : '';
        $department_id = $request->get('department_id') ? $request->get('department_id') : '';
        $ot_year = $request->get('ot_year') ? $request->get('ot_year') : '';
        $ot_month = $request->get('ot_month') ? $request->get('ot_month') : '';
        $section_id = $request->get('section_id') ? $request->get('section_id') : null;

          $sql = "SELECT
            ev.department_name, rg.group_id,
            rg.emp_id,rg.emp_code, rg.off_day,
            rg.reff_value,
            rg.division_id,
            rg.section_id,
             rg.approve_yn,
            rg.department_id,ev.designation,
             l_emp_type.emp_type_id,
            ev.emp_name || ' (' || l_emp_type.emp_type_name || ')' as emp_name
  FROM ot_roster_group rg, employee_info_vu ev left join l_emp_type on (l_emp_type.emp_type_id = ev.emp_type_id)
 WHERE     rg.emp_id = ev.emp_id
       AND rg.group_name = '$group_name'
       AND rg.ot_year = '$ot_year'
       AND rg.ot_month = '$ot_month'
      -- AND ev.dpt_department_id = '$department_id
       AND NVL (rg.SECTION_ID, 0) = NVL (:section_id, 0)
       AND rg.DEPARTMENT_ID = '$department_id'
       ORDER BY ev.EMP_CODE ASC";
        $details = DB::Select($sql,['section_id'=>$section_id]);

        return $details;
    }

    // Employee search
    public function searchResult(Request $request)
    {
        $emps = [];
        $department_id = $request->get('department_id');
        $section_id = $request->get('section_id');
        $group_section_id = $request->get('group_section_id');

        if (isset($request)) {
            $whereMonth = '';
            $whereSection = '';

            if ($group_section_id) {
                $whereSection = " AND org.section_id = $group_section_id ";
            }


            if ($request->get('month')) {
                $monthId = $request->get('month');
//                $whereMonth .= " AND ev.emp_id NOT IN
//                                (SELECT emp_id
//                                FROM ot_roster_group org
//                                WHERE ot_month_id = $monthId AND approve_yn = 'Y' $whereSection AND org.department_id = $department_id )";
                $whereMonth .= " AND ev.emp_id NOT IN
                                (SELECT emp_id
                                FROM ot_roster_group org
                                WHERE ot_month_id = $monthId  $whereSection AND org.department_id = $department_id )";
            }
            if ($group_section_id) {
                $whereMonth .= " AND ev.section_id = $group_section_id ";
            }

            if ($section_id) {
                $whereMonth .= " AND ev.section_id = $section_id ";
            }

//          echo  $sql = "SELECT distinct ev.emp_id,
//                   ev.emp_code,
//                   et.emp_type_id,
//                   ev.emp_name || ' (' || et.emp_type_name || ')' as emp_name,
//                   ev.designation,
//                   ev.designation_id,
//                   NVL(ev.current_department_id,ev.dpt_department_id) as dpt_department_id,
//                   NVL(ev.current_department_name,ev.department_name) as department_name,
//                   ev.dpt_division_id,
//                   ev.section_id
//                FROM employee_info_vu ev
//                left join l_emp_type et on (et.emp_type_id = ev.emp_type_id)
//                    WHERE NVL(ev.current_department_id,ev.dpt_department_id) = '$department_id'
//                        AND ev.emp_status_id in (1, 13)" . $whereMonth;
            $employeeList = DB::select("SELECT distinct ev.emp_id,
                   ev.emp_code,
                   et.emp_type_id,
                   ev.emp_name || ' (' || et.emp_type_name || ')' as emp_name,
                   ev.designation,
                   ev.designation_id,
                   NVL(ev.current_department_id,ev.dpt_department_id) as dpt_department_id,
                   NVL(ev.current_department_name,ev.department_name) as department_name,
                   ev.dpt_division_id,
                   ev.section_id
                FROM employee_info_vu ev
                left join l_emp_type et on (et.emp_type_id = ev.emp_type_id)
                    WHERE NVL(ev.current_department_id,ev.dpt_department_id) = '$department_id'
                        AND ev.emp_status_id in (1, 13) " . $whereMonth . "ORDER BY ev.EMP_ID");

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
        }

        $previousGroups = [];
        if ($request->get('month')){
            $previousGroups = $this->previousGroups($request);
        }

        return [
            "status" => true,
            "previousGroups" => $previousGroups,
            "employees" => $emps
        ];
    }


    public function searchWithGroupSectionResult(Request $request)
    {
        $emps = [];
        $department_id = $request->get('department_id');
        $section_id = $request->get('section_id');
        $group_section_id = $request->get('group_section_id');

        if (isset($request)) {
            $whereMonth = '';
            $whereSection = '';

            if ($group_section_id) {
                $whereSection = " AND org.section_id = $group_section_id ";
            }

            if ($request->get('month')) {
                $monthId = $request->get('month');
                $whereMonth .= " AND ev.emp_id NOT IN
                                (SELECT emp_id
                                FROM ot_roster_group org
                                WHERE ot_month_id = $monthId  $whereSection AND org.department_id = $department_id )";
            }
            if ($group_section_id) {
                $whereMonth .= " AND ev.section_id = $group_section_id ";
            } else {
                $whereMonth .= " AND ev.section_id is null ";
            }

            if ($section_id) {
                $whereMonth .= " AND ev.section_id = $section_id ";
            }
            $employeeList = DB::select("SELECT distinct ev.emp_id,
                   ev.emp_code,
                   et.emp_type_id,
                   ev.emp_name || ' (' || et.emp_type_name || ')' as emp_name,
                   ev.designation,
                   ev.designation_id,
                   NVL(ev.current_department_id,ev.dpt_department_id) as dpt_department_id,
                   NVL(ev.current_department_name,ev.department_name) as department_name,
                   ev.dpt_division_id,
                   ev.section_id
                FROM employee_info_vu ev
                left join l_emp_type et on (et.emp_type_id = ev.emp_type_id)
                    WHERE NVL(ev.current_department_id,ev.dpt_department_id) = '$department_id'
                        AND ev.emp_status_id in (1, 13) " . $whereMonth);

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
        }

        $previousGroups = [];
        if ($request->get('month')){
            $previousGroups = $this->previousGroups($request);
        }

        return [
            "status" => true,
            "previousGroups" => $previousGroups,
            "employees" => $emps
        ];
    }

    public function previousGroups($request){
        $month = $request->get('month');
        $department_id = $request->get('department_id');
        $otMonth = OtMonths::find($month);
        $lastMonthYear = date('Y-m', strtotime($otMonth->ot_year.'-'.$otMonth->ot_month." -1 month"));
        $monthYear = explode("-" ,$lastMonthYear);
        $lastOtMonth = OtMonths::where('ot_year',$monthYear[0])->where('ot_month',$monthYear[1])->first();
        return OtGroupMst::where('ot_month_id',$lastOtMonth->ot_month_id)->where('department_id',$department_id)->get();
    }
    public function previousGroupEmployees($month){
        $otMonth = OtMonths::find($month);
        $lastMonthYear = date('Y-m', strtotime($otMonth->ot_year.'-'.$otMonth->ot_month." -1 month"));
        $monthYear = explode("-" ,$lastMonthYear);
        $lastOtMonth = OtMonths::where('ot_year',$monthYear[0])->where('ot_month',$monthYear[1])->first();
        return OtGroupMst::where('ot_month_id',$lastOtMonth->ot_month_id)->get();
    }

    // Group search
    public function searchGroupResult(Request $request)
    {
        try {
            $rosterGroupList = '';
            $department_id = $request->get('department_id') ? $request->get('department_id') : '';
            $section_id = $request->get('section_id') ? $request->get('section_id') : '';
            $month_id = $request->get('month') ? $request->get('month') : '';
            $group = $request->get('group') ? $request->get('group') : '';
            $ot_year = '';
            $ot_month = '';
            if ($month_id) {
                $months = new OtMonths();
                $month = $months->where('ot_month_id', $month_id)->first();
                $ot_year = $month['ot_year'] ? $month['ot_year'] : '';
                $ot_month = $month['ot_month'] ? $month['ot_month'] : '';
            }

            if (isset($request)) {
                $query = "SELECT rg.group_name,
         rg.department_id,
         rg.section_id,
         s.DPT_SECTION,
         ld.department_name,
         ot_year,
         ot_month,
         TO_CHAR (TO_DATE (ot_year || ot_month, 'RRRRMM'), 'RRRR-fmMonth')
            AS year_month,
         COUNT(*)  AS total,
         COUNT (CASE WHEN approve_yn = 'Y' THEN approve_yn END) AS approved
    FROM ot_roster_group rg, l_department ld , L_DPT_SECTION s
   WHERE   rg.department_id = ld.department_id  AND rg.SECTION_ID = s.DPT_SECTION_ID(+)";
                // dd($rosterGroupList);
                if ($request->get('section_id')){
                    $query .= " AND (rg.section_id = '$section_id')";
                }
                if ($department_id && !$ot_year && !$ot_month && !$group) {
                    $query .= " AND (rg.department_id = '$department_id')";
                } else if (!$department_id && $ot_year && $ot_month && !$group) {
                    $query .= " AND (rg.ot_year = '$ot_year'  AND rg.ot_month = '$ot_month')";
                } else if ($department_id && $ot_year && $ot_month && !$group) {
                    $query .= " AND (rg.department_id = '$department_id' AND rg.ot_year = '$ot_year'  AND rg.ot_month = '$ot_month')";
                } else if ($department_id && $ot_year && $ot_month && $group) {
//                    $query .= " AND (rg.department_id = '$department_id' AND rg.ot_year = '$ot_year'  AND rg.ot_month = '$ot_month'  AND UPPER(rg.group_name) LIKE '%' || UPPER('$group') || '%')";
                    $query .= " AND (rg.department_id = '$department_id' AND rg.ot_year = '$ot_year'  AND rg.ot_month = '$ot_month'  AND rg.ot_group_id = '$group')";
                } else if (!$department_id && $ot_year && $ot_month && $group) {
//                    $query .= " AND (rg.ot_year = '$ot_year'  AND rg.ot_month = '$ot_month'  AND UPPER(rg.group_name) LIKE '%' || UPPER('$group') || '%')";
                    $query .= " AND (rg.ot_year = '$ot_year'  AND rg.ot_month = '$ot_month'  AND rg.ot_group_id = '$group')";
                } else {
                    $query .= " ";
                }

                $query .= " GROUP BY rg.group_name,
                         rg.department_id,
                         ld.department_name,
                         rg.section_id,
                         s.DPT_SECTION,
                         ot_year,
                         ot_month,
                         TO_CHAR (TO_DATE (ot_year || ot_month, 'RRRRMM'), 'RRRR-fmMonth')";
                // echo $query;
                $rosterGroupList = DB::select($query);
            }
            return [
                "status" => true,
                "rosterGroup" => $rosterGroupList //->all()
            ];

        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
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
        DB::beginTransaction();
        $rosterGroup = new OtRosterGroup();
        $params = [];
        try {
            //dd($request->get('items')[0]['group_id']);
//            !$request->get('edit') ||
            if (isset($request->get('items')[0]['group_id']) && $request->get('items')[0]['group_id'] == 0){
                $group_name = OtGroupMst::where('group_name',trim($request->get('group_name')))->where('ot_month_id',$request->get('month'))->count();
                if ($group_name){
                    return ["o_status_code" => false, "o_status_message" =>'Group Name Already Existed'];
                }
            }

            // dd($group_name = OtGroupMst::where('group_name',trim($request->get('group_name')))->where('ot_month_id',$request->get('month'))->count());
            foreach ($request->get('items') as $otRosterGroup) {
                $p_ot_roster_id = isset($otRosterGroup['group_id']) ? $otRosterGroup['group_id'] : '';
                $emp_id = isset($otRosterGroup['emp_id']) ? $otRosterGroup['emp_id'] : '';
                $statusCode = sprintf("%4000s", "");
                $statusMessage = sprintf('%4000s', '');
               // OtRosterGroup::where()

                $params = [
                    "p_group_id" => [
                        "value" => &$p_ot_roster_id,
                        "type" => \PDO::PARAM_INT,
                        "length" => 255
                    ],
                    "p_group_name" => $request->get('group_name'),
                    "p_ot_month_detail_id" => $request->get('month_slabs'),
                    "p_shift_id" => $request->get('shift'),
                    "p_emp_id" => $otRosterGroup['emp_id'],
                    "p_off_day" => isset($otRosterGroup['off_day']) ? $otRosterGroup['off_day'] : '',
                    "p_emp_code" => isset($otRosterGroup['emp_code']) ? $otRosterGroup['emp_code'] : '',
                    "p_division_id" => isset($otRosterGroup['dpt_division_id']) ? $otRosterGroup['dpt_division_id'] : $otRosterGroup['division_id'],
                    "p_department_id" => isset($otRosterGroup['dpt_department_id']) ? $otRosterGroup['dpt_department_id'] : $otRosterGroup['department_id'],
                    "p_section_id" => isset($otRosterGroup['section_id']) ? $otRosterGroup['section_id'] : '',
                    "p_reff_value" => isset($otRosterGroup['reff_value']) ? $otRosterGroup['reff_value'] : '',
                    "p_ot_month_id" => $request->get('month'),
                    "p_approve_yn" => isset($otRosterGroup['approve_yn']) ? $otRosterGroup['approve_yn'] : '',
                    "p_insert_by" => Auth()->ID(),
                    "p_update_by" => Auth()->ID(),
                    'o_status_code' => &$statusCode,
                    'o_status_message' => &$statusMessage
                ];
                //dd($params);
                DB::executeProcedure('OVERTIME.create_ot_roster_group', $params);
                if ($params['o_status_code'] != 1) {
                    DB::rollBack();
                    return $params;
                }
            }

            if ($params['o_status_code'] == 1)
                DB::commit();

            return $params;// ["table_info" => $this->load_ot_tmp_data(),  "params" =>$params]; //
        } catch (\Exception $e) {
            return ["table_info" => $params, "exception" => true, "o_status_code" => false, "o_status_message" => $e->getMessage()];
        }

    }
    public function storeApproval(Request $request)
    {

        DB::beginTransaction();

        $rosterGroup = new OtRosterGroup();
        $params = [];
//        $offDays = [];
//        foreach ($request->get('items') as $offday){
//            $offDays[] = isset($offday['off_day']) ?  $offday['off_day'] : '';
//        };
        // dd($request->all());

        try {
            foreach ($request->get('items') as $otRosterGroup) {
                $p_ot_roster_id = isset($otRosterGroup['group_id']) ? $otRosterGroup['group_id'] : '';
                $emp_id = isset($otRosterGroup['emp_id']) ? $otRosterGroup['emp_id'] : '';

                $statusCode = sprintf("%4000s", "");
                $statusMessage = sprintf('%4000s', '');

                $params = [
                    "p_group_id" => [
                        "value" => &$p_ot_roster_id,
                        "type" => \PDO::PARAM_INT,
                        "length" => 255
                    ],
                    "p_emp_id" => $otRosterGroup['emp_id'],
                    "p_ot_month_detail_id" => $request->get('month'),
                    "p_approve_yn" => isset($otRosterGroup['approve_yn']) ? $otRosterGroup['approve_yn'] : '',
                    "p_insert_by" => Auth()->ID(),
                    'o_status_code' => &$statusCode,
                    'o_status_message' => &$statusMessage
                ];

                DB::executeProcedure('OVERTIME.ot_roster_group_approval', $params);
                if ($params['o_status_code'] != 1) {
                    DB::rollBack();
                    return $params;
                }
            }

            if ($params['o_status_code'] == 1)
                DB::commit();

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
