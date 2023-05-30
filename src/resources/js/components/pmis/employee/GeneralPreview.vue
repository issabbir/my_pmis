<template>
    <div>
        <b-row>
            <b-col md="8">
                <b-row>
                    <b-col md="6">
                        <b-form-group
                            label="Deputation"
                            label-for="deputation"
                            label-cols-md="3">
                            <b-form-input :value="deputation" disabled id="deputation"></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Previous Workplace"
                            label-for="previous_workplace"
                            label-cols-md="3">
                            <b-form-input :value="employee.previous_workplace" id="previous_workplace" disabled></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Previous Designation"
                            label-for="previous_designation"
                            label-cols-md="3">
                            <b-form-input :value="employee.previous_designation" id="previous_designation" disabled></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="6">
                        <b-form-group
                            label="Previous Office Address"
                            label-for="previous_office_address"
                            label-cols-md="3">
                            <b-form-input :value="employee.previous_office_address" id="previous_office_address" disabled></b-form-input>
                        </b-form-group>
                    </b-col>
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
                            label="Salutation"
                            label-for="salutation"
                            label-cols-md="3">
                            <b-form-input :value="(!employee.salutation_id)?'':employee.salutation_id.salutation" id="salutation" disabled></b-form-input>
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
                    label="Employee Name"
                    label-for="emp_name"
                    label-cols-md="3">
                    <b-form-input :value="employee.emp_name" id="emp_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Employee Name (Bengali)"
                    label-for="emp_name_bng"
                    label-cols-md="3">
                    <b-form-input :value="employee.emp_name_bng" id="emp_name_bng" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Father's Name"
                    label-for="emp_father_name"
                    label-cols-md="3">
                    <b-form-input :value="employee.emp_father_name" id="emp_father_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Father's Name (Bengali)"
                    label-for="emp_father_name_bng"
                    label-cols-md="3">
                    <b-form-input :value="employee.emp_father_name_bng" id="emp_father_name_bng" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Mother's Name"
                    label-for="emp_mother_name"
                    label-cols-md="3">
                    <b-form-input :value="employee.emp_mother_name" id="emp_mother_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
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
                    <b-form-input :value="(!employee.emp_blood_group_id)?'':employee.emp_blood_group_id.text" id="blood_group" disabled></b-form-input>
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
                    <b-form-input :value="(!employee.emp_gender_id)?'':employee.emp_gender_id.gender_name" id="gender_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Marital Status"
                    label-for="marital_status"
                    label-cols-md="3">
                    <b-form-input :value="(!employee.emp_maritial_status_id)?'':employee.emp_maritial_status_id.text" id="marital_status" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Nationality"
                    label-for="nationality"
                    label-cols-md="3">
                    <b-form-input :value="(!employee.emp_nationality_id)?'':employee.emp_nationality_id.text" id="nationality" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Religion"
                    label-for="emp_religion_name"
                    label-cols-md="3">
                    <b-form-input :value="employee.emp_religion_name" id="emp_religion_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Identity Symbol"
                    label-for="identity_symbol"
                    label-cols-md="3">
                    <b-form-input :value="employee.identity_symbol" id="identity_symbol" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Identity Symbol (Bengali)"
                    label-for="identity_symbol_bng"
                    label-cols-md="3">
                    <b-form-input :value="employee.identity_symbol_bng" id="identity_symbol_bng" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Authentication Type Name"
                    label-for="auth_doc_type_name"
                    label-cols-md="3">
                    <b-form-input :value="(!employee.auth_doc_type_id)?'':employee.auth_doc_type_id.text" id="auth_doc_type_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Authentication ID No."
                    label-for="nid_no"
                    label-cols-md="3">
                    <b-form-input :value="employee.nid_no" id="nid_no" disabled></b-form-input>
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

        </b-row>
    </div>
</template>

<script>
    import moment from 'moment'
    export default {
        name: "general-preview",
        props:{
            employee : {},

        },
        data() {
            return  {
            }
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
