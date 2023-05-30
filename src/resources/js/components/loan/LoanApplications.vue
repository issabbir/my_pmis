<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Apply for Loan</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-form-input v-model="updateIndex" required id="input-update-index" type="text"
                                      :style="{'display':'none'}"></b-form-input>
                        <b-row>
                            <b-col md="4">
                                <b-form-group label="Loan Type" label-for="loan_type" class="required">
                                    <b-form-select
                                        id="loan_type"
                                        v-model="loanApplication.loan_type_id"
                                        text-field="loan_name"
                                        value-field="loan_type_id"
                                        :options="loanTypes"
                                        required
                                        @change="loanTypeChange(loanApplication.loan_type_id)">
                                    </b-form-select>
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
                                <b-form-group label="Section" label-for="Section">
                                    <b-form-input id="Section" v-model="loanApplication.dpt_section"
                                                  readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Applied Amount(TK)" label-for="application_amt" class="required">
                                    <b-form-input
                                        v-if="visible === true"
                                        @input="handleChange(loanApplication.application_amt)"
                                        @blur="onBlurNumber" type="number"
                                        v-model="loanApplication.application_amt"
                                        number
                                        id="application_amt"
                                        class="text-right"
                                        required>

                                    </b-form-input>
                                    <b-form-input v-if="visible === false" @focus="onFocusText" type="text"
                                                  v-model="formattedData"  number id="application_amt" class="text-right"
                                                  required></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Applied Installment" label-for="application_installment"
                                              class="required">
                                    <b-form-select v-model="loanApplication.installment_no" @change="approximateAmt" id="application_installment"
                                                   :options="appInstlmntList" required></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Interest Rate" label-for="interest">
                                    <b-form-input v-model="loanApplication.rate_of_interest" number class="text-right"
                                                  id="interest" readonly></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Approximate installment amount" label-for="interest">
                                    <b-form-input v-model="loanApplication.approx_installment_amount" number class="text-right"
                                                  id="approx_installment_amount"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Reason" label-for="Reason">
                                    <b-form-textarea v-model="loanApplication.reason" id="Reason"></b-form-textarea>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Description" label-for="Description" class="required">
                                    <b-form-textarea v-model="loanApplication.description" id="Description"
                                                     required></b-form-textarea>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col>
                                <b-card class="border">
                                    <b-card-title >
                                        Guarantors
                                        <b-button type='button' size="sm" class="btn btn-info float-right" @click="addNewRow"><i class="fa fa-plus-circle"></i> Add</b-button>
                                    </b-card-title>
                                    <b-card-text class="border-top">
                                        <b-table-simple bordered striped hover  :small="small">
                                            <colgroup>
                                                <col style="width: 3%"></col>
                                                <col style="width: 15%"></col>
                                                <col style="width: 29%"></col>
                                                <col style="width: 15%"></col>
                                                <col style="width: 20%"></col>
                                                <col style="width: 15%"></col>
                                                <col style="width: 3%"></col>
                                            </colgroup>
                                            <b-thead>
                                                <b-tr>
                                                    <b-th class="p-1 text-center">SL</b-th>
                                                    <b-th class="p-1">Guarantor</b-th>
                                                    <b-th class="p-1">Name</b-th>
                                                    <b-th class="p-1">Contact</b-th>
                                                    <b-th class="p-1">Relation</b-th>
                                                    <b-th class="p-1">Attachment</b-th>
                                                    <b-th class="p-1 text-center">Remove</b-th>
                                                </b-tr>
                                            </b-thead>
                                            <b-tbody>
                                                <b-tr v-for="(item, k) in loanApplication.guarantors" :key="`${k}`">
                                                    <b-td class="p-1 text-center">
                                                        {{k+1}}
                                                    </b-td>
                                                    <b-td class="p-1">
                                                        <v-select
                                                            label="option_name"
                                                            v-model="item.selectedGuarantor"
                                                            size="sm"
                                                            :options="guarantorList"
                                                            @search="searchGurantors"
                                                            id="guar_info_id_spe"
                                                        >
                                                            <!--                                                    @onChange="selectedGEmployee"-->
                                                            <template #selected-option="{ emp_code }">
                                                                <div style="display: flex; align-items: baseline;">
                                                                    {{ emp_code  }}
                                                                </div>
                                                            </template>
                                                        </v-select>
                                                    </b-td>
                                                    <b-td class="p-1">
                                                        <b-form-input size="sm" id="emp_name" v-model="item.selectedGuarantor.emp_name" readonly></b-form-input>
                                                    </b-td>
                                                    <b-td class="p-1">
                                                        <b-form-input size="sm" v-model="item.contact"></b-form-input>
                                                    </b-td>
                                                    <b-td class="p-1">
                                                        <b-form-select
                                                            v-model="item.relation_with_loan"
                                                            size="sm"
                                                            id="loan_type"
                                                            :options="relationList"
                                                            required>
                                                        </b-form-select>
                                                    </b-td>
                                                    <b-td class="p-1">
                                                        <b-form-file size="sm" v-model="filedata"  @change="encodeFileSpecial(k)"></b-form-file>
                                                    </b-td>
                                                    <b-td scope="row" class="text-center p-1">
                                                        <a v-if="item.attachment" class="text-primary" size="sm" @click="showAttachmnet(item.attachment)"><i class="bx bx-download cursor-pointer"></i> </a>
                                                        <i class="bx bx-trash text-danger" @click="deleteRowSpecial(k, item)"></i>
                                                    </b-td>
                                                </b-tr>
                                            </b-tbody>
                                        </b-table-simple>
                                    </b-card-text>
                                </b-card>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col>
                                <b-card class="border">
                                    <b-card-title >
                                        Documents
                                        <b-button type='button' size="sm" class="btn btn-info float-right" @click="addNewDocumentRow"><i class="fa fa-plus-circle"></i> Add</b-button>
                                    </b-card-title>
                                    <b-card-text class="border-top">
                                        <b-table-simple bordered striped hover  :small="small">
                                            <colgroup>
                                                <col style="width: 5%"></col>
                                                <col style="width: 50%"></col>
                                                <col style="width: 40%"></col>
                                                <col style="width: 5%"></col>
                                            </colgroup>
                                            <b-thead>
                                                <b-tr>
                                                    <b-th class="p-1 text-center">SL</b-th>
                                                    <b-th class="p-1">File Name</b-th>
                                                    <b-th class="p-1">Attachment</b-th>
                                                    <b-th class="p-1 text-center">Remove</b-th>
                                                </b-tr>
                                            </b-thead>
                                            <b-tbody>
                                                <b-tr v-for="(item, k) in loanApplication.attachments" :key="`${k}`">
                                                    <b-td class="p-1 text-center">
                                                        {{k+1}}
                                                    </b-td>
                                                    <b-td class="p-1">
                                                        <b-form-input size="sm" v-model="item.loan_doc_name" id="name" type="text" placeholder="" name="Name"></b-form-input>
                                                    </b-td>
                                                    <b-td class="p-1">
                                                        <b-form-file v-model="filedata" size="sm"  @change="encodeFileDocument(k)"></b-form-file>
                                                    </b-td>
                                                    <b-td scope="row" class=" text-center p-1">
                                                        <a class="text-primary" v-if="item.loan_doc" size="sm" @click="showAttachmnet(item.loan_doc)"><i class="bx bx-download cursor-pointer"></i> </a>
                                                        <i class="text-danger bx bx-trash" @click="deleteRowDocument(k, item)"></i>
                                                    </b-td>
                                                </b-tr>
                                            </b-tbody>
                                        </b-table-simple>
                                    </b-card-text>
                                </b-card>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="mt-2 d-flex justify-content-end">
                                <b-button-group>
                                    <b-button v-if="loanApplication.approval_yn=='N'" md="6" size="md" variant="primary"  type="submit">{{submitBtn}}</b-button>&nbsp;
                                    <b-button md="6" size="md" variant="secondary" type="reset">Reset</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Loan List</b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="columns" :totalList="totalItems" :small="small" perPage="10"
                               v-bind:items="listItems" :primaryKeyColumnName="'application_id'">
                        <template v-slot:action2="{ rows }">
                            <b-button size="sm" @click="openViewModal(rows.item)" variant="primary">View</b-button>
                            <b-button size="sm" @click="selectLoan(rows.item)" variant="primary">Edit</b-button>
                            <b-button size="sm" v-if="rows.item.approval_yn=='N' && rows.item.approval_workflow_id != null" @click="showModalApproval(rows.item)" variant="primary">Approve</b-button>
                            <b-button size="sm" v-if="rows.item.approval_workflow_id == null" @click="showWorkflowModal(rows.item.application_id)" variant="primary">WORKFLOW</b-button>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
            <b-modal id="bv-modal-example" hide-footer>
                <div class="d-block text-center">
                    <h3>HB Loan amount cannot exceed 120,000!</h3>
                </div>
            </b-modal>
            <b-modal v-model="approveShow" size="xl" okTitle="Submit" :hide-footer=true :hide-header=true>
                <b-row >
                    <b-col>
                        <h4>{{'Loan application approval process'}}</h4>
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
            <b-modal size="xl" ref="view_modal" hide-footer title="Loan Application Details">
                <div class="d-block text-center">
                    <b-row>
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

                        <!--<b-col md="4">
                            <b-form-group
                                label="Maximum Amount"
                                label-for="maximum_amount"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="modalData.maximum_amount" disabled id="maximum_amount"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Previous Loan Amount"
                                label-for="previous_loan_amount"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="modalData.previous_loan_amount" disabled id="previous_loan_amount"></b-form-input>
                            </b-form-group>
                        </b-col>-->
                        <b-col md="4">
                            <b-form-group
                                label="Application Amount"
                                label-for="application_amt_formatted"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="modalData.application_amt_formatted" disabled id="application_amt_formatted"></b-form-input>
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
                                <b-form-input v-model="modalData.rate_of_interest" disabled id="rate_of_interest"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Approximate Installment Amount"
                                label-for="balance"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="modalData.approx_installment_amount" disabled id="balance"></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Basic Amount"
                                label-for="basic_amt"
                                label-cols-md="4"
                            >
                                <b-form-input class="text-right" v-model="modalData.basic_amt" disabled id="basic_amt"></b-form-input>
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
                                label="Disbursement Amount"
                                label-for="disbursement_amount"
                                label-cols-md="4"
                            >
                                <b-form-input v-model="modalData.disbursement_amount" disabled id="disbursement_amount"></b-form-input>
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
                <b-card title="Guarantor List">
                    <b-card-body class="border">
                        <b-table
                            small
                            :items="guarantorList"
                            :fields="guarantorFields"
                            striped
                            hover
                            responsive
                        >
                            <template #cell(action)="data">
                                <a v-if="data.item.attachment" size="sm" @click="showAttachmnet(data.item.attachment)"><i class="bx bx-download cursor-pointer"></i> </a>
                                <p v-else>No Attachment</p>
                            </template>
                        </b-table>
                    </b-card-body>
                </b-card>

                <b-card title="Documents List">
                    <b-card-body class="border">
                        <b-table
                            small
                            :items="documentList"
                            :fields="documentFields"
                            striped
                            hover
                            responsive
                        >
                            <template #cell(action)="data">
                                <a v-if="data.item.loan_doc" size="sm" @click="showAttachmnet(data.item.loan_doc)"><i class="bx bx-download cursor-pointer"></i> </a>
                                <p v-else>No Attachment</p>
                            </template>
                        </b-table>
                    </b-card-body>
                </b-card>
            </b-modal>
        </div>
    </div>
