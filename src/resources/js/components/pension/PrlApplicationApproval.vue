<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <b-card-header header-bg-variant="dark" header-text-variant="white">PRL Application Approval</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSearch" @reset.prevent="onReset" v-if="show">
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Department"
                                    label-for="department_id"
                                    >
                                    <b-form-select
                                        id="department_id"
                                        v-model="searchEmployee.department_id"
                                        :options="departments"
                                        required
                                        value-field="department_id"
                                        text-field="department_name"
                                    ></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Employee Code"
                                    label-for="employee"
                                >
                                    <v-select
                                        label="option_name"
                                        v-model="selectedEmployee"
                                        :options="empIdList"
                                        @search="searchEmployeeCodes">
                                        <template #search="{attributes, events}">
                                            <input
                                                id="employee"
                                                class="vs__search"
                                                v-bind="attributes"
                                                v-on="events"
                                                name="employee"
                                            />
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-button-group class="mt-1">
                                    <b-button md="6"  size="md" variant="success" type="submit" >Search</b-button>
                                    <b-button md="6"  size="md" variant="dark" type="reset" >Reset</b-button>
                                </b-button-group>
                            </b-col>

                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">PRL Application Approval List</b-card-header>
                <b-card-body class="border">
                        <Datatable v-bind:fields="fields" :totalList="totalList" :perPage="perPage" v-bind:items="items"  v-bind:pageColSize="4" v-bind:searchColSize="5" :primaryKeyColumnName="'roster_date'">
                            <template  v-slot:action2="{ rows }">
                                {{rows.index + 1}}
                            </template>

                            <template v-slot:action4="{ rows }">
                                <b-link ml="4" class="text-primary" v-if="rows.item.approve_status != 1 && rows.item.approve_status != -1" v-b-modal.modal-center @click="renderModal(rows.item)">
                                    <i class="bx bx-link cursor-pointer"></i>
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
                    title="PRL Leave Approval"
                    @ok="approve()"
                    ok-title="Submit"
                >
                    <b-container fluid>
                        <b-row>
                            <b-col md="3">
                                <b-form-group label="Employee Code" label-for="emp_code">
                                    <b-form-input v-model="formData.emp_code" id="emp_code" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Employee Name" label-for="emp_name">
                                    <b-form-input v-model="formData.emp_name" id="emp_name" readonly ></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="3">
                                <b-form-group label="Department" label-for="department_name">
                                    <b-form-input v-model="formData.department_name" id="department_name" readonly ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Designation" label-for="designation">
                                    <b-form-input v-model="formData.designation" id="designation" readonly ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Emergency Number" label-for="emergency_num">
                                    <b-form-input v-model="formData.emergency_num" id="emergency_num" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Date of Birth" label-for="emp_dob">
                                    <b-form-input v-model="formData.emp_dob" readonly id="emp_dob" ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Quota Name" label-for="quota_name">
                                    <b-form-input v-model="formData.quota_name" readonly id="quota_name" ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Join Date" label-for="join_date">
                                    <b-form-input v-model="formData.emp_join_date" readonly id="join_date" ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="LEAVE TYPE" label-for="leave_type">
                                    <b-form-input v-model="formData.leave_type" id="leave_type" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="LEAVE For" label-for="leave_for_used_type">
                                    <b-form-input v-model="formData.leave_for_used_type" id="leave_for_used_type" readonly></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="3">
                                <b-form-group label="Available Days" label-for="available_balance">
                                    <b-form-input v-model="formData.available_balance" readonly id="available_balance"></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="3">
                                <b-form-group label="Application date" label-for="application_date">
                                    <b-form-input v-model="formData.application_date" id="application_date" readonly ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Start Date" label-for="leave_start_date">
                                    <date-picker
                                      id="leave_start_date"
                                      v-model="formData.leave_start_date"
                                      width="100%"
                                      input-class="form-control"
                                      type="date"
                                      lang="en"
                                      required  v-validate="'required'"
                                      format="DD-MM-YYYY"
                                      name="leave_start_date"
                                      :popup-style="{ visibility: 'hidden' }"
                                      :editable="false"
                                    ></date-picker>
                                </b-form-group>
                            </b-col>

                            <b-col md="3">
                                <b-form-group label="End Date" label-for="leave_end_date">
                                    <date-picker
                                      id="leave_end_date"
                                      v-model="formData.leave_end_date"
                                      width="100%"
                                      input-class="form-control"
                                      type="date"
                                      lang="en"
                                      required  v-validate="'required'"
                                      format="DD-MM-YYYY"
                                      name="leave_end_date"
                                      :popup-style="{ visibility: 'hidden' }"
                                      :editable="false"
                                    ></date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Leave Days" label-for="leave_days">
                                    <b-form-input v-model="formData.leave_days"  readonly id="leave_days" ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Approval Status" label-for="approve_status">
                                    <b-form-radio-group id="approve_status" v-model="formData.approve_status">
                                        <b-form-radio value="1">Approve</b-form-radio>
                                        <b-form-radio value="-1">Reject</b-form-radio>
                                    </b-form-radio-group>
                                </b-form-group>
                            </b-col>
                            <b-col md="12">
                                <b-form-group label="Remarks" label-for="leave_reason">
                                    <b-textarea v-model="formData.leave_reason" rows="1" id="leave_reason" max-rows="5" readonly></b-textarea>
                                </b-form-group>
                            </b-col>
                            <b-col md="12" v-show="formData.approve_status === '-1'">
                                <b-form-group label="Comments" label-for="leave_reason">
                                    <b-textarea v-model="formData.approve_remarks" rows="1" id="leave_reason" max-rows="5" ></b-textarea>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-container>
                </b-modal>
            </div>
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
                selectedEmployee:{},
                searchEmployee: {
                    emp_id:'',
                    department_id: null,
                },
                formData:{
                    approve_date: new Date(),
                    approve_status:1,
                    approve_remarks:'',
                    leave_for_used_type: ''
                },
                empIdList: [],
                show: true,

                fields: [
                    {key: 'action2', label: 'Sl', sortable: true, sortDirection: 'desc'},
                    {key: 'emp_code', label: 'Emp Code', sortable: true, sortDirection: 'desc'},
                    {key: 'emp_name', label: 'Employee Name', sortable: true, sortDirection: 'desc'},
                    {key: 'leave_type', label: 'Leave Type', sortable: true, sortDirection: 'desc'},
                    {key: 'leave_for_used_type', label: 'Leave For', sortable: true, sortDirection: 'desc'},
                    {key: 'application_date', label: 'Application Date', sortable: true, sortDirection: 'desc', class: 'text-right'},
                    {key: 'emp_join_date', label: 'Join Date', sortable: true, sortDirection: 'desc', class: 'text-right'},
                    {key: 'leave_start_date', label: 'Start Date',formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }, sortable: true, sortDirection: 'desc', class: 'text-right'},
                    {
                        key: 'leave_end_date',
                        label: 'End Date',
                        formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        },
                        sortable: true,
                        sortDirection: 'desc', class: 'text-center'},
                    {key: 'leave_days', label: 'Leave Days', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {
                        key: 'approve_status',
                        label: 'Status',
                        formatter: value => {
                            if(value == 1) {
                                return 'Approved'
                            } else if(value == -1){
                                return 'Rejected'
                            } else {
                                return 'Pending'
                            }
                        },
                        class: 'text-center'
                    },
                    {key: 'action4', label: 'Action', class: 'text-center'}
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
                leaveBal: [],

                infoModal: {
                    id: 'info-modal',
                    title: '',
                    content: ''
                },
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "PRL Application Approval"});
            this.loadData();
        },
        watch: {
            selectedEmployee:function(val,oldVal) {
                if(val != null){
                    this.searchEmployee.emp_id = val.emp_id;
                    if ( val.department) {
                        this.searchEmployee.department_id =  val.department.department_id;
                    }else {
                        this.department_id = '';
                    }


                }
            }
        },
        methods: {
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/leave/leave-approval").then(res => {
                    this.departments = res.data.departments;
                });
            },


            searchEmployeeCodes(id){
                id = id.trim();
                if(id.length > 2) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/leave/leave-entry/emp-info/${id}/${this.searchEmployee.department_id}`).then(res => { // This url seems inaccurate! but employee data should be same so using this url.
                        this.empIdList = res.data.empcodeList;
                        if (res.data.empcodeList)
                            this.emp_name=res.data.empcodeList.emp_name;
                    })
                }
            },
            onSearch() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pension/search-prl-unapproval-list", this.searchEmployee).then(res => {
                    this.items = res.data;
                    this.totalList = res.data.length;
                });
            },



            onReset() {
                this.searchEmployee = {department_id: '',};
                this.selectedEmployee = '';

            },
            editRow(i, code) {
                this.submitBtn = 'Update';
                this.updateIndex = i;
                let data = this.tableData.items[i];

                console.log(data);

                this.form.employee_id = data.employee_id;
                this.form.department_name = data.department_name;
                this.form.designation = data.designation;
                this.form.division_name = data.division_name;
                this.form.financial_code = data.financial_code;
                this.form.shift = data.shift;
            },
            deleteRow(i, code) {
                if (i > -1) {
                    this.tableData.items.splice(i, 1);
                }
            },
            renderModal(item){
                this.formData = {...item};
                this.formData.approve_status = 1
            },
            approve(){
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pension/prl-approval", this.formData).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.onSearch()
                        this.onReset();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                    }
                });
            }


        }
    }
</script>

<style>
    .required{

        color:red
    }
</style>
