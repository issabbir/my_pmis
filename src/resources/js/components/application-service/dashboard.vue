<template>
    <div>
        <div class="content-header row">
        </div>
        <div class="content-body"><!-- Dashboard Ecommerce Starts -->
            <section id="dashboard-ecommerce">
                <div class="row">
                    <!-- Greetings Content Starts -->
                    <div class="col-xl-4 col-md-6 col-12 dashboard-greetings">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="greeting-text">Congratulations John!</h3>
                                <p class="mb-0">Main Dashboard Md. Hasanuzzaman Dipu</p>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-end">
                                        <div class="dashboard-content-left">
                                            <h1 class="text-primary font-large-2 text-bold-500">$89k</h1>
                                            <p>You have done 57.6% more sales today.</p>
                                            <button type="button" class="btn btn-primary glow">View Sales</button>
                                        </div>
                                        <div class="dashboard-content-right">
                                            <img src="/app-assets/images/icon/cup.png" height="220" width="220" class="img-fluid"
                                                 alt="Dashboard Ecommerce" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </section>
            <!-- Dashboard Ecommerce ends -->

        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
