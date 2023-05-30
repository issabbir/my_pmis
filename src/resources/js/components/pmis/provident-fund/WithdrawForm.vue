<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <b-card-header header-bg-variant="dark" header-text-variant="white">Application for Settlement
                </b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">
                        <b-row>
                            <b-col md="3">
                                <b-form-group
                                    label="Fund Type"
                                    label-for="fundType"
                                    class="requiredField">
                                    <b-form-select v-model="pfWithdraw.settlement_types"
                                                   :options="fundtypeList" id="fundType"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Empoyee"
                                    label-for="employeeId"
                                    class="requiredField">
                                    <v-select
                                        label="option_name"
                                        v-model="selectedEmployee"
                                        :options="empIdList"
                                        @search="searchEmpCode"
                                        id="employeeId">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="PF ID">
                                    <b-input v-model="pfWithdraw.pf_id" disabled></b-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="EMPLOYEE NAME">
                                    <b-input v-model="pfWithdraw.emp_name" disabled></b-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="DEPARTMENT">
                                    <b-input v-model="pfWithdraw.department_name" disabled></b-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="DESIGNATION">
                                    <b-input v-model="pfWithdraw.designation" disabled></b-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="PAY SCALE">
                                    <b-input v-model="pfWithdraw.pay_scale" disabled></b-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="BASIC SALARY">
                                    <b-input v-model="pfWithdraw.basic_salary" disabled></b-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Bank Name"
                                    label-for="employeeId">
                                    <b-input v-model="pfWithdraw.bank_name" disabled></b-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Branch Name"
                                    label-for="employeeId">
                                    <b-input v-model="pfWithdraw.branch_name" disabled></b-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Bank Account No"
                                    label-for="employeeId">
                                    <b-input v-model="pfWithdraw.account_number" disabled></b-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="APPOINTMENT DATE"
                                    label-for="employeeId">
                                    <b-input v-model="pfWithdraw.appointment_date" disabled></b-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="RETIREMENT DATE"
                                    label-for="employeeId">
                                    <b-input v-model="pfWithdraw.retirement_date" disabled></b-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="RETIREMENT LEAVE DATE"
                                    label-for="employeeId">
                                    <b-input v-model="pfWithdraw.retirement_leave_date" disabled></b-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="3">
                                <b-form-group
                                    label="Applicant Type"
                                    label-for="Applicant Type"
                                    class="requiredField">
                                    <b-form-select v-model="pfWithdraw.applicant_type"
                                                   :options="applicanttypeList"
                                                   id="applicant_type"
                                                   name="applicant_type"
                                    ></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3" v-if="pfWithdraw.applicant_type==2">
                                <b-form-group
                                    label="Nominee"
                                    label-for="relationship_id">
                                    <b-form-select v-model="pfWithdraw.relationship_id"
                                                   :options="nomineeList"
                                                   id="relationship_id"
                                                   name="relationship_id"
                                                   value-field="nominee_id"
                                                   text-field="nominee_name"
                                                   @change="setApplicant()"
                                    ></b-form-select>
                                </b-form-group>
                            </b-col>

                            <b-col md="3" v-if="pfWithdraw.applicant_type==2">
                                <b-form-group
                                    label="Applicant Name"
                                    label-for="applicant_name">
                                    <b-form-input
                                        id="applicant_name"
                                        name="applicant_name"
                                        v-model="pfWithdraw.applicant_name"
                                        type="text"
                                        readonly
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>


                            <b-col md="3" v-if="pfWithdraw.applicant_type==2">
                                <b-form-group
                                    label="Nominee's Percentage"
                                    label-for="Employee Name">
                                    <b-form-input
                                        id="empName"
                                        v-model="pfWithdraw.percentage"
                                        type="text"
                                        required
                                        placeholder="0%"
                                        disabled
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>


                            <b-col md="3">
                                <b-form-group
                                    label="Apply Date"
                                    label-for="date"
                                    class="requiredField">
                                    <date-picker
                                        width="100%"
                                        input-class="form-control"
                                        v-model="pfWithdraw.application_date"
                                        type="date"
                                        lang="en"
                                        :editable="false"
                                        format="DD-MM-YYYY">
                                    </date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    class="requiredField"
                                    label="Settlement No"
                                    label-for="vn">
                                    <b-input
                                        input-class="form-control"
                                        placeholder="Voucher No"
                                        id="voucher_no"
                                        name="voucher_no"
                                        required
                                        v-model="pfWithdraw.voucher_no">
                                    </b-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Attachment" label-for="goAttachment" class="message">
                                    <b-form-file
                                        @change="encodeFile"
                                        id="goAttachment"
                                        placeholder="Go Attachment"
                                    ></b-form-file>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col class="col-md-12 col-12">
                                <fieldset class="border p-2">
                                    <legend class="w-auto">Amount</legend>
                                    <b-row>
                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4" class="text-right">
                                                        <label >PF Amount</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input v-model="pfWithdraw.pf_amount" readonly style="text-align:right"></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>

                                    </b-row>
                                    <b-row>
                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4" class="text-right">
                                                        <label>PF Interest(AUTHORITATIVE DONATION)</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input v-model="pfWithdraw.pf_interest" readonly style="text-align:right"></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4" class="text-right">
                                                        <label>Total PF</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input v-model="total_pf" readonly style="text-align:right"></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4" class="text-right">
                                                        <label>Total Loan Amount </label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input :state="false" v-model="pfWithdraw.total_loan_amount"  readonly style="text-align:right"></b-form-input>
