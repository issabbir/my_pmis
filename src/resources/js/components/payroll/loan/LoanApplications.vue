<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Apply for Loan</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" v-if="show" @reset.prevent="onReset">
                        <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}"></b-form-input>
                        <b-row>
                            <b-col md="4">
                                <b-form-group label="Loan Type" label-for="loan_type" class="required">
                                    <b-form-select id="loan_type" v-model="loanApplication.loan_type_id" text-field="loan_name" value-field="loan_type_id" :options="loanTypes" required></b-form-select>
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
                                        required
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
                                    <b-form-input v-model="loanApplication.application_amt" number id="application_amt" class="text-right" required></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Applied Installment" label-for="application_installment" class="required">
                                    <b-form-select v-model="loanApplication.installment_no" id="application_installment" :options="appInstlmntList" required></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Interest Rate" label-for="interest" class="required">
                                    <b-form-input v-model="loanApplication.rate_of_interest" number class="text-right" id="interest" required></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Reason" label-for="Reason" class="required">
                                    <b-form-textarea v-model="loanApplication.reason" id="Reason" required></b-form-textarea>
                                </b-form-group>
                            </b-col>
                            <b-col md="8">
                                <b-form-group label="Description" label-for="Description" class="required">
                                    <b-form-textarea v-model="loanApplication.description" id="Description" required></b-form-textarea>
                                </b-form-group>
                            </b-col>
                            <b-col md="4" v-if="loanApplication.application_id">
                                <b-form-group
                                    id="input-group-4"
                                    label="Loan status"
                                    label-for="input-4"
                                >
                                    <b-form-radio-group
                                        v-model="loanApplication.approval_yn"
                                        :options="[
                                                    { item: 'Y', name: 'Approved' },
                                                    { item: 'N', name: 'Not Approved' }]"
                                        class="mb-3"
                                        value-field="item"
                                        text-field="name"
                                    ></b-form-radio-group>
                                </b-form-group>
                            </b-col>
                            <b-col md="8">
                                <b-form-group v-if="loanApplication.application_id" label="Comments From Executive" label-for="comment_executive" >
                                    <b-form-textarea v-model="loanApplication.comment_executive" id="comment_executive"></b-form-textarea>
                                </b-form-group>
                            </b-col>
                            <b-col md="4" v-if="loanApplication.application_id && loanApplication.executive_approval==0">
                                <b-form-group
                                    label="Executive Approval"
                                    label-for="executive_approval"
                                >
                                    <b-form-radio-group
                                        v-model="loanApplication.executive_approval"
                                        :options="approval"
                                        class="mb-3"
                                        id="executive_approval"
                                    ></b-form-radio-group>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group v-if="loanApplication.application_id" label="Comments From Accounts" label-for="comment_accounts">
                                    <b-form-textarea v-model="loanApplication.comment_accounts" id="comment_accounts"></b-form-textarea>
                                </b-form-group>
                            </b-col>
                            <b-col md="4" v-if="loanApplication.application_id && loanApplication.executive_approval==1 && loanApplication.executive_approval==0">
                                <b-form-group
                                    label="Accounts Approval"
                                    label-for="accounts_approval"
                                >
                                    <b-form-radio-group
                                        v-model="loanApplication.accounts_approval"
                                        :options="approval"
                                        class="mb-3"
                                        id="accounts_approval"
                                    ></b-form-radio-group>
                                </b-form-group>
                            </b-col>
                            <b-col md="4"  v-if="loanApplication.application_id && loanApplication.executive_approval==1 && loanApplication.executive_approval==0">
                                <b-form-group label="Approval Date" label-for="approval_date">
                                    <date-picker
                                        width="100%"
                                        input-class="form-control"
                                        v-model="loanApplication.approval_date"
                                        type="date"
                                        lang="en"
                                        :editable="false"
                                        format="DD-MM-YYYY"
                                        id="approval_date">
                                    </date-picker>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col class="mt-2 d-flex justify-content-end">
                                <b-button md="6" size="md" variant="primary" type="submit">Apply</b-button>&nbsp;
                                <b-button md="6" size="md" variant="secondary" type="reset">Reset</b-button>

                            </b-col>
                        </b-row>
                        <!--</fieldset>-->
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Loan List</b-card-header>
                <b-card-body class="border">
                    <Datatable  v-bind:fields="columns" :totalList="totalItems" :small="small" perPage="10" v-bind:items="listItems"  :primaryKeyColumnName="'application_id'">
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
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    import vcss from 'vue-select/dist/vue-select.css';
    import DatePicker from "vue2-datepicker";



    export default {
        components: { Datatable, Vue, vSelect, vcss, DatePicker},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan Applications"});
            this.loadData();
        },
        data() {
            return {
                loanApplication:{
                    rate_of_interest:5,
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
                    executive_approval:null,
                    accounts_approval:null
                },
                small:true,
                empIdList: [],
                listItems:[],
                loanTypes:[],
                totalItems:0,
                selectedEmployee: {},
                updateIndex: -1,
                approval:[{text:'Approved', value:1},{text:'Not Approved', value: -1}, {text: 'Pending', value: 0}],
                appInstlmntList: [{text: '12', value: 12}, {text: '24', value: 24},{text: '36', value: 36}, {text: '48', value: 48}],
                show: true,
                columns: [
                    {label: 'SL', key: 'index', sortable:true},
                    {label: 'Employee', key: 'option_name', sortable:true},
                    {label: 'Designation', key:'designation', sortable:true},
                    {label: 'Loan Type', key:'loan_type', sortable:true},
                    {label: 'Loan No.', key: 'loan_no'},
                    {label: 'App. Date', key: 'application_date', sortable:true},
                    {label: 'Amount', key: 'application_amt_formatted', sortable: true, class:'text-right'},
                    {label: 'Status', key: 'approval_status', sortable:false},
                    {label: 'Action', key: 'action2'}
                ]}
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

                }

            }

        },
        methods: {
            onSubmit() {
                if(this.loanApplication.application_id==null){
                    this.loanApplication.executive_approval=0;
                    this.loanApplication.accounts_approval=-1;
                }
                else if(this.loanApplication.application_id && this.loanApplication.executive_approval==1){
                    this.loanApplication.accounts_approval=0;
                }
                else if(this.loanApplication.application_id && this.loanApplication.executive_approval==0){
                    this.loanApplication.accounts_approval=-1;
                }
                else if(this.loanApplication.application_id && this.loanApplication.executive_approval==-1){
                    this.loanApplication.accounts_approval=-1;
                }
                else if(this.loanApplication.application_id && this.loanApplication.accounts_approval==1){
                    this.loanApplication.executive_approval=1;
                }
                else if(this.loanApplication.application_id && this.loanApplication.accounts_approval==-1){
                    this.loanApplication.executive_approval=0;
                }
                else if(this.loanApplication.application_id && this.loanApplication.accounts_approval==0){
                    this.loanApplication.executive_approval=1;
                }
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
                this.selectedEmployee={emp_id:null};
                this.loanApplication={};
                this.loanApplication.installment_no=null;
                this.loanApplication.application_id=null;
                //    this.listItems=null;
                this.empIdList={};
            },
            editRow(i, code) {

            },
            deleteRow(i, code) {

            },
            searchEmployees(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/emp/${id}`, this.loanApplication).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            selectLoan(item) {
                this.selectedEmployee=item;
                this.loanApplication = item;
                this.loanApplication.gpf_id = item.gpf_id;
                this.loanApplication.application_id=item.application_id;
                window.scrollTo(0,0);
            },
            loadData() {
                //this.loanApplication.loan_type_id = 1;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loans/pf`).then(res => {
                    this.loanTypes=res.data.loanTypes.filter(t=>t.loan_type_id!=1);
                    this.listItems = res.data.pfLoans.filter(i=>i.loan_type_id!=1);
                    this.totalItems = res.data.length;
                });
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
