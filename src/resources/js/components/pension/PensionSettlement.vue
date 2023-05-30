<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-form @submit.prevent="onSearch" @reset.prevent="onReset">
                <b-card>
                    <b-card-header header-bg-variant="dark" header-text-variant="white">Search Application</b-card-header>
                    <b-card-body class="border">
                            <b-row>
                                <b-col md="4">
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
                                <b-col md="4">
                                    <b-form-group label="DEPARTMENT" label-for="department" class="requiredField">
                                        <b-form-select
                                            id="department"
                                            v-model="formData.department_id"
                                            :options="departmentOptions"
                                            text-field="department_name"
                                            value-field="department_id"
                                            required
                                        ></b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group label="Status" label-for="status" class="requiredField">
                                        <b-form-select
                                          id="status"
                                          v-model="formData.status"
                                          :options="booleanOptions"
                                          required
                                        ></b-form-select>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        <b-row>
                            <b-col class="d-flex justify-content-end">
                                <b-form-group>
                                    <b-button-group class="mt-1">
                                        <b-button type="submit" variant="success">Search</b-button>
                                        <b-button type="reset" variant="secondary">Reset</b-button>
                                    </b-button-group>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </b-card-body>
                </b-card>
                <div>
                    <b-modal
                        id="modal-center"
                        @ok="processed()"
                         ok-title="Settlement"
                        :ok-disabled="!modalData.approved_date"
                        scrollable
                        size="xl"
                        :title="message+' '+modalData.emp_name">
