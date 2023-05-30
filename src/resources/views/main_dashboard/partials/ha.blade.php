@if (isset($ajax) && $ajax)
    @php
        $available_total = 0;
        $allotted_total = 0;
        $maintenance_total = 0;
        $reserved_total = 0;
        $out_of_use_total = 0;
        $totals = 0;
    @endphp
    @foreach($data as $dt)
        @php
            $available_total = $available_total + $dt->available;
            $allotted_total = $allotted_total + $dt->allotted;
            $maintenance_total = $maintenance_total + $dt->maintenance;
            $reserved_total = $reserved_total + $dt->reserved;
            $out_of_use_total = $out_of_use_total + $dt->out_of_use;
            $totals = $totals + $dt->total
        @endphp
        <tr >
            <td class="text-right">{{$dt->house_type}}</td>
            <td class="text-right"><a title="AVAILABLE" href="" data-status="{{$dt->house_type}}+1" class="has-second-level">{{$dt->available}}</a></td>
            <td class="text-right"><a title="ALLOTTED" data-status="{{$dt->house_type}}+2" class="has-second-level" href="">{{$dt->allotted}}</a></td>
            <td class="text-right"><a title="MAINTENANCE" data-status="{{$dt->house_type}}+3" class="has-second-level" href="">{{$dt->maintenance}}</a></td>
            <td class="text-right"><a title="RESERVED" href="" data-status="{{$dt->house_type}}+4" class="has-second-level">{{$dt->reserved}}</a></td>
            <td class="text-right"><a title="OUT OF USE" href="" data-status="{{$dt->house_type}}+5" class="has-second-level">{{$dt->out_of_use}}</a></td>
            <td class="bg-light bg-success text-right">{{$dt->total}}</td>
        </tr>
    @endforeach
    <tr style="background-color: #7E8FA3; color: white">
        <td class="text-center">Total</td>
        <td class="text-right">{{$available_total}}</td>
        <td class="text-right">{{$allotted_total}}</td>
        <td class="text-right">{{$maintenance_total}}</td>
        <td class="text-right">{{$reserved_total}}</td>
        <td class="text-right">{{$out_of_use_total}}</td>
        <td class="text-right">{{$totals}}</td>
    </tr>
@else

<div class="card" style="height: 95%">
    <div class="card-header bg-rgba-primary p-1 shadow-lg">
        <h4 class="card-title float-left">House Allotment</h4>
        <a href="#" class="float-right zoom-on"><i class="ficon bx bx-fullscreen"></i></a>
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
                                <th class="text-right">Type</th>
                                <th class="text-right">Available</th>
                                {{--                            <th class="text-right">Occupied</th>--}}
                                <th class="text-right">Allotted</th>
                                <th class="text-right">Maintenance</th>
                                <th class="text-right">reserved</th>
                                {{--                            <th class="text-right">Vacant</th>--}}
                                <th class="text-right">Expired</th>
                                <th class="text-right">Total</th>
                            </tr>
                            </thead>
                            <tbody id="house-allotment-data">

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

