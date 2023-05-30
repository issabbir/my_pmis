<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card >
                <b-card-header header-bg-variant="dark" header-text-variant="white">Search By Employee</b-card-header>
                <b-card-body class="border">
                    <b-form @submit="onSubmit" @reset="onReset">
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                        label-for="emp_code"
                                        label="Emp Code">
                                        <v-select
                                            label="option_name"
                                            v-model="selectedEmployee"
                                            :options="empIdList"
                                            @search="searchEmpCode"
                                            id="emp_code">
                                        </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="2">
                                <b-form-group
                                        label-for="input-group-3"
                                        label="Year From">
                                        <b-form-select id='input-group-3' v-model="searchParams.year_from" :options="year_from"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="2">
                                <b-form-group
                                        label-for="input-group-4"
                                        label="Month From">
                                        <b-form-select id='input-group-4' v-model="searchParams.month_from" :options="month_from"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="2">
                                <b-form-group
                                        label-for="input-group-5"
                                        label="Year To">
                                        <b-form-select id='input-group-5' v-model="searchParams.year_to" :options="year_to"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="2">
                                <b-form-group
                                        label-for="input-group-6"
                                        label="Month To">
                                        <b-form-select id='input-group-6' v-model="searchParams.month_to" :options="month_to"></b-form-select>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="12" class="mt-2 d-flex justify-content-end">
                                <b-form-group>
                                    <b-button type="submit" variant="primary"><i class='bx bx-search'></i> Search</b-button>
                                    <b-button md="6" size="md" variant="dark" type="reset">Reset</b-button>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>

            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">GPF Info</b-card-header>
                <b-card-body class="border">
                    <b-row>
                        <b-col md="6" xl="4" >
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="GPF ID"
                                label-for="gpf_id"
                                >
                                <b-form-input v-model="listItems.gpf_id" readonly id="gpf_id"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" xl="4" >
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="Employee Code"
                                label-for="code"
                                >
                                <b-form-input v-model="listItems.emp_code" readonly id="code"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" xl="4" >
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="Employee Name"
                                label-for="emp_name"
                                >
                                <b-form-input v-model="listItems.emp_name" readonly id="emp_name"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" xl="4" >
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="Designation"
                                label-for="designation"
                                >
                                <b-form-input v-model="listItems.designation" readonly id="designation"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" xl="4" >
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="Department"
                                label-for="department"
                                >
                                <b-form-input v-model="listItems.department_name" readonly id="department"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" xl="4">
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="Pay Scale"
                                label-for="pay_scale"
                                >
                                <b-form-input v-model="listItems.pay_scale" readonly id="pay_scale" style="text-align:right"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" xl="4" >
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="Current Basic"
                                label-for="current_basice"
                                >
                                <b-form-input v-model="listItems.basic_amt" readonly id="current_basice" style="text-align:right"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" xl="4">
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="PRL Date"
                                label-for="prl_date"
                                >
                                <b-form-input v-model="listItems.emp_lpr_date" readonly id="prl_date"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" xl="4" >
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="Joining Date"
                                label-for="join_date"
                                >
                                <b-form-input v-model="listItems.emp_join_date" readonly id="join_date"></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>

            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">GPF Summary</b-card-header>
                <b-card-body class="border">
                    <b-row>
                        <b-col md="6" xl="4" >
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="GPF Opening"
                                label-for="opening"
                                >
                                <b-form-input v-model="listItems.opening" readonly id="opening" class="text-right"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" xl="4">
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="GPF Subscription"
                                label-for="GPF-Subscription"
                                >
                                <b-form-input v-model="listItems.gpf_subscription" readonly id="GPF-Subscription" class="text-right"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" xl="4" >
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="GPF Interest"
                                label-for="gpf_interest"
                                >
                                <b-form-input v-model="listItems.gpf_interest" readonly id="gpf_interest" class="text-right"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" xl="4" >
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="Loan Amount"
                                label-for="loan"
                                >
                                <b-form-input v-model="listItems.loan" readonly id="loan" class="text-right"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" xl="4" >
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="Loan Repay Amount"
                                label-for="loan_repay"
                                >
                                <b-form-input v-model="listItems.loan_repay_amount" readonly id="loan_repay" class="text-right"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" xl="4" >
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="PF Balance"
                                label-for="pf_balance"
                                >
                                <b-form-input v-model="listItems.pf_balance" readonly id="pf_balance" class="text-right"></b-form-input>
                            </b-form-group>
                        </b-col>
                         <b-col md="6" xl="4" >
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="Total Installment"
                                label-for="installment_number"
                                >
                                <b-form-input v-model="listItems.total_installment" readonly id="installment_number" class="text-right"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" xl="4" >
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="Total Paid Installment"
                                label-for="paid_installment"
                                >
                                <b-form-input v-model="listItems.total_paid_installment" readonly id="paid_installment" class="text-right"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" xl="4" >
                            <b-form-group
                                label-cols-sm="4"
                                label-cols-lg="4"
                                label="Loan Balance"
                                label-for="loan_balance"
                                >
                                <b-form-input v-model="listItems.loan_balance" readonly id="loan_balance" class="text-right"></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from '../../../Repository/ApiRepository';
    import moment from 'moment';
    import DatePicker from "vue2-datepicker";
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';

    export default {
        components: { Datatable, DatePicker, Vue, vSelect, vcss},
    data() {
        return {
          searchParams: {year_from:[]},
          listItems:{},
          selectedEmployee:[],
          empIdList: [],
          year_from:[],
          year_to:[],
          current_year: moment().format('yyyy'),
          month_from:[{text:'January', value:'1'},{text:'February', value:'2'},{text:'March', value:'3'},{text:'April', value:'4'},{text:'May', value:'5'},{text:'June', value:'6'},{text:'July', value:'7'},{text:'August', value:'8'},{text:'September', value:'9'},{text:'October', value:'10'},{text:'November', value:'11'},{text:'December', value:'12'}],
          month_to:[{text:'January', value:'1'},{text:'February', value:'2'},{text:'March', value:'3'},{text:'April', value:'4'},{text:'May', value:'5'},{text:'June', value:'6'},{text:'July', value:'7'},{text:'August', value:'8'},{text:'September', value:'9'},{text:'October', value:'10'},{text:'November', value:'11'},{text:'December', value:'12'}],
          totalItems:0,
          employeeList:[],
          columns: [
                {
                      label: 'Employee Code',
                      key: 'emp_code',
                      sortable:true
                },
                {
                    label: 'Employee Name',
                    key: 'emp_name',
                    sortable:true
                },
                {
                    label: 'Leave type',
                    key: 'leave_type',
                },
                {
                    label: 'Leave Year',
                    key: 'leave_from_balance',
                },
                {
                    label: 'Leave Enjoyed',
                    key: 'leave_enjoy',
                },
                {
                    label: 'Leave Remaining',
                    key: 'leave_remaining_balance',
                }
            ],
        };
  },
    watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.searchParams.emp_code = val.emp_code;
                    this.searchParams.emp_name = val.emp_name;
                    this.searchParams.designation = val.designation;
                    this.searchParams.gpf_id = val.gpf_id;
                    this.searchParams.year_from=val.joning_year;
                    this.searchParams.year_to=moment().format('YYYY');
                    this.searchParams.month_from=val.joning_month;
                    this.searchParams.month_to=moment().format('M')
                    for(let i=val.joning_year; i<=moment().format('YYYY'); i++) {
                        this.year_from.push(i);
                        this.year_to.push(i);
                    }
                }
            }
        },
  mounted() {
    this.$store.commit("setBreadcrumbEmpty");
    this.$store.commit("setBreadcrumb", { link: "#", label: "Provident Fund" });
    this.$store.commit("setBreadcrumb", { link: "/pf-summary", label: "PF Summary" });
    this.getFormData();
  },

  beforeMount(){

  },
  methods: {
    onSubmit: function(e) {
        e.preventDefault();
        this.search();
    },
    onReset:function(e){
        e.preventDefault();
        this.selectedEmployee='',
        this.searchParams.emp_code= '';
        this.searchParams.gpf_id = '';
        this.searchParams.year_from='';
        this.searchParams.year_to='';
        this.searchParams.month_from='';
        this.searchParams.month_to='';
        this.listItems='';
    },
    getFormData: function () {
        ApiRepository.callApi(ApiRepository.GET_COMMAND, '/leave/leave-summery-form-data').then(res => {
            this.employeeList = res.data.leave_types;
        });
    },
    search: function() {
        let params = this.searchParams;
        ApiRepository.callApi(ApiRepository.POST_COMMAND, '/providentFund/gpf/employees/search', params).then(res => {
            if (res.data)
            this.listItems = res.data[0];

            // this.totalItems = res.data.total;
        });
    },
    searchEmpCode(id) {
         if (id) {
            ApiRepository.callApi(ApiRepository.GET_COMMAND, `/providentFund/gpf/employees/${id}`, this.loanApplication).then(res => {
                this.empIdList = res.data;
                console.log(res.data);
            })
        }


    }
  }
};
</script>

<style scoped>
.input{
    background-color: white
}
</style>
