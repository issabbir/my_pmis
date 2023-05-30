<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card  v-if="loanApplication.application_id!=null">
                <b-card-header header-bg-variant="dark" header-text-variant="white">Approval for {{this.heading}}</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" v-if="show" @reset.prevent="onReset">
                        <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}"></b-form-input>
                        <b-row>
                            <b-col md="4">
                                <b-form-group label="Loan Type" label-for="loan_type" class="required">
                                      <b-form-input id="emp_name" v-model="loanApplication.loan_name" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Employee Code" label-for="emp_code" class="required">
                                    <b-form-input id="emp_name" v-model="loanApplication.emp_code" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Employee Name" label-for="emp_name">
                                    <b-form-input id="emp_name" v-model="loanApplication.emp_name" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Designation" label-for="designation">
                                    <b-form-input id="designation" v-model="loanApplication.designation" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Department" label-for="department">
                                    <b-form-input id="department" v-model="loanApplication.department_name" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Section" label-for="Section">
                                    <b-form-input id="Section" v-model="loanApplication.dpt_section" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Applied Amount(TK)" label-for="application_amt" class="required">
                                    <b-form-input
                                         @input="handleChange(loanApplication.application_amt)"
                                         type="number"
                                        v-model="loanApplication.application_amt"
                                        number
                                        id="application_amt"
                                        class="text-right"
                                        readonly
                                        required >
                                    </b-form-input>
                                 </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Applied Installment" label-for="application_installment" class="required">
                                    <b-form-input v-model="loanApplication.installment_no"   class="text-right" id="interest" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Interest Rate" label-for="interest">
                                    <b-form-input v-model="loanApplication.rate_of_interest" number class="text-right" id="interest" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Reason" label-for="Reason">
                                    <b-form-textarea v-model="loanApplication.reason" id="Reason" readonly></b-form-textarea>
                                </b-form-group>
                            </b-col>
                            <b-col md="8">
                                <b-form-group label="Description" label-for="Description" class="required">
                                    <b-form-textarea v-model="loanApplication.description" id="Description" readonly></b-form-textarea>
                                </b-form-group>
                            </b-col>
                            <b-col md="12" v-if="application_page == 'LG'">
                                <fieldset class="border mb-1">
                                    <legend class="w-auto" style="font-weight: bold;font-size: 17px;padding: 5px">Loan Guarantor</legend>
                                    <b-row class="ml-1 mr-1">
                                        <b-col md="4" >
                                            <b-form-group  label="Loan Disbustment Amount" label-for="comment_accounts">
                                                <b-form-input v-model="loanApplication.rate_of_interest" number class="text-right" id="interest" readonly></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </fieldset>
                            </b-col>
                            <b-col md="12" v-if="application_page == 'LD'">
                                <fieldset class="border mb-1">
                                    <legend class="w-auto" style="font-weight: bold;font-size: 17px;padding: 5px">Loan Disbursement</legend>
                                    <b-row class="ml-1 mr-1">
                                        <b-col md="4" >
                                            <b-form-group  label="Disbursement Amount" label-for="disburse_amt">
                                                <b-form-input v-model="loanApplication.application_amt" number class="text-right" id="disburse_amt" readonly></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4" >
                                            <b-form-group  label="Disbursement Install Number" label-for="disburse_installment_no">
                                                <b-form-input v-model="loanApplication.disburse_installment_no" number class="text-right" id="disburse_installment_no" readonly></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4" >
                                            <b-form-group  label="Disbursement Rate of Interest" label-for="disburse_rate_of_interest">
                                                <b-form-input v-model="loanApplication.disburse_rate_of_interest" number class="text-right" id="disburse_rate_of_interest" readonly></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4" >
                                            <b-form-group  label="Number of Disbursement" label-for="no_disbursed">
                                                <b-form-input v-model="loanApplication.no_disbursed" class="text-right" id="no_disbursed" readonly></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4" >
                                            <b-form-group  label="Disbursement Description" label-for="disburse_description">
                                                <b-form-textarea v-model="loanApplication.disburse_description" id="disburse_description" readonly></b-form-textarea>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </fieldset>
                            </b-col>
                            <b-col md="12" v-if="application_page == 'LP'">
                                <fieldset class="border mb-1">
                                    <legend class="w-auto" style="font-weight: bold;font-size: 17px;padding: 5px">Loan Payment</legend>
                                    <b-row class="ml-1 mr-1">
                                        <b-col md="4" >
                                            <b-form-group  label="Payment Amount" label-for="payment_amt">
                                                <b-form-input v-model="loanApplication.payment_amt" number class="text-right" id="payment_amt" readonly></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4" >
                                            <b-form-group  label="Payment Install Number" label-for="payment_installment_no">
                                                <b-form-input v-model="loanApplication.payment_installment_no" number class="text-right" id="payment_installment_no" readonly></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4" >
                                            <b-form-group  label="Payment Rate of Interest" label-for="payment_rate_of_interest">
                                                <b-form-input v-model="loanApplication.payment_rate_of_interest" number class="text-right" id="payment_rate_of_interest" readonly></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4" >
                                            <b-form-group  label="Payment Description" label-for="disburse_description">
                                                <b-form-textarea v-model="loanApplication.payment_description" id="payment_description" readonly></b-form-textarea>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </fieldset>
                            </b-col>
                            <b-col md="12" v-if="application_page == 'PI'">
                                <fieldset class="border mb-1">
                                    <legend class="w-auto" style="font-weight: bold;font-size: 17px;padding: 5px">Pay Instruction</legend>
                                    <b-row class="ml-1 mr-1">
                                            <b-col md="4" >
                                                <b-form-group  label="Instruction Date" label-for="instr_date">
                                                    <b-form-input v-model="loanApplication.instr_date" number class="text-right" id="interest" readonly></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="4" >
                                                <b-form-group  label="Instruction Interest Amount" label-for="disburse_amt">
                                                    <b-form-input v-model="loanApplication.instr_interest_amt" number class="text-right" id="interest" readonly></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                            <b-col md="4" >
                                                <b-form-group  label="Instruction Principal Amount" label-for="instr_priencipal_amt">
                                                    <b-form-input v-model="loanApplication.instr_priencipal_amt" number class="text-right" id="interest" readonly></b-form-input>
                                                </b-form-group>
                                            </b-col>
                                    </b-row>
                                </fieldset>
                            </b-col>
                            <b-col md="12" v-if="loanApplication.is_immediate_declained=='Y'">
                                <b-card
                                    border-variant="warning"
                                    header-text-variant="white"
                                    header-tag="header"
                                    header="Application Decline"
                                    header-bg-variant="warning"
                                    align="left">
                                    <b-card-text>Declined By: {{loanApplication.declined_by}} </b-card-text>
                                    <b-card-text>Declined Date: {{loanApplication.declined_date}}</b-card-text>
                                    <b-card-text>Declined Reason: {{loanApplication.declined_reason}}</b-card-text>
                                </b-card>
                            </b-col>
                            <b-col md="12">
                                <b-card
                                    border-variant="success"
                                    header-text-variant="white"
                                    header-tag="header"
                                    header="Authorization"
                                    header-bg-variant="success"
                                    align="left">
                                    <b-row class="ml-1 mr-1">
                                        <b-col md="8" >
                                            <b-form-group  label="Comments" label-for="comment_accounts" class="required">
                                                <b-form-textarea required v-model="loanApplication.comment_status" id="comment_accounts"></b-form-textarea>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group
                                                label="Authorization"
                                                label-for="accounts_approval"
                                            >
                                                <b-form-radio-group
                                                    v-model="loanApplication.approval_status"
                                                    :options="approval"
                                                    class="mb-3"
                                                    id="accounts_approval"
                                                ></b-form-radio-group>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </b-card>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="mt-2 d-flex justify-content-end">
                                <b-button-group>
                                    <b-button md="6" size="md" variant="primary" type="submit">{{submitBtn}}</b-button>&nbsp;
                                    <b-button md="6" size="md" variant="secondary" type="reset">Reset</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Loan List</b-card-header>
                <b-card-body class="border">
                        <b-row>
                            <b-col md="4">
                                <b-form-group label="Application Page" label-for="application_page_id" class="required">
                                    <b-form-select id="application_page_id" v-model="applicationSearch.application_page_id"
                                                   text-field="show_value" value-field="pass_value"
                                                   @change="searchApproval"
                                                   :options="applicationPageList" required></b-form-select>
                                </b-form-group>
                            </b-col>
                        </b-row>

                    <Datatable  v-bind:fields="columns" :totalList="totalItems" :small="small" perPage="10" v-bind:items="listItems">
                        <template v-slot:action2="{ rows }">
                            <b-link @click="selectLoan(rows.item)" class="ot-btn btn btn-primary">
                                <i  class="bx bx-edit cursor-pointer"></i>
                            </b-link>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import Datatable from '../../layouts/common/datatable_store';
    import ApiRepository from "../../Repository/ApiRepository";
    import vcss from 'vue-select/dist/vue-select.css';
    import DatePicker from "vue2-datepicker";
    import moment from "moment";



    export default {
        components: { Datatable, Vue, vSelect, vcss, DatePicker},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Approval Form"});
            this.loadData();
        },
        data() {
            return {
                isHidden: false,
                heading: '',
                loanApplication:{
                    rate_of_interest:null,
                    instr_date:null,
                    no_disbursed:null,
                    disburse_amt:null,
                    disburse_installment_no:null,
                    disburse_rate_of_interest:null,
                    disburse_description:null,
                    payment_amt:null,
                    payment_installment_no:null,
                    payment_rate_of_interest:null,
                    payment_description:null,
                    loan_type_id:null,
                    emp_name:null,
                    designation:null,
                    department_name:null,
                    dpt_section:null,
                    gpf_id:null,
                    bill_code:null,
                    reason:null,
                    application_amt:null,
                    installment_no:null,
                    description:null,
                    approval_status:null,
                    comment_status:null
                },
                applicationSearch:{
                    application_page_id:null
                },
                application_page:null,
                max_value:null,
                submitBtn:'Apply',
                amountReadonly:true,
                ex_hidden:false,
                acc_hidden:false,
                formattedData:null,
                visible: true,
                temp: null,
                small:true,
                empIdList: [],
                listItems:[],
                loanTypes:[],
                applicationPageList:[],
                totalItems:0,
                selectedEmployee: {},
                updateIndex: -1,
                approval:[{text:'Accept', value:'Y'},{text:'Decline', value: 'N'}],
                appInstlmntList: [{text: '12', value: 12}, {text: '24', value: 24},{text: '36', value: 36}, {text: '48', value: 48}],
                show: true,
                columns: [
                    {label: 'SL', key: 'index', sortable:true},
                    {label: 'Employee Code', key: 'emp_code', sortable:true},
                    {label: 'Employee', key: 'emp_name', sortable:true},
                    {label: 'Designation', key:'designation', sortable:true},
                    {label: 'Loan Type', key:'loan_name', sortable:true},
                    {label: 'Loan No.', key: 'loan_no'},
                    {label: 'Amount', key: 'application_amt', sortable: true, class:'text-right',
                        formatter: value => {
                            if(value) {
                                let val = (value/1).toFixed(2).replace(',', ',')
                                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                            }
                        },
                    },
                    {label: 'Action', key: 'action2'}
                ]}
        },
        computed: {
            visibleFields() {
                return this.columns.filter(field => field.visible)
            }
        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.loanApplication.emp_code = val.emp_code;
                    this.loanApplication.emp_name=  val.emp_name;
                    this.loanApplication.emp_id=  val.emp_id;
                    this.loanApplication.bill_code = val.bill_code;
                    if (val.section_name)
                        this.loanApplication.dpt_section = val.dpt_section;
                    if ( val.department_name)
                        this.loanApplication.department_name=  val.department_name;
                    if(val.designation)
                        this.loanApplication.designation=  val.designation;

                    this.loanApplication.gpf_id = val.gpf_id;

                    if(this.loanApplication.loan_type_id){
                        this.amountReadonly=false;
                    }
                }

            }

        },
        methods: {
            onSubmit() {
                let data = {};
                    data = this.loanApplication;
                    data.application_page_id = this.applicationSearch.application_page_id;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/loan/loan-approved`,data).then(res => {
                    if (res.data.o_status_code == 1){
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.onReset();
                        this.searchApproval(res.data.p_approval_for);
                    }
                    else{
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            onReset() {
                this.selectedEmployee={emp_id:null};
                this.loanApplication={};
                this.loanApplication.reference_id=null;
                this.loanApplication.approval_id=null;
                this.loanApplication.installment_no=null;
                this.loanApplication.application_id=null;
                //    this.listItems=null;
                this.empIdList=[];
            },
            editRow(i, code) {

            },
            deleteRow(i, code) {

            },
            searchApproval(id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/loan-approvals-change-data/${id}`, this.loanApplication).then(res => {
                        this.listItems = res.data;
                        this.totalItems = res.data.length;
                        this.heading = this.applicationPageList.filter(a=>a.pass_value==id)[0].show_value
                        this.loanApplication = {}
                        if(res.data.length > 0 && res.data.filter(a => a.transactions_type != null).length >0) {
                            this.columns.splice(5, 0, {label: 'Transaction Type', key: 'transactions_type_name'})
                        }
                        else if((res.data.length < 1 || res.data.filter(a => a.transactions_type != null).length < 1) && this.columns.filter(a=>a.key == 'transactions_type_name').length>0) {
                            this.columns.splice(5,1)
                        }
                        if(res.data.length > 0 && res.data.filter(b => b.attachment_doc_no != null).length >0) {
                            this.columns.splice(7, 0, {label: 'Voucher No', key: 'attachment_doc_no'})
                        }
                        else if((res.data.length < 1 || res.data.filter(b => b.attachment_doc_no != null).length < 1) && this.columns.filter(a=>a.key == 'attachment_doc_no').length>0) {
                            this.columns.splice(7,1)
                        }
                        if(res.data.length > 0 && res.data.filter(c => c.doc_date != null).length >0) {
                            this.columns.splice(8, 0, {label: 'Check Issue Date', key: 'doc_date'})
                        }
                        else if((res.data.length < 1 || res.data.filter(c => c.doc_date != null).length < 1) && this.columns.filter(a=>a.key == 'doc_date').length>0) {
                            this.columns.splice(8,1)
                        }
                    })
            },
            selectLoan(item) {
                this.submitBtn='Submit';
                this.application_page = this.applicationSearch.application_page_id;
                this.selectedEmployee=item;
                this.loanApplication = item;
                this.loanApplication.reference_id=item.reference_id;
                this.loanApplication.approval_id=item.approval_id;
                this.loanApplication.gpf_id = item.gpf_id;
                this.loanApplication.application_id=item.application_id;
                if (this.loanApplication.application_id ){
                    this.ex_hidden=true;
                }
                else{
                    this.ex_hidden=false;
                }

                if(this.loanApplication.application_id ){
                    this.acc_hidden=true;
                }
                else{
                    this.acc_hidden=false;
                }
                this.onBlurNumber();

                window.scrollTo(0,0);
            },
            loadData() {
                //this.loanApplication.loan_type_id = 1;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/loan-approvals`).then(res => {
                    this.applicationPageList = res.data.loan_application_type;
                    this.loanTypes = res.data.loanTypes;
                    this.totalItems = res.data.length;
                });
            },
            onBlurNumber() {
                this.visible = false;
                this.temp = this.loanApplication.application_amt;
                this.formattedData = this.thousandSeprator(this.loanApplication.application_amt);
            },
            onFocusText() {
                this.visible = true;
                this.formattedData = this.temp;
            },
            thousandSeprator(amount) {
                if (amount !== '' || amount !== undefined || amount !== 0 || amount !== '0' || amount !== null) {
                    return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                } else {
                    return amount;
                }
            },
            loanTypeChange(id){
                this.loanApplication.rate_of_interest =this.loanTypes.filter(a=>a.loan_type_id==id)[0].rate_of_interest;
                this.max_value=this.loanTypes.filter(a=>a.loan_type_id==id)[0].max_value;

            },
            handleChange(input) {
                if (this.loanApplication.loan_type_id==2 && input > this.max_value)
                {
                    this.$bvModal.show('bv-modal-example');
                    this.loanApplication.application_amt=this.max_value;
                }
            },
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
            hide(){
                return true
            }
        }
    }
</script>

<style>
    .required label:after {
        content:"*";
        color: red;
    }
</style>
