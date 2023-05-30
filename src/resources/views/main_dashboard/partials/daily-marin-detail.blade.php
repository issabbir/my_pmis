<div class="card" style="height: 95%">
     <div class="card-header bg-rgba-primary p-1 shadow-lg">
        <h4 class="card-title float-left">Marine {{$type}} Details</h4>
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
                                <th class="text-left">SL</th>
                                <th class="text-left">VESSEL ID</th>
                                <th class="text-left">VESSEL REG NO</th>
                                <th class="text-left">LOCAL AGENT</th>
                                <th class="text-left">MASTER NAME</th>
                                <th class="text-left">LAST PORT</th>
                            </tr>
                            </thead>
                            <tbody id="house-allotment-data">
                            @if(isset($data))
                                @php $i=1; @endphp
                                @foreach($data as $key=>$value)
                                    <tr role="row">
                                        <td aria-colindex="7" role="cell">{{$i++}}</td>
                                        <td aria-colindex="7" role="cell">{{$value->vessel_id}}</td>
                                        <td aria-colindex="7" role="cell">{{$value->vessel_reg_no}}</td>
                                        <td aria-colindex="7" role="cell">{{$value->local_agent}}</td>
                                        <td aria-colindex="7" role="cell">{{$value->master_name}}</td>
                                        <td aria-colindex="7" role="cell">{{$value->last_port}}</td>
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
