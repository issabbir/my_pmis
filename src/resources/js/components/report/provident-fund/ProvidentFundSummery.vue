<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <b-col md="3">
                    <b-form-group label="Report" label-for="input-3">
                        <select v-model="report" class="form-control text-uppercase" v-if="reports">
                            <option v-for="rep in reports" :key="rep.report_id" :value="rep">{{rep.report_name |uppercase}}</option>
                        </select>
                    </b-form-group>
                </b-col>
            </b-card>
            <b-card class="card" v-if="report.params !=null" title="Set parameter">
                <b-form target="_blank" :action="'/report/render/'+report.report_name" method="post">
                    <b-row>
                        <b-col md="3" v-for="param in report.params" :key="param.report_param_id">
                            <b-form-group :label="param.param_label" label-for="input" :class="{requiredField:param.requied_yn == 'Y'}">
                                <b-form-select v-if="param.component=='bill_code'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="billcodes"
                                               :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="null">-- Please select an option --
                                        </option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-else-if="param.component=='month_id'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="prMonths"
                                               :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="null">-- Please select an option --
                                        </option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-else-if="param.component=='pr_year'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="prYears"
                                               :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="null">-- Please select an option --
                                        </option>
                                    </template>
                                </b-form-select>
                                <b-form-select
                                    v-else-if="param.component=='emp_type_id'"
                                    :required="param.requied_yn == 'Y'"
                                    v-model="param.default_value"
                                    :options="empTypes"
                                    :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="null">-- Please select an option --
                                        </option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-else-if="param.component=='department_id'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="departments"
                                               :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="">-- Please select an option --
                                        </option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-else-if="param.component=='loanType'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="loanTypes"
                                               :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="">-- Please select an option --
                                        </option>
                                    </template>
                                </b-form-select>
                                <b-form-input v-else-if="param.component=='date'" :required="param.requied_yn == 'Y'" :id="param.param_name" :name="param.param_name" data-date-format="dd-mm-yyyy" type="date" v-model="param.default_value"></b-form-input>
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
                                <input type="hidden" name="_token" v-model="csrf" />
                                <b-button type="submit" variant="primary">Generate Report</b-button>
                            </b-col>
                    </b-row>
                </b-form>
            </b-card>
        </div>
    </div>
</template>

<script>
    import ApiRepository from "../../../Repository/ApiRepository";
    import axios from 'axios';
    import DatePicker from "vue2-datepicker";
    export default {
        components: {DatePicker},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Provident Fund"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Report"});
            this.loadData();
        },
        data() {
            return {
                billcodes: [],
                prMonths: [],
                departments: [],
                empTypes: [],
                reports: [],
                prYears:[],
                typeOptions:[{'text':'PDF', 'value':'pdf'},{'text':'Excel', 'value':'xlsx'}],
                loanTypes:[
                        {'text':'LOAN REPAYMENT', 'value':68},
                        {'text':'LOAN INTEREST', 'value':200},
                        {'text':'LOAN DRAWN', 'value':100},
                        // {'text':'SETTLEMENT', 'value':300},
                    ],
                selectedType:'pdf',
                csrf:'',
                report: {type: 'pdf', xdo: ''}
            };
        },
        methods: {
            loadData: function () {
                this.csrf = axios.defaults.headers.common['X-CSRF-TOKEN'];
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/providentFund/report-parameters").then(res => {
                    this.billcodes = res.data.billcodes;
                    this.departments = res.data.departments;
                    this.prMonths = res.data.prMonths;
                    this.prYears = res.data.prFiscalYears;
                    this.empTypes = res.data.empTypes;
                    this.reports = res.data.reports;
                });
            },
        },
        filters: {
            uppercase: function($val) {
                return $val.toUpperCase();
            }
        }
    };
</script>
