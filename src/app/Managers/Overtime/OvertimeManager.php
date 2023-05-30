<?php

namespace App\Managers\Overtime;
use App\Contracts\Overtime\OvertimeContract;
use App\Entities\Admin\LRosterShift;
use App\Entities\Overtime\OtGroupMst;
use App\Entities\Overtime\OtMonths;
use App\Entities\Overtime\OtMonthsDetail;
use App\Entities\Overtime\OtRosterGroup;
use DB;

class OvertimeManager implements OvertimeContract
{
    public function findOtMonths($id=null)
    {
        $OtMonths = new OtMonths();
        if ($id) {
            return $OtMonths->find($id);
        }
        return $OtMonths->orderby('ot_year', 'asc','ot_month' ,'asc')->get();
    }

    public function findOtYears($id=null)
    {
        $OtMonths=new OtMonths();
        if($id){
            return $OtMonths->find($id);
        }
        return $OtMonths->where('open_yn', 'Y')->orderby('ot_month_id','desc')->get();

    }

    public function findGroups($monthId, $departmentId,$sectionId=null)
    {
       // dd($sectionId);

        $group = new OtGroupMst();
        $groups = $group->where(
            [
                ['ot_month_id', '=', $monthId],
                ['department_id', '=', $departmentId]
            ]
        );
        if ($sectionId != 'null'){
            $groups = $groups->where('section_id', $sectionId);
        }
            $data = $groups->get();

        return $data;
    }

    public function findGroupsDeptChange($departmentId)
    {
        /*$group = new OtGroupMst();
        $groups = $group->where(
            [
                ['department_id', '=', $departmentId]
            ]
        )->get();

        return $groups;*/
        $data = \Illuminate\Support\Facades\DB::select("SELECT gm.ot_group_id VALUE,
          gm.group_name
       || ' - '
       || TO_CHAR (om.effective_start_date, 'fmMonth, RRRR')
          text
  FROM ot_group_mst gm, ot_months om
 WHERE     gm.ot_month_id = om.ot_month_id
       AND om.open_yn = 'O'
       AND gm.department_id = :department_id", ['department_id' => $departmentId]);
        return $data;
    }

    public function findMonthSlabs($monthId, $departmentId)
    {
        $otMonthsDetail = new OtMonthsDetail();

        $monthSlabs = $otMonthsDetail->where(
            [
                ['ot_month_id', '=', $monthId],
                ['department_id', '=', $departmentId]
            ]
        )->orderBy('effective_start_date', 'asc')->orderBy('effective_end_date', 'asc')->get();

        return $monthSlabs;
    }

    public function findShifts($id=null)
    {
        $otShifts = new LRosterShift();

        if ($id) {
            return $otShifts->find($id);
        }

        return $otShifts->orderby('shift_id', 'asc')->get();
    }

    public function findOpenOtMonths()
    {
        $OtMonths = new OtMonths();
        return $OtMonths->where('open_yn', 'O')->orderby('effective_start_date', 'desc')->get();
    }
}
