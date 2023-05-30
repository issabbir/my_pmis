<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Apply for GPF Loan</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="eligible_for_loan">
                        <b-row>
                            <b-col md="3">
                                <b-form-group
                                    label="GPF No"
                                    label-for="gpf_id"
                                >
                                    <b-form-input id="gpf_id" v-model="loanApplication.gpf_id" readonly class="text-right"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Bill No"
                                    label-for="bill_code"
                                >
                                    <b-form-input id="bill_code" v-model="loanApplication.bill_code" readonly class="text-right"></b-form-input>
                                </b-form-group>

                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="PF Total Amount"
                                    label-for="balance"
                                >
                                    <b-form-input id="balance" v-model="loanApplication.balance" readonly class="text-right"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Maximum Amount"
                                    label-for="maximum_amount"
                                >
                                    <b-form-input id="maximum_amount" v-model="loanApplication.maximum_amount_formatted" readonly class="text-right"></b-form-input>
                                </b-form-group>

                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Previous Loan Amount"
                                    label-for="previous_loan_amount"
                                >
                                    <b-form-input id="previous_loan_amount" v-model="loanApplication.previous_loan_amount" readonly class="text-right"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Applied Amount(TK)"
                                    label-for="application_amt"
                                    class="requiredField"
                                >
                                    <b-form-input id="application_amt" :readonly="loanApplication.application_id?true:false" v-model="loanApplication.application_amt" number class="text-right"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Applied Installment"
                                    label-for="installment_no"
                                    class="requiredField"
                                >
                                    <b-form-select id="installment_no" v-model="loanApplication.installment_no" :options="appInstlmntList" ></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Interest Rate"
                                    label-for="rate_of_interest"
                                    class="requiredField"
                                >
                                    <b-form-input id="rate_of_interest" readonly v-model="loanApplication.rate_of_interest" number class="text-right"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Description"
                                    label-for="description"
                                >
                                    <b-form-textarea id="description" :disabled="loanApplication.application_id?true:false" v-model="loanApplication.description"></b-form-textarea>
                                </b-form-group>
                            </b-col>
                            <b-col md="6">
                                <b-form-group
                                    label="Reason"
                                    label-for="reason"
                                >
                                    <b-form-textarea id="reason" :disabled="loanApplication.application_id?true:false" v-model="loanApplication.reason" ></b-form-textarea>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col class="mt-2 d-flex justify-content-end">
                                <b-button  md="6" size="md" variant="primary" type="submit">Apply</b-button>&nbsp;
                                <b-button md="6" size="md" variant="secondary" type="reset">Reset</b-button>

                            </b-col>
                        </b-row>
                        <!--</fieldset>-->
                    </b-form>

                    <p v-else class="text-danger text-center">You are not allowed to apply for GPF Loan</p>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">GPF Loan Lists</b-card-header>
                <b-card-body class="border">
                    <Datatable  v-bind:fields="columns" :totalList="totalItems" perPage="10" v-bind:items="listItems"  :primaryKeyColumnName="'application_id'"></Datatable>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import Datatable from '../../../../layouts/common/datatable';
    import ApiRepository from "../../../../Repository/ApiRepository";
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from "moment";

    export default {
        components: { Datatable, Vue, vSelect, vcss},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Provident Fund"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan Application"});

            this.loadData();
            this.searchEmployees(this.$store.getters.user.user_name)
        },
        data() {
            return {
                eligible_for_loan: false,
                loanApplication:{
                    rate_of_interest:5,
                    approval_status_1:0,
                    maximum_amount: '',
                    maximum_amount_formatted: '',
                    previous_loan_amount:'',
                    application_id: '',
                    gpf_id: ''
                },
                workflow:{
                    workflow_step_id:'',
                    note:''
                },
                approval:{},
                listItems:[],
                totalItems:0,
                selectedEmployee: {},
                appInstlmntList: [{text: '12', value: 12}, {text: '24', value: 24},{text: '36', value: 36}, {text: '48', value: 48}],
                columns: [
                    {label: 'SL', key: 'index', sortable:true, class: 'ten'},
                    {label: 'Loan No.', key: 'loan_no',  class: 'twenty'},
                    {label: 'GPF ID', key: 'gpf_id',  class: 'twenty'},
                    {label: 'App. Date', key: 'application_date', sortable:true,  class: 'fifteen'},
                    {label: 'Amount', key: 'application_amt_formatted', sortable: true, class:'text-right fifteen'},
                    {label: 'Status', key: 'approval_status', sortable:false, class: 'ten'},
                    {label: 'Loan Status', key: 'loan_status', sortable: true, class:'ten'}
                ]
            }
        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.loanApplication.emp_code = val.emp_code
                    this.loanApplication.emp_name=  val.emp_name
                    this.loanApplication.emp_id=  val.emp_id
                    this.loanApplication.bill_code = val.bill_code
                    this.loanApplication.balance = val.balance
                    this.loanApplication.previous_loan_amount=val.previous_loan_amount
                    if (val.section_name)
                        this.loanApplication.dpt_section = val.section_name
                    if ( val.department_name)
                        this.loanApplication.department_name=  val.department_name
                    if(val.designation)
                        this.loanApplication.designation=  val.designation
                    this.loanApplication.maximum_amount=  val.maximum_amount
                    this.loanApplication.maximum_amount_formatted=  val.maximum_amount_formatted
                    this.loanApplication.gpf_id = val.gpf_id
                }
            }
        },
        methods: {
            onSubmit() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/loans/pf`,this.loanApplication).then(res => {
                    if (res.data.o_status_code == 1){
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.onReset();
                        this.loadData();
                    }
                    else{
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            onReset() {
                this.selectedEmployee=null;
                this.loanApplication = {
                    rate_of_interest:5,
                    approval_status_1:0,
                    maximum_amount: '',
                    previous_loan_amount:'',
                    application_id: '',
                    gpf_id: ''
                }
                this.loanApplication.installment_no=null;
            },
            editRow(i, code) {

            },
            searchEmployees(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/providentFund/pf-employee-self/${id}/Y`, this.loanApplication).then(res => {
                        if(res.data.length > 0){
                            this.eligible_for_loan = true
                            this.selectedEmployee = res.data[0]
                        } else {
                            this.eligible_for_loan = false
                        }

                    })
                }
            },
            loadData() {
                this.loanApplication.loan_type_id = 1;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loans/pf-self`).then(res => {
                    this.listItems = res.data.pfLoans.filter(i=>i.loan_type_id==1);
                    this.totalItems = this.listItems.length
                });
            }
        }
    }
</script>

<style>
    .required:after {
        content:"*";
        color: red;
    }

    .ten {
        width: 10%;
    }
    .seven {
        width: 7%;
    }
    .fifteen {
        width: 15%;
    }
    .twenty {
        width: 20%;
    }
    .eight {
        width: 8%;
    }
</style>
