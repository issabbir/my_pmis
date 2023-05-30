<template>
    <div class="content-body">
        <b-row>
            <b-col md="4" >
                <b-card class="h-100">
                    <b-card-body>
                        <b-form-group class="text-center">
                            <b-img rounded="circle" :src="employee.emp_photo ? employee.emp_photo : '/images/avatar.png'" width="150" height="150"></b-img>
                        </b-form-group>
                        <b-form-group v-if="employee.approved_yn == 'N'" class="text-center">
                            <b-badge class="badge-pill badge-danger">Approval Pending</b-badge>
                        </b-form-group>
                        <b-form-group
                            label="Employee Code"
                            label-for="emp_code"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder border" :value="employee.emp_code" id="emp_code" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Salutation"
                            label-for="salutation"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="(!employee.salutation_id)?'':employee.salutation_id.salutation" id="salutation" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Name"
                            label-for="emp_name"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="employee.emp_name" id="emp_name" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="নাম"
                            label-for="emp_name_bng"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="employee.emp_name_bng" id="emp_name_bng" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Father's Name"
                            label-for="emp_father_name"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="employee.emp_father_name" id="emp_father_name" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="পিতার নাম"
                            label-for="emp_father_name_bng"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="employee.emp_father_name_bng" id="emp_father_name_bng" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Mother's Name"
                            label-for="emp_mother_name"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="employee.emp_mother_name" id="emp_mother_name" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="মাতার নাম"
                            label-for="emp_mother_name_bng"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="employee.emp_mother_name_bng" id="emp_mother_name_bng" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Blood Group"
                            label-for="blood_group"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="(!employee.emp_blood_group_id)?'':employee.emp_blood_group_id.text" id="blood_group" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Date of Birth"
                            label-for="emp_dob"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="birthDate" id="emp_dob" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Age"
                            label-for="age"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="employee.age" id="age" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Gender"
                            label-for="gender_name"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="(!employee.emp_gender_id)?'':employee.emp_gender_id.gender_name" id="gender_name" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Marital Status"
                            label-for="marital_status"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="(!employee.employeeSelectedMaritialStatus)?'':employee.employeeSelectedMaritialStatus.text" id="marital_status" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Nationality"
                            label-for="nationality"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="(!employee.employeeSelectedNationality)?'':employee.employeeSelectedNationality.text" id="nationality" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Religion"
                            label-for="emp_religion_name"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="employee.emp_religion_name" id="emp_religion_name" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Identity Symbol"
                            label-for="identity_symbol"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="employee.identity_symbol" id="identity_symbol" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="জন্মদাগ"
                            label-for="identity_symbol_bng"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="employee.identity_symbol_bng" id="identity_symbol_bng" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Authentication Type Name"
                            label-for="auth_doc_type_name"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="(!employee.employeeSelectedAuthDocType)?'':employee.employeeSelectedAuthDocType.text" id="auth_doc_type_name" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Authentication ID No."
                            label-for="nid_no"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="employee.nid_no" id="nid_no" readonly></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Tribal"
                            label-for="tribal_yn"
                            label-align="right"
                            label-cols-md="4">
                            <b-form-input class="font-weight-bolder" :value="tribal" id="tribal_yn" readonly></b-form-input>
                        </b-form-group>
                    </b-card-body>
                </b-card>
            </b-col>
            <b-col>
                <b-card>
                    <b-card-body>
                        <h4 class="text-center">POSITION</h4>
                        <hr>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="Deputation"
                                    label-for="deputation"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="deputation" readonly id="deputation"></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Previous Workplace"
                                    label-for="previous_workplace"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="employee.previous_workplace" id="previous_workplace" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Previous Designation"
                                    label-for="previous_designation"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="employee.previous_designation" id="previous_designation" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Previous Office Address"
                                    label-for="previous_office_address"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="employee.previous_office_address" id="previous_office_address" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Division"
                                    label-for="dpt_division_name"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="(!employee.dpt_division)?'':employee.dpt_division.text" id="dpt_division_name" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Department"
                                    label-for="department_name"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="(!employee.employeeSelectedDepartment)?'':employee.employeeSelectedDepartment.text" id="department_name" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Section"
                                    label-for="dpt_section"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="(!employee.section)?'':employee.section.text" id="dpt_section" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Designation"
                                    label-for="designation"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="(!employee.designation)?'':employee.designation.designation" id="designation" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Employee Type"
                                    label-for="emp_type_name"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="(!employee.employeeSelectedType)?'':employee.employeeSelectedType.emp_type_name" id="emp_type_name" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Grade"
                                    label-for="grade_range"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="(!employee.grade)?'':employee.grade.text" id="grade_range" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Grade Step"
                                    label-for="basic_amt"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="(!employee.employeeSelectedGradeStep)?'':employee.employeeSelectedGradeStep[0].text" id="basic_amt" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Class"
                                    label-for="emp_class"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="employee.emp_class" id="emp_class" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Joining Date"
                                    label-for="emp_join_date"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="joiningDate" id="emp_join_date" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Working Location"
                                    label-for="working_location"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="(!employee.location)?'':employee.location.text" id="working_location" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="GO Number"
                                    label-for="emp_go_number"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="employee.emp_go_number" id="emp_go_number" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="GO Date"
                                    label-for="emp_go_date"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="goDate" id="emp_go_date" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Quota"
                                    label-for="quota_name"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="(!employee.employeeSelectedQuota)?'':employee.employeeSelectedQuota.text" id="quota_name" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="LPR Date"
                                    label-for="emp_lpr_date"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="employee.emp_lpr_date" id="emp_lpr_date" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Status"
                                    label-for="emp_status"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="(!employee.employeeSelectedJobStatus)?'':employee.employeeSelectedJobStatus.text" id="emp_status" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Post Type"
                                    label-for="post_type"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="(!employee.employeeSelectedPostType)?'':employee.employeeSelectedPostType.text" id="post_type" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="OT Category"
                                    label-for="ot_category"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="(!employee.ot_category_id)?'':employee.ot_category_id.text" id="ot_category" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Reporting Officer"
                                    label-for="option_name"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="(!employee.reporting_officer)?'':employee.reporting_officer.option_name" id="option_name" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Appointment Type"
                                    label-for="appoinment_type"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="(!employee.employeeSelectedAppointmentType)?'':employee.employeeSelectedAppointmentType.text" id="appoinment_type" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Active"
                                    label-for="emp_active_yn"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="active" id="emp_active_yn" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Active Date"
                                    label-for="emp_active_date"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="activeDate" id="emp_active_date" readonly></b-form-input>
                                </b-form-group>
                            </b-col>

                        </b-row>
                    </b-card-body>

                </b-card>
                <b-card style="margin-bottom: 0px!important;">
                    <b-card-body>
                        <h4 class="text-center">OTHERS</h4>
                        <hr>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="GPF Status"
                                    label-for="gpf_yn"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="gpf_status" id="gpf_yn" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="GPF ID"
                                    label-for="emp_pf_id"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="employee.emp_pf_id" id="emp_pf_id" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Bank"
                                    label-for="bank_name"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="(!employee.employeeSelectedBank)?'':employee.employeeSelectedBank.text" id="bank_name" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Bank Branch"
                                    label-for="branch_name"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="(!employee.employeeSelectedBankBranch)?'':employee.employeeSelectedBankBranch.text" id="branch_name" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Bank Account No."
                                    label-for="emp_bank_acc_no"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="employee.emp_bank_acc_no" id="emp_bank_acc_no" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="BCS Batch No."
                                    label-for="emp_bcs_batch_no"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="employee.emp_bcs_batch_no" id="emp_bcs_batch_no" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="TIN No."
                                    label-for="emp_tin_no"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="employee.emp_tin_no" id="emp_tin_no" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="On Pension"
                                    label-for="on_pension_yn"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="on_pension" id="on_pension_yn" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Deceased"
                                    label-for="deceased_yn"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="deceased" id="deceased_yn" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Bill Code"
                                    label-for="bill_code"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="employee.bill_code" id="bill_code" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Emergency Contact Name"
                                    label-for="emp_emergency_contact_name"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="employee.emp_emergency_contact_name" id="emp_emergency_contact_name" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Emergency Contact Mobile"
                                    label-for="emp_emergency_contact_mobile"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="employee.emp_emergency_contact_mobile" id="emp_emergency_contact_mobile" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Relation Type"
                                    label-for="relation_type"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="(!employee.employeeSelectedEmergencyRelationType)?'':employee.employeeSelectedEmergencyRelationType.text" id="relation_type" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Emergency Contact Address"
                                    label-for="emp_emergency_contact_address"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="employee.emp_emergency_contact_address" id="emp_emergency_contact_address" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Confirmation Date"
                                    label-for="emp_confirmation_date"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="confirmationDate" id="emp_confirmation_date" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Medical Book ID"
                                    label-for="emp_medical_book_id"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="employee.emp_medical_book_id" id="emp_medical_book_id" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Security ID"
                                    label-for="emp_security_id"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="employee.emp_security_id" id="emp_security_id" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="HBL Status"
                                    label-for="hbl_yn"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="hblStatus" id="hbl_yn" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Allowance Status"
                                    label-for="allowance_yn"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="allowance_status" id="allowance_yn" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Selection Grade"
                                    label-for="selection_grade_yn"
                                    label-align="right"
                                    label-cols-md="4">
                                    <b-form-input class="font-weight-bolder" :value="selection_grade_status" id="selection_grade_yn" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-card-body>
                </b-card>
            </b-col>
        </b-row>
        <b-modal @ok="onSubmit" ref="edit-modal" size="xl" title="Your Information">
            <b-row>
                <b-col md="9">
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="নাম"
                                label-for="emp_name_bng"
                                class="requiredField"
                            >
                                <b-form-input
                                    id="emp_name_bng"
                                    v-model="basicInfo.emp_name_bng"
                                    type="text"
                                    class="uppercase"
                                    :maxlength="3000"
                                    placeholder=""
                                ></b-form-input>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.basicInfo.emp_name_bng.$error && !$v.basicInfo.emp_name_bng.required}">নাম লিখুন!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                class="requiredField"
                                label="Father's Name"
                                label-for="emp_father_name"
                            >
                                <b-form-input
                                    id="emp_father_name"
                                    v-model="basicInfo.emp_father_name"
                                    type="text"
                                    required
                                    class="uppercase"
                                    :maxlength="250"
                                    placeholder=""  v-validate="'required'"
                                    name="emp_father_name"
                                ></b-form-input>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.basicInfo.emp_father_name.$error && !$v.basicInfo.emp_father_name.required}">Father's name is required!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="পিতার নাম"
                                label-for="title"
                                class="requiredField"
                            >
                                <b-form-input
                                    id="emp_father_name_bangla"
                                    v-model="basicInfo.emp_father_name_bng"
                                    type="text"
                                    class="uppercase"
                                    :maxlength="3000"
                                    placeholder=""
                                ></b-form-input>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.basicInfo.emp_father_name_bng.$error && !$v.basicInfo.emp_father_name_bng.required}">পিতার নাম লিখুন!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                class="requiredField"
                                label="Mother's Name"
                                label-for="emp_mother_name">
                                <b-form-input
                                    id="emp_mother_name"
                                    v-model="basicInfo.emp_mother_name"
                                    type="text"
                                    required
                                    class="uppercase"
                                    :maxlength="250"
                                    placeholder="" v-validate="'required'"
                                    name="emp_mother_name"
                                ></b-form-input>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.basicInfo.emp_mother_name.$error && !$v.basicInfo.emp_mother_name.required}">Mother's name is required!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                class="requiredField"
                                label="মাতার নাম"
                                label-for="emp_mother_name_bng">
                                <b-form-input
                                    id="emp_mother_name_bng"
                                    v-model="basicInfo.emp_mother_name_bng"
                                    type="text"
                                    class="uppercase"
                                    :maxlength="3000"
                                    placeholder=""
                                ></b-form-input>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.basicInfo.emp_mother_name_bng.$error && !$v.basicInfo.emp_mother_name_bng.required}">মাতার নাম লিখুন!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                class="requiredField"
                                label="Blood Group"
                                label-for="emp_blood_group_id">
                                <v-select v-model="bloodGroups" :options="bloodGroupList"
                                          name="emp_blood_group_id" id="emp_blood_group_id"
                                          label="text"
                                          required v-validate="'required'">
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                    </template>
                                </v-select>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.basicInfo.emp_blood_group_id.$error && !$v.basicInfo.emp_blood_group_id.required}">Blood group is required!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                class="requiredField"
                                label="Marital Status"
                                label-for="emp_maritial_status_id">
                                <v-select
                                    class="uppercase"
                                    v-model="maritalStatus"
                                    :options="maritalStatusList"
                                    v-validate="'required'"
                                    label="text"
                                    id="emp_maritial_status_id"
                                    name="emp_maritial_status_id">
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                    </template>
                                </v-select>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.basicInfo.emp_maritial_status_id.$error && !$v.basicInfo.emp_maritial_status_id.required}">Marital status is required!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                class="requiredField"
                                label="Religion"
                                label-for="emp_religion_id">
                                <v-select v-model="religions" :options="religionList"
                                          name="emp_religion_id" id="emp_religion_id"
                                          label="text"
                                          required v-validate="'required'">
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                    </template>
                                </v-select>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.basicInfo.emp_religion_id.$error && !$v.basicInfo.emp_religion_id.required}">Religion is required!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                class="requiredField"
                                label="Gender"
                                label-for="emp_gender_id">
                                <b-form-radio-group
                                    v-model="basicInfo.emp_gender_id"
                                    :options="genderList"
                                    name="emp_gender_id"
                                    required  v-validate="'required'"
                                ></b-form-radio-group>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.basicInfo.emp_gender_id.$error && !$v.basicInfo.emp_gender_id.required}">Gender is required!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Identity symbol"
                                label-for="identity_symbol">
                                <b-form-input
                                    id="identity_symbol"
                                    name="identity_symbol"
                                    v-model="basicInfo.identity_symbol"
                                    type="text"
                                    :maxlength="250"
                                    placeholder=""
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="পরিচয় চিহ্ন"
                                label-for="identity_symbol_bng">
                                <b-form-input
                                    id="identity_symbol_bng"
                                    name="identity_symbol_bng"
                                    v-model="basicInfo.identity_symbol_bng"
                                    type="text"
                                    :maxlength="3000"
                                    placeholder=""
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Medical Book ID"
                                label-for="emp_medical_book_id"
                            >
                                <b-form-input
                                    id="emp_medical_book_id"
                                    v-model="basicInfo.emp_medical_book_id"
                                    type="text"
                                    :maxlength="50"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-col>
                <b-col md="3" class="text-center profileImage">
                    <b-card class="m-0" style="border: 1px solid #eff1f2;">
                        <b-card-text >
                            <img id="profilepic" :src="basicInfo.emp_photo ? basicInfo.emp_photo : '/images/avatar.png'"  class="img-fluid" alt="...">
                        </b-card-text>
                    </b-card>
                    <label style="width:100%" class="btn btn-primary"> Upload Photo
                        <input class="uploadImage"  type="file"  name="emp_photo" @change="getPhoto" accept="image/png,image/jpg,image/jpeg" v-validate="'image|size:100'" />
                    </label>
                    <div :class="{'invalid-feedback':true ,'d-block':$v.basicInfo.emp_photo.$error && !$v.basicInfo.emp_photo.required}">Select your profile picture</div>
                </b-col>


                <b-col md="3">
                    <b-form-group
                        label="security ID"
                        label-for="emp_security_id"
                    >
                        <b-form-input
                            id="emp_security_id"
                            v-model="basicInfo.emp_security_id"
                            :maxlength="50"
                            type="text"
                        ></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Emergency Contact Name"
                        label-for="emp_emergency_contact_name">
                        <b-form-input
                            id="emp_emergency_contact_name"
                            v-model="basicInfo.emp_emergency_contact_name"
                            type="text"
                            :maxlength="200"
                        ></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Emergency Contact Mobile No"
                        label-for="emp_emergency_contact_mobile">
                        <b-form-input
                            id="emp_emergency_contact_mobile"
                            v-model="basicInfo.emp_emergency_contact_mobile"
                            type="text"
                            name="emp_emergency_contact_mobile"
                            v-validate="{ numeric: true, regex: /^01[5-9]\d{8}$/ }"
                            :maxlength="15"
                            placeholder=""
                        ></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="3">
                    <b-form-group
                        label="Emergency Contact Relation"
                        label-for="emp_emergency_relation_id">
                        <v-select v-model="emergencyRelationTypes"
                                  :options="relationList"
                                  name="emp_emergency_relation_id"
                                  id="emp_emergency_relation_id"
                                  label="text"
                                  class="uppercase">
                            <template #search="{attributes, events}">
                                <input class="vs__search"
                                       v-bind="attributes" v-on="events"/>
                            </template>
                        </v-select>
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Emergency Contact Address"
                        label-for="emp_emergency_contact_add056">
                        <b-form-input
                            id="emp_emergency_contact_address"
                            v-model="basicInfo.emp_emergency_contact_address"
                            type="text"
                            :maxlength="500"
                        ></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="6">
                    <b-form-group
                        label="Controlling Officer"
                        label-for="reporting_officer_id">
                        <v-select
                            label="option_name"
                            v-model="selectedEmployee"
                            :options="employeeList"
                            @search="searchEmployeeById"
                            id="reporting_officer_id"
                            name="reporting_officer_id"
                            class="uppercase">
                            <template #search="{attributes, events}">
                                <input
                                    class="vs__search"
                                    v-bind="attributes"
                                    v-on="events"
                                />
                            </template>
                        </v-select>
                    </b-form-group>
                </b-col>
            </b-row>
        </b-modal>
    </div>
