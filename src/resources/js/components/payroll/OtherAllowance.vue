<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Other Allowance</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Fiscal Years"
                                    class="requiredField"
                                    label-for="Fiscal_Years"
                                >
                                    <b-form-input  v-if="otherAllowance.pr_month" disabled  v-model="otherAllowance.pr_month.fiscal_year.fy_name" id="amount"></b-form-input>
                                    <b-form-select
                                        v-else
                                        v-model="otherAllowance.fiscalYear"
                                        :options="activeFiscalYearOptions"
                                        class=""
                                        value-field="value"
                                        text-field="text"
                                        disabled-field="notEnabled" name="fiscalYear"
                                        required
                                        @change="getActivePrMonths"
                                    >
                                        <template v-slot:first>
                                            <option value="">-- Please select an option --</option>
                                        </template>
                                    </b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Month"
                                    class="requiredField"
                                    label-for="Month"
                                >
                                    <b-form-select v-model="otherAllowance.pr_month_id"
                                                   name="pr_month" required
                                                   :options="fiscalMonthOptions" value-field="value"
                                                   text-field="formatted_month"
                                    >
                                        <template v-slot:first>
                                            <option value="">-- Please select an option --</option>
                                        </template>
                                    </b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Other Head Type"
                                    class="requiredField"
                                    label-for="other_head_type"
                                >
                                    <b-form-select
                                        v-model="otherAllowance.other_head_type_id"
                                        :options="allowanceTypes"
                                        class=""
                                        value-field="value"
                                        text-field="text"
                                        disabled-field="notEnabled" name="other_head_type"
                                        required
                                    >
                                        <template v-slot:first>
                                            <option value="">-- Please select an option --</option>
                                        </template>
                                    </b-form-select>
                                </b-form-group>
                            </b-col>
