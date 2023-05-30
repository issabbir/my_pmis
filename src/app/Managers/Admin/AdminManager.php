<?php

namespace App\Managers\Admin;

use App\Contracts\Admin\AdminContract;
use App\Entities\Admin\HrDepartment;
use App\Entities\Admin\HrDesignation;
use App\Entities\Admin\HrDivision;
use App\Entities\Admin\HrExamBody;
use App\Entities\Admin\HrSection;
use App\Entities\Admin\HrLocDivision;
use App\Entities\Admin\HrLocDistrict;
use App\Entities\Admin\HrLocThana;
use App\Entities\Admin\LAddressType;
use App\Entities\Admin\LAppointmentType;
use App\Entities\Admin\LAuthDocType;
use App\Entities\Admin\LBank;
use App\Entities\Admin\LBillHead;
use App\Entities\Admin\LBloodGroup;
use App\Entities\Admin\LBranch;
use App\Entities\Admin\LBranchView;
use App\Entities\Admin\LCompany;
use App\Entities\Admin\LContactType;
use App\Entities\Admin\LDepartment;
use App\Entities\Admin\LDesignation;
use App\Entities\Admin\LDocs;
use App\Entities\Admin\LDocType;
use App\Entities\Admin\LDptDivision;
use App\Entities\Admin\LDptSection;
use App\Entities\Admin\LEmpAllowances;
use App\Entities\Admin\LEmpGrade;
use App\Entities\Admin\LEmpStatus;
use App\Entities\Admin\LEmpType;
use App\Entities\Admin\LExam;
use App\Entities\Admin\LExamSubject;
use App\Entities\Admin\LExamBody;
use App\Entities\Admin\LExamResult;
use App\Entities\Admin\LExamResultType;
use App\Entities\Admin\LFamilyMemberStatus;
use App\Entities\Admin\LGender;
use App\Entities\Admin\LGeoCountry;
use App\Entities\Admin\LGeoDistrict;
use App\Entities\Admin\LGeoDivision;
use App\Entities\Admin\LGeoThana;
use App\Entities\Admin\LGradeSteps;
use App\Entities\Admin\LHoliday;
use App\Entities\Admin\LInstitute;
use App\Entities\Admin\LLeaveType;
use App\Entities\Admin\LLocation;
use App\Entities\Admin\LMaritalStatus;
use App\Entities\Admin\LModule;
use App\Entities\Admin\LNationality;
use App\Entities\Admin\LNomineeFor;
use App\Entities\Admin\LOptions;
use App\Entities\Admin\LOtCategory;
use App\Entities\Admin\LPostType;
use App\Entities\Admin\LProfessionType;
use App\Entities\Admin\LQuota;
use App\Entities\Admin\LRelationType;
use App\Entities\Admin\LReligion;
use App\Entities\Admin\LRole;
use App\Entities\Admin\LRoleEmp;
use App\Entities\Admin\LRosterShift;
use App\Entities\Admin\LSalutation;
use App\Entities\Admin\LSectionLocation;
use App\Entities\Admin\LService;
use App\Entities\Admin\LTourType;
use App\Entities\Admin\LTraining;
use App\Entities\Admin\LTrainingType;
use App\Entities\Admin\LUserLookups;
use App\Entities\Admin\LWorkFlow;
use App\Entities\Pension\PensionHeads;
use App\Entities\Pmis\Employee\Employee;
use App\Entities\Security\Menu;
use App\Entities\Security\Module;
use App\Entities\Security\Permission;
use App\Entities\Security\Report;
use App\Entities\Security\Submenu;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminManager implements AdminContract
{


    protected $user;

    public function __construct(Guard $auth)
    {
        $this->user = $auth->user();
    }

    /**
     * Get one or more division based on parameter
     *
     * @param null $id
     * @return mixed
     */
    public function findDptDivisions($id = null)
    {
        $division = new LDptDivision();
        if ($id)
            return $division->find($id);
        return $division->orderBy("dpt_division_name", 'asc')->get();
    }

    /**
     * Get one or more division based on parameter
     *
     * @param null $id
     * @return mixed
     */
    public function findCommonLookups($p_type = null)
    {
        if ($p_type)
            $sql = "select common_lookups_list(:p_type) from dual";
        return $list = DB::select($sql, ['p_type' => $p_type]);
    }

    /**
     * Get one or more departments based on parameter
     *
     * @param null $id
     * @return mixed
     */
    public function findEmployeeTypes($id = null)
    {
        $row = new \stdClass();
        $row->employee_type_id = null;
        $row->employee_type_name = 'ALL';
        $row->text = 'Select One';
        $row->value = null;
        $employee_type = new LEmpType();
        if ($id)
            return $employee_type->find($id);

        $hasPermission = Auth()->user()->hasPermission('CAN_SEE_ALL_DEPARTMENT');

        if ($hasPermission) {
            $emp_types = $employee_type->orderBy("emp_type_id", 'ASC')->get();
            $emp_types[sizeof($emp_types)] =  $row;
            return $emp_types;
        }

//        $employee = new Employee();
//        $employee = $employee->find(Auth()->user()->emp_id);

//        if ($employee && $employee->dpt_department_id)
//            return $department->where('department_id', $employee->dpt_department_id)->orderBy("department_name", 'ASC')->get();
//        if ($employee && $employee->current_department_id)
//            return $department->where('department_id', $employee->current_department_id)->orderBy("department_name", 'ASC')->get();

        return [];
    }

    /**
     * Get one or more departments based on parameter
     *
     * @param null $id
     * @return mixed
     */
    public function findDepartments($id = null)
    {
        $row = new \stdClass();
        $row->department_id = null;
        $row->department_name = 'ALL';
        $row->text = 'Select One';
        $row->value = null;
        $department = new LDepartment();
        if ($id)
            return $department->find($id);

        $hasPermission = Auth()->user()->hasPermission('CAN_SEE_ALL_DEPARTMENT');

        if ($hasPermission) {
            $departments = $department->orderBy("department_name", 'ASC')->get();
            $departments[sizeof($departments)] =  $row;
            return $departments;
        }

        $employee = new Employee();
        $employee = $employee->find(Auth()->user()->emp_id);

//        if ($employee && $employee->dpt_department_id)
//            return $department->where('department_id', $employee->dpt_department_id)->orderBy("department_name", 'ASC')->get();
        if ($employee && $employee->current_department_id)
            return $department->where('department_id', $employee->current_department_id)->orderBy("department_name", 'ASC')->get();

        return [];
    }

    /**
     * Get one or more departments based on parameter
     *
     * @param null $id
     * @return mixed
     */
    public function findAllDepartments($id = null)
    {
        $row = new \stdClass();
        $row->department_id = null;
        $row->department_name = 'ALL';
        $row->text = 'Select One';
        $row->value = null;
        $department = new LDepartment();
        if ($id)
            return $department->find($id);

        $departments = $department->orderBy("department_name", 'ASC')->get();
        $departments[sizeof($departments)] =  $row;
        return $departments;
    }

    public function findDepartmentsFS($id = null)
    {
        $row = new \stdClass();
        $row->department_id = null;
        $row->department_name = 'ALL';
        $row->text = 'Select One';
        $row->value = null;
        $department = new LDepartment();
        if ($id)
            return $department->find($id);

        $hasPermission = Auth()->user()->hasPermission('CAN_SEE_ALL_DEPARTMENT');

        if ($hasPermission) {
            $departments = $department->orderBy("department_name", 'ASC')->get();
            $departments[sizeof($departments)] =  $row;
            return $departments;
        }

        $employee = new Employee();
        $employee = $employee->find(Auth()->user()->emp_id);

//        if ($employee && $employee->dpt_department_id)
//            return $department->where('department_id', $employee->dpt_department_id)->orderBy("department_name", 'ASC')->get();
        if ($employee && $employee->current_department_id)
            return $department->where('department_id', $employee->current_department_id)->orderBy("department_name", 'ASC')->get();

        return [];
    }

    public function findPensionHeads($id = null)
    {
        $row = new \stdClass();
        $row->pension_head_id = null;
        $row->pension_head = 'ALL';
        $row->text = 'Select One';
        $row->value = null;
        $pension_head = new PensionHeads();
        if ($id)
            return $pension_head->find($id);

        $hasPermission = Auth()->user()->hasPermission('CAN_SEE_ALL_DEPARTMENT');

        if ($hasPermission) {
            $pension_heads = $pension_head->orderBy("pension_head_id", 'ASC')
                ->whereIn('pension_head_id', [4,5,6,7,8,9,10])
                ->get();
            $pension_heads[sizeof($pension_heads)] =  $row;
            return $pension_heads;
        }
        return [];
    }
    /**
     * Get one or more departments based on parameter
     *
     * @param null $id
     * @return mixed
     */
    public function findCurrentDepartments($id = null)
    {
        $row = new \stdClass();
        $row->department_id = null;
        $row->department_name = 'ALL';
        $row->text = 'ALL';
        $row->value = null;
        $department = new LDepartment();
        if ($id)
            return $department->find($id);

        $hasPermission = Auth()->user()->hasPermission('CAN_SEE_ALL_DEPARTMENT');

        if ($hasPermission) {
            $departments = $department->orderBy("department_name", 'ASC')->get();
            $departments[sizeof($departments)] =  $row;
            return $departments;
        }

        $employee = new Employee();
        $employee = $employee->find(Auth()->user()->emp_id);

        if ($employee->dpt_department_id == $employee->current_department_id){
             $departments = $department->where('department_id', $employee->dpt_department_id)->orderBy("department_name", 'ASC')->get();
        }else{
             $departments = $department->where('department_id', $employee->current_department_id)->orderBy("department_name", 'ASC')->get();
        }
        return $departments;
    }


    public function findDepartmentsForBasic($id = null)
    {
        $row = new \stdClass();
        $row->department_id = null;
        $row->department_name = 'ALL';
        $row->text = 'ALL';
        $row->value = null;
        $department = new LDepartment();
        if ($id)
            return $department->find($id);

        $hasPermission = Auth()->user()->hasPermission('CAN_SEE_ALL_DEPARTMENT');

        if ($hasPermission) {
            $departments = $department->orderBy("department_name", 'ASC')->get();
            $departments[sizeof($departments)] =  $row;
            return $departments;
        }

        $employee = new Employee();
        $employee = $employee->find(Auth()->user()->emp_id);
        if ($employee && $employee->current_department_id)
            return $department->where('department_id', $employee->current_department_id)->orderBy("department_name", 'ASC')->get();

        return [];
    }


    public function findSections($id = null)
    {
        $section = new LDptSection();
        if ($id)
            return $section->find($id);

        return $section->orderBy("dpt_section", 'asc')->get();
    }

    public function findCurrentSections($id = null)
    {
        $employee = new Employee();
        $employee = $employee->find(Auth()->user()->emp_id);
        if ($employee->section_id && !Auth::user()->hasRole('admin')){
            $sections = LDptSection::where('dpt_section_id',$employee->section_id)->get();
        }else{
            $sections = LDptSection::orderBy("dpt_section", 'asc')->get();
        }
        return $sections;
    }

    public function findSectionsForExternalUser($id = null)
    {
        $employee = new Employee();
        if ($employee->section_id && !Auth::user()->hasRole('admin')){
            $sections = LDptSection::where('dpt_section_id',$employee->section_id)->get();
        }else{
            $sections = LDptSection::orderBy("dpt_section", 'asc')->get();
        }
        return $sections;
    }

    public function findLocDivision($id = null)
    {
        $division = new LGeoDivision();
        if ($id)
            return $division->find($id);

        return $division->orderBy("division_id", 'desc')->get();
    }

    public function findLocDistrict($id = null)
    {
        $division = new LGeoDistrict();
        if ($id)
            return $division->find($id);

        return $division->orderBy("district_id", 'desc')->get();
    }

    public function findLocThana($id = null)
    {
        $division = new LGeoThana();
        if ($id)
            return $division->find($id);

        return $division->orderBy("thana_id", 'desc')->get();
    }

    /**
     * Find one for more banks
     *
     * @param null $id
     * @return mixed
     */
    public function findBanks($id = null)
    {
        $bank = new LBank();

        if ($id)
            return $bank->find($id);

        return $bank->orderBy("bank_name", 'asc')->get();
    }

    /**
     * Find exam one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findExam($id = null)
    {

        $exam = new LExam();

        if ($id)
            return $exam->find($id);

        return $exam->orderBy("exam_name", 'asc')->get();
    }

    public function findSubject($id = null)
    {

        $examSubject = new LExamSubject();

        if ($id)
            return $examSubject->find($id);

        return $examSubject->orderBy("exam_subject_name", 'asc')->get();
    }

    /**
     * Find one or more Exam bodies
     *
     * @param null $id
     * @return mixed
     */
    public function findExamBodies($id = null)
    {
        $examBody = new LExamBody();
        if ($id)
            return $examBody->find($id);

        return $examBody->orderBy("exam_body_name", 'asc')->get();
    }

    /**
     * Find Exam Results one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findExamResult($id = null)
    {
        $examResult = new LExamResult();

        if ($id)
            return $examResult->find($id);

        return $examResult->orderBy("exam_result_id", 'asc')->get();
    }

    /**
     * Find designations one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findDesignations($id = null)
    {
        $designation = new LDesignation();

        if ($id)
            return $designation->find($id);

        return $designation->orderBy("designation", 'asc')->get();
    }

    /**
     * Find employee grades
     *
     * @param null $id
     * @return mixed
     */
    public function findEmpGrads($id = null)
    {
        $empGrade = new LEmpGrade();

        if ($id)
            return $empGrade->find($id);

        return $empGrade->orderBy("emp_grade_id", 'asc')->get();
    }


    public function findMobileAllowances($id = null)
    {
        $mobile_allowances = new LEmpAllowances();

        if ($id)
            return $mobile_allowances->where('type','MOBILE')->where('id', $id)->get();

        return $mobile_allowances->orderBy("amount", 'asc')->get();
    }

    /**
     * FIXME: Pay grade should have a mapping with employee type. Its not currently available. But for presentation purpose
     * we are fixing by hard coded value.
     *
     * @param $employeeType
     * @return mixed
     */
    public function findPayGradeByEmployeeType($employeeType)
    {
        $divideGradeFromEmployeeId = 12;
        $empGrade = new LEmpGrade();
        if ($employeeType == 2) { // Staff
            $empGrade = $empGrade->where(
                [
                    ['emp_grade_id', '>=', $divideGradeFromEmployeeId] // 11 or over grade_id
                ]
            );


        } else if ($employeeType == 1) { // Officer
            $empGrade = $empGrade->where(
                [
                    ['emp_grade_id', '<', $divideGradeFromEmployeeId] // 11 or lower grade_id
                ]
            )->orWhere(
                [
                    ['emp_grade_id', '=', 99] // 11 or over grade_id
                ]
            );
        }

        return $empGrade->orderBy("emp_grade_id", 'asc')->get();
    }

    /**
     * Find one or more grade steps
     *
     * @param null $id
     * @return mixed
     */
    public function findGradeSteps($id = null)
    {
        $gradeStep = new LGradeSteps();
        if ($id)
            return $gradeStep->find($id);

        return $gradeStep->orderBy("grade_steps_id", 'asc')->get();
    }


    /**
     * Find one or more grade steps
     *
     * @param null $id
     * @return mixed
     */
    public function findAllGradeSteps($id = null)
    {
        if ($id)
            $sql = "select operations.emp_promotion_grade_step_list(:id) from dual";
         return $list = DB::select($sql, ['id' => $id]);
    }

    /**
     * Find one or more Profession types
     *
     * @param null $id
     * @return mixed
     */
    public function findProfessionTypes($id = null)
    {
        $professionType = new LProfessionType();
        if ($id)
            return $professionType->find($id);

        return $professionType->orderBy("profession_type", 'asc')->get();
    }

    /**
     * @param null $id
     * @return array|mixed
     */
    public function findDepartmentWiseDesignation($id = null)
    {
        if ($id)
            $sql = "select operations.dept_wise_designation_list(:id) from dual";
        return $list = DB::select($sql, ['id' => $id]);
    }

    /**
     * @param null $id
     * @return array|mixed
     */
    public function getDesignationByGrade($id = null,$emp_grade_id=null)
    {
        if ($id)
            $sql = "select operations.grade_wise_designation_list(:id,:emp_grade_id) from dual";
        return $list = DB::select($sql, ['id' => $id,'emp_grade_id' => $emp_grade_id]);
    }

    /**
     * @return array|mixed
     */
    public function findLocationTypeList()
    {

        $sql = "select operations.location_type_list from dual";
        return $list = DB::select($sql);
    }

    /**
     * @param null $id
     * @return array|mixed
     */
    public function findLocationList($id = null)
    {
        if ($id)
            $sql = "select operations.location_list(:id) from dual";
        return $list = DB::select($sql, ['id' => $id]);
    }

    /**
     * @param null $id
     * @return array|mixed
     */
    public function findEmployeePromotionGrade($id = null)
    {
        if ($id)
            $sql = "select operations.emp_promotion_grade_list(:id) from dual";
        return $list = DB::select($sql, ['id' => $id]);
    }

    /**
     * Find one or more profession tpe
     *
     * @param null $id
     * @return mixed
     */
    public function findPostType($id = null)
    {
        $postType = new LPostType();
        if ($id)
            return $postType->find($id);

        return $postType->orderBy("post_type", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findAddressType($id = null)
    {
        $addressType = new LAddressType();
        if ($id)
            return $addressType->find($id);

        return $addressType->orderBy("address_type", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findAppointmentTypes($id = null)
    {
        $appointmentType = new LAppointmentType();
        if ($id)
            return $appointmentType->find($id);

        return $appointmentType->orderBy("appoinment_type", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findAuthDocTypes($id = null)
    {
        $authDocType = new LAuthDocType();
        if ($id)
            return $authDocType->find($id);

        return $authDocType->orderBy("auth_doc_type_name", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findBillHeads($id = null)
    {
        $billHead = new LBillHead();
        if ($id)
            return $billHead->find($id);

        return $billHead->orderBy("bill_head_name", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findBloodGroups($id = null)
    {
        $bloodGroup = new LBloodGroup();
        if ($id)
            return $bloodGroup->find($id);

        return $bloodGroup->orderBy("blood_group", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findBranches($id = null)
    {
        $branch = new LBranch();
        if ($id)
            return $branch->find($id);

        return $branch->orderBy("branch_name", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findCompanies($id = null)
    {
        $company = new LCompany();
        if ($id)
            return $company->find($id);

        return $company->orderBy("company_name", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findDocs($id = null)
    {
        $docs = new LDocs();
        if ($id)
            return $docs->find($id);

        return $docs->orderBy("docs_name", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findDocTypes($id = null)
    {
        $docsType = new LDocType();
        if ($id)
            return $docsType->find($id);

        return $docsType->orderBy("docs_type_name", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findDptSections($id = null)
    {
        $dptSections = new LDptSection();
        if ($id)
            return $dptSections->find($id);

        return $dptSections->orderBy("dpt_section", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findEmpStatus($id = null)
    {
        $empStatus = new LEmpStatus();
        if ($id)
            return $empStatus->find($id);

        return $empStatus->orderBy("emp_status", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findFamilyMemberStatus($id = null)
    {
        $familyMemberStatus = new LFamilyMemberStatus();
        if ($id)
            return $familyMemberStatus->find($id);

        return $familyMemberStatus->orderBy("family_member_status", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findGenders($id = null)
    {
        $gender = new LGender();
        if ($id)
            return $gender->find($id);

        return $gender->orderBy("gender_name", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findGeoCountries($id = null)
    {
        $geoCountry = new LGeoCountry();
        if ($id)
            return $geoCountry->find($id);

        return $geoCountry->orderBy("country", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findGeoDistrict($id = null)
    {
        $geoDistrict = new LGeoDistrict();
        if ($id)
            return $geoDistrict->find($id);

        return $geoDistrict->orderBy("geo_district_name", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findGeoDivision($id = null)
    {
        $geoDivision = new LGeoDivision();
        if ($id)
            return $geoDivision->find($id);

        return $geoDivision->orderBy("geo_division_name", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findGeoThana($id = null)
    {
        $geoThana = new LGeoThana();
        if ($id)
            return $geoThana->find($id);

        return $geoThana->orderBy("geo_thana_name", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findHolidays($id = null)
    {
        $holiday = new LHoliday();
        if ($id)
            return $holiday->find($id);

        return $holiday->orderBy("holiday", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findLeaveType($id = null)
    {
        $row = new \stdClass();
        $row->text = 'ALL';
        $row->value = null;
        $leaveType = new LLeaveType();
        $leaveTypes = [];
        if ($id)
            return $leaveType->find($id);
        $leaveType = $leaveType->orderBy("leave_type", 'asc')->get();
        $leaveType[sizeof($leaveType)] =  $row;
        return $leaveType;
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findLeaveWithoutPRL($id = null)
    {
        $leaveType = new LLeaveType();
        if ($id)
            return $leaveType->find($id);

        return $leaveType->whereNotIn('leave_type_id',['11'])->orderBy("leave_type", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findLeaveWithPRL($id = null)
    {
        $leaveType = new LLeaveType();
        if ($id)
            return $leaveType->find($id);

        return $leaveType->whereIn('leave_type_id',['11'])->orderBy("leave_type", 'asc')->get();
    }


    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findLocation($id = null)
    {
        $location = new LLocation();
        if ($id)
            return $location->find($id);

        return $location->orderBy("working_location", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findMaritalStatus($id = null)
    {
        $maritalStatus = new LMaritalStatus();
        if ($id)
            return $maritalStatus->find($id);

        return $maritalStatus->orderBy("maritial_status_id", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findModules($id = null)
    {
        $module = new LModule();
        if ($id)
            return $module->find($id);

        return $module->orderBy("module_name", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findNationality($id = null)
    {
        $nationality = new LNationality();
        if ($id)
            return $nationality->find($id);

        return $nationality->orderBy("nationality", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findOptions($id = null)
    {
        $options = new LOptions();
        if ($id)
            return $options->find($id);

        return $options->orderBy("option_name", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findOtCategories($id = null)
    {
        $otCategory = new LOtCategory();
        if ($id)
            return $otCategory->find($id);

        return $otCategory->orderBy("ot_category", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findQuota($id = null)
    {
        $quota = new LQuota();
        if ($id)
            return $quota->find($id);

        return $quota->orderBy("quota_name", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findEmpTypes($id = null)
    {
        $empType = new LEmpType();
        if ($id)
            return $empType->find($id);

        return $empType->orderBy("emp_type_name", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findRelationType($id = null)
    {
        $relationType = new LRelationType();
        if ($id)
            return $relationType->find($id);

        return $relationType->orderBy("relation_type", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findReligion($id = null)
    {
        $religion = new LReligion();
        if ($id)
            return $religion->find($id);

        return $religion->orderBy("religion", 'asc')->get();
    }


    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findRole($id = null)
    {
        $role = new LRole();
        if ($id)
            return $role->find($id);

        return $role->orderBy("role_name", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findRoleEmp($id = null)
    {
        $roleEmp = new LRoleEmp();
        if ($id)
            return $roleEmp->find($id);

        return $roleEmp->orderBy("role_id", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findRosterShift($id = null)
    {
        $rosterShift = new LRosterShift();
        if ($id)
            return $rosterShift->find($id);

        return $rosterShift->orderBy("shift_code", 'asc')->get();
    }


    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findSalutation($id = null)
    {
        $salutation = new LSalutation();
        if ($id)
            return $salutation->find($id);

        return $salutation->orderBy("salutation", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findSectionLocation($id = null)
    {
        $sectionLocation = new LSectionLocation();
        if ($id)
            return $sectionLocation->find($id);

        return $sectionLocation->orderBy("section_id", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findService($id = null)
    {
        $service = new LService();
        if ($id)
            return $service->find($id);

        return $service->orderBy("service_id", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findTourType($id = null)
    {
        $tourType = new LTourType();
        if ($id)
            return $tourType->find($id);

        return $tourType->orderBy("tour_type", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findTraining($id = null)
    {
        $training = new LTraining();
        if ($id)
            return $training->find($id);

        return $training->orderBy("training", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findTrainingType($id = null)
    {
        $trainingType = new LTrainingType();
        if ($id)
            return $trainingType->find($id);

        return $trainingType->orderBy("training_type", 'asc')->get();
    }

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findWorkFlow($id = null)
    {
        $workFlow = new LWorkFlow();
        if ($id)
            return $workFlow->find($id);

        return $workFlow->orderBy("wf_id", 'asc')->get();
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function findCategories($id = null)
    {
        $category = new LOtCategory();
        if ($id)
            return $category->find($id);

        return $category->orderBy("ot_category_id", 'asc')->get();
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function findAuthDoc($id = null)
    {
        $authDoc = new LAuthDocType();
        if ($id)
            return $authDoc->find($id);

        return $authDoc->orderBy("auth_doc_type_id", 'asc')->get();
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function findContactType($id = null)
    {
        $contactType = new LContactType();
        if ($id)
            return $contactType->find($id);

        return $contactType->orderBy("emp_contact_type_id", 'asc')->get();
    }

    public function findInstitute($id = null)
    {
        $institutes = new LInstitute();
        if ($id)
            return $institutes->find($id);

        return $institutes->orderBy("institute_id", 'asc')->get();
    }


    public function findReportsByModuleId($id)
    {
        $report = new Report();
        return $report->where('module_id', $id)->orderBy("report_name", 'asc')->get();
    }

    public function findPermissionsByModuleId($id)
    {
        $permission = new Permission();
        return $permission->where('module_id', $id)->orderBy("permission_name", 'asc')->get();
    }

    public function findMenusByModuleId($id)
    {
        $menu = new Menu();
        return $menu->where('module_id', $id)->orderBy("menu_order_no", 'asc')->get();
    }

    public function findSubMenusL1ByMenuId($id)
    {
        $submenu = new Submenu();
        return $submenu->where('menu_id', $id)->where('parent_submenu_id', null)->orderBy("menu_order_no", 'asc')->get();
    }

    public function findSubMenusL2BySubMenuId($id)
    {
        $submenu = new Submenu();
        return $submenu->where('parent_submenu_id', $id)->orderBy("menu_order_no", 'asc')->get();
    }

    public function findEmpCods($id = null)
    {
        $empcodes = new Employee();
        // if($id){
        // return $empcodes->find($id);
        // }
        return $empcodes->select('emp_id', 'emp_code', 'emp_name', 'designation_id', 'dpt_department_id', 'section_id')
            ->where('emp_code', 'like', '%' . $id . '%')->limit(20)->get();


    }

    public function findSecuriyModules($id = null)
    {
        $module = new Module();
        if ($id)
            return $module->find($id);

        return $module->orderBy('module_name', 'asc')->get();
    }

    public function findSecurityReports($id = null)
    {
        $reports = new Report();
        if ($id)
            return $reports->find($id);

        return $reports->orderBy('module_id', 'asc')->orderBy('report_name', 'asc')->get();
    }

    public function findUserLookups($id = null)
    {
        $userLookups = new LUserLookups();
        if ($id)
            return $userLookups->find($id);

        return $userLookups->orderBy('lookup_code', 'asc')->get();
    }

    public  function  findEmpClass($id = null)
    {
       $empClasses=new LEmpGrade();

       return $empClasses->distinct('emp_class')->orderBy('emp_class','asc')->get(['emp_class']);
    }

    public function findExamResultType($id = null)
    {
        $examResultType=new LExamResultType();
        if($id)
            return $examResultType->find($id);
        return $examResultType->orderby('sort_order','asc')->get();
    }

    public function findNomineeFor($id = null)
    {
        return LNomineeFor::find($id);
    }
}
