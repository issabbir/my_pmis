<template>
    <div class="content-wrapper">
        <div class="content-body">
                <b-card>
                    <b-card-header header-bg-variant="dark" header-text-variant="white">Roster Months Slab</b-card-header>

                    <b-card-body class="border">
                        <b-form @submit.prevent="onSubmit($event)" name="search" data-vv-scope="search">
                            <b-row>
                                <b-col md="3">
                                    <b-form-group
                                        label="Division"
                                        label-for="division">
                                        <b-form-select  id="division" v-model="otMonthsDetails.division_id" :options="divisionList"></b-form-select>
                                    </b-form-group>
                                </b-col>
                                 <b-col md="3">
                                    <b-form-group
                                        label="Department"
                                        label-for="department"
                                        >
                                        <b-form-select  id="department" required v-model="otMonthsDetails.department_id" :options="departmentList"></b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="Section"
                                        label-for="section"
                                        >
                                        <b-form-select  id="section" v-model="otMonthsDetails.section_id" :options="sectionList"></b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col md="3">
                                    <b-form-group
                                        label="OT Roster Month"
                                        label-for="ot_rst_month">
                                        <b-form-select  id="ot_rst_month" required v-model="otMonthsDetails.ot_month_id" :options="otRosterMonthsList"></b-form-select>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col class="d-flex justify-content-end">
                                    <b-button lg="6" size="md" class="shadow mr-1 mb-1" variant="success" type="submit">
                                        <i class="bx bx-search cursor-pointer"></i>Search
                                    </b-button>
                                    <b-button lg="6" size="md" class="btn-light shadow mb-1" variant="dark" type="reset">
                                        Reset
                                    </b-button>
                                </b-col>
                            </b-row>
                        </b-form>
                    </b-card-body>
                </b-card>

                                                            <!-- @click="$bvModal.show('modal-xl')" @click="onShowModal($event,'modal-xl')"  -->
                <b-card>
                    <template>
                        <b-modal id="modal-xl-otslab" size="xl"  v-model="modalShow" hide-footer title="Roster Months Slab Entry" v-bind:no-close-on-backdrop="true">
                            <!-- <b-form @submit="onSubmitModal" @reset="onResetModal"> -->
                                <b-form @submit.prevent="addRow($event)" @reset.prevent="onReset" name="creationForm" data-vv-scope="creationForm" >
                                <b-card-text>
                                    <b-row>
                                            <b-col md="4">
                                                <label  for="division">Division</label>
                                                <b-form-select  id="division" v-model="otMonthsDetails.division_id" :options="divisionList"></b-form-select>
                                            </b-col>
                                            <b-col md="4">
                                                <label  for="department">Department</label>
                                                <b-form-select  id="department" required v-model="otMonthsDetails.department_id" @input="onMonthCalenderSelectOnRoster()"  :options="departmentList"></b-form-select>
                                            </b-col>
                                            <b-col md="4">
                                                <label  for="section">Section</label>
                                                <b-form-select  id="section" v-model="otMonthsDetails.section_id" :options="sectionList"></b-form-select>
                                            </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col md="4">
                                            <label  for="ot_rst_month">OT Roster Month</label>
                                            <b-form-select  id="ot_rst_month" required v-model="otMonthsDetails.ot_month_id" @input="onMonthCalenderSelectOnRoster()" :options="otRosterMonthsList"></b-form-select>
                                        </b-col>
                                        <b-col md="4">
                                            <label  for="fromDate">From Date</label>
                                            <date-picker width="100%" required input-class="form-control" onkeydown="return false" readonly v-model="otMonthsDetails.fromDate"  type="date" lang="en" format="DD-MM-YYYY" :value-type="dateValueType"></date-picker>
                                        </b-col>

                                        <b-col md="4">
                                            <label  for="endDate">To Date</label>
                                            <date-picker width="100%" required input-class="form-control" onkeydown="return false" readonly v-model="otMonthsDetails.endDate"  type="date" lang="en" format="DD-MM-YYYY" :value-type="dateValueType"></date-picker>
                                        </b-col>
                                    </b-row>
                                      <b-row>
                                          <b-col class="d-flex justify-content-end mt-1">
                                              <b-button id="add"  type="submit" class="btn btn-dark shadow mr-1 mb-1">Add</b-button> &nbsp;
                                              <b-button lg="6" size="md" class="btn-dark shadow mr-1 mb-1 btn-secondary" type="reset"> Reset</b-button>
                                          </b-col>
                                        </b-row>
                                </b-card-text>
                            </b-form>
                        </b-modal>
                    </template>
                    <b-card-header header-bg-variant="dark" header-text-variant="white">Roster Months Slab List</b-card-header>
                    <b-card-body class="border">
                            <!-- Zero configuration table -->
                            <section id="basic-datatable">

                                <b-button type="submit" @click="onShowModal($event,'modal-xl-otslab')" class="btn btn-success shadow mr-1 mb-1">Add new slab</b-button> &nbsp;

                                <Datatable v-bind:fields="tableData.fields" v-bind:items="tableData.items" :totalList="totalList" :perPage="perPage" >

                                    <template v-slot:action2="{ rows }">
                                        {{rows.index + 1}}
                                    </template>

                                    <template v-slot:action5="{ rows }">
                                        <b-link class="text-danger" @click="deleteRow(rows.item.ot_month_detail_id)">
                                            <i class="bx bx-trash cursor-pointer"></i>
                                        </b-link>
                                    </template>

                                </Datatable>


                            </section>
                            <!--/ Zero configuration table -->
                    </b-card-body>
                </b-card>
        </div>
    </div>