<!--                            <b-col md="4">-->
<!--                                <b-form-group-->
<!--                                    label="Department"-->
<!--                                    label-for="department"-->
<!--                                >-->
<!--                                    <v-select v-model="selectedDepartment" name="department"-->
<!--                                              @input="departmentChange($event)"-->
<!--                                              :options="departmentOptions"-->
<!--                                              label="text" required>-->
<!--                                        <template #search="{attributes, events}">-->
<!--                                            <input class="vs__search" v-bind="attributes" v-on="events"/>-->
<!--                                        </template>-->
<!--                                    </v-select>-->
<!--                                </b-form-group>-->
<!--                            </b-col>-->
                            <b-col md="4">
                                <b-form-group
                                    label="Transaction Date"
                                    class=""
                                    label-for="amount"
                                >
                                    <date-picker
                                        width="100%"
                                        input-class="form-control"
                                        v-model="otherAllowance.trans_date"
                                        type="date"
                                        lang="en"
                                        :editable="false"
                                        format="DD-MM-YYYY"
                                        required>
                                    </date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col md="8">
                                <b-form-group
                                    label="Transaction Purpose"
                                    class=""
                                    label-for="trans_purpose"
                                >
                                    <b-form-input  v-model="otherAllowance.trans_purpose" id="trans_purpose"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <!--                            <b-col md="4">-->
                            <!--                                <b-form-group-->
                            <!--                                    label="Tax Amount"-->
                            <!--                                    class=""-->
                            <!--                                    label-for="tax_amount"-->
                            <!--                                >-->
                            <!--                                    <b-form-input required  v-model="otherAllowance.tax_amount" id="tax_amount"></b-form-input>-->
                            <!--                                </b-form-group>-->
                            <!--                            </b-col>-->
                            <b-col md="4">
                                <b-form-group
                                    label="Pay Order Number"
                                    class="requiredField"
                                    label-for="po_no"
                                >
                                    <b-form-input required  v-model="otherAllowance.po_no" id="po_no"></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Pay Order Date"
                                    class="requiredField"
                                    label-for="po_date"
                                >
                                    <date-picker
                                        width="100%"
                                        input-class="form-control"
                                        v-model="otherAllowance.po_date"
                                        type="date"
                                        lang="en"
                                        :editable="false"
                                        format="DD-MM-YYYY"
                                        required>
                                    </date-picker>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Amount"
                                    class="requiredField"
                                    label-for="amount"
                                >
                                    <b-form-input required  v-model="otherAllowance.amount" id="amount"></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Number of Employee"
                                    class="requiredField"
                                    label-for="no_of_emp"
                                >
                                    <b-form-input required type="number" @input="employeeList($event)"  v-model="otherAllowance.no_of_emp" :readonly="onlyEdit" id="no_of_emp"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Remarks"
                                    class=""
                                    label-for="remarks"
                                >
                                    <b-form-textarea
                                        id="remarks"
                                        v-model="otherAllowance.remarks"
                                        placeholder="Enter something..."
                                        rows="3"
                                        max-rows="6"
                                    ></b-form-textarea>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row v-if="this.otherAllowance.other_allowance_details.length > 0">
                            <b-col md="12" >
                                <table class="table table-border table-sm">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th>Employee Name</th>
                                        <th class="text-right">Amount</th>
                                        <th class="text-right">Tax Amount</th>
                                        <th class="text-right" v-if="onlyEdit">Action</th>
                                    </tr>
                                    </thead>
                                    <tr v-for="(other_allowance_details,k) in otherAllowance.other_allowance_details" :key="k">
                                        <td>
                                            <v-select
                                                id=""
                                                v-model="other_allowance_details.employee"
                                                @input="selectEmployee(other_allowance_details.employee)"
                                                @search="searchEmployee"
                                                label="option_name"
                                                :options="employeeOptions">
                                                <template #search="{attributes, events}">
                                                    <input class="vs__search" v-bind="attributes" v-on="events" />
                                                </template>
                                            </v-select>
                                        </td>
                                        <td class="text-right">
                                            <b-form-input class="text-right" @input="taxCalculation(other_allowance_details.amount,k)" v-model="other_allowance_details.amount" placeholder="Amount"></b-form-input>
                                        </td>
                                        <td class="text-right">
                                            <b-form-input class="text-right" v-model="other_allowance_details.tax" placeholder="Tax Amount"></b-form-input>
                                        </td>
                                        <td class="text-right" v-if="onlyEdit">
                                            <button type="button" :disabled="otherAllowance.approve_yn == 'Y'" class="btn btn-danger" @click="deleteEmployee(other_allowance_details)" >Delete</button>
                                        </td>
                                    </tr>
                                </table>
                                <button v-if="onlyEdit" type="button" class="btn btn-success" @click="addMoreEmployee" :disabled="otherAllowance.approve_yn == 'Y'">Add</button>
                            </b-col>
                        </b-row>
                        <!--                        <b-row>-->
                        <!--                            <b-col md="12" v-if="this.otherAllowance.no_of_emp > 0">-->
                        <!--                                <table class="table table-border table-sm">-->
                        <!--                                    <thead class="thead-dark">-->
                        <!--                                    <tr>-->
                        <!--                                        <th>Employee Name</th>-->
                        <!--                                        <th class="text-right">Amount</th>-->
                        <!--                                        <th class="text-right">Tax Amount</th>-->
                        <!--                                    </tr>-->
                        <!--                                    </thead>-->
                        <!--                                    <tr v-for="index in Number(this.otherAllowance.no_of_emp)" :key="index">-->

                        <!--                                        <td>-->
                        <!--                                            <v-select-->
                        <!--                                                id="employee"-->
                        <!--                                                v-model="otherAllowance[index].other_allowance_details.employee"-->
                        <!--                                                @input="selectEmployee(otherAllowance.other_allowance_details.employee)"-->
                        <!--                                                label="option_name"-->
                        <!--                                                :options="employeeOptions">-->
                        <!--                                                <template #search="{attributes, events}">-->
                        <!--                                                    <input class="vs__search" v-bind="attributes" v-on="events" />-->
                        <!--                                                </template>-->
                        <!--                                            </v-select>-->
                        <!--                                        </td>-->
                        <!--                                        <td class="text-right">-->
                        <!--                                            <b-form-input class="text-right" @input="taxCalculation(otherAllowance.other_allowance_details[index].amount,index)"  v-model="otherAllowance.other_allowance_details[index].amount" placeholder="Amount"></b-form-input>-->
                        <!--                                        </td>-->
                        <!--                                        <td class="text-right" v-if="!otherAllowance.other_allowance_details.tax">-->
                        <!--                                            <b-form-input class="text-right" v-model="otherAllowance.other_allowance_details[index].tax_amount" placeholder="Tax Amount"></b-form-input>-->
                        <!--                                        </td>-->
                        <!--                                    </tr>-->
                        <!--                                </table>-->
                        <!--                            </b-col>-->
                        <!--                        </b-row>-->
                        <b-row>
                            <b-col class="d-flex justify-content-end" v-if="otherAllowance.approve_yn != 'Y'">
                                <b-button type="submit" variant="primary" :disabled="otherAllowance.pr_month && !onlyEdit">{{submit}}</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>

            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Other Allowance List</b-card-header>
                <b-card-body class="border">
                    <Datatable  :fields="fields" :totalList="totalLength" :small="true" :perPage="perPage" :items="items" style="white-space: nowrap!important;" >
                        <template v-slot:actions="{ rows }">
                            <b-button v-if="rows.item.approve_yn!='Y'" :variant="rows.item.hold_yn != 'Y'? 'secondary' : 'danger'" size="sm" @click="holdAllowance(rows.item)"> {{rows.item.hold_yn != 'Y'?'Hold':'Active'}} </b-button>
                            <b-button v-if="rows.item.hold_yn!='Y'" :variant="rows.item.approve_yn != 'Y'? 'primary' : 'success'" size="sm" @click="approveAllowance(rows.item)">{{rows.item.approve_yn != 'Y'?'Approve':'Approved'}}</b-button>
                            <!--                            <a class="btn btn-dark btn-secondary mr-2 btn-sm" target="_blank"-->
                            <!--                               :href="`/report/render/RPT_HONORARIUM_BILL?xdo=/~weblogic/Payroll/RPT_HONORARIUM_BILL.xdo&P_FY_ID=${rows.item.pr_month ? rows.item.pr_month.pr_year : 0}&P_PR_MONTH_ID=${rows.item.pr_month_id}&P_DEPARTMENT_ID=${rows.item.department_id}&type=pdf&filename=RPT_HONORARIUM_BILL`">-->
                            <!--                                <i class="bx bx-printer"></i> Print</a> -->
                            <a class="btn btn-dark btn-secondary mr-2 btn-sm" target="_blank"
                               :href="`/report/render/RPT_HONORARIUM_BILL?xdo=/~weblogic/Payroll/RPT_HONORARIUM_BILL.xdo&p_other_allowance_id=${rows.item.emp_other_allwoance_id ? rows.item.emp_other_allwoance_id : 0}&type=pdf&filename=RPT_HONORARIUM_BILL`">
                                <i class="bx bx-printer"></i> Print</a>
                            <b-button  variant="info" size="sm" @click="viewAllowance(rows.item)">View</b-button>
                            <b-button  variant="primary" size="sm" @click="editAllowance(rows.item)">Edit</b-button>
                            <!--                            <b-button v-if="rows.item.disburse_yn!='Y'" :variant="rows.item.disburse_yn != 'Y'? 'primary' : 'success'" size="sm" @click="disburseAllowance(rows.item)">{{rows.item.disburse_yn != 'Y'?'Disburse':'Disbursed'}}</b-button>-->
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>

        </div>
    </div>
