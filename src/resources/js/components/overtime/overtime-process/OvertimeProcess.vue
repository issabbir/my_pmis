<template>
    <b-container fluid>
        <b-form @submit.prevent="onSubmit" @reset.prevent="onReset">
            <b-card title="Overtime Process">
                <b-card-body class="border">
                    <b-row>
                        <b-col md="3">
                            <b-form-group
                                label="Month"
                                label-for="month"
                            >
                                <b-form-select v-model="overtimeProcess.fromDate" id="month" required :options="month_option" ></b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Department"
                                label-for="department"
                            >
                                <b-form-select @change="findSection"  id="department" required v-model="overtimeProcess.department_id" :options="departmentList"></b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group class="" id="section_id" label="Section" label-for="section_id">
                                <b-form-select class="form-control" id="section_id" name="section_id" v-model="overtimeProcess.section_id">
                                    <option value="">Select Section</option>
                                    <option :value="section.value" v-for="section in sections">{{ section.text }}</option>
                                </b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <b-form-group
                                label="Bill Code"
                                label-for="bill_code"
                            >
                                <b-form-input
                                  v-validate="'required'"
                                  name="bill_code"
                                  id="bill_code"
                                  oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                  v-model="overtimeProcess.bill_code"
                                  type="text"
                                  placeholder="Bill Code"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="12" class="d-flex justify-content-end">
                            <b-button type="reset" class="btn btn-dark btn-outline-dark  mb-1">Reset</b-button> &nbsp;
                            <b-button id="submit" type="submit" class="btn btn-dark shadow mb-1">Search</b-button>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
            <b-card title="Overtime Process List">
                <b-card-body class="border">
                    <b-button type="submit" v-if="tableData.items.length>0" @click="processData($event,overtimeProcess)" class="btn btn-success shadow mr-1 mb-1">Process all Data</b-button> &nbsp;
                    <Datatable responsive="true" :fields="tableData.fields" :items="tableData.items" :totalList="totalList" :perPage="perPage">
                        <template v-slot:action2="{ rows }">
                            {{rows.index + 1}}
                        </template>
                        <!-- <template v-slot:actions="{ rows }">
                             <b-link ml="4" class="text-primary"
                                 @click="editRow(rows.item.designation_id)">
                                 <i class="bx bx-edit cursor-pointer"></i>
                             </b-link>
                         </template>-->
                    </Datatable>
                </b-card-body>
            </b-card>
        </b-form>
    </b-container>
</template>

