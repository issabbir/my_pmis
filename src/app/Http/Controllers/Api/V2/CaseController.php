<?php


namespace App\Http\Controllers\Api\V2;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CaseController
{
    public function cases(){
        $sql="SELECT TO_CHAR (CASE_DATE, 'RRRR') AS YEAR,
         COUNT (CASE WHEN CM.CASE_STATUS_ID = 1 THEN 1 END) AS NEW,
         COUNT (CASE WHEN CM.CASE_STATUS_ID NOT IN (1, 3) THEN 1 END)
            AS IN_PROGRESS,
         COUNT (CASE WHEN CM.CASE_STATUS_ID = 3 THEN 1 END) AS COMPLETED,
         COUNT (*) AS TOTAL
    FROM CPACMS.CASE_MASTER_INFO CM, CPACMS.L_CASE_STATUS CS
   WHERE CM.CASE_STATUS_ID = CS.CASE_STATUS_ID
GROUP BY TO_CHAR (CASE_DATE, 'RRRR')";

        $cases = DB::select($sql);
        $row = [];
        $new = 0;
        $in_progress = 0;
        $completed = 0;
        $total = 0;
        foreach ($cases as $salary) {
            $new += $salary->new;
            $in_progress += $salary->in_progress;
            $completed += $salary->completed;
            $total += $salary->total;
        }
        $row['year'] = 'Total';
        $row['new'] = $new;
        $row['in_progress'] = $in_progress;
        $row['completed'] = $completed;
        $row['total'] = $total;
        $row['_rowVariant'] = 'dark';
        array_unshift($cases,$row);
        return $cases;
    }
}
