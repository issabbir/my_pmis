<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Existing Loan Edit</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>
                            <b-col md="4">
                                <b-form-group label="Loan Type" label-for="loan_type" class="required">
                                    <b-form-select
                                        id="loan_type"
                                        v-model="loanApplication.loan_type_id"
                                        text-field="loan_name"
                                        value-field="loan_type_id"
                                        :options="loanTypes"
                                        required
                                        @change="loanTypeChange(loanApplication.loan_type_id)">
                                    </b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Employee Code" label-for="emp_code" class="required">
                                    <v-select
                                        label="option_name"
                                        v-model="selectedEmployee"
                                        :options="empIdList"
                                        @search="searchEmployees"
                                        id="emp_code"
                                    >
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Employee Name" label-for="emp_name">
                                    <b-form-input id="emp_name" v-model="loanApplication.emp_name"
                                                  readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Designation" label-for="designation">
                                    <b-form-input id="designation" v-model="loanApplication.designation"
                                                  readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Department" label-for="department">
                                    <b-form-input id="department" v-model="loanApplication.department_name"
                                                  readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Loan No" label-for="loan_no">
                                    <b-form-input id="loan_no" v-model="loanApplication.loan_no"
                                                  readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Open Date" label-for="open_date">
                                    <date-picker
                                        width="100%"
                                        input-class="form-control"
                                        v-model="loanApplication.open_date"
                                        type="date"
                                        lang="en"
                                        :editable="false"
                                        format="DD/MM/YYYY"
                                        disabled>
                                    </date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Loan amount" label-for="loan_amount">
                                    <b-form-input v-model="loanApplication.loan_amount" number class="text-right" readonly
                                                  id="loan_amount"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Installment No" label-for="installment_no">
                                    <b-form-input v-model="loanApplication.installment_no" readonly number required
                                                  id="installment_no"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="First Disbursement Date" label-for="first_disbursement_date">
                                    <date-picker
                                        width="100%"
                                        input-class="form-control"
                                        v-model="loanApplication.first_disbursement_date"
                                        type="date"
                                        lang="en"
                                        :editable="false"
                                        format="DD/MM/YYYY" disabled>
                                    </date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Disbursement Amount" label-for="disbursement_amt">
                                    <b-form-input v-model="loanApplication.disbursement_amt" number class="text-right" readonly
                                                  id="disbursement_amt"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Paid Installment No" label-for="paid_installment_no">
                                    <b-form-input v-model="loanApplication.paid_installment_no " number readonly
                                                  id="paid_installment_no "></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Remaining Principal" label-for="remaining_principal">
                                    <b-form-input v-model="loanApplication.remaining_principal" number class="text-right"
                                                  id="remaining_principal"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Remaining Interest" label-for="remaining_interest">
                                    <b-form-input v-model="loanApplication.remaining_interest " number class="text-right" readonly
                                                  id="remaining_interest "></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Approximate installment amount" label-for="approx_installment_amount" class="required">
                                    <b-form-input v-model="loanApplication.approx_installment_amount" number class="text-right" required
                                                  id="approx_installment_amount"></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col class="mt-2 d-flex justify-content-end">
                                <b-button-group>
                                    <b-button  md="6" size="md" variant="primary"  type="submit">{{submitBtn}}</b-button>&nbsp;
                                    <b-button md="6" size="md" variant="secondary" type="reset">Reset</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import ApiRepository from '../../Repository/ApiRepository';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../layouts/common/datatable';

    export default {
        components: {vSelect, vcss,Datatable,DatePicker},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan Applications"});
            this.loadData();

         },
        computed: {
            splicedOptions: function () {
                return this.options.slice(0,-1)
            }
        },
        data() {
            return {
                loanApplication: {
                    application_id: null,
                    loan_no: null,
                    emp_id: null,
                    gpf_id: null,
                    loan_type_id: null,
                    application_amt: null,
                    remaining_principal: null,
                    remaining_interest: null,
                    rate_of_interest: null,
                    comment_status_1: '',
                    approval_status_1: 0,
                    comment_status_2: '',
                    approval_status_2: 0,
                    approx_installment_amount: null,
                    emp_name: null,
                    designation: null,
                    department_name: null,
                    dpt_section: null,
                    bill_code: null,
                    loan_amount :null,
                    disbursement_amt:null,
                    open_date:null,
                    first_disbursement_date:null,
                    installment_no:null,
                    paid_installment_no:null
                },
                max_value: null,
                submitBtn: 'Submit',
                formattedData: null,
                small: true,
                empIdList: [],
                listItems: [],
                loanTypes: [],
                totalItems: 0,
                selectedEmployee: {
                    basic_amt: "",
                    bill_code: "",
                    biller_code: null,
                    department_name: "",
                    designation: "",
                    designation_id: "",
                    division_name: "",
                    dpt_department_id: "",
                    dpt_division_id: "",
                    dpt_section: null,
                    emp_code: "",
                    emp_grade_id: "",
                    emp_id: "",
                    emp_name: "",
                    emp_name_bng: null,
                    gpf_id: "",
                    grade_range: "",
                    grade_step_id: "",
                    join_month: "",
                    join_year: "",
                    location_id: "",
                    location_name: "",
                    location_type_id: "",
                    location_type_name: "",
                    nps_year: "",
                    option_name: "",
                    rownum: "",
                    total_disbursement_amount: null,
                    section_id: null
                },
                show: true,
            }

        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null && val.emp_id != null) {
                    this.loanApplication = {
                        rate_of_interest: this.loanApplication.rate_of_interest,
                       // approx_installment_amount: this.loanApplication.approx_installment_amount,
                        loan_type_id: this.loanApplication.loan_type_id,
                        emp_name: val.emp_name,
                        designation: val.designation ? val.designation : null,
                        department_name: val.department_name ? val.department_name: null,
                        dpt_section: val.section_name ? val.dpt_section : null,
                        gpf_id: val.gpf_id,
                        bill_code: val.bill_code,
                        reason: this.loanApplication.reason,
                        application_amt: this.loanApplication.application_amt,
                        installment_no: val.installment_no ? val.installment_no : this.loanApplication.installment_no,
                        description: this.loanApplication.description,
                        approval_status_1: this.loanApplication.approval_status_1,
                        approval_status_2: this.loanApplication.approval_status_2,
                        approval_yn:this.loanApplication.approval_yn,
                        emp_code: val.emp_code,
                        emp_id: val.emp_id,
                        application_id: val.loan_id,
                        loan_no: val.loan_no,
                        remaining_interest: val.remaining_interest,
                        remaining_principal: val.remaining_principal,
                        approx_installment_amount: val.approx_installment_amount,
                        loan_amount: val.loan_amount,
                        open_date: val.open_date,
                        disbursement_amt: val.total_disbursement_amount,
                        first_disbursement_date: val.first_disbursement_date,
                        paid_installment_no: val.paid_installment_no
                    }
                }
            }
        },
        filters: {

        },
        methods: {
            onSubmit() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/loan/exist-loan-edit`, this.loanApplication).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.loadData();
                        this.onReset();

                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            loanTypeChange(id) {
                this.loanApplication.rate_of_interest = this.loanTypes.filter(a => a.loan_type_id == id)[0].rate_of_interest;
                this.max_value = this.loanTypes.filter(a => a.loan_type_id == id)[0].max_value;
                this.loan_type = id;
            },
            onReset() {
                this.selectedEmployee = {
                    basic_amt: "",
                    bill_code: "",
                    biller_code: null,
                    department_name: "",
                    designation: "",
                    designation_id: "",
                    division_name: "",
                    dpt_department_id: "",
                    dpt_division_id: "",
                    dpt_section: null,
                    emp_code: "",
                    emp_grade_id: "",
                    emp_id: null,
                    emp_name: "",
                    emp_name_bng: null,
                    gpf_id: "",
                    grade_range: "",
                    grade_step_id: "",
                    join_month: "",
                    join_year: "",
                    location_id: "",
                    location_name: "",
                    location_type_id: "",
                    location_type_name: "",
                    nps_year: "",
                    option_name: "",
                    rownum: "",
                    section_id: null
                };
                this.loanApplication={};
            },
            searchEmployees(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/exit-emp/${this.loan_type}/${id}`, this.loanApplication).then(res => {
                        this.empIdList = res.data;
                     })
                }
            },
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/loan-application`).then(res => {
                    this.loanTypes = res.data.loanTypes;
                    this.listItems = res.data.pfLoans;
                    this.totalItems = res.data.pfLoans.length;
                    this.relationList = res.data.relations;
                    if(this.$route.query.application_id > 0){
                        this.listItems = this.listItems.filter(a=>a.application_id == this.$route.query.application_id)
                        this.totalItems = this.listItems.length;
                    }
                });
            },
        }
    }
</script>

<style>

</style>
