<template>
        <b-container fluid>
               <b-form @submit.prevent="onSubmit" @reset="onReset">
                    <b-card>
                        <b-card-header header-bg-variant="dark" header-text-variant="white">{{titleHeading}}</b-card-header>
                        <b-card-body v-if="displaySearchForm" class="border">
                             <b-row>
                                <b-col md="4">
                                     <label>Employee Code</label>
                                    <v-select
                                        label="option_name"
                                        v-model="searchSelectedEmployee"
                                        :options="empIdListRegistered"
                                        @search="searchRegisteredEmpInfo">

                                    </v-select>
                                </b-col>
                                <b-col md="4">
                                    <label  for="department">Department</label>
                                    <b-form-select @change="findSection"  id="department" v-model="overtimeRegister.department_id" :options="departmentList"></b-form-select>
                                </b-col>
                                <b-col md="4">
                                    <label  for="section">Section</label>
                                    <b-form-select  id="section" v-model="overtimeRegister.section_id" :options="sectionList"></b-form-select>
                                </b-col>
                             </b-row>
                            <b-row>
                                <b-col md="4">
                                    <label  for="fromDate">From Date <span class="text-danger">*</span></label>
                                    <date-picker width="100%" :input-attr="{required:'required'}" onkeydown="return false"  input-class="form-control" v-model="overtimeRegister.fromDate"   type="date" lang="en" format="DD-MM-YYYY" :value-type="dateValueType"></date-picker>
                                </b-col>
                                <b-col md="4">
                                    <label  for="endDate">End Date <span class="text-danger">*</span></label>
                                    <date-picker width="100%"  input-class="form-control" onkeydown="return false" :input-attr="{required:'required'}" v-model="overtimeRegister.endDate"  type="date" lang="en" format="DD-MM-YYYY" :value-type="dateValueType"></date-picker>
                                </b-col>
                                <b-col md="4">
                                    <label for="approval">Approval Status</label>

                                    <b-form-select v-slot:first v-model="overtimeRegister.registerApproval" :options="approvedStatusListToSearch"></b-form-select>
                                </b-col>
                            </b-row>
                            <b-row class="mt-3">
                                    <b-col>
                                        <b-button type="button"   @click="showBookingForm" class="btn btn-success shadow mr-1 mb-1">Create New Booking</b-button> &nbsp;
                                    </b-col>
                                    <b-col class="d-flex justify-content-end ">
                                        <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Search</b-button> &nbsp;
                                        <b-button type="reset" class="btn btn-outline-dark  mb-1">Reset</b-button>
                                    </b-col>
                            </b-row>
                        </b-card-body>
                        <b-card-body v-if="displayBookingForm" class="border">
                            <template>
                                <div>
                                    <b-form @submit="onSubmitModal" @reset="onResetModal" >
                                        <b-row>
                                            <b-col md="6" class="allowance-col">
                                                <b-row>
                                                    <b-col md="6">
                                                      <b-form-group
                                                       label="Reference Number"
                                                       label-for="ref_number"
                                                      >
                                                        <b-form-input
                                                          v-model="singleOvertimeRegister.ref_number"
                                                          type="text"
                                                          id="ref_number"
                                                          oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                          min="3"
                                                        ></b-form-input>
                                                      </b-form-group>

                                                    </b-col>
                                                    <b-col md="6">
                                                        <!--<b-row>
                                                            <b-col md="12">
                                                              <b-input-group>
                                                                <v-select
                                                                  label="option_name"
                                                                  v-model="selectedEmployee"
                                                                  :options="empIdListUnRegistered"
                                                                  @search="searchUnregisteredEmpInfo"  md="8">
                                                                </v-select>
                                                                <template #append>
                                                                  <i class='bx bx-list-ul cursor-pointer'  @click="showUsedUnusedModalDetails"  style="color:red;"></i>
                                                                </template>
                                                              </b-input-group>
                                                                &lt;!&ndash;<label>Employee Code</label>
                                                                <v-select
                                                                    label="option_name"
                                                                    v-model="selectedEmployee"
                                                                    :options="empIdListUnRegistered"
                                                                    @search="searchUnregisteredEmpInfo"  md="8">
                                                                </v-select>&ndash;&gt;
                                                            </b-col>
                                                            &lt;!&ndash;<b-col md="1">
                                                                <label>&nbsp;</label>
                                                                <i class='bx bx-list-ul cursor-pointer'  @click="showUsedUnusedModalDetails"  style="color:red;"></i>
                                                            </b-col>&ndash;&gt;
                                                        </b-row>-->
                                                      <b-form-group
                                                        label="Employee"
                                                        label-for="employee"
                                                      >
                                                      <b-input-group>

                                                          <v-select
                                                            id="employee"
                                                            label="option_name"
                                                            v-model="selectedEmployee"
                                                            :options="empIdListUnRegistered"
                                                            @search="searchUnregisteredEmpInfo"  md="8">
                                                          </v-select>


                                                        <template #append v-if="selectedEmployee.emp_id">
                                                          <i class='bx bx-list-ul cursor-pointer'  @click="showUsedUnusedModalDetails"  style="color:red;"></i>
                                                        </template>
                                                      </b-input-group>
                                                      </b-form-group>
                                                    </b-col>
                                                    <b-col md="6">
                                                      <b-form-group
                                                        label="OT Per Hour (On day)"
                                                        label-for="ot_hour"
                                                      >
                                                        <b-form-input
                                                          v-model="singleOvertimeRegister.m_ot_hour"
                                                          @input="calculateOtDate()"
                                                          type="number"
                                                          min="1"
                                                          required
                                                          max="4"
                                                          value="4"
                                                          placeholder="Type 1 to 4"
                                                          id="ot_hour"
                                                        ></b-form-input>
                                                      </b-form-group>
                                                    </b-col>
                                                    <b-col md="6">
                                                      <b-form-group
                                                       label="OT Per Hour (Off day)"
                                                       label-for="ot_hour"
                                                      >
                                                        <b-form-input
                                                          v-model="singleOvertimeRegister.m_ot_off_hour"
                                                          @input="calculateOtDate()"
                                                          type="number"
                                                          min="1"
                                                          required
                                                          max="8"
                                                          placeholder="Type 1 to 8"
                                                          id="ot_hour"
                                                        ></b-form-input>
                                                      </b-form-group>
                                                    </b-col>
                                                    <b-col md="6">
                                                      <b-form-group
                                                        label="From Date"
                                                        label-for="fromDate"
                                                      >
                                                        <date-picker
                                                            width="100%"
                                                           :not-before="noteBeforeDate"
                                                           :not-after="noteAfterDate"
                                                           @input="calculateOtDate()"
                                                           input-class="form-control"
                                                           readonly v-model="singleOvertimeRegister.fromDate"
                                                           type="date" lang="en"
                                                           format="DD-MM-YYYY"
                                                            id="fromDate"
                                                           :value-type="dateValueType" required
                                                        ></date-picker>
                                                      </b-form-group>
                                                    </b-col>
                                                    <b-col md="6">
                                                      <b-form-group
                                                        label="End Date"
                                                        label-for="endDate"
                                                      >
                                                        <date-picker
                                                          width="100%"
                                                          :not-before="noteBeforeDate"
                                                          :not-after="noteAfterDate"
                                                          @input="calculateOtDate()"
                                                          input-class="form-control"
                                                          readonly
                                                          v-model="singleOvertimeRegister.endDate"
                                                          type="date"
                                                          lang="en"
                                                          format="DD-MM-YYYY"
                                                          id="endDate"
                                                          :value-type="dateValueType"
                                                          required ></date-picker>
                                                      </b-form-group>
                                                    </b-col>
                                                </b-row>
                                            </b-col>
                                            <b-col md="6">
                                                <b-row>
                                                    <b-col md="6">
                                                      <b-form-group
                                                        label="Department"
                                                        label-for="department"
                                                      >
                                                        <b-form-input
                                                          id="department"
                                                          v-model="singleOvertimeRegister.m_department"
                                                          readonly
                                                          type="text"
                                                        ></b-form-input>
                                                      </b-form-group>
                                                    </b-col>
                                                    <b-col md="6">
                                                        <b-form-group
                                                          label="Section"
                                                          label-for="section"
                                                        >
                                                          <b-form-input
                                                            id="section"
                                                            v-model="singleOvertimeRegister.m_section"
                                                            readonly
                                                            type="text"
                                                          ></b-form-input>
                                                        </b-form-group>
                                                    </b-col>
                                                    <b-col md="6">
                                                      <b-form-group
                                                        label="Designation"
                                                        label-for="designation"
                                                      >
                                                        <b-form-input
                                                          id="designation"
                                                          v-model="singleOvertimeRegister.m_designation"
                                                          readonly
                                                          type="text"
                                                        ></b-form-input>
                                                      </b-form-group>
                                                    </b-col>
                                                    <b-col md="6">
                                                      <b-form-group
                                                        label="Regular OT Hours"
                                                        label-for="regular"
                                                      >
                                                        <b-form-input
                                                          id="regular"
                                                          v-model="singleOvertimeRegister.regular"
                                                          readonly
                                                          type="text"
                                                        ></b-form-input>
                                                      </b-form-group>
                                                    </b-col>
                                                    <b-col md="6">
                                                      <b-form-group
                                                        label="Off day OT Hours"
                                                        label-for="offday"
                                                      >
                                                        <b-form-input
                                                          id="offday"
                                                          v-model="singleOvertimeRegister.offday"
                                                          readonly
                                                          type="text"
                                                        ></b-form-input>
                                                      </b-form-group>
                                                    </b-col>
                                                    <b-col md="6">
                                                      <b-form-group
                                                        label="Total OT Hours"
                                                        label-for="total"
                                                      >
                                                        <b-form-input
                                                          id="total"
                                                          v-model="singleOvertimeRegister.total"
                                                          readonly
                                                          type="text"
                                                        ></b-form-input>
                                                      </b-form-group>
                                                    </b-col>
                                                </b-row>
                                            </b-col>
                                        </b-row>
                                      <b-row>
                                        <!--<b-col md="4" style="display:none">
                                          <label for="approval">Approval Status</label>

                                          <b-form-select v-slot:first required v-model="singleOvertimeRegister.registerApproval" :options="approvedStatusList"></b-form-select>
                                        </b-col>-->
                                        <b-col md="12">
                                          <b-form-group label="Description" label-for="remarks">
                                            <b-form-textarea
                                              v-model="singleOvertimeRegister.remarks"
                                              id="remarks"
                                              rows="2">
                                            </b-form-textarea>
                                          </b-form-group>
                                        </b-col>
                                      </b-row>
                                        <b-row >
                                                <b-col>
                                                    <b-button type="button"   @click="showSearchForm" class="btn btn-success shadow mr-1 mb-1">SEARCH DATA</b-button> &nbsp;
                                                </b-col>
                                                <b-col class="d-flex justify-content-end ">
                                                    <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">{{submitBtn}}</b-button> &nbsp;
                                                    <b-button type="reset" class="btn btn-outline-dark  mb-1">{{resetBtn}}</b-button>
                                                </b-col>
                                        </b-row>

                                    </b-form>
                                    <!-- </b-modal> -->
                                </div>

                            </template>
                        </b-card-body>

                    </b-card>
               </b-form>

                <b-card>
                    <b-card-header header-bg-variant="dark" header-text-variant="white">Overtime Register List</b-card-header>
                    <b-card-body class="border">
                        <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :totalList="totalList" :perPage="perPage">
                            <template v-slot:action2="{ rows }">
                                <b-link ml="4" v-if="rows.item.approve_status == 1" class="text-primary" target="_blank"
                                        :to='"/overtime/"+rows.item.ot_register_id'>
                                    <i class="bx bx-edit cursor-pointer"></i>
                                </b-link>
                            </template>
                        </Datatable>
                    </b-card-body>

                </b-card>

            <b-modal id="usedUnusedModal" hide-footer v-model="usedUnusedModalShow"  title="Employee Roster Slab Details" ref="modal">
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
                                            <b-td>{{index+1}}</b-td> <b-td>{{data.date_from | formatDate}} TO {{data.date_to | formatDate}}</b-td>
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
        export default {

        components: { DatePicker,Datatable,Vue,vSelect,vcss },
        data() {
            return {
                dateValueType: this.dateFormatter(),
                fromDate: this.dateFormatter(),
                endDate: this.dateFormatter(),
                singleOvertimeRegister:{
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
                    // fields: [
                    //     {key:'rn',label:'SL', sortable:true},
                    //     {key:'from_date',label:'From Date', sortable:true},
                    //     {key:'to_date',label:'To Date', sortable:true}
                    //     ],
                    items: []
                },
                // option:{
                //     option_name:''
                // },
                overtimeRegister:{
                    registerApproval:'',
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
                displayBookingForm: false,
                displaySearchForm: true,
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
                                return 'Not';
                            }else if(value == -1){
                                return 'Rejected';
                            }
                        } , sortable:true},
                        {key:'reference_value',label:'Ref Number', sortable:true},
                        {key:'action2', label:'Change Details',sortable:true},
                         {key:'remarks',label:'remarks', sortable:true,tdClass: 'd-none',thClass: 'd-none'},
                         {key:'ot_register_id',label:'ot_register_id', sortable:true,tdClass: 'd-none',thClass: 'd-none'},
                         {key:'emp_id',label:'emp_id', sortable:true,tdClass: 'd-none',thClass: 'd-none'},
                        ],
                    items: []
                },
                approvedStatusList: [ {text: 'Need Approved',value: 0}], // {text: 'Approved', value: 1},
                approvedStatusListToSearch: [ { text: 'Select One', value: null },{text: 'Need Approved',value: 0},{text: 'Approved', value: 1}],

            };
        },
        filters: {
            formatDate: function (value) {
                if(value) {
                    return moment(value).format('DD-MM-YYYY');
                }
            }
        },
        watch: {
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
                    this.singleOvertimeRegister.m_section=  val.dpt_section;
                    this.singleOvertimeRegister.m_section_id=  val.section_id;

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

                    this.calculateOtDate();
                }

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
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Regular Activities"});
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime Register"});
                    this.allpreloadData();
                    this.singleOvertimeRegister.m_ot_hour=4;
                    this.singleOvertimeRegister.m_ot_off_hour=8;

        },
        methods: {
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
                    findSection() {
                        if(this.overtimeRegister.department_id) {
                            ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/section-by-department/${this.overtimeRegister.department_id}`).then(res => {
                                this.sectionList = res.data;
                                if (res.data.length == 1){
                                    this.overtimeRegister.section_id = res.data[0].value;
                                }
                            });
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

                                // Below code is for testing
                                //console.log(res.data.unusedOtSlab[0].from_date+' '+res.data.unusedOtSlab[0].to_date);
                                 //this.disabledDays = ['2020-01-05','2020-01-10'];
                                // this.singleOvertimeRegister.fromDate = this.notBeforeStartDate('2020-05-05');
                                // this.noteBeforeDate = '2020-05-05';
                                // this.singleOvertimeRegister.endDate = this.notAfterEndDate('2020-06-05');
                                // this.noteAfterDate = '2020-06-05';
                            })
                        }
                    },
                    showBookingForm(){
                        this.displayBookingForm = true;
                        this.displaySearchForm  = false;
                        this.titleHeading = "Overtime Register Entry";

                        if(this.singleOvertimeRegister.ref_number != undefined || null){
                            this.loadData('b',this.singleOvertimeRegister.ref_number);
                        }
                    },
                    showSearchForm(){
                        this.displayBookingForm = false;
                        this.displaySearchForm   = true;
                        this.titleHeading = "Overtime Register";
                    },
                    allpreloadData(){
                        ApiRepository.callApi(ApiRepository.GET_COMMAND, '/overtime/ot-registers').then(result => { //preload-data
                            this.departmentList = result.data.departmentList;
                            this.sectionList    = result.data.sectionList;
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
                    onSubmit() {
                        let currObj = this;
                        ApiRepository.callApi(ApiRepository.POST_COMMAND,'/overtime/ot-registers/search_result',this.overtimeRegister).then(result => {
                                if(result.data.table_info.length > 0){
                                    if(result.data.status){
                                        this.tableData.items = result.data.table_info;
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

                    },
                    onReset(evt) {
                        evt.preventDefault()
                        this.overtimeRegister ={};
                        this.searchSelectedEmployee = {};
                        this.tableData.items = [];
                        this.$nextTick(() => {
                            this.show = true;
                        });
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
                    onSubmitModal(evt) {
                            let currObj = this;
                            evt.preventDefault();

                            if(this.singleOvertimeRegister.fromDate == undefined || null){
                                currObj.$notify({ group: 'pmis', text: 'Please enter from date', type:'error' });
                                return;
                            }
                            if(this.singleOvertimeRegister.endDate == undefined || null){
                                currObj.$notify({ group: 'pmis', text: 'Please enter to date', type:'error' });
                                return;
                            }

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

                                ApiRepository.callApi(ApiRepository.POST_COMMAND,'/overtime/ot-registers',this.singleOvertimeRegister).then(result => {

                                    this.tableData.items = result.data.table_info;
                                    if(result.data.o_status_code == 1) {
                                            currObj.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' });
                                            this.singleOvertimeRegister.ref_number = result.data.p_reference_value;
                                            this.loadData('b',this.singleOvertimeRegister.ref_number);
                                            this.detailsRow(this.singleOvertimeRegister.m_emp_id,'1');

                                    }else {
                                        currObj.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' });
                                    }
                                });
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
                    onResetModal(evt) {
                        this.singleOvertimeRegister ={
                                registerApproval:0,
                                m_emp_id:'',
                                fromDate:'',
                                endDate:'',
                                offday:0,
                                regular:0,
                                total:0
                        };
                        //this.singleOvertimeRegister.m_emp_id
                        this.selectedEmployee = {};
                        //this.loadData(this.singleOvertimeRegister.ref_number);
                        this.tableData.items = [];
                        evt.preventDefault();

                    },
                    calculateOtDate(){
                        let flag = 0;
                        if(this.singleOvertimeRegister.m_emp_id == undefined || this.singleOvertimeRegister.m_emp_id == null){
                               return true;
                        }
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

                        ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-registers/calculate-ot-date',this.singleOvertimeRegister).then(result => {
                            this.singleOvertimeRegister.regular = Number(0);
                            this.singleOvertimeRegister.offday = Number(0);
                            this.singleOvertimeRegister.total = Number(0);
                            let res = result.data[0];
                            this.singleOvertimeRegister.regular = res.reg_day_total_hour;
                            this.singleOvertimeRegister.offday = res.off_day_total_hour;
                            this.singleOvertimeRegister.total = Number(res.total_hour);

                        });

                    }
                },
               // props: ['message'],
        };
</script>

<style scoped>
  #employee.v-select{
    width: 90%!important;
  }
  .vs__actions{
    width: 20%!important;
  }
</style>
