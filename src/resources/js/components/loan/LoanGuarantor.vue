<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Loan Guarantor</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>

                            <b-col md="4">
                                <b-form-group label="Loan Type" label-for="loan_type" class="required">
                                    <b-form-select id="loan_type_id" v-model="loanApplication.loan_type_id"
                                                   text-field="loan_name" value-field="loan_type_id"
                                                   :options="loanTypes" required
                                                   @change="loanTypeChange(loanApplication.loan_type_id)"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Employee Code" label-for="emp_code" class="required">
                                    <v-select
                                        label="option_name"
                                        v-model="selectedEmployee"
                                        :options="empIdList"
                                        @search="searchEmployees"
                                        id="emp_code"
                                    >
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Employee Name" label-for="emp_name">
                                    <b-form-input id="emp_name" v-model="loanApplication.emp_name"
                                                  readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Designation" label-for="designation">
                                    <b-form-input id="designation" v-model="loanApplication.designation"
                                                  readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Department" label-for="department">
                                    <b-form-input id="department" v-model="loanApplication.department_name"
                                                  readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Section" label-for="section">
                                    <b-form-input  id="section" v-model="loanApplication.dpt_section"
                                                  readonly></b-form-input>
                                </b-form-group>
                            </b-col>


                        </b-row>
                        <b-row class="mt-2">
                            <b-col md="12">
                                <b-card class="cutome_boder" title="Guarantor" :aria-hidden="show ? 'true' : null">
                                    <b-row v-for="(guarantor, index) in createGuarantorParam.params" :key="index"
                                           class="mt-1">

                                        <b-col lg="1" style="margin-top: 20px">
                                            {{ index+1 }}
                                        </b-col>
                                        <b-col lg="2">
                                            <b-form-group label="Guarantor" label-for="guar_info_id" class="required">
                                                <v-select
                                                    label="option_name"
                                                    v-model="guarantor.selectedGurantor"
                                                    :options="GurantorList"
                                                    @search="searchGurantors"
                                                    id="guar_info_id"
                                                >
