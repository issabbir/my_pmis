<?php

namespace App\Contracts\Admin;

interface AdminContract
{
    // Employee Position
    public function findDptDivisions($id = null);

    public function findDepartments($id = null);
    public function findCurrentDepartments($id = null);
    public function findDepartmentsForBasic($id = null);

    public function findSections($id = null);

    // Exam Setup


    // Location Setup-----------//Arafat
    public function findLocDivision($id = null);

    public function findLocDistrict($id = null);

    public function findLocThana($id = null);

    //General

    /**
     * Find one for more banks
     *
     * @param null $id
     * @return mixed
     */
    public function findBanks($id = null);

    /**
     * Find exam one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findExam($id = null);

    /**
     * Find exam body one or more
     *
     * @param null $id
     * @return mixed
     */

    public function findSubject($id = null);

    /**
     * Find exam body one or more
     *
     * @param null $id
     * @return mixed
     */

    public function findExamBodies($id = null);

    /**
     * Find Exam Results one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findExamResult($id = null);

    /**
     * @param null $id
     * @return mixed
     */
    public function findDepartmentWiseDesignation($id = null);
    public function getDesignationByGrade($id = null,$emp_grade_id = null);

    /**
     * @return mixed
     */
    public function findLocationTypeList();

    /**
     * @param null $id
     * @return mixed
     */
    public function findLocationList($id = null);

    /**
     * Find designations
     *
     * @param null $id
     * @return mixed
     */
    public function findDesignations($id = null);

    /**
     * Find employee grades
     *
     * @param null $id
     * @return mixed
     */
    public function findEmpGrads($id = null);
    public function findMobileAllowances($id = null);
    /**
     * Find one or more grade steps
     *
     * @param null $id
     * @return mixed
     */

    public function findCommonLookups($p_type = null);

    /**
     * Find one or more grade steps
     *
     * @param null $id
     * @return mixed
     */

    public function findGradeSteps($id = null);

    /**
     * Find one or more Profession types
     *
     * @param null $id
     * @return mixed
     */
    public function findProfessionTypes($id = null);

    /**
     * Find one or more profession tpe
     *
     * @param null $id
     * @return mixed
     */
    public function findPostType($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findAddressType($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findAppointmentTypes($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findAuthDocTypes($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findBillHeads($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findAllGradeSteps($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findBloodGroups($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findBranches($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findCompanies($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findDocs($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findDocTypes($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findDptSections($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findEmpStatus($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findFamilyMemberStatus($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findGenders($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findGeoCountries($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findGeoDistrict($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findGeoDivision($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findGeoThana($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findHolidays($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findLeaveType($id = null);


    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findLeaveWithoutPRL($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findLeaveWithPRL($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findLocation($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findMaritalStatus($id = null);

    /**
     * @param null $id
     * @return mixed
     */
    public function findEmployeePromotionGrade($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */

    public function findModules($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findNationality($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findOptions($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findOtCategories($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findQuota($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findEmpTypes($id = null);


    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findRelationType($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findReligion($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findRole($id = null);


    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findRoleEmp($id = null);


    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findRosterShift($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findSalutation($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findSectionLocation($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findService($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findTourType($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findTraining($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findTrainingType($id = null);

    /**
     * Find one or more
     *
     * @param null $id
     * @return mixed
     */
    public function findWorkFlow($id = null);

    public function findInstitute($id = null);

    public function findReportsByModuleId($id);

    public function findPermissionsByModuleId($id);

    public function findMenusByModuleId($id);

    public function findSubMenusL1ByMenuId($id);

    public function findSubMenusL2BySubMenuId($id);

    public function findPayGradeByEmployeeType($employeeType);

    public function findUserLookups($id);

    public function findEmpClass($id = null);

    public function findExamResultType($id = null);

    public function findNomineeFor($id = null);




}
