<template>
    <b-container fluid>
        <b-form @submit.prevent="onSearchData" @reset.prevent="onReset">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">Unregistered Overtime Search</b-card-header>
                <b-card-body class="border">
                    <b-row>
                        <b-col md="3">
                            <label for="departmentID">Department</label>
                            <b-form-select id="departmentID" v-model="irregularOvertime.department"
                                           :options="departmentList"></b-form-select>
                        </b-col>
                        <b-col md="3">
                            <label for="otMonth">Month</label>
                            <b-form-select id="otMonth" v-model="irregularOvertime.otMonth" required :options="otMonths"
                                           @input="otMonthSlab"></b-form-select>
                        </b-col>
                        <b-col md="3">
                            <label for="otMonthSlab">Month Slab</label>
                            <b-form-select id="otMonthSlab" v-model="irregularOvertime.otMonthSlab" required
                                           :options="otMonthsSlabs"></b-form-select>
                        </b-col>
                        <b-col md="3">
                            <label>Employee</label>
                            <v-select
                                label="option_name"
                                v-model="selectedEmployee"
                                :options="empIdList"
                                @search="searchempcods">
                            </v-select>
                        </b-col>
                    </b-row>
                    <b-row class="mt-2">
                        <b-col class="d-flex justify-content-end ">
                            <b-button type="submit" class="btn btn-dark shadow mr-1 mb-1">Search</b-button> &nbsp;
                            <b-button type="reset" class="btn btn-outline-dark  mb-1">Reset</b-button>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-card>
        </b-form>

        <div v-if="items.length>0"><a class="btn btn-primary" target="_blank" :href="'/report/render?xdo=/~weblogic/OT/Unassign_OT.xdo&p_ot_month_detail_id='+irregularOvertime.otMonthSlab+'&p_department_id='+irregularOvertime.department+'&type=pdf&filename=unregister_ot'">PDF</a><a class="btn btn-info" target="_blank" :href="'/report/render?xdo=/~weblogic/OT/Unassign_OT.xdo&p_ot_month_detail_id='+irregularOvertime.otMonthSlab+'&p_department_id='+irregularOvertime.department+'&type=xlsx&filename=unregister_ot'">Excel</a></div>
        <b-card title="Unregistered Overtime Approval list" class="ot-irr-form">
            <b-card-text>
                <b-form-checkbox
                    v-model="allSelected"
                    :indeterminate="indeterminate"
                    aria-describedby="items"
                    aria-controls="items"
                    @change="toggleAll"
                    class="all-select"
                >
                </b-form-checkbox>
                <Datatable v-bind:fields="fields" :totalList="totalList" :perPage="perPage" v-bind:items="items"
                           v-bind:pageColSize="4" v-bind:searchColSize="5">
                    <template v-slot:action2="{ rows }">
                        <b-form-checkbox
                            :disabled="isFromDisable"
                            v-model="selectCheckbox"
                            :value="rows.item.attendance_id"
                            stacked
                        ></b-form-checkbox>
                    </template>
                </Datatable>
                <b-row class="mt-2">
                    <b-col class="d-flex justify-content-end ">
                        <b-button type="submit" @click="unRegisteredOT" class="btn btn-dark shadow  mb-1">Submit
                        </b-button>
                    </b-col>
                </b-row>
            </b-card-text>
        </b-card>
    </b-container>
</template>

