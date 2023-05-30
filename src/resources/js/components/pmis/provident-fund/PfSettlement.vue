<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card class="card" v-if="updateIndex>0">
                <b-card-header header-bg-variant="dark" header-text-variant="white">PF settlement</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                    <b-form-input v-model="updateIndex" required id="input-update-index" type="text"
                                  :style="{'display':'none'}"></b-form-input>
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Employee Code"
                                    label-for="Emp Code">
                                    <b-form-input
                                        id="emp_code"
                                        v-model="searchParams.emp_code"
                                        type="text"
                                        required
                                        placeholder="Emp Code"
                                        disabled
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="PF ID"
                                    label-for="PF ID">
                                    <b-form-input
                                        id="result"
                                        v-model="searchParams.pf_id"
                                        type="text"
                                        required
                                        placeholder="PF ID"
                                        disabled
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Employee Name"
                                    label-for="Employee Name">
                                    <b-form-input
                                        id="emp_name"
                                        v-model="searchParams.employee_name"
                                        type="text"
                                        required
                                        placeholder="Name"
                                        disabled
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Designation"
                                    label-for="Designation">
                                    <b-form-input
                                        id="designation_id"
                                        v-model="searchParams.designation"
                                        type="text"
                                        required
                                        placeholder="Designation"
                                        disabled
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Pay Scale"
                                    label-for="Pay Scale">
                                    <b-form-input
                                        id="pay_scale"
                                        v-model="searchParams.pay_scale"
                                        type="text"
                                        required
                                        placeholder="Pay Scale"
                                        disabled
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Basic salary"
                                    label-for="Basic salary">
                                    <b-form-input
                                        id="basic_sal_amt"
                                        v-model="searchParams.basic_salary"
                                        type="text"
                                        required
                                        placeholder="Basic Salary"
                                        disabled
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Bank"
                                    label-for="Bank">
                                    <b-form-input
                                        id="bank_id"
                                        v-model="searchParams.bank"
                                        type="text"
                                        required
                                        placeholder="Bank Name"
                                        disabled
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Appointment Date"
                                    label-for="appointment_date">
                                    <b-form-input v-model="searchParams.appointment_date" type="text" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Retirement Date"
                                    label-for="retirement_date">
                                    <b-form-input v-model="searchParams.retirement_date" type="text" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Retirement Leave Date"
                                    label-for="retirement_leave_date">
                                    <b-form-input v-model="searchParams.retirement_leave_date" type="text" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>

