<?php


namespace App\Managers\Dashboad;


use Illuminate\Support\Facades\DB;

class IncidentManager
{
    public function getData()
    {
        $sql = "SELECT INCIDENCE_ID,
       INCIDENCE_NUMBER,
       INCIDENCE_DATE,
       INCIDENCE_TIME,
       INCIDENCE_PLACE_ID,
       INCIDENCE_TYPE_ID,
       INCIDENCE_SUBTYPE_ID,
       REPORTER_CPA_YN,
       REPORTER_EMP_ID,
       REPORTER_NAME,
       INCIDENCE_DESCRIPTION,
       INCIDENCE_DESCRIPTION_BN,
       NVL(INCIDENCE_PLACE,' ') INCIDENCE_PLACE,
       ATTACHMENT_DOC,
       ATTACHMENT_TYPE,
       ATTACHMENT_NAME,
       INCIDENCE_STATUS_ID,
       ASSIGN_EMP_ID,
       ASSIGN_DATE,
       ASSIGN_NOTE,
       ASSIGN_DUE_DATE,
       INSERT_BY,
       INSERT_DATE,
       UPDATE_BY,
       UPDATE_DATE,
       ASSIGN_BY,
       REPORTER_MOBILE,
       OTHER_INCIDENCE,
       ORGANIZATION_NAME,
       ORG_MOBILE_NUMBER,
       NORMAL_INC_YN,
       REMARKS,
       INCIDENCE_STATUS,
       INCIDENCE_TYPE,
       INCIDENCE_SUBTYPE_NAME, rownum sl
  FROM (  SELECT ii.*,
                 iis.INCIDENCE_STATUS,
                 iit.INCIDENCE_TYPE,
                 iist.INCIDENCE_SUBTYPE_NAME
            FROM SECDBMS.IMS_INCIDENCE        ii,
                 SECDBMS.IMS_INCIDENCE_STATUS iis,
                 SECDBMS.IMS_INCIDENCE_TYPE   iit,
                 SECDBMS.IMS_INCIDENCE_SUBTYPE iist
           WHERE     ii.INCIDENCE_STATUS_ID = iis.INCIDENCE_STATUS_ID
                 AND II.INCIDENCE_TYPE_ID = IIT.INCIDENCE_TYPE_ID
                 AND II.INCIDENCE_SUBTYPE_ID = IIST.INCIDENCE_SUBTYPE_ID(+)
                 AND TRUNC (INCIDENCE_DATE) IN (SELECT TRUNC (INCIDENCE_DATE)
                                                  FROM SECDBMS.IMS_INCIDENCE
                                                 WHERE -- TRUNC (INCIDENCE_DATE) >= SYSDATE - 180)
                                                       INCIDENCE_STATUS_ID = 2)
                 AND ii.INCIDENCE_STATUS_ID NOT IN(6)
          )
   WHERE ROWNUM <= 15 ORDER BY INCIDENCE_DATE DESC";
       return DB::select($sql);
    }

    public function getFreshWaterDailyData() {
        $sql = "SELECT DISTINCT
       (SELECT WATER_VESSEL_NAME
          FROM EWB.L_WATER_VESSEL
         WHERE water_vessel_id = ra.water_vessel_id)    water_vessel,
       ra.TOTAL_QTY,
       rq.VESSEL_NAME
  FROM EWB.W_RECEIVE_ACK  ra,
       EWB.W_BOOKING_MST  bm,
       EWB.W_BOOKING_DTL  bd,
       EWB.W_REQUISITION  rq
 WHERE     ra.BOOKING_MST_ID = bm.BOOKING_MST_ID
       AND ra.BOOKING_MST_ID = bd.BOOKING_MST_ID
       AND bm.REQ_ID = rq.REQ_ID
       AND ra.WATER_VESSEL_ID IS NOT NULL
       AND TRUNC (ra.ACK_DATE) = TRUNC (SYSDATE)";

        return DB::select($sql);
    }

    public function getFreshWaterMonthlyData() {
        $sql = "SELECT DISTINCT
       (SELECT WATER_VESSEL_NAME
          FROM EWB.L_WATER_VESSEL
         WHERE water_vessel_id = ra.water_vessel_id)    water_vessel,
       ra.TOTAL_QTY,
       rq.VESSEL_NAME
  FROM EWB.W_RECEIVE_ACK  ra,
       EWB.W_BOOKING_MST  bm,
       EWB.W_BOOKING_DTL  bd,
       EWB.W_REQUISITION  rq
 WHERE     ra.BOOKING_MST_ID = bm.BOOKING_MST_ID
       AND ra.BOOKING_MST_ID = bd.BOOKING_MST_ID
       AND bm.REQ_ID = rq.REQ_ID
       AND ra.WATER_VESSEL_ID IS NOT NULL
       AND TO_CHAR (ra.ACK_DATE, 'MM') = EXTRACT (MONTH FROM SYSDATE)";

        return DB::select($sql);
    }
}
