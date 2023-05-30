<template>
    <div class="content-wrapper">
        <div class="content-body rosterGroup">
            <b-card class="card">
                <b-card-header header-bg-variant="dark" header-text-variant="white">Create Roster Group</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSearch('search')" @reset="onReset" data-vv-scope="search">
                        <b-row >
                            <b-col md="4">
                                <b-form-group
                                  label="Department"
                                  label-for="department"
                                >
                                    <b-form-select
                                      @change="findSection"
                                      v-validate="'required'"
                                      id="department"
                                      name="department"
                                      v-model="employeeSearch.department_id"
                                      :options="departmentList">
                                        <template v-slot:first>
                                            <option :value="null">-- Please select a department --</option>
                                        </template>
                                    </b-form-select>
                                    <span :style="errorMessage">{{ errors.first('search.department') }}</span>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group class="" id="section_id" label="Section" label-for="section_id">
                                    <b-form-select  class="form-control" id="section_id" name="section_id" v-model="employeeSearch.section_id" >
                                        <option value="">Select Section</option>
                                        <option :value="section.value" v-for="section in sections">{{ section.text}}</option>
                                    </b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col class="mt-2">
                                <b-button lg="6" size="md" variant="dark" type="submit" >Search Employee</b-button>&nbsp;
                                <b-button lg="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>

            <b-form @submit.prevent="onSubmit('roster')" @reset="onReset"  v-if="show" data-vv-scope="roster">
                <!-- Zero configuration table -->
                <section id="basic-datatable">
                    <b-card>
                        <b-card-title>
                            <b-row align-h="start">
                                <b-col md="3">
                                    <label>OT Month <span class="text-danger">*</span></label>
                                    <b-form-select v-validate="'required'"  name="month"   :disabled="isFromDisable"  id="month"  v-model="rosterGroup.month" @change="fnCheckboxDisabled()"  :options="monthList">
                                        <template v-slot:first>
                                            <option :value="null">Select Month</option>
                                        </template>
                                    </b-form-select>
                                    <span :style="errorMessage">{{ errors.first('roster.month') }}</span>
                                </b-col>
                                <b-col md="3" v-if="isEditShow">
                                    <label>Previous Group </label>
                                    <b-form-select   name="group"   id="group"  v-model="rosterGroup.group" @change="previousGroup()"  :options="previousGroupList">
                                        <template v-slot:first>
                                            <option :value="null">Select Group</option>
                                        </template>
                                    </b-form-select>
                                </b-col>
                                <b-col md="3">
                                    <label>Group Name <span class="text-danger">*</span></label>
                                    <b-form-input v-validate="'required'" name="GroupName"   :disabled="isFromDisable" v-model="rosterGroup.groupName" maxlength="30" minlength="8" type="text" placeholder="Group Name"></b-form-input>
                                    <span :style="errorMessage">{{ errors.first('roster.GroupName') }}</span>
                                </b-col>
                            </b-row>
                        </b-card-title>
                        <b-card-body class="mb-0 roster-group pt-0 pb-0 border">
                            <Datatable v-bind:fields="fields" v-bind:items="items" :totalList="totalList" :perPage="perPage" :filterIgnoredFields="ignoredFields" >
                                <template v-slot:head1="{ rows }">
                                    <b-form-checkbox
                                        v-model="allSelected"
                                        :indeterminate="indeterminate"
                                        aria-describedby="items"
                                        aria-controls="items"
                                        @change="toggleAll"
                                        :disabled="checkBoxDisabled"
                                     >
                                    </b-form-checkbox>
                                </template>
                                <template v-slot:headCell1="{ rows }">
                                    <b-form-checkbox
                                    :disabled="isFromDisable || checkBoxDisabled"
                                    v-model="rows.item.checkbox"
                                    value="1"
                                    unchecked-value="0"
                                    stacked
                                    ></b-form-checkbox>

                                </template>
                                <template v-slot:action3="{ rows }">
