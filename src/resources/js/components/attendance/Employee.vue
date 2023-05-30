<template>
    <div class="content-wrapper">
        <div class="content-body">
            <div id="stacked-pill" v-if="employeeDetails" >
                <b-card>
                    <b-card-header header-bg-variant="dark" header-text-variant="white">Search Employees</b-card-header>
                    <b-card-body class="border">
                        <b-form @submit="onSubmit" @reset="onReset" >
                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                        label="DEPARTMENT"
                                        label-for="department"
                                        class="requiredField">
                                        <b-form-select
                                            v-model="employeeSearch.department_id"
                                            :options="departments"
                                            class=""
                                            name="departments"
                                            v-validate="'required'"  :allow-empty="false" :reset-after="false"
                                            value-field="value"
                                            text-field="text"
                                            disabled-field="notEnabled"
                                            @change="onChangeDepartment(employeeSearch.department_id)"
                                        ></b-form-select>
                                        <span :style="errorMessage">{{ errors.first('departments') }}</span>

                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Section"
                                        label-for="section">
                                        <b-form-select
                                            v-model="employeeSearch.dpt_section_id"
                                            :options="sectionOptions"
                                            class=""
                                            value-field="value"
                                            text-field="text"
                                            disabled-field="notEnabled"
                                        ></b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Employee"
                                        label-for="employee_code">
                                        <v-select
                                                label="option_name"
                                                v-model="selectedEmployee"
                                                :options="empIdList"
                                                @search="searchEmployeeCodes">
                                            <template #search="{attributes, events}">
                                                <input
                                                        class="vs__search"
                                                        v-bind="attributes"
                                                        v-on="events"
                                                />
                                            </template>
                                        </v-select>

                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                            label="From Date"
                                            label-for="p_emp_dob"
                                            class="requiredField"
                                    >
                                        <date-picker
                                                    v-model="employeeSearch.from_date"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date" lang="en"
                                                    name="from date"
                                                    v-validate="'required'"  :allow-empty="false" :reset-after="false"
                                                    format="DD-MM-YYYY" :value-type="valueType" :editable="false"
                                                    >
                                        </date-picker>
                                        <span :style="errorMessage">{{ errors.first('from date') }}</span>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                            label="To Date"
                                            class="requiredField"
                                            label-for="p_emp_dob"
                                    >
                                        <date-picker
                                                    v-model="employeeSearch.to_date"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date" lang="en"
                                                    name="to date"
                                                    v-validate="'required'"  :allow-empty="false" :reset-after="false"
                                                    format="DD-MM-YYYY" :value-type="valueType" :editable="false"
                                                    >
                                        </date-picker>
                                        <span :style="errorMessage">{{ errors.first('to date') }}</span>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                            label="Type"
                                            label-for="type"
                                    >
                                        <b-form-select
                                            v-model="employeeSearch.type"
                                            :options="leave_type_list"
                                            class=""
                                            value-field="value"
                                            text-field="text"
                                        >
                                            <template v-slot:first>
                                                <b-form-select-option :value="null">-- Please select a type --</b-form-select-option>
                                            </template>
                                        </b-form-select>

                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <div class="col-md-12 pr-0 d-flex justify-content-end mt-1">
                                <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1">Search</b-button>
                                <b-button type="reset" class="btn btn-outline-dark mr-1 mb-1">Reset</b-button>
                            </div>
                            </b-form>
                    </b-card-body>
                </b-card>
                <b-card>
                    <b-card-header header-bg-variant="dark" header-text-variant="white">Attendance Employees</b-card-header>
                    <b-card-body class="border">
                        <!--    <data-table v-if="dataUrl" class="table-default"-->
                        <!--    :columns="columns"-->
                        <!--    :url="dataUrl" :classes='classess' :filterabe=true>-->
                        <!--    <span slot="filters" slot-scope="{ tableData, perPage }">-->
                        <!--    <b-row class="row mb-1">-->
                        <!--    <b-col md="1">-->
                        <!--    <select-->
                        <!--    v-model="tableData.length"-->
                        <!--    class="form-control">-->
                        <!--     <option-->
                        <!--      :key="index"-->
                        <!--        :value="records"-->
                        <!--         v-for="(records, index) in perPage">-->
                        <!--        {{records}}-->
                        <!--        </option>-->
                        <!--          </select>-->
                        <!--          </b-col>-->
                        <!--        <b-col md="2">-->
                        <!--         <router-link class="btn btn-dark" to="/attendance/Entry">Add attendance</router-link>-->
                        <!--       </b-col>-->
                        <!--    </b-row>-->
                        <!--   </span>-->
                        <!--  </data-table>-->
                        <Datatable v-bind:fields="columns" :totalList="totalList" :perPage="perPage" v-bind:items="items"  v-bind:pageColSize="4" v-bind:searchColSize="5" :primaryKeyColumnName="'roster_date'">
                            <template  v-slot:action2="{ rows }">
                                <a href="#" @click.prevent="detailsAttendance(rows.item.emp_id,rows.item.date_from,rows.item.date_to)"><i class="bx bx-detail cursor-pointer"></i></a>
                            </template>
                        </Datatable>
                    </b-card-body>
                </b-card>
            </div>
            <div v-if="attendanceDetails">
                <b-form @submit="onSubmit" @reset="onReset" >
                    <div class="pr-0 d-flex justify-content-start mt-1">
                        <b-button  type="button" id="basic_sub_btns" @click="backToEmployee" class="btn btn-dark shadow mr-1 mb-1"><i class="bx bx-arrow-back cursor-pointer"></i> Back</b-button>
                    </div>
                    <b-card>
                        <b-card-header header-bg-variant="dark" header-text-variant="white">Employees Details</b-card-header>
                        <b-card-body class="border">
                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                        label="Employee Code"
                                        label-for="emp_code"
                                    >
                                    <b-form-input v-model="employee_details.emp_code"  disabled  type="text" placeholder="Holiday"></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Employee Name"
                                        label-for="emp_code"
                                    >
                                    <b-form-input v-model="employee_details.emp_name"  disabled  type="text" placeholder="Holiday"></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Department Name"
                                        label-for="emp_code"
                                    >
                                    <b-form-input v-model="employee_details.department.department_name"  disabled  type="text" placeholder="Holiday"></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-card-body>
                    </b-card>
                </b-form>
                <b-card>
                    <b-card-header header-bg-variant="dark" header-text-variant="white">Attendance Employees</b-card-header>
                    <b-card-body class="border">
                        <Datatable v-bind:fields="fields"
                        :totalList="totalListAttentdance"
                        :perPage="perPageAttendance"
                        v-bind:items="attentdance"
                        :primaryKeyColumnName="'roster_date'">
                        </Datatable>
                    </b-card-body>
                </b-card>
            </div>
        </div>
    </div>
