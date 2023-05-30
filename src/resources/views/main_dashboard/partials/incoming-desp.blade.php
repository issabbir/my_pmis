<div class="card mb-1" style="height: 95%">
    <div class="card-header bg-rgba-primary p-1 shadow-lg">
        <h4 class="card-title float-left">Incoming and DESP from CPA</h4>
        <a href="#" class="float-right zoom-on"><i class="ficon bx bx-fullscreen"></i></a>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="text-bold-600 text-center">LAST 24HRS. TOTAL INCOMING IN CPA</div>
                    <div class="table-responsive ">
                        <!-- table start -->
                        <table class="table table-striped table-hover table-bordered table-sm">
                            <colgroup>
                                <col width="80%"/>
                                <col width="10%"/>
                                <col width="10%"/>
                            </colgroup>
                            <thead>
                          {{--  <tr class="bg-light bg-success">
                                <th colspan="3">LAST 24HRS. TOTAL INCOMING IN CPA</th>
                            </tr>--}}
                            <tr class="bg-light bg-success">
                                <th>Title</th>
                                <th class="text-center">Box</th>
                                <th class="text-center">Tues</th>
                            </tr>
                            </thead>
                            <tbody id="daily-total-incoming"></tbody>
                        </table>
                        <!-- table ends -->
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="text-bold-600 text-center">LAST 24HRS. TOTAL DESP, FROM CPA</div>
                    <div class="table-responsive ">
                        <table class="table table-striped table-hover table-bordered table-sm">
                            <colgroup>
                                <col width="80%"/>
                                <col width="10%"/>
                                <col width="10%"/>
                            </colgroup>
                            <thead>
                            {{--<tr class="bg-light bg-success">
                                <th colspan="3">LAST 24HRS. TOTAL DESP, FROM CPA</th>
                            </tr>--}}
                            <tr class="bg-light bg-success">
                                <th>Title</th>
                                <th class="text-center">Box</th>
                                <th class="text-center">Tues</th>
                            </tr>
                            </thead>
                            <tbody id="daily-total-desp"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
