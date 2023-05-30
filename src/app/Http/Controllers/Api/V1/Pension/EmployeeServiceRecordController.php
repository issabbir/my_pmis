<?php


namespace App\Http\Controllers\Api\V1\Pension;

use App\Contracts\Admin\AdminContract;
use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Pension\PensionEmployee;
use App\Entities\Pension\PensionNominee;
use App\Http\Controllers\Controller;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmployeeServiceRecordController extends Controller
{

    public function getEmployeePensionRecord(Request $request)
    {
        $sql = "select pension.emp_personnel_rec_data(:emp_id)  from dual";
        return DB::select($sql,['emp_id' => $request->get('emp_id')]);
    }

    public function storeServiceRecord(Request $request)
    {
        try {

            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $params = [
                "p_application_id" => $request->get("application_id"),
                "p_minor_date_from" => date("Y-m-d", strtotime($request->get("minor_date_from"))),
                "p_minor_date_to" => date("Y-m-d", strtotime($request->get("minor_date_to"))),
                "p_extr_leave_from" => date("Y-m-d", strtotime($request->get("extr_leave_from"))),
                "p_extr_leave_to" => date("Y-m-d", strtotime($request->get("extr_leave_to"))),
                "p_dismissal_from" => date("Y-m-d", strtotime($request->get("dismissal_from"))),
                "p_dismissal_to" => date("Y-m-d", strtotime($request->get("dismissal_to"))),
                "p_break_empmnt_from" => date("Y-m-d", strtotime($request->get("break_empmnt_from"))),
                "p_break_empmnt_to" => date("Y-m-d", strtotime($request->get("break_empmnt_to"))),
                "p_before_break_empmnt_from" => date("Y-m-d", strtotime($request->get("before_break_empmnt_from"))),
                "p_before_break_employment_to" => date("Y-m-d", strtotime($request->get("before_break_employment_to"))),
                "p_cancel_for_resignation_from" => date("Y-m-d", strtotime($request->get("cancel_for_resignation_from"))),
                "p_cancel_for_resignation_to" => date("Y-m-d", strtotime($request->get("cancel_for_resignation_to"))),
                "p_unauthorized_absence_from" => date("Y-m-d", strtotime($request->get("unauthorized_absence_from"))),
                "p_unauthorized_absence_to" => date("Y-m-d", strtotime($request->get("unauthorized_absence_to"))),
                "p_net_service_period" => $request->get("net_service_period"),
                "p_oth_eligible_services_year" => $request->get("oth_eligible_services_year"),
                "p_oth_eligible_services_month" => $request->get("oth_eligible_services_month"),
                "p_oth_eligible_services_day" => $request->get("oth_eligible_services_day"),
                "p_eligible_for_get_pen_from" => date("Y-m-d", strtotime($request->get("eligible_for_get_pen_from"))),
                "p_eligible_for_get_pen_to" => date("Y-m-d", strtotime($request->get("eligible_for_get_pen_to"))),
                "p_remission_period_year" => $request->get("remission_period_year"),
                "p_remission_period_month" => $request->get("remission_period_month"),
                "p_remission_period_day" => $request->get("remission_period_day"),
                "p_other_service_for_pension" => $request->get("other_service_for_pension"),
                "p_net_eligible_service_period" => $request->get("net_eligible_service_period"),
                "p_pension_allowance_gratuity" => $request->get("pension_allowance_gratuity"),
                "p_last_monthly_receive_salary" => $request->get("last_monthly_receive_salary"),
                "p_rate_of_pension_allowance" => $request->get("rate_of_pension_allowance"),
                "p_net_pension_allowance" => $request->get("net_pension_allowance"),
                "p_half_of_net_pension" => $request->get("half_of_net_pension"),
                "p_exchange_rate_of_first_half" => $request->get("exchange_rate_of_first_half"),
                "p_eligible_lump_sum_gratuity" => $request->get("eligible_lump_sum_gratuity"),
                "p_net_monthly_pension_allow" => $request->get("net_monthly_pension_allow"),
                "p_c307kha1" => $request->get("c307kha1"),
                "p_c307kha2" => $request->get("c307kha2"),
                "p_total_allowance" => $request->get("total_allowance"),
                "p_total_monthly_pension" => $request->get("total_monthly_pension"),
                "p_insert_by" => Auth::id(),
                "o_status_code" => &$status_code,
                "o_status_message" => &$status_message,
            ];
            DB::executeProcedure("PENSION.emp_personnel_record_ins", $params);
           // $this->storeNomineeRecord($request);
          ///  DB::commit();
        } catch (\Exception $e) {
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
    }

    public function employee(Request $request)
    {
        $employees = new PensionEmployee();
        /*$employees = $employees
            ->where('emp_code','!=', null)
            ->where(function($query) {
                $query->where('retirement_date', '<',new \DateTime("01/01/2021"))
                   ->orWhere('retirement_date', '=',null);
            });*/


        if ($request->get('filter') != 'null') {
            $employees = $employees
                ->where('emp_code', 'like', "%".$request->get('filter')."%")
                ->orwhere(DB::raw('LOWER(emp_name)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orwhere(DB::raw('LOWER(bank_acc_no)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orwhere(DB::raw('LOWER(medical_allow)'), 'like', "%".strtolower($request->get('filter'))."%")
//                ->orwhere(DB::raw('LOWER(pension_amt_pct)'), 'like', "%".strtolower($request->get('filter'))."%")
//                ->orwhere(DB::raw('LOWER(monthly_amount)'), 'like', "%".strtolower($request->get('filter'))."%")
                ->orWhereHas('department', function($q) use ($request) {
                    if ($request->get('filter')) {
                        $q->where(DB::raw('LOWER(department_name)'),'like',"%".strtolower($request->get('filter'))."%");
                    }
                })
            ->orWhereHas('designation', function($q) use ($request) {
                if ($request->get('filter')) {
                    $q->where(DB::raw('LOWER(designation)'),'like',"%".strtolower($request->get('filter'))."%");
                }

            });


//
//

        }
        if ($pension_cat = $request->get('pension_cat')){
            $employees = $employees->where('pension_pct', (int)$pension_cat);
        }
        if ($request->get('emp_type') != 'null'){
            //echo $request->get('emp_type');
            $employees = $employees->where('emp_type_id', $request->get('emp_type'));
        }
        if ($request->get('department_id') != 'null'){
            $employees = $employees->where('dpt_department_id', $request->get('department_id'));
        }
        if ($request->get('emp_id') != 'null'){
            $employees = $employees->where('emp_id', $request->get('emp_id'));
        }
        if ($request->get('on_pension_yn') != 'null'){
            $employees = $employees->where('on_pension_yn', $request->get('on_pension_yn'));
        }
        return $employees->orderBy('insert_date', 'desc')->paginate($request->get('size'));
    }

    public function updateEmployee(Request $request){

        try {
            DB::beginTransaction();
            $status_code = sprintf("%4000s", "");
            $status_message = sprintf("%4000s", "");
            $emp_id = PensionEmployee::where('emp_code',$request->get("emp_code"))->count();
            if($emp_id){
                $params = [
                    'p_emp_id' => [
                        'value' => $request->get("emp_id"),
                        "type" => \PDO::PARAM_INPUT_OUTPUT,
                        "length" => 255
                    ],
                    "p_emp_code" =>$request->get("emp_code"),
                    "p_emp_name" =>$request->get("emp_name"), //new
                    "p_emp_dob" => $request->get("emp_dob") && $request->get("emp_dob") != 'Invalid date' ? date("Y-m-d", strtotime($request->get("emp_dob"))): null,
                    "p_emp_join_date" => $request->get("emp_join_date") ? date("Y-m-d", strtotime($request->get("emp_join_date"))): null,
                    "p_emp_lpr_date" => $request->get("emp_lpr_date") ? date("Y-m-d", strtotime($request->get("emp_lpr_date"))): null,
                    "p_emp_gender_id" => $request->get("emp_gender_id"),
                    "p_emp_religion_id" => $request->get("emp_religion_id"),
                    "p_emp_blood_group_id" => $request->get("emp_blood_group_id"),
                    "p_emp_quota_id" => $request->get("emp_quota_id"),
                    "p_emp_medical_book_id" => $request->get("emp_medical_book_id"),
                    "p_emp_grade_id" => $request->get("emp_grade_id"),
                    "p_dpt_department_id" => $request->get("dpt_department_id"),
                    "p_pension_amt" => $request->get("pension_amt"),
                    "p_medical_allow" => $request->get("medical_allow"),
                    "p_old_pension_amt" => $request->get("old_pension_amt"),
                    "p_designation_id" => $request->get("designation_id"),
                    "p_emp_class" => $request->get("emp_class"),
                    "p_emp_gender_name" => $request->get("emp_gender_name"),
                    "p_emp_religion_name" => $request->get("emp_religion_name"),
                    "p_bank_acc_no" => $request->get("bank_acc_no"), //new
                    "p_death_date" => $request->get("death_date") ? date("Y-m-d", strtotime($request->get("death_date"))): null,
                    "p_retirement_date" => $request->get("retirement_date") ? date("Y-m-d", strtotime($request->get("retirement_date"))): null,
                    "p_tribal_yn" => $request->get("tribal_yn"),
                    "p_dearness_allow" => $request->get("dearness_allow"),
                    "p_miscellaneous_ded" => $request->get("miscellaneous_ded"),
                    "p_over_pay_fix_ded" => $request->get("over_pay_fix_ded"),
                    "p_foreign_ta_da_ded" => $request->get("foreign_ta_da_ded"),
                    "p_it_con_fee_ded" => $request->get("it_con_fee_ded"),
                    "p_prl_inc_bon_ded" => $request->get("prl_inc_bon_ded"),
                    "p_emp_nominee_id" => null,
                    "p_nominee_name" => $request->get("nominee_name"),
                    "p_relationship_id" => $request->get("relationship_id"),
                    "p_nominee_dob" => $request->get("nominee_dob") ? date("Y-m-d", strtotime($request->get("nominee_dob"))): null,
                    "p_emp_type_id" => isset($request->get("emp_type_id")['value']) ? $request->get("emp_type_id")['value'] : null,
                    "p_pension_pct" => $request->get("pension_pct"),
                    "p_on_pension_yn" => $request->get("on_pension_yn"),
                    "p_emp_contact_no" => $request->get("emp_contact_no"),
                    "p_emp_nid_no" => $request->get("emp_nid_no"),
                    "p_pension_start_date" => $request->get("pension_start_date") ? date("Y-m-d", strtotime($request->get("pension_start_date"))) : null,
                    "p_pension_end_date" => $request->get("pension_end_date") ? date("Y-m-d", strtotime($request->get("pension_end_date"))) : null,
                    "p_insert_by" => Auth::id(),
                    "o_status_code" => &$status_code,
                    "o_status_message" => &$status_message,
                ];
                DB::executeProcedure("PENSION.exiting_pension_emp_info_upd", $params);
//                dd($params);
                if (count($request->get('nominees')) > 0){
                      $this->storeNomineeRecord($request->get("emp_id"), $request);
//                    if ($nominee['o_status_code'] == 1){
//                        DB::commit();
//                    }else{
//                        DB::rollBack();
//                    }
                }
                DB::commit();

                return ["exception" => false, "status" => true, "o_status_code" => $params["o_status_code"], "o_status_message" => $params["o_status_message"]];
            } else {

                $empID = null;
                $params = [
                    'p_emp_id' => [
                        'value' => &$empID,
                        "type" => \PDO::PARAM_INPUT_OUTPUT,
                        "length" => 255
                    ],
                    "p_emp_code" =>$request->get("emp_code"),
                    "p_emp_name" =>$request->get("emp_name"), //new
                    "p_emp_name_bng" =>$request->get("emp_name_bng"), //new
                    "p_emp_father_name" =>$request->get("emp_father_name"), //new
                    "p_emp_father_name_bng" =>$request->get("emp_father_name_bng"), //new
                    "p_emp_mother_name" =>$request->get("emp_mother_name"), //new
                    "p_emp_mother_name_bng" =>$request->get("emp_mother_name_bng"), //new
                    "p_emp_dob" => $request->get("emp_dob") && $request->get("emp_dob") != 'Invalid date' ? date("Y-m-d", strtotime($request->get("emp_dob"))): null,
                    "p_emp_join_date" => $request->get("emp_join_date") ? date("Y-m-d", strtotime($request->get("emp_join_date"))): null,
                    "p_emp_lpr_date" => $request->get("emp_lpr_date") ? date("Y-m-d", strtotime($request->get("emp_lpr_date"))): null,
                    "p_emp_gender_id" => $request->get("emp_gender_id"),
                    "p_emp_religion_id" => $request->get("emp_religion_id"),
                    "p_emp_blood_group_id" => $request->get("emp_blood_group_id"),
                    "p_emp_nationality_id" => $request->get("emp_nationality_id"),//new
                    "p_emp_quota_id" => $request->get("emp_quota_id"),
                    "p_emp_medical_book_id" => $request->get("emp_medical_book_id"),
                    "p_identity_symbol" => $request->get("identity_symbol"), //new
                    "p_identity_symbol_bng" => $request->get("identity_symbol_bng"), //new
                    "p_emp_grade_id" => $request->get("emp_grade_id"),
                    "p_dpt_division_id" => $request->get("dpt_division_id"),//new
                    "p_dpt_department_id" => $request->get("dpt_department_id"),
                    "p_section_id" => $request->get("section_id"), //new
                    "p_designation_id" => $request->get("designation_id"),
                    "p_emp_class" => $request->get("emp_class"),
                    "p_emp_gender_name" => $request->get("emp_gender_name"),
                    "p_emp_gender_name_bng" => $request->get("emp_gender_name_bng"),//new
                    "p_emp_religion_name" => $request->get("emp_religion_name"),
                    "p_bank_id" => $request->get("bank_id"), //new
                    "p_branch_id" => $request->get("branch_id"), //new
                    "p_emp_nominee_id" => null, //new
                    "p_nominee_name" => $request->get("nominee_name"), //new
                    "p_relationship_id" => $request->get("relationship_id"), //new
                    "p_percentage" => null, //new
                    "p_nominee_marital_status_id" => null, //new
                    "p_nominee_acc_no" => null, //new
                    "p_nominee_bank_id" => null, //new
                    "p_nominee_branch_id" => null, //new
                    "p_nominee_gender_id" => null, //new
                    "p_bank_acc_no" => $request->get("bank_acc_no"), //new
                    "p_pension_amt" => $request->get("pension_amt"),
                    "p_medical_allow" => $request->get("medical_allow"),
                    "p_old_pension_amt" => $request->get("old_pension_amt"),
                    "p_death_date" => $request->get("death_date") ? date("Y-m-d", strtotime($request->get("death_date"))): null,
                    "p_retirement_date" => $request->get("retirement_date") ? date("Y-m-d", strtotime($request->get("retirement_date"))): null,
                    "p_tribal_yn" => $request->get("tribal_yn"),
                    "p_dearness_allow" => $request->get("dearness_allow"),
                    "p_miscellaneous_ded" => $request->get("miscellaneous_ded"),
                    "p_over_pay_fix_ded" => $request->get("over_pay_fix_ded"),
                    "p_foreign_ta_da_ded" => $request->get("foreign_ta_da_ded"),
                    "p_it_con_fee_ded" => $request->get("it_con_fee_ded"),
                    "p_prl_inc_bon_ded" => $request->get("prl_inc_bon_ded"),
                    "p_nominee_dob" => $request->get("nominee_dob") ? date("Y-m-d", strtotime($request->get("nominee_dob"))): null,
                    "p_emp_type_id" => isset($request->get("emp_type_id")['value']) ? $request->get("emp_type_id")['value'] : null,
                    "p_pension_pct" => $request->get("pension_pct"),
                    //"p_on_pension_yn" => $request->get("on_pension_yn"),
                    "p_emp_contact_no" => $request->get("emp_contact_no"),
                    "p_emp_nid_no" => $request->get("emp_nid_no"),
                    "p_pension_start_date" => $request->get("pension_start_date") ? date("Y-m-d", strtotime($request->get("pension_start_date"))) : null,
                    "p_pension_end_date" => $request->get("pension_end_date") ? date("Y-m-d", strtotime($request->get("pension_end_date"))) : null,
                    "p_insert_by" => Auth::id(),
                    "o_status_code" => &$status_code,
                    "o_status_message" => &$status_message,
                ];
               // dd(count($request->get('nominees')));
                DB::executeProcedure("PENSION.exiting_pension_emp_info_ins", $params);
//                dd($params);
               // dd(count($request->get('nominees')));
                if (count($request->get('nominees')) > 0){
                    $nominee = $this->storeNomineeRecord($empID, $request);
                    if ($nominee['o_status_code'] == 1){
                        DB::commit();
                    }else{
                        DB::rollBack();
                        return ["exception" => false, "status" => true, "o_status_code" => $params["o_status_code"], "o_status_message" => $params["o_status_message"]];
                    }
                }
               // dd('nominees');
                DB::commit();
                return ["exception" => false, "status" => true, "o_status_code" => $params["o_status_code"], "o_status_message" => $params["o_status_message"]];
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }

    }
    public function storeNomineeRecord($empID, Request $request)
    {
        try {
            $params = [];
            $i = 1;
           // $nominees = (array)$request->get('nominees');
            //sort($nominees);
            //dd($nominees);
            foreach ($request->get('nominees') as $key=>$nominee){
                $status_code = sprintf("%4000s", "");
                $status_message = sprintf("%4000s", "");
               // $countNominee = count($request->get("nominees"));
//                if ($i++ >= count($request->get("nominees")) && $nominee["nominee_code"]){
//                    //dd(++$countNominee);
//                    $nominee_code = $request->get("emp_code").'-N'. $i++;
//                }else{
//                    $nominee_code = $request->get("emp_code").'-N'. ++$countNominee;
//                }
//                dd($nominee_code);
               // $nominee_code = $request->get("emp_code").'-N'. $i++;
                $params = [
                    "p_nominee_id" => isset($nominee["nominee_id"]) ? $nominee["nominee_id"] : null,
                    "p_emp_id" => $empID,
                    "p_nominee_name" => $nominee['nominee_name'],
                    "p_relationship_id" => isset($nominee["relationship_id"]['value']) ? $nominee["relationship_id"]['value'] : $nominee["relationship_id"],
                    "p_percentage" => $nominee["percentage"],
                    "p_address_line_1" => null,
                    "p_address_line_2" => null,
                    "p_nominee_contact_no" => $nominee["nominee_contact_no"],
                    "p_nominee_email" => $nominee["nominee_email"],
                    "p_nominee_dob" => $nominee["nominee_dob"],
                    "p_nominee_marital_status_id" => null,
                    "p_nominee_photo" => null,
                    "p_nominee_auth_id" => null,
                    "p_nominee_auth_id_photo" => null,
                    "p_nominee_acc_no" => $nominee["nominee_acc_no"],
                    "p_bank_id" => null,
                    "p_branch_id" => null,
                    "p_nominee_gender_id" => null,
                    "p_insert_by" => Auth::id(),
                    "p_update_by" => null,
                    "p_auth_type_id" => null,
                    "p_medical_id" => null,
                    "p_district_id" => null,
                    "p_thana_id" => null,
                    "p_post_code" => null,
                    "p_nominee_photo_name" => null,
                    "p_nominee_photo_type" => null,
                    "p_nominee_auth_id_photo_name" => null,
                    "p_nominee_auth_id_photo_type" => null,
                    "p_approved_yn" => "Y",
                    "p_nominee_for_id" => null,
                    "p_autistic_yn" => null,
                    "p_emp_family_id" => null,
                    "p_active_yn" => 'Y',
                    "p_alternate_nominee_ids" => null,
                    "p_alternate_nominee_names" => null,
                    "p_pension_start_date" => isset($nominee["pension_start_date"]) ? date("Y-m-d", strtotime($nominee["pension_start_date"])) : null,
                    "p_pension_end_date" => isset($nominee["pension_end_date"]) ? date("Y-m-d", strtotime($nominee["pension_end_date"])) : null,
//                    "p_total_monthly_pension" => $nominee["nominee_total"],
                    "p_pension_amt" => $nominee["pension_amt"],
                    "p_medical_allow" => $nominee["medical_allow"],
                    "p_nominee_code" => $request->get("emp_code").'/N'. $i++,
                    "p_nominee_nid" => isset($nominee["nominee_nid_no"]) ? $nominee["nominee_nid_no"] : '',
                    "o_status_code" => &$status_code,
                    "o_status_message" => &$status_message,
                ];

                DB::executeProcedure("PENSION.create_pension_nominee", $params);
                // Log::info($params);
                //dd($params);
            }
            return $params;
        } catch (\Exception $e) {
            dd( $e->getMessage());
            return ["exception" => true, "status" => false, "o_status_code" => 99, "o_status_message" => $e->getMessage()];
        }
    }
    public function pensionNominee($emp_id){
          $pensionNominees =  PensionNominee::where('emp_id',$emp_id)->get();
          return ['status'=>true, 'data'=>$pensionNominees];
    }
    public function pensionNomineeUpdate(Request $request){
        try {
            $pensionNominee =  new PensionNominee();
            $params = [
                "nominee_name" =>  $request->get('nominee_name'),
                "relationship_id" => $request->get('relationship_id'),
                "percentage" => $request->get("percentage"),
                "nominee_contact_no" => $request->get("nominee_contact_no"),
                "nominee_dob" => $request->get("nominee_dob"),
                "nominee_acc_no" => $request->get("nominee_acc_no"),
                "pension_start_date" => $request->get("pension_start_date") ? date("Y-m-d", strtotime($request->get("pension_start_date"))) : null,
                "pension_end_date" => $request->get("pension_end_date") ? date("Y-m-d", strtotime($request->get("pension_end_date"))) : null,
                "pension_amt" => $request->get("pension_amt"),
                "medical_allow" => $request->get("medical_allow"),
                "nominee_nid_no" => $request->get("nominee_nid_no"),
            ];
            $pensionNominee->where('nominee_id',$request->get('nominee_id'))->update($params);
            return ['o_status_code'=>1, 'o_status_message'=>'Successfully Update'];
        }catch (\Exception $exception){
            return ['o_status_code'=>1, 'o_status_message'=>$exception->getMessage()];
        }
    }
    public function pensionNomineeDelete($emp_id,$nominee_id){
          $pensionNominee =  PensionNominee::where('nominee_id',$nominee_id)->first();
          $pensionNominee->delete();
          return ['o_status_code'=>1, 'o_status_message'=>'Successfully Deleted'];
    }
}
