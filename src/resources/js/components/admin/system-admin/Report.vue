<template>
    <b-row class="content-wrapper">
        <b-col class="content-body">
            <b-row>
                <b-col>
                    <b-card class="card">
                        <b-card-header>
                            <h4 class="card-title">Reports</h4>
                        </b-card-header>
                        <b-card-text class="card-content">
                            <b-card-body mb="2">
                                <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                                    <b-row>
                                        <b-col lg="3">
                                            <b-form-group
                                                    id="module_id"
                                                    label="Module Name"
                                                    label-for="module_id">
                                                <b-form-select v-model="report.module_id" :options="modules" required v-validate="'required'" name="module_id" id="module_id"></b-form-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col lg="3">
                                            <b-form-group
                                                    id="report_name"
                                                    label="Report Name"
                                                    label-for="report_name">
                                                <b-form-input v-model="report.report_name" required v-validate="'required'" id="report_name" type="text" placeholder="Report Name" name="report_name"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col lg="3">
                                            <b-form-group
                                                    id="report_xdo_path"
                                                    label="Report XDO Path"
                                                    label-for="report_xdo_path">
                                                <b-form-input v-model="report.report_xdo_path" required v-validate="'required'" id="report_xdo_path" type="text" placeholder="Report XDO path" name="report_xdo_path"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col lg="3">
                                            <b-form-group
                                                    id="report_rtf_path"
                                                    label="Report RTF Path"
                                                    label-for="report_rtf_path">
                                                <b-form-input v-model="report.report_rtf_path" id="report_rtf_path" type="text" placeholder="Report RTF path" name="report_rtf_path"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row class="mt-1 param-heading">
                                        <b-col lg="1">
                                            <label for="SL">SL</label>
                                     </b-col>
                                     <b-col lg="2">
                                         <label for="paramName">Param Name</label>
                                      </b-col>
                                     <b-col lg="2">
                                         <label for="paramLevelName">Param Level Name</label>
                                      </b-col>
                                     <b-col lg="2">
                                         <label for="paramDefaultValue">Param Default Value</label>
                                      </b-col>
                                     <b-col lg="2">
                                         <label for="component">Component</label>
                                      </b-col>
                                     <b-col lg="1">
                                         <label for="order">Order No</label>
                                      </b-col>
                                         <b-col lg="1">
                                             <label for="Required">Required</label>
                                      </b-col>
                                     <b-col lg="1">
                                        <b-row>
                                            <b-col lg="12" class="form-group">
                                                <label for="Action">Action</label>
                                            </b-col>
                                       </b-row>
                                     </b-col>
                                    </b-row>
                                     <b-row v-for="(param, index) in createReportsParam.params" :key="index" class="mt-1">
                                     <b-col lg="1">
                                             {{ index+1 }}
                                      </b-col>
                                     <b-col lg="2">
                                                <b-form-input v-model="param.param_name" id="paramName" type="text" placeholder="Param Name" name="param_name"></b-form-input>
                                       </b-col>
                                     <b-col lg="2">
                                                <b-form-input v-model="param.param_label" id="paramLevelName" type="text" placeholder="Param Level Name" name="param_level_name"></b-form-input>
                                       </b-col>
                                       <b-col lg="2">
                                                <b-form-input v-model="param.default_value" id="paramDefaultValue" type="text" placeholder="Param Default Value" name="param_default_value"></b-form-input>
                                       </b-col>
                                       <b-col lg="2">
                                           <b-form-select
                                                v-model="param.component"
                                                :options="componentList[report.module_id]"
                                                id="Component"
                                                name="component"
                                             ></b-form-select>
