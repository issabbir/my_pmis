@if (isset($ajax) && $ajax)
    @foreach($data as $dt)
    <tr>
        <td class="text-right" data-status="'year">{{$dt->year}}</td>
        <td class="text-right" ><a data-status="in_progress" data-year="{{$dt->year}}" href="javascript:void(0)" class="case-second-level"> {{$dt->in_progress + $dt->new}} </a></td>
        <td class="text-right" ><a href="javascript:void(0)" data-status="completed" data-year="{{$dt->year}}" class="case-second-level" >{{$dt->completed}} </a>  </td>
        <td class="bg-light bg-success text-right">{{$dt->total}}</td>
    </tr>
    @endforeach
@else

<div class="card mb-1" style="height: 95%">
    <div class="card-header bg-rgba-primary p-1 shadow-lg">
        <h4 class="card-title float-left">Case</h4>
        <a href="#" class="float-right zoom-on"><i class="ficon bx bx-fullscreen"></i></a>
    </div>
    <div class="card-content">
        <div class="card-body pb-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive ">
                        <!-- table start -->
                        <table class="table table-striped table-hover table-bordered table-sm mt-1">
                            <thead>
                            <tr class="bg-light bg-success">
                                <th class="text-right">Year</th>
                                <th class="text-right">Ongoing</th>
                                <th class="text-right">Closed</th>
                                <th class="bg-light bg-success text-right">Total</th>
                            </tr>
                            </thead>
                            <tbody id="case-data">
                            </tbody>
                        </table>
                        <!-- table ends -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
