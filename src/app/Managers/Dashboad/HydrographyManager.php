<?php


namespace App\Managers\Dashboad;


use Illuminate\Support\Facades\DB;

class HydrographyManager
{
    public function getData()
    {
        $sql = "SELECT TO_CHAR (POD.CREATED_DATE, 'FMMONTH-YYYY')     AS SURVEY_CHART,
         SUM (POD.PRICE)                                AS SALES_AMOUNT,
         SUM (POD.QTY)  QUANTITY
    FROM HYDROAS.PRODUCT_ORDER_DETAIL POD
GROUP BY TO_CHAR (POD.CREATED_DATE, 'FMMONTH-YYYY')
ORDER BY TO_DATE (SURVEY_CHART, 'FMMONTH-YYYY')";

        $datas = DB::select($sql);
        /*$formatted_data = [];
        $row = [];
        foreach ($datas as $data) {
            $row['survey_chart'] = $data->survey_chart;
            $row['sales_amount_format'] = number_format($data->sales_amount, 2);
            $row['sales_amount'] = $data->sales_amount;
            array_push($formatted_data, $row);
        }*/
        return $datas;
    }

    public function getSchData()
    {
        $sql_sch = "SELECT COUNT (*)                                        AS TOTAL_SCHEDULE,
       SUM (CASE WHEN APPROVED_YN = 'Y' THEN 1 END)     AS APPROVED,
       SUM (CASE WHEN APPROVED_YN = 'N' THEN 1 END)     AS NOT_APPROVED
  FROM HYDROAS.SCHEDULE_MASTER
 WHERE TRUNC (INSERT_TIME) >= ADD_MONTHS (TRUNC (SYSDATE), -3)";

        $data_sch = DB::select($sql_sch);
        /*$format_data = [];
        $row1 = [];
        foreach ($data_sch as $data) {
            $row1['total_schedule'] = $data->total_schedule;
            $row1['approved'] = $data->approved;
            $row1['not_approved'] = $data->not_approved;
            array_push($format_data, $row1);
        }*/
        return $data_sch;
    }
}
