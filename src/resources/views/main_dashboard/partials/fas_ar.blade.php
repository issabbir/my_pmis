@if (isset($ajax) && $ajax ==  true)
    @foreach($accounts_receivable as $key=>$val)
        <tr class="">
            <td>{{$val->party_ledger_name}}</td>
            <td class="text-right">{{$val->outstanding_amount}}</td>
        </tr>
    @endforeach
@else
    <div class="card" style="height: 95%">
        <div class="card-header bg-rgba-primary p-1 shadow-lg">
            <h6 class="card-title float-left">Accounts Receivable</h6>
            <a href="#" class="float-right zoom-on"><i class="ficon bx bx-fullscreen"></i></a>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="row mb-0">
                    <div class="col-md-12 col-12 pl-md-0 h-100">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <!-- table start -->
                                        <table class="table table-striped table-hover table-bordered table-sm mt-1">
                                            <thead class="bg-success bg-light">
                                            <tr>
                                                <th>Party Ledger</th>
                                                <th class="text-right">Outstanding Amount</th>
                                            </tr>
                                            </thead>
                                            <tbody id="fas_ar">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

