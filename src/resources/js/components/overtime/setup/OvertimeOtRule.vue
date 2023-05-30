<template>
    <div class="content-wrapper">
        <div class="content-body  overtimeOtRule">
            <b-card class="card">
                <b-card-header header-bg-variant="dark" header-text-variant="white">OT Rule Add</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit('rule')" @reset="onReset" data-vv-scope="search">
                        <!--<fieldset class="border p-2">-->
                        <!--<legend class="w-auto">Holiday Setup</legend>-->
                        <b-row >
                            <b-col>
                                <b-row class="row">
<!--                                    onkeypress="return /[a-z]/i.test(event.key)"-->
                                    <b-col md="3">
                                        <label>Rule Name<span class="text-danger">*</span></label>
                                        <b-form-input v-validate="'required'" maxlength="30" name="RuleName" id="RuleName" v-model="otRule.ruleName"   type="text" placeholder="Rule Name"></b-form-input>
                                        <span :style="errorMessage">{{ errors.first('otRule.ruleName') }}</span>
                                    </b-col>
                                    <b-col md="3">
                                        <label>Rule Name Bangla<span class="text-danger">*</span></label>
                                        <b-form-input v-validate="'required'" name="ruleNameBn" onkeypress="return /\p{Bengali}+/u.test(event.key)" pattern="/^[\p{Bengali}]{0,100}$/u" maxlength="30" v-model="otRule.ruleNameBn"   type="text" placeholder="Rule Name Bangla"></b-form-input>
                                        <span :style="errorMessage">{{ errors.first('otRule.ruleNameBn') }}</span>
                                    </b-col>
                                    <b-col md="3">
                                        <label>REGULER DAY RATE<span class="text-danger">*</span></label>
                                        <b-form-input   class="text-right" v-validate="'required'" name="regDateRate"    v-model="otRule.regDateRate"   type="number" step="0.001"></b-form-input>
                                        <span :style="errorMessage">{{ errors.first('otRule.regDateRate') }}</span>
                                    </b-col>
                                    <b-col md="3">
                                        <label>Off Day Rate<span class="text-danger">*</span></label>
                                        <b-form-input  class="text-right" v-validate="'required'" name="offDayRate"    v-model="otRule.offDayRate"   type="number" step="0.001"></b-form-input>
                                        <span :style="errorMessage">{{ errors.first('otRule.offDayRate') }}</span>
                                    </b-col>
                                    <b-col class="mt-2 text-right">
                                        <b-button lg="12" size="md" variant="dark" type="submit" >{{submitBtn}}</b-button>&nbsp;
                                        <b-button lg="12" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                    </b-col>
                                </b-row>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>

              <!-- Zero configuration table -->
            <section id="basic-datatable2">
                <b-card class="card">
                    <b-card-header header-bg-variant="dark" header-text-variant="white">OT Rule List</b-card-header>
                    <b-card-body class="border">

                        <Datatable  v-bind:fields="dataTable.fields" v-bind:items="dataTable.items" :totalList="totalRosterList" :filterIgnoredFields="ignoredFields" :perPage="perPage" >
                                <template v-slot:action2="{ rows }">
                                        {{rows.index + 1}}
                                </template>
                            <template v-slot:action3="{ rows }">
                                <b-link ml="4" class="text-primary"
                                        @click="editRow(rows.item.ot_category_id)">
                                    <i class="bx bx-edit cursor-pointer"></i>
                                </b-link>
<!--                                <b-link ml="4" class="text-primary"-->
<!--                                        @click="deleteRow(rows.item.ot_category_id)">-->
<!--                                    <i class="bx bx-trash cursor-pointer text-danger"></i>-->
<!--                                </b-link>-->
                            </template>
                        </Datatable>
                    </b-card-body>
                </b-card>
            </section>
        </div>
    </div>
</template>


