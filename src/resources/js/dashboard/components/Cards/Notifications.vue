<template>
    <div class="content-body">
        <b-row>
            <b-col md="12">
                <b-card >
                    <b-card-body>
                        <b-alert show variant="info">
                            <h4 class="alert-heading">LPR Date</h4>
                            <p>
                                Aww yeah, you successfully read this important alert message. This example text is going to
                                run a bit longer so that you can see how spacing within an alert works with this kind of
                                content.
                            </p>
                            <hr>
                            <p class="mb-0">
                                Whenever you need to, be sure to use margin utilities to keep things nice and tidy.
                            </p>
                        </b-alert>
                    </b-card-body>
                </b-card>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import moment from "moment";
    import ApiRepository from "../../../Repository/ApiRepository";
    export default {
        name: "AlertMessage",
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
                color: ''
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
                    this.employee.emp_lpr_date = ''
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
