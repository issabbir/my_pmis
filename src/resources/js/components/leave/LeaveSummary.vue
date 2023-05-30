<template>
    <div>
        <b-card>
            <b-card-header header-bg-variant="dark" header-text-variant="white">Employee Leave Summary</b-card-header>
            <b-card-body class="border">
                <b-form @submit="onSubmit">
                    <b-row>
                        <b-col md="4">
                            <b-form-group
                                    label-for="input-group-1"
                                    label="Leave Type"
                                    class="requiredField"
                                    label-cols-md="3">
                                <b-form-select for='input-group-1' required v-model="searchParams.type" :options="leaveTypes"></b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                    label-for="input-group-2"
                                    label="Leave Year"
                                    class="requiredField"
                                    label-cols-md="3">
                                <b-form-select v-model="searchParams.year" field-value="year" :options="years"></b-form-select>
                            </b-form-group>
                        </b-col>
                        <b-col md="4">
                            <b-form-group
                                label="Employee Code"
                                label-for="emp_id"
                                class="requiredField"
                                label-cols-md="3"
                            >
                                <v-select
                                    label="option_name"
                                    v-model="selectedEmployee"
                                    :options="employeeOptions"
                                    @search="searchEmployees">
                                    <template #search="{attributes, events}">
                                        <input
                                            class="vs__search"
                                            :required="selectedEmployee && selectedEmployee.emp_id==null"
                                            v-bind="attributes"
                                            v-on="events"
                                        />
                                    </template>
                                </v-select>
                            </b-form-group>
                        </b-col>

                    </b-row>
                    <b-row>
                        <b-col class="d-flex justify-content-end align-items-end">
                            <b-form-group>
                                <b-button type="submit" variant="primary"><i class='bx bx-search'></i> Search</b-button>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-form>
            </b-card-body>
        </b-card>

        <b-card v-if="totalItems">
            <b-card-header header-bg-variant="dark" header-text-variant="white">Leave Details
                <a :href="reportUrl" class="btn btn-success float-right" @click="renderPdf" target="_blank">Print</a>
            </b-card-header>
            <b-card-body class="border">
                <Datatable bordered v-bind:fields="columns" :totalList="totalItems" perPage="10" v-bind:items="listItems"  :primaryKeyColumnName="'emp_code'"></Datatable>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
    import Datatable from '../../layouts/common/datatable';
    import ApiRepository from '../../Repository/ApiRepository';
    import moment from 'moment';
    import vSelect from 'vue-select';
    import vcss from 'vue-select/dist/vue-select.css';

    export default {
        components: {vSelect, vcss, Datatable},
        data() {
            return {
                reportParams: {
                    xdo:'/~weblogic/Leave/M_LEAVE_SUMMARY_DETAILS.xdo',
                    type:"pdf",
                    p_leave_type_id  :'',
                    p_leave_year   :'',
                    p_emp_code   :'',
                    filename:'Employee Leave'
                },
                reportUrl:'',
                employeeOptions:[],
                selectedEmployee: {},
                searchParams: {
                    year:moment().format("YYYY"),
                    type:null,
                    emp_code: '',
                    emp_id: ''
                },
                listItems:[],
                totalItems:0,
                leaveTypes:[],
                years:[],
                columns: [
                    {
                        label: 'SL',
                        key: 'index',
                        sortable:true
                    },
                    {
                        label: 'Leave type',
                        key: 'leave_type',
                        sortable:true
                    },
                    {
                        label: 'Leave Days',
                        key: 'leave_days',
                        formatter: value => {
                            if(value && value > 1) {
                                return value+' Days'
                            } else if (value && value == 1){
                                return value+' Day'
                            } else {
                                return '0 Day'
                            }
                        },
                        sortable:true
                    },
                    {
                        label: 'Leave Enjoyed',
                        key: 'leave_enjoy',
                        sortable:true,
                        class: 'text-right',
                        formatter: value => {
                            if(value && value > 1) {
                                return value+' Days'
                            } else if (value && value == 1){
                                return value+' Day'
                            } else {
                                return '0 Day'
                            }
                        },
                    },
                    {
                        label: 'Leave Encashment',
                        key: 'leave_encashment_days',
                        sortable:true,
                        class: 'text-right',
                        formatter: (value, key, item) => {
                            if(value && value > 1) {
                                return value+' Days'
                            } else if (value && value == 1){
                                return value+' Day'
                            } else {
                                return ''
                            }
                        },
                    },
                    {
                        label: 'PRL Leave',
                        key: 'prl_leave_days',
                        class: 'text-right',
                        sortable:true,
                        formatter: (value, key, item) => {
                            if(value && value > 1) {
                                return value+' Days'
                            } else if (value && value == 1){
                                return value+' Day'
                            } else {
                                return ''
                            }
                        },
                    },
                    {
                        label: 'Leave Remaining',
                        key: 'remaining_balance',
                        class: 'text-right',
                        sortable:true,
                        formatter: value => {
                            if(value && value > 1) {
                                return value+' Days'
                            } else if (value && value == 1){
                                return value+' Day'
                            } else {
                                return '0 Day'
                            }
                        },
                    }
                ],
            };
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", { link: "#", label: "Leave-management" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "Leave Summary" });
            this.getFormData();
        },
        watch: {
            selectedEmployee:function (val, oldVal) {
                if(val){
                    this.searchParams.emp_code = val.emp_code
                    this.searchParams.emp_id = val.emp_id
                }
            }
        },
        beforeMount(){

        },
        methods: {
            renderPdf: function() {
                this.reportParams.p_leave_type_id = this.searchParams.type!=null?this.searchParams.type:''
                this.reportParams.p_leave_year = this.searchParams.year
                this.reportParams.p_emp_code = this.searchParams.emp_code
                let params = this.reportParams;
                let queryString = Object.keys(params).map(function(key) {
                    return  key+"="+params[key]
                }).join('&');

                this.reportUrl = '/report/render?'+queryString;
            },
            onSubmit: function(e) {
                e.preventDefault();
                this.search();
            },
            getFormData: function () {
                ApiRepository.callApi(ApiRepository.GET_COMMAND, '/leave/leave-summery-form-data').then(res => {
                    this.leaveTypes = res.data.leave_types;
                    this.years = res.data.leave_years;
                });
            },
            search: function() {
                let params = this.searchParams;
                ApiRepository.callApi(ApiRepository.POST_COMMAND, '/leave/leave-summery-search', params).then(res => {
                    this.listItems = res.data.list;
                    this.totalItems = res.data.total;
                });
            },
            searchEmployees(id){
                if(id && (id !== undefined)) {
                    let url = this.$store.getters.user.user_name == 'admin' ? `/leave/leave-entry/emp-info/${id}`:`/leave/leave-entry/emp-info/${id}/${this.$store.getters.user.department_id}`
                    ApiRepository.callApi(ApiRepository.GET_COMMAND, url).then(res => {
                        this.employeeOptions = res.data.empcodeList;
                    })
                }
            }
        }
    };
</script>
