
@if (isset($ajax) && $ajax)
    @foreach($data as $dt)
{{--                {{dd($data)}}--}}
        <tr>
            <td class="text-left">{{$dt->position}}</td>
            <td class="text-right">{{$dt->total_post}}</td>
            <td class="text-right">{{$dt->applied}}</td>
            <td class="text-left">{{date('Y-m-d',strtotime($dt->deadline))}}</td>
        </tr>
    @endforeach
@else

    <div class="card" style="height: 95%;" >
        <div class="card-header bg-rgba-primary p-1 shadow-lg">
            <h4 class="card-title float-left ">Recruitment</h4>
            <a href="#" class="float-right zoom-on"><i class="ficon bx bx-fullscreen"></i></a>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive" >
                            <!-- table start -->
                            <table class="table table-striped table-bordered table-hover table-sm mt-1" >
                                <col width="60%">
                                <col width="10%">
                                <col width="10%">
                                <col width="20%">
                                <thead>
                                <tr class="bg-light bg-success">
                                    <th class="text-left">Position</th>
                                    <th class="text-right">Post</th>
                                    <th class="text-right">Applied</th>
                                    <th class="text-left">Deadline</th>
                                </tr>
                                </thead>
                                <tbody id="recruitment-data">

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