<!--                        :hide-footer="!modalData.approved_date"-->
                        <b-container fluid>
                                <b-row>
                                    <b-col md="3">
                                        <b-form-group label="Employee Name" label-for="emp_name">
                                            <b-form-input
                                                id="emp_name"
                                                v-model="modalData.emp_name"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="Employee Code" label-for="emp_code">
                                            <b-form-input
                                                id="emp_code"
                                                v-model="modalData.emp_code"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="Division" label-for="division_name">
                                            <b-form-input
                                                id="division_name"
                                                v-model="modalData.division_name"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="Department" label-for="department_name">
                                            <b-form-input
                                                id="department_name"
                                                v-model="modalData.department_name"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="Designation" label-for="designation">
                                            <b-form-input
                                                id="designation"
                                                v-model="modalData.designation"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="NPS Year" label-for="nps_year">
                                            <b-form-input
                                                id="nps_year"
                                                v-model="modalData.nps_year"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="3">
                                        <b-form-group label="Joining Date" label-for="emp_join_date">
                                            <b-form-input
                                                id="emp_join_date"
                                                v-model="modalData.emp_join_date"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="LPR Date" label-for="emp_lpr_date">
                                            <b-form-input
                                                id="emp_lpr_date"
                                                v-model="modalData.emp_lpr_date"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="12" class="mb-2">
                                        <b-table
                                            :items="nomineeItems"
                                            :fields="nomineeFields"
                                            sort-icon-left
                                            bordered
                                            responsive="sm"
                                            :small="small"
                                            hover
                                            head-variant="dark"
                                            class="mt-2"
                                        >
                                            <template v-slot:cell(index)="data">
                                                {{ data.index + 1 }}
                                            </template>
                                        </b-table>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="Bank Account" label-for="emp_bank_acc_no">
                                            <b-form-input
                                                id="emp_bank_acc_no"
                                                v-model="modalData.emp_bank_acc_no"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="Bank Name" label-for="bank">
                                            <b-form-input
                                                id="bank"
                                                v-model="modalData.bank"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="Branch Name" label-for="bank_branch">
                                            <b-form-input
                                                id="bank_branch"
                                                v-model="modalData.bank_branch"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="Bill Code" label-for="bill_code">
                                            <b-form-input
                                                id="bill_code"
                                                v-model="modalData.bill_code"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="Biller Code" label-for="biller_code">
                                            <b-form-input
                                                id="biller_code"
                                                v-model="modalData.biller_code"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="Grade" label-for="emp_grade_id">
                                            <b-form-input
                                                id="emp_grade_id"
                                                v-model="modalData.emp_grade_id"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="Grade Step" label-for="grade_step_id">
                                            <b-form-input
                                                id="grade_step_id"
                                                v-model="modalData.grade_step_id"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="3">
                                        <b-form-group label="Service Period" label-for="service_period">
                                            <b-form-input
                                                id="service_period"
                                                v-model="modalData.service_period"
                                                readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="Actual Service Period" label-for="actual_service_period">
                                            <b-form-input
                                              id="actual_service_period"
                                              v-model="modalData.actual_service_period"
                                              readonly
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                                <b-row class="border-top mt-1 pt-1">
                                    <b-col md="3">
                                        <b-form-group label="Last Pay Scale" label-for="last_scale">
                                                <b-form-input
                                                    id="last_scale"
                                                    v-model="modalData.last_scale"
                                                    class="text-right"
                                                    readonly
                                                ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3" >
                                        <b-form-group label="Last Basic" label-for="basic">
                                                <b-form-input
                                                    id="basic"
                                                    v-model="modalData.last_basic"
                                                    class="text-right"
                                                    readonly
                                                ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="Proposed Basic Pension" label-for="proposed_basic_pension">
                                                <b-form-input
                                                    id="proposed_basic_pension"
                                                    v-model="modalData.proposed_basic_pension"
                                                    class="text-right"
                                                    :readonly="readonly"
                                                ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="Proposed Monthly Pension" label-for="proposed_monthly_pension">
                                                <b-form-input
                                                    id="proposed_monthly_pension"
                                                    v-model="modalData.proposed_monthly_pension"
                                                    class="text-right"
                                                    :readonly="readonly"
                                                ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="Medical Allowance" label-for="medical_allowance">
                                                <b-form-input
                                                    id="medical_allowance"
                                                    v-model="modalData.medical_allowance"
                                                    class="text-right"
                                                    :readonly="readonly"
                                                ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="Monthly Net Amount" label-for="pension_allowance">
                                                <b-form-input
                                                    id="pension_allowance"
                                                    v-model="modalData.pension_allowance"
                                                    class="text-right"
                                                    :readonly="readonly"
                                                ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="Surrender Amount (50%)" label-for="surrender_value">
                                                <b-form-input
                                                    id="surrender_value"
                                                    v-model="modalData.surrender_value_fifty_pct"
                                                    class="text-right"
                                                    :readonly="readonly"
                                                ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group label="Adjustment Amount" label-for="adjustment">
                                            <b-form-input
                                                id="adjustment "
                                                v-model="modalData.adjust_amount"
                                                class="text-right"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="12">
                                        <b-form-group label="Comment" label-for="comment">
                                            <b-form-textarea
                                              id="comment "
                                              v-model="modalData.comment"
                                            ></b-form-textarea>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            <b-row>
                                <b-col class="text-center">
                                    <b-badge :href="reportUrl" variant="success" block @click="printDraft(modalData.emp_code)" target="_blank">Print draft before settlement</b-badge>
                                </b-col>
                            </b-row>
                        </b-container>
                    </b-modal>
                </div>
            </b-form>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Pension Application List</b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :totalList="totalList" :perPage="perPage">
                        <template v-slot:actions="{ rows }">
                            <a v-if="rows.item.settlement_yn != 'Y'" v-b-modal.modal-center @click="renderModal(rows.item)"><i class="bx bx-edit cursor-pointer"></i></a>
                            <template v-else>Completed</template>

                        </template>
                        <template v-slot:action2="{ rows }">
                            <b-button size="sm" v-if="rows.item.approval_workflow_id==null" @click="showWorkflowModal(rows.item.pension_calculation_id)" variant="primary">WORKFLOW</b-button>
                            <b-button size="sm" variant="primary" v-if="rows.item.approval_workflow_id != null && !rows.item.approved_date" @click="showModalApproval(rows.item)" class="btn-warning">APPROVE ON GOING</b-button>
                            <b-button size="sm" variant="primary" v-if="rows.item.approval_workflow_id != null && rows.item.approved_date" @click="showModalApproval(rows.item)" class="btn-success">APPROVED</b-button>

                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>

            <b-modal v-model="approveShow" size="xl" okTitle="Submit" :hide-footer=true :hide-header=true >
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
                <b-form-select v-model="workflowData.approval_workflow_id" text-field="work_flow_name" value-field="approval_workflow_id" :options="workflowOptions"></b-form-select>
            </b-modal>
        </div>
    </div>
