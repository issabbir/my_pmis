<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-form   @submit.prevent="onSearchData"  @reset.prevent="onReset">
                <b-card>
                    <b-card-header header-bg-variant="dark" header-text-variant="white">PF Applications</b-card-header>
                    <b-card-body class="border">
                        <b-row>
                            <b-col md="8">
                                <label for="emp_code">Employee Code</label>
                                <v-select
                                    label="option_name"
                                    v-model="selectedEmployee"
                                    :options="empIdList"
                                    @search="searchempcods"
                                    id="emp_code">
                                </v-select>
                            </b-col>
<!--                            <b-col md="3">-->
<!--                                <label for="departmentID">Department</label>-->
<!--                                <b-form-select id="departmentID" v-model="employeeSearch.department" required-->
<!--                                            :options="departmentList"></b-form-select>-->
<!--                            </b-col>-->
<!--                            <b-col md="3">-->
<!--                                <label for="section">Section</label>-->
<!--                                <b-form-select id="section" v-model="employeeSearch.section"-->
<!--                                            :options="sectionList"></b-form-select>-->
<!--                            </b-col>-->

                            <b-col md="4">
                                <label for="status">Pf Status</label>
                                <b-form-select id="status" v-model="employeeSearch.status"
                                            :options="status"></b-form-select>
                            </b-col>
                        </b-row>
                        <b-row class="mt-2">
                            <b-col class="d-flex justify-content-start">
                                <b-button type="button" variant="primary" @click="showModal"  >Add new</b-button>
                            </b-col>
                            <b-col class="d-flex justify-content-end">
                                <b-button-group>
                                    <b-button type="submit" variant="success">Search</b-button>
                                    <b-button type="reset" variant="secondary" >Reset</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>
                    </b-card-body>
                </b-card>
            </b-form>

            <b-modal v-model="show" size="xl"   :ok-disabled="(gpf.approval_workflow_id==null || gpf.status_yn == 'Y')?false:true"  okTitle="Submit"  :hide-header=true @ok="addSubmit">
                 <b-row >
                    <b-col>
                        <h4>Add New</h4>
                    </b-col>
                    <b-col class="d-flex justify-content-end">
                        <b-button size="sm" variant="outline-secondary" @click="hide()">Close</b-button>
                    </b-col>
                </b-row>

                <b-row class="border rounded mt-2">
                    <b-col md="6">
                        <b-form-group
                            class="pt-2 requiredField"
                            id="input-gpf"
                            label="GPF ID"
                            label-for="input-gpf-id"
                        >
                            <b-form-input
                                id="input-gpf-id"
                                v-model="gpf.gpf_id"
                                :disabled="gpf.status_yn == 'Y'"
                                type="text"
                                class="text-left"
                                required
                            ></b-form-input>
                        </b-form-group>
                            <b-form-group
                                class="pt-2 requiredField"
                                id="input-employee"
                                label="Employee"
                                label-for="employee"
                            >
                                <v-select
                                        label="option_name"
                                        v-model="newSelectedEmployee"
                                        :options="nonEmpIdList"
                                        @search="searchNonEmps" required>
                                    <template #search="{attributes, events}">
                                        <input
                                            class="vs__search"
                                            :required="!gpf.emp_id"
                                            v-bind="attributes"
                                            v-on="events"
                                        />
                                    </template>
                                </v-select>
                            </b-form-group>
                        <b-form-group
                                id="input-gpf-percent"
                                label="GPF Percentage"
                                label-for="input-gpf-percent"
                                description="Percentage minimum 5% and maximum 25% "
                        >
                            <b-form-input
                                    id="input-gpf-percent" :max="25" :maxlength="5" :min="5"
                                    v-model="gpf.percent" @keyup="calAmount(gpf.percent)"
                            ></b-form-input>
                            <span v-if="gpf.percent>25" style="color:red">Percentage cannot exceed 25</span>
                            <span v-if="gpf.percent<5" style="color:red">Percentage cannot less than 5</span>
                        </b-form-group>
                        <b-form-group
                                id="input-gpf"
                                label="GPF Amount"
                                label-for="input-gpf-amount"
                        >
                            <b-form-input
                                    id="input-gpf-amount"
                                    v-model="gpf.amount" readonly
                                    type="text"
                                    class="text-right"
                            ></b-form-input>
                        </b-form-group>
                        <b-form-group
                            id="input-gpf"
                            label="GPF Interest"
                            label-for="input-gpf-amount"
                        >
                            <b-form-radio-group
                                v-model="gpf.on_gpf_interest_yn"
                                :options="optionsInterest"
                                class="mt-1"
                                disabled-field="notEnabled"
                                name="on_gpf_interest_yn"
                                id="on_gpf_interest_yn"
                            ></b-form-radio-group>
                        </b-form-group>
                       <!-- <b-form-group
                                id="input-group-12"
                                label="Office Order No:"
                                label-for="input-2"
                        >
                            <b-form-input
                                    id="input-2"
                                    v-model="gpf.officeOrderNo"
                                    type="text"
                            ></b-form-input>
                        </b-form-group>
                            <b-form-group
                                    id="input-group-3"
                                    label="Office Order Date:"
                                    label-for="input-3"
                            >
                            <date-picker
                                v-model="gpf.officeOrderDate"
                                width="100%"
                                input-class="form-control"
                                lang="en"
                                format="DD-MM-YYYY"
                                id="input-3"
                            ></date-picker>
                        </b-form-group>-->
                        <input type="hidden" v-model="gpf.status" value="N" />
                    </b-col>
                    <b-col md="6">
                        <b-table stacked :items="emps" :fields="empFields"></b-table>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        <b-table :small="true" :items="nominees" :fields="nomineeFields">
                            <template #cell(action)="row">
                                <b-link v-if="row.item.emp_family.auth_attachment" @click="showAttachment(row.item.emp_family.auth_attachment)">
                                    <i class="bx bx-download cursor-pointer"></i>
                                </b-link>
                            </template>
                        </b-table>
                    </b-col>
                </b-row>
            </b-modal>

            <b-modal v-model="approveShow" size="xl" okTitle="Submit" :hide-footer=true :hide-header=true @ok="addSubmit">
                <b-row >
                    <b-col>
                        <h4>{{'Provident fund application approval process'}}</h4>
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
                <b-form-select v-model="workflowData.approval_workflow_id" text-field="work_flow_name"  value-field="approval_workflow_id" :options="workflowOptions"></b-form-select>
            </b-modal>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Application List</b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="fields" :totalList="totalList" :perPage="perPage" v-bind:items="items" v-bind:pageColSize="4" v-bind:searchColSize="5">
                        <template v-slot:action2="{ rows }">
                            <b-button size="sm" variant="primary" v-if="(rows.item.status_yn=='N' ||rows.item.status_yn==undefined) && rows.item.approval_workflow_id != null" @click="showModalApproval(rows.item)">APPROVE</b-button>
                            <b-button size="sm" @click="selectEmp(rows.item)" variant="primary">{{(rows.item.approval_workflow_id==null || rows.item.status_yn == 'Y')?'EDIT':'VIEW'}}</b-button>
                            <b-button size="sm" v-if="rows.item.approval_workflow_id==null" @click="showWorkflowModal(rows.item.gpf_id)" variant="primary">WORKFLOW</b-button>
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
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";

    export default {
        components: {DatePicker, Datatable, Vue, vSelect, vcss},
        data() {
            return {
                workflowData: {
                    approval_workflow_id: '',
                    gpf_id: ''
                },
                workflowOptions: [],
                backWard: false,
                max:25,
                pfemployee:{},
                workflowProcess:[],
                next_step:{},
                workflow_step_id:'',
                previous_step:{},
                current_step:{},
                show:false,
                approveShow:false,
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
                workflow:{
                    workflow_step_id:'',
                    note:''
                },
                selectedInterest : 'Y',
                gpf:{
                    app_id:'',
                    gpf_id:'',
                    emp_id:0,
                    basic_amt:0,
                    amount:0,
                    officeOrderNo:null,
                    officeOrderDate:null,
                    status: 'N',
                    on_gpf_interest_yn: 'Y',
                    percent: 5,
                    approval_workflow_id: null,
                    status_yn: '',
                    item: {}
                },
                optionsInterest: [
                    { value: 'Y', text: 'Yes' },
                    { value: 'N', text: 'No' },
                ],
                employeeSearch:{
                    status: 'N',
                    emp_id: '',
                    emp_code: '',
                    emp_name: '',
                    department: null
                },
                empIdList: [],
                nonEmpIdList:[],
                dateValueType: this.dateFormatter(),
                selectedEmployee: {},
                newSelectedEmployee:{
                    basic_amt:0
                },
                departmentList: [],
                sectionList: [],
                status: [
                    {text: 'All', value: ''},
                    {text: 'Approved', value: 'Y'},
                    {text: 'Not Approved', value: 'N'}],
                perPage: 5,
                emps: [],
                empFields: [
                    {key:'emp_name',label:'Employee Name'},
                    {key:'emp_code',label:'Employee Code'},
                    'designation',
                    {key:'department_name',label:'Department'},
                    {key:'basic_amt',label:'Basic Amount'}
                    ],
                totalList: 0,
                fields: [{key: 'index', sortable: true, label: 'Sl',},
                    {key: 'emp_code', sortable: true},
                    {key: 'emp_name', sortable: true},
                    {key: 'department_name', sortable: true, label: 'Department'},
                    {key: 'designation', sortable: true, label: 'Designation'},
                    {key: 'gpf_status', sortable: true, label: 'PF Status'},
                    {key: 'action2',  label: 'Action', class: 'text-right'}
                ],
                items: [],
                nominees: [],
                nomineeFields: [
                    {key: 'nominee_name', sortable: true},
                    {key: 'relationship.text', label: 'Relationship', sortable: true},
                    {
                        key: 'autistic_yn',
                        formatter: (value) => {
                            if(value == 'Y'){
                                return 'YES'
                            } else if(value == 'N'){
                                return 'NO'
                            } else {
                                return ''
                            }
                        },
                        label: 'Autistic',
                        sortable: true},
                    {key: 'percentage'},
                    {key: 'action', class: 'text-center'}
                ]
            }
        },
        watch: {
            // selectedInterest: function (val, oldVal) {
            //         this.gpf.on_gpf_interest_yn = val;
            // },
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.employeeSearch.emp_code = val.emp_code;
                    this.employeeSearch.department=val.dpt_department_id;
                    this.employeeSearch.department_name=val.department_name;
                }
            },
            newSelectedEmployee: function(val) {
                if (val !== null || val!=undefined || val!='') {
                    this.loadNominee(val.emp_id)
                    this.pfemployee.emp_code = val.emp_code;
                    this.emps= [];
                    this.emps.push(val);
                    if(val.basic_amt == null || val.basic_amt==''|| val.basic_amt==undefined){
                        this.gpf.basic_amt=0;
                    }else{
                        this.gpf.basic_amt=parseFloat(val.basic_amt);
                    }
                    if(val.gpf_pct == null || val.gpf_pct==''|| val.gpf_pct==undefined){
                        this.gpf.percent=5;
                    } else {
                        this.gpf.percent=val.gpf_pct;
                    }
                    this.calAmount(this.gpf.percent)
                    // this.gpf.percent=(val.gpf_pct == null || val.gpf_pct==''||val.gpf_pct==undefined) ? 0 : parseFloat(val.gpf_pct);
                    // this.gpf.amount = (this.gpf.basic_amt*this.gpf.percent)/100?(this.gpf.basic_amt*this.gpf.percent)/100:0;
                }
            },
            "gpf.percent":function (val, oldVal) {
                this.calAmount(val)
            }
        },
        computed: {
            splicedOptions: function () {
                return this.options.slice(0,-1)
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Provident Fund"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "GPF Application"});
            this.allDatalistShow()
            this.authorizedDepartments()
            let department = this.$route.query.department;
            if (department && (department !== undefined)) {
                this.onSearchData();
            }
            this.loadWorkflow();
        },

        methods: {
            nomineeApprove() {
            },
            allDatalistShow() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/overtime/ot-actuals').then(res => {
                    this.sectionList = res.data.sections;
                });
            },
            loadNominee(id) {
                if(id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/nominees/specific/gpf/${id}`).then(res => {
                        this.nominees = res.data.data;
                    });
                }
            },
            authorizedDepartments() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/departments').then(res => {
                    this.departmentList = res.data.departments
                    /*this.employeeSearch.department = res.data.department_id*/
                    this.employeeSearch.status = 'N'
                    this.onSearchData()
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
            hasHistoryPermission:function() {
                if (this.$store.getters.hasGrantAccess) {
                    return this.$store.getters.hasGrantAccess;
                }

                return this.$store.getters.permissions.includes('CAN_SEE_STATUS_HISTORIES');
            },
            hideApprovalModal(){
                this.approveShow = false;
            },
            addState: function(state) {
                state.workflow_object_id = (this.next_step)?this.next_step.approval_workflow_id:this.current_step.approval_workflow_id;
                state.note = this.workflow.note;
                state.workflow_step_id = this.workflow.workflow_step_id;
                state.target_url = window.location.pathname.substring(1)+'#'+this.$route.path
                state.message = 'GPF application submitted by '+this.gpf.item.emp_name+'('+this.gpf.item.emp_code+')'+'. Approval review request sent to you.'
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/workflow/status/${state.approval_workflow_id}/${this.gpf.gpf_id}`, state).then(res => {
                    this.workflowProcess = res.data.workflowProcess;
                    this.next_step = res.data.next_step;
                    if (this.next_step)
                        this.workflow_step_id = this.next_step.workflow_step_id;
                    this.previous_step = res.data.previous_step;
                    this.current_step = res.data.current_step;
                    this.options = res.data.options;
                    this.workflow.note = ''
                    this.backWard = false
                });
            },
            finalApproved: function() {
                let state = (this.next_step)?this.next_step:this.current_step;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/gpf/final-approve/${state.approval_workflow_id}/${this.gpf.item.gpf_id}`, state).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.hideApprovalModal();
                        this.onSearchData();
                        this.confirmShow = false;
                        this.approveShow = false;
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            searchempcods(id) {
                if (id) {
                    this.employeeSearch.department=0;
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/providentFund/search-employees/${id}/${this.employeeSearch.department}`).then(res => {
                        this.empIdList = res.data;
                    });
                }
            },
            searchNonEmps(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/providentFund/non-pf-employees/${id}`).then(res => {
                        this.nonEmpIdList = res.data;
                    })
                }
            },
            addSubmit(bvModalEvt) {
                this.gpf.emp_id = this.newSelectedEmployee.emp_id;
                bvModalEvt.preventDefault();
                this.gpf.percent = parseFloat(this.gpf.percent);
                this.gpf.officeOrderDate = moment(this.gpf.officeOrderDate).format('YYYY-MM-DD');
                // this.gpf.on_gpf_interest_yn = this.selectedInterest;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/providentFund/employees/add`, this.gpf).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.onSearchData();
                        this.show = false;
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                })
            },
            showAttachment(order_attachment) {
                const win = window.open("","_blank");
                let html = '';
                html += '<html>';
                html += '<body style="margin:0!important">';
                html += '<embed width="100%" height="100%" src="'+order_attachment+'"/>';
                html += '</body>';
                html += '</html>';
                setTimeout(() => {
                    win.document.write(html);
                }, 0);

            },
            onSearchData() {
                let currObj = this;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/providentFund/search-pf-employees',this.employeeSearch).then(res => {
                    if (res.data.pfEmployees.length > 0) {
                        if (res.data.status) {
                            this.items = res.data.pfEmployees;
                        } else {
                            this.items = [];
                        }
                    } else {
                        this.items = [];
                        //currObj.$notify({group: 'pmis', text: 'Sorry! No data found', type: 'error'});
                    }
                    this.totalList = res.data.pfEmployees.length;
                    return;
                });
            },
            actualTimeStatusUpdate() {
                let currObj = this;
                let param = this.tableDataAllowancs.items;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-actuals-status', param).then(res => {
                    if (res.data.o_status_code == 1) {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.onSearchData();
                    } else {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
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
            onReset() {
                this.show = false;
                this.$nextTick(() => {
                    this.employeeSearch = {};
                    this.selectedEmployee = null;
                    if(this.items){
                        this.items =[];
                        this.totalList='';
                    }
                })
            },
            showModal() {
                this.gpf={
                    amount:'',
                    basic_amt:'',
                    gpf_id:'',
                    officeOrderDate:'',
                    officeOrderNo:'',
                    percent:5,
                    status:'N'
                };
                this.newSelectedEmployee={};
                this.emps = [];
                this.show = true;
            },
            showModalApproval(item) {
                this.gpf = {
                    amount:'',
                    gpf_id:'GPF'+item.gpf_id,
                    note:'',
                    item: item
                };
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/workflow/status/${item.approval_workflow_id}/${this.gpf.gpf_id}`).then(res => {
                    this.workflowProcess = res.data.workflowProcess;
                    this.next_step = res.data.next_step;
                    if (this.next_step)
                        this.workflow_step_id = this.next_step.workflow_step_id;
                    this.previous_step = res.data.previous_step;
                    this.current_step = res.data.current_step;
                    this.options = res.data.options;
                    this.approveShow = true;
                    this.workflow.workflow_step_id = this.next_step.workflow_step_id;
                });
            },
            calAmount(val) {
                let percent =parseFloat(val);
                this.gpf.amount = (parseFloat(this.gpf.basic_amt)*percent)/100;
            },
            selectEmp(item) {
                this.newSelectedEmployee = item;
                this.gpf.status = item.status_yn;
                this.gpf.approval_workflow_id = item.approval_workflow_id;
                this.gpf.app_id = item.app_id;
                this.gpf.gpf_id = item.gpf_id;
                this.gpf.percent = item.gpf_pct;
                this.gpf.amount = item.gpf_amount;
                this.gpf.officeOrderNo = item.office_order_no;
                this.gpf.officeOrderDate = item.office_order_date;
                this.gpf.status_yn = item.status_yn;
                this.gpf.on_gpf_interest_yn = item.on_gpf_interest_yn;
                this.show = true;
            },

            showWorkflowModal(id){
                this.workflowData.gpf_id = id
                this.$refs['workflow_modal'].show()
            },
            hideWorkflowModal(){
                this.workflowData.gpf_id = ''
                this.$refs['workflow_modal'].hide()
            },
            mapWorkflow(){
                let gpf_id = this.workflowData.gpf_id
                this.workflowData.gpf_id = 'GPF'+this.workflowData.gpf_id
                ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/providentFund/update-workflow-id/${gpf_id}`, this.workflowData).then(res => {
                    if (res.data.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: 'Workflow Updated Successfully Done', type: 'success'});
                        this.onSearchData();
                        this.authorizedDepartments()
                    } else {
                        this.$notify({group: 'pmis', text: 'Workflow Updated Failed', type: 'error'});
                    }
                });
            },
            loadWorkflow(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/workflow_for_module/4`).then(res => {
                    this.workflowOptions = res.data.filter(item => item.work_flow_name == 'PF NEW SUB APPROVAL');
                });
            },
            hide() {
                this.show=false;
                this.nominees = []
                this.nonEmpIdList = []
                this.approveShow=false;
            }
        },
        filters: {
            dateFormat: function(value) {
                if (value) {
                    return moment(String(value)).format('MM/DD/YYYY hh:mm')
                }
            }
        },
    };
</script>

<style scope>
    .table td {

    }
</style>

