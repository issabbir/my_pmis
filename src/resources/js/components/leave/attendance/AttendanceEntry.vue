<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <div class="card-header">
                    <h4 class="card-title">Attendance</h4>
                </div>
                <b-card-text class="card-content">
                    <div class="card-body mb-2">
                        <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                            <b-row>
                                <b-col md="3">
                                    <b-form-group
                                        class="requiredField"
                                        id="emp_id"
                                        label="Employee"
                                        label-for="emp_id"
                                    >
                                        <v-select
                                            label="option_name"
                                            name="selectedEmployee"
                                            v-model="selectedEmployee"
                                            :options="empIdList"
                                            @search="searchempcods">
                                            <template #search="{attributes, events}">
                                                <input
                                                    class="vs__search"
                                                    :required="Object.keys(selectedEmployee).length === 0"
                                                    v-bind="attributes"
                                                    v-on="events"
                                                />
                                            </template>
                                        </v-select>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        id="Empoyee_Name"
                                        label="Empoyee Name"
                                        label-for="Empoyee_Name"
                                    >
                                        <b-form-input v-model="attendance.emp_name" disabled ></b-form-input>
                                    </b-form-group>

                                </b-col>
                                <b-col md="3">
                                    <b-form-group>
                                        <b-form-group
                                            id="designation"
                                            label="Designation"
                                            label-for="designation"
                                        >
                                            <b-form-input disabled v v-model="attendance.designation" ></b-form-input>
                                        </b-form-group>
                                    </b-form-group>

                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        id="Department"
                                        label="Department"
                                        label-for="Department"
                                    >
                                        <b-form-input v-model="attendance.department_name" disabled ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row class="pull-top">
                                <b-col md="3">
                                    <b-form-group
                                        id="Section"
                                        label="Section"
                                        label-for="Section"
                                    >
                                        <b-form-input v-model="attendance.section" disabled ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        class="requiredField"
                                        id="shift_id"
                                        label="Shift"
                                        label-for="shift_id"
                                    >
                                        <b-form-select v-model="attendance.shift"
                                                       class="select2 form-control"
                                                       id="shift_id"
                                                       name="shift_id"
                                                       @change="getShiftHours"
                                                       :required = "getRequired"
                                                       :options="shiftList">
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        class="requiredField"
                                        id="start_time"
                                        label="Start Time"
                                        label-for="start_time"
                                    >
                                        <b-form-input disabled v-model="attendance.shift.shift_start_time" ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        class="requiredField"
                                        id="end_time"
                                        label="End Time"
                                        label-for="end_time"
                                    >
                                        <b-form-input disabled v-model="attendance.shift.shift_end_time" ></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        class="requiredField"
                                        id="roster_date"
                                        label="Roster Date"
                                        label-for="roster_date"
                                    >
                                        <date-picker width="100%" :required="getRequired" input-class="form-control" v-model="attendance.roster_date"  type="date" :editable="false" lang="en" format="YYYY-MM-DD" :value-type="dateValueType" :not-after="notAfterToday()"></date-picker>
                                    </b-form-group>

                                    <span :style="errorMessage" v-show="reqRosterDate">Roster Date Required!</span>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        class="requiredField"
                                        id="in_time"
                                        label="In time"
                                        label-for="in_time"
                                    >
                                        <date-picker width="100%" :required="getRequired" input-class="form-control" v-model="attendance.in_time" type="datetime" :editable="false" lang="en" format="YYYY-MM-DD HH:mm" :value-type="dateTimeValueType"  :not-after="notAfterToday()"></date-picker>
                                    </b-form-group>
                                    <span :style="errorMessage" v-show="reqInTime">In Time Required!</span>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        class="requiredField"
                                        id="out_time"
                                        label="Out Time"
                                        label-for="out_time"
                                    >
                                        <date-picker width="100%" :required="getRequired" input-class="form-control" v-model="attendance.out_time"  type="datetime" :editable="false" lang="en" format="YYYY-MM-DD HH:mm" :value-type="dateTimeValueType" :not-after="notAfterToday()"></date-picker>
                                    </b-form-group>
                                    <span :style="errorMessage" v-show="reqOutTime">Out Time Required!</span>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        class="requiredField"
                                        label="Off day"
                                        label-for="on_off_day_yn"
                                    >
                                        <b-form-radio-group
                                            v-model="attendance.off_day_yn"
                                            :options="yesNoOptions"
                                            name="on_off_day_yn"
                                        ></b-form-radio-group>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        class="requiredField"
                                        label="Holiday"
                                        label-for="on_holiday_yn">
                                        <b-form-radio-group
                                            v-model="attendance.holiday_yn"
                                            :options="yesNoOptions"
                                            name="on_holiday_yn" >

                                        </b-form-radio-group>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Reason"
                                        label-for="reason"
                                    >
                                        <b-form-textarea v-model="attendance.remarks" placeholder="Type Reason"></b-form-textarea>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col class="mt-2 d-flex justify-content-end">
                                    <b-button md="6"  size="md" variant="dark" type="submit" >{{submitBtn}}</b-button>&nbsp;
                                    <b-button md="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                    &nbsp;
                                    <a v-bind:href="'leave#/attendance/employee'"  class="btn btn-dark" >Exit</a>
                                </b-col>
                            </b-row>
                            <!--</fieldset>-->
                        </b-form>
                    </div>
                </b-card-text>
            </b-card>

            <b-card>
                <!-- Zero configuration table -->
                <b-row>
                    <b-col>
                        <b-card title="Arttendance List">
                            <template>
                                <div class="content-wrapper">
                                    <div class="content-body">
                                        <Datatable v-bind:fields="fields" v-bind:items="items" >
                                            <template v-slot:actions="{ rows }">
                                                <b-link ml="4" class="text-primary"
                                                        @click="editRow(rows.item.attendance_id)">
                                                    <i class="bx bx-edit cursor-pointer"></i>
                                                </b-link>
                                            </template>
                                        </Datatable>
                                    </div>
                                </div>
                            </template>
                        </b-card>
                    </b-col>

                </b-row>
                <!--/ Zero configuration table -->
            </b-card>
        </div>

    </div>
