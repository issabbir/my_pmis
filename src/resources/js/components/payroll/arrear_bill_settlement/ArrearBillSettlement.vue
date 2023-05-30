<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Search For Arrear Bill</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSearch" @reset.prevent="onReset">
                        <b-row>
                            <b-col md="3">
                                <b-form-group
                                    label="Fiscal Years"
                                    class="requiredField"
                                    label-for="Fiscal_Years"
                                >
                                    <b-form-select
                                        v-model="searchParams.fiscalYear"
                                        :options="fiscalYearOptions"
                                        class=""
                                        value-field="value"
                                        text-field="text"
                                        disabled-field="notEnabled" name="fiscalYear"
                                        required
                                        @change="getPrMonths"
                                    >
                                        <template v-slot:first>
                                            <option value="">-- Please select an option --</option>
                                        </template>
                                    </b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Month"
                                    class="requiredField"
                                    label-for="Month"
                                >
                                    <b-form-select v-model="searchParams.pr_month"
                                                   name="pr_month" required
                                                   :options="fiscalMonthOptions" value-field="value"
                                                   text-field="formatted_month"
                                                   @change="getBillCodes">
                                        <template v-slot:first>
                                            <option value="">-- Please select an option --</option>
                                        </template>
                                    </b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Bill Code."
                                    label-for="bill_code"
                                >
                                    <v-select v-model="searchParams.bill_code" :options="billCodeOptions" label="bill_code"  :disabled="!searchParams.pr_month" required>
                                        <template #search="{attributes, events}">
                                            <input
                                                class="vs__search"
                                                v-bind="attributes"
                                                v-on="events"
                                            />
                                        </template>
                                    </v-select>

                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Employee"
                                    class=""
                                    label-for="emp_id"
                                >
                                    <v-select
                                        id="employee"
                                        v-model="selectedEmployee"
                                        @search="searchEmployee"
                                        label="option_name"
                                        :options="employeeOptions">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events" />
                                        </template>
                                    </v-select>

                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="d-flex justify-content-end">
                                <b-button type="submit" variant="primary">Search</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>

            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Arrear Bill List</b-card-header>
                <b-card-body class="border">
                    <Datatable  :fields="fields" :totalList="totalLength" :small="true" :perPage="perPage" :items="items" >
                        <template v-slot:actions="{ rows }">
                            <b-button variant="secondary" size="sm" @click="renderModal(rows.item)"> View </b-button>
                            <b-button :variant="rows.item.bill_status_id != 2? 'primary' : 'success'" size="sm" @click="showApprovalModal(rows.item)">{{rows.item.bill_status_id != 2?'Approve':'Approved'}}</b-button>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>

            <b-modal ref="detailsModal" scrollable size="xl" @ok.prevent="updateDetails" ok-title="Update" title="Arrear Bill Information">
                <b-card>
                    <b-card-text>
                        <b-row>
                            <b-col md="2">
                                <b>Employee Code</b>
                            </b-col>
                            <b-col md="4">
                                {{modalData.employee.emp_code}}
                            </b-col>
                            <b-col md="2">
                                <b>Employee Name</b>
                            </b-col>
                            <b-col md="4">
                                {{modalData.employee.emp_name}}
                            </b-col>
                            <b-col md="2">
                                <b>Designation</b>
                            </b-col>
                            <b-col md="4">
                                {{modalData.employee.designation.designation}}
                            </b-col>
                            <b-col md="2">
                                <b>Division</b>
                            </b-col>
                            <b-col md="4">
                                {{modalData.employee.dpt_division.dpt_division_name}}
                            </b-col>
                            <b-col md="2">
                                <b>Department</b>
                            </b-col>
                            <b-col md="4">
                                {{modalData.employee.department.department_name}}
                            </b-col>
                            <b-col md="2">
                                <b>Employee Status</b>
                            </b-col>
                            <b-col md="4" style="color:red">
                                {{modalData.employee.emp_status.text}}
                            </b-col>
                            <b-col md="2">
                                <b>Bill Code</b>
                            </b-col>
                            <b-col md="4">
                                {{modalData.bill_code}}
                            </b-col>
                            <b-col md="2">
                                <b>Bill No.</b>
                            </b-col>
                            <b-col md="4">
                                {{modalData.bill_no}}
                            </b-col>
                            <b-col md="2">
                                <b>Bill Date</b>
                            </b-col>
                            <b-col md="4">
                                {{modalData.bill_date|dateFormat}}
                            </b-col>
                            <b-col md="2">
                                <b>Fiscal Year</b>
                            </b-col>
                            <b-col md="4">
                                {{modalData.pr_months.pr_year}}
                            </b-col>
                            <b-col md="2">
                                <b>Month Name</b>
                            </b-col>
                            <b-col md="4">
                                {{modalData.pr_months.pr_month|months}}
                            </b-col>

                            <b-col md="2">
                                <b>Bill Status</b>
                            </b-col>
                            <b-col md="4">
                                {{modalData.bill_status.status_name}}
                            </b-col>
                            <b-col md="2">
                                <b>Bill Type</b>
                            </b-col>
                            <b-col md="4" style="color:red">
                                {{modalData.bill_type.bill_type_name}}
                            </b-col>
                            <b-col md="2">
                                <b>Curr. Basic Amount</b>
                            </b-col>
                            <b-col md="4">
                                {{modalData.curr_basic_amt}}
                            </b-col>
                            <b-col md="2">
                                <b>Arrear From Date</b>
                            </b-col>
                            <b-col md="4">
                                {{arrear_from_date}}
                            </b-col>
                            <b-col md="2">
                                <b>Arrear To Date</b>
                            </b-col>
                            <b-col md="4">
                                {{arrear_to_date}}
                            </b-col>
                            <b-col md="2">
                                <b>Total Arrear Days</b>
                            </b-col>
                            <b-col md="4">
                                {{modalData.total_arrear_days}}
                            </b-col>
                        </b-row>
                    </b-card-text>
                </b-card>

                <b-card>
                    <b-card-text>
                        <b-row>
                            <b-col md="3">
                                <b-form-group
                                    label="Government Order No"
                                    label-for="go_no"
                                    class="requiredField"
                                >
                                    <b-form-input required :disabled="modalData.bill_status_id > 0 || buttonShow == false" v-model.trim="$v.modalData.go_no.$model" id="go_no"></b-form-input>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.modalData.go_no.$error && !$v.modalData.go_no.required}">Government order number is required!</div>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Government Order Date"
                                    label-for="go_date"
                                    class="requiredField"
                                >
                                    <date-picker
                                        v-model.trim="$v.modalData.go_date.$model"
                                        width="100%"
                                        input-class="form-control"
                                        type="date"
                                        lang="en"
                                        name="go_date"
                                        :disabled="modalData.bill_status_id > 0 || buttonShow == false"
                                        id="go_date"
                                        :value-type="valueType"
                                        format="DD-MM-YYYY"
                                        required
                                        :editable="false">
                                    </date-picker>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.modalData.go_date.$error && !$v.modalData.go_date.required}">Government order date is required!</div>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Pay Advice No"
                                    label-for="pay_advice_no"
                                    class="requiredField"
                                >
                                    <b-form-input required :disabled="modalData.bill_status_id > 0 || buttonShow == false" v-model.trim="$v.modalData.pay_advice_no.$model" id="pay_advice_no"></b-form-input>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.modalData.pay_advice_no.$error && !$v.modalData.pay_advice_no.required}">Pay advice number is required!</div>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Pay Advice Date"
                                    label-for="pay_advice_date"
                                    class="requiredField"
                                >
                                    <date-picker
                                        v-model.trim="$v.modalData.pay_advice_date.$model"
                                        width="100%"
                                        input-class="form-control"
                                        type="date"
                                        required
                                        :disabled="modalData.bill_status_id > 0 || buttonShow == false"
                                        lang="en"
                                        name="pay_advice_date"
                                        id="pay_advice_date"
                                        :value-type="valueType"
                                        format="DD-MM-YYYY"
                                        :editable="false">
                                    </date-picker>
                                    <div :class="{'invalid-feedback':true ,'d-block':$v.modalData.pay_advice_date.$error && !$v.modalData.pay_advice_date.required}">Pay advice date is required!</div>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-card-text>
                </b-card>

                <b-card >
                    <b-card-text>
                        <b-row>
                            <b-col>
                                <b-row>
                                    <b-col>
                                        <b>Allowances: {{Number(allowances).toFixed(2)}}</b>
                                    </b-col>
                                    <b-col>
                                        <b>Allowances (Amendment): {{Number(allowancesAmendment).toFixed(2)}}</b>
                                        <b-button v-if="modalData.bill_status_id == 0 && buttonShow == true" variant="primary" @click="showAllowanceForm = showAllowanceForm?false:true" size="sm">{{allowanceAddButton}}</b-button>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col>
                                        <b-form v-if="showAllowanceForm" @submit.prevent="addAllowance">
                                            <b-row>
                                                <b-col >
                                                    <b-form-group
                                                        label="Salary Head"
                                                    >
                                                        <v-select
                                                            id="bill_head_id"
                                                            v-model="selectedBillHeadForAllowance"
                                                            label="salary_head"
                                                            :options="billHeadOptions.filter(a=> a.deduction_yn == 'N')">
                                                            <template #search="{attributes, events}">
                                                                <input class="vs__search" v-bind="attributes" v-on="events" />
                                                            </template>
                                                        </v-select>
                                                    </b-form-group>
                                                </b-col>
                                                <b-col>
                                                    <b-form-group
                                                        label="Amount"
                                                    >
                                                        <b-input-group prepend="৳">
                                                            <template #append>
                                                                <b-button v-if="modalData.paid_yn == 'N' && modalData.approved_yn == 'N'" type="submit" variant="success">Save</b-button>
                                                            </template>
                                                            <b-form-input class="text-right" v-model="allowanceFormData.amount" ></b-form-input>
                                                        </b-input-group>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                        </b-form>
                                    </b-col>
                                </b-row>

                                <b-row v-for="(detail, i) in modalData.details" :key="`${i}`">
                                    <b-col  md="6" v-if="detail.deduction_yn == 'N'">
                                        <label for="">{{detail.bill_head.salary_head}}</label>
                                        <a v-if="detail.addition_yn == 'Y' && modalData.approved_yn == 'N'" href="javascript:void(0)" class="text-danger" @click="deleteDetails(detail.bill_details_id)" role="button"><i class="bx bx-minus-circle"></i></a>
                                        <b-form-group>
                                            <b-form-input disabled class="text-right" v-model="detail.amount" ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col  md="6" v-if="detail.deduction_yn == 'N'">
                                        <b-form-group
                                            :label="detail.bill_head.salary_head+' AMENDMENT'"
                                        >
                                            <b-form-input :disabled="modalData.bill_status_id > 0 || buttonShow == false" class="text-right" v-model="detail.amount_amendment" ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </b-col>
                            <b-col class="border-left" v-if="modalData.employee.emp_status.value == 7">
                                <b-row>
                                    <b-col>
                                        <b>Deductions: {{Number(deductions).toFixed(2)}}</b>
                                    </b-col>
                                    <b-col>
                                        <b>Deductions (Amendment): {{Number(deductionsAmendment).toFixed(2)}}</b>
                                        <b-button v-if="modalData.bill_status_id == 0 && buttonShow == true" variant="primary" @click="showDeductionForm = showDeductionForm?false:true" size="sm">{{deductionAddButton}}</b-button>
                                    </b-col>
                                </b-row>
                                <b-form v-if="showDeductionForm" @submit.prevent="addDeduction">
                                    <b-row >
                                        <b-col>
                                            <b-form-group
                                                label="Salary Head"
                                            >
                                                <v-select
                                                    v-model="selectedBillHeadForDeduction"
                                                    label="salary_head"
                                                    :options="billHeadOptions.filter(a=> a.deduction_yn == 'Y')">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events" />
                                                    </template>
                                                </v-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col>
                                            <b-form-group
                                                label="Amount"
                                            >
                                                <b-input-group prepend="৳">
                                                    <template #append>
                                                        <b-button v-if="modalData.paid_yn == 'N' && modalData.approved_yn == 'N'" type="submit" variant="success">Save</b-button>
                                                    </template>
                                                    <b-form-input :disabled="modalData.bill_status_id > 0" class="text-right" v-model="deductionFormData.amount" ></b-form-input>
                                                </b-input-group>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </b-form>

                                <b-row v-for="(detail, i) in modalData.details" :key="`${i}`">
                                    <b-col  md="6" v-if="detail.deduction_yn == 'Y'">
                                        <label for="">{{detail.bill_head.salary_head}}</label>
                                        <a v-if="detail.addition_yn == 'Y' && modalData.approved_yn == 'N'" href="javascript:void(0)" class="text-danger" @click="deleteDetails(detail.bill_details_id)" role="button"><i class="bx bx-minus-circle"></i></a>
                                        <b-form-group
                                        >
                                            <b-form-input disabled class="text-right" v-model="detail.amount" ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col  md="6" v-if="detail.deduction_yn == 'Y'">
                                        <b-form-group
                                            :label="detail.bill_head.salary_head+' AMENDMENT'"
                                        >
                                            <b-form-input :disabled="modalData.bill_status_id > 0 || buttonShow == false" class="text-right" v-model="detail.amount_amendment" ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </b-col>
                        </b-row>
                        <hr>
                        <b-row>
                            <b-col>
                                <b-form-group
                                    label="Remarks"
                                    label-for="remarks"
                                >
                                    <b-form-textarea :disabled="modalData.bill_status_id > 0 || buttonShow == false" v-model="modalData.remarks" id="remarks"></b-form-textarea>
                                </b-form-group>
                            </b-col>
                        </b-row>

                    </b-card-text>
                </b-card>
                <template #modal-footer="{ ok, cancel }">

                    <b-row class="w-100">
                        <b-col md="9" class="text-right">
                            <p style="line-height: 0.5rem">Total Arrear bill Amount: <i style="color:red">{{Number(modalData.total_amount).toFixed(2)}}</i> </p>
                            <p style="line-height: 0.5rem">Total Arrear bill Amount Amendment:  <i style="color:red">{{Number(modalData.total_amount_amendment).toFixed(2)}}</i></p>
                        </b-col>
                        <b-col md="3" class="text-right">
                            <b-button variant="danger" @click="cancel()">Cancel</b-button>
                            <b-button type="submit" variant="success" v-if="modalData.bill_status_id == 0 && buttonShow" @click="ok()">Update</b-button>
                        </b-col>
                    </b-row>


                </template>
            </b-modal>
            <Approval
                :title="approveFormData.title"
                :group_id="approveFormData.group_id"
                :module_name_url="approveFormData.module_name_url"
                :item="approveFormData.item"
                :id="approveFormData.id"
                :showModal.sync="approveFormData.showModal"
                :datatable="onSearch"
            >
            </Approval>
        </div>
    </div>