</template>

<script>

    import DatePicker from 'vue2-datepicker';
    import vSelect from 'vue-select';
    import ApiRepository from '../../Repository/ApiRepository';
    import Checkbox from '../datatable/checkbox/Checkbox.vue';
    import moment from 'moment';
    import Datatable from '../../layouts/common/datatable';

    export default {
        components: { Datatable, DatePicker, Checkbox, vSelect },
        data() {
            return {
                dataUrl: '/v1/leave/attendance/employees',
                errorMessage: {color: 'red'},
                valueType: this.dateFormatter(),
                employeeSearch: {
                    department: '',
                    payGrade: '',
                    selectedEmployee: null,
                    type:null,
                    from_date: new Date(),
                    to_date: new Date()
                },
                employee_details: {
                    department: {
                        department_name:null
                    }
                },
                selected: 'first',
                emp_status: [],
                sections:[],
                sectionOptions:[],
                departments:[],
                attendance:{},
                empIdList: [],
                totalList: 0,
                totalListAttentdance: 0,
                perPage: 5,
                perPageAttendance: 31,
                attendanceDetails: false,
                employeeDetails: true,
                require_employee: true,
                selectedEmployee: {'option_name':'','emp_id':'', 'emp_name':''},
                leave_type_list:[],
                attendance_type_list:[
                        {"text": "Select One", "value": null},
                        {"text": "Absent", "value": "absent"},
                        {"text": "Unauthorized Absent", "value": "unauthorized_absent"},
                        {"text": "Sick Leave", "value": "sick_leave"},
                        {"text": "Early  Leave", "value": "early_leave"},
                        {"text": "Maternity  Leave", "value": "maternity_leave"},
                        {"text": "Late  Attendance", "value": "late_attendance"},
                    ],
                attendance_status:[{"text": "Present", "value": "1"},{"text": "Leave with pay", "value": "1"}],
                text: '',
                fields: [
                     {
                        label: 'Date',
                        key: 'roster_date',
                        sortable:true
                     },
                     {
                        label: 'Day',
                        key: 'roster_day',
                        sortable:true
                     },
                    {
                        label: 'In Time',
                        key: 'in_time',
                    },
                    {
                        label: 'Out Time',
                        key: 'out_time',
                    },
                    {
                        label: 'Late',
                        key: 'late',
                    },
                    {
                        label: 'Early Leave',
                        key: 'early_leave',
                    },
                    {
                        label: 'Leave Type',
                        key: 'leave_type',
                    }
                ],
                attentdance: [],
                columns: [
                    {
                        label: 'Employee code',
                        key: 'emp_code',
                     },
                    {
                        label: 'Employee Name',
                        key: 'emp_name',
                     },
                    {
                        label: 'Designation',
                        key: 'designation',
                     },
                    {
                        label: 'Late',
                        key: 'late',
                     },
                    {
                        label: 'Early Leave',
                        name: 'early_leave',
                     },
                    {
                        label: 'Absent',
                        key: 'absent',
                     },
                    {
                        label: 'Leave Day',
                        key: 'leave_day',
                     }, {
                        label: 'Action',
                        key: 'action2',
                     },
                ],
                items: [],
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
        watch: {
            // selectedEmployee:function(val,oldVal) {
            //      if(val != null){
            //         this.attendanceSearch.emp_id = val.emp_id;
            //         if ( val.department) {
            //               this.attendanceSearch.department_name =  val.department.department_name;
            //               this.attendanceSearch.department_id =  val.department.department_id;
            //         }else {
            //             this.department_id = '';
            //         }
            //
            //         if(val.designation) {
            //             this.designation_name =  val.designation.designation;
            //         }
            //
            //         if(val.section) {
            //             this.section_name = val.section.section_name;
            //         }
            //     }
            // }
          },
        methods: {
            selectRow(data) {
                alert(data);
            },
            searchLookups() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/attendance/details").then(res => {
                    this.sections = res.data.sections;
                    this.departments = res.data.departments;
                    this.leave_type_list = res.data.leave_types;
                });
            },
            searchEmployeeCodes(id){
                id = id.trim();
                if(id.length > 0) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/attendance/entry/emp-info/${id}/${this.employeeSearch.department_id}`).then(res => { // This url seems inaccurate! but employee data should be same so using this url.
                        this.empIdList = res.data.empcodeList;
                        this.emp_name=res.data.empcodeList.emp_name;

                    })
                }
            },
            detailsAttendance(empId,toDate,fromDate){
                this.attendanceDetails = true;
                this.employeeDetails = false;
                let to_date = moment(toDate).format("YYYY-MM-DD");
                let from_date =  moment(fromDate).format("YYYY-MM-DD");
                let type = this.employeeSearch.type ? this.employeeSearch.type : 0;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/attendance/details/${empId}/${to_date}/${from_date}/${type}`).then(res => {
                    this.employee_details = res.data.employee_details;
                    this.attentdance = res.data.attendance;
                    this.totalListAttentdance = res.data.attendance.length;
                });
                //this.$router.push({ path:`/attendance-details/${empId}/${to_date}/${from_date}/${type}`});
            },
            backToEmployee(){
                this.attendanceDetails = false;
                this.employeeDetails = true;
            },
            onSubmit(e) {
                e.preventDefault();

                  this.employeeSearch.selectedEmployee = this.selectedEmployee;
                 this.$validator.validateAll().then(() => {
                   if (!this.errors.any()) {
                     ApiRepository.callApi(ApiRepository.POST_COMMAND, "/attendance/details", this.employeeSearch).then(res => {
                         this.items = res.data.details;
                         this.totalList = res.data.details.length;
                     });
                   } else {
                            console.log('here', this.errors);
                         }
                 });
            },
            onChangeDepartment(id){
                this.sectionOptions = this.sections.filter(a=>a.department_id == id)
            },
            onReset(evt) {
                evt.preventDefault();
                this.employeeSearch = {};
                this.selectedEmployee = {'option_name':'','emp_id':'', 'emp_name':''}
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

