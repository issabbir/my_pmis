<?php

namespace App\Http\Controllers\Api\V1\Overtime\Setup;

use App\Entities\Overtime\OtMonths;
use App\Http\Controllers\Controller;
use App\Managers\Overtime\OvertimeManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class OtRosterMonthSetupController extends Controller
{
    protected $overtimeManager;

    public function __construct(OvertimeManager $overtimeManager)
    {
        $this->overtimeManager = $overtimeManager;
    }

    public function index(Request $request)
    {
        return [
            "otmonts" => $this->getOTMonth(),
            "rosterYears" => $this->getRosterYear()
        ];

    }

    private function getOTMonth()
    {
        $query = "select OT_MONTH_ID, FY_ID, OT_YEAR,
                OT_MONTH, EFFECTIVE_START_DATE, EFFECTIVE_END_DATE, CURRENT_YN,
                PERMITED_EMP_ID, PERMITED_DATE, INSERT_BY, INSERT_DATE, UPDATE_DATE,
                UPDATE_BY, DESCRIPTION,decode(OPEN_YN,'O','Open','N','Not Open','C','Closed')OPEN_YN from OT_MONTHS
                order by OT_YEAR asc,ot_month asc";


        $otmonts = DB::select($query);

        return $otmonts;

    }

    public function getNextOTYearMonth()
    {
        /* $query = "SELECT nvl(DECODE (MAX (ot_month), '12', MAX (ot_year) + 1,MAX (ot_year)),to_char(sysdate,'yyyy')) next_ot_year,
                 nvl(decode(MAX (ot_month),'12','1',MAX (ot_month) + 1), EXTRACT (MONTH FROM SYSDATE)) next_month
                 FROM OT_MONTHS
                 WHERE ot_year = (SELECT MAX (ot_year) FROM OT_MONTHS)";*/

        $query = "SELECT TO_CHAR (mm, 'RRRR') next_ot_year, TO_CHAR (mm, 'fmMM') next_month
  FROM (WITH t
             AS (SELECT ot_year,
                        ot_month,
                        TO_DATE (ot_year || ot_month, 'RRRRMM') max_month
                   FROM ot_months)
        SELECT CASE
                  WHEN TRUNC (SYSDATE, 'MM') <= MAX (max_month)
                  THEN
                     ADD_MONTHS (MAX (max_month), 1)
                  ELSE
                     ADD_MONTHS (TRUNC (SYSDATE, 'MM'), 1)
               END
                  mm
          FROM t
         WHERE ot_year = (SELECT MAX (ot_year) FROM t))";

        $otNextYearMonth = DB::select($query);
        return [
            "otNextYearMonth" => $otNextYearMonth
        ];

    }

    private function getRosterYear()
    {
        $currYear = date("Y");
        $startYear = $currYear - 10;
        $endYear = $currYear + 10;
        $i = 0;
        $rosterYears = [];
        $year = array();
        for ($i = $startYear; $i <= $endYear; $i++) {
            $year[] = $i;
        }

        foreach ($year as $item) {
            $rosterYears[] = ["text" => $item, 'value' => $item];
        }
        return $rosterYears;

    }

    private function findRosterYear()
    {
        $query = "select OT_YEAR from OT_MONTHS group by OT_YEAR order by OT_YEAR";
        $otYear = DB::select($query);

        $otYear_option = [];
        //$otYear_option[] = [];
        foreach ($otYear as $item) {
            $otYear_option[] = ["text" => $item->ot_year,
                'value' => $item->ot_year];
        }
        return $otYear_option;
    }

    public function getRosterYears()
    {
        return [
            "rosterYears" => $this->findRosterYear()
        ];
    }


    public function view(Request $request, $id)
    {
        $OtMonthsdata = new OtMonths();
        $OtMonthsdata = $OtMonthsdata->find($id);
        return $OtMonthsdata;
    }

    public function store(Request $request)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [

                "p_ot_month_id" => $request->get("ot_month_id"),
                "p_ot_year" => $request->get("ot_year"),
                "p_ot_month" => $request->get("ot_month"),
                "p_effective_start_date" => date("Y-m-d", strtotime($request->get("effective_start_date"))),
                "p_effective_end_date" => date("Y-m-d", strtotime($request->get("effective_end_date"))),
                "p_open_yn" => $request->get("open_yn"),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OVERTIME.OT_MONTH_ENTRY", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    public function update(Request $request, $id)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [

                "p_ot_month_id" => $id,
                "p_ot_year" => $request->get("ot_year"),
                "p_ot_month" => $request->get("ot_month"),
                "p_effective_start_date" => date("Y-m-d", strtotime($request->get("effective_start_date"))),
                "p_effective_end_date" => date("Y-m-d", strtotime($request->get("effective_end_date"))),
                "p_open_yn" => $request->get("open_yn"),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("OVERTIME.OT_MONTH_ENTRY", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }


    public function search(Request $request)
    {
        try {
            $ot_year = $request->get("ot_year");
            $ot_month = $request->get("ot_month");
            $open_yn = $request->get("open_yn");

            $query = "SELECT * FROM
            (select OT_MONTH_ID, FY_ID, OT_YEAR, OT_MONTH, EFFECTIVE_START_DATE,
            EFFECTIVE_END_DATE, CURRENT_YN,
            OPEN_YN EDIT_OPEN_YN,
            OPEN_YN, PERMITED_EMP_ID,
            PERMITED_DATE, DESCRIPTION from OT_MONTHS where OT_YEAR is not null";

            if ($ot_year) {
                $query .= " and OT_YEAR= '" . $ot_year . "' ";
            }
            if ($ot_month) {
                $query .= " and OT_MONTH = '" . $ot_month . "' ";
            }
            if ($open_yn) {
                $query .= " and OPEN_YN = '" . $open_yn . "' ";
            }
            $query .= ") order by CURRENT_YN desc,OPEN_YN desc, OT_YEAR asc,OT_MONTH asc";
            $otmonts = DB::select($query);

            return [
                "otmonts" => $otmonts
            ];
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

    }

    public function otMonthClosed(Request $request)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $ot_month_id = $request->get('ot_month_id');
            $edit_open_yn = $request->get('edit_open_yn');
            $current_yn = $request->get('current_yn');
            $params = [
                "p_ot_month_id" => $ot_month_id,
                "p_open_yn" => $edit_open_yn,
                "p_current_yn" => $current_yn?:'N',
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("overtime.ot_month_entry_status_upd", $params);
            if ($params['o_status_code'] != 1) {
                throw new Oci8Exception($params['o_status_message'], $params['o_status_code']);
            }
        }catch (\Exception $e) {
            return ["exception" => true, "status" => false, 'o_status_code' => $e->getCode(), "o_status_message" => $e->getMessage()];
        }

//        $status_code = 0;
//        $unpostedOts = $request->post();
//        $counter = 0;
//        $message = "";
//        $status_message = "no rows update";
//        $params = ["o_status_message" => $status_message, "o_status_code" => $status_code];
//        if ($unpostedOts) {
//            DB::beginTransaction();
//            try {
//                foreach ($unpostedOts as $unpostedOt) {
//
//                    $ot_month_id = $unpostedOt['ot_month_id'];
//                    $edit_open_yn = $unpostedOt['edit_open_yn'];
//                    $open_yn = $unpostedOt['open_yn'];
//
//                    if ($edit_open_yn == $open_yn) {
//                        continue;
//
//                    } else {
//                        $status_code = sprintf("%4000s", "");
//                        $status_message = sprintf("%4000s", "");
//                        $params = [
//
//                            "p_ot_month_id" => $ot_month_id,
//                            "p_open_yn" => $edit_open_yn,
//                            "p_insert_by" => auth()->id(),
//                            "o_status_code" => &$status_code,
//                            "o_status_message" => &$status_message,
//                        ];
//                        DB::executeProcedure("overtime.ot_month_entry_status_upd", $params);
//                        if ($params['o_status_code'] != 1) {
//                            throw new Oci8Exception($params['o_status_message'], $params['o_status_code']);
//                        }
//                    }
//
//                    $counter++;
//                }
//                DB::commit();
//            } catch
//            (\Exception $e) {
//                DB::rollback();
//                return ["exception" => true, "status" => false, 'o_status_code' => $e->getCode(), "o_status_message" => $e->getMessage()];
//            }
//            if ($counter == 0) {
//                $params['o_status_message'] = "No rows update!";
//            } else {
//                $params['o_status_message'] = "Successfully updated ${counter} records!";
//            }
//        }
        return $params;
    }
}
