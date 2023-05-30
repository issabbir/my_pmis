<template>
    <div class="mt-3">
        <div class="content-body">
            <div class="md-layout">
                <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-50">
                    <b-card>
                        <b-card-header header-bg-variant="dark" header-text-variant="white">Employee</b-card-header>
                        <b-card-body class="border">
                            <b-row>
                                <b-col>
                                    <b-table
                                        :responsive="true"
                                        :small="true"
                                        :sticky-header="true"
                                        :outlined="true"
                                        :no-border-collapse="true"
                                        :hover="true"
                                        :striped="true"
                                        :items="employeeDetails.items"
                                        :fields="employeeDetails.fields"
                                        :totalList="employeeDetails.totalList">
                                    </b-table>
                                </b-col>
                                <b-col>
                                    <b-table
                                        :responsive="true"
                                        :small="true"
                                        :sticky-header="true"
                                        :outlined="true"
                                        :no-border-collapse="true"
                                        :hover="true"
                                        :striped="true"
                                        :items="employeeDetails.itemsForGender"
                                        :fields="employeeDetails.fieldsForGender"
                                        :totalList="employeeDetails.totalListForGender">
                                        <template #cell(total)="data">
                                            {{ Number(data.item.officer) + Number(data.item.staff) }}
                                        </template>
                                    </b-table>
                                </b-col>
                            </b-row>

                        </b-card-body>
                    </b-card>
                    <b-card>
                        <b-card-header header-bg-variant="dark" header-text-variant="white">Cases</b-card-header>
                        <b-card-body class="border">
                            <b-row>
                                <b-col>
                                    <b-table
                                        :responsive="true"
                                        :small="true"
                                        :sticky-header="true"
                                        :outlined="true"
                                        :no-border-collapse="true"
                                        :hover="true"
                                        :striped="true"
                                        :items="caseDetails.items"
                                        :fields="caseDetails.fields"
                                        :totalList="caseDetails.totalList">
                                    </b-table>
                                </b-col>
                            </b-row>
                        </b-card-body>
                    </b-card>
                </div>
                <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-50">
                    <b-card title="">
                        <b-card-header header-bg-variant="dark" header-text-variant="white">Salary & Others</b-card-header>
                        <b-card-body class="border">
                            <b-row>
                                <b-col md="12">
                                    <BarChart :labels="employeeSalariesMonth" :data="employeeSalariesSeries" label="Monthly Salaries" background-color="#f87979"/>
                                </b-col>

                            </b-row>
                            <b-row class="mt-4">
                                <b-col md="12">
                                    <b-table
                                        :responsive="true"
                                        :small="true"
                                        :sticky-header="true"
                                        :outlined="true"
                                        :no-border-collapse="true"
                                        :hover="true"
                                        :striped="true"
                                        :items="salaryDetails.items"
                                        :totalList="salaryDetails.totalList">
                                    </b-table>
                                </b-col>
                            </b-row>
                        </b-card-body>
                    </b-card>

                </div>
                <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-25">
                    <chart-card
                        :chart-data="dailySalesChart.data"
                        :chart-options="dailySalesChart.options"
                        :chart-type="'Bar'"
                        data-background-color="blue"
                    >
                        <template slot="content">
                            <h4 class="title">Monthly Overtime</h4>
                            <p class="category">
                  <span class="text-success"
                  ><i class="fas fa-long-arrow-alt-up"></i> 55%
                  </span>
                                increase in today sales.
                            </p>
                            <b-form-select v-model="department" :options="departments"></b-form-select>
                        </template>

                        <template slot="footer">
                            <div class="stats">
                                <md-icon>access_time</md-icon>
                                updated 4 minutes ago
                            </div>
                        </template>
                    </chart-card>
                </div>
                <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-25">
                    <chart-card
                        :chart-data="emailsSubscriptionChart.data"
                        :chart-options="emailsSubscriptionChart.options"
                        :chart-responsive-options="emailsSubscriptionChart.responsiveOptions"
                        :chart-type="'Bar'"
                        data-background-color="red"
                    >
                        <template slot="content">
                            <h4 class="title">Monthly Payroll</h4>
                            <p class="category">
                                Last Campaign Performance
                            </p>
                            <b-form-select v-model="payrollDept" :options="departments"></b-form-select>
                        </template>

                        <template slot="footer">
                            <div class="stats">
                                <md-icon>access_time</md-icon>
                                updated 10 days ago
                            </div>
                        </template>
                    </chart-card>
                </div>
                <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-25">
                    <chart-card
                        :chart-data="dataCompletedTasksChart.data"
                        :chart-options="dataCompletedTasksChart.options"
                        :chart-type="'Bar'"
                        data-background-color="green"
                    >
                        <template slot="content">
                            <h4 class="title">Department Wise Employees</h4>
                            <p class="category">
                                Last Campaign Performance
                            </p>
                            <b-form-select v-model="empdpt" :options="departments"></b-form-select>
                        </template>

                        <template slot="footer">
                            <div class="stats">
                                <md-icon>access_time</md-icon>
                                campaign sent 26 minutes ago
                            </div>
                        </template>
                    </chart-card>
                </div>
                <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-25">
                    <chart-card
                        :chart-data="dataCompletedTasksChart.data"
                        :chart-options="dataCompletedTasksChart.options"
                        :chart-type="'Bar'"
                        data-background-color="orange"
                    >
                        <template slot="content">
                            <h4 class="title">Department Wise Employees</h4>
                            <p class="category">
                                Last Campaign Performance
                            </p>
                            <b-form-select v-model="empdpt" :options="departments"></b-form-select>
                        </template>

                        <template slot="footer">
                            <div class="stats">
                                <md-icon>access_time</md-icon>
                                campaign sent 26 minutes ago
                            </div>
                        </template>
                    </chart-card>
                </div>

                <div class="md-layout-item md-medium-size-50 md-xsmall-size-100 md-size-25">
                    <stats-card data-background-color="green">
                        <template slot="header">
                            <md-icon>store</md-icon>
                        </template>

                        <template slot="content">
                            <p class="category">Revenue</p>
                            <h3 class="title">BDT 1.2M</h3>
                        </template>

                        <template slot="footer">
                            <div class="stats">
                                <md-icon>date_range</md-icon>
                                Last 24 Hours
                            </div>
                        </template>
                    </stats-card>
                </div>
                <div class="md-layout-item md-medium-size-50 md-xsmall-size-100 md-size-25">
                    <stats-card data-background-color="orange">
                        <template slot="header">
                            <md-icon>content_copy</md-icon>
                        </template>

                        <template slot="content">
                            <p class="category">Total On Roll Employees</p>
                            <h3 class="title">
                                49/50
                                <small>GB</small>
                            </h3>
                        </template>

                        <template slot="footer">
                            <div class="stats">
                                <md-icon class="text-danger">warning</md-icon>
                                <a href="#pablo">Get More Space...</a>
                            </div>
                        </template>
                    </stats-card>
                </div>
                <div class="md-layout-item md-medium-size-50 md-xsmall-size-100 md-size-25">
                    <stats-card data-background-color="red">
                        <template slot="header">
                            <md-icon>info_outline</md-icon>
                        </template>

                        <template slot="content">
                            <p class="category">Total Absent</p>
                            <h3 class="title">75</h3>
                        </template>

                        <template slot="footer">
                            <div class="stats">
                                <md-icon>local_offer</md-icon>
                                Tracked from Github
                            </div>
                        </template>
                    </stats-card>
                </div>
                <div class="md-layout-item md-medium-size-50 md-xsmall-size-100 md-size-25">
                    <stats-card data-background-color="blue">
                        <template slot="header">
                            <i class="fab fa-twitter"></i>
                        </template>

                        <template slot="content">
                            <p class="category">Total Leave</p>
                            <h3 class="title">+245</h3>
                        </template>

                        <template slot="footer">
                            <div class="stats">
                                <md-icon>update</md-icon>
                                Just Updated
                            </div>
                        </template>
                    </stats-card>
                </div>

                <div class="md-layout-item md-medium-size-50 md-xsmall-size-100 md-size-50 mt-1">
                    <b-card>
                        <b-card-text>
                            <BarChart :labels="employeeSalariesMonth" :data="employeeSalariesSeries" label="Monthly Salaries" background-color="#f87979"/>
                        </b-card-text>
                    </b-card>
                </div>
                <div class="md-layout-item md-medium-size-50 md-xsmall-size-100 md-size-50 mt-1">
                    <b-card>
                        <b-card-text>
                            <PieChart :labels="departmentName" :data="numberOfEmployee" label="Department Wise Employee"/>
                        </b-card-text>
                    </b-card>
                </div>
                <div class="md-layout-item md-medium-size-50 md-xsmall-size-100 md-size-50">
                    <b-card>
                        <b-card-text>
                            <LineChart :labels="employeeSalariesMonth" :data="employeeSalariesSeries" label="Monthly Salaries"/>
                        </b-card-text>
                    </b-card>
                </div>
                <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-50">
                    <md-card>
                        <md-card-header data-background-color="blue">
                            <h4 class="title">Recruitment</h4>
                            <p class="category">New employees on 15th September, 2016</p>
                        </md-card-header>
                        <md-card-content>
                            <ordered-table table-header-color="blue"></ordered-table>
                        </md-card-content>
                    </md-card>
                </div>
                <div class="md-layout-item md-medium-size-100 md-xsmall-size-100 md-size-50 mt-2">
                    <nav-tabs-card>
                        <template slot="content">
                            <span class="md-nav-tabs-title">Tasks:</span>
                            <md-tabs class="md-success" md-alignment="left">
                                <md-tab id="tab-home" md-label="Appointments" md-icon="bug_report">
                                    <nav-tabs-table></nav-tabs-table>
                                </md-tab>

                                <md-tab id="tab-pages" md-label="Meetings" md-icon="code">
                                    <nav-tabs-table></nav-tabs-table>
                                </md-tab>

                                <md-tab id="tab-posts" md-label="Applications" md-icon="cloud">
                                    <nav-tabs-table></nav-tabs-table>
                                </md-tab>
                            </md-tabs>
                        </template>
                    </nav-tabs-card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {ModuleCard, StatsCard, ChartCard, NavTabsCard, NavTabsTable, OrderedTable, AreaChart, BarChart, LineChart, PieChart, RadarChart} from "../components";
    import Datatable from '../../layouts/common/datatable'
    import Repo from '../../Repository/ApiRepository';
    export default {
        components: {ModuleCard, StatsCard, ChartCard, NavTabsCard, NavTabsTable, OrderedTable, AreaChart, BarChart, LineChart, PieChart, RadarChart, Datatable},
        data() {
            return {
                employeeDetails: {
                    items: [],
                    fields: [
                        {key: 'label', label: ''},
                        {key: 'officer', class: 'text-right'},
                        {key: 'staff', class: 'text-right'},
                        {key: 'total', class: 'text-right'}
                    ],
                    totalList: 1,
                    itemsForGender: [],
                    fieldsForGender: [
                        {key: 'label', label: ''},
                        {key: 'officer', class: 'text-right'},
                        {key: 'staff', class: 'text-right'},
                        {key: 'total', class: 'text-right'}
                    ],
                    totalListForGender: 1,

                },
                salaryDetails: {
                    items: [],
                    fields: [

                    ],
                    totalList: 1
                },
                caseDetails: {
                    items: [],
                    fields: [
                        {key: 'year', label: 'Year'},
                        {key: 'new', class: 'text-right'},
                        {key: 'in_progress', class: 'text-right'},
                        {key: 'completed', class: 'text-right'},
                        {key: 'total', class: 'text-right'}
                    ],
                    totalList: 1
                },
                filterData: '',
                numberOfEmployee: [],
                departmentName: [],
                chartData: {
                    Books: 24,
                    Magazine: 30,
                    Newspapers: 10
                },
                perPage: 4,
                currentPage:1,
                filter: null,
                rawInput: null,
                totalList: 1,
                totalRows: 1,
                search: { filter: null, text: "" },
                pageOptions: [5, 10, 15,31],
                pageSize: (this.pageColSize != undefined) ? this.pageColSize : '2',
                searchSize: (this.searchColSize != undefined) ? this.searchColSize : '3',
                departments:[],
                modules:[],
                oldModules: [],
                department:'',
                payrollDept:'',
                empdpt:'',
                dailySalesChart: {
                    data: {
                        labels: ["M", "T", "W", "T", "F", "S", "S"],
                        series: [[12, 17, 7, 17, 23, 18, 30]]
                    },
                    options: {
                        lineSmooth: this.$Chartist.Interpolation.cardinal({
                            tension: 0
                        }),
                        low: 0,
                        high: 50, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
                        chartPadding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0
                        }
                    }
                },
                dataCompletedTasksChart: {
                    data: {
                        labels: ["12am", "3pm", "6pm", "9pm", "12pm", "3am", "6am", "9am"],
                        series: [[230, 750, 450, 300, 280, 240, 200, 190]]
                    },

                    options: {
                        lineSmooth: this.$Chartist.Interpolation.cardinal({
                            tension: 0
                        }),
                        low: 0,
                        high: 1000, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
                        chartPadding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0
                        }
                    }
                },
                employeeSalariesMonth : [],
                employeeSalariesSeries : [],
                emailsSubscriptionChart: {
                    data: {
                        labels: ["a","b","c","d","e","f"],
                        series: [[1,2,3,4,5,6]]
                    },
                    options: {
                        axisX: {
                            showGrid: false
                        },
                        low: 0,
                        high: 1000000000,
                        chartPadding: {
                            top: 0,
                            right:6,
                            bottom: 0,
                            left: 0
                        }
                    },
                    responsiveOptions: [
                        [
                            "screen and (max-width: 980px)",
                            {
                                seriesBarDistance: 5,
                                axisX: {
                                    labelInterpolationFnc: function(value) {
                                        return value[0];
                                    }
                                }
                            }
                        ]
                    ]
                }
            };
        },
        props: ["pageColSize", "searchColSize", "filterIgnoredFields", 'filterIncludedFields','sortBy'],
        computed: {
            m_modules() {
                return this.$store.getters.menus
            },
            rows(){
                return this.m_modules.length
            }
        },
        watch: {
            rawInput(newVal, oldVal) {
                clearTimeout(this.$_timeout)
                this.$_timeout = setTimeout(() => {
                    this.filter = newVal;
                }, 150) // set this value to your preferred debounce timeout
            },
            filter: function (val, oldVal) {
                if(val){
                    this.modules = this.oldModules.filter(function(menu) {
                        return menu.menu_name.toLowerCase().includes(val.toLowerCase())
                    })
                    this.totalList = this.modules.length

                } else{
                    this.modules = this.oldModules
                    this.totalList = this.modules.length
                }
                this.currentPage = 1
            }
        },
        mounted() {
            this.getModules()
            this.monthlySalaries()
            this.departmentWiseEmployee()
            this.$store.dispatch("getMenues");
            this.employee()
            this.salary()
            this.case()
        },
        methods: {
            getModules() {
                Repo.callApi(Repo.GET_COMMAND, '/pmis/api/access-modules').then(res=> {
                    this.modules = res.data;
                    this.oldModules = res.data;
                    this.totalList = this.modules.length;
                })
            },
            monthlySalaries() {
                Repo.callApi(Repo.GET_COMMAND, '/pmis/api/monthly-salaries').then(res=> {
                    this.emailsSubscriptionChart.data = res.data
                    this.employeeSalariesSeries = res.data.series
                    this.employeeSalariesMonth = res.data.labels
                })
            },
            departmentWiseEmployee() {
                Repo.callApi(Repo.GET_COMMAND, '/pmis/api/department-wise-employee').then(res=> {
                    this.numberOfEmployee = res.data.data
                    this.departmentName = res.data.labels
                })
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length;
                this.currentPage = 1;
            },
            clear() {
                this.filter = ''
                this.rawInput = '';
            },

            employee(){
                Repo.callApi(Repo.GET_COMMAND, '/pmis/cmdb/employees').then(res=> {
                    this.employeeDetails.items = res.data.employee
                    this.employeeDetails.totalList = this.employeeDetails.items.length

                    this.employeeDetails.itemsForGender = res.data.gender_employee
                    this.employeeDetails.totalListForGender = this.employeeDetails.itemsForGender.length
                })
            },
            salary(){
                Repo.callApi(Repo.GET_COMMAND, '/pmis/cmdb/salaries').then(res=> {
                    this.salaryDetails.items = res.data
                    this.employeeDetails.totalList = this.salaryDetails.items.length
                })
            },
            case(){
                Repo.callApi(Repo.GET_COMMAND, '/pmis/cmdb/case').then(res=> {
                    this.caseDetails.items = res.data.map(option => {
                        let newPropsObj = {
                            _cellVariants: { year: 'info', 'new': 'warning', in_progress: 'success', completed: 'danger', total: 'secondary' }
                        };
                        return Object.assign(option, newPropsObj);

                    });
                    this.caseDetails.totalList = this.caseDetails.items.length
                })
            }
        }
    };
</script>
<style scoped>
    .md-card-stats .title {
        font-weight: bold;
        font-size: 18px;
    }
    .md-card {
        margin: 7px 0;
    }
    /*.has-search .form-control-feedback {
        position: absolute;
        z-index: 2;
        display: block;
        width: 2.375rem;
        height: 2.375rem;
        line-height: 2.375rem;
        text-align: center;
        pointer-events: none;
        color: #aaa;
    }
    .form-control-feedback {
        opacity: 1;
    }*/
</style>