</template>

<script>
    import ApiRepository from '../../Repository/ApiRepository';
    import Datatable from '../../layouts/common/datatable';
    import moment from "moment";
    import vSelect from 'vue-select'
    import vcss from 'vue-select/dist/vue-select.css';
    import DatePicker from "vue2-datepicker";
    import Approval from "../../layouts/common/Approval";
    const { required, requiredIf, maxLength, minLength, email } = require("vuelidate/lib/validators");
    export default {
        name: "OtherAllowance",
        components: {vSelect, vcss, DatePicker, Datatable, Approval},
        data() {
            return {
                otherAllowance: {
                    emp_other_allwoance_id: 0,
                    department_id: 0,
                    other_head_type_id: 1,
                    fiscalYear: 0,
                    pr_month_id: 0,
                    amount: 0,
                    hold_yn: 'N',
                    tax_amount: '',
                    trans_date: '',
                    trans_purpose: '',
                    po_no: '',
                    po_date: '',
                    no_of_emp: '',
                    remarks: '',
                    // other_allowance_details: {
                    //     employee : [],
                    //     amount:[],
                    //     tax_amount:[],
                    // },
                    other_allowance_details: [],
                },
                submit :  'Submit',
                onlyEdit : false,
                tax_value : null,
                total_details_amount :  0,
                fiscalYearOptions: [],
                activeFiscalYearOptions: [],
                fiscalMonthOptions: [],
                activeFiscalMonthOptions: [],
                departmentOptions: [],
                employeeOptions: [],
                selectedDepartment: {},
                selectedEmployee: {},
                allowanceTypes: [],
                items: [],
                fields: [
                    {key: 'index', label: 'Sl'},
                    {key: 'department.department_name', label: 'Department'},
                    {key: 'head_type.other_head_type', label: 'Other Head Type'},
                    {key: 'amount', label: 'Amount'},
                    {key: 'po_no', label: 'Pay Order No'},
                    {
                        key: 'po_date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        label: 'Pay Order Date'
                    },
                    // {
                    //     key: 'update_date',
                    //     formatter: value => {
                    //         if(value) {
                    //             return moment(value).format('DD-MM-YYYY');
                    //         }
                    //     },
                    //     label: 'Modification Date'
                    // },
                    {key: 'action', class: 'text-center'}
                ],
                totalLength: 1,
                perPage: 5
            }
        },
        mounted() {
            this.loadBasicInfo()
            this.getFiscalYears()
            this.getActiveFiscalYears()
            this.preload()
        },
        watch: {

            selectedDepartment : function (val, oldVal) {
                console.log('value',val.value);
                if(val.value){
                    this.otherAllowance.department_id = val.value
                }
            },

            selectedEmployee: function (val, oldVAl) {
                //console.log('emp_id',val.emp_id)
                if(val) {
                    this.otherAllowance.emp_id = val.emp_id
                } else {
                    this.otherAllowance.emp_id = ""
                }
            },

            selectedBillHeadForAllowance: function (val, oldVal) {
                if(val) {
                    this.allowanceFormData.bill_head_id = val.bill_head_id
                    this.allowanceFormData.coa_code = val.coa_code
                    this.allowanceFormData.deduction = val.deduction
                    this.allowanceFormData.deduction_yn = val.deduction_yn
                } else  {
                    this.allowanceFormData.bill_head_id = ''
                    this.allowanceFormData.coa_code = ''
                    this.allowanceFormData.deduction = ''
                    this.allowanceFormData.deduction_yn = ''
                }
            }
        },
        filters: {
            months : function (value) {
                if(value == 1) {
                    return 'JULY'
                } else if(value == 2){
                    return 'AUGUST'
                }else if(value == 3){
                    return 'SEPTEMBER'
                }else if(value == 4){
                    return 'OCTOBER'
                }else if(value == 5){
                    return 'NOVEMBER'
                }else if(value == 6){
                    return 'DECEMBER'
                }else if(value == 7){
                    return 'JANUARY'
                }else if(value == 8){
                    return 'FEBRUARY'
                }else if(value == 9){
                    return 'MARCH'
                }else if(value == 10){
                    return 'APRIL'
                }else if(value == 11){
                    return 'MAY'
                }else if(value == 12){
                    return 'JUNE'
                }else {
                    return ''
                }
            },
            dateFormat(value) {
                if (value) {
                    return moment(String(value)).format('MM/DD/YYYY')
                }
            }
        },
        computed: {

        },
        methods: {
            employeeList(data){
                if (data > 0){
                    for (let i=0; i < data; i++){
                        this.otherAllowance.other_allowance_details.push({
                            employee : '',
                            amount:'',
                            tax:'',
                        });
                    }
                }else{
                    this.otherAllowance.other_allowance_details = [];
                }

            },
            addMoreEmployee(){
                this.otherAllowance.other_allowance_details.push({
                    employee : '',
                    amount:'',
                    tax:'',
                });
                this.otherAllowance.no_of_emp = this.otherAllowance.other_allowance_details.length;
            },
            deleteEmployee(data){
                const index = this.otherAllowance.other_allowance_details.indexOf(data);
                if (index > -1) { // only splice array when item is found
                    this.otherAllowance.other_allowance_details.splice(index, 1); // 2nd parameter means remove one item only
                }
                this.otherAllowance.no_of_emp = this.otherAllowance.other_allowance_details.length;
            },
            loadBasicInfo(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pmis/employee/basic-infos").then(res => {
                    this.departmentOptions = res.data.allDepartment
                });
            },
            getFiscalYears(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/payroll/get-fiscal-years`).then( res => {
                    this.fiscalYearOptions = res.data
                    let that = this;
                    this.fiscalYearOptions.forEach(function(item) {
                        if (item.current_yn == 'Y') {
                            that.otherAllowance.fiscalYear = item.fy_id;
                            that.getPrMonths();
                        }
                    });
                })
            },
            getActiveFiscalYears(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/payroll/get-active-fiscal-years`).then( res => {
                    this.activeFiscalYearOptions = res.data
                    let that = this;
                    this.fiscalYearOptions.forEach(function(item) {
                        if (item.current_yn == 'Y') {
                            that.otherAllowance.fiscalYear = item.fy_id;
                            that.getPrMonths();
                        }
                    });
                })
            },
            getPrMonths(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/payroll/active-pr-months/${this.otherAllowance.fiscalYear}`).then( res => {
                    this.fiscalMonthOptions = res.data;
                    let that = this;
                    this.fiscalMonthOptions.forEach(function(month) {
                        if (month.text == moment().format("MMMM")) {
                            that.otherAllowance.pr_month_id = month.value;
                        }
                    });
                })
            },
            getActivePrMonths(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/payroll/active-pr-months/${this.otherAllowance.fiscalYear}`).then( res => {
                    this.activeFiscalMonthOptions = res.data;
                    let that = this;
                    this.fiscalMonthOptions.forEach(function(month) {
                        if (month.text == moment().format("MMMM")) {
                            that.otherAllowance.pr_month_id = month.value;
                        }
                    });
                })
            },
            preload(){
                this.onlyEdit = false;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/allowance-types/`).then(res => {
                    this.allowanceTypes = res.data;
                })
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/allowance-list/`).then(res => {
                    if (res.data.length > 0){
                        this.items = res.data
                        this.totalLength = res.data.length
                    } else {
                        this.items = []
                        this.totalLength = 1
                    }
                })

            },
            viewAllowance(data) {
                //console.log(data)
                this.otherAllowance = data;
                this.otherAllowance.fiscalYear = data.pr_month ? data.pr_month.fy_name : '';
                this.selectedDepartment= data.department.department_name
                this.onlyEdit = false;
                // this.selectedDepartment = {
                //     text: data.department_id,
                //     value: data.department ? data.department.department_name :'',
                //
                // };
            },
            editAllowance(data) {
                //console.log(data)
                this.otherAllowance = data;
                this.otherAllowance.fiscalYear = data.pr_month ? data.pr_month.fy_name : '';
                this.selectedDepartment= data.department.department_name
                this.submit = 'Update';
                this.onlyEdit = true;
                this.departmentChange();
                // this.searchEmployee(0);
                // this.selectedDepartment = {
                //     text: data.department_id,
                //     value: data.department ? data.department.department_name :'',
                //
                // };
            },
            onSubmit() {
                let currObj = this;
                let totalSum = 0;
                this.otherAllowance.other_allowance_details.forEach(obj => {
                    // let objSum = obj.amount + obj.amount;
                    totalSum += parseInt(obj.amount);
                })
                console.log('total_details_amount',totalSum);
                if (this.otherAllowance.amount != totalSum){
                    totalSum = 0;
                    currObj.$notify({group: 'pmis', text: 'Total Amount Not Match', type: 'error'})
                    return;
                }
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/payroll/allowance-add", this.otherAllowance).then(res => {
                    if (res.data.o_status_code == 1){
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.onReset()
                        this.preload()
                    }else{
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message ? res.data.o_status_message : 'Something went wrong', type: 'error'})
                    }
                }).catch(err => {
                    currObj.$notify({ group: 'pmis', text: err.message+' Something went wrong', type:'error' });
                });
            },
            approveAllowance(data) {
                let currObj = this;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/payroll/allowance-approve", data).then(res => {
                    if (res.data.o_status_code == 1){
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.preload()
                    }else{
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message ? res.data.o_status_message : 'Something went wrong', type: 'error'})
                    }
                }).catch(err => {
                    currObj.$notify({ group: 'pmis', text: 'Something went wrong', type:'error' });
                });
            },
            holdAllowance(data) {
                if (data.hold_yn == 'Y'){
                    data.hold_yn = 'N';
                }else{
                    data.hold_yn = 'Y';
                }
                let currObj = this;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/payroll/allowance-hold", data).then(res => {
                    if (res.data.o_status_code == 1){
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.preload()
                    }else{
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message ? res.data.o_status_message : 'Something went wrong', type: 'error'})
                    }
                }).catch(err => {
                    currObj.$notify({ group: 'pmis', text: 'Something went wrong', type:'error' });
                });
            },
            disburseAllowance(data) {
                let currObj = this;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/payroll/allowance-disburse", data).then(res => {
                    if (res.data.o_status_code == 1){
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.preload()
                    }else{
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message ? res.data.o_status_message : 'Something went wrong', type: 'error'})
                    }
                }).catch(err => {
                    currObj.$notify({ group: 'pmis', text: 'Something went wrong', type:'error' });
                });
            },



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
            onReset() {
                this.otherAllowance = {
                    emp_other_allwoance_id: 0,
                    emp_id: 0,
                    emp_code: 0,
                    department_id: 0,
                    other_head_type_id: 0,
                    fiscalYear: 0,
                    pr_month_id: 0,
                    amount: 0,
                    hold_yn: 'N',
                    other_allowance_details: []
                }
                this.selectedDepartment = {}
                this.selectedEmployee = {}
            },

            selectEmployee(employee){
                console.log(employee)
                if (employee.emp_tin_no !== '   -   -' && employee.emp_tin_no !== '-   -' && employee.emp_tin_no !== '0' && employee.emp_tin_no !== null) {
                    this.tax_value =  10;
                }else{
                    this.tax_value =  15;
                }
            },
            taxCalculation(amount,k){
                console.log(this.tax_value)
                this.otherAllowance.other_allowance_details[k].tax = amount * this.tax_value/100;
            },
            searchEmployee(emp_code){
                // console.log(emp_code)
                if (emp_code) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/search-all-employees/${emp_code}`).then(res => {
                        this.employeeOptions = res.data;
                    })
                }
            },
            employeeChange(event){
                console.log('employee_id',event.value);
            },
            departmentChange(event){
                console.log('department_id',event.value);
                this.selectedEmployee = {}
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/search-employees-dpt/${event.value}/0`).then(res => {
                    this.employeeOptions = res.data;
                })
            }
        }
    }
</script>

<style scoped>
</style>
