<template>
    <b-container fluid>
        <b-form @submit.prevent="onSearchData" @reset.prevent="onReset">
            <b-card title="Attendance Approval">
                <b-card-text>
                    <b-row>

                        <b-col md="3">
                            <label>Department</label>
                            <b-form-select  id="departmentID" v-model="attendanceapproval.department" :options="departmentList"></b-form-select>
                        </b-col>
                        <b-col md="3">
                            <label>Section</label>
                            <b-form-select  id="section" v-model="attendanceapproval.section" :options="sectionList"></b-form-select>
                        </b-col>
                        <b-col md="3">
                            <label>Employee Code</label>
                            <v-select
                                label="option_name"
                                v-model="selectedEmployee"
                                :options="empIdList"
                                @search="searchempcods">
                                <template #search="{attributes, events}">
                                    <input
                                        class="vs__search"
                                        v-bind="attributes"
                                        v-on="events"
                                    />
                                </template>
                            </v-select>
                        </b-col>

                        <b-col md="3">
                            <label  for="roster_date">Roster Date</label>
                            <date-picker width="100%" input-class="form-control" id="roster_date" v-model="attendanceapproval.roster_date"  type="date" :editable="false" lang="en" format="YYYY-MM-DD" :value-type="dateValueType" :not-after="notAfterToday()"></date-picker>
                        </b-col>
                    </b-row>
                </b-card-text>
                <b-row class="mt-3">
                    <b-col class="d-flex justify-content-end ">
                        <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Search</b-button> &nbsp;
                        <b-button type="reset" class="btn btn-outline-dark  mb-1">Reset</b-button>
                    </b-col>
                </b-row>
            </b-card>
        </b-form>

        <template>
            <div>
                <b-modal id="modal-xl" size="xl"  v-model="modalShow" hide-footer >
                    <b-form @submit.stop.prevent="onSubmitModal">
                        <b-card-text>
                            <b-row>
                                <b-col md="6">
                                    <label>Employee Name</label>
                                    <b-form-input v-model="selectedItem.emp_name" readonly  type="text"></b-form-input>
                                </b-col>
                                <b-col md="3">
                                    <label>Employee Code</label>
                                    <b-form-input v-model="selectedItem.emp_code" readonly type="text"></b-form-input>
                                </b-col>
                                <b-col md="3">
                                    <label>Designation</label>
                                    <b-form-input v-model="selectedItem.designation" readonly type="text"></b-form-input>
                                </b-col>
                                <b-col md="3">
                                    <label>Department</label>
                                    <b-form-input v-model="selectedItem.department_name" readonly type="text"></b-form-input>
                                </b-col>
                                <b-col md="3">
                                    <label>Section</label>
                                    <b-form-input v-model="selectedItem.dpt_section"  readonly  type="text"></b-form-input>
                                </b-col>
                                <b-col md="3">
                                    <label>Shift</label>
                                    <b-form-input v-model="selectedItem.shift_code"  readonly  type="text"></b-form-input>

                                </b-col>

                                <b-col md="3">
                                    <label>Shift Start</label>
                                    <b-form-input v-model="selectedItem.shift_start_time"  readonly  type="text"></b-form-input>

                                </b-col>

                                <b-col md="3">
                                    <label>Shift End</label>
                                    <b-form-input v-model="selectedItem.shift_end_time"  readonly  type="text"></b-form-input>
                                </b-col>

                                <b-col md="3">
                                    <label>Shift Hour</label>
                                    <b-form-input v-model="selectedItem.shift_hours"  readonly  type="text"></b-form-input>
                                </b-col>

                                <b-col md="3">
                                    <label>Work Hour</label>
                                    <b-form-input v-model="selectedItem.work_hours"  readonly  type="text"></b-form-input>
                                </b-col>

                                <b-col md="3">
                                    <label>Overtime Hour</label>
                                    <b-form-input v-model="selectedItem.overtime_hours"  readonly  type="text"></b-form-input>
                                </b-col>

                                <b-col md="3">
                                    <b-form-group
                                        class="requiredField"
                                        id="roster_date"
                                        label="Roster Date"
                                        label-for="roster_date"
                                    >
                                        <date-picker width="100%" input-class="form-control" v-model="selectedItem.roster_date"  type="date" :editable="false" lang="en" format="YYYY-MM-DD" :value-type="dateValueType" :not-after="notAfterToday()"></date-picker>
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
                                        <date-picker width="100%" input-class="form-control" v-model="selectedItem.in_time" type="datetime" :editable="false" lang="en" format="YYYY-MM-DD HH:mm" :value-type="dateTimeValueType"  :not-after="notAfterToday()"></date-picker>
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
                                        <date-picker width="100%" input-class="form-control" v-model="selectedItem.out_time"  type="datetime" :editable="false" lang="en" format="YYYY-MM-DD HH:mm" :value-type="dateTimeValueType" :not-after="notAfterToday()"></date-picker>
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
                                            v-model="selectedItem.off_day_yn"
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
                                            v-model="selectedItem.holiday_yn"
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
                                        <b-form-textarea v-model="selectedItem.remarks" placeholder="Type Reason"></b-form-textarea>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-card-text>
                        <b-row class="mt-3">
                            <b-col class="d-flex justify-content-end ">
                                <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Update</b-button>
                                <b-button md="6" size="md" class="btn-outline-dark mr-1 mb-1"  @click="closeModal()">Cancel</b-button>
                            </b-col>
                        </b-row>

                    </b-form>
                </b-modal>
            </div>

        </template>
        <b-card title="Attendance Approval List">
            <b-card-text>
                <Datatable v-bind:fields="tableDataAllowancs.fields" v-bind:items="tableDataAllowancs.items"  v-bind:pageColSize="4" v-bind:searchColSize="5">
                    <template  v-slot:action4="{ rows }" >
                        <b-form-select v-model="rows.item.registerApproval" :options="processApprovalList"></b-form-select>
                    </template>
                    <template v-slot:action3="{ rows }">
                        <b-link ml="4" class="text-primary"
                                @click="editRow(rows.item)">
                            <i class="bx bx-edit cursor-pointer"></i>
                        </b-link>
                    </template>
                </Datatable>

                <b-row class="mt-3">
                    <b-col class="d-flex justify-content-end ">
                        <b-button type="submit" @click="onSubmit" class="btn btn-dark shadow mr-1 mb-1">Submit</b-button> &nbsp;
                        <b-button type="reset" @click="onCancel" class="btn btn-outline-dark  mb-1">Cancel</b-button>
                    </b-col>
                </b-row>
            </b-card-text>
        </b-card>
    </b-container>