<script>
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../../layouts/common/datatable';
    import ApiRepository from "../../../Repository/ApiRepository";

    export default {
        components: {DatePicker, Datatable, Vue, vSelect, vcss},
        data() {
            return {
                dateValueType: this.dateFormatter(),
                empIdList: [],
                selectedEmployee: {},
                isFromDisable: false,
                otMonths: {},
                otMonthsSlabs: {},
                irregularOvertime: {},
                departmentList: [],
                selectCheckbox: [],
                allSelected: false,
                indeterminate: false,
                perPage: 5,
                totalList: 0,
                fields: [
                    {key: 'action2', label: '', variant: ""},
                    {key: 'index', label: 'Sl', sortable: true},
                    {key: 'emp_code', sortable: true},
                    {key: 'emp_name', sortable: true},
                    {key: 'designation', sortable: true, label: 'Designation'},
                    {key: 'shift_code', sortable: true, label: 'shift'},
                    {
                        key: 'roster_date', formatter: value => {
                            if (value) {
                                return moment(value).format('DD-MM-YYYY');
                            }
                        }, label: 'roster date', sortable: true
                    },
                    {
                        key: 'in_time', label: 'In Time', formatter: value => {
                            if (value) {
                                return moment(value).format('h:mm:ss A');
                            }
                        }, sortable: true
                    },
                    {
                        key: 'out_time', label: 'Out Time', formatter: value => {
                            if (value) {
                                return moment(value).format('h:mm:ss A');
                            }
                        }, sortable: true
                    },
                    {key: 'ot_hour', label: 'OT Hours', sortable: true}],
                items: [],
            };
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
            selectedEmployee: function (val, oldVal) {
                if (val !== null) {
                    this.irregularOvertime.emp_id = val.emp_id;
                }
            }

        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Irregular Overtime"});
            this.allDatalistShow();

        },

        methods: {
            toggleAll(checked) {
                if (this.allSelected == false) {
                    this.allSelected = false;
                    this.indeterminate = false;
                    for (let i in this.items) {
                        this.selectCheckbox.push(this.items[i].attendance_id);
                    }
                } else {
                    this.allSelected = true;
                    this.indeterminate = true;
                    this.selectCheckbox = [];
                }
            },
            allDatalistShow() {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/overtime/ot-actuals').then(res => {
                    this.departmentList = res.data.departments;
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
                let dptId = this.irregularOvertime.department;
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-irregulars/emp-info/${id}/${dptId}`, this.irregularOvertime).then(res => {
                        this.empIdList = res.data.empcodeList;
                    })
                }
            },
            otMonthSlab() {
                let id = this.irregularOvertime.otMonth;
                let dptId = this.irregularOvertime.department;
                if (id) {
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-irregulars/${id}/${dptId}`, this.irregularOvertime).then(res => {
                        this.otMonthsSlabs = res.data.otMontSlabs;
                    })
                }
            },
            onSearchData() {
                let currObj = this;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-irregulars/search', this.irregularOvertime).then(res => {
                    if (res.data.otUnregister.length > 0) {
                        if (res.data.status) {
                            this.items = res.data.otUnregister;
                        }
                    } else {
                        this.items = [];
                        currObj.$notify({group: 'pmis', text: 'Sorry! No data found', type: 'error'});
                    }
                    this.totalList = res.data.otUnregister.length;
                    return;

                });
            },
            unRegisteredOT() {
                let currObj = this;
                let empId = this.selectCheckbox;
                //console.log(empId);
                let data = {};
                data.items = this.items.filter(function (item, index) {
                    return empId.includes(item.attendance_id);
                });
                if (this.selectCheckbox.length > 0) {
                    ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-irregulars', data).then(res => {
                        if (res.data.o_status_code == 1) {
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                            //this.onSearchData();
                        } else {
                            currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                        }
                    });
                } else {
                    currObj.$notify({group: 'pmis', text: 'Please select a Employee', type: 'error'});
                }
            },
            onReset() {
                this.show = false;
                this.$nextTick(() => {
                    if(this.items){
                        this.items =[];
                        this.totalList='';
                    }
                    this.show = true;
                    this.irregularOvertime = {};
                    this.selectedEmployee = null;
                })
            }
        }
    };
</script>
<style>

    .ot-irr-form .all-select {
        top: 127px;
        position: absolute;
        left: 30px;
        z-index: 111;
    }
</style>