<!--                                        rows.item.off_day-->
                                    <b-form-select :disabled="isFromDisable || rows.item.emp_type_id==1"   class="offdays"   v-model="rows.item.off_day"    :options="daysList">
                                        <template v-slot:first>
                                            <option :value="null">--Please select day--</option>
                                        </template>
                                    </b-form-select>
                                </template>
                                <template v-slot:action4="{ rows }">
                                        <b-form-input  :disabled="isFromDisable" v-model="rows.item.reff_value"  type="text" placeholder=""></b-form-input>
                                </template>

                                <template v-slot:action5="{ rows }">
                                    <b-link v-if="rows.item.group_id && isFromDisable == false" ml="4" class="text-primary"
                                        @click="deleteEmployee(rows.item.group_id,rows.item.emp_id,rows.index)">
                                        <i class="bx bx-trash cursor-pointer text-danger"></i>
                                    </b-link>
                                </template>

                            </Datatable>


                            <b-button v-if="isEdit" @click="addMoreEmployee" lg="6" size="md" variant="dark" type="button" >Add New Employee</b-button>&nbsp;
                            <b-row align-h="end">
                                <b-col md="2" class="mb-2 d-flex justify-content-end">
                                    <b-button :disabled="isFromDisable" lg="6" size="md" variant="dark" type="submit" class="mr-2" >{{submitBtn}}</b-button>&nbsp;
                                    <b-button lg="6" size="md" class="btn-outline-dark"  type="reset">Cancel</b-button>
                                </b-col>
                            </b-row>
                        </b-card-body>
                    </b-card>
                </section>
            </b-form>
             <!-- Zero configuration table -->
            <section id="basic-datatable2">
                <b-card class="card">
                    <b-card-header header-bg-variant="dark" header-text-variant="white">Group List</b-card-header>
                    <b-card-body class="border">
                        <b-row>
                            <b-col md="3">
                                <b-form-group
                                    label="Department"
                                    label-for="Department"
                                >
                                    <b-form-select @change="findSectionInGroup" id="Department" name="department" v-model="groupSearch.department_id" :options="departmentList">
                                        <template v-slot:first>
                                            <option :value="null">-- Please select a department --</option>
                                        </template>
                                    </b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group class="" id="group_section_id" label="Section" label-for="section_id">
                                    <b-form-select  class="form-control" id="section_id" name="section_id" v-model="groupSearch.section_id" >
                                        <option value="">Select Section</option>
                                        <option :value="section.value" v-for="section in groupSections">{{ section.text }}</option>
                                    </b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group
                                    label="OT Month"
                                    label-for="OT_Month"
                                >
                                    <b-form-select id="OT_Month"  v-model="groupSearch.month"  :options="monthList">
                                        <template v-slot:first>
                                            <option :value="null">Select Month</option>
                                        </template>
                                    </b-form-select>
                                </b-form-group>

                            </b-col>

                            <b-col md="3" class="mt-2">
                                <b-button size="md" variant="dark" @click="searchGroup" type="button" >Search</b-button>&nbsp;
                                <b-button size="md" class="btn-outline-dark" @click="resetSearchGroup"  type="reset">Cancel</b-button>
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
                                <b-link ml="4" class="text-primary"
                                        @click="viewRow(rows.item)">
                                    <i class="bx bx-show cursor-pointer"></i>
                                </b-link>
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
                selectedOffday:'FRI',
                daysList: [
                    {text:'Saturday', value:'SAT'},
                    {text:'Sunday', value:'SUN'},
                    {text:'Monday', value:'MON'},
                    {text:'Tuesday', value:'TUE'},
                    {text:'Wednesday', value:'WED'},
                    {text:'Thursday', value:'THU'},
                    {text:'Friday', value:'FRI'},
                ],
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
                    {key:'action3', label: 'Off Day *', formatter: 'off_day'},
                    {key:'action4', label: 'Shoronjom/Reference (optional)', sortable:true},
                    {key:'head2', label: '', thClass: 'd-block'},
                    {key:'action5', label: 'Action', thClass: 'd-none'},
                 ],
                items:[],
                dataTable: {
                         fields: [
                            {key:'action2', label: 'SL', sortable:true},
                            {key:'group_name', label: 'Group Name', sortable:true},
                            {key:'department_name', label: 'Department', sortable:true},
                            {key:'dpt_section', label: 'Section', sortable:true},
                            {key:'year_month', label: 'Year/Month', sortable:true},
                            {key:'total', label: 'Number of Employee', sortable:true},
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
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/overtime/ot-roster-group").then(res => {
                    this.departmentList = res.data.departmentList;
                    this.yearList = res.data.years;
                    this.monthList = res.data.months;
                    this.shiftList = res.data.shifts;
                    this.dataTable.items = res.data.rosterGroup;
                    this.totalRosterList = res.data.rosterGroup.length;


                });
            },
             searchGroup(search){
                  this.isFromDisable = false;
                  let currObj = this;
                         ApiRepository.callApi(ApiRepository.POST_COMMAND, "/overtime/ot-roster-group/search-group", this.groupSearch).then(res => {
                             this.dataTable.items = res.data.rosterGroup;
                             this.totalRosterList = res.data.rosterGroup.length;
                         });
              },
            onSearch(search){
                this.isFromDisable = false;
                let currObj = this;
                this.employeeSearch.month = '';
                this.$validator.validateAll(search).then(() => {
                     if (!this.errors.any()) {
                         ApiRepository.callApi(ApiRepository.POST_COMMAND, "/overtime/ot-roster-group/search", this.employeeSearch).then(res => {
                             this.items = res.data.employees.filter(item => {
                                 return !item.ot_month_id.includes(this.rosterGroup.month)
                             });
                             for (let i = 0; this.items.length > i; i++){
                                 this.items[i].off_day = 'FRI';
                             }
                             this.totalList = res.data.employees.length;
                             if (this.totalList > 0) {
                                 this.show = true;
                                 this.submitBtn = 'Save';
                             }else{
                                 this.isEditShow = false;
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
                let data={};
                data.items = this.items.filter(function(item,index) {
                    return item.checkbox == "1";
                });
                console.log(data.items);
                data.group_name = this.rosterGroup.groupName;
                data.month = this.rosterGroup.month;
                data.month_slabs = this.rosterGroup.month_slabs;
                data.shift = this.rosterGroup.shift;
                data.edit = this.isEdit;
                let currObj = this;
                this.$validator.validateAll(roster).then(() => {
                      if (!currObj.errors.any()) {
                         if (data.items.length > 0) {
                             ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-roster-group', data).then(res => {
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
                });
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
            editRow(data) {
                 //console.log(this.selectCheckboxApprove);
                let param = data;
                //this.updateIndex = id;
                this.isFromDisable = false;
                this.checkBoxDisabled = false;
                this.isEdit = true;
                this.isEditShow = false;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/overtime/ot-roster-group/details`,param).then(result => {
                    this.submitBtn = 'Update';
                    this.rosterGroup.groupName = result.data.group_name;
                    this.rosterGroup.month = result.data.month;
                    this.rosterGroup.month_slabs = result.data.month_slabs;
                    this.rosterGroup.shift = result.data.shift;
                    this.departmentId = result.data.departmentId;
                    this.section_id = result.data.section_id;
                    // this.designation = result.data.designation;
                    // this.department_name = result.data.department_name;
                    this.items = result.data.rosterDetails;
                    console.log(this.items);
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
                    this.items.forEach(function(v,i){
                        if (v.approve_yn == 'Y'){
                            that.selectCheckboxApprove.push(v.approve_yn);
                        }else{
                            that.selectCheckboxApprove.push('N');
                        }
                    });
                    //this.selectCheckbox = result.data.rosterDetails;
                    this.totalList = result.data.rosterDetails.length;
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
                param.department_id = this.departmentId ? this.departmentId : this.employeeSearch.department_id
                param.group_section_id = this.section_id ? this.section_id : this.employeeSearch.section_id
                param.month = this.rosterGroup.month;
                //console.log(param);
                ApiRepository.callApi(ApiRepository.POST_COMMAND, "/overtime/ot-roster-group/search-with-group-section", param).then(res => {
                             let that = this;
                             // let  $data = res.data.employees.filter(function(item,index) {
                             //      return  !empId.includes(item.emp_id);
                             //   });
                           let  $data = res.data.employees;   // 020202 ROMEL DAS (STAFF)	this id not show section wise so use this
                              $data.forEach(function (value,i) {
                                  if(value.off_day){
                                         that.isFromDisable = true;
                                  }
                                  that.items.push(value);
                              });
                                for (let i = 0; this.items.length > i; i++){
                                    this.items[i].off_day = 'FRI';
                                }
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
            findSection() {
                if(this.employeeSearch.department_id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/section-by-department/${this.employeeSearch.department_id}`).then(res => {
                        this.sections = res.data;
                        if (res.data.length == 1){
                            this.employeeSearch.section_id = res.data[0].value;
                        }
                    });
                }
            },
            findSectionInGroup() {
                if(this.groupSearch.department_id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/section-by-department/${this.groupSearch.department_id}`).then(res => {
                        this.groupSections = res.data;
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

            },
            previousGroup:function(e) {
                if (this.rosterGroup.group){
                    this.isEdit = true;
                    this.employeeSearch.group = this.rosterGroup.group;
                    this.employeeSearch.month = this.rosterGroup.month;
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, "/overtime/ot-previous-group", this.employeeSearch).then(res => {
                        this.items = res.data.employees;
                        this.totalList = res.data.employees.length;
                        let that = this
                        this.items.forEach(function(v,i){
                            if (v.emp_id){
                                that.items[i].checkbox = 1;
                            }else{
                                that.items[i].checkbox = 0;
                            }

                            that.selectCheckbox.push(v.emp_id);
                        });
                        if(this.items.length > 0){
                            this.show = true;
                        }
                    });
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

