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
                                             <div class="pr-0 d-flex justify-content-start mt-1">
                                                    <a  href="/attendance#/attendance/employee" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1"><i class="bx bx-arrow-back cursor-pointer"></i> Back</a>
                                                </div>
                                            <b-card
                                                title="Employee Details"
                                            >
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
                                            </b-card>
                                        </b-form>
                                        <b-row>
                                            <b-col>
                                                <b-card title="Attendance employees">
                                                    <template>
                                                        <div class="content-wrapper">
                                                            <div class="content-body">
                                                                <Datatable v-bind:fields="columns" :totalList="totalList" :perPage="perPage" v-bind:items="items"  v-bind:pageColSize="4" v-bind:searchColSize="5" :primaryKeyColumnName="'roster_date'">

                                                                </Datatable>
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
    import vSelect from 'vue-select';
    import ApiRepository from '../../Repository/ApiRepository';
    import Checkbox from '../datatable/checkbox/Checkbox.vue';
    import moment from 'moment';
    import Datatable from '../../layouts/common/datatable';

    export default {
        components: { Datatable, DatePicker, Checkbox, vSelect },
        props:['empId','fromdate','todate','type'],
        data() {
            return {
                dataUrl: '/v1/leave/attendance/employees',
                valueType: this.dateFormatter(),
                employee_details: {
                    department: {
                        department_name:null
                    }
                },
                selected: 'first',
                emp_status: [],
                sections:[],
                departments:[],
                attendance:{},
                empIdList: [],
                totalList: 0,
                perPage: 31,
                require_employee: true,
                selectedEmployee: {'option_name':'','emp_id':'', 'emp_name':''},
                leave_type_list:[],
                 columns: [
                    {
                        label: 'Date',
                        key: 'roster_date',formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable:true
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
                        label: 'Leave Type',
                        key: 'leave_type',
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
            this.loadData();
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
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/attendance/details/${this.empId}/${this.fromdate}/${this.todate}/${this.type}`).then(res => {
                    this.employee_details = res.data.employee_details;
                    this.items = res.data.attendance;
                    this.totalList = res.data.attendance.length;
                });
            },
            searchEmployeeCodes(id){
                id = id.trim();
                if(id.length > 0) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/leave/leave-entry/emp-info/${id}`).then(res => { // This url seems inaccurate! but employee data should be same so using this url.
                        this.empIdList = res.data.empcodeList;
                        this.emp_name=res.data.empcodeList.emp_name;

                    })
                }
            },
            onSubmit(e) {
                e.preventDefault();

                  this.employeeSearch.selectedEmployee = this.selectedEmployee;

                 ApiRepository.callApi(ApiRepository.POST_COMMAND, "/attendance/details", this.employeeSearch).then(res => {
                     this.items = res.data.details;
                     this.totalList = res.data.details.length;
                });
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

