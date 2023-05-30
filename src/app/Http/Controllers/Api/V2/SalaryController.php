<?php


namespace App\Http\Controllers\Api\V2;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SalaryController
{
    public function employeeSalary(){
        $sql = "select * from(
WITH ADDITION
     AS (SELECT PM.PR_MONTH_ID,
                  TO_CHAR (PM.CALCULATION_START_DATE, 'FMMONTH-YYYY')  MONTH_NAME,
                  PM.CALCULATION_START_DATE,
                  SUM (AMOUNT) ADDITION
             FROM PR_SALARY_PROCESS PR, L_DEPARTMENT LD, PR_MONTHS PM
            WHERE     DEDUCTION_YN = 'N'
                  AND PR.DPT_DEPARTMENT_ID = LD.DEPARTMENT_ID
                  AND PM.PR_MONTH_ID = PR.PR_MONTH_ID
         GROUP BY
                  PM.PR_MONTH_ID,
                  PM.CALCULATION_START_DATE,
                  TO_CHAR (PM.CALCULATION_START_DATE, 'FMMONTH-YYYY')),
     DEDECTION
     AS ( SELECT PM.PR_MONTH_ID,
                  TO_CHAR (PM.CALCULATION_START_DATE, 'FMMONTH-YYYY')  MONTH_NAME,
                  PM.CALCULATION_START_DATE,
                  SUM (AMOUNT) DED
             FROM PR_SALARY_PROCESS PR, L_DEPARTMENT LD, PR_MONTHS PM
            WHERE     DEDUCTION_YN = 'Y'
                  AND PR.DPT_DEPARTMENT_ID = LD.DEPARTMENT_ID
                  AND PM.PR_MONTH_ID = PR.PR_MONTH_ID
         GROUP BY
                  PM.PR_MONTH_ID,
                  PM.CALCULATION_START_DATE,
                  TO_CHAR (PM.CALCULATION_START_DATE, 'FMMONTH-YYYY'))
  SELECT
         AD.MONTH_NAME,
         AD.CALCULATION_START_DATE,
         AD.ADDITION - DED.DED NETPAY
    FROM ADDITION AD, DEDECTION DED
   WHERE
          AD.PR_MONTH_ID = DED.PR_MONTH_ID

ORDER BY AD.CALCULATION_START_DATE desc)
where rownum <= 2";

        $salaries = DB::select($sql);
        $data = [];
        $row = [];
        $change = 0;
        foreach ($salaries as $salary) {
            $change -= $salary->netpay;
            $row['label'] = 'Salary';
            $row[strtolower($salary->month_name)] = $salary->netpay;
            $row['Change'] = $change;
        }
        $data[] = $row;
        return $data;
    }
}
