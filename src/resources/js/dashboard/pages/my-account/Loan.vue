<template>
    <div class="content-body">
        <b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">Loan Information</b-card-header>
            <b-card-body class="border">
               <!-- <b-form @submit.prevent="loadLoan">
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Loan Type"
                                label-for="loan_type_id"
                            >
                                <b-form-select id="loan_type_id"  value-field="loan_type_id" text-field="loan_name" :options="loanTypeOptions" v-model="formData.loan_type_id"></b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Loan No"
                                label-for="loan_no"
                            >
                                <b-form-input id="month" v-model="formData.loan_no"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Year From"
                                label-for="year_from"
                            >
                                <b-form-select id="year_from" :options="yearOptions" v-model="formData.year_from"></b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Month From"
                                label-for="month_from"
                            >
                                <b-form-select id="month_from" value-field="month_id" text-field="month_name" :options="monthOptions" v-model="formData.month_from"></b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Year To"
                                label-for="year_to"
                            >
                                <b-form-select id="year_to" :options="yearOptions" v-model="formData.year_to"></b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Month From"
                                label-for="month_to"
                            >
                                <b-form-select id="month_to" value-field="month_id" text-field="month_name" :options="monthOptions" v-model="formData.month_to"></b-form-select>
                            </b-form-group>
                        </b-col>

                    </b-row>
                    <b-row>
                        <b-col class="d-flex justify-content-end">
                            <b-button type="submit">Search</b-button>
                        </b-col>
                    </b-row>
                </b-form>-->
                <Datatable :items="items" :perPage="perPage" :fields="fields" :totalList="totalList"></Datatable>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import Datatable from "../../../layouts/common/datatable"
    import ApiRepository from "../../../Repository/ApiRepository"
    import moment from "moment";
    export default {
        name: "Loan",
        components: {Datatable},
        data() {
            return {
                formData: {
                    loan_type_id: '',
                    loan_no: '',
                    year_from: '',
                    month_from: '',
                    year_to: '',
                    month_to: ''
                },
                fields: [
                    {key: 'index', label: 'Sl.', sortable: true},
                    {key: 'loan_no', label: 'Loan No', orderDate: true},
                    {key: 'loan', label: 'Loan Amount', orderDate: true},
                    {key: 'installment_amount', sortable: true},
                    {key: 'interest_rate', sortable: true},
                    {key: 'loan_interest_paid', label: 'Interest Paid', sortable: true},
                    {key: 'loan_repay_amount', label: 'Repay Amount', sortable: true},
                    {key: 'opening', sortable: true},
                    {key: 'total_installment', sortable: true},
                    {key: 'total_paid_installment', sortable: true},
                    {key: 'loan_balance', sortable: true},
                ],
                items: [],
                perPage: 5,
                totalList: 1,
                loanTypeOptions: [],
                yearOptions: [],
                monthOptions: []
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty")
            this.$store.commit("setBreadcrumb", {link: "dashboard", label: "Dashboard"})
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account", label: "My Account"})
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account/loan", label: "Loan Information"})
            this.loadLoanType()
            this.loadYear()
            this.loadMonth()
            this.loadLoan()

        },
        methods: {
            loadLoan() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/api/employee-loans`, this.formData).then(result => {
                    this.items = result.data.data.loan
                    this.totalList = this.items.length
                });
            },
            loadLoanType() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/api/loan-pf-loan-type`).then(result => {
                    this.loanTypeOptions = result.data.data.loan_types
                });
            },
            loadYear(){
                const years = []
                const dateStart = moment('1900')
                const dateEnd = moment().subtract(1, 'years')
                while (dateEnd.diff(dateStart, 'years') >= 0) {
                    years.push(dateStart.format('YYYY'))
                    dateStart.add(1, 'year')
                }
                this.yearOptions = years.sort(function(a, b){return b-a})
            },
            loadMonth(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/api/month/list`, this.formData).then(result => {
                    this.monthOptions = result.data.data.months
                });
            }
        }
    }
</script>

<style scoped>
.form-control{
    display: block;
    width: 100%;
    height: calc(1.4em + .94rem + 3.7px);
    padding: .47rem .8rem;
    font-size: 1rem;
    line-height: 1.4;
    color: #475F7B;
    background-color: #FFF;
    border: 1px solid #DFE3E7!important;
    border-radius: .267rem;
    -webkit-transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
</style>
