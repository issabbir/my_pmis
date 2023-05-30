<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Employees
                    <b-button class="float-right" variant="success" size="sm" v-b-modal.employee_modal>ADD NEW
                    </b-button>
                </b-card-header>
                <b-card-body class="border">
                    <b-row>
                        <b-col md="6">
                            <b-form-group label="Department" label-for="department" class="requiredField">
                                <b-form-select

                                    v-model="pensionHeadObj.department_id"
                                    :options="departmentList"
                                    name="department"
                                    required
                                ></b-form-select>

                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                id="pensionCat"
                                label="Employee Type"
                            >
                                <b-form-select v-model="pensionHeadObj.emp_type" name="empType"  @change="selectempType"
                                               :options="empTypeOption"
                                               label="text">
                                </b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group label="Employee Code" label-for="emp_code">
                                <v-select
                                    label="option_name"
                                    v-model="selectedPensionEmployee"
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
                        <b-col md="6">
                            <b-form-group
                                id="pensionCat"
                                label="Pension category"
                            >
                                <b-form-select v-model="pensionHeadObj.pensionCat" name="pensionCat" @change="selectPensionCat"
                                               :options="pensionCatOption"
                                               label="text" required>
                                </b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="6">
                            <b-form-group
                                id="onPension"
                                label="On Pension"
                            >
                                <b-form-select v-model="pensionHeadObj.on_pension_yn" name="onPension"
                                               :options="pensionOptions"
                                               label="text">
                                </b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" class="text-right float-right mt-2">
                             <button class="btn btn-primary" @click="searchEmployeeData">Search</button>
                        </b-col>
                    </b-row>

                    <hr class="my-3">

                    <Datatable v-bind:fields="fields" v-bind:items="loadTableData" :perPage="perPage"
                               :totalList="totalDataList" :update="doRefresh">
                        <template v-slot:action2="{ rows }">
                                  <span v-if="rows.item.on_pension_yn == 'Y'" class="text-success text-center">Yes</span>
                                  <span class="text-danger text-center" v-else>No</span>
                         </template>
                        <template v-slot:actions="{ rows }">
                            <b-link ml="4" class="text-primary text-center" v-b-modal.modal-center
                                    @click="editRow(rows.item)">
                                <i class="bx bx-edit cursor-pointer"></i>
                            </b-link>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>

            <b-modal ref="employee_modal" id="employee_modal" size="xl" @close="onReset" @cancel="onReset"
                     @ok="onSubmit" title="Employee Modification">
                <fieldset class="p-1" style="border: 1px #000000 solid;">
                    <b-form-radio-group
                            v-model="selectedCheck"
                            :options="optionsCheck"
                            class="mb-2"
                            value-field="item"
                            text-field="name"
                            disabled-field="notEnabled"
                    ></b-form-radio-group>
                    <b-row>
                        <b-col md="3">
                            <b-form-group
                                label="Employee Code"
                                label-for="emp_code"
                            >
                                <b-form-input
                                    id="emp_code"
                                    :readonly="formData.emp_id?true:false"
                                    v-model="formData.emp_code"
                                    @change="getEmpDataByCode"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Employee Name"
                                label-for="emp_name"
                            >
<!--                                <b-form-input-->
<!--                                    id="emp_name"-->
<!--                                    :readonly="formData.emp_id?true:false"-->
<!--                                    v-model="formData.emp_name"-->
<!--                                ></b-form-input>-->
                                <b-form-input
                                    id="emp_name"
                                    v-model="formData.emp_name"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                    label="Department"
                                    label-for="department"
                            >
                                <v-select v-model="selectedDepartment" name="department"
                                          :options="departmentOptions"
                                          label="text" required>
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                    </template>
                                </v-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                    label="Designation"
                                    label-for="designation"
                            >
                                <v-select v-model="selectedDesignation" name="designation"
                                          :options="designationOptions"
                                          label="text" required>
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                    </template>
                                </v-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                    label="Employee Type"
                                    label-for="emp_type"
                            >
                                <!--<b-form-select v-model="selectedEmpType" name="emp_type"
                                               :options="empTypeOptions"
                                               label="text" required>
                                </b-form-select>-->
                                <v-select v-model="selectedEmpType" name="emp_type"
                                          :options="empTypeOptions"
                                          label="text" required>
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                    </template>
                                </v-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                    label="Pension Category"
                                    label-for="pension_category"
                            >
                                <b-form-select v-model="selectedPensionCat" name="pension_category"
                                               :options="pensionCatOption"
                                               label="text" required>
                                </b-form-select>

                                <!--                                <v-select v-model="selectedPensionCat" name="pensionCatOption"-->
                                <!--                                          :options="pensionCatOption"-->
                                <!--                                          label="text" required>-->
                                <!--                                    <template #search="{attributes, events}">-->
                                <!--                                        <input class="vs__search" v-bind="attributes" v-on="events"/>-->
                                <!--                                    </template>-->
                                <!--                                </v-select>-->
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                    label="Genders"
                                    label-for="emp_gender_id"
                            >
                                <v-select v-model="selectedGender" name="emp_gender_id"
                                          :options="genderOptions"
                                          label="text" required>
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                    </template>
                                </v-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                    label="Religion"
                                    label-for="religion"
                            >
                                <v-select v-model="selectedReligion" name="religion"
                                          :options="religionOptions"
                                          label="text" required>
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                    </template>
                                </v-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                    label="Mobile No"
                                    label-for="mobile_no"
                            >
                                <b-form-input
                                        id="mobile_no"
                                        class="text-left"
                                        v-model="formData.emp_contact_no"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                    label="NID"
                                    label-for="nid"
                            >
                                <b-form-input
                                        id="emp_nid"
                                        class="text-left"
                                        v-model="formData.emp_nid_no"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                    label="Bank Account"
                                    label-for="bank_acc_no"
                            >
                                <b-form-input
                                        id="bank_acc_no"
                                        class="text-left"
                                        v-model="formData.bank_acc_no"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                    label="Blood Group"
                                    label-for="blood_group"
                            >
                                <v-select v-model="selectedBloodGroup" name="blood_group"
                                          :options="bloodGroupOptions"
                                          label="text" required>
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                    </template>
                                </v-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                label="Birth Date"
                                label-for="emp_dob"
                            >
                                <date-picker
                                    width="100%"
                                    input-class="form-control"
                                    v-model="formData.emp_dob"
                                    type="date"
                                    lang="en"
                                    :editable="false"
                                    :value-type="valueType"
                                    format="DD-MM-YYYY"
                                    required>
                                </date-picker>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                label="Join Date"
                                label-for="emp_join_date"
                            >
                                <date-picker
                                    width="100%"
                                    input-class="form-control"
                                    v-model="formData.emp_join_date"
                                    type="date"
                                    lang="en"
                                    :editable="false"
                                    format="DD-MM-YYYY"
                                    :value-type="valueType"
                                    required>
                                </date-picker>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                label="LPR Date"
                                label-for="emp_lpr_date"
                            >
                                <date-picker
                                    width="100%"
                                    input-class="form-control"
                                    v-model="formData.emp_lpr_date"
                                    type="date"
                                    lang="en"
                                    :editable="false"
                                    :value-type="valueType"
                                    format="DD-MM-YYYY"
                                    required>
                                </date-picker>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                    label="Retirement Date"
                                    label-for="retirement_date"
                            >
                                <date-picker
                                        width="100%"
                                        input-class="form-control"
                                        v-model="formData.retirement_date"
                                        type="date"
                                        lang="en"
                                        :editable="false"
                                        format="DD-MM-YYYY"
                                        :value-type="valueType"
                                        required>
                                </date-picker>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                    label="Pension Start Date"
                                    label-for="pension_start_date"
                            >
                                <date-picker
                                        width="100%"
                                        input-class="form-control"
                                        v-model="formData.pension_start_date"
                                        type="date"
                                        lang="en"
                                        :editable="false"
                                        :value-type="valueType"
                                        format="DD-MM-YYYY"
                                        required>
                                </date-picker>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                    label="Pension End Date"
                                    label-for="pension_end_date"
                            >
                                <date-picker
                                        width="100%"
                                        input-class="form-control"
                                        v-model="formData.pension_end_date"
                                        type="date"
                                        lang="en"
                                        :editable="false"
                                        :value-type="valueType"
                                        format="DD-MM-YYYY"
                                        required>
                                </date-picker>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                    label="Death Date"
                                    label-for="death_date"
                            >
                                <date-picker
                                        width="100%"
                                        input-class="form-control"
                                        v-model="formData.death_date"
                                        type="date"
                                        lang="en"
                                        :editable="false"
                                        :value-type="valueType"
                                        format="DD-MM-YYYY"
                                        required>
                                </date-picker>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                label="Medical Book ID"
                                label-for="emp_medical_book_id"
                            >
                                <b-form-input id="emp_medical_book_id"
                                              v-model="formData.emp_medical_book_id"></b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                label="Quota"
                                label-for="quota"
                            >
                                <v-select v-model="selectedQuota" name="quota"
                                          :options="quotaOptions"
                                          label="text" required>
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                    </template>
                                </v-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                label="Grade"
                                label-for="grade"
                            >
                                <v-select v-model="selectedGrade" name="grade"
                                          :options="gradeOptions"
                                          label="text" required>
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                    </template>
                                </v-select>
                            </b-form-group>
                        </b-col>

                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                label="Employee Class"
                                label-for="class"
                            >
                                <v-select v-model="selectedClass" name="class"
                                          :options="classOptions"
                                          label="text" required>
                                    <template #search="{attributes, events}">
                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                    </template>
                                </v-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group label="Tribal" v-slot="{ ariaDescribedby }">
                                <b-form-radio-group
                                    id="tribal_yn"
                                    v-model="formData.tribal_yn"
                                    :options="booleanOptions"
                                    :aria-describedby="ariaDescribedby"
                                    name="radio-options"
                                ></b-form-radio-group>
                            </b-form-group>
                        </b-col>
