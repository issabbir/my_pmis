<?php


namespace App\Helper;


use App\Entities\Pmis\Employee\EmployeeTemp;
use Illuminate\Support\Facades\DB;

class HelperClass
{
    public static function currentDesignation($emp_id){
        $employeeTemp = new EmployeeTemp();

        $sql = "SELECT DISTINCT designation FROM EMPLOYEE a,l_designation tn, CHARGE_ENTRY cn
                               WHERE     tn.designation_id =
                                         cn.charge_designation_id
                                     AND a.emp_id = cn.emp_id
                                     AND a.emp_id =
                                         NVL ( :emp_id, a.emp_id )
                                     AND SYSDATE BETWEEN cn.CHARGE_ACTIVATION_DATE
                                                     AND NVL (cn.CHARGE_END_DATE,
                                                              SYSDATE)
                                                              and  ROWNUM = 1";
        $designation = DB::selectOne($sql,['emp_id'=>$emp_id]);

        $selectedEmployeeTemp = $employeeTemp->find($emp_id);
        $employeeDesignation = isset($selectedEmployeeTemp->designation) ? $selectedEmployeeTemp->designation->designation : '';
        return $designation ? $designation->designation : $employeeDesignation;
    }
    public static function dateDiffInDays($date1, $date2)
    {
        $to = \Carbon\Carbon::parse($date1);
        $from = \Carbon\Carbon::parse($date2);

        return $to->diffInDays(\Carbon\Carbon::parse($from));
    }
}
