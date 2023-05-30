<?php

namespace App\Http\Controllers\Api\V1\Overtime;

use App\Http\Controllers\Controller;
use App\Contracts\Admin\AdminContract;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Contracts\Pmis\Employee\EmployeeContract;
class OtProcessController extends Controller
{
    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        return $this->getPreloadInfo();
    }
    public function getPreloadInfo(){
        return [
             "year_month_option"=> $this->year_month_option(),
             "departmentList"   => $this->departmentList(),
             "sectionList"      => $this->sectionList()
        ];
    }


    private function year_month_option(){
        $query ="SELECT ot_month_id,
            TO_CHAR (
               TO_DATE ('01' || LPAD (ot_month, 2, '0') || '2000', 'DDMMRRRR'),
               'fmMonth')
         || ' '
         || ot_year
            AS show_value,
         effective_start_date calculation_start_date,
         effective_end_date calculation_end_date
    FROM ot_months
    where open_yn = 'O'
ORDER BY effective_start_date ASC";
        $ym_data = DB::select($query);
       // dd($ym_data);
        $year_month_option = [];
        $year_month_option[] = ["value" => null, 'text' => 'Select Year Month'];
         foreach ($ym_data as $item) {
            $year_month_option[] = ["text" => $item->show_value,
            'value' => $item];
        }
         return $year_month_option;
    }

    private function departmentList(){
        $departmentList = [];
        $departmentList[] = ["value" => null, 'text' => 'Select Department'];
         foreach ($this->adminManager->findCurrentDepartments() as $item) {
            $departmentList[] = ["text" => $item->department_name, 'value' => $item->department_id];
        }
         return $departmentList;
    }
    private function sectionList(){
        $sectionList = [];
        $sectionList[] = ["value" => null, 'text' => 'Select Section'];
         foreach ($this->adminManager->findDptSections() as $item) {
            $sectionList[] = ["text" => $item->dpt_section, 'value' => $item->dpt_section_id];
        }
         return $sectionList;
    }

    public function search_result(Request $request)
    {

        try {
            $department = $request->get("department_id");
            $section    = $request->get("section_id");
            $bill_code    = $request->get("bill_code");
            $fromDate   = $request->get("fromDate");
            $monthId = $fromDate['ot_month_id'];

            $calculation_start_date = date("Y-m-d", strtotime($fromDate['calculation_start_date']));
            $calculation_end_date = date("Y-m-d", strtotime($fromDate['calculation_end_date']));
            $query = "select overtime.ot_calculation_process_data (:p_date_from,
                                         :p_date_to,
                                         :p_pr_month_id,
                                         :p_dpt_department_id,
                                         :p_section,
                                         :p_bill_code) from dual";

            $params = [
                'p_date_from'           => $calculation_start_date,
                'p_date_to'             => $calculation_end_date,
                'p_dpt_department_id'   => $department,
                'p_bill_code'           => $bill_code,
                'p_section'             => $section,
                'p_pr_month_id'         => $monthId
            ];

            $data = DB::select($query, $params);

            return [
                "status" => true,
                "table_info" => $data //$query ////->all()
            ];


//            $query = "SELECT rd.emp_id,
//            rd.emp_code,
//            rd.emp_name,
//            rd.designation_id,
//            ev.designation,
//            rd.dpt_department_id,
//            ev.department_name,
//            rd.section_id,
//            ev.dpt_section,
//            rd.biller_code,
//            rd.bill_code,
//             -- re.date_from,
//             -- re.date_to,
//            COUNT (*)   no_of_day,
//            SUM (
//                DECODE (DECODE (rd.holiday_yn, 'N', rd.off_day_yn, rd.holiday_yn),
//                        'Y', rd.register_hour,
//                        0))                                            off_day_register_hour,
//            SUM (
//                DECODE (DECODE (rd.holiday_yn, 'N', rd.off_day_yn, rd.holiday_yn),
//                        'N', rd.register_hour,
//                        0))                                            reg_day_register_hour,
//            SUM (
//                DECODE (DECODE (rd.holiday_yn, 'N', rd.off_day_yn, rd.holiday_yn),
//                        'Y', rd.approve_hour,
//                        0))                                            off_day_approve_hour,
//            SUM (
//                DECODE (DECODE (rd.holiday_yn, 'N', rd.off_day_yn, rd.holiday_yn),
//                        'N', rd.approve_hour,
//                        0))                                            reg_day_approve_hour,
//            SUM (
//                DECODE (DECODE (rd.holiday_yn, 'N', rd.off_day_yn, rd.holiday_yn),
//                        'Y', rd.actual_hour,
//                        0))                                            off_day_actual_hour,
//            SUM (
//                DECODE (DECODE (rd.holiday_yn, 'N', rd.off_day_yn, rd.holiday_yn),
//                        'N', rd.actual_hour,
//                        0))                                            reg_day_actual_hour,
//            SUM (
//                DECODE (DECODE (rd.holiday_yn, 'N', rd.off_day_yn, rd.holiday_yn),
//                        'Y', rd.special_hour,
//                        0))                                            off_day_special_hour,
//            SUM (
//                DECODE (DECODE (rd.holiday_yn, 'N', rd.off_day_yn, rd.holiday_yn),
//                        'N', rd.special_hour,
//                        0))                                            reg_day_special_hour,
//              SUM (
//                  DECODE (
//                      DECODE (rd.holiday_yn, 'N', rd.off_day_yn, rd.holiday_yn),
//                      'Y', rd.special_hour,
//                      0))
//            + SUM (
//                  DECODE (
//                      DECODE (rd.holiday_yn, 'N', rd.off_day_yn, rd.holiday_yn),
//                      'Y', rd.approve_hour,
//                      0))                                              final_off_day_approve_hour,
//              SUM (
//                  DECODE (
//                      DECODE (rd.holiday_yn, 'N', rd.off_day_yn, rd.holiday_yn),
//                      'N', rd.special_hour,
//                      0))
//            + SUM (
//                  DECODE (
//                      DECODE (rd.holiday_yn, 'N', rd.off_day_yn, rd.holiday_yn),
//                      'N', rd.approve_hour,
//                      0))                                              final_reg_day_approve_hour,
//                      NVL (
//                            SUM (
//                                DECODE (
//                                    DECODE (rd.holiday_yn,
//                                            'N', rd.off_day_yn,
//                                            rd.holiday_yn),
//                                    'Y', rd.special_hour,
//                                    0))
//                            + SUM (
//                                DECODE (
//                                    DECODE (rd.holiday_yn,
//                                            'N', rd.off_day_yn,
//                                            rd.holiday_yn),
//                                    'Y', rd.approve_hour,
//                                    0))
//                            + SUM (
//                                DECODE (
//                                    DECODE (rd.holiday_yn,
//                                            'N', rd.off_day_yn,
//                                            rd.holiday_yn),
//                                    'N', rd.special_hour,
//                                    0))
//                            + SUM (
//                                DECODE (
//                                    DECODE (rd.holiday_yn,
//                                            'N', rd.off_day_yn,
//                                            rd.holiday_yn),
//                                    'N', rd.approve_hour,
//                                    0)),
//                         0) final_total_approve_hr,
//
//            SUM (NVL (overtime.ot_time (rd.emp_id, rd.roster_date, 'N'), 0))    ot_hour
//            FROM ot_register re, ot_register_dtl rd, employee_info_vu ev
//            WHERE     ev.emp_id = rd.emp_id
//            AND re.ot_register_id = rd.ot_register_id ";
//            if($department){
//                $query .= " AND re.dpt_department_id = '".$department."' ";
//            }
//            if($bill_code){
//                $query .= " AND rd.bill_code = '".$bill_code."' ";
//            }
//            if($section){
//                $query .= "  AND rd.section_id = = '".$section."' ";
//            }
//
//            $query .= " and re.date_from  >= TO_DATE('".$calculation_start_date."', 'YYYY/MM/DD')
//            and re.date_to <= TO_DATE('".$calculation_end_date."', 'YYYY/MM/DD') ";
//
//            $query .= " AND re.approve_status = 1
//             AND NVL (re.process_flag, 0) = 0
//             AND NVL (re.ot_status, 0) = 0
//            AND NVL (rd.ot_status, 0) = 0
//
//            GROUP BY rd.emp_id,
//            rd.emp_code,
//            rd.emp_name,
//            rd.designation_id,
//            ev.designation,
//            rd.dpt_department_id,
//            ev.department_name,
//            rd.section_id,
//            ev.dpt_section,
//            rd.biller_code,
//            rd.bill_code
//            -- re.date_from,
//            -- re.date_to
//            ";
//
////         $query = "SELECT rd.emp_id,
//         rd.emp_code,
//         rd.emp_name,
//         rd.designation_id,
//         ev.designation,
//         rd.dpt_department_id,
//         ev.department_name,
//         rd.section_id,
//         ev.dpt_section,
//         rd.biller_code,
//         rd.bill_code,
//         re.date_from,
//         re.date_to,
//         NVL (NVL (rd.holiday_yn, rd.off_day_yn), 'N')     off_day_yn,
//         rd.register_hour                                  per_day_hour ,
//         COUNT (*)                                         no_of_day,
//         SUM (rd.register_hour)                            AS register_hour,
//         SUM (rd.approve_hour)                             AS approve_hour,
//         SUM (rd.actual_hour)                              AS actual_hour
//          -- rd.APPROVE_STATUS status
//     FROM ot_register re, ot_register_dtl rd, employee_info_vu ev
//    WHERE ev.emp_id = rd.emp_id
//          AND re.approve_status = 1
//          AND NVL (re.process_flag, 0) = 0
//          AND NVL (re.ot_status, 0) = 0
//          AND NVL (rd.ot_status, 0) = 0
//          AND re.ot_register_id = rd.ot_register_id
//          AND re.dpt_department_id = rd.dpt_department_id ";

//         if($department){
//             $query .= " and rd.dpt_department_id = '".$department."' ";
//         }
//         if($section){
//             $query .= " and rd.section_id         = '".$section."' ";
//         }

//         $query .= " and re.date_from  >= TO_DATE('".$calculation_start_date."', 'YYYY/MM/DD')
//         and re.date_to <= TO_DATE('".$calculation_end_date."', 'YYYY/MM/DD') ";

//             $query .= " GROUP BY rd.emp_id,
//             rd.emp_code,
//             rd.emp_name,
//             rd.designation_id,
//             ev.designation,
//             rd.dpt_department_id,
//             ev.department_name,
//             rd.section_id,
//             ev.dpt_section,
//             rd.biller_code,
//             rd.bill_code,
//             re.date_from,
//             re.date_to,
//             NVL (NVL (rd.holiday_yn, rd.off_day_yn), 'N'),
//             rd.register_hour
//              ";



        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
    }

    public function view(Request $request)
    {
        $query = "select rownum rn,
        ot_register.emp_code,
        ot_register.emp_name,
        l_designation.designation,
        ot_register.designation_id,
        l_department.department_name,
        l_dpt_section.dpt_section,
        ot_register.dpt_division_id,
        ot_register.section_id,
        ot_register.date_from,
        ot_register.date_to,
        ot_register.register_hour,
        ot_register.approve_hour,
         (SELECT SUM (NVL (actual_hour, 0))
              FROM ot_register_dtl
             WHERE     ot_register_id = ot_register.ot_register_id
                   AND roster_date BETWEEN ot_register.date_from
                                       AND ot_register.date_to) actual_hour,
        ot_register.approve_status status

         from ot_register

         left join l_department on l_department.department_id = ot_register.dpt_department_id
         left join l_designation on l_designation.designation_id = ot_register.designation_id
         left join l_dpt_section on l_dpt_section.dpt_section_id = ot_register.section_id
         Where EMP_CODE is not null and OT_REGISTER_TEMP.APPROVE_STATUS = 1 ";
            $data = DB::select($query);
            return [
                "status" => true,
                "table_info"    => $data //->all()
            ];

    }

    public function store(Request $request)
    {
        $fromDate = $request->get('fromDate');
        $dateId = isset($fromDate['ot_month_id'])?$fromDate['ot_month_id']:'';
        if(!$dateId){   //!$request->get('department_id') ||

            return ["exception" => true, "o_status_code" => 999, "o_status_message" => "Please fill up date field"];
        }
        try {
                $p_dpt_department_id = $request->get('department_id'); //$request->department_id;
                $p_section_id        = $request->get('section_id'); //$request->p_section_id;
                $p_bill_code        = $request->get('bill_code'); //$request->p_section_id;
                $p_pr_month_id       = $dateId;
                //$p_insert_by         = Auth()->ID();
                $statusCode          = sprintf("%4000s", "");
                $statusMessage       = sprintf('%4000s', '');
                $params = [
                   "p_dpt_department_id"   => $p_dpt_department_id?:$p_dpt_department_id,
                   "p_section_id"          => $p_section_id?:$p_section_id,
                   "p_pr_month_id"         => $p_pr_month_id,
                   "p_bill_code"         => $p_bill_code,
                   "p_insert_by"           => Auth()->ID(),
                   "o_status_code"         => &$statusCode,
                   "o_status_message"      => &$statusMessage
                ];
                 //print_r($params);
                 DB::executeProcedure('OVERTIME.ot_calculation_process', $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "o_status_code" => 999, "o_status_message" => $e->getMessage()];
        }
        return $params;
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
