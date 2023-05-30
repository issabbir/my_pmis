<template>
    <div class="content-body">
        <div class="col-md-12 col-sm-12 pr-md-0 ">
            <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
                <b-card title="Search Employee's Charge">
                    <b-card-body class="border">
                        <b-row>
                            <b-col md="3">
                                <b-form-group
                                    label="Employee Code"
                                    label-for="emp_code"
                                >
                                    <v-select
                                        label="option_name"
                                        id="emp_code"
                                        name="emp_code"
                                        v-model="searchSelectedEmployee"
                                        :options="empIdList"
                                        @search="searchempcods">

                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Division"
                                    label-for="src_division_id"
                                >
                                    <v-select v-model="division" :options="divisionList"
                                              name="src_division_id" id="src_division_id" label="text"
                                              class="uppercase">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Department"
                                    label-for="src_department"
                                >
                                    <v-select v-model="department" :options="departmentList"
                                              name="src_department" id="src_department" label="text"
                                              class="uppercase">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Section"
                                    label-for="src_section"
                                >
                                    <v-select v-model="section" :options="sectionList"
                                              name="src_section" id="src_section" label="text"
                                              class="uppercase">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Designation"
                                    label-for="designation_id"
                                >
                                    <v-select v-model="designation" :options="designationList"
                                              name="designation_id" id="designation_id" label="text"
                                              class="uppercase">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Employee Grade"
                                    label-for="employee_grade"
                                >
                                    <v-select v-model="employeeGrade" :options="gradeList"
                                              name="employee_grade" id="employee_grade" label="text"
                                              class="uppercase">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Order No"
                                    label-for="order_no_search"
                                >
                                    <b-form-input id="order_no_search" name="order_no_search" class="uppercase" v-model="searchCharge.c_order_no" placeholder="Order No" trim></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Order Date"
                                    label-for="order_date_search"
                                >
                                    <date-picker
                                        id="order_date_search"
                                        name="order_date_search"
                                        width="100%"
                                        input-class="form-control"
                                        v-model="searchCharge.orderDate"
                                        type="date"
                                        lang="en"
                                        format="DD-MM-YYYY"
                                        :value-type="dateValueType"></date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="Charge Type"
                                    label-for="charge_type_id"
                                >
                                    <v-select v-model="chargeType" :options="chargeTypeList"
                                              name="charge_type_id" id="charge_type_id_search" label="text"
                                              class="uppercase">
                                        <template #search="{attributes, events}">
                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                        </template>
                                    </v-select>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col class="d-flex justify-content-end ">
                                <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Search</b-button> &nbsp;
                                <b-button type="reset" class="btn btn-outline-dark  mb-1">Reset</b-button>
                            </b-col>
                        </b-row>
                    </b-card-body>
                </b-card>
            </b-form>

            <b-card>
                <b-card-title>
                    Charge List
                    <b-button type="submit" @click="addNewCharge" variant="success" size="sm" class="float-right">Add New Charge</b-button> &nbsp;
                </b-card-title>
                <b-card-body class="border">
                    <Datatable v-bind:fields="tableData.fields" v-bind:items="onSubmit" :totalList="totalList" :per-page="perPage">
                        <template v-slot:action3="{ rows }">
                            <b-link ml="4" class="text-primary" @click="editRow(rows.item)">
                                <i class="bx bx-edit cursor-pointer"></i>
                            </b-link>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>
            <b-modal id="modal-xl" size="xl" centered no-close-on-backdrop ref="insertModal"  @ok.prevent="onSubmitModal" @cancel.prevent="onResetModal" title="Charge Entry">
                <b-form>
                    <b-card-body>
                        <fieldset class="border pr-2 pl-2">
                            <legend class="w-auto">Employee Details</legend>
                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                        class="requiredField"
                                        id="employee_name"
                                        label="Employee Code"
                                        label-for="employee_name"
                                    >
                                        <v-select
                                            label="option_name"
                                            v-model="selectedEmployee"
                                            :options="employeeList"
                                            name="employee_name"
                                            @search="searchEmployee">
                                            <template #selected-option="{ emp_code }">
                                                <div style="display: flex; align-items: baseline;">
                                                    {{ emp_code }}
                                                </div>
                                            </template>
                                        </v-select>
                                        <div :class="{'invalid-feedback':true ,'d-block':$v.chargeEntry.emp_id.$error && !$v.chargeEntry.emp_id.required}">Employee is required!</div>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Employee Name"
                                        label-for="employee_name"
                                    >
                                        <b-form-input v-model="chargeEntry.emp_name" id="employee_name" readonly  type="text" placeholder="Employee Name"></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Division"
                                        label-for="division"
                                    >
                                        <b-form-input v-model="chargeEntry.division" id="division" readonly  type="text" placeholder="Division"></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Department"
                                        label-for="department"
                                    >
                                        <b-form-input v-model="chargeEntry.department" id="department" readonly  type="text" placeholder="Department"></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Designation"
                                        label-for="designation"
                                    >
                                        <b-form-input v-model="chargeEntry.designation" id="designation" readonly  type="text" placeholder="Designation"></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4" style="display: none">
                                    <b-form-group
                                        label="Section"
                                        label-for="section"
                                    >
                                        <b-form-input v-model="chargeEntry.section" id="section" readonly  type="text" placeholder="Section"></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Employee Grade"
                                        label-for="emp_grade"
                                    >
                                        <b-form-input v-model="chargeEntry.emp_grade" id="emp_grade" readonly  type="text" placeholder="Employee Grade"></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </fieldset>

                        <br>
                        <fieldset class="border pr-2 pl-2">
                            <legend class="w-auto">Charge Details</legend>

                            <b-row>
                                <b-col md="4">
                                    <b-form-group
                                        class="requiredField"
                                        id="charge_type_id"
                                        label="Charge Type"
                                        label-for="charge_type_id"
                                    >
                                        <b-form-select
                                            id="charge_type_id"
                                            v-model.trim="$v.chargeEntry.charge_type_id.$model"
                                            :options="chargeTypeList"
                                            name="charge_type_id">
                                        </b-form-select>
                                        <div :class="{'invalid-feedback':true ,'d-block':$v.chargeEntry.charge_type_id.$error && !$v.chargeEntry.charge_type_id.required}">Charge type is required!</div>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        class="requiredField"
                                        label="Division"
                                        label-for="dpt_division_id">
                                        <v-select  v-model.trim="modalDivision" :options="modalDivisionList"
                                                   name="dpt_division_id" id="dpt_division_id"
                                                   label="text" class="uppercase"
                                                   @input="divisionChange(modalDivision.value)">
                                            <template #search="{attributes, events}">
                                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                                            </template>
                                        </v-select>
                                        <div :class="{'invalid-feedback':true ,'d-block':$v.chargeEntry.charge_dpt_division_id.$error && !$v.chargeEntry.charge_dpt_division_id.required}">Division is required!</div>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        class="requiredField"
                                        label="DEPARTMENT"
                                        label-for="dpt_department_id">
                                        <v-select v-model.trim="modalDepartment" :options="modalDepartmentList"
                                                  name="dpt_department_id" id="dpt_department_id"
                                                  label="text" class="uppercase"
                                                  @input="departmentChange(modalDepartment.value)">
                                            <template #search="{attributes, events}">
                                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                                            </template>
                                        </v-select>
                                        <div :class="{'invalid-feedback':true ,'d-block':$v.chargeEntry.charge_dpt_department_id.$error && !$v.chargeEntry.charge_dpt_department_id.required}">Department is required!</div>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="SECTION"
                                        label-for="section_id">
                                        <v-select
                                            v-model="modalSection"
                                            :options="modalSectionList"
                                            name="section_id"
                                            id="section_id"
                                            class="uppercase"
                                            label="text">
                                            <template #search="{attributes, events}">
                                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                                            </template>
                                        </v-select>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        class="requiredField"
                                        label="DESIGNATION"
                                        label-for="modal_designation_id">
                                        <v-select v-model="modalDesignation" :options="modalDesignationList"
                                                  name="designation_id" id="modal_designation_id" label="designation"
                                                  class="uppercase"
                                                  @input="designationChange(modalDesignation.designation_id)">
                                            <template #search="{attributes, events}">
                                                <input class="vs__search" v-bind="attributes" v-on="events"/>
                                            </template>
                                        </v-select>
                                        <div :class="{'invalid-feedback':true ,'d-block':$v.chargeEntry.charge_designation_id.$error && !$v.chargeEntry.charge_designation_id.required}">Designation is required!</div>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        label="Grade"
                                        label-for="grade"
                                    >
                                        <b-form-input v-model.trim="chargeEntry.charge_emp_grade" id="grade" readonly  type="text" placeholder="Grade"></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4">
                                    <b-form-group
                                        class="requiredField"
                                        label="Order No"
                                        label-for="order_no"
                                    >
                                        <b-form-input
                                            id="order_no"
                                            type="text"
                                            v-model="$v.chargeEntry.c_order_no.$model"
                                            placeholder="Order No"
                                            ></b-form-input>
                                        <div :class="{'invalid-feedback':true ,'d-block':$v.chargeEntry.c_order_no.$error && !$v.chargeEntry.c_order_no.required}">Order number is required!</div>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4" :class="{pointerEvents:!chargeEntry.emp_joining_date}">
                                    <b-form-group
                                        class="requiredField"
                                        id="order_date"
                                        label="Order Date"
                                        label-for="order_date"
                                    >
                                        <date-picker
                                            width="100%"
                                            input-class="form-control"
                                            :not-before="chargeEntry.emp_joining_date"
                                            :editable="false"
                                            v-model.trim="$v.chargeEntry.order_date.$model"
                                            type="date" lang="en"
                                            format="DD-MM-YYYY"
                                            :value-type="dateValueType"
                                            name="order_date">
                                        </date-picker>
                                        <div :class="{'invalid-feedback':true ,'d-block':$v.chargeEntry.order_date.$error && !$v.chargeEntry.order_date.required}">Order date is required!</div>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4" :class="{pointerEvents:!chargeEntry.order_date}">
                                    <b-form-group
                                        class="requiredField"
                                        label="Charge Activation Date"
                                        label-for="charge_activation_date"
                                    >
                                        <date-picker
                                            width="100%" id="charge_activation_date"
                                            input-class="form-control"
                                            :editable="false"
                                            :not-before="chargeEntry.order_date"
                                            v-model.trim="$v.chargeEntry.charge_activation_date.$model"
                                            type="date"
                                            lang="en"
                                            format="DD-MM-YYYY"
                                            :value-type="dateValueType"
                                            name="charge_activation_date">
                                        </date-picker>
                                        <div :class="{'invalid-feedback':true ,'d-block':$v.chargeEntry.charge_activation_date.$error && !$v.chargeEntry.charge_activation_date.required}">Charge activation date is required!</div>
                                    </b-form-group>
                                </b-col>
                                <b-col md="4" :class="{pointerEvents:!chargeEntry.charge_activation_date}">
                                    <b-form-group
                                        label="Charge End Date"
                                        label-for="charge_end_date"
                                    >
                                        <date-picker
                                            width="100%"
                                            id="charge_end_date"
                                            input-class="form-control"
                                            v-model="chargeEntry.charge_end_date"
                                            :editable="false"
                                            :not-before="chargeEntry.charge_activation_date"
                                            type="date"
                                            lang="en"
                                            format="DD-MM-YYYY"
                                            :value-type="dateValueType"
                                            name="charge_end_date">
                                        </date-picker>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4">
                                    <b-form-group
                                        label="Total Working Day"
                                        label-for="dayCount"
                                    >
                                        <b-form-input v-model="dayCount" id="dayCount"  readonly type="text" placeholder="Days"></b-form-input>
                                    </b-form-group>
                                </b-col>
                                <b-col sm="4">
                                    <b-form-group class="message" label="ATTACHMENT" label-for="orderAttachment" >
                                        <b-form-file @change="encodeFile"
                                                     id="orderAttachment"
                                                     placeholder="Attachment"
                                        ></b-form-file>
                                    </b-form-group>
                                </b-col>
                                <!--<b-col md="4" v-if="canHavePermission()">
                                    <b-form-group
                                        class="requiredField"
                                        label="Status Type"
                                        label-for="approved_yn"
                                    >
                                        <b-form-select
                                            id="approved_yn"
                                            v-model.trim="$v.chargeEntry.approved_yn.$model"
                                            :options="statusList"
                                            name="status_type">
                                        </b-form-select>
                                        <div :class="{'invalid-feedback':true ,'d-block':$v.chargeEntry.approved_yn.$error && !$v.chargeEntry.approved_yn.required}">Status type is required!</div>
                                    </b-form-group>
                                </b-col>-->
                                <b-col md="12" v-if="chargeEntry.charge_type_id==2">
                                    <b-form-group
                                        class="requiredField"
                                        label="Additional Charge Details"
                                        label-for="additional_charge_details"
                                    >
                                        <b-form-textarea
                                            rows="2"
                                            max-rows="5"
                                            id="additional_charge_details"
                                            v-model.trim="$v.chargeEntry.additional_charge_details.$model"
                                            placeholder="Additional Charge Details">
                                        </b-form-textarea>
                                        <div :class="{'invalid-feedback':true ,'d-block':$v.chargeEntry.additional_charge_details.$error && !$v.chargeEntry.additional_charge_details.required}">Additional charge details is required!</div>
                                    </b-form-group>
                                </b-col>

                                <b-col md="12">
                                    <b-form-group
                                        label="Description"
                                        label-for="description"
                                    >
                                        <b-form-textarea id="description" v-model="chargeEntry.description" placeholder="Description" rows="2" max-rows="5" ></b-form-textarea>
                                    </b-form-group>

                                </b-col>
                            </b-row>
                        </fieldset>
                    </b-card-body>
                </b-form>
            </b-modal>
        </div>
    </div>
