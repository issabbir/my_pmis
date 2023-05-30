<template>
    <div>
        <b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">PRL Application</b-card-header>
            <b-card-body class="border">
                <b-form @submit.prevent="onSubmitPrl" @reset.prevent="onReset">
                    <b-row>
                        <b-col md="3">
                            <b-form-group
                                label="Employee Code"
                                label-for="emp_code"
                            >
                                <b-input-group>
                                    <v-select
                                        class="w-75"
                                        label="option_name"
                                        v-model="selectedEmployeePRL"
                                        :options="empIdList"
                                        @search="searchempcodsPRL">
                                        <template #search="{attributes, events}">
                                            <input
                                                id="emp_code"
                                                class="vs__search"
                                                :required="formData.emp_id==null"
                                                v-bind="attributes"
                                                v-on="events"
                                                name="emp_code"
                                            />
                                        </template>
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>
                                    <b-form-input v-model="formData.emp_id" hidden></b-form-input>
                                    <b-input-group-append class="w-25">
                                        <b-button v-b-modal.modal-center v-if="formData.emp_id!=null"><i class="bx bx-link cursor-pointer"></i></b-button>
                                       <!-- <a style="float:left" v-b-modal.modal-center v-if="formData.emp_id!=null" class="mt-2 ml-0 pr-1"> <i class="bx bx-link cursor-pointer"></i></a>-->
                                    </b-input-group-append>
                                </b-input-group>

                            </b-form-group>
                        </b-col>

                        <b-col md="3">
                            <b-form-group label="Employee Name" label-for="emp_name">
                                <b-form-input v-model="formData.emp_name" readonly id="emp_name" ></b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="3">
                            <b-form-group label="Department" label-for="department_name" >
                                <b-form-input v-model="formData.department_name" readonly id="department_name" ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="Designation" label-for="designation">
                                <b-form-input v-model="formData.designation" readonly id="designation" ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="Date of Birth" label-for="dob">
                                <b-form-input v-model="formData.emp_dob" readonly id="emp_dob" ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="Age" label-for="age">
                                <b-form-input v-model="formData.age" readonly id="age" ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="Quota Name" label-for="quota_name">
                                <b-form-input v-model="formData.quota_name" readonly id="quota_name" ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="Emergency Number" label-for="emergency_num">
                                <b-form-input v-model="formData.emergency_num" id="emergency_num"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="LEAVE TYPE" label-for="leave_type_id" class="required" >
                                <b-form-select v-model="formData.leave_type_id" required :options="leavetypesPRL" id="leave_type_id"></b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="Join Date" label-for="join_date">
                                <b-form-input v-model="formData.emp_join_date" readonly id="join_date" ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="Application Date" class="required" label-for="application_date" >
                                <date-picker
                                    v-model="formData.application_date"
                                    width="100%"
                                    input-class="form-control"
                                    type="date"
                                    lang="en"
                                    @change="formData.leave_start_date = ''"
                                    required  v-validate="'required'"
                                    format="DD-MM-YYYY" :value-type="dateValueType"
                                    name="application_date"
                                    id="application_date"
                                ></date-picker>
                                <span :style="errorMessage">{{ errors.first('application_date') }}</span>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="Service Period" label-for="service_period">
                                <b-form-input v-model="formData.service_period" readonly id="service_period"></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-row>
                        <b-col md="3">
                            <b-form-group label="LAP Days" label-for="lap_days">
                                <b-form-input v-model="formData.lap_balance_format" readonly id="lap_days"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="LAP Start Date" class="required" label-for="lap_start_date">
                                <date-picker
                                  :disabled="formData.lap_balance <= 0"
                                        v-model="formData.lap_start_date"
                                        width="100%"
                                        input-class="form-control"
                                        type="date"
                                        lang="en"
                                        @change="formData.lap_end_date = ''"
                                        format="DD-MM-YYYY" :value-type="dateValueType"
                                        name="lap_start_date"
                                        id="lap_start_date"
                                ></date-picker>

                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="LAP End Date" class="required" label-for="lap_end_date">
                                <date-picker
                                  :disabled="formData.lap_balance <= 0 || !formData.lap_start_date"
                                        v-model="formData.lap_end_date"
                                        width="100%"
                                        input-class="form-control"
                                        type="date"
                                        lang="en"
                                        :default-value="formData.lap_start_date"
                                        :not-before="formData.lap_start_date ? formData.lap_start_date: new Date()"
                                        :not-after="lap_not_after"
                                        format="DD-MM-YYYY" :value-type="dateValueType"
                                        name="lap_end_date"
                                        id="lap_end_date"
                                ></date-picker>

                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="LAP Leave Days" label-for="lap_leave_days">
                                <b-form-input v-model="lap_leave_days" readonly id="lap_leave_days"></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="3">
                            <b-form-group label="LHAP Days" label-for="lhap_days">
                                <b-form-input v-model="formData.lhap_balance_format" readonly id="lhap_days"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="LHAP Start Date" class="required" label-for="lhap_start_date">
                                <date-picker
                                        v-model="formData.lhap_start_date"
                                        width="100%"
                                        input-class="form-control"
                                        type="date"
                                        lang="en"

                                        :not-before="formData.lap_end_date ? lhap_not_before : ( formData.lhap_start_date ? formData.lhap_start_date : new Date())"
                                        format="DD-MM-YYYY"
                                        :value-type="dateValueType"
                                        :disabled="lap_leave_days > 0"
                                        name="lhap_start_date"
                                        id="lhap_start_date"
                                ></date-picker>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="LHAP End Date" class="required" label-for="lhap_end_date">
                                <date-picker
                                        v-model="formData.lhap_end_date"
                                        width="100%"
                                        input-class="form-control"
                                        type="date"
                                        :default-value="formData.lhap_start_date"
                                        lang="en"
                                        :not-before="formData.lhap_start_date ? formData.lhap_start_date: new Date()"
                                        :not-after="lhap_not_after"
                                        :disabled="!formData.lhap_start_date"
                                        format="DD-MM-YYYY" :value-type="dateValueType"
                                        name="lhap_end_date"
                                        id="lhap_end_date"
                                ></date-picker>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="LHAP Leave Days" label-for="lap_leave_days">
                                <b-form-input v-model="lhap_leave_days" readonly id="lhap_leave_days"></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <hr>
                    <b-row>
                        <b-col md="3">
                            <b-form-group label="Leave Days" label-for="leave_days">
                                <b-form-input v-model="leave_days"   readonly id="leave_days" ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="9">
                            <b-form-group label="Attachment" label-for="attachment" class="message">
                                <b-form-file
                                    @change="encodeFileEnd"
                                    id="attachment"
                                    placeholder="Attachment"
                                ></b-form-file>
                            </b-form-group>
                        </b-col>
                        <b-col md="12">
                            <b-form-group label="Remarks" label-for="leave_reason">
                                <b-textarea v-model="formData.leave_reason" id="leave_reason"  rows="1" max-rows="5">
                                </b-textarea>
                            </b-form-group>
                        </b-col>
                    </b-row>

                    <div class="col-md-12 pr-0 d-flex justify-content-end">
                        <b-button-group>
                            <b-button type="submit" id="basic_sub_btn"  variant="success" >{{submitBtn}}</b-button>
                            <b-button type="reset" variant="secondary">Cancel</b-button>
                        </b-button-group>
                    </div>
                </b-form>
            </b-card-body>
        </b-card>
        <b-card >
            <b-card-header header-bg-variant="dark" header-text-variant="white">PRL Application List</b-card-header>
            <b-card-body class="border">
                <Datatable v-bind:fields="fieldsPRL" :totalList="totalListPRL" :perPage="perPage" v-bind:items="itemsPRL">
                    <template v-slot:actions="{ rows }">
                        <b-link ml="4" class="text-primary"
                                @click="editRowPRL(rows.item)">
                            <i class="bx bx-edit cursor-pointer"></i>
                        </b-link>
                        <a v-if="rows.item.attachment" :href="'/v1/leave/leave-attachment-download/'+rows.item.leave_id">
                            <i class='bx bx-file' ></i>
                        </a>
                    </template>
                </Datatable>
            </b-card-body>
        </b-card>
        <b-modal
            id="modal-center"
            scrollable
            size="xl"
            body-bg="light"
            title="Leave Balance">
            <b-container fluid>
                <b-table  small responsive striped hover :items="leaveBal" :fields="leaveValFields"></b-table>
            </b-container>
            <template v-slot:modal-footer="{cancel}">
                <b-button size="sm" variant="secondary" @click="cancel()">Cancel</b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from "../../Repository/ApiRepository";
    export default {
        name: "prl-leave",
        components: {DatePicker,Datatable,Vue,vSelect,vcss},
        data() {
            return {
                old_lap_start_date: null,
                old_lap_end_date: null,
                old_lhap_start_date: null,
                old_lhap_end_date: null,
                formData: {
                    leave_id: '',
                    emp_id: '',
                    emp_code: '',
                    emp_name: '',
                    department_name: '',
                    designation: '',
                    emp_dob: '',
                    emp_date_of_birth: '',
                    quota_name: '',
                    emergency_num: '',
                    leave_type_id: 11,
                    emp_join_date: '',
                    leave_days:0,
                    application_date: moment().format("YYYY-MM-DD"),
                    leave_start_date: moment().format("YYYY-MM-DD"),
                    leave_end_date: moment().format("YYYY-MM-DD"),
                    leave_reason:null,
                    available_balance:null,
                    service_period: null,
                    monday:null,
                    attachment: '',
                    lap_balance: 0,
                    lap_leave_days: '',
                    lap_start_date: null,
                    lap_end_date: null,
                    lhap_balance: 0,
                    lap_balance_format: '',
                    lhap_balance_format: '',
                    lhap_leave_days: '',
                    lhap_start_date: null,
                    lhap_end_date: null,
                    full_pay_yn: 'N'
                },
                leaveValFields: [
                    {key: 'leave_type', label: 'Leave Type'},
                    {key: 'leave_enjoy', label: 'Spent', variant: 'secondary'},
                    {key: 'remaining_balance', label: 'Balance', sortable: true, variant: 'danger'},
                    {key: 'monday', label: 'Months', sortable: true, variant: 'success'}
                ],
                leaveBal: [],
                selectedEmployeePRL: {
                    option_name: '',
                    emp_name: '',
                    emp_id: '',
                    department_name: '',
                    designation: '',
                    emp_dob: '',
                    quota_name: '',
                    emergency_num: '',
                    emp_join_date: '',
                    leave_start_date: '',
                    leave_end_date: '',
                    lap_balance: '',
                    available_balance: '',
                    available_balance_old: '',
                    lap_balance_format: '',
                    lhap_balance_format: '',
                    lhap_balance: '',
                    age: ''
                },
                empIdList: [],
                leavetypesPRL: [],
                dateValueType: this.dateFormatter(),
                submitBtn: 'Save',
                errorMessage: {color: 'red'},
                totalListPRL:0,
                perPage: 5,
                fieldsPRL: [
                    {key: 'emp_code', label: 'Emp Code', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'emp_name', label: 'Employee Name', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'department_name', label: 'Department', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'designation', label: 'Designation', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'emp_dob', label: 'Date Of Birth', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'quota_name', label: 'Quota', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'emp_join_date', label: 'Join Date', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {
                        key: 'application_date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        label: 'Application Date',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-left'
                    },
                    {
                        key: 'use_from_type_id',
                        label: 'Leave For',
                        formatter: value => {
                            if(value == 1) {
                                return 'LAP'
                            } else {
                                return 'LHAP'
                            }
                        },
                    },
                    {key: 'leave_start_date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }, label: 'Start Date', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'leave_end_date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        label: 'End Date', sortable: true, sortDirection: 'desc', class: 'text-left'
                    },
                    {
                        key: 'action', class: 'text-center'
                    }

                ],
                itemsPRL: []
            }
        },
        mounted() {
            this.loadDataPRL()
        },
        watch: {
            selectedEmployeePRL:function(val,oldVal) {
                if(val !== null) {
                    this.formData.emp_name =  val.emp_name;
                    this.formData.emp_id =  val.emp_id;
                    this.formData.department_name =  val.department_name;
                    this.formData.designation =  val.designation;
                    this.formData.emp_dob =  val.emp_dob;
                    this.formData.emp_date_of_birth =  val.emp_date_of_birth;
                    this.formData.quota_name =  val.quota_name;
                    this.formData.emergency_num = val.emergency_num;
                    this.formData.emp_join_date= val.emp_join_date;
                    this.formData.leave_end_date = val.leave_end_date;
                    this.formData.leave_start_date = val.leave_start_date;
                    this.formData.lap_start_date = this.old_lap_start_date ? this.old_lap_start_date:(val.lap_balance > 0? val.leave_start_date: null)
                    this.formData.lap_end_date = this.old_lap_end_date? this.old_lap_end_date: (val.lap_balance > 0? val.leave_end_date: null)
                    this.formData.available_balance = val.available_balance;
                    this.formData.service_period=val.available_balance_old;
                    this.formData.lap_balance = val.lap_balance
                    this.formData.lap_balance_format = val.lap_balance_format
                    this.formData.lhap_balance_format = val.lhap_balance_format
                    this.formData.lhap_balance = val.lhap_balance
                    this.formData.lhap_start_date = this.old_lhap_start_date?this.old_lhap_start_date : (val.lap_balance <= 0 && val.lhap_balance > 0 ? val.leave_start_date: null)
                    //this.formData.lhap_end_date = val.lap_balance <= 0 && val.lhap_balance > 0 ? val.leave_start_date: null
                    this.getLeaveBalance(val.emp_id)
                }
            },
            "formData.emp_dob": function() {
                if(this.formData.emp_date_of_birth) {
                    this.formData.age = this.getAge(this.formData.emp_date_of_birth);
                } else {
                    this.formData.age = '';
                }
            },
            lap_leave_days: function (val, oldVal) {
                console.log('old_lhap_start_date',this.old_lhap_start_date)
                console.log('lhap_start_date',this.formData.lhap_start_date)
                if(this.old_lhap_start_date == null){

                    if(val != 365){
                        var result = new Date(this.formData.lap_end_date);
                        result.setDate(result.getDate() + 1);
                        this.formData.lhap_start_date = moment(result).format("YYYY-MM-DD")
                    } else {
                        this.formData.lhap_start_date = ''
                    }
                     this.formData.lhap_end_date = ''
                     this.formData.lhap_leave_days = ''
                }

            }
        },
        computed: {
            half_days : function() {
                if(this.formData.full_pay_yn == 'Y'){
                    return Number(this.lhap_leave_days) / 2
                } else {
                    return ''
                }

            },
            lap_leave_days:function () {
                console.log(this.formData.lap_start_date, this.formData.lap_end_date)
                let startDate = moment(this.formData.lap_start_date)
                let endDate = moment(this.formData.lap_end_date)
                let countDays = endDate.diff(startDate,'days')
                if (isNaN(countDays)) {
                    return null
                }
                else{
                    return countDays + 1
                }
            },
            lhap_leave_days:function () {
                let startDate = moment(this.formData.lhap_start_date)
                let endDate = moment(this.formData.lhap_end_date)
                let countDays = endDate.diff(startDate,'days')

                if (isNaN(countDays)) {
                    return null
                }
                else{
                    return countDays + 1
                }
            },
            leave_days:function(){
                return Number(this.lap_leave_days) + Number(this.lhap_leave_days)
            },
            lap_not_after:function () {
                if(!this.formData.lap_start_date){
                    return new Date()
                } else {
                    var result = new Date(this.formData.lap_start_date);
                    result.setDate(result.getDate() + (Number(this.formData.lap_balance)-1))
                    let end_date  = moment(result);
                    let start_date  = moment(this.formData.lap_start_date);

                    if (end_date.isLeapYear() || start_date.isLeapYear()) {
                        result.setDate(result.getDate() + 1)
                    }

                    return result;
                }
            },
            lhap_not_after:function () {
                if(!this.formData.lhap_start_date){
                    return new Date()
                } else {
                    if(365 - Number(this.lap_leave_days) > this.formData.lhap_balance){
                        var result = new Date(this.formData.lhap_start_date);
                        result.setDate(result.getDate() + (Number(this.formData.lhap_balance)-1));

                        /*** Considered Leap year and enabled one more day if got leap year ***/
                        let end_date  = moment(result);
                        let start_date  = moment(this.formData.lhap_start_date);

                        if (end_date.isLeapYear() || start_date.isLeapYear()) {
                            result.setDate(result.getDate() + 1)
                        }
                        /**** end ***/

                        //this.formData.lhap_end_date = this.formData.lhap_start_date
                        return result;
                    } else{
                        var result = new Date(this.formData.lhap_start_date);
                        result.setDate(result.getDate() + (Number(365 - Number(this.lap_leave_days))-1));

                        /*** Considered Leap year and enabled one more day if got leap year ***/
                        let end_date  = moment(result);
                        let start_date  = moment(this.formData.lhap_start_date);

                        if (end_date.isLeapYear() || start_date.isLeapYear()) {
                            result.setDate(result.getDate() + 1)
                        }
                        /**** end ***/

                        //this.formData.lhap_end_date = this.formData.lhap_start_date
                        return result;
                    }

                }
            },
            lhap_not_before: function () {
                if(365 - Number(this.lap_leave_days) > this.formData.lhap_balance){
                    var result = new Date(this.formData.lhap_start_date);
                    result.setDate(result.getDate() + (Number(this.formData.lhap_balance)-1));
                    return result;
                } else{
                    var result = new Date(this.formData.lhap_start_date);
                    result.setDate(result.getDate() + (Number(365 - Number(this.lap_leave_days))-1));
                    return result;
                }

                /*var result = new Date(this.formData.lap_end_date);
                result.setDate(result.getDate()+1);
                return result;*/
            }
        },
        methods: {
            getAge(dateOfBirth) {
                let duration = moment.duration(moment().diff(dateOfBirth));
                let years = duration.years();
                let months = duration.months();
                let days = duration.days();

                let textDuration = '';
                if(years > 0) {
                    textDuration = `${years} years `;
                }

                if(months > 0) {
                    textDuration += `${months} months `;
                }

                if(days > 0) {
                    textDuration += `${days} days`;
                }

                return textDuration;
            },
            onSubmitPrl(){
                let currObj = this;
                this.$validator.validateAll().then(() => {
                    if (!this.errors.any()) {
                        this.formData.leave_days = this.leave_days;
                        this.formData.lap_leave_days = this.lap_leave_days;
                        this.formData.lhap_leave_days = this.lhap_leave_days;
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pension/store-prl-leave", this.formData).then(res => {
                            if (res.data.o_status_code == 1) {
                                currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                this.loadDataPRL();
                                this.onReset();
                            } else {
                                currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                            }
                        });
                    }
                });
            },
            encodeFileEnd(e){
                let file_limit = 2000000;
                let vm = this;
                if(e.target.files[0].size<=file_limit){
                    if (e.target.files[0].type=='application/pdf'||e.target.files[0].type=='image/jpeg'||e.target.files[0].type=='image/jpg'){
                        let file = e.target.files[0];
                        let reader = new FileReader();
                        let type = file.type;
                        let name = file.name;
                        reader.readAsDataURL(file);
                        reader.onload = (file)=>{
                            vm.formData.attachment = reader.result;
                        }
                    }
                    else {
                        this.$notify({group: 'pmis', text: "File type should be in pdf, jpg or jpeg", type: 'error'});
                    }

                }else{
                    this.$notify({group: 'pmis', text: "File size should not exceed 2MB", type: 'error'});
                    return;
                }
            },
            loadDataPRL: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/leave/leave-entry", this.formData).then(res => {
                    this.leavetypesPRL=res.data.prlLeaveTypes.filter(a=>a.leave_type_id==11);
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/department-wise-prl-data/${this.$store.getters.user.department_id}`).then(res => {
                    this.itemsPRL=res.data;
                    this.totalListPRL = this.itemsPRL.length;
                });
            },
            editRowPRL(item) {
                this.selectedEmployeePRL = item;
                this.getLeaveBalance(item.emp_id);
                this.formData.leave_id = item.leave_id
                this.formData.application_date = item.application_date
                this.formData.leave_reason = item.leave_reason
                this.formData.attachment = item.attachment
                //this.formData = item;
                if(this.itemsPRL.filter(a => a.use_from_type_id == 1 && a.emp_id == item.emp_id)[0] != undefined){
                    this.old_lap_start_date = this.itemsPRL.filter(a => a.use_from_type_id == 1 && a.emp_id == item.emp_id)[0].leave_start_date
                    this.old_lap_end_date = this.itemsPRL.filter(a => a.use_from_type_id == 1 && a.emp_id == item.emp_id)[0].leave_end_date

                    this.formData.lap_start_date =  this.itemsPRL.filter(a => a.use_from_type_id == 1 && a.emp_id == item.emp_id)[0].leave_start_date
                    this.formData.lap_end_date =this.itemsPRL.filter(a => a.use_from_type_id == 1 && a.emp_id == item.emp_id)[0].leave_end_date
                }else{
                    this.old_lap_start_date = null
                    this.old_lap_end_date = null
                    this.formData.lap_start_date =  null
                    this.formData.lap_end_date = null
                }

                if(this.itemsPRL.filter(a => a.use_from_type_id == 5 && a.emp_id == item.emp_id)[0] != undefined)
                {
                    this.old_lhap_start_date = this.itemsPRL.filter(a => a.use_from_type_id == 5 && a.emp_id == item.emp_id)[0].leave_start_date
                    this.old_lhap_end_date = this.itemsPRL.filter(a => a.use_from_type_id == 5 && a.emp_id == item.emp_id)[0].leave_end_date
                    this.formData.lhap_start_date = this.itemsPRL.filter(a => a.use_from_type_id == 5 && a.emp_id == item.emp_id)[0].leave_start_date
                    this.formData.lhap_end_date = this.itemsPRL.filter(a => a.use_from_type_id == 5 && a.emp_id == item.emp_id)[0].leave_end_date
                } else{
                    this.old_lhap_start_date = null
                    this.old_lhap_end_date = null
                    this.formData.lhap_start_date = null
                    this.formData.lhap_end_date = null
                }

                $(document).scrollTop(0);
                this.submitBtn = 'Update'
            },
            searchempcodsPRL(id){
                if(id && (id !== undefined)) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/department-wise-emp-search/${id}/${this.$store.getters.user.department_id}`, this.formData).then(res => {
                        this.empIdList = res.data;
                    })
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
            getLeaveBalance(id){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/leave-balance/${id}`).then(res => {
                    this.leaveBal = res.data;
                });
            },
            onReset() {
                this.show = false;
                this.$nextTick(() => {
                    this.selectedEmployeePRL = {
                        option_name: '',
                        emp_name: '',
                        emp_id: ''
                    };
                    this.formData = {
                        leave_id: '',
                        emp_id: '',
                        emp_code: '',
                        emp_name: '',
                        department_name: '',
                        designation: '',
                        emp_dob: '',
                        quota_name: '',
                        emergency_num: '',
                        leave_type_id: 11,
                        emp_join_date: '',
                        leave_days:0,
                        application_date: moment().format("YYYY-MM-DD"),
                        leave_start_date: moment().format("YYYY-MM-DD"),
                        leave_end_date: moment().format("YYYY-MM-DD"),
                        leave_reason:null,
                        available_balance:null,
                        service_period: null,
                        monday:null,
                        attachment: '',
                        lap_balance: 0,
                        lap_balance_format: '',
                        lap_leave_days: '',
                        lap_start_date: '',
                        lap_end_date: '',
                        lhap_balance: 0,
                        lhap_balance_format: '',
                        lhap_leave_days: '',
                        lhap_start_date: '',
                        lhap_end_date: '',
                        full_pay_yn: ''
                    }
                    this.submitBtn = 'Save';
                    this.show = true;
                });
            },
        }
    }
</script>

<style scoped>
    img {
        height: auto;
        max-width: 2.5rem;
        margin-right: 1rem;
    }

    .d-center {
        display: flex;
        align-items: center;
    }

    .selected img {
        width: auto;
        max-height: 23px;
        margin-right: 0.5rem;
    }

    .v-select .dropdown li {
        border-bottom: 1px solid rgba(112, 128, 144, 0.1);
    }

    .v-select .dropdown li:last-child {
        border-bottom: none;
    }

    .v-select .dropdown li a {
        padding: 10px 20px;
        width: 100%;
        font-size: 1.25em;
        color: #3c3c3c;
    }

    .v-select .dropdown-menu .active > a {
        color: #fff;
    }
    .nav.nav-pills .nav-item .nav-link, .nav.nav-pills .nav-item.dropdown.show .dropdown-menu, .nav.nav-tabs .nav-item .nav-link, .nav.nav-tabs .nav-item.dropdown.show .dropdown-menu{
        border-radius: 0px;
    }
    .nav.nav-pills .nav-item, .nav.nav-tabs .nav-item {
        margin-right: 0px;
    }
    div.requiredField  label:after{
        content: '*';
        color: red;
    }
</style>
