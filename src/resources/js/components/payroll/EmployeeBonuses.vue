<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Employee Bonus</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>
                            <b-col md="3">
                                <b-form-group
                                        label="Fiscal Years"
                                        class="requiredField"
                                        label-for="Fiscal_Years">
                                    <b-form-select
                                            v-model="process.fiscalYear"
                                            :options="fiscalYearOptions"
                                            class=""
                                            value-field="value"
                                            text-field="text"
                                            disabled-field="notEnabled" name="fiscalYear"
                                            required v-validate="'required'"
                                            data-vv-scope="search"
                                            @change="getMonths">
                                        <template v-slot:first>
                                            <option value="">-- Please select an option --
                                            </option>
                                        </template>
                                    </b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                        label="Month"
                                        class="requiredField"
                                        label-for="Month">
                                    <b-form-select v-model="process.pr_month"
                                                    name="pr_month" required
                                                    v-validate="'required'"
                                                    :options="fiscal_months" value-field="value"
                                                    text-field="text"
                                                    data-vv-scope="creationForm" @change="getBillCodes">
                                        <template v-slot:first>
                                            <option value="">-- Please select an option --
                                            </option>
                                        </template>
                                    </b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Bonus Head"
                                    class="requiredField"
                                    label-for="bonus_head">
                                    <b-form-select v-model="process.bonus_head" :options="bonusHeads" name="bonus_head" text-field="salary_head" value-field="salary_head_id" v-validate="'required'"></b-form-select>
                                </b-form-group>
                                <span :style="errorMessage">{{ errors.first('bonus_head') }}</span>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                        label="Bill Code"
                                        class="requiredField"
                                        label-for="bill_code">
                                    <v-select v-model="process.bill_code" :options="billCodes" label="bill_code"  :disabled="!process.pr_month" required>
                                        <template #search="{attributes, events}">
                                            <input class="vs__search"
                                                    :required="!process.bill_code"
                                                    v-bind="attributes"
                                                    v-on="events"/>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="text-right">
                                <b-button type="submit" variant="dark">Search</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                    <b-modal v-model="show" size="xl"
                                ref="modal"
                                @show="resetModal"
                                @hidden="resetModal"
                                @ok="handleOk"
                                hide-header
                                okTitle="Update"
                                cancelTitle="Close"
                                :hide-footer="!canHasPermission()">
                        <b-row>
                            <b-col>
                                <h4>Bonus Information</h4>
                            </b-col>
                            <b-col class="d-flex justify-content-end">
                                <b-button size="sm" variant="outline-secondary" @click="hide()">Close</b-button>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                        label="Employee name"
                                        label-for="name-input">
                                    <label>{{bonus.emp_name}}</label>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                        label="Designation"
                                        label-for="name-input">
                                    <label>{{bonus.designation.designation}}</label>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                        label="Net Bonus pay"
                                        label-for="name-input">
                                    <label><strong>{{bonus.formatted_bonus}}</strong></label>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <hr class="mt-0"/>
                        <b-row>
                            <b-col md="6" class="allowance-col">
                                <b-row>
                                    <b-col md="6" v-if="bonusesHead.bonuses"
                                           v-for="bonus in bonusesHead.bonuses"
                                           :key="bonus.pr_process_id">
                                        <div class="mt-1">
                                            <label>{{bonus.salary_head}}
                                            </label>
                                            <b-input-group>
                                                <template v-slot:append
                                                          v-if="bonus.editable_yn == 'Y' && bonus.every_month_yn == 'N'">
                                                    <button type="button" v-if="false"
                                                            @click="updateBonus(bonus)"
                                                            class="btn btn-dark btn-sm"><strong
                                                        class="text-white">Update</strong>
                                                    </button>
                                                </template>
                                                <b-form-input class="text-right" v-if="bonus.editable_yn == 'Y' && canHasPermission()" readonly
                                                              v-model="bonus.amount" ></b-form-input>
                                                <b-form-input class="text-right" v-else v-model="bonus.amount"
                                                              readonly></b-form-input>
                                            </b-input-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6">
                                        <div class="mt-1">
                                            <label>Remarks</label>
                                            <b-input-group>
                                                <b-form-input  v-model="bonus.remarks" v-if="bonus.editable_yn == 'Y' && canHasPermission()" name="remarks" id="remarks"></b-form-input>
                                                <b-form-input  v-model="bonus.remarks" v-else name="remarks" id="remarks" readonly></b-form-input>
                                            </b-input-group>
                                        </div>
                                    </b-col>
                                </b-row>
                            </b-col>
                        </b-row>
                    </b-modal>

                    <b-modal id="modal-center" :centered="true" title="Please Confirm" size="sm"
                                buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"
                                :hideHeaderClose="false"
                                @ok="deleteHead">
                        <div>Are you want to delete?</div>
                    </b-modal>

                    <b-modal v-model="statusModalShow" size="xl"
                                ref="modal"
                                :hide-footer=true
                                :hide-header=true>
                        <b-row>
                            <b-col>
                                <h4>{{currentBillState.salary_head+' STATUS FOR BILL CODE : '+process.bill_code}}</h4>
                            </b-col>
                            <b-col class="d-flex justify-content-end">
                                <b-button size="sm" variant="outline-secondary" @click="statusModalhide()">Close</b-button>
                            </b-col>
                        </b-row>
                        <b-row class="mt-2">
                            <b-col>
                                <bill-status v-if="process.bill_code" @current-status="setCurrentState" :process="process" ></bill-status>
                            </b-col>
                        </b-row>
                    </b-modal>

                    <div v-if="report == 'grid' && isProcessDone" >
                        <b-row class="p-1">
                            <b-col>
                                <div v-if="currentBillState" class="alert alert-dismissible alert-info">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h4 class="alert-heading">{{currentBillState.status_name}}</h4>
                                        <h4 class="alert-heading">{{currentBillState.salary_head}}</h4>
                                        <small>By {{currentBillState.emp_name}}</small>
                                        <small>{{currentBillState.designation}}</small>
                                        <small><span class="badge badge-pill badge-secondary">{{currentBillState.pbs_insert_date|dateFormat}}</span></small>
                                    </div>
                                    <div class="mb-1">{{currentBillState.note}}</div>
                                    <div>
                                        <b-button v-if="dataLength > 0"  variant="primary" @click="statusModalShow = true">
                                            <i class='bx bxs-wrench'></i> Bill Status
                                        </b-button>
                                        <b-button v-if="dataLength > 0" variant="success" @click="emp_bonus()" >
                                            <i class='bx bxs-report'></i> Employee Bonuses
                                        </b-button>



