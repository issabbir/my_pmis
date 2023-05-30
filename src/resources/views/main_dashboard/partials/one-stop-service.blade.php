<div class="card" style="height: 95%">
    <div class="card-header bg-rgba-primary p-1 shadow-lg">
        <h4 class="card-title float-left">Daily One Stop Service</h4>
        <a href="#" class="float-right zoom-on"><i class="ficon bx bx-fullscreen"></i></a>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="mt-2 text-bold-600 text-center">Today's Collection</div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-sm mt-1">
                    <col style="width: 20%">
                    <col style="width: 20%">
                    <col style="width: 20%">
                    <col style="width: 20%">
                    <thead  class="bg-success bg-light">
                    <tr>
                        <th style="width: 15%">#</th>
                        <th style="width: 10%">NO. OF Container</th>
                        <th class="text-right">NO. OF Bill</th>
                        <th class="text-right">Bill Amount</th>
                        <th class="text-right">PAID BILL</th>
                        <th class="text-right">Paid amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="dataTodayLcl">
                        <td class="">LCL BILL</td>
                        <td>0</td>
                        <td class="text-right">0</td>
                        <td class="text-right">0</td>
                        <td class="text-right">0</td>
                        <td class="text-right">0</td>
                    </tr>
                    <tr class="dataTodayFcl">
                        <td class="">FCL BILL</td>
                        <td>0</td>
                        <td class="text-right">0</td>
                        <td class="text-right">0</td>
                        <td class="text-right">0</td>
                        <td class="text-right">0</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-2 text-bold-600 text-center">Last 7 Days Handling of Container</div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-sm mt-1">
                        <col style="width: 12%">
                        <col style="width: 13%">
                        <col style="width: 13%">
                        <col style="width: 13%">
                        <col style="width: 13%">
                        <col style="width: 12%">
                        <col style="width: 12%">
                        <col style="width: 12%">
                    <thead id="container_handled_label" class="bg-success bg-light"></thead>
                    <tbody id="container_handled_data">
                </table>
                <canvas id="SevenDaysCollection" class="d-flex justify-content-center" ></canvas>
            </div>
            <div class="mt-2 text-bold-600 text-center">Delivery Status</div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover table-sm mt-1">
                    <col style="width: 10%">
                    <col style="width: 30%">
                    <col style="width: 30%">
                    <col style="width: 30%">
                    <thead  class="bg-success bg-light">
                    <tr>
                        <th>#</th>
                        <th>Cart tickets issued</th>
                        <th>Gate pass issued</th>
                        <th>Gate pass used</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="dataDeliveryLcl">
                        <td>LCL</td>
                        <td class="">0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr class="dataDeliveryFcl">
                        <td>FCL</td>
                        <td class="">0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="oneStopModel" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div id="onestop_pop_content"></div>
    </div>
</div>

