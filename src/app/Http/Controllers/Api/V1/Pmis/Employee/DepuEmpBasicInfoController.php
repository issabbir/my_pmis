<?php

namespace App\Http\Controllers\Api\V1\Pmis\Employee;

use App\Contracts\Admin\AdminContract;
use App\Contracts\Pmis\Employee\DepuEmpBasicInfoContract;
use App\Entities\Admin\LAppointmentType;
use App\Entities\Admin\LAuthDocType;
use App\Entities\Admin\LBank;
use App\Entities\Admin\LBloodGroup;
use App\Entities\Admin\LBranch;
use App\Entities\Admin\LDepartment;
use App\Entities\Admin\LEmpStatus;
use App\Entities\Admin\LEmpType;
use App\Entities\Admin\LGradeSteps;
use App\Entities\Admin\LMaritalStatus;
use App\Entities\Admin\LNationality;
use App\Entities\Admin\LOtCategory;
use App\Entities\Admin\LPostType;
use App\Entities\Admin\LQuota;
use App\Entities\Admin\LRelationType;
use App\Entities\Admin\PrBillCodeMaster;
use App\Entities\Pmis\Employee\EmployeeDepu;
use App\Http\Controllers\Controller;
use App\Http\Requests\BasicInfoRequest;
use App\Managers\Admin\AdminManager;
use App\Managers\Pmis\Employee\DepuEmpBasicInfoManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepuEmpBasicInfoController extends Controller
{
    /** @var AdminContract|AdminManager  */
    protected $adminManager;

    /** @var DepuEmpBasicInfoContract|DepuEmpBasicInfoManager  */
    protected $depuEmpBasicInfoManager;

    /**
     * DepuEmpBasicInfoController constructor.
     * @param DepuEmpBasicInfoContract $depuEmpBasicInfoManager
     */
    public function __construct(AdminContract $adminManager,DepuEmpBasicInfoContract $depuEmpBasicInfoManager)
    {
        $this->adminManager = $adminManager;
        $this->depuEmpBasicInfoManager = $depuEmpBasicInfoManager;
    }

    public function index(Request $request)
    {
         return $this->getInitData();
     }

    public function view(Request $request, $id)
    {
        $employeeDepu = new EmployeeDepu();
        $employeeDepartment = new LDepartment();
        $employeeBank = new LBank();
        $empoyeeBankBranch = new LBranch();
        $employeeMaritialStatus = new LMaritalStatus();
        $employeeBloodGroup = new LBloodGroup();
        $employeeJobStatus = new LEmpStatus();
        $employeeQuota = new LQuota();
        $employeeBillerCode = new PrBillCodeMaster();
        $employeeNationality = new LNationality();
        $employeeOtCategory = new LOtCategory();
        $employeePostType = new LPostType();
        $employeeEmergencyRelationType = new LRelationType();
        $employeeAppointmentType = new LAppointmentType();
        $employeeAuthDocType = new LAuthDocType();
        $employeeType = new LEmpType();
        $employeeGradeSteps = new LGradeSteps();


        $selectedEmployee = $employeeDepu->find($id);
        $employeeSelectedGradeStep = $employeeGradeSteps->where('grade_steps_id', '=', $selectedEmployee->grade_step_id)
            ->where('grade_id', '=', $selectedEmployee->grade_id)
            ->get();
        $employeeSelectedMaritialStatus = $employeeMaritialStatus->find($selectedEmployee->emp_maritial_status_id);
        $employeeSelectedQuota = $employeeQuota->find($selectedEmployee->emp_quota_id);
        $employeeSelectedBloodGroup = $employeeBloodGroup->find($selectedEmployee->emp_blood_group_id);
        $employeeSelectedJobStatus = $employeeJobStatus->find($selectedEmployee->emp_status_id);
        $employeeSelectedBank = $employeeBank->find($selectedEmployee->bank_id);
        $employeeSelectedBankBranch = $empoyeeBankBranch->find($selectedEmployee->branch_id);
        $employeeSelectedDepartment = $employeeDepartment->find($selectedEmployee->dpt_department_id);
        $employeeSelectedBillerCode = $employeeBillerCode->where('bill_code', '=', $selectedEmployee->biller_code)->get();
        $employeeSelectedNationality = $employeeNationality->find($selectedEmployee->emp_nationality_id);
        $employeeSelectedOtCategory = $employeeOtCategory->find($selectedEmployee->ot_category_id);
        $employeeSelectedPostType = $employeePostType->find($selectedEmployee->post_type_id);
        $employeeSelectedEmergencyRelationType = $employeeEmergencyRelationType->find($selectedEmployee->emp_emergency_relation_id);
        $employeeSelectedAppointmentType = $employeeAppointmentType->find($selectedEmployee->appointment_type_id);
        $employeeSelectedAuthDocType = $employeeAuthDocType->find($selectedEmployee->auth_doc_type_id);
        $employeeSelectedType = $employeeType->find($selectedEmployee->emp_type_id);

        $selectedEmployee->employeeSelectedBank = $employeeSelectedBank;
        $selectedEmployee->employeeSelectedBankBranch = $employeeSelectedBankBranch;
        $selectedEmployee->employeeSelectedGradeStep = $employeeSelectedGradeStep;
        $selectedEmployee->employeeSelectedMaritialStatus = $employeeSelectedMaritialStatus;
        $selectedEmployee->employeeSelectedBloodGroup = $employeeSelectedBloodGroup;
        $selectedEmployee->employeeSelectedQuota = $employeeSelectedQuota;
        $selectedEmployee->employeeSelectedJobStatus = $employeeSelectedJobStatus;
        $selectedEmployee->employeeSelectedDepartment = $employeeSelectedDepartment;
        $selectedEmployee->employeeSelectedBillerCode = $employeeSelectedBillerCode;
        $selectedEmployee->employeeSelectedNationality = $employeeSelectedNationality;
        $selectedEmployee->employeeSelectedOtCategory = $employeeSelectedOtCategory;
        $selectedEmployee->employeeSelectedPostType = $employeeSelectedPostType;
        $selectedEmployee->employeeSelectedEmergencyRelationType = $employeeSelectedEmergencyRelationType;
        $selectedEmployee->employeeSelectedAppointmentType = $employeeSelectedAppointmentType;
        $selectedEmployee->employeeSelectedAuthDocType = $employeeSelectedAuthDocType;
        $selectedEmployee->employeeSelectedType = $employeeSelectedType;

        return $selectedEmployee;
     }

     public function payGrades(Request $request, $empTypeId)
     {
         return $this->paygradeByEmployeeType($empTypeId);
     }

     public function employeeInformation(Request $request, $name)
     {
         $employeeList = DB::table('employee_depu')->select('emp_id','emp_code',DB::raw("emp_code||' '||emp_name AS option_name"),'emp_name','designation_id','dpt_department_id','section_id','bill_code')
             ->where(function($query) use ($name){
                 $query->where(DB::raw('LOWER(emp_name)'),'like',strtolower('%'.$name.'%'))
                     ->orWhere('emp_code', 'like', '%'.$name."%" );
             })
             ->groupBy('emp_id','emp_code','emp_name','designation_id','dpt_department_id','section_id','bill_code')
             ->limit(20)
             ->get();

         return $employeeList;
     }

     public function uniqueEmployeeCode(Request $request)
     {
         $employeeId = $request->get('emp_id');
         $employeeCode = $request->get('emp_code');
         $employeeSelect = DB::table('employee_depu')->select('emp_id', 'emp_code')->where('emp_code', $employeeCode)->first();
         $IsAvlEmployee= DB::table('employee')->select('emp_id', 'emp_code')->where('emp_code', $employeeCode)->first();
         $uniqueMessage = '';
        if(strlen($employeeCode)<6){
            $uniqueMessage = 'Employee code must be 6 digit!';
        }else{
            if($employeeId) {
                if($employeeSelect) {
                    if($employeeSelect->emp_id != $employeeId) {
                        $uniqueMessage = 'The given code already exists!';
                    }
                }
            } else {
                if($employeeSelect) {
                    $uniqueMessage = 'The given code already exists!';
                }
            }
        }
         return response()->json(['unique_message' => $uniqueMessage]);
     }

    public function checkIsValidNID(Request $request)
    {
        //dd((int)strlen($request->get('auth_id'))!==10);
        $authId =strlen($request->get('auth_id'));
        $authTypeId =$request->get('auth_type');
        $uniqueMessage = '';
        if($authTypeId==1){
            if($authId!==10 && $authId!==13 && $authId!==17) {
                $uniqueMessage = 'Invalid National ID';
            }
        }else if($authTypeId==2){
            if($authId!==9) {
                $uniqueMessage = 'Invalid Passport ID';
            }
        }else{
            if($authId!==17) {
                $uniqueMessage = 'Invalid birth certificate ID';
            }
        }

        return response()->json(['unique_message' => $uniqueMessage]);

    }

    public function store(BasicInfoRequest $request)
    {
        return $this->depuEmpBasicInfoManager->addBasicInInfo($request);
    }

    public function updateGpfSubscription(Request $request, $id)
    {
        return $this->depuEmpBasicInfoManager->updateGpfSubscription($request);
    }

    public function update(Request $request, $id)
    {
        //TODO: Default template for action.
    }

    public function remove(Request $request)
    {
        //TODO: Default template for action.
    }

    public function gpfSubscription(Request $request, $id)
    {
        $employeeDepu = DB::table('employee_depu')->select('emp_code','emp_id', 'gpf_pct', 'gpf_amount')->where('emp_id', $id)->first();
        $query = "select emp_gpf_summary_data_pmis(:p1) from dual";
        $gpf_summary_data=DB::selectOne($query,['p1' => $employeeDepu->emp_code]);
        return response()->json(['gpf_summary_data'=>$gpf_summary_data,
                                'emp_id' => $employeeDepu->emp_id,
                                'emp_code'=>$employeeDepu->emp_code,
                                'gpf_pct' => $employeeDepu->gpf_pct,
                                'gpf_amount' => $employeeDepu->gpf_amount]);
    }

    /**
     * @return array
     */
    private function getInitData() {
        return [
            "payGrade" => $this->empGrads(),
            "salutation" => $this->salutation(),
            "dptDivision" => $this->dptDivisions(),
            "department" => $this->departments(),
            "allDepartment" => $this->allDepartments(),
            "designation" => $this->designation(),
            "empType" => $this->empTypes(),
            "quota" => $this->quota(),
            "status" => $this->empStatus(),
            "maritalStatus" => $this->maritalStatus(),
            "bloodGroup" => $this->bloodGroups(),
            "nationality" => $this->nationality(),
            "postType" => $this->postType(),
            "location" => $this->location(),
            "banks" => $this->banks(),
            "billerCodes" => $this->billerCodes(),
            "branches" => $this->branches(),
            "sections" => $this->sections(),
            "religions" => $this->religions(),
            "otCategories" => $this->otCategories(),
            "employees" => $this->employees(),
            'genders' => $this->genders(),
            'auth_type_ids' => $this->adminManager->findAuthDocTypes(),
            'appointmentType' => $this->appointmentType(),
            'relations' => $this->relationType(),
         ];
    }

    /**
     * FIXME: Pay grade should have a mapping with employee type. Its not currently available. But for presentation purpose
     * we are fixing by hard coded value.
     */
    private function paygradeByEmployeeType($employeeType) {

        $grades = [];
        $grades[] = ["value" => null, 'text' => 'Select Grade'];
        foreach ($this->adminManager->findPayGradeByEmployeeType($employeeType) as $item) {
            $grades[] = ["text" =>"Grade ".$item->emp_grade_id." (".$item->grade_range.")", 'value' => $item->emp_grade_id];
        }
        return $grades;
    }

    /**
     * @return array
     */
    private function empGrads() {
        $grades = [];
        $grades[] = ["value" => null, 'text' => 'Select Grade'];
         foreach ($this->adminManager->findEmpGrads() as $item) {
            $grades[] = ["text" => $item->grade_range, 'value' => $item->emp_grade_id];
        }
         return $grades;
    }
    /**
     * @return array
     */
    private function salutation() {
        $salutation = [];
        $salutation[] = ["value" => null, 'text' => 'Select Salutation'];
         foreach ($this->adminManager->findSalutation() as $item) {
            $salutation[] = ["text" => $item->salutation, 'value' => $item];
        }
         return $salutation;
    }

    /**
     * @return array
     */
    private function salutationById($id) {
        $salutation = [];
        $salutation[] = ["value" => null, 'text' => 'Select Salutation'];
        foreach ($this->adminManager->findSalutation() as $item) {
            $salutation[] = ["text" => $item->salutation, 'value' => $item];
        }
        return $salutation;
    }

    /**
     * @return array
     */
    private function dptDivisions() {
        $dptDivisions = [];
        $dptDivisions[] = ["value" => null, 'text' => 'Select Divisions'];
         foreach ($this->adminManager->findDptDivisions() as $item) {
            $dptDivisions[] = ["text" => $item->dpt_division_name, 'value' => $item->dpt_division_id];
        }
         return $dptDivisions;
    }
    /**
     * @return array
     */
    private function departments() {
        $departments = [];
        $departments[] = ["value" => null, 'text' => 'Select Departments'];
         foreach ($this->adminManager->findDepartments() as $item) {
            $departments[] = ["text" => $item->department_name, 'value' => $item->department_id];
        }
         return $departments;
    }
    /**
     * @return array
     */
    private function allDepartments() {
        $departments = [];
        $departments[] = ["value" => null, 'text' => 'Select Departments'];
         foreach ($this->adminManager->findAllDepartments() as $item) {
            $departments[] = ["text" => $item->department_name, 'value' => $item->department_id];
        }
         return $departments;
    }
    /**
     * @return array
     */
    private function designation() {
        $designation = [];
        $designation[] = ["value" => null, 'text' => 'Select Designations'];
         foreach ($this->adminManager->findDesignations() as $item) {
            $designation[] = ["text" => $item->designation, 'value' => $item->designation_id];
        }
         return $designation;
    }

    /**
     * @return array
     */
    private function empTypes() {
        $empTypes = [];
        $empTypes[] = ["value" => null, 'text' => 'Select Employee Types'];
         foreach ($this->adminManager->findEmpTypes() as $item) {
            $empTypes[] = ["text" => $item->emp_type_name, 'value' => $item->emp_type_id];
        }
         return $empTypes;
    }

     /**
     * @return array
     */
    private function quota() {
        $quota = [];
        $quota[] = ["value" => null, 'text' => 'Select Quota'];
         foreach ($this->adminManager->findQuota() as $item) {
            $quota[] = ["text" => $item->quota_name, 'value' => $item->quota_id];
        }
         return $quota;
    }
    /**
     * @return array
     */
    private function empStatus() {
        $empStatus = [];
        $empStatus[] = ["value" => null, 'text' => 'Select Employee Status'];
         foreach ($this->adminManager->findEmpStatus() as $item) {
            $empStatus[] = ["text" => $item->emp_status, 'value' => $item->emp_status_id];
        }
         return $empStatus;
    }
    /**
     * @return array
     */
    private function maritalStatus() {
        $maritalStatus = [];
        $maritalStatus[] = ["value" => null, 'text' => 'Select Marital Status'];
         foreach ($this->adminManager->findMaritalStatus() as $item) {
            $maritalStatus[] = ["text" => $item->maritial_status, 'value' => $item->maritial_status_id];
        }
         return $maritalStatus;
    }
    /**
     * @return array
     */
    private function bloodGroups() {
        $bloodGroups = [];
        $bloodGroups[] = ["value" => null, 'text' => 'Select Blood Group'];
         foreach ($this->adminManager->findBloodGroups() as $item) {
            $bloodGroups[] = ["text" => $item->blood_group, 'value' => $item->blood_group_id];
        }
         return $bloodGroups;
    }
    /**
     * @return array
     */
    private function nationality() {
        $nationality = [];
        $nationality[] = ["value" => null, 'text' => 'Select Nationality'];
         foreach ($this->adminManager->findNationality() as $item) {
            $nationality[] = ["text" => $item->nationality, 'value' => $item->nationality_id];
        }
         return $nationality;
    }
    /**
     * @return array
     */
    private function postType() {
        $postTypes = [];
        $postTypes[] = ["value" => null, 'text' => 'Select Post Type'];
         foreach ($this->adminManager->findPostType() as $item) {
            $postTypes[] = ["text" => $item->post_type, 'value' => $item->post_type_id];
        }
         return $postTypes;
    }
    /**
     * @return array
     */
    private function location() {
        $locations = [];
        $locations[] = ["value" => null, 'text' => 'Select Locations'];
         foreach ($this->adminManager->findLocation() as $item) {
            $locations[] = ["text" => $item->working_location, 'value' => $item->location_id];
        }
         return $locations;
    }

    /**
     * @return array
     */
    private function banks() {
        $banks = [];
        $banks[] = ["value" => null, 'text' => 'Select Bank'];
         foreach ($this->adminManager->findBanks() as $item) {
            $banks[] = ["text" => $item->bank_name, 'value' => $item->bank_id];
        }
         return $banks;
    }

    /**
     * IN HURRY! QUICK FIXING THE ISSUE.
     * @return array
     */
    public function billerCodes()
    {
        // pr_bill_code_master
        $prBillCodeMaster = PrBillCodeMaster::where('activation_flag', 'Y')->orderBy('bill_code', 'ASC')->get();
        $billerCodes = [];
        $billerCodes[] = ["value" => null, 'text' => 'Select Biller Code'];

        foreach ($prBillCodeMaster as $item) {
            $billerCodes[] = ["text" => $item->bill_code, 'value' => $item->bill_code];
        }

        return $billerCodes;
    }

    /**
     * @return array
     */
    private function branches() {
        $branch = [];
        $branch[] = ["value" => null, 'text' => 'Select Branch'];
         foreach ($this->adminManager->findBranches() as $item) {
            $branch[] = ["text" => $item->branch_name, 'value' => $item->branch_id];
        }
         return $branch;
    }
    /**
     * @return array
     */
    private function sections() {
        $sections = [];
        $sections[] = ["value" => null, 'text' => 'Select Section'];
         foreach ($this->adminManager->findDptSections() as $item) {
            $sections[] = ["text" => $item->dpt_section, 'value' => $item->dpt_section_id];
        }
         return $sections;
    }
    /**
     * @return array
     */
    private function gradeSteps() {
        $gradeSteps = [];
        $gradeSteps[] = ["value" => null, 'text' => 'Select Grade Step'];
         foreach ($this->adminManager->findGradeSteps() as $item) {
            $gradeSteps[] = ["text" => $item->basic_amt, 'value' => $item->grade_steps_id];
        }
         return $gradeSteps;
    }
    /**
     * @return array
     */
    private function religions() {
        $religions = [];
        $religions[] = ["value" => null, 'text' => 'Select Religion'];
         foreach ($this->adminManager->findReligion() as $item) {
            $religions[] = ["text" => $item->religion, 'value' => $item->religion_id,'religion_bng'=>$item->religion_bng];
        }
         return $religions;
    }
    /**
     * @return array
     */
    private function otCategories() {
        $otCategories = [];
        $otCategories[] = ["value" => null, 'text' => 'Select OT Category'];
         foreach ($this->adminManager->findOtCategories() as $item) {
            $otCategories[] = ["text" => $item->ot_category, 'value' => $item->ot_category_id];
        }
         return $otCategories;
    }

    private function employees() {
        $employees = [];
        $employees[] = ["value" => null, 'text' => 'Select Reporting Officer'];

        return $employees;
    }

    private function genders() {
        $genders = [];
         foreach ($this->adminManager->findGenders() as $item) {
            $genders[] = ["text" => $item->gender_name, 'value' => $item];
        }
         return $genders;
    }
    private function appointmentType() {
        $appointmentType = [];
         $appointmentType[] = ["value" => null, 'text' => 'Select Appointment Type'];
         foreach ($this->adminManager->findAppointmentTypes() as $item) {
            $appointmentType[] = ["text" => $item->appoinment_type, 'value' => $item->appoinment_type_id];
        }
         return $appointmentType;
    }
    private function relationType() {
        $relationType = [];
         $relationType[] = ["value" => null, 'text' => 'Select Relation'];
         foreach ($this->adminManager->findRelationType() as $item) {
            $relationType[] = ["text" => $item->relation_type, 'value' => $item->relation_type_id];
        }
         return $relationType;
    }
    private function classType() {
        $genders = [];
         foreach ($this->adminManager->findGenders() as $item) {
            $genders[] = ["text" => $item->gender_name, 'value' => $item->gender_id];
        }
         return $genders;
    }
}