</template>

<script>
    import ApiRepository from "../../../Repository/ApiRepository";
    import Datatable from '../../../layouts/common/datatable';
    import moment from "moment";
    import vSelect from 'vue-select'
    import vcss from 'vue-select/dist/vue-select.css';
    import DatePicker from "vue2-datepicker";
    import Approval from "../../../layouts/common/Approval";
    import {validationMixin} from "vuelidate"
    const { required, requiredIf, maxLength, minLength, email } = require("vuelidate/lib/validators");
    export default {
        name: "ArrearBillSettlement",
        components: {vSelect, vcss, DatePicker, Datatable, Approval},
        data() {
            return {
                buttonShow: false,
                boxTwo: '',
                valueType: this.dateFormatter(),
                allowanceAddButton: 'Add',
                deductionAddButton: 'Add',
                showAllowanceForm: false,
                showDeductionForm: false,
                allowances: 0,
                allowancesAmendment: 0,
                deductions: 0,
                deductionsAmendment: 0,
                fiscalYearOptions: [],
                billCodeOptions: [],
                fiscalMonthOptions: [],
                employeeOptions: [],
                billHeadOptions: [],
                selectedEmployee: {},
                selectedBillHeadForAllowance: {
                    bill_head_id: '',
                    bill_head_name: '',
                    coa_code: '',
                    deduction_yn: '',
                    salary_head: ''
                },
                selectedBillHeadForDeduction: {
                    bill_head_id: '',
                    bill_head_name: '',
                    coa_code: '',
                    deduction_yn: '',
                    salary_head: ''
                },
                searchParams: {
                    fiscalYear: '',
                    pr_month: '',
                    bill_code: '',
                    emp_id: ''
                },
                approveFormData: {
                    title: "",
                    group_id: "",
                    module_name_url: "",
                    item: "",
                    id: "",
                    showModal: false
                },
                allowanceFormData: {
                    bill_details_id: '',
                    bill_master_id: '',
                    bill_head_id: '',
                    line_status_yn: 'Y',
                    line_description: '',
                    coa_code: '',
                    amount: '',
                    deduction_yn: '',
                    deduction: '',
                    active_yn: 'Y',
                    remarks: ''
                },
                deductionFormData: {
                    bill_details_id: '',
                    bill_master_id: '',
                    bill_head_id: '',
                    line_status_yn: 'Y',
                    line_description: '',
                    coa_code: '',
                    amount: '',
                    deduction_yn: '',
                    deduction: '',
                    active_yn: 'Y',
                    remarks: ''
                },
                modalData: {
                    total_amount: '',
                    total_amount_amendment: '',
                    emp_code: '',
                    emp_name: '',
                    bill_master_id: '',
                    bill_no: '',
                    bill_description: '',
                    pr_month_id: '',
                    go_no: '',
                    go_date: '',
                    bill_date: '',
                    bill_type_id: '',
                    bill_code: '',
                    curr_basic_amt: '',
                    arrear_from_date: '',
                    arrear_to_date: '',
                    total_arrear_days: '',
                    details: [],
                    employee: {
                        emp_status_id: '',
                        emp_status: {
                            text: "",
                            value: 0
                        },
                        designation: {},
                        section: {
                            dpt_section: '',
                            dpt_section_bng: '',
                            dpt_section_id: '',
                            text: ''
                        },
                        dpt_division: {},
                        department: {}
                    },
                    pr_months: {},
                    bill_type: {
                        bill_type_name: ''
                    },
                    emp_id: '',
                    dpt_division_id: '',
                    division_name: '',
                    department_id: '',
                    department_name: '',
                    designation_name: '',
                    bill_status: {
                        status_name: ''
                    },
                    bill_status_id: 0,
                    master_active_yn: 'Y',
                    deputation_yn: 'Y',
                    remarks: '',
                    pay_advice_no: '',
                    pay_advice_date: '',
                    paid_yn: '',
                    approved_yn: '',
                    fy_id: '',
                    pr_month: '',
                    bill_details_id: '',
                    bill_head_id: '',
                    line_status_yn: '',
                    line_description: '',
                    coa_code: '',
                    amount: '',
                    deduction_yn: '',
                    deduction: '',
                    details_active_yn: 'Y',
                    details_remarks: '',
                },
                items: [],
                fields: [
                    {key: 'index', label: 'Sl'},
                    {key: 'employee.emp_code', label: 'Employee Code'},
                    {key: 'employee.emp_name', label: 'Employee Name'},
                    {key: 'bill_no', label: 'Bill No'},
                    {key: 'bill_code', label: 'Bill Code'},
                    {
                        key: 'total_amount',
                        label: 'Arr. Bill Amount',
                        formatter: value => {
                            if (value){
                                return  Number(value).toFixed(2)
                            } else {
                                return ''
                            }
                        },
                        class:'text-right'
                    },
                    {
                        key: 'total_amount_amendment',
                        label: 'Arr. Bill Amount Amendment.',
                        formatter: value => {
                            if (value){
                                return  Number(value).toFixed(2)
                            } else {
                                return ''
                            }
                        },
                        class:'text-right'
                    },
                    {
                        key: 'update_date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        label: 'Modification Date'
                    },
                    {key: 'bill_status.status_name', label: 'Status'},

                    {key: 'action', class: 'text-center'}
                ],
                totalLength: 1,
                perPage: 5
            }
        },
        mixins: [validationMixin],
        validations: {
            modalData: {
                go_date: {required},
                go_no: {required},
                pay_advice_date: {required},
                pay_advice_no: {required}
            }
        },
        mounted() {
            this.billHeadList()
            this.getFiscalYears()
            this.hasUpdatePermission()
        },
        watch: {
            selectedEmployee: function (val, oldVAl) {
                if(val) {
                    this.searchParams.emp_id = val.emp_id
                } else {
                    this.searchParams.emp_id = ""
                }
            },
            'approveFormData.showModal':function(val, oldVal) {
                if(val === 'false') {
                    this.onSearch()
                }
            },
            showAllowanceForm: function (val, oldVal) {
                if(val == true){
                    this.allowanceAddButton = 'Hide'
                } else {
                    this.allowanceAddButton = 'Add'
                }
            },
            showDeductionForm: function (val, oldVal) {
                if(val == true){
                    this.deductionAddButton = 'Hide'
                } else {
                    this.deductionAddButton = 'Add'
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
            },
            selectedBillHeadForDeduction: function (val, oldVal) {
                if(val) {
                    this.deductionFormData.bill_head_id = val.bill_head_id
                    this.deductionFormData.coa_code = val.coa_code
                    this.deductionFormData.deduction = val.deduction
                    this.deductionFormData.deduction_yn = val.deduction_yn
                } else  {
                    this.deductionFormData.bill_head_id = ''
                    this.deductionFormData.coa_code = ''
                    this.deductionFormData.deduction = ''
                    this.deductionFormData.deduction_yn = ''
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
            deputation: function (value) {
                if(value == 'Y'){
                    return 'YES'
                } else if(value == 'N') {
                    return 'NO'
                } else {
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
            arrear_from_date(){
                if(this.modalData.arrear_from_date) {
                    return moment(this.modalData.arrear_from_date).format('DD-MM-YYYY');
                }
            },
            arrear_to_date(){
                if(this.modalData.arrear_to_date) {
                    return moment(this.modalData.arrear_to_date).format('DD-MM-YYYY');
                }
            }
        },
        methods: {
            onSearch() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND,`/payroll/arrear-details-list-settlement`, this.searchParams).then( res => {
                    if (res.data.length > 0){
                        this.items = res.data
                        this.totalLength = res.data.length
                    } else {
                        this.items = []
                        this.totalLength = 1
                    }
                })
            },
            deleteDetails(id) {
                this.$bvModal.msgBoxConfirm('Please confirm that you want to delete', {
                    title: 'Please Confirm',
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'danger',
                    okTitle: 'YES',
                    cancelTitle: 'NO',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                })
                    .then(value => {
                        if(value == true) {
                            ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/payroll/delete-bill-details/${id}`).then( res => {
                                if (res.data.o_status_code == 1) {
                                    this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                                    ApiRepository.callApi(ApiRepository.POST_COMMAND,`/payroll/arrear-details-list-settlement`, this.searchParams).then( res => {
                                        if (res.data.length > 0){
                                            this.items = res.data
                                            this.totalLength = res.data.length
                                            this.modalData.total_amount = this.items.filter(a=>a.bill_master_id == this.modalData.bill_master_id)[0].total_amount
                                            this.modalData.total_amount_amendment = this.items.filter(a=>a.bill_master_id == this.modalData.bill_master_id)[0].total_amount_amendment
                                            this.modalData.details = this.items.filter(a=>a.bill_master_id == this.modalData.bill_master_id)[0].details
                                            this.allowanceFormData.amount = ''
                                            this.selectedBillHeadForAllowance = {
                                                bill_head_id: '',
                                                bill_head_name: '',
                                                coa_code: '',
                                                deduction_yn: '',
                                                salary_head: ''
                                            }
                                            this.showAllowanceForm = false
                                            this.deductionAllowanceCalculation()
                                        } else {
                                            this.items = []
                                            this.totalLength = 1
                                        }
                                    })
                                } else {
                                    this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                                }
                            })
                        }
                    })
                    .catch(err => {
                        // An error occurred
                    })
            },
            updateDetails() {
                this.$v.$touch()
                this.$v.modalData.$touch()
                if(!this.$v.modalData.$invalid){
                    ApiRepository.callApi(ApiRepository.PUT_COMMAND,`/payroll/update-bill-details`, this.modalData).then( res => {
                        if (res.data.o_status_code == 1) {
                            this.$refs['detailsModal'].hide()
                            this.$v.$reset()
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                            ApiRepository.callApi(ApiRepository.POST_COMMAND,`/payroll/arrear-details-list-settlement`, this.searchParams).then( res => {
                                if (res.data.length > 0){
                                    this.items = res.data
                                    this.totalLength = res.data.length
                                    this.modalData.total_amount = this.items.filter(a=>a.bill_master_id == this.modalData.bill_master_id)[0].total_amount
                                    this.modalData.total_amount_amendment = this.items.filter(a=>a.bill_master_id == this.modalData.bill_master_id)[0].total_amount_amendment
                                    this.modalData.go_no = this.items.filter(a=>a.bill_master_id == this.modalData.bill_master_id)[0].go_no
                                    this.modalData.go_date = this.items.filter(a=>a.bill_master_id == this.modalData.bill_master_id)[0].go_date
                                    this.modalData.pay_advice_no = this.items.filter(a=>a.bill_master_id == this.modalData.bill_master_id)[0].pay_advice_no
                                    this.modalData.pay_advice_date = this.items.filter(a=>a.bill_master_id == this.modalData.bill_master_id)[0].pay_advice_date
                                    this.modalData.details = this.items.filter(a=>a.bill_master_id == this.modalData.bill_master_id)[0].details
                                    this.allowanceFormData.amount = ''
                                    this.selectedBillHeadForAllowance = {
                                        bill_head_id: '',
                                        bill_head_name: '',
                                        coa_code: '',
                                        deduction_yn: '',
                                        salary_head: ''
                                    }
                                    this.showAllowanceForm = false
                                    this.deductionAllowanceCalculation()
                                } else {
                                    this.items = []
                                    this.totalLength = 1
                                }
                            })
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                        }

                    })
                }

            },
            addAllowance(){
                ApiRepository.callApi(ApiRepository.POST_COMMAND,`/payroll/add-bill-details`, this.allowanceFormData).then( res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                        ApiRepository.callApi(ApiRepository.POST_COMMAND,`/payroll/arrear-details-list-settlement`, this.searchParams).then( res => {
                            if (res.data.length > 0){
                                this.items = res.data
                                this.totalLength = res.data.length
                                this.modalData.total_amount = this.items.filter(a=>a.bill_master_id == this.modalData.bill_master_id)[0].total_amount
                                this.modalData.total_amount_amendment = this.items.filter(a=>a.bill_master_id == this.modalData.bill_master_id)[0].total_amount_amendment
                                this.modalData.details = this.items.filter(a=>a.bill_master_id == this.modalData.bill_master_id)[0].details
                                this.allowanceFormData.amount = ''
                                this.selectedBillHeadForAllowance = {
                                    bill_head_id: '',
                                    bill_head_name: '',
                                    coa_code: '',
                                    deduction_yn: '',
                                    salary_head: ''
                                }
                                this.showAllowanceForm = false
                                this.deductionAllowanceCalculation()
                            } else {
                                this.items = []
                                this.totalLength = 1
                            }
                        })
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                    }

                })
            },
            addDeduction(){
                ApiRepository.callApi(ApiRepository.POST_COMMAND,`/payroll/add-bill-details`, this.deductionFormData).then( res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                        ApiRepository.callApi(ApiRepository.POST_COMMAND,`/payroll/arrear-details-list-settlement`, this.searchParams).then( res => {
                            if (res.data.length > 0){
                                this.items = res.data
                                this.totalLength = res.data.length
                                this.modalData.total_amount = this.items.filter(a=>a.bill_master_id == this.modalData.bill_master_id)[0].total_amount
                                this.modalData.total_amount_amendment = this.items.filter(a=>a.bill_master_id == this.modalData.bill_master_id)[0].total_amount_amendment
                                this.modalData.details = this.items.filter(a=>a.bill_master_id == this.modalData.bill_master_id)[0].details
                                this.deductionFormData.amount = ''
                                this.selectedBillHeadForDeduction = {
                                    bill_head_id: '',
                                    bill_head_name: '',
                                    coa_code: '',
                                    deduction_yn: '',
                                    salary_head: ''
                                }
                                this.showDeductionForm = false
                                this.deductionAllowanceCalculation()
                            } else {
                                this.items = []
                                this.totalLength = 1
                            }
                        })
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                    }
                })
            },
            hasUpdatePermission() {
                this.buttonShow = this.$store.getters.hasGrantAccess || this.$store.getters.permissions.includes('CAN_UPDATE_ARREAR_BILL_STATEMENT') ? true : false
            },
            getFiscalYears(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/payroll/get-fiscal-years`).then( res => {
                    this.fiscalYearOptions = res.data
                    let that = this;
                    this.fiscalYearOptions.forEach(function(item) {
                        if (item.current_yn == 'Y') {
                            that.searchParams.fiscalYear = item.fy_id;
                            that.getPrMonths();
                        }
                    });
                })
            },
            getPrMonths(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/payroll/get-pr-months/${this.searchParams.fiscalYear}`).then( res => {
                    this.fiscalMonthOptions = res.data;
                    let that = this;
                    this.fiscalMonthOptions.forEach(function(month) {
                        if (month.text == moment().format("MMMM")) {
                            that.searchParams.pr_month = month.value;
                            that.getBillCodes();
                        }
                    });
                })
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

            },
            getBillCodes() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/get-bill-codes/${this.searchParams.pr_month}`).then(res => {
                    this.billCodeOptions = res.data;
                });
            },
            searchEmployee(name){
                if (name) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/search-employee/${name}`).then(res => {
                        this.employeeOptions = res.data;
                    })
                }
            },
            showApprovalModal(item) {
                this.approveFormData = {
                    title: "Arrear bill settlement approval process",
                    group_id: item.bill_type.approval_workflow_id,
                    module_name_url: "arrear-bill",
                    item: item,
                    id: item.bill_master_id,
                    showModal: true
                }
            },
            renderModal(item){
                this.$refs['detailsModal'].show()
                this.modalData = {
                    paid_yn: item.paid_yn,
                    approved_yn: item.approved_yn,
                    active_yn: item.active_yn,
                    total_amount: item.total_amount,
                    total_amount_amendment: item.total_amount_amendment,
                    bill_master_id: item.bill_master_id,
                    bill_no: item.bill_no,
                    bill_description: item.bill_description,
                    pr_month_id: item.pr_month_id,
                    go_no: item.go_no,
                    go_date: item.go_date,
                    bill_date: item.bill_date,
                    bill_type_id: item.bill_type_id,
                    bill_code: item.bill_code,
                    curr_basic_amt: item.curr_basic_amt,
                    arrear_from_date: item.arrear_from_date,
                    arrear_to_date: item.arrear_to_date,
                    total_arrear_days: item.total_arrear_days,
                    details: item.details,
                    employee: {
                        deputation_yn: item.employee.deputation_yn,
                        emp_code: item.employee.emp_code,
                        emp_name: item.employee.emp_name,
                        emp_status_id: item.employee.emp_status_id,
                        emp_status: {
                            text: item.employee.emp_status.text,
                            value: item.employee.emp_status.value
                        },
                        designation: item.employee.designation,
                        section: {
                            dpt_section: item.employee.section ? item.employee.section.dpt_section: '',
                            dpt_section_bng: item.employee.section ? item.employee.section.dpt_section_bng: '',
                            dpt_section_id: item.employee.section ? item.employee.section.dpt_section_id: '',
                            text: item.employee.section ? item.employee.section.text: ''
                        },
                        dpt_division: item.employee.dpt_division,
                        department: item.employee.department
                    },
                    pr_months: item.pr_months,
                    bill_type: {
                        bill_type_name: item.bill_type.bill_type_name
                    },
                    emp_id: item.emp_id,
                    emp_code: item.emp_code,
                    dpt_division_id: item.dpt_division_id,
                    division_name: item.division_name,
                    department_id: item.department_id,
                    department_name: item.department_name,
                    designation_name: item.designation_name,
                    bill_status: {
                        status_name: item.bill_status.status_name
                    },
                    bill_status_id: item.bill_status_id,
                    deputation_yn: item.deputation_yn,
                    remarks: item.remarks,
                    pay_advice_no: item.pay_advice_no,
                    pay_advice_date: item.pay_advice_date,
                    fy_id: item.fy_id,
                    pr_month: item.pr_month,
                    bill_details_id: item.bill_details_id,
                    bill_head_id: item.bill_head_id,
                    line_status_yn: item.line_status_yn,
                    line_description: item.line_description,
                    coa_code: item.coa_code,
                    amount: item.amount,
                    deduction_yn: item.deduction_yn,
                    deduction: item.deduction,
                }
                this.allowanceFormData = {
                    bill_details_id: '',
                    bill_master_id: item.bill_master_id,
                    bill_head_id: '',
                    line_status_yn: 'Y',
                    line_description: '',
                    coa_code: '',
                    amount: '',
                    deduction_yn: '',
                    deduction: '',
                    active_yn: 'Y',
                    remarks: ''
                }
                this.deductionFormData = {
                    bill_details_id: '',
                    bill_master_id: item.bill_master_id,
                    bill_head_id: '',
                    line_status_yn: 'Y',
                    line_description: '',
                    coa_code: '',
                    amount: '',
                    deduction_yn: '',
                    deduction: '',
                    active_yn: 'Y',
                    remarks: ''
                }
                this.deductionAllowanceCalculation()

            },
            billHeadList() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/bill-head-list`).then(res => {
                    this.billHeadOptions = res.data;
                })
            },
            onInputBillHead(data, index) {
                this.modalData.details[index].bill_head_id = data.salary_head_id
                this.modalData.details[index].coa_code = data.coa_code
                this.modalData.details[index].deduction_yn = data.deduction_yn
            },
            deductionAllowanceCalculation(){
                this.deductions = 0
                this.deductionsAmendment = 0
                this.allowances = 0
                this.allowancesAmendment = 0
                let object = this
                this.modalData.details.forEach(function (item, index) {
                    if(item.deduction_yn == 'Y'){
                        object.deductions = Number(object.deductions) + Number(item.amount)
                        object.deductionsAmendment = Number(object.deductionsAmendment) + Number(item.amount_amendment)
                    } else {
                        object.allowances = Number(object.allowances) + Number(item.amount)
                        object.allowancesAmendment = Number(object.allowancesAmendment) + Number(item.amount_amendment)
                    }
                })
            }
        }
    }
</script>

<style scoped>
    select.form-control[multiple], select.form-control[size], textarea.form-control {
        height:2.6rem;
    }

    legend{
        font-size: 1rem;
    }
    a {
        color: #444;
    }
    .form-control.is-invalid, .was-validated .form-control:valid{
        background-image: url()!important;
    }
    .form-control.is-valid, .was-validated .form-control:valid{
        background-image: url()!important;
    }
    select.form-control[multiple][data-v-397e62f8], select.form-control[size][data-v-397e62f8], .forSmall.form-control[data-v-397e62f8] {
        height: 2.05rem;
    }
</style>