</template>

<script>
    import moment from "moment";
    import ApiRepository from "../../Repository/ApiRepository";
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';
    const {required, requiredIf, maxLength, minLength, maxValue, email} = require("vuelidate/lib/validators");
    export default {
        name: "Profile",
        props: ['id'],
        components: {
            vSelect
        },
        data() {
            return {
                employee: {},
                employeeList: [],
                selectedEmployee: {'option_name':'','emp_id':'', 'emp_name':''},
                bloodGroups: {},
                maritalStatus: {},
                religions: {},
                emergencyRelationTypes: {},
                bloodGroupList: [],
                maritalStatusList: [],
                religionList: [],
                genderList: [],
                relationList: [],
                basicInfo: {
                    emp_name_bng: '',
                    emp_father_name: '',
                    emp_father_name_bng: '',
                    emp_mother_name: '',
                    emp_mother_name_bng: '',
                    emp_gender_id: '',
                    emp_religion_id: '',
                    emp_blood_group_id: '',
                    emp_security_id: '',
                    emp_medical_book_id: '',
                    identity_symbol: '',
                    identity_symbol_bng: '',
                    emp_emergency_contact_name: '',
                    emp_emergency_contact_mobile: '',
                    emp_emergency_contact_address: '',
                    emp_emergency_relation_id: '',
                    emp_maritial_status_id: '',
                    emp_religion_name: '',
                    emp_religion_name_bng: '',
                    emp_photo_name: '',
                    emp_photo_type: '',
                    emp_photo: '',
                    reporting_officer_id: ''
                }
            }
        },
        validations: {
            basicInfo: {
                emp_name_bng: {required},
                emp_father_name: {required},
                emp_father_name_bng: {required},
                emp_mother_name: {required},
                emp_mother_name_bng: {required},
                identity_symbol: {},
                identity_symbol_bng: {},
                emp_gender_id: {required},
                emp_emergency_contact_name: {},
                emp_emergency_contact_mobile: {},
                emp_emergency_contact_address: {},
                emp_medical_book_id: {},
                emp_security_id: {},
                emp_blood_group_id: {required},
                emp_maritial_status_id: {required},
                emp_religion_id: {required},
                emp_religion_name: {},
                emp_religion_name_bng: {},
                emp_emergency_relation_id: {},
                emp_photo_name: {},
                emp_photo_type: {},
                emp_photo: {required},
                reporting_officer_id: {}
            }
        },
        methods: {
            searchEmployeeById(id){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/basic-infos/controlling-officer/${id}`).then(res => {
                    this.employeeList = res.data;
                })
            },
            onSubmit(bvModalEvt){
                bvModalEvt.preventDefault()
                let currObj = this;
                this.$v.$touch();
                this.$v.basicInfo.$touch();
                if(!this.$v.basicInfo.$invalid){
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pmis/employee/profile-update", this.basicInfo).then(resp => {
                        if (resp.data.o_status_code == 1) {
                            currObj.$notify({ group: 'pmis', text: resp.data.o_status_message, type:'success' });
                            this.$nextTick(() => {
                                this.loadData()
                                this.$refs['edit-modal'].hide()
                            })
                        }else {
                            currObj.$notify({ group: 'pmis', text: resp.data.o_status_message, type:'error' });
                        }
                    }).catch(err => {
                        console.log(err);
                    });
                }
            },
            getPhoto(event) {
                let currObj = this;
                let input = event.target;
                let reader = new FileReader();
                if (input.files && input.files.length > 0) {
                    reader.onload = (e) => {
                        currObj.basicInfo.emp_photo = e.target.result;
                    }
                };
                reader.readAsDataURL(input.files[0]);
                this.basicInfo.emp_photo_name = input.files[0].name;
                this.basicInfo.emp_photo_type = input.files[0].name.split('.').pop();
            },
            showModal(){
                this.$refs['edit-modal'].show()
                this.basicInfo = {
                    emp_name_bng: this.employee.emp_name_bng,
                    emp_father_name: this.employee.emp_father_name,
                    emp_father_name_bng: this.employee.emp_father_name_bng,
                    emp_mother_name: this.employee.emp_mother_name,
                    emp_mother_name_bng: this.employee.emp_mother_name_bng,
                    identity_symbol: this.employee.identity_symbol,
                    identity_symbol_bng: this.employee.identity_symbol_bng,
                    emp_gender_id: this.employee.emp_gender_id.gender_id,
                    emp_photo_name: this.employee.emp_photo_name,
                    emp_photo_type: this.employee.emp_photo_type,
                    emp_photo: this.employee.emp_photo,
                    emp_security_id: this.employee.emp_security_id,
                    emp_medical_book_id: this.employee.emp_medical_book_id,
                    emp_emergency_contact_name:this.employee.emp_emergency_contact_name,
                    emp_emergency_contact_mobile: this.employee.emp_emergency_contact_mobile,
                    emp_emergency_contact_address: this.employee.emp_emergency_contact_address
                }
                this.bloodGroups = this.employee.employeeSelectedBloodGroup
                this.maritalStatus = this.employee.employeeSelectedMaritialStatus
                this.religions = this.employee.emp_religion_id
                this.emergencyRelationTypes = this.employee.employeeSelectedEmergencyRelationType
                this.selectedEmployee = this.employee.selectedEmployee;
            },
            allBasicInfo() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/employee/basic-infos').then(result => {
                    this.bloodGroupList = result.data.bloodGroup;
                    this.maritalStatusList = result.data.maritalStatus;
                    this.religionList = result.data.religions;
                    this.genderList = result.data.genders;
                    this.relationList = result.data.relations;
                    this.religions =result.data.religions[4];
                    this.bloodGroups=result.data.bloodGroup[5];
                    this.basicInfo.emp_gender_id=result.data.genders[1].value;
                    this.maritalStatus=result.data.maritalStatus[1];
                })
            },
            loadData(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/employee-profile-by-id/${this.id}`).then(result => {
                    this.employee = result.data;
                });
            },
            getAge(dateOfBirth) {
                let duration = moment.duration(moment().diff(dateOfBirth));
                let years = duration.years();
                let months = duration.months();
                let days = duration.days();

                let textDuration = '';
                if(years > 0) {
                    textDuration = `${years} years `;
                }

                if(months > 0) {
                    textDuration += `${months} months `;
                }

                if(days > 0) {
                    textDuration += `${days} days`;
                }

                return textDuration;
            },
            calculateLprDate() {
                this.employee.emp_lpr_date = this.employee.emp_dob && this.employee.employeeSelectedQuota.value ?
                    this.employee.employeeSelectedQuota.value == 2 ?
                        moment(this.employee.emp_dob).add(61, 'year').format("DD-MM-YYYY"):
                        moment(this.employee.emp_dob).add(59, 'year').format("DD-MM-YYYY"):
                    this.employee.emp_lpr_date = ''
            },
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "/pmis#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: `/pmis#/employee-profile/${this.id}`, label: "Employee Profile"});
            this.loadData()
            this.allBasicInfo()
        },
        watch: {
            id:function(val, oldVal){
                this.loadData()
            },
            selectedEmployee:function(val,oldVal) {
                if(val !== null) {
                    this.basicInfo.reporting_officer_id = val.emp_id;
                } else {
                    this.basicInfo.reporting_officer_id = '';
                }
            },
            bloodGroups: function (val, oldVal) {
                if (val !== null) {
                    this.basicInfo.emp_blood_group_id = val.value;
                } else {
                    this.basicInfo.emp_blood_group_id ='';
                }
            },
            maritalStatus: function (val, oldVal) {
                if (val !== null) {
                    this.basicInfo.emp_maritial_status_id = val.value;
                } else {
                    this.basicInfo.emp_maritial_status_id ='';
                }
            },
            religions: function (val, oldVal) {
                if (val !== null) {
                    this.basicInfo.emp_religion_id = val.value;
                    this.basicInfo.emp_religion_name = val.text;
                    this.basicInfo.emp_religion_name_bng = val.religion_bng;
                } else {
                    this.basicInfo.emp_religion_id ='';
                    this.basicInfo.emp_religion_name = '';
                    this.basicInfo.emp_religion_name_bng = '';
                }
            },
            emergencyRelationTypes: function (val, oldVal) {
                if (val !== null) {
                    this.basicInfo.emp_emergency_relation_id = val.value;
                } else {
                    this.basicInfo.emp_emergency_relation_id ='';
                }
            },
            "employee.emp_dob": function() {
                if(this.employee.emp_dob) {
                    this.employee.age = this.getAge(this.employee.emp_dob)
                } else {
                    this.employee.age = ''
                }

                this.calculateLprDate()
            },
            "employee.emp_quota_id": function() {
                this.calculateLprDate()
            },
        },
        computed:{
            deputation:function () {
                if (this.employee.deputation_yn == 'N'){
                    return 'NO'
                }
                else {
                    return 'YES'
                }
            },
            tribal: function () {
                if(this.employee.tribal_yn=='N'){
                    return 'NO'
                }
                else {
                    return  'YES'
                }
            },
            active: function () {
                if(this.employee.emp_active_yn=='N'){
                    return 'NO'
                }
                else {
                    return  'YES'
                }
            },
            gpf_status: function () {
                if(this.employee.gpf_yn=='N'){
                    return 'NO'
                }
                else {
                    return  'YES'
                }
            },
            on_pension: function () {
                if(this.employee.on_pension_yn=='N'){
                    return 'NO'
                }
                else {
                    return  'YES'
                }
            },
            deceased: function () {
                if(this.employee.deceased_yn=='N'){
                    return 'NO'
                }
                else {
                    return  'YES'
                }
            },
            allowance_status: function () {
                if(this.employee.allowance_yn=='N'){
                    return 'NO'
                }
                else {
                    return  'YES'
                }
            },
            selection_grade_status: function() {
                if(this.employee.selection_grade_yn == 'N'){
                    return 'NO'
                }
                else {
                    return  'YES'
                }
            },
            approval: function () {
                if(this.employee.approved_yn=='N'){
                    return 'NO'
                }
                else {
                    return  'YES'
                }
            },
            hblStatus: function () {
                if(this.employee.hbl_yn=='N'){
                    return 'NO'
                }
                else {
                    return  'YES'
                }
            },
            birthDate:function () {
                if(this.employee.emp_dob){
                    return moment(String(this.employee.emp_dob)).format('DD/MM/YYYY')
                }
                else {
                    return  ''
                }
            },
            activeDate:function () {
                if(this.employee.emp_active_date){
                    return moment(String(this.employee.emp_active_date)).format('DD/MM/YYYY')
                }
                else {
                    return  ''
                }
            },
            joiningDate:function () {
                if(this.employee.emp_join_date){
                    return moment(String(this.employee.emp_join_date)).format('DD/MM/YYYY')
                }
                else {
                    return  ''
                }
            },
            confirmationDate:function () {
                if(this.employee.emp_confirmation_date){
                    return moment(String(this.employee.emp_confirmation_date)).format('DD/MM/YYYY')
                }
                else {
                    return  ''
                }
            },
            goDate:function () {
                if(this.employee.emp_go_date){
                    return moment(String(this.employee.emp_go_date)).format('DD/MM/YYYY')
                }
                else {
                    return  ''
                }
            },
        }
    }
</script>

<style scoped>
    .form-control, .form-group .form-control {
        background-color: solid #DFE3E7!important;
    }
    #profilepic{
        height: 180px !important;
        width: 100%;
    }
    .uploadImage {
        display: none;
    }
</style>
