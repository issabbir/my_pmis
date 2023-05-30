<?php


namespace App\Services\Report;


use Illuminate\Support\Facades\DB;

class OverTime
{

    private $weekdays = [
        'friday'=>[],
        'saturday'=>[],
        'sunday' =>[],
        'monday'=>[],
        'tuesday'=>[],
        'wednesday'=>[],
        'thursday'=>[]
    ];

    public function __construct()
    {

    }

    public function getMonthlyOverTime($month, $emp_code = '', $department = ''){
        $sql = "SELECT
          ev.emp_name,
          ev.emp_bank_acc_no,   
          ev.emp_code,
          ev.designation,
          ev.basic_amt,
          TO_CHAR (qu.work_day, 'fmDay') AS work_day,
             TO_CHAR (qu.work_day, 'DD')
             || ' - '
             || CASE
                WHEN TO_CHAR (qu.work_day, 'fmDY') =
    (SELECT off_day
                           FROM ot_roster_details rd, ot_months_detail md
                          WHERE     rd.ot_month_detail_id =
    md.ot_month_detail_id
AND rd.roster_id = emp_id)
                THEN
                   8
                ELSE
                   NVL ( (SELECT 8
                            FROM l_holiday
                           WHERE qu.work_day BETWEEN date_from AND date_to),
                        wh)
             END
             AS work_hour,
          CASE
                WHEN TO_CHAR (qu.work_day, 'fmDY') =
    (SELECT off_day
                           FROM ot_roster_details rd, ot_months_detail md
                          WHERE     rd.ot_month_detail_id =
    md.ot_month_detail_id
AND rd.roster_id = emp_id)
                THEN
                   8
                ELSE
                   NVL ( (SELECT 8
                            FROM l_holiday
                           WHERE qu.work_day BETWEEN date_from AND date_to),
                        wh)
             END
             AS fix_work_hour,
           TO_CHAR (qu.work_day, 'MM') AS month,
          CASE
             WHEN TO_CHAR (qu.work_day, 'fmDY') =
    (SELECT off_day
                        FROM ot_roster_details rd, ot_months_detail md
                       WHERE     rd.ot_month_detail_id =
    md.ot_month_detail_id
AND rd.roster_id = emp_id)
             THEN
                'Y'
             ELSE
                NVL ( (SELECT 'Y'
                         FROM l_holiday
                        WHERE qu.work_day BETWEEN date_from AND date_to),
                     'N')
          END
             off_day,
             TO_CHAR (LAST_DAY(qu.work_day), 'DD') as month_day,
             TRUNC((ev.basic_amt/TO_CHAR (LAST_DAY(qu.work_day), 'DD')/8),2) as hour_rate
     FROM (    SELECT DISTINCT LEVEL,
                               emp_id,
                               NVL (actual_hour, approve_hour) AS wh,
                               date_from - 1 + LEVEL AS work_day
                 FROM ot_register
           CONNECT BY LEVEL <= TRUNC ( (date_to - date_from)) + 1) qu,
          employee_info_vu ev
    WHERE qu.emp_id = ev.emp_id and TO_CHAR (qu.work_day, 'MM') = :month and (ev.emp_code =:emp_code or :emp_code is null) order by ev.emp_name;

";

     $_result = DB::select($sql,['month'=>$month, 'emp_code' => $emp_code]);
     return $this->serialize($_result);
  }

  private function serialize($_result) {
      $data = [];

      foreach ($_result as $res) {
          $dt = array();
          $dt[$res->emp_code] = [];
      }
  }

}

