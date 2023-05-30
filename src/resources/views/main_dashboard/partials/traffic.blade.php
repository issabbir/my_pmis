<div class="card" style="height: 95%">
    <div class="card-header bg-rgba-primary p-1 shadow-lg">
        <h4 class="card-title float-left">Traffic</h4>
        <a href="#" class="float-right zoom-on"><i class="ficon bx bx-fullscreen"></i></a>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <!-- table start -->
                        {{--<table class="table table-striped table-bordered  table-hover table-sm mt-1">
                            <thead  class="bg-success bg-light">
                            <tr>
                                <th colspan="5">Today's Handling of vessels</th>
                            </tr>
                            <tr>
                                <th>Vessel Type</th>
                                <th>Berthing</th>
                                <th>Waiting</th>
                                <th>O/A Parking</th>
                                <th>O/A Entry</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="font-weight-bold">Cargo</td>
                                <td>10</td>
                                <td>10</td>
                                <td>7</td>
                                <td>8</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Container</td>
                                <td>15</td>
                                <td>4</td>
                                <td>11</td>
                                <td>5</td>
                            </tr>
                            </tbody>
                        </table>--}}
                        <div class="mt-2 text-bold-600 text-center">Monthly handling of vessels<</div>
                        <table class="table table-striped table-bordered  table-hover table-sm mt-1">
                            <thead id="vessel_handled_label" class="bg-success bg-light"></thead>
                            <tbody id="vessel_handled_data">
                            </tbody>
                        </table>

                        <div class="row ml-1 mr-1 mt-1 shadow-lg bg-white rounded p-2">
                            <div class="col-md-6">
                                <div class="col-md-12 border border-info ">
                                    <canvas id="VesselHandlingChart" width="300" height="300"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 border border-info ">
                                    <canvas id="CargoContainerChart" width="300" height="300"></canvas>
                                </div>
                            </div>

                        </div>
                        <div class="mt-2 text-bold-600 text-center">Container & Cargo Monthly Compare</div>
                        <table class="table table-striped table-bordered  table-hover table-sm mt-1">
                            <thead  class="bg-success bg-light" id="container_cargo_monthly_compare_label"></thead>
                            <tbody id="container_cargo_monthly_compare_data">
                            </tbody>
                        </table>
                        <!-- table ends -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
