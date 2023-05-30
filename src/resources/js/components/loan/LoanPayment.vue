<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Loan Payment</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" v-if="show" @reset.prevent="onReset">
                        <b-form-input v-model="updateIndex" required id="input-update-index" type="text" :style="{'display':'none'}"></b-form-input>
                        <b-row>
                            <b-col md="3">
<!--                                v-model="loanPayment.f_year"-->
                                <b-form-group label="Financial Year" label-for="f_year" class="required">
                                    <b-form-select :options="prYears"
                                                   @change="getMonths"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Months" label-for="f_year" class="required">
                                    <b-form-select v-model="loanPayment.prMonths" :options="prMonthsAll"
                                                   @change=""></b-form-select>
<!--                                    <b-form-input id="emp_name" v-model="loanPayment.prMonths" readonly></b-form-input>-->
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Loan Type" label-for="loan_type" class="">
                                    <b-form-select id="loan_type" v-model="loanPayment.loan_type_id"
                                                   text-field="loan_name" value-field="loan_type_id"
                                                   :options="loanTypes" required
                                                   @change="loanTypeChange(loanPayment.loan_type_id)"></b-form-select>
                                </b-form-group>
                            </b-col>
<!--                            <b-col md="3">-->
<!--                                <b-form-group label="Loan No" label-for="loan_no" class="required">-->
<!--                                    <v-select-->
<!--                                        label="loan_no"-->
<!--                                        value="application_id"-->
<!--                                        v-model="selectedLoan"-->
<!--                                        :options="LoanList"-->
<!--                                        @search="searchEmployees"-->
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
                            <b-col md="3">
                                <b-form-group label="Employee Code" label-for="emp_code" class="required">
                                    <v-select
                                        label="option_name"
                                        value="emp_id"
                                        v-model="selectedLoan"
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
                            <b-col md="3">
                                <b-form-group label="Loan Number" label-for="loan_no">
                                    <b-form-input id="loan_no" v-model="loanPayment.loan_no" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Employee Name" label-for="emp_name">
                                    <b-form-input id="emp_name" v-model="loanPayment.emp_name" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Designation" label-for="designation">
                                    <b-form-input id="designation" v-model="loanPayment.designation" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Department" label-for="department">
                                    <b-form-input id="department" v-model="loanPayment.department_name" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Section" label-for="Section">
                                    <b-form-input id="Section" v-model="loanPayment.dpt_section" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Loan Amount(TK)" label-for="application_amt">
                                    <b-form-input
                                        v-if="visible === true"
                                        @input="handleChange(loanPayment.application_amt)"
                                        type="number"
                                        v-model="loanPayment.loan_amount"
                                        number
                                        id="application_amt"
                                        class="text-right"
                                        readonly
                                        required >
                                    </b-form-input>
                                    <b-form-input v-if="visible === false" @focus="onFocusText" type="text" v-model="formattedData" number id="application_amt" class="text-right" required ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Remaining Principle Amount(TK)" label-for="remaining_principle_amount">
                                    <b-form-input
                                        v-if="visible === true"
                                          type="number"
                                        v-model="loanPayment.remaining_principle_amount"
                                        number
                                        id="remaining_principle_amount"
                                        class="text-right"
                                        readonly
                                        required >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Remaining Interest Amount(TK)" label-for="remaining_interest_amount">
                                    <b-form-input
                                        v-if="visible === true"
                                         type="number"
                                        v-model="loanPayment.remaining_interest_amount"
                                        number
                                        id="remaining_interest_amount"
                                        class="text-right"
                                        readonly
                                        required >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Number Of Installment" label-for="number_of_installment" class="required">
                                    <b-form-input
                                        v-if="visible === true"
                                        type="number"
                                        v-model="loanPayment.number_of_installment"
                                        number
                                        readonly
                                        id="number_of_installment"
                                        class="text-right"
                                        required >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Challan Amount" label-for="payment_priciple_interest" class="required">
                                    <b-form-input required
                                                  v-model="loanPayment.challan_amount"
                                                  @input="calculationPriciple"  number
                                                  class="text-right" id="payment_priciple_interest"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group :state="state" label="Payment Principle amount" label-for="payment_priciple_interest">
                                    <b-form-input :state="state" v-model="loanPayment.payment_interest_amount" @input="calculationInterest"  number readonly class="text-right" id="payment_priciple_interest"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Payment Interest amount" label-for="interest">
                                    <b-form-input v-model="loanPayment.payment_priciple_interest" number class="text-right" id="payment_interest_amount"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group class="requiredField" label="Challan Number" label-for="challan_number">
                                    <b-form-input required v-model="loanPayment.challan_number" number class="text-left" id="challan_number"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group label="Challan Date" label-for="doc_date" class="requiredField">
                                    <date-picker
                                        width="100%"
                                        input-class="form-control"
                                        v-model="loanPayment.doc_date"
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
                                <b-form-group label="Attachment" label-for="interest">
                                    <b-form-file @change="encodeFile($event)"
                                                 v-bind:id="'attachment'.index"
                                                 name="attachment"
                                                 placeholder="Attachment"
                                    ></b-form-file>
                                </b-form-group>
                            </b-col>
                            <b-col sm="3">
                                <b-form-group label="Bank Deposit Date" label-for="bank_deposit_date" class="requiredField">
                                    <date-picker
                                        width="100%"
                                        input-class="form-control"
                                        v-model="loanPayment.bank_deposit_date"
                                        :value-type="valueType"
                                        type="date"
                                        lang="en"
                                        :editable="false"
                                        format="DD-MM-YYYY"
                                        required>
                                    </date-picker>
                                </b-form-group>
                            </b-col>

                            <b-col md="9">
                                <b-form-group label="Note" label-for="note" class="required">
                                    <b-form-textarea v-model="loanPayment.note" id="note" required></b-form-textarea>
                                </b-form-group>
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
                <b-card-header header-bg-variant="dark" header-text-variant="white">Loan Payment List</b-card-header>
                <b-card-body class="border">
                    <Datatable  v-bind:fields="columns" :totalList="totalItems" :small="small" perPage="10" v-bind:items="loadData"  :primaryKeyColumnName="'application_id'">
