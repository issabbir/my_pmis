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
                                <th class="text-left">TRAINING NAME</th>
                                <th class="text-left">BATCH NO</th>
                                <th class="text-left">TRAINER NAME</th>
                                <th class="text-left">START DATE</th>
                                <th class="text-left">END DATE</th>
                            </tr>
                            </thead>
                            <tbody id="house-allotment-data">
                            @if(isset($data))
                                @foreach($data as $key=>$value)
                                    <tr role="row">
                                        <td aria-colindex="7" role="cell">{{$value->training_title}}</td>
                                        <td aria-colindex="7" role="cell">{{$value->batch_id}}</td>
                                        <td aria-colindex="7" role="cell">{{$value->trainer_name}}</td>
                                        <td aria-colindex="7" role="cell">{{date('d-m-Y',strtotime($value->start_date))}}</td>
                                        <td aria-colindex="7" role="cell">{{date('d-m-Y',strtotime($value->end_date))}}</td>
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
