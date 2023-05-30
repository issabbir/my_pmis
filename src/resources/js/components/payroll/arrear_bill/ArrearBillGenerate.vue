<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Arrear Bill Master Info</b-card-header>
                <b-card-body class="border">
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                label="Employee"
                                label-for="employee"
                                class="requiredField"
                            >
                                <v-select
                                    id="employee"
                                    v-model="selectedEmployee"
                                    @search="searchEmployee"
                                    @input="datatable()"
                                    label="option_name"
                                    :options="employeeOptions">
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events" />
                                    </template>
                                </v-select>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.formData.masterData.emp_id.$error && !$v.formData.masterData.emp_id.required}">Employee is required!</div>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group
                                label="Designation"
                                label-for="designation_name"
                            >
                                <b-form-input
                                    v-model="formData.masterData.designation_name"
                                    readonly
                                    id="designation_name">
                                </b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Section"
                                label-for="section_name"
                            >
                                <b-form-input
                                    v-model="formData.masterData.section_name"
                                    readonly
                                    id="section_name">
                                </b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Department"
                                label-for="department_name"
                            >
                                <b-form-input
                                    v-model="formData.masterData.department_name"
                                    readonly
                                    id="department_name">
                                </b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="4">
                            <b-form-group
                                label="Division"
                                label-for="division_name"
                            >
                                <b-form-input
                                    v-model="formData.masterData.division_name"
                                    readonly
                                    id="division_name">
                                </b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Bill Code"
                                label-for="bill_code"
                            >
                                <b-form-input
                                    v-model="formData.masterData.bill_code"
                                    readonly
                                    type="number"
                                    id="bill_code">
                                </b-form-input>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.formData.masterData.bill_code.$error && !$v.formData.masterData.bill_code.required}">Bill code is required!</div>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col>
                            <fieldset class="border pr-2 pl-2">
                                <legend class="w-auto">Bill Information</legend>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                                label="From Date"
                                                label-for="from_date"
                                                class="requiredField"
                                        >
                                            <date-picker
                                                    v-model="formData.masterData.bill_from_date"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    name="from_date"
                                                    @input="getSelectedDate"
                                                    id="from_date"
                                                    :not-after="new Date()"
                                                    :value-type="valueType"
                                                    format="DD-MM-YYYY"
                                                     >
                                            </date-picker>
                                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.masterData.bill_from_date.$error && !$v.formData.masterData.bill_from_date.required}">From date is required!</div>
                                         </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                                label="To Date"
                                                label-for="to_date"
                                                class="requiredField"
                                        >
                                            <date-picker
                                                    v-model="formData.masterData.bill_to_date"
                                                    width="100%"
                                                    input-class="form-control"
                                                    type="date"
                                                    lang="en"
                                                    name="to_date"
                                                    id="to_date"
                                                    :not-before="to_date_after"
                                                    :value-type="valueType"
                                                    format="DD-MM-YYYY"
                                                    >
                                            </date-picker>
                                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.masterData.bill_to_date.$error && !$v.formData.masterData.bill_to_date.required}">To date is required!</div>
                                         </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Bill No"
                                            label-for="bill_no"
                                            class="requiredField"
                                        >
                                            <b-form-input
                                                v-model="formData.masterData.bill_no"
                                                id="bill_no">
                                            </b-form-input>
                                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.masterData.bill_no.$error && !$v.formData.masterData.bill_no.required}">Bill number is required!</div>
                                        </b-form-group>
                                    </b-col>


                                    <b-col md="6">
                                        <b-form-group
                                            label="Bill Type"
                                            label-for="bill_type_id"
                                            class="requiredField"
                                        >
                                            <b-form-select
                                                v-model="formData.masterData.bill_type_id"
                                                :options="billTypeOptions"
                                                text-field="bill_type_name"
                                                value-field="bill_type_id"
                                                id="bill_type_id">
                                            </b-form-select>
                                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.masterData.bill_type_id.$error && !$v.formData.masterData.bill_type_id.required}">Bill type is required!</div>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Fiscal Year"
                                            label-for="fy_id"
                                            class="requiredField"
                                        >
                                            <b-form-select
                                                v-model="formData.masterData.fy_id"
                                                :options="fyOptions"
                                                @change="prMonthList(formData.masterData.fy_id)"
                                                text-field="pr_year"
                                                value-field="fy_id"
                                                id="fy_id">
                                            </b-form-select>
                                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.masterData.fy_id.$error && !$v.formData.masterData.fy_id.required}">Fiscal year is required!</div>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="PR Month"
                                            label-for="pr_month_id"
                                            class="requiredField"
                                        >
                                            <b-form-select
                                                v-model="formData.masterData.pr_month"
                                                :options="prMonthOptions"
                                                @change="getPrMonthId(formData.masterData.pr_month)"
                                                text-field="pr_month_name"
                                                value-field="pr_month"
                                                id="pr_month_id">
                                            </b-form-select>
                                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.masterData.pr_month.$error && !$v.formData.masterData.pr_month.required}">Payroll month is required!</div>
                                        </b-form-group>
                                    </b-col>


                                    <b-col md="6">
                                        <b-form-group
                                            label="Bill Date"
                                            label-for="bill_date"
                                            class="requiredField"
                                        >
                                            <date-picker
                                                v-model="formData.masterData.bill_date"
                                                width="100%"
                                                input-class="form-control"
                                                type="date"
                                                lang="en"
                                                name="bill_date"
                                                id="bill_date"
                                                :not-after="new Date()"
                                                :value-type="valueType"
                                                format="DD-MM-YYYY"
                                                :editable="false">
                                            </date-picker>
                                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.masterData.bill_date.$error && !$v.formData.masterData.bill_date.required}">Bill date is required!</div>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="6">
                                        <b-form-group
                                            label="Bill Status"
                                            label-for="bill_status_id"
                                            class="requiredField"
                                        >
                                            <b-form-select
                                                v-model="formData.masterData.bill_status_id"
                                                :options="billStatusOptions"
                                                text-field="status_name"
                                                value-field="bill_status_id"
                                                style="pointer-events: none"
                                                id="bill_status_id">
                                            </b-form-select>
                                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.masterData.bill_status_id.$error && !$v.formData.masterData.bill_status_id.required}">Bill status is required!</div>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="12">
                                        <b-form-group
                                            label="Description"
                                            label-for="bill_description"
                                        >
                                            <b-form-textarea
                                                v-model="formData.masterData.bill_description"
                                                id="bill_description">
                                            </b-form-textarea>
                                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.masterData.bill_description.$error && !$v.formData.masterData.bill_description.required}">Bill description is required!</div>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </fieldset>
                        </b-col>
                        <b-col>
                            <fieldset class="border pr-2 pl-2">
                                <legend class="w-auto">Others Information</legend>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                            label="GO No"
                                            label-for="go_no"
                                            class="requiredField"
                                        >
                                            <b-form-input
                                                v-model="formData.masterData.go_no"
                                                id="go_no">
                                            </b-form-input>
                                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.masterData.go_no.$error && !$v.formData.masterData.go_no.required}">GO number is required!</div>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="GO Date"
                                            label-for="go_date"
                                            class="requiredField"
                                        >
                                            <date-picker
                                                v-model="formData.masterData.go_date"
                                                width="100%"
                                                input-class="form-control"
                                                type="date"
                                                lang="en"
                                                name="go_date"
                                                id="go_date"
                                                :value-type="valueType"
                                                format="DD-MM-YYYY"
                                                :editable="false">
                                            </date-picker>
                                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.masterData.go_date.$error && !$v.formData.masterData.go_date.required}">GO date is required!</div>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Pay Advice No"
                                            label-for="pay_advice_no"
                                        >
                                            <b-form-input
                                                v-model="formData.masterData.pay_advice_no"
                                                id="pay_advice_no">
                                            </b-form-input>
                                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.masterData.pay_advice_no.$error && !$v.formData.masterData.pay_advice_no.required}">Pay advice number is required!</div>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Pay Advice Date"
                                            label-for="pay_advice_date"
                                        >
                                            <date-picker
                                                v-model="formData.masterData.pay_advice_date"
                                                width="100%"
                                                input-class="form-control"
                                                type="date"
                                                lang="en"
                                                name="pay_advice_date"
                                                id="pay_advice_date"
                                                :value-type="valueType"
                                                format="DD-MM-YYYY"
                                                :editable="false">
                                            </date-picker>
                                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.masterData.pay_advice_date.$error && !$v.formData.masterData.pay_advice_date.required}">Pay advice date is required!</div>
                                        </b-form-group>
                                    </b-col>


                                    <b-col md="6">
                                        <b-form-group
                                            label="Active Status"
                                            label-for="active_yn"
                                            class=""
                                        >
