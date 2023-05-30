<?php

namespace App\Http\Controllers\Api\V1\Overtime;

use App\Entities\Overtime\OtDisburseVU;
use App\Http\Controllers\Controller;
use App\Contracts\Admin\AdminContract;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Contracts\Pmis\Employee\EmployeeContract;
use SebastianBergmann\Environment\Console;
use Illuminate\Contracts\Auth\Guard;
use Yajra\Pdo\Oci8\Exceptions\Oci8Exception;

class OtRegisterController extends Controller
{
    public function __construct(AdminContract $adminManager)
    {
        // Dependency injection
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        //die(__CLASS__.'::index');
        //TODO: Default template for action.
        return $this->getPreloadInfo();
    }
    public function disbursement(Request $request)
    {
        return ["status" => false, "data" => OtDisburseVU::all()];
    }

    public function disbursementStore(Request $request){
        $disbursementAllData = ($request->post());
        // dd($disbursementAllData['items']);
        $counter = 0;
        if($disbursementAllData){
            DB::beginTransaction();
            try {
                foreach ($disbursementAllData['items'] as $key=>$disbursementSingleData) {

                    $ot_month_id = $disbursementSingleData['ot_month_id'].' ';
                    $statusCode = sprintf("%4000s", "");
                    $statusMessage = sprintf('%4000s', '');
                    $params = [
                        "p_ot_month_id"  => $ot_month_id,
                        "p_bill_code"      =>  $disbursementSingleData["bill_code"],
                        "p_insert_by"      =>  Auth::id(),
                        'o_status_code'         => &$statusCode,
                        'o_status_message'      => &$statusMessage
                    ];
                    DB::executeProcedure('PMIS.overtime_disburse', $params);
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



    public function otDateFromGroup($id){
        $data = DB::select("SELECT effective_start_date AS fromDate,
       effective_end_date AS endDate
  FROM ot_group_mst gm, ot_months om
 WHERE gm.ot_month_id = om.ot_month_id AND gm.ot_group_id = :ot_group_id", ['ot_group_id' => $id]);
        return $data;
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
         foreach ($this->adminManager->findCurrentDepartments() as $item) {
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
            $otGroup_id = $request->get('otGroup_id');

            if(isset($registerApproval)){
                $query .= " and OT_REGISTER_TEMP.APPROVE_STATUS = '".$registerApproval."' ";
            }

            if($refNumSearch){
                $query .= " and OT_REGISTER_TEMP.REFERENCE_VALUE = '".$refNumSearch."' ";
            }

            if($otGroup_id){
                $query .= " and OT_REGISTER_TEMP.ot_group_id = '".$otGroup_id."' ";
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
         return [
             "unusedOtSlab" => ($resultUnusedOtSlab)
         ];
    }

    public function store(Request $request)
    {
        try {
            $ref_number = $request->get("ref_number");
            $p_ot_register_id = '';
            $statusCode = sprintf("%4000s", "");
            $statusMessage = sprintf('%4000s', '');
            $params = [
                "p_ot_register_id" => [
                    "value" => &$p_ot_register_id,
                    "type" => \PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                "p_emp_id"              => $request->get("m_emp_id"),
                "p_date_from"           => date("Y-m-d", strtotime($request->get("fromDate"))),
                "p_date_to"             => date("Y-m-d", strtotime($request->get("endDate"))),
                "p_register_hour"       => $request->get("m_ot_hour"),
                'p_off_hour'            => $request->get("m_ot_off_hour"),
                "p_remarks"             => $request->get("remarks"),
                "p_approve_status"      => $request->get("registerApproval"),
                "p_reference_value"     => $request->get("ref_number"),
                "p_reference_value_id"  => 12345,
                "p_insert_by"           => Auth()->ID(),
                'o_status_code'         => &$statusCode,
                'o_status_message'      => &$statusMessage
            ];

             DB::executeProcedure('OVERTIME.ot_register_temp_ins', $params);
             return $params;// ["table_info" => $this->load_ot_tmp_data(),  "params" =>$params]; //
        }
        catch (\Exception $e) {
            return [  "p_reference_value"=>$ref_number, "table_info" => $this->load_ot_tmp_data(),"exception" => true, "status" => false, "message" => $e->getMessage()];
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
        $dpt_id = $auth->user()->employee['current_department_id'];
        //dd($dpt_id);
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
}
