<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <b-card-header header-bg-variant="dark" header-text-variant="white">Leave Approval</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset="onReset">
                        <b-row>
<!--                            <b-col md="5">-->
<!--                                <b-form-group-->
<!--                                label="Department"-->
<!--                                class="requiredField"-->
<!--                                label-for="department_id"-->
<!--                                label-cols-md="4">-->
<!--                                    <b-form-select-->
<!--                                        v-model="searchEmployee.department_id"-->
<!--                                        :options="departments"-->
<!--                                        class=""-->
<!--                                        required-->
<!--                                        value-field="value"-->
<!--                                        text-field="text"-->
<!--                                        disabled-field="notEnabled"-->
<!--                                        id="department_id"-->
<!--                                    ></b-form-select>-->
<!--                                </b-form-group>-->
<!--                            </b-col>-->
                            <b-col md="5">
                                <b-form-group
                                label="Employee"
                                label-cols-md="4">
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
                                                    name="employee"
                                                />
                                            </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="7">
                                    <b-button md="6"  size="md" variant="success" type="submit" >Search</b-button>&nbsp;
                                    <b-button md="6"  size="md" variant="dark" type="reset" >Reset</b-button>&nbsp;
                            </b-col>

                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Leave Application Data</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmitLeave" @reset.prevent="onResetLeave" v-if="show">
                        <Datatable v-bind:fields="fields" :totalList="totalList" :perPage="perPage" v-bind:items="items"  v-bind:pageColSize="4" v-bind:searchColSize="5" :primaryKeyColumnName="'roster_date'">
                            <template  v-slot:action2="{ rows }">
                                        {{rows.index + 1}}
                            </template>
                            <template  v-slot:action3="{ rows }">
<!--                                <b-form-select v-if="rows.item.approve_status != 1"-->
<!--                                            v-model="rows.item.approve_status_edit"-->
<!--                                            :options="statusList"-->
<!--                                            class=""-->
<!--                                            value-field="value"-->
<!--                                            text-field="text"-->
<!--                                            disabled-field="notEnabled" @change="rows.item.submit=true"-->
<!--                                        ></b-form-select>-->
                                <label v-if="rows.item.approve_status == 1">Approved</label>
                                <label v-else-if="rows.item.approve_status == 2">Reject</label>
                                <label v-else>Pending</label>
                            </template>
                            <template v-slot:action4="{rows}">
                                <b-button size="sm" @click="info(rows.item, rows.index, $event.target)" class="mr-1"><i class='bx bxs-detail'></i> Details</b-button>
                            </template>
                        </Datatable>
