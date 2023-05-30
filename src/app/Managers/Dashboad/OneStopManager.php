<?php


namespace App\Managers\Dashboad;


use Illuminate\Support\Facades\DB;

class OneStopManager
{
    public function getData()
    {
        //Todo: Need to get data from one stop

        return [
            'todayLcl'=>$this->lclContainer(),
            'todayFcl'=>$this->fclContainer(),
            'deliveryLcl'=>$this->lclDelivery(),
            'deliveryFcl'=>$this->fclDelivery(),
            'containerLclHandled'=> $this->getContainerLclHandled(),
            'containerFclHandled'=> $this->getContainerFclHandled()
        ];
    }

    protected function lclContainer(){
         $sql = "WITH
    cont
    AS
        (SELECT COUNT (c.CONTAINER_NO)     AS No_Of_Container
           FROM COSS.OS_ASSIGNMENT_CONTAINER c
          WHERE c.ASSIGNMENT_ID IN
                    (SELECT ASSIGNMENT_ID
                       FROM COSS.OS_ASSIGNMENT_MASTER
                      WHERE     TRUNC (bill_date) = TRUNC (SYSDATE)
                            AND FINAL_BILL_YN = 'Y')),
    bill
    AS
        (  SELECT am.fcl_lcl,
                  COUNT (am.bill_no)     NO_OF_BILL,
                  SUM (am.TOTAL_AMT)     AS BILL_AMOUNT
             FROM COSS.OS_ASSIGNMENT_MASTER am
            WHERE     TRUNC (am.bill_date) = TRUNC (SYSDATE)
                  AND am.FINAL_BILL_YN = 'Y'
         GROUP BY am.fcl_lcl),
    PAID
    AS
        (SELECT COUNT (BILL_NO) AS BILL_NO, SUM (tm.TOTAL_AMT) AS PAID_AMOUNT
           FROM COSS.OS_TRAN_MASTER tm
          WHERE TRUNC (tm.TRAN_DATE) = TRUNC (SYSDATE))
SELECT bill.fcl_lcl,
       cont.No_Of_Container,
       bill.NO_Of_Bill,
       bill.BILL_AMOUNT,
       PAID.BILL_NO     AS NO_OF_PAID_BILL,
       paid.PAID_AMOUNT
  FROM cont, bill, paid";


        return DB::selectOne($sql);
    }
    protected function fclContainer(){
         $sql = "SELECT AM.FCL_LCL,
       NVL((SELECT COUNT (ASSIGNMENT_ID)
          FROM COSS.OS_ASSIGNMENT_CONTAINER asm
         WHERE AM.ASSIGNMENT_ID = asm.ASSIGNMENT_ID),0)
           NO_OF_CONTAINER,
       NVL((SELECT COUNT (TRAN_ID)
          FROM COSS.OS_TRAN_MASTER tm
         WHERE TRUNC(tm.TRAN_DATE) = TRUNC(SYSDATE)),0)
           NO_OF_BILL,
       NVL((SELECT SUM (AM.TOTAL_AMT)
          FROM COSS.OS_ASSIGNMENT_MASTER asm
         WHERE     AM.ASSIGNMENT_ID = asm.ASSIGNMENT_ID
               AND TRUNC(AM.BILL_DATE) = TRUNC(SYSDATE)),0)
           BILL_AMOUNT,
       NVL((SELECT SUM (TM.TOTAL_AMT)
          FROM COSS.OS_TRAN_MASTER tm
         WHERE TRUNC(tm.TRAN_DATE) = TRUNC(SYSDATE)),0)
           PAID_AMOUNT
  FROM COSS.OS_ASSIGNMENT_MASTER AM
 WHERE     TRUNC(AM.BILL_DATE) = TRUNC(SYSDATE)      -- TO_DATE ('28/12/2021', 'DD/MM/YYYY'))
       AND UPPER (AM.FCL_LCL) = 'FCL'";

