<template>
    <div class="content-body">
        <b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">Casual Leave Application</b-card-header>
            <b-card-body class="border">
                <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Application Date"
                                label-for="application_date"
                                class="requiredField"
                            >
                                <date-picker
                                    v-model="LeaveEntry.application_date"
                                    width="100%"
                                    input-class="form-control"
                                    type="date"
                                    @change="LeaveEntry.leave_start_date = '', LeaveEntry.approve_date = ''"
                                    lang="en"
                                    required
                                    format="DD-MM-YYYY" :value-type="dateValueType"
                                    name="application_date"
                                ></date-picker>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group
                                label="Start Date"
                                label-for="leave_start_date"
                                class="requiredField"
                            >
                                <date-picker
                                    v-model="LeaveEntry.leave_start_date"
                                    width="100%"
                                    input-class="form-control"
                                    type="date"
                                    lang="en"
                                    @change="LeaveEntry.leave_end_date = ''"
                                    required
                                    format="DD-MM-YYYY" :value-type="dateValueType"
                                    name="leave_start_date"
                                ></date-picker>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="End Date"
                                label-for="leave_end_date"
                                class="requiredField"
                            >
                                <date-picker
                                    v-model="LeaveEntry.leave_end_date"
                                    width="100%"
                                    input-class="form-control"
                                    type="date"
                                    lang="en"
                                    :not-before="LeaveEntry.leave_start_date"
                                    required
                                    format="DD-MM-YYYY" :value-type="dateValueType"
                                    name="leave_end_date"
                                ></date-picker>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group
                                label="Leave Days"
                                label-for="leave_days"
                            >
                                <b-form-input
                                    v-model="leave_days"
                                    disabled
                                    required
                                    id="leave_days">
                                </b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group
                                label="Emergency Number"
                                label-for="emergency_num"
                            >
                                <b-form-input
                                    v-model="LeaveEntry.emergency_num"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group label="Attachment" label-for="attachment" class="message">
                                <b-form-file
                                    @change="encodeFileEnd"
                                    id="attachment"
                                    placeholder="Attachment"
                                ></b-form-file>
                            </b-form-group>
                        </b-col>
                        <b-col md="12">
                            <b-form-group
                                label="Leave Reason"
                                label-for="leave_reason"
                            >
                                <b-textarea
                                    v-model="LeaveEntry.leave_reason"
                                    rows="2"
                                    max-rows="5">
                                </b-textarea>
                            </b-form-group>
                        </b-col>
                    </b-row>

                    <div class="col-md-12 pr-0 d-flex justify-content-end">
                        <b-button type="submit" class="btn btn-dark shadow mr-1">Submit</b-button>&nbsp;
                        <b-button type="reset" class="btn btn-outline-dark">Cancel</b-button>
                    </div>
                </b-form>

            </b-card-body>
        </b-card>
        <b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">Leave Summary</b-card-header>
            <b-card-body class="border">
                <Datatable :items="items" :perPage="perPage" :fields="fields" :totalList="totalList"></Datatable>
            </b-card-body>
        </b-card>

        <b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">Leave Enjoy</b-card-header>
            <b-card-body class="border">
                <Datatable :items="enjoyItems" :perPage="perPage" :fields="enjoyFields" :totalList="enjoyTotalList"></Datatable>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import Datatable from "../../../layouts/common/datatable"
    import ApiRepository from "../../../Repository/ApiRepository"
    import DatePicker from "vue2-datepicker";
    import moment from "moment";
    export default {
        name: "Leave",
        components: {Datatable, DatePicker},
        data() {
            return {
                dateValueType: this.dateFormatter(),
                errorMessage: {color: 'red'},
                LeaveEntry: {
                    leave_days:0,
                    application_date: moment().format("YYYY-MM-DD"),
                    leave_start_date: moment().format("YYYY-MM-DD"),
                    leave_end_date: moment().format("YYYY-MM-DD"),
                    approve_date:moment().format("YYYY-MM-DD"),
                    leave_type_id: 7,
                    emp_id: '',
                    emp_name: '',
                    designation: '',
                    department_name: '',
                    approve_by_emp_id: '',
                    leave_approve_ref_no: '',
                    leave_reason: '',
                    emergency_num: '',
                    attachment: ''
                },
                fields: [
                    {key: 'leave_type', label: 'Leave Type', orderDate: true},
                    {key: 'leave_enjoy', label: 'Leave Enjoy', orderDate: true},
                    {key: 'remaining_balance', label: 'Leave Remaining', sortable: true}
                ],
                enjoyFields: [
                    {key: 'index', label: 'Sl.', sortable: true},
                    {
                        key: 'application_date',
                        label: 'Application Date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        orderDate: true},
                    {
                        key: 'approve_date',
                        label: 'Approve Date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        orderDate: true
                    },
                    {key: 'leave_type', label: 'Leave Type', sortable: true},
                    {
                        key: 'leave_start_date',
                        label: 'Start Date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        sortable: true
                    },
                    {
                        key: 'leave_end_date',
                        label: 'End Date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        sortable: true
                    },
                    {key: 'leave_days', label: 'Leave Days', sortable: true}
                ],
                items: [],
                enjoyItems: [],
                perPage: 5,
                totalList: 1,
                enjoyTotalList: 1
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty")
            this.$store.commit("setBreadcrumb", {link: "dashboard", label: "Dashboard"})
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account", label: "My Account"})
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account/leave", label: "My Leave"})
            this.loadLeave()
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
            loadLeave() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/api/leave`).then(result => {
                    this.items = result.data.data.leave_remaining
                    this.totalList = this.items.length

                    this.enjoyItems = result.data.data.leave_enjoy
                    this.enjoyTotalList = this.enjoyItems.length
                });
            },
            onSubmit() {
                let currObj = this;
                let id = this.LeaveEntry.leave_id;
                this.LeaveEntry.leave_days = this.leave_days;

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
            },
            onReset() {
                this.$nextTick(() => {
                    this.selectedEmployee='';
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
                        emergency_num: ''
                    }
                    this.submitBtn = 'Save';
                });
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
        }
    }
</script>

<style scoped>

</style>