</template>

<script>

    import DatePicker from 'vue2-datepicker';
    import BFormDatepicker from 'bootstrap-vue'
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from '../../Repository/ApiRepository';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';


    export default {
        components: {DatePicker, Datatable, vSelect, vcss, BFormDatepicker},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension Settlement"});
            this.preLoadData();
            this.loadWorkflow()
            this.onSearch()
        },
        data() {
            return {
                workflowData: {
                    approval_workflow_id: '',
                    pension_calculation_id: ''
                },
                workflowOptions: [],
                backWard: false,
                max:25,
                workflowProcess:[],
                next_step:{},
                workflow_step_id:'',
                previous_step:{},
                current_step:{},
                show:false,
                approveShow:false,
                process_step:'',
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
                pension:{
                    emp_id:0,
                    basic_amt:0,
                    amount:0,
                    officeOrderNo:null,
                    officeOrderDate:null,
                    status: 'N',
                    percent: 5,
                    approval_workflow_id: null,
                    status_yn: '',
                    item: {}
                },
                booleanOptions: [
                    {text: 'Pending', value: 'N'},
                    {text: 'Completed', value: 'Y'}
                ],
                selectedEmployee: {},
                empIdList: [],
                departmentOptions:[],
                reportParams: {
                    xdo: '/~weblogic/Pension/pension_cal_settle.xdo',
                    type: "pdf",
                    p_emp_code: '',
                    filename: 'Pension Settlement and Calculation'
                },

                reportUrl: '',
                totalNominee:0,
                small: true,
                nomineeItems:[],
                formData: {
                    department_id: null,
                    emp_id: null,
                    status: 'N'
                },
                modalData:{
                    adjust_amount:'',
                    emp_code:'',
                    comment: ''
                },
                readonly:false,
                disabledRadio:false,
                UpdateBtnhidden:false,
                ProcessBtnhidden:false,
                message:'',
                totalList:null,
                perPage:5,
                nomineeFields: [
                    {key:'index', label:'SL', sortable:true, class:'text-center'},
                    {key:'nominee_name', label: 'Nominee Name', sortable:true},
                    {key:'relationship', label: 'Relationship', sortable:true},
                    {key:'percentage', label: 'Percentage', sortable:true},
                ],
                tableData: {
                    fields: [
                        {key: 'index', label: 'SL', class: 'text-center'},
                        {key: 'emp_code', label: 'Employee Code ', sortable: true, class: 'text-left'},
                        {key: 'emp_name', label: 'Name', class: 'text-left'},
                        {key: 'department_name', label: 'Department'},
                        {key: 'designation', label: 'Designation', sortable: true},
                        {key: 'pension_allowance', label: 'Monthly Net Amount', sortable: true,class: 'text-left'},
                        {key: 'surrender_value_fifty_pct', label: 'Pension Amount', sortable: true, class: 'text-left'},
                        {key: 'apps_date', label: 'Application Date', sortable: true, class: 'text-left'},
                        {key: 'action2', label: 'Status'},
                        'action'],
                    items: [],
                }
            }
        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val) {
                    this.formData.emp_code = val.emp_code;
                    this.formData.emp_id = val.emp_id;
                    this.formData.department_id = val.dpt_department_id;
                    this.formData.designation_id = val.designation_id;
                    this.formData.apps_id=val.apps_id;
                } else {
                    this.formData.emp_id = null
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
            // workflow start
            loadWorkflow(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/workflow_for_module/5`).then(res => {
                    this.workflowOptions = res.data
                });
            },
            mapWorkflow(){
                let pension_calculation_id = this.workflowData.pension_calculation_id
                this.workflowData.pension_calculation_id = 'PENSIONCAL'+this.workflowData.pension_calculation_id
                ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/pension/update-workflow-id/${pension_calculation_id}`, this.workflowData).then(res => {
                    if (res.data.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: 'Workflow Updated Successfully Done', type: 'success'});
                        this.onSearch();
                        this.authorizedDepartments()
                    } else {
                        this.$notify({group: 'pmis', text: 'Workflow Updated Failed', type: 'error'});
                    }
                });
            },
            hideApprovalModal(){
                this.approveShow = false;
            },
            showModalApproval(item) {
                this.pension = {
                    amount:'',
                    pension_calculation_id:'PENSIONCAL'+item.pension_calculation_id,
                    note:'',
                    item: item
                };
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/workflow/status/${item.approval_workflow_id}/${this.pension.pension_calculation_id}`).then(res => {
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
            addState: function(state) {
                state.workflow_object_id = (this.next_step)?this.next_step.approval_workflow_id:this.current_step.approval_workflow_id;
                state.note = this.workflow.note;
                state.workflow_step_id = this.workflow.workflow_step_id;
                state.target_url = window.location.pathname.substring(1)+'#'+this.$route.path
                state.message = 'Pension application submitted by '+this.pension.item.emp_name+'('+this.pension.item.emp_code+')'+'. Approval review request sent to you.'
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/workflow/status/${state.approval_workflow_id}/${this.pension.pension_calculation_id}`, state).then(res => {
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
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/process-cal-final-approval/${state.approval_workflow_id}/${this.pension.item.pension_calculation_id}`, state).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.hideApprovalModal();
                        this.onSearch();
                        this.confirmShow = false;
                        this.approveShow = false;
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
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
            hasHistoryPermission:function() {
                if (this.$store.getters.hasGrantAccess) {
                    return this.$store.getters.hasGrantAccess;
                }

                return this.$store.getters.permissions.includes('CAN_SEE_STATUS_HISTORIES');
            },
            showWorkflowModal(id){
                this.workflowData.pension_calculation_id = id
                this.$refs['workflow_modal'].show()
            },
            hideWorkflowModal(){
                this.workflowData.pension_calculation_id = ''
                this.$refs['workflow_modal'].hide()
            },
            // workflow end
            onSearch() {
                let data=this.formData;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/search-pension-settlement-data-list`, data).then(res => {
                    this.tableData.items = res.data;
                    this.totalList=res.data.length;
                });
            },
            renderModal(item) {
                this.message='Pension Settlement For';
                this.modalData = item;
                this.readonly=true;
                this.disabledRadio=true;
                this.UpdateBtnHidden=true;
                this.ProcessBtnHidden=false;
                this.loadNominee(this.modalData.emp_id);
            },

            processed() {
                if(confirm("Do you really want to settlement the application?")){
                    this.modalData.settlement_yn='Y';
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/pension-settlement`,this.modalData).then(res => {
                        console.log(res.data);
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            this.onSearch();
                            this.modalData={};
                            this.selectedEmployee=[];
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                }
            },

            printDraft(i) {
                // let title='Prl-notice'
                this.reportParams.p_emp_code =i;
                let params = this.reportParams;
                let queryString = Object.keys(params).map(function (key) {
                    return key + "=" + params[key]
                }).join('&');
                this.reportUrl = '/report/render/settlement_draft?' + queryString;
            },

            onReset() {
                this.formData={};
                this.selectedEmployee=[];
                this.tableData.items=[];
            },
            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/search-pension-empcode/${id}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            preLoadData(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/operation/promotions/form-data').then(res => {
                    this.departmentOptions = res.data.departments;
                });
            },
            loadNominee: function(id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/applications/nominee/${id}`).then(res => {
                    this.nomineeItems = res.data;
                    this.totalNominee=res.data.length;
                    console.log(res.data);
                });
            },

        }
    }
</script>

