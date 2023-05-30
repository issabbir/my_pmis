<?php


namespace App\Managers\Dashboad;


use Illuminate\Support\Facades\DB;

class VesselBillingManager
{
    public function getData()
    {
        $sql = "select
            nvl(sum(TOTAL_BILL_AMT_BDT), 0) total_bill_amount,
            nvl(sum(FAS_PAID_AMOUNT), 0) PAID_AMOUNT, to_char((sysdate -7),'FMDD-MM-YYYY') bill_from_date,
            to_char(sysdate,'FMDD-MM-YYYY') bill_to_date
                from VSL.VSL_BILL_MASTER
                    where status = 'A'
                    and UPDATE_DATE between (sysdate -7) and sysdate";
        return DB::select($sql);
    }


    public function getVesselHandled(){
        $sql = "select t2.*, nvl(t3.total,0) total from (with tb as (
select sysdate, add_months(sysdate,-level+1) month_add
from dual
connect by level<=4
)
select to_char (t.month_add,'fmMON-YYYY') MONTH_YEAR  , extract(year from month_add) n_year, extract( month from month_add) n_month
from tb t ) t2
left join
(SELECT MONTH_YEAR, TOTAL
    FROM ( SELECT TO_CHAR (PILOTAGE_FROM_TIME, 'fmMON-YYYY')
                       MONTH_YEAR,
                   TO_DATE (TO_CHAR (PILOTAGE_FROM_TIME, 'fmMON-YYYY'),
                            'MON-YYYY'),
                   COUNT (*)
                       AS TOTAL
              FROM MDA.PILOTAGES
            WHERE STATUS = 'C'
          GROUP BY TO_NUMBER (TO_CHAR (PILOTAGE_FROM_TIME, 'MMYYYY')),
                   TO_CHAR (PILOTAGE_FROM_TIME, 'fmMON-YYYY')
          ORDER BY 2 DESC)
   WHERE ROWNUM BETWEEN 1 AND 4
ORDER BY ROWNUM DESC
) t3 on(t2.MONTH_YEAR = t3.MONTH_YEAR)
order by to_date (t2.MONTH_YEAR, 'fmMON-YYYY')";
        $vessels = DB::select($sql);


        $container_cargo_sql = "SELECT UPDATED_AT AS MONTHS,
       NVL (CONTAINER, 0) AS CONTAINER,
       NVL (CARGO, 0) AS CARGO
  FROM (WITH A
             AS (    SELECT TO_CHAR (
                               ADD_MONTHS (TRUNC (SYSDATE, 'yyyy') - 1,
                                           LEVEL - 1),
                               'MON-RRRR')
                               UPDATED_AT
                       FROM DUAL
                 CONNECT BY LEVEL <= 2),
             B
             AS (  SELECT VC.NAME,
                          TO_CHAR (TRUNC (VH.UPDATED_AT), 'MON-YYYY')
                             UPDATED_AT,
                          SUM (
                               NVL (VH.OA_WORK, 0)
                             + NVL (VH.OA_NOT_WORK, 0)
                             + NVL (VH.SPL_BERTH_WORK, 0)
                             + NVL (VH.SPL_BERTH_NOT_WORK, 0)
                             + NVL (VH.JETTY_WORK, 0)
                             + NVL (VH.JETTY_NOT_WORK, 0))
                             AS TOTAL
                     FROM COSS.DB_VESSEL_CATEGORIES VC
                          LEFT JOIN COSS.DB_DAILY_VESSEL_HISTORIES VH
                             ON VC.ID = VH.VESSEL_CATEGORY_ID
                    WHERE VC.ID IN (1, 2)
                 GROUP BY VC.NAME,
                          TO_CHAR (TRUNC (VH.UPDATED_AT), 'MON-YYYY'))
        SELECT A.UPDATED_AT, B.NAME, NVL (B.TOTAL, 0) TOTAL
          FROM A, B
         WHERE A.UPDATED_AT = B.UPDATED_AT(+))
       PIVOT
          (SUM (TOTAL)
          FOR NAME
          IN ('Container' AS CONTAINER, 'General Cargo' AS CARGO)) PIVOT_TABLE";
        $container_cargo = DB::select($container_cargo_sql);
        $data = [];
        $columns = [];
        $labels = [];
        $value = [];
        foreach ($vessels as $vessel) {
            $columns[] = $vessel->month_year;
            $data[$vessel->month_year]= $vessel->total;
        }
        foreach ($vessels as $vessel) {
            $labels[] = $vessel->month_year;
            $value [] = (int)$vessel->total;
        }
        return ['columns' => array_unique($columns), 'data' => $data, 'labels' => $labels, 'value'=>$value,'container_cargo'=>$container_cargo ];
    }
}
