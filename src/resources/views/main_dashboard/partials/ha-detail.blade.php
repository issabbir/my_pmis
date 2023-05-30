<div class="card" style="height: 95%">
    {{--<div class="card-header bg-rgba-primary p-1 shadow-lg">
        <h4 class="card-title float-left">Detail</h4>
        <a href="#" class="float-right zoom-on"><i class="ficon bx bx-fullscreen"></i></a>
    </div>--}}
    <div class="card-content">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <!-- table start -->
                        <table class="table table-striped table-bordered table-hover table-sm mt-1">
                            <thead>
                            <tr class="bg-light bg-success">
                                <th class="text-right">HOUSE NAME</th>
                                <th class="text-right">BUILDING NAME</th>
                                <th class="text-right">COLONY NAME</th>
                                <th class="text-right">HOUSE SIZE</th>
                                <th class="text-right">FLOOR NUMBER</th>
                                <th class="text-right">PARKING</th>
                                @if($status == 2)
                                <th class="text-left">ALLOTMENT DATE</th>
                                @endif
                                @if($status == 5)
                                    <th class="text-left">EXPIRATION DATE</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody id="house-allotment-data">
                            @if(isset($data))
                                @foreach($data as $key=>$value)
                                    <tr role="row">
                                        <td aria-colindex="7" role="cell">{{$value->house_name}}</td>
                                        <td aria-colindex="7" role="cell">{{$value->building_name}}</td>
                                        <td aria-colindex="7" role="cell">{{$value->colony_name}}</td>
                                        <td aria-colindex="7" role="cell">{{$value->house_size}}</td>
                                        <td aria-colindex="7" role="cell">{{$value->floor_number}}</td>
                                        <td aria-colindex="7" role="cell">
                                            @if($value->parking_yn =='Y')
                                                Available
                                            @else
                                                Not Available
                                            @endif
                                        </td>
                                        @if($status == 2)
                                            <td aria-colindex="7" role="cell">@if($value->date_of_allotment!=null){{date('d-m-Y', strtotime($value->date_of_allotment))}}@else -- @endif</td>
                                        @endif
                                        @if($status == 5)
                                            <td aria-colindex="7" role="cell">@if($value->update_date!=null){{date('d-m-Y', strtotime($value->update_date))}}@else -- @endif</td>
                                        @endif
                                    </tr>
                                @endforeach
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
