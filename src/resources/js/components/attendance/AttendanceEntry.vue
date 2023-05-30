<template>
    <b-container fluid>
        <b-form @submit.prevent="search" @reset.prevent="reset">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Attendance Entry</b-card-header>
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
                                        <label>Employee</label>
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
                                        <b-form-select v-model="attendanceSearch.month_year" required :options="months_years_options" name="month_year"></b-form-select>
                                    </b-col>
                                </b-row>
                            </b-form-group>
                        </b-col>
                        <b-col class="d-flex justify-content-end">
                            <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Search</b-button> &nbsp;
                            <b-button type="reset" class="btn btn-outline-dark  mb-1">Reset</b-button>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
        </b-form>
        <b-row>
            <b-col >
                <b-form @submit.prevent="submit">
                    <b-card>
                        <b-card-header header-bg-variant="dark" header-text-variant="white">Monthly Attendance</b-card-header>
                        <b-card-body v-if="items.length > 0" class="border">
                            <Datatable v-bind:fields="fields" :tbodyTrClass="rowClass" :totalList="totalList" :perPage="perPage" v-bind:items="items"  v-bind:pageColSize="4" v-bind:searchColSize="5" :primaryKeyColumnName="'roster_date'">
                                <template  v-slot:action3="{ rows }">
                                    <div :key="rows.item.roster_date">
<!--                                        <input type="text"  class="form-control mask" v-model="rows.item.in_time" @input="getWorkHours(rows)" @change="getWorkHours(rows)" :disabled="rows.item.is_disabled==1||rows.item.approve_status==1"/>-->
                                        <input type="text"  :disabled="rows.item.device_yn == 'Y'"   class="form-control mask"  v-model="rows.item.in_time" @input="getWorkHours(rows)" @change="getWorkHours(rows)" />
                                    </div>
                                </template>
                                <template v-slot:action4="{ rows }">
                                    <div :key="rows.item.roster_date">
<!--                                        <input type="text"  class="form-control mask" v-model="rows.item.out_time" @input="getWorkHours(rows)" @change="getWorkHours(rows)" :disabled="rows.item.is_disabled==1||rows.item.approve_status==1" />-->
                                        <input type="text" :disabled="rows.item.device_yn == 'Y'"  class="form-control mask"  v-model="rows.item.out_time" @input="getWorkHours(rows)" @change="getWorkHours(rows)"   />
                                    </div>
                                </template>
                                <template  v-slot:action5="{ rows }">
                                    <div :key="rows.item.roster_date">{{ rows.item.work_hours }}</div>
                                </template>
<!--                                <template  v-slot:action6="{ rows }">-->
<!--                                    <div :key="rows.item.roster_date"> <input type="checkbox" v-model="rows.item.absent_yn" value="Y"/>   </div>-->
<!--                                </template>-->
                                <template  v-slot:action7="{ rows }">
<!--                                    <b-form-input  :key="rows.item.roster_date"  v-model="rows.item.remarks" :name="`attendance-remarks-${rows.item.roster_date}`" :disabled="rows.item.is_disabled==1||rows.item.approve_status==1" ></b-form-input>-->
                                    <b-form-input v-if="rows.item.in_time >= rows.item.late_start_time && rows.item.roster_day !== 'FRIDAY' && rows.item.roster_day !== 'SATURDAY'" :class="rows.item.academic_yn == 'Y' ? 'displayAcademic' : ''" disabled class="table-warning" :key="rows.item.roster_date" v-model="late_remark" :name="`attendance-remarks-${rows.item.roster_date}`" ></b-form-input>
                                    <b-form-input v-else :class="rows.item.academic_yn == 'Y' ? 'displayAcademic' : ''" disabled  :key="rows.item.roster_date"  v-model="rows.item.remarks" :name="`attendance-remarks-${rows.item.roster_date}`" ></b-form-input>

                                    <b-form-input  class="displayAcademic" v-if="rows.item.academic_yn == 'Y' " disabled  :key="rows.item.attendance_id"  v-model="rows.item.academic_remarks" :name="`attendance-remarks-${rows.item.attendance_id}`" ></b-form-input>
                                </template>
                                <template  v-slot:action8="{ rows }">
                                    <!--                                    <b-form-input  :key="rows.item.roster_date"  v-model="rows.item.remarks" :name="`attendance-remarks-${rows.item.roster_date}`" :disabled="rows.item.is_disabled==1||rows.item.approve_status==1" ></b-form-input>-->
                                    <b-form-input :title="rows.item.comments ? rows.item.comments_update_by : 'No Comments'"  :key="rows.item.roster_date"  v-model="rows.item.comments" :name="`attendance-comments-${rows.item.roster_date}`" :disabled="rows.item.is_disabled==1||rows.item.approve_status==1" ></b-form-input>
                                </template>
                            </Datatable>
                            <ul class="legendColor">
                                <li><span class="color leave"></span> &nbsp;Leave</li>
                                <li><span class="color offday"></span> &nbsp;WEEKLY REST DAY</li>
                                <li><span class="color holiday"></span> &nbsp;Holiday</li>
