<?php

namespace App\Http\Controllers\Api\V1\Pmis\Employee;

use App\Contracts\Admin\AdminContract;
use App\Contracts\Pmis\Employee\BasicInfoContract;
use App\Entities\Admin\LAppointmentType;
use App\Entities\Admin\LAuthDocType;
use App\Entities\Admin\LBank;
use App\Entities\Admin\LBloodGroup;
use App\Entities\Admin\LBranch;
use App\Entities\Admin\LDepartment;
use App\Entities\Admin\LEmpAllowances;
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
use App\Entities\Pmis\Employee\ChargeEntry;
use App\Entities\Pmis\Employee\EmpFamily;
use App\Entities\Pmis\Employee\EmployeeTemp;
use App\Entities\Security\GenNotifications;
use App\Http\Controllers\Controller;
use App\Http\Requests\BasicInfoRequest;
use App\Managers\Admin\AdminManager;
use App\Managers\Pmis\Employee\BasicInfoManager;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BasicInfoController extends Controller
{
    /** @var AdminContract|AdminManager  */
    protected $adminManager;

    /** @var BasicInfoContract|BasicInfoManager  */
    protected $basicInfoManager;

    /**
     * BasicInfoController constructor.
     * @param BasicInfoContract $basicInfoManager
     */
    public function __construct(AdminContract $adminManager,
        BasicInfoContract $basicInfoManager)
    {
        $this->adminManager = $adminManager;

        $this->basicInfoManager = $basicInfoManager;
    }

    public function index(Request $request)
    {
//        return $this->basicInfoManager->addBasicInInfo($request);

         return $this->getInitData();

     }

    /**
     * Employee designation information
     * @param $did
     * @return mixed
     */
     public function infoByDesignation($did) {
       $result = DB::selectOne('select
        sp.department_id,
        sp.designation_id,
        sp.emp_type_id,
        et.emp_type_name,
        eg.grade_range,
        eg.emp_grade_bng,
        sp.GRADE,
        sp.class
        from L_SANCTIONED_POST sp
            left join   L_EMP_TYPE et on (et.EMP_TYPE_ID = sp.EMP_TYPE_ID)
            left join   L_EMP_GRADE eg on (eg.EMP_GRADE_ID = sp.GRADE)
                where DESIGNATION_ID=:did', ['did' => $did]);

//         $data_for_emp_code = [
//             'department_id' => $result->department_id,
//             'emp_type_id' => ['value' => $result->emp_type_id],
//             'designation_id' => $result->designation_id
//         ];

//         $randomEmpCode = $this->getEmpCode($data_for_emp_code);

         $data = [
             'department_id' => $result->department_id,
             'emp_type' => ['text' => $result->emp_type_name, 'value' => $result->emp_type_id],
             'grade' => ['text' => 'GRADE '.$result->grade. ' ('.$result->grade_range.')', 'value' => $result->grade],
             'class' => $result->class,
             'designation_id' => $result->designation_id,
//             'random_emp_code' => $randomEmpCode
         ];

         return response()->json($data);
     }

    public function getEmpCode($data){

        $dep_id = intval($data['department_id']);
        $desg_id = intval($data['designation_id']);
        $emp_type_id = intval($data['emp_type_id']);
        $deputation_yn = intval($data['deputation_yn']);

        $result = DB::select('SELECT PMIS.GEN_EMP_CODE(?,?,?,?) as result from dual', [$dep_id, $desg_id, $emp_type_id, $deputation_yn]);
        $value = $result[0]->result;

        //dd($value);
        return $value;
    }

    public function getParams($depId, $desId, $empType, $deputationYn)
    {
        $params =[$depId, $empType, $desId, $deputationYn];
        return (array) DB::selectOne('SELECT PMIS.GEN_EMP_CODE(?,?,?,?) as result from dual', $params);
    }


    public function employeeProfile(Request $request){
         return $this->view($request, Auth::user()->employee->emp_id);
    }

    public function employeeProfileById(Request $request, $id){
        return $this->view($request, $id);
    }

    public function view(Request $request, $id)
    {
        $employeeTemp = new EmployeeTemp();
        $employeeDepartment = new LDepartment();
        $employeeBank = new LBank();
        $empoyeeBankBranch = new LBranch();
        $employeeGradeSteps = new LGradeSteps();
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
        $additionalCharge=new ChargeEntry();
        $empAllowance=new LEmpAllowances();

        $selectedEmployeeTemp = $employeeTemp->find($id);
        $selectedMobileAllowance = $empAllowance->where('amount', $selectedEmployeeTemp->mobile_allowance)->first();
        $reportingOfficerTemp = $employeeTemp->find($selectedEmployeeTemp->reporting_officer_id);
        $employeeSelectedMaritialStatus = $employeeMaritialStatus->find($selectedEmployeeTemp->emp_maritial_status_id);
        $employeeSelectedQuota = $employeeQuota->find($selectedEmployeeTemp->emp_quota_id);
        $employeeSelectedBloodGroup = $employeeBloodGroup->find($selectedEmployeeTemp->emp_blood_group_id);
        $employeeSelectedJobStatus = $employeeJobStatus->find($selectedEmployeeTemp->emp_status_id);
        $employeeSelectedBank = $employeeBank->find($selectedEmployeeTemp->bank_id);
        $employeeSelectedBankBranch = $empoyeeBankBranch->find($selectedEmployeeTemp->branch_id);
        $employeeSelectedGradeStep = $employeeGradeSteps->where('grade_steps_id', '=', $selectedEmployeeTemp->grade_step_id)
                                                        ->where('grade_id', '=', $selectedEmployeeTemp->emp_grade_id)
                                                        ->get();

        $employeeSelectedDepartment = $employeeDepartment->find($selectedEmployeeTemp->dpt_department_id);
        $employeeSelectedCurrentDepartment = $employeeDepartment->find($selectedEmployeeTemp->current_department_id);
        $employeeSelectedBillerCode = $employeeBillerCode->where('bill_code', '=', $selectedEmployeeTemp->biller_code)->get();
        $employeeSelectedNationality = $employeeNationality->find($selectedEmployeeTemp->emp_nationality_id);
        $employeeSelectedOtCategory = $employeeOtCategory->find($selectedEmployeeTemp->ot_category_id);
        $employeeSelectedPostType = $employeePostType->find($selectedEmployeeTemp->post_type_id);
        $employeeSelectedEmergencyRelationType = $employeeEmergencyRelationType->find($selectedEmployeeTemp->emp_emergency_relation_id);
        $employeeSelectedAppointmentType = $employeeAppointmentType->find($selectedEmployeeTemp->appointment_type_id);
        $employeeSelectedAuthDocType = $employeeAuthDocType->find($selectedEmployeeTemp->auth_doc_type_id);
        $employeeSelectedType = $employeeType->find($selectedEmployeeTemp->emp_type_id);
        $selectedEmpAddCharge=$additionalCharge->where('emp_id',$id)
                                               ->where('approved_yn','Y')
                                                ->with('chargeDptDivision','chargeDepartment','chargeDesignation')
                                               ->orderBy('c_order_no','desc')
                                               ->first();

        if ($reportingOfficerTemp) {
            $reportingOfficer = new \stdClass();

            $reportingOfficer->option_name = $reportingOfficerTemp->emp_code . ' ' . $reportingOfficerTemp->emp_name;
            $reportingOfficer->emp_id = $reportingOfficerTemp->emp_id;
            $reportingOfficer->emp_name = $reportingOfficerTemp->emp_name;

            $selectedEmployeeTemp->selectedEmployee = $reportingOfficer;
            $selectedEmployeeTemp->reporting_officer = $reportingOfficer;
        } else {
            $reportingOfficer = new \stdClass();

            $reportingOfficer->option_name = '';
            $reportingOfficer->emp_id = '';
            $reportingOfficer->emp_name = '';

            $selectedEmployeeTemp->selectedEmployee = $reportingOfficer;
            $selectedEmployeeTemp->reporting_officer = $reportingOfficer;

        }
        $currentDesignation = $this->currentDesignation($selectedEmployeeTemp->emp_id);
        $selectedEmployeeTemp->selectedMobileAllowance = $selectedMobileAllowance;
        $selectedEmployeeTemp->employeeSelectedBank = $employeeSelectedBank;
        $selectedEmployeeTemp->employeeSelectedBankBranch = $employeeSelectedBankBranch;
        $selectedEmployeeTemp->employeeSelectedGradeStep = $employeeSelectedGradeStep;
        $selectedEmployeeTemp->employeeSelectedMaritialStatus = $employeeSelectedMaritialStatus;
        $selectedEmployeeTemp->employeeSelectedBloodGroup = $employeeSelectedBloodGroup;
        $selectedEmployeeTemp->employeeSelectedQuota = $employeeSelectedQuota;
        $selectedEmployeeTemp->employeeSelectedJobStatus = $employeeSelectedJobStatus;
        $selectedEmployeeTemp->employeeSelectedDepartment = $employeeSelectedDepartment;
        $selectedEmployeeTemp->employeeSelectedCurrentDepartment = $employeeSelectedCurrentDepartment;
        $selectedEmployeeTemp->employeeSelectedBillerCode = $employeeSelectedBillerCode;
        $selectedEmployeeTemp->employeeSelectedNationality = $employeeSelectedNationality;
        $selectedEmployeeTemp->employeeSelectedOtCategory = $employeeSelectedOtCategory;
        $selectedEmployeeTemp->employeeSelectedPostType = $employeeSelectedPostType;
        $selectedEmployeeTemp->employeeSelectedEmergencyRelationType = $employeeSelectedEmergencyRelationType;
        $selectedEmployeeTemp->employeeSelectedAppointmentType = $employeeSelectedAppointmentType;
        $selectedEmployeeTemp->employeeSelectedAuthDocType = $employeeSelectedAuthDocType;
        $selectedEmployeeTemp->employeeSelectedType = $employeeSelectedType;
        $selectedEmployeeTemp->selectedEmpAddCharge = $selectedEmpAddCharge;
        $selectedEmployeeTemp->currentDesignation = $currentDesignation;

        $father = EmpFamily::select('EMP_MEMBER_NAME','EMP_MEMBER_NAME_BNG','RELATION_TYPE_ID','GENDER_ID')->where('emp_id',$id)
                ->where('RELATION_TYPE_ID',1)->first();
        $mother = EmpFamily::select('EMP_MEMBER_NAME','EMP_MEMBER_NAME_BNG','RELATION_TYPE_ID','GENDER_ID')->where('emp_id',$id)
                ->where('RELATION_TYPE_ID',2)->first();

        $selectedEmployeeTemp->emp_father_name = isset($father->emp_member_name) ? $father->emp_member_name : $selectedEmployeeTemp->emp_father_name;
        $selectedEmployeeTemp->emp_father_name_bng = isset($father->emp_member_name_bng) ? $father->emp_member_name_bng : $selectedEmployeeTemp->emp_father_name_bng;
        $selectedEmployeeTemp->emp_mother_name = isset($mother->emp_member_name) ? $mother->emp_member_name : $selectedEmployeeTemp->emp_mother_name;
        $selectedEmployeeTemp->emp_mother_name_bng = isset($mother->emp_member_name_bng) ? $mother->emp_member_name_bng : $selectedEmployeeTemp->emp_mother_name_bng;
       // dd($selectedEmployeeTemp->emp_family);

        return $selectedEmployeeTemp;

     }

     public function chargeEntryDetails(Request $request, $id){

         $sql = "SELECT DISTINCT
       (SELECT DEPARTMENT_NAME
          FROM PMIS.L_DEPARTMENT
         WHERE DEPARTMENT_ID = ce.DPT_DEPARTMENT_ID)
           DEPARTMENT,
       LDD.DPT_DIVISION_NAME
           DIVISION,
       NVL (
           (SELECT DISTINCT d.designation
              FROM CHARGE_ENTRY  ce
                   INNER JOIN l_designation d
                       ON (d.designation_id = ce.designation_id)
             WHERE     emp_id = e.emp_id
                   AND SYSDATE BETWEEN CHARGE_ACTIVATION_DATE
                                   AND NVL (CHARGE_END_DATE, SYSDATE)
                   AND ROWNUM = 1),
           LD.DESIGNATION)
           designation,
       e.emp_code,
       lc.charge_type_name
  FROM pmis.employee  e
       LEFT JOIN pmis.charge_entry ce ON (e.emp_code = ce.emp_code)
       LEFT JOIN pmis.l_dpt_division ldd
           ON (ldd.dpt_division_id = ce.charge_dpt_division_id)
       LEFT JOIN pmis.l_designation ld
           ON (ld.designation_id = ce.charge_designation_id)
       INNER JOIN pmis.l_charge_type lc
           ON (lc.charge_type_id = ce.charge_type_id)
 WHERE e.emp_id = :p_emp_id";

         $chargeData = DB::selectOne($sql,['p_emp_id'=> $id]);


         $chargeDataString = ['chargeEntry' => $chargeData];
//         dd($chargeData);
         return $chargeDataString;
     }

     private function currentDesignation($emp_id){
         $sql = "SELECT DISTINCT designation FROM EMPLOYEE a,l_designation tn, CHARGE_ENTRY cn
                               WHERE     tn.designation_id =
                                         cn.charge_designation_id
                                     AND a.emp_id = cn.emp_id
                                     AND a.emp_id =
                                         NVL ( :emp_id, a.emp_id )
                                     AND SYSDATE BETWEEN cn.CHARGE_ACTIVATION_DATE
                                                     AND NVL (cn.CHARGE_END_DATE,
                                                              SYSDATE)
                                                              and  ROWNUM = 1";
         $designation = DB::selectOne($sql,['emp_id'=>$emp_id]);

         return $designation;
     }
     public function payGrades(Request $request, $empTypeId)
     {
         return $this->paygradeByEmployeeType($empTypeId);
     }

     public function employeeInformation(Request $request, $name)
     {
         $employeeList = DB::table('employee')->select('emp_id','emp_code',DB::raw("emp_code||' '||emp_name AS option_name"),'emp_name','designation_id','dpt_department_id','section_id','bill_code')
             ->where(function($query) use ($name){
                 $query->where(DB::raw('LOWER(emp_name)'),'like',strtolower('%'.$name.'%'))
                     ->orWhere('emp_code', 'like', '%'.$name."%" );
             })
             ->groupBy('emp_id','emp_code','emp_name','designation_id','dpt_department_id','section_id','bill_code')
             ->limit(20)
             ->get();

         return $employeeList;
     }

    public function controllingOfficer(Request $request, $name)
    {
//        $employeeList = DB::table('employee')
//            ->join('cpa_security.sec_users', 'cpa_security.sec_users.emp_id', '=', 'pmis.employee.emp_id')
//            ->join('cpa_security.sec_user_roles', 'cpa_security.sec_user_roles.user_id', '=', 'cpa_security.sec_users.user_id')
//            ->join('cpa_security.sec_role', 'cpa_security.sec_role.role_id', '=', 'cpa_security.sec_user_roles.role_id')
//            ->where(function($query) use ($name){
//                $query->where(DB::raw('LOWER(emp_name)'),'like',strtolower('%'.$name.'%'))
//                    ->orWhere('emp_code', 'like', '%'.$name."%" );
//            })
//            ->where('cpa_security.sec_role.role_key','=','CONTROLING_OFFICER')
//            ->groupBy('emp_id','emp_code','emp_name','designation_id','dpt_department_id','section_id','bill_code')
//            ->limit(20)
//            ->select('emp_id','emp_code',DB::raw("emp_code||' '||emp_name AS option_name"),'emp_name','designation_id','dpt_department_id','section_id','bill_code')
//            ->get();

        $department_id = $_REQUEST['department'];
        $sql = <<<QUERY
select t2.*
from (select rownum AS "rn", t1.*
      from (select emp."EMP_ID",
                   "EMP_CODE",
                   emp_code || ' ' || emp_name AS option_name,
                   "EMP_NAME",
                   "DESIGNATION_ID",
                   "DPT_DEPARTMENT_ID",
                   "SECTION_ID",
                   "BILL_CODE"
            from EMPLOYEE emp
                     inner join  CPA_SECURITY.SEC_USERS su
                                on (su.EMP_ID = emp.EMP_ID)
                     inner join CPA_SECURITY.SEC_USER_ROLES sur
                                on (sur.USER_ID = su.USER_ID)
                     inner join CPA_SECURITY.SEC_ROLE sr
                                on(sr.role_id = sur.role_id)
            where (LOWER(emp_name) like :param  or "EMP_CODE" like :param)
            and emp.DPT_DEPARTMENT_ID = nvl(:department,emp.DPT_DEPARTMENT_ID)
            and sr.ROLE_KEY = 'CONTROLING_OFFICER'
            group by emp."EMP_ID", "EMP_CODE", "EMP_NAME", "DESIGNATION_ID", "DPT_DEPARTMENT_ID", "SECTION_ID",
                     "BILL_CODE") t1) t2
where t2."rn" between 1 and 20

QUERY;
        $employeeList = DB::select($sql,['param'=>'%'.$name.'%', 'department' => $department_id]);

        return $employeeList;
    }


public  function allcontrollingOfficer(Request $request, $id){
//    $department_id = $_REQUEST['department'];
    $sql = <<<QUERY
select t2.*
from (select rownum AS "rn", t1.*
      from (select emp."EMP_ID",
                   "EMP_CODE",
                   emp_code || ' ' || emp_name AS option_name,
                   "EMP_NAME",
                   "DESIGNATION_ID",
                   "DPT_DEPARTMENT_ID",
                   "SECTION_ID",
                   "BILL_CODE"
            from EMPLOYEE emp
                     inner join  CPA_SECURITY.SEC_USERS su
                                on (su.EMP_ID = emp.EMP_ID)
                     inner join CPA_SECURITY.SEC_USER_ROLES sur
                                on (sur.USER_ID = su.USER_ID)
                     inner join CPA_SECURITY.SEC_ROLE sr
                                on(sr.role_id = sur.role_id)
            where (LOWER(emp_name) like :param  or "EMP_CODE" like :param)
            and sr.ROLE_KEY = 'CONTROLING_OFFICER'
            group by emp."EMP_ID", "EMP_CODE", "EMP_NAME", "DESIGNATION_ID", "DPT_DEPARTMENT_ID", "SECTION_ID",
                     "BILL_CODE") t1) t2
where t2."rn" between 1 and 20

QUERY;
    $allemployeeList = DB::select($sql, ['param'=>'%'.$id.'%']);

    return $allemployeeList;
}


     public function uniqueEmployeeCode(Request $request)
     {
         $employeeId = $request->get('emp_id');
         $employeeCode = $request->get('emp_code');
         $employeeSelect = DB::table('employee')->select('emp_id', 'emp_code')->where('emp_code', $employeeCode)->first();
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
//        dd($request->post());
        return $this->basicInfoManager->addBasicInInfo($request);
    }

    public function updateGpfSubscription(Request $request, $id)
    {
        return $this->basicInfoManager->updateGpfSubscription($request);
    }

    public function update(Request $request)
    {
        if ($request->get('emp_photo_type') !== 'jpg' && $request->get('emp_photo_type') !== 'jpeg'){
            return ['status' => false, 'o_status_code'=> 99, 'o_status_message' => 'Please upload only jpg image'];
        }
        return $this->basicInfoManager->updateProfile($request);
    }

    public function getNotification($id){
         $query = "select * from cpa_security.gen_notifications where notification_id = $id";
         $data = DB::selectOne($query);
         return response()->json($data);
    }

    public function seen_notification(){
         $user_id = Auth::user()->user_id;
         $result = GenNotifications::where('notification_to', $user_id)->orWhereNull('notification_to')
            ->update(['seen_yn' => 'Y']);
         return $result;
    }

    public function remove(Request $request)
    {
        //TODO: Default template for action.
    }

    public function gpfSubscription(Request $request, $id)
    {
        $employeeTemp = DB::table('employee_temp')->select('emp_code','emp_id', 'gpf_pct', 'gpf_amount')->where('emp_id', $id)->first();
        $query = "select emp_gpf_summary_data_pmis(:p1) from dual";
        $gpf_summary_data=DB::selectOne($query,['p1' => $employeeTemp->emp_code]);
        return response()->json(['gpf_summary_data'=>$gpf_summary_data,
                                'emp_id' => $employeeTemp->emp_id,
                                'emp_code'=>$employeeTemp->emp_code,
                                'gpf_pct' => $employeeTemp->gpf_pct,
                                'gpf_amount' => $employeeTemp->gpf_amount]);
    }

    /**
     * @return array
     */
    private function getInitData() {
        $arr = [
            0 => [
                "text" => "Select one",
                "value" => ""
            ],
            1 => [
                "text" => "50%",
                "value" => "50"
            ],
            2 => [
                "text" => "100%",
                "value" => "100"
            ]
        ];

        return [
            "mobileAllowances" => $this->mobileAllowances(),
            "mobileAllowances" => $this->mobileAllowances(),
            "mobileAllowances" => $this->mobileAllowances(),
            "mobileAllowances" => $this->mobileAllowances(),
            "mobileAllowances" => $this->mobileAllowances(),
            "payGrade" => $this->empGrads(),
            "actualGrads" => $this->empActualGrads(),
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
            'gender_options'=> $this->gender_options(),
            'auth_type_ids' => $this->adminManager->findAuthDocTypes(),
            'appointmentType' => $this->appointmentType(),
            'relations' => $this->relationType(),
            'pensionCat' => $arr,
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

    private function mobileAllowances() {
        $mobile_allowances = [];
        foreach ($this->adminManager->findMobileAllowances() as $item) {
            $mobile_allowances[] = ["text" => $item->amount, 'value' => $item->id];
        }
        return $mobile_allowances;
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

    private function gender_options() {
        $genders = [];
        foreach ($this->adminManager->findGenders() as $item) {
            $genders[] = ["text" => $item->gender_name, 'value' => $item->gender_id];
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
