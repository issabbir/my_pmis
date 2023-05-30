<?php


namespace App\Managers\Dashboad;


use Illuminate\Support\Facades\DB;

class SalaryManager
{
    public function employeeSalary(){
        $sql = "SELECT 'Salary' AS NAME, MONTH_NAME, NETPAY AS AMOUNT
  FROM (WITH
            ADDITION
            AS
                (SELECT PM.PR_MONTH_ID,
                        TO_CHAR (PM.CALCULATION_START_DATE, 'FMMONTH-YYYY')
                            MONTH_NAME,
                        PM.CALCULATION_START_DATE,
                        NVL (P.ADDITION, 0)
                            ADDITION
                   FROM (  SELECT PR.PR_MONTH_ID, SUM (PR.AMOUNT) ADDITION
                             FROM PR_SALARY_PROCESS PR
                            WHERE PR.DEDUCTION_YN = 'N'
                         GROUP BY PR.PR_MONTH_ID) P,
                        PR_MONTHS  PM
                  WHERE     P.PR_MONTH_ID(+) = PM.PR_MONTH_ID
                        AND (   TRUNC (SYSDATE) BETWEEN PM.CALCULATION_START_DATE
                                                    AND PM.CALCULATION_END_DATE
                             OR TRUNC (LAST_DAY (ADD_MONTHS (SYSDATE, -1))) BETWEEN PM.CALCULATION_START_DATE
                                                                                AND PM.CALCULATION_END_DATE)),
            DEDECTION
            AS
                (SELECT PM.PR_MONTH_ID,
                        TO_CHAR (PM.CALCULATION_START_DATE, 'FMMONTH-YYYY')
                            MONTH_NAME,
                        PM.CALCULATION_START_DATE,
                        NVL (P.DED, 0)
                            DED
                   FROM (  SELECT PR.PR_MONTH_ID, SUM (PR.AMOUNT) DED
                             FROM PR_SALARY_PROCESS PR
                            WHERE PR.DEDUCTION_YN = 'Y'
                         GROUP BY PR.PR_MONTH_ID) P,
                        PR_MONTHS  PM
                  WHERE     P.PR_MONTH_ID(+) = PM.PR_MONTH_ID
                        AND (   TRUNC (SYSDATE) BETWEEN PM.CALCULATION_START_DATE
                                                    AND PM.CALCULATION_END_DATE
                             OR TRUNC (LAST_DAY (ADD_MONTHS (SYSDATE, -1))) BETWEEN PM.CALCULATION_START_DATE
                                                                                AND PM.CALCULATION_END_DATE))
          SELECT AD.MONTH_NAME,
                 AD.CALCULATION_START_DATE,
                 AD.ADDITION - DED.DED     NETPAY
            FROM ADDITION AD, DEDECTION DED
           WHERE     AD.PR_MONTH_ID = DED.PR_MONTH_ID
                 AND (   AD.MONTH_NAME = TO_CHAR (SYSDATE, 'FMMONTH-YYYY')
                      OR AD.MONTH_NAME =
                         TO_CHAR (ADD_MONTHS (SYSDATE, -1), 'FMMONTH-YYYY'))
        ORDER BY AD.CALCULATION_START_DATE DESC)
 WHERE ROWNUM <= 2
UNION ALL
  SELECT 'PF'                                                   AS NAME,
         TO_CHAR (m.CALCULATION_START_DATE, 'FMMONTH-YYYY')     MONTH_NAME,
         NVL (SUM (amount), 0)                                  PF_AMOUNT
    FROM GPF_TRANSACTION_DETAILS t, PR_MONTHS m
   WHERE     t.MONTH_ID(+) = m.PR_MONTH_ID
         AND (   TRUNC (SYSDATE) BETWEEN m.CALCULATION_START_DATE
                                     AND m.CALCULATION_END_DATE
              OR TRUNC (LAST_DAY (ADD_MONTHS (SYSDATE, -1))) BETWEEN m.CALCULATION_START_DATE
                                                                 AND m.CALCULATION_END_DATE)
GROUP BY 'PF', TO_CHAR (m.CALCULATION_START_DATE, 'FMMONTH-YYYY')
UNION ALL
  SELECT 'OT'                                                 AS NAME,
         TO_CHAR (m.EFFECTIVE_START_DATE, 'FMMONTH-YYYY')     MONTH_NAME,
         NVL (SUM (t.pay_amount), 0)                          OT_AMOUNT
    FROM OT_CALCULATION t, OT_MONTHS m
   WHERE     t.OT_MONTH_ID(+) = m.OT_MONTH_ID
         AND (   TRUNC (SYSDATE) BETWEEN m.EFFECTIVE_START_DATE
                                     AND m.EFFECTIVE_END_DATE
              OR TRUNC (LAST_DAY (ADD_MONTHS (SYSDATE, -1))) BETWEEN m.EFFECTIVE_START_DATE
                                                                 AND m.EFFECTIVE_END_DATE)
GROUP BY 'OT', TO_CHAR (m.EFFECTIVE_START_DATE, 'FMMONTH-YYYY')
ORDER BY 1, 2 DESC";

        $salaries = DB::select($sql);

        $data = [];
        $columns = [];
        foreach ($salaries as $salary) {
            $columns[] = strtolower($salary->month_name);
            $data[strtolower($salary->name)][strtolower($salary->month_name)]= $salary->amount;
            $data[strtolower($salary->name)][strtolower($salary->month_name).'-format']= number_format($salary->amount,2);
        }
        return ['columns' => array_unique($columns), 'data' => $data ];
    }

}
