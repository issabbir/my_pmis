<template>
    <div>
        <h4 class="text-center">GENERAL</h4>
        <hr>
        <b-row>
            <b-col md="8">
                <b-row>
                    <b-col md="6">
                        <b-form-group
                            label="Employee Code"
                            label-for="emp_code"
                            label-cols-md="3">
                            <b-form-input :value="employee.emp_code" id="emp_code" disabled></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Employee Name"
                            label-for="emp_name"
                            label-cols-md="3">
                            <b-form-input :value="employee.emp_name" id="emp_name" disabled></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Employee Name (Bengali)"
                            label-for="emp_name_bng"
                            label-cols-md="3">
                            <b-form-input :value="employee.emp_name_bng" id="emp_name_bng" disabled></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Father's Name"
                            label-for="emp_father_name"
                            label-cols-md="3">
                            <b-form-input :value="employee.emp_father_name" id="emp_father_name" disabled></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Father's Name (Bengali)"
                            label-for="emp_father_name_bng"
                            label-cols-md="3">
                            <b-form-input :value="employee.emp_father_name_bng" id="emp_father_name_bng" disabled></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Mother's Name"
                            label-for="emp_mother_name"
                            label-cols-md="3">
                            <b-form-input :value="employee.emp_mother_name" id="emp_mother_name" disabled></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>
            </b-col>
            <b-col md="4" class="d-flex justify-content-center">
                <b-form-group>
                    <img id="" :src="employee.emp_photo ? employee.emp_photo : '/images/avatar.png'" width="150" height="150" alt="...">
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="4">
                <b-form-group
                    label="Mother's Name (Bengali)"
                    label-for="emp_mother_name_bng"
                    label-cols-md="3">
                    <b-form-input :value="employee.emp_mother_name_bng" id="emp_mother_name_bng" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Blood Group"
                    label-for="blood_group"
                    label-cols-md="3">
                    <b-form-input :value="blood_group.text" id="blood_group" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Date of Birth"
                    label-for="emp_dob"
                    label-cols-md="3">
                    <b-form-input :value="birthDate" id="emp_dob" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Age"
                    label-for="age"
                    label-cols-md="3">
                    <b-form-input :value="employee.age" id="age" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Gender"
                    label-for="gender_name"
                    label-cols-md="3">
                    <b-form-input :value="employee.emp_gender_name" id="gender_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Marital Status"
                    label-for="marital_status"
                    label-cols-md="3">
                    <b-form-input :value="marital_status.text" id="marital_status" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Nationality"
                    label-for="nationality"
                    label-cols-md="3">
                    <b-form-input :value="nationality.text" id="nationality" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Religion"
                    label-for="emp_religion_name"
                    label-cols-md="3">
                    <b-form-input :value="religion.text" id="emp_religion_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Authentication Type Name"
                    label-for="auth_doc_type_name"
                    label-cols-md="3">
                    <b-form-input :value="authentication_type.text" id="auth_doc_type_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Authentication ID No."
                    label-for="nid_no"
                    label-cols-md="3">
                    <b-form-input :value="employee.auth_no" id="auth_no" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Previous Workplace"
                    label-for="previous_workplace"
                    label-cols-md="3">
                    <b-form-input :value="employee.previous_workplace" id="previous_workplace" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Previous Designation"
                    label-for="previous_designation"
                    label-cols-md="3">
                    <b-form-input :value="employee.previous_designation" id="previous_designation" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Tribal"
                    label-for="tribal_yn"
                    label-cols-md="3">
                    <b-form-input :value="tribal" id="tribal_yn" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Active"
                    label-for="emp_active_yn"
                    label-cols-md="3">
                    <b-form-input :value="active" id="emp_active_yn" disabled></b-form-input>
                </b-form-group>
            </b-col>
        </b-row>
        <h4 class="text-center">POSITION</h4>
        <hr>
        <b-row>
            <b-col md="4">
                <b-form-group
                    label="Division"
                    label-for="dpt_division_name"
                    label-cols-md="3">
                    <b-form-input :value="division.text" id="dpt_division_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Department"
                    label-for="department_name"
                    label-cols-md="3">
                    <b-form-input :value="department.text" id="department_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Section"
                    label-for="dpt_section"
                    label-cols-md="3">
                    <b-form-input :value="section.text" id="dpt_section" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Designation"
                    label-for="designation"
                    label-cols-md="3">
                    <b-form-input :value="designation.text" id="designation" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Employee Type"
                    label-for="emp_type_name"
                    label-cols-md="3">
                    <b-form-input :value="employee_type.text" id="emp_type_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Grade"
                    label-for="grade_range"
                    label-cols-md="3">
                    <b-form-input class="text-right" :value="payGrade.text" id="grade_range" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                  label="Grade Step"
                  label-for="grade_step"
                  label-cols-md="3">
                    <b-form-input class="text-right" :value="gradeStep.text" id="grade_step" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Class"
                    label-for="emp_class"
                    label-cols-md="3">
                    <b-form-input :value="employee.emp_class" id="emp_class" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Joining Date"
                    label-for="emp_join_date"
                    label-cols-md="3">
                    <b-form-input :value="joiningDate" id="emp_join_date" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="PRL Date"
                    label-for="emp_lpr_date"
                    label-cols-md="3">
                    <b-form-input :value="employee.emp_lpr_date" id="emp_lpr_date" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Status"
                    label-for="emp_status"
                    label-cols-md="3">
                    <b-form-input :value="employee.emp_status_name" id="emp_status" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Appointment Type"
                    label-for="appoinment_type"
                    label-cols-md="3">
                    <b-form-input :value="appointment_type.text" id="appoinment_type" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Active Date"
                    label-for="emp_active_date"
                    label-cols-md="3">
                    <b-form-input :value="activeDate" id="emp_active_date" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="PIN/ID NO"
                    label-for="pin_id_no"
                    label-cols-md="3">
                    <b-form-input :value="employee.pin_id_no" id="pin_id_no" disabled></b-form-input>
                </b-form-group>
            </b-col>

        </b-row>
        <h4 class="text-center">OTHERS</h4>
        <hr>
        <b-row>
            <b-col md="4">
                <b-form-group
                    label="Working Location"
                    label-for="working_location"
                    label-cols-md="3">
                    <b-form-input :value="location.text" id="working_location" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Bank"
                    label-for="bank_name"
                    label-cols-md="3">
                    <b-form-input :value="bank.text" id="bank_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Bank Branch"
                    label-for="branch_name"
                    label-cols-md="3">
                    <b-form-input :value="branch.text" id="branch_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Bank Account No."
                    label-for="emp_bank_acc_no"
                    label-cols-md="3">
                    <b-form-input :value="employee.emp_bank_acc_no" id="emp_bank_acc_no" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="TIN No."
                    label-for="emp_tin_no"
                    label-cols-md="3">
                    <b-form-input :value="employee.emp_tin_no" id="emp_tin_no" disabled></b-form-input>
                </b-form-group>
            </b-col>

            <b-col md="4">
                <b-form-group
                    label="Bill Code"
                    label-for="bill_code"
                    label-cols-md="3">
                    <b-form-input :value="employee.bill_code" id="bill_code" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Medical Book ID"
                    label-for="emp_medical_book_id"
                    label-cols-md="3">
                    <b-form-input :value="employee.emp_medical_book_id" id="emp_medical_book_id" disabled></b-form-input>
                </b-form-group>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import moment from 'moment'
    export default {
        name: "employee-preview",
        props:[
            'employee',
            'division',
            'department',
            'designation',
            'section',
            'employee_type',
            'bank',
            'branch',
            'appointment_type',
            'location',
            'payGrade',
            'gradeStep',
            'salutation',
            'blood_group',
            'authentication_type',
            'religion',
            'nationality',
            'marital_status'
        ],
        data() {
           return  {
           }
        },
        watch: {
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