<!--                                                <b-form-input v-model="param.component" id="Component" type="text" placeholder="Component" name="component"></b-form-input>-->
                                       </b-col>
                                       <b-col lg="1">
                                                <b-form-input v-model="param.order_no" id="Order" type="text" placeholder="Order" name="order_no"></b-form-input>
                                       </b-col>
                                         <b-col lg="1">

                                                  <b-form-checkbox
                                                      :id="'paramRequired'+index"
                                                      v-model="param.requied_yn"
                                                      name="paramRequired"
                                                      value="Y"
                                                      unchecked-value="N"
                                                    >
                                                     </b-form-checkbox>
                                       </b-col>
                                     <b-col lg="1">
                                        <b-row>
                                            <b-col lg="12" class="form-group">
                                                   <a type="button" @click.prevent="removeReportsParam(index)" class="mr-1">
                                                            <i class="bx bx-trash cursor-pointer text-danger"></i>
                                                   </a>
                                             </b-col>
                                       </b-row>
                                     </b-col>
                                 </b-row>
                                          <b-row align-h="end" class="mt-1">
                                            <b-col lg="12" class="form-group">
                                               <b-button
                                             @click.prevent="addReportsParam"
                                             size="md"
                                            class="btn-dark mr-1"
                                            type="submit"
                                          > Add </b-button>
                                            </b-col>
                                       </b-row>
                                    <b-row>
                                        <b-col class="d-flex justify-content-end">
                                            <b-button lg="6" size="md" variant="dark mr-1" type="submit" >{{submitBtn}}</b-button>&nbsp;
                                            <b-button lg="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                        </b-col>
                                    </b-row>
                                    <!--</fieldset>-->

                                </b-form>
                            </b-card-body>
                        </b-card-text>
                    </b-card>
                </b-col>
            </b-row>

            <b-row>
                <b-col>
                    <b-card title="Report List">
                        <template>
                            <div class="content-wrapper">
                                <div class="content-body">
                                    <Datatable v-bind:fields="fields" v-bind:items="items" :totalList="totalList" :perPage="perPage" :primaryKeyColumnName="'report_id'">
                                        <template v-slot:action2="{ rows }">
                                            <b-link ml="4" class="text-primary"
                                                    @click="editRow(rows.item.report_id)">
                                                <i class="bx bx-edit cursor-pointer"></i>
                                            </b-link>
                                            <b-link class="text-danger" v-b-modal="'report-remove'" @click="deletedItem = rows.item">
                                                <i class="bx bx-trash cursor-pointer"></i>
                                            </b-link>
                                        </template>
                                    </Datatable>
                                    <b-modal :id="'report-remove'" :centered="true" title="Please Confirm" size="sm" buttonSize="sm" okTitle="YES" cancelTitle="NO" footerClass="p-2"  :hideHeaderClose="false"
                                             @ok="deleteRow()" @hidden="deletedItem = null">
                                        <div>Are you sure you want to delete?</div>
                                    </b-modal>
                                </div>
                            </div>
                        </template>
                    </b-card>
                </b-col>
            </b-row>
        </b-col>
    </b-row>
</template>

