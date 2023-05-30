<?php


namespace App\Managers\Dashboad;


use Illuminate\Support\Facades\DB;

class HouseAllotmentManager
{

    public function getData()
    {
        $sql = "SELECT DISTINCT
         HT.HOUSE_TYPE,
         COUNT (*)                                                 AS total,
         COUNT (CASE WHEN Hl.HOUSE_STATUS_ID = '1' THEN 0 END)     AVAILABLE,
         COUNT (CASE WHEN Hl.HOUSE_STATUS_ID = '2' THEN 0 END)     ALLOTTED,
         COUNT (CASE WHEN Hl.HOUSE_STATUS_ID = '3' THEN 0 END)     MAINTENANCE,
         COUNT (CASE WHEN Hl.HOUSE_STATUS_ID = '4' THEN 0 END)     RESERVED,
         COUNT (CASE WHEN Hl.HOUSE_STATUS_ID = '5' THEN 0 END)     OUT_OF_USE
    FROM has.HOUSE_LIST HL, has.L_HOUSE_TYPE HT, has.L_HOUSE_STATUS HS
   WHERE     HL.HOUSE_TYPE_ID = HT.HOUSE_TYPE_ID
         AND HL.HOUSE_STATUS_ID = HS.HOUSE_STATUS_ID
GROUP BY HT.HOUSE_TYPE

ORDER BY 1 DESC,
         2 DESC,
         3 DESC,
         4 DESC,
         5 DESc";

        $houseAllotment = DB::select($sql);
//dd($sql);
        return $houseAllotment;

    }

    public function getPopData($status)
    {
        $stringParts = explode("+", $status);

        $house_type  = $stringParts[0];
        $status = $stringParts[1];

        $sql = "select hl.*, cl.colony_name, bl.building_name, ha.DATE_OF_ALLOTMENT
  from has.house_list         hl,
       has.l_colony       cl,
       has.building_list  bl,
       has.l_house_type       ht, has.HOUSE_ALLOTTMENT ha
 where     hl.colony_id = cl.colony_id
       and hl.building_id = bl.building_id
       and hl.house_type_id = ht.house_type_id
       and hl.HOUSE_ID = ha.HOUSE_ID(+) --and ha.ALLOT_YN = 'Y'
       and hl.house_status_id = :status --:status
       and upper (ht.house_type) = upper (:house_type)--:house_type)";
        $data = db::select($sql,['status' => $status, 'house_type' => $house_type]);
        return $data;

    }


}
