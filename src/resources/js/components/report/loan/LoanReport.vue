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
                                                   :name="param.param_name"></b-form-select>
                                    <b-form-select v-else-if="param.component=='month_id'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="prMonths"
                                                :name="param.param_name" @change="getBillCodes"></b-form-select>
                                    <b-form-select v-else-if="param.component=='bill_code'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="billcodes"
                                                   :name="param.param_name" :disabled="billcodes.length<=0"></b-form-select>
                                    <b-form-select v-else-if="param.component=='department_id'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="departments"
                                                   :name="param.param_name"></b-form-select>
                                    <b-form-select v-else-if="param.component=='loanNumber'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="loanNumbers"
                                                   :name="param.param_name"></b-form-select>
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
                </b-card-body>
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "Report"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan"});
            this.loadData();
        },
        data() {
            return {
                billcodes: [],
                prMonths: [],
                departments: [],
                reports: [],
                prYears:[],
                loanNumbers:[],
                typeOptions:[{'text':'PDF', 'value':'pdf'},{'text':'Excel', 'value':'xlsx'}],
                selectedType:'pdf',
                csrf:'',
                report: {type: 'pdf', xdo: ''}
            };
        },
        methods: {
            loadData: function () {
                this.csrf = axios.defaults.headers.common['X-CSRF-TOKEN'];
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/loan/report-parameters").then(res => {
                    //this.billcodes = res.data.billcodes;
                    this.departments = res.data.departments;
                    this.prMonths = res.data.prMonths;
                    this.prYears = res.data.prFiscalYears;
                    this.loanNumbers=res.data.loanNumbers;
                    this.reports = res.data.reports;
                });
            },
            getBillCodes: function(data) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/report-parameters/bill-codes/"+data).then(res => {
                    this.billcodes = res.data;
                });
            }
        }
    };
</script>
