<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header>
                    <b-row>
                        <b-col md="8" lg="6" sm="12">
                            <b-form-group
                                label="Report Name"
                                label-for="input-3"
                                label-cols-sm="4"
                                label-cols-md="3"
                                label-cols-lg="3"
                                label-align-sm="right"
                                label-align-md="right"
                            >
                                <select v-model="report" class="form-control text-uppercase" v-if="reports">
                                    <option v-for="rep in reports" :key="rep.report_id" :value="rep">{{rep.report_name}}</option>
                                </select>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-card-header>
                <b-card-body v-if="report.params !=null" class="border">
                    <b-form target="_blank" :action="'/report/render/'+report.report_name" method="post">
                        <b-row>
                            <b-col md="3" v-for="param in report.params" :key="param.report_param_id">
                                <b-form-group :label="param.param_label" label-for="input" :class="{requiredField:param.requied_yn == 'Y'}">
                                    <b-form-select
                                        v-if="param.component=='pr_year'"
                                        :required="param.requied_yn == 'Y'"
                                        v-model="param.default_value" :options="prYears"
                                        :name="param.param_name">
                                    </b-form-select>
                                    <b-form-select
                                        v-else-if="param.component=='month_id'"
                                        :required="param.requied_yn == 'Y'"
                                        v-model="param.default_value"
                                        :options="prMonths"
                                        :name="param.param_name"
                                        @change="getBillCodes"
                                    ></b-form-select>
                                    <b-form-select
                                    v-else-if="param.component=='bonus_month'"
                                    :required="param.requied_yn == 'Y'"
                                    v-model="prMonthsId"
                                    :options="prMonths"
                                    :name="param.param_name"
                                    @change="getBillCodes"
                                    ></b-form-select>
                                    <b-form-select
                                        v-else-if="param.component=='bonus_month_id'"
                                        :required="param.requied_yn == 'Y'"
                                        v-model="param.default_value"
                                        :options="prMonths"
                                        :name="param.param_name"
                                        @change="getBillCodes"
                                    ></b-form-select>
                                    <b-form-select
                                        v-else-if="param.component=='bill_code'"
                                        :required="param.requied_yn == 'Y'"
                                        v-model="param.default_value"
                                        :options="billcodes"
                                        :name="param.param_name"
                                        :disabled="billcodes.length<=0"
                                        ></b-form-select>
                                    <b-form-select
                                        v-else-if="param.component=='department_id'"
                                        :required="param.requied_yn == 'Y'"
                                        v-model="param.default_value"
                                        @change="departmentWiseEmployee(param.default_value)"
                                        :options="departments"
                                        :name="param.param_name"></b-form-select>
                                    <b-form-select
                                        v-else-if="param.component=='department_id_fs'"
                                        :required="param.requied_yn == 'Y'"
                                        v-model="param.default_value"
                                        :options="departmentsfs"
                                        :name="param.param_name">
                                    </b-form-select>
                                    <b-form-select
                                        v-else-if="param.component=='emp_type_id'"
                                        :required="param.requied_yn == 'Y'"
                                        v-model="empTypesVal"
                                        :options="empTypes"
                                        :name="param.param_name">
                                    </b-form-select>
                                    <b-form-select
                                        v-else-if="param.component=='pensionHeadId'"
                                        :required="param.requied_yn == 'Y'"
                                        v-model="param.default_value"
                                        :name="param.param_name">
                                        <option :value="head.pension_head_id" v-for="head in pensionHead">{{ head.pension_head }}</option>
                                    </b-form-select>
                                    <b-form-select
                                        v-else-if="param.component=='pension_pct'"
                                        :required="param.requied_yn == 'Y'"
                                        v-model="pensionPctVal"
                                        :options="pensionPct"
                                        :name="param.param_name"></b-form-select>
                                    <b-form-select v-else-if="param.component=='loanNumber'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="loanNumbers"
                                                   :name="param.param_name"></b-form-select>
                                    <v-select v-else-if="param.component=='emp_ids' && report.report_xdo_path != '/~weblogic/Pension/pension_cal_settle.xdo' && report.report_xdo_path != '/~weblogic/Pension/pension_pay_slip.xdo'"
                                              label="option_name"
                                              v-model="selectedEmployee"
                                              :options="empIdList"
                                              @input="empInformation(selectedEmployee.emp_code)"
                                              @search="searchEmpCode"
                                              :name="param.param_name">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>
                                    <v-select v-else-if="param.component=='department_wise_emp_ids'"
                                              label="option_name"
                                              v-model="selectedEmployee"
                                              :options="empList"
                                              @input="empInformation(selectedEmployee.emp_code)"
                                              @search="searchEmpCode"
                                              :name="param.param_name">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>

                                    <v-select v-else-if="param.component=='emp_ids' && report.report_xdo_path == '/~weblogic/Pension/pension_cal_settle.xdo'"
                                              label="option_name"
                                              v-model="selectedEmployee"
                                              :options="empIdList"
                                              @search="searchPensionEmpCode"
                                              :name="param.param_name">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>

                                    <v-select v-else-if="param.component=='emp_ids' && report.report_xdo_path == '/~weblogic/Pension/pension_pay_slip.xdo'"
                                              label="option_name"
                                              v-model="selectedEmployee"
                                              :options="empIdList"
                                              @search="searchPensionEmpCodeForPaySlip"
                                              :name="param.param_name">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>

                                    <v-select v-else-if="param.component=='retired_dead_employee'"
                                              label="option_name"
                                              v-model="selectedEmployee"
                                              :options="empIdList"
                                              @search="searchRetiredDeadEmployee"
                                              :name="param.param_name">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>

                                    <v-select v-else-if="param.component=='pension_application_employee'"
                                              label="option_name"
                                              v-model="selectedEmployee"
                                              :options="empIdList"
                                              @search="searchPensionApplicationEmployee"
                                              :name="param.param_name">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>

                                    <v-select v-else-if="param.component=='pension_clearance_employee'"
                                              label="option_name"
                                              v-model="selectedEmployee"
                                              :options="empIdList"
                                              @search="searchPensionClearanceEmployee"
                                              :name="param.param_name">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>

                                    <b-form-input v-else-if="param.component=='date'"
                                                  :required="param.requied_yn == 'Y'"
                                                  :id="param.param_name" :name="param.param_name"
                                                  data-date-format="dd-mm-yyyy" type="date" v-model="param.default_value">
                                    </b-form-input>
                                    <b-form-group
                                        :label-for="param.param_name"
                                        v-else-if="param.component=='datePicker'"
                                    >
                                        <date-picker
                                            :id="param.param_name"
                                            :name="param.param_name"
                                            :required="param.requied_yn == 'Y'"
                                            width="100%"
                                            input-class="form-control"
                                            v-model="param.default_value"
                                            type="date"
                                            lang="en"
                                            readonly
                                            format="YYYY-MM-DD"
                                            :value-type="dateValueType"></date-picker>
                                    </b-form-group>

                                    <b-input v-else v-model="param.default_value" :required="param.requied_yn == 'Y'"
                                             :name="param.param_name"></b-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="3">
                                <b-form-group>
                                    <select v-model="selectedType" name="type" class="form-control" v-if="typeOptions">
                                        <option v-for="type in typeOptions" :key="type.value" :value="type.value">{{type.text}}</option>
                                    </select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <input type="hidden" :value="report.report_xdo_path" name="xdo" />
                                <input type="hidden" :value="report.report_id" name="rid" />
                                <input type="hidden" :value="report.report_name" name="filename" />
                                <input type="hidden" v-if="selectedEmployee!=null"  :value="custome.emp_code"  name="p_emp_code"></input>
                                <input type="hidden" v-if="selectedEmployee!=null"  :value="custome.emp_code"  name="emp_code"></input>
                                <input type="hidden" v-if="selectedEmployee!=null"  :value="custome.emp_code"  name="P_EMP_CODE"></input>
                                <input type="hidden" name="_token" v-model="csrf" />
                                <b-link target="_blank" v-if="report.report_id==72" :href="`/report/pension-settlement-report?emp_code=${custome.emp_code}`" class="btn btn-primary">Generate Report</b-link>
                                <b-button v-else type="submit" variant="primary">Generate Report</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import ApiRepository from "../../../Repository/ApiRepository";
    import axios from 'axios';
    import DatePicker from "vue2-datepicker";
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from "moment";
    export default {
        components: {DatePicker,vSelect, vcss},
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.custome.emp_code = val.emp_code;
                }
            },
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Reports"});
            this.loadData();
        },
        data() {
            return {
                custome:{emp_code:""},
                selectedEmployee: {
                    option_name: '',
                    emp_code: ''
                },
                empIdList: [],
                empList: [],
                billcodes: [],
                pensionPctVal: null,
                prMonths: [],
                bonusMonths: [],
                prMonthsId: null,
                departments: [],
                departmentsfs: [],
                empTypes: [],
                empTypesVal: null,
                pensionHead: [],
                reports: [],
                prYears:[],
                dateValueType: this.dateFormatter(),
                pensionPct:[
                    {'text':'ALL', 'value':null},
                    {'text':'50%', 'value':50},
                    {'text':'100%', 'value':100}
                ],
                loanNumbers:[],
                typeOptions:[{'text':'PDF', 'value':'pdf'},{'text':'Excel', 'value':'xlsx'}],
                selectedType:'pdf',
                selectedPct: null,
                csrf:'',
                report: {type: 'pdf', xdo: ''}
            };
        },
        methods: {
            loadData: function () {
                this.csrf = axios.defaults.headers.common['X-CSRF-TOKEN'];
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pension/report-parameters").then(res => {
                    //this.billcodes = res.data.billcodes;
                    console.log(res)
                    this.departments = res.data.departments;
                    this.departmentsfs = res.data.departmentsfs;
                    this.prMonths = res.data.prMonths;
                    this.bonusMonths = res.data.prMonths;
                    this.pensionHead = res.data.pension_heads;
                    this.prYears = res.data.prFiscalYears;
                    this.loanNumbers = res.data.loanNumbers;
                    this.empTypes = res.data.empTypes;
                    this.reports = res.data.reports;

                    let that = this;
                    this.bonusMonths.forEach( month => {
                        if (month.text == moment().format("MMMM-YYYY")) {
                            this.prMonthsId = month.value;
                        }
                    });
                });
            },
            getBillCodes: function(data) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/report-parameters/bill-codes/"+data).then(res => {
                    this.billcodes = res.data;
                });
            },
            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/emp/${id}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            empInformation(id) {
                console.log(id)
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/employee-wise-information/${id}`).then(res => {
                        console.log(res.data.data)
                        if (res.data.data.pension_pct == 50)
                        {
                            this.pensionPctVal = 50
                        }else if (res.data.data.pension_pct == 100) {
                            this.pensionPctVal = 100
                        }else{
                            this.pensionPctVal = null
                        }
                        if (res.data.data.emp_type_id == 1)
                        {
                            this.empTypesVal = 1
                        }else if (res.data.data.emp_type_id == 2) {
                            this.empTypesVal = 2
                        }else{
                            this.empTypes = null
                        }
                    })
                }
            },
            searchPensionEmpCode(id){
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/settlement-calculation-emp/${id}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            searchPensionEmpCodeForPaySlip(id){
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/settlement-calculation-emp/${id}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            searchRetiredDeadEmployee(name){
                if (name) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/retired-dead-employee/${name}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            departmentWiseEmployee(id) {
                if (id) {
                    this.selectedEmployee = null
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/department-wise-employees/${id}`).then(res => {
                        this.empList = res.data;
                    })
                }
            },
            searchPensionApplicationEmployee(name){
                if (name) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/pension-application-employee/${name}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            searchPensionClearanceEmployee(name){
                if (name) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/pension-clearance-employee/${name}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
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
        }
    };
</script>
