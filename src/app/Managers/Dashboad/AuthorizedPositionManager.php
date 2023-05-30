<?php


namespace App\Managers\Dashboad;


use Illuminate\Support\Facades\DB;

class AuthorizedPositionManager
{
    public function authorizedPosition(){
        $sql = "SELECT AUTHORIZED_POSITION,
       TOTAL_WORKING,
       (AUTHORIZED_POSITION - TOTAL_WORKING) AS VACANT
  FROM (select
                 '8679' as AUTHORIZED_POSITION,
               (select
                    count(e.emp_id) count
                from employee e
                    inner join l_emp_type et on (et.emp_type_id = e.emp_type_id)
                    where EMP_STATUS_ID in (1,2,4,6,10,13)
                    )
                  TOTAL_WORKING
          FROM DUAL)";

        $authorizedPosition = DB::select($sql);

        return $authorizedPosition;
    }
}
