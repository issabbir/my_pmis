<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card"  >
                <b-card-header >
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
                                <select v-model="report" @change="onChangeReport" class="form-control text-uppercase" v-if="reports">
                                    <option v-for="rep in reports" :key="rep.report_id" :value="rep">{{rep.report_name |uppercase}}</option>
                                </select>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-card-header>
                <b-card-body class="border" v-if="report.params !=null">
                    <b-form target="_blank" :action="'/report/render/'+report.report_name" method="post">
                        <b-row>
                            <b-col md="3" v-for="param in report.params" :key="param.report_param_id">
                                <b-form-group :label="param.param_label" label-for="input" :class="{requiredField:param.requied_yn == 'Y'}">
                                    <b-form-select v-if="param.component=='bill_code'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="billcodes"
                                                :name="param.param_name">
                                        <template v-slot:first>
                                            <option value="">-- Please select an option --
                                            </option>
                                        </template>
                                    </b-form-select>
                                    <b-form-select v-else-if="param.component=='month'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="months"
                                                :name="param.param_name">
                                        <template v-slot:first>
                                            <option value="">-- Please select an option --
                                            </option>
                                        </template>
                                    </b-form-select>
                                    <b-form-select v-else-if="param.component=='pr_year'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="prYears"
                                                :name="param.param_name">
                                        <template v-slot:first>
                                            <option value="">-- Please select an option --
                                            </option>
                                        </template>
                                    </b-form-select>
                                    <b-form-select v-else-if="param.component=='attendance_status'" text-field="show_velue" value-field="passing_value" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="attendance_status_options"
                                                   :name="param.param_name">
                                        <template v-slot:first>
                                            <option value="">-- Please select an option --
                                            </option>
                                        </template>
                                    </b-form-select>

                                    <b-form-select v-else-if="param.component=='department_id'"
                                                   @input="loadDesignation(param.default_value)"
                                                   :required="param.requied_yn == 'Y'"
                                                   v-model="selected"
                                                   :options="departments"
                                                   @change="department_id = param.default_value"
                                                :name="param.param_name">
                                    </b-form-select>
                                    <b-form-select
                                      v-else-if="param.component=='designation_id'"
                                      :required="param.requied_yn == 'Y'"
                                      v-model="param.default_value"
                                      :options="designations"
                                      text-field="designation"
                                      value-field="designation_id"
                                      :name="param.param_name">
                                        <template v-slot:first>
                                            <option value="">-- Please select an option --
                                            </option>
                                        </template>
                                    </b-form-select>
                                    <b-form-select v-else-if="param.component=='emp_type_id'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="empTypes" text-field="emp_type_name" value-field="emp_type_id"
                                                   :name="param.param_name">
                                        <template v-slot:first>
                                            <option value="">-- Please select an option --
                                            </option>
                                        </template>
                                    </b-form-select>
                                    <b-form-input v-else-if="param.component=='date'"
                                                  :required="param.requied_yn == 'Y'"
                                                  :id="param.param_name"
                                                  :name="param.param_name"
                                                  data-date-format="dd-mm-yyyy"
                                                  type="date"
                                                  v-model="param.default_value"
                                    ></b-form-input>

                                    <!--                                    <date-picker v-else-if="param.component=='date'"-->
