<?php

namespace App\Http\Controllers\Api\V1\Pmis;

use App\Contracts\Pmis\Employee\EmployeeContract;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Pmis\Employee\EmployeeDepu;
use App\Entities\Pmis\Employee\EmployeeTemp;
use App\Http\Controllers\Controller;
use App\Managers\Pmis\Employee\EmployeeManager;
use Illuminate\Http\Request;
use App\Contracts\Admin\AdminContract;
use App\Managers\Admin\AdminManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class SearchEmployeeController extends Controller
{
    private $adminManager;
    private $employeeManager;

    public function __construct(AdminContract $adminManager, EmployeeContract $employeeManager)
    {
        $this->adminManager = $adminManager;
        $this->employeeManager = $employeeManager;
    }

    public function index(Request $request)
    {
        $adminManager = $this->adminManager;
        $statusData = $adminManager->findEmpStatus();
        $data[] = ['text'=>'All','value'=>'null'];
        foreach ($statusData as $status){
            $data[] = $status;
        }

        return [
            "departments" => $adminManager->findDepartments(),
            "sections" => $adminManager->findDptSections(),
            "actualGrade" => $this->empActualGrads(),
            "status" => $data,
        ];
    }

    /**
     * @return array
     */
    private function empActualGrads() {
        $grades = [];
        $grades[] = ["value" => null, 'text' => 'Select Grade'];
        foreach ($this->adminManager->findEmpGrads() as $item) {
            $grades[] = ["text" => 'Grade '.$item->emp_grade_id.' ('.$item->grade_range.') ', 'value' => $item->emp_grade_id];
        }
        return $grades;
    }

    public function lookupDataForBasic(Request $request)
    {
        $adminManager = $this->adminManager;
        $statusData = $adminManager->findEmpStatus();
        $data[] = ['text'=>'All','value'=>'null'];
        foreach ($statusData as $status){
            $data[] = $status;
        }

        return [
            "departments" => $adminManager->findDepartmentsForBasic(),
            "sections" => $adminManager->findDptSections(),
            "status" => $data,
        ];
    }



    public function search($departmentId='',$sectionId = '', $emp_grade_id='', $designation_id = '',$status_id = '',$deputation_yn = '',$emp_active_yn = '',$actual_grade_id = '', $emp_code = '', Request $request) {

        $employees = new EmployeeTemp();
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = trim($request->input('search'));


        if(is_numeric($departmentId)) {
            $employees = $employees->where('dpt_department_id','=',$departmentId);
        }

        if(is_numeric($sectionId)) {
            $employees = $employees->where('section_id','=',$sectionId);
        }

        if(is_numeric($emp_grade_id)) {
            $employees = $employees->where('emp_grade_id','=', $emp_grade_id);
        }

        if(is_numeric($designation_id)) {
            $employees = $employees->where('designation_id','=', $designation_id);
        }
        if(is_numeric($status_id)) {
            $employees = $employees->where('emp_status_id','=', $status_id);
        }
        if($emp_code) {
            $employees = $employees->where('emp_code','=', trim($emp_code));
        }
        if(is_numeric($actual_grade_id)) {
            $employees = $employees->where('actual_grade_id','=', trim($actual_grade_id));
        }

        if ($searchValue) {
            $searchValue = strtolower($searchValue);
            $employees = $employees->where(function($query) use ($searchValue) {
                $query->where(DB::raw('LOWER(emp_name)'),'like',"%".$searchValue."%")
                    ->orWhere(DB::raw('LOWER(emp_code)'),'like',"%".$searchValue."%");
            });
        }
        $employees = $employees->where('deputation_yn','=',$deputation_yn);
        $employees = $employees->where('emp_active_yn','=',$emp_active_yn);

        if($sortBy == 'emp_name' || $sortBy == 'emp_code') {
          $employees = $employees->orderBy($sortBy, $orderBy);
        }elseif ($sortBy == 'designation.designation'){
            $employees = $employees->orderBy('designation_id', $orderBy);
        }elseif ($sortBy == 'department.department_name'){
            $employees = $employees->orderBy('dpt_department_id', $orderBy);
        }elseif ($sortBy == 'joindate'){
            $employees = $employees->orderBy('emp_join_date', $orderBy);
        }elseif ($sortBy == 'lprdate'){
            $employees = $employees->orderBy('emp_lpr_date', $orderBy);
        }{
            $employees = $employees->orderBy("emp_name", 'asc')->orderBy("emp_code", 'asc');
        }

        $data = $employees->paginate($length);
        return new DataTableCollectionResource($data);
    }

    public function searchForBasic($departmentId='',$sectionId = '', $emp_grade_id='', $designation_id = '',$status_id = '', $emp_code = '', Request $request) {

        $employees = new EmployeeTemp();
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = trim($request->input('search'));
        if(is_numeric($departmentId)) {
            $employees = $employees->where('current_department_id','=',$departmentId);
        }

        if(is_numeric($sectionId)) {
            $employees = $employees->where('section_id','=',$sectionId);
        }

        if(is_numeric($emp_grade_id)) {
            $employees = $employees->where('emp_grade_id','=', $emp_grade_id);
        }

        if(is_numeric($designation_id)) {
            $employees = $employees->where('designation_id','=', $designation_id);
        }
        if(is_numeric($status_id)) {
            $employees = $employees->where('emp_status_id','=', $status_id);
        }
        if($emp_code) {
            $employees = $employees->where('emp_code','=', trim($emp_code));
        }
        if ($searchValue) {
            $searchValue = strtolower($searchValue);
            $employees = $employees->where(DB::raw('LOWER(emp_name)'),'like',"%".$searchValue."%")
                ->orWhere(DB::raw('LOWER(emp_code)'),'like',"%".$searchValue."%");

            if(is_numeric($departmentId)) {
                $employees = $employees->where('current_department_id','=',$departmentId);
            }
        }

        $employees = $employees->orderBy("emp_name", 'asc')->orderBy("emp_code", 'asc');
        $data = $employees->paginate($length);
        return new DataTableCollectionResource($data);
    }

    public function searchUnapprovedEmployees($id) {

        $employeeManager = $this->employeeManager;
        return $employeeManager->unapprovedEmployeeOption($id);
    }

    public function unapprovedEmployees(){
        $employeeManager = $this->employeeManager;
        return $employeeManager->unapprovedEmployee();
    }

    public function comparisonEmployeeUpdate($id){

        $emp_id = (int)$id;
        $employee = DB::selectOne("SELECT emp.emp_id,
       emp.emp_code,
       sa.salutation               AS salutation_id,
       emp.emp_name,
       emp.emp_name_bng,
       emp.emp_father_name,
       emp.emp_father_name_bng,
       emp.emp_mother_name,
       emp.emp_mother_name_bng,
       emp.emp_dob,
       emp.emp_join_date,
       emp.emp_lpr_date,
       lg.gender_name              AS emp_gender_id,
       lr.religion                 AS emp_religion_id,
       lbg.blood_group             AS emp_blood_group_id,
       lna.nationality             AS emp_nationality_id,
       lq.quota_name               AS emp_quota_id,
       les.emp_status              AS emp_status_id,
       emp.emp_security_id,
       emp.emp_medical_book_id,
       emp.identity_symbol,
       emp.identity_symbol_bng,
       emp.emp_pf_id,
       emp.emp_photo,
       emp.emp_confirmation_date,
       emp.emp_go_number,
       emp.emp_go_date,
       emp.emp_bcs_batch_no,
       'Grade '||leg.emp_grade_id||' (' ||leg.grade_range||')'             AS emp_grade_id,
       'Grade '||ag.emp_grade_id||' (' ||ag.grade_range||')'             AS actual_grade_id,
       'Grade '||jg.emp_grade_id||' (' ||jg.grade_range||')'             AS joining_grade_id,
       dv.dpt_division_name        AS dpt_division_id,
       dp.department_name          AS dpt_department_id,
       lds.dpt_section             AS section_id,
       d.designation               AS designation_id,
       emp.emp_class,
       let.emp_type_name           AS emp_type_id,
       emp.gpf_yn,
       emp.hbl_yn,
       emp.allowance_yn,
       emp.tax_yn,
       lms.maritial_status         AS emp_maritial_status_id,
       co.emp_name || ' (' || co.emp_code ||  ')'  AS reporting_officer_id,
       lpt.post_type               AS post_type_id,
       emp.salutation,
       emp.emp_gender_name,
       emp.salutation_bng,
       emp.emp_gender_name_bng,
       emp.emp_religion_name,
       emp.previous_workplace,
       emp.previous_designation,
       emp.previous_office_address,
       loc.ot_category             AS ot_category_id,
       emp.ot_category_name,
       emp.emp_emergency_contact_name,
       emp.emp_emergency_contact_mobile,
       ert.relation_type  AS  emp_emergency_relation_id,
       emp.emp_emergency_contact_address,
       'Grade Step '|| lgs.grade_steps_id||' (' ||lgs.basic_amt||')'           AS grade_step_id,
       ll.working_location         AS location_id,
       emp.biller_code,
       emp.bill_code,
       lb.bank_id                  AS bank_id,
       lbra.branch_name            AS branch_id,
       emp.emp_bank_acc_no,
       emp.on_pension_yn,
       emp.deceased_yn,
       emp.emp_active_yn,
       emp.emp_active_date,
       emp.emp_religion_name_bng,
       emp.emp_tin_no,
       lat.appoinment_type         AS appointment_type_id,
       emp.nid_no,
       emp.tribal_yn,
       emp.approved_yn,
       emp.shift_id,
       emp.gpf_pct,
       lprt.profession_type        AS profession_type_id,
       /* emp.emp_photo_name,
       emp.emp_photo_type, */
       emp.auth_document,
      /* emp.auth_document_name,
       emp.auth_document_type,*/
       emp.deputation_yn,
       emp.gpf_amount,
       emp.rep_designation,
       emp.emp_old_lpr_date,
       ladt.auth_doc_type_name     AS auth_doc_type_id,
       emp.old_grade_id,
       emp.old_grade_step_id,
       emp.selection_grade_yn,
       emp.dead_date,
       emp.resign_date,
       emp.last_promotion_date,
       emp.last_increment_date,
       emp.old_basic_amt,
       emp.additional_charge_yn,
       emp.addition_c_order_no,
       ldo.designation             AS charge_designation_id,
       emp.emp_hold_yn,
       emp.prl_sent_email_yn,
       emp.mobile_allowance,
       dpo.department_name         AS current_department_id,
       emp.application_id
  FROM employee  emp
       LEFT JOIN l_salutation sa ON sa.salutation_id = emp.salutation_id
       LEFT JOIN l_gender lg ON lg.gender_id = emp.emp_gender_id
       LEFT JOIN  l_religion lr ON lr.religion_id = emp.emp_religion_id
       LEFT JOIN  l_blood_group lbg ON lbg.blood_group_id = emp.emp_blood_group_id
       LEFT JOIN  l_nationality lna ON lna.nationality_id = emp.emp_nationality_id
       LEFT JOIN l_quota lq ON lq.quota_id = emp.emp_quota_id
       JOIN l_emp_status les ON les.emp_status_id = emp.emp_status_id
       LEFT JOIN  l_emp_grade leg ON leg.emp_grade_id = emp.emp_grade_id
       LEFT JOIN  l_emp_grade ag ON ag.emp_grade_id = emp.actual_grade_id
       LEFT JOIN  l_emp_grade jg ON jg.emp_grade_id = emp.joining_grade_id
       LEFT JOIN  l_designation d ON d.designation_id = emp.designation_id
       LEFT JOIN  l_department dp ON dp.department_id = emp.dpt_department_id
       LEFT JOIN  l_dpt_division dv ON dv.dpt_division_id = emp.dpt_division_id
       LEFT JOIN  l_dpt_section lds ON lds.dpt_section_id = emp.section_id
       LEFT JOIN  l_emp_type let ON let.emp_type_id = emp.emp_type_id
       LEFT JOIN  l_maritial_status lms
           ON lms.maritial_status_id = emp.emp_maritial_status_id
       LEFT JOIN l_post_type lpt ON lpt.post_type_id = emp.post_type_id
       LEFT JOIN  l_ot_category loc ON loc.ot_category_id = emp.ot_category_id
       JOIN l_grade_steps lgs
           ON     lgs.grade_steps_id = emp.grade_step_id
              AND lgs.grade_id = leg.emp_grade_id
       LEFT JOIN l_banks lb ON lb.bank_id = emp.bank_id
       LEFT JOIN l_branch lbra ON lbra.branch_id = emp.branch_id
       LEFT JOIN l_appoinment_type lat
           ON lat.appoinment_type_id = emp.appointment_type_id
       LEFT JOIN l_profession_type lprt
           ON lprt.profession_type_id = emp.profession_type_id
       LEFT JOIN l_auth_doc_type ladt
           ON ladt.auth_doc_type_id = emp.auth_doc_type_id
       LEFT JOIN l_designation ldo
           ON ldo.designation_id = emp.charge_designation_id
       LEFT JOIN l_department dpo
           ON dpo.department_id = emp.current_department_id
       LEFT JOIN l_location ll ON lgs.grade_steps_id = emp.location_id
       LEFT JOIN employee co ON co.emp_id = emp.reporting_officer_id
       LEFT JOIN l_relation_type ert ON ert.relation_type_id = emp.emp_emergency_relation_id
 WHERE emp.emp_id = $emp_id");

        $sql = "SELECT emp.emp_id,
       emp.emp_code,
       sa.salutation               AS salutation_id,
       emp.emp_name,
       emp.emp_name_bng,
       emp.emp_father_name,
       emp.emp_father_name_bng,
       emp.emp_mother_name,
       emp.emp_mother_name_bng,
       emp.emp_dob,
       emp.emp_join_date,
       emp.emp_lpr_date,
       lg.gender_name              AS emp_gender_id,
       lr.religion                 AS emp_religion_id,
       lbg.blood_group             AS emp_blood_group_id,
       lna.nationality             AS emp_nationality_id,
       lq.quota_name               AS emp_quota_id,
       les.emp_status              AS emp_status_id,
       emp.emp_security_id,
       emp.emp_medical_book_id,
       emp.identity_symbol,
       emp.identity_symbol_bng,
       emp.emp_pf_id,
       emp.emp_photo,
       emp.emp_confirmation_date,
       emp.emp_go_number,
       emp.emp_go_date,
       emp.emp_bcs_batch_no,
       'Grade '||leg.emp_grade_id||' (' ||leg.grade_range||')'             AS emp_grade_id,
       'Grade '||ag.emp_grade_id||' (' ||ag.grade_range||')'             AS actual_grade_id,
       'Grade '||jg.emp_grade_id||' (' ||jg.grade_range||')'             AS joining_grade_id,
       dv.dpt_division_name        AS dpt_division_id,
       dp.department_name          AS dpt_department_id,
       lds.dpt_section             AS section_id,
       d.designation               AS designation_id,
       emp.emp_class,
       let.emp_type_name           AS emp_type_id,
       emp.gpf_yn,
       emp.hbl_yn,
       emp.allowance_yn,
       emp.tax_yn,
       lms.maritial_status         AS emp_maritial_status_id,
       co.emp_name || ' (' || co.emp_code ||  ')'  AS reporting_officer_id,
       lpt.post_type               AS post_type_id,
       emp.salutation,
       emp.emp_gender_name,
       emp.salutation_bng,
       emp.emp_gender_name_bng,
       emp.emp_religion_name,
       emp.previous_workplace,
       emp.previous_designation,
       emp.previous_office_address,
       loc.ot_category             AS ot_category_id,
       emp.ot_category_name,
       emp.emp_emergency_contact_name,
       emp.emp_emergency_contact_mobile,
       ert.relation_type  AS  emp_emergency_relation_id,
       emp.emp_emergency_contact_address,
       'Grade Step '|| lgs.grade_steps_id||' (' ||lgs.basic_amt||')'              AS grade_step_id,
       ll.working_location         AS location_id,
       emp.biller_code,
       emp.bill_code,
       lb.bank_id                  AS bank_id,
       lbra.branch_name            AS branch_id,
       emp.emp_bank_acc_no,
       emp.on_pension_yn,
       emp.deceased_yn,
       emp.emp_active_yn,
       emp.emp_active_date,
       emp.emp_religion_name_bng,
       emp.emp_tin_no,
       lat.appoinment_type         AS appointment_type_id,
       emp.nid_no,
       emp.tribal_yn,
       emp.approved_yn,
       emp.shift_id,
       emp.gpf_pct,
       lprt.profession_type        AS profession_type_id,
       /*emp.emp_photo_name,
       emp.emp_photo_type,*/
       emp.auth_document,
       /*emp.auth_document_name,
       emp.auth_document_type,*/
       emp.deputation_yn,
       emp.gpf_amount,
       emp.rep_designation,
       emp.emp_old_lpr_date,
       ladt.auth_doc_type_name     AS auth_doc_type_id,
       emp.old_grade_id,
       emp.old_grade_step_id,
       emp.selection_grade_yn,
       emp.dead_date,
       emp.resign_date,
       emp.last_promotion_date,
       emp.last_increment_date,
       emp.old_basic_amt,
       emp.additional_charge_yn,
       emp.addition_c_order_no,
       ldo.designation             AS charge_designation_id,
       emp.emp_hold_yn,
       emp.prl_sent_email_yn,
       emp.mobile_allowance,
       dpo.department_name         AS current_department_id,
       emp.application_id
  FROM employee_temp  emp
       LEFT JOIN l_salutation sa ON sa.salutation_id = emp.salutation_id
       LEFT JOIN l_gender lg ON lg.gender_id = emp.emp_gender_id
       LEFT JOIN  l_religion lr ON lr.religion_id = emp.emp_religion_id
       LEFT JOIN  l_blood_group lbg ON lbg.blood_group_id = emp.emp_blood_group_id
       LEFT JOIN  l_nationality lna ON lna.nationality_id = emp.emp_nationality_id
       LEFT JOIN l_quota lq ON lq.quota_id = emp.emp_quota_id
       JOIN l_emp_status les ON les.emp_status_id = emp.emp_status_id
       LEFT JOIN  l_emp_grade leg ON leg.emp_grade_id = emp.emp_grade_id
       LEFT JOIN  l_emp_grade ag ON ag.emp_grade_id = emp.actual_grade_id
       LEFT JOIN  l_emp_grade jg ON jg.emp_grade_id = emp.joining_grade_id
       LEFT JOIN  l_designation d ON d.designation_id = emp.designation_id
       LEFT JOIN  l_department dp ON dp.department_id = emp.dpt_department_id
       LEFT JOIN  l_dpt_division dv ON dv.dpt_division_id = emp.dpt_division_id
       LEFT JOIN  l_dpt_section lds ON lds.dpt_section_id = emp.section_id
       LEFT JOIN  l_emp_type let ON let.emp_type_id = emp.emp_type_id
       LEFT JOIN  l_maritial_status lms
           ON lms.maritial_status_id = emp.emp_maritial_status_id
       LEFT JOIN l_post_type lpt ON lpt.post_type_id = emp.post_type_id
       LEFT JOIN  l_ot_category loc ON loc.ot_category_id = emp.ot_category_id
       JOIN l_grade_steps lgs
           ON     lgs.grade_steps_id = emp.grade_step_id
              AND lgs.grade_id = leg.emp_grade_id
       LEFT JOIN l_banks lb ON lb.bank_id = emp.bank_id
       LEFT JOIN l_branch lbra ON lbra.branch_id = emp.branch_id
       LEFT JOIN l_appoinment_type lat
           ON lat.appoinment_type_id = emp.appointment_type_id
       LEFT JOIN l_profession_type lprt
           ON lprt.profession_type_id = emp.profession_type_id
       LEFT JOIN l_auth_doc_type ladt
           ON ladt.auth_doc_type_id = emp.auth_doc_type_id
       LEFT JOIN l_designation ldo
           ON ldo.designation_id = emp.charge_designation_id
       LEFT JOIN l_department dpo
           ON dpo.department_id = emp.current_department_id
       LEFT JOIN l_location ll ON lgs.grade_steps_id = emp.location_id
       LEFT JOIN employee co ON co.emp_id = emp.reporting_officer_id
       LEFT JOIN l_relation_type ert ON ert.relation_type_id = emp.emp_emergency_relation_id
       WHERE emp.emp_id = $emp_id";

        $employeeTemp = DB::selectOne($sql);
        $employee = (array)$employee;
        $employeeLabel = $this->employeeLabel();
       // dd($employee);
        $employeeTemp = (array)$employeeTemp;
        //dd($employee);
        unset($employee['update_date']);
        unset($employeeTemp['update_date']);
        unset($employeeLabel['update_date']);
        unset($employee['auth_document']);
        unset($employeeTemp['auth_document']);
        unset($employeeLabel['auth_document']);

        $results = array_diff($employeeTemp,$employee);


        $previousData = [];
        foreach ($results as $key=>$result){
             $previousData[$key] = $employee[$key];
        }
         return ['previous_changes' => $previousData,'current_changes' => $results,'emp_label' => $employeeLabel];
    }

    protected function employeeLabel(){
        return $label =[
              "emp_id" => "EMPLOYEE ID",
              "emp_code" => "EMPLOYEE CODE",
              "salutation_id" => 'SALUTATION',
              "emp_name" => "EMPLOYEE NAME",
              "emp_name_bng" => 'EMPLOYEE NAME BANGLA',
              "emp_father_name" => "FATHER NAME",
              "emp_father_name_bng" => "FATHER NAME BANGLA",
              "emp_mother_name" => "MOTHER NAME",
              "emp_mother_name_bng" => "MOTHER NAME BANGLA",
              "emp_dob" => "DATE OF BIRTH",
              "emp_join_date" => "EMPLOYEE JOIN DATE",
              "emp_lpr_date" => "EMPLOYEE LPR DATE",
              "emp_gender_id" => "GENDER",
              "emp_religion_id" => "EMPLOYEE RELIGION",
              "emp_blood_group_id" => "EMPLOYEE BLOOD GROUP",
              "emp_nationality_id" => "NATIONALITY",
              "emp_quota_id" => "EMPLOYEE QUOTA",
              "emp_status_id" => "STATUS",
              "emp_security_id" => "EMPLOYEE SECURITY", // No found table
              "emp_medical_book_id" => "EMPLOYEE MEDICAL BOOK", // No found table
              "identity_symbol" => "IDENTITY SYMBOL",
              "identity_symbol_bng" => "IDENTITY SYMBOL BANGLA",
              "emp_pf_id" => "EMPLOYEE PF",   // No found table
              "emp_photo" => "EMPLOYEE PHOTO",
              "emp_confirmation_date" => "EMPLOYEE CONFIRMATION DATE",
              "emp_go_number" => "OFFICE ORDER",
              "emp_go_date" => "ORDER DATE",
              "emp_bcs_batch_no" => 'BCS BATCH NO',
              "emp_grade_id" => "PAY GRADE",
              "actual_grade_id" => "ACTUAL GRADE",
              "joining_grade_id" => "JOINING GRADE",
              "dpt_division_id" => "DIVISION",
              "dpt_department_id" => "DEPARTMENT",
              "section_id" => "SECTION",
              "designation_id" => "DESIGNATION",
              "emp_class" => "CLASS III",
              "emp_type_id" => "EMPLOYEE TYPE",
              "gpf_yn" => "GPF",
              "hbl_yn" => "HBL",
              "allowance_yn" => "ALLOWANCE",
              "tax_yn" => "TAX",
              "emp_maritial_status_id" => "MARITAL STATUS",
              "reporting_officer_id" => "CONTROLLING OFFICER",  // No found table
              "post_type_id" => "POST TYPE",
              "salutation" => "SALUTATION",
              "emp_gender_name" => "MALE",
              "salutation_bng" => "SALUTATION BANGLA",
              "emp_gender_name_bng" => "GENDER BANGLA",
              "emp_religion_name" => "RELIGION",
              "previous_workplace" => "PREVIOUS WORKPLACE",
              "previous_designation" => "PREVIOUS WORKPLACE DESIGNATION",
              "previous_office_address" => "PREVIOUS WORKPLACE OFFICE ADDRESS",
              "ot_category_id" => "OT CATEGORY",
              "ot_category_name" => "OT CATEGORY NAME",
              "emp_emergency_contact_name" => "EMERGENCY CONTACT NAME",
              "emp_emergency_contact_mobile" => "EMERGENCY CONTACT MOBILE",
              "emp_emergency_relation_id" => "EMERGENCY RELATION",   // No found table
              "emp_emergency_contact_address" => "EMERGENCY CONTACT ADDRESS",
              "grade_step_id" => "PAY GRADE STEP",
              "location_id" => "LOCATION",
              "biller_code" => "BILLER CODE",
              "bill_code" => "BILL CODE",
              "bank_id" => "BANK",
              "branch_id" => "BRANCH",
              "emp_bank_acc_no" => "BANK ACC NO",
              "on_pension_yn" => "PENSION",
              "deceased_yn" => "DECEASED",
              "emp_active_yn" => "ACTIVE",
              "emp_active_date" => "ACTIVE DATE",
              "emp_religion_name_bng" => "RELIGION BANGLA",
              "emp_tin_no" => "EMP TIN NO",
              "appointment_type_id" => "APPOINTMENT TYPE",
              "nid_no" => "NID NO",
              "tribal_yn" => "TRIBAL",
              "approved_yn" => "APPROVED",
              "shift_id" => "SHIFT",
              "gpf_pct" => "GPF PCT",
              "profession_type_id" => "PROFESSION TYPE",
              /*"emp_photo_name" => "PHOTO NAME",
              "emp_photo_type" => "PHOTO TYPE",*/
              "auth_document" => "AUTHENTICATION ID",
              /*"auth_document_name" => "AUTHENTICATION DOCUMENT",
              "auth_document_type" => "AUTHENTICATION TYPE",*/
              "deputation_yn" => "DEPUTATION",
              "gpf_amount" => "GPF AMOUNT",
              "rep_designation" => "REP DESIGNATION",
              "emp_old_lpr_date" => "LPR DATE", // No found table
              "auth_doc_type_id" => "AUTH DOC TYPE",
              "old_grade_id" => "OLD GRADE ID",
              "old_grade_step_id" => "OLD GRADE STEP",
              "selection_grade_yn" => "SELECTION GRADE",
              "dead_date" => "DEAD DATE",
              "resign_date" => "RESIGN DATE",
              "last_promotion_date" => "LAST PROMOTION DATE",
              "last_increment_date" => "LAST INCREMENT DATE",
              "old_basic_amt" => "BASIC AMT",
              "additional_charge_yn" => "ADDITIONAL CHARGE",
              "addition_c_order_no" => "ADDITION C ORDER NO",
              "charge_designation_id" => "CHARGE DESIGNATION",
              "emp_hold_yn" => "EMPLOYEE HOLD",
              "prl_sent_email_yn" => "PRL_SENT_EMAIL",
              "mobile_allowance" => "MOBILE ALLOWANCE",
              "current_department_id" => "CURRENT DEPARTMENT",
              "application_id" => "APPLICATION ID",
            ];
    }
}
