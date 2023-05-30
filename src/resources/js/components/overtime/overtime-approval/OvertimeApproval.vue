<template>
    <b-container fluid>
        <b-form @submit.prevent="onSearchData" @reset.prevent="onReset">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Overtime Register Approval</b-card-header>
                <b-card-body class="border">
                    <b-row>
                        <b-col md="4">
                            <label for="departmentID">Department<span class="text-danger">*</span></label>
                            <b-form-select id="departmentID" v-model="overtimeapproval.department"
                                           :options="departmentList" @change="getGroupName" required ></b-form-select>
                        </b-col>
                        <b-col md="4">
                            <label for="section">Section</label>
                            <b-form-select
                              id="section"
                              v-model="overtimeapproval.section"
                              :options="sectionList">
                                <template v-slot:first>
                                    <option :value="null">-- Please select a section --</option>
                                </template>
                            </b-form-select>
                        </b-col>
                        <b-col md="4">
                            <label>Employee Code</label>
                            <v-select
                                label="option_name"
                                v-model="selectedEmployee"
                                :options="empIdList"
                                @search="searchempcods">
                            </v-select>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <label>OT Month <span class="text-danger">*</span></label>
                            <b-form-select v-validate="'required'"  name="month"  id="month"  v-model="overtimeapproval.month" @change="getGroupName"   :options="monthList" required>
                                <template v-slot:first>
                                    <option :value="null">Select Month</option>
                                </template>
                            </b-form-select>
                         </b-col>
                        <b-col md="4">
                            <label>Groups</label>
                            <b-form-select id="approval_status" v-model="overtimeapproval.otGroup"
                                           :options="otGroups"></b-form-select>
                        </b-col>
                        <b-col md="4">
                            <label>Approval Status</label>
                            <b-form-select id="approval_status" v-model="overtimeapproval.approval_status"
                                           :options="approvalStatus"></b-form-select>
                        </b-col>
                    </b-row>
                     <b-row>
                        <b-col class="d-flex justify-content-end mt-1">
                            <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Search</b-button> &nbsp;
                            <b-button type="reset" class="btn btn-outline-dark  mb-1">Reset</b-button>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
        </b-form>

        <b-card >
            <b-card-header header-bg-variant="dark" header-text-variant="white">
                Overtime Register Approval List
                <span class="all-approved" title="Select Approved all">  <b-form-checkbox
                        id="checkbox-1"
                        v-model="selectAll"
                        name="checkbox-1"
                        value=true
                        unchecked-value=false @input="selectAllApproved"
                ></b-form-checkbox></span>

            </b-card-header>
            <b-card-body class="border">
                <Datatable v-bind:fields="tableDataAllowancs.fields" :totalList="totalList" :perPage="perPage"
                           v-bind:items="tableDataAllowancs.items" v-bind:pageColSize="4" v-bind:searchColSize="5">

                    <template v-slot:action2="{ rows }">
                        <b-form-input type="number" :disabled="rows.item.approve_status==1"
                                      v-model="rows.item.approve_hour" class="text-right"></b-form-input>
                    </template>
                    <template v-slot:action3="{ rows }">

                        <b-form-input type="number" :disabled="rows.item.approve_status==1"
                                      v-model="rows.item.approve_hour_offday" class="text-right"></b-form-input>
                    </template>

                    <template v-slot:action4="{ rows }">
                        <b-form-select v-if="rows.item.approve_status != 1" v-model="rows.item.approve_edit_status"
                                       :options="approvedStatusList"></b-form-select>
                        <label v-else-if="rows.item.approve_status == 1">Approved</label>
                    </template>
                </Datatable>
                <b-row class="mt-2">
                    <b-col class="d-flex justify-content-end ">
                        <b-button type="submit" @click="overtimeApprovalSubmit" class="btn btn-dark shadow  mb-1">
                            Submit
                        </b-button>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </b-container>
</template>

