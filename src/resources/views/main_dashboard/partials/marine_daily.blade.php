<div class="card">
    <div class="card-header bg-rgba-primary p-1 shadow-lg">
        <h4 class="card-title float-left">Marine Daily Statistics</h4>
        <a href="#" class="float-right zoom-on"><i class="ficon bx bx-fullscreen"></i></a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="pie-chart-wrapper">
                    <canvas id="daily-pilotage-service" class="d-flex justify-content-center"></canvas>
                    <div id="daily_pilotage_service"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="pie-chart-wrapper">
                    <canvas id="daily-mooring-service" class="d-flex justify-content-center"></canvas>
                    <div id="daily_mooring_service"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="">
                    <canvas id="daily-dues-collection" class="d-flex justify-content-center"></canvas>
                </div>
            </div>

            <div class="col-md-12">

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover table-sm mt-1">
                        <thead class="bg-success bg-light">
                            <tr>
                                <th colspan="3">Daily Fresh Water Supply</th>
                            </tr>
                            <tr>
                                <th class="">Receiving Vessel</th>
                                <th class="">Water Supplied(TON)</th>
                                <th class="">Suppling Vessel</th>
                            </tr>
                        </thead>
                        <tbody id="daily-fresh-water"></tbody>
                    </table>
                </div>

            </div>
            <div class="col-md-12">
                @include('main_dashboard.partials.vessel-bills')
            </div>

        </div>

    </div>
</div>


