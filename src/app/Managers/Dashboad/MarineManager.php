<?php


namespace App\Managers\Dashboad;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\DeclareDeclare;

class MarineManager
{
    public function dailyPilotageService(){

        $sql = <<<QUERY
select * from (
select count(CASE
                 WHEN mp.PILOTAGE_TYPE_ID=1 then 1
                 END)
        as inward_vessel,
    count(CASE
                     WHEN mp.PILOTAGE_TYPE_ID=2 then 1
                     END)
            as shifting_vessel,
       count(CASE
                 WHEN mp.PILOTAGE_TYPE_ID=3 then 1
                 END)
           as outward_vessel
from
mda.PILOTAGES mp
    where trunc(mp.PILOTAGE_FROM_TIME)=trunc(sysdate)
    and mp.STATUS='C')
group by inward_vessel,shifting_vessel,outward_vessel
QUERY;
        $data = DB::selectOne($sql);

        return $data;
    }
    public function dailyPilotageServiceDetials($type){

        if ($type == 'Inward Vessel'){
            $vType = 1;
        }elseif ($type == 'Shifting Vessel'){
            $vType = 2;
        }elseif ($type == 'Outward Vessel'){
            $vType = 3;
        }else{
            $vType = null;
        }
        $sql = "select * from
mda.PILOTAGES mp
    left join mda.L_PILOTAGE_TYPES PT  ON mp.PILOTAGE_TYPE_ID = PT.ID WHERE
    trunc(mp.PILOTAGE_FROM_TIME)=trunc(sysdate)
    and mp.STATUS='C' and PILOTAGE_TYPE_ID=:p_type";
        $data = DB::select($sql,['p_type' => $vType]);

        return $data;
    }

    public function monthlyPilotageServcieLineChart(){

        $cur_mon_first_date= Carbon::parse(Carbon::now())->startOfMonth();
        $cur_mon_last_date= Carbon::parse(Carbon::now())->endOfMonth();
        $number_of_days= Carbon::parse(Carbon::now())->daysInMonth;

        $inward_sql = <<<QUERY
select nvl(dd.qty,0)qty from
(select  1 + level - 1 dt
from   dual
connect by level <=:number_of_days)cal
left join (select to_char(mp.PILOTAGE_FROM_TIME,'dd')PILOTAGE_FROM_TIME, count(mp.ID)qty
from mda.PILOTAGES mp
where mp.STATUS = 'C'
        and mp.PILOTAGE_TYPE_ID=1
        and  mp.PILOTAGE_FROM_TIME between :from_date and :to_date
group by to_char(mp.PILOTAGE_FROM_TIME,'dd')
order by to_char(mp.PILOTAGE_FROM_TIME,'dd') asc)dd
on cal.dt=dd.PILOTAGE_FROM_TIME
order by cal.dt asc
QUERY;

        $shifting_sql = <<<QUERY

select nvl(dd.qty,0)qty from
(select  1 + level - 1 dt
from   dual
connect by level <=:number_of_days)cal
left join (select to_char(mp.PILOTAGE_FROM_TIME,'dd')PILOTAGE_FROM_TIME, count(mp.ID)qty
from mda.PILOTAGES mp
where mp.STATUS = 'C'
        and mp.PILOTAGE_TYPE_ID=2
        and  mp.PILOTAGE_FROM_TIME between :from_date and :to_date
group by to_char(mp.PILOTAGE_FROM_TIME,'dd')
order by to_char(mp.PILOTAGE_FROM_TIME,'dd') asc)dd
on cal.dt=dd.PILOTAGE_FROM_TIME
order by cal.dt asc
QUERY;

        $outward_sql = <<<QUERY
select nvl(dd.qty,0)qty from
(select  1 + level - 1 dt
from   dual
connect by level <=:number_of_days)cal
left join (select to_char(mp.PILOTAGE_FROM_TIME,'dd')PILOTAGE_FROM_TIME, count(mp.ID)qty
from mda.PILOTAGES mp
where mp.STATUS = 'C'
        and mp.PILOTAGE_TYPE_ID=3
        and  mp.PILOTAGE_FROM_TIME between :from_date and :to_date
group by to_char(mp.PILOTAGE_FROM_TIME,'dd')
order by to_char(mp.PILOTAGE_FROM_TIME,'dd') asc)dd
on cal.dt=dd.PILOTAGE_FROM_TIME
order by cal.dt asc
QUERY;


        $inward_data = DB::select($inward_sql,['from_date'=>date("Y-m-d", strtotime($cur_mon_first_date)),
                                              'to_date'=>date("Y-m-d", strtotime($cur_mon_last_date)),
                                               'number_of_days'=>$number_of_days]);

        $shifting_data = DB::select($shifting_sql,['from_date'=>date("Y-m-d", strtotime($cur_mon_first_date)),
            'to_date'=>date("Y-m-d", strtotime($cur_mon_last_date)),
            'number_of_days'=>$number_of_days]);

        $outward_data = DB::select($outward_sql,['from_date'=>date("Y-m-d", strtotime($cur_mon_first_date)),
            'to_date'=>date("Y-m-d", strtotime($cur_mon_last_date)),
            'number_of_days'=>$number_of_days]);


        return compact('inward_data','shifting_data','outward_data');

    }

