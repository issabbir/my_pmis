<template>
    <div class="content-body">
        <div id="stacked-pill">
            <div class="col-md-12">
                <div class="card bg-transparent border">
                    <div class="card-content">
                        <div class="card-body pt-1">
                            <div class="pills-stacked">
                                <div class="">
                                    <div class="col-md-12 col-sm-12 border-right pr-md-0">
                                        <b-form @submit="onSubmit" @reset="onReset" >
                                            <b-card
                                                title="Search Employee"
                                            >
                                                <b-row>
                                                    <b-col md="4">
                                                        <b-form-group
                                                            label="DEPARTMENT"
                                                            label-for="department"
                                                        >
                                                            <b-form-select
                                                                v-model="employeeSearch.department_id"
                                                                :options="departments"
                                                                class=""
                                                                value-field="value"
                                                                text-field="text"
                                                                disabled-field="notEnabled"
                                                            ></b-form-select>

                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="4">
                                                        <b-form-group
                                                            label="Section"
                                                            label-for="section"
                                                        >
                                                            <b-form-select
                                                                v-model="employeeSearch.dpt_section_id"
                                                                :options="sections"
                                                                class=""
                                                                value-field="value"
                                                                text-field="text"
                                                                disabled-field="notEnabled"
                                                            ></b-form-select>

                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="4">
                                                        <b-form-group
                                                                class=""
                                                                label="Date"
                                                                label-for="p_emp_dob"
                                                        >
                                                            <date-picker
                                                                         v-model="employeeSearch.date"
                                                                         width="100%"
                                                                         input-class="form-control"
                                                                         type="date" lang="en"
                                                                         required
                                                                         format="DD-MM-YYYY" :value-type="valueType" :editable="false" :not-after="notAfterToday()"
                                                                         name="emp_dob">
                                                            </date-picker>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="4">
                                                        <b-form-group
                                                            label="Employee Code"
                                                            label-for="employee_code"
                                                        >
                                                            <b-form-input
                                                                v-model="employeeSearch.emp_code"
                                                                type="text"
                                                                placeholder="Employee Code"
                                                            ></b-form-input>

                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="4">
                                                        <b-form-group
                                                                label="Employee Name"
                                                                label-for="employee_name"
                                                        >
                                                            <b-form-input
                                                                    id="employee_name"
                                                                    v-model="employeeSearch.emp_name"
                                                                    type="text"
                                                                    placeholder="Employee Name"
                                                            ></b-form-input>

                                                        </b-form-group>
                                                    </b-col>
                                                </b-row>

                                                <div class="col-md-12 pr-0 d-flex justify-content-end mt-1">
                                                    <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1">Search</b-button>
                                                <b-button type="reset" class="btn btn-outline-dark mr-1 mb-1">Reset</b-button>
                                            </div>
                                            </b-card>
                                        </b-form>
                                        <b-row>
                                            <b-col>
                                                <b-card title="Attendance employees">
                                                    <template>
                                                        <div class="content-wrapper">
                                                            <div class="content-body">
                                                                <data-table v-if="dataUrl" class="table-default"
                                                                        :columns="columns"
                                                                        :url="dataUrl" :classes='classess' :filterabe=true>
                                                                    <span slot="filters" slot-scope="{ tableData, perPage }">
                                                                        <b-row class="row mb-1">
                                                                            <b-col md="1">
                                                                                <select
                                                                                        v-model="tableData.length"
                                                                                        class="form-control">
                                                                                    <option
                                                                                            :key="index"
                                                                                            :value="records"
                                                                                            v-for="(records, index) in perPage">
                                                                                        {{records}}
                                                                                    </option>
                                                                                </select>
                                                                            </b-col>
                                                                            <b-col md="2">
                                                                                <router-link class="btn btn-dark" to="/attendance/Entry">Add attendance</router-link>
                                                                            </b-col>
                                                                        </b-row>
                                                                    </span>
                                                                </data-table>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </b-card>
                                            </b-col>
                                        </b-row>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import DatePicker from 'vue2-datepicker';
    import ApiRepository from '../../../Repository/ApiRepository';
    import Checkbox from '../../datatable/checkbox/Checkbox.vue';
    import moment from 'moment';

    export default {
        components: { DatePicker, Checkbox },
        data() {
            return {
                dataUrl: '/v1/leave/attendance/employees',
                valueType: this.dateFormatter(),
                employeeSearch: {
                    department: 'Administration',
                    payGrade: 'Grade-1',
                    jobStatus: 'Active',
                },
                selected: 'first',
                emp_status: [],
                sections:[],
                departments:[],
                attendance:{},
                attendance_status:[{"text": "Present", "value": "1"},{"text": "Leave with pay", "value": "1"}],
                text: '',
                columns: [
                    {
                        label: 'Employee code',
                        name: 'emp_code',
                        filterable: false,
                    },
                    {
                        label: 'Employee Name',
                        name: 'emp_name',
                        filterable: true,
                    },
                    {
                        label: 'Designation',
                        name: 'designation',
                        filterable: false,
                    },
                    {
                        label: 'In time',
                        name: 'in_time',
                        filterable: true,
                    },
                    {
                        label: 'Out time',
                        name: 'out_time',
                        filterable: false,
                    },
                    {
                        label: 'Work hours',
                        name: 'work_hours',
                        filterable: false,
                    },
                    {
                        label: 'Late In',
                        name: 'late_yn',
                        filterable: false,
                    },
                    {
                        label: 'Is Absent',
                        name: 'absent_yn',
                        filterable: false,
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
                }
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Info"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Search"});
            this.searchLookups();
         },
        methods: {
            selectRow(data) {
                alert(data);
            },
            searchLookups() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pmis/search-employees").then(res => {
                    this.sections = res.data.sections;
                    this.departments = res.data.departments;
                });
            },
            onSubmit(e) {
                e.preventDefault();
                let params = this.employeeSearch;
                let queryString = Object.keys(params).map(function(key) {
                    return key + '=' + params[key]
                }).join('&');
                this.dataUrl= "/v1/leave/attendance/employees?"+queryString;
                // ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pmis/employeeSearch", this.employeeSearch).then(res => {
                //     this.items = res.data.employees;
                // });
            },
            onReset(evt) {
                evt.preventDefault();
                this.employeeSearch = {};
                this.dataUrl = '/v1/leave/attendance/employees';
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
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
            notAfterToday() {
                return moment().subtract(1, 'days');
            },
        }
    }
</script>