       return DB::selectOne($sql);
    }

    protected function lclDelivery(){
         $sql = "SELECT AM.FCL_LCL,
       NVL((SELECT COUNT (CT.CART_TICKET_ID)
          FROM COSS.DO_CART_TICKETS DCT
         WHERE     DCT.CART_TICKET_ID = CT.CART_TICKET_ID
               AND TRUNC(DCT.ISSUE_DATE) = TRUNC(SYSDATE)),0) --TO_DATE ('28/12/2021', 'DD/MM/YYYY'))
           CART_TICKET_ISSUED,
       NVL((SELECT COUNT (CART_TICKET_ID)
          FROM COSS.DO_CART_TICKETS DCT
         WHERE     DCT.CART_TICKET_ID = CT.CART_TICKET_ID
               AND DCT.GATE_PASS_YN = 'Y'
               AND TRUNC(DCT.GATE_PASS_DATE) = TRUNC(SYSDATE)),0)
           GATE_PASS_ISSUED,
       NVL((SELECT COUNT (GATE_CONFIRMATION_ID)
          FROM COSS.GATE_CONFIRMATION GC
         WHERE     GC.CART_TICKET_ID = CT.CART_TICKET_ID
               AND TRUNC(GC.DELIVERY_DATE) = TRUNC(TRUNC(SYSDATE))),0)
           GATE_PASS_USED
  FROM COSS.DO_CART_TICKETS CT, COSS.OS_ASSIGNMENT_MASTER AM
 WHERE AM.BILL_NO = CT.BILL_NO AND AM.FCL_LCL = 'LCL'";

       return DB::selectOne($sql);
    }
    protected function fclDelivery(){
         $sql = "SELECT AM.FCL_LCL,
       NVL((SELECT COUNT (CT.CART_TICKET_ID)
          FROM COSS.DO_CART_TICKETS DCT
         WHERE     DCT.CART_TICKET_ID = CT.CART_TICKET_ID
               AND TRUNC(DCT.ISSUE_DATE) = TRUNC(SYSDATE) ),0) --TO_DATE ('28/12/2021', 'DD/MM/YYYY'))
           CART_TICKET_ISSUED,
       NVL((SELECT COUNT (CART_TICKET_ID)
          FROM COSS.DO_CART_TICKETS DCT
         WHERE     DCT.CART_TICKET_ID = CT.CART_TICKET_ID
               AND DCT.GATE_PASS_YN = 'Y'
               AND  TRUNC(DCT.GATE_PASS_DATE) = TRUNC(SYSDATE)),0)
           GATE_PASS_ISSUED,
       NVL((SELECT COUNT (GATE_CONFIRMATION_ID)
          FROM COSS.GATE_CONFIRMATION GC
         WHERE     GC.CART_TICKET_ID = CT.CART_TICKET_ID
               AND TRUNC(GC.DELIVERY_DATE) = TRUNC(SYSDATE)),0)
           GATE_PASS_USED
  FROM COSS.DO_CART_TICKETS CT, COSS.OS_ASSIGNMENT_MASTER AM
 WHERE AM.BILL_NO = CT.BILL_NO AND AM.FCL_LCL = 'FCL'";

       return DB::selectOne($sql);
    }

    public function getContainerLclHandled(){
        $sql = "SELECT TO_CHAR (day_7)     AS day_7,
       TO_CHAR (day_6)     AS day_6,
       TO_CHAR (day_5)     AS day_5,
       TO_CHAR (day_4)     AS day_4,
       TO_CHAR (day_3)     AS day_3,
       TO_CHAR (day_2)     AS day_2,
       TO_CHAR (day_1)     AS day_1
  FROM (SELECT *
          FROM (SELECT pd, heading
                  FROM (SELECT DISTINCT
                               cu.container_no     AS container_no,
                               cu.unstaffing_date
                          FROM COSS.container_unstaffing     cu,
                               COSS.OS_ASSIGNMENT_MASTER     am,
                               COSS.OS_ASSIGNMENT_CONTAINER  ac
                         WHERE     cu.CONTAINER_NO = ac.CONTAINER_NO
                               AND am.ASSIGNMENT_ID = ac.ASSIGNMENT_ID
                               AND am.FCL_LCL = 'LCL') concnt,
                       (    SELECT trunc(sysdate) --TO_DATE ('07-Jan-2022', 'DD-Mon-RRRR')
                                           - ROWNUM     AS pd,
                                   'Day ' || ROWNUM     AS heading
                              FROM DUAL
                        CONNECT BY LEVEL <= 7) qd
                 WHERE concnt.unstaffing_date(+) = qd.pd)
               PIVOT (MIN (pd)
                     FOR heading
                     IN ('Day 7' AS day_7,
                        'Day 6' AS day_6,
                        'Day 5' AS day_5,
                        'Day 4' AS day_4,
                        'Day 3' AS day_3,
                        'Day 2' AS day_2,
                        'Day 1' AS day_1)))
UNION ALL
SELECT TO_CHAR (day_7)     AS day_7,
       TO_CHAR (day_6)     AS day_6,
       TO_CHAR (day_5)     AS day_5,
       TO_CHAR (day_4)     AS day_4,
       TO_CHAR (day_3)     AS day_3,
       TO_CHAR (day_2)     AS day_2,
       TO_CHAR (day_1)     AS day_1
  FROM (SELECT *
          FROM (SELECT container_no, heading
                  FROM (SELECT DISTINCT
                               cu.container_no     AS container_no,
                               cu.unstaffing_date
                          FROM COSS.container_unstaffing     cu,
                               COSS.OS_ASSIGNMENT_MASTER     am,
                               COSS.OS_ASSIGNMENT_CONTAINER  ac
                         WHERE     cu.CONTAINER_NO = ac.CONTAINER_NO
                               AND am.ASSIGNMENT_ID = ac.ASSIGNMENT_ID
                               AND am.FCL_LCL = 'LCL') concnt,
                       (    SELECT trunc(sysdate) --TO_DATE ('07-Jan-2022', 'DD-Mon-RRRR')
                                           - ROWNUM     AS pd,
                                   'Day ' || ROWNUM     AS heading
                              FROM DUAL
                        CONNECT BY LEVEL <= 7) qd
                 WHERE concnt.unstaffing_date(+) = qd.pd)
               PIVOT (COUNT (container_no)
                     FOR heading
                     IN ('Day 7' AS day_7,
                        'Day 6' AS day_6,
                        'Day 5' AS day_5,
                        'Day 4' AS day_4,
                        'Day 3' AS day_3,
                        'Day 2' AS day_2,
                        'Day 1' AS day_1)))";
        $lclData = DB::select($sql);

       // dd($lclData);
        $day_1 = date('d-M-y',strtotime($lclData[0]->day_1));
        $day_2 = date('d-M-y',strtotime($lclData[0]->day_2));
        $day_3 = date('d-M-y',strtotime($lclData[0]->day_3));
        $day_4 = date('d-M-y',strtotime($lclData[0]->day_4));
        $day_5 = date('d-M-y',strtotime($lclData[0]->day_5));
        $day_6 = date('d-M-y',strtotime($lclData[0]->day_6));
        $day_7 = date('d-M-y',strtotime($lclData[0]->day_7));
        $labels = [$day_1,$day_2,$day_3,$day_4,$day_5,$day_6,$day_7];
        $value = [$lclData[1]->day_1,$lclData[1]->day_2,$lclData[1]->day_3,$lclData[1]->day_4,$lclData[1]->day_5,$lclData[1]->day_6,$lclData[1]->day_7];

        return ['labels' => $labels, 'value'=>$value ];
 }
    public function getContainerFclHandled(){
        $sql = "SELECT TO_CHAR (day_7)     AS day_7,
       TO_CHAR (day_6)     AS day_6,
       TO_CHAR (day_5)     AS day_5,
       TO_CHAR (day_4)     AS day_4,
       TO_CHAR (day_3)     AS day_3,
       TO_CHAR (day_2)     AS day_2,
       TO_CHAR (day_1)     AS day_1
  FROM (SELECT *
          FROM (SELECT pd, heading
                  FROM (SELECT DISTINCT
                               cu.container_no     AS container_no,
                               cu.unstaffing_date
                          FROM COSS.container_unstaffing     cu,
                               COSS.OS_ASSIGNMENT_MASTER     am,
                               COSS.OS_ASSIGNMENT_CONTAINER  ac
                         WHERE     cu.CONTAINER_NO = ac.CONTAINER_NO
                               AND am.ASSIGNMENT_ID = ac.ASSIGNMENT_ID
                               AND am.FCL_LCL = 'FCL') concnt,
                       (    SELECT trunc(sysdate) --TO_DATE ('30-Dec-2021', 'DD-Mon-RRRR')
                                           - ROWNUM     AS pd,
                                   'Day ' || ROWNUM     AS heading
                              FROM DUAL
                        CONNECT BY LEVEL <= 7) qd
                 WHERE concnt.unstaffing_date(+) = qd.pd)
               PIVOT (MIN (pd)
                     FOR heading
                     IN ('Day 7' AS day_7,
                        'Day 6' AS day_6,
                        'Day 5' AS day_5,
                        'Day 4' AS day_4,
                        'Day 3' AS day_3,
                        'Day 2' AS day_2,
                        'Day 1' AS day_1)))
UNION ALL
SELECT TO_CHAR (day_7)     AS day_7,
       TO_CHAR (day_6)     AS day_6,
       TO_CHAR (day_5)     AS day_5,
       TO_CHAR (day_4)     AS day_4,
       TO_CHAR (day_3)     AS day_3,
       TO_CHAR (day_2)     AS day_2,
       TO_CHAR (day_1)     AS day_1
  FROM (SELECT *
          FROM (SELECT container_no, heading
                  FROM (SELECT DISTINCT
                               cu.container_no     AS container_no,
                               cu.unstaffing_date
                          FROM COSS.container_unstaffing     cu,
                               COSS.OS_ASSIGNMENT_MASTER     am,
                               COSS.OS_ASSIGNMENT_CONTAINER  ac
                         WHERE     cu.CONTAINER_NO = ac.CONTAINER_NO
                               AND am.ASSIGNMENT_ID = ac.ASSIGNMENT_ID
                               AND am.FCL_LCL = 'FCL') concnt,
                       (    SELECT  trunc(sysdate) --TO_DATE ('30-Dec-2021', 'DD-Mon-RRRR')
                                           - ROWNUM     AS pd,
                                   'Day ' || ROWNUM     AS heading
                              FROM DUAL
                        CONNECT BY LEVEL <= 7) qd
                 WHERE concnt.unstaffing_date(+) = qd.pd)
               PIVOT (COUNT (container_no)
                     FOR heading
                     IN ('Day 7' AS day_7,
                        'Day 6' AS day_6,
                        'Day 5' AS day_5,
                        'Day 4' AS day_4,
                        'Day 3' AS day_3,
                        'Day 2' AS day_2,
                        'Day 1' AS day_1)))";
        $fclData = DB::select($sql);

        $day_1 = date('d-M-y',strtotime($fclData[0]->day_1));
        $day_2 = date('d-M-y',strtotime($fclData[0]->day_2));
        $day_3 = date('d-M-y',strtotime($fclData[0]->day_3));
        $day_4 = date('d-M-y',strtotime($fclData[0]->day_4));
        $day_5 = date('d-M-y',strtotime($fclData[0]->day_5));
        $day_6 = date('d-M-y',strtotime($fclData[0]->day_6));
        $day_7 = date('d-M-y',strtotime($fclData[0]->day_7));
        $labels = [$day_1,$day_2,$day_3,$day_4,$day_5,$day_6,$day_7];
        $value = [$fclData[1]->day_1,$fclData[1]->day_2,$fclData[1]->day_3,$fclData[1]->day_4,$fclData[1]->day_5,$fclData[1]->day_6,$fclData[1]->day_7];

        return ['labels' => $labels, 'value'=>$value ];
    }

    public function getContainerDetails($type){
//        $sql = "SELECT am.vessel_reg_no,
//       am.verification_id,
//       ac.assignment_id,
//       ac.container_no,
//       ac.number_of_packages,
//       ac.container_status,
//       ac.container_size,
//       ac.gross_weight,
//       ac.container_type,
//       ac.container_height,
//       ac.container_length,
//       ac.container_width,
//       ac.rotation_no,
//       cu.cnf_agent_code,
//       cu.cnf_agent_name
//  FROM coss.os_assignment_master am,
//       coss.os_assignment_container ac,
//       coss.container_unstaffing cu
// WHERE     am.assignment_id = ac.assignment_id
//       AND ac.container_no = cu.container_no(+)
//       AND  trunc(am.bill_date) = trunc (sysdate) --TO_DATE ('04/01/2022', 'DD/MM/YYYY') ---'04-Jan-22'
//       AND UPPER (am.fcl_lcl) = :p_fcl_lcl                      --'LCL'--'FCL'";

        $sql = "WITH
    cont
    AS
        (SELECT c.CONTAINER_NO,
        		c.CONTAINER_SIZE,
        		c.CONTAINER_HEIGHT,
        		c.NUMBER_OF_PACKAGES,
        		cu.VESSEL_NAME,
        		cu.VESSEL_REG_NO_ID,
                cu.CNF_AGENT_CODE,
                cu.CNF_AGENT_NAME,
                ROWNUM     AS SL
           FROM COSS.OS_ASSIGNMENT_CONTAINER c, COSS.CONTAINER_UNSTAFFING cu
          WHERE     c.ASSIGNMENT_ID IN
                        (SELECT ASSIGNMENT_ID
                           FROM COSS.OS_ASSIGNMENT_MASTER
                          WHERE     TRUNC (bill_date) = TRUNC (SYSDATE))
                AND cu.CONTAINER_NO = c.CONTAINER_NO),
    bill
    AS
        (SELECT am.fcl_lcl,
                am.bill_no,
                am.TOTAL_AMT,
                am.FINAL_BILL_YN,
                ROWNUM     AS SL
           FROM COSS.OS_ASSIGNMENT_MASTER am
          WHERE     TRUNC (am.bill_date) = TRUNC (SYSDATE)),
    PAID
    AS
        (SELECT BILL_NO, tm.TOTAL_AMT, ROWNUM AS SL
           FROM COSS.OS_TRAN_MASTER tm
          WHERE TRUNC (tm.TRAN_DATE) = TRUNC (SYSDATE))
SELECT bill.fcl_lcl,
       cont.CONTAINER_NO,
       bill.bill_no,
       bill.TOTAL_AMT     AS BILL_AMOUNT,
       (CASE WHEN bill.FINAL_BILL_YN = 'Y' THEN 'PAID' ELSE 'UNPAID' END) AS FINAL_BILL,
       PAID.BILL_NO       AS PAID_BILL_NO,
       paid.TOTAL_AMT     AS PAID_AMOUNT,
       cont.CONTAINER_SIZE,
       cont.CONTAINER_HEIGHT,
       cont.NUMBER_OF_PACKAGES,
       cont.VESSEL_NAME,
       cont.VESSEL_REG_NO_ID AS vessel_reg_no,
       cont.CNF_AGENT_CODE,
       cont.CNF_AGENT_NAME
  FROM cont, bill, paid
 WHERE cont.SL = bill.SL AND BILL.SL(+) = PAID.SL
 and bill.fcl_lcl=:p_fcl_lcl";

        return DB::select($sql,['p_fcl_lcl' => $type]);
    }
    public function getContainerHandleList($date,$type){
//                $sql = "SELECT am.vessel_reg_no,
//       am.verification_id,
//       ac.assignment_id,
//       ac.container_no,
//       ac.number_of_packages,
//       ac.container_status,
//       ac.container_size,
//       ac.gross_weight,
//       ac.container_type,
//       ac.container_height,
//       ac.container_length,
//       ac.container_width,
//       ac.rotation_no,
//       cu.cnf_agent_code,
//       cu.cnf_agent_name
//  FROM coss.os_assignment_master am,
//       coss.os_assignment_container ac,
//       coss.container_unstaffing cu
// WHERE     am.assignment_id = ac.assignment_id
//       AND ac.container_no = cu.container_no(+)
//       AND am.bill_date = TO_DATE ( :p_bill_date, 'DD-Mon-YY')  ---'04-Jan-22'
//       AND UPPER (am.fcl_lcl) = :p_fcl_lcl";

        $sql = "SELECT cu.VESSEL_REG_NO_ID,
       cu.VERIFY_NO,
       cu.CONTAINER_NO,
       cu.number_of_packages,
       cu.container_status,
       cu.CONTAINER_LENGTH as container_size,
       cu.gross_weight,
       cu.container_type,
       cu.container_height,
       cu.container_length,
       cu.container_width,
       cu.rotation_no,
       cu.cnf_agent_code,
       cu.cnf_agent_name
  FROM
       coss.container_unstaffing cu
 WHERE      trunc(cu.unstaffing_date) = TO_DATE ( :p_bill_date, 'DD-Mon-YY')  ---'04-Jan-22'
       AND UPPER (cu.CONTAINER_STATUS) = :p_fcl_lcl";

                return DB::select($sql,['p_bill_date' => $date,'p_fcl_lcl' => $type]);
    }


    public function getVesselHistory(){
        $workable_sql = "SELECT   VC.ID,
         VC.NAME,
         VH.UPDATED_AT,
         NVL (VH.OA_WORK, 0) OA_WORK,
         NVL (VH.OA_NOT_WORK, 0) OA_NOT_WORK,
         NVL (VH.SPL_BERTH_WORK, 0) SPL_BERTH_WORK,
         NVL (VH.SPL_BERTH_NOT_WORK, 0) SPL_BERTH_NOT_WORK,
         NVL (VH.JETTY_WORK, 0) JETTY_WORK,
         NVL (VH.JETTY_NOT_WORK, 0) JETTY_NOT_WORK
    FROM COSS.DB_VESSEL_CATEGORIES VC
         LEFT JOIN COSS.DB_DAILY_VESSEL_HISTORIES VH
            ON     VC.ID = VH.VESSEL_CATEGORY_ID
   WHERE VC.IS_WORKABLE = 'Y'
   and trunc(vh.updated_at) = (select trunc(updated_at) from (
            SELECT UPDATED_AT,  row_number() over (order by UPDATED_AT DESC) r FROM COSS.DB_DAILY_VESSEL_HISTORIES

) where r =1
)
   group by VC.ID,VC.IS_WORKABLE,VH.UPDATED_AT
   ,VC.NAME, VH.OA_WORK,VH.OA_NOT_WORK,vh.spl_berth_work,VH.SPL_BERTH_NOT_WORK,VH.JETTY_WORK,VH.JETTY_NOT_WORK
  ORDER BY VH.UPDATED_AT DESC, VC.ID ASC";

        $non_workable_sql = "SELECT VC.ID,
         VC.NAME, nvl(VH.UPDATED_AT, sysdate) UPDATED_AT,
         NVL (VH.OA_WORK, 0) OA_WORK,
         NVL (VH.OA_NOT_WORK, 0) OA_NOT_WORK,
         NVL (VH.SPL_BERTH_WORK, 0) SPL_BERTH_WORK,
         NVL (VH.SPL_BERTH_NOT_WORK, 0) SPL_BERTH_NOT_WORK,
         NVL (VH.JETTY_WORK, 0) JETTY_WORK,
         NVL (VH.JETTY_NOT_WORK, 0) JETTY_NOT_WORK
    FROM COSS.DB_VESSEL_CATEGORIES VC
         LEFT JOIN COSS.DB_DAILY_VESSEL_HISTORIES VH
            ON     VC.ID = VH.VESSEL_CATEGORY_ID

   WHERE VC.IS_WORKABLE = 'N'
     and trunc(vh.updated_at) = (select trunc(updated_at) from (
            SELECT UPDATED_AT,  row_number() over (order by UPDATED_AT DESC) r FROM COSS.DB_DAILY_VESSEL_HISTORIES

) where r =1
)
ORDER BY VH.UPDATED_AT DESC, VC.ID ASC";

        return [
            'workable'=>DB::select($workable_sql),
            'non_workable'=>DB::select($non_workable_sql)
        ];
    }




    public function dailyContHand(){
        $sql = "SELECT T.TITLE, CH.TOTAL_CONTAINER
  FROM COSS.DB_TITLES T
       LEFT JOIN COSS.DB_CONTAINER_HANDLING CH
          ON (    T.ID = CH.TITLE_ID
              AND TRUNC (NVL (CH.DATE_ON, SYSDATE)) = TRUNC (SYSDATE))
 WHERE UPPER (T.TYPE) = 'HANDLING'
 order by t.id";

        return DB::select($sql);
    }

    public function dailyTotalIncoming(){
        $sql = "SELECT T.TITLE, NVL (CID.UNIT_BOX, 0) BOX, NVL (CID.UNIT_TUES, 0) TUES
  FROM COSS.DB_TITLES T
       LEFT JOIN COSS.DB_CPA_IN_DISP CID
          ON (    T.ID = CID.TITLE_ID
              AND TRUNC (NVL (CID.DATE_ON, SYSDATE)) = TRUNC (SYSDATE))
 WHERE UPPER (T.TYPE) = 'INCOMING'
 order by t.id";
        return DB::select($sql);
    }

    public function dailyTotalDesp(){
        $sql = "SELECT T.TITLE, NVL (CID.UNIT_BOX, 0) BOX, NVL (CID.UNIT_TUES, 0) TUES
  FROM COSS.DB_TITLES T
       LEFT JOIN COSS.DB_CPA_IN_DISP CID
          ON (    T.ID = CID.TITLE_ID
              AND TRUNC (NVL (CID.DATE_ON, SYSDATE)) = TRUNC (SYSDATE))
 WHERE UPPER (T.TYPE) = 'DESP'
 order by t.id";
        return DB::select($sql);
    }

    public function getVesselMovementData()
    {
        $sql = "SELECT T.TITLE,
       NVL (M.NOS, 0) AS NOS,
       TO_CHAR (START_TIME, 'HH24:MI') START_TIME,
       TO_CHAR (END_TIME, 'HH24:MI') END_TIME
  FROM COSS.DB_TITLES T
       LEFT JOIN COSS.DB_VESSEL_MOVEMENTS M
          ON (    T.ID = M.TITLE_ID
              AND TRUNC (NVL (M.DATE_ON, SYSDATE)) = TRUNC (SYSDATE))
 WHERE UPPER (T.TYPE) = 'MOVEMENT'
 order by t.id";

        return DB::select($sql);
    }

    public function getNotWorkingVesselOuter(){
        $sql = "SELECT T.TITLE, nvl(O.CONTENT, '---') CONTENT
  FROM COSS.DB_TITLES T
       LEFT JOIN COSS.DB_OTHERS O
          ON (    T.ID = O.TITLE_ID
              AND TRUNC (NVL (O.DATE_ON, SYSDATE)) = TRUNC (SYSDATE))
 WHERE UPPER (T.TYPE) = 'NOT_W_V_OA'";
        return DB::select($sql);
    }

    public function getVacantBerth(){
        $sql = "SELECT T.TITLE, O.CONTENT
  FROM COSS.DB_TITLES T
       LEFT JOIN COSS.DB_OTHERS O
          ON (    T.ID = O.TITLE_ID
              AND TRUNC (NVL (O.DATE_ON, SYSDATE)) = TRUNC (SYSDATE))
 WHERE UPPER (T.TYPE) = 'VACANT_BERTH'";
        return DB::select($sql);
    }
    public function getPopData($date_on){
        $sql = "SELECT LD.ID,DT.title,LD.lying_qty,LD.date_on FROM COSS.DB_LYING_DTL LD left join COSS.DB_TITLES DT on LD.TITLE_ID = DT.ID  WHERE DATE_ON = TO_DATE (:date_on,'YY-MM-DD')";
        return DB::select($sql,['date_on'=>date('Y-m-d',strtotime($date_on))]);
    }
}
