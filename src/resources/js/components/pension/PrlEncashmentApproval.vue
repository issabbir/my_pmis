<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card">
                <b-card-header header-bg-variant="dark" header-text-variant="white">PRL Encashment Approval</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSearch" @reset.prevent="onReset" v-if="show">
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Department"
                                    label-for="department"
                                    label-cols-md="4">
                                    <b-form-select
                                        v-model="searchEmployee.department_id"
                                        :options="departments"
                                        class=""
                                        required
                                        value-field="department_id"
                                        text-field="department_name"
                                    ></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Employee"
                                    label-for="employee"
                                    label-cols-md="4">
                                    <v-select
                                            label="option_name"
                                            v-model="searchEncashmentEmployee"
                                            :options="empIdList"
                                            @search="searchEncashmentEmp">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-button-group>
                                    <b-button md="6"  size="md" variant="success" type="submit" >Search</b-button>
                                    <b-button md="6"  size="md" variant="dark" type="reset" >Reset</b-button>
                                </b-button-group>
                            </b-col>

                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">PRL Encashment Approved List</b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="fields" :totalList="totalList" :perPage="perPage" v-bind:items="items"  v-bind:pageColSize="4" v-bind:searchColSize="5" :primaryKeyColumnName="'roster_date'">
                     <template v-slot:action4="{ rows }">
                            <b-link ml="4" class="text-primary" v-b-modal.modal-center @click="renderModal(rows.item)">
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
                    title="PRL Encashment Approval"
                    ok-title="Submit"
                    @ok="approve()"

                >
                    <b-container fluid>
                      <b-card>
                            <b-card-header header-bg-variant="dark" header-text-variant="white">PRL Encashment  Details</b-card-header>
                            <b-card-body class="border">
                                <b-row>
                                    <b-col md="4">
                                        <b-form-group label="Emp Code" label-for="EmpCode">
                                            <b-form-input v-model="formData.emp_code" readonly></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group label="Employee Name" label-for="EmployeeName">
                                            <b-form-input v-model="formData.emp_name" readonly ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group label="Department" label-for="Department">
                                            <b-form-input v-model="formData.department_name" readonly ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group label="Designation" label-for="Designation">
                                            <b-form-input v-model="formData.designation" readonly ></b-form-input>
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
                                        <b-form-group label="Join Date" label-for="join_date">
                                            <b-form-input v-model="formData.emp_join_date" readonly id="join_date" ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group label="Available Days" label-for="Available Days">
                                            <b-form-input v-model="formData.available_balance"  disabled  required id="monday" ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                        <b-col md="4">
                                            <b-form-group label="Last Basic" label-for="LastBasic">

                                                    <b-form-input v-model="formData.basic_amt"  disabled   class="text-right" required id="encahement_basic" ></b-form-input>

                                            </b-form-group>
                                        </b-col>
                                        <b-col md="4">
                                            <b-form-group label="Encashment Day" label-for="EncashmentDay">
                                                <b-form-input
                                                    v-model="formData.encashment_days"
                                                    required
                                                    disabled
                                                    id="encashment_days"
                                                ></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                    <b-col md="4">
                                        <b-form-group label="Encashment Amount" label-for="Encashment Amount">

                                                <b-form-input v-model="formData.enchasement_amt"
                                                              disabled
                                                              required
                                                              class="text-right"
                                                              id="amount">
                                                </b-form-input>

                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4">
                                        <b-form-group label="Approval Status" label-for="approval_status">
                                            <b-form-radio-group id="approval_status" v-model="formData.approval_status">
                                                <b-form-radio value="1">Approve</b-form-radio>
                                                <b-form-radio value="-1">Reject</b-form-radio>
                                            </b-form-radio-group>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="12" v-show="formData.approval_status === '-1'">
                                        <b-form-group label="Comments" label-for="leave_reason">
                                            <b-textarea v-model="formData.approve_remarks" rows="1" id="leave_reason" max-rows="5" ></b-textarea>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </b-card-body>
                        </b-card>
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
                searchEncashmentEmployee:{},
                searchEmployee: {
                    emp_id:'',
                    department_id: '',
                },
                formData:{
                    encashment_app_id: '',
                    emp_id: '',
                    leave_type_id: '',
                    encashment_days: '',
                    amount: '',
                    approval_status:null,
                    approve_remarks:'',
                    approve_by_emp_id: '',
                    lap_encashment_days_consumed: 0,
                    lap_encashment_days: 0,
                    lap_encashment_amount: 0.00,
                    lhap: 0,
                    lhap_encashment_days_consumed: 0,
                    lhap_encashment_days: 0,
                    lhap_encashment_amount: 0.00,
                    enchasement_amt: 0
                },
                empIdList: [],
                show: true,

                fields: [
                    {key: 'emp_code', label: 'Emp Code', sortable: true, sortDirection: 'desc', class: 'text-left'},
                    {
                        key: 'emp_name',
                        label: 'Employee Name',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-left'
                    },
                    {
                        key: 'department_name',
                        label: 'Department',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-left'
                    },
                    {
                        key: 'designation',
                        label: 'Designation',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-left'
                    },
                    // {
                    //     key: 'leave_type',
                    //     label: 'Leave Type',
                    //     sortable: true,
                    //     sortDirection: 'desc',
                    //     class: 'text-left'
                    // },
                    {
                        key: 'application_date',
                        label: 'Application Date',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-left'
                    },
                    {
                        key: 'encashment_days',
                        label: 'Encashment Days',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-left'
                    },
                    {key: 'enchasement_amt', label: 'Encashment Amount', sortable: true, sortDirection: 'desc',  class: 'text-left'},
                    {key: 'action4', label: 'Action'}],
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
            this.$store.commit("setBreadcrumb", {link: "#", label: "PRL Encashment Approval"});
            this.loadData();
        },
        watch: {
            searchEncashmentEmployee:function(val,oldVal) {
                if(val != null){
                    this.searchEmployee.emp_id = val.emp_id;
                    this.searchEmployee.department_id =  val.dpt_department_id;
                    }
                }
        },
        methods: {
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/leave/leave-approval").then(res => {
                    this.departments = res.data.departments;
                });
            },

            searchEncashmentEmp(id) {
                if (id && (id !== undefined)) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/encashment-emp-search/${id}`, this.searchEncashmentApps).then(res => {
                        this.empIdList = res.data;

                    })
                }
            },
            onSearch() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pension/search-encashment-data", this.searchEmployee).then(res => {
                    console.log(res.data);
                    this.items = res.data;
                    this.totalList = res.data.length;
                });

            },

            onReset() {
                this.searchEncashmentEmployee = {};
                this.searchEmployee = {};
                this.items=null;
                this.show = false;
                this.$nextTick(() => {
                    this.show = true
                })
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
                console.log(this.form);

            },
            deleteRow(i, code) {
                if (i > -1) {
                    this.tableData.items.splice(i, 1);
                }
            },
            renderModal(item){
                this.formData=item;
                this.formData.lap_encashment_amount = item.lap_encashment_amt
                this.formData.lhap_encashment_amount = item.lhap_encashment_amt
                this.getLeaveBalance(item.emp_id);
            },
            getLeaveBalance(id){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/leave-balance/${id}`).then(res => {
                    this.leaveBal = res.data;
                });
            },
            approve(){
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/store-leave-encashment`, this.formData).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
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
