<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">
                    Pension Continuation Application
                    <b-button v-b-modal.employee_modal v-if="pensionApplication.application_type == 'A15'" class="float-right" size="sm" variant="primary">Employee List For 15 Years</b-button>
                </b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Re-continuation For"
                                    label-for="application-type"
                                >
                                    <b-form-select
                                        :options="continuationTypeOptions"
                                        v-model="pensionApplication.application_type"
                                        text-field="show_value"
                                        value-field="pass_value"
                                    >

                                    </b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Employee Code"
                                    label-for="emp_code"
                                >
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
                                <b-form-group
                                    label="Employee Name"
                                    label-for="name"
                                >
                                    <b-form-input
                                        id="name"
                                        type="text"
                                        required
                                        readonly
                                        v-model="pensionApplication.emp_name"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="DESIGNATION"
                                    label-for="designation"
                                >
                                    <b-form-input
                                        v-model="pensionApplication.designation"
                                        id="designation"
                                        type="text"
                                        required
                                        readonly
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="DEPARTMENT"
                                    label-for="department_name"
                                >
                                    <b-form-input
                                        v-model="pensionApplication.department_name"
                                        id="department_name"
                                        type="text"
                                        required
                                        readonly
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="PRL DATE"
                                    label-for="prl_date"
                                >
                                    <date-picker
                                        id="prl_date"
                                        v-model="pensionApplication.emp_lpr_date"
                                        width="100%"
                                        input-class="form-control"
                                        type="date"
                                        lang="en"
                                        :value-type="valueType"
                                        format="DD-MM-YYYY"
                                        disabled
                                    ></date-picker>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group
                                    label="PERMANENT RETIREMENT DATE"
                                    label-for="perm_retd_date"
                                >
                                    <date-picker
                                        v-model="pensionApplication.permanent_retirement_date"
                                        :disabled="pensionApplication.permanent_retirement_date!=null"
                                        width="100%"
                                        id="perm_retd_date"
                                        input-class="form-control"
                                        type="date"
                                        :value-type="valueType"
                                        lang="en"
                                        format="DD-MM-YYYY"
                                        :input-attr="{ required: true }"
                                    ></date-picker>
                                </b-form-group>
                            </b-col>

                            <b-col md="4">
                                <b-form-group label="Branch Name of Sonali Bank" label-for="branch_of_sonali_bank">
                                    <b-form-input
                                        id="account_no"
                                        v-model="pensionApplication.branch_name"
                                        disabled
                                        type="text"
                                        required
                                        placeholder="Branches Name"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Account No" label-for="account_no">
                                    <b-form-input
                                        id="account_no"
                                        v-model="pensionApplication.account_number"
                                        disabled
                                        type="text"
                                        required
                                        placeholder="Account No"
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group label="Service Period" label-for="service_period">
                                    <b-form-input
                                        id="service_period"
                                        v-model="pensionApplication.service_period"
                                        type="text"
                                        placeholder="Service Preiod"
                                        readonly
                                    ></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Application Date"
                                    label-for="application_date"
                                >
                                    <date-picker
                                        v-model="pensionApplication.application_date"
                                        width="100%"
                                        id="application_date"
                                        input-class="form-control"
                                        type="date"
                                        lang="en"
                                        :value-type="valueType"
                                        format="DD-MM-YYYY"
                                        :input-attr="{ required: true }"
                                    ></date-picker>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row class="mb-1" v-if="nomineeItems.length > 0">
                            <b-col class="border ml-1 mr-1 p-2">
                                <b-table-simple>
                                    <b-thead>
                                        <b-tr>
                                            <b-th class="p-1">SL</b-th>
                                            <b-th class="p-1">Nominee Name</b-th>
                                            <b-th class="p-1">Birth Date</b-th>
                                            <b-th class="p-1">Relation</b-th>
                                            <b-th class="p-1">Percentage</b-th>
                                            <b-th class="p-1">Bank Info</b-th>
                                            <b-th class="p-1">Is Autistic</b-th>
                                            <b-th v-if="forShow == true" class="p-1">Is Applicant</b-th>
                                        </b-tr>
                                    </b-thead>
                                    <b-tbody>
                                        <b-tr v-for="(nominee, k) in nomineeItems" :key="`${k}`">
                                            <b-td class="p-1 text-right">
                                                {{k+1}}
                                            </b-td>
                                            <b-td class="p-1">
                                                <b-form-input readonly size="sm" v-model="nominee.nominee_name"></b-form-input>
                                            </b-td>
                                            <b-td class="p-1">
                                                <b-form-input readonly size="sm" v-model="nominee.nominee_dob"></b-form-input>
                                            </b-td>
                                            <b-td class="p-1">
                                                <b-form-input readonly size="sm" v-model="nominee.relationship"></b-form-input>
                                            </b-td>
                                            <b-td class="p-1">
                                                <b-form-input readonly size="sm" v-model="nominee.percentage"></b-form-input>
                                            </b-td>
                                            <b-td class="p-1">
                                                <b-form-input readonly size="sm" v-model="nominee.bank_info"></b-form-input>
                                            </b-td>
                                            <b-td class="p-1">
                                                <b-form-input readonly size="sm" v-model="nominee.is_autistic"></b-form-input>
                                            </b-td>
                                            <b-td class="p-1" v-if="forShow == true">
                                                <input  type="radio" name="is_applicant" :checked="nominee.nominee_id == nominee_id" @change="onChangeIsApplicant(nominee)" >
                                            </b-td>
                                        </b-tr>
                                    </b-tbody>
                                </b-table-simple>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="d-flex justify-content-end">
                                <b-button-group>
                                    <b-button type="submit" variant="primary">Submit</b-button>
                                    <b-button type="reset" variant="secondary">Reset</b-button>
                                </b-button-group>
                            </b-col>
                        </b-row>

                    </b-form>
                </b-card-body>
            </b-card>
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Continuation Application List
                </b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="columns" :totalList="totalItems" perPage="5" v-bind:items="listItems"
                               v-bind:pageColSize="4" v-bind:searchColSize="5">
                        <template v-slot:action4="{ rows }">
                            <b-link ml="4" class="text-primary" v-if="rows.item.approved_yn=='N'" @click="edit(rows.item)">
                                <i class="bx bx-edit cursor-pointer"></i>
                            </b-link>
                            <b-link ml="4" class="text-primary" @click="view(rows.item)">
                                <i class="bx bx-show cursor-pointer"></i>
                            </b-link>
                            <b-button size="sm" v-if="rows.item.approved_yn=='N' && (rows.item.approval_workflow_id != null ||rows.item.approved_yn=='Y') " @click="showModalApproval(rows.item)" variant="primary">Approve</b-button>
                            <b-button size="sm"  v-if="rows.item.approved_yn=='Y' && rows.item.approval_workflow_id != null" variant="primary">Approved</b-button>
                            <b-button size="sm" v-if="rows.item.approval_workflow_id == null" @click="showWorkflowModal(rows.item.recontinue_app_id)" variant="primary">WORKFLOW</b-button>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
            <div>
                <b-modal
                    id="modal-center"
                    scrollable
                    size="xl"
                    body-bg="light"
                    title="Pension Clearance Status"
                >
                    <b-container fluid>
                        <b-card>
                            <b-card-header header-bg-variant="dark" header-text-variant="white">Pension Clearance Status
                                for {{this.clearanceEmp }}
                            </b-card-header>
                            <b-card-body class="border">
                                <b-row class="mb-1">
                                    <b-col class="border ml-1 mr-1 p-2">
                                        <b-table
                                            :items="pensionItems"
                                            :fields="pensionFields"
                                            sort-icon-left
                                            responsive="sm"
                                            :small="small"
                                            hover
                                            head-variant="dark"
                                        >
                                            <template v-slot:cell(index)="data">
                                                {{ data.index + 1 }}
                                            </template>
                                        </b-table>
                                    </b-col>
                                </b-row>
                            </b-card-body>
                        </b-card>
                    </b-container>
                </b-modal>
            </div>
        </div>
        <b-modal id="employee_modal" hide-footer size="xl">
            <b-table small striped hover responsive  :items="employeeList" :fields="employeeFields"></b-table>
        </b-modal>
        <b-modal v-model="approveShow" size="xl" okTitle="Submit" :hide-footer=true :hide-header=true>
            <b-row >
                <b-col>
                    <h4>{{'Pension re-continue application approval process'}}</h4>
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
        <b-modal size="xl" ref="view-data" @ok="mapWorkflow" @close="hideWorkflowModal">
            <b-card-body class="border">
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Re-continuation For"
                                label-for="application-type"
                            >
                                <b-form-input
                                    type="text"
                                    required
                                    readonly
                                    v-model="pensionApplication.application_type"
                                ></b-form-input>

                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Employee Code"
                                label-for="emp_code"
                            >
                                <b-form-input
                                    type="text"
                                    required
                                    readonly
                                    v-model="pensionApplication.emp_code"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Employee Name"
                                label-for="name"
                            >
                                <b-form-input
                                    type="text"
                                    required
                                    readonly
                                    v-model="pensionApplication.emp_name"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group
                                label="DESIGNATION"
                                label-for="designation"
                            >
                                <b-form-input
                                    v-model="pensionApplication.designation"
                                    id="designation"
                                    type="text"
                                    readonly
                                ></b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group
                                label="DEPARTMENT"
                                label-for="department_name"
                            >
                                <b-form-input
                                    v-model="pensionApplication.department_name"
                                    type="text"
                                    readonly
                                ></b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group
                                label="PRL DATE"
                                label-for="prl_date"
                            >
                                <date-picker
                                    v-model="pensionApplication.emp_lpr_date"
                                    width="100%"
                                    input-class="form-control"
                                    type="date"
                                    lang="en"
                                    format="DD-MM-YYYY"
                                    disabled
                                ></date-picker>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group
                                label="PERMANENT RETIREMENT DATE"
                                label-for="perm_retd_date"
                            >
                                <date-picker
                                    v-model="pensionApplication.permanent_retirement_date"
                                    :disabled="pensionApplication.permanent_retirement_date!=null"
                                    width="100%"
                                    input-class="form-control"
                                    type="date"
                                    lang="en"
                                    format="DD-MM-YYYY"
                                    :input-attr="{ required: true }"
                                ></date-picker>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group label="Branch Name of Sonali Bank" label-for="branch_of_sonali_bank">
                                <b-form-input
                                    v-model="pensionApplication.branch_name"
                                    disabled
                                    type="text"
                                    required
                                    placeholder="Branches Name"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group label="Account No" label-for="account_no">
                                <b-form-input
                                    v-model="pensionApplication.account_number"
                                    disabled
                                    type="text"
                                    required
                                    placeholder="Account No"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group label="Service Period" label-for="service_period">
                                <b-form-input
                                    v-model="pensionApplication.service_period"
                                    type="text"
                                    placeholder="Service Preiod"
                                    readonly
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Application Date"
                                label-for="application_date"
                            >
                                <date-picker
                                    disabled=""
                                    v-model="pensionApplication.application_date"
                                    width="100%"
                                    input-class="form-control"
                                    type="date"
                                    lang="en"
                                    :value-type="valueType"
                                    format="DD-MM-YYYY"
                                    :input-attr="{ required: true }"
                                ></date-picker>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row class="mb-1" v-if="nomineeItems.length > 0">
                        <b-col class="border ml-1 mr-1 p-2">
                            <b-table-simple>
                                <b-thead>
                                    <b-tr>
                                        <b-th class="p-1">SL</b-th>
                                        <b-th class="p-1">Nominee Name</b-th>
                                        <b-th class="p-1">Birth Date</b-th>
                                        <b-th class="p-1">Relation</b-th>
                                        <b-th class="p-1">Percentage</b-th>
                                        <b-th class="p-1">Bank Info</b-th>
                                        <b-th class="p-1">Is Autistic</b-th>
                                        <b-th v-if="forShow == true" class="p-1">Is Applicant</b-th>
                                    </b-tr>
                                </b-thead>
                                <b-tbody>
                                    <b-tr v-for="(nominee, k) in nomineeItems" :key="`${k}`">
                                        <b-td class="p-1 text-right">
                                            {{k+1}}
                                        </b-td>
                                        <b-td class="p-1">
                                            <b-form-input readonly size="sm" v-model="nominee.nominee_name"></b-form-input>
                                        </b-td>
                                        <b-td class="p-1">
                                            <b-form-input readonly size="sm" v-model="nominee.nominee_dob"></b-form-input>
                                        </b-td>
                                        <b-td class="p-1">
                                            <b-form-input readonly size="sm" v-model="nominee.relationship"></b-form-input>
                                        </b-td>
                                        <b-td class="p-1">
                                            <b-form-input readonly size="sm" v-model="nominee.percentage"></b-form-input>
                                        </b-td>
                                        <b-td class="p-1">
                                            <b-form-input readonly size="sm" v-model="nominee.bank_info"></b-form-input>
                                        </b-td>
                                        <b-td class="p-1">
                                            <b-form-input readonly size="sm" v-model="nominee.is_autistic"></b-form-input>
                                        </b-td>
                                        <b-td class="p-1" v-if="forShow == true">
                                            <input  type="radio" name="is_applicant" :checked="nominee.nominee_id == nominee_id" @change="onChangeIsApplicant(nominee)" >
                                        </b-td>
                                    </b-tr>
                                </b-tbody>
                            </b-table-simple>
                        </b-col>
                    </b-row>
            </b-card-body>
        </b-modal>
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
    import { TablePlugin } from 'bootstrap-vue'

    export default {
        components: {DatePicker, Datatable, vSelect, vcss, BFormDatepicker, TablePlugin},
        computed: {
            splicedOptions: function () {
                return this.options.slice(0,-1)
            }
        },
        data() {
            return {
                nominee_id: '',
                valueType: this.dateFormatter(),
                employeeList: [],
                employeeFields: [
                    {key: 'emp_code', label: 'Employee Code'},
                    {key: 'emp_name', label: 'Employee Name'},
                    {key: 'designation'},
                    {key: 'department_name', label: 'Department'},
                    {key: 'service_period'},
                    {key: 'emp_lpr_date', label: 'LPR Date'},
                    {key: 'permanent_retirement_date'},
                    {key: 'bank_info'}
                ],
                forShow: false,
                value: 'Y',
                selected: '',
                disabled: false,
                backWard: false,
                selectedEmployee: {
                    account_number: "",
                    account_type: null,
                    account_type_id: null,
                    available_days: null,
                    bank_info: "",
                    branch_id: "",
                    branch_name: "",
                    department_name: "",
                    designation: "",
                    designation_id: "",
                    dpt_department_id: "",
                    emp_code: "",
                    emp_id: "",
                    emp_lpr_date: "",
                    emp_name: "",
                    emp_status: null,
                    option_name: "",
                    permanent_retirement_date: "",
                    service_period: ""
                },
                empIdList: [],
                continuationTypeOptions: [],
                totalItems: 0,
                nomineeItems: [],
                pensionItems: [],
                totalPension: 0,
                clearanceEmp:' ' ,
                small: true,
                listItems: [],
                length: '',
                branches: [],
                permanentDate: null,
                pensionApplication: {
                    recontinue_app_id: '',
                    application_type: '',
                    emp_id: '',
                    emp_name: '',
                    designation: '',
                    department_name: '',
                    emp_lpr_date: '',
                    nominee_id: '',
                    application_date: moment(new Date()).format("YYYY-MM-DD"),
                    attachments: []
                },
                employeeTitleList: [
                    {text: 'MR.', value: 'MR.'},
                    {text: 'MRS.', value: 'MRS.'}
                ],
                options: [
                    {text: 'Male', value: ''},
                    {text: 'Female', value: 'second'},
                    {text: 'Other', value: 'third'}
                ],
                isApplicantOptions: [
                    { item: 'Y', name: '' },
                ],
                columns: [
                    {label: 'SL', key: 'index', sortable: false},
                    {label: 'Employee Code', key: 'emp_code', sortable: true},
                    {label: 'Employee Name', key: 'emp_name', sortable: true},
                    {
                        label: 'Employee Status',
                        key: 'emp_status',
                        sortable: true
                    },
                    {
                        label: 'Application Date',
                        key: 'application_date',
                        sortable: true,
                        formatter: value => {
                            if (value) {
                                return moment(value).format('DD-MM-YYYY')
                            }
                        }
                    },
                    {label: 'Nominee Name', key: 'nominee_name', sortable: true},
                    {label: 'Action', key: 'action4', class: 'text-center'}
                ],
                pensionFields: [
                    {label: 'SL', key: 'index'},
                    {label: 'Clearance Department', key: 'department_name', sortable: true, },
                    {key: 'clearance_date', label: 'Date',formatter: value => {
                            if(value) {
                                return moment(value).format('DD-MM-YYYY')
                            }
                        }, sortable: true, sortDirection: 'desc', class: 'text-center',variant: 'danger' },
                    {label: 'Status', key: 'dependency_yn', sortable: true, class: 'text-center',variant: 'success'},
                    {label: 'Remarks', key: 'remarks', sortable: true, class: 'text-center' ,variant: 'warning'},
                    {label: 'Clearance By', key: 'clearance_by_name', class: 'text-center', sortable: true,variant: 'primary'}


                ],
                nomineeFields: [
                    {key: 'index', label: 'SL', sortable: true},
                    {key: 'nominee_name', label: 'Nominee Name', sortable: true},
                    {key: 'relationship', label: 'Relationship', sortable: true},
                    {key: 'nominee_dob', label: 'Birth Date', sortable: true},
                    {key: 'percentage', label: 'Percentage', sortable: true},
                    {key: 'marital_status', label: 'Marital Status', sortable: true}
                ],
                workflow:{
                    workflow_step_id:'',
                    note:''
                },
                show: true,
                confirmShow:false,
                approveShow:false,
                showHistory:false,
                next_step:{},
                previous_step:{},
                current_step:{},
                nextState:{},
                dateValueType: this.dateFormatter(),
                workflowData: {
                    approval_workflow_id: '',
                    recontinue_app_id: ''
                },
                workflowOptions: [],
            }
        },
        watch: {
            'pensionApplication.application_type':function(val, oldVal){
                // if(val){
                //     this.pensionApplication.emp_id = ""
                //     this.pensionApplication.emp_name = ""
                //     this.pensionApplication.designation = ""
                //     this.pensionApplication.department_name = ""
                //     this.pensionApplication.bank_id = 37
                //     this.pensionApplication.account_number = ""
                //     this.pensionApplication.emp_lpr_date = ""
                //     this.pensionApplication.permanent_retirement_date = ""
                //     this.pensionApplication.emp_status = ""
                //     this.selectedEmployee = {
                //         account_number: "",
                //         account_type: null,
                //         account_type_id: null,
                //         available_days: null,
                //         bank_info: "",
                //         branch_id: "",
                //         branch_name: "",
                //         department_name: "",
                //         designation: "",
                //         designation_id: "",
                //         dpt_department_id: "",
                //         emp_code: "",
                //         emp_id: "",
                //         emp_lpr_date: "",
                //         emp_name: "",
                //         emp_status: null,
                //         option_name: "",
                //         permanent_retirement_date: "",
                //         service_period: ""
                //     }
                //     this.nomineeItems = []
                // }
            },
            selectedEmployee: function (val, oldVal) {
                if (val.emp_id) {
                    this.pensionApplication.emp_id = val.emp_id
                    this.pensionApplication.emp_name = val.emp_name
                    this.pensionApplication.designation = val.designation
                    this.pensionApplication.department_name = val.department_name
                    this.pensionApplication.bank_id = 37
                    this.pensionApplication.account_number = val.account_number
                    this.pensionApplication.emp_lpr_date = val.emp_lpr_date
                    this.pensionApplication.permanent_retirement_date = val.permanent_retirement_date
                    this.pensionApplication.emp_status = val.emp_status
                    this.loadNominee(val.emp_id)
                    if(this.pensionApplication.emp_status=='D'){
                        this.forShow = true
                    }
                    else {
                        this.forShow = false
                    }
                }
            }
        },

        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Re-Continue Application"});
            this.loadBrances();
            this.loadTable();
            this.loadContinuationType();
            this.loadEmployees();
            this.loadWorkflow();

        },

        filters: {
            dateFormat: function (d) {
                return moment(d).format("YYYY-M-D");
            }
        },
        methods: {
            onSubmit() {
                if (this.pensionApplication.emp_status == 'D') {
                    if (!this.pensionApplication.nominee_id){
                        this.$notify({group: 'pmis', text: 'Select a nominee', type: 'error'});
                    } else {
                        this.save()
                    }
                } else {
                    this.save()
                }

            },
            save(){
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/nominee-pension-application`, this.pensionApplication).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.onReset()
                        this.loadTable()
                        this.nomineeItems = []
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            edit(item){
                this.pensionApplication = item
                this.selectedEmployee = item
                this.nominee_id = item.nominee_id;
            },
            view(item){
                this.pensionApplication = item
                this.pensionApplication.application_type = item.application_type == 'A15' ? 'After 15 Years' : 'Attendance'
                // this.selectedEmployee = item
                this.nominee_id = item.nominee_id;
                this.$refs['view-data'].show();
            },
            onReset() {
                this.selectedEmployee = [];
                this.pensionApplication = {};
                this.nomineeItems = []
                this.$nextTick(() => {
                })
            },
            searchEmpCode(id) {
                this.empIdList = []
                if (id && this.pensionApplication.application_type == 'REC') {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/applications/emp/${id}`).then(res => {
                        this.empIdList = res.data;
                    })
                } else if(id && this.pensionApplication.application_type == 'A15'){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/applications/emp-for-fifteen-years/${id}`).then(res => {
                        console.log(res.data)
                        this.empIdList = res.data;
                    })
                }
                else {
                    this.empIdList = []
                }
            },
            loadEmployees(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/employees-for-fifteen-years/`).then(res => {
                    this.employeeList = res.data;
                })
            },
            loadContinuationType() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/re-continuation-type-list`).then(res => {
                    this.continuationTypeOptions = res.data;
                })
            },
            loadTable: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pension/all-continuation-application').then(res => {
                    this.listItems = res.data;
                    this.totalItems = res.data.length;
                });
            },
            loadBrances: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pension/applications/form-data').then(res => {
                    this.branches = res.data.branches;
                });
            },
            loadNominee: function (id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/nominee/${id}`).then(res => {
                    this.nomineeItems = res.data;
                });
            },

            renderModal(item) {
                let id = item.emp_id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/get-pension-clearance-status/${id}`).then(res => {
                    this.pensionItems = res.data;
                    this.clearanceEmp=res.data[0].emp_name;
                    this.totalPension = res.data.length;

                });
            },
            onChangeIsApplicant(nominee){
                for(let i = 0; i < this.nomineeItems.length; i++){
                    this.nomineeItems[i].is_applicant = ""
                }
                this.pensionApplication.nominee_id = nominee.nominee_id
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
            loadWorkflow(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/workflow`).then(res => {
                    this.workflowOptions = res.data.filter(a=>a.module_id == 5)
                });
            },
            showModalApproval(item) {
                this.loan = {
                    amount:'',
                    item: item,
                    object_id: 'PENRCON'+item.recontinue_app_id,
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
                state.message = 'Pension re-continue application approval review request sent to you.'

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
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pension/recontinue-final-approval/${state.approval_workflow_id}/${this.loan.object_id}`, state).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.hideApprovalModal();
                        this.loadTable();
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
            hideApprovalModal(){
                this.approveShow = false;
            },
            mapWorkflow(){
                ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/pension/update-pension-recontinue/workflow/${this.workflowData.recontinue_app_id}`, this.workflowData).then(res => {
                    this.loadTable();
                });
            },
            showWorkflowModal(id){
                this.workflowData.recontinue_app_id = id
                this.$refs['workflow_modal'].show()
            },
            hideWorkflowModal(){
                this.workflowData.recontinue_app_id = ''
                this.$refs['workflow_modal'].hide()
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

