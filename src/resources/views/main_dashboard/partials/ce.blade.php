@if (isset($ajax) && $ajax)
    @foreach($data as $dt)
{{--        {{dd($data)}}--}}
        <tr>
            <td class="text-left">{{$dt->department_name}}</td>
            <td class="text-right">{{$dt->initials}}</td>
            <td class="text-right">{{$dt->in_progress}}</td>
            <td class="text-right">{{$dt->out_of_schedule}}</td>
            <td class="text-right">{{$dt->completed }}</td>
            <td class="text-right">{{$dt->time_extended}}</td>
            <td class="text-right">{{$dt->dev_partner_exist}}</td>
            <td class="text-right">{{$dt->dev_partner_not_exist}}</td>
        </tr>
    @endforeach
@else

    <div class="card" style="height: 95%">
        <div class="card-header bg-rgba-primary p-1 shadow-lg">
            <h4 class="card-title float-left">Contract Management</h4>
            <a href="#" class="float-right  zoom-on"><i class="ficon bx bx-fullscreen"></i></a>
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
                                    <th class="text-left">Department Name</th>
                                    <th class="text-right">Initial</th>
                                    <th class="text-right">In Progress</th>
                                    <th class="text-right">Out Of Schedule</th>
                                    <th class="text-right">Completed</th>
                                    <th class="text-right">Extended Time</th>
                                    <th class="text-right">Dev Partner Exist</th>
                                    <th class="text-right">Dev Partner Not Exist</th>
                                </tr>
                                </thead>
                                <tbody id="civil-engineering-data">

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
