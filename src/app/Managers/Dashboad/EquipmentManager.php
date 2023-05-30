<?php


namespace App\Managers\Dashboad;


use Illuminate\Support\Facades\DB;

class EquipmentManager
{
    public function getData()
    {
        $sql = "SELECT COUNT (e.EQUIP_ID)      Total_Equipment,
                       COUNT (rd.EQUIP_ID)     working_equip,
                       COUNT (sm.EQUIP_ID)     servicing_equip
                  FROM EQMS.EQUIPMENT e, EQMS.ROSTER_DTL rd, EQMS.SERVICE_MST sm
                 WHERE e.EQUIP_ID = rd.EQUIP_ID(+) AND e.EQUIP_ID = sm.EQUIP_ID(+)";
       return DB::select($sql);
    }
}