<!--                                                 v-model="param.param_name"-->
<!--                                                 width="100%"-->
<!--                                                 type="date"-->
<!--                                                 lang="en" :required="param.requied_yn == 'Y'"-->
<!--                                                 format="DD-MM-YYYY"-->
<!--                                                 :id="param.param_name" :name="param.param_name"-->
<!--                                    ></date-picker>-->
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

                                    <b-form-select
                                        v-else-if="param.component=='Sections'"
                                        :required="param.requied_yn == 'Y'"
                                        v-model="param.default_value"
                                        :options="empSections"
                                        :name="param.param_name">
                                        <template v-slot:first>
                                            <option value="">-- Please select an option --</option>
                                        </template>
                                    </b-form-select>


                                    <v-select v-else-if="param.component=='controlling_office_wise_employee'"
                                              label="option_name"
                                              v-model="selectedEmployee"
                                              :options="employeeOptions"
                                              @search="controllingOfficerWiseEmployee"
                                              :name="param.param_name">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>

                                    <v-select v-else-if="param.component=='controlling_officer'"
                                              label="option_name"
                                              v-model="selectedControllingOfficer"
                                              :options="controllingOfficerOptions"
                                              @search="searchControllingOfficer"
                                              :name="param.param_name">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>

                                    <b-form-select
                                        v-else-if="param.component==='academic_yn'"
                                        :required="param.requied_yn == 'Y'"
                                        v-model="selectedAcademic"
                                        :options="academic_yn"
                                        @change="onChangeAcademicEmployee($event)"
                                        :name="param.param_name"></b-form-select>

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
                                    <input type="hidden" v-if="selectedEmployee!=null"  :value="custom.emp_code"  name="p_emp_code" />
                                    <input type="hidden" v-if="selectedEmployee!=null"  :value="custom.emp_code"  name="emp_code" />
                                    <input type="hidden" v-if="selectedEmployee!=null"  :value="custom.emp_code"  name="P_EMP_CODE"/>
                                    <input type="hidden" v-if="selectedControllingOfficer!=null"  :value="custom.reporting_officer_id"  name="P_REPORTING_OFFICER_ID"/>
                                    <input type="hidden" name="_token" v-model="csrf" />
                                    <b-button type="submit" variant="primary">Generate Report</b-button>
                                </b-col>
                        </b-row>
                    </b-form>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import ApiRepository from "../../../Repository/ApiRepository";
    import DatePicker from "vue2-datepicker";
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import axios from 'axios';
    import moment from 'moment'
    export default {
        components: {DatePicker, vSelect, vcss},
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.custom.emp_code = val.emp_code;
                    this.custom.emp_id = val.emp_id;
                }
            },
            selectedControllingOfficer: function (val, oldVal) {
                if(val.emp_id !== null){
                    this.custom.reporting_officer_id = val.emp_id
                }
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Report"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Attendance"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Summary"});
            this.loadData()
            this.loadDesignation(this.department_id)
        },
        data() {
            return {
                designations: [],
                allDesignations: [],
                empTypes:[],
                department_id:'',
                default_date: new Date(),
                custom:{
                    emp_code:"",
                    emp_id: "",
                    reporting_officer_id: ''
                },
                selectedEmployee: [],
                selectedControllingOfficer: [],
                empIdList: [],
                empSections: [],
                employeeOptions: [],
                controllingOfficerOptions: [],
                billcodes: [],
                months: [],
                departments: [],
                reports: [],
                academicEmp: [],
                attendance_status_options: [],
                prYears:[],
                academic_yn:[
                    {'text':'ALL', 'value':null},
                    {'text':'Academic', 'value': 'Y'},
                    {'text':'Non Academic', 'value': 'N'}
                ],
                typeOptions:[{'text':'PDF', 'value':'pdf'},{'text':'Excel', 'value':'xlsx'}],
                selectedType:'pdf',
                csrf:'',
                selected: null,
                selectedAcademic: null,
                report: {type: 'pdf', xdo: ''}
            };
        },
        methods: {
            onChangeReport(){
                this.report.params.forEach(function(el){
                    if(el.component == 'date' && el.report_param_id == 2568 && el.report_id == 946 || el.report_param_id == 2551 && el.report_id == 945){
                        el.default_value = moment().subtract(1, 'months').startOf('month').format("YYYY-MM-DD")
                    }else if(el.component=='date' && el.report_param_id != 2568 && el.report_id == 946 || el.report_param_id != 2551 && el.report_id == 945){
                        el.default_value = moment().subtract(1, 'months').endOf('month').format("YYYY-MM-DD")
                    }else {
                        el.default_value = moment(new Date()).format("YYYY-MM-DD")
                    }
                })
                console.log('param',this.report.params)
            },
            loadData: function () {
                this.csrf = axios.defaults.headers.common['X-CSRF-TOKEN'];
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/attendance/report-parameters?department_id=${this.department_id}`).then(res => {
                     // console.log(res.data);
                    this.billcodes = res.data.billcodes;
                    this.departments = res.data.departments;
                    this.allDesignations = res.data.designations;
                    this.designations = this.allDesignations;
                    this.empSections    = res.data.empSections;
                    this.empTypes=res.data.empTypes;
                    this.months = res.data.months;
                    this.prYears = res.data.prFiscalYears;
                    this.reports = res.data.reports;
                    this.attendance_status_options = res.data.attendanceStatus
                });
            },
            loadDesignation(id){
                if(id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/get-designation-by-department/${id}`).then(res => {
                        this.designations = res.data.designations;
                    });
                }else{
                    this.designations = this.allDesignations;
                }

            },
            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/emp/${id}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },

            searchControllingOfficer(id){
                if(id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/controlling-officer/${id}/${this.department_id}`).then(res => {
                        this.controllingOfficerOptions = res.data;
                    })
                }
            },

            controllingOfficerWiseEmployee(id){
                if(id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/controlling-officer-wise-employee/${id}/${this.custom.reporting_officer_id}`).then(res => {
                        this.employeeOptions = res.data;
                    })
                }
            },
            onChangeAcademicEmployee(event){
                // let value = this.val();
                if(event === 'Y'){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/academic-employee/`).then(res => {
                        console.log(res.data)
                        this.academicEmp = res.data;
                        this.employeeOptions.splice(0);
                        this.empIdList.splice(0);
                        this.empIdList = res.data;
                        this.employeeOptions = res.data;
                    })
                }else if(event === 'N' || event === null){
                    this.employeeOptions.splice(0);
                    this.empIdList.splice(0);
                }
            }


        },
        filters: {
            uppercase: function($val) {
                return $val.toUpperCase();
            }
        }
    };
</script>