<!--                                                        <b-form-input :state="false" :value="Number(pfWithdraw.total_loan_amount).toFixed(2)" readonly style="text-align:right"></b-form-input>-->
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>

                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4" class="text-right">
                                                        <label>PF Loan Amount Due</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input v-model="pfWithdraw.pf_loan_amount_due" readonly style="text-align:right"></b-form-input>
<!--                                                        <b-form-input :value="Number(pfWithdraw.pf_loan_amount_due).toFixed(2)" disabled style="text-align:right"></b-form-input>-->
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row>

                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4" class="text-right">
                                                        <label>PF Loan Interest Due</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input  v-model="pfWithdraw.pf_loan_interest_due" readonly style="text-align:right"></b-form-input>
<!--                                                        <b-form-input :value="Number(pfWithdraw.pf_loan_interest_due).toFixed(2)" readonly style="text-align:right"></b-form-input>-->
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4" class="text-right">
                                                        <label>Total Loan Due</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input v-model="pfWithdraw.total_loan_due" readonly style="text-align:right"></b-form-input>
<!--                                                        <b-form-input :value="Number(pfWithdraw.total_loan_due).toFixed(2)" readonly style="text-align:right"></b-form-input>-->
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <hr>
                                    <!--<b-row>
                                        <b-col offset-md="6" md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>PF Balance</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input v-model="pfWithdraw.pf_balance" disabled style="text-align:right"></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>

                                    </b-row>-->
                                    <b-row>
                                        <b-col md="6" offset-md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4" class="text-right">
                                                        <label>Settlement Amount</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input type="text" v-model="pfWithdraw.settlement_amt" style="text-align:right" readonly></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </fieldset>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col class="mt-2 d-flex justify-content-end mt-1">
                                <b-button md="6" size="md" variant="dark" type="submit">{{submitBtn}}</b-button>&nbsp;
                                <b-button md="6" size="md" class="btn-outline-dark" type="reset">Cancel</b-button>
                            </b-col>
                        </b-row>
                        <!--</fieldset>-->
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Settlement Information List
                </b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items"
                               :totalList="totalList" :perPage="perPage" v-bind:pageColSize="4"
                               v-bind:searchColSize="5">
                        <template v-slot:actions="{ rows }">
                            <a size="sm" @click="editRow(rows.item)"> <i class="bx bx-edit cursor-pointer"></i> </a>
                            <a size="sm" @click="showAttachmnet(rows.item.attachment)"><i
                                class="bx bx-download cursor-pointer"></i> </a>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../../layouts/common/datatable';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import ApiRepository from '../../../Repository/ApiRepository';

    function convertDate(inputFormat) {
        function pad(s) {
            return (s < 10) ? '0' + s : s;
        }

        var d = new Date(inputFormat)
        return [pad(d.getDate()), pad(d.getMonth() + 1), d.getFullYear()].join('-')
    }

    export default {
        components: {DatePicker, Datatable, vSelect, vcss},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Provident Fund"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "PF Settlement Application"});
            this.loadData();
        },
        computed: {
            total_pf:function () {
                return Number(Number(this.pfWithdraw.pf_amount) + Number(this.pfWithdraw.pf_interest)).toFixed(2)
            }
        },
        data() {
            return {
                applyDate: new Date(),
                selectedEmployee: {},
                hidden: false,
                empIdList: [],
                nomineeList: [],
                submitBtn: 'Submit',
                pfWithdraw: {
                    settlement_types: '',
                    emp_id: null,
                    applicant_name: null,
                    relationship_id: null,
                    applicant_type: null,
                    application_date: new Date(),
                    bank_info: '',
                    account_number: '',
                    appointment_date: '',
                    bank_name: '',
                    basic_salary: '',
                    branch_name: '',
                    department_name: '',
                    designation: '',
                    emp_name: '',
                    pay_scale: '',
                    pf_id: '',
                    retirement_date: '',
                    retirement_leave_date: '',
                    total_loan_due:null,
                    pf_balance:null,
                    pf_loan_interest_due:null,
                    total_pf:null,
                    pf_loan_amount_due:null,
                    pf_interest:null,
                    total_loan_amount:null,
                    pf_amount:null,
                    settlement_amt:'',
                    voucher_no: '',
                    attachment: '',
                    file_type: '',
                    file_name: '',

                },
                errorMessage: {color: 'red'},
                fundtypeList: [{text: 'GPF', value: 1}, {text: 'CPF', value: 2}],
                applicanttypeList: [{text: 'Self', value: 1}],
                show: true,
                perPage: 5,
                totalList: 0,
                tableData: {
                    fields: [
                        {key: 'index', label: '#sl', sortable: true},
                        {
                            key: 'settlement_types',
                            formatter: value => {
                                if (value) {
                                    return value == 1 ? 'PF' : 'CPF';
                                }
                            },
                            label: 'Fund Type', orderDate: true
                        },
                        {
                            key: 'emp_code',
                            label: 'Employee Code', sortable: true
                        },
                        {
                            key: 'emp_name',
                            label: 'Employee', sortable: true
                        },
                        {
                            key: 'applicant_type',
                            formatter: value => {
                                if (value) {
                                    return value == 1 ? 'Self' : 'Nominee';
                                }
                            },
                            label: 'Applicant Type', sortable: true
                        },
                        {
                            key: 'application_date',
                            formatter: value => {
                                if (value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, label: 'Application Date', sortable: true
                        },
                        'action'],
                    items: []
                }
            }
        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.pfWithdraw.emp_code = val.emp_code;
                    this.pfWithdraw.emp_bank_info = val.bank_info;
                    this.pfWithdraw.account_number = val.account_number;
                    this.pfWithdraw.emp_name = val.emp_name;
                    this.pfWithdraw.appointment_date = convertDate(val.appointment_date);
                    this.pfWithdraw.bank_name = val.bank_name;
                    this.pfWithdraw.basic_salary = val.basic_salary;
                    this.pfWithdraw.branch_name = val.branch_name;
                    this.pfWithdraw.department_name = val.department_name;
                    this.pfWithdraw.designation = val.designation;
                    this.pfWithdraw.pay_scale = val.pay_scale;
                    this.pfWithdraw.pf_id = val.pf_id;
                    this.pfWithdraw.pay_scale = val.pay_scale;
                    this.pfWithdraw.retirement_date = val.retirement_date;
                    this.pfWithdraw.retirement_leave_date = val.retirement_leave_date;
                    this.pfWithdraw.voucher_no = '';
                    this.pfWithdraw.total_loan_due=val.total_loan_due;
                    this.pfWithdraw.pf_balance=val.pf_balance;
                    this.pfWithdraw.pf_loan_interest_due=val.pf_loan_interest_due;
                    this.pfWithdraw.total_pf=val.total_pf;
                    this.pfWithdraw.pf_interest=val.pf_interest;
                    this.pfWithdraw.total_loan_amount=Number(val.total_loan_amount).toFixed(2);
                    this.pfWithdraw.pf_loan_amount_due=Number(val.pf_loan_amount_due).toFixed(2);
                    this.pfWithdraw.settlement_amt=val.settlement_amt;
                    this.pfWithdraw.pf_amount=val.pf_amount;
                    //console.log(val);
                    this.loadNominee(val.emp_id)
                }
            },
            'pfWithdraw.total_loan_due':function (val, oldVal) {
                this.pfWithdraw.settlement_amt = Number(Number(this.total_pf) - Number(val)).toFixed(2)
            }
        },
        methods: {
            encodeFile(e) {
                let file_limit = 2000000;
                let vm = this;
                if (e.target.files[0].size <= file_limit) {
                    if (e.target.files[0].type == 'application/pdf' || e.target.files[0].type == 'application/msword' || e.target.files[0].type == 'image/jpeg' || e.target.files[0].type == 'image/jpg') {
                        let file = e.target.files[0];
                        let reader = new FileReader();
                        let type = file.type;
                        let name = file.name;
                        reader.readAsDataURL(file);
                        reader.onload = (file) => {
                            vm.pfWithdraw.attachment = reader.result;
                            vm.pfWithdraw.file_type = type;
                            vm.pfWithdraw.file_name = name;
                        }
                    } else {
                        this.$notify({group: 'pmis', text: "File type should be in pdf, jpg or jpeg", type: 'error'});
                    }

                } else {
                    this.$notify({group: 'pmis', text: "File size should not exceed 2MB", type: 'error'});
                    return;
                }

            },
            showAttachmnet(data) {
                const win = window.open("", "_blank");
                let html = '';
                html += '<html>';
                html += '<body style="margin:0!important">';
                html += '<embed width="100%" height="100%" src="' + data + '"/>';
                html += '</body>';
                html += '</html>';
                setTimeout(() => {
                    win.document.write(html);
                }, 0);
            },
            onSubmit() {
                if (this.pfWithdraw.settlement_id != null) {
                    this.pfWithdraw.emp_id = this.selectedEmployee.emp_id;
                    ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/providentFund/application/pf-with-draw-update`, this.pfWithdraw).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.loadData();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                } else {
                    this.pfWithdraw.emp_id = this.selectedEmployee.emp_id;
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/providentFund/application/pf-with-draw`, this.pfWithdraw).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onReset();
                            this.loadData();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                }

            },
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/providentFund/application/pf-with-draw-list`).then(res => {
                    this.tableData.items = res.data;
                    this.totalList = res.data.length;
                });
            },
            onReset() {
                this.show = false;
                this.submitBtn = 'Save';
                this.pfWithdraw = {'bank_info': ''},
                    this.selectedEmployee = {};
                this.$nextTick(() => {
                    this.show = true
                })
            },

            editRow(item) {
                this.pfWithdraw = item;
                // this.pfWithdraw.emp_bank_info=item.emp_bank_info
                // console.log(item);
                this.setEmployee(item);
                this.submitBtn = 'Update';
            },
            setEmployee: function (item) {
                this.selectedEmployee = {
                    option_name: item.emp_code,
                    emp_id: item.emp_id,
                    emp_code: item.emp_code,
                    emp_name: item.emp_name,
                    bank_info: item.emp_bank_info,
                }
            },
            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/providentFund/gpf/settlement/emp/${id}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },

            loadNominee: function (id) {
                // ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/applications/nominee/${id}`).then(res => {
                //     this.nomineeList = res.data;
                // });
            },
            setApplicant() {
                this.applicanttypeList.forEach((item) => {
                    if (item.value == 2) {
                        this.nomineeList.forEach((i) => {
                            if (i.nominee_id == this.pfWithdraw.relationship_id) {
                                this.pfWithdraw.applicant_name = i.nominee_name;
                                this.pfWithdraw.percentage = i.percentage;
                            }
                        });
                    }
                });
            }
        }
    }
</script>


<style>
    .message label:after {
        content: " (File should not exceed 2MB)";
        color: red
    }
</style>