</template>

<script>
         import DatePicker from 'vue2-datepicker';
        import Vue from 'vue';
        import vSelect from 'vue-select';
        import vcss from 'vue-select/dist/vue-select.css';
        //import Datatable from '../../../layouts/common/datatable';
        import Datatable from '../../../layouts/common/datatable_store';
        import ApiRepository from "../../../Repository/ApiRepository";
        import moment from 'moment';

        export default {

        components: { DatePicker,Datatable,Vue,vSelect,vcss },
        data() {
            return {
                dateValueType: this.dateFormatter(),
                otMonthsDetails:{
                    fromDate : '',
                    endDate : '',
                    ot_month_id:null,
                    division_id:null,
                    department_id:null,
                    section_id:null,
                    ot_month_detail_id:null
                },
                topSearchHeading:'Overtime Months Slab',
                lowerHeading:'Overtime Months Slab List',
                topModalHeading:'Overtime Months Slab Entry',
                otRosterMonthsList:[{ text: 'Select One', value: null }],
                departmentList: [{ text: 'Select One', value: null }],//[{ text: 'Select One', value: null }, 'Finance & Accounting', 'Administration'],
                sectionList: [{ text: 'Select One', value: null }],
                divisionList:[{ text: 'Select One', value: null }],
                emp_options: [],
                momentFormatMonth: {
                    stringify: (month) => {
                        return month ? moment(month).format('MMMM') : ''
                    },
                    parse: (month) => {
                        return month ? moment(month, 'MMMM').toDate() : null
                    }
                },

                show: true,
                updateIndex:-1,
                //submitBtn: 'Add New Booking',
                resetBtn: 'Reset',
                totalList:0,
                remarks:null,
                perPage:10,
                index:1,
                modalShow: false,

                tableData: {
                    fields: [
                        {key:'action2',label:'SL', sortable:true},
                        {key:'department_name',label:'Department', sortable:true},
                        {key:'effective_start_date', formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable:true},
                        {key:'effective_end_date',formatter: value => {
                                if(value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable:true},
                         {key:'action5', label:'Action'},
                         {key:'ot_month_detail_id',label:'ot_month_detail_id', sortable:true,tdClass: 'd-none',thClass: 'd-none'},

                        ],

                    items: []
                },
                registerApproval:1,
                approvedStatusList: [
                    {value: 1, text: 'Approved'},
                   {value: 0, text: 'Need Approved'}],

            };
        },
        mounted() {
                    this.$store.commit("setBreadcrumbEmpty");
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime"});
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Regular Activities"});
                    this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime Months Details"});
                    this.allpreloadData();
        },
        methods: {
                    allpreloadData(){
                        ApiRepository.callApi(ApiRepository.GET_COMMAND, '/overtime/ot-months-detail').then(result => { //preload-data
                            this.otRosterMonthsList = result.data.otRosterMonthsList;
                            this.departmentList = result.data.departmentList;
                            this.divisionList    = result.data.divisionList;
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
                    onSubmit(evt) {
                        evt.preventDefault();
                        this.loadTableData(this,1);

                    },
                    loadTableData(obj,no_data_found_flag=0){
                        let currObj = obj;
                         ApiRepository.callApi(ApiRepository.POST_COMMAND,'/overtime/ot-months-detail/search_result',this.otMonthsDetails).then(result => {
                                this.tableData.items = []
                                if(result.data.status){
                                    if(result.data.table_info.length > 0){
                                        this.tableData.items = result.data.table_info;
                                    }else{
                                        this.tableData.items = [];
                                        if(no_data_found_flag==1){
                                            currObj.$notify({ group: 'pmis', text: 'No data found', type:'error' });
                                        }
                                    }

                                }else{
                                    this.tableData.items = [];
                                    currObj.$notify({ group: 'pmis', text: result.data.message, type:'error' });
                                }
                                this.totalList = result.data.table_info.length;
                        });
                    },
                    onMonthCalenderSelectOnRoster(){
                        this.otMonthsDetails.fromDate = '';
                        this.otMonthsDetails.endDate  = '';
                        //alert(this.otMonthsDetails.ot_month_id);
                        //this.tableData.items['effective_end_date']
                        this.loadTableData(this.otMonthsDetails,0);
                        if(this.otMonthsDetails.ot_month_id){
                            let otMonthsDetailsArr =  this.otMonthsDetails.ot_month_id.split('#');
                            let startDate = otMonthsDetailsArr[3].split(' ');
                            let endDate   =otMonthsDetailsArr[4].split(' ');
                            this.otMonthsDetails.fromDate = moment().startOf('month').format(startDate[0]);
                            this.otMonthsDetails.endDate =  moment().startOf('month').format(endDate[0]);
                        }else{
                            //this.$notify({ group: 'pmis', text: 'Please select OT Roster Month', type:'error' });
                            this.otMonthsDetails.fromDate = moment().startOf('month').format();
                            this.otMonthsDetails.endDate =  moment().startOf('month').format();
                        }

                    },
                    onShowModal(evt,modal){
                             this.onReset(evt);
                             this.$bvModal.show(modal);
                    },
                    onReset(evt) {
                        evt.preventDefault()
                        this.otMonthsDetails ={
                             fromDate : '',
                             endDate : ''
                        };
                        this.$nextTick(() => {
                            this.show = true;
                        });
                    },
                     addRow(evt) {

                          let currObj = this;
                          evt.preventDefault();
                            if(this.otMonthsDetails.fromDate == undefined || null){
                              currObj.$notify({ group: 'pmis', text: 'Please enter from date', type:'error' });
                              return;
                            }
                            if(this.otMonthsDetails.endDate == undefined || null){
                                currObj.$notify({ group: 'pmis', text: 'Please enter to date', type:'error' });
                                return;
                            }
                            ApiRepository.callApi(ApiRepository.POST_COMMAND,`/overtime/ot-months-detail`,this.otMonthsDetails).then(result => {
                                if(result.data.params.o_status_code == 1) {
                                    currObj.$notify({ group: 'pmis', text: result.data.params.o_status_message, type:'success' });
                                    this.loadTableData(this);
                                }else {
                                    currObj.$notify({ group: 'pmis', text: result.data.params.o_status_message, type:'error' });
                                }
                            });
                        },
                        deleteRow(ot_dtl_id){

                                let currObj = this;
                                ApiRepository.callApi(ApiRepository.GET_COMMAND,`/overtime/ot-months-detail/remove/${ot_dtl_id}`,this.otMonthsDetails).then(result => {
                                    //console.log(result.data);
                                    if(result.data.status == 1) {
                                        currObj.$notify({ group: 'pmis', text: result.data.message, type:'success' });
                                        this.loadTableData(this);
                                    }else {
                                        currObj.$notify({ group: 'pmis', text: result.data.message, type:'error' });
                                    }
                                });
                        }
                },
               // props: ['message'],
        };
</script>
<style>
    #modal-xl-otslab .modal-dialog {
        position: absolute;
        top: 40%;
        left: 50%;
        transform: translate(-50%, -50%) !important;
    }
</style>

