<template>
<!--    <div class="">-->
<!--        <div class="content-header row">-->
<!--        </div>-->
<!--        <div class="content-wrapper">-->
<!--            <div class="content-body">&lt;!&ndash; Dashboard Ecommerce Starts &ndash;&gt;-->
<!--                <section id="dashboard-ecommerce">-->
<!--                    <div class="row">-->
<!--                        &lt;!&ndash; Greetings Content Starts &ndash;&gt;-->
<!--                        <div class="col-xl-4 col-md-6 col-12 dashboard-greetings">-->
<!--                            <div class="card">-->
<!--                                <div class="card-header">-->
<!--                                    <h3 class="greeting-text">Congratulations John! sdfsd</h3>-->
<!--                                    <p class="mb-0">Best seller of the month</p>-->
<!--                                </div>-->
<!--                                <div class="card-content">-->
<!--                                    <div class="card-body">-->
<!--                                        <div class="d-flex justify-content-between align-items-end">-->
<!--                                            <div class="dashboard-content-left">-->
<!--                                                <h1 class="text-primary font-large-2 text-bold-500">$89k</h1>-->
<!--                                                <p>You have done 57.6% more sales today.</p>-->
<!--                                                <button type="button" class="btn btn-primary glow">View Sales</button>-->
<!--                                            </div>-->
<!--                                            <div class="dashboard-content-right">-->
<!--                                                <img src="../../../images/icon/cup.png" height="220" width="220" class="img-fluid"-->
<!--                                                     alt="Dashboard Ecommerce" />-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        &lt;!&ndash; Multi Radial Chart Starts &ndash;&gt;-->
<!--                        <div class="col-xl-4 col-md-6 col-12 dashboard-visit">-->
<!--                            <div class="card">-->
<!--                                <div class="card-header d-flex justify-content-between align-items-center">-->
<!--                                    <h4 class="card-title">Visits of 2019</h4>-->
<!--                                    <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>-->
<!--                                </div>-->
<!--                                <div class="card-content">-->
<!--                                    <div class="card-body">-->
<!--                                        <div id="multi-radial-chart"></div>-->
<!--                                        <ul class="list-inline d-flex justify-content-around mb-0">-->
<!--                                            <li> <span class="bullet bullet-xs bullet-primary mr-50"></span>Target</li>-->
<!--                                            <li> <span class="bullet bullet-xs bullet-danger mr-50"></span>Mart</li>-->
<!--                                            <li> <span class="bullet bullet-xs bullet-warning mr-50"></span>Ebay</li>-->
<!--                                        </ul>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-xl-4 col-12 dashboard-users">-->
<!--                            <div class="row  ">-->
<!--                                &lt;!&ndash; Statistics Cards Starts &ndash;&gt;-->
<!--                                <div class="col-12">-->
<!--                                    <div class="row">-->
<!--                                        <div class="col-sm-6 col-12 dashboard-users-success">-->
<!--                                            <div class="card text-center">-->
<!--                                                <div class="card-content">-->
<!--                                                    <div class="card-body py-1">-->
<!--                                                        <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50">-->
<!--                                                            <i class="bx bx-briefcase-alt font-medium-5"></i>-->
<!--                                                        </div>-->
<!--                                                        <div class="text-muted line-ellipsis">New Products</div>-->
<!--                                                        <h3 class="mb-0">1.2k</h3>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                        <div class="col-sm-6 col-12 dashboard-users-danger">-->
<!--                                            <div class="card text-center">-->
<!--                                                <div class="card-content">-->
<!--                                                    <div class="card-body py-1">-->
<!--                                                        <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50">-->
<!--                                                            <i class="bx bx-user font-medium-5"></i>-->
<!--                                                        </div>-->
<!--                                                        <div class="text-muted line-ellipsis">New Users</div>-->
<!--                                                        <h3 class="mb-0">45.6k</h3>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                        <div class="col-xl-12 col-lg-6 col-12 dashboard-revenue-growth">-->
<!--                                            <div class="card">-->
<!--                                                <div class="card-header d-flex justify-content-between align-items-center pb-0">-->
<!--                                                    <h4 class="card-title">Revenue Growth</h4>-->
<!--                                                    <div class="d-flex align-items-end justify-content-end">-->
<!--                                                        <span class="mr-25">$25,980</span>-->
<!--                                                        <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                                <div class="card-content">-->
<!--                                                    <div class="card-body pb-0">-->
<!--                                                        <div id="revenue-growth-chart"></div>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                &lt;!&ndash; Revenue Growth Chart Starts &ndash;&gt;-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </section>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</template>

<script>
    export default {
        created() {
          this.breadCrumbs = this.$store.state.breadCrumbs
        },
        mounted() {
            this.$store.commit("setBreadcrumb", { link: "/#", label: "PRL & Pension System" });
            this.$store.commit("setBreadcrumb", { link: "#", label: "Dashboard" });
        },
        data() {
            return {
                "breadCrumbs":""
            }
        }

    }
</script>

