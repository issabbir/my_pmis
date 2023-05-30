<div class="card" style="height: 95%">
    <div class="card-header bg-rgba-primary p-1 shadow-lg">
        <h4 class="card-title float-left">Appointment Statistics</h4>
        <a href="#" class="float-right zoom-on"><i class="ficon bx bx-fullscreen"></i></a>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="table-responsive">
                <!-- table start -->
                <table class="table table-striped table-hover table-bordered table-sm mt-1">
                    <caption style="caption-side: top">Meeting Statistics</caption>
                    <thead  class="bg-success bg-light">
                    <tr>
                        <th>Date</th>
                        <th class="text-right">No Of Meeting</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['prv_meeting_data'] as $key=>$val)
                        <tr class="">
                            <td>{{date("d/m/Y", strtotime($val->meeting_date))}}</td>
                            <td class="text-right">{{isset($val->no_of_meeting)?$val->no_of_meeting:0}}</td>
                        </tr>
                    @endforeach
                    @foreach($data['cur_meeting_data'] as $key=>$val)
                        <tr class="">
                            <td>{{date("d/m/Y", strtotime($val->meeting_date))}}</td>
                            <td class="text-right">{{isset($val->no_of_meeting)?$val->no_of_meeting:0}}</td>
                        </tr>
                    @endforeach
                    @foreach($data['nxt_meeting_data'] as $key=>$val)
                        <tr class="">
                            <td>{{date("d/m/Y", strtotime($val->meeting_date))}}</td>
                            <td class="text-right">{{isset($val->no_of_meeting)?$val->no_of_meeting:0}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <table class="table table-striped table-hover table-sm mt-1 table-bordered">
                    <caption style="caption-side: top">Appointment Statistics</caption>
                    <thead class="bg-success bg-light">
                    <tr>
                        <th>Date</th>
                        <th class="text-right">No Of Appointment</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['prv_appointment_data'] as $key=>$val)
                        <tr class="">
                            <td>{{date("d/m/Y", strtotime($val->appointment_date))}}</td>
                            <td class="text-right">{{isset($val->no_of_appointment)?$val->no_of_appointment:0}}</td>
                        </tr>
                    @endforeach
                    @foreach($data['cur_appointment_data'] as $key=>$val)
                        <tr class="">
                            <td>{{date("d/m/Y", strtotime($val->appointment_date))}}</td>
                            <td class="text-right">{{isset($val->no_of_appointment)?$val->no_of_appointment:0}}</td>
                        </tr>
                    @endforeach
                    @foreach($data['nxt_appointment_data'] as $key=>$val)
                        <tr class="">
                            <td>{{date("d/m/Y", strtotime($val->appointment_date))}}</td>
                            <td class="text-right">{{isset($val->no_of_appointment)?$val->no_of_appointment:0}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
