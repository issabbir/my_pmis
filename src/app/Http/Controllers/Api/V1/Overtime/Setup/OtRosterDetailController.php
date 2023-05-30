<?php

namespace App\Http\Controllers\Api\V1\Overtime\Setup;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\LDepartment;
use App\Entities\Admin\LRosterShift;
use App\Entities\Overtime\OtGroupMst;
use App\Entities\Overtime\OtMonths;
use App\Entities\Overtime\OtMonthsDetail;
use App\Entities\Overtime\OtRosterDetails;
use App\Entities\Overtime\OtRosterGroup;
use App\Http\Controllers\Controller;
use App\Managers\Overtime\OvertimeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OtRosterDetailController extends Controller
{
    protected $overtimeManager;

    public function __construct(OvertimeManager $overtimeManager)
    {
        $this->overtimeManager = $overtimeManager;
    }

    public function index(Request $request, AdminContract $adminManager)
    {
        $overtimeManager = $this->overtimeManager;
        //$departments = LDepartment::orderBy('department_name', 'asc')->get();

        return [
            'months' => $overtimeManager->findOpenOtMonths(),
            'departments' => $adminManager->findCurrentDepartments(),
            'shifts' => $overtimeManager->findShifts()
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
    public function findGroups(Request $request, $monthId, $departmentId, $sectionId = null)
    {
        return [
            'groups' => $this->overtimeManager->findGroups($monthId, $departmentId,$sectionId),
        ];
    }

    public function findGroupsDeptChange(Request $request, $departmentId)
    {
        return [
            'groups' => $this->overtimeManager->findGroupsDeptChange($departmentId),
        ];
    }

    public function view(Request $request, $id)
    {

    }

    public function otRosterGroups(Request $request)
    {
        $monthId = $request->get('month_id');
        $groupId = $request->get('group_id');
        $departmentId = $request->get('department_id');
        $section_id = $request->get('section_id');
        $shiftId = $request->get('shift_id');
        $whereSection = '';
        if ($request->get('section_id')){
            $whereSection = " AND rg.section_id = nvl($section_id,rg.section_id)";
        }

        $sql = <<<QUERY
SELECT rg.ot_month        ot_month,
       rg.GROUP_ID        GROUP_ID,
       rg.emp_id,
       e.emp_name         emp_name,
       rg.department_id   department_id,
       ld.department_name department_name,
       lds.DPT_SECTION    section_name,
       rg.emp_code,
       rg.off_day         off_day
  FROM ot_months        om,
       ot_roster_group  rg
       INNER JOIN employee e ON e.emp_id = rg.emp_id
       LEFT JOIN l_department ld ON ld.department_id = rg.department_id
       LEFT JOIN l_dpt_section lds ON lds.dpt_section_id = e.section_id
 WHERE     rg.ot_month_id = nvl(:ot_month_id, rg.ot_month_id)
       AND rg.ot_group_id = nvl(:GROUP_ID, rg.ot_group_id)
       AND rg.department_Id = :department_id
       AND om.ot_year = rg.ot_year
       AND om.ot_month = rg.ot_month
       AND om.open_yn = 'O'
       AND rg.approve_yn = 'Y'
       $whereSection
       ORDER BY e.EMP_CODE
QUERY;

        $rosterGroups =  DB::select($sql,
            [
                'ot_month_id' => $monthId,
                'group_id' => $groupId,
                'department_id' => $departmentId,
            ]
        );

        /** FIXME: JUST TO GET THE SHIFT_ID I HAVE TO DO THIS AS QUICK FIX. Adding ot_month_detail_id in roster_detail table
         * as foreign key constrain and add condition, "AND rd.month_slab_id = md.ot_month_detail_id" may solve this issue!
         * ot_month_detail_id in roster_detail will contain month_slab_id from form.
         */
        if($rosterGroups){
            foreach($rosterGroups as $key => $rosterGroup) {
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

                $rosterDetailData =  DB::selectOne($sql,
                    [
                        'emp_id' => $rosterGroup->emp_id,
                        'department_id' => $departmentId,
                        'shift_id' => $shiftId
                    ]
                );

                if($rosterDetailData) {
                    $shift = LRosterShift::find($rosterDetailData->shift_id);
                    $shift_name = $shift->shift_code. " ($shift->shift_start_time - $shift->shift_end_time)";
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

        foreach($rosterDetails as $key => $rosterDetail) {
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

    public function store(Request $request)
    {
        $rosterGroup = $request->post();

        try {
            $o_status_code = sprintf('%4000s', '');
            $o_status_message = sprintf('%4000s', '');

            $params = [
                'ot_month_id' => $rosterGroup['month_id'],
                'department_id' => $rosterGroup['department_id'],
                'ot_group_id' => $rosterGroup['group_id'],
                'ot_month_detail_id' => $rosterGroup['month_slab_id'],
                'shift_id' => $rosterGroup['shift_id'],
                'insert_by' => auth()->id(),
                'o_status_code' => &$o_status_code,
                'o_status_message' => &$o_status_message,
            ];
            DB::executeProcedure('overtime.ot_roster_detail_ins', $params);
            return $params;
        } catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'o_status_code'=> 99, 'message' => $e->getMessage()];
        }
    }

    public function update(Request $request, $id)
    {

    }

    public function remove(Request $request)
    {

    }

    public function findEmpDetails($monthId, $empId) {
         return DB::select("select OVERTIME.EMP_OT_REG_AVAILABLE_DATA(:empId, :monthId) from dual", ['empId' => $empId, 'monthId' => $monthId]);
    }

    public function updateEmpDetails(Request $request) {
        return $this->OVERTIME_EMP_OT_ROSTER_DETAIL_UPD($request);
    }

    public function OVERTIME_EMP_OT_ROSTER_DETAIL_UPD(Request $request)
    {
        try {

            $status_code = sprintf("%4000s","");
            $status_message = sprintf("%4000s","");
            $params = [

                "p_groupdtl_id" => $request->get("groupdtl_id"),
                "p_shift_id" => $request->get("shift_id"),
                "p_active_yn" => $request->get("active_yn"),
                "p_remarks" => $request->get("remarks"),
                "p_update_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OVERTIME.EMP_OT_ROSTER_DETAIL_UPD", $params);
        }
        catch (\Exception $e) {
            return ["exception" => true,"o_status_code"=>99, "status" => false, "o_status_message" => $e->getMessage()];
        }

        return $params;
    }
}