<!--                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">-->
<!--                            <b-form-group-->
<!--                                label="On Pension"-->
<!--                                label-for="on_pension_yn"-->
<!--                            >-->
<!--                                <b-form-input-->
<!--                                    id="on_pension_yn"-->
<!--                                    readonly-->
<!--                                    v-model="formData.pension_status"-->
<!--                                ></b-form-input>-->
<!--                            </b-form-group>-->
<!--                        </b-col>-->
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group label="On Pension" v-slot="{ ariaDescribedby2 }">
                                <b-form-radio-group
                                    id="pension_status"
                                    v-model="formData.on_pension_yn"
                                    :options="pensionOptions"
                                    :aria-describedby="ariaDescribedby2"
                                    name="pension-options"
                                ></b-form-radio-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                label="Monthly Payable Amount"
                                label-for="monthly_payable_amount"
                            >
                                <b-form-input
                                    id="monthly_payable_amount"
                                    class="text-right"
                                    readonly
                                    number
                                    v-model="monthly_payable_amount"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col md="6"></b-col>
                        <b-col md="6" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <fieldset class="p-1" style="border: 1px #000000 solid;">
                                <legend>Allowance</legend>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                                label="Old Pension Amount"
                                                label-for="old_pension_amt"
                                        >
                                            <b-form-input
                                                    id="old_pension_amt"
                                                    class="text-right"
                                                    number
                                                    v-model="formData.old_pension_amt"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                                label="Pension Amount"
                                                label-for="pension_amt"
                                        >
                                            <b-form-input
                                                    id="pension_amt"
                                                    class="text-right"
                                                    number
                                                    v-model="formData.pension_amt"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                                label="Medical Allowance"
                                                label-for="medical_allow"
                                        >
                                            <b-form-input
                                                    id="medical_allow"
                                                    class="text-right"
                                                    number
                                                    v-model="formData.medical_allow"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                                label="DR Allowance"
                                                label-for="dearness_allow"
                                        >
                                            <b-form-input
                                                    id="dearness_allow"
                                                    class="text-right"
                                                    v-model="formData.dearness_allow"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </fieldset>
                            <b-row class="mt-1">
                                <b-col md="12">
                                    <b-form-group
                                            label="Net Pay:"
                                            label-for="foreign_ta_da_ded" class="text-left"
                                    >
                                        <b-form-input
                                                id="foreign_ta_da_ded" v-model="net_pay"
                                                class="text-right" readonly
                                        ></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-col>
                        <b-col md="6" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <fieldset class="p-1" style="border: 1px #000000 solid;">
                                <legend>Deduction</legend>
                                <b-row>
                                    <b-col md="6">
                                        <b-form-group
                                                label="IT Con. Fee Deduction"
                                                label-for="it_con_fee_ded"
                                        >
                                            <b-form-input
                                                    id="it_con_fee_ded"
                                                    class="text-right"
                                                    number
                                                    v-model="formData.it_con_fee_ded"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                                label="Over Pay & Over Fix. Deduction"
                                                label-for="over_pay_fix_ded"
                                        >
                                            <b-form-input
                                                    id="over_pay_fix_ded"
                                                    class="text-right"
                                                    number
                                                    v-model="formData.over_pay_fix_ded"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                                label="PRL Incentive Bounus Deduction"
                                                label-for="prl_inc_bon_ded"
                                        >
                                            <b-form-input
                                                    id="prl_inc_bon_ded"
                                                    class="text-right"
                                                    number
                                                    v-model="formData.prl_inc_bon_ded"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                                label="Miscellaneous Deduction"
                                                label-for="miscellaneous_ded"
                                        >
                                            <b-form-input
                                                    id="miscellaneous_ded"
                                                    class="text-right"
                                                    v-model="formData.miscellaneous_ded"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="6">
                                        <b-form-group
                                                label="Foreign TA/DA Deduction"
                                                label-for="foreign_ta_da_ded"
                                        >
                                            <b-form-input
                                                    id="foreign_ta_da_ded"
                                                    class="text-right"
                                                    v-model="formData.foreign_ta_da_ded"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
                            </fieldset>

                        </b-col>


                        <b-col md="12" v-if="selectedCheck == 'all' || selectedCheck == 'nominee'">
                            <fieldset class="p-1" style="border: 1px #000000 solid;">
                                <legend>Nominee</legend>
