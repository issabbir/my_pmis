<template>
    <b-container fluid>
        <b-row>
            <b-col md="10">
                <b-card class="ovetimeProcessApproval" :title="personwiseTitle">
                    <b-card-body>
                        <Datatable v-bind:fields="tableData.fields" :sortBy="'roster_date'" v-bind:items="tableData.items" :totalList="totalList" :perPage="perPage">
                            <template v-slot:index="{ rows }">
                                {{rows.index + 1}}
                            </template>
                            <template  v-slot:roster_date="{ rows }">
                                {{rows.item.roster_date}}
                            </template>
                            <template  v-slot:action3="{ rows }">
                                <date-picker
                                    width="100%"
                                    :not-before="rows.item.only_start_date+' 00:00:01'"
                                    :not-after="rows.item.only_end_date+' 23:59:59'"
                                    input-class="form-control dateIconeEliminate" readonly
                                    v-model="rows.item.ot_start_time"
                                    type="datetime" lang="en" format="YYYY-MM-DD HH:mm" value-type="format"
                                    @change="calculate_ot_datetime_diff(rows)"
                                ></date-picker>
                            </template>
                            <template  v-slot:action4="{ rows }">
                                <date-picker
                                    width="100%"
                                    :not-before="rows.item.only_start_date+' 00:00:01'"
                                    :not-after="rows.item.only_end_date+' 23:59:59'"
                                    input-class="form-control dateIconeEliminate" readonly
                                    v-model="rows.item.ot_end_time"
                                    type="datetime" lang="en" format="YYYY-MM-DD HH:mm" value-type="format"
                                    @change="calculate_ot_datetime_diff(rows)"
                                ></date-picker>
                            </template>
                            <template  v-slot:action5="{ rows }">
                                <b-form-input type="text"  v-model="rows.item.ot_hour" readonly></b-form-input>
                            </template>
                        </Datatable>
                        <b-row class="mt-2">
                            <b-col class="d-flex justify-content-end ">
                                <b-button type="submit"  @click="overtimeRegUpdate" class="btn btn-dark shadow mr-1  mb-1">Submit</b-button>
                            </b-col>
                        </b-row>
                    </b-card-body>
                </b-card>
            </b-col>
        </b-row>
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
     props:['id'], //,'dep','sec','date','dptName','monthName'
     components: { DatePicker,Datatable,Vue,vSelect,vcss},
      data() {
        return {
            dateTimeDiffObj:{
                startDateTime:null,
                endDateTime:null,
            },
            selectCheckbox:[],
            perPage:31,
            totalRows:0,
            dateValueType: this.dateFormatter(),
            btn_name:'Check All',
            totalList:0,
            show: false,
            allSelected:true,
            selectedEmployee:{},
            overtimeapproval:{ },
            personwiseTitle:'',
            approval : [{
                approvedOtHours: [],
                registerApproval: [],
            }],
            departmentList: [{ text: 'Select One', value: null }, 'Finance & Accounting', 'Administration'],
            sectionList: [{ text: 'Select One', value: null }, 'Computer', 'Billing'],

            startTimeRange24: [{ text: 'Select One', value: null },'01','02','03','04','05','06','07','08','09',
            '10','11','12','13','14','15','16','17','18','19','20','21','22','23','24'],
             endTimeRange24: [{ text: 'Select One', value: null },'01','02','03','04','05','06','07','08','09',
            '10','11','12','13','14','15','16','17','18','19','20','21','22','23','24'],
                tableData: {
                      fields: [
                        {key: 'index', sortable: true, label: 'Sl',},
                        {key: 'roster_date',formatter: value => {
                                if(value) {
                                     return moment(value).format('DD/MM/YYYY');
                                }
                            },label:'Date', sortable:true},   //thStyle:{ display: 'none'}  // stickyColumn: true, isRowHeader: true, variant:'primary d-none'
                        {key: 'action3',label:'OT Start Time',sortable: true},
                        {key: 'action4',label:'OT End Time',sortable: true},
                        {key: 'action5',label:'OT Hour',sortable: true},
                         {key:'ot_register_dtl_id',label:'ot_register_id', sortable:true,tdClass: 'd-none',thClass: 'd-none'}, //,tdClass: 'd-none',thClass: 'd-none'
                         {key:'emp_id',label:'emp_id', sortable:true,tdClass: 'd-none',thClass: 'd-none'}, //
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
            //this.allDatalistShow();
            this.loadData();
            //console.log(this.id);
      },
        methods:{

        loadData: function () {

            ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-registers-details/${this.id}`).then(res => {

                this.tableData.items = res.data.table_info;
                this.personwiseTitle = ' ( '+res.data.table_info[0].emp_code+' ) Employee Name : '+res.data.table_info[0].emp_name;
                for(let i =0; i < res.data.table_info.length; i++){
                    this.tableData.items[i].ot_start_time = res.data.table_info[i].ot_start_time;
                    this.tableData.items[i].ot_end_time = res.data.table_info[i].ot_end_time;
                    this.tableData.items[i].ot_hour = res.data.table_info[i].ot_hour;

                    this.tableData.items[i].only_start_date = res.data.table_info[i].only_start_date;
                    this.tableData.items[i].only_end_date = res.data.table_info[i].only_end_date;
                }
                this.totalList = res.data.table_info.length;

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
            calculate_ot_datetime_diff(rows){
                        let flag = 0;

                        if(rows.item.ot_start_time== undefined || rows.item.ot_start_time == null){
                             return true;
                        }
                        if(rows.item.ot_end_time == undefined || rows.item.ot_end_time == null){
                               return true;
                        }
                            //console.log(rows.item.ot_start_time+' '+rows.item.ot_end_time+' '+rows.item.ot_hour);
                        // if(rows.item.ot_end_time > rows.item.ot_start_time){
                        //     this.$notify({ group: 'pmis', text: 'OT Start time : '+rows.item.ot_start_time+' can not be larger than End time : '+rows.item.ot_end_time, type:'error' });
                        //     return true;
                        // }

                          ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-registers/calculate-ot-datetime-diff',rows.item).then(result => {
                                 //if(result.data.date_diff_time>=0){
                                    rows.item.ot_hour = result.data.date_diff_time;
                                 //}else{
                                 //    this.$notify({ group: 'pmis', text: 'OT Start time : '+rows.item.ot_start_time+' can not be larger than End time : '+rows.item.ot_end_time, type:'error' });
                                     //rows.item.ot_hour = 0;
                                 //}
                         });
            },

            overtimeRegUpdate(evt) {
                evt.preventDefault();
                let currObj = this;
                //if(this.selectCheckbox.length >0){
                        if(confirm('Do you want to update this data ?')){
                            //console.log(this.selectCheckbox);
                            let param = this.tableData.items; //this.selectCheckbox; //
                            ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-registers-details-update',param).then(res => {
                                     //console.log(res.data);
                                     if(res.data.o_status_code == 1) {
                                         currObj.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' });
                                     }else {
                                         currObj.$notify({ group: 'pmis', text: res.data.o_status_message ? res.data.o_status_message : 'All employee already approved', type:'error' });
                                     }
                            });
                        }
                // }else{
                //      currObj.$notify({ group: 'pmis', text:  'Please select a person', type:'error' });
                // }
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
                    }
        }
};
</script>

<style>
.table-responsive {
    overflow: inherit;
}
.mx-input-append, .mx-clear-wrapper , .mx-input-icon .mx-clear-icon{
    display: none;
}
</style>
