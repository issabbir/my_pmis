<?php

namespace App\Http\Controllers\Api\V2;

use App\Entities\Setup\LMonth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonthController extends Controller
{
    //
    /**
     * @OA\Get(
     * path="/api/month/list",
     * summary="MonthList",
     * description="All month list",
     * operationId="monthList",
     * tags={"month_year"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Success"
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Returns when user is not authenticated",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Not authorized"),
     *    )
     * )
     * )
     */
    public function list(){
        $months = array();

        for ($i=1; $i<=12; $i++) {

            $month = new \stdClass();

            if($i == 1){
                $month->month_id = '0' . (string)$i;
                $month->month_name = 'January';
            }else if($i == 2) {
                $month->month_id = '0' . (string)$i;
                $month->month_name = 'February';
            }else if($i == 3) {
                $month->month_id = '0' . (string)$i;
                $month->month_name = 'March';
            }else if($i == 4) {
                $month->month_id = '0' . (string)$i;
                $month->month_name = 'April';
            }else if($i == 5) {
                $month->month_id = '0' . (string)$i;
                $month->month_name = 'May';
            }else if($i == 6) {
                $month->month_id = '0' . (string)$i;
                $month->month_name = 'June';
            }else if($i == 7) {
                $month->month_id = '0' . (string)$i;
                $month->month_name = 'July';
            }else if($i == 8) {
                $month->month_id = '0' . (string)$i;
                $month->month_name = 'August';
            }else if($i == 9) {
                $month->month_id = '0' . (string)$i;
                $month->month_name = 'September';
            }else if($i == 10) {
                $month->month_id = (string)$i;
                $month->month_name = 'October';
            }else if($i == 11) {
                $month->month_id = (string)$i;
                $month->month_name = 'November';
            }else if($i == 12) {
                $month->month_id = (string)$i;
                $month->month_name = 'December';
            }



            array_push($months,$month);

        }


        return response()->json(['success' => true, 'data' => ['months' => $months]], 200);

    }

    public function getMonthsById() {
        $sql  = "SELECT DISTINCT
         PM.PR_MONTH_ID AS VALUE,
         TO_CHAR (PM.CALCULATION_START_DATE, 'fmMonth - YYYY') AS TEXT
    FROM PR_BILL_STATES PBS
         INNER JOIN L_PR_BILL_STATUS LPS
            ON (LPS.PR_BILL_STATUS_ID = PBS.PR_BILL_STATUS_ID)
         INNER JOIN PR_MONTHS PM ON (PBS.MONTH_ID = PM.PR_MONTH_ID)
   WHERE LPS.STATUS_KEY = 'BILL_DISBURSED' AND PM.OPEN_YN = 'O'
ORDER BY PM.PR_MONTH_ID desc" ;
        return DB::select($sql);
    }
}
