<?php


namespace App\Managers\Dashboad;


use Illuminate\Support\Facades\DB;

class RecruitmentManager
{

    public function getData()
    {
        $sql ="SELECT CD.CIRCULAR_DTL_ID,
         D.DESIGNATION || '-' || DEPARTMENT_NAME AS POSITION,
         CD.TOTAL_POST,
         COUNT (a.APPLICATION_ID) APPLIED,
         et.EXAM_TYPE AS STATUS,
         CMST.APP_END_DATE as deadline
    FROM ors.circular_mst cmst,
    ors.CIRCULAR_DTL cd,
         PMIS.L_DESIGNATION d,
         ors.OR_APPLICATION a,
         (  SELECT rm.CIRCULAR_DTL_ID, MAX (rm.EXAM_TYPE_ID) AS EXAM_TYPE_ID
              FROM ors.EXAM_RESULT_MST rm
          GROUP BY rm.CIRCULAR_DTL_ID) s,
         ors.L_EXAM_TYPE et
   WHERE cmst.circular_id = cd.circular_id    
         and CD.DESIGNATION_ID = D.DESIGNATION_ID
         AND CD.CIRCULAR_DTL_ID = A.CIRCULAR_DTL_ID(+)
         AND CD.CIRCULAR_DTL_ID = s.CIRCULAR_DTL_ID(+)
         AND s.EXAM_TYPE_ID = et.EXAM_TYPE_ID(+)
GROUP BY CD.CIRCULAR_DTL_ID,
         D.DESIGNATION || '-' || DEPARTMENT_NAME,
         CD.TOTAL_POST,
         et.EXAM_TYPE,
         CMST.APP_END_DATE";

        $recruitment = DB::select($sql);
//dd($sql);
        return $recruitment;

    }


}
