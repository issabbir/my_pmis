<?php


namespace App\Managers\Dashboad;
use App\Entities\Ams\MeetingInfo;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\DeclareDeclare;

class BoardDecisionManager
{
    public function board_meeting_statistic(){

//        $sql = <<<QUERY
//select * from (select mi.meeting_id,mi.meeting_name,to_char(mi.meeting_date,'dd/mm/yyyy')meeting_date,
//to_char(mi.MEETING_ACTUAL_START_TIME,'hh:mi:ss')MEETING_ACTUAL_START_TIME,
//(select count(mp.PARTICIPANT_ID) from ams.MEETING_PARTICIPANT mp
//    where mp.MEETING_ID=mi.MEETING_ID and mp.IS_GUEST_PARTICIPANT='Y')no_of_participant
//from ams.meeting_info mi
//where mi.activity_id='20040622002005285'
//and mi.status='A'
//order by mi.meeting_date desc)
//where ROWNUM<=5
//QUERY;
//        $sql = <<<QUERY
//select extract(year from mi.MEETING_DATE) as meeting_yr,
//       count(mi.MEETING_ID)no_of_meeting
//from ams.meeting_info mi
//where mi.activity_id='20040622002005285'
//and mi.status='A'
//group by extract(year from mi.MEETING_DATE)
//order by meeting_yr desc
//QUERY;
        $sql = <<<QUERY
select m.meeting_yr, m.no_of_meeting, d.no_of_decision
from
 ( select extract(year from MEETING_DATE) meeting_yr, count(MEETING_ID) no_of_meeting from AMS.meeting_info
 where activity_id='20040622002005285'   and status='A'  group by extract(year from MEETING_DATE) order by meeting_yr DESC) m

  LEFT JOIN

 ( select count(DISCUSSION_DECISION_ID) no_of_decision, extract(year from MEETING_DATE) meeting_yr
  from ams.MEETING_DISCUSSION_DECISION mdd LEFT JOIN AMS.meeting_info mi ON mdd.MEETING_ID = mi.MEETING_ID
   where  mdd.status='A' and mi.activity_id='20040622002005285' group by extract(year from MEETING_DATE)
   order by meeting_yr DESC) d

 on m.meeting_yr = d.meeting_yr
QUERY;

        $data = DB::select($sql);
        return $data;
    }
}
