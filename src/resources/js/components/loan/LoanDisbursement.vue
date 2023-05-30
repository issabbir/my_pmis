<template>
    <div class="content-wrapper disbustment">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Disbursement</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>
<!--                            <b-col md="3">-->
<!--                                <b-form-group-->
<!--                                    label-for="loan_type"-->
<!--                                    label="Loan Type"-->
<!--                                    class="">-->
<!--                                    <b-form-select-->
<!--                                        v-model="formData.loan_type_id"-->
<!--                                        id="loan_type" text-field="loan_name"-->
<!--                                        value-field="loan_type_id"-->
<!--                                        @change="onChangeLoanType"-->
<!--                                        :options="loanTypes"-->
<!--                                         >-->
<!--                                    </b-form-select>-->
<!--                                </b-form-group>-->
<!--                            </b-col>-->
                            <b-col md="4">
                                <b-form-group label="Loan Type" label-for="loan_type" class="required">
                                    <b-form-select
                                        id="loan_type"
                                        v-model="formData.loan_type_id"
                                        text-field="loan_name"
                                        value-field="loan_type_id"
                                        :options="loanTypes"
                                        required
                                        @change="loanTypeChange(formData.loan_type_id)">
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
<!--                            <b-col md="3">-->
<!--                                <b-form-group label="Loan No" label-for="loan_no" class="required">-->
<!--                                    <v-select-->
<!--                                        label="loan_no"-->
<!--                                        value="application_id"-->
<!--                                        v-model="selectedLoan"-->
<!--                                        :options="loanNumberOptions"-->
<!--                                        @search="onChangeLoanNo(formData.loan_no)"-->
<!--                                        id="loan_no"-->
<!--                                    >-->
<!--                                        <template #selected-option="{ loan_no }">-->
<!--                                            <div style="display: flex; align-items: baseline;">-->
<!--                                                {{ loan_no }}-->
<!--                                            </div>-->
<!--                                        </template>-->
<!--                                    </v-select>-->
<!--                                </b-form-group>-->
<!--                            </b-col>-->
                            <b-col md="4">
                                <b-form-group label="Loan Number" label-for="loan_no">
                                    <b-form-input id="loan_no" v-model="formData.loan_no" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Employee Name" label-for="emp_name">
                                    <b-form-input id="emp_name" v-model="formData.emp_name" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Designation" label-for="designation">
                                    <b-form-input id="designation" v-model="formData.designation" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Department" label-for="department">
                                    <b-form-input id="department" v-model="formData.department_name" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Section" label-for="Section">
                                    <b-form-input id="Section" v-model="formData.dpt_section" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Application Amount" label-for="application_amt">
                                    <b-form-input
                                        v-model="formData.application_amt"
                                        id="application_amt"
                                        class="text-right"
                                        readonly
                                        required >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Disbursement Amount" label-for="disbursement_amount" class="requiredField">
                                    <b-form-input
                                        v-model="formData.transaction_amt"
                                        id="disbursement_amount"
                                        class="text-right"
                                         readonly  >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Previous Disbursement Amount" label-for="previous_disbursement_amount">
                                    <b-form-input
                                        v-model="formData.previous_disbursement_amount"
                                        id="previous_disbursement_amount"
                                        class="text-right"
                                        readonly >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group class="requiredField" label="Fund No" label-for="attachment_doc_no">
                                    <b-form-input
                                        v-model="formData.attachment_doc_no"
                                        id="attachment_doc_no"
                                        class="text-right"
                                        required
                                         >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group label="Cheque issue Date" label-for="doc_date" class="requiredField">
                                    <date-picker
                                        width="100%"
                                        input-class="form-control"
                                        v-model="formData.doc_date"
                                        :value-type="valueType"
                                        type="date"
                                        lang="en"
                                        :editable="false"
                                        format="DD-MM-YYYY"
                                        required>
                                    </date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Attachment" label-for="attachment">
                                    <b-form-file @change="encodeFile(formData,$event)"
                                                 v-bind:id="'attachment'.index"
                                                 name="attachment"
                                                 placeholder="Attachment"
                                    ></b-form-file>
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group label="Description" label-for="description">
                                    <b-form-textarea
                                        id="description"
                                        v-model="formData.description"
                                        placeholder=""
                                        rows="3"
                                        max-rows="6"
                                     ></b-form-textarea>
                                </b-form-group>
                            </b-col>


                        </b-row>
                        <b-row>
                            <b-col class="mt-2 d-flex justify-content-end">
                                <b-button-group>
                                    <b-button md="6" size="md" variant="primary" type="submit">Disburse</b-button>&nbsp;
                                    <b-button md="6" size="md" variant="secondary" type="reset">Reset</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Disbursement List</b-card-header>
                <b-card-body class="border">
                    <Datatable  v-bind:fields="tableData.fields" :totalList="totalItems"  perPage="10" v-bind:items="tableData.items"  :primaryKeyColumnName="'application_id'">
