<template>

    <b-container fluid>
        <b-card title="Employee Wise Actual Time Setup">
            <b-card-text>
                <b-row>
                    <b-col md="3">
                        <b-form-group>
                            <b-row>
                                <b-col md="4">
                                    <label>Emp Code</label>
                                </b-col>
                                <b-col md="8">
                                    <b-form-input v-model="emp_code" disabled></b-form-input>
                                </b-col>
                            </b-row>
                        </b-form-group>

                    </b-col>
                    <b-col md="3">
                        <b-form-group>
                            <b-row>
                                <b-col md="4">
                                    <label>Employee Name</label>
                                </b-col>
                                <b-col md="8">
                                    <b-form-input v-model="emp_name" disabled></b-form-input>
                                </b-col>
                            </b-row>
                        </b-form-group>

                    </b-col>
                    <b-col md="3">
                        <b-form-group>
                            <b-row>
                                <b-col md="4">
                                    <label>Department</label>
                                </b-col>
                                <b-col md="8">
                                    <b-form-input v-model="department_name" disabled></b-form-input>
                                </b-col>
                            </b-row>
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group>
                            <b-row>
                                <b-col md="4">
                                    <label>Designation</label>
                                </b-col>
                                <b-col md="8">
                                    <b-form-input v-model="designation" disabled></b-form-input>
                                </b-col>
                            </b-row>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="3">
                        <b-form-group>
                            <b-row>
                                <b-col md="4">
                                    <label>Registered Hours</label>
                                </b-col>
                                <b-col md="8">
                                    <b-form-input v-model="register_hour" disabled></b-form-input>
                                </b-col>
                            </b-row>
                        </b-form-group>
                    </b-col>

                    <b-col md="3">
                        <b-form-group>
                            <b-row>
                                <b-col md="4">
                                    <label>Approved Hours</label>
                                </b-col>
                                <b-col md="8">
                                    <b-form-input v-model="approve_hour" disabled></b-form-input>
                                </b-col>
                            </b-row>
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group>
                            <b-row>
                                <b-col md="4">
                                    <label>current ot Status</label>
                                </b-col>
                                <b-col md="8">
                                    <b-form-input v-model="ot_status"  disabled></b-form-input>
                                </b-col>
                            </b-row>
                        </b-form-group>
                    </b-col>
                    <b-col md="3">
                        <b-form-group>
                            <b-row>
                                <b-col md="4">
                                    <label>Date Range</label>
                                </b-col>
                                <b-col md="8">
                                    <b-form-input v-model="roster_date_range" disabled></b-form-input>
                                </b-col>
                            </b-row>
                        </b-form-group>
                    </b-col>
                </b-row>
            </b-card-text>
        </b-card>
        <b-row class="empWiseOT">
            <b-col md="12" >
                <b-card title="Employee Wise Actual Overtime Details">
                    <b-row>
                        <b-col md="4">
                            <label  class="float-left sign-label">Legend:</label>
                            <div  class="table-danger btn-sm float-left">&nbsp;</div>
                            <label class="float-left sign-label" >Holiday</label>
                            <div  class="table-success btn-sm float-left">&nbsp;</div>
                            <label class="float-left sign-label" >Weekend</label>
                        </b-col>
                        <b-col md="4" offset-md="4">
                            <label  class="float-left sign-label">Status:</label>
                            <label  class="table-info float-left sign-label">&nbsp;{{ot_status}}</label>
                        </b-col>
                    </b-row>
                    <b-card-text>
                        <!--b-form-checkbox
                            v-model="allSelected"
                            :indeterminate="indeterminate"
                            aria-describedby="items"
                            aria-controls="items"
                            @change="toggleAll"
                            class="all-select"
                        >
                        </b-form-checkbox-->
                        <Datatable v-bind:fields="permittedFields" :totalList="totalList" :perPage="perPage"
                                   :tbodyTrClass="rowClass" v-bind:items="items" v-bind:pageColSize="4"
                                   v-bind:searchColSize="5">
                            <!--template v-slot:action2="{ rows }">
                                <b-form-input type="number" :disabled="rows.item.ot_status==2" :max="3"
                                              v-model="rows.item.edit_actual_hour"></b-form-input>
                            </template-->
                            <!--template v-slot:action3="{ rows }">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" v-if="rows.item.ot_status != 2" type="checkbox"
                                           :disabled="isFromDisable" v-model="selectCheckbox"
                                           :value="rows.item.ot_register_dtl_id" @change="manageState"
                                           :id="`special-hour-enable-checkbox-${rows.item.ot_register_dtl_id}`"/>
                                    <label class="custom-control-label"
                                           :for="`special-hour-enable-checkbox-${rows.item.ot_register_dtl_id}`"></label>
                                </div>
                            </template-->
                            <template v-slot:action3="{ rows }">
                                <b-form-checkbox :disabled="rows.item.ot_status==2"
                                                 :id="'p_'+rows.item.ot_register_dtl_id"
                                                 v-model="rows.item.reconsider_flag"
                                                 :name="'p_'+rows.item.ot_register_dtl_id"
                                                 :value=1></b-form-checkbox>
                            </template>
                            <!--template v-slot:action4="{ rows }">
                                <b-form-input :ref="`special-hours-${rows.item.ot_register_dtl_id}`" type="number"
                                              :max="3" disabled v-model="rows.item.edit_special_hour"></b-form-input>
                            </template-->
                            <template v-slot:action4="{ rows }">
                                <b-form-input class="number_input" :disabled="rows.item.ot_status==2 || rows.item.reconsider_flag==0" type="number"  :max="3"
                                              v-model="rows.item.edit_special_hour"></b-form-input>
                            </template>
                            <template v-slot:action5="{ rows }">
                                <b-form-select v-if="rows.item.ot_status != 2" v-model="rows.item.edit_ot_status"
                                               :options="otStatus" :disabled="hasPermission('CAN_OT_ACTUAL_DEPT_HEAD')==false"></b-form-select>
                                <label v-else-if="rows.item.ot_status ==2">Processed</label>
                            </template>
                            <template v-slot:action6="{ rows }">
                                <b-form-input :disabled="rows.item.ot_status==2" type="text"
                                              v-model="rows.item.remarks"></b-form-input>
                            </template>
                        </Datatable>
                        <b-row class="mt-2">
                            <b-col class="d-flex justify-content-end ">
                                <b-button type="submit" @click="overtimeApprovalSubmit"
                                          class="btn btn-dark shadow mr-1  mb-1">Submit
                                </b-button>
                                <b-button type="reset" @click="exitActualOvertime" class="btn btn-outline-dark  mb-1">
                                    Exit
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-card-text>
                </b-card>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    import Vue from 'vue';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';
    import moment from 'moment';
    import DatePicker from "vue2-datepicker";
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from "../../Repository/ApiRepository";

    export default {
        components: {DatePicker, Datatable, Vue, vSelect, vcss},
        props: ['id'],
        data() {
            return {
                actualTime: {},
                emp_code: '',
                emp_name: '',
                department_name: '',
                register_hour: '',
                designation: '',
                approve_hour: '',
                ot_month_id: '',
                dpt_department_id: '',
                ot_status: '',
                roster_date_range: '',
                otStatus: [{text: 'Hold', value: 1}, {text: 'On Process', value: 0}, {
                    text: 'Process',
                    value: 2
                }, {text: 'Reject', value: -1}],
                isFromDisable: false,
                selectCheckbox: [],
                allSelected: false,
                authAssign: true,
                indeterminate: false,
                perPage: 31,
                totalList: 0,
                permittedFields: [],
                fields: [{key: 'index', sortable: true, label: 'Sl',},
                    {
                        key: 'roster_date', formatter: value => {
                            if (value) {
                                return moment(value).format('DD/MM/YYYY');
                            }
                        }, label: 'Date'
                    },
                    {key: 'wday', label: 'Day', sortable: true},
                    {key: 'shift', label: 'Shift', sortable: true},
                    {key: 'approve_hour', label: 'Appd Hours', sortable: true},
                    // {key: 'attendence_hour', label: 'Attd. Hours', sortable: true},
                    {key: 'ot_hour', label: 'Actual Hours ', class: 'actual_hour_width'},
                    {key: 'action3', label: 'alw', sortable: true, variant: "", class: 'check_box'},
                    {key: 'action4', label: 'Reconsider Hours', class: 'actual_hour_width'},
                    {key: 'action5', label: 'Ot Status' },
                    {key: 'action6', label: 'Comment'}
                ],
                items: [],
            };
        },

        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "Overtime"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Actual Overtime"});
            this.loadData();
        },
        watch: {
            selectCheckbox(newVal, oldVal) {
                // Handle changes in individual flavour checkboxes
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

            }
        },

        methods: {
            manageState(e) {
                let refName = `special-hours-${e.target.value}`;
                if (e.target.checked) {
                    this.$refs[refName].$el.removeAttribute('disabled');
                } else {
                    this.$refs[refName].$el.setAttribute('disabled', '');
                }
            },
            rowClass(item, type) {
                if (item) {
                    if (item.off_day_yn !== null && item.off_day_yn === 'Y') return 'table-success'
                    if (item.holiday_yn !== null && item.holiday_yn === 'Y') return 'table-danger'
                }
            },
            toggleAll(checked) {
                //console.log('here',checked);
                //this.selectCheckbox = checked ? this.items.slice() : []
                if (this.allSelected == false) {
                    this.allSelected = false;
                    this.indeterminate = false;
                    for (let i in this.items) {
                        this.selectCheckbox.push(this.items[i].ot_register_dtl_id);
                    }
                } else {
                    this.allSelected = true;
                    this.indeterminate = true;
                    this.selectCheckbox = [];
                }
            },
            loadData: function () {
                let that = this;
                let permission = this.hasPermission("CAN_OT_ACTUAL_DEPT_HEAD");
                this.fields.forEach(function (i) {
                    if (i.key == "action4") {
                        if (permission)
                            that.permittedFields.push(i);
                    }  else {
                        that.permittedFields.push(i);
                    }
                });
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-actuals/${this.id}`).then(res => {
                    if (res.data.actualTimeEmpInfo[0] && (res.data.actualTimeEmpInfo[0] !== undefined)) {
                        this.emp_code = res.data.actualTimeEmpInfo[0].emp_code;
                        this.emp_name = res.data.actualTimeEmpInfo[0].emp_name;
                        this.department_name = res.data.actualTimeEmpInfo[0].department_name;
                        this.register_hour = res.data.actualTimeEmpInfo[0].register_hour;
                        this.designation = res.data.actualTimeEmpInfo[0].designation;
                        this.approve_hour = res.data.actualTimeEmpInfo[0].approve_hour;
                        this.ot_month_id = res.data.actualTimeEmpInfo[0].ot_month_id;
                        this.ot_status = res.data.actualTimeEmpInfo[0].ot_status;
                        this.roster_date_range = res.data.actualTimeEmpInfo[0].roster_date_range;
                    }
                });

                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/overtime/ot-actual-time-slab/${this.id}`).then(res => {
                    this.items = res.data.actualSlab;
                    this.totalList = res.data.actualSlab.length;

                });
            },

            overtimeApprovalSubmit(evt) {
                evt.preventDefault();
                let currObj = this;
                let param = this.items;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/overtime/ot-actuals', param).then(res => {
                    if (res.data.o_status_code == 1) {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'success'});
                        this.$router.push({
                            path: '/over-time-actual', query: {
                                otMonth: res.data.ot_month_id
                            }
                        });
                    } else {
                        currObj.$notify({group: 'pmis', text: res.data.o_status_message, type: 'error'});
                    }
                });

            },
            exitActualOvertime() {
                let Q_otMonth = this.ot_month_id;
                this.$router.push({path: '/over-time-actual', query: {otMonth: Q_otMonth}})
            },
            hasPermission: function (key) {
                if (this.$store.getters.hasGrantAccess)
                    return this.$store.getters.hasGrantAccess;
                return this.$store.getters.permissions.includes(key);
            }
        }
    };
</script>
<style scoped>
    .sign-label {padding: 4px 6px 3px 3px;}
    .btn-sm {
        padding: 0.467rem 1.2rem;
        font-size: 1.8rem;
        line-height: 0.4;
        border-radius: 0.267rem;
    }
    .actual_hour_width {
        width: 150px !important;
    }

    .check_box {
        width: 50px !important;
    }

    .roster-group {
        position: relative;
    }

    /*.empWiseOT td:nth-child(8) .form-control {*/
    /*    text-align: right;*/
    /*}*/
    .number_input {width:143px;}

</style>