<script>
    import ApiRepository from '../../../Repository/ApiRepository';
    import Datatable from '../../../layouts/common/datatable';

    export default {
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Administration"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "System Admin"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Report"});
            this.loadData();
        },
        components: {
            Datatable
        },
        data() {
            return {
                deletedItem: null,
                report: {
                    report_id: '',
                    module_id: '',
                    report_name: '',
                    report_xdo_path: '',
                    report_rtf_path: '',
                    report_params: '',
                },
                param:{ param_name: '', param_label: '', requied_yn: '', default_value: ''},
                createReportsParam: {
                    params: [
                        { param_name: '', param_label: '', requied_yn: '', default_value: ''},
                    ]
                },
                modules: [],
                show: true,
                updateIndex: -1,
                submitBtn: 'Save',

                fields: [{key: 'index', label: 'SL'}, {key: 'module.module_name', label: 'Module', sortable: true}, {key: 'report_name', sortable: true}, {key: 'report_xdo_path', sortable: true}, {key: 'report_rtf_path', sortable: true},  {key: 'action2', sortable: false}],
                items: [],
                componentList: {
                    '1': [ // HR MODULE
                        {value: '', text: '{text}'},
                        {value: 'emp_status_with_active', text: '{emp_status_with_active}'},
                        {value: 'bill_code', text: '{bill_code}'},
                        {value: 'pr_year', text: "{pr_year}"},
                        {value: 'month_id', text: '{pr_month}'},
                        {value: 'month', text: '{otmonth}'},
                        {value: 'department_id', text: '{department_id}'},
                        {value: 'designation_id', text: '{designation_id}'},
                        {value: 'emp_type_id', text:'{emp_type_name}'},
                        {value: 'emp_ids', text: '{emp_ids}'},
                        {value: 'department_wise_employee', text: '{department wise employee}'},
                        {value: 'empGrades', text: '{empGrades}'},
                        {value: 'empClasses', text: '{empClasses}'},
                        {value: 'division', text: '{division}'},
                        {value: 'district', text: '{district}'},
                        {value: 'thana', text: '{thana}'},
                        {value: 'per_division', text: '{per_division}'},
                        {value: 'per_district', text: '{per_district}'},
                        {value: 'per_thana', text: '{per_thana}'},
                        {value: 'tribalBonus', text: '{tribalBonus}'},
                        {value: 'date', text: '{date}'},
                        {value: 'gender', text: '{gender}'},
                        {value: 'quota', text: '{quota}'},
                        {value: 'religion', text: '{religion}'},
                        {value: 'monthYears', text: '{monthYears}'},
                        {value: 'emp_status_id', text: '{emp_status}'},
                        {value: 'punishment_type', text: '{punishment type}'},
                        {value: 'desc_join', text: '{desc_join}'},
                    ],
                    '2': [  // PAYROLL MODULE
                        {value: '', text: '{text}'},
                        {value: 'bill_code', text: '{bill_code}'},
                        {value: 'pr_year', text: "{pr_year}"},
                        {value: 'month_id', text: '{pr_month}'},
                        {value: 'emp_month_id', text: '{emp_pr_month}'},
                        {value: 'bill_month', text: '{bill_month}'},
                        {value: 'bonus_month_id', text: '{bonus_pr_month}'},
                        {value: 'month', text: '{otmonth}'},
                        {value: 'department_id', text: '{department_id}'},
                        {value: 'emp_ids', text: '{emp_ids}'},
                        {value: 'employee_id', text: '{employee_id}'},
                        {value: 'empGrades', text: '{empGrades}'},
                        {value: 'empClasses', text: '{empClasses}'},
                        {value: 'date', text: '{date}'},
                        {value: 'monthYears', text: '{monthYears}'},
                        {value: 'bonus_head', text: '{bonus_head}'},
                        {value: 'emp_type_id', text:'{emp_type_name}'},
                        {value: 'emp_status_id', text: '{emp_status}'},
                        {value: 'hidden_emp_id', text: '{hidden_emp_id}'},
                    ],
                    '3': [ // OVERTIME MODULE
                        {value: '', text: '{text}'},
                        {value: 'bill_code', text: '{bill_code}'},
                        {value: 'emp_code', text: '{emp_code}'},
                        {value: 'month', text: '{otmonth}'},
                        {value: 'department_id', text: '{department_id}'},
                        {value: 'emp_ids', text: '{emp_ids}'},
                        {value: 'empGrades', text: '{empGrades}'},
                        {value: 'empClasses', text: '{empClasses}'},
                        {value: 'Sections', text: '{Sections}'},
                        {value: 'date', text: '{date}'},
                        {value: 'monthYears', text: '{monthYears}'}
                    ],
                    '4': [ // PF MODULE
                        {value: '', text: '{text}'},
                        {value: 'bill_code', text: '{bill_code}'},
                        {value: 'pr_year', text: "{pr_year}"},
                        {value: 'month_id', text: '{pr_month}'},
                        {value: 'month', text: '{otmonth}'},
                        {value: 'department_id', text: '{department_id}'},
                        {value: 'emp_ids', text: '{emp_ids}'},
                        {value: 'empGrades', text: '{empGrades}'},
                        {value: 'empClasses', text: '{empClasses}'},
                        {value: 'emp_type_id', text:'{emp_type_name}'},
                        {value: 'date', text: '{date}'},
                        {value: 'monthYears', text: '{monthYears}'},
                        {value: 'loanType', text: '{loanType}'}
                    ],
                    '5': [ // PENSION MODULE
                        {value: '', text: '{text}'},
                        {value: 'pension_pct', text: '{pension_pct}'},
                        {value: 'bill_code', text: '{bill_code}'},
                        {value: 'pr_year', text: "{pr_year}"},
                        {value: 'month_id', text: '{pr_month}'},
                        {value: 'bonus_month_id', text: '{bonus_month_id}'},
                        {value: 'bonus_month', text: '{bonus_month}'},
                        {value: 'month', text: '{otmonth}'},
                        {value: 'department_id', text: '{department_id}'},
                        {value: 'emp_type_id', text:'{emp_type_name}'},
                        {value: 'pensionHeadId', text: '{pensionHeadId}'},
                        {value: 'emp_ids', text: '{emp_ids}'},
                        {value: 'department_wise_emp_ids', text: '{department_wise_emp_ids}'},
                        {value: 'empGrades', text: '{empGrades}'},
                        {value: 'empClasses', text: '{empClasses}'},
                        {value: 'date', text: '{date}'},
                        {value: 'datePicker', text: '{datePicker}'},
                        {value: 'monthYears', text: '{monthYears}'},
                        {value: 'retired_dead_employee', text: '{Retired Dead Employee}'},
                        {value: 'pension_application_employee', text: '{Pension Application Employee}'},
                        {value: 'pension_clearance_employee', text: '{Pension Clearance Employee}'}
                    ],
                    '6': [ // ATTENDANCE MODULE
                        {value: '', text: '{text}'},
                        {value: 'bill_code', text: '{bill_code}'},
                        {value: 'Sections', text: '{Sections}'},
                        {value: 'attendance_status', text: '{attendance_status}'},
                        {value: 'pr_year', text: "{pr_year}"},
                        {value: 'month_id', text: '{pr_month}'},
                        {value: 'month', text: '{otmonth}'},
                        {value: 'department_id', text: '{department_id}'},
                        {value: 'emp_ids', text: '{emp_ids}'},
                        {value: 'controlling_office_wise_employee', text: '{controlling officer wise employee}'},
                        {value: 'controlling_officer', text: '{controlling_officer}'},
                        {value: 'empGrades', text: '{empGrades}'},
                        {value: 'empClasses', text: '{empClasses}'},
                        {value: 'academic_yn', text: '{academic_yn}'},
                        {value: 'date', text: '{date}'},
                        {value: 'monthYears', text: '{monthYears}'},
                        {value: 'designation_id', text: '{designation_id}'},
                        {value: 'emp_type_id', text:'{emp_type_name}'}
                    ],
                    '7': [ // LEAVE MODULE
                        {value: '', text: '{text}'},
                        {value: 'bill_code', text: '{bill_code}'},
                        {value: 'pr_year', text: "{pr_year}"},
                        {value: 'month_id', text: '{pr_month}'},
                        {value: 'month', text: '{otmonth}'},
                        {value: 'department_id', text: '{department_id}'},
                        {value: 'emp_ids', text: '{emp_ids}'},
                        {value: 'empGrades', text: '{empGrades}'},
                        {value: 'empClasses', text: '{empClasses}'},
                        {value: 'date', text: '{date}'},
                        {value: 'monthYears', text: '{monthYears}'}
                    ],
                    '8': [ // ACR MODULE
                        {value: '', text: '{text}'},
                        {value: 'bill_code', text: '{bill_code}'},
                        {value: 'pr_year', text: "{pr_year}"},
                        {value: 'month_id', text: '{pr_month}'},
                        {value: 'month', text: '{otmonth}'},
                        {value: 'department_id', text: '{department_id}'},
                        {value: 'emp_ids', text: '{emp_ids}'},
                        {value: 'empGrades', text: '{empGrades}'},
                        {value: 'empClasses', text: '{empClasses}'},
                        {value: 'date', text: '{date}'},
                        {value: 'monthYears', text: '{monthYears}'}
                    ],
                    '9': [ // ALLOWANCE MODULE
                        {value: '', text: '{text}'},
                        {value: 'bill_code', text: '{bill_code}'},
                        {value: 'pr_year', text: "{pr_year}"},
                        {value: 'month_id', text: '{pr_month}'},
                        {value: 'month', text: '{otmonth}'},
                        {value: 'department_id', text: '{department_id}'},
                        {value: 'emp_ids', text: '{emp_ids}'},
                        {value: 'empGrades', text: '{empGrades}'},
                        {value: 'empClasses', text: '{empClasses}'},
                        {value: 'date', text: '{date}'},
                        {value: 'monthYears', text: '{monthYears}'}
                    ],
                    '10': [ // LOAN MODULE
                        {value: '', text: '{text}'},
                        {value: 'bill_code', text: '{bill_code}'},
                        {value: 'pr_year', text: "{pr_year}"},
                        {value: 'month_id', text: '{pr_month}'},
                        {value: 'month', text: '{otmonth}'},
                        {value: 'department_id', text: '{department_id}'},
                        {value: 'emp_ids', text: '{emp_ids}'},
                        {value: 'empGrades', text: '{empGrades}'},
                        {value: 'empClasses', text: '{empClasses}'},
                        {value: 'emp_type_id', text:'{emp_type_name}'},
                        {value: 'date', text: '{date}'},
                        {value: 'monthYears', text: '{monthYears}'}
                    ],
                    '11': [ // ADMINISTRATION MODULE
                        {value: '', text: '{text}'},
                        {value: 'bill_code', text: '{bill_code}'},
                        {value: 'pr_year', text: "{pr_year}"},
                        {value: 'month_id', text: '{pr_month}'},
                        {value: 'month', text: '{otmonth}'},
                        {value: 'department_id', text: '{department_id}'},
                        {value: 'emp_ids', text: '{emp_ids}'},
                        {value: 'empGrades', text: '{empGrades}'},
                        {value: 'empClasses', text: '{empClasses}'},
                        {value: 'date', text: '{date}'},
                        {value: 'monthYears', text: '{monthYears}'}
                    ],
                    '12': [ // APLICATION MODULE
                        {value: '', text: '{text}'},
                        {value: 'bill_code', text: '{bill_code}'},
                        {value: 'pr_year', text: "{pr_year}"},
                        {value: 'month_id', text: '{pr_month}'},
                        {value: 'month', text: '{otmonth}'},
                        {value: 'department_id', text: '{department_id}'},
                        {value: 'emp_ids', text: '{emp_ids}'},
                        {value: 'empGrades', text: '{empGrades}'},
                        {value: 'empClasses', text: '{empClasses}'},
                        {value: 'date', text: '{date}'},
                        {value: 'monthYears', text: '{monthYears}'}
                    ],
                    '13': [ // APPROVAL MODULE
                        {value: '', text: '{text}'},
                        {value: 'bill_code', text: '{bill_code}'},
                        {value: 'pr_year', text: "{pr_year}"},
                        {value: 'month_id', text: '{pr_month}'},
                        {value: 'month', text: '{otmonth}'},
                        {value: 'department_id', text: '{department_id}'},
                        {value: 'emp_ids', text: '{emp_ids}'},
                        {value: 'empGrades', text: '{empGrades}'},
                        {value: 'empClasses', text: '{empClasses}'},
                        {value: 'date', text: '{date}'},
                        {value: 'monthYears', text: '{monthYears}'}

                    ],
                    '14': [ // HAS MODULE
                        {value: '', text: '{text}'},
                        {value: 'house_id', text: '{house List}'},
                        {value: 'advertisement_id', text: '{advertisement}'},
                        {value: 'house_status_id', text: '{house_status}'},
                        {value: 'emp_ids', text: '{emp_ids}'},
                        {value: 'date', text: '{date}'},
                        {value: 'date_range', text: '{Date Range}'},
                        {value: 'l-colony', text: '{Colony List}'},
                        {value: 'buildingList', text: '{Building List}'},
                        {value: 'l-house-type', text: '{House Type List}'},
                        {value: 'house_status_id', text: '{House Status List}'},
                        {value: 'dpt_department_id', text: '{Department List}'},
                        {value: 'employees', text: '{Employee List}'},

                    ],
                    '15': [ // AMS MODULE
                        {value: '', text: '{text}'},
                        {value: 'bill_code', text: '{bill_code}'},
                        {value: 'pr_year', text: "{pr_year}"},
                        {value: 'month_id', text: '{pr_month}'},
                        {value: 'month', text: '{otmonth}'},
                        {value: 'department_id', text: '{department_id}'},
                        {value: 'emp_ids', text: '{emp_ids}'},
                        {value: 'date', text: '{date}'}
                    ],
                    '16': [ // LOAN MODULE
                        {value: '', text: '{text}'},
                        {value: 'bill_code', text: '{bill_code}'},
                        {value: 'pr_year', text: "{pr_year}"},
                        {value: 'month_id', text: '{pr_month}'},
                        {value: 'month', text: '{otmonth}'},
                        {value: 'department_id', text: '{department_id}'},
                        {value: 'emp_ids', text: '{emp_ids}'},
                        {value: 'date', text: '{date}'}
                    ],
                    '17': [ // ORS MODULE
                        {value: '', text: '{text}'},
                        {value: 'circular_only', text: '{circular_only}'},
                        {value: 'circular', text: '{circular}'},
                        {value: 'circular_exam_type', text: '{circular exam type}'},
                        {value: 'circular_exam_roll', text: '{circular exam roll}'},
                        {value: 'exam_center', text: '{Exam Center}'},
                        {value: 'exam_building', text: '{Exam Building List}'},
                        {value: 'exam_room', text: '{Exam Room List}'},
                        {value: 'exam_type', text: '{exam type}'},
                        {value: 'emp_ids', text: '{emp_ids}'},
                        {value: 'date', text: '{date}'},
                        {value: 'date_time', text: '{date time}'}
                    ],
                    '18': [ // INCIDENT MANAGEMENT SYSTEM FOR SECURITY DEPARTMENT.
                        {value: '', text: '{text}'},
                        {value: 'inc_type_subtype', text: '{Incidence Type Sub-type}'},
                        {value: 'date_range', text: '{Date Range}'},
                        {value: 'inc_no', text: '{Incident Number}'},
                        {value: 'rep_type', text: '{Reporter Type}'},
                        {value: 'inc_area', text: '{Incidence Area}'},
                        {value: 'inc_status', text: '{Incidence Status}'},
                        {value: 'date', text: '{date}'}
                    ],
                    '20': [
                        {value: '', text: '{text}'},
                        {value: 'adt_source_id', text: '{Audit Source}'},
                        {value: 'meetings_id', text: '{Meeting}'},
                        {value: 'audit_id', text: '{Audit}'},
                        {value: 'start_date', text: '{Start Date}'},
                        {value: 'end_date', text: '{End Date}'},
                        {value: 'year', text: '{Year}'},
                        {value: 'month', text: '{Month}'}
                    ],
                    '21': [ // WATCHMAN MANAGEMENT SYSTEM FOR SECURITY DEPARTMENT.
                        {value: '', text: '{text}'},
                        {value: 'watchman_loc', text: '{Location (Division, District, Thana)}'},
                        {value: 'watchman_status', text: '{Job Status}'},
                        {value: 'watchman_no', text: '{Watchman Number}'},
                        {value: 'booking_no', text: '{Booking Number}'},
                        {value: 'invoice_no', text: '{Invoice Number}'},
                        {value: 'p_book_or_inv', text: '{Booking Or Invoice}'},
                        {value: 'datepicker', text: '{Date}'},
                        {value: 'date_range', text: '{Date Range}'},
                        {value: 'month_year', text: '{Month Year}'},
                        {value: 'agency', text: '{Agency}'},
                        {value: 'date', text: '{date}'},
                        {value: 'bank', text: '{bank}'},
                        {value: 'bank_branch', text: '{bank_branch}'}
                    ],
                    '28':[
                        {value: '', text: '{text}'},
                        {value: 'vehicle_id', text: '{Vehicle Reg. No.}'},
                        {value: 'driver_id', text: '{Driver CPA Reg. No.}'},
                        {value: 'date_range', text: '{Date Range}'},
                        {value: 'vehicle_id', text: '{Vehicle List}'},
                        {value: 'workshop_id', text: '{Maintenance Job No.}'},
                        {value: 'department_id', text: '{Department List}'},
                        {value: 'maintenance_id', text: '{Job No.}'},
                        {value: 'driver_type_id', text: '{Driver type}'},
                        {value: 'vehicle_class_id', text: '{Vehicle Class}'},
                        {value: 'p_EMPLOYEE_ID', text: '{Employee List}'},
                        {value: 'job_by', text: '{Job by List}'},
                        {value: 'active_yn', text: '{Status}'},
                    ],
                    '30':[
                        {value: '', text: '{text}'},
                        {value: 'chalan_app_list', text: '{chalan app list}'},
                        {value: 'application_list', text: '{application list}'},
                        {value: 'date_range', text: '{Date Range}'},
                        {value: 'start_date', text: '{start date}'},
                        {value: 'end_date', text: '{end date}'},
                        {value: 'substation_list', text: '{substation list}'},
                        {value: 'choose_bill_customer', text: '{customers bill List}'},
                        {value: 'paid_bill_no', text: '{Paid Bill No.}'},
                        {value: 'customers_list', text: '{customer list}'},
                        {value: 'year', text: '{Year List}'},
                        {value: 'month', text: '{month List}'},
                        {value: 'special_msg', text: '{special Message}'},
                        {value: 'customers_with_bill', text: '{Customer Bill}'},
                        {value: 'application_types', text: '{Application types List}'},
                        {value: 'application_status', text: '{Application Status List}'},
                        {value: 'connection_type', text: '{Connection Type List}'},
                        {value: 'person_yn', text: '{Person (Yes/No)}'},
                        {value: 'month_number', text: '{Number of Last Months}'},
                        {value: 'active_yn', text: '{Status}'},
                    ],
                    '31': [ // WATER BILLING SYSTEM.
                        {value: '', text: '{text}'},
                        {value: 'p_booking_mst_id', text: '{Booking Number}'},
                        {value: 'p_invoice_mst_id', text: '{Invoice Number}'},
                        {value: 'p_book_or_inv', text: '{Booking Or Invoice}'},
                        {value: 'p_req_id', text: '{Requisition Number}'},
                        {value: 'date_range', text: '{Date Range}'},
                        {value: 'p_active_yn', text: '{Status}'},
                    ],
                    '33': [ // Contract Management SYSTEM.
                        {value: '', text: '{text}'},
                        {value: 'contract_id', text: '{Contract List}'},
                        {value: 'contract_status', text: '{Contract Status}'},
                        {value: 'contractForMilestone', text: '{Contract List on Milestone}'},
                        {value: 'milestoneByContract', text: '{Milestone Depend on Contract}'},
                        {value: 'milestone_status', text: '{Milestone status}'},
                        {value: 'tender_proposal_id', text: '{Tender Proposal No.}'},
                        {value: 'timeExtContract', text: '{Time Extended Contact}'},
                        {value: 'budgetExtContract', text: '{Budget Extended Contact}'},
                        {value: 'contractor_id', text: '{Contractor List}'},
                        {value: 'p_year', text: '{Year List}'},
                        {value: 'date_range', text: '{Date Range}'},
                        {value: 'p_active_yn', text: '{Status}'},
                    ],
                    '38': [  // DOCUMENT VERIFICATION.
                        {value: '', text: '{text}'},
                        {value: 'igm_dependent_mlo', text: '{IGM Dependent MLO}'},
                        {value: 'date_range', text: '{Date Range}'},
                        {value: 'from_date', text: '{From Date}'},
                        {value: 'verification_status', text: '{Verification Status}'},
                        {value: 'igm_dependent_bl', text: '{IGM Dependent BL}'},
                        {value: 'igm_dep_ctn', text: '{IGM Dep Container}'},
                        {value: 'imp_reg_no', text: '{Import Reg No}'},
                    ],
                    '39': [
                        {value: '', text: '{text}'},
                        {value: 'file_list', text: '{file list}'},
                        {value: 'date_range', text: '{Date Range}'},
                        {value: 'department_list', text: '{department list}'},
                        {value: 'building_list', text: '{building list}'},
                        {value: 'emp_list', text: '{Employee list}'},
                        {value: 'month', text: '{month list}'},
                        {value: 'year', text: '{year list}'},
                        {value: 'start_date', text: '{start date}'},
                        {value: 'end_date', text: '{end date}'}
                    ]
                },
                totalList: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
            }
        },
        methods: {
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/admin/system-admin/reports').then(result => {
                    this.modules = result.data.modules;
                    this.items = result.data.reports;
                    this.totalList = result.data.reports.length;
                });
            },
            addReportsParam: function () {
                this.createReportsParam.params.push(Vue.util.extend({}, this.params));
                if(this.createReportsParam.params.length > 8) {
                    this.disabled = true;
                } else {
                    this.disabled = false;
                }
            },
       removeReportsParam: function(index) {
                Vue.delete(this.createReportsParam.params, index);
                if(this.createReportsParam.params.length < 9) {
                    this.disabled = false;
                } else {
                    this.disabled = true;
                }
            },
            onSubmit(evt) {
                let currObj = this;
                console.log(this.param);
                this.report.report_params = this.createReportsParam.params;
                this.$validator.validateAll().then(() => {
                    if (!this.errors.any()) {
                        this.keepDisable = true;
                        if(this.updateIndex > 0) {
                            ApiRepository.callApi(ApiRepository.PUT_COMMAND,`/admin/system-admin/reports/${this.updateIndex}`,this.report).then(result => {
                                if (result.data.o_status_code == 1) {
                                    currObj.onReset();
                                    this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' })
                                } else{
                                    this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' })
                                }
                                currObj.loadData();
                                this.keepDisable = false;
                            });
                        }else {
                            ApiRepository.callApi(ApiRepository.POST_COMMAND, '/admin/system-admin/reports', this.report).then(result => {
                                if (result.data.o_status_code == 1) {
                                    this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' })
                                } else{
                                    this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' })
                                }
                                currObj.loadData();
                                currObj.onReset();
                                this.keepDisable = false;
                            });
                        }
                    }
                });
            },
            onReset(evt) {
                this.deletedItem = null;
                this.updateIndex = -1;
                this.submitBtn = 'Save';
                this.show = false;
                this.$nextTick(() => {
                    this.report.report_id = '';
                    this.report.module_id = '';
                    this.report.report_name = '';
                    this.report.report_xdo_path = '';
                    this.report.report_rtf_path = '';
                    this.report.report_params = '';
                    this.createReportsParam = {
                            params: [
                                { param_name: '', param_label: '', requied_yn: '', default_value: ''},
                              ]
                    };
                    this.show = true;
                });
            },
            editRow(id) {
                this.updateIndex = id;
                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/admin/system-admin/reports/${id}`).then(result => {
                    this.submitBtn = 'Update';
                    this.report = result.data;
                    if(result.data.params.length > 0){
                        this.createReportsParam.params = result.data.params;
                    }else{
                         this.createReportsParam = {
                            params: [
                                { param_name: '', param_label: '', requied_yn: '', default_value: ''},
                              ]
                      };
                    }

                });

            },
            deleteRow() {
                if (this.deletedItem !== undefined && this.deletedItem) {
                    ApiRepository.callApi(ApiRepository.DELETE_COMMAND,`/admin/system-admin/reports/${this.deletedItem.report_id}`).then( result => {
                        if (result.data.o_status_code == 1) {
                            this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' })
                        } else{
                            this.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' })
                        }
                        this.deletedItem = null;
                        this.loadData();
                        this.onReset();
                    }).catch(err => {
                        this.deletedItem = null;
                        console.log(err);
                    });
                }
            }
        }

    }
</script>
<style>
    .param-heading{
        background-color: aliceblue;
        margin-bottom: 16px;
        padding-top: 17px;
    }
    .param-heading label {
        font-size: 13px;
        font-weight: 600;
    }
</style>