<script>
    import DatePicker from 'vue2-datepicker';
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import Datatable from '../../../layouts/common/datatable_store';
    import ApiRepository from "../../../Repository/ApiRepository";
    export default {
        props: ['message'],
        components: { DatePicker,Datatable,Vue,vSelect, vcss },
        data() {
            return {
                dateValueType: this.dateFormatter(),
                overtimeProcess:{},
                empIdList:[],
                sections:[],
                selectedEmployee:"",
                searchSelectedEmployee:"",
                m_emp_id:null,
                emp_id:null,
                m_emp_type_id:null,
                department : null,
                billCodes: [],
                m_department : null,
                section : null,
                designation:null,
                section_id : null,
                designation_id:null,
                m_section : null,
                m_designation:null,
                m_ot_hour:1,
                fromDate : null, //new Date(),
                endDate : null, //new Date(),
                departmentList: [],//[{ text: 'Select One', value: null }, 'Finance & Accounting', 'Administration'],
                sectionList: [{ text: 'Select One', value: null }, 'Computer', 'Billing'],
                emp_options: [],
                show: true,
                updateIndex:-1,
                submitBtn: 'Save',
                totalList:0,
                reamarks:null,
                perPage:10,
                index:1,
                modalShow: false,
                tableData: {
                    fields: [
                        {key:'action2',label:'SL', sortable:true, class:'text-center'},
                        {key:'emp_code',label:'EMP Code', sortable:true, class:'text-center'},
                        {key:'emp_name',label:'Name', sortable:true},
                        {key:'designation', label:'Designation',sortable:true},
                        {key:'reg_day_approve_hour', label:'Approved (Regular)', sortable:true, class:'text-right'},
                        {key:'reg_day_actual_hour',  label:'Actual (Regular)', sortable: true, class:'text-right'},
                        {key:'off_day_approve_hour', label:'Approved (Holiday)', sortable:true, class:'text-right'},
                        {key:'off_day_actual_hour',  label:'Actual (Holiday)', sortable: true, class:'text-right'},
                        {key:'final_total_approve_hr', label:'Approved (Total)', sortable:true, class:'text-right'},
                    ],
                    items: []
                },
                month_option:[]
            }
        },
        watch: {
            searchSelectedEmployee:function(val,oldVal) {
                this.overtimeProcess.emp_name=  val.emp_name;
                if(val.department)
                    this.overtimeProcess.department_id=  val.department.department_id;
                if(val.designation)
                    this.overtimeProcess.designation=  val.designation.designation;
                if(val.section)
                     this.overtimeProcess.section_id=  val.section.section_id;
                if(val.emp_id)
                     this.overtimeProcess.emp_id=  val.emp_id;

            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Regular Activities"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime Register"});
            this.allpreloadData();
        },
        methods: {
            allpreloadData(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/overtime/ot-processes').then(result => { //preload-data
                     this.month_option = result.data.year_month_option;
                     //console.log(result.data.year_month_option);
                    this.departmentList = result.data.departmentList;
                    this.sectionList    = result.data.sectionList;
                    //this.tableData.items = result.data.table_info;
                });

                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/payroll/salary-process').then(res => {
                    this.billCodes = res.data.billCodes;
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

            processData(evt,obj){

                let currObj = this;
                let department_id = obj.department_id;
                let section_id    = obj.section_id;
                let data          = obj.data;
                let ot_month_id = this.overtimeProcess.fromDate.ot_month_id;
                let dptName = '';
                let fromDate=this.overtimeProcess.fromDate.calculation_start_date;
                let toDate=this.overtimeProcess.fromDate.calculation_end_date;
                let monthName = this.overtimeProcess.fromDate.ot_month_id;
                $.each(this.departmentList, function(key, value) {
                    if(value.value == department_id){
                        dptName = value.text;
                    }
                });
                if(confirm('Do you want to process your data ?')){
                    ApiRepository.callApi(ApiRepository.POST_COMMAND,'/overtime/ot-processes',obj).then(result => {

                                if(result.data.o_status_code == 1) {
                                    currObj.$notify({ group: 'pmis', text: result.data.o_status_message, type:'success' });
                                    //this.$router.push('overtime-process-approval',this.obj);
                                    // named route
                                    this.$router.push({
                                        path:`overtime-process-approval/${obj.department_id}/${obj.section_id}/${fromDate}/${toDate}/${dptName}/${monthName}`,

                                    });

                                }else {
                                    currObj.$notify({ group: 'pmis', text: result.data.o_status_message, type:'error' });

                                }
                    });
                }
                evt.preventDefault();

            },
            findSection() {
                if(this.overtimeProcess.department_id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/section-by-department/${this.overtimeProcess.department_id}`).then(res => {
                        this.sections = res.data;
                        if (res.data.length == 1){
                            this.overtimeProcess.section_id = res.data[0].value;
                        }
                    });
                }
            },
            searchempcods(id){
                if(id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-processes/emp-info/${id}`, this.overtimeProcess).then(res => {
                        this.empIdList = res.data.empcodeList;
                    })
                }
            },
            onSubmit() {
                this.overtimeProcess.emp_id = this.overtimeProcess.emp_id;
                 ApiRepository.callApi(ApiRepository.POST_COMMAND,'/overtime/ot-processes/search_result',this.overtimeProcess).then(result => {
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
                    return;
                 })
            },
            onReset() {
                this.overtimeProcess.department_id = null;
                this.overtimeProcess.section_id = null;
                this.overtimeProcess.fromDate = null;
                this.overtimeProcess ={};
                this.searchSelectedEmployee = null;
                this.show = false;
                this.items=[];
            }
        }
    };
</script>

<style>
    .required:after{
        content: "*";
        color: red;
    }
</style>
