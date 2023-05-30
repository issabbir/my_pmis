<template>
    <b-container fluid>
        <b-form @submit.prevent="onSubmit">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Add Salary Head</b-card-header>
                <b-card-body class="border">
                    <b-row>
                        <b-col md="3">
                            <b-form-group
                                id="empCode"
                                label="Employee Code"
                                label-for="emp_code">
                                <b-form-input id="emp_code"
                                              name="emp_code"
                                              v-model="empSalaryHeadAllocation.emp_code"
                                              disabled></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Full Name"
                                label-for="emp_name">
                                <b-form-input
                                    id="emp_name"
                                    v-model="empSalaryHeadAllocation.emp_name"
                                    type="text"
                                    disabled
                                    name="emp_name"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="3">
                            <b-form-group
                                label="Department"
                                label-for="emp_department">
                                <b-form-input
                                    id="emp_department"
                                    v-model="empSalaryHeadAllocation.emp_department"
                                    type="text"
                                    disabled
                                    name="emp_department"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="3">
                            <b-form-group
                                label="Designation"
                                label-for="emp_designation">
                                <b-form-input
                                    id="emp_designation"
                                    v-model="empSalaryHeadAllocation.emp_designation"
                                    type="text"
                                    disabled
                                    name="emp_designation"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                class="requiredField"
                                label="Salary Head"
                                label-for="salary_head_id">
                                <v-select  v-model="selectedSalaryHead" :options="salaryHeadOptions"
                                           name="salary_head_id" id="salary_head_id"
                                           label="salary_head" class="uppercase"
                                           required v-validate="'required'">
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                    </template>
                                </v-select>
                                <span :style="errorMessage">{{ errors.first('salary_head_id') }}</span>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Amount"
                                class="requiredField"
                                label-for="emp_salary_head_amt">
                                <b-form-input
                                    id="emp_salary_head_amt"
                                    v-model="empSalaryHeadAllocation.emp_salary_head_amt"
                                    required  v-validate="'required'"
                                    name="emp_salary_head_amt"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Deduction"
                                label-for="deduction_yn"
                            >
                                <b-form-input
                                    id="deduction_yn"
                                    readonly
                                    v-model="empSalaryHeadAllocation.deduction">
                                </b-form-input>
                             </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Active"
                                label-for="active_yn"
                                class="requiredField mt-1">
                                <b-form-radio-group
                                    v-model="empSalaryHeadAllocation.active_yn"
                                    :options="active_yn_options" required
                                    name="active_yn"
                                ></b-form-radio-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="12">
                            <b-form-group
                                label="Remarks"
                                label-for="remarks"
                                class=" mt-1">
                                <b-form-textarea
                                    v-model="empSalaryHeadAllocation.remarks"
                                    name="remarks"
                                    id="remarks">
                                </b-form-textarea>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row class="mt-1">
                        <b-col class="d-flex justify-content-end">
                            <b-button type="submit" variant="info" class="mr-1">{{button_name}}</b-button>
                            <b-button type="button" @click="$router.push({name: 'deputation-employee-salary-search'})" >Cancel</b-button>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
        </b-form>
        <b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">Deputation Employee Salary Head Allocation List</b-card-header>
            <b-card-body class="border">
                <Datatable v-bind:fields="fields" :totalList="totalList" :perPage="perPage" v-bind:items="items" v-bind:searchColSize="5">
                    <template v-slot:actions="{ rows }">
                        <b-link   ml="4" class="text-primary"
                                 @click="editRow(rows.item)">
                            <i class="bx bx-edit cursor-pointer"></i>
                        </b-link>
                    </template>
                </Datatable>
            </b-card-body>
        </b-card>
   </b-container>
</template>

