<?php

namespace App\Http\Controllers\Api\V1\Overtime;

use App\Entities\Admin\LDptSection;
use App\Entities\Pmis\Employee\Employee;
use App\Http\Controllers\Controller;
use App\Contracts\Admin\AdminContract;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Contracts\Pmis\Employee\EmployeeContract;
use SebastianBergmann\Environment\Console;

use App\Entities\Overtime\OtMonthsDetail;
//use App\Entities\Overtime\OtRosterGroup;


class OtMonthsDetailsController extends Controller
{
    public function __construct(AdminContract $adminManager)
    {
        // Dependency injection
        $this->adminManager = $adminManager;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return $this->getPreloadInfo();
    }
    public function sectionByDepartment($id){
        $employee = new Employee();
        $employee = $employee->find(Auth()->user()->emp_id);
        if ($employee->section_id && !Auth::user()->hasRole('admin')){
//            $sections = LDptSection::where('dpt_section_id',$employee->section_id)->get();
            $sections = LDptSection::where('department_id', $id)->get();
        }else{
            $sections = LDptSection::where('department_id', $id)->get();
        }
        return $sections;
    }
    public function getPreloadInfo(){
        return [
             "otRosterMonthsList"   => $this->otRosterMonthsList(),
             "departmentList"       => $this->departmentList(),
             "divisionList"         => $this->divisionList(),
             "sectionList"          => $this->sectionList()

        ];
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function load_data(Request $request){

        $query = "select ROWNUM rn,
         OT_MONTH_DETAIL_ID,
         to_char(effective_start_date,'yyyy-mm-dd') effective_start_date,
         to_char(effective_end_date,'yyyy-mm-dd') effective_end_date,
         APPROVAL_STATUS
        from OT_MONTHS_DETAIL
        Where OT_MONTH_ID is not null and (APPROVAL_STATUS is null or APPROVAL_STATUS = 0) ";

            if($request){
                $ot_month_idWithMonthNumber    = $request->get("ot_month_id");
                $department     = $request->get("department_id");
                $division_id    = $request->get("division_id");
                $section        = $request->get("section_id");

                $ot_month_idWithMonthNumberArray = explode('#',$ot_month_idWithMonthNumber);
                $ot_month_id = $ot_month_idWithMonthNumberArray[0];
                $ot_month    = $ot_month_idWithMonthNumberArray[1];


                if($ot_month_id){
                    $query .= " and OT_MONTHS_DETAIL.OT_MONTH_ID = '".$ot_month_id."' ";
                }

                if($department){
                    $query .= " and OT_MONTHS_DETAIL.DPT_DEPARTMENT_ID = '".$department."' ";
                }

                if($division_id){
                    $query .= " and OT_MONTHS_DETAIL.DIVISION_ID = '".$division_id."' ";
                }

                if($section){
                    $query .= " and OT_MONTHS_DETAIL.SECTION_ID         = '".$section."' ";
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
            $query = "select rownum rn,
                    ot_month_detail_id,
                    to_char(effective_start_date,'yyyy-mm-dd') effective_start_date,
                    to_char(effective_end_date,'yyyy-mm-dd') effective_end_date,
                    approval_status, department_name
                    from ot_months_detail omd
                    left join l_department ld on ld.department_id = omd.department_id
                    where
                    omd.ot_month_id is not null
                    and (approval_status is null or approval_status = 0) ";

                        if($request){
                            $ot_month_idWithMonthNumber    = $request->get("ot_month_id");
                            $department     = $request->get("department_id");
                            $division_id    = $request->get("division_id");
                            $section        = $request->get("section_id");

                            $ot_month_idWithMonthNumberArray = explode('#',$ot_month_idWithMonthNumber);
                            $ot_month_id = $ot_month_idWithMonthNumberArray[0];
                            $ot_month    = $ot_month_idWithMonthNumberArray[1];

                            if($ot_month_id){
                                $query .= " and omd.OT_MONTH_ID = '".$ot_month_id."' ";
                            }

                            if($department){
                                $query .= " and omd.DEPARTMENT_ID = '".$department."' ";
                            }

                            if($division_id){
                                $query .= " and omd.DIVISION_ID = '".$division_id."' ";
                            }

                            if($section){
                                $query .= " and omd.SECTION_ID         = '".$section."' ";
                            }

                        }

                        $query .= "  order by department_name,EFFECTIVE_START_DATE,EFFECTIVE_END_DATE asc";
                        $data = DB::select($query);
            return [
                "status" => true,
                "table_info"    => $data
            ];

        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            try {
                //$m_emp_id = $request->get("emp_id");
                $ot_month_idWithMonthNumber    = $request->get("ot_month_id");

                $ot_month_idWithMonthNumberArray = explode('#',$ot_month_idWithMonthNumber);
                $ot_month_id = $ot_month_idWithMonthNumberArray[0];
                $ot_month    = $ot_month_idWithMonthNumberArray[1];

                $start_date = date("Y-m-d", strtotime($request->get("fromDate")));
                $end_date  = date("Y-m-d", strtotime($request->get("endDate")));

                $start_month = date("m", strtotime($request->get("fromDate")));
                $end_month  = date("m", strtotime($request->get("endDate")));

                if(($ot_month != $start_month) || ($ot_month != $end_month)){
                    $params['o_status_message'] = "Roster Month must be same with ".$start_date." and ".$end_date;
                    return [ "exception" => true, "status" => false, "params"=>$params];
                }

                $p_ot_month_detail_id = '';
                $statusCode = sprintf("%4000s", "");
                $statusMessage = sprintf('%4000s', '');
                $params = [
                "p_ot_month_detail_id" => [
                    "value" => &$p_ot_month_detail_id,
                    "type" => \PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                "p_ot_month_id" => $ot_month_id,
                "p_pr_month" => $ot_month, //$request->get("pr_month"),
                "p_division_id" => $request->get("division_id"),
                "p_department_id" => $request->get("department_id"),
                "p_section_id" => $request->get("section_id"),
                "p_effective_start_date" => $start_date,
                "p_effective_end_date" => $end_date,
                "p_insert_by" => Auth()->ID(),
                "o_status_code" => &$statusCode,
                "o_status_message" => &$statusMessage,
                ];


                DB::executeProcedure("OVERTIME.OT_MONTH_DETAIL_ENTRY", $params);
                return ["params"=>$params];// ["table_info" => $this->load_ot_tmp_data(),  "params" =>$params]; //
            }
            catch (\Exception $e) {
                $params['o_status_message'] = $e->getMessage();
                return [ "params"=>$params,"exception" => true, "status" => false]; //"table_info" => $this->load_ot_tmp_data(),
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove($id)
    {
             if($id){

                $monthDetailId = DB::select("select count(ot_month_detail_id) hw_many from ot_roster_details
                where ot_month_detail_id = '".$id."'");

                if($monthDetailId[0]->hw_many){
                    return [ "exception" => true, "status" => false, "message" => "This Data is already in use "];
                }else{
                    try {
                        if(DB::table('OT_MONTHS_DETAIL')->where('OT_MONTH_DETAIL_ID', $id)->delete()){

                            return [ "exception" => true, "status" => true, "message" => 'Remove succssfull'];
                        }
                    }
                    catch (\Exception $e) {
                        return [ "exception" => true, "status" => false, "message" => $e->getMessage()]; //"table_info" => $this->load_ot_tmp_data(),
                    }
                }

            }
    }

    public function otRosterMonths()
    {
        $query = "Select
         OT_MONTH_ID,
         OT_YEAR,
         OT_MONTH,
         to_char(effective_start_date,'yyyy-mm-dd') effective_start_date,
         to_char(effective_end_date,'yyyy-mm-dd') effective_end_date
        from OT_MONTHS
        Where CURRENT_YN = 'Y'
        and OPEN_YN = 'O' Order by OT_YEAR,OT_MONTH desc ";
        $data = DB::select($query);
        // $data =  DB::table('OT_MONTHS')
        //     ->select(
        //     'OT_MONTH_ID',
        //     'OT_YEAR',
        //     'OT_MONTH',
        //     "to_char(effective_start_date,'yyyy/mm/dd') effective_start_date",
        //     "to_char(effective_end_date,'yyyy/mm/dd') effective_end_date",
        //     )
        //     ->where('CURRENT_YN','=','Y')
        //     ->where('OPEN_YN','=','O')
        //     ->orderBy('OT_YEAR','desc')
        //     ->orderBy('OT_MONTH','desc')
        //     ->get();

        return $data;
    }

    private function otRosterMonthsList(){
        $otRosterMonthsList = [];
        $otRosterMonthsList[] = ["value" => null, 'text' => 'Select One'];
         foreach ($this->otRosterMonths() as $item) {
            $monthNum  = $item->ot_month;
            $monthName = date('F', mktime(0, 0, 0, $monthNum, 10));

            $otRosterMonthsList[] = [ "text" => $monthName.'/'.$item->ot_year, 'value'=> $item->ot_month_id.'#'.$item->ot_month.'#'.$item->ot_year.'#'.$item->effective_start_date.'#'.$item->effective_end_date];
        }
         return $otRosterMonthsList;
    }

    private function degType(){
        $degType = [];
        $degType[] = ["value" => null, 'text' => 'Select One'];
         foreach ($this->adminManager->findDesignations() as $item) {
            $degType[] = ["text" => $item->p_designation_id, 'value' => $item->p_designation];
        }
         return $degType;
    }

    private function divisionList(){
        $divisionList = [];
        $divisionList[] = ["value" => null, 'text' => 'Select One'];
         foreach ($this->adminManager->findDptDivisions() as $item) {
            $divisionList[] = ["text" => $item->dpt_division_name, 'value' => $item->dpt_division_id];
        }
         return $divisionList;
    }

    private function departmentList(){
        $departmentList = [];
        $departmentList[] = ["value" => null, 'text' => 'Select One'];
         foreach ($this->adminManager->findCurrentDepartments() as $item) {
            $departmentList[] = ["text" => $item->department_name, 'value' => $item->department_id];
        }
         return $departmentList;
    }
    private function sectionList(){
        $sectionList = [];
        $sectionList[] = ["value" => null, 'text' => 'Select One'];
         foreach ($this->adminManager->findDptSections() as $item) {
            $sectionList[] = ["text" => $item->dpt_section, 'value' => $item->dpt_section_id];
        }
         return $sectionList;
    }

    public function getEmpInfo(Request $request,$id, EmployeeContract $employeeManager){

        return[
            "empcodeList" => $employeeManager->otEmployeeOption($id)
        ];
    }


}
