<?php


namespace App\Managers\Dashboad;


use Illuminate\Support\Facades\DB;

class CaseManager
{

    public function getData()
    {
        $sql = "SELECT TO_CHAR (CASE_DATE, 'RRRR') AS YEAR,
         COUNT (CASE WHEN CM.CASE_STATUS_ID = 1 THEN 1 END) AS NEW,
         COUNT (CASE WHEN CM.CASE_STATUS_ID NOT IN (1, 3) THEN 1 END)
            AS IN_PROGRESS,
         COUNT (CASE WHEN CM.CASE_STATUS_ID = 3 THEN 1 END) AS COMPLETED,
         COUNT (*) AS TOTAL
    FROM CPACMS.CASE_MASTER_INFO CM, CPACMS.L_CASE_STATUS CS
   WHERE CM.CASE_STATUS_ID = CS.CASE_STATUS_ID
GROUP BY TO_CHAR (CASE_DATE, 'RRRR')";

        $cases = DB::select($sql);

        return $this->serialize($cases);

    }

    private function serialize($cases)
    {
        return $cases;
    }

    public function detailInfo($year, $status) {

        if ($status == 'in_progress') {
            /*$sql = "SELECT cm.*
  FROM cpacms.case_master_info cm
 WHERE     cm.case_status_id <> 3
       AND NVL (TO_CHAR (cm.case_date, 'RRRR'), 0) =
           NVL (NVL ( :year, 0), NVL (TO_CHAR (cm.case_date, 'RRRR'), 0))";*/

            $sql = "SELECT CM.CASE_NO,CCAT.CATEGORY_NAME,CMI.COURT_NAME,COUCAT.COURT_CATEGORY_NAME,CS.CASE_STATUS_NAME,EMP.EMP_NAME,DPT.DEPARTMENT_NAME,CM.CASE_DATE
  FROM CPACMS.CASE_MASTER_INFO CM
  LEFT JOIN CPACMS.CASE_CATEGORY CCAT ON (CCAT.CATEGORY_ID = CM.CATEGORY_ID)
  LEFT JOIN CPACMS.COURT_MASTER_INFO CMI ON (CMI.COURT_ID= CM.COURT_ID)
  LEFT JOIN CPACMS.COURT_CATEGORY COUCAT ON (COUCAT.COURT_CATEGORY_ID = CM.COURT_CATEGORY_ID)
  LEFT JOIN CPACMS.L_CASE_STATUS CS ON (CS.CASE_STATUS_ID = CM.CASE_STATUS_ID)
  LEFT JOIN PMIS.EMPLOYEE EMP ON (EMP.EMP_ID = CM.AUTHORISE_OFFICER)
  LEFT JOIN PMIS.L_DEPARTMENT DPT ON (DPT.DEPARTMENT_ID = CM.AUTH_DEPT_ID)
 WHERE     CM.CASE_STATUS_ID <> 3
 AND NVL (TO_CHAR (CM.CASE_DATE, 'RRRR'), 0) = NVL (NVL ( :YEAR, 0), NVL (TO_CHAR (CM.CASE_DATE, 'RRRR'), 0))";
            return DB::select($sql, ['year' => $year]);
        }

        //Completed case
        /*$sql = "SELECT cm.*
  FROM cpacms.case_master_info cm
 WHERE     cm.case_status_id = 3
       AND NVL (TO_CHAR (cm.case_date, 'RRRR'), 0) =
           NVL (NVL ( :year, 0), NVL (TO_CHAR (cm.case_date, 'RRRR'), 0))";*/

        $sql = "SELECT CM.CASE_NO,CCAT.CATEGORY_NAME,CMI.COURT_NAME,COUCAT.COURT_CATEGORY_NAME,CS.CASE_STATUS_NAME,EMP.EMP_NAME,DPT.DEPARTMENT_NAME,CM.CASE_DATE
  FROM CPACMS.CASE_MASTER_INFO CM
  LEFT JOIN CPACMS.CASE_CATEGORY CCAT ON (CCAT.CATEGORY_ID = CM.CATEGORY_ID)
  LEFT JOIN CPACMS.COURT_MASTER_INFO CMI ON (CMI.COURT_ID= CM.COURT_ID)
  LEFT JOIN CPACMS.COURT_CATEGORY COUCAT ON (COUCAT.COURT_CATEGORY_ID = CM.COURT_CATEGORY_ID)
  LEFT JOIN CPACMS.L_CASE_STATUS CS ON (CS.CASE_STATUS_ID = CM.CASE_STATUS_ID)
  LEFT JOIN PMIS.EMPLOYEE EMP ON (EMP.EMP_ID = CM.AUTHORISE_OFFICER)
  LEFT JOIN PMIS.L_DEPARTMENT DPT ON (DPT.DEPARTMENT_ID = CM.AUTH_DEPT_ID)
 WHERE     cm.case_status_id = 3
       AND NVL (TO_CHAR (cm.case_date, 'RRRR'), 0) =
           NVL (NVL ( :year, 0), NVL (TO_CHAR (cm.case_date, 'RRRR'), 0))";
        return DB::select($sql, ['year' => $year]);


    }
}
