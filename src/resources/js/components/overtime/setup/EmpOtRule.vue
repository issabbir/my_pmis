<template>
    <div class="content-wrapper">
        <div class="content-body empotRule">
            <b-card class="card">
                <b-card-header header-bg-variant="dark" header-text-variant="white">Employee OT Rule Define</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSearch('search')" @reset="onReset" data-vv-scope="search">
                        <!--<fieldset class="border p-2">-->
                        <!--<legend class="w-auto">Holiday Setup</legend>-->
                        <b-row >
                            <b-col>
                                <b-row class="row">

                                    <b-col md="4">
                                            <label>Department</label>
                                        <b-form-select  v-validate="'required'"  name="department" v-model="employeeSearch.department_id" :options="departmentList">
                                            <template v-slot:first>
                                                <option :value="null">-- Please select a department --</option>
                                                </template>
                                        </b-form-select>
                                        <span :style="errorMessage">{{ errors.first('search.department') }}</span>
                                    </b-col>
                                    <b-col class="mt-2">
                                        <b-button lg="6" size="md" variant="dark" type="submit" >Search Employee</b-button>&nbsp;
                                        <b-button lg="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                    </b-col>
                                </b-row>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>

            <b-form @submit.prevent="onSubmit('roster')" @reset="onReset"  v-if="show" data-vv-scope="roster">
                <!-- Zero configuration table -->
                <section id="basic-datatable">
                    <b-card class="card">
                        <div class="card-content">
                            <b-card-body class="mb-0 roster-group pt-0 pb-0">

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
                                    <template v-slot:action3="{ rows }">
                                        <b-form-select class="ruleList"   v-model="rows.item.rule"  :options="ruleList">
                                            <template v-slot:first>
                                                <option :value="null">--Please select Rule--</option>
                                            </template>
                                        </b-form-select>
                                    </template>
                                    <template v-slot:action5="{ rows }">
                                        <b-link v-if="rows.item.group_id && isFromDisable == false" ml="4" class="text-primary"
                                        @click="deleteEmployee(rows.item.group_id,rows.item.emp_id,rows.index)">
                                            <i class="bx bx-trash cursor-pointer text-danger"></i>
                                        </b-link>
                                    </template>
                                </Datatable>


<!--                                <b-button v-if="isEdit" @click="addMoreEmployee" lg="6" size="md" variant="dark" type="button" >Add New Employee</b-button>&nbsp;-->
                                <b-row align-h="end" class="mt-2">
                                    <b-col md="2" class="mb-2 d-flex justify-content-end">
                                        <b-button :disabled="isFromDisable" lg="6" size="md" variant="dark" type="submit" class="mr-2" >{{submitBtn}}</b-button>&nbsp;
                                        <b-button lg="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                    </b-col>
                                </b-row>
                            </b-card-body>

                        </div>
                    </b-card>
                </section>
            </b-form>
             <!-- Zero configuration table -->
            <section id="basic-datatable2">
                <b-card class="card">
                    <b-card-header header-bg-variant="dark" header-text-variant="white">Employee OT Rule List</b-card-header>
                    <b-card-body class="border">
                        <b-row>
                            <b-col md="3">
                                <label>Department</label>
                                <b-form-select  name="department" v-model="empRuleSearch.department_id" :options="departmentList">
                                    <template v-slot:first>
                                        <option :value="null">-- Please select a department --</option>
                                    </template>
                                </b-form-select>
                            </b-col>
                            <b-col md="3">
                                <label>Rule Name <span class="text-danger withotmonth"></span></label>
                                <b-form-select id="month"  v-model="empRuleSearch.rule"  :options="ruleList">
                                    <template v-slot:first>
                                                <option :value="null">Select Rule</option>
                                        </template>
                                </b-form-select>
                            </b-col>
                            <b-col md="3" class="mt-2">
                                        <b-button lg="6" size="md" variant="dark" @click="searchGroup" type="button" >Search</b-button>&nbsp;
                                        <b-button lg="6" size="md" class="btn-outline-dark" @click="resetSearchGroup"  type="reset">Cancel</b-button>
                                </b-col>
                        </b-row>

                        <Datatable  v-bind:fields="dataTable.fields" v-bind:items="dataTable.items" :totalList="totalRosterList" :filterIgnoredFields="ignoredFields" :perPage="perPage" >
                                <template v-slot:action2="{ rows }">
                                        {{rows.index + 1}}
                                </template>
                            <template v-slot:action3="{ rows }">
                                <b-link ml="4" class="text-primary"
                                        @click="editRow(rows.item)">
                                    <i class="bx bx-edit cursor-pointer"></i>
                                </b-link>
