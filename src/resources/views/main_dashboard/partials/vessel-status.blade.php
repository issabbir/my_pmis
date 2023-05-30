<div class="card mb-1" style="height: 95%">
    <div class="card-header bg-rgba-primary p-1 shadow-lg">
        <h4 class="card-title float-left">Vessel and Container Handling</h4>
        <a href="#" class="float-right zoom-on"><i class="ficon bx bx-fullscreen"></i></a>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="text-bold-600 text-center">VESSEL MOVEMENT & PILOT BOARDING TIME</div>
                    <div class="table-responsive ">
                        <table class="table table-striped table-bordered table-hover table-sm">
                            <colgroup>
                                <col width="70%"/>
                                <col width="10%"/>
                                <col width="10%"/>
                                <col width="10%"/>
                            </colgroup>
                            <thead  class="bg-success bg-light">
                            <tr>
                                <th>Title</th>
                                <th class="text-center">NOS</th>
                                <th colspan="2" class="text-center">TIME</th>
                            </tr>
                            </thead>
                            <tbody id="vessel_move_data">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="text-bold-600 text-center">LAST 24 HRS. CONT. HANDLING (TUES)</div>
                    <div class="table-responsive ">
                        <table class="table table-striped table-hover table-bordered table-sm">
                            <colgroup>
                                <col width="80%"/>
                                <col width="20%"/>
                            </colgroup>
                            <thead>
                               {{-- <tr class="bg-light bg-success">
                                    <th colspan="3">LAST 24 HRS. CONT. HANDLING (TUES)</th>
                                </tr>--}}
                                <tr class="bg-light bg-success">
                                    <th>Title</th>
                                    <th class="text-center">Total Container</th>
                                </tr>
                            </thead>
                            <tbody id="daily-cont-hand"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
