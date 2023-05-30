<template>
    <b-container fluid>
        <b-card class="ovetimeProcessApproval" title="Overtime Process Approval List">
            <b-card-text>
                <!-- <b-button type="submit" @click="selectAll" v-model="allSelected" class="btn btn-dark shadow mr-1 mb-1">{{btn_name}}</b-button> &nbsp; -->
                <!-- <a target="_blank" :href="'/report/render?xdo= /~weblogic/OT/OT_DETAILS.xdo&P_Month='+month+'&type=pdf&filename=ot&p_Dept='+department" class="btn shadow mr-1 mb-1 btn-primary">Pdf report</a> &nbsp;
                <a target="_blank" :href="'/report/render?xdo= /~weblogic/OT/OT_DETAILS.xdo&P_Month='+month+'&type=xlsx&filename=ot&p_Dept='+department" class="btn shadow mr-1 mb-1 btn-primary">Excel report</a> &nbsp;
                 -->
<!--                <Datatable v-bind:fields="tableData.fields" :totalRows="totalRows" :perPage="perPage"-->
<!--                           v-bind:items="tableData.items" v-bind:pageColSize="4" v-bind:searchColSize="5">-->
                <Datatable v-bind:fields="tableData.fields" :totalList="totalRows" :perPage="perPage"
                           v-bind:items="tableData.items">
                    <!-- <template v-slot:action4="{ rows }">
                            <b-form-checkbox
                            v-model="selectCheckbox"
                            name="checkbox[]"
                            :value="rows.item.ot_register_id"
                            >
                            </b-form-checkbox>
                    </template> -->
                    <template v-slot:action2="{ rows }">
                        {{rows.index + 1}}
                    </template>
                    <template v-slot:action3="{ rows }">
                        <button class="btn btn btn-dark shadow mr-1 mb-1 btn-secondary" @click="detailsRow(rows.item)">
                            Details
                        </button>
                    </template>
                </Datatable>

                <b-modal v-model="show"
                         :title="'Employee Details'"
                         ref="modal"
                >
                    <form ref="form" @submit.stop.prevent="">
                        <div>
                            <b-table-simple hover small responsive>
                                <b-tbody>
                                    <b-tr>
                                        <b-th style="border-top: 0px solid #DFE3E7;">Employee name:</b-th>
                                        <b-td>{{otProcess.emp_name}}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>Employee Code:</b-th>
                                        <b-td>{{otProcess.emp_code}}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>Department:</b-th>
                                        <b-td>{{otProcess.department_name}}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>Designation:</b-th>
                                        <b-td>{{otProcess.designation}}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>Basic Amount:</b-th>
                                        <b-td>{{otProcess.basic_amt}}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>Approve Hour:</b-th>
                                        <b-td>{{otProcess.approve_hour}}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>Actual Hour:</b-th>
                                        <b-td>{{otProcess.actual_hour}}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>Rate:</b-th>
                                        <b-td>{{otProcess.ot_rate}}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>Amount:</b-th>
                                        <b-td>{{otProcess.amount}}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>Status:</b-th>
                                        <b-td>{{otProcess.approve_status == 0 ? 'Pending' : 'Approved'}}</b-td>
                                    </b-tr>
                                </b-tbody>
                            </b-table-simple>
                        </div>
                        <!--                                                    <b-form-group-->
                        <!--                                                            label="Employee name"-->
                        <!--                                                            label-for="name-input">-->

                        <!--                                                    </b-form-group>-->


                    </form>
                </b-modal>
                <!-- <b-row class="mt-3">
                    <b-col class="d-flex justify-content-end ">
                        <b-button type="submit" @click="overtimeApprovalSubmit" class="btn btn-dark shadow mr-1 mb-1">Approve</b-button> &nbsp;
                        <b-button type="reset" class="btn btn-outline-dark  mb-1">Cancel</b-button>
                    </b-col>
                </b-row> -->
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
    import Datatable from '../../../layouts/common/datatable_store';
    import ApiRepository from "../../../Repository/ApiRepository";

    export default {
        props: ['dep', 'sec', 'date', 'dptName', 'monthName'],
        components: {DatePicker, Datatable, Vue, vSelect, vcss},
        data() {
            return {
                selectCheckbox: [],
                month: this.monthName,
                department: this.dptName,
                perPage: 15,
                totalRows: 0,
                dateValueType: this.dateFormatter(),
                otProcess: {
                    emp_name: '',
                    department_name: '',
                    designation: '',
                    basic_amt: '',
                },
                otProcessApproval: {
                    department_id: this.dep,
                    section_id: this.sec,
                    fromdate: this.fromdate,
                    todate: this.todate,
                    month_id:this.monthName
                },
                approvalList: [],
                empIdList: [],
                emp_code: {},
                btn_name: 'Check All',
                show: false,
                allSelected: true,
                selectedEmployee: {},
                overtimeapproval: {},
                approval: [{
                    approvedOtHours: [],
                    registerApproval: [],
                }],
                departmentList: [{text: 'Select One', value: null}, 'Finance & Accounting', 'Administration'],
                sectionList: [{text: 'Select One', value: null}, 'Computer', 'Billing'],
                approvedOThour: '',

                approvedStatusList: [
                    {value: 1, text: 'Approved'},
                    {value: 0, text: 'Reject'}
                ],
                tableData: {
                    fields: [
                        {key: 'action2', label: 'SL'},
                        {key: 'emp_code', sortable: true},
                        {key: 'emp_name', label: 'Name', sortable: true},
                        {key: 'designation', sortable: true, label: 'Designation'},
                        {key: 'basic_amt', sortable: true, label: 'Basic', class: 'text-right'},
                        {
                            key: 'reg_ot_rate',
                            label: 'Regular OT Rate',
                            sortable: true,
                            class: 'text-right',
                            formatter: value => {
                                return Number(value).toFixed(3)
                            }
                        },
                        {
                            key: 'off_ot_rate',
                            label: 'Offday OT Rate',
                            sortable: true,
                            class: 'text-right',
                            formatter: value => {
                                return Number(value).toFixed(3)
                            }
                        },
                        {key: 'reg_app_hour', label: 'Regular OT HR', sortable: true},
                        {key: 'reg_actual_hour', label: 'Regular Actual HR', sortable: true},
                        {key: 'off_app_hour', label: 'Offday OT HR', sortable: true},
                        {key: 'off_actual_hour', label: 'Offday Actual HR', sortable: true},
                        {key: 'reg_amount', label: 'Regular TK', sortable: true, class: 'text-right'},
                        {key: 'off_amount', label: 'Offday TK', sortable: true, class: 'text-right'},
                        {key: 'total_amount', label: 'Total TK', sortable: true, class: 'text-right'},
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
            this.allDatalistShow();
        },

        methods: {
            detailsRow(data) {
                this.otProcess = data;
                this.show = true;
            },
            allDatalistShow() {
                //alert(this.otProcessApproval.department_id +" "+this.otProcessApproval.section_id);

                //alert(this.otProcessApproval.monthYear);
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-process-approval/search_result', this.otProcessApproval).then(res => {
                    this.tableData.items = res.data.table_info;
                    this.totalRows = res.data.table_info.length;
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
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-approvals/emp-info/${id}/${dptId}`, this.overtimeapproval).then(res => {
                        this.empIdList = res.data.empcodeList;
                    })
                }
            },
            onSearchData(evt) {
                this.overtimeapproval.emp_code = this.selectedEmployee.emp_code;
                evt.preventDefault();
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-approvals/search', this.overtimeapproval).then(res => {
                    this.tableData.items = res.data;
                    this.totalRows = res.data.length;
                });
            },
            overtimeApprovalSubmit(evt) {
                evt.preventDefault();
                let currObj = this;
                if (this.selectCheckbox.length > 0) {
                    if (confirm('Are you want to approve?')) {
                        //console.log(this.selectCheckbox);
                        let param = this.selectCheckbox; //this.tableData.items;
                        ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-process-approval', param).then(res => {
                            // console.log(res.data);
                            if (res.data.status.o_status_code == 1) {
                                currObj.$notify({
                                    group: 'pmis',
                                    text: res.data.status.o_status_message,
                                    type: 'success'
                                });
                                this.selectCheckbox = [];
                                this.tableData.items = res.data.approves;

                            } else {
                                currObj.$notify({
                                    group: 'pmis',
                                    text: res.data.status.o_status_message ? res.data.status.o_status_message : 'All employee already approved',
                                    type: 'error'
                                });
                            }
                        });
                    }
                } else {
                    currObj.$notify({group: 'pmis', text: 'Please select a person', type: 'error'});
                }
            },
            selectAll() {
                this.selectCheckbox = [];
                if (this.allSelected == true) {
                    this.allSelected = false;
                    this.btn_name = 'Uncheck All';
                    for (let i in this.tableData.items) {
                        this.selectCheckbox.push(this.tableData.items[i].ot_register_id);
                    }
                } else {
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
                this.overtimeapproval.fromDate = '';
                this.overtimeapproval.endDate = '';
                // Trick to reset/clear native browser form validation state
                this.show = false;
                this.$nextTick(() => {
                    this.show = true
                })
            }
        }
    };
</script>

<style> /* .ovetimeProcessApproval td:nth-child(6), .ovetimeProcessApproval td:nth-child(6), .ovetimeProcessApproval td:nth-child(5), */
/* .ovetimeProcessApproval td:nth-child(10), .ovetimeProcessApproval td:nth-child(11){
     text-align: right;
 }
   .ovetimeProcessApproval td:nth-child(9), .ovetimeProcessApproval td:nth-child(8), .ovetimeProcessApproval td:nth-child(7){
     text-align: center;
 } */
</style>
