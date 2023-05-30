<?php


namespace App\Managers\Dashboad;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\DeclareDeclare;

class AppointmentManager
{
    public function meeting_statistic(){


$last_date=DB::selectOne('select TO_DATE(current_date - 1)as meeting_date
from dual');



        $prv_sql = <<<QUERY
select last.meeting_date,last_meeting.ACTIVITY_TYPE,last_meeting.no_of_meeting from
(select :last_date as meeting_date
from dual)last
left join (select mi.meeting_date, lat.ACTIVITY_TYPE, count(mi.MEETING_ID)no_of_meeting
           from ams.MEETING_INFO mi,ams.L_ACTIVITY_TYPE lat
           where mi.ACTIVITY_ID=lat.ACTIVITY_ID
           and mi.MEETING_DATE=:last_date
           group by mi.meeting_date,ACTIVITY_TYPE)last_meeting on (last.meeting_date=last_meeting.MEETING_DATE)
QUERY;

        $prv_appointment_sql = <<<QUERY
select last.appointment_date, last_appointment.no_of_appointment
from (select :last_date as appointment_date
      from dual) last
         left join (select trunc(ai.APOINTMNET_START_TIME) appointment_date, count(ai.APPOINTMENT_ID) no_of_appointment
                    from ams.APPOINTMENT_INFO ai
                    where trunc(ai.APOINTMNET_START_TIME) = :last_date
                    group by trunc(ai.APOINTMNET_START_TIME)) last_appointment
                   on (last.appointment_date = last_appointment.appointment_date)
QUERY;


        $prv_meeting_data = DB::select($prv_sql,['last_date'=>date("Y-m-d", strtotime($last_date->meeting_date))]);
        $prv_appointment_data = DB::select($prv_appointment_sql,['last_date'=>date("Y-m-d", strtotime($last_date->meeting_date))]);


        $cur_date=DB::selectOne('select TO_DATE(current_date)as meeting_date
from dual');

        $cur_sql=<<<QUERY
select cur.meeting_date,cur_meeting.ACTIVITY_TYPE,cur_meeting.no_of_meeting from
    (select :cur_date as meeting_date
     from dual)cur
        left join (select mi.MEETING_DATE, lat.ACTIVITY_TYPE, count(mi.MEETING_ID)no_of_meeting
                   from ams.MEETING_INFO mi,ams.L_ACTIVITY_TYPE lat
                  where mi.MEETING_DATE=:cur_date
                     and mi.ACTIVITY_ID=lat.ACTIVITY_ID
                   group by MEETING_DATE,ACTIVITY_TYPE)cur_meeting on (cur.meeting_date=cur_meeting.MEETING_DATE)
QUERY;

        $cur_appointment_sql=<<<QUERY
select last.appointment_date, last_appointment.no_of_appointment
from (select :cur_date as appointment_date
      from dual) last
         left join (select trunc(ai.APOINTMNET_START_TIME) appointment_date, count(ai.APPOINTMENT_ID) no_of_appointment
                    from ams.APPOINTMENT_INFO ai
                    where trunc(ai.APOINTMNET_START_TIME) = :cur_date
                    group by trunc(ai.APOINTMNET_START_TIME)) last_appointment
                   on (last.appointment_date = last_appointment.appointment_date)
QUERY;

        $cur_meeting_data = DB::select($cur_sql,['cur_date'=>date("Y-m-d", strtotime($cur_date->meeting_date))]);
        $cur_appointment_data = DB::select($cur_appointment_sql,['cur_date'=>date("Y-m-d", strtotime($cur_date->meeting_date))]);

        $nxt_date=DB::selectOne('select TO_DATE(current_date +1)as meeting_date
from dual');
        $nxt_sql=<<<QUERY
select  nxt.meeting_date,nxt_meeting.ACTIVITY_TYPE,nxt_meeting.no_of_meeting from
    (select :nxt_date as meeting_date
     from dual)nxt
        left join (select mi.MEETING_DATE, lat.ACTIVITY_TYPE, count(mi.MEETING_ID)no_of_meeting
                   from ams.MEETING_INFO mi,ams.L_ACTIVITY_TYPE lat
                   where mi.MEETING_DATE=:nxt_date
                     and mi.ACTIVITY_ID=lat.ACTIVITY_ID
                   group by MEETING_DATE,ACTIVITY_TYPE)nxt_meeting on (nxt.meeting_date=nxt_meeting.MEETING_DATE)
QUERY;

        $nxt_appointment_sql=<<<QUERY
select last.appointment_date, last_appointment.no_of_appointment
from (select :nxt_date as appointment_date
      from dual) last
         left join (select trunc(ai.APOINTMNET_START_TIME) appointment_date, count(ai.APPOINTMENT_ID) no_of_appointment
                    from ams.APPOINTMENT_INFO ai
                    where trunc(ai.APOINTMNET_START_TIME) = :nxt_date
                    group by trunc(ai.APOINTMNET_START_TIME)) last_appointment
                   on (last.appointment_date = last_appointment.appointment_date)
QUERY;

        $nxt_meeting_data = DB::select($nxt_sql,['nxt_date'=>date("Y-m-d", strtotime($nxt_date->meeting_date))]);
        $nxt_appointment_data = DB::select($nxt_appointment_sql,['nxt_date'=>date("Y-m-d", strtotime($nxt_date->meeting_date))]);



        return ['prv_meeting_data' => $prv_meeting_data,
                'cur_meeting_data' => $cur_meeting_data,
                'nxt_meeting_data' => $nxt_meeting_data,
                'prv_appointment_data' => $prv_appointment_data,
                'cur_appointment_data' => $cur_appointment_data,
                'nxt_appointment_data' => $nxt_appointment_data,
            ];
    }
}
