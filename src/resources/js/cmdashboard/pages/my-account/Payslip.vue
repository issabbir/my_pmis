<template>
    <div class="content-body">
        <b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">My Payslip</b-card-header>
            <b-card-body class="border">
                <b-form @submit.prevent="loadPayslip">
                    <b-row>
                        <b-col md="5">
                            <b-form-group
                                label="Year"
                                label-for="year"
                                label-cols-md="3"
                                class="requiredField"
                            >
                                <b-form-select required id="year" @input="loadMonth()" value-field="fy_id" text-field="fy_name" :options="yearOptions" v-model="formData.fy_id"></b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="5">
                            <b-form-group
                                label="Month"
                                label-for="month"
                                label-cols-md="3"
                            >
                                <b-form-select id="month" value-field="pr_month_id" text-field="month" :options="monthOptions" v-model="formData.pr_month"></b-form-select>
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
    </div>
</template>

<script>
    import Datatable from "../../../layouts/common/datatable";
    import ApiRepository from "../../../Repository/ApiRepository";

    export default {
        name: "Payslip",
        components: {Datatable},
        data() {
            return {
                reportPaySlip: {
                    pr_month: '',
                    bill_code: 81,
                    type: "pdf",
                    xdo: '~weblogic/Payroll/Emp_pay_slip.xdo',
                    pr_year:'',
                    filename: 'Employee+Pay+slip',
                    emp_code:""
                },
                formData: {
                    pr_month: '',
                    fy_id: ''
                },
                fields: [
                    {key: 'bill_code', label: 'Bill Code', sortable: true},
                    {key: 'formatted_sum_allowance', label: 'Allowance', sortable: true, class: 'text-right'},
                    {key: 'formatted_bonus', label: 'Bonus', sortable: true, class: 'text-right'},
                    {key: 'formatted_sum_deduction', label: 'Deduction', sortable: true, class: 'text-right'},
                    {key: 'formatted_salary', label: 'Salary', sortable: true, class: 'text-right'},
                    {key: 'action', class: 'text-center'}
                ],
                items: [],
                perPage: 5,
                totalList: 1,
                yearOptions: [],
                monthOptions: []
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "dashboard", label: "Dashboard"});
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account", label: "My Account"});
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account/attendance", label: "My Payslip"});
            this.loadYear()

        },
        methods: {
            loadPayslip() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/api/payslip/details`, this.formData).then(result => {
                    this.items = result.data
                })
            },
            loadYear(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/api/fiscal-year`).then(result => {
                    this.yearOptions = result.data.data.fiscal_year
                });
            },
            loadMonth(){
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/api/fiscal-year-wise-month`, this.formData).then(result => {
                    this.monthOptions = result.data.data.fiscal_year
                    if(this.monthOptions.length>0){
                        this.monthOptions.unshift({ pr_month_id: '', month: 'ALL' })
                        this.formData.pr_month = ''
                    }
                });
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
                //return '/report/render/Employee Pay slip?' + queryString;
                window.open('/report/render/Employee Pay slip?' + queryString,"_blank");
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
