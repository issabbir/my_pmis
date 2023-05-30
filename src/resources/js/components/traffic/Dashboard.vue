<template>
    <div class="">
        <div class="content-header row">
        </div>
        <div class="content-wrapper">
            <div class="content-body"><!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                    <div class="row">

                        <!-- Multi Radial Chart Starts -->
                        <div class="col-xl-4 col-md-6 col-12 dashboard-visit">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">Visits of 2019 (Traffic)</h4>
                                    <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div id="multi-radial-chart"></div>
                                        <ul class="list-inline d-flex justify-content-around mb-0">
                                            <li> <span class="bullet bullet-xs bullet-primary mr-50"></span>Target</li>
                                            <li> <span class="bullet bullet-xs bullet-danger mr-50"></span>Mart</li>
                                            <li> <span class="bullet bullet-xs bullet-warning mr-50"></span>Ebay</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.breadCrumbs = this.$store.state.breadCrumbs
        },
        mounted() {
            // let link = "http://google.com";
            // let label = "google.com";
            // //this.$store.commit("setBreadcrumbEmpty");
            // this.$store.commit("setBreadcrumb", {link, label});
            this.$store.commit("setBreadcrumb", {link:"#", label:"Traffic"});
            this.$store.commit("setBreadcrumb", {link:"#", label:"Dashboard"});
        },
        data() {
            return {
                "breadCrumbs":""
            }
        }
    }
</script>