<!--                                <pension-nominee    @submitted="loadData" :nominees="items" :relationOptions="relationOptions"></pension-nominee>-->
                                    <b-card title="Nominee">
                                        <b-card-body class="border">
                                            <b-form @submit.prevent="onSubmitted" @reset.prevent="onReset" >
                                                <b-row>
<!--                                                    <b-col md="3">-->
<!--                                                        <b-form-group-->
<!--                                                            label="Code"-->
<!--                                                            label-for="nominee_code"  class="requiredField"-->
<!--                                                        >-->
<!--                                                            <b-form-input-->
<!--                                                                readonly-->
<!--                                                                id="nominee_name"-->
<!--                                                                name="nominee_name"-->
<!--                                                                v-model="nominee.nominee_code"-->
<!--                                                                type="text"-->
<!--                                                                :maxlength="200"-->
<!--                                                            ></b-form-input>-->
<!--                                                        </b-form-group>-->
<!--                                                    </b-col>-->

                                                    <b-col md="3">
                                                        <b-form-group
                                                            label="Name"
                                                            label-for="nominee_name"  class="requiredField"
                                                        >
                                                            <b-form-input
                                                                id="nominee_name"
                                                                name="nominee_name"
                                                                v-model="nominee.nominee_name"
                                                                type="text"
                                                                :maxlength="200"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group
                                                            label="Relationship"
                                                            label-for="relationship_nominee"  class="requiredField"
                                                        >
                                                            <v-select v-model="relationships" :options="relationOptions"
                                                                      name="relationship_nominee" id="relationship_nominee" label="text"
                                                                      class="uppercase">
                                                                <template #search="{attributes, events}">
                                                                    <input
                                                                        class="vs__search"
                                                                        v-bind="attributes"
                                                                        v-on="events"
                                                                    />
                                                                </template>
                                                            </v-select>
                                                        </b-form-group>
                                                    </b-col>


                                                    <b-col md="3">
                                                        <b-form-group
                                                            label="Contact No."
                                                            label-for="contact_no"
                                                        >
                                                            <b-form-input
                                                                id="contact_no"
                                                                v-model="nominee.nominee_contact_no"
                                                                type="text"
                                                                name="nominee_contact_no"
                                                                v-validate="{ numeric: true, regex: /^01[5-9]\d{8}$/ }"
                                                                :maxlength="15"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
<!--                                                    <b-col md="3">-->
<!--                                                        <b-form-group-->
<!--                                                            label="E-mail"-->
<!--                                                            label-for="nominee_email"-->
<!--                                                        >-->
<!--                                                            <b-form-input-->
<!--                                                                id="nominee_email"-->
<!--                                                                v-model="nominee.nominee_email"-->
<!--                                                                type="text"-->
<!--                                                                name="nominee_email"-->
<!--                                                                :maxlength="50"-->
<!--                                                                v-validate="'email'"-->
<!--                                                            ></b-form-input>-->
<!--                                                        </b-form-group>-->
<!--                                                    </b-col>-->
                                                    <b-col md="3">
                                                        <b-form-group
                                                            label="NID"
                                                            label-for="nominee_nid"
                                                        >
                                                            <b-form-input
                                                                id="nominee_nid"
                                                                v-model="nominee.nominee_nid_no"
                                                                type="text"
                                                                name="nominee_nid"
                                                                :maxlength="50"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group
                                                            label="Date of Birth"
                                                            label-for="nominee_dob" class="requiredField"
                                                        >
                                                            <date-picker
                                                                required
                                                                v-model="nominee.nominee_dob"
                                                                width="100%"
                                                                name="nominee_dob"
                                                                input-class="form-control"
                                                                type="date" lang="en"
                                                                format="DD-MM-YYYY"
                                                                :value-type="valueType"
                                                                :editable="false"
                                                                :not-after="notAfterToday()">
                                                            </date-picker>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group
                                                            label="Account No"
                                                            label-for="nominee_acc_no" class="requiredField">
                                                            <b-form-input
                                                                required
                                                                id="nominee_acc_no"
                                                                v-model="nominee.nominee_acc_no"
                                                                type="text"
                                                                name="nominee_acc_no"
                                                                :maxlength="500"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group
                                                            label="Percentage(%)"
                                                            label-for="percentage"
                                                            class="requiredField"
                                                        >
                                                            <b-form-input
                                                                required
                                                                :disabled="nomineeEdit"
                                                                id="percentage"
                                                                v-model="nominee.percentage"
                                                                type="text"
                                                                name="percentage"
                                                                :maxlength="3"
                                                                v-validate="'decimal:2|max_value:100'"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3"  >
                                                        <b-form-group
                                                            label="Pension Start Date"
                                                            label-for="pension_start_date"
                                                            class="requiredField"
                                                        >
                                                            <date-picker
                                                                width="100%"
                                                                input-class="form-control"
                                                                v-model="nominee.pension_start_date"
                                                                type="date"
                                                                lang="en"
                                                                :editable="false"
                                                                :value-type="valueType"
                                                                format="DD-MM-YYYY"
                                                                required>
                                                            </date-picker>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3" >
                                                        <b-form-group
                                                            label="Pension End Date"
                                                            label-for="pension_end_date"
                                                        >
                                                            <date-picker
                                                                width="100%"
                                                                input-class="form-control"
                                                                v-model="nominee.pension_end_date"
                                                                type="date"
                                                                lang="en"
                                                                :value-type="valueType"
                                                                :editable="false"
                                                                format="DD-MM-YYYY"
                                                                >
                                                            </date-picker>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group
                                                            label="Pension amount"
                                                            label-for="nominee_pension_amount"
                                                            class="requiredField"
                                                        >
                                                            <b-form-input
                                                                required
                                                                id="nominee_pension_amount"
                                                                v-model="nominee.pension_amt"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group
                                                            label="Medical Amount"
                                                            label-for="nominee_medical_amount"
                                                            class="requiredField"
                                                        >
                                                            <b-form-input
                                                                required
                                                                id="nominee_medical_amount"
                                                                v-model="nominee.medical_allow"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="3">
                                                        <b-form-group
                                                            label="Total"
                                                            label-for="nominee_total"
                                                        >
                                                            <b-form-input
                                                                readonly
                                                                id="nominee_total"
                                                                v-model="nominee.nominee_total"
                                                            ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>

                                                </b-row>
                                                <b-row>
                                                    <b-col class="d-flex justify-content-end">
                                                        <b-button type="submit" id="basic_sub_btn" class="btn btn-dark shadow mr-1">{{submitBtn}}</b-button>&nbsp;
                                                        <b-button type="button" class="btn btn-outline-dark" @click="resetNominee()" >Cancel</b-button>
                                                    </b-col>
                                                </b-row>
                                            </b-form>
                                            <b-table small responsive :items="temp_item" :fields="temp_fields">
                                                <template v-slot:cell(nominee_code)="{ item, index}">
