<template>
    <div>
        <b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">Search Employee</b-card-header>
            <b-card-body class="border">
                <b-row>
                    <b-col sm="4">
                        <b-form-group label="Department Name" label-for="dpt_id" class="requiredField">
                            <b-form-select
                                id="dpt_id"
                                v-model="searchData.department_id"
                                :options="departmentOptions"
                                value-field="value"
                                text-field="text"
                                required
                            ></b-form-select>
                            <div :class="{'invalid-feedback':true ,'d-block':$v.searchData.department_id.$error && !$v.searchData.department_id.required}">Department is required!</div>
                        </b-form-group>
                    </b-col>
                    <b-col md="4">
                        <b-form-group
                            label="Employee Code"
                            label-for="emp_id"
                        >
                            <v-select
                                label="option_name"
                                v-model="selectedEmployee"
                                :options="empIdList"
                                @search="searchempcods">
                                <template #search="{attributes, events}">
                                    <input
                                        class="vs__search"
                                        v-bind="attributes"
                                        v-on="events"
                                    />
                                </template>
                            </v-select>
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group
                            label="LEAVE TYPE"
                            label-for="leave_type_id"
                            class="requiredField"
                        >
                            <b-form-select
                                v-model="searchData.leave_type_id"
                                required
                                id="leave_type_id"
                                :options="leavetypes">
                            </b-form-select>
                            <div :class="{'invalid-feedback':true ,'d-block':$v.searchData.leave_type_id.$error && !$v.searchData.leave_type_id.required}">Leave type is required!</div>
                        </b-form-group>
                    </b-col>
                    <b-col class="text-right mt-2">
                        <b-button @click="search">Search</b-button>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                       <b-table :items="leaveData" bordered striped hover small :fields="leave_fields">
                           <template #table-colgroup="scope">
                               <col style="width:10%">
                               <col style="width:24%">
                               <col style="width:34%">
                               <col style="width:24%">
                               <col style="width:8%">
                           </template>
                           <template #cell(index)="data">
                               {{ data.index + 1 }}
                           </template>
                           <template v-slot:cell(leave_days)="{ value, item, field: { key }}">
                               <b-form-input class="text-right" v-model="item[key]" />
                           </template>
                       </b-table>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col class="text-right">
                        <b-button type="button" @click="onSubmit" class="btn btn-dark shadow mb-1">{{submitBtn}}</b-button>&nbsp;
                        <b-button type="button" @click="onReset"  class="btn btn-outline-dark  mb-1">Cancel</b-button>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
        <b-card >
            <b-card-header header-bg-variant="dark" header-text-variant="white">Existing Leave List</b-card-header>
            <b-card-body class="border">
                <Datatable v-bind:fields="fields" :totalList="totalList" :perPage="perPage"
                           v-bind:items="items">
                    <template v-slot:actions="{ rows }">
                        <b-link ml="4" class="text-primary"
                                @click="editRow(rows.item)">
                            <i class="bx bx-edit cursor-pointer"></i>
                        </b-link>
                        <a v-if="rows.item.attachment" :href="'/v1/leave/leave-attachment-download/'+rows.item.leave_id">
                            <i class='bx bx-file' ></i>
                        </a>
                    </template>
                </Datatable>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from "../../Repository/ApiRepository";
    import { validationMixin } from 'vuelidate'
    const { required, requiredIf, maxLength, minLength, email } = require("vuelidate/lib/validators");
    export default {
        name: "existing-leave-entry",
        components: {DatePicker,Datatable,Vue,vSelect,vcss},
        data() {
            return {
                searchData: {
                    leave_id: '',
                    department_id: '',
                    emp_name: '',
                    emp_id: '',
                    emp_code: '',
                    designation: '',
                    leave_type_id: '',
                    leave_days: 0
                },
                leaveData: [],
                leave_fields: [
                    {key: 'index', label: 'SL', class:'text-center'},
                    {key: 'emp_code', label: 'Employee Code'},
                    {key: 'emp_name', label: 'Employee Name'},
                    {key: 'designation', label: 'Designation'},
                    {key: 'leave_days', label: 'Total Enjoyed Days', class: 'text-center'},
                ],
                departmentOptions: [],
                submitBtn: 'Save',
                errorMessage: {color: 'red'},
                empIdList: [],
                selectedEmployee: {},
                LeaveEntry: {
                    leave_days:0,
                    leave_type_id: '',
                    emp_id: '',
                    emp_name: '',
                    designation: '',
                    department_name: '',
                    leave_reason: ''
                },
                leavetypes: [],
                perPage: 5,
                totalList: 1,
                fields: [
                    {key: 'emp_code', label: 'Emp Code', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'emp_name', label: 'Employee Name', sortable: true, sortDirection: 'desc'},
                    {key: 'department_name', label: 'Department', sortable: true, sortDirection: 'desc'},
                    {key: 'designation', label: 'Designation', sortable: true, sortDirection: 'desc'},
                    {key: 'leave_type', label: 'Leave Type', sortable: true, sortDirection: 'desc'},
                    {key: 'leave_days', label: 'Leave days', sortable: true, sortDirection: 'desc', class: 'text-center'},
                    {key: 'action', class:'text-center'}
                ],
                items: []
            }
        },
        mixins: [validationMixin],
        validations: {
            searchData: {
                leave_id: {},
                department_id: {required},
                emp_name: {},
                emp_id: {},
                emp_code: {},
                designation: {},
                leave_type_id: {required},
                leave_days: {}
            }
        },
        mounted() {
            this.loadData()
            this.getDepartment()
        },
        watch: {
            selectedEmployee:function(val,oldVal) {
                if(val !== null) {
                    this.searchData = {
                        leave_id: this.searchData.leave_id,
                        department_id: val.department ? val.department.department_id: this.searchData.department_id,
                        emp_name: val.emp_name,
                        emp_id: val.emp_id,
                        emp_code: val.emp_code,
                        designation: val.designation ? val.designation.designation: this.searchData.designation,
                        leave_type_id: this.searchData.leave_type_id,
                        leave_days: 0
                    }
                } else {
                    this.searchData = {
                        leave_id: this.searchData.leave_id,
                        department_id: this.searchData.department_id,
                        emp_name: "",
                        emp_id: "",
                        emp_code: "",
                        designation: this.searchData.designation,
                        leave_type_id: this.searchData.leave_type_id,
                        leave_days: 0
                    }
                }
            }
        },
        computed: {
            leave_days:function(){
                let statrDate=moment(this.LeaveEntry.leave_start_date);
                let endDate=moment(this.LeaveEntry.leave_end_date);
                let countDays=endDate.diff(statrDate,'days');
                if (isNaN(countDays)) {
                    return null;
                }
                else{
                    return countDays+1;
                }
            },
        },
        methods: {
            search(){
                this.$v.$touch()
                this.$v.searchData.$touch()
                if(!this.$v.searchData.$invalid){
                    if(this.searchData.emp_id){
                        if(this.leaveData.filter(a=>a.emp_id == this.searchData.emp_id).length == 0){
                            this.leaveData.unshift(this.searchData)
                        } else {
                            this.$notify({group: 'pmis', text: 'Already added to the table', type: 'error'})
                        }
                    } else {
                        ApiRepository.callApi(ApiRepository.GET_COMMAND, `/leave/leave-entry/emp-info/${0}/${this.searchData.department_id}`).then(res => {
                            var object = this
                            res.data.empcodeList.forEach(function (item) {
                                if(object.leaveData.filter(a=>a.emp_id == item.emp_id).length == 0){
                                    object.searchData = {
                                        leave_id: '',
                                        department_id: item.department ? item.department.department_id: object.searchData.department_id,
                                        emp_name: item.emp_name,
                                        emp_id: item.emp_id,
                                        emp_code: item.emp_code,
                                        designation: item.designation ? item.designation.designation: object.searchData.designation,
                                        leave_type_id: object.searchData.leave_type_id,
                                        leave_days: 0
                                    }
                                    object.leaveData.unshift(object.searchData)

                                }
                            });
                            object.searchData = {
                                leave_id: '',
                                department_id: object.searchData.department_id,
                                emp_name: '',
                                emp_id: '',
                                emp_code: '',
                                designation: '',
                                leave_type_id: object.searchData.leave_type_id,
                                leave_days: 0
                            }
                            this.$v.$reset()
                        }).then(response => {

                        })

                    }

                }
            },
            onSubmit() {
                if(this.leaveData.filter(a=> a.leave_days == 0).length > 0){
                    this.$notify({group: 'pmis', text: "Total enjoyed days cannot be zero!", type: 'error'})
                } else {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, `/leave/old_leave_entry`, this.leaveData).then(res => {
                        if (res.data.o_status_code == 1) {
                            this.$notify({group: 'pmis', text: "Data inserted successfully!", type: 'success'});
                            this.loadData();
                            this.onReset();
                        } else {
                            this.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'})
                        }
                    });
                }
            },
            getDepartment(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/pmis/employee/basic-infos').then(result => {
                    this.departmentOptions= result.data.department;
                })
            },
            searchempcods(id){
                if(id && (id !== undefined)) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/leave/leave-entry/emp-info/${id}/${this.searchData.department_id}`, this.LeaveEntry).then(res => {
                        this.empIdList = res.data.empcodeList;
                    })
                }
            },
            loadData: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/leave/old-leave-data").then(res => {
                    this.items=res.data;
                    this.totalList = res.data.length;
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, "/leave/leave-entry", this.LeaveEntry).then(res => {
                    this.leavetypes=res.data.leavetypes;
                });
            },
            editRow(ob) {
                if(this.leaveData.filter(a=>a.leave_id == ob.leave_id).length == 0){
                    this.searchData = {
                        leave_id: ob.leave_id,
                        department_id: '',
                        emp_name: ob.emp_name,
                        emp_id: ob.emp_id,
                        emp_code: ob.emp_code,
                        designation: ob.designation,
                        leave_type_id: ob.leave_type_id,
                        leave_days: ob.leave_days
                    }
                    this.leaveData.unshift(this.searchData);
                    $(document).scrollTop(0);
                    this.submitBtn = 'Update'
                }
            },
            dateFormatter: function() {
                return {
                    value2date: value => {
                        return value ? moment(new Date(value), "YYYY-MM-DD").toDate() : null
                    },
                    date2value: date => {
                        return date ? moment(date).format("YYYY-MM-DD") : null
                    }
                }
            },
            onReset() {
                this.$nextTick(() => {
                    this.selectedEmployee = '';
                    this.searchData = {
                        leave_id: '',
                        department_id: '',
                        emp_name: '',
                        emp_id: '',
                        emp_code: '',
                        designation: '',
                        leave_type_id: '',
                        leave_days: 0
                    }
                    this.submitBtn = 'Save';
                    this.leaveData = []
                    this.$v.$reset()
                });
            },
        }
    }
</script>

<style scoped>
    img {
        height: auto;
        max-width: 2.5rem;
        margin-right: 1rem;
    }

    .d-center {
        display: flex;
        align-items: center;
    }

    .selected img {
        width: auto;
        max-height: 23px;
        margin-right: 0.5rem;
    }

    .v-select .dropdown li {
        border-bottom: 1px solid rgba(112, 128, 144, 0.1);
    }

    .v-select .dropdown li:last-child {
        border-bottom: none;
    }

    .v-select .dropdown li a {
        padding: 10px 20px;
        width: 100%;
        font-size: 1.25em;
        color: #3c3c3c;
    }

    .v-select .dropdown-menu .active > a {
        color: #fff;
    }
    .nav.nav-pills .nav-item .nav-link, .nav.nav-pills .nav-item.dropdown.show .dropdown-menu, .nav.nav-tabs .nav-item .nav-link, .nav.nav-tabs .nav-item.dropdown.show .dropdown-menu{
        border-radius: 0px;
    }
    .nav.nav-pills .nav-item, .nav.nav-tabs .nav-item {
        margin-right: 0px;
    }
    div.requiredField  label:after{
        content: '*';
        color: red;
    }
</style>