<script>
    import DatePicker from "vue2-datepicker";
    import moment from 'moment';
    import Datatable from '../../../layouts/common/datatable_store';
    import ApiRepository from "../../../Repository/ApiRepository";
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
                submitBtn: 'Save',
                isFromDisable: false,
                isEdit: false,
                showClass: 'd-none',
                errorMessage: {color: 'red'},
                dateValueType: this.dateFormatter(),
                groupSearch:{
                    department_id:null,
                    month:null,
                    group:null,
                },
                employeeSearch: {
                    department_id:null
                },
                otRule: {
                    ruleName:null,
                    ruleNameBn:null,
                    regDateRate:null,
                    offDayRate:null,
                    ot_category_id:null,
                },
                selectCheckbox:[],
                selectCheckboxApprove:[],
                allSelected: false,
                allSelectedApprove: false,
                indeterminate: false,
                indeterminateApprove: false,
                checkBoxDisabled:true,
                departmentList: [],
                yearList: [],
                monthList: [],
                groupList: [],
                monthSlubList: [],
                shiftList: [],
                ruleList: [],
                show: false,
                updateIndex:-1,
                perPage:5,
                totalList:0,
                totalRosterList:0,
                ignoredFields: ['emp_id'],
                fields: [
                    {key:'head1', label: '', sortable:true,variant:""},
                    {key:'emp_code', label: 'Employee Code', sortable:true},
                    {key:'emp_name', label: 'Employee Name', sortable:true},
                    {key:'designation', label: 'Designation', sortable:true},
                    {key:'department_name', label: 'Department', sortable:true},
                    {key:'action3', label: 'Rule', formatter: 'off_day'},
                    {key:'action5', label: 'Action', thClass: 'd-none'},
                 ],
                items:[],
                dataTable: {
                         fields: [
                            {key:'action2', label: 'SL', sortable:true},
                            {key:'ot_category', label: 'Rule Name', sortable:true},
                            {key:'ot_category_bng', label: 'Rule Name Bangla', sortable:true},
                            {key:'reg_day_rate', label: 'Reg Day Rate', sortable:true},
                            {key:'off_day_rate', label: 'Off Day Rate', sortable:true},
                            {key:'action3', label: 'Action', sortable:true},
                        ],
                        items:[],
                    },
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
                if(this.allSelected == false){
                    this.allSelected = false;
                    this.indeterminate = false;
                    for (let i in this.items) {
                        this.selectCheckbox.push(this.items[i].emp_id);
                    }
                }else{
                    this.allSelected = true;
                    this.indeterminate = true;
                    this.selectCheckbox = [];
                }
              },
            toggleAllApprove(checked) {
                for (let i in this.items) {
                    this.items[i].approve_yn =  checked ? 'Y' : 'N';
                }
                //this.selectCheckboxApprove = checked ? this.items.slice() : []

                if(this.allSelectedApprove == false){
                    this.allSelectedApprove = false;
                    this.indeterminateApprove = false;
                    for (let i in this.items) {
                        this.selectCheckboxApprove.push(this.items[i].approve_yn);
                    }
                }else{
                    this.allSelectedApprove = true;
                    this.indeterminateApprove = true;
                    this.selectCheckboxApprove = [];
                }
              },
            loadData: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/overtime/ot-rule-list").then(res => {
                    this.departmentList = res.data.departmentList;
                    this.monthList = res.data.months;
                    this.shiftList = res.data.shifts;
                    this.dataTable.items = res.data.rules;
                    this.totalRosterList = res.data.rules.length;
                });
            },
             searchGroup(search){
                  this.isFromDisable = false;
                  let currObj = this;
                         ApiRepository.callApi(ApiRepository.POST_COMMAND, "/overtime/employee-ot-rule/search-ot-rule", this.groupSearch).then(res => {
                             this.dataTable.items = res.data.rosterGroup;
                             this.totalRosterList = res.data.rosterGroup.length;
                         });
              },
            onSearch(search){
                  this.isFromDisable = false;
                let currObj = this;
                 this.$validator.validateAll(search).then(() => {
                     if (!this.errors.any()) {
                         ApiRepository.callApi(ApiRepository.POST_COMMAND, "/overtime/employee-ot-rule/search-ot-emp", this.employeeSearch).then(res => {
                             this.items = res.data.employees.filter(item => {
                                 return !item.ot_month_id.includes(this.rosterGroup.month)
                             });
                             this.totalList = res.data.employees.length;
                             if (this.totalList > 0) {
                                 this.show = true;
                                 this.submitBtn = 'Save';
                             }else{
                                 currObj.$notify({group: 'pmis', text: 'No data Found', type: 'danger'});
                             }
                         });
                     } else {
                        console.log('here', currObj.errors);
                    }
                     this.onReset();
                 });
            },
            onSubmit(rule) {
                 //let empId = this.selectCheckbox;
                //console.log(empId);
                let data={};

                // data.group_name = this.rosterGroup.groupName;
                // data.month = this.rosterGroup.month;
                // data.month_slabs = this.rosterGroup.month_slabs;
                // data.shift = this.rosterGroup.shift;
                let currObj = this;
                this.$validator.validateAll(rule).then(() => {
                      if (!currObj.errors.any()) {
                             //console.log(data);
                             ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-rule-add', this.otRule).then(res => {
                                  if (res.data.o_status_code == 1) {
                                     currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                      this.loadData();
                                      this.show = false;
                                      this.onReset();
                                    // this.viewRow(data);
                                 } else {
                                     currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                                 }
                             });
                     } else {
                        console.log('here', currObj.errors);
                    }
                });
            },
            onReset(evt) {
                    this.submitBtn = 'Save';
                    this.otRule = {
                            ruleName:null,
                            ruleNameBn:null,
                            regDateRate:null,
                            offDayRate:null,
                            ot_category_id:null,
                    }
            },
            resetSearchGroup(evt){
                this.groupSearch = {
                    department_id:null,
                    month:null,
                    group:null,
                }
            },
            editRow(ot_category_id) {
                this.isEdit = true;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-rule-details/${ot_category_id}`).then(result => {
                    this.submitBtn = 'Update';
                    this.otRule.ruleName = result.data.ot_category;
                    this.otRule.ruleNameBn = result.data.ot_category_bng;
                    this.otRule.regDateRate = result.data.reg_day_rate;
                    this.otRule.offDayRate = result.data.off_day_rate;
                    this.otRule.ot_category_id = result.data.ot_category_id;
                });
                this.show = true;

            },
            viewRow(data) {
                //this.updateIndex = id;
                 let param = data;
                //this.updateIndex = id;
                this.isFromDisable = true;
                this.isEdit = false;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-roster-group/details`,param).then(result => {
                    this.submitBtn = 'Update';
                    this.rosterGroup.groupName = result.data.group_name;
                    this.rosterGroup.month = result.data.month;
                    this.rosterGroup.month_slabs = result.data.month_slabs;
                    this.rosterGroup.shift = result.data.shift;
                    this.items = result.data.rosterDetails;
                    this.totalList = result.data.rosterDetails.length;
                    if(this.items.length > 0){
                        this.show = true;
                    }

                });
            },
            addMoreEmployee(){
                let param = {};
                this.isEdit = false;
                let empId = this.selectCheckbox;
                param.department_id = this.departmentId
                //console.log(param);
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/overtime/ot-roster-group/search", param).then(res => {
                             let that = this;
                             let  $data = res.data.employees.filter(function(item,index) {
                                  return  !empId.includes(item.emp_id);
                               });
                              $data.forEach(function (value,i) {
                                  if(value.off_day){
                                         that.isFromDisable = true;
                                  }
                                  that.items.push(value);
                              });
                             this.perPage = 10;
                             this.totalList = res.data.employees.length;
                             if (this.totalList > 0) {
                                 this.show = true;
                                 this.submitBtn = 'Save';
                             }
                 });
            },
            deleteRow(ot_category_id){
                 let currObj = this;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/overtime/ot-rule-delete/"+ot_category_id).then(res => {
                        if (res.data.status) {
                            currObj.$notify({group: 'pmis', text: res.data.message, type: 'success'});
                            this.loadData();
                            // this.items = currObj.items;
                            // this.totalList = currObj.items.length;
                         } else {
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                        }
                });
            },
            //  findMonthSlabs() {
            //     if(this.rosterGroup.month) {
            //         ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-roster-details/find-groups-and-monthslabs/${this.rosterGroup.month}`).then(res => {
            //              if(this.monthSlubList.length <= 1) {
            //                 this.monthSlubList = res.data.month_slabs;
            //             }
            //         });
            //     }
            // },
             findMonthGroup() {
                if(this.groupSearch.month) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-roster-group/find-group-by-months/${this.groupSearch.month}`).then(res => {
                            this.groupList = res.data.groups;
                    });
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
                       // this.rosterGroup.month = this.rosterGroup.month;
                        this.totalList = res.data.employees.length;
                        if (this.totalList > 0) {
                            this.show = true;
                            this.submitBtn = 'Save';
                        }else{
                            currObj.$notify({group: 'pmis', text: 'No data Found', type: 'danger'});
                        }
                    });
                    //this.onReset();
                }
                else {
                    this.checkBoxDisabled = true;
                }


            }

        }
    }
    // $("#RuleName").on("keypress", function(event) {
    //     var englishAlphabetAndWhiteSpace = /[A-Za-z ]/g;
    //     var key = String.fromCharCode(event.which);
    //     if (englishAlphabetAndWhiteSpace.test(key)) {
    //         return true;
    //     }
    //     alert ("this is not in English");//put any message here!!!
    // });
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
    .overtimeOtRule th:nth-child(4), .overtimeOtRule td:nth-child(4){
        text-align: right;
    }
    .overtimeOtRule th:nth-child(5), .overtimeOtRule td:nth-child(5){
        text-align: right;
    }
</style>

