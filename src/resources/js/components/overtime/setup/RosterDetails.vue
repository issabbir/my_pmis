<template>
    <div class="content-wrapper">
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Roster Master</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSearch" @reset.prevent="onResetSearch" v-if="show" data-vv-scope="search">
                        <b-row class="pull-top d-flex justify-content-between mt-1">

                            <b-col md="3">
                                <b-form-group class="requiredField" id="department_id" label="Department" label-for="department_id">
                                    <b-form-select @change="findGroups" class="form-control" id="department_id" name="department_id" v-model="rosterDetail.department_id" required v-validate="'required'">
                                        <option value="">Select Department</option>
                                        <option :value="department.value" v-for="department in departments">{{ department.text }}</option>
                                    </b-form-select>
                                    <span :style="errorMessage">{{ errors.first('search.department_id') }}</span>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group class="" id="section_id" label="Section" label-for="section_id">
                                    <b-form-select   class="form-control" id="section_id" name="section_id" v-model="rosterDetail.section_id" >
                                        <option value="">Select Section</option>
                                        <option :value="section.value" v-for="section in sections">{{ section.text }}</option>
                                    </b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group class="requiredField" id="month_id" label="Roster month" label-for="month_id">
                                    <b-form-select @change="findGroups" class="form-control" id="month_id" name="month_id" v-model="rosterDetail.month_id" required v-validate="'required'">
                                        <option value="">Select Roster Month</option>
                                        <option :value="month.value" v-for="month in months">{{ month.monthlabel }}</option>
                                    </b-form-select>
                                    <span :style="errorMessage">{{ errors.first('search.roster_month_id') }}</span>
                                </b-form-group>
                            </b-col>
                            <b-col md="3">
                                <b-form-group class="requiredField" id="group_id" label="Group" label-for="group_id">
                                    <b-form-select class="form-control" id="group_id" name="group_id" v-model="rosterDetail.group_id" required v-validate="'required'">
                                        <option value="">Select Group</option>
                                        <option :value="group.value" v-for="group in groups">{{ group.text }}</option>
                                    </b-form-select>
                                    <span :style="errorMessage">{{ errors.first('search.group_id') }}</span>
                                </b-form-group>
                            </b-col>
                            <b-col class="mt-2 d-flex justify-content-end">
                                <b-button md="6" size="md" class="btn-outline-dark" type="reset" :disabled="keepDisable">Cancel</b-button>&nbsp;
                                <b-button md="6" size="md" variant="dark" type="submit" :disabled="keepDisable">Get list</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </b-card-body>
            </b-card>
            <b-card v-if="items.length >  0">
                <b-card-header header-bg-variant="dark" header-text-variant="white">Roster Detail</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="onSubmit" @reset.prevent="onResetSubmit" v-if="show" data-vv-scope="submit">
                        <b-row>
                            <b-col md="4">
                                <b-form-group class="requiredField" id="month_slab_id" label="Month Slab" label-for="month_slab_id">
                                    <b-form-select class="form-control" id="month_slab_id" name="month_slab_id" v-model="rosterDetail.month_slab_id" :options="month_slabs" required v-validate="'required'"></b-form-select>
                                    <span :style="errorMessage">{{ errors.first('submit.month_slab_id') }}</span>
                                </b-form-group>
                            </b-col>
                            <b-col md="4">
                                <b-form-group class="requiredField" id="shift_id" label="Shift" label-for="shift_id">
                                    <b-form-select v-model="rosterDetail.shift_id" id="shift_id" name="shift_id" :options="shifts" required v-validate="'required'"></b-form-select>
                                    <span :style="errorMessage">{{ errors.first('submit.shift_id') }}</span>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col>
                                <Datatable v-bind:fields="fields"
                                        v-bind:items="items" :totalList="totalList" :perPage="perPage">
                                    <template v-slot:action2="{ rows }">
                                        {{rows.index + 1}}
                                    </template>
                                    <template v-slot:action2="{ rows }">
                                        <b-link ml="4" class="text-primary"
                                                @click="toggleDetails(rows.item)"  >
                                            <i class='bx bx-comment-dots'></i>
                                        </b-link>
                                    </template>
                                    <template v-slot:row-details="{ rows }" >

                                        <b-card>
                                            <b-card-body>
                                                <b-row class="d-flex justify-content-center">
                                                    <b-table :hover=false  :items="roserMonthDetails" :fields="['sl','roster_date','shift','available','remarks', 'action']">
                                                        <template v-slot:cell(action)="row" v-bind:row="row">
                                                            <slot name="actions" :rows="row">
                                                                <a href="javascript:void(0)" @click="moveShift(row)" title="Update shift and unavailbility"> <i class='bx bxs-edit'></i></a>
                                                            </slot>
                                                        </template>
                                                    </b-table>
                                                </b-row>
                                            </b-card-body>
                                        </b-card>
                                    </template>
                                </Datatable>
                            </b-col>
                        </b-row>
                        <b-row align-h="end">
                            <b-col md="2" class="mt-2 d-flex justify-content-end">
                                <b-button lg="6" size="md" variant="dark" type="submit":disabled="keepDisable">{{submitBtn}}</b-button>&nbsp;
                                <b-button lg="6" size="md" class="btn-outline-dark"  type="reset" :disabled="keepDisable">Cancel</b-button>
                            </b-col>
                        </b-row>

                    </b-form>
                </b-card-body>
            </b-card>

            <!--Make un available popup -->
            <b-modal v-model="unavailableModalshow"
                    ref="modal"
                    :title="'Change Roster for the date of '+selectedRow.roster_date"
                    @ok="makeUnavailableOk"
            >

                <form ref="form" @submit.stop.prevent="handleSubmit">
                    <b-form-group
                            label="Shift"
                            label-for="shift-select"
                    >
                        <b-form-select id="shift-select" v-model="selectedRow.shift_id" :options="shifts"></b-form-select>
                    </b-form-group>
                    <b-form-group label="Available?" label-for="radio-group-2">
                        <b-form-radio-group id="radio-group-2" v-model="selectedRow.active_yn" name="radio-sub-component">
                            <b-form-radio value="Y">Yes</b-form-radio>
                            <b-form-radio value="N">No</b-form-radio>
                        </b-form-radio-group>
                    </b-form-group>
                    <b-form-group
                            label="Reason"
                            label-for="reason-input"
                    >
                        <b-form-textarea
                                id="reason-input"
                                v-model="selectedRow.remarks"
                                placeholder="Enter something..."
                        ></b-form-textarea>
                    </b-form-group>
                </form>
            </b-modal>

            <b-card v-if="rosterlistitems.length >  0">
                <b-card-header header-bg-variant="dark" header-text-variant="white">Roster Detail List</b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent @reset.prevent v-if="show" data-vv-scope="submit">
                        <Datatable v-bind:fields="rosterlistfields" v-bind:sortBy="'ot_months_detail'" v-bind:items="rosterlistitems" :totalList="rosterlisttotalList" :perPage="rosterlistperPage">
                            <template v-slot:actions="{ rows }">
                                <b-link ml="4" class="text-primary"
                                        @click="editRow(rows.item)">
                                    <i class="bx bx-edit cursor-pointer"></i>
                                </b-link>
                            </template>
                        </Datatable>
                    </b-form>
                </b-card-body>
            </b-card>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    import vSelect from 'vue-select';
    //import Datatable from '../../../layouts/common/datatable';
    import Datatable from '../../../layouts/common/datatable_store';
    import ApiRepository from "../../../Repository/ApiRepository";

    export default {
        components: {Datatable, vSelect},
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Setup"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Roster details"});
            this.loadData();
        },
        watch: {
            'rosterDetail.month_id':function(val,oldVal) {
                this.groups = [];
            }
        },
        data() {
            return {
                sortBy: 'ot_months_detail',
                submitBtn: 'Save',
                keepDisable: false,
                errorMessage: {color: 'red'},
                rosterDetail: {
                    month_id: '',
                    department_id: '',
                    group_id: '',
                    shift_id: '',
                    month_slab_id: '',
                },
                show: true,
                months:[{value: '', monthlabel: 'Select Month'}],
                departments:[],
                sections:[],
                groups:[],
                month_slabs:[{value: '', text: 'Select Month Slab'}],
                shifts:[{value: '', text: 'Select Shift'}],
                fields:[
                    {key: 'index', label: 'SL', sortable:true},
                    {key: 'emp_code', label: 'Employee Code'},
                    {key: 'emp_name', label: 'Employee Name'},
                    {key: 'month_slab', label: 'Month Slab', formatter: value=> {
                            if(value.trim()=='') {
                                return 'Not Yet Selected';
                            }

                            return value;
                        }
                    },
                    {key: 'shift_name', label: 'Shift', formatter: value=> {
                            if(value.trim()=='') {
                                return 'Not Yet Selected';
                            }

                            return value;
                        }
                    },
                    {key: 'department_name', label: 'Department'},
                    {key: 'section_name', label: 'Section'},
                    {key: 'off_day', label: 'Off day'},
                    {key: 'action2', label: 'Action'}
                ],
                items:[],
                currentItems: [],
                totalList: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
                rosterlistfields:[
                    {key: 'roster_month', label: 'Roster Month', formatter: function(item) {
                            return moment().month(item.ot_month-1).year(item.ot_year).format('YYYY-MMMM');
                        },  sortable:true
                    },
                    {key: 'roster_group.group_name', label: 'Group'},
                    {key: 'ot_months_detail', label: 'Month slab', formatter: function(item) {
                            let effective_start_date = moment(item.effective_start_date).format('DD-MM-YYYY');
                            let effective_end_date = moment(item.effective_end_date).format('DD-MM-YYYY');

                            return effective_start_date+ ' - ' + effective_end_date;
                        },  sortable:true
                    },
                    {key: 'shift', label: 'Shift', formatter: function(item) {
                            let shift_code = item.shift_code;
                            let shift_start_time = item.shift_start_time;
                            let shift_end_time = item.shift_end_time;

                            return shift_code+ " ("+shift_start_time+" - "+shift_end_time+") ";
                        },  sortable:true
                    },
                    'action'
                ],
                rosterlistitems:[],
                rosterlisttotalList: 1,
                rosterlistcurrentPage: 1,
                rosterlistperPage: 5,
                rosterlistpageOptions: [5, 10, 15],
                rosterlistsortBy: '',
                rosterlistsortDesc: false,
                rosterlistsortDirection: 'asc',
                rosterlistfilter: null,
                rosterlistfilterOn: [],
                roserMonthDetails:[],
                selectedRow:{},
                unavailableModalshow: false

            }
        },
        methods: {
            onSearch() {
                this.$validator.validateAll('search').then(() => {
                    if (!this.errors.any()) {
                        ApiRepository.callApi(ApiRepository.GET_COMMAND, "/overtime/ot-roster-details/ot-roster-groups", {params: this.rosterDetail}).then(res => {
                            this.items = res.data.roster_groups;
                            this.totalList = res.data.roster_groups.length;
                            this.rosterlistitems = res.data.roster_details;
                            this.rosterlisttotalList = res.data.roster_details.length;
                            this.month_slabs = res.data.month_slabs;
                        });
                    }
                });
            },
            onSubmit() {
                this.$validator.validateAll('submit').then(() => {
                    if (!this.errors.any()) {
                        this.items = this.items.map((el) => {
                            let o = Object.assign({}, el);
                            o.month_id = this.rosterDetail.month_id;
                            o.month_slab_id = this.rosterDetail.month_slab_id;
                            o.shift_id = this.rosterDetail.shift_id;
                            return o;
                        });
                        this.keepDisable = true;
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, "/overtime/ot-roster-details", this.rosterDetail).then(res => {
                            if (res.data.o_status_code == 1) {
                                this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' })
                            } else{
                                this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                            }
                            this.loadData();
                            this.onSearch();
                            this.keepDisable = false;
                            this.submitBtn = "Save";
                            /*this.onReset();*/
                        });
                    }
                });
            },
            onResetSearch() {
                this.show = false;
                this.$nextTick(() => {
                    this.rosterDetail.month_id = '';
                    this.rosterDetail.department_id = '';
                    this.rosterDetail.group_id = '';
                    this.items = [];
                    this.rosterlistitems = [];
                    this.rosterlisttotalList = null;
                    this.show = true;
                })
            },
            onResetSubmit() {
                this.show = false;
                this.$nextTick(() => {
                    this.rosterDetail.month_slab_id = '';
                    this.rosterDetail.shift_id = '';
                    this.items = [];
                    this.rosterlistitems = [];
                    this.rosterlisttotalList = null;
                    this.show = true;
                    this.submitBtn = "Save";
                })
            },
            loadData() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/overtime/ot-roster-details').then(res => {
                    this.months = res.data.months;
                    this.departments = res.data.departments;
                    this.shifts = res.data.shifts;
                });
            },
            findGroups() {
                if(this.rosterDetail.month_id && this.rosterDetail.department_id) {
                    let section_id = this.rosterDetail.section_id ? this.rosterDetail.section_id : null;
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-roster-details/find-groups/${this.rosterDetail.month_id}/${this.rosterDetail.department_id}/${section_id}`).then(res => {
                        this.groups = res.data.groups;
                    });
                }
                if(this.rosterDetail.department_id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/section-by-department/${this.rosterDetail.department_id}`).then(res => {
                        this.sections = res.data;
                        // if (res.data.length == 1){
                        //     this.rosterDetail.section_id = res.data[0].value;
                        // }
                    });
                }
            },
            editRow(item) {
                this.submitBtn = "Update";
                this.rosterDetail.month_id = item.roster_month.ot_month_id;
                this.rosterDetail.group_id = item.roster_group.ot_group_id;
                this.rosterDetail.month_slab_id = item.ot_months_detail.ot_month_detail_id;
                this.rosterDetail.shift_id = item.shift.shift_id;
                this.onSearch();
            },
            toggleDetails(row) {
                if(row._showDetails){
                    this.$set(row, '_showDetails', false)
                }else{
                    this.items.forEach(item => {
                        this.$set(item, '_showDetails', false)
                    });

                    this.$nextTick(() => {
                        if (row.month_slab_id) {
                            ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-roster-details/employee/${row.month_slab_id}/${row.emp_id}`).then(res => {
                                   this.roserMonthDetails = res.data;
                                   this.roserMonthDetails.forEach(function(item) {
                                        item._rowVariant = item._rowvariant;
                                   });
                            });
                        }
                        this.$set(row, '_showDetails', true)
                    })
                }
            },
            unAssigned(row) {
                this.selectedRow = row.item;
                this.unavailableModalshow = true;
            },
            moveShift(row) {
                this.selectedRow = row.item;
                this.unavailableModalshow = true;
            },
            makeUnavailableOk(bvModalEvt) {
                bvModalEvt.preventDefault();
                let shift;
                let shift_id = this.selectedRow.shift_id;
                this.shifts.forEach(function(val) {
                    if (val.value==shift_id) {
                        shift = val.text;
                    }
                });
                ApiRepository.callApi(ApiRepository.PUT_COMMAND, `/overtime/ot-roster-details/update`, this.selectedRow).then(res => {
                    if (res.data.o_status_code == 1) {
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'success' });
                        this.unavailableModalshow = false;
                        this.selectedRow.shift = shift;
                        this.selectedRow.available= (this.selectedRow.active_yn=="Y")?"Yes":'No';
                        this.selectedRow._rowVariant= (this.selectedRow.active_yn=="Y")?"":'danger';
                    } else{
                        this.$notify({ group: 'pmis', text: res.data.o_status_message, type:'error' })
                    }
                });
            }
        },
    }
</script>
<style>
    .pull-top {
        margin-top: -20px;
    }
</style>



<!--select	 "OT_ROSTER_V_1"."SHIFT_CODE" as "SHIFT_CODE",-->
<!--"OT_ROSTER_V_1"."OT_MONTH_NAME" as "OT_MONTH_NAME",-->
<!--"OT_ROSTER_V_1"."OT_YEAR" as "OT_YEAR",-->
<!--"OT_ROSTER_V_1"."GROUP_NAME" as "GROUP_NAME",-->
<!--"OT_ROSTER_V_1"."EMP_NAME" as "EMP_NAME",-->
<!--"OT_ROSTER_V_1"."DESIGNATION" as "DESIGNATION",-->
<!--"OT_ROSTER_V_1"."EMP_CODE" as "EMP_CODE",-->
<!--"OT_ROSTER_V_1"."DEPARTMENT_NAME" as "DEPARTMENT_NAME",-->
<!--"OT_ROSTER_V_1"."OFF_DAY" as "OFF_DAY",-->
<!--"OT_ROSTER_V_1"."PERMITED_DATE" as "PERMITED_DATE",-->
<!--"OT_ROSTER_V_1"."OT_CATEGORY" as "OT_CATEGORY",-->
<!--"OT_ROSTER_V_1"."REFF_VALUE" as "REFF_VALUE",-->
<!--"OT_ROSTER_V_1"."EFFECTIVE_START_DATE" as "EFFECTIVE_START_DATE",-->
<!--"OT_ROSTER_V_1"."EFFECTIVE_END_DATE" as "EFFECTIVE_END_DATE",-->
<!--"OT_ROSTER_V_1"."OT_MONTH_ID" as "OT_MONTH_ID"-->
<!--from	"PMIS"."OT_ROSTER_V" "OT_ROSTER_V_1"-->
<!--where   "OT_ROSTER_V_1"."GROUP_NAME"=nvl(:P_Group_Name, "OT_ROSTER_V_1"."GROUP_NAME")-->
<!--and "OT_ROSTER_V_1"."OT_MONTH_ID" =nvl(:P_month,"OT_ROSTER_V_1"."OT_MONTH_ID" )-->
<!--and "OT_ROSTER_V_1"."DEPARTMENT_ID" =NVL(:P_Dpt, "OT_ROSTER_V_1"."DEPARTMENT_ID" )-->
