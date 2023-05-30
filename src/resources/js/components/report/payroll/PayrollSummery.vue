<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header>
                    <b-row>
                        <b-col md="6" lg="4" sm="12">
                            <b-form-group
                                label="Report Name"
                                label-for="input-3"
                                label-cols-sm="3"
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
                                    <b-form-select v-if="param.component=='pr_year'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="prYears"
                                                   :name="param.param_name" @change="getMonths"></b-form-select>
                                    <b-form-select v-else-if="param.component=='month_id'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="prMonths"
                                                :name="param.param_name" @change="getBillCodes"></b-form-select>
                                    <b-form-select v-else-if="param.component=='emp_month_id'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="prMonthsAll"
                                                :name="param.param_name" @change=""></b-form-select>
                                    <b-form-select v-else-if="param.component=='bill_month'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="billMonths"
                                                   :name="param.param_name"></b-form-select>
                                    <b-form-select v-else-if="param.component=='bonus_month_id'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="prBonusMonths"
                                                :name="param.param_name" @change="getBillCodes"></b-form-select>
                                    <b-form-select v-else-if="param.component=='bill_code'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="billcodes"
                                                   :name="param.param_name" :disabled="billcodes.length<=0"></b-form-select>
                                    <b-form-select v-else-if="param.component=='department_id'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="departments"
                                                :name="param.param_name"></b-form-select>
                                    <b-form-select v-else-if="param.component=='bonus_head'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="bonusHeads"
                                                   :name="param.param_name" text-field="salary_head" value-field="salary_head_id"></b-form-select>
                                    <b-form-select v-else-if="param.component=='p_emp_type'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="empType"
                                                   :name="param.param_name"></b-form-select>
                                    <b-form-select v-else-if="param.component=='emp_status'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="empStatus"
                                                   :name="param.param_name"></b-form-select>
                                    <v-select v-else-if="param.component=='emp_ids'"
                                            label="option_name"
                                            v-model="selectedEmployee"
                                            :options="empIdList"
                                            @search="searchEmpCode"
                                            :name="param.param_name">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>
                                    <v-select v-else-if="param.component=='employee_id'"
                                            label="option_name"
                                            v-model="selectedAllEmployee"
                                            :options="allEmpIdList"
                                            @search="searchAllEmpCode"
                                            :name="param.param_name">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>
                                    <b-form-select
                                        v-else-if="param.component=='emp_type_id'"
                                        :required="param.requied_yn == 'Y'"
                                        v-model="param.default_value"
                                        :options="empTypes"
                                        :name="param.param_name"></b-form-select>
                                    <b-form-select v-else-if="param.component=='emp_status_id'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="empStatus"
                                                   :name="param.param_name">
                                        <template v-slot:first>
                                            <option value="">-- Please select an option --
                                            </option>
                                        </template>
                                    </b-form-select>
                                    <b-form-input v-else-if="param.component=='date'" :required="param.requied_yn == 'Y'" :id="param.param_name" :name="param.param_name" data-date-format="dd-mm-yyyy" type="date" v-model="param.default_value"></b-form-input>
                                    <b-input v-else-if="param.component == 'hidden_emp_id'"  :required="param.requied_yn == 'Y'"
                                            :name="param.param_name" style="display:none" :value="emp_id"></b-input>
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
                                    <input type="hidden" v-if="selectedEmployee!=null"  :value="custome.emp_code"  name="emp_code"/>
                                    <input type="hidden" v-if="selectedEmployee!=null"  :value="selectedEmployee.emp_code"  name="p_emp_code"></input>
                                    <input type="hidden" v-if="selectedAllEmployee!=null"  :value="selectedAllEmployee.emp_code"  name="p_emp_code"></input>
                                    <input type="hidden" name="_token" v-model="csrf" />
                                    <b-button type="submit" variant="primary">Generate Report</b-button>
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
    export default {
        components: {DatePicker, vSelect, vcss},
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.custome.emp_code = val.emp_code;
                }
            },
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Report"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Payroll"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Summery"});
            this.loadData();
            // this.getBillCodes();
            this.emp_id = this.$store.getters.user.emp_id;
        },
        data() {
            return {
                custome:{emp_code:""},
                selectedEmployee: [],
                selectedAllEmployee: [],
                empIdList: [],
                allEmpIdList: [],
                billcodes: [],
                prMonths: [],
                prMonthsAll: [],
                billMonths: [],
                prBonusMonths: [],
                departments: [],
                bonusHeads:[],
                reports: [],
                prYears:[],
                emp_id:null,
                empType:[],
                empStatus:[],
                empTypes: [],
                typeOptions:[{'text':'PDF', 'value':'pdf'},{'text':'Excel', 'value':'xlsx'}],
                selectedType:'pdf',
                csrf:'',
                report: {type: 'pdf', xdo: ''}
            };
        },

        methods: {
            loadData: function () {
                this.csrf = axios.defaults.headers.common['X-CSRF-TOKEN'];
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/report-parameters/2").then(res => {
                    this.billcodes = res.data.billcodes;
                    this.departments = res.data.departments;
                    this.prMonths = res.data.prMonths;
                    //this.prMonthsAll = res.data.prMonthsAll;
                    this.billMonths = res.data.billMonths
                    this.prBonusMonths = res.data.prBonusMonths;
                    this.prYears = res.data.prFiscalYears;
                    this.empTypes = res.data.empType;
                    this.empStatus = res.data.empStatus;
                    this.reports = res.data.reports;
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/bonus-process-heads").then(res => {
                    this.bonusHeads = res.data.bonusHeads;
                });
            },
            // getBillCodes: function(data) {
            //     ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/report-parameters/bill-codes/"+data).then(res => {
            //         this.billcodes = res.data;
            //     });
            // },
            getMonths: function(year) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/report-parameters/year-months/"+year).then(res => {
                    this.prMonthsAll = res.data;
                });
            },
            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/emp/${id}`).then(res => {
                        this.empIdList = res.data;
                        // console.log(res.data);
                    })
                }
            },
            searchAllEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/all-emp/${id}`).then(res => {
                        this.allEmpIdList = res.data;
                        // console.log(res.data);
                    })
                }
            },

        }
    };
</script>