<!--                                        <b-button variant="success" @click="billCompare()" >-->
<!--                                            <i class='bx bxs-report'></i> Bill Compare With Last Month-->
<!--                                        </b-button>-->
                                        <b-button v-if="isBillDisburse()" variant="dark" @click="bonus_payslip()" >
                                            <i class='bx bxs-report'></i> Bonus payslip
                                        </b-button>

<!--                                        <b-button v-if="isBillDisburse()" variant="warning" @click="bankAdvise()" >-->
                                        <b-button  variant="warning" @click="bankAdvise()" >
                                            <i class='bx bxs-report'></i> Print Bank Advise
                                        </b-button>

                                    </div>
                                    <b-form id="emp_bonus_form" target="_blank" :action="'/report/render/Employee_Monthly_Bonus'" method="post">
                                        <input type="hidden" :value="process.bill_code" name="p_bill_code" />
                                        <input type="hidden" :value="process.pr_month" name="p_pr_month_id" />
                                        <input type="hidden" :value="process.bonus_head" name="p_salary_head_id" />
                                        <input type="hidden" value="/~weblogic/Payroll/RPT_MONTHLY_BONUS_REPORT.xdo" name="xdo" />
                                        <input type="hidden" value="pdf" name="type" />
                                        <input type="hidden" name="_token" v-model="csrf" />
                                    </b-form>
                                    <b-form id="bankadvise_form" target="_blank" :action="'/report/render/Employee_Festival_Report'" method="post">
                                        <input type="hidden" :value="process.bill_code" name="p_bill_code" />
                                        <input type="hidden" :value="process.fiscalYear" name="p_pr_year" />
                                        <input type="hidden" :value="process.emp_code" name="p_emp_code" />
                                        <input type="hidden" :value="process.bonus_head" name="p_bonus_id" />
                                        <input type="hidden" value="/~weblogic/Payroll/Festival_Bonus.xdo" name="xdo" />
                                        <input type="hidden" :value="report.report_id" name="rid" />
                                        <input type="hidden" :value="report.report_name" name="PAY_SLIP"/>
                                        <input type="hidden" value="pdf" name="type" />
                                        <input type="hidden" name="_token" v-model="csrf" />
                                    </b-form>
                                    <b-form id="bonus_payslip_form" target="_blank" :action="'/report/render/Employee_Festival_Report'" method="post">
                                        <input type="hidden" :value="process.bill_code" name="bill_code" />
                                        <input type="hidden" :value="process.pr_month" name="pr_month" />
                                        <input type="hidden" :value="process.emp_code" name="emp_code" />
                                        <input type="hidden" value="/~weblogic/Payroll/RPT_Emp_pay_slip_bonus.xdo" name="xdo" />
                                        <input type="hidden" value="pdf" name="type" />
                                        <input type="hidden" name="_token" v-model="csrf" />
                                    </b-form>
                                </div>
                                <div v-else class="alert alert-dismissible alert-warning">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h4 class="alert-heading">Status!</h4>
                                    </div>
                                    <p class="mb-0">Bill not yet process</p>
                                </div>
                            </b-col>
                        </b-row>
                        <data-table
                          class="table-default"
                          :columns="columns"
                          :url="dataUrl"
                          :classes='classess'
                          :filterabe=true
                        >
                        </data-table>

                    </div>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>

    import ApiRepository from "../../Repository/ApiRepository";
    import EditButton from '../datatable/button/Button';
    import vSelect from 'vue-select'
    import billStatus from './BonusStatus';
    import moment from 'moment';

    export default {
        props: ['id'],
        components: {vSelect,billStatus},
        data() {
            return {
                dataLength: null,
                dataUrl: '',
                statusModalShow : false,
                report: 'grid',
                reportParams: {
                    xdo: '/~weblogic/Payroll/Dep_Bill_Wise_Payroll_Report.xdo', //Bill code instead of biller code.
                    bill_code: '',
                    p_month_id: '',
                    pr_year:'',
                    filename: 'Employee salaries'
                },
                reportPaySlip: {
                    xdo: '/~weblogic/Payroll/Emp_pay_slip.xdo',
                    type: "pdf",
                    bill_code: 81, //Bill code instead of biller code.
                    pr_month: '',
                    pr_year:'',
                    emp_code:"",
                    filename: 'Payroll_Salary'
                },
                reportUrl: '',
                excelUrl:'',
                isProcessDone: false,
                allowance_adding_show: false,
                deduction_adding_show: false,
                selectedHead: {},
                allowance: {},
                bonuses: [],
                deduction: {},
                deductions: [],
                process: {fiscalYear: '', pr_month: '',bonus_head:'', bill_code: '', emp_code:''},
                amt: 0,
                errorMessage: {},
                salaryProcess: {'designation': ''},
                bonus: {'designation': '',
                        'remarks':''},
                bonusesHead: [],
                bonusHeads:[],
                show: false,
                submitBtn: 'Save',
                totalRows: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
                staticFiscalYear: null,
                staticFiscalYearName: '',
                fiscalYearOptions: [],
                fiscal_months: [],
                fiscalYear: null,
                employeeList: [],
                salaryHeadList: [],
                billCodes: [], //Bill code instead of biller code.
                records: [],
                reportedOfficers: [],
                csrf:'',
                items: [],
                infoModal: {
                    id: 'info-modal',
                    title: '',
                    content: ''
                },
                columns: [
                    {
                        label: '#SL',
                        name: 'rn',
                        filterable: false,
                    },
                    {
                        label: 'Employee code',
                        name: 'emp_code',
                        filterable: true,
                    },
                    {
                        label: 'Employee Name',
                        name: 'emp_name',
                        filterable: true,
                    },
                    {
                        label: 'Designation',
                        name: 'designation.designation',
                        filterable: false,
                    },
                    {
                        label: 'Net Bonus',
                        name: 'formatted_bonus',
                        filterable: false,
                    },
                    {
                        label: '',
                        name: 'Details',
                        filterable: false,
                        classes: {
                            'btn': true,
                            'btn-primary': true,
                            'btn-sm': true,
                        },
                        event: "click",
                        handler: this.editRow,
                        component: EditButton,
                    }
                ],
                classess: {
                    "table-container": {
                        "table-responsive": true,
                    },
                    "table": {
                        "table": true,
                        "table-striped": true,
                        "table-dark": false,
                    },
                    "t-head": {},
                    "t-body": {},
                    "t-head-tr": {},
                    "t-body-tr": {},
                    "td": {},
                    "th": {},
                },
                statusItems: [],
                statusItemsTotal:0,
                currentBillState: {},
                statusColumns:
                    [
                        {
                            label: 'SL',
                            key: 'sl'
                        }
                    ]

            }
        },

        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Payroll"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Bonus"});
            this.csrf = axios.defaults.headers.common['X-CSRF-TOKEN'];
            this.totalRows = this.items.length;
            this.onReset();
            this.load();
            this.allBonusHeads();
        },
        filters: {
            dateFormat: function(value) {
                if (value) {
                    return moment(String(value)).format('DD/MM/YYYY hh:mm')
                }
            },

        },
        watch: {
            dataUrl:function(url) {
                console.log('url', url)
            },
        },
        methods: {
            editRow(data) {
                this.bonus = data;
                console.log('data',data);
                this.allowance_adding_show = false;
                this.deduction_adding_show = false;
                let url = '/payroll/bonus-heads';
                ApiRepository.callApi(ApiRepository.POST_COMMAND, url, data).then(res => {
                    console.log('res.data',res.data);
                    this.bonusesHead = res.data;
                    this.show = true;
                });
            },

                renderPaySlip:function(data){
                this.reportPaySlip.bill_code = data.bill_code; //Bill code instead of biller code.
                this.reportPaySlip.pr_year = data.fiscalYear;
                this.reportPaySlip.pr_month = data.pr_month;
                this.reportPaySlip.type='pdf';
                let params = this.reportPaySlip;
                let queryString = Object.keys(params).map(function (key) {
                    return key + "=" + params[key]
                }).join('&');
                return '/report/render?' + queryString;
            },
            hasEmpId: function () {
                return ((this.id !== undefined) && (this.id > 0));
            },
            load() {
                let url = '/payroll/salary-process';
                ApiRepository.callApi(ApiRepository.GET_COMMAND, url).then(res => {
                    this.fiscalYearOptions = res.data.fecialYearList;
                    let that = this;
                    this.fiscalYearOptions.forEach(function(item) {
                        if (item.current_yn == 'Y') {
                            that.process.fiscalYear = item.fy_id;
                            that.getMonths();
                        }
                    });
                    this.billCodes = res.data.billCodes; //Bill code instead of biller code.
                });
            },
            onSubmit(evt) {
                evt.preventDefault();
                let params = this.process;
                console.log('this.process',this.process);
                let queryString = Object.keys(params).map(function (key) {
                    return params[key]
                }).join('/');
                console.log('queary',queryString);
                this.dataUrl = "/v1/payroll/bonuses/" + queryString;
                this.isProcessDone = true;

                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/bonuses/"+queryString).then(res => {
                   this.dataLength = res.data.data.length
                });


                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/bonus-bill-status/"+queryString).then(res => {
                    this.currentBillState = res.data.state;
                });
            },
            onReset() {
                this.$nextTick(() => {
                    this.isProcessDone = false
                })
            },
            checkFormValidity() {
                const valid = this.$refs.form.checkValidity()
                this.nameState = valid ? 'valid' : 'invalid'
                return valid
            },
            resetModal() {
                this.name = ''
                this.nameState = null
            },
            handleOk(bvModalEvt) {
                let url = '/payroll/bonus-process/heads';
                let data = this.bonusesHead;
                data.bonus = this.bonus;
                ApiRepository.callApi(ApiRepository.PUT_COMMAND, url, data).then(res => {
                    console.log('res',res)
                    if (res.data.o_status_code == 1) {
                        this.bonus.formatted_bonus = res.data.bonus.formatted_bonus;
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                        this.$refs.modal.hide();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                    }
                });
            },
            pdfUrl: function () {
                this.reportParams.bill_code = this.process.bill_code; //Bill code instead of biller code.
                this.reportParams.pr_year = this.process.fiscalYear;
                this.reportParams.p_month_id = this.process.pr_month;
                //this.reportParams.type='pdf';
                let params = this.reportParams;
                let queryString = Object.keys(params).map(function (key) {
                    return key + "=" + params[key]
                }).join('&');
                this.excelUrl = '/report/render/Bill-wise-employee-salaries?' + queryString+"&type=xlsx";
                return '/report/render/Bill-wise-employee-salaries?' + queryString+"&type=pdf";
            },
            exlUrl: function () {
                this.reportParams.type='xlsx';
                let params = this.reportParams;
                let obj = new Object;
                let queryString = obj.keys(params).map(function (key) {
                    return key + "=" + params[key]
                }).join('&');
                return '/report/render?' + queryString;
            },
            updateBonus: function (bonus) {
                let url = '/payroll/bonus-process/' + bonus.pr_process_id;
                ApiRepository.callApi(ApiRepository.PUT_COMMAND, url, bonus).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                    } else
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                });
            },
            addDeduction: function () {
                let url = '/payroll/pr-bonus-heads/Y';
                ApiRepository.callApi(ApiRepository.POST_COMMAND, url, this.bonus).then(res => {
                    this.deductions = res.data;
                    this.deduction_adding_show = true;
                });
            },
            addAllowance: function () {
                let url = '/payroll/pr-bonus-heads/N';
                ApiRepository.callApi(ApiRepository.POST_COMMAND, url, this.bonus).then(res => {
                    this.bonuses = res.data;
                    this.allowance_adding_show = true;
                });
            },
            submitDeduction: function () {
                let url = '/payroll/pr-bonus-heads/Y/add';
                this.bonus.deduction = this.deduction;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, url, this.bonus).then(res => {
                    if (res.data.params.o_status_code == 1) {
                        this.deductions = res.data.prSalaryHeads;
                        this.bonusesHead = res.data.bonusesHead;
                        this.deduction = {};
                        this.bonus.formatted_sum_deduction = res.data.salary.formatted_sum_deduction;
                        this.bonus.formatted_sum_allowance = res.data.salary.formatted_sum_allowance;
                        this.bonus.formatted_salary = res.data.salary.formatted_salary;
                        this.bonus.salary = res.data.salary.salary;
                        this.bonus.deduction = {};
                        this.$notify({group: 'pmis', text: res.data.params.o_status_message, type: 'success'})
                    } else
                        this.$notify({group: 'pmis', text: res.data.params.o_status_message, type: 'error'})

                });
            },
            allBonusHeads() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/bonus-process-heads").then(res => {
                    this.bonusHeads = res.data.bonusHeads;
                });
            },
            submitAllowance: function () {
                let url = '/payroll/pr-bonus-heads/N/add';
                this.bonus = this.allowance;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, url, this.bonus).then(res => {
                    if (res.data.params.o_status_code == 1) {
                        this.bonuses = res.data.prSalaryHeads;
                        this.bonusesHead = res.data.bonusesHead;
                        this.allowance = {};
                        this.bonus.formatted_sum_deduction = res.data.salary.formatted_sum_deduction;
                        this.bonus.formatted_sum_allowance = res.data.salary.formatted_sum_allowance;
                        this.bonus.formatted_salary = res.data.salary.formatted_salary;
                        this.bonus.salary = res.data.salary.salary;
                        this.bonus.allowance = {};
                        this.$notify({group: 'pmis', text: res.data.params.o_status_message, type: 'success'})
                    } else
                        this.$notify({group: 'pmis', text: res.data.params.o_status_message, type: 'error'})

                });
            },
            getMonths: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/bonus-setup/year/" + this.process.fiscalYear).then(res => {
                    this.fiscal_months = res.data;
                    let that = this;
                    this.fiscal_months.forEach(function(month) {
                        if (month.text == moment().format("MMMM")) {
                            that.process.pr_month = month.value;
                            that.getBillCodes();
                        }
                    });
                });
            },
            getBillCodes:function() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/bonus-setup/bill-codes/" + this.process.fiscalYear+"/"+ this.process.pr_month).then(res => {
                    this.billCodes = res.data;
                });
            },
            currentBillStatus: function() {
                let params = this.process;
                let queryString = Object.keys(params).map(function (key) {
                    return params[key]
                }).join('/');
                this.dataUrl = "/v1/payroll/bonuses/" + queryString;
                this.isProcessDone = true;

                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/bonus-bill-status/"+queryString).then(res => {
                    this.currentBillState = res.data.state;
                });
            },
            deleteHead: function () {
                if (this.selectedHead) {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, "/payroll/bonus-process/heads", this.selectedHead).then(res => {
                        if (res.data.params.o_status_code == 1) {
                            this.deductions = res.data.prSalaryHeads;
                            this.bonusesHead = res.data.bonusesHead;
                            this.deduction = {};
                            this.allowance = {};
                            this.bonus.formatted_sum_deduction = res.data.salary.formatted_sum_deduction;
                            this.bonus.formatted_sum_allowance = res.data.salary.formatted_sum_allowance;
                            this.bonus.formatted_salary = res.data.salary.formatted_salary;
                            this.bonus.salary = res.data.salary.salary;
                            this.bonus.deduction = {};
                            this.bonus.allowance = {};
                            this.$notify({group: 'pmis', text: res.data.params.o_status_message, type: 'success'})
                        } else
                            this.$notify({group: 'pmis', text: res.data.params.o_status_message, type: 'error'})
                    });
                }
            },
            canHasPermission: function() {
                let role = 'BILL_CLARK';
                let hasRole = this.$store.getters.roles.filter( element => element.role_key == role);
                if(!(hasRole.length>0))
                    return false;

                return this.currentBillState && this.currentBillState.status_key == 'PAYROLL_PROCESSED';
            },

            setCurrentState: function() {
                this.currentBillState = this.currentBillStatus();
            },
            bankAdvise: function() {
                let form = document.getElementById('bankadvise_form');
                form.submit();
            },
            bonus_payslip: function() {
                let form = document.getElementById('bonus_payslip_form');
                form.submit();
            },
            emp_bonus: function() {
                let form = document.getElementById('emp_bonus_form');
                form.submit();
            },
            billCompare: function() {
                let form = document.getElementById('compare_form');
                form.submit();
            },
            printPayslip: function() {

                let form = document.getElementById('payslip_form');
                form.submit();
            },
            isBillDisburse:function() {
                if (this.currentBillState && this.currentBillState.status_key == 'BILL_DISBURSED') {
                    return true;
                }
            },
             hide(){
                this.show=false;
            },
            statusModalhide(){
                this.statusModalShow=false;
            }
        }
    }
</script>
<style>
    div.requiredField label.d-block:after {
        content: '*';
        color: red;
    }

    .allowance-col {
        border-right: 1px solid #ccc;
    }

    #loadingMessage {
        width: 100%;
        height: 100%;
        z-index: 1000;
        background: #ccc;
        top: 0px;
        left: 0px;
        position: absolute;
    }
    .vs__dropdown-toggle {
        padding: 0 0 9px !important;
    }

</style>
