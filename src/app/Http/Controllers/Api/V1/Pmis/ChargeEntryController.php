<?php

namespace App\Http\Controllers\Api\V1\Pmis;

use App\Contracts\Admin\AdminContract;
use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Admin\LChargeType;
use App\Entities\Admin\LDepartment;
use App\Entities\Admin\LDesignation;
use App\Entities\Admin\LDptDivision;
use App\Entities\Admin\LDptSection;
use App\Entities\Admin\LEmpGrade;
use App\Entities\Pmis\Employee\ChargeEntry;
use App\Entities\Pmis\Employee\EmpFamilyTemp;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Security\Role;
use App\Entities\Security\User;
use App\Entities\Security\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChargeEntryController extends Controller
{
    private $adminManager;
    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {
        return $this->getPreloadInfo($request);
    }

    public function getPreloadInfo(Request $request){
        $LChargeType = new LChargeType();
        $charge = $LChargeType->get();
        $department = new LDepartment();
        if(Auth::user()->hasPermission('CAN_SEE_ONLY_SELF_DEPARTMENT') && !Auth::user()->hasRole('SUPER_ADMIN')) {
//            $department_id = Auth::user()->employee->dpt_department_id;
            $department_id = Auth::user()->employee->current_department_id;
            $department = $department->where('department_id','=', $department_id)->get();
        }else{
            $department = $department->orderBy('department_name')->get();
        }
        $section = new LDptSection();
        $section = $section->orderBy('dpt_section')->get();
        $designation = new LDesignation();
        $designation = $designation->orderBy('designation')->get();
        $division = new LDptDivision();
        $division = $division->orderBy('dpt_division_name')->get();
        $grade = new LEmpGrade();
        $grade = $grade->get();
        return [
            "charge" => $charge,
            "department" => $department,
            "section" => $section,
            "designation" => $designation,
            "division" => $division,
            "grade" => $grade
        ];
    }
    public function unapprovedInCharge(Request $request) {

        $department_id = Auth::user()->employee->dpt_department_id;

        if(Auth::user()->hasPermission('CAN_SEE_ONLY_SELF_DEPARTMENT') && !Auth::user()->hasRole('SUPER_ADMIN')) {
            $empId = $request->get('emp_id');
            $sql = "SELECT CE.*, E.EMP_NAME, E.EMP_CODE,CT.CHARGE_TYPE_NAME,
 case
       when CE.update_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=CE.update_by)
       when CE.insert_by is not null
           then (select e.emp_name from cpa_security.sec_users u inner join pmis.employee e on (e.emp_id=u.emp_id) where u.user_id=CE.insert_by)
       else '' end last_updated_by
FROM CHARGE_ENTRY CE
JOIN EMPLOYEE E ON CE.EMP_ID = E.EMP_ID
LEFT JOIN L_CHARGE_TYPE CT ON CE.CHARGE_TYPE_ID = CT.CHARGE_TYPE_ID
WHERE CE.EMP_ID = NVL(:EMPID, CE.EMP_ID)
AND (CE.APPROVED_YN='N' OR CE.APPROVED_YN IS NULL
AND E.DPT_DEPARTMENT_ID = $department_id)";
            return  $list = DB::select($sql, ['empId' => $empId]);
        }else {
            $empId = $request->get('emp_id');
            $sql = "SELECT CE.*, E.EMP_NAME, E.EMP_CODE,CT.CHARGE_TYPE_NAME
FROM CHARGE_ENTRY CE
JOIN EMPLOYEE E ON CE.EMP_ID = E.EMP_ID
LEFT JOIN L_CHARGE_TYPE CT ON CE.CHARGE_TYPE_ID = CT.CHARGE_TYPE_ID
WHERE CE.EMP_ID = NVL(:EMPID, CE.EMP_ID) AND (CE.APPROVED_YN='N' OR CE.APPROVED_YN IS NULL)";
            return  $list = DB::select($sql, ['empId' => $empId]);
//            dd($list);
        }
    }
    public function inChargeApproval(Request $request){
        DB::beginTransaction();
        try {
            foreach ($request->get('items') as $item) {
                $statusCode = sprintf('%20f', '');
                $statusMessage = sprintf('%4000s', '');
                $params = [
                    'p_emp_id' => $item['emp_id'],
                    'p_insert_by' => Auth::id(),
                    'o_status_code' => &$statusCode,
                    'o_status_message' => &$statusMessage
                ];

                DB::executeProcedure('emp_charge_entry_apv', $params);

                if($item['emp_id'] != null ){
                    $user_id = User::where('emp_id', $item['emp_id'])->value('user_id');
                    $user_notification = [
                        "p_notification_to" => $user_id,
                        "p_insert_by" => Auth::id(),
                        "p_note" => 'Your new charge has been approved.',
                        "p_priority" => null,
                        "p_module_id" => 1,
                        "p_target_url" => "pmis#/charge-entry"
                    ];
                    DB::executeProcedure("cpa_security.cpa_general.notify_add", $user_notification);
                }

                $insert_by = ChargeEntry::where('c_order_no', $item['c_order_no'])->value('insert_by');
                if($user_id != $insert_by){
                    $emp_name = Employee::where('emp_id', $item['emp_id'])->value('emp_name');
                    $operator_notification = [
                        "p_notification_to" => $insert_by,
                        "p_insert_by" => Auth::id(),
                        "p_note" => 'New charge approved for '.$emp_name.'.',
                        "p_priority" => null,
                        "p_module_id" => 1,
                        "p_target_url" => "pmis#/charge-entry"
                    ];
                    DB::executeProcedure("cpa_security.cpa_general.notify_add", $operator_notification);
                }


                if ($params['o_status_code'] == 1)
                    continue;
                else {
                    DB::rollBack();
                    return $params;
                }
            }

        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        DB::commit();
        return $params;
    }
    public function view(Request $request)
    {
        //TODO: Default template for action.
        $this->search_result($request);

    }
    public function search_result(Request $request)
    {
        try {
            return[
                "data" => $this->getChargeEntryList($request)
            ];
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
    }
    private function getChargeEntryList(Request $request)
    {
        $chargeOrderNumber = $request->get("c_order_no");
        $chargeType = $request->get("charge_type_id");
        $orderDate = $request->get("orderDate");
        $department = $request->get("department_id");
        $division = $request->get("division_id");
        $section    = $request->get("section_id");
        $designation = $request->get("degination_id");
        $grade    = $request->get("grade_id");
        $emp_id   = $request->get("emp_id");



        $charge_entry = new ChargeEntry();

        if ($chargeOrderNumber){
            $charge_entry = $charge_entry->where('c_order_no', $chargeOrderNumber);
        }
        if($chargeType){
            $charge_entry = $charge_entry->where('charge_type_id', $chargeType);
        }
        if($designation){
            $charge_entry = $charge_entry->whereHas('designation', function($q) use ($designation) {
                $q->where('designation_id', 'like', "%".$designation."%");
            })
            ->orWhereHas('charge_designation', function($q) use ($designation) {
                $q->where('designation_id', 'like', "%".$designation."%");
            });
        }
        if($orderDate){
            $charge_entry = $charge_entry->where('order_date', $orderDate);
        }
        if($division){
            $charge_entry = $charge_entry->whereHas('division', function($q) use ($division) {
                $q->where('dpt_division_id', 'like', "%".$division."%");
            })
                ->orWhereHas('charge_division', function($q) use ($division) {
                    $q->where('dpt_division_id', 'like', "%".$division."%");
                });
        }
        if($department){
            $charge_entry = $charge_entry->whereHas('department', function($q) use ($department) {
                $q->where('department_id', 'like', "%".$department."%");
            })
                ->orWhereHas('charge_department', function($q) use ($department) {
                    $q->where('department_id', 'like', "%".$department."%");
                });
        }
        if($section){
            $charge_entry = $charge_entry->whereHas('section', function($q) use ($section) {
                $q->where('dpt_section_id', 'like', "%".$section."%");
            })
                ->orWhereHas('charge_section', function($q) use ($section) {
                    $q->where('dpt_section_id', 'like', "%".$section."%");
                });
        }
        if($grade){
            $charge_entry = $charge_entry->whereHas('employee_grade', function($q) use ($grade) {
                $q->where('emp_grade_id', 'like', "%".$grade."%");
            })
                ->orWhereHas('charge_employeeGrade', function($q) use ($grade) {
                    $q->where('emp_grade_id', 'like', "%".$grade."%");
                });
        }
        if($emp_id){
            $charge_entry = $charge_entry->whereHas('employee', function($q) use ($emp_id) {
                $q->where('emp_id', 'like', "%".$emp_id."%");
            });

        }

        if ($request->get('filter') != 'null') {
            $charge_entry = $charge_entry
                ->where('charge_type_id', 'like', "%".$request->get('filter')."%")
                ->orWhereHas('employee', function($q) use ($request) {
                    if ($request->get('filter')) {
                        $q->where('emp_name', 'like', "%".$request->get('filter')."%")
                        ->orWhere('emp_code', 'like', "%".$request->get('filter')."%");
                    }
                });;
        }
//        $department_id = Auth::user()->employee->dpt_department_id;
        $department_id = Auth::user()->employee->current_department_id;
        if(Auth::user()->hasPermission('CAN_SEE_ONLY_SELF_DEPARTMENT') && !Auth::user()->hasRole('SUPER_ADMIN')) {
            $charge_entry = $charge_entry->where('dpt_department_id', $department_id)
                            ->paginate($request->get('size'));
            return $charge_entry;
        }else {
            $charge_entry = $charge_entry->paginate($request->get('size'));
            return $charge_entry;
        }
    }
    public function store(Request $request)
    {
         try {
            $statusCode = sprintf("%4000s", "");
            $statusMessage = sprintf('%4000s', '');
            $params = [
                "p_charge_entry_id"=> $request->get('charge_entry_id'),
                "p_c_order_no" => $request->get("c_order_no"),
                "p_emp_id" => $request->get("emp_id"),
                "p_emp_code" => $request->get("emp_code"),
                "p_order_date" => $request->get("order_date"),
                "p_charge_type_id" => $request->get("charge_type_id"),
                "p_description" => $request->get("description"),
                "p_charge_activation_date" => $request->get("charge_activation_date"),
                "p_charge_end_date" => $request->get("charge_end_date"),
                "p_approved_yn" => $request->get("approved_yn"),
                "p_additional_charge_detail" => $request->get("additional_charge_details"),
                "p_charge_dpt_division_id" => $request->get("charge_dpt_division_id"),
                "p_charge_dpt_department_id" => $request->get("charge_dpt_department_id"),
                "p_charge_section_id" => $request->get("charge_section_id"),
                "p_charge_emp_grade_id" => $request->get("charge_emp_grade_id"),
                "p_charge_designation_id" => $request->get("charge_designation_id"),
                "p_insert_by" => auth()->id(),
                "p_files" => [
                    'value' => $request->get('files'),
                    'type' => SQLT_CLOB,
                ],
                "p_filename" => $request->get("filename"),
                "p_file_type" => $request->get("file_type"),
                "o_status_code" => &$statusCode,
                "o_status_message" => &$statusMessage
            ];
            //return ($params);
             DB::executeProcedure('employees.emp_charge_entry', $params);

             if($request->get("emp_id") != null ){
                 $user_id = User::where('emp_id', $request->get("emp_id"))->value('user_id');
                 $user_notification = [
                     "p_notification_to" => $user_id,
                     "p_insert_by" => Auth::id(),
                     "p_note" => 'Your new charge has been sent for approval.',
                     "p_priority" => null,
                     "p_module_id" => 1,
                     "p_target_url" => "pmis#/charge-entry"
                 ];
                 DB::executeProcedure("cpa_security.cpa_general.notify_add", $user_notification);
             }



             $role_id = Role::where('role_key', 'Incharge_Approval')->value('role_id');
             $user_roles = UserRole::where('role_id', $role_id)->get();
             $emp_name = Employee::where('emp_id', $request->get("emp_id"))->value('emp_name');
             foreach ($user_roles as $user_role){
                 $operator_notification = [
                     "p_notification_to" => $user_role->user_id,
                     "p_insert_by" => Auth::id(),
                     "p_note" => 'New charge for '.$emp_name.'. Your approval require.',
                     "p_priority" => null,
                     "p_module_id" => 1,
                     "p_target_url" => "pmis#/inCharge-approval"
                 ];
                 DB::executeProcedure("cpa_security.cpa_general.notify_add", $operator_notification);
             }
        }
        catch (\Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
        return $params;
    }

    public function specific(Request $request,$id)
    {
        $cahargeEntry = new ChargeEntry();
        $cahargeEntry = $cahargeEntry->with('employee')->where('charge_entry.c_order_no',$id)->get();
        return[
            "data" => $cahargeEntry[0]
        ];
    }
    public function update(Request $request)
    {
        //TODO: Default template for action.

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
    public function getEmpInfo(Request $request,$id, EmployeeContract $employeeManager){

        return[
            "empcodeList" => $employeeManager->chargeBaseEmployeeOption($id)
        ];
    }
}
