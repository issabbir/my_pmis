<?php

namespace App\Http\Controllers\Api\V1\Overtime;

use App\Contracts\Overtime\OvertimeContract;
use App\Entities\Admin\LRosterShift;
use App\Entities\Overtime\OtGroupMst;
use App\Entities\Overtime\OtMonths;
use App\Entities\Overtime\OtMonthsDetail;
use App\Entities\Overtime\OtRosterDetails;
use App\Http\Controllers\Controller;
use App\Contracts\Admin\AdminContract;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Contracts\Pmis\Employee\EmployeeContract;
use SebastianBergmann\Environment\Console;
use Illuminate\Contracts\Auth\Guard;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class OtGroupRegisterController extends Controller
{
    protected $adminManager;
    protected $overtimeManager;

    public function __construct(AdminContract $adminManager, OvertimeContract $overtimeManager)
    {
        // Dependency injection
        $this->adminManager = $adminManager;
        $this->overtimeManager = $overtimeManager;
    }

    public function index(Request $request)
    {
        //die(__CLASS__.'::index');
        //TODO: Default template for action.
        return $this->getPreloadInfo();
    }
    public function getOtRegTempPreData(){
        $data =  DB::table('OT_REGISTER_TEMP')
            ->select(
            'OT_REGISTER_TEMP.EMP_CODE',
            'OT_REGISTER_TEMP.EMP_NAME',
            'OT_REGISTER_TEMP.DESIGNATION_ID',
            'OT_REGISTER_TEMP.DPT_DIVISION_ID',
            'OT_REGISTER_TEMP.SECTION_ID',
            'OT_REGISTER_TEMP.DATE_FROM',
            'OT_REGISTER_TEMP.DATE_TO',
            'OT_REGISTER_TEMP.REGISTER_HOUR'
            )
            ->orderBy('OT_REGISTER_TEMP.DATE_FROM','desc')
            ->get();
        return $data;
    }

    public function getPreloadInfo(){
        $data = $this->getOtRegTempPreData();
        return [
             //"degType"          => $this->degType(),
             "departmentList"   => $this->departmentList(),
             "sectionList"      => $this->sectionList(),
             // "professionType"=> $this->professionType(),
             "table_info"    => $data //->all()
        ];
    }
    private function degType(){
        $degType = [];
        $degType[] = ["value" => null, 'text' => 'Select Post'];
         foreach ($this->adminManager->findDesignations() as $item) {
            $degType[] = ["text" => $item->p_designation_id, 'value' => $item->p_designation];
        }
         return $degType;
    }
    private function departmentList(){
        $departmentList = [];
        $departmentList[] = ["value" => null, 'text' => 'Select Post'];
         foreach ($this->adminManager->findDepartments() as $item) {
            $departmentList[] = ["text" => $item->department_name, 'value' => $item->department_id];
        }
         return $departmentList;
    }
    private function sectionList(){
        $sectionList = [];
        $sectionList[] = ["value" => null, 'text' => 'Select Post'];
         foreach ($this->adminManager->findDptSections() as $item) {
            $sectionList[] = ["text" => $item->dpt_section, 'value' => $item->dpt_section_id];
        }
         return $sectionList;
    }
    public function view(Request $request,$id)
    {
        try {
            if($id){
                $query = "select ROWNUM rn,
                ot_register_dtl.EMP_CODE,
                ot_register_dtl.EMP_NAME,
                ot_register_dtl.emp_id,
                ot_register_dtl.roster_date ,
                overtime.time_duration (ot_register_dtl.in_time, ot_register_dtl.out_time, 'T') as ot_hour,
                TO_CHAR (ot_register_dtl.in_time,  'YYYY/MM/DD') only_start_date,
                TO_CHAR (ot_register_dtl.out_time+1,  'YYYY/MM/DD') only_end_date,
                ot_register_dtl.in_time ot_start_time,
                ot_register_dtl.out_time ot_end_time,
                ot_register_dtl.holiday_yn,
                ot_register_dtl.off_day_yn,
                ot_register_dtl.ot_register_id,
                ot_register_dtl.ot_register_dtl_id
                from ot_register_dtl
                where ot_register_dtl.ot_register_id = '".$id."' ";
            }
            //TO_CHAR (ot_register_dtl.out_time, 'HH24') ot_end_time

            $data = DB::select($query);
            return [
                "status" => true,
                "table_info"    => $data //->all()
            ];

        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
    }

    public function load_ot_tmp_data(Request $request = null){

        $query = "select ROWNUM rn,
        OT_REGISTER_TEMP.EMP_CODE,
        OT_REGISTER_TEMP.EMP_NAME,
        L_DESIGNATION.DESIGNATION,
        OT_REGISTER_TEMP.DESIGNATION_ID,

        L_DEPARTMENT.DEPARTMENT_NAME,
        L_DPT_SECTION.DPT_SECTION,
        OT_REGISTER_TEMP.DPT_DIVISION_ID,
        OT_REGISTER_TEMP.SECTION_ID,
        OT_REGISTER_TEMP.DATE_FROM,
        OT_REGISTER_TEMP.DATE_TO,
        OT_REGISTER_TEMP.REGISTER_HOUR,
        OT_REGISTER_TEMP.APPROVE_STATUS,
        OT_REGISTER_TEMP.OT_REGISTER_ID,
        OT_REGISTER_TEMP.remarks,
        OT_REGISTER_TEMP.EMP_ID

         from OT_REGISTER_TEMP

        left join L_DEPARTMENT on L_DEPARTMENT.DEPARTMENT_ID = OT_REGISTER_TEMP.DPT_DEPARTMENT_ID
        left join L_DESIGNATION on L_DESIGNATION.DESIGNATION_ID = OT_REGISTER_TEMP.DESIGNATION_ID
        left join L_DPT_SECTION on L_DPT_SECTION.DPT_SECTION_ID = OT_REGISTER_TEMP.SECTION_ID
        Where EMP_CODE is not null ";
        //and (APPROVE_STATUS is null or APPROVE_STATUS = 0)
            if($request){
                $department = $request->get("department_id");
                $section    = $request->get("section_id");
                $fromDate   = ($request->get("fromDate") ? date("Y-m-d", strtotime($request->get("fromDate"))) : '');
                $endDate    = ($request->get("endDate") ? date("Y-m-d", strtotime($request->get("endDate"))) : '');
                $emp_id   = $request->get("emp_id");

                $refNumSearch = $request->get('ref_number');
                $registerApproval = $request->get('registerApproval');

                if($emp_id){
                    $query .= " and OT_REGISTER_TEMP.EMP_ID = '".$emp_id."' ";
                }

                if(isset($registerApproval)){
                    $query .= " and OT_REGISTER_TEMP.APPROVE_STATUS = '".$registerApproval."' ";
                }
                if($refNumSearch){
                    $query .= " and OT_REGISTER_TEMP.REFERENCE_VALUE = '".$refNumSearch."' ";
                }

                if($department){
                    $query .= " and OT_REGISTER_TEMP.DPT_DEPARTMENT_ID = '".$department."' ";
                }
                if($section){
                    $query .= " and OT_REGISTER_TEMP.SECTION_ID         = '".$section."' ";
                 }
                if(!empty($fromDate) && empty($endDate)){
                    $query .= " and OT_REGISTER_TEMP.DATE_FROM  = TO_DATE('".$fromDate."', 'YYYY/MM/DD') ";
                }
                else if(empty($fromDate) && !empty($endDate)){
                    $query .= " and OT_REGISTER_TEMP.DATE_TO  = TO_DATE('".$endDate."', 'YYYY/MM/DD') " ;
                }
                elseif(!empty($fromDate) && !empty($endDate)){
                    $query .= " and OT_REGISTER_TEMP.DATE_FROM  >= TO_DATE('".$fromDate."', 'YYYY/MM/DD')
                    and OT_REGISTER_TEMP.DATE_TO <= TO_DATE('".$endDate."', 'YYYY/MM/DD')";
                }

            }

            $query .= " ";

            // L_DPT_DIVISION.DPT_DIVISION_NAME,
            // left join L_DPT_DIVISION on L_DPT_DIVISION.DPT_DIVISION_ID = OT_REGISTER_TEMP.DPT_DIVISION_ID
            // $query .= " OT_REGISTER_TEMP.DPT_DIVISION_ID = '".$department."' ";

            return DB::select($query);
    }

    public function search_result(Request $request)
    {
        try {

            $query = "select ROWNUM rn,
            OT_REGISTER_TEMP.EMP_CODE,
            OT_REGISTER_TEMP.EMP_NAME,
            L_DESIGNATION.DESIGNATION,
            OT_REGISTER_TEMP.DESIGNATION_ID,

            L_DEPARTMENT.DEPARTMENT_NAME,
            L_DPT_SECTION.DPT_SECTION,
            OT_REGISTER_TEMP.DPT_DIVISION_ID,
            OT_REGISTER_TEMP.SECTION_ID,
            OT_REGISTER_TEMP.DATE_FROM,
            OT_REGISTER_TEMP.DATE_TO,
            OT_REGISTER_TEMP.REGISTER_HOUR,
            OT_REGISTER_TEMP.APPROVE_STATUS,
            OT_REGISTER_TEMP.OT_REGISTER_ID,
            OT_REGISTER_TEMP.remarks,
            OT_REGISTER_TEMP.EMP_ID,
            OT_REGISTER_TEMP.REFERENCE_VALUE

            from OT_REGISTER_TEMP

            left join L_DEPARTMENT on L_DEPARTMENT.DEPARTMENT_ID = OT_REGISTER_TEMP.DPT_DEPARTMENT_ID
            left join L_DESIGNATION on L_DESIGNATION.DESIGNATION_ID = OT_REGISTER_TEMP.DESIGNATION_ID
            left join L_DPT_SECTION on L_DPT_SECTION.DPT_SECTION_ID = OT_REGISTER_TEMP.SECTION_ID
            left join OT_MONTHS on (OT_MONTHS.OT_MONTH_ID = OT_REGISTER_TEMP.OT_MONTH_ID)
            Where EMP_CODE is not null  ";
            //and (APPROVE_STATUS is null or APPROVE_STATUS = 0)
            $refNumSearch = $request->get('ref_number');
            $registerApproval = $request->get('registerApproval');

            if(isset($registerApproval)){
                $query .= " and OT_REGISTER_TEMP.APPROVE_STATUS = '".$registerApproval."' ";
            }

            if($refNumSearch){
                $query .= " and OT_REGISTER_TEMP.REFERENCE_VALUE = '".$refNumSearch."' ";
            }


            if($request){
                $department = $request->get("department_id");
                $section    = $request->get("section_id");
                $fromDate   = ($request->get("fromDate") ? date("Y-m-d", strtotime($request->get("fromDate"))) : '');
                $endDate    = ($request->get("endDate") ? date("Y-m-d", strtotime($request->get("endDate"))) : '');
                $emp_id   = $request->get("emp_id");

                if($emp_id){
                    $query .= " and OT_REGISTER_TEMP.EMP_ID = '".$emp_id."' ";
                }

                if($department){
                    $query .= " and OT_REGISTER_TEMP.DPT_DEPARTMENT_ID = '".$department."' ";
                }
                if($section){
                    $query .= " and OT_REGISTER_TEMP.SECTION_ID         = '".$section."' ";
                 }
                if(!empty($fromDate) && empty($endDate)){
                    $query .= " and OT_REGISTER_TEMP.DATE_FROM  = TO_DATE('".$fromDate."', 'YYYY/MM/DD') ";
                }
                else if(empty($fromDate) && !empty($endDate)){
                    $query .= " and OT_REGISTER_TEMP.DATE_TO  = TO_DATE('".$endDate."', 'YYYY/MM/DD') " ;
                }
                elseif(!empty($fromDate) && !empty($endDate)){
                    $query .= " and OT_REGISTER_TEMP.DATE_FROM  >= TO_DATE('".$fromDate."', 'YYYY/MM/DD')
                    and OT_REGISTER_TEMP.DATE_TO <= TO_DATE('".$endDate."', 'YYYY/MM/DD')";
                }
            }

            $query .= " and UPPER(OT_MONTHS.OPEN_YN)='O'";

            $data = DB::select($query);
            return [
                "status" => true,
                "table_info"    => $data //->all()
            ];

        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
    }

    public function calculate_ot_date(Request $request){

        $p_emp_id     = $request->get("m_emp_id");
        $p_daily_hour_off = $request->get("m_ot_off_hour")?:0;
        $p_daily_hour = $request->get("m_ot_hour")?:0;
        $p_date_from = date("Y-m-d", strtotime($request->get("fromDate")));
        $p_date_to = date("Y-m-d", strtotime($request->get("endDate")));
        $query = "Select overtime.ot_entry_hours(".$p_emp_id.",".$p_daily_hour.",".$p_daily_hour_off.",'".$p_date_from."','".$p_date_to."') as date_cal_culation_data from dual" ;
        return DB::select($query);
    }

    public function getUsedUnUsedSlab(Request $request,$id){
        $p_emp_id     = $id;
        $queryUnusedOtSlab = "Select emp_ot_reg_available_date(".$p_emp_id.") a from dual";
         $resultUnusedOtSlab =  DB::select($queryUnusedOtSlab);

         /*
         $queryUnusedOtSlab = "SELECT MIN (TRUNC(roster_date)) from_date, MAX(TRUNC(roster_date)) to_date
                    FROM ot_roster_group_dtl
                    WHERE emp_id = '".$id."'
                        AND roster_date >
                                (SELECT NVL (MAX (roster_date), TRUNC (SYSDATE) - 3650)
                                    FROM ot_register_dtl
                                    WHERE ot_register_dtl.emp_id = ot_roster_group_dtl.emp_id)";
         */
        //  foreach ($resultUnusedOtSlab as $item) {
        //     $from_date_arr = explode(' ',$item->from_date);
        //     $to_date_arr = explode(' ',$item->to_date);
        //     $resultUnusedOtSlabList[] = $from_date_arr[0].' to '.$to_date_arr[0];
        // } 1912011700022590
         return [
             "unusedOtSlab" => ($resultUnusedOtSlab)
         ];
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $success = false;
        try {
            $ref_number = $request->get("ref_number");
            foreach ($request->get('items') as $data){
                $p_ot_register_id = '';
                $statusCode = sprintf("%4000s", "");
                $statusMessage = sprintf('%4000s', '');
            $params = [
                "p_ot_register_id" => [
                    "value" => &$p_ot_register_id,
                    "type" => \PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                "p_emp_id"              => $data["emp_id"],
                "p_date_from"           => date("Y-m-d", strtotime($data["p_date_from"])),
                "p_date_to"             => date("Y-m-d", strtotime($data["p_date_to"])),
                "p_register_hour"       => $data["m_ot_hour"],
                'p_off_hour'            => $data["m_ot_off_hour"],
                "p_remarks"             => $data["remarks"],
                "p_approve_status"      => $data["registerApproval"],
                "p_reference_value"     => $data["ref_number"],
                "p_reference_value_id"  => 12345,
                "p_ot_group_id"            => $data["ot_group_id"],
                "p_insert_by"           => Auth()->ID(),
                'o_status_code'         => &$statusCode,
                'o_status_message'      => &$statusMessage
            ];

                DB::executeProcedure('OVERTIME.group_ot_register_temp_ins', $params);
                 // dd($params);
                if ($statusCode == 1){
                    DB::commit();
                    $success = true;
                }else{
                    DB::rollBack();
                    $success = false;
                }
            }
            if ($success){
                return ['data'=>$params,'o_status_code' => 1,"o_status_message" => 'All data Inserted Success'];
            }else{
                return [  "p_reference_value"=>$ref_number, "table_info" => $this->load_ot_tmp_data(),"exception" => true, "o_status_code" => false, "o_status_message" => $statusMessage];
            }
        }
        catch (\Exception $e) {
            DB::rollBack();
            return [  "p_reference_value"=>$ref_number, "table_info" => $this->load_ot_tmp_data(),"exception" => true, "o_status_code" => false, "o_status_message" => $e->getMessage()];
        }

    }
    public function ot_registers_details_update(Request $request){
        $registeredDateWiseAllData = ($request->post());
        $counter = 0;
        if($registeredDateWiseAllData){
            DB::beginTransaction();
            try {
                foreach ($registeredDateWiseAllData as $registeredDateWiseSingleData) {
                            $p_ot_register_id = $registeredDateWiseSingleData['ot_register_dtl_id'].' ';
                            $statusCode = sprintf("%4000s", "");
                            $statusMessage = sprintf('%4000s', '');

                            $params = [
                                "p_ot_register_dtl_id"  => $p_ot_register_id,
                                "p_in_time"             =>  date("Y-m-d H:i:s", strtotime($registeredDateWiseSingleData["ot_start_time"])),
                                "p_out_time"            =>  date("Y-m-d H:i:s", strtotime($registeredDateWiseSingleData["ot_end_time"])),
                                "p_remarks"             => 'test',
                                "p_update_by"           => Auth()->ID(),
                                'o_status_code'         => &$statusCode,
                                'o_status_message'      => &$statusMessage
                            ];
                        DB::executeProcedure('OVERTIME.ot_reg_detail_update', $params);
                        if ($params['o_status_code'] != 1) {
                            throw new Oci8Exception($params['o_status_message'], $params['o_status_code']);
                        }
                            //return $params;// ["table_info" => $this->load_ot_tmp_data(),  "params" =>$params]; //
                }
                $counter++;
                DB::commit();
            }
            catch (\Exception $e) {
               DB::rollback();
               return [ "exception" => true, "status" => false, "message" => $e->getMessage()];
            }

            if ($counter == 0) {
                $params['o_status_message'] = "No rows update!";
            } else {
                $params['o_status_message'] = "Successfully updated records!";
            }

        }
        return $params;
    }

    public function calculate_ot_datetime_diff(Request $request){

        // $p_date_from =  date("Y-m-d H:i:s", strtotime($request->startDateTime));
        // $p_date_to = date("Y-m-d H:i:s", strtotime($request->endDateTime));

         $p_date_from =  date("Y-m-d H:i:s", strtotime($request->ot_start_time));
         $p_date_to = date("Y-m-d H:i:s", strtotime($request->ot_end_time));
         $query = "Select overtime.time_duration('".$p_date_from."','".$p_date_to."','T') as date_diff_time from dual" ;
         $result =  DB::selectOne($query);
         return response()->json($result);

    }

    public function update(Request $request,$id)
    {
        //TODO: Default template for action.
        $params =[];
        try {
            //$m_emp_id = $request->get("emp_id");
            $p_ot_register_id = $request->get('ot_register_id');
            $statusCode = sprintf("%4000s", "");
            $statusMessage = sprintf('%4000s', '');
            $params = [
                "p_ot_register_id"      =>$p_ot_register_id ,
                "p_emp_id"              => $request->get("m_emp_id"),
                "p_date_from"           => date("Y-m-d", strtotime($request->get("fromDate"))),
                "p_date_to"             => date("Y-m-d", strtotime($request->get("endDate"))),
                "p_register_hour"       => $request->get("m_ot_hour"),
                'p_off_hour'            => $request->get("m_ot_off_hour"),
                "p_remarks"             => $request->get("remarks"),
                "p_approve_status"      => $request->get("registerApproval"),
                //"p_insert_by"           => '',
                "p_update_by"           => Auth()->ID(),
                'o_status_code'         => &$statusCode,
                'o_status_message'      => &$statusMessage
            ];
            DB::executeProcedure('OVERTIME.ot_register_entry_update', $params);
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
        return $params;

    }

    public function remove(Request $request)
    {
        //TODO: Default template for action.
    }

     /**
     * @param Request $request
     * @param $id
     * @param EmployeeContract|EmployeeManager $employeeManager
     * @return array
     */
    public function getUnRegisteredEmpInfo(Request $request,$id, EmployeeContract $employeeManager,Guard $auth){
        // loged user department id
        //$auth->user()->employee['dpt_department_id'];
        $dpt_id = $auth->user()->employee['dpt_department_id'];
        //$dpt_id = 4;
        return[
            "empcodeList" => $employeeManager->unRegisteredOtEmployeeOptionToEntryNewEmployee($id,$dpt_id)
        ];

    }

    /**
     * @param Request $request
     * @param $id
     * @param EmployeeContract|EmployeeManager $employeeManager
     * @return array
     */
    public function getRegisteredEmpInfo(Request $request,$id, EmployeeContract $employeeManager,Guard $auth){
        // loged user department id
        //$auth->user()->employee['dpt_department_id'];
        $dpt_id = $auth->user()->employee['dpt_department_id'];
        return[
            "empcodeList" => $employeeManager->otEmployeeOptionToSearchRegisteredEmployee($id,$dpt_id)
        ];

    }
        //otEmployeeOptionSameAsRoster($id)
        //employeeOption //otEmployeeOption
        //otEmployeeOption($id)
    public function otRosterGroups(Request $request)
    {
        $monthId = $request->get('month_id');
        $groupId = $request->get('group_id');
        $departmentId = $request->get('department_id');
        $shiftId = $request->get('shift_id');

//        $sql = <<<QUERY
//SELECT rg.ot_month AS ot_month,
//       rg.GROUP_ID AS GROUP_ID,
//       rg.emp_id,
//       rg.ot_group_id,
//       e.emp_name AS emp_name,
//       rg.department_id AS department_id,
//       ld.department_name AS department_name,
//       lds.dpt_section AS section_name,
//       rg.emp_code,
//       rg.off_day off_day
//  FROM ot_months om,
//       ot_roster_group rg
//       INNER JOIN employee e ON e.emp_id = rg.emp_id
//       LEFT JOIN l_department ld ON ld.department_id = rg.department_id
//       LEFT JOIN l_dpt_section lds ON lds.dpt_section_id = e.section_id
// WHERE     rg.ot_month_id = :ot_month_id
//       AND rg.ot_group_id = :GROUP_ID
//       AND rg.department_id = :department_id
//       AND om.ot_year = rg.ot_year
//       AND om.ot_month = rg.ot_month
//       AND om.open_yn = 'O'
//       AND rg.approve_yn = 'Y'
//       AND e.emp_type_id = 2
//       AND rg.ot_group_id IN
//              (SELECT DISTINCT GROUP_ID
//                 FROM ot_roster_details rd
//                WHERE     rd.ot_month_id = rg.ot_month_id
//                      AND rd.department_id = rg.department_id)
//       AND (e.emp_id, om.effective_start_date, om.effective_end_date) NOT IN
//              (  SELECT rt.emp_id, MIN (rt.date_from), MAX (rt.date_to)
//                   FROM ot_register_temp rt
//                  WHERE rt.ot_month_id = om.ot_month_id and e.dpt_department_id = rt.DPT_DEPARTMENT_ID AND rt.approve_status !=1
//               GROUP BY rt.emp_id)
//QUERY;
        $sql = <<<QUERY
 SELECT rg.ot_month            AS ot_month,
       rg.GROUP_ID            AS GROUP_ID,
       rg.emp_id,
       rg.ot_group_id,
       e.emp_name             AS emp_name,
       rg.department_id       AS department_id,
       ld.department_name     AS department_name,
       lds.dpt_section        AS section_name,
       rg.emp_code,
       rg.off_day             off_day,
       om.effective_start_date,
       om.effective_end_date
  FROM ot_months        om,
       ot_roster_group  rg
       INNER JOIN employee e ON e.emp_id = rg.emp_id
       LEFT JOIN l_department ld ON ld.department_id = rg.department_id
       LEFT JOIN l_dpt_section lds ON lds.dpt_section_id = e.section_id
 WHERE     rg.ot_month_id = :ot_month_id
       AND rg.ot_group_id = :group_id
       AND rg.department_id = :department_id
       AND om.ot_year = rg.ot_year
       AND om.ot_month = rg.ot_month
       AND om.open_yn = 'O'
       AND rg.approve_yn = 'Y'
       AND e.emp_type_id = 2
       AND rg.ot_group_id IN
               (SELECT DISTINCT GROUP_ID
                  FROM ot_roster_details rd
                 WHERE     rd.ot_month_id = rg.ot_month_id
                       AND rd.department_id = rg.department_id)
       AND (e.emp_id,
            TRUNC (om.effective_start_date),
            TRUNC (om.effective_end_date)) NOT IN
               (  SELECT rt.emp_id, MIN (rt.date_from), MAX (rt.date_to)
                    FROM ot_register_temp rt
                   WHERE     rt.ot_month_id = :ot_month_id
                         AND rt.DPT_DEPARTMENT_ID = :department_id
                         AND rt.approve_status = 1
                GROUP BY rt.emp_id)
QUERY;

        $rosterGroups =  DB::select($sql,
            [
                'ot_month_id' => $monthId,
                'group_id' => $groupId,
                'department_id' => $departmentId
            ]
        );

        /** FIXME: JUST TO GET THE SHIFT_ID I HAVE TO DO THIS AS QUICK FIX. Adding ot_month_detail_id in roster_detail table
         * as foreign key constrain and add condition, "AND rd.month_slab_id = md.ot_month_detail_id" may solve this issue!
         * ot_month_detail_id in roster_detail will contain month_slab_id from form.
         */
        if($rosterGroups){
            foreach($rosterGroups as $key => $rosterGroup) {
                $sql = <<<QUERY
SELECT
       rd.shift_id, md.effective_start_date, md.effective_end_date,rd.OT_MONTH_DETAIL_ID
  FROM ot_months om,
       ot_roster_group rg,
       employee e,
       ot_months_detail md,
       ot_roster_details rd
 WHERE md.ot_month_id = om.ot_month_id
       AND om.ot_year = rg.ot_year
       AND om.ot_month = rg.ot_month
       AND rg.emp_id = e.emp_id
       AND md.ot_month_id = om.ot_month_id
       AND e.current_department_id = :department_id
       AND e.emp_id = rd.emp_id
       AND om.open_yn = 'O'
       AND rd.emp_id = :emp_id
       AND rd.ot_month_detail_id = md.ot_month_detail_id
       AND rd.shift_id = :shift_id
QUERY;

                $rosterDetailData =  DB::selectOne($sql,
                    [
                        'emp_id' => $rosterGroup->emp_id,
                        'department_id' => $departmentId,
                        'shift_id' => $shiftId
                    ]
                );

                if($rosterDetailData) {
                    $shift = LRosterShift::find($rosterDetailData->shift_id);
                    $shift_name = $shift->shift_code. " ($shift->shift_start_time - $shift->shift_end_time)";
                    $rosterGroups[$key]->shift_name = $shift_name;
                    $effectiveStartDate = date('d-m-Y', strtotime($rosterDetailData->effective_start_date));
                    $effectiveEndDate = date('d-m-Y', strtotime($rosterDetailData->effective_end_date));


                    $rosterGroups[$key]->month_slab = "$effectiveStartDate - $effectiveEndDate";
                    $rosterGroups[$key]->month_slab_id = $rosterDetailData->ot_month_detail_id;

                } else {
                    $rosterGroups[$key]->shift_name = '';
                    $rosterGroups[$key]->month_slab = '';
                    $rosterGroups[$key]->month_slab_id = '';
                }
            }
        }

        $rosterDetails = OtRosterDetails::where(
            [
                ['ot_month_id', '=', $monthId],
                ['group_id', '=', $groupId],
                'department_id' => $departmentId
            ]
        )->distinct()->get([
            'ot_month_id',
            'ot_month_detail_id',
            'group_id',
            'shift_id',
        ]);

        $rosterDetailsArray = [];

        foreach($rosterDetails as $key => $rosterDetail) {
            $rosterGroup = OtGroupMst::find($rosterDetail->group_id);
            $rosterMonth = OtMonths::find($rosterDetail->ot_month_id);
            $rosterMonthDetail = OtMonthsDetail::find($rosterDetail->ot_month_detail_id);
            $shift = LRosterShift::find($rosterDetail->shift_id);

            $rosterDetailsArray[$key]['roster_id'] = $rosterDetail->roster_id;
            $rosterDetailsArray[$key]['roster_month'] = $rosterMonth ? $rosterMonth : '';
            $rosterDetailsArray[$key]['roster_group'] = $rosterGroup ? $rosterGroup : '';
            $rosterDetailsArray[$key]['ot_months_detail'] = $rosterMonthDetail ? $rosterMonthDetail : '';
            $rosterDetailsArray[$key]['shift'] = $shift ? $shift : '';
        }

        $monthSlabs = $this->overtimeManager->findMonthSlabs($monthId, $departmentId);

       // $p_emp_id     = $request->get("m_emp_id");
        if ($request->get("fromDate") && $request->get("endDate")){
            $p_daily_hour_off = $request->get("m_ot_off_hour")?:0;
            $p_daily_hour = $request->get("m_ot_hour")?:0;
            $p_date_from = date("Y-m-d", strtotime($request->get("fromDate")));
            $p_date_to = date("Y-m-d", strtotime($request->get("endDate")));
            $ref_number = $request->get("ref_number")?:0;
            $remarks = $request->get("remarks")?:0;
            $registerApproval = $request->get("registerApproval")?:0;
            foreach ($rosterGroups as $key=>$group){
                $query = "Select overtime.ot_entry_hours(".$group->emp_id.",".$p_daily_hour.",".$p_daily_hour_off.",'".$p_date_from."','".$p_date_to."') as date_cal_culation_data from dual" ;
                $data =  DB::selectOne($query);
                $rosterGroups[$key]->off_day_total_hour = $data->off_day_total_hour;
                $rosterGroups[$key]->reg_day_total_hour = $data->reg_day_total_hour;
                $rosterGroups[$key]->total_hour = $data->total_hour;
                $rosterGroups[$key]->p_date_from = $p_date_from;
                $rosterGroups[$key]->p_date_to = $p_date_to;
                $rosterGroups[$key]->ref_number = $ref_number;
                $rosterGroups[$key]->ref_number = $ref_number;
                $rosterGroups[$key]->remarks = $remarks;
                $rosterGroups[$key]->registerApproval = $registerApproval;
                $rosterGroups[$key]->m_ot_hour = $p_daily_hour;
                $rosterGroups[$key]->m_ot_off_hour = $p_daily_hour_off;
            }
        }
        //dd($rosterGroups);
        return [
            'roster_groups' => $rosterGroups,
            'roster_details' => $rosterDetailsArray,
            'month_slabs' => $monthSlabs
        ];
    }
}
