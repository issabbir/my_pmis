<template>
    <div class="content-body">
        <b-row>
            <b-col md="4">
                <b-card >
                    <b-card-body>
                        <b-form-group class="text-center">
                            <b-img rounded="circle" :src="employee.emp_photo ? employee.emp_photo : '/images/avatar.png'" width="150" height="150"></b-img>
                        </b-form-group>
                        <b-form-group
                            label="Employee Code"
                            label-for="emp_code"
                            label-cols-md="4">
                            <b-form-input :value="employee.emp_code" id="emp_code" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Salutation"
                            label-for="salutation"
                            label-cols-md="4">
                            <b-form-input :value="(!employee.salutation_id)?'':employee.salutation_id.salutation" id="salutation" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Name"
                            label-for="emp_name"
                            label-cols-md="4">
                            <b-form-input :value="employee.emp_name" id="emp_name" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="নাম"
                            label-for="emp_name_bng"
                            label-cols-md="4">
                            <b-form-input :value="employee.emp_name_bng" id="emp_name_bng" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Father's Name"
                            label-for="emp_father_name"
                            label-cols-md="4">
                            <b-form-input :value="employee.emp_father_name" id="emp_father_name" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="পিতার নাম"
                            label-for="emp_father_name_bng"
                            label-cols-md="4">
                            <b-form-input :value="employee.emp_father_name_bng" id="emp_father_name_bng" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Mother's Name"
                            label-for="emp_mother_name"
                            label-cols-md="4">
                            <b-form-input :value="employee.emp_mother_name" id="emp_mother_name" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="মাতার নাম"
                            label-for="emp_mother_name_bng"
                            label-cols-md="4">
                            <b-form-input :value="employee.emp_mother_name_bng" id="emp_mother_name_bng" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Blood Group"
                            label-for="blood_group"
                            label-cols-md="4">
                            <b-form-input :value="(!employee.emp_blood_group_id)?'':employee.emp_blood_group_id.text" id="blood_group" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Date of Birth"
                            label-for="emp_dob"
                            label-cols-md="4">
                            <b-form-input :value="birthDate" id="emp_dob" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Age"
                            label-for="age"
                            label-cols-md="4">
                            <b-form-input :value="employee.age" id="age" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Gender"
                            label-for="gender_name"
                            label-cols-md="4">
                            <b-form-input :value="(!employee.emp_gender_id)?'':employee.emp_gender_id.gender_name" id="gender_name" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Marital Status"
                            label-for="marital_status"
                            label-cols-md="4">
                            <b-form-input :value="(!employee.employeeSelectedMaritialStatus)?'':employee.employeeSelectedMaritialStatus.text" id="marital_status" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Nationality"
                            label-for="nationality"
                            label-cols-md="4">
                            <b-form-input :value="(!employee.employeeSelectedNationality)?'':employee.employeeSelectedNationality.text" id="nationality" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Religion"
                            label-for="emp_religion_name"
                            label-cols-md="4">
                            <b-form-input :value="employee.emp_religion_name" id="emp_religion_name" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Identity Symbol"
                            label-for="identity_symbol"
                            label-cols-md="4">
                            <b-form-input :value="employee.identity_symbol" id="identity_symbol" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="জন্মদাগ"
                            label-for="identity_symbol_bng"
                            label-cols-md="4">
                            <b-form-input :value="employee.identity_symbol_bng" id="identity_symbol_bng" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Authentication Type Name"
                            label-for="auth_doc_type_name"
                            label-cols-md="4">
                            <b-form-input :value="(!employee.employeeSelectedAuthDocType)?'':employee.employeeSelectedAuthDocType.text" id="auth_doc_type_name" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Authentication ID No."
                            label-for="nid_no"
                            label-cols-md="4">
                            <b-form-input :value="employee.nid_no" id="nid_no" disabled></b-form-input>
                        </b-form-group>
                        <b-form-group
                            label="Tribal"
                            label-for="tribal_yn"
                            label-cols-md="4">
                            <b-form-input :value="tribal" id="tribal_yn" disabled></b-form-input>
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
                                    label-cols-md="4">
                                    <b-form-input :value="deputation" disabled id="deputation"></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="6">
                                <b-form-group
                                    label="Previous Workplace"
                                    label-for="previous_workplace"
                                    label-cols-md="4">
                                    <b-form-input :value="employee.previous_workplace" id="previous_workplace" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Previous Designation"
                                    label-for="previous_designation"
                                    label-cols-md="4">
                                    <b-form-input :value="employee.previous_designation" id="previous_designation" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Previous Office Address"
                                    label-for="previous_office_address"
                                    label-cols-md="4">
                                    <b-form-input :value="employee.previous_office_address" id="previous_office_address" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Division"
                                    label-for="dpt_division_name"
                                    label-cols-md="4">
                                    <b-form-input :value="(!employee.dpt_division)?'':employee.dpt_division.text" id="dpt_division_name" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Department"
                                    label-for="department_name"
                                    label-cols-md="4">
                                    <b-form-input :value="(!employee.employeeSelectedDepartment)?'':employee.employeeSelectedDepartment.text" id="department_name" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Section"
                                    label-for="dpt_section"
                                    label-cols-md="4">
                                    <b-form-input :value="(!employee.section)?'':employee.section.text" id="dpt_section" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Designation"
                                    label-for="designation"
                                    label-cols-md="4">
                                    <b-form-input :value="(!employee.designation)?'':employee.designation.designation" id="designation" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Employee Type"
                                    label-for="emp_type_name"
                                    label-cols-md="4">
                                    <b-form-input :value="(!employee.employeeSelectedType)?'':employee.employeeSelectedType.emp_type_name" id="emp_type_name" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Grade"
                                    label-for="grade_range"
                                    label-cols-md="4">
                                    <b-form-input :value="(!employee.grade)?'':employee.grade.text" id="grade_range" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Grade Step"
                                    label-for="basic_amt"
                                    label-cols-md="4">
                                    <b-form-input :value="(!employee.employeeSelectedGradeStep)?'':employee.employeeSelectedGradeStep[0].text" id="basic_amt" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Class"
                                    label-for="emp_class"
                                    label-cols-md="4">
                                    <b-form-input :value="employee.emp_class" id="emp_class" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Joining Date"
                                    label-for="emp_join_date"
                                    label-cols-md="4">
                                    <b-form-input :value="joiningDate" id="emp_join_date" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Working Location"
                                    label-for="working_location"
                                    label-cols-md="4">
                                    <b-form-input :value="(!employee.location)?'':employee.location.text" id="working_location" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="GO Number"
                                    label-for="emp_go_number"
                                    label-cols-md="4">
                                    <b-form-input :value="employee.emp_go_number" id="emp_go_number" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="GO Date"
                                    label-for="emp_go_date"
                                    label-cols-md="4">
                                    <b-form-input :value="goDate" id="emp_go_date" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Quota"
                                    label-for="quota_name"
                                    label-cols-md="4">
                                    <b-form-input :value="(!employee.employeeSelectedQuota)?'':employee.employeeSelectedQuota.text" id="quota_name" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="LPR Date"
                                    label-for="emp_lpr_date"
                                    label-cols-md="4">
                                    <b-form-input :value="employee.emp_lpr_date" id="emp_lpr_date" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Status"
                                    label-for="emp_status"
                                    label-cols-md="4">
                                    <b-form-input :value="(!employee.employeeSelectedJobStatus)?'':employee.employeeSelectedJobStatus.text" id="emp_status" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Post Type"
                                    label-for="post_type"
                                    label-cols-md="4">
                                    <b-form-input :value="(!employee.employeeSelectedPostType)?'':employee.employeeSelectedPostType.text" id="post_type" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="OT Category"
                                    label-for="ot_category"
                                    label-cols-md="4">
                                    <b-form-input :value="(!employee.ot_category_id)?'':employee.ot_category_id.text" id="ot_category" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Reporting Officer"
                                    label-for="option_name"
                                    label-cols-md="4">
                                    <b-form-input :value="employee.selectedEmployee.option_name" id="option_name" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Appointment Type"
                                    label-for="appoinment_type"
                                    label-cols-md="4">
                                    <b-form-input :value="(!employee.employeeSelectedAppointmentType)?'':employee.employeeSelectedAppointmentType.text" id="appoinment_type" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Active"
                                    label-for="emp_active_yn"
                                    label-cols-md="4">
                                    <b-form-input :value="active" id="emp_active_yn" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Active Date"
                                    label-for="emp_active_date"
                                    label-cols-md="4">
                                    <b-form-input :value="activeDate" id="emp_active_date" disabled></b-form-input>
                                </b-form-group>
                            </b-col>

                        </b-row>
                    </b-card-body>

                </b-card>
                <b-card>
                    <b-card-body>
                        <h4 class="text-center">OTHERS</h4>
                        <hr>
                        <b-row>
                            <b-col md="6">
                                <b-form-group
                                    label="GPF Status"
                                    label-for="gpf_yn"
                                    label-cols-md="4">
                                    <b-form-input :value="gpf_status" id="gpf_yn" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="GPF ID"
                                    label-for="emp_pf_id"
                                    label-cols-md="4">
                                    <b-form-input :value="employee.emp_pf_id" id="emp_pf_id" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Bank"
                                    label-for="bank_name"
                                    label-cols-md="4">
                                    <b-form-input :value="(!employee.employeeSelectedBank)?'':employee.employeeSelectedBank.text" id="bank_name" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Bank Branch"
                                    label-for="branch_name"
                                    label-cols-md="4">
                                    <b-form-input :value="(!employee.employeeSelectedBankBranch)?'':employee.employeeSelectedBankBranch.text" id="branch_name" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Bank Account No."
                                    label-for="emp_bank_acc_no"
                                    label-cols-md="4">
                                    <b-form-input :value="employee.emp_bank_acc_no" id="emp_bank_acc_no" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="BCS Batch No."
                                    label-for="emp_bcs_batch_no"
                                    label-cols-md="4">
                                    <b-form-input :value="employee.emp_bcs_batch_no" id="emp_bcs_batch_no" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="TIN No."
                                    label-for="emp_tin_no"
                                    label-cols-md="4">
                                    <b-form-input :value="employee.emp_tin_no" id="emp_tin_no" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="On Pension"
                                    label-for="on_pension_yn"
                                    label-cols-md="4">
                                    <b-form-input :value="on_pension" id="on_pension_yn" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Deceased"
                                    label-for="deceased_yn"
                                    label-cols-md="4">
                                    <b-form-input :value="deceased" id="deceased_yn" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Bill Code"
                                    label-for="bill_code"
                                    label-cols-md="4">
                                    <b-form-input :value="employee.bill_code" id="bill_code" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Emergency Contact Name"
                                    label-for="emp_emergency_contact_name"
                                    label-cols-md="4">
                                    <b-form-input :value="employee.emp_emergency_contact_name" id="emp_emergency_contact_name" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Emergency Contact Mobile"
                                    label-for="emp_emergency_contact_mobile"
                                    label-cols-md="4">
                                    <b-form-input :value="employee.emp_emergency_contact_mobile" id="emp_emergency_contact_mobile" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Relation Type"
                                    label-for="relation_type"
                                    label-cols-md="4">
                                    <b-form-input :value="(!employee.employeeSelectedEmergencyRelationType)?'':employee.employeeSelectedEmergencyRelationType.text" id="relation_type" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Emergency Contact Address"
                                    label-for="emp_emergency_contact_address"
                                    label-cols-md="4">
                                    <b-form-input :value="employee.emp_emergency_contact_address" id="emp_emergency_contact_address" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Confirmation Date"
                                    label-for="emp_confirmation_date"
                                    label-cols-md="4">
                                    <b-form-input :value="confirmationDate" id="emp_confirmation_date" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Medical Book ID"
                                    label-for="emp_medical_book_id"
                                    label-cols-md="4">
                                    <b-form-input :value="employee.emp_medical_book_id" id="emp_medical_book_id" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Security ID"
                                    label-for="emp_security_id"
                                    label-cols-md="4">
                                    <b-form-input :value="employee.emp_security_id" id="emp_security_id" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="HBL Status"
                                    label-for="hbl_yn"
                                    label-cols-md="4">
                                    <b-form-input :value="hblStatus" id="hbl_yn" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Allowance Status"
                                    label-for="allowance_yn"
                                    label-cols-md="4">
                                    <b-form-input :value="allowance_status" id="allowance_yn" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Selection Grade"
                                    label-for="selection_grade_yn"
                                    label-cols-md="4">
                                    <b-form-input :value="selection_grade_status" id="selection_grade_yn" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-card-body>
                </b-card>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import SingleLightbox from "../../components/SingleLightbox";
    import moment from "moment";
    import ApiRepository from "../../../Repository/ApiRepository";
    export default {
        name: "Profile",
        components: {
            'single-lightbox': SingleLightbox
        },
        data() {
            return {
                employee: {}
            }
        },
        methods: {
            loadData(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/employeeProfile`).then(result => {
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
            this.$store.commit("setBreadcrumb", {link: "dashboard", label: "Dashboard"});
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account", label: "My Account"});
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account/nominee", label: "My Profile"});
            this.loadData()
        },
        watch: {
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

</style>
