<template>
     <div class="content-wrapper">
        <div class="content-body">
            <!-- Dashboard Analytics Start -->
            <section id="dashboard-analytics">
                <div class="mb-2">
                    <h3 class="text-center">Welcome To PMIS</h3>
                </div>
                <b-card>
                    <b-card-header>Statistical Report</b-card-header>
                    <b-card-text>
                        <b-card-body class="pb-0 text-center">
                            <div class="row">

                                <div class="d-flex justify-content-center align-items-center col-md-4">
                                    <div class="avatar bg-rgba-primary  p-25 mr-75 mr-xl-2">
                                        <div class="avatar-content">
                                            <i class="bx bx-user text-primary font-medium-2"></i>
                                        </div>
                                    </div>
                                    <div class="total-amount">
                                        <h5 class="mb-0">{{genderWiseEmployeeData.statistics.attendance.total}}</h5>
                                        <small class="text-muted">Total</small>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center align-items-center col-md-4">
                                    <div class="avatar bg-rgba-warning  p-25 mr-75 mr-xl-2">
                                        <div class="avatar-content">
                                            <i class="bx bx-dollar text-warning font-medium-2"></i>
                                        </div>
                                    </div>
                                    <div class="total-amount">
                                        <h5 class="mb-0">{{genderWiseEmployeeData.statistics.attendance.officer}}</h5>
                                        <small class="text-muted">Officer</small>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center align-items-center col-md-4">
                                    <div class="avatar bg-rgba-warning  p-25 mr-75 mr-xl-2">
                                        <div class="avatar-content">
                                            <i class="bx bx-dollar text-warning font-medium-2"></i>
                                        </div>
                                    </div>
                                    <div class="total-amount">
                                        <h5 class="mb-0">{{genderWiseEmployeeData.statistics.attendance.staff}}</h5>
                                        <small class="text-muted">Staff</small>
                                    </div>
                                </div>
                            </div>

                        </b-card-body>
                        <hr>
                        <div class="pie-chart-wrapper" >
                            <bar-chart v-if="loaded" :chartdata="employeeDetailBardata" :options="options"></bar-chart>
                        </div>
                    </b-card-text>
                    <!--<b-card-body class="border">


                        &lt;!&ndash;<div class="d-flex justify-content-center" v-if="grantAccess">
                            <iframe src="/report/render?xdo=/~weblogic/Dashboard.xdo&filename=test&type=html"
                                    style="width: 730.0pt; height:1000px; border:0;" align="midddle">
                                <p>Your browser does not support iframes.</p>
                            </iframe>
                        </div>&ndash;&gt;
                    </b-card-body>-->
                </b-card>
            </section>
        </div>
    </div>
</template>