</template>

<script>
    import DatePicker from 'vue2-datepicker';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from "../../Repository/ApiRepository";
    import moment from 'moment';
    const {required, maxLength, minLength, email, requiredIf} = require("vuelidate/lib/validators");
    export default {

        components: { DatePicker, Datatable, vSelect, vcss },
        data() {
            return {
                division:{text:'', value:''},
                modalDivision:{text:'', value:''},
                department:{text:'', value:''},
                modalDepartment:{text:'', value:''},
                section:{text:'', value:''},
                modalSection:{text:'', value:''},
                designation:{text:'', value:''},
                modalDesignation:{text:'', value:''},
                employeeGrade:{text:'', value:''},
                chargeType:{text:'', value:''},
                errorMessage: {color: 'red'},
                dateValueType: this.dateFormatter(),
                searchCharge:{
                    c_order_no:null,
                    chargeType:null,
                    division_id:null,
                    department_id:null,
                    designation_id:null,
                    section_id:null,
                    grade_id:null,
                },
                chargeEntry:{
                    charge_entry_id: '',
                    c_order_no: '',
                    emp_id: '',
                    emp_code: '',
                    order_date: '',
                    charge_type_id: '',
                    description: '',
                    charge_activation_date: '',
                    charge_end_date: '',
                    approved_yn: 'N',
                    additional_charge_details:'',
                    charge_dpt_division_id: '',
                    charge_dpt_department_id: '',
                    charge_section_id: '',
                    charge_emp_grade_id: '',
                    charge_designation_id: '',
                    dayCount:0,
                    emp_grade: '',
                    charge_emp_grade: '',
                    chargeType: '',
                    statusType: '',
                    emp_joining_date: '',
                    files: '',
                    filename: '',
                    file_type: ''
                },
                singleOvertimeRegister:{},
                empIdList:[],
                employeeList:[],
                selectedEmployee:{
                    option_name: '',
                    emp_code: '',
                    emp_id: '',
                    emp_name: '',
                    dpt_division: {
                        text: ''
                    },
                    department: {
                        text: ''
                    },
                    designation: {
                        text: ''
                    },
                    grade: {
                        text: ''
                    },
                    section: {
                        text: ''
                    },
                    emp_join_date: ''
                },
                searchSelectedEmployee:null,
                m_emp_id:null,
                emp_id:null,
                m_emp_type_id:null,
                m_department : null,
                keepDisable: false,
                section_id : null,
                designation_id:null,
                m_section : null,
                m_designation:null,
                m_ot_hour:4,
                fromDate : new Date(),
                charge_end_date : new Date(),
                departmentList: [],
                modalDepartmentList: [],
                sectionList: [],
                modalSectionList: [],
                emp_options: [],
                divisionList: [],
                modalDivisionList: [],
                designationList: [],
                modalDesignationList: [],
                gradeList: [],
                show: true,
                updateIndex:-1,
                submitBtn: 'Save',
                resetBtn:'Reset',
                totalList:1,
                reamarks:null,
                perPage:5,
                index:1,
                tableData: {
                    fields: [
                        {key:'index',label:'SL', sortable:true},
                        {key:'emp_code',label:'EMP Code', sortable:true},
                        {key:'employee.emp_name',label:'EMP Name', sortable:true},
                        {key:'charge_type.charge_type_name',label:'Charge Type', sortable:true},
                        {key:'order_date', formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable:true, class:'text-right'},
                        {key:'charge_activation_date',formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, label:'Activation Date', sortable:true, class:'text-right'},
                        {key:'charge_end_date',formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, label:'End Date', sortable:true, class:'text-right'},
                        {key:'approved_yn',formatter: value => {
                                return (value == 'Y')?'Approved':'Incomplete';
                            }, label:'Status Type', sortable:true},
                        {key:'action3',label:'Action', class:'text-center'}
                    ],
                    items: []
                },
                registerApproval:1,
                chargeTypeList: [],
                statusList: [
                     {value: 'Y', text: 'Approved'},
                     {value: 'N', text: 'Incomplete'}
                ]

            };
        },
        validations: {
            chargeEntry: {
                charge_entry_id: {},
                c_order_no: {
                    required
                },
                emp_id: {required},
                emp_code: {required},
                order_date: {required},
                charge_type_id: {required},
                description: {},
                charge_activation_date: {required},
                charge_end_date: {},
                approved_yn: {},
                additional_charge_details:{
                    required: requiredIf(function () {
                        return this.chargeEntry.charge_type_id == 2 ? true : false
                    })
                },
                charge_dpt_division_id: {
                    required
                },
                charge_dpt_department_id: {
                    required
                },
                charge_section_id: {},
                charge_emp_grade_id: {
                    required
                },
                charge_designation_id: {
                    required
                },
            }
        },
        watch: {
            searchSelectedEmployee:function(val,oldVal) {
                if(val != null) {
                    this.searchCharge.emp_id = val.emp_id;
                }
            },
            division : function(val, oldVal){
                if(val !== null) {
                    this.searchCharge.division_id = val.dpt_division_id;
                } else {
                    this.searchCharge.division_id = '';
                }
            },
            modalDivision : function(val, oldVal){
                if(val !== null) {
                    this.chargeEntry.charge_dpt_division_id = val.value;
                } else {
                    this.chargeEntry.charge_dpt_division_id = '';
                }
            },
            department : function(val, oldVal){
                if(val !== null) {
                    this.searchCharge.department_id = val.department_id;
                } else {
                    this.searchCharge.department_id = '';
                }
            },
            modalDepartment : function(val, oldVal){
                if(val !== null) {
                    this.chargeEntry.charge_dpt_department_id = val.value;
                } else {
                    this.chargeEntry.charge_dpt_department_id = '';
                }
            },
            section : function(val, oldVal){
                if(val !== null) {
                    this.searchCharge.section_id = val.value;
                } else {
                    this.searchCharge.section_id = '';
                }
            },
            modalSection : function(val, oldVal){
                if(val !== null) {
                    this.chargeEntry.charge_section_id = val.dpt_section_id;
                } else {
                    this.chargeEntry.charge_section_id = '';
                }
            },
            designation : function(val, oldVal){
                if(val !== null) {
                    this.searchCharge.designation_id = val.designation_id;
                } else {
                    this.searchCharge.designation_id = '';
                }
            },
            modalDesignation : function(val, oldVal){
                if(val !== null) {
                    this.chargeEntry.charge_designation_id = val.designation_id;
                } else {
                    this.chargeEntry.charge_designation_id = '';
                }
            },
            employeeGrade : function(val, oldVal){
                if(val !== null) {
                    this.searchCharge.grade_id = val.emp_grade_id;
                } else {
                    this.searchCharge.grade_id = '';
                }
            },
            chargeType : function(val, oldVal){
                if(val !== null) {
                    this.searchCharge.charge_type_id = val.charge_type_id;
                } else {
                    this.searchCharge.charge_type_id = '';
                }
            },
            selectedEmployee:function(val,oldVal) {
                if(val != null){
                    this.chargeEntry.emp_name=  val.emp_name
                    this.chargeEntry.emp_code=  val.emp_code
                    this.chargeEntry.emp_id=  val.emp_id
                    this.chargeEntry.division=  val.dpt_division.text
                    this.chargeEntry.department=  val.department.text
                    this.chargeEntry.designation=  val.designation.text
                    this.chargeEntry.emp_grade=  val.grade.text
                    this.chargeEntry.section= val.section ? val.section.text:''
                    this.chargeEntry.emp_joining_date = val.emp_join_date
                }
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Employee Information"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Charge Entry"});
            this.allpreloadData()
        },
        computed:{
            dayCount:function(){
                let charge_activation_date=moment(this.chargeEntry.charge_activation_date);
                let charge_end_date=moment(this.chargeEntry.charge_end_date);
                let countDays=charge_end_date.diff(charge_activation_date,'days');
                if (countDays)
                    return this.chargeEntry.charge_activation_date == null || this.chargeEntry.charge_end_date == null ? 0 : countDays+1;

                return '';
             }
        },
        methods: {
            notBeforeSpecificDate(date, days) {
                if(date != '' || date !=  undefined || date != null){
                    if(days == 0 || days == null){
                        return moment(date, 'YYYY-MM-DD');
                    }
                    else {
                        return moment(date, 'YYYY-MM-DD').add(days, 'days');
                    }
                }

            },
            allpreloadData(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/charge-entry').then(result => {
                    this.chargeTypeList = result.data.charge.filter(a=> a.charge_type_id != 3)
                    this.departmentList = result.data.department;
                    this.sectionList = result.data.section;
                    this.designationList = result.data.designation;
                    this.divisionList = result.data.division;
                    this.gradeList = result.data.grade;
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
            searchempcods(id){
                id = id.trim();
                if(id.length > 0) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/charge-entry/emp-info/${id}`, this.chargeEntry).then(res => {
                        this.empIdList = res.data.empcodeList;
                    })
                }
            },
            searchEmployee(id){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/charge-entry/emp-info/${id}`).then(res => {
                    this.employeeList = res.data.empcodeList;
                })
            },
            addNewCharge(){
                this.onResetModalRecord();
                this.allBasicInfo()
                this.$refs['insertModal'].show()
            },
            onSubmit(ctx, callback) {
                if(callback != undefined ){
                    this.provider = callback
                } else {
                    this.provider = this.provider
                }
                ctx.currentPage = ctx.currentPage == undefined ? 1 : ctx.currentPage
                ctx.perPage = ctx.perPage == undefined ? this.perPage : ctx.perPage
                ctx.filter = ctx.filter == undefined ? null : ctx.filter
                ApiRepository.callApi(ApiRepository.POST_COMMAND,'/pmis/charge-entry/search_result'+'?page=' + ctx.currentPage + '&size=' + ctx.perPage+'&filter=' + ctx.filter,this.searchCharge).then(result => {
                    let items = result.data.data.data
                    this.totalList = result.data.data.total
                    this.perPage = result.data.data.per_page
                    this.provider(items)
                });
                return null
            },


            provider(items) {

            },
            onReset() {
                this.searchCharge = {}
                this.searchSelectedEmployee = null
                this.division = {}
                this.department = {}
                this.section = {}
                this.designation = {}
                this.employeeGrade = {}
                this.chargeType = {}
                this.show = false
            },
            onSubmitModal() {
                this.$v.$touch();
                this.$v.chargeEntry.$touch();
                let currObj = this;
                this.chargeEntry.dayCount = this.dayCount;
                if (!this.$v.chargeEntry.$invalid) {
                     ApiRepository.callApi(ApiRepository.POST_COMMAND,'/pmis/charge-entry',this.chargeEntry).then(result => {
                        if(result.data.o_status_code == 1) {
                            currObj.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' })
                            this.$refs['insertModal'].hide()
                            this.allpreloadData()
                            this.onResetModalRecord()
                            } else {
                                currObj.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' })
                            }
                     })
                }
            },
            onResetModal(){
                this.$refs['insertModal'].hide()
                this.onResetModalRecord()
            },
            onResetModalRecord() {
                this.selectedEmployee = {
                    option_name: '',
                    emp_code: '',
                    emp_id: '',
                    emp_name: '',
                    dpt_division: {
                        text: ''
                    },
                    department: {
                        text: ''
                    },
                    designation: {
                        text: ''
                    },
                    grade: {
                        text: ''
                    },
                    section: {
                        text: ''
                    },
                    emp_join_date: ''
                }
                this.modalDivision = {
                    text: '',
                    value: ''
                }
                this.chargeEntry = {
                    charge_entry_id: '',
                    c_order_no: '',
                    emp_id: '',
                    emp_code: '',
                    order_date: '',
                    charge_type_id: '',
                    description: '',
                    charge_activation_date: '',
                    charge_end_date: '',
                    approved_yn: '',
                    additional_charge_details:'',
                    charge_dpt_division_id: '',
                    charge_dpt_department_id: '',
                    charge_section_id: '',
                    charge_emp_grade_id: '',
                    charge_designation_id: '',
                    dayCount:0,
                    emp_grade: '',
                    charge_emp_grade: '',
                    chargeType: '',
                    statusType: '',
                    emp_joining_date: ''
                }
                this.$v.$reset()
                this.submitBtn = "Save"
            },
            editRow(item){
                this.allBasicInfo()
                this.chargeEntry.charge_entry_id = item.charge_entry_id
                this.chargeEntry.c_order_no = item.c_order_no
                this.chargeEntry.charge_type_id = item.charge_type_id
                this.chargeEntry.additional_charge_details = item.additional_charge_detail
                this.chargeEntry.charge_activation_date = item.charge_activation_date
                this.chargeEntry.charge_end_date = item.charge_end_date
                this.chargeEntry.approved_yn = item.approved_yn
                this.chargeEntry.description = item.description
                this.chargeEntry.order_date = item.order_date
                this.selectedEmployee = {
                    option_name: item.emp_code +' '+ item.employee.emp_name,
                    emp_name: item.employee.emp_name,
                    emp_code: item.emp_code,
                    emp_id: item.emp_id,
                    dpt_division: {
                        text: item.division.text
                    },
                    department: {
                        text: item.department.department_name
                    },
                    designation: {
                        text: item.designation.text
                    },
                    grade: {
                        text: item.employee_grade.text
                    },
                    section: {
                        text: item.section ? item.section.text:''
                    },
                    emp_join_date: item.emp_join_date
                }
                this.modalDivision = item.charge_division
                this.divisionChange(item.charge_division.value)
                this.modalDepartment = {
                    text: item.charge_department.department_name,
                    value: item.charge_department.department_id
                }
                this.departmentChange(item.charge_department.department_id)
                this.modalDesignation = item.charge_designation
                this.designationChange(item.charge_designation.value)
                this.modalSection = item.charge_section
                this.chargeEntry.charge_emp_grade = 'Grade '+item.charge_employee_grade.value + ' ('+ item.charge_employee_grade.text+')'
                this.submitBtn = "Update"
                this.resetBtn = "Close"
                this.$refs['insertModal'].show()
            },
            divisionChange(id){
                this.modalDepartment = {text: '', value: ''}
                this.modalDesignation = {text: '', value: ''}
                this.modalSection = {text: '', value: ''}
                this.modalDepartmentList = []
                this.modalDesignationList = []
                this.modalSectionList = []
                this.chargeEntry.charge_emp_grade = ''
                this.chargeEntry.charge_emp_grade_id = ''
                if(id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/departments/${id}`).then(result => {
                        this.modalDepartmentList = result.data
                    })
                }

            },
            departmentChange(id){
                this.modalDesignation = {text: '', value: ''}
                this.modalSection = {text: '', value: ''}
                this.modalDesignationList = []
                this.modalSectionList = []
                this.chargeEntry.charge_emp_grade = ''
                this.chargeEntry.charge_emp_grade_id = ''
                if(id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/admin/sections/${id}`).then(result => {
                        this.modalSectionList = result.data
                    })
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/operation/get-designation-by-department/${id}`).then(res => {
                        this.modalDesignationList = res.data.designations
                    })
                }
            },
            designationChange(id){
                this.chargeEntry.charge_emp_grade = ''
                this.chargeEntry.charge_emp_grade_id = ''
                if (id){
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/employee/basic-infos/by-designation/${id}`).then(resp => {
                        this.chargeEntry.charge_emp_grade = resp.data.grade.text
                        this.chargeEntry.charge_emp_grade_id = resp.data.grade.value
                    })
                }
            },
            allBasicInfo() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/employee/basic-infos').then(result => {
                    this.modalDivisionList = result.data.dptDivision
                })
            },
            canHavePermission() {

                if (this.$store.getters.hasGrantAccess) {
                    return this.$store.getters.hasGrantAccess;
                }

                return this.$store.getters.permissions.includes('CAN_APPROVE_CHARGE_ENTRY');
            },
            encodeFile(e) {
                let file_limit = 2000000;
                let vm = this;
                if(e.target.files[0].size<=file_limit){
                    if (e.target.files[0].type=='application/pdf'||e.target.files[0].type=='image/jpeg'||e.target.files[0].type=='image/jpg'){
                        let file = e.target.files[0];
                        let reader = new FileReader();
                        let type = file.type
                        let name = file.name
                        reader.readAsDataURL(file)
                        reader.onload = (file)=>{
                            vm.chargeEntry.files = reader.result
                            vm.chargeEntry.filename = name
                            vm.chargeEntry.file_type = type
                        }
                    }
                    else {
                        this.$notify({group: 'pmis', text: "File type should be in pdf, jpg or jpeg", type: 'error'})
                    }

                }else{
                    this.$notify({group: 'pmis', text: "File size should not exceed 2MB", type: 'error'})
                    return;
                }

            }
        },
    };
</script>
<style>
    .pull-top{
        margin-top: -12px;
    }
    .pointerEvents{
        pointer-events: none;
    }
    legend{
        font-size: 1rem;
    }
</style>


