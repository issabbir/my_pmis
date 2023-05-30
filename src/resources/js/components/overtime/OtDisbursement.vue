<template>
    <div class="content-wrapper">
        <div class="content-body rosterGroup">
            <b-form @submit.prevent="onSubmit" @reset="onReset"   data-vv-scope="roster">
                <section id="basic-datatable2">
                <b-card class="card">
                    <b-card-header header-bg-variant="dark" header-text-variant="white">OT Disbursement</b-card-header>
                    <b-card-body class="border">
                        <b-card-body class="mb-0 roster-group pt-0 pb-0 border">
                            <Datatable v-bind:fields="fields" v-bind:items="items" :totalList="totalList" :perPage="perPage" :filterIgnoredFields="ignoredFields" >
                                <template v-slot:head1="{ rows }">
                                    <b-form-checkbox
                                        v-model="allSelected"
                                        :indeterminate="indeterminate"
                                        aria-describedby="items"
                                        aria-controls="items"
                                        @change="toggleAll"
                                    >
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
                            </Datatable>
                            <b-row align-h="end" class="mt-2">
                                <b-col md="2" class="mb-2 d-flex justify-content-end">
                                    <b-button  lg="6" size="md" variant="dark" type="submit" class="mr-2" >Disburse</b-button>&nbsp;
                                    <b-button lg="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                </b-col>
                            </b-row>
                        </b-card-body>
                    </b-card-body>
                </b-card>
            </section>
            </b-form>
        </div>
    </div>
</template>