<!--                                                    @onChange="selectedGEmployee"-->
                                                    <template #selected-option="{ emp_code }">
                                                        <div style="display: flex; align-items: baseline;">
                                                            {{ emp_code  }}
                                                        </div>
                                                    </template>
                                                </v-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group label="Employee Name" label-for="emp_name">
                                                <b-form-input id="emp_name" v-model="guarantor.selectedGurantor.emp_name"
                                                              readonly></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                         <b-col md="2">
                                            <b-form-group label="contact no" label-for="contact">
                                                <b-form-input id="contact" v-model="guarantor.contact" number :maxlength="11" ></b-form-input>
                                            </b-form-group>
                                        </b-col>

                                        <b-col lg="2">
                                            <b-form-group label="Relation with loan" label-for="relation_with_loan" class="required">
                                                <b-form-select
                                                    v-model="guarantor.relation_with_loan"
                                                    id="loan_type"
                                                    :options="relationList"
                                                    required>
                                                </b-form-select>
                                            </b-form-group>
                                        </b-col>

                                        <b-col lg="1">
                                            <b-row>
                                                <b-col lg="12" class="form-group">
                                                    <a type="button" v-if="index != 0 && index != 1" @click.prevent="removeGuarantorParam(index,guarantor)"
                                                       class="mr-1" style="margin-top: 27px">
                                                        <i class="bx bx-trash cursor-pointer text-danger"></i>
                                                    </a>
                                                </b-col>
                                            </b-row>
                                        </b-col>
                                    </b-row>
                                    <b-row align-h="end" class="mt-1">
                                        <b-col lg="12" class="form-group">
                                            <b-button
                                                @click.prevent="addGuarantorParam"
                                                size="md"
                                                class="btn-dark mr-1"
                                                type="submit"
                                            > Add
                                            </b-button>
                                        </b-col>
                                    </b-row>
                                </b-card>
                            </b-col>
                         </b-row>
                        <b-row>
                            <b-col class="mt-2 d-flex justify-content-end">
                                <b-button-group>
                                    <b-button md="6" size="md" variant="primary" type="submit">Save</b-button>&nbsp;
                                    <b-button md="6" size="md" variant="secondary" type="reset">Reset</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Loan Guarantor List</b-card-header>
                <b-card-body class="border">
                    <Datatable  v-bind:fields="tableData.fields" :totalList="totalItems"  perPage="10" v-bind:items="tableData.items"  :primaryKeyColumnName="'application_id'">
                        <template v-slot:action2="{ rows }">
                            <b-button-group size="sm">
                                <a :href="reportUrl" @click="printNotice(rows.item)" class="ot-btn btn btn-primary" target="_blank"><i  class="bx bx-printer cursor-pointer"></i></a>
                            </b-button-group>
                        </template>
                        <template v-slot:actions="{ rows }">
                            <b-form-select v-model="rows.item.guar_info_id" :options="gurantorOptions.filter(a => a.loan_emp_id == rows.item.emp_id)" value-field="loan_guarantor_id" text-field="emp_name"></b-form-select>
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
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from "../../Repository/ApiRepository";
    import vcss from 'vue-select/dist/vue-select.css';
    import DatePicker from "vue2-datepicker";
    import moment from "moment";

    export default {
        components: { Datatable, Vue, vSelect, vcss, DatePicker},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan Guarantor"});
            this.loadData()
        },
        data() {
            return {
                gurantorOptions:[],
                formData:{
                    transaction_amt:0
                },
                loanApplication: {
                    emp_name: null,
                    designation: null,
                    department_name: null,
                    dpt_section: null,
                    permanent_address: null,
                    present_address: null,
                    contact_no: null,
                },
                loanTypes:[],
                loans:[],
                relationList:[],
                loanList:[],
                loanNumberOptions:[],
                visible: true,
                visibleAmt: true,
                formattedData:null,
                formattedDataAmt:null,
                temp: null,
                tempAmt: null,
                totalItems: null,
                show: true,
                selectedEmployee: {},
               // selectedGurantor: {},
                empIdList: [],
                GurantorList: [],
                reportUrl:'',
                guarantor: {guar_info_id: '', relation_with_loan: '22',emp_name:'',contact:'',selectedGurantor:{emp_name:''}},
                createGuarantorParam: {
                    params: [
                        {guar_info_id: '', relation_with_loan: '22',emp_name:'',contact:'',selectedGurantor:{emp_name:''}},
                        {guar_info_id: '', relation_with_loan: '22',emp_name:'',contact:'',selectedGurantor:{emp_name:''}},
                    ]
                },
                reportParams: {
                    xdo:'/~weblogic/LOAN/RPT_GUARANTOR_LETTER.xdo',
                    type:"pdf",
                    p_loan_guarantor_id:'',
                    p_loan_emp_id: '',
                    filename:'RPT_GUARANTOR_LETTER'
                },
                tableData: {
                    fields: [
                        {label: 'Employee Code', key: 'emp_code'},
                        {label: 'Employee Name', key: 'emp_name'},
                        {label: 'Department Name', key: 'department_name'},
                        {label: 'Designation', key:'designation', sortable:true},
                        {label: 'Gurantor', key: 'action', sortable: false},
                        {label: 'Action', key: 'action2', sortable:false}
                     ],
                    items: []
                }
            }
        },

        watch: {

            'guarantor.selectedGurantor': function (val, oldVal) {
              console.log(this.createGuarantorParam.params);
              //console.log(val);
                if (val !== null) {
                    this.createGuarantorParam.params.guar_emp_code = val.emp_code;
                    this.createGuarantorParam.params.emp_name = val.emp_name;
                    this.createGuarantorParam.params.guar_info_id = val.emp_id;
                    this.createGuarantorParam.params.department_name = val.department_name;
                }
                deep: true
            },
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.loanApplication.emp_code = val.emp_code;
                    this.loanApplication.emp_name = val.emp_name;
                    this.loanApplication.emp_id = val.emp_id;
                    this.loanApplication.bill_code = val.bill_code;
                    if (val.section_name)
                        this.loanApplication.dpt_section = val.dpt_section;
                    if (val.department_name)
                        this.loanApplication.department_name = val.department_name;
                    if (val.designation)
                        this.loanApplication.designation = val.designation;

                    this.loanApplication.gpf_id = val.gpf_id;

                    if (this.loanApplication.loan_type_id) {
                        this.amountReadonly = false;
                    }
                }

            }

        },
        methods: {
            onSubmit() {
                this.loanApplication.guarantors = this.createGuarantorParam.params;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/loan/store-guarantor`,this.loanApplication).then(res => {
                    if (res.data.o_status_code == 1){
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.onReset();
                        this.loadData();
                    }
                    else{
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            onReset() {
                this.loanApplication={};
                this.selectedEmployee=[];
                this.loanApplication.emp_code = null;
                this.loanApplication.emp_name = null;
                this.guarantor = {guar_info_id: '', relation_with_loan: '',attachment: '',attachment_file_name:''},
                    this.createGuarantorParam = {
                        params: [
                            {guar_info_id: '', relation_with_loan: '22',emp_name:'',contact:'',selectedGurantor:{emp_name:''}},
                            {guar_info_id: '', relation_with_loan: '22',emp_name:'',contact:'',selectedGurantor:{emp_name:''}},
                        ]
                    }
            },

            selectLoan(item) {
                this.formData = item;
                this.formData.transaction_amt=item.application_amt;
                window.scrollTo(0,0);
            },
            selectedGEmployee(item) {
                  console.log(item);
            },
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/get-guarantors`).then(res => {
                    this.tableData.items=res.data.data;
                    this.totalItems=res.data.data.length;
                    this.relationList = res.data.relations;
                    this.loanTypes = res.data.loanTypes.filter(i => i.loan_type_id != 1);
                    this.gurantorOptions=res.data.gurantors;
                });
            },

            addGuarantorParam: function () {
                this.createGuarantorParam.params.push(Vue.util.extend({}, this.guarantor));
                if (this.createGuarantorParam.params.length > 8) {
                    this.disabled = true;
                } else {
                    this.disabled = false;
                }
            },
            loanTypeChange(id) {
                this.loanApplication.rate_of_interest = this.loanTypes.filter(a => a.loan_type_id == id)[0].rate_of_interest;
                this.max_value = this.loanTypes.filter(a => a.loan_type_id == id)[0].max_value;
            },
            removeGuarantorParam: function (index,guarantor) {
                console.log(guarantor);
                if(guarantor){
                    this.deleteGuarantor(guarantor.loan_guarantor_id);
                }

                Vue.delete(this.createGuarantorParam.params, index);
                if (this.createGuarantorParam.params.length < 9) {
                    this.disabled = false;
                } else {
                    this.disabled = true;
                }
            },
            deleteGuarantor(id){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/guarantor-delete/${id}`, this.loanApplication).then(res => {
                    this.empIdList = res.data;
                })
            },
            searchEmployees(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/emp/${id}`, this.loanApplication).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            searchGurantors(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/emp/${id}`, this.loanApplication).then(res => {
                        this.GurantorList = res.data;
                    })
                }
            },
            onChangeLoanType(){
                if(this.formData.loan_type_id){
                    this.loanNumberOptions = this.loans.filter(a=>a.loan_type_id==this.formData.loan_type_id)
                }
            },
            onChangeLoanNo(loan_no){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loans/pf`).then(res => {
                    this.formData=res.data.pfLoans.filter(a=>a.loan_no == loan_no)[0];
                    this.formData.transaction_amt=((res.data.pfLoans.filter(a=>a.loan_no == loan_no)[0].application_amt) - (res.data.pfLoans.filter(a=>a.loan_no == loan_no)[0].disbursement_amount));
                });
            },
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            },
            printNotice(i) {
                let item = Object.assign({}, i);
                console.log(item);
                // let title='Prl-notice'
                this.reportParams.p_loan_guarantor_id =  item && item.guar_info_id  ? item.guar_info_id : '';
                this.reportParams.p_loan_emp_id = item.loan_emp_id;
                let params = this.reportParams;
                let queryString = Object.keys(params).map(function (key) {
                    return key + "=" + params[key]
                }).join('&');
                this.reportUrl = '/report/render/Loan Guarantor Agreement?' + queryString;
            },
        }
    }
</script>

<style>
    .required label:after {
        content:"*";
        color: red;
    }
</style>

