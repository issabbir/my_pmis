<template>
    <div class="content-body">
        <div class="col-md-12 col-sm-12 pr-md-0">
            <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" method="post" >
                <b-card title="Search Employees">
                    <b-card-body class="border">
                        <b-row>
<!--                            :style="departments.length == 1? 'pointer-events:none':''"-->
                            <b-col md="4" :style="departments.length == 1? 'pointer-events:none':''">
                                <b-form-group
                                    label="DEPARTMENT"
                                    label-for="department"
                                    label-cols-md="3"
                                    class="text-right"
                                >
                                    <v-select v-model="department" :options="departments"
                                              name="department" id="department" label="text"
                                              v-validate="'required'"
                                              class="uppercase required">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                        </template>

                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Section"
                                    label-for="section"
                                    label-cols-md="3"
                                    class="text-right"
                                >
                                    <v-select v-model="section" :options="sections"
                                              name="section" id="section" label="text"
                                              v-validate="'required'"
                                              class="uppercase required">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Pay Grade" label-for="grade" label-cols-md="3" class="text-right">
                                    <v-select
                                        label="text"
                                        v-model="selectedGrade"
                                        :options="gradeOptions"
                                        id="grade">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Actual Grade" label-for="actual_grade" label-cols-md="3" class="text-right">
                                    <v-select
                                        label="text"
                                        v-model="actualSelectedGrade"
                                        :options="actualGradeOptions"
                                        id="actual_grade">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Designation" label-for="designation" label-cols-md="3" class="text-right">
                                    <v-select
                                        label="designation"
                                        v-model="selectedDesignation"
                                        :options="designationOptions"
                                        id="designation">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group label="Employee Code" label-for="emp_code" label-cols-md="3" class="text-right">
                                    <v-select
                                        label="option_name"
                                        v-model="selectedEmployee"
                                        :options="employeeOptions"
                                        @search="searchEmployee"
                                        id="emp_code">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Status" label-for="status" label-cols-md="3" class="text-right">
                                    <v-select
                                        label="text"
                                        v-model="selectedStatus"
                                        :options="statusOptions"
                                        id="status">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                  label="Deputation Status"
                                  label-for="deputation_yn"
                                  label-cols-md="3"
                                  v-slot="{ ariaDescribedby }"
                                  class="text-right">
                                    <b-form-radio-group
                                      id="deputation_yn"
                                      v-model="employeeSearch.deputation_yn"
                                      :options="options"
                                      :aria-describedby="ariaDescribedby"
                                      name="radio-options"
                                    ></b-form-radio-group>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Active Status"
                                    label-for="emp_active_yn"
                                    label-cols-md="3"
                                    v-slot="{ emp_active_yn }"
                                    class="text-right">
                                    <b-form-radio-group
                                        id="emp_active_yn"
                                        v-model="employeeSearch.emp_active_yn"
                                        :options="activeOptions"
                                        :aria-describedby="emp_active_yn"
                                        name="emp_active_yn"
                                    ></b-form-radio-group>
                                </b-form-group>
                            </b-col>
                            <b-col class="d-flex justify-content-end align-items-end">
                                <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1">Search</b-button>
                            </b-col>
                        </b-row>
                    </b-card-body>
                </b-card>
            </b-form>

            <b-card  v-if="dataUrl">
                <b-card-body class="border">
                    <b-row class="mb-1">
                        <b-col align-self="end" class="float-right">
                            <b-button-group size="sm" v-if="reportUrl"  >
                                <a :href="reportUrl" class="btn btn-dark" target="_blank">Render to PDF</a>
                            </b-button-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>
                            <data-table  class="table-default"
                                :columns="columns"
                                :url="dataUrl" :classes='classess' >
                                <div slot="filters" slot-scope="{ tableData, perPage }">
                                    <div class="row mb-2">
                                        <div class="col-md-4">
                                            <select class="form-control" v-model="tableData.length">
                                                <option :key="page" v-for="page in perPage">{{ page }}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <select v-if="false"
                                                    v-model="tableData.filters.isAdmin"
                                                    class="form-control">
                                                <option value>Dis</option>
                                                <option value='admin'>Admin</option>
                                                <option value='staff'>Staff</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input
                                                    name="name"
                                                    class="form-control"
                                                    v-model="tableData.search"
                                                    placeholder="Search Table">
                                        </div>
                                    </div>
                                </div>
                        </data-table>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    import DatePicker from 'vue2-datepicker';
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from '../../Repository/ApiRepository';
    import ViewButton from './ViewButton';
    import axios from 'axios';
    import vSelect from 'vue-select';

    export default {
        components: { DatePicker, ViewButton, vSelect},
        watch: {
            dataUrl:function(url) {
            },

            department:function (val, oldVal) {
                console.log('department', val.department_id)
                if(val.department_id !== null) {
                    this.sections = this.oldSections.filter(a=>a.department_id == val.department_id)
                    if(this.employeeSearch.emp_grade_id != 'null'){
                        this.designationOptions = this.oldDesignations.filter(a=>a.department_id == val.department_id && a.grade_id == this.employeeSearch.emp_grade_id)
                        this.selectedDesignation = null
                    } else {
                        this.designationOptions = this.oldDesignations.filter(a=>a.department_id == val.department_id)
                        this.selectedDesignation = null
                    }
                    this.employeeSearch.department_id = val.department_id;
                } else {
                    this.sections = this.oldSections
                    this.employeeSearch.department_id = 'null';
                    if(this.employeeSearch.emp_grade_id != 'null'){
                        this.designationOptions = this.oldDesignations.filter(a=>a.grade_id == this.employeeSearch.emp_grade_id)
                        this.selectedDesignation = null
                    } else {
                        this.designationOptions = this.oldDesignations
                        this.selectedDesignation = null
                    }

                }
            },
            section:function (val, oldVal) {
                if(val !== null) {
                    this.employeeSearch.dpt_section_id = val.dpt_section_id;
                } else {
                    this.employeeSearch.dpt_section_id = 'null';
                }
            },
            selectedEmployee: function (val, oldVal) {
                if(val !== null) {
                    this.employeeSearch.emp_code = val.emp_code;
                    this.selectedStatus = {'text':val.emp_status, 'value':val.emp_status_id};
                } else {
                    this.employeeSearch.emp_code = null;
                }
            },
            selectedDesignation: function (val, oldVal) {
                if(val !== null) {
                    this.employeeSearch.designation_id = val.designation_id;
                } else {
                    this.employeeSearch.designation_id = 'null';
                }
            },
            actualSelectedGrade: function (val, oldVal) {
                if(val !== null) {
                    this.employeeSearch.actual_grade_id = val.value;
                } else {
                    this.employeeSearch.actual_grade_id = 'null';
                }
            },
            selectedGrade: function (val, oldVal) {

                if(val !== null) {
                    if(this.employeeSearch.department_id != 'null' && this.employeeSearch.department_id != null ){
                        this.designationOptions = this.allDesignationOptions.filter(a=>a.grade_id == val.value && a.department_id == this.employeeSearch.department_id)
                        this.selectedDesignation = null
                    }else {
                        this.designationOptions = this.allDesignationOptions.filter(a=>a.grade_id == val.value)
                        this.selectedDesignation = null
                    }
                    this.employeeSearch.emp_grade_id = val.value;
                } else {
                    if(this.employeeSearch.department_id != 'null' && this.employeeSearch.department_id != null ){
                        this.designationOptions = this.allDesignationOptions.filter(a=> a.department_id == this.employeeSearch.department_id)
                        this.selectedDesignation = null
                    }else {
                        this.designationOptions = this.allDesignationOptions
                        this.selectedDesignation = null
                    }
                    this.employeeSearch.emp_grade_id = 'null';
                }
            },
            selectedStatus:function (val, oldVal) {
                if(val !== null) {
                    this.employeeSearch.emp_status_id = val.value;
                } else {
                    this.employeeSearch.emp_status_id = 'null';
                }
            }

        },
        data() {
            return {
                options: [
                    { text: 'Yes', value: 'Y' },
                    { text: 'No', value: 'N' },
                ],
                activeOptions: [
                    { text: 'Yes', value: 'Y' },
                    { text: 'No', value: 'N' },
                ],
                oldDesignations: [],
                selectedDesignation: {},
                designationOptions:[],
                statusOptions:[],
                allDesignationOptions:[],
                selectedGrade:{},
                actualSelectedGrade:{},
                gradeOptions: [],
                actualGradeOptions: [],
                selectedEmployee: {},
                selectedStatus: {'text':'On Roll', 'value':1},
                employeeOptions: [],
                department:{'text':'ALL', 'value':null, department_id: null},
                section:{'text':'', 'value':''},
                dataUrl:'',
                employeeSearch: {
                    department_id:'null',
                    dpt_section_id:'null',
                    emp_grade_id: 'null',
                    designation_id:'null',
                    emp_status_id:1,
                    deputation_yn: 'N',
                    emp_active_yn: 'Y',
                    actual_grade_id: null,
                    emp_code:null
                },
                reportUrl:'',
                reportParams: {
                    xdo:'/~weblogic/employee_list.xdo',
                    type:"pdf",
                    department_id:'',
                    dpt_section_id: '',
                    emp_grade_id: '',
                    designation_id: '',
                    emp_code: '',
                    emp_status_id: '',
                    filename:'Employee'
                },
                selected: 'first',
                emp_status: [],
                sections:[],
                oldSections:[],
                departments:[],
                text: '',
                columns: [
                    {label: 'SL#', name: 'rn', filterable: false, width: 5},
                    {label: 'Employee code', name: 'emp_code', filterable: true, width: 10},
                    {label: 'Employee Name', name: 'emp_name', filterable: true, width: 15},
                    {label: 'Designation', name: 'designation.designation', filterable: true, width: 15},
                    {label: 'Department', name: 'department.department_name', filterable: true, width: 15,},
                    {label: 'Join Date', name: 'joindate', filterable: true, width: 15},
                    {label: 'PRL Date', name: 'lprdate', filterable: true, width: 15},
                    {label: '', name: 'Edit', filterable: false, classes: {'btn': true, 'btn-primary': true, 'btn-sm': true,}, event: "click", handler: this.displayRow, component: ViewButton, width: 10},
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
                    "t-head": {

                    },
                    "t-body": {

                    },
                    "t-head-tr": {

                    },
                    "t-body-tr": {

                    },
                    "td": {

                    },
                    "th": {

                    },
                }            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Search"});
            this.searchLookups();
            this.loadDesignations()
            this.loadGrades()
        },
        methods: {
            searchEmployee(id){
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/emp/${id}`).then(res => {
                        this.employeeOptions = res.data;
                    })
                }
            },
            loadDesignations(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/employee-position/designations`).then(res => {

                    this.oldDesignations = res.data.table_info
                    this.allDesignationOptions = res.data.table_info
                    this.designationOptions = this.allDesignationOptions
                })
            },
            loadGrades(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pmis/all-grades").then(res => {
                    this.gradeOptions = res.data;
                });
            },
            displayRow(data) {
                this.$router.push('/employee/basic-info/'+data.emp_id);
            },
            searchLookups() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pmis/search-employees").then(res => {
                    console.log(res)
                    this.actualGradeOptions = res.data.actualGrade;
                    this.sections = res.data.sections;
                    this.oldSections = this.sections;
                    this.departments = res.data.departments;
                    this.statusOptions = res.data.status;
                    if(res.data.departments.length == 1){
                        this.department = {
                            text: res.data.departments[0].text,
                            value: res.data.departments[0].value,
                            department_id: res.data.departments[0].value
                        }
                    }
                });
            },
            onSubmit() {
                this.employeeSearch.department_id = this.employeeSearch.department_id == null ? 'null' : this.employeeSearch.department_id
                if(this.employeeSearch.emp_code){
                    this.employeeSearch.actual_grade_id = this.employeeSearch.actual_grade_id == null ? 'null' : this.employeeSearch.actual_grade_id
                }

                let params = this.employeeSearch;
                let queryString = Object.keys(params).map(function(key) {
                    return params[key]
                }).join('/');
                this.renderPdf();
                this.dataUrl="/v1/pmis/employeeSearch/"+queryString;
            },
            onReset() {
                this.employeeSearch = {};
                this.dataUrl = "/v1/pmis/employeeSearch";
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            renderPdf: function() {
                this.reportParams.department_id = this.employeeSearch.department_id;
                this.reportParams.dpt_section_id = this.employeeSearch.dpt_section_id;
                this.reportParams.emp_grade_id = this.employeeSearch.emp_grade_id;
                this.reportParams.designation_id = this.employeeSearch.designation_id;
                this.reportParams.emp_code = this.employeeSearch.emp_code;
                this.reportParams.emp_status_id = this.employeeSearch.emp_status_id?this.employeeSearch.emp_status_id: 'null';
                let params = this.reportParams;
                let queryString = Object.keys(params).map(function(key) {
                    return  key+"="+params[key]
                }).join('&');

                this.reportUrl = '/report/render/Employees?'+queryString;
            },
        }
    }
</script>