<!--                        <b-row>-->
<!--                            <div class="col-md-12 pr-0 d-flex justify-content-end mt-1">-->
<!--                                <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1">Submit</b-button>-->
<!--                            </div>-->
<!--                        </b-row>-->
                    </b-form>
                </b-card-body>
            </b-card>
            <b-modal ref="my-modal"  :id="infoModal.id" :title="infoModal.title" size="xl"  @hide="resetInfoModal" >
                <b-row>
                    <b-col md="4">
                        <b-form-group
                            label="Leave Type"
                            label-for="leave_type"
                            label-cols-md="4"
                        >
                            <b-form-input disabled id="leave_type" :value="infoModal.leave_type"></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Employee Name"
                            label-for="emp_name"
                            label-cols-md="4"
                        >
                            <b-form-input disabled id="emp_name" :value="infoModal.emp_name"></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Designation"
                            label-for="designation"
                            label-cols-md="4"
                        >
                            <b-form-input disabled id="designation" :value="infoModal.designation"></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Employee Code"
                            label-for="emp_code"
                            label-cols-md="4"
                        >
                            <b-form-input disabled id="emp_code" :value="infoModal.emp_code"></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Application Date"
                            label-for="application_date"
                            label-cols-md="4"
                        >
                            <b-form-input disabled id="application_date" :value="infoModal.application_date|formattedDate"></b-form-input>
                        </b-form-group>
                    </b-col>


                    <b-col md="4">
                        <b-form-group
                            label="Leave Start Date"
                            label-for="leave_start_date"
                            label-cols-md="4"
                        >
                            <b-form-input disabled id="leave_start_date" :value="infoModal.leave_start_date|formattedDate"></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Leave End Date"
                            label-for="leave_end_date"
                            label-cols-md="4"
                        >
                            <b-form-input disabled id="leave_end_date" :value="infoModal.leave_end_date|formattedDate"></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Leave Days"
                            label-for="leave_days"
                            label-cols-md="4"
                        >
                            <b-form-input disabled id="leave_days" :value="infoModal.leave_days"></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Status"
                            label-for="leave_days"
                            label-cols-md="4"
                        >
                            <b-form-input disabled id="leave_days" :style="`color:#fff !important; font-weight: bold;background-color: ${infoModal.approve_status == 1 ? 'green' : '#fc960f'}`" v-if="infoModal.approve_status == 0 || infoModal.approve_status == 1" :value="infoModal.approve_status == 1 ? 'Approve' : 'Pending'"></b-form-input>
                            <b-form-input disabled id="leave_days"  style="background-color: red;color:#fff !important; font-weight: bold"  v-else value="Reject"></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="12">
                        <b-form-group
                            label="Leave Reason"
                            label-for="leave_reason"
                        >
                            <b-form-textarea disabled id="leave_reason" :value="infoModal.leave_reason"></b-form-textarea>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row class="leave_summery">
                    <b-col md="12" class="mb-2">
                        <h5>Leave Summery</h5>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Total Leave"
                            label-for="total_leave"
                            label-cols-md="4"
                        >
                           <b-form-input readonly id="total_leave" :value="leaveSummery.leave_days"></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Total Enjoy"
                            label-for="leave_enjoy"
                            label-cols-md="4"
                        >
                            <b-form-input readonly id="total_leave" :value="leaveSummery.leave_enjoy"></b-form-input>
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Total Remaining"
                            label-for="total_remaining"
                            label-cols-md="4"
                        >
                            <b-form-input readonly id="total_leave" :value="leaveSummery.remaining_balance"></b-form-input>
                        </b-form-group>
                    </b-col>

                </b-row>
                <div slot="modal-footer">
                    <b-link  v-if="infoModal.attachment" :href='infoModal.attachment'  download><i class="bx bx-download cursor-pointer" title="Download Attachment"></i> </b-link>
                    <b-button v-if="infoModal.attachment" variant="success" @click="showAttachmnet(infoModal.attachment)">View Attachment</b-button>
                    <b-button variant="primary" v-if="infoModal.approve_status == 0" @click="leaveApprove(infoModal.leave_id)">Approved</b-button>
                    <b-button variant="danger" v-if="infoModal.approve_status == 0" @click="leaveReject(infoModal.leave_id)">Reject</b-button>
                    <b-button variant="secondary" @click="hideModal">Close</b-button>
                </div>
            </b-modal>
        </div>


    </div>
</template>

