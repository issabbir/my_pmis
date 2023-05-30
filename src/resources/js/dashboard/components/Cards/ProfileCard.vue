<template>
    <div class="content-body">
        <b-row v-if="showLPRNotice">
            <b-col md="12">
            <b-alert show variant="info">
                <h4 class="alert-heading">LPR Date</h4>
                <p>
                    Your LPR Date will be over in a year.
                </p>
            </b-alert>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="12">
                <b-card >
                    <b-card-body>
                            <b-row>
                                <b-col md="3">
                                    <b-img rounded="circle" :src="employee.emp_photo ? employee.emp_photo : '/images/avatar.png'" width="120" height="120"></b-img>
                                </b-col>
                                <b-col md="9">
                                    <b-form-input :value="(!employee.salutation_id)?employee.emp_name:employee.salutation_id.salutation + ' ' + employee.emp_name" id="salutation" disabled></b-form-input>
                                    <b-form-input :value="(employee.currentDesignation)? employee.currentDesignation.designation+', '+employee.employeeSelectedDepartment.text:employee.designation.designation+', '+employee.employeeSelectedDepartment.text" id="designation" disabled></b-form-input>
                                    <b-form-input :value="((!employee.emp_blood_group_id)?'':'Blood Group # '+employee.emp_blood_group_id.text)+', DOB # '+birthDate+', Employee Code # '+employee.emp_code" id="blood_group" disabled></b-form-input>
                                </b-col>
                            </b-row>
                        <hr>
                            <b-row>
                                <b-col md="3">
                                    <b-form-group
                                        label="Status"
                                        label-for="emp_status">
                                        <b-alert :variant="color" :show="color">
                                            <label  class="text-white font-weight-bold" id="emp_status">{{ (!employee.employeeSelectedJobStatus)?'':employee.employeeSelectedJobStatus.text }}</label>
                                        </b-alert>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        class="text-nowrap"
                                        label="Appointment Type"
                                        label-for="appoinment_type">
                                        <label id="appoinment_type">{{ (!employee.employeeSelectedAppointmentType)?'':employee.employeeSelectedAppointmentType.text }}</label>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Active Date"
                                        label-for="emp_active_date">
                                        <label id="emp_active_date">{{ activeDate }}</label>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="PRL Date"
                                        label-for="emp_lpr_date">
                                        <label id="emp_lpr_date">{{ employee.emp_lpr_date }}</label>
                                    </b-form-group>
                                </b-col>
                            </b-row>
<!--                        <b-form-group>-->
<!--                            -->
<!--                        </b-form-group>-->
<!--                        <b-form-group-->
<!--                            label="Employee Code"-->
<!--                            label-for="emp_code"-->
<!--                            label-cols-md="4">-->
<!--                            <b-form-input :value="employee.emp_code" id="emp_code" disabled></b-form-input>-->
<!--                        </b-form-group>-->
<!--                        <b-form-group-->
<!--                            label-cols-md="4">-->
<!--                            <b-form-input :value="(!employee.salutation_id)?'':employee.salutation_id.salutation + employee.emp_name" id="salutation" disabled></b-form-input>-->
<!--                        </b-form-group>-->
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
        name: "ProfileCard",
        components: {
            'single-lightbox': SingleLightbox
        },
        data() {
            return {
                employee: {
                    employeeSelectedJobStatus: {
                        emp_status: "",
                        emp_status_bng: '',
                        emp_status_id: '',
                        enable_yn: '',
                        text: "",
                        value: ''
                    }
                },
                color: '',
                showLPRNotice: false
                // color: 'bg-success'
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
                        moment(this.employee.emp_dob).add(61, 'year').format("DD/MM/YYYY"):
                        moment(this.employee.emp_dob).add(59, 'year').format("DD/MM/YYYY"):
                    this.employee.emp_lpr_date = '';

                let todayPlusOneYear = new moment().add(365, 'days');

                let lpr = this.employee.emp_lpr_date;
                if (lpr && lpr.isBefore(todayPlusOneYear)) {
                    this.showLPRNotice = true;
                }
            },
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "dashboard", label: "Dashboard"});
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account", label: "My Account"});
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account/nominee", label: "My Profile"});
            this.loadData();
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
            employee: function (val, oldVal) {
                val.employeeSelectedJobStatus.value=='1'?this.color='success':this.color='secondary'
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
    .alert {
        padding: 2px 10px;
    }
</style>
