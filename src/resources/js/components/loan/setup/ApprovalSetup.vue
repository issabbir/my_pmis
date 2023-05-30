<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Approval Setup</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>
                            <b-col md="4">
                                <b-form-group label="Application Page" label-for="application_page_id" class="required">
                                    <b-form-select id="application_page_id" v-model="approvalSetup.application_page_id"
                                                   text-field="show_value" value-field="pass_value"
                                                   :options="applicationPageList" required></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Approval For Department" label-for="loan_type" class="required">
                                    <b-form-select id="approval_for_department_id" v-model="approvalSetup.approval_for_department_id"
                                                   text-field="text" value-field="value"
                                                   :options="deparmentList"
                                                   @change="approvalDepartmentChange"
                                    ></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Department" label-for="loan_type" class="required">
                                    <b-form-select id="department_id" v-model="approvalSetup.department_id"
                                                   text-field="text" value-field="value"
                                                   :options="deparmentList"
                                                   @change="departmentChange"
                                                    ></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Section" label-for="loan_type">
                                    <b-form-select id="loan_type" v-model="approvalSetup.section_id"
                                                   text-field="dpt_section" value-field="dpt_section_id"
                                                   :options="sectionsList"
                                                     >
                                        <template #first>
                                            <b-form-select-option value="">-- Please select an option --</b-form-select-option>
                                        </template>
                                    </b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Employee Code" label-for="emp_code">
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
<!--                            <b-col md="4">-->
<!--                                <b-form-group label="Approval Type" label-for="loan_type" class="required">-->
<!--                                    <b-form-select id="loan_type" v-model="approvalSetup.approval_type"-->
<!--                                                   text-field="text" value-field="value"-->
<!--                                                   :options="approvalTypeList" required></b-form-select>-->
<!--                                </b-form-group>-->
<!--                            </b-col>-->
                            <b-col md="4">
                                <b-form-group label="Priority Sequence Rate" label-for="priority_sequence" class="required">
                                    <b-form-input v-model="approvalSetup.priority_sequence" number
                                                  id="priority_sequence"></b-form-input>
                                </b-form-group>
                            </b-col>

                        </b-row>
                        <b-row>
                            <b-col class="mt-2 d-flex justify-content-end">
                                <b-button-group>
                                    <b-button md="6" size="md" variant="primary" type="submit">{{submit}}</b-button>&nbsp;
                                    <b-button md="6" size="md" variant="secondary" type="reset">Reset</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Approval Setup List</b-card-header>
                <b-card-body class="border">
                    <Datatable  v-bind:fields="tableData.fields" :totalList="totalItems"  perPage="10" v-bind:items="tableData.items"  :primaryKeyColumnName="'application_id'">
                        <template v-slot:action2="{ rows }">
                            <b-link @click="selectApprovalSetup(rows.item)" class="ot-btn btn btn-primary">
                                <i  class="bx bx-edit cursor-pointer"></i>
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
    import Datatable from '../../../layouts/common/datatable_store';
    import ApiRepository from "../../../Repository/ApiRepository";
    import vcss from 'vue-select/dist/vue-select.css';
    import DatePicker from "vue2-datepicker";
    import moment from "moment";



    export default {
        components: { Datatable, Vue, vSelect, vcss, DatePicker},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan Approval Setup"});
            this.loadData();
        },
        data() {
            return {
                formData:{
                    transaction_amt:0
                },
                approvalSetup: {
                    application_page_id: null,
                    approval_for_department_id: null,
                    type: null,
                    department_id: null,
                    section_id: null,
                    approval_type: null,
                    priority_sequence: null,
                },
                active_list:[{text:'Yes', value:'Y'},{text:'No', value: 'N'}],
                loanTypes:[],
                loans:[],
                loanList:[],
                loanNumberOptions:[],
                visible: true,
                visibleAmt: true,
                formattedData:null,
                formattedDataAmt:null,
                temp: null,
                submit: 'Add',
                tempAmt: null,
                totalItems: null,
                showTypeFiled: null,
                selectedEmployee: {},
                empIdList: [],
                deparmentList: [],
                sectionsList: [],
                applicationPageList: [],
                approvalTypeList: [
                    {text: 'Parallel', value: 'P'},
                    {text: 'Sequential', value: 'S'}
                ],
                types: [
                    {text: 'Employee', value: 'employee'},
                    {text: 'Department', value: 'department'},
                    {text: 'Section', value: 'section'}
                ],
                tableData: {
                    fields: [
                        {label: 'Approval For Application', key:'approval_for_name', sortable:false},
                        {label: 'Approval For Department', key:'approval_for_department', sortable:false},
                        {label: 'Department Name', key: 'approval_department_name'},
                        {label: 'Section', key: 'approval_section_name'},
                        {label: 'Employee Name', key: 'emp_name'},
                        {label: 'Priority Sequence', key:'priority_sequence', sortable:false},
                        {label: 'Action', key:'action2', sortable:false}
                     ],
                    items: []
                }
            }
        },

        watch: {
            selectedEmployee: function (val, oldVal) {
                 if (val !== null) {
                    this.approvalSetup.emp_code = val.emp_code;
                    this.approvalSetup.emp_name = val.emp_name;
                    this.approvalSetup.emp_id = val.emp_id;
                }else{
                    this.approvalSetup.emp_code = val;
                    this.approvalSetup.emp_id = val;
                }

            }

        },
        methods: {
            onSubmit() {
                // let data = {};
                //  data = this.approvalSetup;
                //  data.emp_code = this.selectedEmployee;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/loan/approval-setup`,this.approvalSetup).then(res => {
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
                this.approvalSetup = {
                        application_page_id: null,
                        type: null,
                        department_id: null,
                        section_id: null,
                        approval_type: null,
                        priority_sequence: null,
                }
                this.submit = 'Add';
            },
            selectApprovalSetup(item) {
                this.submit = 'Update';
                console.log(item.approval_for_department_id);
                this.selectedEmployee = item;
                this.approvalSetup.approval_setup_id = item.approval_setup_id;
                this.approvalSetup.application_page_id = item.application_page_id;
                this.approvalSetup = item;
                this.searchEmployees(this.approvalSetup.emp_code);
                this.departmentChange(item.approval_department);
                this.approvalSetup.department_id = item.approval_department;
                this.approvalSetup.approval_for_department_id = item.approval_for_department_id;
                this.approvalSetup.section_id = item.approval_section;
                this.approvalSetup.approval_type = item.priority_type;
                this.approvalSetup.priority_sequence = item.priority_sequence;
                this.approvalSetup.application_page_id=item.approval_for;
                this.approvalSetup.emp_id=item.approval_emp_id;
            },
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/get-approvals`).then(res => {
                    this.applicationPageList = res.data.loan_application_type;
                    this.tableData.items=res.data.approvalSetup;
                    this.totalItems=res.data.approvalSetup.length;
                });
                this.applicationPageChange();
            },
            searchEmployees(id) {
                let section_id=0,department_id=0;
                department_id = this.approvalSetup.department_id;
                section_id = this.approvalSetup.section_id != null ? this.approvalSetup.section_id : 0;
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/approval-emp/${department_id}/${section_id}/${id}`, this.approvalSetup).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            departmentChange(id){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/section-by-department/${id}`).then(res => {
                     this.sectionsList = res.data;
                });
            },
            approvalDepartmentChange(id) {
                let application_page_id = this.approvalSetup.application_page_id;
                if (application_page_id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/approve-for-department/${application_page_id}/${id}`).then(res => {
                        this.approvalSetup.priority_sequence = res.data.priority_sequence;
                    });
                }
            },
            // sectionsChange(){
            //     ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/department-by-employee`).then(res => {
            //         this.sectionsList = res.data.sections;
            //     });
            // },
            applicationPageChange(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/loan-approval-types`).then(res => {
                    this.deparmentList = res.data.departments;
                    //this.sectionsList = res.data.sections;
                });
            },
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
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