<!--                        <b-row>-->
<!--                            <b-col md="12">-->
<!--                                <b-form-group-->
<!--                                    label="Retirement Reasons"-->
<!--                                    label-for="Retirement Reasons">-->
<!--                                    <b-textarea md="6" rows="3">-->
<!--                                        <b-form-input v-model="searchParams.retire_reason"></b-form-input>-->
<!--                                    </b-textarea>-->
<!--                                </b-form-group>-->
<!--                            </b-col>-->
<!--                        </b-row>-->

                        <b-row>
                            <b-col class="col-md-12 col-12">
                                <fieldset class="border p-2">
                                    <legend class="w-auto">Amount</legend>
                                    <b-row>
                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4" class="text-right">
                                                        <label >PF Amount</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input v-model="searchParams.pf_amount" disabled style="text-align:right"></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>

                                    </b-row>
                                    <b-row>
                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4" class="text-right">
                                                        <label>PF Interest(AUTHORITATIVE DONATION)</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input v-model="searchParams.pf_interest" disabled style="text-align:right"></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4" class="text-right">
                                                        <label>Total PF</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input v-model="total_pf" disabled style="text-align:right"></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4" class="text-right">
                                                        <label>Total Loan Amount </label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input :state="false" :value="Number(searchParams.total_loan_amount).toFixed(2)" disabled style="text-align:right"></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>

                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4" class="text-right">
                                                        <label>PF Loan Amount Due</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input :value="Number(searchParams.pf_loan_amount_due).toFixed(2)" disabled style="text-align:right"></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row>

                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4" class="text-right">
                                                        <label>PF Loan Interest Due</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input :value="Number(searchParams.pf_loan_interest_due).toFixed(2)" disabled style="text-align:right"></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4" class="text-right">
                                                        <label>Total Loan Due</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input :value="Number(searchParams.total_loan_due).toFixed(2)" disabled style="text-align:right"></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <hr>
                                    <!--<b-row>
                                        <b-col offset-md="6" md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4">
                                                        <label>PF Balance</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input v-model="searchParams.pf_balance" disabled style="text-align:right"></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>

                                    </b-row>-->
                                    <b-row>
                                        <b-col md="6" offset-md="6">
                                            <b-form-group>
                                                <b-row>
                                                    <b-col md="4" class="text-right">
                                                        <label>Settlement Amount</label>
                                                    </b-col>
                                                    <b-col md="8">
                                                        <b-form-input type="text" v-model="searchParams.settlement_amt" style="text-align:right" disabled></b-form-input>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </fieldset>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="mt-2 d-flex justify-content-end">
                                <b-button md="6" disabled size="md" variant="dark" type="submit">Submit</b-button>&nbsp;
                                <b-button md="6" size="md" class="btn-outline-dark" type="reset">Cancel</b-button>
                            </b-col>
                        </b-row>
                        <!--</fieldset>-->
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">PF Settlement Application</b-card-header>
                <b-card-body class="border">
                    <Datatable  v-bind:fields="fields" :totalList="totalItems" perPage="10" v-bind:items="pfSettlementItems"  :primaryKeyColumnName="'settlement_id'">
                        <template v-slot:action2="{ rows }">
                            <b-button size="sm"  @click="selectApplication(rows.item)" variant="primary">view</b-button>
                            <b-button size="sm" v-if="rows.item.attachment!=null" variant="primary" @click="showAttachmnet(rows.item.attachment)">Download</b-button>
                            <b-button size="sm" v-if="rows.item.settelment_approve_yn=='N' && rows.item.approval_workflow_id != null" @click="showModalApproval(rows.item)" variant="primary">Approve</b-button>
                            <b-button size="sm" v-if="rows.item.approval_workflow_id==null" @click="showWorkflowModal(rows.item.settlement_id)" variant="primary">WORKFLOW</b-button>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
            <b-modal v-model="approveShow" size="xl" okTitle="Submit" :hide-footer=true :hide-header=true>
                <b-row >
                    <b-col>
                        <h4>{{'Provident fund settlement approval process'}}</h4>
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
                                                    <div class="text-success">{{state.workflow_step.workflow}}</div>
                                                    <small><span class="badge badge-pill badge-secondary">{{state.workflow_step.insert_date|dateFormat}}</span></small>
                                                </div>
                                                <div class="d-flex w-100 justify-content-between">
                                                    <small>By {{state.user.emp_name}}</small>
                                                    <small>{{state.user.designation}}</small>
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
    import ApiRepository from '../../../Repository/ApiRepository';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../../layouts/common/datatable';
    export default {
        components: {vSelect, vcss,Datatable,DatePicker},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Provident Fund"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "PF Settlement"});
            this.loadSettlementData();
            this.loadWorkflow();
        },
        computed: {
            splicedOptions: function () {
                return this.options.slice(0,-1)
            },
            total_pf:function () {
                return Number(Number(this.searchParams.pf_amount) + Number(this.searchParams.pf_interest)).toFixed(2)
            }
        },
        data() {
            return {
                selectedEmployee:[],
                empIdList: [],
                searchParams: {
                    emp_code:null,
                    emp_name:'',
                    settlement_id:null,
                    settlement_amt:'',
                    designation:'',
                    bank:null,
                    pf_id:null,
                    total_loan_due:null,
                    pf_balance:null,
                    pf_loan_interest_due:null,
                    total_pf:null,
                    pf_loan_amount_due:null,
                    pf_interest:null,
                    total_loan_amount:null,
                    pf_amount:null,
                    basic_salary:null,
                    appointment_date:null,
                    retirement_date:null,
                    retirement_leave_date:null,

                },
                show: true,
                approveShow:false,
                pfSettlementItems:[],
                fields: [
                    {key: 'index', label: 'Sl', class:'text-center'},
                    {key: 'emp_code', label: 'Emp Code', sortable: true, sortDirection: 'desc'},
                    {key: 'employee_name', label: 'Emp Name', sortable: true},
                    {key: 'pay_scale', label:'Pay Scale', sortable:true},
                    {key: 'pf_id', label: 'PF ID', sortable: true, sortDirection: 'desc'},
                    {key: 'service_period', label: 'Service Period', sortable: true, sortDirection: 'desc'},
                    {key: 'total_loan_amount', label: 'Total Loan Amount', sortable: true, class: 'text-right'},
                    {key: 'pf_amount', label: 'Pf Amount', sortable: true, sortDirection: 'desc', class: 'text-right'},
                    {label: 'Action', key: 'action2', class: 'text-right twenty'}
                ],
                updateIndex: -1,
                items:[],
                totalItems:0,
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
                workflowData: {
                    approval_workflow_id: '',
                    settlement_id: ''
                },
                workflow:{
                    workflow_step_id:'',
                    note:''
                },
                workflowOptions: [],
                workflowProcess:[],
                next_step:{},
                workflow_step_id:'',
                previous_step:{},
                current_step:{},
                dateValueType: this.dateFormatter(),
                billStatusShow:false,
                process_step:'',
                billStates:[],
                nextState:{},
                approval:{},
                comment:{},
                stateOptions: [],
                currentStatus: {process_step:''},
                options:[],
                showHistory:false,
                confirmShow:false,
                backWard: false,
            }
        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.searchParams.emp_id=val.emp_id;
                    this.searchParams.settlement_id=val.settlement_id;
                    this.searchParams.emp_code= val.emp_code;
                    this.searchParams.gpf_id = val.gpf_id;
                    this.searchParams.emp_name=val.emp_name;
                    this.searchParams.designation=val.designation;
                    this.searchParams.bank=val.bank;
                    this.searchParams.basic_salary=val.basic_salary;
                    this.searchParams.pf_id=val.pf_id;
                    this.searchParams.total_loan_due=val.total_loan_due;
                    this.searchParams.pf_balance=val.pf_balance;
                    this.searchParams.pf_loan_interest_due=val.pf_loan_interest_due;
                    this.searchParams.total_pf=val.total_pf;
                    this.searchParams.pf_interest=val.pf_interest;
                    this.searchParams.total_loan_amount=val.total_loan_amount;
                    this.searchParams.settlement_amt=val.settlement_amt;

                }
            },
            'searchParams.total_loan_due':function (val, oldVal) {
                this.searchParams.settlement_amt = Number(Number(this.total_pf) - Number(val)).toFixed(2)
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
            showAttachmnet(data) {
                const win = window.open("","_blank");
                let html = '';
                html += '<html>';
                html += '<body style="margin:0!important">';
                html += '<embed width="100%" height="100%" src="'+data+'"/>';
                html += '</body>';
                html += '</html>';
                setTimeout(() => {
                    win.document.write(html);
                }, 0);
            },
            hasHistoryPermission:function() {
                if (this.$store.getters.hasGrantAccess) {
                    return this.$store.getters.hasGrantAccess;
                }

                return this.$store.getters.permissions.includes('CAN_SEE_STATUS_HISTORIES');
            },
            selectApplication(item) {
                this.updateIndex=1;
                this.selectedEmployee=item;
                this.searchParams = item;
                window.scrollTo(0,0);
            },
            showWorkflowModal(id){
                this.workflowData.settlement_id = id
                this.$refs['workflow_modal'].show()
            },
            hideWorkflowModal(){

                this.workflowData.settlement_id = ''
                this.$refs['workflow_modal'].hide()
            },
            hideApprovalModal(){
                this.approveShow = false;
            },
            mapWorkflow(){
                let settle_id = this.workflowData.settlement_id
                this.workflowData.settlement_id = 'Settlement'+this.workflowData.settlement_id
                ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/providentFund/update-settlement-workflow/${settle_id}`, this.workflowData).then(res => {
                    if (res.data.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: 'Workflow Updated Successfully Done', type: 'success'});
                        this.loadSettlementData();
                    } else {
                        this.$notify({group: 'pmis', text: 'Workflow Updated Failed', type: 'error'});
                    }
                });
            },
            loadWorkflow(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/workflow_for_module/4`).then(res => {
                    this.workflowOptions = res.data.filter(item => item.work_flow_name.toUpperCase().includes('SETTLEMENT'));
                });
            },
            loadSettlementData:function() {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/providentFund/gpf/settlement/employees`).then(res => {
                        this.pfSettlementItems = res.data;
                        this.totalItems = res.data.length;
                    })
            },
            onSubmit() {
                let currObj = this;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/providentFund/gpf/settlement', this.searchParams).then(res => {
                    if (res.data.o_status_code == 1) {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.onReset();
                    } else {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            hasPermission: function(step) {
                if(step.role_yn=='Y'){
                    let hasRole = this.$store.getters.roles.filter( element => element.role_key == step.user_role);
                    return hasRole.length>0;
                } else {
                    return step.user_name == this.$store.state.user.user_name
                }

            },
            onReset() {
                // Reset our form values
                this.searchParams={},
                this.selectedEmployee={},
                this.updateIndex=-1,
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })
            },
            showModalApproval(item) {
                this.gpf = {
                    amount:'',
                    item: item,
                    object_id:'Settlement'+item.settlement_id,
                    note:''
                };
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/workflow/status/${item.approval_workflow_id}/${this.gpf.object_id}`).then(res => {
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
                state.workflow_step_id = this.workflow.workflow_step_id;
                state.target_url = window.location.pathname.substring(1)+'#'+this.$route.path
                state.message = 'GPF settlement application approval review request sent to you.'
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/workflow/status/${state.approval_workflow_id}/${this.gpf.object_id}`, state).then(res => {
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
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/gpf-settlement/final-approve/${state.approval_workflow_id}/${this.gpf.item.settlement_id}`, state).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.hideApprovalModal();
                        this.loadSettlementData();
                        this.confirmShow = false;
                        this.approveShow = false;
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
        }
    }
</script>


