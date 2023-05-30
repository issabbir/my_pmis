<template>
    <div>
        <b-row>
            <b-col md="4">
                <b-form-group
                    label="Division"
                    label-for="dpt_division_name"
                    label-cols-md="3">
                    <b-form-input :value="(!employee.dpt_division_id)?'':employee.dpt_division_id.text" id="dpt_division_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Department"
                    label-for="department_name"
                    label-cols-md="3">
                    <b-form-input :value="(!employee.dpt_department_id)?'':employee.dpt_department_id.text" id="department_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Section"
                    label-for="dpt_section"
                    label-cols-md="3">
                    <b-form-input :value="(!employee.section_id)?'':employee.section_id.text" id="dpt_section" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Designation"
                    label-for="designation"
                    label-cols-md="3">
                    <b-form-input :value="(!employee.designation_name)?'':employee.designation_name.designation" id="designation" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Current Department"
                    label-for="current_department_name"
                    label-cols-md="3">
                    <b-form-input :value="(!employee.current_department_id)?'':employee.current_department_id.text" id="current_department_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Employee Type"
                    label-for="emp_type_name"
                    label-cols-md="3">
                    <b-form-input :value="(!employee.emp_type_id)?'':employee.emp_type_id.emp_type_name" id="emp_type_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Grade"
                    label-for="grade_range"
                    label-cols-md="3">
                    <b-form-input class="text-right" :value="(!employee.emp_grade_id)?'':employee.emp_grade_id.text" id="grade_range" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Grade Step"
                    label-for="basic_amt"
                    label-cols-md="3">
                    <b-form-input class="text-right" :value="(!employee.grade_step_id)?'':employee.grade_step_id.text" id="basic_amt" disabled></b-form-input>
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
                    label="GO Number"
                    label-for="emp_go_number"
                    label-cols-md="3">
                    <b-form-input :value="employee.emp_go_number" id="emp_go_number" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="GO Date"
                    label-for="emp_go_date"
                    label-cols-md="3">
                    <b-form-input :value="goDate" id="emp_go_date" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Quota"
                    label-for="quota_name"
                    label-cols-md="3">
                    <b-form-input :value="(!employee.emp_quota_id)?'':employee.emp_quota_id.text" id="quota_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="LPR Date"
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
                    <b-form-input :value="(!employee.emp_status_id)?'':employee.emp_status_id.text" id="emp_status" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Post Type"
                    label-for="post_type"
                    label-cols-md="3">
                    <b-form-input :value="(!employee.post_type_id)?'':employee.post_type_id.text" id="post_type" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="OT Category"
                    label-for="ot_category"
                    label-cols-md="3">
                    <b-form-input :value="(!employee.ot_category_id)?'':employee.ot_category_id.text" id="ot_category" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Reporting Officer"
                    label-for="option_name"
                    label-cols-md="3">
                    <b-form-input :value="(!employee.reporting_officer)?'':employee.reporting_officer.option_name" id="option_name" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                    label="Appointment Type"
                    label-for="appoinment_type"
                    label-cols-md="3">
                    <b-form-input :value="(!employee.appointment_type_id)?'':employee.appointment_type_id.text" id="appoinment_type" disabled></b-form-input>
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
            <b-col md="4">
                <b-form-group
                    label="Active Date"
                    label-for="emp_active_date"
                    label-cols-md="3">
                    <b-form-input :value="activeDate" id="emp_active_date" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="3">
                <b-form-group
                  label-cols-md="3"
                  label="Merit Position"
                  label-for="merit_position">
                    <b-form-input
                      id="merit_position"
                      name="merit_position"
                      :value="employee.merit_position"
                      disabled
                    >
                    </b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="3">
                <b-form-group
                  label-cols-md="3"
                  label="Academic"
                  label-for="academic_yn">
                    <b-form-input id="academic_yn"
                                  name="academic_yn"
                                  :value="employee.academic_yn == 'Y'?'Yes': 'No'"
                                  disabled
                    >
                    </b-form-input>
                </b-form-group>
            </b-col>
        </b-row>
        <hr/>
        <h5 v-if="employee.selectedEmpAddCharge!=null">Additional Charge</h5>
        <b-row v-if="employee.selectedEmpAddCharge!=null">
            <b-col md="4">
            <b-form-group
                    label="Division"
                    label-for="additional_charge_division"
                    label-cols-md="3">
                <b-form-input :value="(!employee.selectedEmpAddCharge.charge_dpt_division)?'':employee.selectedEmpAddCharge.charge_dpt_division.dpt_division_name" id="additional_charge_division" disabled></b-form-input>
            </b-form-group>
        </b-col>
            <b-col md="4">
                <b-form-group
                        label="Department"
                        label-for="additional_charge_department"
                        label-cols-md="3">
                    <b-form-input :value="(!employee.selectedEmpAddCharge.charge_department)?'':employee.selectedEmpAddCharge.charge_department.department_name" id="additional_charge_department" disabled></b-form-input>
                </b-form-group>
            </b-col>
            <b-col md="4">
                <b-form-group
                        label="Designation"
                        label-for="additional_charge_designation"
                        label-cols-md="3">
                    <b-form-input :value="(!employee.selectedEmpAddCharge.charge_designation)?'':employee.selectedEmpAddCharge.charge_designation.designation" id="additional_charge_designation" disabled></b-form-input>
                </b-form-group>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import moment from 'moment'
    export default {
        name: "position-preview",
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