<script>
    import VueCharts from 'vue-chartjs'
    import LineChart from './partials/LineChart.js'
    import BarChart from "./chartjs/Bar";
    import {mapState} from 'vuex';
    // require styles
    import 'swiper/dist/css/swiper.css'
    import { swiper, swiperSlide } from 'vue-awesome-swiper'
    import Repo from "../../Repository/ApiRepository";
    export default {
        components: {
            BarChart
        },
        name: 'carrousel',
        data() {
            return {
                genderWiseEmployeeData: {},
                loaded: false,
                employeeDetailBardata: {},
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    tooltips: {
                        enabled: true
                    },
                    hover: {
                        animationDuration: 1
                    },
                    animation: {
                        duration: 1,
                        onComplete: function () {
                            var chartInstance = this.chart,
                                ctx = chartInstance.ctx;
                            ctx.textAlign = 'center';
                            ctx.fillStyle = "rgba(0, 0, 0, 1)";
                            ctx.textBaseline = 'bottom';
                            // Loop through each data in the datasets
                            this.data.datasets.forEach(function (dataset, i) {
                                var meta = chartInstance.controller.getDatasetMeta(i);
                                meta.data.forEach(function (bar, index) {
                                    var data = dataset.data[index];
                                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                });
                            });
                        }
                    }
                }
            }
        },
        computed: {
          ...mapState(['grantAccess'])
        },
        mounted() {
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Dahsboard"});


            try {
                this.genderWiseEmployee()
                this.employeeDetails()
            } catch (e) {
                console.error(e)
            }
        },
        methods: {
            employeeDetails() {
                this.loaded = false
                axios
                    .get('/cdb/employee-details')
                    .then(response => {
                        let dataResult = response.data
                        this.employeeDetailBardata = {
                            labels: ["Late Present", "On Leave", "Training", "Tour"],
                            datasets: [{
                                label: "Officer",
                                backgroundColor: "#5A8DEE",
                                data: [
                                    dataResult[0].length > 0 ? dataResult[0].filter(a => a.emp_type_name == 'OFFICER').length > 0 ? dataResult[0].filter(a => a.emp_type_name == 'OFFICER')[0].count : 0 : 0,
                                    dataResult[1].length > 0 ? dataResult[1].filter(a => a.emp_type_name == 'OFFICER').length > 0 ? dataResult[1].filter(a => a.emp_type_name == 'OFFICER')[0].count : 0 : 0,
                                    dataResult[2].length > 0 ? dataResult[2].filter(a => a.emp_type_name == 'OFFICER').length > 0 ? dataResult[2].filter(a => a.emp_type_name == 'OFFICER')[0].count : 0 : 0,
                                    dataResult[3].length > 0 ? dataResult[3].filter(a => a.emp_type_name == 'OFFICER').length > 0 ? dataResult[3].filter(a => a.emp_type_name == 'OFFICER')[0].count : 0 : 0
                                ]
                            }, {
                                label: "Staff",
                                backgroundColor: "#4BC0C0",
                                data: [
                                    dataResult[0].length > 0 ? dataResult[0].filter(a => a.emp_type_name == 'STAFF').length > 0 ? dataResult[0].filter(a => a.emp_type_name == 'STAFF')[0].count : 0 : 0,
                                    dataResult[1].length > 0 ? dataResult[1].filter(a => a.emp_type_name == 'STAFF').length > 0 ? dataResult[1].filter(a => a.emp_type_name == 'STAFF')[0].count : 0 : 0,
                                    dataResult[2].length > 0 ? dataResult[2].filter(a => a.emp_type_name == 'STAFF').length > 0 ? dataResult[2].filter(a => a.emp_type_name == 'STAFF')[0].count : 0 : 0,
                                    dataResult[3].length > 0 ? dataResult[3].filter(a => a.emp_type_name == 'STAFF').length > 0 ? dataResult[3].filter(a => a.emp_type_name == 'STAFF')[0].count : 0 : 0
                                ]
                            }]
                        }
                        this.loaded = true
                    })
            },
            genderWiseEmployee(){
                axios.get('/cdb/gender-wise-officer-staff').then(response => {
                    this.genderWiseEmployeeData = response.data
                })
            }
        }
    }
</script>
<style scoped>
.swiper-container {
    padding: 0px 130px;
 }
  .swiper-slide {
    width: 60%;
    min-height: 200px;
   }
  .swiper-slide:nth-child(2n) {
    width: 40%;
  }
  .swiper-slide:nth-child(3n) {
    width: 20%;
  }
  .card.cardSlide {
        min-height: 180px;
    }
    .first_row{
        min-height: 530px;
     }
    .second_row{
        min-height: 275px;
     }
    .third_row{
        min-height: 500px;
     }
    .forth_row{
        min-height: 410px;
     }

     @media only screen and (max-width: 1400px) {
            .swiper-container {
                padding: 0px !important;
            }
            .swiper-slide {
                width: 50%;
                min-height: 200px;
            }
            .swiper-slide:nth-child(2n) {
                width: 50%;
            }
            .swiper-slide:nth-child(3n) {
                width: 50%;
            }
            .swiper-slide h5{
                font-size: 15px !important;
            }
         #dashboard-analytics h2{
             font-size: 22px !important;
         }
            #dashboard-analytics h4, #dashboard-analytics h6{
                font-size: 15px !important;
            }
         #dashboard-analytics span{
             font-size:12px;
         }
         #dashboard-analytics table tr th{
             font-size:13px;
         }
        }
    @media only screen and (max-width: 640px) {
            .swiper-container {
                padding: 0px !important;
            }
            .swiper-slide {
                width: 100% !important;
                min-height: 200px;
            }
            .swiper-slide:nth-child(2n) {
                width: 100% !important;
            }
            .swiper-slide:nth-child(3n) {
                width: 100% !important;
            }

            .shadow-lg.p-2 {
                padding: 0!important;
            }
        }
</style>
