<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Employee Wise Salary Allocation</b-card-header>
                <b-card-body class="border">
                    <b-form @submit="onSubmit" @reset="onReset">
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                label="Employee Code"
                                label-for="employees"
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label-cols-md="4"
                                >
                                    <!--v-select v-model="employeeSalaryAllocation.emp_id" :options="empIdList" label="emp_code">
                                        </v-select-->
                                    <v-select
                                        label="option_name"
                                        v-model="selectedEmployee"
                                        :options="empIdList"
                                        id="employees"
                                        @search="searchempcods">
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                label="Employee Name"
                                label-for="employeeName"
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label-cols-md="4">
                                    <b-form-input v-model="employeeSalaryAllocation.emp_name" readonly id="employeeName"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                label="Department"
                                label-for="departmentName"
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label-cols-md="4">
                                    <b-form-input v-model="employeeSalaryAllocation.department_name" readonly id="departmentName"></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                label="Section"
                                label-for="sectionName"
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label-cols-md="4">
                                    <b-form-input v-model="employeeSalaryAllocation.section" readonly id="sectionName"></b-form-input>                                              
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                label="Designation"
                                label-for="designationName"
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label-cols-md="4">
                                    <b-form-input v-model="employeeSalaryAllocation.designation" readonly id="designationName" ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                label="Allocation Type"
                                label-for="allocationType"
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label-cols-md="4">
                                    <b-select v-model="employeeSalaryAllocation.salary_head_id" :options="allocations" id="allocationType"></b-select>
                                </b-form-group>

                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                label="Activation Status"
                                label-for="activationStatus"
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label-cols-md="4">
                                    <b-select v-model="employeeSalaryAllocation.active_yn" :options="status" id="activationStatus"></b-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="8">
                                <b-form-group
                                label="Remarks"
                                label-for="remarks"
                                label-cols-sm="2"
                                label-cols-lg="2"
                                label-cols-md="2">
                                    <b-form-input v-model="employeeSalaryAllocation.description" id="remarks"></b-form-input>
                                    <b-form-input v-model="employeeSalaryAllocation.applicable_id" hidden ></b-form-input>
                                    <b-form-input v-model="employeeSalaryAllocation.emp_id" hidden ></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row >
                            <b-col class="d-flex justify-content-end">
                                <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1 mb-1">{{submitBtn}}</b-button>&nbsp;
                                <b-button type="reset" v-bind:href="'payroll#/salary-setup/search-employeewise-salary-allocation'" class="btn btn-outline-dark  mb-1">Cancel</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card class="card">
                <b-card-header header-bg-variant="dark" header-text-variant="white">Employee Based Salary Allocation</b-card-header>
                <b-card-body class="border">
                    <Datatable 
                    v-bind:fields="fields" 
                    :totalList="totalList" 
                    :perPage="perPage"
                    v-bind:items="items">
                        <template v-slot:actions="{ rows }">
                            <b-link ml="4" class="text-primary"
                                    @click="editRow(rows.item.applicable_id)">
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
    import  vcss from 'vue-select/dist/vue-select.css';
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    export default {
        components: {Datatable,Vue,vSelect,vcss},
        watch: {
            selectedEmployee: function (val, oldVal) {
                this.employeeSalaryAllocation.emp_name = val.emp_name;
                if (val.department)
                    this.employeeSalaryAllocation.department_name = val.department.department_name;

                if (val.designation)
                    this.employeeSalaryAllocation.designation = val.designation.designation;

                if (val.section)
                    this.employeeSalaryAllocation.section = val.section.section_name;

            },
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Payroll"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Setup"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Employee Wise Salary Allocation Setup" });
            this.loadData();
        },
        data() {
            return {
                employeeSalaryAllocation: {},
                emp_name:'',
                selectedEmployee:{},
                perPage:5,
                totalList:0,
                empIdList:[],
                allocations:[],
                status: [{ text: 'Active', value: 'Y'},{ text: 'Inactive', value: 'N'}],
                show: true,
                updateIndex: -1,
                submitBtn: 'Save',
                fields: [{key:'emp_code', label:'Emp Code', sortable:true},
                    {key:'emp_name', label:'Name', sortable:true},
                    {key:'department_name', label:'Department', sortable:true},
                    {key:'designation', label:'Designation', sortable:true},
                    {key:'salary_head_name',label:'Salary Head ', sortable:true}, {key:'active_yn', label:'Activation Status', sortable:true}, {key:'description',label:'Remark', sortable:true},'action'],
                items: [],

            }
        },
        methods: {
            searchempcods(id){
                if(id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/salary-allocation/get-empinfo/${id}`, this.employeeSalaryAllocation).then(res => {
                        this.empIdList = res.data.empcodeList;
                        this.emp_name=res.data.empcodeList.emp_name;

                    })
                }
            },
            /*changeEmpid(selectedEmployee){
                let emp_id=selectedEmployee.emp_id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/salary-allocation/get-empwise-salaryheads/${emp_id}`).then(res => {
                    this.allocations=res.data.allocationsalaryheads;

                })
            },*/

             onSubmit(evt) {
                evt.preventDefault();
                let currObj = this;
                let id = this.employeeSalaryAllocation.applicable_id;
                // this.$validator.validateAll().then(() => {
                //  if (!this.errors.any()) {
                 this.employeeSalaryAllocation.emp_id = this.selectedEmployee.emp_id;
                if (id > 0) {
                    //this.employeeSalaryAllocation.emp_id=this.
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, "/payroll/salary-allocation/update", this.employeeSalaryAllocation).then(res => {
                        if (res.data.o_status_code == 1){
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.loadData();
                            this.onReset(evt);
                        }
                        else{
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                        }
                    });
                } else {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, "/payroll/salary-allocation", this.employeeSalaryAllocation).then(res => {
                        if (res.data.o_status_code == 1) {
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.loadData();
                            this.onReset(evt);
                        }else{
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                        }
                    }).catch(err => {
                        currObj.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' });
                    });
                }
            },

            loadData: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/salary-allocation", this.employeeSalaryAllocation).then(res => {
                   // this.empIdList=res.data.empIdList;
                    this.allocations=res.data.allocationsalaryheads;
                    this.items=res.data.allocateddata;
                    this.totalList = res.data.allocateddata.length;

                });
            },
            onReset(evt) {
                evt.preventDefault();
                this.selectedEmployee=null;
                this.employeeSalaryAllocation.applicable_id = "";
                this.employeeSalaryAllocation.emp_name = "";
                this.employeeSalaryAllocation.department_name = "";
                this.employeeSalaryAllocation.designation="";
                this.employeeSalaryAllocation.active_yn =null;
                this.employeeSalaryAllocation.description = null;
                this.employeeSalaryAllocation.salary_head_id="";
                this.submitBtn = 'Save';
                this.show = false;
            },
            editRow(id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/salary-allocation/${id}`).then(result => {
                    this.submitBtn = 'Update';
                    this.employeeSalaryAllocation = result.data;
                    this.selectedEmployee = result.data.employee;
                    //this.changeEmpid(result.data.emp_id);

                });
            },

        },
    }
</script>
<!--style>
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
</style-->
                                                
