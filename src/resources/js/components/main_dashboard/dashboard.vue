<template>
    <div class="content-wrapper">
        <div class="content-body">
            <!-- Dashboard Analytics Start -->
            <section id="dashboard-analytics">
                    <div class="mb-2">
                        <h3 class="text-center">Dashboard</h3>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Statistical Report
                        </div>
                        <div class="card-body border mb-2 ml-2 mr-2 " >
                            <div class="d-flex justify-content-center" v-if="grantAccess">
                                <iframe src="/report/render?xdo=/~weblogic/Dashboard.xdo&filename=test&type=html"
                                        style="width: 730.0pt; height:1000px; border:0;" align="midddle">
                                    <p>Your browser does not support iframes.</p>
                                </iframe>
                            </div>
                        </div>
                    </div>
            </section>
            <!-- Dashboard Analytics end -->
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex';
    export default {
        components: {
        },
        data() {
            return {
            }
        },
        computed: {
            ...mapState(['grantAccess'])
        },
        mounted() {
            this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "CPA"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Dashboard"});
        },
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