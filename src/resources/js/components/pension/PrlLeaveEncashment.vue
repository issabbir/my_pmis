<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">PRL Leave Encashment Application</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">
                        <b-row>
                            <b-col md="3">
                                <b-form-group label="Emp Code" label-for="EmpCode">
                                    <v-select
                                        label="option_name"
                                        v-model="selectedEmployee"
                                        :options="empIdList"
                                        @search="searchempcods">
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Employee Name" label-for="EmployeeName">
                                    <b-form-input
                                      v-model="prlLeaveEncashment.emp_name"
                                      disabled
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Department" label-for="Department">
                                    <b-form-input
                                      v-model="prlLeaveEncashment.department_name"
                                      disabled
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Designation" label-for="Designation">
                                    <b-form-input
                                      v-model="prlLeaveEncashment.designation"
                                      disabled
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Date of Birth" label-for="dob">
                                    <b-form-input v-model="prlLeaveEncashment.emp_dob" readonly id="emp_dob" ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Quota Name" label-for="quota_name">
                                    <b-form-input v-model="prlLeaveEncashment.quota_name" readonly id="quota_name" ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Join Date" label-for="join_date">
                                    <b-form-input v-model="prlLeaveEncashment.emp_join_date" readonly id="join_date" ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Last Basic" label-for="Current_Basic">
                                    <b-form-input
                                        v-model="prlLeaveEncashment.encahement_basic"
                                        disabled
                                        required
                                        class="text-right"
                                        id="encahement_basic"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Service Period" label-for="service_period">
                                    <b-form-input v-model="prlLeaveEncashment.service_period" disabled required
                                                  id="service_period"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Available Days" label-for="Available_Days">
                                    <b-form-input v-model="prlLeaveEncashment.available_balance" disabled required
                                                  id="available_balance"></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <hr>
                        <b-row>
                            <b-col md="3">
                                <b-form-group label="LAP DAYS  (Balance)" label-for="lap">
                                    <b-form-input
                                      v-model="prlLeaveEncashment.lap"
                                      disabled
                                      required
                                      id="lap"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group :label="`LAP ENCASHMENT DAYS (Consumed) - ${Number((prlLeaveEncashment.basic_amt / 30) * prlLeaveEncashment.lap_encashment_days_consumed).toFixed(2)} tk`" label-for="lap_encashment_days_consumed">
                                    <b-form-input
                                      v-model="prlLeaveEncashment.lap_encashment_days_consumed"
                                      disabled
                                      required
                                      id="lap_encashment_days_consumed"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="LAP ENCASHMENT DAYS" label-for="lap_encashment">
                                    <b-form-input
                                      v-model="prlLeaveEncashment.lap_encashment_days"
                                      :disabled="prlLeaveEncashment.lap == 0"
                                      id="lap_encashment"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="LAP ENCASHMENT AMOUNT" label-for="lap_encashment_amount">
                                    <b-form-input
                                      v-model="prlLeaveEncashment.lap_encashment_amount"
                                      class="text-right"
                                      disabled
                                      id="lap_encashment_amount"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="3">
                                <b-form-group label="LHAP DAYS (Balance)" label-for="lhap">
                                    <b-form-input
                                      v-model="prlLeaveEncashment.lhap"
                                      disabled
                                      required
                                      id="lhap"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group :label="`LHAP ENCASHMENT DAYS (Consumed) - ${Number((prlLeaveEncashment.basic_amt / 30) * prlLeaveEncashment.lhap_encashment_days_consumed).toFixed(2)} tk`" label-for="lhap_encashment_days_consumed">
                                    <b-form-input
                                      v-model="prlLeaveEncashment.lhap_encashment_days_consumed"
                                      disabled
                                      required
                                      id="lhap_encashment_days_consumed"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="LHAP ENCASHMENT DAYS" label-for="lhap_encashment">
                                    <b-form-input
                                      v-model="prlLeaveEncashment.lhap_encashment_days"
                                      :disabled="Number(prlLeaveEncashment.lap) < 540 && Number(prlLeaveEncashment.lap) == Number(prlLeaveEncashment.lap_encashment_days_consumed) +  Number(prlLeaveEncashment.lap_encashment_days)?false:true"
                                      id="lhap_encashment"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="LHAP ENCASHMENT AMOUNT" label-for="lhap_encashment_amount">
                                    <b-form-input
                                      v-model="prlLeaveEncashment.lhap_encashment_amount"
                                      disabled
                                      class="text-right"
                                      id="lhap_encashment_amount"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <hr>
                        <b-row>
                            <b-col offset-md="6" md="3">
                                <b-form-group label="Total Encashment Days (Max 540)" label-for="encashment_days">
                                    <b-form-input
                                      v-model="total_encashment_days"
                                      required
                                      disabled
                                      class="requiredField"
                                      id="encashment_days"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Total Encashment Amount" label-for="amount">
                                    <b-form-input
                                      v-model="total_encashment_amount"
                                      disabled
                                      required
                                      class="text-right"
                                      id="amount"
                                    >
                                    </b-form-input>
                                </b-form-group>
                            </b-col>

                        </b-row>
                        <b-row>
                            <b-col md="12" class="pr-0 d-flex justify-content-end">
                                <b-button-group>
                                    <b-button type="submit" id="basic_sub_btn" variant="success">{{submitBtn}}</b-button>
                                    <b-button type="reset" variant="secondary">Cancel</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>

                    </b-form>
                </b-card-body>
            </b-card>

            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">PRL Leave Encashment Details
                </b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSearch" @reset.prevent="onSearchReset">
                        <b-row>
                            <b-col md="3">
                                <b-form-group label="DEPARTMENT" label-for="department" class="requiredField">
                                    <b-form-select
                                            id="department"
                                            v-model="searchEncashmentApps.department_id"
                                            :options="departmentOptions"
                                            text-field="department_name"
                                            value-field="department_id"
                                            required
                                    ></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group label="Employee Code" label-for="emp_code">
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

                            <b-col md="3">
                                <b-form-group>
                                    <b-button-group class="mt-1">
                                        <b-button type="submit" variant="primary">Search</b-button>
                                        <b-button type="reset" variant="secondary">Reset</b-button>
                                    </b-button-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-form>

                    <Datatable :fields="fields" :totalList="totalList" :perPage="perPage" :items="items">
                        <template v-slot:actions="{ rows }">
                            <b-link ml="4" class="text-primary"
                                    @click="editRow(rows.item)">
                                <i class="bx bx-edit cursor-pointer"></i>
                            </b-link>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>

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

    export default {
        components: {DatePicker, Datatable, Vue, vSelect, vcss},
        data() {
            return {
                prlLeaveEncashment: {
                    basic_amt:'',
                    available_days: 0,
                    available_balance: 0,
                    amount: '',
                    encahement_basic: '',
                    encashment_days: null,
                    lap: 0,
                    lap_encashment_days_consumed: 0,
                    lap_encashment_days: 0,
                    lap_encashment_amount: 0.00,
                    lhap: 0,
                    lhap_encashment_days_consumed: 0,
                    lhap_encashment_days: 0,
                    lhap_encashment_amount: 0.00,
                    service_period: ''
                },
                searchEncashmentApps: {},
                available_days: ' ',
                available_balance:'',
                selectedEmployee: {},
                searchEncashmentEmployee:{},
                selectedApprovedEmployee: {},
                departmentOptions:{},
                selected: {},
                updateIndex: -1,
                submitBtn: 'Submit',
                empIdList: [],
                emp_code: {},
                leavetypes: [],
                specificLeaveType:[],
                perPage: 5,
                totalList: 0,
                file: '',
                show: true,
                fields: [
                    {key: 'emp_code', label: 'Emp Code', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {
                        key: 'emp_name',
                        label: 'Employee Name',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-center'
                    },
                    {
                        key: 'department_name',
                        label: 'Department',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-center'
                    },
                    {
                        key: 'designation',
                        label: 'Designation',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-center'
                    },
                    {
                        key: 'application_date',
                        label: 'Application Date',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-center'
                    },
                    {
                        key: 'encashment_days',
                        label: 'Encashment Days',
                        sortable: true,
                        sortDirection: 'desc',
                        class: 'text-center'
                    },
                    {key: 'enchasement_amt', label: 'Encashment Amount', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    'action'],
                items: []
            }
        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.prlLeaveEncashment.emp_name = val.emp_name;
                    this.prlLeaveEncashment.emp_id = val.emp_id;
                    this.prlLeaveEncashment.encahement_basic = val.basic_amount;
                    this.prlLeaveEncashment.available_balance=val.available_balance;
                    this.prlLeaveEncashment.service_period=val.service_period;
                    this.prlLeaveEncashment.basic_amt=val.basic_amt;
                    this.prlLeaveEncashment.emp_dob=val.emp_dob;
                    this.prlLeaveEncashment.quota_name=val.quota_name;
                    this.prlLeaveEncashment.emp_join_date=val.emp_join_date;
                    this.prlLeaveEncashment.encashment_days=val.encashment_days;
                    this.prlLeaveEncashment.lap_encashment_days_consumed=val.lap_encashment_days_consumed;
                    this.prlLeaveEncashment.lhap_encashment_days_consumed=val.lhap_encashment_days_consumed;

                    if(Number(val.encashment_days) > Number(val.lap)){
                        this.prlLeaveEncashment.lap_encashment_days = val.lap
                    } else {
                        this.prlLeaveEncashment.lap_encashment_days = val.encashment_days
                    }

                    if(Number(this.prlLeaveEncashment.lap_encashment_days) < Number(val.encashment_days)){
                        this.prlLeaveEncashment.lhap_encashment_days = Number(val.encashment_days) - Number(this.prlLeaveEncashment.lap_encashment_days)
                    }

                    this.prlLeaveEncashment.lap=val.lap;
                    this.prlLeaveEncashment.lhap=val.lhap;
                    if (val.department_name)
                        this.prlLeaveEncashment.department_name = val.department_name;
                    if (val.designation)
                        this.prlLeaveEncashment.designation = val.designation;
                }
            },

            "prlLeaveEncashment.encashment_days": function () {
                if (this.prlLeaveEncashment.encahement_basic) {
                    this.prlLeaveEncashment.amount =(this.prlLeaveEncashment.basic_amt / 30) * this.prlLeaveEncashment.encashment_days;
                } else {
                    this.prlLeaveEncashment.amount = '';
                }
            },

            "prlLeaveEncashment.lap_encashment_days": function (val, oldVal) {
                if(val > (540)){
                    this.prlLeaveEncashment.lap_encashment_days = 0
                    this.$notify({group: 'pmis', text: 'LAP encashment days cannot exceed 540', type: 'error'});
                }

                if(val > Number(this.prlLeaveEncashment.lap)){
                    this.prlLeaveEncashment.lap_encashment_days = 0
                    this.$notify({group: 'pmis', text: `LAP encashment days cannot exceed ${this.prlLeaveEncashment.lap}`, type: 'error'});
                }

                if (this.prlLeaveEncashment.encahement_basic) {
                    this.prlLeaveEncashment.lap_encashment_amount =Number((this.prlLeaveEncashment.basic_amt / 30) * this.prlLeaveEncashment.lap_encashment_days).toFixed(2)
                } else {
                    this.prlLeaveEncashment.lap_encashment_amount = 0.00;
                }
            },

            "prlLeaveEncashment.lhap_encashment_days": function (val, oldVal) {
                if(val > (540)){
                    this.prlLeaveEncashment.lhap_encashment_days = 0
                    this.$notify({group: 'pmis', text: 'LHAP encashment days cannot exceed 540', type: 'error'});
                }

                if(val > Number(this.prlLeaveEncashment.lhap)){
                    this.prlLeaveEncashment.lhap_encashment_days = 0
                    this.$notify({group: 'pmis', text: `LHAP encashment days cannot exceed ${this.prlLeaveEncashment.lhap}`, type: 'error'});
                }
                if (this.prlLeaveEncashment.encahement_basic) {
                    this.prlLeaveEncashment.lhap_encashment_amount = Number((this.prlLeaveEncashment.basic_amt / 30) * this.prlLeaveEncashment.lhap_encashment_days).toFixed(2)
                } else {
                    this.prlLeaveEncashment.lhap_encashment_amount = 0.00;
                }
            },
            total_encashment_days:function(val, oldVal){
                if(val > 540){
                    this.prlLeaveEncashment.lap_encashment_days = 0
                    this.prlLeaveEncashment.lhap_encashment_days = 0
                    this.$notify({group: 'pmis', text: 'Total encashment days cannot exceed 540', type: 'error'});
                }
            }
        },

        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "PRL Leave Encashment"});
            this.preLoadData()
        },
        computed: {
            total_encashment_days:function () {
                return Number(this.prlLeaveEncashment.lap_encashment_days_consumed) + Number(this.prlLeaveEncashment.lap_encashment_days) + Number(this.prlLeaveEncashment.lhap_encashment_days_consumed) + Number(this.prlLeaveEncashment.lhap_encashment_days)
            },
            total_encashment_amount:function () {
                return Number(Number(this.prlLeaveEncashment.lap_encashment_amount) + Number((this.prlLeaveEncashment.basic_amt / 30) * this.prlLeaveEncashment.lap_encashment_days_consumed) + Number(this.prlLeaveEncashment.lhap_encashment_amount) + Number((this.prlLeaveEncashment.basic_amt / 30) * this.prlLeaveEncashment.lhap_encashment_days_consumed)).toFixed(2)
            }
        },


        methods: {
            searchempcods(id) {
                if (id && (id !== undefined)) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/encashment-emp-search/${id}`, this.prlLeaveEncashment).then(res => {
                        this.empIdList = res.data;
                        //this.emp_name=res.data.empcodeList.emp_name;

                    })
                }
            },
            searchEncashmentEmp(id) {
                if (id && (id !== undefined)) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/encashment-emp-search/${id}`, this.searchEncashmentApps).then(res => {
                        this.empIdList = res.data;

                    })
                }
            },
            preLoadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/operation/promotions/form-data').then(res => {
                    this.departmentOptions = res.data.departments;
                });
            },
            onSubmit() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/store-leave-encashment`, this.prlLeaveEncashment).then(res => {
                 if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        //this.loadData();
                        this.onSearch();
                        this.onReset();

                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                    }
                });
            },
            onSearch: function () {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pension/get-encashment-application-data", this.searchEncashmentApps).then(res => {
                    this.items = res.data;
                    this.totalList = res.data.length;
                });

            },

            onSearchReset() {
                this.show = false;
                this.$nextTick(() => {
                    this.searchEncashmentEmployee = '';
                    this.searchEncashmentApps = {};
                });
            },

            onReset() {
                this.show = false;
                this.$nextTick(() => {
                    this.selectedEmployee = {};
                    this.prlLeaveEncashment = {};
                    this.submitBtn = 'Save';
                    this.show = true;
                });
            },
            editRow(i){
                let item = Object.assign({}, i);
                this.prlLeaveEncashment = item;
                this.prlLeaveEncashment.lap_encashment_amount = item.lap_encashment_amt
                this.prlLeaveEncashment.lhap_encashment_amount = item.lhap_encashment_amt
                this.setEmployee(item);
                this.submitBtn = 'Update';
            },
            setEmployee: function (item) {
                this.selectedEmployee = {
                    emp_id: item.emp_id,
                    option_name: item.emp_code + ' ' + item.emp_name,
                    designation: item.designation,
                    dpt_department_id: item.department_id,
                    department_name: item.department_name,
                    emp_dob: item.emp_dob,
                    quota_name: item.quota_name,
                    emp_join_date: item.emp_join_date,
                    available_balance: item.available_balance,
                    encashment_days:item.encashment_days,
                    emp_code: item.emp_code,
                    emp_name: item.emp_name,
                    basic_amt:item.basic_amt,
                    basic_amount: item.basic_amount,
                    service_period: item.service_period,
                    lap: item.lap,
                    lhap: item.lhap,
                    lap_encashment_days_consumed: item.lap_encashment_days_consumed,
                    lhap_encashment_days_consumed: item.lhap_encashment_days_consumed
                }
            },
            // getLeaveBalance() {
            //     let emp_id = this.prlLeaveEncashment.emp_id;
            //     if (emp_id != null || emp_id != undefined) {
            //         let leave_type_id = this.prlLeaveEncashment.leave_type_id;
            //         ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/get-leave-balance/${emp_id}/${leave_type_id}`).then(res => {
            //             console.log(res.data[0].remaining_balance);
            //             this.available_days = res.data[0].remaining_balance;
            //             this.prlLeaveEncashment.available_days = this.available_days;
            //         });
            //     }
            //
            // }

        },

    }
</script>

<style>
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
</style>
