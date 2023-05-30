<template>
    <b-container fluid>
        <b-form @submit.prevent="search" @reset.prevent="reset">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Attendance Approval</b-card-header>
                <b-card-body class="border">
                    <b-row>
                        <b-col md="4">
                            <b-form-group>
                                <b-row>
                                    <b-col md="4">
                                        <label>Employee Name</label>
                                    </b-col>
                                    <b-col md="8">
                                        <b-form-input v-model="emp_name" disabled ></b-form-input>
                                    </b-col>
                                </b-row>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group>
                                <b-row>
                                    <b-col md="4">
                                        <label>Designation</label>
                                    </b-col>
                                    <b-col md="8">
                                        <b-form-input v-model="designation_name" disabled ></b-form-input>
                                    </b-col>
                                </b-row>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group>
                                <b-row>
                                    <b-col md="4">
                                        <label>Department</label>
                                    </b-col>
                                    <b-col md="8">
                                        <b-form-input v-model="department_name" disabled ></b-form-input>
                                    </b-col>
                                </b-row>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <b-form-group>
                                <b-row>
                                    <b-col md="4">
                                        <label>Employee Code</label>
                                    </b-col>
                                    <b-col md="8">
                                        <v-select
                                                label="option_name"
                                                v-model="selectedEmployee"
                                                :options="empIdList"
                                                @search="searchEmployeeCodes">
                                            <template #search="{attributes, events}">
                                                <input
                                                        class="vs__search"
                                                        :required="require_employee"
                                                        v-bind="attributes"
                                                        v-on="events"
                                                        name="employee"
                                                />
                                            </template>
                                        </v-select>
                                    </b-col>
                                </b-row>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group>
                                <b-row>
                                    <b-col md="4">
                                        <label>Month</label>
                                    </b-col>
                                    <b-col md="8">
                                        <b-form-select v-model="attendanceApprovalSearch.month_year" required :options="months_years_options" name="month_year"></b-form-select>
                                    </b-col>
                                </b-row>
                            </b-form-group>
                        </b-col>
                        <b-col class="text-right">
                            <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Search</b-button> &nbsp;
                            <b-button type="reset" class="btn btn-outline-dark  mb-1">Reset</b-button>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
        </b-form>
        <b-form @submit.prevent="submit">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">
                    Monthly Attendance Approvals
                </b-card-header>
                <b-card-body class="border" v-if="items.length > 0">
                    <Datatable v-bind:fields="fields" :totalList="totalList" :perPage="perPage" v-bind:items="items"  v-bind:pageColSize="4" v-bind:searchColSize="5" :primaryKeyColumnName="'roster_date'">
                        <template v-slot:head>
                            Comments
                            <span class="all-approved float-right"> <b-form-checkbox
                                id="checkbox-1"
                                v-model="selectAll"
                                name="checkbox-1"
                                value=true
                                v-if="items.length > 0"
                                unchecked-value=false @input="selectAllApproved"
                            >Approve All</b-form-checkbox></span>
                        </template>
                        <template  v-slot:action2="{ rows }">
                            {{ rows.item.roster_date  | dateTimeFormat }}
                        </template>
                        <template  v-slot:action3="{ rows }">
                            <div>
                                 <input type="text"  :disabled="!rows.item.comments && rows.item.device_yn == 'Y'"   class="form-control mask"  v-model="rows.item.in_time" @input="getWorkHours(rows)" @change="getWorkHours(rows)"  />
                            </div>
                        </template>
                        <template v-slot:action4="{ rows }">
                            <div>
                                <input type="text"  :disabled="!rows.item.comments  && rows.item.device_yn == 'Y'"    class="form-control mask"  v-model="rows.item.out_time" @input="getWorkHours(rows)" @change="getWorkHours(rows)"  />
                             </div>
                        </template>
                        <template  v-slot:action5="{ rows }">
                            <div :key="rows.item.roster_date">{{ rows.item.work_hours }}</div>
                        </template>
                        <template  v-slot:action6="{ rows }">
                            <b-form-select :key="rows.item.roster_date" v-model="rows.item.approve_status" :options="approveStatuses"></b-form-select>
                        </template>
                        <template  v-slot:headCell1="{ rows }">
                            <b-form-input type="text" :title="rows.item.comments ? rows.item.comments_update_by : 'No Comments'" :key="rows.item.roster_date" v-model="rows.item.comments" :disabled="(rows.item.approve_status==='0')" :name="`attendance-comments-${rows.item.roster_date}`"></b-form-input>
                        </template>
                    </Datatable>
                    <b-row class="mt-2">
                        <b-col class="d-flex justify-content-end">
                            <b-button type="submit"  class="btn btn-dark shadow mr-1  mb-1">Approve</b-button>
                        </b-col>
                    </b-row>
                </b-card-body>
                <b-card-body v-else class="border">
                    No data available!
                </b-card-body>
            </b-card>
        </b-form>
        <AttendanceApprovalDepartment></AttendanceApprovalDepartment>
    </b-container>
