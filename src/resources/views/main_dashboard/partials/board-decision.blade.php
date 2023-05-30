<div class="card" style="height: 95%">
    <div class="card-header bg-rgba-primary p-1 shadow-lg">
        <h4 class="card-title float-left">Board Decision Statistics</h4>
        <a href="#" class="float-right zoom-on"><i class="ficon bx bx-fullscreen"></i></a>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="table-responsive">
                <!-- table start -->
                <table class="table table-striped table-bordered table-hover table-sm mt-1">
                    <thead class="bg-success bg-light">
                    <tr>
                        <th>Year</th>
                        <th class="text-right" >Number Of Decision</th>
                        <th class="text-right" >Number Of Meeting</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $key=>$val)
                        <tr class="">
                            <td>{{$val->meeting_yr}}</td>
                            <td class="text-right">{{$val->no_of_decision}}</td>
                            <td class="text-right">{{$val->no_of_meeting}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
