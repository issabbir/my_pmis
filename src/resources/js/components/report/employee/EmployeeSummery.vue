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
<!--                {{ quota }}-->
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
                                <b-form-select
                                    v-else-if="param.component=='punishment_type'"
                                    :required="param.requied_yn == 'Y'"
                                    v-model="param.default_value"report
                                    text-field="show_velue"
                                    value-field="passing_value"
                                    :options="punishmentTypeOptions"
                                    :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="">-- Please select an option --</option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-else-if="param.component=='month_id'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="prMonths"
                                               :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="">-- Please select an option --</option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-else-if="param.component=='pr_year'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="prYears" :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="">-- Please select an option --
                                        </option>
                                    </template>
                                </b-form-select>
                                <b-form-select
                                    v-else-if="param.component=='department_id' && (report.report_name != 'Employee Report')"
                                    @input="loadDesignation(param.default_value)"
                                    :required="param.requied_yn == 'Y'"
                                    v-model="param.default_value"
                                    :options="departments"
                                    :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="">-- Please select an option --</option>
                                    </template>
                                </b-form-select>
                                <b-form-select
                                    v-else-if="param.component=='department_id' && (report.report_name == 'Employee Report')"
                                    @input="loadDesignation(param.default_value)"
                                    :required="param.requied_yn == 'Y'"
                                    v-model="param.default_value"
                                    :options="departments"
                                    :name="param.param_name">
                                    <template v-slot:first>
                                        <option :value="null"> All </option>
                                    </template>
                                </b-form-select>
                                <b-form-select
                                    v-else-if="param.component=='designation_id' && (report.report_name != 'Employee Report')"
                                    :required="param.requied_yn == 'Y'"
                                    v-model="param.default_value"
                                    :options="designations"
                                    text-field="designation"
                                    value-field="designation_id"
                                    :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="">-- Please select an option --</option>
                                    </template>
                                </b-form-select>
                                <b-form-select
                                    v-else-if="param.component=='designation_id' && (report.report_name == 'Employee Report')"
                                    :required="param.requied_yn == 'Y'"
                                    v-model="param.default_value"
                                    :options="designations"
                                    text-field="designation"
                                    value-field="designation_id"
                                    :name="param.param_name">
                                    <template v-slot:first>
                                        <option :value="null"> All </option>
                                    </template>
                                </b-form-select>
                                <b-form-select
                                    v-else-if="param.component=='gender'"
                                    :required="param.requied_yn == 'Y'"
                                    v-model="param.default_value"
                                    :options="gender"
                                    text-field="gender_name"
                                    value-field="gender_id"
                                    :name="param.param_name">
                                    <template v-slot:first>
                                        <option :value="null"> All </option>
                                    </template>
                                </b-form-select>
                                <b-form-select
                                    v-else-if="param.component=='religion'"
                                    :required="param.requied_yn == 'Y'"
                                    v-model="param.default_value"
                                    :options="religion"
                                    text-field="religion"
                                    value-field="religion_id"
                                    :name="param.param_name">
                                    <template v-slot:first>
                                        <option :value="null"> All </option>
                                    </template>
                                </b-form-select>
                                <b-form-select
                                    v-else-if="param.component=='quota'"
                                    :required="param.requied_yn == 'Y'"
                                    v-model="param.default_value"
                                    :options="quota"
                                    text-field="quota_name"
                                    value-field="quota_id"
                                    :name="param.param_name">
                                    <template v-slot:first>
                                        <option :value="null"> All </option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-else-if="param.component=='fams_year'"
                                               :required="param.requied_yn == 'Y'"
                                               v-model="param.default_value" :options="fiscalYearOptions"
                                               value-field="fy_id"
                                               text-field="fy_name"
                                               :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="">-- Please select an option --</option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-else-if="param.component=='emp_status_id'"
                                               :required="param.requied_yn == 'Y'"
                                               v-model="param.default_value" :options="emp_status_options"
                                               :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="">-- Please select an option --</option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-else-if="param.component=='emp_status_with_active' && (report.report_name != 'Employee Report')"
                                               :required="param.requied_yn == 'Y'"
                                               v-model="param.default_value" :options="emp_status_with_active_options"
                                               :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="">-- Please select an option --</option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-else-if="param.component=='emp_status_with_active' && (report.report_name == 'Employee Report')"
                                               :required="param.requied_yn == 'Y'"
                                               v-model="param_default_value" :options="emp_status_with_active_options"
                                               :name="param.param_name">
                                    <template v-slot:first>
                                        <option :value="null"> All </option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-else-if="param.component=='monthYears'"
                                               :required="param.requied_yn == 'Y'" v-model="param.default_value"
                                               :options="monthYears" :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="">-- Please select an option --</option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-else-if="param.component=='tribalBonus'"
                                               :required="param.requied_yn == 'Y'" v-model="param.default_value"
                                               :options="tribalBonus" :name="param.param_name">
                                </b-form-select>
                                <b-form-select
                                    v-else-if="param.component=='empGrades' && (report.report_name != 'Employee Report')"
                                    :required="param.requied_yn == 'Y'"
                                    v-model="param.default_value"
                                    @change="onChangePayGrade(param.default_value)"
                                    :options="empGrades"
                                    :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="">-- Please select an option --</option>
                                    </template>
                                </b-form-select>
                                <b-form-select
                                    v-else-if="param.component=='empGrades' && (report.report_name == 'Employee Report')"
                                    :required="param.requied_yn == 'Y'"
                                    v-model="param.default_value"
                                    @change="onChangePayGrade(param.default_value)"
                                    :options="empGrades"
                                    :name="param.param_name">
                                    <template v-slot:first>
                                        <option :value="null"> All </option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-else-if="param.component=='empClasses' && (report.report_name != 'Employee Report')"
                                               :required="param.requied_yn == 'Y'" v-model="param.default_value"
                                               :options="empClasses" text-field="emp_class"
                                               value-field="emp_class" :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="">-- Please select an option --</option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-else-if="param.component=='empClasses' && (report.report_name == 'Employee Report')"
                                               :required="param.requied_yn == 'Y'" v-model="param.default_value"
                                               :options="empClasses" text-field="emp_class"
                                               value-field="emp_class" :name="param.param_name">
                                    <template v-slot:first>
                                        <option :value="null"> All </option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-else-if="param.component=='emp_type_id' && (report.report_name != 'Employee Report')"
                                               :required="param.requied_yn == 'Y'" v-model="param.default_value"
                                               :options="empTypes" text-field="emp_type_name" value-field="emp_type_id"
                                               :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="">-- Please select an option --</option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-else-if="param.component=='emp_type_id' && (report.report_name == 'Employee Report')"
                                               :required="param.requied_yn == 'Y'" v-model="param.default_value"
                                               :options="empTypes" text-field="emp_type_name" value-field="emp_type_id"
                                               :name="param.param_name">
                                    <template v-slot:first>
                                        <option :value="null"> All </option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-else-if="param.component=='desc_join'"
                                               :required="param.requied_yn == 'Y'" v-model="param.default_value"
                                               :options="joinList" :name="param.param_name">
                                    <template v-slot:first>
                                        <option value="">-- Please select an option --</option>
                                    </template>
                                </b-form-select>
                                <!--                                <v-select v-else-if="param.component=='monthYears'" :required="param.requied_yn == 'Y'" v-model="param.default_value" :options="monthYears"-->
                                <!--                                          :name="param.param_name" label="text">-->
                                <!--                                    <template #search="{attributes, events}">-->
                                <!--                                        <input class="vs__search" v-bind="attributes" v-on="events"/>-->
                                <!--                                    </template>-->
                                <!--                                </v-select>-->
                                <b-form-select
                                    v-else-if="param.component=='division'"
                                    v-model="divisions"
                                    @input="geoDivisionChange"
                                    :options="division_ids"
                                    :selected="selected"
                                    :name="param.param_name">
                                    <template v-slot:first>
                                        <option :value="null"> ALL </option>
                                    </template>
                                </b-form-select>
                                <b-form-select
                                    v-else-if="param.component=='district'"
                                    v-model="districts"
                                    @input="geoDistrictChange"
                                    :options="district_ids"
                                    :name="param.param_name">
                                    <template v-slot:first>
                                        <option :value="null"> ALL </option>
                                    </template>
                                </b-form-select>
                                <b-form-select
                                    v-else-if="param.component=='thana'"
                                    v-model="thanas"
                                    :options="thana_ids"
                                    :name="param.param_name">
                                    <template v-slot:first>
                                        <option :value="null"> ALL </option>
                                    </template>
                                </b-form-select>
                                <b-form-select
                                    v-else-if="param.component=='per_division'"
                                    v-model="per_divisions"
                                    @input="geoPerDivisionChange"
                                    :options="per_division_ids"
                                    :name="param.param_name">
                                    <template v-slot:first>
                                        <option :value="null"> ALL </option>
                                    </template>
                                </b-form-select>
                                <b-form-select
                                    v-else-if="param.component=='per_district'"
                                    v-model="per_districts"
                                    @input="geoPerDistrictChange"
                                    :options="per_district_ids"
                                    :name="param.param_name">
                                    <template v-slot:first>
                                        <option :value="null"> ALL </option>
                                    </template>
                                </b-form-select>
                                <b-form-select
                                    v-else-if="param.component=='per_thana'"
                                    v-model="per_thanas"
                                    :options="per_thana_ids"
                                    :name="param.param_name">
                                    <template v-slot:first>
                                        <option :value="null"> ALL </option>
                                    </template>
                                </b-form-select>
                                <v-select v-else-if="param.component=='department_wise_employee'"
                                          label="option_name"
                                          v-model="selectedEmployee"
                                          :options="empIdList"
                                          @search="departmentWiseEmployee"
                                          :name="param.param_name">
                                    <template #selected-option="{ emp_code }">
                                        <div style="display: flex; align-items: baseline;">
                                            {{ emp_code }}
                                        </div>
                                    </template>
                                </v-select>

                                <v-select v-else-if="param.component=='emp_ids' && (report.report_name != 'Employee Details Report' && report.report_name != 'Employee Profile')"
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
                                <v-select v-else-if="param.component=='emp_ids' && (report.report_name == 'Employee Details Report' || report.report_name == 'Employee Profile')"
                                          label="option_name"
                                          v-model="selectedEmployee"
                                          :options="empIdList"
                                          @search="searchEmpCodeByDepartment"
                                          :name="param.param_name">
                                    <template #selected-option="{ emp_code }">
                                        <div style="display: flex; align-items: baseline;">
                                            {{ emp_code }}
                                        </div>
                                    </template>
                                </v-select>
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
                            <input type="hidden" v-if="selectedEmployee!=null"  :value="selectedEmployee.emp_code"  name="p_emp_code"></input>
                            <input type="hidden" v-if="selectedEmployee!=null"  :value="selectedEmployee.emp_code"  name="emp_code"></input>
                            <input type="hidden" v-if="selectedEmployee!=null"  :value="selectedEmployee.emp_code"  name="P_EMP_CODE"></input>
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
    import DatePicker from "vue2-datepicker";
    import axios from 'axios';
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
            department_id(val, oldVal){
                this.selectedEmployee = null
                this.empIdList = []
            }

        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Report"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Summary"});
            this.loadData();
            this.loadFiscalYears()
            this.loadPunishmentType()
        },
        data() {
            return {
                punishmentTypeOptions: [],
                custome:{emp_code:""},
                selectedEmployee: {},
                empIdList: [],
                billcodes: [],
                prMonths: [],
                departments: [],
                designations: [],
                allDesignations: [],
                emp_status_options: [],
                param_default_value: '1',
                emp_status_with_active_options: [],
                reports: [],
                prYears:[],
                monthYears:[],
                empGrades:[],
                empClasses:[],
                empTypes:[],
                tribalBonus:[
                    {'text':'ALL', 'value':null},
                    {'text':'YES', 'value':'Y'},
                    {'text':'NO', 'value':'N'}
                ],
                gender:[],
                religion:[],
                divisions: null,
                districts: null,
                thanas: null,
                per_divisions: null,
                per_districts: null,
                per_thanas: null,
                division_ids: [{'text':'', 'value': ''}],
                district_ids: [{'value': '', 'text': ''}],
                thana_ids: [{'value': '', 'text': ''}],
                per_division_ids: [{'value': '', 'text': ''}],
                per_district_ids: [{'value': '', 'text': ''}],
                per_thana_ids: [{'value': '', 'text': ''}],
                quota: [{'value': '', 'text': ''}],
                typeOptions:[{'text':'PDF', 'value':'pdf'},{'text':'Excel', 'value':'xlsx'}],
                joinList:[
                    {'text':'Join Date', 'value':1},
                    {'text':'PRL Date', 'value':2}
                ],
                address: {
                    emp_address_id: '',
                    address_type_id:'',
                    address_line_1:'',
                    address_line_1_bng:'',
                    address_line_2:'',
                    address_line_2_bng:'',
                    division_id:'',
                    district_id:'',
                    thana_id:'',
                    post_code:'',
                    same_as:'N',
                    old_division_id:'',
                    old_district_id:'',
                    approved_yn: 'N'
                },
                selectedType:'pdf',
                csrf:'',
                report: {type: 'pdf', xdo: ''},
                fiscalYearOptions: [],
            };
        },
        watch: {
            divisions:function(val,oldVal) {
                if(val !== null) {
                    this.address.division_id = val;
                } else {
                    this.address.division_id = '';
                }
            },
            districts:function(val,oldVal) {
                if(val !== null) {
                    this.address.district_id = val;
                } else {
                    this.address.district_id = '';
                }
            },
            thanas:function(val,oldVal) {
                if(val !== null) {
                    this.address.thana_id = val;
                } else {
                    this.address.thana_id = '';
                }
            }
        },
        methods: {
            loadData: function () {
                this.csrf = axios.defaults.headers.common['X-CSRF-TOKEN'];
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pmis/employee/report-parameters").then(res => {
                    // console.log(res)
                    this.billcodes = res.data.billcodes;
                    this.departments = res.data.departments;
                    this.allDesignations = res.data.designations;
                    this.designations = this.allDesignations
                    this.emp_status_options = res.data.emp_status;
                    this.emp_status_with_active_options = [...res.data.emp_status];
                    this.emp_status_with_active_options.unshift({emp_status_id: 100, emp_status: 'Running', value: 100, text:'Running'})
                    this.prMonths = res.data.prMonths;
                    this.prYears = res.data.prFiscalYears;
                    this.monthYears=res.data.monthYears;
                    this.empGrades=res.data.empGrades;
                    this.empClasses=res.data.empClass;
                    this.empTypes=res.data.empTypes;
                    this.reports = res.data.reports;
                    this.gender = res.data.gender;
                    this.religion = res.data.religion;
                    this.division_ids = res.data.division_ids;
                    this.per_division_ids = res.data.division_ids;
                    this.quota = res.data.quota;
                    // if(this.division_ids.length <=1) {
                    // }
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
            departmentWiseEmployee(emp_name) {
                if (emp_name) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/department-wise-employee/${emp_name}/${this.department_id}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            loadFiscalYears(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/api/fiscal-year`).then(res => {
                    this.fiscalYearOptions = res.data.data.fiscal_year
                    console.log(this.fiscalYearOptions)
                })
            },
            loadPunishmentType(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/get-lookup-data/PUNISHMENT`).then(res => {
                    this.punishmentTypeOptions = res.data.punishments
                })
            },
            searchEmpCodeByDepartment(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/providentFund/search-employees-dpt/${id}/${this.department_id}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            loadDesignation(id){
                if(id){
                    this.department_id = id
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/get-designation-by-department/${id}`).then(res => {
                        if(this.grade_id){
                            this.designations = res.data.designations.filter(a=>a.grade_id == this.grade_id);
                        }else {
                            this.designations = res.data.designations;
                        }

                    });
                }else{
                    this.department_id = null
                    if(this.grade_id){
                        this.designations = this.allDesignations.filter(a=>a.grade_id == this.grade_id);
                    }else {
                        this.designations = this.allDesignations;
                    }
                }

            },
            onChangePayGrade(id){
                if(id){
                    this.grade_id = id
                    if(this.department_id){
                        ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/get-designation-by-department/${this.department_id}`).then(res => {
                            this.designations = res.data.designations.filter(a=>a.grade_id == id);
                        });
                    }else{
                        this.designations = this.allDesignations.filter(a=>a.grade_id == id)
                    }
                }else {
                    this.grade_id = null
                    if(this.department_id){
                        ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/get-designation-by-department/${this.department_id}`).then(res => {
                            this.designations = res.data.designations;
                        });
                    }else{
                        this.designations = this.allDesignations
                    }
                }


            },
            geoDivisionChange(id){
                let division_id = this.divisions;
                // console.log(division_id)
                if(this.address.old_division_id){
                    if(division_id!==this.address.old_division_id){
                        this.districts = {
                            text: '',
                            value: ''
                        };
                        this.thanas = {
                            text: '',
                            value: ''
                        };
                    }
                } else {
                    this.districts = {
                        text: '',
                        value: ''
                    };
                    this.thanas = {
                        text: '',
                        value: ''
                    };
                }
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/geo-districts/${division_id}`).then(result => {
                    this.district_ids = result.data;
                });
            },
            geoDistrictChange(id){
                if(id){
                    let district_id = this.districts;
                    console.log(district_id)
                    if(this.address.old_district_id){
                        if(district_id!=this.address.old_district_id){
                            this.thanas={
                                text: '',
                                value: ''
                            };
                        }
                    } else {
                        this.thanas={
                            text: '',
                            value: ''
                        };
                    }
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/geo-thanas/${district_id}`).then(result => {
                        this.thana_ids = result.data;
                    });
                }
            },
            geoPerDivisionChange(id){
                let per_division_id = this.per_divisions;
                console.log(per_division_id)
                if(this.address.old_division_id){
                    if(division_id!==this.address.old_division_id){
                        this.districts = {
                            text: '',
                            value: ''
                        };
                        this.thanas = {
                            text: '',
                            value: ''
                        };
                    }
                } else {
                    this.districts = {
                        text: '',
                        value: ''
                    };
                    this.thanas = {
                        text: '',
                        value: ''
                    };
                }
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/geo-districts/${per_division_id}`).then(result => {
                    this.per_district_ids = result.data;
                });
            },
            geoPerDistrictChange(id){
                if(id){
                    let district_id = this.per_districts;
                    console.log(district_id)
                    if(this.address.old_district_id){
                        if(district_id!=this.address.old_district_id){
                            this.thanas={
                                text: '',
                                value: ''
                            };
                        }
                    } else {
                        this.thanas={
                            text: '',
                            value: ''
                        };
                    }
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/geo-thanas/${district_id}`).then(result => {
                        this.per_thana_ids = result.data;
                    });
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
<style>
    .vs__dropdown-menu {
        display: table-caption;
        position: relative;
        top: calc(100% - 1px);
        left: 0;
        padding: 5px 0;
        margin: 0;
        width: 100%;
        max-height: 350px;
        min-width: 160px;
        overflow-y: auto;
        box-shadow: 0 3px 6px 0 rgb(0 0 0 / 15%);
        border: 1px solid rgba(60,60,60,.26);
        border-top-style: none;
        border-radius: 0 0 4px 4px;
        text-align: left;
        list-style: none;
        background: #fff;
    }
</style>
