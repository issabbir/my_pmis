<template>
    <div class="content-body">
        <b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">My Payslip</b-card-header>
            <b-card-body class="border">
                <b-form @submit.prevent="loadPayslip">
                    <b-row>
                        <b-col md="5">
                            <b-form-group
                                label="Month"
                                label-for="month"
                                label-cols-md="3"
                            >
                                <b-form-select id="month" :options="monthOptions" v-model="formData.pr_month"></b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="2">
                            <b-button type="submit">Search</b-button>
                        </b-col>
                    </b-row>
                </b-form>

                <Datatable :items="items" :perPage="perPage" :fields="fields" >
                    <template v-slot:actions="{ rows }"  >
                        <a size="sm" @click="renderPaySlip(rows.item)"> <i class="bx bx-detail cursor-pointer"></i> </a>
                    </template>
                </Datatable>
            </b-card-body>
        </b-card>
        <b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">My Bonus Payslip</b-card-header>
            <b-card-body class="border">
                <b-form @submit.prevent="loadBonusPayslip">
                    <b-row>
                        <b-col md="5">
                            <b-form-group
                                label="Month"
                                label-for="month"
                                label-cols-md="3"
                            >
                                <b-form-select id="month" :options="monthOptions" v-model="formData.pr_month"></b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="5">
                            <b-form-group
                                label="Bonus Type"
                                label-for="bonusType"
                                label-cols-md="3"
                            >
                                <b-form-select id="bonusType" :options="bonusTypeOptions" v-model="formData.bonus_type"></b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="2">
                            <b-button type="submit">Search</b-button>
                        </b-col>
                    </b-row>
                </b-form>

                <Datatable :items="bItems" :perPage="perPage" :fields="fields" >
                    <template v-slot:actions="{ rows }"  >
                        <a size="sm" @click="renderBonusPaySlip(rows.item)"> <i class="bx bx-detail cursor-pointer"></i> </a>
                    </template>
                </Datatable>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import Datatable from "../../../layouts/common/datatable";
    import ApiRepository from "../../../Repository/ApiRepository";
    import axios from "axios";

    export default {
        name: "Payslip",
        components: {Datatable},
        data() {
            return {
                csrf:'',
                reportPaySlip: {
                    pr_month: '',
                    bill_code: 81,
                    type: "pdf",
                    xdo: '~weblogic/Payroll/Emp_pay_slip.xdo',
                    pr_year:'',
                    filename: 'Employee+Pay+slip',
                    emp_code:""
                },
                reportBonusPaySlip: {
                    pr_month: '',
                    bill_code: 81,
                    type: "pdf",
                    xdo: '~weblogic/Payroll/RPT_Emp_pay_slip_bonus.xdo',
                    pr_year:'',
                    filename: 'Employee+Pay+slip',
                    emp_code:""
                },
                formData: {
                    pr_month: '',
                    bonus_type: '',
                    fy_id: ''
                },
                fields: [
                    {key: 'bill_code', label: 'Bill Code', sortable: true},
                    {key: 'formatted_month', label: 'Month', sortable: true},
                    {key: 'sum_allowance', label: 'Allowance', sortable: true, class: 'text-right'},
                    {key: 'bonus_amount', label: 'Bonus', sortable: true, class: 'text-right'},
                    {key: 'sum_deduction', label: 'Deduction', sortable: true, class: 'text-right'},
                    {key: 'salary', label: 'Salary', sortable: true, class: 'text-right'},
                    {key: 'action', class: 'text-center'}
                ],
                items: [],
                bItems: [],
                perPage: 5,
                totalList: 1,
                yearOptions: [],
                monthOptions: [],
                bonusTypeOptions: []
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "dashboard", label: "Dashboard"});
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account", label: "My Account"});
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account/attendance", label: "My Payslip"});
            this.loadData()

        },
        methods: {
            loadData: function () {
                this.csrf = axios.defaults.headers.common['X-CSRF-TOKEN'];
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pmis/api/getMonthsById").then(res => {
                    this.monthOptions = res.data
                    if(this.monthOptions.length>0){
                        this.monthOptions.unshift({ value: '', text: 'All' })
                        this.formData.pr_month = ''
                    }
                })
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pmis/api/bonus-type").then(res => {
                    console.log(res);
                    this.bonusTypeOptions = res.data
                    if(this.bonusTypeOptions.length>0){
                        this.bonusTypeOptions.unshift({ value: '', text: 'All' })
                        this.formData.bonus_type = ''
                    }
                })
            },
            loadPayslip() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/api/payslip/details`, this.formData).then(result => {
                    console.log(result)
                    this.items = result.data
                })
            },
            loadBonusPayslip() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/api/bonus-payslip/details`, this.formData).then(result => {
                    console.log(result)
                    this.bItems = result.data
                })
            },
            renderPaySlip(data){
                this.reportPaySlip.bill_code = data.bill_code;
                this.reportPaySlip.pr_year = data.pr_year;
                this.reportPaySlip.pr_month = data.pr_month_id;
                this.reportPaySlip.emp_code = data.emp_code;
                this.reportPaySlip.type='pdf';
                let params = this.reportPaySlip;
                let queryString = Object.keys(params).map(function (key) {
                    return key + "=" + params[key]
                }).join('&');
                window.open('/report/render/Employee Pay slip?' + queryString,"_blank");
            },
            renderBonusPaySlip(data){
                this.reportBonusPaySlip.bill_code = data.bill_code;
                this.reportBonusPaySlip.pr_year = data.pr_year;
                this.reportBonusPaySlip.pr_month = data.pr_month_id;
                this.reportBonusPaySlip.emp_code = data.emp_code;
                this.reportBonusPaySlip.type='pdf';
                let params = this.reportBonusPaySlip;
                let queryString = Object.keys(params).map(function (key) {
                    return key + "=" + params[key]
                }).join('&');
                window.open('/report/render/Employee Bonus Pay slip?' + queryString,"_blank");
            }
        }
    }
</script>

<style scoped>
    div.form-group.requiredField  label:after{
        content: '*';
        color: red;
    }
</style>