</template>

<script>
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import  vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from "../../Repository/ApiRepository";
    import AttendanceApprovalDepartment from "../attendance/AttendanceApprovalDepartment";
    export default {
        components: { DatePicker,Datatable,Vue,vSelect,vcss,AttendanceApprovalDepartment},
        props:['id'],
        data() {
            return {
                attendanceApprovalSearch: {
                    emp_id: '',
                    month_year: '',
                },
                approveStatuses: [
                    {value: '0', text: 'Select Status'},
                    {value: 1, text: 'Approved'},
                    {value: -1, text: 'Reject'}
                ],
                empIdList: [],
                selectAll:false,
                emp_name: '',
                emp_id: '',
                department_name: '',
                department_id: '',
                designation_name: '',
                section_name: '',
                require_employee: true,
                months_years_options: [],
                selectedEmployee: {'option_name':'','emp_id':'', 'emp_name':''},
                fields: [
                    {key: 'action2', label: 'Date'},
                    {key: 'action3', label: 'In Time'},
                    {key: 'action4', label: 'Out Time'},
                    {key: 'action5', label: 'Work Hours', class: 'text-center'},
                    {key: 'action6', label: 'Status'},
                    {key: 'head', label: 'Comments'}
                    ],
                items: [],
                totalList: null,
                perPage: 35,
            };
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Attendance"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Approval"});
            this.loadData();
        },
        watch: {
            selectedEmployee:function(val,oldVal) {
                this.require_employee = true;
                if(val != null){
                    this.require_employee = false;
                    this.emp_name = val.emp_name;
                    this.attendanceApprovalSearch.emp_id = val.emp_id;
                    if ( val.department) {
                        this.department_name =  val.department.department_name;
                        this.department_id =  val.department.department_id;
                    }else {
                        this.department_id = '';
                    }

                    if(val.designation) {
                        this.designation_name =  val.designation.designation;
                    }

                    if(val.section) {
                        this.section_name = val.section.section_name;
                    }
                }
            },
        },
        filters: {
            dateTimeFormat: function ($val) {
                return moment($val, 'YYYY-MM-DD').format('DD-MM-YYYY');
            },
            trim: function(string) {
                return string.trim()
            }
        },
        methods:{
            // getWorkHours: function(rows) {
            //     if(rows.item.out_time && rows.item.in_time) {
            //         let outTime = moment(rows.item.out_time);
            //         let inTime = moment(rows.item.in_time);
            //
            //         let ms = moment(outTime,"YYYY-MM-DD HH:mm:ss").diff(moment(inTime,"YYYY-MM-DD HH:mm:ss"));
            //         let d = moment.duration(ms);
            //         let s = Math.floor(d.asHours()) + moment.utc(ms).format(":mm");
            //         rows.item.work_hours = s;
            //     }
            // },
            getWorkHours: function(rows) {
                    if(rows.attendance_id && rows.item.out_time && rows.item.in_time) {
                        let outTime = moment(rows.item.out_time);
                        let inTime = moment(rows.item.in_time);

                        let ms = moment(outTime,"YYYY-MM-DD HH:mm:ss").diff(moment(inTime,"YYYY-MM-DD HH:mm:ss"));
                        let d = moment.duration(ms);
                        let s = Math.floor(d.asHours()) + moment.utc(ms).format(":mm");
                        rows.item.work_hours = s;
                    }else{
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, '/attendance/cal-hour', rows.item,{},false).then(res => {
                            let ob = res.data[0];
                            if (ob.o_status_code == 99) {
                                //this.$notify({ group: 'pmis', text: ob.o_status_message, type:'error' })
                                rows.item.work_hours = "Invalid";
                                rows.item._rowVariant = 'danger';
                            }
                            else {
                                rows.item.work_hours = ob.work_hours;
                                rows.item._rowVariant = 'default';
                            }
                        });
                    }
            },
            inTimeNotBefore: function(rosterDate, outTime) {
                if(outTime) {
                    let clonedOutTime = JSON.parse(JSON.stringify(outTime));
                    return moment(clonedOutTime, "YYYY-MM-DD HH:mm:ss").hour(0).minute(0).second(0);
                } else {
                    let clonedRosterDate = JSON.parse(JSON.stringify(rosterDate));
                    return moment(clonedRosterDate, "YYYY-MM-DD HH:mm:ss").subtract(1, 'days').hour(0).minute(0).second(0);
                }
            },
            inTimeNotAfter: function(rosterDate, outTime) {
                if(outTime) {
                    let clonedOutTime = JSON.parse(JSON.stringify(outTime));
                    let momentOutTime = moment(outTime, "YYYY-MM-DD HH:mm:ss");

                    return moment(clonedOutTime, "YYYY-MM-DD HH:mm:ss").hour(momentOutTime.hour()).minute(momentOutTime.minute()).second(momentOutTime.second());
                } else {
                    let clonedRosterDate = JSON.parse(JSON.stringify(rosterDate));
                    return moment(clonedRosterDate, "YYYY-MM-DD HH:mm:ss").hour(23).minute(59).second(59);
                }
            },
            outTimeNotBefore: function(inTime) {
                if(inTime) {
                    let clonedInTime = JSON.parse(JSON.stringify(inTime));
                    let momentInTime = moment(inTime, "YYYY-MM-DD HH:mm:ss");
                    return moment(clonedInTime, "YYYY-MM-DD HH:mm:ss").hour(momentInTime.hour()).minute(momentInTime.minute()).second(momentInTime.second());
                }
            },
            outTimeNotAfter: function(inTime) {
                if(inTime) {
                    let clonedInTime = JSON.parse(JSON.stringify(inTime));
                    return moment(clonedInTime, "YYYY-MM-DD HH:mm:ss").add(1, 'days').hour(23).minute(59).second(59);
                }
            },
            loadData: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/attendance/attendances').then(res => {
                    this.months_years_options = res.data.months_years_options;
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
            search() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/attendance/approvals-search', this.attendanceApprovalSearch).then(res => {
                    this.selectAll = false;
                    this.items = res.data;
                });
            },
            reset() {
                this.attendanceApprovalSearch.emp_id = '';
                this.attendanceApprovalSearch.month_year = '';
                this.emp_name = '';
                this.emp_id = '';
                this.department_name = '';
                this.department_id = '';
                this.designation_name = '';
                this.section_name = '';
                this.selectedEmployee = {'option_name':'','emp_id':'', 'emp_name':''};
                this.items = [];
                this.selectAll = false;

            },

            submit() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/attendance/approvals', this.items).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                        this.items = [];
                    } else{
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                    }
                });
            },
            toggleTimePanel() {
                this.showTimePanel = !this.showTimePanel;
            },
            handleOpenChange() {
                this.showTimePanel = false;
            },
            selectAllApproved: function() {
                if (this.selectAll == 'true') {
                    this.items.forEach(function (item) {
                        item.approve_status = "1";
                    });
                }
                else {
                    this.items.forEach(function (item) {
                        item.approve_status = "0";
                    });
                }
            }
        }
    };
</script>
<style>
    .mx-input-append {
        display: none;
    }
    .table-responsive {
        overflow: inherit;
    }
    .mx-input-wrapper .form-control:disabled, .form-control[readonly] {
        background-color: white;
    }
   /* .all-approved {
        position: absolute;
        right:420px;
        top:175px;
        z-index: 100;
        cursor: pointer;
    }*/
</style>
