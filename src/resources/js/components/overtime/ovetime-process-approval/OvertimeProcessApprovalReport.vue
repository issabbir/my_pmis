<template>
            <b-container fluid>

                        <b-form @submit="onSubmitSearch" @reset="onResetSearch">
                                <b-card title="Overtime Bill Generation">
                                    <b-card-text>
                                        <b-row>
                                            <b-col md="3">
                                                <label  for="department">Department</label>
                                                <b-form-select  id="department" required v-model="otProcessApproval.department_id" :options="departmentList"></b-form-select>
                                            </b-col>
                                            <b-col md="3">
                                                <label  for="section">Section</label>
                                                <b-form-select  id="section" v-model="otProcessApproval.section_id" :options="sectionList"></b-form-select>
                                            </b-col>
                                            <b-col md="3">
                                                <label  for="month">Month</label>
                                                <!-- <date-picker width="100%" aria-readonly=""  input-class="form-control"  v-model="otProcessApproval.fromDate"  type="month" lang="en" format="DD-MM-YYYY" :value-type="dateValueType"></date-picker> -->
                                                <b-form-select v-model="otProcessApproval.month" required :options="month_option" ></b-form-select>

                                            </b-col>

                                            <b-col md="3" >
                                                <label  for="">&nbsp;</label>
                                                <b-form-group>
                                                        <b-button id="submit" type="submit" class="btn btn-dark shadow mr-1 mb-1">Search</b-button> &nbsp;
                                                        <b-button type="reset" class="btn btn-dark btn-outline-dark  mb-1">Reset</b-button>
                                                </b-form-group>
                                                <!-- <b-button id="submit" type="submit" class="btn btn-dark shadow mr-1 mb-1">Search</b-button> &nbsp; -->
                                                <!-- <b-button type="reset" class="btn btn-outline-dark  mb-1">Reset</b-button> -->
                                            </b-col>

                                        </b-row>
                                    </b-card-text>

                                </b-card>
                        </b-form>

                            <b-card class="ovetimeProcessApproval" title="Overtime Bill Generation Form">
                                    <b-card-text>
                                        <b-button type="submit" @click="selectAll" v-model="allSelected" class="btn btn-dark shadow mr-1 mb-1">{{btn_name}}</b-button> &nbsp;

                                        <!-- <a target="_blank" :href="'/report/render?xdo= /~weblogic/OT/OT_DETAILS.xdo&P_Month='+month+'&type=pdf&filename=ot&p_Dept='+department" class="btn shadow mr-1 mb-1 btn-primary">Pdf report</a> &nbsp;
                                        <a target="_blank" :href="'/report/render?xdo= /~weblogic/OT/OT_DETAILS.xdo&P_Month='+month+'&type=xlsx&filename=ot&p_Dept='+department" class="btn shadow mr-1 mb-1 btn-primary">Excel report</a> &nbsp;
                                         -->
                                        <Datatable v-bind:fields="tableData.fields" :totalRows="totalRows" :perPage="perPage" v-bind:items="tableData.items"  v-bind:pageColSize="4" v-bind:searchColSize="5">
                                            <template v-slot:action4="{ rows }">
                                                    <b-form-checkbox
                                                    v-model="selectCheckbox"
                                                    name="checkbox[]"
                                                    :value="rows.item.ot_register_id"
                                                    >
                                                    </b-form-checkbox>
                                            </template>
                                            <template v-slot:action2="{ rows }">
                                                {{rows.index + 1}}
                                            </template>
                                            <template v-slot:action3="{ rows }">
                                                <button class="btn btn btn-dark shadow mr-1 mb-1 btn-secondary" @click="detailsRow(rows.item)">Details</button>
                                            </template>
                                        </Datatable>

                                                                        <b-modal v-model="show"
                                                                                :title="'Employee Details'"
                                                                            ref="modal"
                                                                        >
                                                                            <form ref="form" @submit.stop.prevent="">
                                                                                <div>
                                                                                    <b-table-simple hover small   responsive>
                                                                                        <b-tbody>
                                                                                        <b-tr>
                                                                                            <b-th style="border-top: 0px solid #DFE3E7;">Employee name:</b-th>
                                                                                            <b-td>{{otProcess.emp_name}}</b-td>
                                                                                        </b-tr>
                                                                                        <b-tr>
                                                                                            <b-th>Employee Code:</b-th>
                                                                                            <b-td>{{otProcess.emp_code}}</b-td>
                                                                                        </b-tr>
                                                                                        <b-tr>
                                                                                            <b-th>Department:</b-th>
                                                                                            <b-td>{{otProcess.department_name}}</b-td>
                                                                                        </b-tr>
                                                                                        <b-tr>
                                                                                            <b-th>Designation:</b-th>
                                                                                            <b-td>{{otProcess.designation}}</b-td>
                                                                                        </b-tr>
                                                                                        <b-tr>
                                                                                            <b-th>Basic Amount:</b-th>
                                                                                            <b-td>{{otProcess.basic_amt}}</b-td>
                                                                                        </b-tr>
                                                                                        <b-tr>
                                                                                            <b-th>Approve Hour:</b-th>
                                                                                            <b-td>{{otProcess.approve_hour}}</b-td>
                                                                                        </b-tr>
                                                                                        <b-tr>
                                                                                            <b-th>Actual Hour:</b-th>
                                                                                            <b-td>{{otProcess.actual_hour}}</b-td>
                                                                                        </b-tr>
                                                                                        <b-tr>
                                                                                            <b-th>Rate:</b-th>
                                                                                            <b-td>{{otProcess.ot_rate}}</b-td>
                                                                                        </b-tr>
                                                                                        <b-tr>
                                                                                            <b-th>Amount:</b-th>
                                                                                            <b-td>{{otProcess.amount}}</b-td>
                                                                                        </b-tr>
                                                                                        <b-tr>
                                                                                            <b-th>Status:</b-th>
                                                                                            <b-td>{{otProcess.approve_status == 0 ? 'Pending' : 'Approved'}}</b-td>
                                                                                        </b-tr>
                                                                                    </b-tbody>
                                                                                    </b-table-simple>
                                                                                </div>
                            <!--                                                    <b-form-group-->
                            <!--                                                            label="Employee name"-->
                            <!--                                                            label-for="name-input">-->

                            <!--                                                    </b-form-group>-->


                                                                            </form>
                                                                </b-modal>
                                        <b-row class="mt-3">
                                            <b-col class="d-flex justify-content-end ">
                                                <b-button type="submit" @click="overtimeApprovalSubmit" class="btn btn-dark shadow mr-1 mb-1">Generate Bill</b-button> &nbsp;
                                                <!-- <b-button type="reset" class="btn btn-outline-dark  mb-1">Cancel</b-button> -->
                                            </b-col>
                                        </b-row>
                                    </b-card-text>
                                </b-card>
            </b-container>