<!--                                            <b-form-select-->
<!--                                                v-model="formData.masterData.active_yn"-->
<!--                                                :options="booleanOptions"-->
<!--                                                id="active_yn">-->
<!--                                            </b-form-select>-->
<!--                                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.masterData.active_yn.$error && !$v.formData.masterData.active_yn.required}">Active status is required!</div>-->
                                            <b-form-input
                                                    readonly
                                                    v-model="formData.masterData.active_status"
                                                    id="active_yn">
                                            </b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                            label="Deputation"
                                            label-for="deputation_yn"
                                            class=""
                                        >
<!--                                            <b-form-select-->
<!--                                                v-model="formData.masterData.deputation_yn"-->
<!--                                                :options="booleanOptions"-->
<!--                                                id="deputation_yn">-->
<!--                                            </b-form-select>-->
<!--                                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.masterData.deputation_yn.$error && !$v.formData.masterData.deputation_yn.required}">Deputation is required!</div>-->
                                            <b-form-input
                                                    readonly
                                                    v-model="formData.masterData.deputation_status"
                                                    id="deputation_yn">
                                            </b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="12">
                                        <b-form-group
                                            label="Remarks"
                                            label-for="remarks"
                                        >
                                            <b-form-textarea
                                                v-model="formData.masterData.remarks"
                                                id="remarks">
                                            </b-form-textarea>
                                            <div :class="{'invalid-feedback':true ,'d-block':$v.formData.masterData.remarks.$error && !$v.formData.masterData.remarks.required}">Remarks is required!</div>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </fieldset>
                        </b-col>
                    </b-row>

                </b-card-body>
            </b-card>


            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Arrear Bill Details Info
                </b-card-header>
                <b-card-body class="border">
                    <b-row>
                        <b-col md="3">
                            <b-form-group
                                label="Bill Head"
                                label-for="bill_head_id"
                                class="requiredField"
                            >
                                <v-select
                                    id="bill_head_id"
                                    v-model="selectedBillHead"
                                    label="bill_head_name"
                                    :options="billHeadOptions">
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events" />
                                    </template>
                                </v-select>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.formData.detailsData.bill_head_id.$error && !$v.formData.detailsData.bill_head_id.required}">Bill head is required!</div>
                            </b-form-group>
                        </b-col>
                       <b-col md="3">
                            <b-form-group
                                label="Line Status"
                                label-for="line_status_yn"
                                class="requiredField"
                            >
                                <b-form-select
                                    v-model.trim="formData.detailsData.line_status_yn"
                                    :options="booleanOptions"
                                    id="line_status_yn">
                                </b-form-select>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.formData.detailsData.line_status_yn.$error && !$v.formData.detailsData.line_status_yn.required}">Line status is required!</div>
                            </b-form-group>
                        </b-col>
                        <b-col v-if="formData.detailsData.line_status_yn == 'Y'" md="3">
                            <b-form-group
                                label="Line Description"
                                label-for="line_description"
                            >
                                <b-form-textarea
                                    id="line_description"
                                    v-model="formData.detailsData.line_description">
                                </b-form-textarea>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.formData.detailsData.line_description.$error && !$v.formData.detailsData.line_description.required}">Line description is required!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="COA Code"
                                label-for="coa_code"
                            >
                                <b-form-input
                                    id="coa_code"
                                    type="number"
                                    readonly
                                    v-model="formData.detailsData.coa_code">
                                </b-form-input>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.formData.detailsData.coa_code.$error && !$v.formData.detailsData.coa_code.required}">COA code is required!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Amount"
                                label-for="amount"
                                class="requiredField"
                            >
                                <b-form-input
                                    type="number"
                                    class="text-right"
                                    id="amount"
                                    v-model="formData.detailsData.amount">
                                </b-form-input>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.formData.detailsData.amount.$error && !$v.formData.detailsData.amount.required}">Amount is required!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Deduction"
                                label-for="deduction_yn"
                            >
                                <b-form-input
                                    id="deduction_yn"
                                    readonly
                                    v-model="formData.detailsData.deduction">
                                </b-form-input>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.formData.detailsData.deduction_yn.$error && !$v.formData.detailsData.deduction_yn.required}">Deduction is required!</div>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Active"
                                label-for="active_yn"
                                class="requiredField"
                            >
                                <b-form-select
                                    v-model="formData.detailsData.active_yn"
                                    :options="booleanOptions"
                                    id="active_yn">
                                </b-form-select>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.formData.detailsData.active_yn.$error && !$v.formData.detailsData.active_yn.required}">Active status is required!</div>
                            </b-form-group>
                        </b-col>
                        <b-col :md="formData.detailsData.line_status_yn == 'Y'?3:6">
                            <b-form-group
                                label="Remarks"
                                label-for="remarks"
                            >
                                <b-form-textarea
                                    id="remarks"
                                    v-model.trim="formData.detailsData.remarks">
                                </b-form-textarea>
                                <div :class="{'invalid-feedback':true ,'d-block':$v.formData.detailsData.remarks.$error && !$v.formData.detailsData.remarks.required}">Remarks is required!</div>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col class="d-flex justify-content-end">
                            <b-button type='button' class="mr-1" @click="submit">Submit</b-button>
                            <b-button type='button' class="mr-1" @click="detailsDataReset" variant="warning">Details Reset</b-button>
                            <b-button type='button' @click="reset" variant="warning">All Reset</b-button>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>


            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Arrear Bill List</b-card-header>
                <b-card-body class="border">
                    <Datatable  :fields="fields" :totalList="totalLength" :small="true" :perPage="perPage" :items="items" >
                        <template v-slot:actions="{ rows }">
                            <b-button variant="light" size="sm" @click="renderModal(rows.item)"> View </b-button>
                            <b-button size="sm" @click="rows.toggleDetails">
                                {{ rows.detailsShowing ? 'Hide' : 'Show'}} Details
                            </b-button>
                            <b-button variant="primary" size="sm" v-if="rows.item.bill_status_id != 2" @click="showApprovalModal(rows.item)">Approve</b-button>
                            <b-button variant="success" size="sm" v-else>Approved</b-button>
                            <b-button variant="warning" size="sm" v-if="rows.item.bill_status_id == 0" @click="arrearMasterByBillNo(rows.item.bill_no)"> New Details </b-button>
                        </template>
                        <template #row-details="rows">
                            <b-card-body>
                                <b-table-simple >
                                    <b-thead>
                                        <b-tr>
                                            <b-th class="p-0">Head Name</b-th>
                                            <b-th class="p-0">Line Description</b-th>
                                            <b-th class="p-0">Deduction</b-th>
                                            <b-th class="p-0">Amount</b-th>
                                            <b-th class="p-0 text-center">Action</b-th>
                                        </b-tr>
                                    </b-thead>
                                    <b-tbody>
                                        <b-tr v-for="(item, i) in rows.rows.item.details" :key="i">
                                            <b-td class="p-0">
                                                <b-form-input v-model="item.bill_head.salary_head" readonly></b-form-input>
                                            </b-td>
                                            <b-td class="p-0">
                                                <b-form-textarea v-model="item.line_description" readonly></b-form-textarea>
                                            </b-td>
                                            <b-td class="p-0">
                                                <b-form-input :value="item.deduction_yn|deputation" readonly></b-form-input>
                                            </b-td>
                                            <b-td class="p-0">
                                                <b-form-input class="text-right" :value="Number(item.amount).toFixed(2)" readonly></b-form-input>
                                            </b-td>
                                            <b-td class="p-0 text-center">
                                                <b-button v-if="rows.rows.item.bill_status_id==0" @click="edit(rows.rows.item, item)" variant="warning">Edit</b-button>
                                            </b-td>
                                        </b-tr>
                                    </b-tbody>
                                </b-table-simple>
                                <b-button size="sm" @click="rows.rows.toggleDetails">Hide Details</b-button>
                            </b-card-body>

                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>

            <Approval
                :title="approveFormData.title"
                :group_id="approveFormData.group_id"
                :module_name_url="approveFormData.module_name_url"
                :item="approveFormData.items"
                :id="approveFormData.id"
                :showModal.sync="approveFormData.showModal"
                :datatable="datatable"
            >
            </Approval>


            <b-modal ref="detailsModal" size="xl" :ok-only="true" :hide-footer="true" title="Arrear Bill Details">
                <fieldset class="border pr-2 pl-2">
                    <legend class="w-auto">Master Information</legend>
                    <b-card>
                        <b-card-text>
                            <b-row>
                                <b-col md="3">
                                    <b-form-group
                                        label="Employee Code"
                                        label-for="emp_code"
                                    >
                                        <b-form-input
                                            id="emp_code"
                                            v-model="modalData.employee.emp_code"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Employee Name"
                                        label-for="emp_name"
                                    >
                                        <b-form-input
                                            id="emp_name"
                                            v-model="modalData.employee.emp_name"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Designation"
                                        label-for="designation"
                                    >
                                        <b-form-input
                                            id="designation"
                                            v-model="modalData.employee.designation.designation"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Section"
                                        label-for="dpt_section"
                                    >
                                        <b-form-input
                                            id="dpt_section"
                                            v-model="modalData.employee.section.dpt_section"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Department"
                                        label-for="department_name"
                                    >
                                        <b-form-input
                                            id="department_name"
                                            v-model="modalData.employee.department.department_name"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Division"
                                        label-for="dpt_division_name"
                                    >
                                        <b-form-input
                                            id="dpt_division_name"
                                            v-model="modalData.employee.dpt_division.dpt_division_name"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Deputation"
                                        label-for="deputation"
                                    >
                                        <b-form-input
                                            id="deputation"
                                            :value="modalData.employee.deputation_yn|deputation"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Bill Code"
                                        label-for="bill_code"
                                    >
                                        <b-form-input
                                            id="bill_code"
                                            v-model="modalData.bill_code"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Bill No"
                                        label-for="bill_no"
                                    >
                                        <b-form-input
                                            id="bill_no"
                                            v-model="modalData.bill_no"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="3">
                                    <b-form-group
                                        label="Area From Date"
                                        label-for="bill_from_date"
                                    >
                                        <b-form-input
                                            id="bill_from_date"
                                            :value="modalData.bill_from_date|dateFormat"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="3">
                                    <b-form-group
                                        label="Area To Date"
                                        label-for="bill_to_date"
                                    >
                                        <b-form-input
                                            id="bill_to_date"
                                            :value="modalData.bill_to_date|dateFormat"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col md="3">
                                    <b-form-group
                                        label="Bill Type"
                                        label-for="bill_type_name"
                                    >
                                        <b-form-input
                                            id="bill_type_name"
                                            v-model="modalData.bill_type.bill_type_name"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Fiscal Year"
                                        label-for="pr_year"
                                    >
                                        <b-form-input
                                            id="pr_year"
                                            v-model="modalData.pr_months.pr_year"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Month Name"
                                        label-for="pr_month_name"
                                    >
                                        <b-form-input
                                            id="pr_month_name"
                                            :value="modalData.pr_months.pr_month|months"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Bill Date"
                                        label-for="bill_date"
                                    >
                                        <b-form-input
                                            id="bill_date"
                                            :value="modalData.bill_date|dateFormat"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Status Name"
                                        label-for="status_name"
                                    >
                                        <b-form-input
                                            id="status_name"
                                            v-model="modalData.bill_status.status_name"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="GO No"
                                        label-for="go_no"
                                    >
                                        <b-form-input
                                            id="go_no"
                                            v-model="modalData.go_no"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="GO Date"
                                        label-for="go_date"
                                    >
                                        <b-form-input
                                            id="go_date"
                                            :value="modalData.go_date|dateFormat"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Pay Advice No"
                                        label-for="pay_advice_no"
                                    >
                                        <b-form-input
                                            id="pay_advice_no"
                                            v-model="modalData.pay_advice_no"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Pay Advice Date"
                                        label-for="pay_advice_date"
                                    >
                                        <b-form-input
                                            id="pay_advice_date"
                                            :value="modalData.pay_advice_date|dateFormat"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Active Status"
                                        label-for="master_active_yn"
                                    >
                                        <b-form-input
                                            id="master_active_yn"
                                            :value="modalData.active_yn|deputation"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Total Amount"
                                        label-for="total_amount"
                                    >
                                        <b-form-input
                                            id="total_amount"
                                            :state="true"
                                            class="text-right"
                                            :value="Number(modalData.total_amount).toFixed(2)"
                                            readonly
                                        >
                                        </b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Bill Description"
                                        label-for="bill_description"
                                    >
                                        <b-form-textarea
                                            id="bill_description"
                                            v-model="modalData.bill_description"
                                            readonly
                                        >
                                        </b-form-textarea>
                                    </b-form-group>
                                </b-col>
                                <b-col md="6">
                                    <b-form-group
                                        label="Remarks"
                                        label-for="master_remarks"
                                    >
                                        <b-form-textarea
                                            id="master_remarks"
                                            v-model="modalData.remarks"
                                            readonly
                                        >
                                        </b-form-textarea>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-card-text>
                    </b-card>

                </fieldset>
                <br>
                <fieldset class="border pr-2 pl-2">
                    <legend class="w-auto">Details Information</legend>
                    <b-card >
                        <b-card-text>
                            <b-table-simple >
                                <b-thead>
                                    <b-tr>
                                        <b-th class="p-0">Head Name</b-th>
                                        <b-th class="p-0">Line Description</b-th>
                                        <b-th class="p-0">Deduction</b-th>
                                        <b-th class="p-0">Amount</b-th>
                                    </b-tr>
                                </b-thead>
                                <b-tbody>
                                    <b-tr v-for="(detail, i) in modalData.details" :key="`${i}`">
                                        <b-td class="p-0">
                                            <b-form-input v-model="detail.bill_head.salary_head" readonly></b-form-input>
                                        </b-td>
                                        <b-td class="p-0">
                                            <b-form-textarea  v-model="detail.line_description" readonly></b-form-textarea>
                                        </b-td>
                                        <b-td class="p-0">
                                            <b-form-input :value="detail.deduction_yn|deputation" readonly></b-form-input>
                                        </b-td>
                                        <b-td class="p-0">
                                            <b-form-input class="text-right" :value="Number(detail.amount).toFixed(2)" readonly></b-form-input>
                                        </b-td>
                                    </b-tr>
                                </b-tbody>
                            </b-table-simple>
                        </b-card-text>
                    </b-card>

                </fieldset>
            </b-modal>
        </div>
    </div>