<script>
    import DatePicker from "vue2-datepicker";
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import ApiRepository from '../../Repository/ApiRepository';
    import Datatable from '../../layouts/common/datatable';
    import moment from 'moment';
    export default {
        components: {DatePicker,vSelect,Datatable,vcss},
        data() {
            return {
                interviwdate: new Date(),
                searchEmployee: {
                    emp_id: null,
                    department_name: '',
                    department_id: null,
                    selectedEmployee:{}
                },
                selectedEmployee: {'option_name':'','emp_id':'', 'emp_name':''},
                leaveSummery: {},
                empIdList: [],
                empNameList: [{text: 'Waker', value: 1}, {text: 'Jamil', value: 2}],
                show: true,
                statusList: [
                    // {text: 'Select Status', value: null},
                    {text: 'Approved', value: 1},
                    {text: 'Reject', value: -1}
                    ],
                boardactionlist: [{text: 'Interview', value: 1}, {text: 'Reject', value: 2}],
                fields: [
                    {key: 'action2', label: 'Sl', sortable: true, sortDirection: 'desc'},
                    {key: 'emp_code', label: 'Emp Code', sortable: true, sortDirection: 'desc'},
                    {key: 'emp_name', label: 'Employee Name', sortable: true, sortDirection: 'desc'},
                    {key: 'leave_type', label: 'Leave Type', sortable: true, sortDirection: 'desc'},
                    {key: 'application_date', label: 'Application Date',formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }, sortable: true, sortDirection: 'desc', class: 'text-right'},
                    {key: 'leave_start_date', label: 'Start Date',formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable: true, sortDirection: 'desc', class: 'text-right'},
                    {key: 'leave_end_date', label: 'End Date',formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable: true, sortDirection: 'desc', class: 'text-right'},
                    {key: 'leave_days', label: 'Date Received', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'action4', label: 'Reason'},
                    {key: 'action3', label: 'Status', class: 'text-center'}
                ],
                items: [],
                departments: [],
                totalList: 0,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
                infoModal: {
                    id: 'info-modal',
                    title: '',
                    attachment: '',
                    content: '',
                    application_date: "",
                    approve_status: "",
                    approve_status_edit: "",
                    designation: "",
                    emp_code: "",
                    emp_id: "",
                    emp_name: "",
                    leave_days: "",
                    leave_end_date: "",
                    leave_id: "",
                    leave_reason: null,
                    leave_start_date: "",
                    leave_type: "",
                    leave_type_id: ""
                },
            }
        },
          mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Leave"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Approval Leave"});
            this.loadData();
            this.loadLeaveData();
        },
        watch: {
            selectedEmployee:function(val,oldVal) {
                 if(val != null){
                    this.searchEmployee.emp_id = val.emp_id;
                    if ( val.department) {
                          this.searchEmployee.department_name =  val.department.department_name;
                          this.searchEmployee.department_id =  val.department.department_id;
                    }else {
                        this.searchEmployee.department_name =  ''
                        this.searchEmployee.department_id =  ''
                    }
                }
            }
          },
        filters: {
            formattedDate: function (value) {
                if (!value) return ''
                return moment(value).format('DD-MM-YYYY');
            }
        },
        methods: {
            info(item, index, button) {
                this.infoModal = {
                    id: 'info-modal',
                    title: `Application Details`,
                    attachment: item.attachment,
                    content: !(`${item.leave_reason}`)?`${item.leave_reason}`:'',
                    application_date: item.application_date,
                    approve_status: item.approve_status,
                    approve_status_edit: item.approve_status_edit,
                    designation: item.designation,
                    emp_code: item.emp_code,
                    emp_id: item.emp_id,
                    emp_name: item.emp_name,
                    leave_days: item.leave_days,
                    leave_end_date: item.leave_end_date,
                    leave_id: item.leave_id,
                    leave_reason: item.leave_reason,
                    leave_start_date: item.leave_start_date,
                    leave_type: item.leave_type,
                    leave_type_id: item.leave_type_id
                }
                this.loadLeaveTotalSummery(item);
                this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            },
            resetInfoModal() {
                this.infoModal = {
                    id: 'info-modal',
                    title: '',
                    content: '',
                    attachment: '',
                    application_date: "",
                    approve_status: "",
                    approve_status_edit: "",
                    designation: "",
                    emp_code: "",
                    emp_id: "",
                    emp_name: "",
                    leave_days: "",
                    leave_end_date: "",
                    leave_id: "",
                    leave_reason: null,
                    leave_start_date: "",
                    leave_type: "",
                    leave_type_id: ""
                }
            },
            loadLeaveTotalSummery(item) {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/leave/leave-total-summery",item).then(res => {
                     this.leaveSummery = res.data.summery;
                });
            },
            leaveApprove(leave_id) {
                let currObj =this;
                let item = {'leave_id' : leave_id};
                 item.approve_status_edit = 1;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/leave/leave-approval/single-approve`,item).then(res => {
                    if(res.data.o_status_code == 1) {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.loadLeaveData();
                    }else{
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                    this.$refs['my-modal'].hide()
                });
            },
            leaveReject(leave_id) {
                let currObj = this;
                let item = {'leave_id' : leave_id};
                item.approve_status_edit = 2;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/leave/leave-approval/single-approve`,item).then(res => {
                    if(res.data.o_status_code == 1) {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.loadLeaveData();
                    }else{
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                    this.$refs['my-modal'].hide()
                });
            },
            hideModal() {
                this.$refs['my-modal'].hide()
            },
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/leave/leave-approval").then(res => {
                     this.departments = res.data.departments;
                });
            },

            loadLeaveData() {
                this.searchEmployee.department_id = this.searchEmployee.department_id?this.searchEmployee.department_id: this.$store.getters.user.department_id
                this.searchEmployee.selectedEmployee = this.selectedEmployee ? this.selectedEmployee : null;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/leave/leave-approval/search", this.searchEmployee).then(res => {
                    if(this.$route.query.leave_id){
                        this.items = res.data.leaveData.filter(a=>a.leave_id == this.$route.query.leave_id);
                        this.totalList = this.items.length;
                    } else {
                        this.items = res.data.leaveData
                        this.totalList = this.items.length;
                    }

                });
            },
            searchEmployeeCodes(id){
                id = id.trim();
                if(id.length > 2) {
                   let url = this.$store.getters.user.user_name == 'admin' ? `/leave/leave-entry/emp-info/${id}`:`/leave/leave-entry/emp-info/${id}/${this.$store.getters.user.department_id}`

                    ApiRepository.callApi(ApiRepository.GET_COMMAND, url).then(res => { // This url seems inaccurate! but employee data should be same so using this url.
                        this.empIdList = res.data.empcodeList;
                        if (res.data.empcodeList)
                        this.emp_name=res.data.empcodeList.emp_name;
                    })
                }
            },
            onSubmit() {
                this.loadLeaveData();
             },
            onSubmitLeave() {
                 let currObj = this;
                  ApiRepository.callApi(ApiRepository.POST_COMMAND, `/leave/leave-approval/approve`,this.items).then(res => {
                      if(res.data.o_status_code == 1) {
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                          this.loadLeaveData();
                        }else{
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                });
             },

            onReset(evt) {
                evt.preventDefault();
               this.searchEmployee = {department_id: '',};
               this.selectedEmployee = '';

            },
            editRow(i, code) {
                this.submitBtn = 'Update';
                this.updateIndex = i;
                let data = this.tableData.items[i];
                this.form.employee_id = data.employee_id;
                this.form.department_name = data.department_name;
                this.form.designation = data.designation;
                this.form.division_name = data.division_name;
                this.form.financial_code = data.financial_code;
                this.form.shift = data.shift;

                console.log(this.form);

            },
            deleteRow(i, code) {
                if (i > -1) {
                    this.tableData.items.splice(i, 1);
                }
            },
            showAttachmnet(data) {
                const win = window.open("","_blank");
                let html = '';
                html += '<html>';
                html += '<body style="margin:0!important">';
                html += '<embed width="100%" height="100%" src="'+data+'"/>';
                html += '</body>';
                html += '</html>';
                setTimeout(() => {
                    win.document.write(html);
                }, 0);
            }

        }
    }
</script>

<style>
    div.requiredField  label:after{
        content: '*';
        color: red;
    }
    .leave_summery{
        background-color: #39da8a;
        padding-top: 15px;
    }
</style>
