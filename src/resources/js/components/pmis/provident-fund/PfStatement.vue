<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">PF Statement</b-card-header>
                <b-card-body class="border">
                    <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                        <b-row>
                            <b-col md="4">
                            <b-form-group
                                label="Empoyee Code"
                                label-for="emp_code"
                            >
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
                                    label="Employee Name"
                                    label-for="emp_name"
                                >
                                    <b-form-input
                                        id="emp_name"
                                        v-model="searchParams.emp_name"
                                        type="text"
                                        required
                                        placeholder="Name"
                                        readonly
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Designation"
                                    label-for="designation"
                                >
                                    <b-form-input
                                        id="designation"
                                        v-model="searchParams.designation"
                                        type="text"
                                        required
                                        placeholder="Designation"
                                        readonly
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Department"
                                    label-for="Department"
                                >
                                    <b-form-input
                                        id="department_name"
                                        v-model="searchParams.department_name"
                                        type="text"
                                        required
                                        placeholder="Department"
                                        readonly
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="GPF ID"
                                    label-for="gpf_id"
                                >
                                    <b-form-input
                                        id="gpf_id"
                                        v-model="searchParams.gpf_id"
                                        type="text"
                                        required
                                        readonly
                                        placeholder="GPF ID"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="Financial Years"
                                    label-for="financial_year"
                                >
                                    <b-form-select
                                        id="financial_year"
                                        v-model="searchParams.fy_id"
                                        :options="fyearsList"
                                        required
                                        value-field="fy_id"
                                        text-field="fy_name"
                                    ></b-form-select>
                                </b-form-group>
                            </b-col>

                        </b-row>
                        <b-row>
                            <b-col class="mt-1 d-flex justify-content-end">
                                <b-button md="4" size="md" variant="success" type="submit">Search</b-button>&nbsp;
                                <b-button md="4" class="mr-1" size="md" variant="secondary" type="reset">Reset</b-button>
                                <a v-if="reportUrl" :href="reportUrl" class="btn btn-primary" target="_blank">Render to PDF</a>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">PF Information Details</b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="fields" v-bind:items="items">
                        <!-- <template slot="actions" v-bind:row="row">
                            <a size="sm" class="text-primary" href=""
                                data-toggle="modal"
                                data-target="#border-less"><i
                                class="bx bx-edit cursor-pointer"></i>
                            </a>
                            <a size="sm" class="text-primary" href=""
                                data-toggle="modal"
                                data-target="#border-details"><i
                                class="bx bx-show cursor-pointer"></i></a>
                        </template> -->
                    </Datatable>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from '../../../Repository/ApiRepository';
    import moment from 'moment';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';

    export default {
        components: {DatePicker, Datatable, vSelect, vcss},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Provident Fund"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "PF Statement"});
            this.formData();
        },
        data() {
            return {
                selectedEmployee:[],
                empIdList: [],
                searchParams: {
                    emp_code:null,
                    emp_name:'',
                    emp_id:null,
                    designation:'',
                    designation_id:null,
                    department_name:'',
                    dpt_department_id:null,
                    pf_id:null,
                    fy_id:null
                },
                reportUrl:'',
                reportParams: {
                    xdo:'/~weblogic/PF/GPF_STATEMENT.xdo',
                    type:"pdf",
                    P_BILL_CODE:'',
                    P_DEPARTMENT_ID:'',
                    P_PR_YEAR:'',
                    P_EMP_CODE:'',
                    filename:'GPF Statement'
                },
                fyearsList:[],
                applyDate: new Date(),

                balance_date: new Date(),
                designationList: [{
                    text: 'Select One',
                    value: null
                }, 'Chairman', 'General Manager (A & F)', 'General Manager (Admin)', 'Head Of ICT'],
                departmentList: [{
                    text: 'Select One',
                    value: null
                }, 'Administration', 'Planning', 'Security', 'Finance & Accounts'],
                show: true,
                fields: [
                    {key: 'index', label: 'Sl', class:'text-center'},
                    {key: 'year_month', label: 'Months', sortable: true, sortDirection: 'desc'},
                    {key: 'basic_amt', label: 'Basic', sortable: true, class:'text-right'},
                    {key: 'opening_pf', label:'Opening PF', class:'text-right', sortable:true},
                    {key: 'subscription', label: 'Subscription', sortable: true, sortDirection: 'desc', class: 'text-right'},
                    {key: 'arear_pf', label: 'Arear PF', sortable: true, sortDirection: 'desc', class: 'text-right'},
                    {key: 'opening_loan', label: 'Opening Loan', sortable: true, class: 'text-right'},
                    {key: 'loan_drawn', label: 'Loan Drawn', sortable: true, sortDirection: 'desc', class: 'text-right'},
                    {key: 'loan_repayment', label: 'Loan Repay', sortable: true, sortDirection: 'desc', class: 'text-right'},
                    {key: 'loan_interest', label: 'Loan Interest', class:'text-right'},
                    {key: 'settlement', label: 'Settlement', sortable: true, sortDirection: 'desc', class: 'text-right'},
                    {key: 'loan_closing_balance', label: 'Closing Loan', sortable: true, class: 'text-right'},
                    {key: 'interest', label: 'GPF Interest', sortable: true, sortDirection: 'desc', class: 'text-right'},
                    {key: 'closing_balance', sortable:true, class:'text-right' },
                    // 'action'
                    ],
                items: [],
                totalRows: 1,
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
                    content: ''
                },
            }
        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.searchParams.emp_id=val.emp_id;
                    this.searchParams.emp_code= val.emp_code;
                    this.searchParams.gpf_id = val.gpf_id;
                    this.searchParams.emp_name=val.emp_name;
                    this.searchParams.designation=val.designation;
                    this.searchParams.designation_id=val.designation_id;
                    this.searchParams.department_name=val.department_name;
                    this.searchParams.dpt_department_id=val.dpt_department_id;

                }
            }
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault()
                let empId=this.searchParams.emp_id;
                let fy_id=this.searchParams.fy_id;
                this.renderPdf();
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/providentFund/gpf/statement/${empId}/${fy_id}`).then(result => {
                this.items = result.data;
                }).catch(err => {
                    console.log('error');
                });

            },
            onReset(evt) {
                evt.preventDefault();
                this.items=[];
                this.selectedEmployee='';
                this.form.empId = '';
                this.form.empName = '';
                this.form.designation_id = null;
                this.form.department_id = null;
                this.form.pf_id = '';

                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                })

            },
            /*editRow(i, code) {

            },*/
            deleteRow(i, code) {
                if (i > -1) {
                    this.tableData.items.splice(i, 1);
                }
            },
            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/providentFund/gpf/employees/${id}`, this.loanApplication).then(res => {
                        this.empIdList = res.data;
                        console.log(res.data);
                    })
                }
            },

            formData(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/providentFund/form-data`, this.loanApplication).then(res => {
                    console.log(res.data.fyears);
                    this.fyearsList=res.data.fyears;
                })
            },
            renderPdf: function() {
                this.reportParams.P_PR_YEAR = this.searchParams.fy_id;
                this.reportParams.P_BILL_CODE = '';
                this.reportParams.P_DEPARTMENT_ID = this.searchParams.department_id;
                this.reportParams.P_EMP_CODE = this.searchParams.emp_code;
                let params = this.reportParams;
                let queryString = Object.keys(params).map(function(key) {
                    return  key+"="+params[key]
                }).join('&');
                this.reportUrl = '/report/render/GPF Statement?'+queryString;
            },

        }
    }
</script>

