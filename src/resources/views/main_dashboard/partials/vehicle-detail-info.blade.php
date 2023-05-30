<div class="card" style="height: 95%">
    <div class="card-content">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <!-- table start -->
                        <table class="table table-striped table-bordered table-hover table-sm mt-1">
                            <thead>
                            <tr class="bg-light bg-success">
                                <th class="text-right">VEHICLE REG NO</th>
                                <th class="text-right">CHASSIS NO</th>
                                <th class="text-right">ENGINE NO</th>
                                <th class="text-right">MANUFACTURE YEAR</th>
                                <th class="text-right">CC</th>
                                <th class="text-right">PURCHASE DATE</th>
                            </tr>
                            </thead>
                            <tbody id="house-allotment-data">
                            @if(isset($data))
                                @foreach($data as $key=>$value)
                                    <tr role="row">
                                        <td aria-colindex="7" role="cell">
                                            @if($value->vehicle_reg_no!=null)
                                                {{$value->vehicle_reg_no}}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td aria-colindex="7" role="cell">
                                            @if($value->chassis_no!=null)
                                                {{$value->chassis_no}}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td aria-colindex="7" role="cell">
                                            @if($value->engine_no!=null)
                                                {{$value->engine_no}}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td aria-colindex="7" role="cell">
                                            @if($value->manufactur_year!=null)
                                                {{$value->manufactur_year}}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td aria-colindex="7" role="cell">
                                            @if($value->cc!=null)
                                                {{$value->cc}}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td aria-colindex="10" role="cell">
                                            @if($value->purchase_date!=null)
                                                {{date('Y-m-d', strtotime($value->purchase_date))}}
                                            @else
                                                --
                                            @endif
                                        </td>
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
