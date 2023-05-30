<template>
        <b-container fluid>
            <!-- <Form></Form>
            <Listing></Listing> -->
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Roster Group Search</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSearch" @reset.prevent="onResetSearch" v-if="show" data-vv-scope="search">
                        <b-row class="pull-top d-flex justify-content-between mt-1">

                            <b-col md="3">
                                <b-form-group class="requiredField" id="department_id" label="Department" label-for="department_id">
                                    <b-form-select  @change="findGroups" class="form-control" id="department_id" name="department_id" v-model="rosterDetail.department_id" required v-validate="'required'">
                                        <option value="">Select Department</option>
                                        <option :value="department.value" v-for="department in departments">{{ department.text }}</option>
                                    </b-form-select>
                                    <span :style="errorMessage">{{ errors.first('search.department_id') }}</span>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group class="" id="section_id" label="Section" label-for="section_id">
                                    <b-form-select class="form-control" id="section_id" name="section_id" v-model="rosterDetail.section_id" >
                                        <option value="">Select Section</option>
                                        <option :value="section.value" v-for="section in sections">{{ section.text }}</option>
                                    </b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group class="requiredField" id="month_id" label="Roster month" label-for="month_id">
                                    <b-form-select @change="findGroups" class="form-control" id="month_id" name="month_id" v-model="rosterDetail.month_id" required v-validate="'required'">
                                        <option value="">Select Roster Month</option>
                                        <option :value="month.value" v-for="month in months">{{ month.monthlabel }}</option>
                                    </b-form-select>
                                    <span :style="errorMessage">{{ errors.first('search.roster_month_id') }}</span>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group class="requiredField" id="group_id" label="Group" label-for="group_id">
                                    <b-form-select class="form-control" id="group_id" name="group_id" v-model="rosterDetail.group_id" required v-validate="'required'">
                                        <option value="">Select Group</option>
                                        <option :value="group.value" v-for="group in groups">{{ group.text }}</option>
                                    </b-form-select>
                                    <span :style="errorMessage">{{ errors.first('search.group_id') }}</span>
                                </b-form-group>
                            </b-col>
                                <b-col md="12" class="justify-content-end d-flex mt-2">
                                    <b-button type="reset" variant="outline-dark" :disabled="keepDisable">Reset</b-button> &nbsp;
                                    <b-button type="submit"  variant="dark" :disabled="keepDisable">Search Group</b-button>
                                </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-form @submit="onSubmit" @reset="onReset">
                <b-card>
                    <b-card-header header-bg-variant="dark" header-text-variant="white">{{titleHeading}}</b-card-header>
                    <b-card-body v-if="displaySearchForm" class="border">
                        <b-row>
                            <b-col md="4">
                                <b-form-group
                                    label="Department"
                                    class="requiredField"
                                    label-for="department">
                                    <b-form-select
                                        @change="departemntChange(overtimeRegister.department_id)"
                                        id="department"
                                        required
                                        v-model="overtimeRegister.department_id"
                                        :options="departmentList">
                                    </b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group class="" id="otGroup_id" label="Group" label-for="otGroup_id">
                                    <b-form-select
                                        class="form-control"
                                        id="otGroup_id"
                                        @change="dateFromGroup"
                                        name="otGroup_id"
                                        v-model="rosterDetail.otGroup_id"
                                        required
                                        v-validate="'required'">
                                        <option value="">Select Group</option>
                                        <option :value="group.value" v-for="group in groupsForSearch">{{ group.text }}
                                        </option>
                                    </b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Employee Code"
                                    label-for="emp_code">
                                    <v-select
                                        label="option_name"
                                        id="emp_code"
                                        v-model="searchSelectedEmployee"
                                        :options="empIdListRegistered"
                                        @search="searchRegisteredEmpInfo">
                                    </v-select>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="4">
                                <b-form-group class="requiredField" label="From Date" label-for="fromDate">
                                    <date-picker
                                        width="100%"
                                        :input-attr="{required:'required'}"
                                        input-class="form-control"
                                        v-model="overtimeRegister.fromDate"
                                        :readonly="disbaledDate"
                                        type="date"
                                        lang="en"
                                        format="DD-MM-YYYY"
                                        :value-type="dateValueType">
                                    </date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group class="requiredField" label="To Date" label-for="endDate">
                                    <date-picker
                                        width="100%"
                                        input-class="form-control"
                                        :input-attr="{required:'required'}"
                                        v-model="overtimeRegister.endDate"
                                        :readonly="disbaledDate"
                                        type="date"
                                        lang="en"
                                        format="DD-MM-YYYY"
                                        :value-type="dateValueType">
                                    </date-picker>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group
                                    label="Approval Status"
                                    label-for="approval"
                                >
                                    <b-form-select
                                        v-slot:first
                                        v-model="overtimeRegister.registerApproval"
                                        :options="approvedStatusListToSearch">
                                    </b-form-select>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col>
                                <b-button type="button" @click="showBookingForm" variant="success">Create New Booking
                                </b-button> &nbsp;
                            </b-col>
                            <b-col class="d-flex justify-content-end ">
                                <b-button type="submit" variant="secondary" class=" mr-1">Search</b-button> &nbsp;
                                <b-button type="reset" variant="outline-primary">Reset</b-button>
                            </b-col>
                        </b-row>
                    </b-card-body>
                    <b-card-body v-if="displayBookingForm" class="border">
                        <template>
                            <div>
                                <b-form @submit.prevent="onSubmitModal" @reset.prevent="onResetModal">
                                    <b-row>
                                        <b-col md="3">
                                            <b-form-group
                                                label="OT Per Hour (On day)"
                                                label-for="ot_hour"
                                                class="requiredField">
                                                <b-form-input
                                                    v-model="singleOvertimeRegister.m_ot_hour"
                                                    @input="calculateOtDate()"
                                                    type="number"
                                                    required
                                                    :maxlength="2"
                                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                    v-validate="rulesOn"
                                                    name="m_ot_hour"
                                                    value="4"
                                                    id="m_ot_hour"
                                                    placeholder="Type 1 to 4">
                                                </b-form-input>
                                                <span :style="errorMessage">{{ errors.first('m_ot_hour') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="OT Per Hour (Off day)"
                                                label-for="ot_hour"
                                                class="requiredField">
                                                <b-form-input
                                                    v-model="singleOvertimeRegister.m_ot_off_hour"
                                                    @input="calculateOtDate()"
                                                    type="number"
                                                    required
                                                    :maxlength="2"
                                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                    v-validate="rulesOff"
                                                    id="m_ot_off_hour"
                                                    value="8"
                                                    name="m_ot_off_hour"
                                                    placeholder="Type 1 to 8">
                                                </b-form-input>
                                                <span :style="errorMessage">{{ errors.first('m_ot_off_hour') }}</span>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="From Date"
                                                label-for="fromDate"
                                                class="requiredField">
                                                <date-picker
                                                    width="100%"
                                                    id="fromDate"
                                                    :not-before="noteBeforeDate"
                                                    :not-after="noteAfterDate"
                                                    @input="calculateOtDate()"
                                                    input-class="form-control"
                                                    readonly
                                                    v-model="singleOvertimeRegister.fromDate"
                                                    type="date" lang="en"
                                                    format="DD-MM-YYYY"
                                                    :value-type="dateValueType" required>
                                                </date-picker>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="3">
                                            <b-form-group
                                                label="End Date"
                                                label-for="endDate"
                                                class="requiredField">
                                                <date-picker
                                                    width="100%"
                                                    :not-before="noteBeforeDate"
                                                    :not-after="noteAfterDate"
                                                    @input="calculateOtDate()"
                                                    input-class="form-control"
                                                    readonly v-model="singleOvertimeRegister.endDate"
                                                    type="date" lang="en"
                                                    format="DD-MM-YYYY"
                                                    id="endDate"
                                                    :value-type="dateValueType" required>
                                                </date-picker>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col md="4" style="display:none">
                                            <b-form-group
                                                label="Approval Status"
                                                label-for="approval">
                                                <b-form-select
                                                    id="approval"
                                                    v-slot:first
                                                    required
                                                    v-model="singleOvertimeRegister.registerApproval"
                                                    :options="approvedStatusList">
                                                </b-form-select>
                                            </b-form-group>
                                        </b-col>
                                        <b-col md="9">
                                            <b-form-group label="Description" label-for="res">
                                                <b-form-textarea
                                                    v-model="singleOvertimeRegister.remarks"
                                                    placeholder="Put a your valid Description"
                                                    rows="2">
                                                </b-form-textarea>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                    <Datatable v-if="rosterGroupData"  v-bind:fields="otTableData.fields"
                                               v-bind:items="otTableData.items" :totalList="totalList"
                                               :perPage="perPage">
                                        <template v-slot:head1="{ rows }">
                                            <b-form-checkbox
                                                v-model="allSelected"
                                                :indeterminate="indeterminate"
                                                aria-describedby="items"
                                                aria-controls="items"
                                                @change="toggleAll">
                                            </b-form-checkbox>
                                        </template>
                                        <template v-slot:headCell1="{ rows }">
                                            <b-form-checkbox
                                                v-model="rows.item.checkbox"
                                                value="1"
                                                unchecked-value="0"
                                                stacked
                                            ></b-form-checkbox>
                                        </template>
                                        <template v-slot:action3="{ rows }">
                                            <b-form-input readonly="readonly" v-model="rows.item.reg_day_total_hour"
                                                          type="text" placeholder=""></b-form-input>
                                        </template>
                                        <template v-slot:action4="{ rows }">
                                            <b-form-input readonly="readonly" v-model="rows.item.off_day_total_hour"
                                                          type="text" placeholder=""></b-form-input>
                                        </template>
                                        <template v-slot:action5="{ rows }">
                                            <b-form-input readonly="readonly" v-model="rows.item.total_hour" type="text"
                                                          placeholder=""></b-form-input>
                                        </template>
                                        <template v-slot:row-details="{ rows }">
                                            <b-card>
                                                <b-card-body>
                                                    <b-row class="d-flex justify-content-center">
                                                        <b-table :hover=false :items="roserMonthDetails"
                                                                 :fields="['sl','roster_date','shift','available','remarks', 'action']">
                                                            <template v-slot:cell(action)="row" v-bind:row="row">
                                                                <slot name="actions" :rows="row">
                                                                    <a href="javascript:void(0)" @click="moveShift(row)"
                                                                       title="Update shift and unavailbility"> <i
                                                                        class='bx bxs-edit'></i></a>
                                                                </slot>
                                                            </template>
                                                        </b-table>
                                                    </b-row>
                                                </b-card-body>
                                            </b-card>
                                        </template>
                                    </Datatable>
                                    <b-row style="margin-top: 15px">
                                        <b-col>
                                            <b-button type="button" @click="showSearchForm"
                                                      class="btn btn-success shadow mr-1 mb-1">SEARCH DATA
                                            </b-button> &nbsp;
                                        </b-col>
                                        <b-col v-if="rosterGroupData" class="d-flex justify-content-end ">
                                            <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">
                                                {{submitBtn}}
                                            </b-button> &nbsp;
                                            <b-button type="reset" class="btn btn-outline-dark  mb-1">{{resetBtn}}
                                            </b-button>
                                        </b-col>
                                    </b-row>
                                </b-form>
                            </div>
                        </template>
                    </b-card-body>
                </b-card>
            </b-form>
            <b-card v-if="showOverTimeList">
                <b-card-header header-bg-variant="dark" header-text-variant="white">Overtime Register List
                </b-card-header>
                <b-card-body class="border">
                    <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :totalList="totalList"
                               :perPage="perPage">
                        <template v-slot:action2="{ rows }">
                            <b-link ml="4" v-if="rows.item.approve_status == 1" class="text-primary" target="_blank"
                                    :to='"/overtime/"+rows.item.ot_register_id'>
                                <i class="bx bx-edit cursor-pointer"></i>
                            </b-link>
                        </template>
                    </Datatable>
                </b-card-body>
            </b-card>

            <b-modal id="usedUnusedModal" hide-footer v-model="usedUnusedModalShow" title="Employee Roster Slab Details"
                     ref="modal">
                <b-card>
                    <b-card-body class="border">
                        <b-table-simple>
                            <b-thead head-variant="dark">
                                <b-tr>
                                    <b-th>SL</b-th>
                                    <b-th>Available Date</b-th>
                                </b-tr>
                            </b-thead>
                            <b-tbody>
                                <b-tr v-for="(data, index) in otSlabUsedTable.items" :key="data.index"> <!--  -->
                                    <!-- <b-td>{{index}}</b-td> -->
                                    <b-td>{{index+1}}</b-td>
                                    <b-td>{{data.date_from | formatDate}} TO {{data.date_to | formatDate}}</b-td>
                                    <!-- <b-td>{{this.otSlabUsedTable.items['from_date']| formatDate}} TO {{ this.otSlabUsedTable.items['to_date']| formatDate}}</b-td> -->
                                </b-tr>
                            </b-tbody>
                        </b-table-simple>
                    </b-card-body>
                </b-card>
            </b-modal>
        </b-container>
</template>

<script>
        import DatePicker from 'vue2-datepicker';
        import Vue from 'vue';
        import vSelect from 'vue-select';
        import vcss from 'vue-select/dist/vue-select.css';
        import Datatable from '../../../layouts/common/datatable_store';
        import ApiRepository from "../../../Repository/ApiRepository";
        import moment from 'moment';
        const {required, maxLength, minLength, email} = require("vuelidate/lib/validators");
        export default {

        components: { DatePicker,Datatable,Vue,vSelect,vcss },
        data() {
            return {
                dateValueType: this.dateFormatter(),
                fromDate: this.dateFormatter(),
                endDate: this.dateFormatter(),
                disbaledDate: false,
                errorMessage: {color: 'red'},
                rosterDetail: {
                    month_id: '',
                    department_id: '',
                    section_id: '',
                    group_id: '',
                    shift_id: '',
                    fromDate: '',
                    endDate: '',
                },
                authDept: '',
                show: true,
                otPerdayValidationRule: 'max_value:4',
                otPerdayValidationRuleDept: 'max_value:24',
                otPerOffDayValidationRuleDept: 'max_value:24',
                otPerOffDayValidationRule: 'max_value:8',
                showOverTimeList:false,
                rosterGroupData:false,
                months:[],
                departments:[],
                sections:[],
                groups:[],
                groupsForSearch: [],
                keepDisable: false,
                month_slabs:[{value: '', text: 'Select Month Slab'}],
                singleOvertimeRegister:{
                    m_emp_id:0,
                    registerApproval:0,
                    ref_number:null,
                    fromDate : null,
                    endDate :  null,
                    offday:0,
                    regular:0,
                    total:0
                },
                otSlab:{
                    unused:[],
                    used:''
                },
                otSlabUnusedTable: {
                    fields: [
                        {key:'rn',label:'SL', sortable:true},
                        {key:'from_date',label:'From Date', sortable:true},
                        {key:'to_date',label:'To Date', sortable:true}
                        ],
                    items: []
                },
                otSlabUsedTableTotalList:0,
                noteBeforeDate:'',
                noteAfterDate:'',
                otSlabUsedTable: {
                    items: []
                },
                overtimeRegister:{
                    registerApproval:'',
                    endDate: '',
                    fromDate: ''
                },
                empIdListRegistered:[],
                empIdListUnRegistered:[],
                selectedEmployee:{
                },
                searchSelectedEmployee:{},
                m_emp_id:null,
                emp_id:null,
                old_emp_id:null,
                m_emp_type_id:null,
                department : null,
                m_department : null,
                m_department_id : null,
                section : null,
                designation:null,
                section_id : null,
                designation_id:null,
                m_section_id:null,
                m_section : null,
                m_designation:null,
                m_ot_hour:4,
                departmentList: [],//[{ text: 'Select One', value: null }, 'Finance & Accounting', 'Administration'],
                sectionList: [{ text: 'Select One', value: null }, 'Computer', 'Billing'],
                emp_options: [],
                disabledDays: [],
                displayBookingForm: true,
                displaySearchForm: false,
                updateIndex:-1,
                submitBtn: 'Add New Booking',
                resetBtn: 'Reset',
                titleHeading: "Overtime Register",
                totalList:0,
                remarks:null,
                perPage:10,
                index:1,
                modalShow: false,
                usedUnusedModalShow: false,
                selectCheckbox:[],
                allSelected: false,
                allSelectedApprove: false,
                indeterminate: false,
                indeterminateApprove: false,
                //show:false,
                tableData: {
                    fields: [
                        {key:'rn',label:'SL', sortable:true},
                        {key:'emp_code',label:'EMP Code', sortable:true},
                        {key:'emp_name',label:'Name', sortable:true},
                        {key:'designation', label:'Designation',sortable:true} ,
                        {key:'department_name', label:'Department', sortable:true},
                        {key:'dpt_section', label:'Section', sortable:true},
                        {key:'date_from', formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable:true},
                        {key:'date_to',formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable:true},
                        {key:'register_hour', label:'Reg. Hour', sortable:true},
                        {key:'approve_status', formatter: value=>{
                            if(value == 1){
                                return 'Approved';
                            }else if(value == 0){
                                return 'Not Approved';
                            }else if(value == -1){
                                return 'Rejected';
                            }
                        } , sortable:true},
                         {key:'remarks',label:'remarks', sortable:true,tdClass: 'd-none',thClass: 'd-none'},
                         {key:'ot_register_id',label:'ot_register_id', sortable:true,tdClass: 'd-none',thClass: 'd-none'},
                         {key:'emp_id',label:'emp_id', sortable:true,tdClass: 'd-none',thClass: 'd-none'},
                        ],
                    items: []
                },
                otTableData: {
                    fields:[
                        {key: 'head1', label: ''},
                        {key: 'headCell1', label: ''},
                        {key: 'emp_code', label: 'Employee Code'},
                        {key: 'emp_name', label: 'Employee Name'},
                        {key: 'department_name', label: 'Department'},
                        {key: 'section_name', label: 'Section'},
                        {key: 'action3', label: 'Regular OT Hour'},
                        {key: 'action4', label: 'Off Day OT Hour'},
                        {key: 'action5', label: 'Total OT Hour'},
                    ],
                    items:[],
                },
                rosterlistitems:[],
                rosterlisttotalList: 1,
                rosterlistcurrentPage: 1,
                rosterlistperPage: 5,
                //rosterlistpageOptions: [5, 10, 15],
                rosterlistpageOptions: [5, 10, 15, 50,{
                    value: Number.MAX_SAFE_INTEGER,
                    text: "Show All"
                }],
                rosterlistsortBy: '',
                rosterlistsortDesc: false,
                rosterlistsortDirection: 'asc',
                rosterlistfilter: null,
                rosterlistfilterOn: [],
                roserMonthDetails:[],
                approvedStatusList: [ {text: 'Need Approved',value: 0}], // {text: 'Approved', value: 1},
                approvedStatusListToSearch: [ { text: 'Select One', value: null },{text: 'Need Approved',value: 0},{text: 'Approved', value: 1}],

            };
        },
        computed: {
            rulesOn() {
                if (this.rosterDetail.department_id == 1 || this.rosterDetail.department_id == 2 || this.rosterDetail.department_id == 15 || this.rosterDetail.department_id == 18){
                    return this.otPerdayValidationRuleDept;
                }else{
                    return this.otPerdayValidationRule;
                }
            },
            rulesOff() {
                if (this.rosterDetail.department_id == 1 || this.rosterDetail.department_id == 2 || this.rosterDetail.department_id == 15 || this.rosterDetail.department_id == 18){
                    return this.otPerOffDayValidationRuleDept;
                }else{
                    return this.otPerOffDayValidationRule;
                }
            }
        },
        filters: {
            formatDate: function (value) {
                if(value) {
                    return moment(value).format('DD-MM-YYYY');
                }
            }
        },
        watch: {
            selectCheckbox(newVal, oldVal) {
                if (newVal.length === 0) {
                    this.indeterminate = false
                    this.allSelected = false
                } else if (newVal.length === this.items.length) {
                    this.indeterminate = false
                    this.allSelected = true
                } else {
                    this.indeterminate = true
                    this.allSelected = false
                }
            },
            selectedEmployee:function(val,oldVal) {
                if(val != undefined && val != null){
                    //this.singleOvertimeRegister.m_emp_id = '';
                    this.singleOvertimeRegister.emp_name=  val.emp_name;
                    if(val.department_name){
                        this.singleOvertimeRegister.m_department=  val.department_name;
                        this.singleOvertimeRegister.m_department_id=  val.department_id;
                    }
                    if(val.designation)
                        this.singleOvertimeRegister.m_designation=  val.designation;
                    if(val.section){
                        this.singleOvertimeRegister.m_section=  val.section;
                        this.singleOvertimeRegister.m_section_id=  val.section_id;
                    }

                    if(val.emp_id){
                        this.singleOvertimeRegister.m_emp_id=  val.emp_id;
                    }
                    if(val.date_from){
                        this.singleOvertimeRegister.fromDate = moment(this.notBeforeStartDate(val.date_from)).format("YYYY-MM-DD");
                        this.noteBeforeDate = val.date_from;
                    }else{
                         this.noteBeforeDate = '';
                    }
                    if(val.date_to){
                        this.singleOvertimeRegister.endDate = moment(this.notAfterEndDate(val.date_to)).format("YYYY-MM-DD");
                        this.noteAfterDate = val.date_to;
                    }else{
                        this.noteAfterDate = '';
                    }
                        this.detailsRow(val.emp_id); // tooltip button
                        //this.otSlabUsedTable.items['from_date'] = val.date_from;  // tooltip details er bodoley single total range
                        //this.otSlabUsedTable.items['to_date']   = val.date_to;   // tooltip details er bodoley single total range

                }
                this.calculateOtDate();
            },
            searchSelectedEmployee:function(val,oldVal) {
                if(val){
                        this.overtimeRegister.emp_name=  val.emp_name;
                        if(val.department)
                            this.overtimeRegister.department_id=  val.department.department_id;
                        if(val.designation)
                            this.overtimeRegister.designation=  val.designation.designation;
                        if(val.section)
                            this.overtimeRegister.section_id=  val.section.section_id;
                        if(val.emp_id)
                            this.overtimeRegister.emp_id=  val.emp_id;
                }
            }
        },
        mounted() {
                    this.$store.commit("setBreadcrumbEmpty");
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime"});
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime Group Register"});
                    this.allpreloadData();
                    this.calculateOtDate();
                    this.authDepartment();
                    this.singleOvertimeRegister.m_ot_hour=4;
                    this.singleOvertimeRegister.m_ot_off_hour=8;

        },
        methods: {
            toggleAll(checked) {
                for (let i in this.otTableData.items) {
                    this.otTableData.items[i].checkbox =  checked ? '1' : '0';
                }
                if(this.allSelected == false){
                    this.allSelected = false;
                    this.indeterminate = false;
                    for (let i in this.items) {
                        this.selectCheckbox.push(this.otTableData.items[i].emp_id);
                    }
                }else{
                    this.allSelected = true;
                    this.indeterminate = true;
                    this.selectCheckbox = [];
                }
            },
            onSearch() {
                this.$validator.validateAll('search').then(() => {
                    if (!this.errors.any()) {
                        ApiRepository.callApi(ApiRepository.GET_COMMAND, "/overtime/ot-register-booking-groups", {params: this.rosterDetail}).then(res => {
                            this.otTableData.items = res.data.roster_groups;
                            this.totalList = res.data.roster_groups.length;
                            this.rosterlistitems = res.data.roster_details;
                            this.rosterlisttotalList = res.data.roster_details.length;
                            this.month_slabs = res.data.month_slabs;
                            this.rosterGroupData=true;
                            this.displayBookingForm = true;
                            this.displaySearchForm  = false;
                            this.showOverTimeList=false;
                            this.titleHeading = "Overtime Register Entry";
                        });
                    }
                });
            },
            dateFromGroup(id) {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-date-from-group/${id}`).then(res => {
                    this.overtimeRegister.fromDate = res.data[0].fromdate
                    this.overtimeRegister.endDate = res.data[0].enddate
                    this.disbaledDate = true;
                });
            },
            notBeforeStartDate(from_date) {
                if(from_date) {

                    return moment(from_date).add('0', 'days');
                }
            },
            notAfterEndDate(to_date) {
                if(to_date) {
                    return moment(to_date).subtract('0', 'days');
                }
            },
            showUsedUnusedModalDetails(){
                this.usedUnusedModalShow = true;
            },
            detailsRow(emp_id,dateBetweenRecall = '0') {

                if(emp_id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-registers/emp-otslab-used-unused-info/${emp_id}`, this.overtimeRegister).then(res => {
                        this.otSlabUsedTable.items = res.data.unusedOtSlab;

                        if(dateBetweenRecall == '1'){
                          this.singleOvertimeRegister.fromDate = moment(this.notBeforeStartDate(res.data.unusedOtSlab[0].date_from)).format("YYYY-MM-DD");
                          this.noteBeforeDate = res.data.unusedOtSlab[0].date_from;

                          this.singleOvertimeRegister.endDate = moment(this.notAfterEndDate(res.data.unusedOtSlab[0].date_to)).format("YYYY-MM-DD");
                          this.noteAfterDate = res.data.unusedOtSlab[0].date_to;
                        }
                    })
                }
            },
            showBookingForm(){
                this.displayBookingForm = true;
                this.displaySearchForm  = false;
                this.showOverTimeList=false;
                this.titleHeading = "Overtime Register Entry";

                if(this.singleOvertimeRegister.ref_number != undefined || null){
                    this.loadData('b',this.singleOvertimeRegister.ref_number);
                }
            },
            showSearchForm(){
                this.displayBookingForm = false;
                this.displaySearchForm   = true;
                this.titleHeading = "Search Overtime Register";
            },
            allpreloadData(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/overtime/ot-registers').then(result => { //preload-data
                    this.departmentList = result.data.departmentList;
                    this.sectionList    = result.data.sectionList;
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/overtime/ot-roster-details').then(res => {
                    this.months = res.data.months;
                    this.departments = res.data.departments;
                    this.shifts = res.data.shifts;
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

            searchRegisteredEmpInfo(id){
                if(id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-registers/emp-info-registered/${id}`, this.overtimeRegister).then(res => {
                        this.empIdListRegistered=[];
                        this.empIdListRegistered = res.data.empcodeList;
                    })
                }
            },
            searchUnregisteredEmpInfo(id){
                if(id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-registers/emp-info-unregistered/${id}`, this.overtimeRegister).then(res => {
                        this.empIdListUnRegistered=[];
                        this.empIdListUnRegistered = res.data.empcodeList;
                    })
                }
            },
            searchOtEmployeeByRefNumber(where,refNum){

                 if(refNum.length > 0){
                    this.loadData(where,refNum);
                }else{
                    this.tableData.items = [];
                }
            },
            onSubmit(evt) {
                let currObj = this;
                evt.preventDefault();
                let data={};
                data.items = this.otTableData.items.filter(function(item,index) {
                    return item.checkbox == "1";
                    //return  empId.includes(item.emp_id);
                });
                // if (data.items.length > 0) {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND,'/overtime/ot-registers/search_result',this.overtimeRegister).then(result => {
                            //this.tableData.items = result.data.table_info;
                            if(result.data.table_info.length > 0){
                                if(result.data.status){
                                    this.tableData.items = result.data.table_info;
                                    this.showOverTimeList=true;
                                }else{
                                    this.tableData.items = [];
                                }

                            }else{
                                 this.tableData.items = [];
                                 currObj.$notify({ group: 'pmis', text: 'No data found', type:'error' });
                            }
                             this.totalList = result.data.table_info.length;
                             return;
                    });

                // }else {
                //     currObj.$notify({group: 'pmis', text: 'Please select a Employee', type: 'error'});
                // }
            },
            onReset(evt) {
                evt.preventDefault()
                this.overtimeRegister ={};
                this.searchSelectedEmployee = {};
                this.tableData.items = [];
                this.showOverTimeList=false;
                if(this.showBookingForm!=true){
                    this.showBookingForm=true;
                }
                this.$nextTick(() => {
                    this.show = true;
                });
            },
            onResetSearch(evt){
                evt.preventDefault()
            },
            loadData(where,refNum = 0){
                if(refNum.length > 0){
                    let searchObj = {
                        department_id : '',
                        section_id :'',
                        fromDate   :'',
                        endDate    :'',
                        emp_id     :'',
                        ref_number :''
                    };

                    if(where =='b'){
                        searchObj.department_id = this.singleOvertimeRegister.m_department_id;
                        searchObj.section_id    = this.singleOvertimeRegister.m_section_id;
                        searchObj.fromDate      = '';//this.singleOvertimeRegister.fromDate;
                        searchObj.endDate       = '';//this.singleOvertimeRegister.endDate;
                        //searchObj.emp_id        = this.singleOvertimeRegister.m_emp_id;
                        searchObj.ref_number    = refNum;
                    }
                    else{
                        searchObj.department_id = this.overtimeRegister.department_id;
                        searchObj.section_id    = this.overtimeRegister.section_id;
                        searchObj.fromDate      = '';//this.overtimeRegister.fromDate;
                        searchObj.endDate       = '';//this.overtimeRegister.endDate;
                        searchObj.emp_id        = this.overtimeRegister.emp_id;
                        if(this.overtimeRegister.ref_number == undefined || null){
                            searchObj.ref_number    = refNum;
                        }else{
                            searchObj.ref_number    = refNum;
                        }
                    }

                    ApiRepository.callApi(ApiRepository.POST_COMMAND,'/overtime/ot-registers/search_result',searchObj).then(result => {
                            this.tableData.items = result.data.table_info;
                            if(result.data.status){
                                this.tableData.items = result.data.table_info;
                            }else{
                                this.tableData.items = [];
                            }

                            //if(where =='b'){
                                //this.overtimeRegister.ref_number    = refNum;
                                this.searchObj ={};
                            //}
                            this.totalList = result.data.table_info.length;
                    });
                }
            },
            findGroups() {
                if(this.rosterDetail.department_id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/section-by-department/${this.rosterDetail.department_id}`).then(res => {
                        this.sections = res.data;
                        if (res.data.length == 1){
                            this.rosterDetail.section_id = res.data[0].value;
                        }
                    });
                }
                if(this.rosterDetail.month_id && this.rosterDetail.department_id) {
                    let section_id = this.rosterDetail.section_id ? this.rosterDetail.section_id : null;
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-roster-details/find-groups/${this.rosterDetail.month_id}/${this.rosterDetail.department_id}/${section_id}`).then(res => {
                        this.groups = res.data.groups;
                    });
                }

            },
            onSubmitModal() {
                let currObj = this;
                let data={};
                data.items = this.otTableData.items.filter(function(item,index) {
                    return item.checkbox == "1";
                });
                    if(this.singleOvertimeRegister.fromDate == undefined || null){
                        currObj.$notify({ group: 'pmis', text: 'Please enter from date', type:'error' });
                        return;
                    }
                    if(this.singleOvertimeRegister.endDate == undefined || null){
                        currObj.$notify({ group: 'pmis', text: 'Please enter to date', type:'error' });
                        return;
                    }
                    console.log(data.items);
                if (data.items.length > 0) {
                    if(this.updateIndex > 0){
                            ApiRepository.callApi(ApiRepository.POST_COMMAND,`/overtime/ot-registers/update/${this.updateIndex}`,this.singleOvertimeRegister).then(result => {
                            if(result.data.o_status_code == 1) {
                                    currObj.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' });
                                    this.modalShow = false;
                                    this.loadData('b',this.singleOvertimeRegister.ref_number);
                                    this.detailsRow(this.singleOvertimeRegister.m_emp_id,'1');
                                }else {
                                    currObj.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' });
                                }
                            });
                    }else{
                        ApiRepository.callApi(ApiRepository.POST_COMMAND,'/overtime/ot-group-registers',data).then(result => {
                            this.tableData.items = result.data.table_info;
                            if(result.data.o_status_code == 1) {
                                    currObj.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' });
                                    this.singleOvertimeRegister.ref_number = result.data.p_reference_value;
                                    this.loadData('b',this.singleOvertimeRegister.ref_number);
                                    this.detailsRow(this.singleOvertimeRegister.m_emp_id,'1');
                                    this.displayBookingForm = false;
                                    this.displaySearchForm = true;
                            }else {
                                currObj.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' });
                            }
                        });
                    }
                } else {
                    currObj.$notify({group: 'pmis', text: 'Please select a Employee', type: 'error'});
                }
            },
             editRow(rows) {
                 this.singleOvertimeRegister.m_department = rows.item.department_name;
                 this.singleOvertimeRegister.m_section= rows.item.dpt_section;
                 this.singleOvertimeRegister.m_designation=rows.item.designation;
                 this.singleOvertimeRegister.m_ot_hour=rows.item.register_hour;
                 this.singleOvertimeRegister.fromDate=rows.item.date_from;
                 this.singleOvertimeRegister.endDate=rows.item.date_to;
                 this.singleOvertimeRegister.remarks=rows.item.remarks;
                 this.singleOvertimeRegister.registerApproval=rows.item.approve_status;
                 this.selectedEmployee = {};
                 this.selectedEmployee=rows.item.emp_code+' '+rows.item.emp_name;
                 this.singleOvertimeRegister.old_emp_id=rows.item.emp_id;
                 this.singleOvertimeRegister.m_emp_id= null;
                 this.singleOvertimeRegister.ot_register_id=rows.item.ot_register_id;
                 this.modalShow = true;
                 this.submitBtn = 'Update';
                 this.resetBtn  = 'Reset';
                 this.updateIndex = rows.item.ot_register_id;
                 this.calculateOtDate();

             },
            onResetModal() {
                this.singleOvertimeRegister ={
                        registerApproval:0,
                        m_emp_id:'',
                        fromDate:'',
                        endDate:'',
                        offday:0,
                        regular:0,
                        total:0
                };
                this.selectedEmployee = {};
                this.tableData.items = [];

            },
            departemntChange(id){
                if(id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-roster-details/find-groups/${id}`).then(res => {
                        this.groupsForSearch = res.data.groups;
                    });
                }
            },
            authDepartment(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/auth-user-department`).then(res => {
                    // console.log()
                    this.authDept = res.data.auth_user_dept;
                });
            },
            calculateOtDate(){
                let flag = 0;

                if(this.singleOvertimeRegister.m_ot_hour== undefined || this.singleOvertimeRegister.m_ot_hour == null){
                     return true;
                }
                if(this.singleOvertimeRegister.m_ot_off_hour== undefined || this.singleOvertimeRegister.m_ot_off_hour == null){
                     return true;
                }
                if(this.singleOvertimeRegister.fromDate== undefined || this.singleOvertimeRegister.fromDate == null){
                         return true;
                }
                if(this.singleOvertimeRegister.endDate== undefined || this.singleOvertimeRegister.endDate == null){
                          return true;
                }
                var that = this;
                this.rosterDetail.m_ot_off_hour = this.singleOvertimeRegister.m_ot_off_hour;
                this.rosterDetail.m_ot_hour = this.singleOvertimeRegister.m_ot_hour;
                this.rosterDetail.m_ot_off_hour = this.singleOvertimeRegister.m_ot_off_hour;
                this.rosterDetail.fromDate = this.singleOvertimeRegister.fromDate;
                this.rosterDetail.endDate = this.singleOvertimeRegister.endDate;
                this.rosterDetail.ref_number = this.singleOvertimeRegister.ref_number;
                this.rosterDetail.remarks = this.singleOvertimeRegister.remarks;
                this.rosterDetail.registerApproval = this.singleOvertimeRegister.registerApproval;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/overtime/ot-register-booking-groups", {params: this.rosterDetail}).then(res => {
                    this.otTableData.items = res.data.roster_groups;
                    this.totalList = res.data.roster_groups.length;
                    this.rosterlistitems = res.data.roster_details;
                    this.rosterlisttotalList = res.data.roster_details.length;
                    this.month_slabs = res.data.month_slabs;
                    this.rosterGroupData=true;
                    this.displayBookingForm = true;
                    this.displaySearchForm  = false;
                    this.showOverTimeList=false;
                    this.titleHeading = "Overtime Register Entry";

                });
                //     for (let i = 0; i < this.otTableData.items.length; i++ ) {
                //         ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-registers/calculate-ot-date', that.singleOvertimeRegister).then(result => {
                //             // this.singleOvertimeRegister.regular = Number(0);
                //             // this.singleOvertimeRegister.offday = Number(0);
                //             // this.singleOvertimeRegister.total = Number(0);
                //             let res = result.data[0];
                //             that.otTableData.items[i].regular = Number(res.reg_day_total_hour);
                //             that.otTableData.items[i].offday = Number(res.off_day_total_hour);
                //             that.otTableData.items[i].total = Number(res.total_hour);
                //
                //         });
                //this.singleOvertimeRegister.m_emp_id = '';
                //this.otTableData.items = this.otTableData.items;
            }
        },
        };
</script>

