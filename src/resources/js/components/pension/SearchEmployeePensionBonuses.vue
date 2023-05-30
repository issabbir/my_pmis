<template>
    <div class="content-wrapper">
        <div id="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Employee Bonus </b-card-header>
                <b-card-body class="border">
                    <b-form @submit="onSubmit" @reset.prevent="onReset" v-if="show">
                    <b-row class="d-flex justify-content-start">
                        <b-col md="3">
                            <b-form-group label="Year" label-for="year" class="requiredField">
                                <b-form-select
                                    @change="changeYear"
                                    v-model="pensionHeadObj.fy_id"
                                    :options="yearsList"
                                    name="years"
                                    required
                                ></b-form-select>
                                <span :style="errorMessage">{{ errors.first('fy_id') }}</span>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="Month" label-for="month" class="requiredField">
                                <b-form-select
                                    v-model="pensionHeadObj.pr_month_id"
                                    :options="monthsList"
                                    name="month"
                                    required
                                ></b-form-select>
                                <span :style="errorMessage">{{ errors.first('pr_month_id') }}</span>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="Department" label-for="department" >
                                <b-form-select

                                    v-model="pensionHeadObj.department_id"
                                    :options="departmentList"
                                    name="department"
                                    required
                                ></b-form-select>

                            </b-form-group>
                        </b-col>

                        <b-col md="3">
                            <b-form-group label="Employee Code" label-for="emp_code">
                                <v-select
                                        label="option_name"
                                        v-model="selectedEmployee"
                                        :options="empIdList"
                                        @search="searchEmpCode"

                                        id="emp_code">
                                    <template #selected-option="{ emp_code }">
                                        <div style="display: flex; align-items: baseline;">
                                            {{ emp_code }}
                                        </div>
                                    </template>
                                </v-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="Employee Type" label-for="emp_type_name"  >
                                <b-form-select
                                    v-model="pensionHeadObj.p_emp_type_id"
                                    :options="employeeTypeList"

                                ></b-form-select>
                                <span :style="errorMessage">{{ errors.first('p_emp_type_id') }}</span>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="Bonus Head" label-for="bonus_head" class="requiredField">
                                <b-form-select
                                    v-model="pensionHeadObj.bonus_head"
                                    :options="bonusHeads"
                                    name="bonus_head"
                                    required
                                    text-field="pension_head" value-field="pension_head_id"
                                ></b-form-select>
                                <span :style="errorMessage">{{ errors.first('bonus_head') }}</span>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group label="Pension category" label-for="pensionCat"  class="requiredField">
                                <b-form-select v-model="pensionHeadObj.pensionCat" name="pensionCat" @change="selectPensionCat"
                                               :options="pensionCatOption"
                                               label="text" required>
                                </b-form-select>
                            </b-form-group>
                        </b-col>
                    </b-row>


                    <b-row>
                        <b-col class="d-flex justify-content-end" >
                            <b-form-group class="mt-2">
                                <b-button type="submit" variant="primary"><i class='bx bx-search'></i> Search</b-button>
                                <b-button type="reset" variant="secondary">Reset</b-button>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Bonus Employee List
                    <b-button-group size="sm" class="float-right">
                        <b-button type="submit" v-if="approvalProcessData.approval_workflow_id==null && tableData.items.length>0" @click="showWorkflowModal(approvalProcessData.pension_process_approval_id)" variant="success">Assign Workflow</b-button>
                        <b-button type="submit" v-if="tableData.items.length>0 && approvalProcessData.approval_workflow_id!=null && approvalProcessData.approved_yn=='N'" @click="showModalApproval(approvalProcessData)" variant="primary">Approval</b-button> &nbsp;
                    </b-button-group>
                </b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :totalList="totalList" :perPage="perPage">
                    </Datatable>
                </b-card-body>
            </b-card>
            <b-modal v-model="approveShow" size="xl" okTitle="Submit"  :hide-footer=true :hide-header=true>
                <b-row >
                    <b-col>
                        <h4>{{'Pension bonus approval process'}}</h4>
                    </b-col>
                    <b-col class="d-flex justify-content-end">
                        <b-button size="sm" variant="outline-secondary" @click="hideApprovalModal()">Close</b-button>
                    </b-col>
                </b-row>
                <b-row  class="border mb-1 pt-1 pb-1 mt-2">
                    <b-col>
                        <h5>Process Step</h5>
                        <b-progress :value="current_step.process_step*25"  variant="success" key="success"></b-progress>
                        <b-form @submit.prevent="addState(next_step?next_step:current_step)">
                            <b-row class="pt-1">
                                <b-col v-if="current_step">
                                    <b-list-group>
                                        <b-list-group-item href="#" class="flex-column align-items-start">
                                            <div class="d-flex w-100 justify-content-between">
                                                <div class="text-success">{{current_step.workflow}}</div>
                                                <small><span class="badge badge-pill badge-secondary">{{current_step.insert_date|dateFormat}}</span></small>
                                            </div>
                                            <div class="d-flex w-100 justify-content-between">
                                                <small>By {{(current_step.user)?current_step.user.emp_name:''}}</small>
                                                <small>{{(current_step.user)?current_step.user.designation:''}}</small>
                                            </div>
                                            <div class="d-flex w-100 justify-content-between" v-if="false">
                                                <div>
                                                    Current status: <b-badge variant="warning">Pending</b-badge>
                                                </div>
                                                <div>
                                                    <b-button size="sm"  pill variant="success">Accept</b-button>
                                                    <b-button size="sm" pill variant="outline-danger">Change request</b-button>
                                                </div>
                                            </div>
                                            <div>
                                                <b-list-group >
                                                    <b-list-group-item v-if="false">
                                                        <div class="d-flex w-100 justify-content-between">
                                                            <b-input-group>
                                                                <b-form-input></b-form-input>
                                                                <b-input-group-append>
                                                                    <b-button variant="outline-primary">ADD</b-button>
                                                                </b-input-group-append>
                                                            </b-input-group>
                                                        </div>
                                                    </b-list-group-item>
                                                    <b-list-group-item  class="mt-1">
                                                        <div><pre>{{current_step.note}}</pre></div>
                                                    </b-list-group-item>
                                                </b-list-group>
                                            </div>
                                        </b-list-group-item>
                                    </b-list-group>

                                    <div v-if="hasHistoryPermission()" class="mt-1">
                                        <b-button  variant="warning" @click="showHistory = !showHistory" ><i
                                            class='bx bxs-down-arrow-square'></i> Show Authorization Status Histories
                                        </b-button>
                                        <b-list-group v-if="showHistory" class="mt-1">
                                            <b-list-group-item v-for="state in workflowProcess" :key="state.workflow_step.workflow_key" href="#" class="flex-column align-items-start">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <div class="text-success">{{state.workflow_step.forward_title}}</div>
                                                    <small><span class="badge badge-pill badge-secondary">{{state.workflow_step.insert_date|dateFormat}}</span></small>
                                                </div>
                                                <div class="d-flex w-100 justify-content-between">
                                                    <small>By {{state.user.emp_name}}</small>
                                                    <small>{{state.user.designation}}</small>
                                                    <small>{{state.user.designation}}</small>
                                                </div>
