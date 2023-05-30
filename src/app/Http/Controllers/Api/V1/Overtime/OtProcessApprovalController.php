<?php

namespace App\Http\Controllers\Api\V1\Overtime;

use App\Entities\Overtime\OtCalProcess;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OtProcessApprovalController extends Controller
{
    public $department = '';
    public $section    = '';
    public $calculation_start_date  = '';
    public $calculation_end_date = '';
    public $monthYear = '';

    public function __construct()
    {

    }

    public function index(Request $request)
    {
        //return $this->getInit();
    }

    public function view(Request $request)
    {
        //TODO: Default template for action.
    }

    public function search_result(Request $request)
    {

        $this->department = $request->get("department_id");
        $this->section    = $request->get("section_id");
        $this->calculation_start_date  = $request->get("fromdate");
        $this->calculation_end_date = $request->get("todate");
       // $this->monthYear  = $request->get('month_id');
       // $dateArr    = explode('####',$this->monthYear);
        //$month_id = $dateArr[0];
        $month_id= $request->get('month_id');
        // $dateArr    = explode('####',$monthYear);
        // $pr_month_id = $dateArr[0];
        // $onlydateArray = explode(' ',$dateArr[1]);
        // $calculation_start_date = $onlydateArray[0];
        // $onlydateArray2 = explode(' ',$dateArr[2]);
        // $calculation_end_date = $onlydateArray2[0];
        // print_r($request->all());

    //     $query = "SELECT oc.ot_register_id,
    //      oc.emp_id,
    //      oc.emp_code,
    //      oc.emp_name,
    //      ei.basic_amt,
    //      ei.designation,
    //      ei.department_name,
    //      oc.ot_category_id,
    //      oc.ot_category_name,
    //      round(oc.ot_rate,2) as ot_rate,
    //      ot_type,
    //      oc.approve_status,
    //      round(SUM (approve_hour),2) AS approve_hour,
    //      round(SUM (actual_hour),2) AS actual_hour,
    //      round(SUM (amount),2)  AS amount
    // FROM ot_cal_process oc, employee_info_vu ei
    // WHERE oc.emp_id = ei.emp_id ";

//    $query = "SELECT oc.ot_register_id,
//        oc.emp_id,
//        oc.emp_code,
//        oc.emp_name,
//        -- to_char(ei.basic_amt, '99,99,990.00') as basic_amt,
//        ei.basic_amt,
//        ei.designation,
//        ei.department_name,
//        oc.ot_category_id,
//        oc.ot_category_name,
//        reg_ot_rate,
//        off_ot_rate,
//        oc.approve_status,
//        off_app_hour AS off_app_hour,
//        reg_app_hour AS reg_app_hour,
//        off_actual_hour AS off_actual_hour,
//        reg_actual_hour AS reg_actual_hour,
//        reg_amount as reg_amount,
//        off_amount as off_amount,
//        round((reg_amount+OFF_AMOUNT),2)  as total_amount
//        --to_char(reg_amount, '99,99,990.00') as reg_amount,
//        --to_char(off_amount, '99,99,990.00') as off_amount,
//        --to_char((reg_amount+OFF_AMOUNT), '99,99,990.00')  as total_amount
//        FROM ot_calculation oc, employee_info_vu ei
//        WHERE     oc.emp_id = ei.emp_id
//        AND oc.approve_status = 0 ";
    $query = "SELECT DISTINCT oc.ot_register_id,
                oc.emp_id,
                oc.emp_code,
                oc.emp_name,
                -- to_char(ei.basic_amt, '99,99,990.00') as basic_amt,
                ei.basic_amt,
                ei.designation,
                ei.department_name,
                oc.ot_category_id,
                oc.ot_category_name,
                reg_ot_rate,
                off_ot_rate,
                oc.approve_status,
                off_app_hour AS off_app_hour,
                reg_app_hour AS reg_app_hour,
                oc.off_actual_hour as off_actual_hour,
                --off_actual_hour AS off_actual_hour,
              --  (SELECT distinct SUM (otr.OFFDYAPP_HOUR)
       -- FROM --emp_attendance ea, l_roster_shift rs,
        --OT_REGISTER otr
       --WHERE   -
             --AND
           --  otr.emp_id = a.emp_id-
           --  )
                reg_actual_hour AS reg_actual_hour,
                reg_amount AS reg_amount,
--                (SELECT distinct SUM (otr.OFFDYAPP_HOUR)
--        FROM emp_attendance ea, l_roster_shift rs, OT_REGISTER otr
--       WHERE     ea.shift_id = rs.shift_id
--             AND otr.emp_id = ea.emp_id
--             AND ea.emp_id = a.emp_id
--             AND ea.roster_date = a.roster_date)

             (SELECT distinct SUM (otr.OFFDYAPP_HOUR)
        FROM --emp_attendance ea, l_roster_shift rs,
        OT_REGISTER otr
       WHERE     --ea.shift_id = rs.shift_id
             --AND
             otr.emp_id = a.emp_id
            -- AND ea.emp_id = a.emp_id
             --AND ea.roster_date = a.roster_date
             )*OFF_OT_RATE AS off_amount,
                ROUND ( (reg_amount + OFF_AMOUNT), 2) AS total_amount
  --to_char(reg_amount, '99,99,990.00') as reg_amount,
  --to_char(off_amount, '99,99,990.00') as off_amount,
  --to_char((reg_amount+OFF_AMOUNT), '99,99,990.00')  as total_amount
  FROM ot_calculation oc, employee_info_vu ei, emp_attendance a
 WHERE     oc.emp_id = ei.emp_id
       AND oc.EMP_ID = a.emp_id
       AND oc.approve_status = 0";

        if(!empty($this->department) && ($this->department != 'undefined')){
            $query .= " and oc.dpt_department_id = '".$this->department."' ";
        }
        if(!empty($this->section) && ($this->section != 'undefined')){
            $query .= " and oc.section_id  = '".$this->section."' ";
        }

        // if(!empty($this->calculation_start_date) && !empty($this->calculation_end_date)){
        //         $query .= " and oc.DATE_FROM  >= TO_DATE('".$this->calculation_start_date."', 'YYYY/MM/DD')
        //         and oc.DATE_TO <= TO_DATE('".$this->calculation_end_date."', 'YYYY/MM/DD') ";
        // }
        if($month_id){
            $query .= " and oc.ot_month_id = '".$month_id."' ";
        }


        $data = DB::Select($query);
        //dd(DB::Select($query));

        return [
            "status" => true,
            "table_info" => $data //$query //$query //->all()
        ];

    }

    public function search_result_report(Request $request)
    {
        if($request->get('realObj')['department_id']){
            $this->department = $request->get('realObj')['department_id'];
            $this->section    = $request->get('realObj')['section_id'];
            $this->monthYear  = $request->get('realObj')['month'];
        }else{
            $this->department = $request->get("department_id");
            $this->section    = $request->get("section_id");
            $this->monthYear  = $request->get('month');
        }

         $dateArr    = explode('####',$this->monthYear);
         $month_id = $dateArr[0];
        // $onlydateArray = explode(' ',$dateArr[1]);
        // $calculation_start_date = $onlydateArray[0];
        // $onlydateArray2 = explode(' ',$dateArr[2]);
        // $calculation_end_date = $onlydateArray2[0];
        // print_r($request->all());
       /*
        $query = "SELECT oc.ot_register_id,
         oc.emp_id,
         oc.emp_code,
         oc.emp_name,
         ei.basic_amt,
         ei.designation,
         ei.department_name,
         oc.ot_category_id,
         oc.ot_category_name,
         round(oc.ot_rate,2) as ot_rate,
         ot_type,
         oc.approve_status,
         round(SUM (approve_hour),2) AS approve_hour,
         round(SUM (actual_hour),2) AS actual_hour,
         round(SUM (amount),2)  AS amount
    FROM ot_cal_process oc, employee_info_vu ei
    WHERE oc.emp_id = ei.emp_id ";
       */
        $query = "SELECT oc.ot_register_id,
        oc.emp_id,
        oc.emp_code,
        oc.emp_name,
        to_char(ei.basic_amt, '99,99,999.99') as basic_amt,
        ei.designation,
        ei.department_name,
        oc.ot_category_id,
        oc.ot_category_name,
        reg_ot_rate,
        off_ot_rate,
        oc.approve_status,
        off_app_hour AS off_app_hour,
        reg_app_hour AS reg_app_hour,
        off_actual_hour AS off_actual_hour,
        reg_actual_hour AS reg_actual_hour,
        reg_amount,
        off_amount,
        (reg_amount+OFF_AMOUNT) as total_amount
        FROM ot_calculation oc, employee_info_vu ei
        WHERE     oc.emp_id = ei.emp_id
        AND oc.approve_status = 0 ";

        if(!empty($this->department) && ($this->department != 'undefined')){
            $query .= " and oc.dpt_department_id = '".$this->department."' ";
        }
        if(!empty($this->section) && ($this->section != 'undefined')){
            $query .= " and oc.section_id  = '".$this->section."' ";
        }

        // if(!empty($this->calculation_start_date) && !empty($this->calculation_end_date)){
        //         $query .= " and oc.DATE_FROM  >= TO_DATE('".$this->calculation_start_date."', 'YYYY/MM/DD')
        //         and oc.DATE_TO <= TO_DATE('".$this->calculation_end_date."', 'YYYY/MM/DD') ";
        // }

        // if($month_id){
        //     $query .= " and oc.ot_month_id = '".$month_id."' ";
        // }

        /*
        $query .= " GROUP BY oc.ot_register_id,
        oc.emp_id,
        oc.emp_code,
        oc.emp_name,
        ei.basic_amt,
        ei.designation,
        ei.department_name,
        oc.ot_category_id,
        oc.ot_category_name,
        oc.approve_status,
        oc.ot_rate,
        ot_type
        order by oc.approve_status, oc.emp_name  asc";
        */
        $data = DB::Select($query);

        return [
            "status" => true,
            "table_info" => $data //->all()
        ];

    }


    public function store(Request $request)
    {
        try {
                $params = [];
                $statusCode          = sprintf("%4000s", "1");
                $statusMessage       = sprintf('%4000s', '');
                $ot_reg_arrray       = $request->get('paramsCheckedObj');

                if(count($ot_reg_arrray)>0){
                    foreach ($ot_reg_arrray as $otApproval){
                        // if($otApproval['approve_status'] == 1){
                        //     //return ["status" =>  ["o_status_code" => 0, "o_status_message" => 'All employee already approved']];
                        //     continue;
                        // }else{
                                $params = [
                                            "p_ot_register_id"      => $otApproval,
                                            "p_approve_status"      => 1,
                                            "p_update_by"           => Auth()->ID(),
                                            "o_status_code"         => &$statusCode,
                                            "o_status_message"      => &$statusMessage
                                            ];

                            DB::executeProcedure('OVERTIME.ot_cal_process_approve', $params);
                       // }

                }
                return ["approves" => $this->search_result_report($request), "status" => $params];
            }

        }
        catch (\Exception $e) {
            return ["status" => ["exception" => true, "o_status_code" => 0, "o_status_message" => $e->getMessage()]];
        }
     }

    public function update(Request $request)
    {
        //TODO: Default template for action.
    }

    public function remove(Request $request)
    {
        //TODO: Default template for action.
    }
}
