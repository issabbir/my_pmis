<?php

namespace App\Http\Controllers\Api\V1\Pmis\Employee;

use App\Contracts\Admin\AdminContract;
use App\Http\Controllers\Controller;
use App\Managers\Admin\AdminManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TempBasicInfoCollectionController extends Controller
{
    /** @var AdminContract|AdminManager */
    protected $adminManager;

    public function __construct(AdminContract $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    public function index(Request $request)
    {

    }

    public function getEmployeeBasicInfo($p_emp_id)
    {
        $sql = "select open_info.emp_basic_info(:emp_id) from dual";
        return $basicInfo = DB::select($sql, ['emp_id' => $p_emp_id]);
    }

    public function getEmployeeLoanInfo($p_emp_id)
    {
        $sql = "select open_info.emp_loan_search(:emp_id) from dual";
        return $loanInfo = DB::select($sql, ['emp_id' => $p_emp_id]);
    }

    public function getEmployeeClubInfo($p_emp_id)
    {
        $sql = "select open_info.emp_other_attributes_search(:emp_id) from dual";
        return $clubInfo = DB::select($sql, ['emp_id' => $p_emp_id]);
    }

    public function getEmployeeFamilyInfo($p_emp_id)
    {
        $sql = "select open_info.emp_family_search(:emp_id) from dual";
        return $familyInfo = DB::select($sql, ['emp_id' => $p_emp_id]);
    }

    public function getEmployeeGPFInfo($emp_code)
    {
        $sql = "SELECT *
  FROM GPF_OPENING_BALANCE
 WHERE EMP_CODE = :emp_code";
        return DB::select($sql, ['emp_code' => $emp_code]);
    }

    public function storeBasicInfo(Request $request)
    {
      //  dd($request->all());
        try {
            $statusCode = sprintf('%20f', '');
            $statusMessage = sprintf('%4000s', '');

            $params = [
                'p_emp_id' => $request->get('emp_id'),
                'p_emp_name_bng' => $request->get('emp_name_bng'),
                'p_location_id' => $request->get('location_id'),
                'p_deputation_yn' => $request->get('deputation_yn'),
                'p_emp_blood_group_id' => $request->get('emp_blood_group_id'),
                'p_reporting_officer_id' => $request->get('reporting_officer_id'),
                'p_emp_emergency_relation_id' => $request->get('emp_emergency_relation_id'),
                'p_emp_emerg_contact_address' => $request->get('emp_emergency_contact_address'),
                'p_emp_emergency_contact_mobile' => $request->get('emp_emergency_contact_mobile'),
                'p_emp_emergency_contact_name' => $request->get('emp_emergency_contact_name'),
                'p_last_promotion_date' => $request->get("last_promotion_date")==null?"":date("Y-m-d", strtotime($request->get("last_promotion_date"))),
                'p_last_increment_date' => $request->get("last_increment_date")==null?"":date("Y-m-d", strtotime($request->get("last_increment_date"))),
                'p_emp_quota_id' => $request->get('emp_quota_id'),
                'p_emp_status_id' => $request->get('emp_status_id'),
                'p_tribal_yn' => $request->get('tribal_yn'),
                'p_emp_maritial_status_id' => $request->get('emp_maritial_status_id'),
                'p_emp_religion_id' => $request->get('emp_religion_id'),
                'p_religion_bng' => $request->get('religion_bng'),
                'p_emp_gender_id' => $request->get('emp_gender_id'),
                'p_emp_medical_book_id' => $request->get('emp_medical_book_id'),
                'p_emp_security_id' => $request->get('emp_security_id'),
                'p_nid_no' => $request->get('nid_no'),
                'p_auth_doc_type_id' => $request->get('auth_doc_type_id'),
                'p_auth_document' => $request->get('auth_document'),
                'p_auth_document_name' => $request->get('auth_document_name'),
                'p_auth_document_type' => $request->get('auth_document_type'),
                'p_last_time_scale_date' => $request->get("last_time_scale_date")==null?"":date("Y-m-d", strtotime($request->get("last_time_scale_date"))),
                'p_charge_activation_date' => $request->get("charge_activation_date")==null?"":date("Y-m-d", strtotime($request->get("charge_activation_date"))),
                'p_ts_promotion_id' => $request->get('ts_promotion_id'),
                'p_rs_promotion_id' => $request->get('rs_promotion_id'),
                'p_c_order_no' => $request->get('c_order_no'),
                'p_emp_photo' => [
                    'value' => $request->post('emp_photo'),
                    'type' => SQLT_CLOB,
                ],
                'p_emp_photo_name' => $request->get('emp_photo_name'),
                'p_emp_photo_type' => $request->get('emp_photo_type'),
                'p_insert_by' => auth()->id(),
                'o_status_code' => &$statusCode,
                'o_status_message' => &$statusMessage
            ];
            DB::executeProcedure("open_info.emp_opening_ins", $params);
            return $params;
        } catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
    }

    public function storeClubInfo(Request $request)
    {
        //dd($request->all());
        $attribute = $request->get('attribute_type_id');

        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_attribute_id" => $request->get('attribute_id'),
                "p_emp_id" => $request->get('emp_id'),
                'p_attribute_type_id' => $attribute['attribute_type_id'],
                "p_deduction_yn" => $request->get('deduction_yn'),
                "p_amount" => $request->get('amount'),
                "p_percentage" => $request->get('percentage'),
                "p_active_yn" => $request->get('active_yn'),
                "p_description" => $request->get('description'),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message
            ];
            DB::executeProcedure("open_info.emp_club_info_entry", $params);
            return $params;
        } catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }


    }

    public function storeLoanInfo(Request $request)
    {

        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_application_id" => $request->get('open_loan_id'),
                "p_emp_id" => $request->get('emp_id'),
                "p_cgpf_no" => $request->get('cgpf_no'),
                "p_loan_type_id" => $request->get('loan_type_id'),
                "p_application_amt" => $request->get('application_amt'),
                "p_description" => $request->get('description'),
                "p_reason" => $request->get('reason'),
                "p_rate_of_interest" => $request->get('rate_of_interest'),
                "p_installment_no" => $request->get('installment_no'),
                "p_approval_status" => $request->get('approval_status'),
                "p_remaining_balance" => $request->get('remaining_balance'),
                "p_remaining_installment_no" => $request->get('remaining_installment_no'),
                "p_approx_installment_amount" => $request->get('approx_installment_amount'),
                "p_remaining_interest" => $request->get('remaining_interest'),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message
            ];
            DB::executeProcedure("open_info.open_loan_entry", $params);
            return $params;
        } catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
    }

    public function storeGPFInfo(Request $request)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_emp_code" => $request->get('emp_code'),
                "p_pf_subsint_last_jun" => $request->get('pf_subsint_last_jun'),
                "p_pf_subs_from_last_jul" => $request->get('pf_subs_from_last_jul'),
                "p_op_int_from_last_jul" => $request->get('op_int_from_last_jul'),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message
            ];
            DB::executeProcedure("open_info.open_gpf_subscription_entry", $params);
            return $params;
        } catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
    }



    public function storeFamilyInfo(Request $request)
    {
       // dd($request->all());
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_emp_family_id" => $request->get('emp_family_id'),
                "p_emp_id" => $request->get('emp_id'),
                "p_emp_code" => $request->get('emp_code'),
                "p_emp_member_name" => $request->get('emp_member_name'),
                "p_emp_member_name_bng" => $request->get('emp_member_name_bng'),
                "p_relation_type_id" => $request->get('relation_type_id'),
                "p_address_line_1" => $request->get('address_line_1'),
                "p_address_line_2" => $request->get('address_line_2'),
                "p_emp_member_dob" => date("Y-m-d", strtotime($request->get("emp_member_dob"))),
                "p_gender_id" => $request->get('gender_id'),
                "p_marital_status_id" => $request->get('marital_status_id'),
                "p_member_nid" => $request->get('member_nid'),
                "p_member_birth_reg_id" => $request->get('member_birth_reg_id'),
                "p_thana_upazila" => $request->get('thana_id'),
                "p_district_id" => $request->get('district_id'),
                "p_nominee_percent" => $request->get('nominee_percent'),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message
            ];
            DB::executeProcedure("open_info.emp_open_family_ins", $params);
            return $params;
        } catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
    }



    public function deleteClubInfo(Request $request, $id)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_attribute_id" => $request->get('attribute_id'),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message
            ];
            DB::executeProcedure("open_info.emp_club_info_del", $params);
            return $params;
        } catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
    }

    public function deleteLoanInfo(Request $request, $id)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_application_id" => $request->get('application_id'),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message
            ];
            DB::executeProcedure("open_info.open_loan_del", $params);
            return $params;
        } catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
    }

    public function deleteFamilyInfo(Request $request, $id)
    {
        try {
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_emp_family_id" => $request->get('emp_family_id'),
                "p_insert_by" => auth()->id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message
            ];
            DB::executeProcedure("open_info.emp_club_info_del", $params);
            return $params;
        } catch (Exception $e) {
            return ["exception" => true, "status" => false, "message" => $e->getMessage()];
        }
    }

    public function remove(Request $request)
    {

    }

}