    public function monthlyPilotageService(){
        $cur_mon_first_date= Carbon::parse(Carbon::now())->startOfMonth();
        $cur_mon_last_date= Carbon::parse(Carbon::now())->endOfMonth();

        $sql = <<<QUERY
select * from (
                  select count(CASE
                                   WHEN mp.PILOTAGE_TYPE_ID=1 then 1
                      END)
                             as inward_vessel,
                         count(CASE
                                   WHEN mp.PILOTAGE_TYPE_ID=2 then 1
                             END)
                             as shifting_vessel,
                         count(CASE
                                   WHEN mp.PILOTAGE_TYPE_ID=3 then 1
                             END)
                             as outward_vessel
                  from
                      mda.PILOTAGES mp
                  where mp.PILOTAGE_FROM_TIME between :from_date and :to_date
                    and mp.STATUS='C')
group by inward_vessel,shifting_vessel,outward_vessel
QUERY;

        $data = DB::selectOne($sql,['from_date'=>date("Y-m-d", strtotime($cur_mon_first_date)),
                                 'to_date'=>date("Y-m-d", strtotime($cur_mon_last_date))]);

        return $data;
    }

    public function dailyMooringService(){
        $sql = "SELECT 50 as tug,
       10 as boat,
       15 AS container
  FROM dual";

        $data = DB::select($sql);

        return $data;
    }

    public function monthlyMooringService(){
        /*$sql = "SELECT 500 as tug,
       120 as boat,
       105 AS container
  FROM dual";*/
        $sql = "WITH
    GET_DATE
    AS
        (    SELECT TRUNC (SYSDATE, 'MM') + LEVEL - 1     AS COLLECTION_DATE
               FROM DUAL
         CONNECT BY TRUNC (TRUNC (SYSDATE, 'MM') + LEVEL - 1, 'MM') =
                    TRUNC (SYSDATE, 'MM'))
SELECT COLLECTION_DATE,
       (SELECT NVL (SUM (MOORING_CHARGE_AMNT), 0)     AS TOTAL_CHARGE_AMNT
          FROM MDA.MOORING_CHARGE
         WHERE STATUS = 'A' AND TRUNC (COLLECTION_DATE) = D.COLLECTION_DATE)    AS TOTAL_CHARGE_AMNT
  FROM GET_DATE D";

        $data = DB::select($sql);

        return $data;
    }

    public function dailyDuesCollection(){
        $sql = "SELECT DISTINCT
         C.OFFICE_ID,
         O.OFFICE_NAME,
         SUM (NVL (C.PORT_DUES_AMOUNT, 0)) OVER (PARTITION BY C.OFFICE_ID)
             AS TOTAL_PORT_DUES_AMOUNT,
         SUM (NVL (C.RIVER_DUES_AMOUNT, 0)) OVER (PARTITION BY C.OFFICE_ID)
             TOTAL_RIVER_DUES_AMOUNT,
         SUM (NVL (C.LICENSE_BILL_AMOUNT, 0)) OVER (PARTITION BY C.OFFICE_ID)
             TOTAL_LICENSE_BILL_AMOUNT,
         SUM (NVL (C.OTHER_DUES_AMOUNT, 0)) OVER (PARTITION BY C.OFFICE_ID)
             TOTAL_OTHER_DUES_AMOUNT,
         SUM (NVL (C.VAT_AMOUNT, 0)) OVER (PARTITION BY C.OFFICE_ID)
             TOTAL_VAT_AMOUNT
    FROM MDA.COLLECTION_SLIPS C, MDA.L_LICENSE_OFFICE O
   WHERE     C.STATUS = 'A'
         AND C.OFFICE_ID = O.OFFICE_ID
         AND TO_CHAR (C.COLLECTION_DATE, 'DD-MM-YYYY') =
             TO_CHAR (SYSDATE, 'DD-MM-YYYY')
ORDER BY 2 ASC";

        $data = DB::select($sql);

        return $data;
    }

    public function monthlyDuesCollection(){
        $sql = "SELECT DISTINCT
         C.OFFICE_ID,
         O.OFFICE_NAME,
         SUM (NVL (C.PORT_DUES_AMOUNT, 0)) OVER (PARTITION BY C.OFFICE_ID)
             AS TOTAL_PORT_DUES_AMOUNT,
         SUM (NVL (C.RIVER_DUES_AMOUNT, 0)) OVER (PARTITION BY C.OFFICE_ID)
             TOTAL_RIVER_DUES_AMOUNT,
         SUM (NVL (C.LICENSE_BILL_AMOUNT, 0)) OVER (PARTITION BY C.OFFICE_ID)
             TOTAL_LICENSE_BILL_AMOUNT,
         SUM (NVL (C.OTHER_DUES_AMOUNT, 0)) OVER (PARTITION BY C.OFFICE_ID)
             TOTAL_OTHER_DUES_AMOUNT,
         SUM (NVL (C.VAT_AMOUNT, 0)) OVER (PARTITION BY C.OFFICE_ID)
             TOTAL_VAT_AMOUNT
    FROM MDA.COLLECTION_SLIPS C, MDA.L_LICENSE_OFFICE O
   WHERE     C.STATUS = 'A'
         AND C.OFFICE_ID = O.OFFICE_ID
         AND TO_CHAR (C.COLLECTION_DATE, 'MM-YYYY') =
             TO_CHAR (SYSDATE, 'MM-YYYY')
ORDER BY 2 ASC";

        $data = DB::select($sql);

        return $data;
    }

    public function dailyFreshWater(){

    }

    public function monthlyFreshWater(){

    }
}