<script>
    import DatePicker from "vue2-datepicker";
    import moment from 'moment';
    import Datatable from '../../layouts/common/datatable_store';
    import ApiRepository from "../../Repository/ApiRepository";
    export default {
        components: {DatePicker,Datatable},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Overtime"});
            this.$store.commit("setBreadcrumb", { link: "#", label: "Roster" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "OT Roster Group" });
            this.$store.commit("setPerPage",this.perPage);
            this.loadData();
        },
        computed: {
           /* filteredItems() {
                return this.items.filter(item => {
                    return !item.ot_month_id.includes(this.rosterGroup.month)
                })
            }*/
        },
        data() {
            return {
                unique_code_message: '',
                departmentId: 0,
                section_id: 0,
                submitBtn: 'Save',
                isFromDisable: false,
                isEdit: false,
                isEditShow: false,
                showClass: 'd-none',
                errorMessage: {color: 'red'},
                dateValueType: this.dateFormatter(),
                groupSearch:{
                    department_id:null,
                    section_id:null,
                    month:null,
                    group:null,
                },
                employeeSearch: {
                    department_id:null,
                    section_id:null
                },
                rosterGroup: {
                    year:null,
                    month:null,
                    group:null,
                    month_slabs:null,
                    shift:null,
                    off_day:null
                },
                selectCheckbox:[],
                selectCheckboxApprove:[],
                allSelected: false,
                allSelectedApprove: false,
                indeterminate: false,
                indeterminateApprove: false,
                checkBoxDisabled:true,
                departmentList: [],
                sections: [],
                groupSections: [],
                yearList: [],
                monthList: [],
                groupList: [],
                previousGroupList: [],
                monthSlubList: [],
                shiftList: [],
                show: false,
                updateIndex:-1,
                perPage:5,
                totalList:0,
                totalRosterList:0,
                ignoredFields: ['emp_id'],
                fields: [
                    {key:'head1', label: '', sortable:true,variant:""},
                    {key:'ot_year', label: 'OT Year', sortable:true},
                    {key:'ot_month', label: 'OT Month', sortable:true},
                    {key:'effective_start_date',
                        formatter: value => {
                            if (value) {
                                return moment(value).format('YYYY-MM-DD');
                            }
                        },label:'Effective Start Date', sortable:true},
                    {key:'effective_end_date',
                        formatter: value => {
                            if (value) {
                                return moment(value).format('YYYY-MM-DD');
                            }
                        },label:'Effective End Date', sortable:true},
                    {key:'bill_code', label: 'Bill Code', sortable:true},
                    {key:'disburse_yn', label: 'Disburse', sortable:true},
                    {key:'pay_amount', label: 'Pay Amount', sortable:true},
                    {key:'head2', label: '', thClass: 'd-block'},
                    {key:'action5', label: 'Action', thClass: 'd-none'},
                 ],
                items:[],
                holiday_type_options: [],
                status_options: [],

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
              selectCheckboxApprove(newVal, oldVal) {
                if (newVal.length === 0) {
                  this.indeterminateApprove = false
                  this.allSelectedApprove = false
                } else if (newVal.length === this.items.length) {
                  this.indeterminateApprove = false
                  this.allSelectedApprove = true
                } else {
                  this.indeterminateApprove = true
                  this.allSelectedApprove = false
                }
              }
            },
        filters: {
            filterData: function(item) {

            }
        },
        methods: {
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
            toggleAll(checked) {
                for (let i in this.items) {
                    this.items[i].checkbox =  checked ? '1' : '0';
                }
                if(this.allSelected == 1){
                    this.allSelected = 1;
                    this.indeterminate = false;
                    for (let i in this.items) {
                        this.selectCheckbox.push(this.items[i].emp_id);
                    }
                }else{
                    this.allSelected = 0;
                    this.indeterminate = true;
                    this.selectCheckbox = [];
                }
              },
            loadData: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/overtime/ot-disbursement").then(res => {
                    this.items = res.data.data;
                    this.totalList = res.data.data.length;
                });
            },
            onSubmit() {
                let data={};
                data.items = this.items.filter(function(item,index) {
                    return item.checkbox == "1";
                });
                console.log(data.items);
                let currObj = this;
                      if (!currObj.errors.any()) {
                         if (data.items.length > 0) {
                             ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-disbursement', data).then(res => {
                                  if (res.data.o_status_code == 1) {
                                     currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                      this.loadData();
                                      this.show = false;
                                 } else {
                                     currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                                 }
                             });
                          } else {
                             currObj.$notify({group: 'pmis', text: 'Please select a Employee', type: 'error'});
                          }
                     } else {
                        console.log('here', currObj.errors);
                    }
            },
            onReset(evt) {
                 this.items = {};
                 this.rosterGroup.groupName = '';
                 this.rosterGroup.month = '';
                 this.rosterGroup.month_slabs = '';
                 this.rosterGroup.shift = '';
                 this.rosterGroup.group = '';
                 this.show = false;
                 this.isFromDisable = false;
                 this.isEdit = false;
                 this.selectCheckbox = [];
                 this.previousGroupList = [];
                 this.employeeSearch.month = '';
            },
            resetSearchGroup(evt){
                this.groupSearch = {
                    department_id:null,
                    month:null,
                    group:null,
                }
            },
            fnCheckboxDisabled:function() {
                if (this.rosterGroup.month) {
                    this.checkBoxDisabled = false;
                    this.isFromDisable = false;
                    let currObj = this;
                    this.employeeSearch.month = this.rosterGroup.month;
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, "/overtime/ot-roster-group/search", this.employeeSearch).then(res => {
                        this.items = res.data.employees;
                        this.previousGroupList = res.data.previousGroups;
                        for (let i = 0; this.items.length > i; i++){
                            this.items[i].off_day = 'FRI';
                        }
                       // this.rosterGroup.month = this.rosterGroup.month;
                        this.totalList = res.data.employees.length;
                        if (this.totalList > 0) {
                            this.show = true;
                            this.submitBtn = 'Save';
                        }else{
                            currObj.$notify({group: 'pmis', text: 'No data Found', type: 'danger'});
                        }
                        if (this.previousGroupList.length > 0 && this.totalList > 0){
                            this.isEditShow = true;
                        }else{
                            this.isEditShow = false;
                        }
                    });
                    //this.onReset();
                }
                else {
                    this.checkBoxDisabled = true;
                }
               // this.employeeSearch.month = '';

            }

        }
    }
</script>

<style>
    .disabled, .disabled a, :disabled, :disabled a {
        background-color: #f2f4f4 !important;
    }
    .roster-group{
        position: relative;
    }
    .roster-group .all-select {
            top: 66px;
            position: absolute;
            left: 30px;
            z-index: 111;
    }

    .input-group-append .data-table-filter.disabled, .data-table-filter.disabled a,.data-table-filter :disabled,.data-table-filter :disabled a {
        background-color: #394c62 !important;
    }
.withotmonth{
    font-size: 12px;
    text-transform: lowercase;
    font-style: italic;
}
</style>

