<?php

namespace App\Http\Controllers\Api\V1\Leave;

use App\Contracts\Admin\AdminContract;
use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Leave\EmpLeaveTemp;
use App\Entities\Pmis\Employee\EmpEducationTemp;
use App\Entities\Pmis\Employee\EmpLeave;
use App\Entities\Pmis\Employee\Employee;
use App\Enums\Pmis\Employee\Statuses;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use App\Managers\Pmis\Employee\EmployeeManager;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;
use PhpParser\Node\Param;

class EmpLeaveTempController extends Controller
{

    protected $adminManager;

    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        //$leavedata = new EmpLeaveTemp();
        $adminManager = $this->adminManager;
       /* $approvedEmpCode = DB::table('employee')
            ->select('emp_code', 'emp_id');*/

        $sql = "SELECT *
  FROM (  SELECT ROWNUM RN,
                 E.EMP_CODE || ' ' || E.EMP_NAME AS OPTION_NAME,
                 E.EMP_NAME,
                 E.EMP_CODE,
                 ELT.*,
                 CODE.EMP_CODE AS APPROVE_EMP_CODE,
                 CODE.EMP_ID AS APPROVE_EMP_ID,
                 CODE.OPTION_NAME2 AS APPROVE_OPTION_NAME,
                 DPT.DEPARTMENT_NAME,
                 DG.DESIGNATION,
                 LT.LEAVE_TYPE
            FROM EMP_LEAVE_TEMP ELT
                 INNER JOIN EMPLOYEE E ON ELT.EMP_ID = E.EMP_ID
                 LEFT JOIN L_DEPARTMENT DPT
                    ON DPT.DEPARTMENT_ID = E.DPT_DEPARTMENT_ID
                 LEFT JOIN L_DESIGNATION DG
                    ON DG.DESIGNATION_ID = E.DESIGNATION_ID
                 LEFT JOIN L_LEAVE_TYPE LT
                    ON LT.LEAVE_TYPE_ID = ELT.LEAVE_TYPE_ID
                 LEFT JOIN
                 (SELECT EMP_CODE,
                         EMP_ID,
                         EMP_CODE || ' ' || EMP_NAME AS OPTION_NAME2
                    FROM EMPLOYEE) CODE
                    ON CODE.EMP_ID = ELT.APPROVE_BY_EMP_ID
        WHERE ELT.APPROVE_STATUS != 1
        ORDER BY ELT.INSERT_DATE DESC)";


