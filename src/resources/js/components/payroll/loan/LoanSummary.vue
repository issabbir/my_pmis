<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card >
                <b-card-header header-bg-variant="dark" header-text-variant="white">Search</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
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
                            <b-col md="4">
                                <b-form-group
                                    label-for="loan_type"
                                    label="Loan Type">
                                    <b-form-select
                                        v-model="searchParams.loan_type_id"
                                        id="loan_type" text-field="loan_name"
                                        value-field="loan_type_id"
                                        @change="onChangeLoanType"
                                        :options="loanTypes"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label-for="loan_number"
                                    label="Loan Number">
                                    <v-select v-model="searchParams.loan_no"
                                              :options="loanNumberOptions" value="loan_no"
                                              label="loan_no" >
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label-for="input-group-3"
                                    label="Year From">
                                    <b-form-select id='input-group-3' v-model="searchParams.year_from" :options="year_from"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label-for="input-group-4"
                                    label="Month From">
                                    <b-form-select id='input-group-4' v-model="searchParams.month_from" :options="month_from"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label-for="input-group-5"
                                    label="Year To">
                                    <b-form-select id='input-group-5' v-model="searchParams.year_to" :options="year_to"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
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
                <b-card-header header-bg-variant="dark" header-text-variant="white">Basic Information</b-card-header>
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
                <b-card-header header-bg-variant="dark" header-text-variant="white">Loan Summary</b-card-header>
                <b-card-body class="border">
                    <b-row>

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
                                label="Interest"
                                label-for="interest"
                            >
                                <b-form-input v-model="listItems.gpf_interest" readonly id="interest" class="text-right"></b-form-input>
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
                searchParams: {year_from:[], gpf_id:null},
                listItems:{},
                loanTypes:[],
                loanNumberOptions:[],
                selectedEmployee:[],
                empIdList: [],
                year_from:[],
                year_to:[],
                current_year: moment().format('yyyy'),
                month_from:[{text:'January', value:'01'},{text:'February', value:'02'},{text:'March', value:'03'},{text:'April', value:'04'},{text:'May', value:'05'},{text:'June', value:'06'},{text:'July', value:'07'},{text:'August', value:'08'},{text:'September', value:'09'},{text:'October', value:'10'},{text:'November', value:'11'},{text:'December', value:'12'}],
                month_to:[{text:'January', value:'1'},{text:'February', value:'2'},{text:'March', value:'3'},{text:'April', value:'4'},{text:'May', value:'5'},{text:'June', value:'6'},{text:'July', value:'7'},{text:'August', value:'8'},{text:'September', value:'9'},{text:'October', value:'10'},{text:'November', value:'11'},{text:'December', value:'12'}],
                totalItems:0,
                employeeList:[],
                columns: [
                    {label: 'Employee Code', key: 'emp_code', sortable:true},
                    {label: 'Employee Name', key: 'emp_name', sortable:true},
                    {label: 'Leave type', key: 'leave_type',},
                    {label: 'Leave Year', key: 'leave_from_balance',},
                    {label: 'Leave Enjoyed', key: 'leave_enjoy',},
                    {label: 'Leave Remaining', key: 'leave_remaining_balance',}
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
                    this.searchParams.year_from=val.join_year;
                    this.searchParams.year_to=moment().format('YYYY');
                    this.searchParams.month_from=val.join_month;
                    this.searchParams.month_to=moment().format('M')
                    for(let i=val.join_year; i<=moment().format('YYYY'); i++) {
                        this.year_from.push(i);
                        this.year_to.push(i);
                    }
                }

                if(this.searchParams.emp_code!=null && this.searchParams.loan_type_id==null){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/loan-search`).then(res => {
                        this.loanNumberOptions=res.data.filter(a=>a.emp_code==this.searchParams.emp_code);
                    });
                }
                else if(this.searchParams.emp_code!=null && this.searchParams.loan_type_id!=null){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/loan-search`).then(res => {
                        this.loanNumberOptions=res.data.filter(a=>a.emp_code==this.searchParams.emp_code && a.loan_type_id==this.searchParams.loan_type_id);
                    });
                }

            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Loan" });
            this.$store.commit("setBreadcrumb", { link: "/pf-summary", label: "Loan Summary" });
            this.getFormData();
        },

        beforeMount(){

        },
        methods: {
            onSubmit: function() {
                this.search();
            },
            onReset:function(){
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
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loans/pf`).then(res => {
                    this.loanTypes=res.data.loanTypes;
                });

                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/loan-search`).then(res => {
                    this.loanNumberOptions=res.data;
                });
            },
            search: function() {
                let params = this.searchParams;
                console.log('params',params);
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/loan/loan-summary-data`, params).then(res => {
                    console.log(res);
                    if (res.data)
                        this.listItems = res.data[0];
                });
            },
            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/emp/${id}`, this.loanApplication).then(res => {
                        this.empIdList = res.data;
                        console.log(res.data);
                    })
                }


            },
            onChangeLoanType(){
                if(this.searchParams.emp_code==null && this.searchParams.loan_type_id!=null){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/loan-search`).then(res => {
                        this.loanNumberOptions=res.data.filter(a=>a.loan_type_id==this.searchParams.loan_type_id);
                    });
                }
                else if(this.searchParams.emp_code!=null && this.searchParams.loan_type_id!=null){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/loan-search`).then(res => {
                        this.loanNumberOptions=res.data.filter(a=>a.emp_code==this.searchParams.emp_code && a.loan_type_id==this.searchParams.loan_type_id);
                    });
                }
            },


        }
    };
</script>

<style scoped>
    .input{
        background-color: white
    }
</style>