<!--                                                    <span>{{formData.emp_code}}</span>{{'/Ns'}}<span>{{index+1}}</span>-->
                                                    <span v-if="item.nominee_id">{{item.nominee_code}}</span>
                                                    <span v-else > <span>{{formData.emp_code}}</span>{{'/N'}}<span>{{index+1}} </span> </span>
                                                </template>
                                                <template v-slot:cell(nominee_total)="{ item, index}">
                                                     {{item.nominee_total ? item.nominee_total : (parseInt(item.pension_amt) + parseInt(item.medical_allow))}}
                                                </template>
                                                <template v-slot:cell(percentage)="{ value, item, field: { key }}">
                                                    <template v-if="item.edit_yn == 'N'">{{ value }}</template>
                                                    <b-form-input class="text-right" v-else v-model="item[key]" />
                                                </template>
                                                <template v-slot:cell(action)="{ item, index }">
<!--                                                    <b-link class="text-primary" @click="item.edit_yn = item.edit_yn == 'N'?'Y':'N'" ml="4"><i class="bx cursor-pointer" :class="item.edit_yn == 'N'?'bx-edit':'bx-detail'"></i></b-link>-->
                                                    <b-link class="text-primary" v-if="item.nominee_id" @click="onEditNominee(item)" ml="4"><i class="bx cursor-pointer" :class="'bx-edit'"></i></b-link>
                                                    <b-link class="text-danger"  @click="onDelete(item.emp_id,item.nominee_id, index)"><i class="bx bx-trash cursor-pointer"></i></b-link>
                                                </template>
                                            </b-table>
                                            <div>Total Percentage: <strong>{{totalPercentage}}</strong></div>
<!--                                            <b-row>-->
<!--                                                <b-col class="d-flex justify-content-end align-items-end">-->
<!--                                                    <b-button @click="finalSubmit" type="button">Save</b-button>-->
<!--                                                </b-col>-->
<!--                                            </b-row>-->
                                        </b-card-body>
                                    </b-card>
                            </fieldset>
                        </b-col>

                    </b-row>
                </fieldset>
            </b-modal>
        </div>
    </div>
</template>