<!--                        <template v-slot:action2="{ rows }">-->
<!--                            <b-link @click="selectLoan(rows.item)" class="ot-btn btn btn-primary">-->
<!--                                <i  class="bx bx-edit cursor-pointer"></i>-->
<!--                            </b-link>-->
<!--                        </template>-->
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
    import groupBy from "lodash/groupBy"
    import axios from "axios";


    export default {
        components: { Datatable, Vue, vSelect, vcss, DatePicker},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan Payment"});
            this.fyMonthData();
            // ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/search-loan/null/null`, this.loanApplication).then(res => {
            //     this.LoanList = res.data;
            // })
        },
        computed:{
            state() {
                return this.loanPayment.payment_interest_amount>=0 && this.loanPayment.payment_interest_amount<=this.loanPayment.challan_amount
            }
        },
        data() {
            return {
                valueType: this.dateFormatter(),
                loanPayment:{
                    prMonths:null,
                    rate_of_interest:null,
                    loan_type_id:null,
                    emp_name:null,
                    loan_no:null,
                    designation:null,
                    department_name:null,
                    dpt_section:null,
                    payment_interest_amount:0,
                    payment_priciple_interest:0,
                    challan_amount:null,
                    challan_number:null,
                    note:null,
                    loan_amount:null,
                    installment_no:null,
                    remaining_principle_amount:0,
                    remaining_interest_amount:0,
                    number_of_installment:0,
                    attachment:null,
                    attachment_file_name:null,
                    doc_date: '',
                    bank_deposit_date: ''
                },
                max_value:null,
                loan_type:null,
                submitBtn:'Submit',
                amountReadonly:true,
                ex_hidden:false,
                acc_hidden:false,
                formattedData:null,
                visible: true,
                temp: null,
                small:true,
                empIdList:[],
                prYears:[],
                prMonths:[],
                prMonthsAll:[],
                LoanList: [],
                listItems:[],
                loanTypes:[],
                totalItems:0,
                selectedLoan: {},
                updateIndex: -1,
                approval:[{text:'Approved', value:1},{text:'Not Approved', value: -1}, {text: 'Pending', value: 0}],
                appInstlmntList: [{text: '12', value: 12}, {text: '24', value: 24},{text: '36', value: 36}, {text: '48', value: 48}],
                show: true,
                columns: [
                    {label: 'SL', key: 'index', sortable:true},
                    {label: 'Transactions no', key: 'transactions_no', sortable:true},
                    {
                        label: 'Transaction Date',
                        key:'transaction_date',
                        sortable:true,
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                    },
                    {label: 'Transactions Type', key:'transaction_type.meaning', sortable:true},
                    {label: 'Amount', key: 'transaction_amt', sortable: true, class:'text-right',
                        formatter: value => {
                            if(value) {
                                let val = (value/1).toFixed(2).replace(',', ',')
                                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                            }
                        },
                    },
                    {label: 'description', key: 'description', sortable:false},
                    {label: 'Installment No', key: 'installment_no', sortable:false},
                    {
                        label: 'Due Installment No',
                        key: 'due_installment_no',
                        sortable:false
                    },
                    {
                        label: 'Due Amount',
                        key: 'due_amount',
                        sortable:false,
                        class: 'text-right'
                    },
                    {
                        label: 'Status',
                        key: 'approval_status',
                        sortable:true,
                        formatter: value => {
                            if(value == 'Y') {
                                return 'Approved'
                            } else if (value == 'N'){
                                return 'Not Approved'
                            } else {
                                return ''
                            }
                        },
                    },
                    // {label: 'Action', key: 'action2'}
                ]}
        },
        watch: {
            selectedLoan: function (val, oldVal) {
                if (val !== null) {
                    this.loanPayment.loan_no = val.loan_no;
                    this.loanPayment.emp_name=  val.employee_name;
                    this.loanPayment.application_id=  val.application_id;
                    this.loanPayment.bill_code = val.bill_code;
                    if (val.section)
                        this.loanPayment.dpt_section = val.section;
                    if ( val.department)
                        this.loanPayment.department_name=  val.department;
                    if(val.designation)
                        this.loanPayment.designation=  val.designation;

                    this.loanPayment.loan_amount = val.loan_amount;
                    this.loanPayment.remaining_principle_amount = val.remaining_principle_amount;
                    this.loanPayment.remaining_interest_amount = val.remaining_interest_amount;
                    this.loanPayment.number_of_installment = val.paid_installment_no;

                    if(this.loanPayment.loan_type_id){
                        this.amountReadonly=false;
                    }
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
            encodeFile(e) {
                let file_limit = 2000000;
                let self = this;
                if(e.target.files[0].size<=file_limit){
                    if (e.target.files[0].type=='application/msword'||e.target.files[0].type=='application/vnd.openxmlformats-officedocument.wordprocessingml.document'||e.target.files[0].type=='application/pdf'||e.target.files[0].type=='image/jpeg'||e.target.files[0].type=='image/jpg'
                        || e.target.files[0].type=='image/png' || e.target.files[0].type=='application/vnd.ms-excel' || e.target.files[0].type=='application/vnd.ms-excel'){
                        let file = e.target.files[0];
                        let reader = new FileReader();
                        let type = file;
                        let name = file.name;

                        reader.readAsDataURL(file);

                        reader.onload = (file)=> {
                            self.loanPayment.attachment = reader.result;
                            self.loanPayment.attachment_file_name = name;
                        }
                    }
                    else {
                        this.$notify({group: 'pmis', text: "File type should be in pdf, jpg or jpeg", type: 'error'});
                    }

                }else{
                    this.$notify({group: 'pmis', text: "File size should not exceed 2MB", type: 'error'});
                    return;
                }

            },
            calculationPriciple(){
                this.loanPayment.payment_interest_amount = this.loanPayment.challan_amount;
                this.loanPayment.payment_priciple_interest = this.loanPayment.challan_amount - this.loanPayment.payment_interest_amount;
            },
            calculationInterest(){
                this.loanPayment.payment_priciple_interest = this.loanPayment.challan_amount - this.loanPayment.payment_interest_amount;
            },
            onSubmit() {
                 ApiRepository.callApi(ApiRepository.POST_COMMAND, `/loan/payment-store`,this.loanPayment).then(res => {
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
                this.selectedEmployee={emp_id:null}
                this.selectedLoan = {}
                this.loanPayment = {
                        rate_of_interest:null,
                        loan_type_id:null,
                        emp_name:null,
                        loan_no:null,
                        designation:null,
                        department_name:null,
                        dpt_section:null,
                        payment_interest_amount:null,
                        payment_priciple_interest:null,
                        challan_amount:null,
                        challan_number:null,
                        note:null,
                        loan_amount:null,
                        installment_no:null,
                        remaining_principle_amount:0,
                        remaining_interest_amount:0,
                        number_of_installment:0,
                        attachment:null,
                        attachment_file_name:null,
                },
                //    this.listItems=null;
                this.LoanList=[];
            },
            editRow(i, code) {

            },
            deleteRow(i, code) {

            },
            loanTypeChange(id) {
                this.loan_type = id;
                // this.loanApplication.rate_of_interest = this.loanTypes.filter(a => a.loan_type_id == id)[0].rate_of_interest;
                // this.max_value = this.loanTypes.filter(a => a.loan_type_id == id)[0].max_value;

            },
            searchEmployees(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/search-loan/${this.loan_type}/${id}`, this.loanApplication).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            selectLoan(item) {
                this.submitBtn='Update';
                this.selectedEmployee=item;
                this.loanApplication = item;
                this.searchEmployees(this.loanApplication.emp_code);
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
            dynamicSort(property) {
                var sortOrder = 1;
                if(property[0] === "-") {
                    sortOrder = -1;
                    property = property.substr(1);
                }
                return function (a,b) {
                    var result = (a[property] < b[property]) ? -1 : (a[property] > b[property]) ? 1 : 0;
                    return result * sortOrder;
                }
            },
            fyMonthData() {
                this.csrf = axios.defaults.headers.common['X-CSRF-TOKEN'];
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/loan/active_financial_year").then(res => {
                    this.prMonths = res.data.prMonths;
                    //this.prMonthsAll = res.data.prMonthsAll;
                    this.prYears = res.data.prFiscalYears;
                });
            },
            loadData(ctx, callback) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/payments`+'?page=' + ctx.currentPage + '&size=' + ctx.perPage+'&filter=' + ctx.filter).then(res => {
                    const items =res.data.payments.data;
                    this.totalItems = res.data.payments.total;
                    this.loanTypes=res.data.loanTypes;
                    callback(items);
                });
                return null;
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
            // loanTypeChange(id){
            //     let search = null;
            //     // this.loanApplication.rate_of_interest =this.loanTypes.filter(a=>a.loan_type_id==id)[0].rate_of_interest;
            //     // this.max_value=this.loanTypes.filter(a=>a.loan_type_id==id)[0].max_value;
            //     ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/search-loan/${id}/${search}`, this.loanApplication).then(res => {
            //         this.LoanList = res.data;
            //     })
            // },
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
            getMonths: function(year) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/loan/year-months/"+year).then(res => {
                    this.prMonthsAll = res.data;
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
    .form-control.is-valid, .was-validated .form-control:valid {
        border-color:#DFE3E7!important;
    }
</style>