<!--                                                <div class="d-flex w-100 justify-content-between">-->
<!--                                                    <small>By {{state.user.emp_name}}</small>-->
<!--                                                    <small>{{state.user.designation}}</small>-->
<!--                                                </div>-->
                                                <div class="d-flex w-100 justify-content-between" v-if="false">
                                                    <div>
                                                        Current status: <b-badge variant="warning">Pending</b-badge>
                                                    </div>
                                                    <div>
                                                        <b-button size="sm"  pill variant="success">Accept</b-button>
                                                        <b-button size="sm" pill variant="outline-danger">Change request</b-button>
                                                    </div>
                                                </div>
                                                <div>
                                                    <b-list-group >
                                                        <b-list-group-item v-if="false">
                                                            <div class="d-flex w-100 justify-content-between">
                                                                <b-input-group>
                                                                    <b-form-input></b-form-input>
                                                                    <b-input-group-append>
                                                                        <b-button variant="outline-primary">ADD</b-button>
                                                                    </b-input-group-append>
                                                                </b-input-group>
                                                            </div>
                                                        </b-list-group-item>
                                                        <b-list-group-item class="mt-1">
                                                            <div>{{state.note}}</div>
                                                        </b-list-group-item>
                                                    </b-list-group>
                                                </div>
                                            </b-list-group-item>
                                        </b-list-group>
                                    </div>
                                </b-col>
                                <b-col>
                                    <div>
                                        <div v-if="!next_step" class="d-flex w-100 justify-content-center">
                                            <b-card bg-variant="success" text-variant="white" :title="nextState.status_name">
                                                <b-card-text >
                                                    <b-row v-if="backWard">
                                                        <b-col md="12">
                                                            <b-form-group label="Change state to" label-for="from-state">
                                                                <b-form-select required v-model="workflow.workflow_step_id" :options="splicedOptions"></b-form-select>
                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col md="12">
                                                            <b-form-group class="requiredField" label="Note" label-for="workflow-note">
                                                                <b-form-textarea :disabled="!hasPermission(current_step)"
                                                                                 v-model="workflow.note"
                                                                                 required
                                                                                 placeholder="Enter something..."
                                                                ></b-form-textarea>
                                                            </b-form-group>
                                                        </b-col>
                                                        <b-col md="12" class="d-flex justify-content-center">
                                                            <b-button type="submit" :disabled="!hasPermission(current_step)" class="mr-1" variant="dark"><i class='bx bxs-send'></i> Update State</b-button>
                                                            <b-button @click="backWard=false" variant="primary">Back to Approve</b-button>
                                                            <small class="text-danger" v-if='!hasPermission(current_step)'>You don't have permission to do this!!</small>
                                                        </b-col>
                                                    </b-row>
                                                    <b-row v-else>
                                                        <b-col md="12" >
                                                            <div>All approval process has been done. Now the application ready to approve.</div>
                                                        </b-col>
                                                        <b-col class="d-flex justify-content-center">
                                                            <b-button type="button" :disabled="!hasPermission(current_step)" class="mr-1" variant="primary" @click="confirmShow = true" >Approve</b-button>
                                                            <b-button @click="backWard = true">Backward</b-button>
                                                            <small class="text-danger" v-if='!hasPermission(current_step)'>You don't have permission to change the state!!</small>
                                                        </b-col>
                                                    </b-row>
                                                </b-card-text>
                                            </b-card>
                                        </div>
                                        <div v-else>
                                            <b-form-group label="Change state to" label-for="from-state">
                                                <b-form-select required v-model="workflow.workflow_step_id" :options="options"></b-form-select>
                                            </b-form-group>
                                            <b-form-group class="requiredField" label="Note" label-for="workflow-note">
                                                <b-form-textarea :disabled="!hasPermission(current_step)"
                                                                 v-model="workflow.note"
                                                                 required
                                                                 placeholder="Enter something..."
                                                ></b-form-textarea>
                                            </b-form-group>
                                            <div>
                                                <b-button type="submit" :disabled="!hasPermission(current_step)" variant="dark"><i
                                                    class='bx bxs-send'></i> Update State
                                                </b-button>
                                                <small class="text-danger" v-if='!hasPermission(current_step)'>You don't have permission to do this!!</small>
                                            </div>
                                        </div>
                                    </div>
                                </b-col>
                            </b-row>
                        </b-form>
                        <b-modal v-model="confirmShow" :centered="true" title="Please Confirm"  size="sm"
                                 buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2" @ok="finalApproved()"
                                 :hideHeaderClose="false" >
                            <div>Are you sure want to final approve this?</div>
                        </b-modal>
                    </b-col>
                </b-row>
            </b-modal>
            <b-modal ref="workflow_modal" @ok="mapWorkflow" @close="hideWorkflowModal">
                <b-form-select v-model="workflowData.approval_workflow_id" text-field="work_flow_name" value-field="approval_workflow_id" :options="workflowOptions"></b-form-select>
            </b-modal>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    import DatePicker from 'vue2-datepicker';
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from '../../Repository/ApiRepository';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';

    export default {
        components: { DatePicker, Datatable,vSelect, vcss },
        data() {
            return {
                errorMessage: {color: 'red'},
                selectedEmployee: [],
                empIdList: [],
                pensionHeadObj:{
                    fy_id : '',
                    pr_month_id : null,
                    department_id: null,
                    p_emp_type_id:null,
                    emp_id:null,
                    bonus_head : null,
                    pensionCat:''
                },

                pr_month_id:0,
                yearsList: [],
                monthsList: [],
                departmentList:[],
                employeeTypeList:[],
                bonusHeads: [],
                process_type_List:[
                    { value: '50', text: '50%' },
                    { value: '100', text: '100%' },
                ],
                //pr_month_id:[],
                workflow:{
                    workflow_step_id:'',
                    note:''
                },
                show: true,
                confirmShow:false,
                approveShow:false,
                showHistory:false,
                backWard:false,
                next_step:{},
                options:[],
                previous_step:{},
                current_step:{},
                process_step:'',
                billStates:[],
                nextState:{},
                comment:{},
                stateOptions: [],
                dateValueType: this.dateFormatter(),
                updateIndex:-1,
                submitBtn: 'Save',
                perPage:5,
                totalList:0,
                pensionCatOption: [
                    { text: 'All Pension Category', value: '' },
                    { text: '50%', value: '50' },
                    { text: '100%', value: '100' }
                ],
                bonusOptions: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'}
                ],
                tableData: {
                    fields: [
                        {key: 'index', label: 'SL', class: 'text-left'},
                        {key: 'emp_code', label: 'Employee Code ', sortable: true, class: 'text-left'},
                        {key: 'emp_name', label: 'Employee Name ', sortable: true, class: 'text-left'},
                        {key: 'department_name', label: 'Department', class: 'text-left'},
                        {key: 'designation', label: 'Designation', class: 'text-left'},
                        {key: 'emp_bank_no', label: 'Bank Account', class: 'text-left'},
                        { key: 'pension_amount',  label: 'Pension Amount' ,  class: 'text-right',sortable: true},
                        {key: 'amount', label: 'Monthly Payable Amount' ,  class: 'text-right',sortable: true},

                        // {key: 'department_name', label: 'Application Date', sortable: true, class: 'text-left'},
                        // 'action'
                    ],
                    items: [],
                },
                workflowData: {
                    approval_workflow_id: '',
                    pension_process_approval_id: '',
                    pension_cat: '',
                    pension_head_id: ''
                },
                approvalProcessData:{
                    approval_workflow_id: null,
                    approved_yn: null,
                    bonus_yn: 'Y',
                    disbursement_yn:null,
                    month_id: null,
                    pension_process_approval_id: null,
                    workflow_process_id: null
                },
                workflowOptions: [],
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pensioners' Bonus"});
            // this.$validator.attach('months', 'required');
            this.allSalarySetup();
            this.changeYear();
            this.preLoadData();
            this.loadWorkflow();
            this.loadEmployeeType()
            this.pensionBonusHeads();

        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.pensionHeadObj.emp_id=val.emp_id;
                    this.pensionHeadObj.department_id=val.dpt_department_id;
                }
            }
        },
        filters: {
            dateFormat: function(value) {
                if (value) {
                    return moment(String(value)).format('MM/DD/YYYY hh:mm')
                }
            }
        },
        methods: {
            onSubmit: function(e) {
                e.preventDefault();
                this.search();
            },
            preLoadData(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/operation/promotions/form-data').then(res => {
                    //console.log(this.res);
                    this.departmentList= res.data.departments;
                });
            },
            changeYear(){
                if(this.pensionHeadObj.fy_id){
                     ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/salary-setup/months-by-year-id/"+ this.pensionHeadObj.fy_id).then(res => {
                         console.log(res)
                        this.monthsList = res.data;
                         let that = this;
                         this.monthsList.forEach( month => {
                             if (month.text == moment().format("MMMM")) {
                                 this.pensionHeadObj.pr_month_id = month.value;
                             }
                         });
                    });
                }
            },
            loadWorkflow(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/workflow`).then(res => {
                    this.workflowOptions = res.data.filter(a=>a.module_id == 5)
                    console.log(this.workflowOptions)
                });
            },
            loadEmployeeType(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/employee-position/designations').then(result => {
                    this.employeeTypeList = result.data.empType;
                });
            },
            pensionBonusHeads() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pension/bonus-process-heads").then(res => {
                    this.bonusHeads = res.data.bonusHeads;
                });
            },
            dateFormatter: function() {
                return {
                    value2date: value => {
                        return value ? moment(new Date(value), "YYYY-MM-DD").toDate() : null;
                    },
                    date2value: date => {
                        return date ? moment(date).format("YYYY-MM-DD") : null;
                    }
                }
            },
            showModalApproval(item) {
                this.loan = {
                    amount:'',
                    item: item,
                    object_id:'pen_prc_'+item.pension_process_approval_id,
                    note:''
                };
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/workflow/status/${item.approval_workflow_id}/${this.loan.object_id}`).then(res => {
                    this.workflowProcess = res.data.workflowProcess;
                    this.next_step = res.data.next_step;
                    if (this.next_step)
                        this.workflow_step_id = this.next_step.workflow_step_id;
                    this.previous_step = res.data.previous_step;
                    this.current_step = res.data.current_step;
                    this.options = res.data.options;
                    this.approveShow = true;
                });
            },
            addState: function(state) {
                state.workflow_object_id = (this.next_step)?this.next_step.approval_workflow_id:this.current_step.approval_workflow_id;
                state.note = this.workflow.note;
                state.workflow_step_id = this.workflow.workflow_step_id
                state.target_url = window.location.pathname.substring(1)+'#'+this.$route.path+'?application_id='+this.loan.object_id
                state.message = 'Monthly pension bonus approval review request sent to you.'

                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/workflow/status/${state.approval_workflow_id}/${this.loan.object_id}`, state).then(res => {
                    this.workflowProcess = res.data.workflowProcess;
                    this.next_step = res.data.next_step;
                    if (this.next_step)
                        this.workflow_step_id = this.next_step.workflow_step_id;
                    this.previous_step = res.data.previous_step;
                    this.current_step = res.data.current_step;
                    this.options = res.data.options;
                    this.workflow.note = ''
                    this.backWard = false
                    // this.$emit('current-status');
                });
            },
            finalApproved: function() {
                let state = (this.next_step)?this.next_step:this.current_step;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/process-final-approval/${state.approval_workflow_id}/${this.loan.object_id}`, state).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.hideApprovalModal();
                        this.confirmShow = false;
                        this.approveShow = false;
                        this.search();
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            hasHistoryPermission:function() {
                if (this.$store.getters.hasGrantAccess) {
                    return this.$store.getters.hasGrantAccess;
                }

                return this.$store.getters.permissions.includes('CAN_SEE_STATUS_HISTORIES');
            },
            hideApprovalModal(){
                this.approveShow = false;
            },
            mapWorkflow(){
                this.workflowData.pension_cat = this.pensionHeadObj.pensionCat;
                this.workflowData.pension_head_id = this.pensionHeadObj.bonus_head;
                ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/pension/update-pension-workflow/${this.workflowData.pension_process_approval_id}`, this.workflowData, ).then(res => {
                    this.search();
                });
            },
            // allSalarySetup() {
            //     ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/year-list").then(res => {
            //         this.yearsList = res.data;
            //     });
            // },

            allSalarySetup() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pension/bonus-process-heads").then(res => {
                    this.yearsList= res.data.fecialYearList;
                    let that = this;
                    this.yearsList.forEach(function(item) {
                        if (item.current_yn == 'Y') {
                            that.pensionHeadObj.fy_id = item.fy_id;
                            that.changeYear();
                            return;
                        }
                    });
                });
            },
            search: function() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/pension/pension-bonus-data',this.pensionHeadObj).then(res => {
                    this.tableData.items = res.data.data;
                    this.totalList = this.tableData.items.length;
                    this.approvalProcessData={
                        approval_workflow_id: res.data.process_data.approval_workflow_id,
                        approved_yn: res.data.process_data.approved_yn,
                        bonus_yn: res.data.process_data.bonus_yn,
                        disbursement_yn:res.data.process_data.disbursement_yn,
                        month_id: res.data.process_data.month_id,
                        pension_process_approval_id: res.data.process_data.pension_process_approval_id,
                        workflow_process_id: res.data.process_data.workflow_process_id
                    };
                });
            },
            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/pension-payable/emp/${id}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            showWorkflowModal(id){
                this.workflowData.pension_process_approval_id = id
                this.$refs['workflow_modal'].show()
            },
            hideWorkflowModal(){
                this.workflowData.pension_process_approval_id = ''
                this.$refs['workflow_modal'].hide()
            },
            onReset() {
                this.selectedEmployee = [];
                this.pensionHeadObj = {};
                this.show = false;
                this.$nextTick(() => {
                    this.show = true
                })
            },
            hasPermission: function(step) {
                if(step.role_yn=='Y'){
                    let hasRole = this.$store.getters.roles.filter( element => element.role_key == step.user_role);
                    return hasRole.length>0;
                } else {
                    return step.user_name == this.$store.state.user.user_name
                }

            },
        }
    }
</script>
<style>
    .mx-datepicker-popup {
        z-index: 9999;
    }
    .table.pr_month_setup td {
        border-bottom: 1px solid #DFE3E7;
        font-size: 14px;
        text-transform: capitalize;
    }
    .salaryInput td{
        padding-top: 20px;
        border:0px !important;
    }

    .process-salary{
        font-size: 20px;
        font-weight: 700;
        letter-spacing: 1px;
        padding: 12px 22px;
    }
</style>