<!--                        <template v-slot:action2="{ rows }">-->
<!--                            <b-link @click="selectLoan(rows.item)" class="ot-btn btn btn-primary">-->
<!--                                <i  class="bx bx-edit cursor-pointer"></i>-->
<!--                            </b-link>-->
<!--                        </template>-->
                    </Datatable>
                </b-card-body>
            </b-card>
            <b-modal id="bv-modal-example" hide-footer>
                <div class="d-block text-center">
                    <h3>HB Loan amount cannot exceed 120,000!</h3>
                </div>
            </b-modal>
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan Disbursement"});
            this.loadData();
            // ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/search-loan-disbursement/null/null`).then(res => {
            //     this.loanNumberOptions = res.data;
            // })
        },
        data() {
            return {
                valueType: this.dateFormatter(),
                empIdList: [],
                loan_type: [],
                formData:{
                    attachment_doc_no: '',
                    doc_date: '',
                    cheque_status: '',
                    transaction_amt:0,
                    attachment:null,
                    attachment_file_name:null,
                    loan_type_id:null
                },
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
                    section_id: null
                },
                selectedLoan:{},
                loanTypes:[],
                loans:[],
                loanList:[],
                loanNumberOptions:[],
                visible: true,
                visibleAmt: true,
                formattedData:null,
                formattedDataAmt:null,
                temp: null,
                tempAmt: null,
                totalItems: null,
                tableData: {
                    fields: [
                        {label: 'Loan No.', key: 'loan_no'},
                        {label: 'Employee Name', key: 'emp_name'},
                        {label: 'Employee Code', key: 'emp_code'},
                        {label: 'Transactions No', key: 'transactions_no'},
                        {label: 'Disbursement Amount', key: 'disbursement_amount', sortable:true},
                        {label: 'Transaction Amt', key:'transaction_amt', sortable:true},
                        {key:'transaction_date', formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable:true},
                        {label: 'Fund No', key:'doc_no', sortable:true},
                        {label: 'Cheque Date', key:'doc_date',
                            formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            },
                            sortable:true},
                        {label: 'Status', key: 'approval_status', sortable:false},
                        // {label: 'Action', key: 'action2'},
                    ],
                    items: []
                }
            }
        },

        watch: {
            // selectedLoan: function (val, oldVal) {
            //     if (val !== null) {
            //         this.formData.loan_no = val.loan_no;
            //         this.formData.emp_name=  val.employee_name;
            //         this.formData.application_id=  val.application_id;
            //         this.formData.application_amt = val.application_amt;
            //         this.formData.transaction_amt = val.disbursment_amount;
            //         this.formData.previous_disbursement_amount = val.previous_disbursement_amount;
            //         if (val.section)
            //             this.formData.dpt_section = val.section;
            //         if ( val.department)
            //             this.formData.department_name=  val.department;
            //         if(val.designation)
            //             this.formData.designation=  val.designation;
            //     }
            //
            // },
            selectedEmployee: function (val, oldVal) {
                if (val !== null && val.emp_id != null) {
                    // this.formData = {
                    //     emp_name: val.emp_name,
                    //     designation: val.designation ? val.designation : null,
                    //     department_name: val.department_name ? val.department_name: null,
                    //     dpt_section: val.section_name ? val.dpt_section : null,
                    //     gpf_id: val.gpf_id,
                    //     bill_code: val.bill_code,
                    //     emp_code: val.emp_code,
                    //     emp_id: val.emp_id,
                    // }
                    this.formData.loan_no = val.loan_no;
                    this.formData.emp_name=  val.employee_name;
                    this.formData.application_id=  val.application_id;
                    this.formData.application_amt = val.application_amt;
                   this.formData.transaction_amt = val.disbursment_amount;
                   this.formData.previous_disbursement_amount = val.previous_disbursement_amount;
                    if (val.section)
                        this.formData.dpt_section = val.section;
                    if ( val.department)
                        this.formData.department_name=  val.department;
                    if(val.designation)
                        this.formData.designation=  val.designation;
                 }
                }

        },
        methods: {
            dateFormatter: function() {
                return {
                    value2date: value => {
                        return value ? moment(new Date(value), "YYYY-MM-DD").toDate() : null;
                    },
                    date2value: date => {
                        return date ? moment(date).format("YYYY-MM-DD") : null;
                    }
                }
            },
            encodeFile(fileParam,e) {
                let file_limit = 5000000;
                let self = this;
                if(e.target.files[0].size<=file_limit){
                    if (e.target.files[0].type=='application/msword'||e.target.files[0].type=='application/vnd.openxmlformats-officedocument.wordprocessingml.document'||e.target.files[0].type=='application/pdf'||e.target.files[0].type=='image/jpeg'||e.target.files[0].type=='image/jpg'
                        || e.target.files[0].type=='image/png' || e.target.files[0].type=='application/vnd.ms-excel' || e.target.files[0].type=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || e.target.files[0].type=='text/plain'){
                        let file = e.target.files[0];
                        let reader = new FileReader();
                        let type = file;
                        let name = file.name;

                        reader.readAsDataURL(file);

                        reader.onload = (file)=> {
                            self.formData.attachment = reader.result;
                            self.formData.attachment_file_name = name;
                        }
                    }
                    else {
                        this.$notify({group: 'pmis', text: "File type should be in pdf,excel,doc, jpg or jpeg", type: 'error'});
                        return;
                    }

                }else{
                    this.$notify({group: 'pmis', text: "File size should not exceed 5MB", type: 'error'});
                    return;
                }

            },
            loanTypeChange(id) {
                this.loan_type = id;
                // this.loanApplication.rate_of_interest = this.loanTypes.filter(a => a.loan_type_id == id)[0].rate_of_interest;
                // this.max_value = this.loanTypes.filter(a => a.loan_type_id == id)[0].max_value;

            },
            searchEmployees(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/search-loan-disbursement/${this.loan_type}/${id}`, this.loanApplication).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            onSubmit() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/loan/store-loan-disbursement`,this.formData).then(res => {
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
                this.formData={};
                this.selectedLoan=null;
                this.formattedData=null;
            },
            selectLoan(item) {
                this.formData = item;
               // this.formData.transaction_amt=item.application_amt;
                window.scrollTo(0,0);
            },
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/disbursements`).then(res => {
                    this.tableData.items=res.data;
                    this.totalItems=res.data.length;
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loans/pf`).then(res => {
                    this.loanTypes=res.data.loanTypes;
                    this.loanList=res.data.pfLoans;
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/loan-search`).then(res => {
                    this.loans=res.data;

                });
            },
            onChangeLoanType(id){
                if(id){
                    let search = null;
                        ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/search-loan-disbursement/${id}/${search}`).then(res => {
                            this.loanNumberOptions = res.data;
                        })
                 }
            },
            onChangeLoanNo(loan_no){
                let loan_type_id = this.formData.loan_type_id;
                if (loan_no) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/search-loan-disbursement/${loan_type_id}/${loan_no}`).then(res => {
                        this.loanNumberOptions = res.data;
                    })
                }
                // ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loans/pf`).then(res => {
                //     this.formData=res.data.pfLoans.filter(a=>a.loan_no == loan_no)[0];
                //     this.formData.transaction_amt=((res.data.pfLoans.filter(a=>a.loan_no == loan_no)[0].application_amt) - (res.data.pfLoans.filter(a=>a.loan_no == loan_no)[0].disbursement_amount));
                // });
            },
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
        }
    }
</script>

<style>
    .required label:after {
        content:"*";
        color: red;
    }
    .disbustment th:nth-child(5), .disbustment td:nth-child(5){
        text-align: right;
    }
    .disbustment th:nth-child(6), .disbustment td:nth-child(6){
        text-align: right;
    }
</style>