</template>

<script>
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import moment from 'moment';
    import  vcss from 'vue-select/dist/vue-select.css';
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    export default {
        components: { DatePicker,Datatable,Vue,vSelect,vcss},
        data() {
            return {
                errorMessage: {color: 'red'},
                dateValueType: this.dateFormatter(),
                dateTimeValueType: this.dateTimeFormatter(),
                dateValueType: this.dateFormatter(),
                approvalList:[],
                selectedItem:[],
                empIdList: [],
                departmentList:[],
                sectionList:[],
                emp_code: {},
                modalShow: false,
                selectedEmployee:{},
                attendanceapproval:{
                    department: '',
                    section: '',
                    roster_date: '',
                },
                reqRosterDate:false,
                reqInTime:false,
                reqOutTime:false,
                approval : [{
                    approvedOtHours: [],
                    registerApproval: [],
                }],
                processApprovalList:
                    [
                        {value: 1, text: 'Approved'},
                        {value: -1, text: 'Reject'}
                    ],
                yesNoOptions: [{text: 'Yes', value: 'Y'},{text: 'No', value: 'N'}],
                tableDataAllowancs: {
                    fields: [
                        {key: 'emp_code', sortable: true},
                        {key: 'emp_name', sortable: true},
                        {key: 'designation', sortable: true},
                        {key: 'roster_date',
                            formatter: value => {
                                if (value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable: true},
                        {key: 'shift_code', label: 'Shift', sortable: true},
                        {key: 'in_time',
                            formatter: value => {
                                if (value) {
                                    return moment(value).format('HH:mm');
                                }
                            }, sortable: true},
                        {key: 'out_time',
                            formatter: value => {
                                if (value) {
                                    return moment(value).format('HH:mm');
                                }
                            }, sortable: true},
                        {key: 'remarks'},
                        {key: 'action4', label: 'Approval/Rejection'},
                        {key: 'action3', label: 'Action'}
                    ],
                    items: []
                },
            };
        },
        watch: {
            selectedEmployee:function(val,oldVal) {
                this.attendanceapproval.emp_id = val.emp_id;
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Attendance"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Process"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Attendance Process"});
            this.allDatalistShow();
            this.onReset();
        },

        methods:{
            notAfterToday() {
                return moment();
            },
            editRow(item) {
                this.selectedItem  = item;
                this.modalShow = true;
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
            allDatalistShow(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/overtime/ot-approvals').then(res => {
                    this.departmentList = res.data.departments;
                    this.sectionList = res.data.sections;
                });
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
                let dptId=this.attendanceapproval.department;
                if(id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-approvals/emp-info/${id}/${dptId}`, this.attendanceapproval).then(res => {
                        this.empIdList = res.data.empcodeList;
                    })
                }
            },
            onSearchData() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/leave/attendance/approval-list-search',this.attendanceapproval).then(res => {
                    this.tableDataAllowancs.items = res.data;
                });
            },
            onSubmit() {
                let param = this.tableDataAllowancs.items;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/leave/attendance/approval-list',param).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                        this.allDatalistShow();
                        this.onReset();
                        this.onSearchData();
                    } else{
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                    }
                });
            },
            onCancel(){
                this.onSearchData();
            },
            onSubmitModal() {
                let currObj = this;
                ApiRepository.callApi(ApiRepository.POST_COMMAND,'/leave/attendance/attendance-entry',this.selectedItem).then(result => {
                    if(result.data.o_status_code == 1) {
                        currObj.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' });
                        this.modalShow = false;
                    }else {
                        currObj.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' });
                    }
                });
            },
            onReset() {
                // Reset our form values
                this.attendanceapproval.emp_id = null;
                this.attendanceapproval.department = null;
                this.attendanceapproval.section = null;
                this.attendanceapproval.roster_date =  '';
                this.tableDataAllowancs.items = [];
                // Trick to reset/clear native browser form validation state
                this.show = false;
                this.$nextTick(() => {
                    this.show = true
                })
            },
            closeModal(){
                this.modalShow = false;
            }
        }
    };
</script>