        $prlSql = "SELECT *
  FROM (  SELECT ROWNUM RN,
                 E.EMP_CODE || ' ' || E.EMP_NAME AS OPTION_NAME,
                 E.EMP_NAME,
                 E.EMP_CODE,
                 ELT.*,
                 CODE.EMP_CODE AS APPROVE_EMP_CODE,
                 CODE.EMP_ID AS APPROVE_EMP_ID,
                 CODE.OPTION_NAME2 AS APPROVE_OPTION_NAME,
                 DPT.DEPARTMENT_NAME,
                 DG.DESIGNATION,
                 LT.LEAVE_TYPE
            FROM EMP_LEAVE_TEMP ELT
                 INNER JOIN EMPLOYEE E ON ELT.EMP_ID = E.EMP_ID
                 LEFT JOIN L_DEPARTMENT DPT
                    ON DPT.DEPARTMENT_ID = E.DPT_DEPARTMENT_ID
                 LEFT JOIN L_DESIGNATION DG
                    ON DG.DESIGNATION_ID = E.DESIGNATION_ID
                 LEFT JOIN L_LEAVE_TYPE LT
                    ON LT.LEAVE_TYPE_ID = ELT.LEAVE_TYPE_ID
                 LEFT JOIN
                 (SELECT EMP_CODE,
                         EMP_ID,
                         EMP_CODE || ' ' || EMP_NAME AS OPTION_NAME2
                    FROM EMPLOYEE) CODE
                    ON CODE.EMP_ID = ELT.APPROVE_BY_EMP_ID
           WHERE ELT.LEAVE_TYPE_ID = 11 AND ELT.APPROVE_STATUS != 1
        ORDER BY ELT.INSERT_DATE DESC)";
        $leavedata = DB::select($sql);
        $prlLeaveData=DB::select($prlSql);
        return [
            "leavetypes" => $adminManager->findLeaveWithoutPRL(),
            "prlLeaveTypes" => $adminManager->findLeaveWithPRL(),
            "data" => $leavedata,
            "prldata"=>$prlLeaveData];
    }


    public function departmentWiseLeave($department_id=null)
    {
        $dept_id = Auth::user()->employee->current_department_id;
//        $dpt_condition = \auth()->user()->user_name == 'admin'? '' : 'AND E.DPT_DEPARTMENT_ID = nvl('.$department_id.', E.DPT_DEPARTMENT_ID)';
        $dpt_condition = \auth()->user()->user_name == 'admin'? '' : 'AND E.CURRENT_DEPARTMENT_ID = nvl('.$dept_id.', E.CURRENT_DEPARTMENT_ID)';
        $adminManager = $this->adminManager;
        $sql = "SELECT *
  FROM (  SELECT ROWNUM RN,
                 E.EMP_CODE || ' ' || E.EMP_NAME AS OPTION_NAME,
                 E.EMP_NAME,
                 E.EMP_CODE,
                 ELT.*,
                 CODE.EMP_CODE AS APPROVE_EMP_CODE,
                 CODE.EMP_ID AS APPROVE_EMP_ID,
                 CODE.OPTION_NAME2 AS APPROVE_OPTION_NAME,
                 DPT.DEPARTMENT_NAME,
                 DG.DESIGNATION,
                 LT.LEAVE_TYPE
            FROM EMP_LEAVE_TEMP ELT
                 INNER JOIN EMPLOYEE E ON ELT.EMP_ID = E.EMP_ID
                 LEFT JOIN L_DEPARTMENT DPT
                    ON DPT.DEPARTMENT_ID = E.DPT_DEPARTMENT_ID
                 LEFT JOIN L_DESIGNATION DG
                    ON DG.DESIGNATION_ID = E.DESIGNATION_ID
                 LEFT JOIN L_LEAVE_TYPE LT
                    ON LT.LEAVE_TYPE_ID = ELT.LEAVE_TYPE_ID
                 LEFT JOIN
                 (SELECT EMP_CODE,
                         EMP_ID,
                         EMP_CODE || ' ' || EMP_NAME AS OPTION_NAME2
                    FROM EMPLOYEE) CODE
                    ON CODE.EMP_ID = ELT.APPROVE_BY_EMP_ID
        WHERE ELT.APPROVE_STATUS != 1 $dpt_condition
        ORDER BY ELT.INSERT_DATE DESC)";


        $prlSql = "SELECT *
  FROM (  SELECT ROWNUM RN,
                 E.EMP_CODE || ' ' || E.EMP_NAME AS OPTION_NAME,
                 E.EMP_NAME,
                 E.EMP_CODE,
                 ELT.*,
                 CODE.EMP_CODE AS APPROVE_EMP_CODE,
                 CODE.EMP_ID AS APPROVE_EMP_ID,
                 CODE.OPTION_NAME2 AS APPROVE_OPTION_NAME,
                 DPT.DEPARTMENT_NAME,
                 DG.DESIGNATION,
                 LT.LEAVE_TYPE
            FROM EMP_LEAVE_TEMP ELT
                 INNER JOIN EMPLOYEE E ON ELT.EMP_ID = E.EMP_ID
                 LEFT JOIN L_DEPARTMENT DPT
                    ON DPT.DEPARTMENT_ID = E.DPT_DEPARTMENT_ID
                 LEFT JOIN L_DESIGNATION DG
                    ON DG.DESIGNATION_ID = E.DESIGNATION_ID
                 LEFT JOIN L_LEAVE_TYPE LT
                    ON LT.LEAVE_TYPE_ID = ELT.LEAVE_TYPE_ID
                 LEFT JOIN
                 (SELECT EMP_CODE,
                         EMP_ID,
                         EMP_CODE || ' ' || EMP_NAME AS OPTION_NAME2
                    FROM EMPLOYEE) CODE
                    ON CODE.EMP_ID = ELT.APPROVE_BY_EMP_ID
           WHERE ELT.LEAVE_TYPE_ID = 11 AND ELT.APPROVE_STATUS != 1 $dpt_condition
        ORDER BY ELT.INSERT_DATE DESC)";
        $leavedata = DB::select($sql);
        $prlLeaveData=DB::select($prlSql);
        return [
            "leavetypes" => $adminManager->findLeaveWithoutPRL(),
            "prlLeaveTypes" => $adminManager->findLeaveWithPRL(),
            "data" => $leavedata,
            "prldata"=>$prlLeaveData];
    }



    public function oldLeaveData(){
        $sql = "SELECT *
  FROM (  SELECT ROWNUM RN,
                 E.EMP_CODE || ' ' || E.EMP_NAME AS OPTION_NAME,
                 E.EMP_NAME,
                 E.EMP_CODE,
                 ELT.*,
                 CODE.EMP_CODE AS APPROVE_EMP_CODE,
                 CODE.EMP_ID AS APPROVE_EMP_ID,
                 CODE.OPTION_NAME2 AS APPROVE_OPTION_NAME,
                 DPT.DEPARTMENT_NAME,
                 DG.DESIGNATION,
                 LT.LEAVE_TYPE
            FROM EMP_LEAVE_TEMP ELT
                 INNER JOIN EMPLOYEE E ON ELT.EMP_ID = E.EMP_ID
                 LEFT JOIN L_DEPARTMENT DPT
                    ON DPT.DEPARTMENT_ID = E.DPT_DEPARTMENT_ID
                 LEFT JOIN L_DESIGNATION DG
                    ON DG.DESIGNATION_ID = E.DESIGNATION_ID
                 LEFT JOIN L_LEAVE_TYPE LT
                    ON LT.LEAVE_TYPE_ID = ELT.LEAVE_TYPE_ID
                 LEFT JOIN
                 (SELECT EMP_CODE,
                         EMP_ID,
                         EMP_CODE || ' ' || EMP_NAME AS OPTION_NAME2
                    FROM EMPLOYEE) CODE
                    ON CODE.EMP_ID = ELT.APPROVE_BY_EMP_ID
        WHERE ELT.leave_reason = 'Old Data'
        ORDER BY ELT.INSERT_DATE DESC)";

        $leavedata = DB::select($sql);
        return $leavedata;
    }
    public function view(Request $request, $id)
    {
        $leavedata = new EmpLeaveTemp();
        $leavedata = $leavedata->find($id);
        $leavedata->employee;
        return $leavedata;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        if ($request->get("application_date") == null) {
            $application_date = '';
        } else {
            $application_date = date("Y-m-d", strtotime($request->get("application_date")));
        }
        if ($request->get("approve_date") == null) {
            $approve_date = '';
        } else {
            $approve_date = date("Y-m-d", strtotime($request->get("approve_date")));
        }
        if ($request->get("leave_start_date") == null) {
            $leave_start_date = '';
        } else {
            $leave_start_date = date("Y-m-d", strtotime($request->get("leave_start_date")));
        }
        if ($request->get("leave_end_date") == null) {
            $leave_end_date = '';
        } else {
            $leave_end_date = date("Y-m-d", strtotime($request->get("leave_end_date")));
        }
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_emp_id" => $request->get("emp_id")?$request->get("emp_id"):\auth()->user()->emp_id,
                "p_leave_type_id" => $request->get("leave_type_id"),
                "p_application_date" => $application_date,
                "p_approve_date" => $approve_date,
                "p_approve_by_emp_id" => $request->get("approve_by_emp_id"),
                "p_leave_start_date" => $leave_start_date,
                "p_leave_end_date" => $leave_end_date,
                "p_leave_days" => $request->get("leave_days"),
                "p_leave_id" => $request->get("leave_id"),
                "p_leave_approve_ref_no" => $request->get("leave_approve_ref_no"),
                "p_leave_reason" => $request->get("leave_reason"),
                "p_emergency_num" => $request->get("emergency_num"),
                "p_full_pay_yn" => $request->get("full_pay_yn"),
                "p_attachment" => [
                    'value' => $request->post('attachment'),
                    'type' => SQLT_CLOB,
                ],
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            //print_r ($params);
            //die();
            DB::executeProcedure("LEAVE.EMP_LEAVE_TEMP_INS", $params);
            if ($params['o_status_code'] == 99){
                DB::rollBack();
            }else{
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }

    public function update(Request $request)
    {

        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_emp_id" => $request->get("emp_id"),
                "p_leave_type_id" => $request->get("leave_type_id"),
                "p_application_date" => date("Y-m-d", strtotime($request->get("application_date"))),
                "p_approve_date" => date("Y-m-d", strtotime($request->get("approve_date"))),
                "p_approve_by_emp_id" => $request->get("approve_by_emp_id"),
                "p_leave_start_date" => date("Y-m-d", strtotime($request->get("leave_start_date"))),
                "p_leave_end_date" => date("Y-m-d", strtotime($request->get("leave_end_date"))),
                "p_leave_days" => $request->get("leave_days"),
                "p_leave_id" => $request->get("leave_id"),
                "p_leave_approve_ref_no" => $request->get("leave_approve_ref_no"),
                "p_leave_reason" => $request->get("leave_reason"),
                "p_emergency_num" => $request->get("emergency_num"),
                "p_full_pay_yn" => $request->get("full_pay_yn"),
                "p_attachment" => [
                    'value' => $request->post('attachment'),
                    'type' => SQLT_CLOB,
                ],
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];

            DB::executeProcedure("LEAVE.EMP_LEAVE_TEMP_INS", $params);
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }


    public function old_leave_entry(Request $request)
    {
        $leave_data = $request->all();

        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            foreach ($leave_data as $leave){
                $params = [
                    "p_leave_id" => $leave["leave_id"],
                    "p_emp_id" => $leave["emp_id"],
                    "p_leave_type_id" => $leave["leave_type_id"],
                    "p_leave_days" => $leave["leave_days"],
                    "p_leave_reason" => "Old Data",
                    "p_insert_by" => auth()->id(),
                    "o_status_code" => &$status_code,
                    "o_status_message" => &$status_message,
                ];
                DB::executeProcedure("old_leave_entry", $params);
            }

        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }

        return $params;
    }


    public function downloadAttachment($leave_id) {
        $leave = EmpLeaveTemp::find($leave_id);
        if($leave) {
            if($leave->attachment) {
                $content = $leave->attachment;
                $contentType = explode('/', mime_content_type($content))[1];
                $filename = "Leave-Attachment.pdf";
                /*$filename = $leave->attachment_filename;*/

                if (preg_match('/;base64,/', $content)) {
                    $content = substr($content, strpos($content, ',') + 1);
                    $content = base64_decode($content);
                }

                return response()->make($content, 200, [
                    'Content-Type' => $contentType,
                    'Content-Disposition' => 'attachment; filename="'.$filename.'"'
                ]);
            }
            die("No Attachment found!!");
        }
    }

    private $fileTypes = [
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'png' => 'image/png',
        'jpg' => 'image/jpg',
        'jpeg' => 'image/jpeg',
    ];

    private function getContentType($fileType)
    {
        $contentType = $this->fileTypes[$fileType];

        if($contentType) {
            return $contentType;
        }

        return '';
    }

    /*public  function getEmpInfo(Request $request,$id){
        $employee = new Employee();
        $emp = $employee->where('emp_id', $id)->first();
          //echo $emp->designation['designation'];
        //$emp->section->dpt_section;
        return [
             "empname" =>$emp->emp_name,
             "deptname"=>$emp->department->department_name,
             "designation"=>$emp->designation['designation'] ? $emp->designation['designation']  : ''
            ];
    }*/

    /**
     * @param Request $request
     * @param $id
     * @param EmployeeContract|EmployeeManager $employeeManager
     * @return array
     */
    public function getAttentDanceEmpInfo($id, $dpt=null)
    {

        $adminManager = $this->adminManager;
        $department_id = $dpt;
//        if(!Auth::user()->hasPermission('CAN_SEE_ALL_DEPARTMENT')){
//            $department_id = Auth::user()->employee->dpt_department_id;
//        }
        if(!Auth::user()->hasPermission('CAN_SEE_ALL_DEPARTMENT')){
            $department_id = Auth::user()->employee->current_department_id;
        }

        return [
            "empcodeList" => $this->employeeOptionWithAttendance($id, $department_id)
        ];
    }
    /**
     * @param Request $request
     * @param $id
     * @param EmployeeContract|EmployeeManager $employeeManager
     * @return array
     */
    public function getEmpInfo(Request $request, $id, $dpt=null, EmployeeContract $employeeManager)
    {
        $adminManager = $this->adminManager;
        $department_id = $dpt;
        if(!Auth::user()->hasPermission('CAN_SEE_ALL_DEPARTMENT')){
            $department_id = Auth::user()->employee->current_department_id;
        }
        return [
            "empcodeList" => $this->employeeOptionWithLeave($id, $department_id)
        ];
    }


    /**
     * Employee options, can be used wherever its needed.
     *
     * @param $search
     * $param $dpt
     * @return mixed
     */
    public function employeeOptionWithLeave($search, $dpt)
    {

        $employee = new Employee();
        $employee =  $employee->select('emp_id','emp_code',DB::raw("emp_code||' '||emp_name AS option_name"), DB::raw("trunc(((sysdate - to_date(to_char(EMP_JOIN_DATE, 'fmyyyy-mm-dd'), 'YYYY-MM-DD')))/365) as job_duration"),'emp_name','designation_id','dpt_department_id','section_id','bill_code','dpt_division_id')
           /* ->whereIn('employee.emp_status_id',[Statuses::ON_ROLL,Statuses::LEAVE]) *///Only on roll employee and leave employee
        ;
        if ($dpt != null){
            $employee = $employee->where('dpt_department_id','=', $dpt);
            return $employee->where(function($query) use ($search){
                $query->where(DB::raw('LOWER(emp_name)'),'like',strtolower('%'.trim($search).'%'))
                    ->orWhere('emp_code', 'like', '%'.trim($search)."%" );
            })->groupBy('emp_id','emp_code','emp_name','designation_id','dpt_department_id','section_id','bill_code','dpt_division_id','EMP_JOIN_DATE')
                ->get();
        }


        return $employee->where(function($query) use ($search){
            $query->where(DB::raw('LOWER(emp_name)'),'like',strtolower('%'.trim($search).'%'))
                ->orWhere('emp_code', 'like', '%'.trim($search)."%" );
        })->groupBy('emp_id','emp_code','emp_name','designation_id','dpt_department_id','section_id','bill_code','dpt_division_id','EMP_JOIN_DATE')
            ->take(20)
            ->get();

    }

    public function employeeOptionWithAttendance($search, $dpt)
    {

        $employee = new Employee();
        $employee =  $employee->select('emp_id','emp_code',DB::raw("emp_code||' '||emp_name AS option_name"), DB::raw("trunc(((sysdate - to_date(to_char(EMP_JOIN_DATE, 'fmyyyy-mm-dd'), 'YYYY-MM-DD')))/365) as job_duration"),'emp_name','designation_id','dpt_department_id','section_id','bill_code','dpt_division_id','current_department_id')
            ->whereIn('employee.emp_status_id',[Statuses::ON_ROLL,Statuses::LEAVE,Statuses::DEPUTATION,]) //Only on roll employee and leave employee
        ;
        if ($dpt){
            $employee = $employee->where('current_department_id','=', $dpt);
        }


        return $employee->where(function($query) use ($search){
            $query->where(DB::raw('LOWER(emp_name)'),'like',strtolower('%'.trim($search).'%'))
                ->orWhere('emp_code', 'like', '%'.trim($search)."%" );
        })->groupBy('emp_id','emp_code','emp_name','designation_id','dpt_department_id','section_id','bill_code','dpt_division_id','EMP_JOIN_DATE','current_department_id')
            ->limit(20)
            ->get();

    }


    /**
     * Employee options, can be used wherever its needed.
     *
     * @param $search
     * $param $dpt
     * @return mixed
     */
    public function employeeOption($search, $dpt)
    {
        $employee = new Employee();
        $employee =  $employee->select('emp_id','emp_code',DB::raw("emp_code||' '||emp_name AS option_name"), DB::raw("trunc(((sysdate - to_date(to_char(EMP_JOIN_DATE, 'fmyyyy-mm-dd'), 'YYYY-MM-DD')))/365) as job_duration"),'emp_name','designation_id','dpt_department_id','section_id','bill_code','dpt_division_id')
            ->where('employee.emp_status_id','=', Statuses::ON_ROLL) //Only on roll employee
            ;
        if ($dpt)
            $employee = $employee->where('dpt_department_id','=', $dpt);

           return $employee->where(function($query) use ($search){
                $query->where(DB::raw('LOWER(emp_name)'),'like',strtolower('%'.trim($search).'%'))
                    ->orWhere('emp_code', 'like', '%'.trim($search)."%" );
        })->groupBy('emp_id','emp_code','emp_name','designation_id','dpt_department_id','section_id','bill_code','dpt_division_id','EMP_JOIN_DATE')
        ->limit(20)
        ->get();


    }



}