<script>
    import ApiRepository from "../../Repository/ApiRepository";
    import Datatable from '../../layouts/common/ajax_datatable';
    import DatePicker from "vue2-datepicker";
    import vSelect from 'vue-select';
    import moment from 'moment';
    import vcss from 'vue-select/dist/vue-select.css';
    import BNFNominee from "../pmis/employee/BNFNominee";
    import GPFNominee from "../pmis/employee/GPFNominee";
    import PensionNominee from "../pension/PensionNominee";
    import SideBar from "../pmis/partials/sidebar";

    export default {
        name: "EmployeeModification",
        components: {DatePicker, Datatable, vSelect, vcss,'pension-nominee':PensionNominee},
        data() {
            return {
                totalDataList: '',
                currentPage: 1,
                perPage: 15,
                isBusy: false,
                selectedBloodGroup: {},
                selectedQuota: {},
                selectedRelation: {},
                selectedGrade: {},
                selectedDesignation: {},
                selectedEmpType: {},
                selectedDepartment: {},
                selectedClass: {},
                selectedGender: {},
                selectedReligion: {},
                selectedPensionCat: '',
                doRefresh: false,
                families: [],
                nomineeEdit: false,
                nominees: null,
                nominee: {
                    active_yn: 'Y',
                    emp_id: this.id,
                    emp_family_id: null,
                    edit_yn: 'N',
                    autistic_yn: 'N',
                    approved_yn: 'N',
                    nominee_for_id: 2,
                    nominee_id: '',
                    nominee_name: '',
                    relationship_id: '',
                    relationship_name: '',
                    relationship: {},
                    percentage: '',
                    address_line_1: '',
                    address_line_2: '',
                    district_id: '',
                    thana_id: '',
                    post_code: '',
                    nominee_contact_no: '',
                    nominee_email: '',
                    nominee_nid_no: '',
                    nominee_dob: '',
                    nominee_marital_status_id: '',
                    marital_status: {},
                    nominee_photo: null,
                    nominee_photo_name: null,
                    nominee_photo_type: null,
                    auth_type_id: '',
                    nominee_auth_id: '',
                    nominee_auth_id_photo: null,
                    nominee_auth_id_photo_name: null,
                    nominee_auth_id_photo_type: null,
                    nominee_acc_no: '',
                    medical_id: '',
                    bank_id: '',
                    branch_id: '',
                    nominee_gender_id: '',
                    old_district_id: '',
                    pension_start_date: '',
                    pension_end_date: '',
                    pension_amt: '',
                    medical_allow: '',
                    nominee_total: '',
                },
                formData: {
                    emp_id: '',
                    emp_code: '',
                    emp_name: '',
                    emp_name_bng: '',
                    emp_father_name: '',
                    emp_father_name_bng: '',
                    emp_mother_name: '',
                    emp_mother_name_bng: '',
                    emp_dob: '',
                    emp_join_date: '',
                    emp_lpr_date: '',
                    emp_gender_id: '',
                    emp_religion_id: '',
                    emp_blood_group_id: '',
                    emp_nationality_id: '',
                    emp_quota_id: '',
                    relationship_id: '',
                    emp_medical_book_id: '',
                    identity_symbol: '',
                    identity_symbol_bng: '',
                    emp_grade_id: '',
                    dpt_division_id: '',
                    dpt_department_id: '',
                    emp_type_id: '',
                    pension_category: '',
                    section_id: '',
                    designation_id: '',
                    emp_class: '',
                    emp_gender_name: '',
                    emp_gender_name_bng: '',
                    emp_religion_name: '',
                    bank_id: '',
                    branch_id: '',
                    pension_pct: 0,
                    pension_amt: 0,
                    medical_allow: 0,
                    old_pension_amt: 0,
                    dearness_allow: 0,
                    foreign_ta_da_ded: 0,
                    it_con_fee_ded: 0,
                    over_pay_fix_ded: 0,
                    prl_inc_bon_ded: 0,
                    miscellaneous_ded: 0,
                    //old_pension_amt: 0,
                    death_date: '',
                    bank_acc_no: '',
                    retirement_date: '',
                    tribal_yn: 'N',
                    on_pension_yn: 'Y',
                    emp_contact_no : '',
                    emp_nid_no : '',
                    pension_start_date : '',
                    pension_end_date : '',
                    nominees:[]
                },
                pensionCat: '',
                emp_type: null,
                pensionHeadObj:{
                    department_id: null,
                    process_type:null,
                    emp_id:null,
                    pensionCat:'',
                    on_pension_yn:null,
                    emp_type:null,
                },
                empIdList: [],
                yearsList: [],
                monthsList: [],
                departmentList:[],
                genderOptions: [],
                religionOptions: [],
                bloodGroupOptions: [],
                quotaOptions: [],
                relationOptions: [],
                gradeOptions: [],
                departmentOptions: [],
                empTypeOptions: [],
                designationOptions: [],
                pensionCatOption: [],
                selectedPensionEmployee: '',
                selectedCheck: 'all',
                submitBtn: 'Add',
                textColor: 'text-success',
                keepDisable: false,
                valueType: this.dateFormatter(),
                relationships: {text:'',value:'', gender_id: ''},
                optionsCheck: [
                    { item: 'all', name: 'All'},
                    { item: 'employee', name: 'Employee' },
                    { item: 'nominee', name: 'Nominee' },
                ],
                empTypeOption: [
                    { text: 'All', value: null },
                    { text: 'Officer', value: 1 },
                    { text: 'Staff', value: 2 }
                ],
                /*pensionCatOption: [
                    {text: 'All Pension Category', value: ''},
                    {text: '50%', value: '50'},
                    {text: '100%', value: '100'}
                ],*/
                pensionOptions: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'}
                ],
                booleanOptions: [
                    {text: 'Yes', value: 'Y'},
                    {text: 'No', value: 'N'}
                ],
                classOptions: [
                    {text: 'Class I', value: 'Class I'},
                    {text: 'Class II', value: 'Class II'},
                    {text: 'Class III', value: 'Class III'},
                    {text: 'Class IV', value: 'Class IV'}
                ],
                totalPercentage:0,
                temp_item: [],
                temp_fields: [
                    {key: 'nominee_code', label: 'Nominee  Code', sortable: true},
                    {key: 'nominee_name', sortable: true},
                    {
                        key: 'percentage',
                        label: 'Percentage',
                        sortable: true,
                        filterByFormatted: true,
                        sortByFormatted: true,
                        formatter: (value) => {
                            if(value) {
                                return value+"%";
                            }
                            return value;
                        },
                        class:'text-right'
                    },
                    {key: 'relationship_name', label: 'Relationship', sortable: true},
                    {key: 'pension_amt', label: 'Pension Amount', sortable: true},
                    {key: 'medical_allow', label: 'Medical Amount', sortable: true},
                    {key: 'nominee_total', label: 'Total Amount', sortable: true},
                    {key: 'action', label: 'Action', sortable: false},
                ],
                fields: [
                    {label: 'SL', key: 'index', sortable: true},
                    {key: 'emp_code', label: 'Employee Code', sortable: true},
                    {key: 'emp_name', label: 'Employee Name', sortable: true},
                    {key: 'department.department_name', label: 'Department', sortable: true},
                    {key: 'designation.designation', label: 'Designation', sortable: true},
                    {key: 'bank_acc_no', label: 'Bank Account' , sortable: true},
                    {key: 'medical_allow', label: 'Medical Allow' , sortable: true},
                    {key: 'pension_amt_pct', label: 'Pension Amount', sortable: true },
                    {key: 'monthly_amount', label: 'Monthly Payable Amount', sortable: true  },
                    // {
                    //     key: 'emp_lpr_date', label: 'LPR Date',
                    //     formatter: value => {
                    //         if (value) {
                    //             return moment(value).format('DD-MM-YYYY');
                    //         }
                    //     }, class: 'text-right'
                    // },
                    {
                        key: 'action2', label: 'On Pension'
                    },
                    {key: 'action', class: 'text-center'}

                ],

            }
        },
        watch: {
            selectedPensionEmployee: function (val, oldVal) {
                console.log(val);
                if (val !== null) {
                    this.pensionHeadObj.emp_id=val.emp_id;
                    this.pensionHeadObj.department_id=val.dpt_department_id;
                }else{
                    this.pensionHeadObj.emp_id = null;
                    this.pensionHeadObj.department_id=null;
                }
            },
            'formData.emp_code':{
                handler: function (after, before) {
                    //console.log('asd',after);
                    this.nominee.nominee_code = after + 'N1';
                },
                deep: true
            },
            'nominee.medical_allow':{
                handler: function (after, before) {
                    //console.log('asd',after);
                    this.nominee.nominee_total = (parseFloat(this.nominee.pension_amt) + parseFloat(after)).toFixed(3);
                },
                deep: true
            },
            'nominee.pension_amt':{
                handler: function (after, before) {
                    //console.log('asd',after);
                    this.nominee.nominee_total = (parseFloat(this.nominee.medical_allow) + parseFloat(after)).toFixed(3);
                },
                deep: true
            },
            totalPercentage:function(val, oldVal){
                if(val > 100){
                    this.$notify({ group: 'pmis', text: 'Your total percentage cannot exceed 100', type:'error' })
                    this.percentage = 0
                }
            },
            temp_item: {
                deep: true,
                handler(val, oldVal){
                    this.totalPercentage = 0
                    this.temp_item.filter(a => a.active_yn == 'Y').forEach(this.calculatePercentage)
                }
            },
            relationships: function (val, oldVal) {
                console.log('val',val);
                if (val.value) {
                    this.nominee.relationship_id = val.value
                    this.nominee.relationship_name = val.text
                } else {
                    this.nominee.relationship_id = null;
                }
            },
            selectedPensionCat: function (val, oldVal) {
                console.log(val)
                if (val) {
                    this.formData.pension_pct = val
                } else {
                    this.formData.pension_pct = null;
                }
            },
            selectedBloodGroup: function (val, oldVal) {
                if (val) {
                    this.formData.emp_blood_group_id = val.value
                } else {
                    this.formData.emp_blood_group_id = null
                }
            },
            selectedQuota: function (val, oldVal) {
                if (val) {
                    this.formData.emp_quota_id = val.value
                } else {
                    this.formData.emp_quota_id = null
                }
            },
            selectedRelation: function (val, oldVal) {
                if (val) {
                    this.formData.relationship_id = val.value
                } else {
                    this.formData.relationship_id = null
                }
            },
            selectedGrade: function (val, oldVal) {
                if (val) {
                    this.formData.emp_grade_id = val.value
                } else {
                    this.formData.emp_grade_id = null;
                }
            },
            selectedDesignation: function (val, oldVal) {
                if (val) {
                    this.formData.designation_id = val.value
                } else {
                    this.formData.designation_id = null;
                }
            },
            selectedDepartment: function (val, oldVal) {
                if (val) {
                    this.formData.dpt_department_id = val.value
                } else {
                    this.formData.dpt_department_id = null;
                }
            },
            selectedEmpType: function (val, oldVal) {
                //console.log(val);
                if (val) {
                    this.formData.emp_type_id = val
                } else {
                    this.formData.emp_type_id = null;
                }
            },

            selectedClass: function (val, oldVal) {
                if (val) {
                    this.formData.emp_class = val.value
                } else {
                    this.formData.emp_class = null;
                }
            },
            selectedGender: function (val, oldVal) {
                if (val) {
                    this.formData.emp_gender_id = val.value.value
                    this.formData.emp_gender_name = val.text
                } else {
                    this.formData.emp_gender_id = null
                    this.formData.emp_gender_name = ''
                }
            },
            selectedReligion: function (val, oldVal) {
                if (val) {
                    this.formData.emp_religion_id = val.value
                    this.formData.emp_religion_name = val.text
                } else {
                    this.formData.emp_religion_id = null;
                    this.formData.emp_religion_name = '';
                }
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Pension"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Modification"});
            this.loadBasicInfo()
            this.allSetup()

        },
        computed: {
            monthly_payable_amount() {
                return Number(this.formData.pension_amt) + Number(this.formData.medical_allow)
            },
            net_pay() {
                return Number(this.formData.pension_amt)
                    + Number(this.formData.medical_allow)
                    + Number(this.formData.dearness_allow)
                    + Number(this.formData.foreign_ta_da_ded)
                    - Number(this.formData.it_con_fee_ded)
                    - Number(this.formData.over_pay_fix_ded)
                    - Number(this.formData.prl_inc_bon_ded)
                    - Number(this.formData.miscellaneous_ded)
            }
        },
        methods: {
            allSetup() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/payroll/year-list").then(res => {
                    this.yearsList = res.data;
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/operation/promotions/form-data').then(res => {
                    this.departmentList= res.data.departments;
                });
            },
            calculatePercentage(item, index) {
                //this.totalPercentage = this.nominee.reduce((a, b) => a + b.percentage)
                //this.totalPercentage = 0;
                if (item.percentage)
                    this.totalPercentage = parseFloat(this.totalPercentage) + parseFloat(item.percentage)
            },
            changeYear(){
                if(this.pensionHeadObj.fy_id ){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pension/salary-setup/months-by-year-id/"+ this.pensionHeadObj.fy_id).then(res => {
                        this.monthsList = res.data;
                    });
                }
            },
            searchEmpCode(id) {
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/pension-payable/emp/${id}`).then(res => {
                        this.empIdList = res.data;
                    })
                }
            },
            onSubmitted() {
                // this.$touch()
                // this.nominee.$touch()
                // if (!this.nominee.$invalid){
               // console.log('nominee',this.nominee);

                if (this.nominee.nominee_id){
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/employee/pension-nominees-update`,this.nominee).then(result => {
                        if (result.data.o_status_code == 1){
                            // this.temp_item = this.temp_item.filter(a=>a.nominee_id != nominee_id)
                            //this.filterFamilies();
                            this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' })
                        } else {
                            this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' })
                        }
                    })
                }else{
                    if((this.totalPercentage + parseFloat(this.nominee.percentage)) >100){
                        this.$notify({ group: 'pmis', text: 'Your total percentage cannot exceed 100', type:'error' })
                    } else {
                        this.nominee.nominee_name = this.nominee.nominee_name + ' ' + this.nominee.relationship_name + ' of ' + this.formData.emp_name;
                        this.temp_item.unshift(this.nominee)
                        //this.temp_item.includes(this.nominee.nominee_code)
                        // this.filterFamilies()
                        this.modelClear()
                        this.nominee.nominee_code = this.formData.emp_code + 'N2';
                    }
                }

                //}
            },
            // finalSubmit() {
            //     if(this.totalPercentage == 100){
            //         let currObj = this;
            //         ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pmis/employee/nominees/2", this.temp_item).then(result => {
            //             if (result.data.o_status_code == 1) {
            //                 this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' })
            //                 this.$emit('submitted')
            //                 currObj.loadData();
            //                 currObj.onReset();
            //             } else{
            //                 this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' })
            //             }
            //
            //             this.keepDisable = false;
            //         });
            //     } else {
            //         this.$notify({ group: 'pmis', text: 'Total percentage should be 100%', type:'error' })
            //     }
            // },
            onEdit(id) {
                this.edit = this.edit !== id ? id : null;
            },
            onEditNominee(item){
                    this.nominee = item;
                   // this.nominee_contact_no = item.nominee_contact_no;
                    //this.nominee_nid_no = item.nominee_nid;
                    this.relationships = {
                        text: item.relations ? item.relations.text : '',
                        value: item.relations ? item.relations.value : ''
                    }
                this.submitBtn = 'Update';
                this.nomineeEdit = true;
            },
            onDelete(emp_id,nominee_id, index){
                this.$bvModal.msgBoxConfirm('Please confirm that you want to delete', {
                    title: 'Please Confirm',
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'danger',
                    okTitle: 'YES',
                    cancelTitle: 'NO',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                })
                    .then(response=> {
                        if(response == true){
                            if(nominee_id){
                                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/pension-nominees-delete/${emp_id}/${nominee_id}`).then(result => {
                                    if (result.data.o_status_code == 1){
                                        this.temp_item = this.temp_item.filter(a=>a.nominee_id != nominee_id)
                                        //this.filterFamilies();
                                        this.totalPercentage = (this.totalPercentage - parseFloat(this.temp_item.percentage));
                                        this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' })
                                    } else {
                                        this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' })
                                    }
                                })
                            } else {
                                this.temp_item = this.temp_item.filter(a=>a.nominee_id != nominee_id)
                                // this.filterFamilies();
                            }
                        }
                    })
            },
            resetNominee(){
                this.submitBtn = 'Add';
               // this.nominee = [];
                this.relationships = {
                    text:  '',
                    value: ''
                }
                this.nomineeEdit = false;
                this.nominee = {
                    active_yn: 'Y',
                    emp_id: this.id,
                    emp_family_id: null,
                    edit_yn: 'N',
                    autistic_yn: 'N',
                    approved_yn: 'N',
                    nominee_for_id: 2,
                    nominee_id: '',
                    nominee_name: '',
                    relationship_id: '',
                    relationship_name: '',
                    relationship: {},
                    percentage: '',
                    address_line_1: '',
                    address_line_2: '',
                    district_id: '',
                    thana_id: '',
                    post_code: '',
                    nominee_contact_no: '',
                    nominee_email: '',
                    nominee_nid_no: '',
                    nominee_dob: '',
                    nominee_marital_status_id: '',
                    marital_status: {},
                    nominee_photo: null,
                    nominee_photo_name: null,
                    nominee_photo_type: null,
                    auth_type_id: '',
                    nominee_auth_id: '',
                    nominee_auth_id_photo: null,
                    nominee_auth_id_photo_name: null,
                    nominee_auth_id_photo_type: null,
                    nominee_acc_no: '',
                    medical_id: '',
                    bank_id: '',
                    branch_id: '',
                    nominee_gender_id: '',
                    old_district_id: '',
                    pension_start_date: '',
                    pension_end_date: '',
                    pension_amt: '',
                    medical_allow: '',
                    nominee_total: '',
                }
            },
            pensionNominee: function(emp_id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/pension-nominees/${emp_id}`).then(res => {
                    this.temp_item = res.data.data
                });
            },
            // addField(value, fieldType) {
            //     this.formData.nominees.push({
            //         nominee_code : '',
            //         nominee_bank_account : '',
            //         nominee_mobile : '',
            //         nominee_percentage : '',
            //         nominee_pension_start_date : '',
            //         nominee_pension_end_date : '',
            //         nominee_pension_amount : '',
            //         nominee_medical_amount : '',
            //         nominee_total : '',
            //     });
            // },
            // removeField(index, fieldType) {
            //     this.formData.nominees.splice(index, 1);
            // },
            onSubmit() {
                this.formData.emp_dob = moment(this.formData.emp_dob).format("YYYY-MM-DD");

                if(this.selectedCheck != 'employee'){
                    if(this.totalPercentage == 100){
                        let that = this;
                        this.formData.nominees = this.temp_item;
                        //console.log('form',this.formData)
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pension/employees", this.formData).then(res => {
                            if (res.data.o_status_code == 1) {
                                this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                // $refs.tableEmployee.$loadTableData();
                                //that.$refs.tableEmployee.refresh();
                                that.temp_item = [];
                                that.doRefresh = true;
                                //this.$root.$emit('bv::refresh::table', 'tableEmployee')
                                //this.loadTableData();
                                this.onReset()
                                this.resetNominee();
                            } else {
                                this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                            }
                        })
                    } else {
                        this.$notify({ group: 'pmis', text: 'Total percentage should be 100%', type:'error' })
                    }
                }else {
                    let that = this;
                    this.formData.nominees = this.temp_item;
                    //console.log('form',this.formData)
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pension/employees", this.formData).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            // $refs.tableEmployee.$loadTableData();
                            //that.$refs.tableEmployee.refresh();
                            that.temp_item = [];
                            that.doRefresh = true;
                            //this.$root.$emit('bv::refresh::table', 'tableEmployee')
                            //this.loadTableData();
                            this.onReset()
                            this.resetNominee();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    })
                }

            },
            editRow(item) {
                this.totalPercentage = 0;
                this.formData = item
                this.formData.emp_dob = item.emp_dob ? moment(new Date(item.emp_dob), "YYYY-MM-DD").toDate() : '';
                console.log(item)
                this.selectedBloodGroup = {
                    text: item.blood_group ? item.blood_group.text : '',
                    value: item.blood_group ? item.blood_group.value : ''
                }
                this.selectedQuota = {
                    text: item.quota ? item.quota.text : '',
                    value: item.quota ? item.quota.value : ''
                }
                this.selectedRelation = {
                    text: item.relations ? item.relations.text : '',
                    value: item.relations ? item.relations.value : ''
                }
                this.selectedGrade = {
                    text: item.grade ? item.grade.text : '',
                    value: item.grade ? item.grade.value : ''
                }
                this.selectedDesignation = {
                    text: item.designation ? item.designation.text : '',
                    value: item.designation ? item.designation.value : ''
                }
                this.selectedDepartment = {
                    text: item.department ? item.department.text : '',
                    value: item.department ? item.department.value : ''
                }
                this.selectedEmpType = {
                    text: item.emp_type ? item.emp_type.text : '',
                    value: item.emp_type ? item.emp_type.value : ''
                }
               // this.emp_type_id = item.emp_type ? item.emp_type.value : '';
               //  this.selectedPensionCat = {
               //      text: item.pension_pct ? item.pension_pct.text : '',
               //      value: item.pension_pct ? item.pension_pct.value : ''
               //  }
                this.selectedPensionCat = item.pension_pct;
                    this.selectedClass = {
                    text: item.emp_class,
                    value: item.emp_class
                }
                this.selectedGender = {
                    text: item.gender ? item.gender.text : '',
                    value: {
                        value: item.gender ? item.gender.value : ''
                    }
                }
                this.selectedReligion = {
                    text: item.religion ? item.religion.text : '',
                    value: item.religion ? item.religion.value : ''
                }
                this.$refs['employee_modal'].show()
                this.pensionNominee(item.emp_id);
            },

            loadTableData(ctx, callback) {
                // this.currentPage = ctx.currentPage;
                // this.perPage = ctx.perPage;
                let filter = ctx.filter;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pension/employees" + '?page=' + ctx.currentPage + '&size=' + ctx.perPage + '&filter=' + filter + '&pension_cat=' + this.pensionHeadObj.pensionCat
                    +  '&department_id=' + this.pensionHeadObj.department_id + '&emp_id=' + this.pensionHeadObj.emp_id + '&emp_type=' + this.pensionHeadObj.emp_type+ '&on_pension_yn=' + this.pensionHeadObj.on_pension_yn
                ).then(res => {
                    let items = res.data.data;
                    this.currentPage = res.data.current_page;
                    this.totalDataList = res.data.total;
                    this.doRefresh = false;
                    callback(items);
                });
                return null
            },
            searchEmployeeData() {
                // this.totalList = 1;
               // this.pensionHeadObj.pensionCat = value;
                // console.log(this.pensionCat = value)
                //this.loadTableData();
                this.doRefresh = !this.doRefresh;
            },
            selectPensionCat(value) {
                // this.totalList = 1;
                this.pensionHeadObj.pensionCat = value;
                // console.log(this.pensionCat = value)
                //this.loadTableData();
                this.doRefresh = !this.doRefresh;
            },
            selectempType(value) {
                // this.totalList = 1;
                this.pensionHeadObj.emp_type = value;
                // console.log(this.pensionCat = value)
                //this.loadTableData();
                this.doRefresh = !this.doRefresh;
            },
            //employee
            getEmpDataByCode() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pension/pension-employee-details/${this.formData.emp_code}`).then(res => {
                    // console.log(res.data.data)

                    if(res.data.data != null){
                        // console.log('res.data.data')
                        this.formData = res.data.data;
                        this.selectedDepartment = {
                            text: res.data.data.department_name,
                            value: res.data.data.dpt_department_id
                        }
                        this.selectedDesignation = {
                            text: res.data.data.designation,
                            value: res.data.data.designation_id
                        }
                        this.selectedEmpType = {
                            text: res.data.data.emp_type_name,
                            value: res.data.data.emp_type_id
                        }
                        this.selectedGender = {
                            text: res.data.data.emp_gender_name,
                            value: res.data.data.emp_gender_id
                        }
                        this.selectedReligion = {
                            text: res.data.data.emp_religion_name,
                            value: res.data.data.emp_religion_id
                        }
                        this.selectedBloodGroup = {
                            text: res.data.data.blood_group,
                            value: res.data.data.emp_blood_group_id
                        }
                        this.selectedQuota = {
                            text: res.data.data.quota_name,
                            value: res.data.data.emp_quota_id
                        }
                        this.selectedGrade = {
                            text: res.data.data.grade_range,
                            value: res.data.data.emp_grade_id
                        }
                        this.selectedClass = {
                            text: res.data.data.emp_class,
                            value: res.data.data.emp_class
                        }
                    }

                })
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
            notAfterToday() {
                return moment().subtract(1, 'days');
            },
            hasEmpId() {
                return ((this.id !== undefined) && (this.id > 0));
            },
            loadBasicInfo() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pmis/employee/basic-infos").then(res => {
                    this.genderOptions = res.data.genders
                    this.designationOptions = res.data.designation
                    this.religionOptions = res.data.religions
                    this.bloodGroupOptions = res.data.bloodGroup
                    this.quotaOptions = res.data.quota
                    this.relationOptions = res.data.relations
                    this.gradeOptions = res.data.payGrade
                    this.departmentOptions = res.data.department
                    this.empTypeOptions = res.data.empType
                    this.pensionCatOption = res.data.pensionCat
                });
            },
            onReset() {
                this.selectedBloodGroup = {text: '', value: ''}
                this.selectedQuota = {text: '', value: ''}
                this.selectedRelation = {text: '', value: ''}
                this.selectedGrade = {text: '', value: ''}
                this.selectedClass = {text: '', value: ''}
                this.selectedDesignation = {text: '', value: ''}
                this.selectedGender = {text: '', value: ''}
                this.selectedReligion = {text: '', value: ''}
                this.selectedDepartment = {text: '', value: ''}
                this.selectedEmpType = {text: '', value: ''}
                this.selectedPensionCat = {text: '', value: ''}
                this.formData = {
                    emp_id: '',
                    emp_code: '',
                    emp_name: '',
                    emp_name_bng: '',
                    emp_father_name: '',
                    emp_father_name_bng: '',
                    emp_mother_name: '',
                    emp_mother_name_bng: '',
                    emp_dob: '',
                    emp_join_date: '',
                    emp_lpr_date: '',
                    emp_gender_id: '',
                    emp_religion_id: '',
                    emp_blood_group_id: '',
                    emp_nationality_id: '',
                    emp_quota_id: '',
                    relationship_id: '',
                    emp_medical_book_id: '',
                    identity_symbol: '',
                    identity_symbol_bng: '',
                    emp_grade_id: '',
                    dpt_division_id: '',
                    dpt_department_id: '',
                    emp_type: '',
                    pension_category: '',
                    section_id: '',
                    designation_id: '',
                    emp_class: '',
                    emp_gender_name: '',
                    emp_gender_name_bng: '',
                    emp_religion_name: '',
                    bank_id: '',
                    branch_id: '',
                    retirement_date: '',
                    bank_acc_no: '',
                    tribal_yn: 'N',
                    on_pension_yn: 'Y',
                    emp_contact_no : '',
                    emp_nid_no : '',
                    pension_start_date : '',
                    pension_end_date : '',
                    nominees:[]
                }
                this.temp_item = [];
                // this.nominee = [];
                this.submitBtn = 'Add';
            },
            modelClear(){
                this.nominee = {
                    active_yn: 'Y',
                    emp_id: this.id,
                    emp_family_id:'',
                    autistic_yn: 'N',
                    approved_yn: 'N',
                    nominee_for_id: 2,
                    nominee_name: '',
                    relationship_id: '',
                    relationship: {},
                    percentage: '',
                    address_line_1: '',
                    address_line_2: '',
                    district_id: '',
                    thana_id: '',
                    post_code: '',
                    nominee_contact_no: '',
                    nominee_email: '',
                    nominee_dob: '',
                    nominee_marital_status_id: '',
                    marital_status: {},
                    nominee_photo: null,
                    nominee_photo_name: null,
                    nominee_photo_type: null,
                    auth_type_id: '',
                    nominee_auth_id: '',
                    nominee_auth_id_photo: null,
                    nominee_auth_id_photo_name: null,
                    nominee_auth_id_photo_type: null,
                    nominee_acc_no: '',
                    medical_id: '',
                    bank_id: '',
                    branch_id: '',
                    nominee_gender_id: '',
                    old_district_id: '',
                    nominee_id: '',
                    alternate_nominee: [],
                    alternate_nominee_names: '',
                    alternate_nominee_ids: ''
                }
                this.selectedFamily = null
                this.alternateNominee = []
                this.relationships = {text:'',value:'', gender_id: ''}
                this.maritalStatus = {'text':'','value':''}
                this.genders = {'text':'','value':''}
                this.districts = {'text':'','value':''}
                this.thana = {'text':'','value':''}
                this.authenticationTypes = {text:'',value:''}
                this.banks = {'text':'','value':''}
                this.branches = {'text':'','value':''}
                this.submitBtn = 'Add';
               // this.temp_item = [];
                // this.$reset()
            }
        }
    }
</script>

<style scoped>

</style>
