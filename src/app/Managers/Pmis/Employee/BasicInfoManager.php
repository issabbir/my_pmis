<?php
namespace App\Managers\Pmis\Employee;

use App\Contracts\Pmis\Employee\BasicInfoContract;

use App\Entities\Pmis\Employee\Employee;
use App\Entities\Security\Role;
use App\Entities\Security\UserRole;
use Exception;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;


/**
* Class  as a services to maintain some business logic with db operation
*
* @package App\Managers\Pmis\Employee
*/
class BasicInfoManager implements BasicInfoContract
{
    private $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function updateProfile(Request $request){
        $emp_id = Auth::user()->emp_id;
        try {
            $statusCode = sprintf('%20f', '');
            $statusMessage = sprintf('%4000s', '');

            $params = [
                'emp_id' => [
                    'value' => &$emp_id,
                    "type" => PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                'emp_name_bng' => $request->get('emp_name_bng'),
                'emp_father_name' => $request->get('emp_father_name'),
                'emp_father_name_bng' => $request->get('emp_father_name_bng'),
                'emp_mother_name' => $request->get('emp_mother_name'),
                'emp_mother_name_bng' => $request->get('emp_mother_name_bng'),
                'emp_gender_id' => $request->get('emp_gender_id'),
                'emp_religion_id' =>$request->get('emp_religion_id'),
                'emp_blood_group_id' => $request->get('emp_blood_group_id'),
                'emp_security_id' => $request->get('emp_security_id'),
                'emp_medical_book_id' => $request->get('emp_medical_book_id'),
                'identity_symbol' => $request->get('identity_symbol'),
                'identity_symbol_bng' => $request->get('identity_symbol_bng'),
                'emp_emergency_contact_name' => $request->get('emp_emergency_contact_name'),
                'emp_emergency_contact_mobile' => $request->get('emp_emergency_contact_mobile'),
                'emp_emergency_relation_id' => $request->get('emp_emergency_relation_id'),
                'emp_emergency_contact_addr' => $request->get('emp_emergency_contact_address'),
                'emp_maritial_status_id' => $request->get('emp_maritial_status_id'),
                'emp_religion_name' => $request->get('emp_religion_name'),
                'emp_religion_name_bng' =>$request->get('emp_religion_name_bng'),
                'emp_photo' => [
                    'value' => $request->post('emp_photo'),
                    'type' => SQLT_CLOB,
                ],
                'emp_photo_name' => $request->get('emp_photo_name'),
                'emp_photo_type' => $request->get('emp_photo_type'),
                'reporting_officer_id' => $request->get('reporting_officer_id'),
                'update_by' => Auth::id(),
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage,
            ];
            DB::executeProcedure('personal_profile_update', $params);
            if ($params['o_status_code'] == 1) {
                    $role_id = Role::where('role_key', 'PMIS APPROVAL')->value('role_id');
                    $user_roles = UserRole::where('role_id', $role_id)->get();
                    $emp_name = Employee::where('emp_id', $emp_id)->value('emp_name');
                    foreach ($user_roles as $user_role){
                        $operator_notification = [
                            "p_notification_to" => $user_role->user_id,
                            "p_insert_by" => Auth::id(),
                            "p_note" => $emp_name.' has updated basic information. Your approval require.',
                            "p_priority" => null,
                            "p_module_id" => 1,
                            "p_target_url" => "pmis#/employee-approval"
                        ];
                        DB::executeProcedure("cpa_security.cpa_general.notify_add", $operator_notification);
                    }
                return ['status' => true, 'o_status_code'=> 1, 'o_status_message' => 'Updated Successfully'];
            } else {
                return $params;
            }
        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        return $params;
    }


    public function addBasicInInfo(Request $request)
    {
        $salutation = $request->get('salutation_id');
        $gender = $request->get('emp_gender_id');
        $otCategory = $request->get('ot_category_id');
//      $religion = $request->get('emp_religion_id');
        $emp_blood_group = $request->get('emp_blood_group_id');

        try {
            $statusCode = sprintf('%20f', '');
            $empId = $request->get('emp_id') ?: '';
            $updateBasicInfo = ($empId > 0);
            $statusMessage = sprintf('%4000s', '');

            $emp_dob = $request->get('emp_dob') ? date("Y-m-d", strtotime($request->get('emp_dob'))) : '';
            $emp_join_date = $request->get('emp_join_date') ? date("Y-m-d", strtotime($request->get('emp_join_date'))) : '';
            $emp_lpr_date = $request->get('emp_lpr_date') ? date("Y-m-d", strtotime($request->get('emp_lpr_date'))) : '';
            $emp_confirmation_date = $request->get('emp_confirmation_date') ? date("Y-m-d", strtotime($request->get('emp_confirmation_date'))) : '';
            $emp_go_date = $request->get('emp_go_date') ? date("Y-m-d", strtotime($request->get('emp_go_date'))) : '';
            $emp_active_date = $request->get('emp_active_date') ? date("Y-m-d", strtotime($request->get('emp_active_date'))) : '';

            $params = [
                'emp_id' => [
                    'value' => &$empId,
                    "type" => PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                'emp_code' => $request->get('emp_code'),
                'salutation_id' =>($salutation && isset($salutation['salutation_id']))?$salutation['salutation_id']:'',
                'emp_name' => $request->get('emp_name'),
                'emp_name_bng' => $request->get('emp_name_bng'),
                'emp_father_name' => $request->get('emp_father_name'),
                'emp_father_name_bng' => $request->get('emp_father_name_bng'),
                'emp_mother_name' => $request->get('emp_mother_name'),
                'emp_mother_name_bng' => $request->get('emp_mother_name_bng'),

                'emp_dob' => $emp_dob,
                'emp_join_date' => $emp_join_date,
                'emp_lpr_date' => $emp_lpr_date,

                'emp_gender_id' => isset($gender)?$gender['gender_id']:'',
                'emp_religion_id' =>$request->get('emp_religion_id'),
                'emp_blood_group_id' => $request->get('emp_blood_group_id'),
                'emp_nationality_id' => $request->get('emp_nationality_id'),
                'emp_quota_id' => $request->get('emp_quota_id'),
                'emp_status_id' => $request->get('emp_status_id'),
                'emp_security_id' => $request->get('emp_security_id'),
                'emp_medical_book_id' => $request->get('emp_medical_book_id'),
                'identity_symbol' => $request->get('identity_symbol'),
                'identity_symbol_bng' => $request->get('identity_symbol_bng'),
                'emp_pf_id' => $request->get('emp_pf_id'),
                'emp_photo' => [
                    'value' => $request->post('emp_photo'),
                    'type' => SQLT_CLOB,
                ],

                'emp_confirmation_date' => $emp_confirmation_date,
                'emp_go_number' => $request->get('emp_go_number'),
                'emp_go_date' => $emp_go_date,

                'emp_bcs_batch_no' => $request->get('emp_bcs_batch_no'),
                'emp_grade_id' => $request->get('emp_grade_id'),
                'dpt_division_id' => $request->get('dpt_division_id'),
                'dpt_department_id' => $request->get('dpt_department_id'),
                'section_id' => $request->get('section_id'),
                'designation_id' => $request->get('designation_id'),
                'emp_class' => $request->get('emp_class'),
                'emp_type_id' => $request->get('emp_type_id'),
                'gpf_yn' => $request->get('gpf_yn'),
                'hbl_yn' => $request->get('hbl_yn'),
                'allowance_yn' => $request->get('allowance_yn'),
                'tax_yn' => $request->get('tax_yn'),
                'emp_maritial_status_id' => $request->get('emp_maritial_status_id'),
                'reporting_officer_id' => $request->get('reporting_officer_id'),
                'post_type_id' => $request->get('post_type_id'),
                'salutation' => $salutation ?$salutation['salutation'] : '',
                'emp_gender_name' => isset($gender)?$gender['gender_name']:'',
                'salutation_bng' => $salutation ?$salutation['salutation_bng']:'',
                'emp_gender_name_bng' => isset($gender)?$gender['gender_name_bng']:'',
                'emp_religion_name' => $request->get('emp_religion_name'),
                'previous_workplace' => $request->get('previous_workplace'),
                'previous_designation' => $request->get('previous_designation'),
                'previous_office_address' => $request->get('previous_office_address'),
                'ot_category_id' => isset($otCategory)?$otCategory['value']:'',
                'ot_category_name' => isset($otCategory)?$otCategory['text']:'',
                'emp_emergency_contact_name' => $request->get('emp_emergency_contact_name'),
                'emp_emergency_contact_mobile' => $request->get('emp_emergency_contact_mobile'),
                'emp_emergency_relation_id' => $request->get('emp_emergency_relation_id'),
                'emp_emergency_contact_add056' => $request->get('emp_emergency_contact_address'),
                'grade_step_id' => $request->get('grade_step_id'),
                'location_id' => $request->get('location_id'),
                'biller_code' => $request->get('biller_code'),
                'bill_code' => $request->get('bill_code'),
                'bank_id' => $request->get('bank_id'),
                'branch_id' => $request->get('branch_id'),
                'emp_bank_acc_no' => $request->get('emp_bank_acc_no'),
                'on_pension_yn' => $request->get('on_pension_yn'),
                'deceased_yn' => $request->get('deceased_yn'),
                'emp_active_yn' => $request->get('emp_active_yn'),
                'emp_active_date' => $emp_active_date,
                'emp_religion_name_bng' =>$request->get('emp_religion_name_bng'),
                'insert_by' => $this->auth->Id(),
                'update_by' => $this->auth->Id(),
                'emp_tin_no' => $request->get('emp_tin_no'),
                'appointment_type_id' => $request->get('appointment_type_id'),
                'nid_no' => $request->get('nid_no'),
                'tribal_yn' => $request->get('tribal_yn'),
                'approved_yn' => $request->get('approved_yn'),
                'emp_photo_name' => $request->get('emp_photo_name'),
                'emp_photo_type' => $request->get('emp_photo_type'),
                'auth_document' => [
                    'value' => $request->post('auth_document'),
                    'type' => SQLT_CLOB,
                ],
                'auth_document_name' => $request->get('auth_document_name'),
                'auth_document_type' => $request->get('auth_document_type'),
                'deputation_yn' => $request->get('deputation_yn'),
                'auth_doc_type_id' => $request->get('auth_doc_type_id'),
                'selection_grade_yn' => $request->get('selection_grade_yn'),
                'p_actual_grade_id' => $request->get('actual_grade_id'),
                'p_mobile_allowance' => $request->get('mobile_allowance'),
                'current_department_id' => $request->get('current_department_id'),
                'merit_position' => $request->get('merit_position'),
                'p_academic_yn' => $request->get('academic_yn'),
                'p_circular_number' => $request->get('p_circular_number'),
                'p_salary_process_type' => $request->get('salary_process_type'),
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage,
            ];

            DB::executeProcedure('employees.create_new_basicinfo', $params);
             if ($params['o_status_code'] == 1) {
                $employeeId = $empId;
                if(!$updateBasicInfo) {
                    return ['status' => true, 'o_status_code'=> 1, 'url' => '/employee/basic-info/'.$params['emp_id']['value'], 'id' => $params['emp_id']['value'], 'o_status_message' => 'Inserted Successfully'];
                    $role_id = Role::where('role_key', 'PMIS APPROVAL')->value('role_id');
                    $user_roles = UserRole::where('role_id', $role_id)->get();
                    $emp_name = Employee::where('emp_id', $params['emp_id']['value'])->value('emp_name');
                    foreach ($user_roles as $user_role){
                        $operator_notification = [
                            "p_notification_to" => $user_role->user_id,
                            "p_insert_by" => Auth::id(),
                            "p_note" => 'New employee '.$emp_name.' has been registered. Your approval require.',
                            "p_priority" => null,
                            "p_module_id" => 1,
                            "p_target_url" => "pmis#/employee-approval"
                        ];
                        DB::executeProcedure("cpa_security.cpa_general.notify_add", $operator_notification);
                    }
                } else {
                    return ['status' => true, 'o_status_code'=> 1, 'id' => $params['emp_id']['value'], 'o_status_message' => 'Updated Successfully'];
                }
            } else {
                 return $params;
             }
        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }
        return $params;
    }

    public function updateGpfSubscription($request)
    {
        try {
            $empId = $request->get('emp_id');
            $statusCode = sprintf('%20f', '');
            $statusMessage = sprintf('%4000s', '');
            $typeOf = $request->get('type_of');
            $valueOf = $request->get('value_of');
            $gpfPct = null;
            $gpfAmount = null;

            if($typeOf ==='gpf_pct') {
                $gpfPct = $valueOf;
            } else if($typeOf ==='gpf_amount') {
                $gpfAmount = $valueOf;
            } else {
                return ["exception" => false, 'status' => false, 'message' => 'Type of value is missing!'];
            }

            $params = [
                'emp_id' => $empId,
                'gpf_pct' => $gpfPct,
                'gpf_amount' => $gpfAmount,
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage,
            ];

            DB::executeProcedure('employees.emp_gpf_pct_update', $params);

            if ($params['o_status_code'] == 1) {
                return ['status' => true, 'o_status_code'=> 1, 'url' => '/employee/gpf-subscription/'.$empId, 'id' => $empId, 'o_status_message' => 'Updated Successfully'];
            } else {
                return $params;
            }
        }
        catch (Exception $e) {
            return ["exception" => true, 'status' => false, 'message' => $e->getMessage()];
        }

        return $params;
    }
}