</template>

<script>
    import ApiRepository from '../../Repository/ApiRepository';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../layouts/common/datatable';


    export default {
        components: {vSelect, vcss,Datatable,DatePicker},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Loan Applications"});
            this.loadData();
            this.loadWorkflow();

         },
        computed: {
            splicedOptions: function () {
                return this.options.slice(0,-1)
            }
        },
        data() {
            return {
                filedata: null,
                modalData: {
                    application_amt: "",
                    application_amt_formatted: "",
                    application_date: "",
                    application_id: "",
                    approval_status: "",
                    approval_status_1: null,
                    approval_status_2: null,
                    approval_workflow_id: "",
                    approval_yn: "",
                    approx_installment_amount: "",
                    basic_amt: "",
                    bill_code: "",
                    comment_status_1: null,
                    comment_status_2: null,
                    department_name: "",
                    description: "",
                    designation: "",
                    designation_id: "",
                    disbursement_amount: null,
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
                    option_name: "",
                    rate_of_interest: "",
                    reason: null,
                    section_id: null,
                    section_name: null,
                    sl: "2",
                    status_1_date: null,
                    status_2_date: null
                },
                loanApplication: {
                    application_id: null,
                    emp_id: null,
                    gpf_id: null,
                    loan_type_id: null,
                    application_amt: null,
                    description: null,
                    reason: null,
                    rate_of_interest: null,
                    installment_no: null,
                    comment_status_1: '',
                    approval_status_1: 0,
                    comment_status_2: '',
                    approval_status_2: 0,
                    approx_installment_amount: null,
                    attachments: [
                        {loan_doc_id: '', loan_doc_name: '', loan_doc: '', attachment_file_name: ''}
                    ],
                    guarantors: [
                        {loan_guarantor_id: '', contact: '', relation_with_loan: '22', attachment: '', attachment_file_name: '', selectedGuarantor: {emp_id: '', emp_code: ''}},
                        {loan_guarantor_id: '', contact: '', relation_with_loan: '22', attachment: '', attachment_file_name: '', selectedGuarantor: {emp_id: '', emp_code: ''}}
                    ],
                    emp_name: null,
                    designation: null,
                    department_name: null,
                    dpt_section: null,
                    bill_code: null,
                    approval_yn:'N'
                },
                max_value: null,
                submitBtn: 'Apply',
                formattedData: null,
                visible: true,
                temp: null,
                small: true,
                empIdList: [],
                listItems: [],
                loanTypes: [],
                totalItems: 0,
                selectedEmployee: {
                    basic_amt: "",
                    bill_code: "",
                    biller_code: null,
                    department_name: "",
                    designation: "",
                    designation_id: "",
                    division_name: "",
                    dpt_department_id: "",
                    dpt_division_id: "",
                    dpt_section: null,
                    emp_code: "",
                    emp_grade_id: "",
                    emp_id: "",
                    emp_name: "",
                    emp_name_bng: null,
                    gpf_id: "",
                    grade_range: "",
                    grade_step_id: "",
                    join_month: "",
                    join_year: "",
                    location_id: "",
                    location_name: "",
                    location_type_id: "",
                    location_type_name: "",
                    nps_year: "",
                    option_name: "",
                    rownum: "",
                    section_id: null
                },
                relationList: {},
                backWard: false,
                updateIndex: -1,
                approval: [
                    {text: 'Approved', value: 1},
                    {text: 'Not Approved', value: -1},
                    {text: 'Pending', value: 0}
                ],
                reportUrl:'',
                reportParams: {
                    xdo:'/~weblogic/LOAN/RPT_GUARANTOR_LETTER_DETAILS.xdo',
                    type:"pdf",
                    p_loan_guarantor_id:'',
                    p_loan_emp_id: '',
                    filename:'RPT_GUARANTOR_LETTER'
                },
                guarantorList: [],
                documentList: [],
                guarantorFields: [
                    {key: 'guar_info.guar_name', label: 'Guarantor Name'},
                    {key: 'guar_info.guar_emp_code', label: 'Employee Code'},
                    {key: 'guar_info.guar_designation', label: 'Designation'},
                    {key: 'guar_info.guar_department_name', label: 'Department'},
                    {key: 'guar_info.present_address', label: 'Present Address'},
                    {key: 'guar_info.permanent_address', label: 'Permanent Address'},
                    'action'
                ],
                documentFields: [
                    {key: 'loan_doc_name'},
                    'action'
                ],
                appInstlmntList: [
                    {text: '12', value: 12},
                    {text: '24', value: 24},
                    {text: '36', value: 36},
                    {text: '48', value: 48}
                ],
                show: true,
                approveShow:false,
                workflowData: {
                    approval_workflow_id: '',
                    application_id: ''
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
                comment:{},
                stateOptions: [],
                currentStatus: {process_step:''},
                options:[],
                showHistory:false,
                confirmShow:false,
                guarantor: {
                    guar_info_id: '',
                    relation_with_loan: '22',
                    attachment: '',
                    attachment_file_name:'',
                    emp_name:'',
                    contact:'',
                    selectedGurantor:{
                        basic_amt: "",
                        bill_code: "",
                        biller_code: null,
                        department_name: "",
                        designation: "",
                        designation_id: "",
                        division_name: "",
                        dpt_department_id: "",
                        dpt_division_id: "",
                        dpt_section: "",
                        emp_code: "",
                        emp_grade_id: "",
                        emp_id: "",
                        emp_name: "",
                        emp_name_bng: null,
                        gpf_id: "",
                        grade_range: "",
                        grade_step_id: "",
                        join_month: "",
                        join_year: "",
                        location_id: "",
                        location_name: "",
                        location_type_id: "",
                        location_type_name: "",
                        nps_year: "",
                        option_name: "",
                        rownum: "",
                        section_id: ""
                    }
                },
                createGuarantorParam: {
                    params: [
                        {
                            guar_info_id: '',
                            relation_with_loan: '22',
                            attachment: '',
                            attachment_file_name:'',
                            emp_name:'',
                            contact:'',
                            selectedGurantor:{
                                emp_namebasic_amt: "",
                                bill_code: "",
                                biller_code: null,
                                department_name: "",
                                designation: "",
                                designation_id: "",
                                division_name: "",
                                dpt_department_id: "",
                                dpt_division_id: "",
                                dpt_section: "",
                                emp_code: "",
                                emp_grade_id: "",
                                emp_id: "",
                                emp_name: "",
                                emp_name_bng: null,
                                gpf_id: "",
                                grade_range: "",
                                grade_step_id: "",
                                join_month: "",
                                join_year: "",
                                location_id: "",
                                location_name: "",
                                location_type_id: "",
                                location_type_name: "",
                                nps_year: "",
                                option_name: "",
                                rownum: "",
                                section_id: ""
                            }
                        },
                        {
                            guar_info_id: '',
                            relation_with_loan: '22',
                            attachment: '',
                            attachment_file_name:'',
                            emp_name:'',
                            contact:'',
                            selectedGurantor:{
                                basic_amt: "",
                                bill_code: "",
                                biller_code: null,
                                department_name: "",
                                designation: "",
                                designation_id: "",
                                division_name: "",
                                dpt_department_id: "",
                                dpt_division_id: "",
                                dpt_section: "",
                                emp_code: "",
                                emp_grade_id: "",
                                emp_id: "",
                                emp_name: "",
                                emp_name_bng: null,
                                gpf_id: "",
                                grade_range: "",
                                grade_step_id: "",
                                join_month: "",
                                join_year: "",
                                location_id: "",
                                location_name: "",
                                location_type_id: "",
                                location_type_name: "",
                                nps_year: "",
                                option_name: "",
                                rownum: "",
                                section_id: ""
                            }
                        }
                    ]
                },
                columns: [
                    {label: 'SL', key: 'index', sortable: true},
                    {label: 'Employee', key: 'option_name', sortable: true},
                    {label: 'Designation', key: 'designation', sortable: true},
                    {label: 'Loan Type', key: 'loan_type', sortable: true},
                    {label: 'Loan No.', key: 'loan_no'},
                    {label: 'App. Date', key: 'application_date', sortable: true},
                    {label: 'Amount', key: 'application_amt_formatted', sortable: true, class: 'text-right'},
                    {label: 'Status', key: 'approval_status', sortable: false},
                    {label: 'Action', key: 'action2'}
                ]
            }

        },
        watch: {
            'guarantor.selectedGurantor': function (val, oldVal) {
                if (val !== null) {
                    this.createGuarantorParam.params.guar_emp_code = val.emp_code;
                    this.createGuarantorParam.params.emp_name = val.emp_name;
                    this.createGuarantorParam.params.guar_info_id = val.emp_id;
                    this.createGuarantorParam.params.department_name = val.department_name;
                }
                deep: true
            },
            selectedEmployee: function (val, oldVal) {
                if (val !== null && val.emp_id != null) {
                    this.loanApplication = {
                        rate_of_interest: this.loanApplication.rate_of_interest,
                        approx_installment_amount: this.loanApplication.approx_installment_amount,
                        loan_type_id: this.loanApplication.loan_type_id,
                        emp_name: val.emp_name,
                        designation: val.designation ? val.designation : null,
                        department_name: val.department_name ? val.department_name: null,
                        dpt_section: val.section_name ? val.dpt_section : null,
                        gpf_id: val.gpf_id,
                        bill_code: val.bill_code,
                        reason: this.loanApplication.reason,
                        application_amt: this.loanApplication.application_amt,
                        installment_no: this.loanApplication.installment_no,
                        description: this.loanApplication.description,
                        approval_status_1: this.loanApplication.approval_status_1,
                        approval_status_2: this.loanApplication.approval_status_2,
                        approval_yn:this.loanApplication.approval_yn,
                        emp_code: val.emp_code,
                        emp_id: val.emp_id,
                        attachments: this.loanApplication.attachments,
                        guarantors: this.loanApplication.guarantors
                    }
                } else {
                    this.loanApplication = {
                        application_id: null,
                        emp_id: null,
                        gpf_id: null,
                        loan_type_id: this.loanApplication.loan_type_id,
                        application_amt: null,
                        description: null,
                        reason: null,
                        rate_of_interest: null,
                        installment_no: null,
                        comment_status_1: '',
                        approval_status_1: 0,
                        comment_status_2: '',
                        approval_status_2: 0,
                        approx_installment_amount: null,
                        attachments: [
                            {loan_doc_id: '', loan_doc_name: '', loan_doc: '', attachment_file_name: ''}
                        ],
                        guarantors: [
                            {loan_guarantor_id: '', contact: '', relation_with_loan: '22', attachment: '', attachment_file_name: '', selectedGuarantor: {emp_id: '', emp_code: ''}},
                            {loan_guarantor_id: '', contact: '', relation_with_loan: '22', attachment: '', attachment_file_name: '', selectedGuarantor: {emp_id: '', emp_code: ''}}
                        ],
                        emp_name: null,
                        designation: null,
                        department_name: null,
                        dpt_section: null,
                        bill_code: null,
                        approval_yn:'N'
                    }
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
            openViewModal(item){
                this.modalData = item
                this.$refs['view_modal'].show()
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/loan-guarantor/${item.application_id}`).then(res => {
                    this.guarantorList = res.data
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/get-documents/${item.application_id}`).then(res => {
                    this.documentList = res.data
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
            showWorkflowModal(id){
                this.workflowData.application_id = id
                this.$refs['workflow_modal'].show()
            },
            hideWorkflowModal(){
                this.workflowData.application_id = ''
                this.$refs['workflow_modal'].hide()
            },
            hideApprovalModal(){
                this.approveShow = false;
            },
            mapWorkflow(){
                ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/providentFund/update-loan-workflow/${this.workflowData.application_id}`, this.workflowData).then(res => {
                    this.loadData();
                });
            },
            loadWorkflow(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/workflow`).then(res => {
                    this.workflowOptions = res.data.filter(a=>a.module_id == 16)
                });
            },
            showModalApproval(item) {
                this.loan = {
                    amount:'',
                    item: item,
                    object_id:item.application_id,
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
            printReport(i) {
                let item = Object.assign({}, i);
                // let title='Prl-notice'
                this.reportParams.p_loan_guarantor_id =  item && item.guar_info_id  ? item.guar_info_id : '';
                this.reportParams.p_loan_emp_id = item.loan_emp_id;
                let params = this.reportParams;
                let queryString = Object.keys(params).map(function (key) {
                    return key + "=" + params[key]
                }).join('&');
                this.reportUrl = '/report/render/Loan Guarantor Agreement?' + queryString;
            },
            addState: function(state) {
                state.workflow_object_id = (this.next_step)?this.next_step.approval_workflow_id:this.current_step.approval_workflow_id;
                state.note = this.workflow.note;
                state.workflow_step_id = this.workflow.workflow_step_id
                state.target_url = window.location.pathname.substring(1)+'#'+this.$route.path+'?application_id='+this.loan.object_id
                state.message = 'Loan application approval review request sent to you.'

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
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/gpf-loan/final-approve/${state.approval_workflow_id}/${this.loan.object_id}`, state).then(res => {
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
            hasHistoryPermission:function() {
                if (this.$store.getters.hasGrantAccess) {
                    return this.$store.getters.hasGrantAccess;
                }

                return this.$store.getters.permissions.includes('CAN_SEE_STATUS_HISTORIES');
            },
            addNewRow() {
                this.loanApplication.guarantors.push(
                    {
                        loan_guarantor_id: '',
                        contact: '',
                        relation_with_loan: '22',
                        attachment: '',
                        attachment_file_name: '',
                        selectedGuarantor: {
                            emp_id: '',
                            emp_code: ''
                        }
                    },
                )
            },
            addNewDocumentRow() {
                this.loanApplication.attachments.push(
                    {loan_doc_id: '', loan_doc_name: '', loan_doc: '', attachment_file_name: ''}
                )
            },

            employeeGuarantor(id){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/guarantor-employee/${id}`, this.loanApplication).then(res => {
                    this.createGuarantorParam.params = res.data.gurantors;
                })
            },
            deleteAttachment(id){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/attachment-delete/${id}`, this.loanApplication).then(res => {
                    this.empIdList = res.data;
                })
            },
            onSubmit() {
                if (this.loanApplication.application_id == null) {
                    this.loanApplication.approval_status_1 = 0;
                    this.loanApplication.approval_status_2 = -1;
                } else if (this.loanApplication.application_id && this.loanApplication.approval_status_1 == 1 && this.loanApplication.approval_status_2 == 1) {
                    this.loanApplication.approval_status_2 = 1;
                } else if (this.loanApplication.application_id && this.loanApplication.approval_status_1 == 1) {
                    this.loanApplication.approval_status_2 = 0;
                } else if (this.loanApplication.application_id && this.loanApplication.approval_status_1 == 0) {
                    this.loanApplication.approval_status_2 = -1;
                } else if (this.loanApplication.application_id && this.loanApplication.approval_status_1 == -1) {
                    this.loanApplication.approval_status_2 = -1;
                } else if (this.loanApplication.application_id && this.loanApplication.approval_status_2 == 1) {
                    this.loanApplication.approval_status_1 = 1;
                } else if (this.loanApplication.application_id && this.loanApplication.approval_status_2 == -1) {
                    this.loanApplication.approval_status_1 = 0;
                } else if (this.loanApplication.application_id && this.loanApplication.approval_status_2 == 0) {
                    this.loanApplication.approval_status_1 = 1;
                } else if (this.loanApplication.application_id && this.loanApplication.approval_status_1 == 1 && this.loanApplication.approval_status_2 == 1) {
                    this.loanApplication.approval_status_2 = 1;
                }
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/loan/loan-application`, this.loanApplication).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.loadData();
                        this.onReset();

                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            onReset() {
                this.selectedEmployee = {
                    basic_amt: "",
                    bill_code: "",
                    biller_code: null,
                    department_name: "",
                    designation: "",
                    designation_id: "",
                    division_name: "",
                    dpt_department_id: "",
                    dpt_division_id: "",
                    dpt_section: null,
                    emp_code: "",
                    emp_grade_id: "",
                    emp_id: null,
                    emp_name: "",
                    emp_name_bng: null,
                    gpf_id: "",
                    grade_range: "",
                    grade_step_id: "",
                    join_month: "",
                    join_year: "",
                    location_id: "",
                    location_name: "",
                    location_type_id: "",
                    location_type_name: "",
                    nps_year: "",
                    option_name: "",
                    rownum: "",
                    section_id: null
                };
                this.loanApplication = {
                    application_id: null,
                    emp_id: null,
                    gpf_id: null,
                    loan_type_id: null,
                    application_amt: 0,
                    description: null,
                    reason: null,
                    rate_of_interest: null,
                    installment_no: null,
                    comment_status_1: '',
                    approval_status_1: 0,
                    comment_status_2: '',
                    approval_status_2: 0,
                    approx_installment_amount: null,
                    attachments: [
                        {loan_doc_id: '', loan_doc_name: '', loan_doc: '', attachment_file_name: ''}
                    ],
                    guarantors: [
                        {loan_guarantor_id: '', contact: '', relation_with_loan: '22', attachment: '', attachment_file_name: '', selectedGuarantor: {emp_id: '', emp_code: ''}},
                        {loan_guarantor_id: '', contact: '', relation_with_loan: '22', attachment: '', attachment_file_name: '', selectedGuarantor: {emp_id: '', emp_code: ''}}
                    ],
                    emp_name: null,
                    designation: null,
                    department_name: null,
                    dpt_section: null,
                    bill_code: null,
                    approval_yn:'N'
                };
                this.filedata = null
                this.visible = true
                this.empIdList = []

            },
            deleteRowSpecial(index, item) {
                let idx = this.loanApplication.guarantors.indexOf(item)
                if (idx > -1 && this.loanApplication.guarantors.length > 2) {
                    this.loanApplication.guarantors.splice(idx, 1)
                }
                if(item.loan_guarantor_id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/guarantor-delete/${item.loan_guarantor_id}`, this.loanApplication).then(res => {
                        this.empIdList = res.data;
                    })
                }

            },
            deleteRowDocument(index, item) {
                let idx = this.loanApplication.attachments.indexOf(item)
                if (idx > -1 && this.loanApplication.attachments.length > 1) {
                    this.loanApplication.attachments.splice(idx, 1)
                }
            },
            encodeFileSpecial(index) {
                let file_limit = 2000000;
                let vm = this;
                if(event.target.files[0].size<=file_limit){
                    if (event.target.files[0].type=='application/pdf'||event.target.files[0].type=='image/jpeg'||event.target.files[0].type=='image/jpg'){
                        let file = event.target.files[0];
                        let reader = new FileReader();
                        let type = file.type;
                        let name = file.name;
                        reader.readAsDataURL(file);
                        reader.onload = (file)=>{
                            vm.loanApplication.guarantors[index].attachment = reader.result;
                            vm.loanApplication.guarantors[index].attachment_file_name = name;
                        }
                    }
                    else {
                        this.$notify({group: 'pmis', text: "File type should be in pdf, jpg or jpeg", type: 'error'});
                    }

                }else{
                    this.$notify({group: 'pmis', text: "File size should not exceed 2MB", type: 'error'});
                    return;
                }

            },
            encodeFileDocument(index) {
                let file_limit = 2000000;
                let vm = this;
                if(event.target.files[0].size<=file_limit){
                    if (event.target.files[0].type=='application/pdf'||event.target.files[0].type=='image/jpeg'||event.target.files[0].type=='image/jpg'){
                        let file = event.target.files[0];
                        let reader = new FileReader();
                        let type = file.type;
                        let name = file.name;
                        reader.readAsDataURL(file);
                        reader.onload = (file)=>{
                            vm.loanApplication.attachments[index].loan_doc = reader.result;
                            vm.loanApplication.attachments[index].attachment_file_name = name;
                        }
                    }
                    else {
                        this.$notify({group: 'pmis', text: "File type should be in pdf, jpg or jpeg", type: 'error'});
                    }

                }else{
                    this.$notify({group: 'pmis', text: "File size should not exceed 2MB", type: 'error'});
                    return;
                }

            },
            searchGurantors(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/emp/${id}`, this.loanApplication).then(res => {
                        this.guarantorList = res.data;
                    })
                }
            },
            searchEmployees(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/emp/${id}`, this.loanApplication).then(res => {
                        this.empIdList = res.data;
                     })
                }
            },
            selectLoan(item) {
                this.submitBtn = 'Update';
                this.selectedEmployee = item;
                this.loanApplication = item;
                this.searchEmployees(this.loanApplication.emp_code);
                this.loanApplication.gpf_id = item.gpf_id;
                this.loanApplication.application_id = item.application_id;
                this.loanApplication.approx_installment_amount = item.approx_installment_amount;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/get-loanData/${this.loanApplication.application_id}`).then(res => {
                    this.loanApplication = {
                        application_id: res.data.loanData.application_id,
                        emp_id: res.data.loanData.emp_id,
                        gpf_id: res.data.loanData.gpf_id,
                        loan_type_id: res.data.loanData.loan_type_id,
                        application_amt: res.data.loanData.application_amt,
                        description: res.data.loanData.description,
                        reason: res.data.loanData.reason,
                        rate_of_interest: res.data.loanData.rate_of_interest,
                        installment_no: res.data.loanData.installment_no,
                        comment_status_1: res.data.loanData.comment_status_1,
                        approval_status_1: res.data.loanData.approval_status_1,
                        comment_status_2: res.data.loanData.comment_status_2,
                        approval_status_2: res.data.loanData.approval_status_2,
                        approx_installment_amount: res.data.loanData.approx_installment_amount,
                        attachments: res.data.document,
                        guarantors: res.data.guarantor,
                        emp_name: res.data.loanData.emp_name,
                        designation: res.data.loanData.designation,
                        department_name: res.data.loanData.department_name,
                        dpt_section: res.data.loanData.dpt_section,
                        bill_code: res.data.loanData.bill_code,
                        approval_yn:res.data.loanData.approval_yn
                    }

                })
                this.onBlurNumber();

                window.scrollTo(0, 0);
            },
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/loan/loan-application`).then(res => {
                    this.loanTypes = res.data.loanTypes.filter(i => i.loan_type_id != 1);
                    this.listItems = res.data.pfLoans;
                    this.totalItems = res.data.pfLoans.length;
                    this.relationList = res.data.relations;
                    if(this.$route.query.application_id > 0){
                        this.listItems = this.listItems.filter(a=>a.application_id == this.$route.query.application_id)
                        this.totalItems = this.listItems.length;
                    }
                });
            },
            onBlurNumber() {
                this.visible = false;
                this.temp = this.loanApplication.application_amt;
                this.formattedData = this.thousandSeprator(this.loanApplication.application_amt);
            },
            onFocusText() {
                this.visible = true;
                this.formattedData = this.temp;
            },
            thousandSeprator(amount) {
                if (amount !== '' || amount !== undefined || amount !== 0 || amount !== '0' || amount !== null) {
                    return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                } else {
                    return amount;
                }
            },
            loanTypeChange(id) {
                this.loanApplication.rate_of_interest = this.loanTypes.filter(a => a.loan_type_id == id)[0].rate_of_interest;
                this.max_value = this.loanTypes.filter(a => a.loan_type_id == id)[0].max_value;

            },
            handleChange(input) {
                this.approximateAmt(12);
                if (this.loanApplication.loan_type_id == 2 && input > this.max_value) {
                    this.$bvModal.show('bv-modal-example');
                    this.loanApplication.application_amt = this.max_value;
                }
            },
            approximateAmt(input) {
                let application_amt = this.loanApplication.application_amt;
                let install_amount = this.loanApplication.application_amt / input;
                let install_amount_with_percent = (application_amt / input) * 22.5/100;
                this.loanApplication.approx_installment_amount = (install_amount + install_amount_with_percent).toFixed();
              },
            fixed_number_set(number){
               let modulusNumber = 0;
                modulusNumber = (number % 100);
                number -= modulusNumber;
                if (modulusNumber >= 50) {
                    number += 100;
                }
                return number.toFixed();
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
    .required label:after {
        content: "*";
        color: red;
    }
    .cutome_boder{
        border:1px solid gainsboro;
    }
</style>
