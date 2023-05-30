<div class="card" style="height: 95%">
    <div class="card-header bg-rgba-primary p-1 shadow-lg">
        <h4 class="card-title float-left" id="vessel_history_title">Commodity Wise Vessels Particulars in Port</h4>
        <a href="#" class="float-right zoom-on"><i class="ficon bx bx-fullscreen"></i></a>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-sm mt-1">
                    <thead  class="bg-success bg-light">
                    <tr>
                        <th rowspan="2" class="text-center">COMMODITY WISE VESSELS</th>
                        <th colspan="3" class="text-center">AT OUTER ANCHORAGE</th>
                        <th colspan="3" class="text-center">AT RM & SPL. BERTH</th>
                        <th colspan="3" class="text-center">AT MAIN JETTIES</th>
                        <th rowspan="2" class="text-center">TOTAL VESSEL IMPORT</th>
                    </tr>
                    <tr>
                        <th class="text-center">WORK</th>
                        <th class="text-center">NOT WORK</th>
                        <th class="text-center">TOTAL</th>
                        <th class="text-center">WORK</th>
                        <th class="text-center">NOT WORK</th>
                        <th class="text-center">TOTAL</th>
                        <th class="text-center">WORK</th>
                        <th class="text-center">NOT WORK</th>
                        <th class="text-center">TOTAL</th>
                    </tr>
                    </thead>
                    <tbody id="workable_and_nonworkable_data">
                    </tbody>
                </table>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <canvas id="workable-vessel-history" class="d-flex justify-content-center" ></canvas>
                </div>
                <div class="col-md-6">
                    <canvas id="non-workable-vessel-history" class="d-flex justify-content-center" ></canvas>
                </div>
            </div>

            <div class="row mb-1">
                <div class="col-md-6">
                    <div class="table-responsive ">
                        <table class="table table-striped table-hover table-bordered table-sm" style="border:1px solid #5A8DEE!important">
                            <tbody id="workable_vessel" style="border:1px solid #5A8DEE!important"></tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    {{--<div class="table-responsive ">
                        <table class="table table-striped table-hover table-bordered table-sm">
                            <colgroup>
                                <col width="15%"/>
                                <col width="85%"/>
                            </colgroup>
                            <thead  class="bg-primary">
                            <tr>
                                <th colspan="2" class="text-center text-white">NOT WORKING VESSELS AT OUTER ANCHORAGE</th>
                            </tr>
                            </thead>
                            <tbody id="non_workable_vessel"></tbody>
                        </table>
                    </div>--}}
                    <div class="text-bold-600 text-center mt-2">VEHICLE PARTICULARS</div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-sm">
                            <thead  class="bg-success bg-light">
                            <tr>
                                <th class="text-center" rowspan="2">CAPACITY (IN UNITS)</th>
                                <th class="text-center">Yesterday</th>
                                <th colspan="2" class="text-center">Today</th>
                            </tr>
                            <tr>
                                <th class="text-center">DELIVERY</th>
                                <th class="text-center">AUC. LYING</th>
                                <th class="text-center">TOTAL LYING</th>
                            </tr>
                            </thead>
                            <tbody id="vehicle_particulars">
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive ">
                        <table class="table table-striped table-hover table-bordered table-sm">
                            <colgroup>
                                <col style="width: 90%"/>
                                <col style="width: 10%"/>
                            </colgroup>
                            <thead  class="bg-success bg-light">
                            <tr>
                                <th>VACANT BERTH</th>
                                <th class="text-center">TOTAL</th>
                            </tr>
                            </thead>
                            <tbody id="vacant_berth"></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
