<?php


namespace App\Managers\Dashboad;


use Illuminate\Support\Facades\DB;

class AuditManager
{
    public function getInternalAuditData()
    {
        $sql = "SELECT TO_CHAR (START_DATE, 'RRRR') AS YEAR,
         COUNT (CASE WHEN AM.AUDIT_STATUS_ID NOT IN (10, 11) THEN 1 END)
            AS IN_PROGRESS,
         COUNT (CASE WHEN AM.AUDIT_STATUS_ID = 10 THEN 1 END) AS COMPLETED,
         COUNT (*) AS TOTAL
    FROM IAMS.AUDIT_MASTER AM, IAMS.L_AUDIT_STATUS AST
   WHERE AM.AUDIT_STATUS_ID = AST.AUDIT_STATUS_ID
GROUP BY TO_CHAR (START_DATE, 'RRRR')";

        $internal_audits = DB::select($sql);

        return $internal_audits;

    }

    public function detailInfo($status, $year){
        $sql = "SELECT AM.*, ST.STATUS, CAL.FISCAL_YEAR
  FROM GAMS.ADT_MASTER AM
       JOIN GAMS.L_ADT_SOURCE_INFO ASI
          ON ASI.ADT_SOURCE_ID = AM.ADT_SOURCE_ID
       JOIN GAMS.L_ADT_STATUS ST ON ST.STATUS_ID = AM.CURRENT_STATUS_ID
       JOIN CPAACC.FAS_CALENDAR_MASTER CAL
          ON CAL.CALENDAR_ID = AM.FISCAL_YEAR_ID
          where am.current_status_id = :status
          and TO_CHAR (am.AUDIT_ORDER_DATE, 'RRRR') = :year";
        return DB::select($sql,['status' => $status, 'year' => $year]);
    }


    public function getGovAuditData()
    {
        $sql = "SELECT TO_CHAR (AUDIT_ORDER_DATE, 'RRRR') AS YEAR,
         COUNT (CASE WHEN AM.CURRENT_STATUS_ID = 1 THEN 1  END)
            AS AUDIT_ENTRY,
            COUNT (CASE WHEN AM.CURRENT_STATUS_ID = 2 THEN 1 END)
            AS SUBMITTED_FOR_INITIAL_APPROVAL,
            COUNT (CASE WHEN AM.CURRENT_STATUS_ID = 3 THEN 1 END)
            AS INITIALLY_APPROVED,
            COUNT (CASE WHEN AM.CURRENT_STATUS_ID = 4 THEN 1 END)
            AS INITIALLY_REJECTED,
         COUNT (CASE WHEN AM.CURRENT_STATUS_ID = 10 THEN 1 END) AS COMPLETED,
         COUNT (CASE WHEN AM.CURRENT_STATUS_ID = 11 THEN 1 END) AS SUBMITTED_FOR_FINDINGS_APPR,
         COUNT (CASE WHEN AM.CURRENT_STATUS_ID = 12 THEN 1 END) AS FINDINGS_APPROVED,
         COUNT (CASE WHEN AM.CURRENT_STATUS_ID = 13 THEN 1 END) AS FINDINGS_REJECTED,
         COUNT (CASE WHEN AM.CURRENT_STATUS_ID = 14 THEN 1 END) AS FINDINGS_ENTRY,
         COUNT (*) AS TOTAL
    FROM GAMS.ADT_MASTER AM, GAMS.L_ADT_STATUS AST
   WHERE AM.CURRENT_STATUS_ID = AST.STATUS_ID
GROUP BY TO_CHAR (AUDIT_ORDER_DATE, 'RRRR')";

        $gov_audits = DB::select($sql);

        return $gov_audits;

    }
}
