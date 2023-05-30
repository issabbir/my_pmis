<?php
namespace App\Managers\Pmis\Employee;
use App\Contracts\Pmis\Employee\DepuEmpBasicInfoContract;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmployeeDepu;
use Exception;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;


/**
* Class  as a services to maintain some business logic with db operation
*
* @package App\Managers\Pmis\Employee
*/
class DepuEmpBasicInfoManager implements DepuEmpBasicInfoContract
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
    public function addBasicInInfo(Request $request)
    {
        try {
            $statusCode = sprintf('%4000s', '');
            $empId = $request->get('emp_id') ?: '';
            $updateBasicInfo = ($empId > 0);
            $statusMessage = sprintf('%4000s', '');

            $emp_dob = $request->get('emp_dob') ? date("Y-m-d", strtotime($request->get('emp_dob'))) : '';
            $emp_join_date = $request->get('emp_join_date') ? date("Y-m-d", strtotime($request->get('emp_join_date'))) : '';
            $emp_lpr_date = $request->get('emp_lpr_date') ? date("Y-m-d", strtotime($request->get('emp_lpr_date'))) : '';
            $emp_active_date = $request->get('emp_active_date') ? date("Y-m-d", strtotime($request->get('emp_active_date'))) : '';
            $params = [
                'emp_id' => [
                    'value' => &$empId,
                    "type" => PDO::PARAM_INPUT_OUTPUT,
                    "length" => 255
                ],
                'emp_code' => $request->get('emp_code'),
                'emp_name' => $request->get('emp_name'),
                'emp_name_bng' => $request->get('emp_name_bng'),
                'emp_father_name' => $request->get('emp_father_name'),
                'emp_father_name_bng' => $request->get('emp_father_name_bng'),
                'emp_mother_name' => $request->get('emp_mother_name'),
                'emp_mother_name_bng' => $request->get('emp_mother_name_bng'),
                'emp_dob' => $emp_dob,
                'emp_join_date' => $emp_join_date,
                'emp_lpr_date' => $emp_lpr_date,
                'emp_gender_id' => $request->get('emp_gender_id'),
                'emp_religion_id' =>$request->get('emp_religion_id'),
                'emp_blood_group_id' => $request->get('emp_blood_group_id'),
                'emp_nationality_id' => $request->get('emp_nationality_id'),
                'emp_status_id' => 13,
                'emp_medical_book_id' => $request->get('emp_medical_book_id'),
                'emp_photo' => [
                    'value' => $request->post('emp_photo'),
                    'type' => SQLT_CLOB,
                ],
                'dpt_division_id' => $request->get('dpt_division_id'),
                'dpt_department_id' => $request->get('dpt_department_id'),
                'section_id' => $request->get('section_id'),
                'designation_id' => $request->get('designation_id'),
                'emp_class' => $request->get('emp_class'),
                'emp_type_id' => $request->get('emp_type_id'),
                'grade_id' => $request->get('grade_id'),
                'grade_step_id' => $request->get('grade_step_id'),
                'emp_maritial_status_id' => $request->get('emp_maritial_status_id'),
                'previous_workplace' => $request->get('previous_workplace'),
                'previous_designation' => $request->get('previous_designation'),
                'location_id' => $request->get('location_id'),
                'bill_code' => $request->get('bill_code'),
                'bank_id' => $request->get('bank_id'),
                'branch_id' => $request->get('branch_id'),
                'emp_bank_acc_no' => $request->get('emp_bank_acc_no'),
                'emp_tin_no' => $request->get('emp_tin_no'),
                'appointment_type_id' => $request->get('appointment_type_id'),
                'emp_photo_name' => $request->get('emp_photo_name'),
                'emp_photo_type' => $request->get('emp_photo_type'),
                'auth_doc_type_id' => $request->get('auth_doc_type_id'),
                'auth_no' => $request->get('auth_no'),
                'emp_active_yn' => $request->get('emp_active_yn'),
                'emp_active_date' => $emp_active_date,
                'tribal_yn' => $request->get('tribal_yn'),
                'pin_id_no' => $request->get('pin_id_no'),
                'emp_quota_id' => $request->get('emp_quota_id'),
                'emp_pf_id' => $request->get('emp_pf_id'),
                'insert_by' => $this->auth->Id(),
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage,
            ];
              //Todo: Bind out parameter
            DB::executeProcedure('employees.employee_depu_entry', $params);
             if ($params['o_status_code'] == 1) {
                if(!$updateBasicInfo) {
                    return ['status' => true, 'o_status_code'=> 1, 'url' => '/search-deputation-employee/', 'o_status_message' => 'Inserted Successfully'];
                } else {
                    return ['status' => true, 'o_status_code'=> 1, 'o_status_message' => 'Updated Successfully', 'id'=>$params['emp_id']['value']];
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
    public function getDeputationEmpInfo($id)
    {
            return Employee::where('emp_id',$id)->first();
    }
}