<script>
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../../layouts/common/datatable_store';
    import ApiRepository from "../../../Repository/ApiRepository";

    export default {
        components: {DatePicker, Datatable, Vue, vSelect, vcss},
        data() {
            return {
                dateValueType: this.dateFormatter(),
                selectAll:false,
                approvalList: [],
                empIdList: [],
                employee: [],
                selectedEmployee: {},
                overtimeapproval: {},
                approval: [{
                    approvedOtHours: [],
                    registerApproval: [],
                }],
                departmentList: [],
                otGroups: [],
                approvalStatus: [
                    {value: 0, text: 'Pending'},
                    {value: 1, text: 'Approved'}],
                sectionList: [],
                monthList: [],
                approvedOThour: '',
                perPage: 5,
                totalList: 0,

                approvedStatusList: [
                    {value: 0, text: 'Pending'},
                    {value: 1, text: 'Approved'},
                    {value: -1, text: 'Reject'}],
                tableDataAllowancs: {
                    fields: [{key: 'emp_code', label:'Employee Code', sortable: true},
                        {key: 'emp_name', label:'Name', sortable: true},
                        {key: 'designation', sortable: true, label: 'Designation',},
                        {
                            key: 'date_from', formatter: value => {
                                if (value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable: true,tdClass: 'date_class'
                        },
                        {
                            key: 'date_to',
                            formatter: value => {
                                if (value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable: true,tdClass: 'date_class'
                        },
                        {key: 'group_name', label: 'Group Name', sortable: true},
                        {key: 'register_hour', label: 'Regd. Hrs on', sortable: true, class:"text-right"},
                        {key: 'offdyreg_hour', label: 'Regd. Hrs off', sortable: true, class:"text-right"},
                        {key: 'action2', label: 'Approved Hours', class:"text-right"},
                        {key: 'action3', label: 'Approved Hours (OFF Day)', class:"text-right"},
                        {key: 'action4', label: 'Status'}],
                    items: [],
                    toggle:true
                },
            };
        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.overtimeapproval.emp_code = val.emp_code;
                }
            }

        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime Register Approval"});
            this.allDatalistShow();
        },

        methods: {
            getGroupName(){
                this.findSection();
                 let department = this.overtimeapproval.department;
                 let month = this.overtimeapproval.month;
                let section_id = this.overtimeapproval.section ? this.overtimeapproval.section : null;
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-get-group/${department}/${month}/${section_id}`).then(res => {
                    this.otGroups = res.data.otGroups;
                });
            },
            findSection() {
                if(this.overtimeapproval.department) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/section-by-department/${this.overtimeapproval.department}`).then(res => {
                        this.sectionList = res.data;
                        if (res.data.length == 1){
                            this.overtimeapproval.section = res.data[0].value;
                        }
                    });
                }
            },
            allDatalistShow() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/overtime/ot-approvals').then(res => {
                    this.departmentList = res.data.departments;
                    this.sectionList = res.data.sections;
                    this.otGroups = res.data.otGroups;
                    this.monthList = res.data.months;
                    this.employee = res.data.employee;
                });
            },
            dateFormatter: function () {
                return {
                    value2date: value => {
                        return value ? moment(new Date(value), "YYYY-MM-DD").toDate() : null;
                    },
                    date2value: date => {
                        return date ? moment(date).format("YYYY-MM-DD") : null;
                    }
                }
            },

            searchempcods(id) {
                let dptId = this.overtimeapproval.department;
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-approvals/emp-info/${id}`, this.overtimeapproval).then(res => {
                        this.empIdList = res.data.empcodeList;
                    })
                }
            },
            onSearchData() {
                this.selectAll = false;
                let currObj = this;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-approvals/search', this.overtimeapproval).then(res => {
                    if (res.data.otRegister.length > 0) {
                        if (res.data.status) {
                            this.tableDataAllowancs.items = res.data.otRegister;
                        } else {
                            this.tableDataAllowancs.items = [];
                        }
                    } else {
                        this.tableDataAllowancs.items = [];
                        //currObj.$notify({group: 'pmis', text: 'Sorry! No data found', type: 'error'});
                    }
                    this.totalList = res.data.otRegister.length;
                    return;
                });
            },
            overtimeApprovalSubmit(evt) {
                evt.preventDefault();
                let currObj = this;
                let param = this.tableDataAllowancs.items;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-approvals', param).then(res => {
                    if (res.data.o_status_code == 1) {

                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        //this.tableDataAllowancs.items=null;
                        this.onSearchData();
                    } else {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            onReset() {
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                    if (this.tableDataAllowancs.items) {
                        this.tableDataAllowancs.items = [];
                        this.totalList='';
                    }
                    this.selectedEmployee = null;
                    this.overtimeapproval = {};
                    this.selectAll = false;
                })
            },
            selectAllApproved: function() {
                if (this.selectAll == 'true') {
                    this.tableDataAllowancs.items.forEach(function (item) {
                        item.approve_edit_status = "1";
                    });
                }
                else {
                    this.tableDataAllowancs.items.forEach(function (item) {
                        item.approve_edit_status = "0";
                    });
                }
            }
        }
    };
</script>
<style scoped>
    .all-approved {
        position: absolute;
        right:45px;
        top:175px;
        z-index: 100;
        cursor: pointer;
    }
    .date_class{
        width: 100px;
    }
    td:nth-child(7) {
        text-align: center;
    }

    td:nth-child(8) {
        text-align: center;
    }

    /* td:nth-child(5), td:nth-child(7){
         text-align: center;
     }*/
</style>