<script>
    import Vue from 'vue';
    import Datatable from '../../../layouts/common/datatable';
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';
    import ApiRepository from "../../../Repository/ApiRepository";
    import moment from "moment";
    export default {
        components: {Datatable, Vue,vSelect},
        props: ['id'],
        data() {
            return {
                selectedSalaryHead: {
                    salary_head_id: '',
                    salary_head: '',
                    default_value: '',
                    deduction_yn: '',
                    deduction: ''
                },
                empSalaryHeadAllocation:{
                    pr_emp_depu_id: '',
                    emp_id: '',
                    emp_code: null,
                    emp_name: null,
                    emp_department: null,
                    emp_designation: null,
                    emp_salary_head_amt: null,
                    active_yn: '',
                    salary_head_id: '',
                    remarks: ''
                },
                button_name:'Add',
                departmentList: [],
                salaryHeadOptions: [{value:'',text:'',}],
                active_yn_options: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'},
                ],
                errorMessage: {color: 'red'},
                perPage:5,
                totalList:0,
                    fields: [
                        {key: 'index', label: 'SL'},
                        {
                            key: 'salary_head',
                            sortable: true,
                            formatter: (value, key, item) => {
                                if(value.length == 17 && (item.salary_head_id == 4 || item.salary_head_id == 33) ) {
                                    return value.slice(0, -8)
                                } else {
                                    return value
                                }
                            },
                        },
                        {
                            key: 'deduction_yn',
                            formatter: value => {
                                if(value == 'Y') {
                                    return 'Yes'
                                } else {
                                    return 'No'
                                }
                            },
                            label: 'Deduction',
                            sortable: true},
                        {key: 'amount', sortable: true},
                        {
                            key: 'active_yn',
                            formatter: value => {
                                if(value == 'Y') {
                                   return 'Active'
                                } else {
                                    return 'Inactive'
                                }
                            },
                            label: 'Active Status',
                            sortable: true},
                        'action'
                    ],
                items: []
            };
        },
        watch: {
            selectedSalaryHead:function (val, oldVal) {
                if (val) {
                    this.empSalaryHeadAllocation.salary_head_id = val.salary_head_id
                    this.empSalaryHeadAllocation.emp_salary_head_amt = val.default_value
                    this.empSalaryHeadAllocation.deduction_yn = val.deduction_yn
                    this.empSalaryHeadAllocation.deduction = val.deduction_yn == 'Y' ? 'Yes' : 'No';
                } else {
                    this.empSalaryHeadAllocation.salary_head_id = ''
                }
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty")
            this.$store.commit("setBreadcrumb", {link: "#", label: "Payroll"})
            this.$store.commit("setBreadcrumb", {link: "#", label: "Setup"})
            this.$store.commit("setBreadcrumb", {link: "#", label: "Deputation Employee Salary Head Allocation"})
            this.allDatalistShow()
            this.loadSalaryHead()
            this.loadTable()
        },

        methods:{
            allDatalistShow(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/deputation-payroll/depu-emp/salary-head/${this.id}`).then(res => {
                     this.empSalaryHeadAllocation = res.data.data;
                     this.empSalaryHeadAllocation.emp_department = (!res.data.data.department)?'':res.data.data.department.department_name;
                     this.empSalaryHeadAllocation.emp_designation =(!res.data.data.designation)?'': res.data.data.designation.designation;
                     this.empSalaryHeadAllocation.active_yn='Y';
                })
            },
            onSubmit() {
                let currObj = this;
                this.empSalaryHeadAllocation.emp_id = this.id
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/deputation-payroll/salary-allocation`,this.empSalaryHeadAllocation).then(res => {
                    if (res.data.o_status_code == 1) {
                        currObj.empSalaryHeadAllocation.emp_id = res.data.id
                        currObj.loadTable()
                        currObj.empSalaryHeadAllocation.pr_emp_depu_id = ''
                        currObj.empSalaryHeadAllocation.emp_salary_head_amt = ''
                        currObj.selectedSalaryHead = {}
                        currObj.empSalaryHeadAllocation.active_yn = 'Y'
                        currObj.empSalaryHeadAllocation.remarks = ''
                        currObj.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                        if(res.data.url) {
                            this.$router.push(res.data.url)
                            this.$router.go()
                        }
                    }else {
                        currObj.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                    }
                }).catch(err => {
                    console.log(err)
                })

            },
            loadTable() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/deputation-payroll/salary-allocation/allocated-list/${this.id}`).then(res => {
                    this.items = res.data.allocatedHeadData;
                    this.totalList = res.data.allocatedHeadData.length
                })
            },
            loadSalaryHead() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/deputation-payroll/salary-allocation/heads/${this.id}/${this.id}`).then(res => {
                    this.salaryHeadOptions = res.data.data;
                    // this.salaryHeadOptions = res.data.data.filter(salary_head_id => res.data.data > 3000000);
                    //this.emp_salary_head_amt = res.data.data.default_value[0];
                })
            },
            editRow(item) {
                this.empSalaryHeadAllocation.pr_emp_depu_id = item.pr_emp_depu_id
                this.selectedSalaryHead = item
                this.selectedSalaryHead.default_value = item.amount
                this.empSalaryHeadAllocation.active_yn = item.active_yn
                this.empSalaryHeadAllocation.remarks = item.remarks
                this.button_name='Update'
            }
        }
};
</script>
