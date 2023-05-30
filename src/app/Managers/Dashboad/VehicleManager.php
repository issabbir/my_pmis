<?php


namespace App\Managers\Dashboad;


use Illuminate\Support\Facades\DB;

class VehicleManager
{
    public function getData()
    {
        $sql = "SELECT SUM (CASE WHEN vi.VEHICLE_STATUS_ID = 1 THEN 1 END) AS operating,
                   SUM (CASE WHEN vi.VEHICLE_STATUS_ID = 2 THEN 1 END)
                      AS repairing_servicing,
                   SUM (CASE WHEN vi.VEHICLE_STATUS_ID = 3 THEN 1 END) AS out_of_order
            FROM MEA.VM_VEHICLE_INFO vi";
       return DB::select($sql);
    }

    public function vehicleParticulars(){
        $sql = "SELECT T1.DATE_ON,
       NVL (T2.CAPACITY, 0) CAPACITY,
       NVL (T2.DELIVERY_QTY, 0) DELIVERY_QTY,
       NVL (T2.AUC_LYING, 0) AUC_LYING,
       NVL (T2.TOTAL_LYING, 0) TOTAL_LYING,
       NVL (T2.UPDATED_AT, T1.DATE_ON) UPDATED_AT
  FROM (SELECT SYSDATE AS DATE_ON FROM DUAL) T1
       LEFT JOIN (SELECT * FROM COSS.DB_VEHICLE_STATUS) T2
          ON TRUNC (T2.DATE_ON) = TRUNC (T1.DATE_ON)";
        return DB::selectOne($sql);
    }

    public function containerLyingPosition(){
        $sql = "
SELECT T2.ID,
       TRUNC (T.DATE_ON) DATE_ON,
       NVL (T2.CAPACITY, 0) CAPACITY,
       NVL (T2.LYING_ON_QTY, 0) LYING_ON_QTY,
       NVL (T2.UPDATED_AT, T.DATE_ON),
       NVL (T2.DELIVERY_QTY, 0) DELIVERY_QTY
  FROM (    SELECT TRUNC (SYSDATE + 1 - ROWNUM) DATE_ON
              FROM DUAL
        CONNECT BY ROWNUM < 3) T
       LEFT JOIN
       (SELECT ID,
               TRUNC (DATE_ON) DATE_ON,
               CAPACITY,
               LYING_ON_QTY,
               UPDATED_AT,
               DELIVERY_QTY
          FROM COSS.DB_CONTAINER_LYINGS) T2
          ON T2.DATE_ON = T.DATE_ON
          order by t.date_on desc";
        return DB::select($sql);
    }

    public function detailInfo($status) {
        $sql = "SELECT * FROM MEA.VM_VEHICLE_INFO vi WHERE vi.VEHICLE_STATUS_ID = :VEHICLE_STATUS_ID";
        return DB::select($sql, ['VEHICLE_STATUS_ID' => $status]);
    }
}