<!--                                <b-link ml="4" class="text-primary"-->
<!--                                        @click="viewRow(rows.item)">-->
<!--                                    <i class="bx bx-show cursor-pointer"></i>-->
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
                empRuleSearch:{
                    department_id:null,
                    rule:null,
                },
                employeeSearch: {
                    department_id:null
                },
                rosterGroup: {
                    rule:null
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
                            {key:'department_name', label: 'Department', sortable:true},
                            {key:'ot_category_name', label: 'Rule Name', sortable:true},
                            {key:'emp_count', label: 'Number of Employee', sortable:true},
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
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/overtime/employee-ot-rule").then(res => {
                    this.departmentList = res.data.departmentList;
                    this.ruleList = res.data.rules;
                    this.monthList = res.data.months;
                    this.shiftList = res.data.shifts;
                    this.dataTable.items = res.data.empRules;
                    this.totalRosterList = res.data.empRules.length;


                });
            },
             searchGroup(search){
                  this.isFromDisable = false;
                  let currObj = this;
                         ApiRepository.callApi(ApiRepository.POST_COMMAND, "/overtime/employee-ot-rule/search-ot-rule", this.empRuleSearch).then(res => {
                             this.dataTable.items = res.data.employeeRuleList;
                             this.totalRosterList = res.data.employeeRuleList.length;
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
            onSubmit(roster) {
                 //let empId = this.selectCheckbox;
                //console.log(empId);
                let data={};
                data.items = this.items.filter(function(item,index) {
                    return item.checkbox == "1";
                   //return  empId.includes(item.emp_id);
                });
                console.log(data.items);
                // data.group_name = this.rosterGroup.groupName;
                // data.month = this.rosterGroup.month;
                // data.month_slabs = this.rosterGroup.month_slabs;
                // data.shift = this.rosterGroup.shift;
                let currObj = this;
                this.$validator.validateAll(roster).then(() => {
                      if (!currObj.errors.any()) {
                         if (data.items.length > 0) {
                             //console.log(data);
                             ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/employee-ot-rule', data).then(res => {
                                  if (res.data.o_status_code == 1) {
                                     currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                                      this.loadData();
                                      this.show = false;
                                    // this.viewRow(data);
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
                });
            },
            onReset(evt) {
                 this.items = {};
                 this.rosterGroup.groupName = '';
                 this.rosterGroup.month = '';
                 this.rosterGroup.month_slabs = '';
                 this.rosterGroup.shift = '';
                 this.show = false;
                 this.isFromDisable = false;
                 this.isEdit = false;
                 this.selectCheckbox = [];
            },
            resetSearchGroup(evt){
                this.empRuleSearch = {
                    department_id:null,
                    rule:null
                }
            },
            editRow(data) {
                 //console.log(this.selectCheckboxApprove);
                let param = data;
                //this.updateIndex = id;
                this.isFromDisable = false;
                this.checkBoxDisabled = false;
                this.isEdit = true;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/overtime/employee-ot-rule/details`,param).then(result => {
                    this.submitBtn = 'Update';
                    this.items = result.data.employeeList;
                    let that = this
                    this.items.forEach(function(v,i){
                        if (v.emp_id){
                            that.items[i].checkbox = 1;
                        }else{
                            that.items[i].checkbox = 0;
                        }

                        that.selectCheckbox.push(v.emp_id);
                    });
                    console.log(this.items);
                    //this.selectCheckbox = result.data.rosterDetails;
                    this.totalList = result.data.employeeList.length;
                    if(this.items.length > 0){
                        this.show = true;
                    }

                });
                this.show = true;

            },
            viewRow(data) {
                //this.updateIndex = id;
                 let param = data;
                //this.updateIndex = id;
                this.isFromDisable = true;
                this.isEdit = false;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/overtime/ot-roster-group/details`,param).then(result => {
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
            deleteEmployee(group_id,emp_id,index){
                let currObj = this;
                console.log(index);
                ApiRepository.callApi(ApiRepository.DELETE_COMMAND, "/overtime/ot-roster-group/"+group_id+"/"+emp_id).then(res => {
                        if (res.data.o_status_code == 1) {
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            currObj.items.splice(index, 1);
                            this.loadData();
                            this.items = currObj.items;
                            this.totalList = currObj.items.length;
                           // this.editRow(data);
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

