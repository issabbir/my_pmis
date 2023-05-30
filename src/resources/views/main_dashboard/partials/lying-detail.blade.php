<div class="card" style="height: 95%">
    <div class="card-header bg-rgba-primary p-1 shadow-lg">
        <h4 class="card-title float-left">Container Lying Position In Port</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <!-- table start -->
                        <table class="table table-striped table-bordered table-hover table-sm mt-1">
                            <thead>
                            <tr class="bg-light bg-success">
                                <th class="text-left">TITLE</th>
                                <th class="text-center">LYING QTY</th>
                            </tr>
                            </thead>
                            <tbody id="house-allotment-data">
                            @if(isset($data))
                                @php $sum = 0; @endphp
                                @foreach($data as $key=>$value)
                                    @php $sum += $value->lying_qty @endphp
                                    <tr role="row">
                                        <td aria-colindex="7" role="cell">{{$value->title}}</td>
                                        <td aria-colindex="7" role="cell" class="text-center">{{$value->lying_qty}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th class="text-right">Total</th>
                                    <td role="cell" class="text-center"><b>{{$sum}}</b></td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <!-- table ends -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
