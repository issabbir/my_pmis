<script src="../../../routes/loan.js"></script>
<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>

                <b-card-header header-bg-variant="dark" header-text-variant="white">Apply for GPF/CPF Loan</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-form-input v-model="updateIndex" required id="input-update-index" type="text"
                                        :style="{'display':'none'}"></b-form-input>

                        <b-row>
                            <b-col md="3" :style="loanApplication.application_id?'pointer-events:none':''">
                                <b-form-group
                                    label="Employee Code"
                                    label-for="emp_code"
                                >
                                    <v-select
                                        id="emp_code"
                                        label="option_name"
                                        v-model="selectedEmployee"
                                        :options="empIdList"
                                        @search="searchEmployees"
                                    >
                                        <template #selected-option="{ emp_code }">
                                            <div style="display: flex; align-items: baseline;">
                                                {{ emp_code }}
                                            </div>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Employee Name"
                                    label-for="emp_name"
                                >
                                    <b-form-input id="emp_name" v-model="loanApplication.emp_name" disabled></b-form-input>
                                </b-form-group>

                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Designation"
                                    label-for="Designation"
                                >
                                    <b-form-input id="Designation" v-model="loanApplication.designation" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Department"
                                    label-for="Department"
                                >
                                    <b-form-input id="Department" v-model="loanApplication.department_name" disabled></b-form-input>
                                </b-form-group>

                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Section"
                                    label-for="Section"
                                >
                                    <b-form-input id="Section" v-model="loanApplication.dpt_section" disabled></b-form-input>
                                </b-form-group>

                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="CPF/GPF No"
                                    label-for="gpf_id"
                                >
                                    <b-form-input id="gpf_id" v-model="loanApplication.gpf_id" disabled></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Bill Code"
                                    label-for="bill_code"
                                >
                                    <b-form-input id="bill_code" v-model="loanApplication.bill_code" disabled></b-form-input>
                                </b-form-group>

                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Bank Account Number"
                                    label-for="emp_bank_acc_no"
                                >
                                    <b-form-input id="emp_bank_acc_no" v-model="loanApplication.emp_bank_acc_no" disabled></b-form-input>
                                </b-form-group>

                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="PF Total Amount"
                                    label-for="balance"
                                >
                                    <b-input-group prepend="৳">
                                        <b-form-input id="balance" v-model="loanApplication.balance" disabled class="text-right"></b-form-input>
                                    </b-input-group>
                                </b-form-group>

                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Maximum Amount"
                                    label-for="maximum_amount_formatted"
                                >
                                    <b-input-group prepend="৳">
                                        <b-form-input id="maximum_amount_formatted" v-model="loanApplication.maximum_amount_formatted" disabled class="text-right"></b-form-input>
                                    </b-input-group>
                                </b-form-group>

                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Previous Loan Amount"
                                    label-for="previous_loan_amount"
                                >
                                    <b-input-group prepend="৳">
                                        <b-form-input id="previous_loan_amount" v-model="loanApplication.previous_loan_amount" disabled class="text-right"></b-form-input>
                                    </b-input-group>

                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Applied Amount"
                                    label-for="application_amt"
                                    class="requiredField"
                                >
                                    <b-input-group prepend="৳">
                                        <b-form-input :disabled="loanApplication.application_id?true:false" v-model="loanApplication.application_amt" number id="application_amt" class="text-right"></b-form-input>
                                    </b-input-group>

                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Applied Installment"
                                    label-for="installment_no"
                                    class="requiredField"
                                >
                                    <b-form-select id="installment_no"  v-model="loanApplication.installment_no"
                                                   :options="appInstlmntList" ></b-form-select>
                                </b-form-group>
                            </b-col>

                            <b-col md="3">
                                <b-form-group
                                    label="Interest Rate"
                                    label-for="rate_of_interest"
                                >
                                    <b-form-input id="rate_of_interest" disabled :value="loanApplication.rate_of_interest+'%'" number></b-form-input>

                                </b-form-group>
                            </b-col>
                            <!--<b-col md="4">
                                <b-form-group>
                                    <b-row style="pointer-events: none">
                                        <b-col md="4">
                                            <label>Loan Type</label>
                                        </b-col>
                                        <b-col md="8">
                                            <b-form-select v-model="loanApplication.loan_type_id" text-field="loan_name" value-field="loan_type_id" :options="loanTypes"></b-form-select>
                                        </b-col>
                                    </b-row>
                                </b-form-group>
                            </b-col>-->

                            <b-col md="3">
                                <b-form-group
                                    label="Description"
                                    label-for="Description"
                                >
                                    <b-form-textarea id="Description" rows="1" :disabled="loanApplication.application_id?true:false" v-model="loanApplication.description"></b-form-textarea>
                                </b-form-group>
                            </b-col>
                            <b-col md="3" v-if="false">
                                <b-form-group
                                    label="Attachment"
                                    label-for="Attachment"
                                >
                                    <b-form-file id="Attachment" rows="1" v-model="loanApplication.attachment" drop-placeholder="Drop file here..."></b-form-file>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Reason"
                                    label-for="Reason"
                                >
                                    <b-form-textarea id="Reason" :disabled="loanApplication.application_id?true:false" v-model="loanApplication.reason" ></b-form-textarea>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col class="mt-2 d-flex justify-content-end">
                                <b-button  md="6" size="md" variant="primary" type="submit">Apply</b-button>&nbsp;
                                <b-button md="6" size="md" variant="secondary" type="reset">Reset</b-button>

                            </b-col>
                        </b-row>
                        <!--</fieldset>-->
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">GPF/CPF Loan Lists</b-card-header>
                <b-card-body class="border">
                    <Datatable  v-bind:fields="columns" :totalList="totalItems" perPage="10" v-bind:items="listItems"  :primaryKeyColumnName="'application_id'">
                        <template v-slot:action2="{ rows }">
                            <b-button size="sm" variant="primary" @click="showDetailModal(rows.item)">VIEW</b-button>
                            <b-button size="sm" @click="selectLoan(rows.item)" variant="success" v-if="rows.item.approval_yn == 'Y'">EDIT</b-button>
                            <b-button size="sm" v-if="rows.item.approval_yn=='N' && rows.item.approval_workflow_id != null" @click="showModalApproval(rows.item)" variant="primary">Approve</b-button>
                            <b-button size="sm" v-if="rows.item.approval_workflow_id==null" @click="showWorkflowModal(rows.item.application_id)" variant="primary">WORKFLOW</b-button>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
            <b-modal v-model="approveShow" size="xl" okTitle="Submit" :hide-footer=true :hide-header=true >
                <b-row >
                    <b-col>
                        <h4>{{'GPF loan application approval process'}}</h4>
                    </b-col>
                    <b-col class="d-flex justify-content-end">
                        <b-button size="sm" variant="outline-secondary" @click="hideApprovalModal()">Close</b-button>
                    </b-col>
                </b-row>
                <b-row  class="border mb-1 pt-1 pb-1 mt-2">
                    <b-col>
                        <h5>Process Step</h5>
                        <b-progress :value="current_step.process_step*33.33"  variant="success" key="success"></b-progress>
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
            <b-modal ref="detail_modal" title="GPF Loan Application Details" no-close-on-backdrop hide-footer size="xl">
                <div class="d-block text-center">
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Employee Code"
                                label-for="emp_code"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="modalData.emp_code" disabled id="emp_code"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Employee Name"
                                label-for="emp_name"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="modalData.emp_name" disabled id="emp_name"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Designation"
                                label-for="designation"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="modalData.designation" disabled id="designation"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Department"
                                label-for="department_name"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="modalData.department_name" disabled id="department_name"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Section"
                                label-for="section_name"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="modalData.section_name" disabled id="section_name"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="GPF NO."
                                label-for="gpf_id"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="modalData.gpf_id" disabled id="gpf_id"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Bill Code"
                                label-for="bill_code"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="modalData.bill_code" disabled id="bill_code"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Bank Account Number"
                                label-for="emp_bank_acc_no"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="modalData.emp_bank_acc_no" disabled id="emp_bank_acc_no"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="PF Total Amount"
                                label-for="balance"
                                label-cols-md="4"
                            >
                                <b-form-input class="text-right" v-model="modalData.balance_formatted" disabled id="balance"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Maximum Amount"
                                label-for="maximum_amount"
                                label-cols-md="4"
                            >
                                <b-form-input class="text-right" v-model="modalData.maximum_amount_formatted" disabled id="maximum_amount"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Previous Loan Amount"
                                label-for="previous_loan_amount"
                                label-cols-md="4"
                            >
                                <b-form-input class="text-right" v-model="modalData.previous_loan_amount_formatted" disabled id="previous_loan_amount"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Application Amount"
                                label-for="application_amt_formatted"
                                label-cols-md="4"
                            >
                                <b-form-input class="text-right" v-model="modalData.application_amt_formatted" disabled id="application_amt_formatted"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Installment No."
                                label-for="installment_no"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="modalData.installment_no" disabled id="installment_no"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Interest Rate"
                                label-for="rate_of_interest"
                                label-cols-md="4"
                            >
                                <b-form-input :value="modalData.rate_of_interest+'%'" disabled id="rate_of_interest"></b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group
                                label="Basic Amount"
                                label-for="basic_amt"
                                label-cols-md="4"
                            >
                                <b-form-input class="text-right" v-model="modalData.basic_amt_formatted" disabled id="basic_amt"></b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group
                                label="Loan No."
                                label-for="loan_no"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="modalData.loan_no" disabled id="loan_no"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Application Date"
                                label-for="application_date"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="modalData.application_date" disabled id="application_date"></b-form-input>
                            </b-form-group>
                        </b-col>

                         <b-col md="4">
                             <b-form-group
                                 label="Approval Status"
                                 label-for="approval_status"
                                 label-cols-md="4"
                             >
                                 <b-form-input v-model="modalData.approval_status" disabled id="approval_status"></b-form-input>
                             </b-form-group>
                         </b-col>
                         <b-col md="4">
                             <b-form-group
                                 label="Loan Type"
                                 label-for="loan_type"
                                 label-cols-md="4"
                             >
                                 <b-form-input v-model="modalData.loan_type" disabled id="loan_type"></b-form-input>
                             </b-form-group>
                         </b-col>

                         <b-col md="4">
                             <b-form-group
                                 label="Disbursement Amount"
                                 label-for="disbursement_amount"
                                 label-cols-md="4"
                             >
                                 <b-form-input class="text-right" :value="modalData.disbursement_amount_formatted != '৳'?modalData.disbursement_amount_formatted: ''" disabled id="disbursement_amount"></b-form-input>
                             </b-form-group>
                         </b-col>
                         <b-col md="4">
                             <b-form-group
                                 label="Disbursement Date"
                                 label-for="disbursement_date"
                                 label-cols-md="4"
                             >
                                 <b-form-input v-model="modalData.disbursement_date" disabled id="disbursement_date"></b-form-input>
                             </b-form-group>
                         </b-col>
                         <b-col md="4">
                             <b-form-group
                                 label="Loan Status"
                                 label-for="loan_status"
                                 label-cols-md="4"
                             >
                                 <b-form-input v-model="modalData.loan_status" disabled id="loan_status"></b-form-input>
                             </b-form-group>
                         </b-col>

                        <b-col md="4">
                            <b-form-group
                                label="Reason"
                                label-for="reason"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="modalData.reason" disabled id="reason"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Description"
                                label-for="description"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="modalData.description" disabled id="description"></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </div>
            </b-modal>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from "moment";


    export default {
        components: { Datatable, Vue, vSelect, vcss},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Provident Fund"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan Application"});

            this.loadData();
            this.loadWorkflow()
        },
        computed: {
            splicedOptions: function () {
                return this.options.slice(0,-1)
            }
        },
        data() {
            return {
                gpf:{
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
                workflowData: {
                    approval_workflow_id: '',
                    application_id: ''
                },
                workflowOptions: [],
                loanApplication:{
                    rate_of_interest:5,
                    approval_status_1:0,
                    maximum_amount: '',
                    maximum_amount_formatted: '',
                    previous_loan_amount:'',
                    emp_bank_acc_no: '',
                    application_id: '',
                    gpf_id: '',
                    installment_no: 48
                },
                backWard: false,
                approveShow:false,
                showHistory:false,
                confirmShow:false,
                workflow:{
                    workflow_step_id:'',
                    note:''
                },
                workflowProcess:[],
                next_step:{},
                workflow_step_id:'',
                previous_step:{},
                current_step:{},
                process_step:'',
                billStates:[],
                nextState:{},
                approval:{},
                stateOptions: [],
                currentStatus: {process_step:''},
                options:[],
                empIdList: [],
                listItems:[],
                loanTypes:[],
                totalItems:0,
                selectedEmployee: {},
                updateIndex: -1,
                appInstlmntList: [{text: '12', value: 12}, {text: '24', value: 24},{text: '36', value: 36}, {text: '48', value: 48}],
                show: true,
                columns: [
                    {label: 'SL', key: 'index', sortable:true, class: 'seven'},
                    {label: 'Employee', key: 'option_name', sortable:true, class: 'fifteen'},
                    {label: 'Designation', key:'designation', sortable:true,  class: 'fifteen'},
                    {label: 'Loan No.', key: 'loan_no',  class: 'seven'},
                    {label: 'GPF ID', key: 'gpf_id',  class: 'seven'},
                    {label: 'App. Date', key: 'application_date', sortable:true,  class: 'seven'},
                    {label: 'Amount', key: 'application_amt_formatted', sortable: true, class:'text-right seven'},
                    {label: 'Status', key: 'approval_status', sortable:false, class: 'seven'},
                    {label: 'Loan Status', key: 'loan_status', sortable: true, class:'seven'},
                    {label: 'Action', key: 'action2', class: 'text-right twenty'}
                ],
                modalData: {
                    emp_bank_acc_no: "",
                    application_amt: "",
                    application_amt_formatted: "",
                    application_date: "",
                    application_id: "",
                    approval_status: "",
                    approval_status_1: "",
                    approval_status_2: null,
                    approval_workflow_id: null,
                    approval_yn: "",
                    balance: "",
                    basic_amt: "",
                    basic_amt_formatted: "",
                    bill_code: "11",
                    comment_status_1: null,
                    comment_status_2: null,
                    department_name: "",
                    description: null,
                    designation: "",
                    designation_id: "",
                    disbursement_amount: null,
                    disbursement_amount_formatted: null,
                    disbursement_date: null,
                    emp_code: "",
                    emp_id: "",
                    emp_name: "",
                    gpf_id: "",
                    installment_no: "",
                    loan_no: "",
                    loan_status: "",
                    loan_type: "",
                    loan_type_id: "",
                    maximum_amount: "",
                    maximum_amount_formatted: "",
                    option_name: "",
                    previous_loan_amount: "",
                    previous_loan_amount_formatted: "",
                    rate_of_interest: "",
                    reason: null,
                    section_id: null,
                    section_name: null,
                    sl: "",
                    status_1_date: null,
                    status_2_date: null,
                    workflow_process_id: null
                }
            }
        },
         watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.loanApplication.emp_code = val.emp_code
                    this.loanApplication.emp_name=  val.emp_name
                    this.loanApplication.emp_id=  val.emp_id
                    this.loanApplication.bill_code = val.bill_code
                    this.loanApplication.balance = val.balance
                    this.loanApplication.previous_loan_amount=val.previous_loan_amount
                    if (val.section_name)
                        this.loanApplication.dpt_section = val.section_name
                    if ( val.department_name)
                        this.loanApplication.department_name=  val.department_name
                    if(val.designation)
                        this.loanApplication.designation=  val.designation
                    this.loanApplication.maximum_amount=  val.maximum_amount
                    this.loanApplication.maximum_amount_formatted=  val.maximum_amount_formatted
                    this.loanApplication.emp_bank_acc_no=  val.emp_bank_acc_no
                    this.loanApplication.gpf_id = val.gpf_id
                }
            }
        },
        methods: {
            onSubmit() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/loans/pf`,this.loanApplication).then(res => {
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
            showDetailModal(item){
                this.$refs['detail_modal'].show()
                this.modalData = item
            },
            onReset() {
                this.selectedEmployee=null;
                this.loanApplication = {
                    rate_of_interest:5,
                    approval_status_1:0,
                    maximum_amount: '',
                    previous_loan_amount:'',
                    application_id: '',
                    gpf_id: ''
                }
               this.loanApplication.installment_no=null;
               this.empIdList={};
            },
            editRow(i, code) {

            },
            deleteRow(i, code) {

            },
            searchEmployees(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/providentFund/pf-employees/${id}/Y`, this.loanApplication).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            selectLoan(item) {
                this.selectedEmployee=item;
                this.loanApplication.gpf_id = item.gpf_id;
                this.loanApplication = item;
                window.scrollTo(0,0);
            },
            loadData() {
                this.loanApplication.loan_type_id = 1;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loans/pf`).then(res => {
                     this.loanTypes=res.data.loanTypes.filter(i=>i.loan_type_id==1);
                     this.listItems = res.data.pfLoans.filter(i=>i.loan_type_id==1);
                     this.totalItems = this.listItems.length
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
            hideApprovalModal(){
                this.approveShow = false;
            },
            hasHistoryPermission:function() {
                if (this.$store.getters.hasGrantAccess) {
                    return this.$store.getters.hasGrantAccess;
                }
                return this.$store.getters.permissions.includes('CAN_SEE_STATUS_HISTORIES');
            },
            showModalApproval(item) {
                this.gpf = {
                    amount:'',
                    item: item,
                    object_id:'Loan'+item.application_id,
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
                    this.workflow.workflow_step_id = res.data.next_step.workflow_step_id;
                });
            },
            hide() {
                 this.show           = false;
                this.nominees       = []
                this.nonEmpIdList   = []
                this.approveShow    = false;
            },
            showWorkflowModal(id){
                this.workflowData.application_id = id
                this.$refs['workflow_modal'].show()
            },
            hideWorkflowModal(){
                this.workflowData.application_id = ''
                this.$refs['workflow_modal'].hide()
            },
            addState: function(state) {
                state.workflow_object_id = (this.next_step)?this.next_step.approval_workflow_id:this.current_step.approval_workflow_id;
                state.note = this.workflow.note;
                state.workflow_step_id = this.workflow.workflow_step_id
                state.target_url = window.location.pathname.substring(1)+'#'+this.$route.path
                state.message = 'GPF loan application submitted by '+this.gpf.item.emp_name+'('+this.gpf.item.emp_code+')'+'. Approval review request sent to you.'
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
                ApiRepository.callApi(ApiRepository.POST_COMMAND,  `/gpf-loan/final-approve/${state.approval_workflow_id}/${this.gpf.item.application_id}`, state).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.hideApprovalModal();
                        this.loadData();
                        this.confirmShow = false;
                        this.approveShow = false;
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            mapWorkflow(){
                let app_id = this.workflowData.application_id
                this.workflowData.application_id = 'Loan'+this.workflowData.application_id
                ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/providentFund/update-loan-workflow/${app_id}`, this.workflowData).then(res => {
                    if (res.data.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: 'Workflow Updated Successfully Done', type: 'success'});
                        this.loadData();
                    } else {
                        this.$notify({group: 'pmis', text: 'Workflow Updated Failed', type: 'error'});
                    }
                });
            },
            loadWorkflow(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/workflow_for_module/4`).then(res => {
                    this.workflowOptions = res.data.filter(item => item.work_flow_name == 'PF LOAN APPROVAL');
                });
            }
        },
        filters: {
            dateFormat: function(value) {
                if (value) {
                    return moment(String(value)).format('MM/DD/YYYY hh:mm')
                }
            }
        },
    }
</script>

<style>


    .ten {
        width: 10%;
    }
    .seven {
        width: 7%;
    }
    .fifteen {
        width: 15%;
    }
    .twenty {
        width: 20%;
    }
    .eight {
        width: 8%;
    }
</style>
