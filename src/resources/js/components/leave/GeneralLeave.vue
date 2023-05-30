<template>
    <div>
        <b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">General Leave Application</b-card-header>
            <b-card-body class="border">
                <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Employee Code"
                                label-for="emp_id"
                                class="requiredField"
                                label-cols-md="4"
                            >
                                <v-select
                                    label="option_name"
                                    v-model="selectedEmployee"
                                    :options="empIdList"
                                    @search="searchempcods">
                                    <template #search="{attributes, events}">
                                        <input
                                            class="vs__search"
                                            :required="selectedEmployee && selectedEmployee.emp_id==null"
                                            v-bind="attributes"
                                            v-on="events"
                                        />
                                    </template>
                                </v-select>
                                <b-form-input v-model="LeaveEntry.emp_id" hidden></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="LEAVE TYPE"
                                label-for="leave_type_id"
                                class="requiredField"
                                label-cols-md="4"
                            >
                                <b-form-select
                                    v-model="LeaveEntry.leave_type_id"
                                    required
                                    id="leave_type_id"
                                    :options="leavetypes">
                                </b-form-select>
                            </b-form-group>
                        </b-col>



                        <b-col md="4">
                            <b-form-group
                                label="Employee Name"
                                label-for="emp_name"
                                label-cols-md="4"
                            >
                                <b-form-input
                                    v-model="LeaveEntry.emp_name"
                                    disabled >
                                </b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group
                                label="Designation"
                                label-for="designation"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="LeaveEntry.designation" disabled ></b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group
                                label="Department"
                                label-for="department_name"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="LeaveEntry.department_name" disabled ></b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group
                                label="Application Date"
                                label-for="application_date"
                                class="requiredField"
                                label-cols-md="4"
                            >
                                <date-picker
                                    v-model="LeaveEntry.application_date"
                                    width="100%"
                                    input-class="form-control"
                                    type="date"
                                    @change="LeaveEntry.leave_start_date = '', LeaveEntry.approve_date = ''"
                                    lang="en"
                                    required  v-validate="'required'"
                                    format="DD-MM-YYYY" :value-type="dateValueType"
                                    name="application_date"
                                ></date-picker>
                                <span :style="errorMessage">{{ errors.first('application_date') }}</span>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group
                                label="Start Date"
                                label-for="leave_start_date"
                                class="requiredField"
                                label-cols-md="4"
                            >
                                <date-picker
                                    v-model="LeaveEntry.leave_start_date"
                                    width="100%"
                                    input-class="form-control"
                                    type="date"
                                    lang="en"
                                    @change="LeaveEntry.leave_end_date = ''"
                                    required  v-validate="'required'"
                                    format="DD-MM-YYYY" :value-type="dateValueType"
                                    name="leave_start_date"
                                ></date-picker>
                                <span :style="errorMessage">{{ errors.first('leave_start_date') }}</span>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="End Date"
                                label-for="leave_end_date"
                                class="requiredField"
                                label-cols-md="4"
                            >
                                <date-picker
                                    v-model="LeaveEntry.leave_end_date"
                                    width="100%"
                                    input-class="form-control"
                                    type="date"
                                    lang="en"
                                    :not-before="LeaveEntry.leave_start_date"
                                    required  v-validate="'required'"
                                    format="DD-MM-YYYY" :value-type="dateValueType"
                                    name="leave_end_date"
                                ></date-picker>
                                <span :style="errorMessage">{{ errors.first('leave_end_date') }}</span>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group
                                label="Leave Days"
                                label-for="leave_days"
                                label-cols-md="4"
                            >
                                <b-form-input
                                    v-model="leave_days"
                                    disabled
                                    required
                                    id="leave_days">
                                </b-form-input>
                                <div :class="{'invalid-feedback':true ,'d-block':LeaveEntry.leave_type_id ==10 && leave_days> 15}">Leave days cannot exceed 15 days!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Leave Reason"
                                label-for="leave_reason"
                                label-cols-md="4"
                            >
                                <b-textarea
                                    v-model="LeaveEntry.leave_reason"
                                    rows="2"
                                    max-rows="5">
                                </b-textarea>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Emergency Number"
                                label-for="emergency_num"
                                label-cols-md="4"
                            >
                                <b-form-input
                                    v-model="LeaveEntry.emergency_num"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col hidden md="4" v-if="LeaveEntry.leave_type_id == 5">
                            <b-form-group label="Full Pay" label-for="full_pay_yn" label-cols-md="4">
                                <b-form-checkbox
                                        id="full_pay_yn"
                                        v-model="LeaveEntry.full_pay_yn"
                                        name="full_pay_yn"
                                        value="Y"
                                        unchecked-value="N"
                                >
                                    Full Pay
                                </b-form-checkbox>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group label="Attachment" label-for="attachment" class="message" label-cols-md="4">
                                <b-form-file
                                    @change="encodeFileEnd"
                                    id="attachment"
                                    placeholder="Attachment"
                                ></b-form-file>
                            </b-form-group>
                        </b-col>

                    </b-row>

                    <div class="col-md-12 pr-0 d-flex justify-content-end">
                        <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">{{submitBtn}}</b-button>&nbsp;
                        <b-button type="reset" class="btn btn-outline-dark  mb-1">Cancel</b-button>
                    </div>
                </b-form>

            </b-card-body>
        </b-card>
        <b-card >
            <b-card-header header-bg-variant="dark" header-text-variant="white">Application List</b-card-header>
            <b-card-body class="border">
                <Datatable v-bind:fields="fields" :totalList="totalList" :perPage="perPage"
                           v-bind:items="items">
                    <template v-slot:actions="{ rows }">
                        <b-link ml="4" class="text-primary"
                                @click="editRow(rows.item)">
                            <i class="bx bx-edit cursor-pointer"></i>
                        </b-link>
                        <a v-if="rows.item.attachment" :href="'/v1/leave/leave-attachment-download/'+rows.item.leave_id">
                            <i class='bx bx-file' ></i>
                        </a>
                    </template>
                </Datatable>
            </b-card-body>
        </b-card>
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
        name: "general-leave",
        components: {DatePicker,Datatable,Vue,vSelect,vcss},
        data() {
            return {
                submitBtn: 'Save',
                selected: {},
                selectedApprovedEmployee: {},
                unique_code_message: '',
                errorMessage: {color: 'red'},
                empIdList: [],
                selectedEmployee: {},
                dateValueType: this.dateFormatter(),
                LeaveEntry: {
                    leave_days:0,
                    application_date: moment().format("YYYY-MM-DD"),
                    leave_start_date: moment().format("YYYY-MM-DD"),
                    leave_end_date: moment().format("YYYY-MM-DD"),
                    approve_date:moment().format("YYYY-MM-DD"),
                    leave_type_id: '',
                    emp_id: '',
                    emp_name: '',
                    designation: '',
                    department_name: '',
                    approve_by_emp_id: '',
                    leave_approve_ref_no: '',
                    leave_reason: '',
                    emergency_num: '',
                    attachment: '',
                    full_pay_yn: 'N'
                },
                leavetypes: [],
                preLeaveTypes: [],
                perPage: 5,
                totalList: 1,
                fields: [
                    {key: 'emp_code', label: 'Emp Code', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'emp_name', label: 'Employee Name', sortable: true, sortDirection: 'desc'},
                    {key: 'department_name', label: 'Department', sortable: true, sortDirection: 'desc'},
                    {key: 'designation', label: 'Designation', sortable: true, sortDirection: 'desc'},
                    {key: 'leave_type', label: 'Leave Type', sortable: true, sortDirection: 'desc'},
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
                        class: 'text-right'
                    },
                    {
                        key: 'leave_start_date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        label: 'Start Date',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-right'
                    },
                    {
                        key: 'leave_end_date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        label: 'End Date',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-right'
                    },
                    {key: 'leave_days', label: 'Leave days', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'leave_reason', label: 'Leave Reason', sortable: true, sortDirection: 'desc'},
                    'action'
                ],
                items: []
            }
        },
        mounted() {
            this.loadData()
        },
        watch: {
            selectedEmployee:function(val,oldVal) {
                if(val !== null) {
                    this.LeaveEntry.emp_name=  val.emp_name;
                    this.LeaveEntry.emp_id=  val.emp_id;
                    if ( val.department)
                        this.LeaveEntry.department_name=  val.department.department_name;
                    if(val.designation)
                        this.LeaveEntry.designation=  val.designation.designation;

                    if(val.job_duration < 3){
                        this.leavetypes = this.preLeaveTypes.filter(a=>a.leave_type_id != 10)
                    } else {
                        this.leavetypes = this.preLeaveTypes
                    }
                }
            },
            "LeaveEntry.leave_type_id":function (val, oldVal) {
                if(val != 5){
                    this.LeaveEntry.full_pay_yn = ''
                }
            }
        },
        computed: {
            leave_days:function(){
                let statrDate=moment(this.LeaveEntry.leave_start_date);
                let endDate=moment(this.LeaveEntry.leave_end_date);
                let countDays=endDate.diff(statrDate,'days');
                if (isNaN(countDays)) {
                    return null;
                }
                else{
                    return countDays+1;
                }
            },
        },
        methods: {
            onSubmit() {
                let currObj = this;
                if(this.LeaveEntry.leave_type_id == 10 && this.leave_days > 15){
                    currObj.$notify({group: 'pmis', text: 'Rest and recreation leave cannot exceed 15 days!', type: 'error'})
                } else {
                    this.$validator.validateAll().then(() => {
                        if (!this.errors.any()) {
                            let id = this.LeaveEntry.leave_id;
                            this.LeaveEntry.leave_days = this.leave_days;
                            this.LeaveEntry.approve_by_emp_id = this.selectedApprovedEmployee.emp_id;

                            if (id > 0) {
                                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/leave/leave-entry/existing/${id}`, this.LeaveEntry).then(res => {
                                    if (res.data.o_status_code == 1) {
                                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                        this.loadData();
                                        this.onReset();
                                    } else {
                                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                                    }
                                });
                            } else {
                                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/leave/leave-entry", this.LeaveEntry).then(res => {
                                    if (res.data.o_status_code == 1) {
                                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                        this.loadData();
                                        this.onReset();
                                    } else {
                                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                                    }
                                });
                            }
                        } else {
                            console.log(this.errors)
                        }
                    });
                }

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
                            vm.LeaveEntry.attachment = reader.result;
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
            validateGeneral: async function() {
                const general = Promise.all([
                    this.$validator.validate('leave_start_date', this.LeaveEntry.leave_start_date),
                    this.$validator.validate('leave_end_date', this.LeaveEntry.leave_end_date),
                    this.$validator.validate('application_date', this.LeaveEntry.application_date)
                ]);

                const areValid = (await general).every(isValid => isValid);
                const uniqueCode = (this.unique_code_message=='');

                return areValid && uniqueCode;
            },
            searchempcods(id){
                if(id && (id !== undefined)) {
                    let url = this.$store.getters.user.user_name == 'admin' ? `/leave/leave-entry/emp-info/${id}`:`/leave/leave-entry/emp-info/${id}/${this.$store.getters.user.department_id}`
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, url).then(res => {
                        this.empIdList = res.data.empcodeList;
                    })
                }
            },
            loadData: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/leave/department-wise-leave/${this.$store.getters.user.department_id}`).then(res => {
                    this.preLeaveTypes=res.data.leavetypes;
                    this.items=res.data.data;
                    this.totalList = res.data.data.length;
                });
            },
            editRow(ob) {
                this.LeaveEntry = ob;
                this.selectedEmployee = {'option_name':ob.option_name,'emp_id':ob.emp_id, 'emp_name':ob.emp_name};
                this.selectedApprovedEmployee = {'option_name':ob.approve_option_name,'emp_id':ob.approve_emp_id};
                $(document).scrollTop(0);
                this.submitBtn = 'Update'
            },
            dateFormatter: function() {
                return {
                    value2date: value => {
                        return value ? moment(new Date(value), "YYYY-MM-DD").toDate() : null
                    },
                    date2value: date => {
                        return date ? moment(date).format("YYYY-MM-DD") : null
                    }
                }
            },
            onReset() {
                this.$nextTick(() => {
                    this.selectedEmployee='';
                    this.selectedApprovedEmployee='';
                    this.LeaveEntry = {
                        leave_days:0,
                        application_date: moment().format("YYYY-MM-DD"),
                        leave_start_date: moment().format("YYYY-MM-DD"),
                        leave_end_date: moment().format("YYYY-MM-DD"),
                        approve_date:moment().format("YYYY-MM-DD"),
                        leave_type_id: '',
                        emp_id: '',
                        emp_name: '',
                        designation: '',
                        department_name: '',
                        approve_by_emp_id: '',
                        leave_approve_ref_no: '',
                        leave_reason: '',
                        emergency_num: '',
                        full_pay_yn: ''
                    }
                    this.submitBtn = 'Save';
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