<!--                                <li><span class="color academic_holiday"></span> &nbsp;Academic Holiday</li>-->
                                <li><span class="color late"></span> &nbsp;Late</li>
                                <li><span class="color absent"></span> &nbsp;Absent</li>
<!--                                <li><span class="color late"></span> &nbsp;Late</li>-->
                            </ul>
                            <b-row class="mt-2">
                                <b-col class="d-flex justify-content-end">
                                    <b-button type="submit"  class="btn btn-dark shadow mr-1  mb-1">Submit</b-button>
                                </b-col>
                            </b-row>
                        </b-card-body>
                        <b-card-body v-else class="border">
                            No data available!
                        </b-card-body>
                    </b-card>
                </b-form>

            </b-col>
        </b-row>
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
    import Inputmask from "inputmask";
    export default {
        components: { DatePicker,Datatable,Vue,vSelect,vcss},
        props:['id'],
        data() {
            return {
                attendanceSearch: {
                    emp_id: '',
                    month_year: '',
                },
                empIdList: [],
                emp_name: '',
                emp_id: '',
                department_name: '',
                department_id: '',
                late_remark: 'LATE',
                rest_remark: 'WEEKLY REST DAY',
                designation_name: '',
                section_name: '',
                displayAcademic: '',
                academic_remarks: '',
                disabled:true,
                require_employee: true,
                months_years_options: [],
                selectedEmployee: {'option_name':'','emp_id':'', 'emp_name':''},
                fields: [
                    {key: 'sl', label: 'SL', class: 'text-center'},
                    {key: 'roster_date', label: 'Date' },
                    {key: 'shift', label: 'Shift'},
                    {key: 'action3', label: 'In Time', class:'max-width'},
                    {key: 'action4', label: 'Out Time', class:'max-width'},
                    {key: 'action5', label: 'Work Hours', class: 'text-center'},
                    // {key: 'action6', label: 'Absent', class: 'text-center'},
                    {key: 'action7', label: 'Remarks'},
                    {key: 'action8', label: 'Comments'},

                ],
                items: [],
                totalList: null,
                perPage: 35,
            };
        },
        computed: {
            visibleFields() {
                return this.fields.filter(field => field.academic_yn == 'Y')
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Attendance"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Entry"});
            this.loadData();
        },
        watch: {
            selectedEmployee:function(val,oldVal) {
                this.require_employee = true;
                if(val != null){
                    this.require_employee = false;
                    this.emp_name = val.emp_name;
                    this.attendanceSearch.emp_id = val.emp_id;
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
            }
        },
        methods:{
            outTimeDisabled: function(rows) {
                if(rows.item.disabled) {
                    return true;
                }

                if(rows.item.in_time == '') {
                    return true;
                }

                return false;
            },
            toggleRowToEdit: function(e, rows) {
                if(e.target.checked) {
                    rows.item.disabled = true;
                } else {
                    rows.item.disabled = false;
                }
            },

            getWorkHours: function(rows) {
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
                        rows.item.is_disabled = 0;
                    }
                });
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/attendance/academic-status', rows.item,{},false).then(res => {
                  //  let ob = res.data[0];
                    rows.item.academic_remarks = res.data.remarks
                });
            },
            inTimeNotBefore: function(rosterDate) {
                let clonedRosterDate = JSON.parse(JSON.stringify(rosterDate));
                return moment(clonedRosterDate, "YYYY-MM-DD HH:mm:ss").subtract(1, 'days').hour(0).minute(0).second(0);
            },
            inTimeNotAfter: function(rosterDate) {
                let clonedRosterDate = JSON.parse(JSON.stringify(rosterDate));
                return moment(clonedRosterDate, "YYYY-MM-DD HH:mm:ss").hour(23).minute(59).second(59);
            },
            outTimeNotBefore: function(rosterDate) {
                let clonedRosterDate = JSON.parse(JSON.stringify(rosterDate));
                return moment(clonedRosterDate, "YYYY-MM-DD HH:mm:ss").hour(0).minute(0).second(0);
            },
            outTimeNotAfter: function(rosterDate) {
                let clonedRosterDate = JSON.parse(JSON.stringify(rosterDate));
                return moment(clonedRosterDate, "YYYY-MM-DD HH:mm:ss").add(1, 'days').hour(23).minute(59).second(59);
            },
            /*inTimeNotBefore: function(rosterDate, outTime) {
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
            },*/
            loadData: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/attendance/attendances').then(res => {
                    console.log(res);
                    this.months_years_options = res.data.months_years_options;
                    this.attendanceSearch.month_year =  moment().format('YYYY-MM');
                });
            },
            searchEmployeeCodes(id){
                id = id.trim();
                if(id.length > 0) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/attendance/entry/emp-info/${id}`).then(res => { // This url seems inaccurate! but employee data should be same so using this url.
                        this.empIdList = res.data.empcodeList;
                        this.emp_name=res.data.empcodeList.emp_name;
                    })
                }
            },
            search() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/attendance/search', this.attendanceSearch).then(res => {

                    console.log(res)
                    this.items = res.data;
                    console.log(res.data)
                    window.setTimeout(f=>
                        {
                            let els = document.getElementsByClassName("mask");
                            Array.prototype.forEach.call(els, function(el) {
                                let im = new Inputmask("99:99",{ "placeholder": "HH:mm" });
                                im.mask(el);
                            });
                        },
                        300
                    );
                    this.items.forEach(function(item) {
                        if (item.onleave_yn === 'Y') {
                            item._rowVariant = 'primary';
                        } else if(item.remarks === 'LATE'){
                            item._rowVariant = 'warning';
                        }
                        // else if(item.row_highlight === 'T'){
                        //     item._rowVariant = 'danger';
                        // }
                        item.is_disabled = 1;


                    });

                });


            },

            rowClass(item, type) {
                if (item) {
                    // //day when rest day
                    // if (item.row_highlight === 'R') return 'table-info'
                    // //day when leave
                    // if (item.row_highlight  === 'L') return 'table-primary'
                    // //day when holiday
                    // if (item.row_highlight  === 'H') return 'table-success'
                    // //day when late
                    // if (item.row_highlight  === 'T') return 'table-warning'
                    // //day when normal

                    //day when rest day
                    if (item.remarks === 'WEEKLY REST DAY') return 'table-info'
                    //day when leave
                    if (item.remarks  === 'LEAVE') return 'table-primary'
                    //day when holiday
                    if (item.remarks  === 'HOLIDAY') return 'table-success'
                    //day when late
                    if (item.remarks  === 'LATE') return 'table-warning'
                    //day when normal
                    if (item.remarks  === 'ABSENT') return 'table-danger'
                    //day when normal

                }
            },
            reset() {
                this.attendanceSearch.emp_id = '';
                this.attendanceSearch.month_year = '';
                this.emp_name = '';
                this.emp_id = '';
                this.department_id = '';
                this.department_name = '';
                this.designation_name = '';
                this.section_name = '';
                this.selectedEmployee = {'option_name':'','emp_id':'', 'emp_name':''};
                this.items = [];
            },

            submit() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/attendance/attendances', this.items).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                        this.search();
                    } else{
                        this.items.forEach(function(item) {
                            if (item.attendance_id == res.data.p_attendance_id) {
                                item._rowVariant = 'danger';
                            }
                        });
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' });
                    }
                });
            },
            toggleTimePanel() {
                this.showTimePanel = !this.showTimePanel;
            },
            handleOpenChange() {
                this.showTimePanel = false;
            },
        }
    };
</script>
<style>

    .displayAcademic {
        display: inline-block;
        width: 43%;
        float: left;
        margin: 5px;
    }
    .mx-input-append {
        display: none;
    }
    .table-responsive {
        overflow: inherit;
    }
    .mx-input-wrapper .form-control:disabled, .form-control[readonly] {
        background-color: white;
    }

    .mx-datepicker-btn-confirm {
        border: 1px solid rgba(0, 0, 0, 0.1);
        color: white;
        background-color: green;
    }
    .max-width,.mask {width:150px !important;}
    .legendColor{
        display: inline-block;
        margin: 0;
        padding: 0;
    }
    .legendColor li{
        padding: 10px;
        list-style: none;
        display: inline;
    }
    .legendColor .color{
        border-radius: 5px;
        padding: 1px 10px;
    }
    .color.leave{
        background-color: #5a8dee;
    }
    .color.holiday{
        background-color: #98ECC2;
    }
    .color.academic_holiday{
        background-color: #e75050;
    }
    .color.offday{
        background-color: #7AE6ED;
    }
    .color.late{
        background-color: #FFBB33;
    }
    .color.absent{
        background-color: #FFB8B8;
    }
</style>
