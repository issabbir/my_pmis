<?php


namespace App\Http\Controllers\Api\V2;

use App\Entities\Security\Menu;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    public function accessModules(){
        $auth = auth();
        if ($auth->user()->hasGrantAll()) {
            $menus = Menu::orderBy('menu_order_no')->get();
        } else {
            $menus = $auth->user()->getRoleMenus();
        }

        $m=[];
        foreach ($menus as $menu) {
            if ($menu->active_yn == 'Y' && $menu->menu_id != 44) {
                $menu->base_url = externalLoginUrl($menu->base_url, $menu->base_path);
                $m[] = $menu;
            }
        }
        return $m;
    }

    public function monthSalary() {
        $sql = 'WITH ADDITION
     AS (SELECT PM.PR_MONTH_ID,
                  TO_CHAR (PM.CALCULATION_START_DATE, \'FMMONTH-YYYY\')  MONTH_NAME,
                  PM.CALCULATION_START_DATE,
                  SUM (AMOUNT) ADDITION
             FROM PR_SALARY_PROCESS PR, L_DEPARTMENT LD, PR_MONTHS PM
            WHERE     DEDUCTION_YN = \'N\'
                  AND PR.DPT_DEPARTMENT_ID = LD.DEPARTMENT_ID
                  AND PM.PR_MONTH_ID = PR.PR_MONTH_ID
         GROUP BY
                  PM.PR_MONTH_ID,
                  PM.CALCULATION_START_DATE,
                  TO_CHAR (PM.CALCULATION_START_DATE, \'FMMONTH-YYYY\')),
     DEDECTION
     AS ( SELECT PM.PR_MONTH_ID,
                  TO_CHAR (PM.CALCULATION_START_DATE, \'FMMONTH-YYYY\')  MONTH_NAME,
                  PM.CALCULATION_START_DATE,
                  SUM (AMOUNT) DED
             FROM PR_SALARY_PROCESS PR, L_DEPARTMENT LD, PR_MONTHS PM
            WHERE     DEDUCTION_YN = \'Y\'
                  AND PR.DPT_DEPARTMENT_ID = LD.DEPARTMENT_ID
                  AND PM.PR_MONTH_ID = PR.PR_MONTH_ID
         GROUP BY
                  PM.PR_MONTH_ID,
                  PM.CALCULATION_START_DATE,
                  TO_CHAR (PM.CALCULATION_START_DATE, \'FMMONTH-YYYY\'))
  SELECT
         AD.MONTH_NAME,
         AD.CALCULATION_START_DATE,
         AD.ADDITION - DED.DED NETPAY
    FROM ADDITION AD, DEDECTION DED
   WHERE
          AD.PR_MONTH_ID = DED.PR_MONTH_ID
ORDER BY AD.CALCULATION_START_DATE';

        $datas = DB::select($sql);
        $labels = [];
        $series = [];
        foreach ($datas as $dt) {
            $labels[] = $dt->month_name;
            $series[] =$dt->netpay;
        }


        return ['labels' => $labels, 'series' => $series];
    }


    public function departmentWiseEmployee(){
        $sql = "SELECT COUNT (E.EMP_CODE) AS NUMBER_OF_EMPLOYEE,
         E.DPT_DEPARTMENT_ID,
         D.DEPARTMENT_NAME
    FROM EMPLOYEE E
         LEFT JOIN L_DEPARTMENT D ON (D.DEPARTMENT_ID = E.DPT_DEPARTMENT_ID)
   WHERE E.EMP_STATUS_ID = 1
GROUP BY E.DPT_DEPARTMENT_ID, D.DEPARTMENT_NAME
ORDER BY DEPARTMENT_NAME";

        $datas = DB::select($sql);
        $labels = [];
        $data = [];
        foreach ($datas as $dt) {
            $labels[] = $dt->department_name;
            $data[] =$dt->number_of_employee;
        }

        return ['labels' => $labels, 'data' => $data];
    }
}
