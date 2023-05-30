<template>
        <div class="content-body">
            <b-card>
                <b-card-header header-bg-variant="dark" header-text-variant="white">
                    <div class="d-flex justify-content-between">
                        <span>My Attendance</span>
                        <a v-if="reportUrl" :href="reportUrl" target="_blank" class="btn btn-outline-success btn-sm">Print Report</a>
                    </div>
                </b-card-header>
                <b-card-body class="border">
                    <b-form @submit.prevent="loadAttendance">
                        <b-row>
                            <b-col md="5">
                                <b-form-group
                                    label="Year"
                                    label-for="year"
                                    label-cols-md="3"
                                >
                                    <b-form-select required id="year" :options="yearOptions" v-model="formData.year"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="5">
                                <b-form-group
                                    label="Month"
                                    label-for="month"
                                    label-cols-md="3"
                                >
                                    <b-form-select required id="month"
                                                   value-field="month_id" text-field="month_name"
                                                   :options="monthOptions" v-model="formData.month"></b-form-select>
                                </b-form-group>
                            </b-col>
                            <b-col md="2">
                                <b-button type="submit">Search</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                    <Datatable v-bind:items="items" :perPage="perPage" :tbodyTrClass="rowClass" :fields="fields" :totalList="totalList"></Datatable>
                    <ul class="legendColor">
                        <li><span class="color leave"></span> &nbsp;Leave</li>
                        <li><span class="color offday"></span> &nbsp;WEEKLY REST DAY</li>
                        <li><span class="color holiday"></span> &nbsp;Holiday</li>
                        <li><span class="color late"></span> &nbsp;Late</li>
                        <li><span class="color absent"></span> &nbsp;Absent</li>
                        <!--                                <li><span class="color late"></span> &nbsp;Late</li>-->
                    </ul>
                </b-card-body>
            </b-card>
        </div>
</template>

<script>
    import Datatable from "../../../layouts/common/datatable";
    import ApiRepository from "../../../Repository/ApiRepository";
    import moment from "moment";

    export default {
        name: "Attendance",
        components: {Datatable},
        data() {
            return {
                formData: {
                    month: '',
                    year: ''
                },
                fields: [
                    {key: 'index', label: 'Sl.', sortable: true},
                    {key: 'roster_date', label: 'Date', orderDate: true},
                    {key: 'roster_day', label: 'Day', orderDate: true},
                    {key: 'remarks', label: 'status', sortable: true},
                    {key: 'in_time', label: 'In Time', sortable: true},
                    {key: 'out_time', label: 'Out Time', sortable: true}
                ],
                items: [],
                perPage: 5,
                totalList: 1,
                yearOptions: [],
                monthOptions: [],
                emp_code: '',
                reportUrl:'',
                reportParams: {
                    xdo:'/~weblogic/pmis/RPT_EMP_WISE_ATTENDENCE_REPORT.xdo',
                    type:"pdf",
                    p_year:'',
                    p_month:'',
                    P_EMP_CODE:'',
                    filename:'EMP WISE ATTENDANCE REPORT'
                },
            }
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "dashboard", label: "Dashboard"});
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account", label: "My Account"});
            this.$store.commit("setBreadcrumb", {link: "dashboard/my-account/attendance", label: "My Attendance"});
            this.loadYear()
            this.loadMonth()
        },
        watch: {
            'formData.year':function(val, oldVal){
                if(val && this.formData.month){
                    this.loadAttendance()
                }
            },
            'formData.month':function(val, oldVal){
                if(val && this.formData.year){
                    this.loadAttendance()
                }
            }
        },
        methods: {
            loadAttendance() {
                this.items = []
                this.totalList = 1
                ApiRepository.callApi(ApiRepository.POST_COMMAND, `/pmis/api/attendance`, this.formData).then(result => {
                    console.log(result.data.data.emp_code)
                    this.emp_code = result.data.data.emp_code
                    if (result.data.data.attendance.length > 0){
                        this.items = result.data.data.attendance
                        this.totalList = this.items.length
                    }
                    this.renderPdf();
                        // else {
                    //     this.$notify({group: 'pmis', text: 'Sorry! you do not have any record.', type: 'error'});
                    // }
                });
            },
            loadYear(){
                const years = []
                const dateStart = moment('1900')
                const dateEnd = moment().subtract(1, 'years')
                while (dateEnd.diff(dateStart, 'years') >= 0) {
                    years.push(dateStart.format('YYYY'))
                    dateStart.add(1, 'year')
                }
                this.yearOptions = years.sort(function(a, b){return b-a})
                this.formData.year = moment().year()
            },
            loadMonth(){
                ApiRepository.callApi(ApiRepository.GET_COMMAND, `/pmis/api/month/list`, this.formData).then(result => {
                    this.monthOptions = result.data.data.months
                    this.formData.month = moment().format('MM')
                });
            },
            rowClass(item, type) {
                if (item) {
                    // //day when rest day
                    // if (item.row_highlight === 'R') return 'table-info'
                    // //day when leave
                    // if (item.row_highlight  === 'L') return 'table-primary'
                    // //day when holiday
                    // if (item.row_highlight  === 'H') return 'table-success'
                    // //day when late
                    // if (item.row_highlight  === 'T') return 'table-warning'
                    // //day when normal

                    //day when rest day
                    if (item.remarks === 'WEEKLY REST DAY') return 'table-info'
                    //day when leave
                    if (item.remarks  === 'LEAVE') return 'table-primary'
                    //day when holiday
                    if (item.remarks  === 'HOLIDAY') return 'table-success'
                    //day when late
                    if (item.remarks  === 'LATE') return 'table-warning'
                    //day when normal
                    if (item.remarks  === 'ABSENT') return 'table-danger'
                    //day when normal

                }
            },
            renderPdf: function() {
                this.reportParams.p_year = this.formData.year;
                this.reportParams.p_month = this.formData.month;
                this.reportParams.P_EMP_CODE = this.emp_code;
                let params = this.reportParams;
                let queryString = Object.keys(params).map(function(key) {
                    return  key+"="+params[key]
                }).join('&');
                this.reportUrl = '/report/render/EMP_WISE_ATTENDANCE_REPORT?'+queryString;
            }
        }
    }
</script>

<style scoped>
    .legendColor{
        display: inline-block;
        margin: 0;
        padding: 0;
    }
    .legendColor li{
        padding: 10px;
        list-style: none;
        display: inline;
    }
    .legendColor .color{
        border-radius: 5px;
        padding: 1px 10px;
    }
    .color.leave{
        background-color: #5a8dee;
    }
    .color.holiday{
        background-color: #98ECC2;
    }
    .color.offday{
        background-color: #7AE6ED;
    }
    .color.late{
        background-color: #FFBB33;
    }
    .color.absent{
        background-color: #FFB8B8;
    }
</style>
