<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Employees
                    <b-button class="float-right" variant="success" size="sm" v-b-modal.employee_modal>ADD NEW
                    </b-button>
                </b-card-header>
                <b-card-body class="border">
                    <b-form-group
                        id="pensionCat"
                        label="Pension category"
                    >
                        <b-form-select v-model="pensionCat" name="pensionCat" @change="selectPensionCat"
                                       :options="pensionCatOption"
                                       label="text" required>
                        </b-form-select>
                    </b-form-group>
                    <Datatable v-bind:fields="fields" v-bind:items="loadTableData" :perPage="perPage"
                               :totalList="totalDataList" :update="doRefresh">
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
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Employee Name"
                                label-for="emp_name"
                            >
                                <b-form-input
                                    id="emp_name"
                                    :readonly="formData.emp_id?true:false"
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
                                        v-model="formData.mobile_no"
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
                                        v-model="formData.emp_nid"
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
                        <b-col md="3" v-if="selectedCheck == 'all' || selectedCheck == 'employee'">
                            <b-form-group
                                label="On Pension"
                                label-for="on_pension_yn"
                            >
                                <b-form-input
                                    id="on_pension_yn"
                                    readonly
                                    v-model="formData.pension_status"
                                ></b-form-input>
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


                        <b-col md="6">
                        </b-col>
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
                                <b-row>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Nominee Code"
                                            label-for="nominee_code"
                                        >
                                            <b-form-input
                                                id="nominee_code"
                                                v-model="formData.nominee_code"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Nominee Name"
                                            label-for="nominee_name"
                                        >
                                            <b-form-input
                                                id="nominee_name"
                                                v-model="formData.nominee_name"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Nominee Birth Date"
                                            label-for="nominee_dob"
                                        >
                                            <date-picker
                                                width="100%"
                                                input-class="form-control"
                                                v-model="formData.nominee_dob"
                                                type="date"
                                                lang="en"
                                                :editable="false"
                                                format="DD-MM-YYYY">
                                            </date-picker>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                            label="Relation"
                                            label-for="relation"
                                        >
                                            <v-select v-model="selectedRelation" name="relation"
                                                      :options="relationOptions"
                                                      label="text" required>
                                                <template #search="{attributes, events}">
                                                    <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                </template>
                                            </v-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                                label="Bank Account"
                                                label-for="nominee_bank_account"
                                        >
                                            <b-form-input
                                                    id="nominee_bank_account"
                                                    v-model="formData.nominee_bank_account"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                                label="Mobile"
                                                label-for="mobile"
                                        >
                                            <b-form-input
                                                    id="mobile"
                                                    v-model="formData.nominee_mobile"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                                label="Pension amount"
                                                label-for="nominee_pension_amount"
                                        >
                                            <b-form-input
                                                    id="nominee_pension_amount"
                                                    v-model="formData.nominee_pension_amount"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                                label="Medical Amount"
                                                label-for="nominee_medical_amount"
                                        >
                                            <b-form-input
                                                    id="nominee_medical_amount"
                                                    v-model="formData.nominee_medical_amount"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="3">
                                        <b-form-group
                                                label="Total"
                                                label-for="nominee_total"
                                        >
                                            <b-form-input
                                                    id="nominee_total"
                                                    v-model="formData.nominee_total"
                                            ></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                </b-row>
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

    export default {
        name: "EmployeeModification",
        components: {DatePicker, Datatable, vSelect, vcss},
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
                    mobile_no : '',
                    emp_nid : '',
                    pension_start_date : '',
                    pension_end_date : '',
                    nominee_code : '',
                    nominee_bank_account : '',
                    nominee_mobile : '',
                    nominee_pension_amount : '',
                    nominee_medical_amount : '',
                    nominee_total : '',
                },
                pensionCat: '',
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
                selectedCheck: 'all',
                optionsCheck: [
                    { item: 'all', name: 'All'},
                    { item: 'employee', name: 'Employee' },
                    { item: 'nominee', name: 'Nominee' },
                ],
                /*pensionCatOption: [
                    {text: 'All Pension Category', value: ''},
                    {text: '50%', value: '50'},
                    {text: '100%', value: '100'}
                ],*/
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
                fields: [
                    {label: 'SL', key: 'index', sortable: true},
                    {key: 'emp_code', label: 'Employee Code'},
                    {key: 'emp_name', label: 'Employee Name'},
                    {key: 'department.department_name', label: 'Department'},
                    {key: 'designation.designation', label: 'Designation'},
                    {key: 'bank_acc_no', label: 'Bank Account' },
                    {key: 'medical_allow', label: 'Medical Allow' },
                    {key: 'pension_amt_pct', label: 'Pension Amount' },
                    {key: 'monthly_amount', label: 'Monthly Payable Amount' },
                    // {
                    //     key: 'emp_lpr_date', label: 'LPR Date',
                    //     formatter: value => {
                    //         if (value) {
                    //             return moment(value).format('DD-MM-YYYY');
                    //         }
                    //     }, class: 'text-right'
                    // },
                    // {
                    //     key: 'on_pension_yn', label: 'On Pension',
                    //     formatter: value => {
                    //         if (value == 'Y') {
                    //             return 'Yes';
                    //         } else {
                    //             return 'No';
                    //         }
                    //     }, class: 'text-right'
                    // },
                    {key: 'action', class: 'text-center'}

                ],

            }
        },
        watch: {
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
            this.loadBasicInfo()
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
            onSubmit() {
                let that = this;
                console.log('form',this.formData)
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/pension/employees", this.formData).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        // $refs.tableEmployee.$loadTableData();
                        //that.$refs.tableEmployee.refresh();
                        that.doRefresh = true;
                        //this.$root.$emit('bv::refresh::table', 'tableEmployee')

                        //this.loadTableData();
                        this.onReset()
                    } else {
                        this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                })
            },
            editRow(item) {
                this.formData = item
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
            },

            loadTableData(ctx, callback) {
                // this.currentPage = ctx.currentPage;
                // this.perPage = ctx.perPage;
                let filter = ctx.filter;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/pension/employees" + '?page=' + ctx.currentPage + '&size=' + ctx.perPage + '&filter=' + filter + '&pension_cat=' + this.pensionCat).then(res => {
                    let items = res.data.data;
                    this.currentPage = res.data.current_page;
                    this.totalDataList = res.data.total;
                    this.doRefresh = false;
                    callback(items);
                });
                return null
            },
            selectPensionCat(value) {
                // this.totalList = 1;
                this.pensionCat = value;
                // console.log(this.pensionCat = value)
                //this.loadTableData();
                this.doRefresh = !this.doRefresh;
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
                    mobile_no : '',
                    emp_nid : '',
                    pension_start_date : '',
                    pension_end_date : '',
                }
            }
        }
    }
</script>

<style scoped>

</style>