</template>

<script>
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import moment from 'moment';
    import  vcss from 'vue-select/dist/vue-select.css';
    import Datatable from '../../../layouts/common/datatable';
    import DatePicker from "vue2-datepicker";
    import ApiRepository from "../../../Repository/ApiRepository";

    export default {
        components: {DatePicker,Vue,vSelect,vcss,Datatable},
        watch: {
            selectedEmployee:function(val,oldVal) {
                this.attendance.emp_name = val.emp_name;
                this.attendance.emp_id = val.emp_id;
                if ( val.department) {
                    this.attendance.department_name =  val.department.department_name;
                    this.attendance.department_id =  val.department.department_id;
                }else {
                    this.attendance.department_id = '';
                }

                if(val.designation) {
                    this.attendance.designation=  val.designation.designation;
                }

                if(val.section) {
                    this.attendance.section = val.section.section_name;
                }
            },
            'attendance.shift':function(val, oldval) {
                this.getShiftHours();
            },
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Attendance"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Setup"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Entry"});
            this.loadData();
        },
        data() {
            return {
                errorMessage: {color: 'red'},
                dateValueType: this.dateFormatter(),
                dateTimeValueType: this.dateTimeFormatter(),
                attendance:{shift:{}},
                attendances:[],
                departmentList:[],
                shiftList:[],
                emp_name:'',
                selectedEmployee:{},
                empIdList:[],
                submitBtn: 'Save',
                getRequired:true,
                reqRosterDate:false,
                reqInTime:false,
                reqOutTime:false,
                items: [],
                fields: [{key:'employee.emp_code', label:'Emp Code', sortable:true},
                    {key:'employee.emp_name', label:'Emp Name', sortable:true},
                    {key:'shift.shift_code', label:'Shift', sortable:true},
                    {key:'shift.shift_start_time', label:'Shift Start', sortable:true},
                    {key:'shift.shift_end_time', label:'Shift End', sortable:true},
                    {key:'roster_date',
                        formatter: value => {
                            if (value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        label:'Roster Date', sortable:true},
                    {key:'in_time',
                        formatter: value => {
                            if (value) {
                                return moment(value).format('HH:mm');
                            }
                        },label:'In time', sortable:true},
                    {key:'out_time',
                        formatter: value => {
                            if (value) {
                                return moment(value).format('HH:mm');
                            }
                        },label:'Out time', sortable:true},
                    'action'],
                yesNoOptions: [{text: 'Yes', value: 'Y'},{text: 'No', value: 'N'}]
            }
        },
        methods: {
            notAfterToday() {
                return moment();
            },
            dateTimeFormatter: function() {
                return {
                    value2date: value => {
                        return value ? moment(new Date(value), "YYYY-MM-DD HH:mm").toDate() : null;
                    },
                    date2value: date => {
                        return date ? moment(date).format("YYYY-MM-DD HH:mm") : null;
                    }
                }
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
            searchempcods(id){
                if(id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/salary-allocation/get-empinfo/${id}`, this.attendance).then(res => {
                        this.empIdList = res.data.empcodeList;
                        this.emp_name=res.data.empcodeList.emp_name;

                    })
                }
            },
            onSubmit(evt) {
                evt.preventDefault();
                this.reqRosterDate = false;
                this.reqInTime = false;
                this.reqOutTime = false;
                if(this.attendance.roster_date == undefined || this.attendance.roster_date == ''){
                    this.reqRosterDate = true;
                    return false;
                }else if(this.attendance.in_time == undefined || this.attendance.in_time == ''){
                    this.reqInTime = true;
                    return false;
                }else if(this.attendance.out_time == undefined || this.attendance.out_time == ''){
                    this.reqOutTime = true;
                    return false;
                }
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/leave/attendance/attendance-entry", this.attendance).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                        this.loadData();
                        this.onReset();
                    } else{
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                    }
                });
            },
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/leave/attendance/attendance-entry").then(res => {
                    this.shiftList = res.data.shifts;
                    this.items=res.data.records;
                    this.attendance.holiday_yn = "N";
                    this.attendance.off_day_yn = "N";
                });
            },
            onReset() {
                this.attendance.holiday_yn = "N";
                this.attendance.off_day_yn = "N";
                this.attendance.attendance_id = '';
                this.attendance.emp_name = '';
                this.attendance.designation = '';
                this.attendance.department_name = '';
                this.attendance.section = '';
                this.attendance.shift = {
                    shift_start_time: '',
                    shift_end_time: ''
                };
                this.attendance.roster_date = '';
                this.attendance.in_time = '';
                this.attendance.out_time = '';
                this.required = true;
                this.submitBtn = 'Save';
                this.reqRosterDate = false;
                this.reqInTime = false;
                this.reqOutTime = false;
                this.selectedEmployee = '';
                this.attendance.remarks = '';
            },
            editRow(id){
                this.attendance.attendance_id = id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/leave/attendance/attendance-entry/${id}`).then(res => {
                    this.attendance = res.data;
                    this.selectedEmployee = res.data.employee;
                    this.submitBtn = 'Update';
                });
            }
        },

    }
</script>
<style>
    .pull-top{
        margin-top: -20px;
    }
</style>