</template>

<script>
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import DatePicker from "vue2-datepicker";
    import moment from 'moment';
    import ApiRepository from "../../../Repository/ApiRepository";
    import Datatable from '../../../layouts/common/datatable';
    import Approval from "../../../layouts/common/Approval";
    const { required, requiredIf, maxLength, minLength, email } = require("vuelidate/lib/validators");

    export default {
        name: "arrear-bill-generate",
        components: {vSelect, vcss, DatePicker, Datatable, Approval},
        data() {
            return {
                to_date_after:'',
                approveFormData: {
                    title: "",
                    group_id: "",
                    module_name_url: "",
                    item: "",
                    id: "",
                    showModal: false
                },
                modalData: {
                    total_amount: '',
                    emp_code: '',
                    emp_name: '',
                    bill_master_id: '',
                    bill_no: '',
                    bill_description: '',
                    pr_month_id: '',
                    go_no: '',
                    go_date: '',
                    bill_date: '',
                    bill_type_id: '',
                    bill_code: '',
                    details: [],
                    employee: {
                        designation: {},
                        section: {
                            dpt_section: '',
                            dpt_section_bng: '',
                            dpt_section_id: '',
                            text: ''
                        },
                        dpt_division: {},
                        department: {}
                    },
                    pr_months: {},
                    bill_type: {
                        bill_type_name: ''
                    },
                    emp_id: '',
                    dpt_division_id: '',
                    division_name: '',
                    department_id: '',
                    department_name: '',
                    designation_name: '',
                    bill_status: {
                        status_name: ''
                    },
                    bill_status_id: 0,
                    master_active_yn: 'Y',
                    deputation_yn: 'Y',
                    remarks: '',
                    pay_advice_no: '',
                    pay_advice_date: '',
                    fy_id: '',
                    pr_month: '',
                    bill_details_id: '',
                    bill_head_id: '',
                    line_status_yn: '',
                    line_description: '',
                    coa_code: '',
                    amount: '',
                    deduction_yn: '',
                    deduction: '',
                    details_active_yn: 'Y',
                    details_remarks: '',
                    bill_from_date: '',
                    bill_to_date: ''
                },
                formData: {
                    masterData: {
                        bill_master_id: '',
                        bill_no: '',
                        bill_description: '',
                        pr_month_id: '',
                        go_no: '',
                        go_date: '',
                        bill_date: '',
                        bill_type_id: '',
                        bill_code: '',
                        emp_id: '',
                        emp_code: '',
                        dpt_division_id: '',
                        division_name: '',
                        department_id: '',
                        department_name: '',
                        designation_name: '',
                        bill_status_id: 0,
                        active_yn: 'Y',
                        active_status: 'Yes',
                        deputation_yn: 'N',
                        deputation_status: 'No',
                        remarks: '',
                        pay_advice_no: '',
                        pay_advice_date: '',
                        fy_id: '',
                        pr_month: '',
                        bill_from_date: '',
                        bill_to_date: ''
                    },
                    detailsData: {
                        bill_details_id: '',
                        bill_master_id: '',
                        bill_head_id: '',
                        line_status_yn: 'Y',
                        line_description: '',
                        coa_code: '',
                        amount: '',
                        deduction_yn: '',
                        deduction: '',
                        active_yn: 'Y',
                        remarks: ''
                    }
                },
                employeeOptions: [],
                booleanOptions: [
                    {value: 'Y', text: 'Yes'},
                    {value: 'N', text: 'No'}
                ],
                billTypeOptions: [],
                billHeadOptions: [],
                billStatusOptions: [],
                fyOptions: [],
                prMonthOptions: [],
                selectedEmployee: {
                    option_name: '',
                    emp_id: '',
                    emp_code: '',
                    dpt_division_id: '',
                    dpt_division: {
                        text: ''
                    },
                    dpt_department_id: '',
                    department: {
                        text: ''
                    },
                    designation: {
                        text: ''
                    },
                    bill_code: '',
                    section: {
                        text: ''
                    }
                },
                selectedBillHead: {
                    bill_head_id: '',
                    bill_head_name: '',
                    coa_code: '',
                    deduction_yn: ''
                },
                emp_id: '',
                valueType: this.dateFormatter(),
                items: [],
                fields: [
                    {key: 'index', label: 'Sl'},
                    {key: 'bill_no', label: 'Bill No'},
                    {key: 'employee.emp_code', label: 'Employee Code'},
                    {key: 'employee.emp_name', label: 'Employee Name'},
                    {key: 'bill_code', label: 'Bill Code'},
                    {key: 'pr_months.pr_year', label: 'Year'},
                    {
                        key: 'pr_months.pr_month',
                        formatter: value => {
                            if(value == 1) {
                                return 'JULY'
                            } else if(value == 2){
                                return 'AUGUST'
                            }else if(value == 3){
                                return 'SEPTEMBER'
                            }else if(value == 4){
                                return 'OCTOBER'
                            }else if(value == 5){
                                return 'NOVEMBER'
                            }else if(value == 6){
                                return 'DECEMBER'
                            }else if(value == 7){
                                return 'JANUARY'
                            }else if(value == 8){
                                return 'FEBRUARY'
                            }else if(value == 9){
                                return 'MARCH'
                            }else if(value == 10){
                                return 'APRIL'
                            }else if(value == 11){
                                return 'MAY'
                            }else if(value == 12){
                                return 'JUNE'
                            }else {
                                return ''
                            }
                        },
                        label: 'Month'},
                    {
                        key: 'total_amount',
                        label: 'Total Amount',
                        formatter: value => {
                            if (value){
                                return  Number(value).toFixed(2)
                            } else {
                                return ''
                            }
                        },
                        class:'text-right'
                    },
                    {
                        key: 'workflow_process',
                        label: 'Current Step',
                        formatter: value => {
                            if (value){
                                return  value.workflow_step.workflow
                            } else {
                                return 'Initial Stage'
                            }
                        },
                        class:'text-center'
                    },
                    {key: 'bill_status.status_name', label: 'Status'},

                    {key: 'action'}
                ],
                totalLength: 1,
                perPage: 5
            }
        },
        validations: {
            formData: {
                masterData: {
                    bill_master_id: {},
                    bill_no: {required},
                    bill_description: {},
                    pr_month_id: {required},
                    go_no: {required},
                    go_date: {required},
                    bill_date: {required},
                    bill_type_id: {required},
                    bill_code: {},
                    emp_id: {required},
                    emp_code: {},
                    dpt_division_id: {},
                    department_id: {},
                    bill_status_id: {required},
                    active_yn: {required},
                    deputation_yn: {required},
                    remarks: {},
                    pay_advice_no: {},
                    pay_advice_date: {},
                    fy_id: {required},
                    pr_month: {required},
                    bill_from_date: {required},
                    bill_to_date: {required}
                },
                detailsData: {
                    bill_details_id: {},
                    bill_master_id: {},
                    bill_head_id: {required},
                    line_status_yn: {required},
                    line_description: {},
                    coa_code: {},
                    amount: {required},
                    deduction_yn: {},
                    active_yn: {required},
                    remarks: {}
                }
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty")
            this.$store.commit("setBreadcrumb", { link: "#", label: "Payroll" })
            this.$store.commit("setBreadcrumb", { link: "#", label: "Arrear Bill" })
            this.fyList()
            this.billStatusList()
            this.billHeadList()
            this.billTypeList()
            this.datatable();
        },
        filters: {
            months : function (value) {
                if(value == 1) {
                    return 'JULY'
                } else if(value == 2){
                    return 'AUGUST'
                }else if(value == 3){
                    return 'SEPTEMBER'
                }else if(value == 4){
                    return 'OCTOBER'
                }else if(value == 5){
                    return 'NOVEMBER'
                }else if(value == 6){
                    return 'DECEMBER'
                }else if(value == 7){
                    return 'JANUARY'
                }else if(value == 8){
                    return 'FEBRUARY'
                }else if(value == 9){
                    return 'MARCH'
                }else if(value == 10){
                    return 'APRIL'
                }else if(value == 11){
                    return 'MAY'
                }else if(value == 12){
                    return 'JUNE'
                }else {
                    return ''
                }
            },
            deputation: function (value) {
                if(value == 'Y'){
                    return 'YES'
                } else if(value == 'N') {
                    return 'NO'
                } else {
                    return ''
                }
            },
            dateFormat(value) {
                if (value) {
                    return moment(String(value)).format('MM/DD/YYYY')
                }
            }
        },
        watch: {
            'approveFormData.showModal':function(val, oldVal) {
                if(val === 'false') {
                    this.datatable()
                }
            },
            selectedEmployee: function (val, oldVal) {
                if (val != null){
                    this.formData.masterData.emp_id = val.emp_id
                    this.formData.masterData.emp_code = val.emp_code
                    this.formData.masterData.dpt_division_id = val.dpt_division_id
                    this.formData.masterData.division_name = val.dpt_division.text
                    this.formData.masterData.department_id = val.dpt_department_id
                    this.formData.masterData.department_name = val.department.text
                    this.formData.masterData.designation_name = val.designation.text
                    this.formData.masterData.bill_code = val.bill_code
                    this.formData.masterData.section_name = val.section != null ? val.section.text : ''
                }
            },
            selectedBillHead: function (val, oldVal) {
                if (val != null){
                    this.formData.detailsData.bill_head_id = val.bill_head_id
                    this.formData.detailsData.deduction_yn = val.deduction_yn
                    this.formData.detailsData.deduction = val.deduction
                    this.formData.detailsData.coa_code = val.coa_code
                }
            }
        },
        methods: {
            getSelectedDate(event){
                console.log(event);
                this.to_date_after = event;
            },
            datatable() {
                ApiRepository.callApi(ApiRepository.POST_COMMAND,`/payroll/arrear-details-list`, this.formData.masterData).then( res => {
                    if (res.data.length > 0){
                        this.items = res.data
                        this.totalLength = res.data.length
                    }
                })
            },
            submit() {
                this.$v.$touch()
                this.$v.formData.masterData.$touch()
                this.$v.formData.detailsData.$touch()
                if(!this.$v.formData.masterData.$invalid && !this.$v.formData.detailsData.$invalid){
                    ApiRepository.callApi(ApiRepository.POST_COMMAND,`/payroll/arrear-bill`, this.formData).then( res => {
                        if(res.data.o_status_code == 1){
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'})
                            this.formData.masterData.bill_master_id = res.data.bill_master_id.value
                            this.detailsDataReset()
                            this.datatable()
                            this.formData.masterData.bill_master_id = res.data.bill_master_id.value == undefined? res.data.bill_master_id: res.data.bill_master_id.value
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                        }
                    })
                }

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
            searchEmployee(name){
                if (name) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/search-employee/${name}`).then(res => {
                        this.employeeOptions = res.data;
                    })
                }
            },
            fyList(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/fy-list`).then(res => {
                    this.fyOptions = res.data;
                    this.formData.masterData.fy_id = res.data.filter(a => a.current_yn == 'Y')[0].fy_id
                    this.prMonthList(this.formData.masterData.fy_id)
                })
            },
            prMonthList(id){
                this.formData.masterData.pr_month = ''
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/pr-month-list/${id}`).then(res => {
                    this.prMonthOptions = res.data;
                })
            },
            getPrMonthId(id){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/get-pr-month-id/${this.formData.masterData.fy_id}/${id}`).then(res => {
                    this.formData.masterData.pr_month_id = res.data[0].pr_month_id;
                })
            },
            arrearMasterByBillNo(billNo){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/arrear-master-by-bill-no/${billNo}`).then(res => {
                    if(res.data.length > 0){
                        this.formData.masterData.bill_master_id = res.data[0].bill_master_id
                        this.datatable()
                        this.formData.masterData.bill_date = res.data[0].bill_date
                        this.formData.masterData.bill_no = res.data[0].bill_no
                        this.formData.masterData.section_name = res.data[0].dpt_section
                        this.formData.masterData.bill_code = res.data[0].bill_code
                        this.formData.masterData.bill_status_id = res.data[0].bill_status_id
                        this.formData.masterData.bill_description = res.data[0].bill_description
                        this.formData.masterData.go_no = res.data[0].go_no
                        this.formData.masterData.go_date = res.data[0].go_date
                        this.formData.masterData.pay_advice_no = res.data[0].pay_advice_no
                        this.formData.masterData.pay_advice_date = res.data[0].pay_advice_date
                        this.formData.masterData.active_yn = res.data[0].active_yn
                        this.formData.masterData.deputation_yn = res.data[0].deputation_yn
                        this.formData.masterData.remarks = res.data[0].remarks
                        this.formData.masterData.bill_type_id = res.data[0].bill_type_id
                        this.formData.masterData.fy_id = res.data[0].fy_id
                        this.formData.masterData.department_name = res.data[0].department_name
                        this.formData.masterData.designation_name = res.data[0].designation
                        this.formData.masterData.division_name = res.data[0].dpt_division_name
                        this.formData.masterData.emp_id = res.data[0].emp_id
                        this.formData.masterData.emp_code = res.data[0].emp_code
                        this.selectedEmployee.option_name = res.data[0].option_name
                        this.selectedEmployee.emp_id = res.data[0].emp_id
                        this.prMonthList(res.data[0].fy_id)
                        this.formData.masterData.pr_month = res.data[0].pr_month
                        this.getPrMonthId(res.data[0].pr_month)
                        this.detailsDataReset()
                    }

                })
            },

            billHeadList() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/bill-head-list`).then(res => {
                    this.billHeadOptions = res.data;
                })
            },
            billTypeList() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/bill-type-list`).then(res => {
                    this.billTypeOptions = res.data;
                })
            },
            billStatusList(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/payroll/bill-status-list`).then(res => {
                    this.billStatusOptions = res.data;
                })
            },
            reset(){
                this.masterDataReset()
                this.detailsDataReset()
            },
            masterDataReset(){
                this.formData.masterData = {
                    bill_master_id: '',
                    bill_no: '',
                    bill_description: '',
                    pr_month_id: '',
                    go_no: '',
                    go_date: '',
                    bill_date: '',
                    bill_type_id: '',
                    bill_code: '',
                    emp_id: '',
                    emp_code: '',
                    dpt_division_id: '',
                    division_name: '',
                    department_id: '',
                    department_name: '',
                    designation_name: '',
                    bill_status_id: 0,
                    active_yn: 'Y',
                    deputation_yn: 'Y',
                    remarks: '',
                    pay_advice_no: '',
                    pay_advice_date: '',
                    fy_id: '',
                    pr_month: ''
                }
                this.selectedEmployee = {
                    option_name: '',
                    emp_id: ''
                }
                this.$v.$reset()
            },
            detailsDataReset(){
                this.selectedBillHead = {
                    bill_head_id: '',
                    bill_head_name: '',
                    coa_code: '',
                    deduction_yn: ''
                }
                this.formData.detailsData = {
                    bill_details_id: '',
                    bill_master_id: '',
                    bill_head_id: '',
                    line_status_yn: 'Y',
                    line_description: '',
                    coa_code: '',
                    amount: '',
                    deduction_yn: '',
                    deduction: '',
                    active_yn: 'Y',
                    remarks: ''
                }
                this.$v.$reset()
            },
            renderModal(item){
                this.$refs['detailsModal'].show()
                this.modalData = {
                    active_yn: item.active_yn,
                    total_amount: item.total_amount,
                    bill_master_id: item.bill_master_id,
                    bill_no: item.bill_no,
                    bill_description: item.bill_description,
                    pr_month_id: item.pr_month_id,
                    go_no: item.go_no,
                    go_date: item.go_date,
                    bill_date: item.bill_date,
                    bill_type_id: item.bill_type_id,
                    bill_code: item.bill_code,
                    details: item.details,
                    employee: {
                        deputation_yn: item.employee.deputation_yn,
                        emp_code: item.employee.emp_code,
                        emp_name: item.employee.emp_name,
                        designation: item.employee.designation,
                        section: {
                            dpt_section: item.employee.section ? item.employee.section.dpt_section: '',
                            dpt_section_bng: item.employee.section ? item.employee.section.dpt_section_bng: '',
                            dpt_section_id: item.employee.section ? item.employee.section.dpt_section_id: '',
                            text: item.employee.section ? item.employee.section.text: ''
                        },
                        dpt_division: item.employee.dpt_division,
                        department: item.employee.department
                    },
                    pr_months: item.pr_months,
                    bill_type: {
                        bill_type_name: item.bill_type.bill_type_name
                    },
                    emp_id: item.emp_id,
                    emp_code: item.emp_code,
                    dpt_division_id: item.dpt_division_id,
                    division_name: item.division_name,
                    department_id: item.department_id,
                    department_name: item.department_name,
                    designation_name: item.designation_name,
                    bill_status: {
                        status_name: item.bill_status.status_name
                    },
                    bill_status_id: item.bill_status_id,
                    deputation_yn: item.deputation_yn,
                    remarks: item.remarks,
                    pay_advice_no: item.pay_advice_no,
                    pay_advice_date: item.pay_advice_date,
                    fy_id: item.fy_id,
                    pr_month: item.pr_month,
                    bill_details_id: item.bill_details_id,
                    bill_head_id: item.bill_head_id,
                    line_status_yn: item.line_status_yn,
                    line_description: item.line_description,
                    coa_code: item.coa_code,
                    amount: item.amount,
                    deduction_yn: item.deduction_yn,
                    deduction: item.deduction,
                    bill_from_date: item.bill_from_date,
                    bill_to_date: item.bill_to_date
                }

            },
            edit(masterData, detailData){
                // Mater Data
                this.formData.masterData.bill_master_id = masterData.bill_master_id
                this.selectedEmployee = {
                    emp_code: masterData.employee.emp_code,
                    emp_id: masterData.employee.emp_id,
                    emp_name: masterData.employee.emp_name,
                    option_name: masterData.employee.option_name,
                    dpt_division_id: masterData.employee.dpt_division.dpt_division_id,
                    dpt_division: {
                        text: masterData.employee.dpt_division.text
                    },
                    dpt_department_id: masterData.employee.department.department_id,
                    department: {
                        text: masterData.employee.department.department_name
                    },
                    designation: {
                        text: masterData.employee.designation.designation
                    },
                    bill_code: masterData.employee.bill_code,
                    section: {
                        text: masterData.employee.section?masterData.employee.section.dpt_section:null
                    }
                }
                this.formData.masterData.bill_date = masterData.bill_date
                this.formData.masterData.bill_no = masterData.bill_no
                this.formData.masterData.bill_code = masterData.bill_code
                this.formData.masterData.bill_status_id = masterData.bill_status_id
                this.formData.masterData.bill_description = masterData.bill_description
                this.formData.masterData.go_no = masterData.go_no
                this.formData.masterData.go_date = masterData.go_date
                this.formData.masterData.pay_advice_no = masterData.pay_advice_no
                this.formData.masterData.pay_advice_date = masterData.pay_advice_date
                this.formData.masterData.active_yn = masterData.active_yn
                this.formData.masterData.active_status = masterData.active_yn == 'Y' ? 'Yes' : 'No'
                this.formData.masterData.deputation_yn = masterData.deputation_yn
                this.formData.masterData.deputation_status = masterData.deputation_yn == 'Y' ? 'Yes' : 'No'
                this.formData.masterData.remarks = masterData.remarks
                this.formData.masterData.bill_type_id = masterData.bill_type_id
                this.formData.masterData.fy_id = masterData.pr_months.fy_id
                this.prMonthList(masterData.pr_months.fy_id)
                this.formData.masterData.pr_month = masterData.pr_months.pr_month
                this.getPrMonthId(masterData.pr_months.pr_month)

                // Details Data
                this.formData.detailsData.bill_details_id = detailData.bill_details_id
                this.selectedBillHead = {
                    bill_head_id: detailData.bill_head.value,
                    bill_head_name: detailData.bill_head.text,
                    deduction_yn: detailData.bill_head.deduction_yn,
                    coa_code: detailData.bill_head.coa_code,
                    deduction: detailData.bill_head.deduction_yn == 'Y' ? 'Yes' : 'No'
                }
                this.formData.detailsData.active_yn = detailData.active_yn
                this.formData.detailsData.line_description = detailData.line_description
                this.formData.detailsData.line_status_yn = detailData.line_status_yn
                this.formData.detailsData.amount = detailData.amount
                this.formData.detailsData.remarks = detailData.remarks

            },
            showApprovalModal(item) {
                this.approveFormData = {
                    title: "Arrear bill approval process",
                    group_id: item.bill_type.approval_workflow_id,
                    module_name_url: "arrear-bill",
                    item: item,
                    id: item.bill_master_id,
                    showModal: true
                }
            }
        }
    }
</script>

<style scoped>
    select.form-control[multiple], select.form-control[size], textarea.form-control {
        height:2.6rem;
    }

    legend{
        font-size: 1rem;
    }
    a {
        color: #444;
    }
    .form-control.is-valid, .was-validated .form-control:valid{
        background-image: url()!important;
    }
    select.form-control[multiple][data-v-397e62f8], select.form-control[size][data-v-397e62f8], .forSmall.form-control[data-v-397e62f8] {
        height: 2.05rem;
    }
</style>