</template>

<script>
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import  vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";
    export default {
     props:['dep','sec','date','dptName','monthName'],
     components: { DatePicker,Datatable,Vue,vSelect,vcss},
      data() {
        return {
            month_option:[],
            selectCheckbox:[],
            month: null, //this.monthName,
            department: null,//this.dptName,
            perPage:20,
            totalRows:0,
            totalList:5,
            dateValueType: this.dateFormatter(),
            otProcess: {
                emp_name: '',
                department_name: '',
                designation: '',
                basic_amt: '',
            },
            otProcessApproval: {
                department_id: null, //this.dep,
                section_id: null, //this.sec,
                // fromdate: this.fromdate,
                // todate: this.todate
                month     : null
            },
            approvalList:[],
            empIdList: [],
            emp_code: {},
            btn_name:'Check All',
            show: false,
            allSelected:true,
            selectedEmployee:{},
            overtimeapproval:{ },
            approval : [{
                approvedOtHours: [],
                registerApproval: [],
            }],
            departmentList: [],
            sectionList: [],
             approvedOThour:'',

                approvedStatusList: [
                    {value: 1, text: 'Approved'},
                    {value: 0, text: 'Reject'}
                ],
                tableData: {
                    fields: [
                        {key:'action4', label:'Check'},
                        {key: 'action2', label: 'SL'},
                        //{key: 'department_name', label: 'Department', sortable: true},
                        {key: 'emp_name', label: 'Name', sortable: true},
                        {key: 'designation', sortable: true, label: 'Designation'},
                        {key: 'emp_code', sortable: true},
                        {key: 'basic_amt', sortable: true, label: 'Basic Amount'},
                        {key: 'reg_ot_rate', label: 'Reg. Rate', sortable: true},
                        {key: 'off_ot_rate', label: 'Offday Rate', sortable: true},
                        {key: 'reg_app_hour', label: 'Reg. Approve', sortable: true},
                        {key: 'off_app_hour', label: 'Offday Approve', sortable: true},
                        {key: 'reg_actual_hour', label: 'Reg. Actual', sortable: true},
                        {key: 'off_actual_hour', label: 'Offday Actual', sortable: true},
                        {key: 'reg_amount',label: 'Reg Amount', sortable: true},
                        {key: 'off_amount',label: 'Offday Amount', sortable: true},
                        // {key: 'approve_status',label: 'Status',formatter:value => {
                        //     return  value == 0 ? 'Pending' : 'Approved'
                        //     }, sortable: true},
                        //{key: 'action3',label: 'Action'},
                        //{key: 'ot_type', sortable: true, label: 'OT Type'},
                        ],
                    items: []
                },
        };
      },

      mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Process"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime Process"});
            this.allpreloadData();
            //this.allDatalistShow();

      },

        methods:{
          allpreloadData(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/overtime/ot-processes').then(result => { //preload-data
                        this.month_option = result.data.year_month_option;
                        //console.log(result.data.year_month_option);
                    this.departmentList = result.data.departmentList;
                    this.sectionList    = result.data.sectionList;
                    //this.tableData.items = result.data.table_info;
                });
         },
         detailsRow(data) {
                this.otProcess = data;
                this.show = true;
            },
            allDatalistShow(){
                 ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-process-approval/search_result_report',this.otProcessApproval).then(res => {
                             this.tableData.items = res.data;
                            //console.log(res.data);
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

        //     searchempcods(id){
        //         let dptId=this.overtimeapproval.department;
        //         if(id) {
        //             ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-approvals/emp-info/${id}/${dptId}`, this.overtimeapproval).then(res => {
        //                 this.empIdList = res.data.empcodeList;
        //             })
        //         }
        //     },
        //    onSearchData(evt) {
        //      this.overtimeapproval.emp_code=this.selectedEmployee.emp_code;
        //         evt.preventDefault();
        //             ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-approvals/search',this.overtimeapproval).then(res => {
        //                      this.tableData.items = res.data;
        //              });
        //           },
            overtimeApprovalSubmit(evt) {
                evt.preventDefault();
                let currObj = this;
                if(this.selectCheckbox.length >0){
                        if(confirm('Do you want to approve?')){

                            let paramsObj = {};
                            paramsObj.realObj = this.otProcessApproval;
                            paramsObj.paramsCheckedObj = this.selectCheckbox;
                            ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-process-approval',paramsObj).then(res => {

                                    if(res.data.status.o_status_code == 1) {
                                        currObj.$notify({ group: 'pmis', text: res.data.status.o_status_message, type:'success' });
                                        this.selectCheckbox=[];
                                        this.tableData.items = res.data.approves.table_info;
                                        this.allSelected = true;
                                        this.btn_name = 'Check All';
                                        this.selectCheckbox = [];

                                    }else {
                                        currObj.$notify({ group: 'pmis', text: res.data.status.o_status_message ? res.data.status.o_status_message : 'All employee already approved', type:'error' });
                                    }
                            });
                        }
                }else{
                     currObj.$notify({ group: 'pmis', text:  'Please select a person', type:'error' });
                }
             },
            selectAll() {
                this.selectCheckbox = [];
                if(this.allSelected == true){
                    this.allSelected = false;
                    this.btn_name = 'Uncheck All';
                    for (let i in this.tableData.items) {
                        this.selectCheckbox.push(this.tableData.items[i].ot_register_id);
                    }
                }else{
                    this.allSelected = true;
                    this.btn_name = 'Check All';
                    this.selectCheckbox = [];
                }
            },
            onReset(evt) {
                        evt.preventDefault();
                        // Reset our form values
                        this.overtimeapproval.empID = null;
                        this.overtimeapproval.department = null;
                        this.overtimeapproval.section = null;
                        this.overtimeapproval.fromDate =  '';
                        this.overtimeapproval.endDate =  '';
                        // Trick to reset/clear native browser form validation state
                        this.show = false;
                        this.$nextTick(() => {
                        this.show = true
                        })
            },
             onSubmitSearch(evt) {
                        evt.preventDefault();
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-process-approval/search_result_report',this.otProcessApproval).then(result => {
                                    //console.log(result.data);
                                    if(result.data.table_info.length > 0){
                                        if(result.data.status){
                                            this.tableData.items = result.data.table_info;
                                        }else{
                                            this.tableData.items = [];
                                        }

                                    }else{
                                        this.tableData.items = [];
                                        this.$notify({ group: 'pmis', text: 'No data found', type:'error' });
                                    }
                                    this.totalList = result.data.table_info.length;
                        });
                },
                onResetSearch(evt) {
                        evt.preventDefault()
                        this.otProcessApproval.department_id = null;
                        this.otProcessApproval.section_id    = null;
                        this.otProcessApproval.fromDate      = null;
                        this.otProcessApproval               = {};
                        this.searchSelectedEmployee          = null;

                    this.show = false;
                }
        }
};
</script>

<style> /* .ovetimeProcessApproval td:nth-child(6), .ovetimeProcessApproval td:nth-child(6), .ovetimeProcessApproval td:nth-child(5), */
   /* .ovetimeProcessApproval td:nth-child(10), .ovetimeProcessApproval td:nth-child(11){
        text-align: right;
    }
      .ovetimeProcessApproval td:nth-child(9), td:nth-child(7){
        text-align: center;
    } */
</style>
