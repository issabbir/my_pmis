<template>
  <div>
      <div>
          <b-row>
              <b-col md="8">
                  <ProfileCard></ProfileCard>
              </b-col>
              <b-col md="4">
                  <b-card bg-variant="transparent">
                      <b-row>
                          <b-col md="12">
                              <b-form-group
                              >
                                  <b-input-group size="sm">
                                      <b-input-group-prepend>
                                          <b-button class="fas fa-search "></b-button>
                                      </b-input-group-prepend>
                                      <b-form-input
                                          id="filter-input"
                                          v-model="filter"
                                          type="search"
                                      ></b-form-input>

                                      <b-input-group-append>
                                          <b-button @click="filter = ''">Clear</b-button>
                                      </b-input-group-append>
                                  </b-input-group>
                              </b-form-group>
                          </b-col>
                      </b-row>
                      <b-card-text>
                          <b-row :per-page="perPage" :current-page="currentPage">
                              <b-col md="12" v-for="(module, index) in modules.slice(4*(currentPage-1),4*(currentPage))" :key="index">
                                  <b-link :href="module.base_url" >
                                      <b-row class="mb-1 p-0" style="background-color: #fff">
                                          <b-col md="3" style="height: 60px; border-bottom-left-radius: 5px; border-top-left-radius: 5px" class="d-flex justify-content-center align-items-center" :style="'background-color:' +module.bg_color">
                                              <div style="font-size: 40px!important; color: #fff;" class="d-flex justify-content-center align-items-center" v-html="module.icon"></div>
                                          </b-col>

                                          <b-col md="9">
                                              <p class="category"></p>
                                              <span class="title text-dark">{{module.menu_name}}</span>
                                          </b-col>
                                      </b-row>
                                  </b-link>
                              </b-col>
                          </b-row>
                          <b-row class="mt-1  mb-0">
                              <b-col md="12">
                                  <b-pagination pills
                                                v-model="currentPage"
                                                :total-rows="totalList"
                                                :per-page="perPage"
                                                align="center"
                                                hide-ellipsis
                                                limit="3"
                                                size="sm"
                                                class="my-0"
                                  ></b-pagination>
                              </b-col>
                          </b-row>
                      </b-card-text>
                  </b-card>

              </b-col>
          </b-row>
      </div>
  </div>
</template>

<script>
import {ProfileCard, ModuleCard, StatsCard, ChartCard, NavTabsCard, NavTabsTable, OrderedTable, AreaChart, BarChart, LineChart, PieChart, RadarChart} from "../components";

import Repo from '../../Repository/ApiRepository';
import axios from "axios";
export default {
  components: {
      ProfileCard,
      ModuleCard,
      StatsCard,
      ChartCard,
      NavTabsCard,
      NavTabsTable,
      OrderedTable,
      AreaChart,
      BarChart,
      LineChart,
      PieChart,
      RadarChart,

  },
  data() {
    return {
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
      this.$store.commit("setBreadcrumbEmpty");
      this.$store.commit("setBreadcrumb", {link: "dashboard", label: "Dashboard"});
      this.getModules()
      this.monthlySalaries()
      this.departmentWiseEmployee()
      this.$store.dispatch("getMenues");
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
  }
};
</script>
<style scoped>
    .bx {
        font-size: 50px!important;
    }
</style>
