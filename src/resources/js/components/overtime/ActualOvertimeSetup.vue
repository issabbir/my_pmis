<template>
    <b-container fluid>
        <b-form   @submit.prevent="onSearchData"  @reset.prevent="onReset">
            <b-card title="Search Actual Overtime">
                <b-card-body class="border">
                    <b-row>
                        <b-col md="3">
                            <label for="otMonth">OT Month<span class="text-danger">*</span></label>
                            <b-form-select id="otMonth" v-model="actualOvertime.otMonth" required
                                           :options="otMonths"></b-form-select>
                        </b-col>
                        <b-col md="3">
                            <label for="departmentID">Department<span class="text-danger">*</span></label>
                            <b-form-select @change="findSection" id="departmentID" v-model="actualOvertime.department" required
                                           :options="departmentList"></b-form-select>
                        </b-col>
                        <b-col md="3">
                            <b-form-group class="" id="section_id" label="Section" label-for="section_id">
                                <b-form-select   class="form-control" id="section_id" name="section_id" v-model="actualOvertime.section_id" >
                                    <option value="">Select Section</option>
                                    <option :value="section.value" v-for="section in sections">{{ section.text }}</option>
                                </b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="3">
                            <label>Employee Code</label>
                            <v-select
                                label="option_name"
                                v-model="selectedEmployee"
                                :options="empIdList"
                                @search="searchempcods"
                                id="emp_code">
                                <template #selected-option="{ emp_code }">
                                    <div style="display: flex; align-items: baseline;">
                                        {{ emp_code }}
                                    </div>
                                </template>
                            </v-select>
                        </b-col>
                        <b-col md="3">
                            <label for="otStatus">OT Status</label>
                            <b-form-select id="otStatus" v-model="actualOvertime.otStatus"
                                           :options="otStatus"></b-form-select>
                        </b-col>
                        <b-col class="d-flex justify-content-end mt-1">
                            <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Search</b-button> &nbsp;
                            <b-button type="reset" class="btn btn-outline-dark  mb-1">Reset</b-button>
                        </b-col>
                    </b-row>
                </b-card-body>

            </b-card>
        </b-form>

        <b-card title="Actual Overtime" class="ot-act-form">
            <b-card-body class="border">
                <Datatable v-bind:fields="tableDataAllowancs.fields" :totalList="totalList" :perPage="perPage"
                           v-bind:items="tableDataAllowancs.items" v-bind:pageColSize="4" v-bind:searchColSize="5">
                    <template v-slot:action4="{ rows }">
                        <b-form-select v-model="rows.item.edit_ot_status" :options="otStatus"></b-form-select>
                    </template>
                    <template v-slot:action2="{ rows }">
                        <b-link :disabled="rows.item.ot_status==1"
                                :to='"/emp-wise-actual-time/"+rows.item.ot_register_id' class="ot-btn btn btn-primary">
                            <i class="bx bx-edit cursor-pointer"></i> Entry
                        </b-link>
                    </template>

                </Datatable>
                <b-row class="mt-2">
                    <b-col class="d-flex justify-content-end ">
                        <b-button type="submit" @click="actualTimeStatusUpdate" class="btn btn-dark shadow  mb-1">
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
    import Datatable from '../../layouts/common/datatable_store';
    import ApiRepository from "../../Repository/ApiRepository";

    export default {
        components: {DatePicker, Datatable, Vue, vSelect, vcss},
        data() {
            return {
                dateValueType: this.dateFormatter(),
                approvalList: [],
                empIdList: [],
                selectedEmployee: {},
                otMonths: {},
                actualOvertime: {
                    otMonth:null,
                    department:null,
                    section_id:null,
                    otStatus:null,
                    emp_code:null
                },
                departmentList: [],
                sectionList: [],
                sections: [],
                approvedOThour: '',
                otStatus: [{text: 'Hold', value: 1}, {text: 'On Process', value: 0}, {text: 'Reject', value: -1}],
                perPage: 5,
                totalList: 0,
                tableDataAllowancs: {
                    fields: [{key: 'index', sortable: true, label: 'Sl',},
                        {key: 'emp_code', sortable: true},
                        {key: 'emp_name', sortable: true},
                        {key: 'department_name', sortable: true},
                        {key: 'designation', sortable: true, label: 'Designation',},
                        {
                            key: 'date_from', formatter: value => {
                                if (value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable: true
                        },
                        {
                            key: 'date_to', formatter: value => {
                                if (value) {
                                    return moment(value).format('DD-MM-YYYY');
                                }
                            }, sortable: true
                        },
                        {key: 'group_name', label: 'Group Name', sortable: true},
                        {key: 'register_hour', label: 'Registered Hours', sortable: true},
                        {key: 'approve_hour', label: 'Approved Hours', sortable: true},
                        {key: 'action4', label: 'Status'},
                        {key: 'action2', label: 'Actual Time Entry'}],
                    items: []
                },
            };
        },
        watch: {
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.actualOvertime.emp_code = val.emp_code;
                }
            }

        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Actual Overtime"});
            this.allDatalistShow();
            let otMonth = this.$route.query.otMonth;
            if (otMonth && (otMonth !== undefined)) {
                this.actualOvertime.otMonth = otMonth;
                this.onSearchData();
            }

        },

        methods: {
            allDatalistShow() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/overtime/ot-actuals').then(res => {
                    this.departmentList = res.data.departments;
                    this.sectionList = res.data.sections;
                    this.otMonths = res.data.otmonths;
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
                let dptId = this.actualOvertime.department;
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-actuals/emp-info/${id}/${dptId}`, this.actualOvertime).then(res => {
                        this.empIdList = res.data.empcodeList;
                    })
                }
            },
            onSearchData() {
                let currObj = this;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-actuals/search', this.actualOvertime).then(res => {
                    if (res.data.otRegister.length > 0) {
                        if (res.data.status) {
                            this.tableDataAllowancs.items = res.data.otRegister;
                            this.actualOvertime.emp_code=null;
                        } else {
                            this.tableDataAllowancs.items = [];
                        }
                    } else {
                        this.tableDataAllowancs.items = [];
                        this.actualOvertime.emp_code=null;
                        currObj.$notify({group: 'pmis', text: 'Sorry! No data found', type: 'error'});
                    }
                    this.totalList = res.data.otRegister.length;
                    return;
                });
            },
            actualTimeStatusUpdate() {
                let currObj = this;
                let param = this.tableDataAllowancs.items;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-actuals-status', param).then(res => {
                    if (res.data.o_status_code == 1) {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.onSearchData();
                    } else {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });
            },
            findSection() {
                if(this.actualOvertime.department) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/section-by-department/${this.actualOvertime.department}`).then(res => {
                        this.sections = res.data;
                        if (res.data.length == 1){
                            this.actualOvertime.section_id = res.data[0].value;
                        }
                    });
                }
            },
            /* goOtActualEntry(){
                 let otMonth=this.actualOvertime.otMonth;
                 let department=this.actualOvertime.department;
                 let section=this.actualOvertime.section;
                 let emp_code=this.selectedEmployee.emp_code;
                 //let params={otMonth:otMonth,department:department,section:section,emp_code:emp_code};
                 this.$router.push({ path: '/emp-wise-actual-time/', query: {otMonth:otMonth,department:department,section:section,emp_code:emp_code} })
                 console.log(this.$route.query.otMonth);
             },*/
            onReset() {
                 // Reset our form values
                this.show = false;
                this.$nextTick(() => {
                    this.show = true;
                    this.actualOvertime = {};
                    this.selectedEmployee = null;
                    if(this.tableDataAllowancs.items){
                        this.tableDataAllowancs.items =[];
                        this.totalList='';
                    }

                })
            }
        }
    };
</script>
<style>
    /*.ot-act-form td:nth-child(7) {*/
    /*    text-align: right;*/
    /*}*/

    /*.ot-act-form td:nth-child(8) {*/
    /*    text-align: right;*/
    /*}*/

    .ot-btn.disabled, .ot-btn.disabled a, :disabled.ot-btn, :disabled.ot-btn a {
        background-color: #757575 !important;
    }
</style>
