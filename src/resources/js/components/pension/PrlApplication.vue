<template>
    <div class="content-wrapper">
        <div class="content-body">
            <PRLLeave></PRLLeave>
            <!--<b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">PRL Application</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">

                        <b-row>
                            <b-col md="4">
                                <b-row>
                                    <b-col md="10">
                                        <b-form-group
                                            label="Employee Code"
                                            label-for="emp_code"
                                        >
                                            <v-select
                                                label="option_name"
                                                v-model="selectedEmployee"
                                                :options="empIdList"
                                                @search="searchempcods">
                                                <template #search="{attributes, events}">
                                                    <input
                                                        id="emp_code"
                                                        class="vs__search"
                                                        :required="selectedEmployee && selectedEmployee.emp_id==null"
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
                                        </b-form-group>
                                    </b-col>
                                    <a style="float:left" v-b-modal.modal-center v-if="formData.emp_id!=null" class="mt-2 ml-0 pr-1"> <i class="bx bx-link cursor-pointer"></i></a>
                                </b-row>
                            </b-col>

                            <b-col md="4">
                                <b-form-group label="Employee Name" label-for="emp_name">
                                    <b-form-input v-model="formData.emp_name" readonly id="emp_name" ></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group label="Department" label-for="department_name">
                                    <b-form-input v-model="formData.department_name" readonly id="department_name" ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Designation" label-for="designation">
                                    <b-form-input v-model="formData.designation" readonly id="designation" ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Date of Birth" label-for="dob">
                                    <b-form-input v-model="formData.emp_dob" readonly id="emp_dob" ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Quota Name" label-for="quota_name">
                                    <b-form-input v-model="formData.quota_name" readonly id="quota_name" ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Emergency Number" label-for="emergency_num">
                                    <b-form-input v-model="formData.emergency_num" id="emergency_num"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="LEAVE TYPE" label-for="leave_type_id" class="required">
                                    <b-form-select v-model="formData.leave_type_id" required :options="leavetypes" id="leave_type_id"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Join Date" label-for="join_date">
                                    <b-form-input v-model="formData.emp_join_date" readonly id="join_date" ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Application Date" class="required" label-for="application_date">
                                    <date-picker
                                        v-model="formData.application_date"
                                        width="100%"
                                        input-class="form-control"
                                        type="date"
                                        lang="en"
                                        required  v-validate="'required'"
                                        format="DD-MM-YYYY" :value-type="dateValueType"
                                        name="application_date"
                                        id="application_date"
                                    ></date-picker>
                                    <span :style="errorMessage">{{ errors.first('application_date') }}</span>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Available Days" label-for="available_balance">
                                    <b-form-input v-model="formData.available_balance" readonly id="available_balance"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Service Period" label-for="service_period">
                                    <b-form-input v-model="formData.service_period" readonly id="service_period"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="LPR Start Date" label-for="leave_start_date" class="required">
                                    <date-picker
                                        id="leave_start_date"
                                        v-model="formData.leave_start_date"
                                        width="100%"
                                        input-class="form-control"
                                        type="date"
                                        lang="en"
                                        required  v-validate="'required'"
                                        format="DD-MM-YYYY" :value-type="dateValueType"
                                        name="leave_start_date"
                                    ></date-picker>
                                    <span :style="errorMessage">{{ errors.first('leave_start_date') }}</span>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group label=" LPR End Date" label-for="leave_end_date" class="required">
                                    <date-picker
                                        id="leave_end_date"
                                        v-model="formData.leave_end_date"
                                        width="100%"
                                        input-class="form-control"
                                        type="date"
                                        lang="en"
                                        required  v-validate="'required'"
                                        format="DD-MM-YYYY" :value-type="dateValueType"
                                        name="leave_end_date"
                                    ></date-picker>
                                    <span :style="errorMessage">{{ errors.first('leave_end_date') }}</span>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Leave Days" label-for="leave_days">
                                    <b-form-input v-model="leave_days"   readonly id="leave_days" ></b-form-input>
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
                    <Datatable v-bind:fields="fields" :totalList="totalList" :perPage="perPage"
                               v-bind:items="items">
                        <template v-slot:actions="{ rows }">
                            <b-link ml="4" class="text-primary"
                                    @click="editRow(rows.item)">
                                <i class="bx bx-edit cursor-pointer"></i>
                            </b-link>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
            <div>
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
            </div>-->
        </div>
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
    import PRLLeave from "../leave/PRLLeave"
    export default {
        components: {DatePicker,Datatable,Vue,vSelect,vcss, PRLLeave},
        watch: {
            selectedEmployee:function(val,oldVal) {
                if(val !== null) {
                    this.formData.emp_name =  val.emp_name;
                    this.formData.emp_id =  val.emp_id;
                    this.formData.department_name =  val.department_name;
                    this.formData.designation =  val.designation;
                    this.formData.emp_dob =  val.emp_dob;
                    this.formData.quota_name =  val.quota_name;
                    this.formData.emergency_num = val.emergency_num;
                    this.formData.emp_join_date= val.emp_join_date;
                    this.formData.leave_end_date = val.leave_end_date;
                    this.formData.leave_start_date = val.leave_start_date;
                    this.formData.available_balance=val.available_balance;
                    this.formData.service_period=val.available_balance_old;
                    this.getLeaveBalance(val.emp_id)
                }
            },
            "formData.emp_dob": function() {
                if(this.formData.emp_dob) {
                    this.formData.age = this.getAge(this.formData.emp_dob);
                } else {
                    this.formData.age = '';
                }
            }

        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "PRL Application"});
            this.loadData();
        },
        data() {
            return {
                unique_code_message: '',
                errorMessage: {color: 'red'},
                dateValueType: this.dateFormatter(),
                formData: {
                    leave_type_id:11,
                    leave_days:0,
                    application_date: moment().format("YYYY-MM-DD"),
                    leave_start_date:null,
                    leave_end_date:null,
                    leave_reason:null,
                    available_balance:null,
                    service_period: null,
                    monday:null,
                    age: null
                },
                selectedEmployee:{},
                selected:{},
                updateIndex: -1,
                submitBtn: 'Submit',
                empIdList: [],
                emp_code: {},
                leavetypes: [],
                perPage:5,
                totalList:0,
                file: '',
                show: true,
                leaveBal: [],
                leaveValFields: [
                    {key: 'leave_type', label: 'Leave Type'},
                    {key: 'leave_enjoy', label: 'Spent', variant: 'secondary'},
                    {key: 'remaining_balance', label: 'Balance', sortable: true, variant: 'danger'},
                    {key: 'monday', label: 'Months', sortable: true, variant: 'success'}
                ],
                fields: [
                    {key: 'emp_code', label: 'Emp Code', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'emp_name', label: 'Employee Name', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'department_name', label: 'Department', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'designation', label: 'Designation', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'emp_dob', label: 'Date Of Birth', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'quota_name', label: 'Quota', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'emp_join_date', label: 'Join Date', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {key: 'application_date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }, label: 'Application Date', sortable: true, sortDirection: 'desc', class: 'text-left'},
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
                   // {key: 'leave_days', label: 'Leave days', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    'action'],
                items: []
            }
        },
        computed:{
            leave_days:function(){
                //return this.message.split('').reverse().join('')
                let statrDate=moment(this.formData.leave_start_date);
                let endDate=moment(this.formData.leave_end_date);
                let countDays=endDate.diff(statrDate,'days');
                // this.leavedays=this.countDays;
                if (!this.formData.emp_id) {
                    return null;
                }
                else{
                    return countDays+1;
                }
            },
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
                if(id && (id !== undefined)) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/emp-search/${id}`, this.formData).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            validateGeneral: async function() {
                const general = Promise.all([
                    this.$validator.validate('leave_start_date', this.formData.leave_start_date),
                    this.$validator.validate('leave_end_date', this.formData.leave_end_date),
                    this.$validator.validate('application_date', this.formData.application_date)
                ]);

                const areValid = (await general).every(isValid => isValid);
                const uniqueCode = (this.unique_code_message=='');

                return areValid && uniqueCode;
            },
            onSubmit() {
                let currObj = this;
                this.$validator.validateAll().then(() => {
                    if (!this.errors.any()) {
                        this.formData.leave_days = this.leave_days;
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pension/store-prl-leave", this.formData).then(res => {
                            if (res.data.o_status_code == 1) {
                                currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                this.loadData();
                                this.onReset();
                            } else {
                                currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                            }
                        });
                    }
                });
            },
            loadData: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/leave/leave-entry", this.formData).then(res => {
                    this.leavetypes=res.data.prlLeaveTypes.filter(a=>a.leave_type_id==11);
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/get-prl-data`).then(res => {
                    this.items=res.data;
                    this.totalList = res.data.length;
                });
            },


            onReset() {
                this.show = false;
                this.$nextTick(() => {
                    this.selectedEmployee={};
                    this.clearFields();
                    this.updateIndex = -1;
                    this.submitBtn = 'Submit';
                    this.show = true;

                });
            },
            clearFields() {
                this.formData.emp_name = '';
                this.formData.emp_id = '';
                this.formData.department_name = '';
                this.formData.designation =  '';
                this.formData.emp_dob =  '';
                this.formData.quota_name =  '';
                this.formData.emergency_num = '';
                this.formData.leave_end_date ='';
                this.formData.join_year ='';
                this.formData.leave_start_date ='';
                this.formData.available_balance='';
            },
            editRow(item) {
                this.selectedEmployee = item;
                this.getLeaveBalance(item.emp_id);
                this.formData = item;
                console.log(item);
                $(document).scrollTop(0);
                this.submitBtn = 'Update'
            },

            getLeaveBalance(id){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/leave-balance/${id}`).then(res => {
                    this.leaveBal = res.data;
                });
            },
        },

    }
</script>

<style>
    img {
        height: auto;
        max-width: 2.5rem;
        margin-right: 1rem;
    }
    .required label:after{
        content:"*";
        color:red;
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
</style>
