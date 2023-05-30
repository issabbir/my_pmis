<template>
    <div class="content-body">
        <div class="col-md-12 col-sm-12 border-right pr-md-0">
            <b-form @submit="onSubmit" @reset="onReset" method="post" >
                <b-card title="Search Employee">
                    <b-card-body class="border">
                        <b-row >
                            <b-col md="4" :style="departments.length == 1? 'pointer-events:none':''+ 'margin-left: -20px'" >
                                <b-form-group
                                    label="DEPARTMENT"
                                    label-for="department"
                                    label-cols-md="4"
                                    class="text-right "


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
                            <!--<b-col md="3">
                                <b-form-group
                                    label="Section"
                                    label-for="section"
                                    label-cols-md="4"
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
                            <b-col md="3">
                                <b-form-group
                                    label="Employee Code"
                                    label-for="emp_code"
                                    label-cols-md="4"
                                    class="text-right"
                                >
                                    <b-form-input id="emp_code"
                                                  v-model="employeeSearch.emp_code">
                                    </b-form-input>

                                </b-form-group>
                            </b-col>-->
                            <b-col md="4" :style="'margin-left: -20px'">
                                <b-form-group label="Employee Code / Name" label-for="emp_code" label-cols-md="3" class="text-right">
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
                            <b-col md="3" :style="'margin-left: -20px'">
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
                            <b-col md="1">
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
        components: { DatePicker, ViewButton, vSelect },
        watch: {
            dataUrl:function(url) {
                console.log(url);
            },
            department:function (val, oldVal) {
                if(val.department_id !== null) {
                    this.employeeSearch.department_id = val.department_id;
                } else {
                    this.employeeSearch.department_id = '';
                }
            },
            section:function (val, oldVal) {
                if(val !== null) {
                    this.employeeSearch.dpt_section_id = val.dpt_section_id;
                } else {
                    this.employeeSearch.dpt_section_id = '';
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
                selectedEmployee: {},
                department:{text:'ALL', value:null, department_id: null},
                section:{'text':'', 'value':''},
                selectedStatus: {text:'On Roll', value:1},
                dataUrl:'',
                employeeSearch: {
                    department_id:'null',
                    dpt_section_id:'null',
                    emp_grade_id: 'null',
                    designation_id:'null',
                    emp_status_id:1,
                    emp_code:null
                },
                reportUrl:'',
                reportParams: {
                    xdo:'/~weblogic/employee_list.xdo',
                    type:"pdf",
                    department_id:'',
                    emp_code: '',
                    emp_status_id: '',
                    filename:'Employee'
                },
                selected: 'first',
                emp_status: [],
                sections:[],
                statusOptions:[],
                departments:[],
                employeeOptions: [],
                text: '',
                columns: [
                    {
                        label: 'SL#',
                        name: 'rn',
                        filterable: false,
                        width: 5,
                    },
                    {
                        label: 'Employee code',
                        name: 'emp_code',
                        filterable: true,
                        width: 10,
                    },
                    {
                        label: 'Employee Name',
                        name: 'emp_name',
                        filterable: true,
                        width: 15,
                    },
                    {
                        label: 'Designation',
                        name: 'designation.designation',
                        filterable: true,
                        width: 20,
                    },
                    {
                        label: 'Department',
                        name: 'current_department.department_name',
                        filterable: true,
                        width: 20,
                    },
                    {
                        label: 'Join Date',
                        name: 'joindate',
                        filterable: true,
                        width: 10,
                    },
                    {
                        label: 'Status',
                        name: 'emp_status.emp_status',
                        filterable: true,
                        width: 10,
                    },
                    {
                        label: '',
                        name: 'Edit',
                        filterable: false,
                        classes: {
                            'btn': true,
                            'btn-primary': true,
                            'btn-sm': true,
                        },
                        event: "click",
                        handler: this.displayRow,
                        component: ViewButton,
                        width: 10,
                    },
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
         },
        methods: {
            displayRow(data) {
                this.$router.push('/basic-info-collection/'+data.emp_id);
            },
            searchLookups() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pmis/search-employees-for-basic").then(res => {
                    this.sections = res.data.sections;
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
            onSubmit(e) {
                e.preventDefault();
                this.employeeSearch.department_id = this.employeeSearch.department_id == null ? 'null' : this.employeeSearch.department_id
                let params = this.employeeSearch;
                let queryString = Object.keys(params).map(function(key) {
                    return params[key]
                }).join('/');
                this.renderPdf();
                this.dataUrl="/v1/pmis/employeeSearchForBasic/"+queryString;

            },
            onReset(evt) {
                evt.preventDefault();
                this.employeeSearch = {};
                this.dataUrl = "/v1/pmis/employeeSearchForBasic";
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length;
                this.currentPage = 1
            },
            renderPdf: function() {
                this.reportParams.department_id = this.employeeSearch.department_id;
                this.reportParams.emp_code = this.employeeSearch.emp_code;
                this.reportParams.emp_status_id = this.employeeSearch.emp_status_id?this.employeeSearch.emp_status_id: 'null';
                let params = this.reportParams;
                let queryString = Object.keys(params).map(function(key) {
                    return  key+"="+params[key]
                }).join('&');

                this.reportUrl = '/report/render?'+queryString;
            },
            searchEmployee(id){
                if (id) {

                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/providentFund/search-employees-dpt/${id}/${this.employeeSearch.department_id}`).then(res => {
                        this.employeeOptions = res.data;
                    })
                }
            },
        }
    }
</script>

