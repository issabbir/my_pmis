<template>
    <b-container fluid>
        <b-form @submit="onSearchData" @reset="onReset">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Search Employee Wise Salary Allocation</b-card-header>
                <b-card-body class="border">
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="3"
                                label="Department"
                                label-for="departmentID"
                                >
                                <b-form-select  id="departmentID" v-model="searchEmpWiseSalaryAllocation.department"  :options="departmentList"></b-form-select>
                            </b-form-group>
                        </b-col>
                         <b-col md="4">
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="3"
                                label="Employee Code"
                                label-for="employeeCodes"
                                >
                                <v-select
                                label="option_name"
                                v-model="selectedEmployee"
                                :options="empIdList"
                                @search="searchempcods"
                                id="employeeCodes">
                                </v-select>
                            </b-form-group>
                        </b-col>
                         <b-col md="4">
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="Activation Status"
                                label-for="approval_status"
                                >
                                <b-form-select  id="approval_status" v-model="searchEmpWiseSalaryAllocation.active_status" :options="activationStatus"></b-form-select>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row class="mt-1">
                        <b-col class="d-flex justify-content-start">
                            <b-button type="button" v-bind:href="'payroll#/salary-setup/employee-salary'" class="btn btn-success shadow mr-1 mb-1">Create New</b-button>
                        </b-col>
                        <b-col class="d-flex justify-content-end">
                            <b-button type="submit" class="btn btn-info shadow mr-1 mb-1">Search</b-button> &nbsp;
                            <b-button type="reset" class="btn btn-outline-dark  mb-1">Reset</b-button>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
        </b-form>
        <b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">Employee Wise Salary Allocation List</b-card-header>
            <b-card-body class="border">
                <Datatable v-bind:fields="fields" :totalList="totalList" :perPage="perPage" v-bind:items="items"  v-bind:pageColSize="4" v-bind:searchColSize="5">

                </Datatable>
            </b-card-body>
        </b-card>
   </b-container>
</template>

<script>
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import  vcss from 'vue-select/dist/vue-select.css';
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    export default {
     components: {Datatable,Vue,vSelect,vcss},
      data() {
        return {
                empIdList: [],
                emp_code: {},
                selectedEmployee:{
                  emp_id:null,  
                },
                
                searchEmpWiseSalaryAllocation:{ 
                    department:null,
                    active_status: null
                },
                departmentList: [],
                activationStatus:[
                    {value: 'Y', text: 'Active'},
                    {value: 'N', text: 'Inactive'}],
                
                perPage:5,
                totalList:0,
                    fields: [{key: 'emp_code', label: 'Employee Code', sortable: true},
                        {key: 'emp_name', label: 'Employee Name', sortable: true},
                        {key: 'department_name', sortable: true, label: 'Department',},
                        {key: 'designation', sortable: true, label: 'Designation',},
                        {key: 'salary_head_name', label: 'Salary Head Name', sortable: true},
                        {key: 'description', label: 'Description',  sortable: true},
                        {key: 'active_status', label: 'Activation Status'},
                        {key: 'deduction_status', label: 'Deduction Status ', sortable: true}],
                    items: []
        };
      },
      mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Payroll"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Setup"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Wise Salary Allocation"});
            this.allDatalistShow();
      },

        methods:{
         allDatalistShow(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/payroll/search-salary-allocation').then(res => {
                                    this.departmentList = res.data.departments;
                });
            },

            searchempcods(id){
                if(id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/search-salary-allocation/emp-info/${id}`, this.searchEmpWiseSalaryAllocation).then(res => {
                        this.empIdList = res.data.empcodeList;
                    })
                }
            },
           onSearchData(evt) {
                        this.searchEmpWiseSalaryAllocation.emp_id=this.selectedEmployee.emp_id;
                        evt.preventDefault();
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, '/payroll/search-salary-allocation/search',this.searchEmpWiseSalaryAllocation).then(res => {
                                    this.items = res.data.salAllocation;
                                    this.totalList = res.data.salAllocation.length;
                        });
                  },
            onReset(evt) {
                        evt.preventDefault();
                        // Reset our form values
                        this.selectedEmployee=[];
                        this.searchEmpWiseSalaryAllocation.department = null;
                        this.searchEmpWiseSalaryAllocation.active_status= null;
                        this.show = false;
                        this.items=null;
                        //this.selectedEmployee.emp_id;
                        this.$nextTick(() => {
                        this.show = true
                        })
                    }
        }
};
</script>
