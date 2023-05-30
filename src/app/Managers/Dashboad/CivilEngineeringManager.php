<?php


namespace App\Managers\Dashboad;


use Illuminate\Support\Facades\DB;

class CivilEngineeringManager
{

    public function getData()
    {
        $sql = "SELECT DISTINCT
         D.DEPARTMENT_NAME,
         COUNT (CASE WHEN C.CONTRACT_STATUS_ID = '1' THEN 0 END) INITIALS,
         COUNT (CASE WHEN C.CONTRACT_STATUS_ID = '2' THEN 0 END) IN_PROGRESS,
         COUNT (CASE WHEN C.CONTRACT_STATUS_ID = '3' THEN 0 END) OUT_OF_SCHEDULE,
         COUNT (CASE WHEN C.CONTRACT_STATUS_ID = '4' THEN 0 END) COMPLETED,
         COUNT (CASE WHEN C.CONTRACT_STATUS_ID = '5' THEN 0 END) TIME_EXTENDED,
         COUNT (CASE WHEN c.DEV_PARTNER_YN = 'Y' THEN 0 END) DEV_PARTNER_EXIST,
         COUNT (CASE WHEN c.DEV_PARTNER_YN = 'N' THEN 0 END)
            DEV_PARTNER_NOT_EXIST
    FROM Cms.CONTRACT_WORK c, cms.V_DEPARTMENT D
   WHERE     C.CPA_DEPARTMENT_ID = D.DEPARTMENT_ID
         AND TO_CHAR (C.INSERT_DATE, 'YYYY') = TO_CHAR (SYSDATE, 'YYYY')
GROUP BY D.DEPARTMENT_NAME
ORDER BY 1 DESC,
         2 DESC,
         3 DESC,
         4 DESC,
         5 DESc";

        $civilEngineering = DB::select($sql);

        return $civilEngineering;

    }
}
