<div class="table-responsive">
    <table id="table_late_attendance" class="table datatable mdl-data-table dataTable table-striped table-hover table-bordered table-sm mt-1">
        <thead  class="bg-success bg-light">
        <tr>
            <th>EMPLOYEE CODE</th>
            <th>EMPLOYEE NAME</th>
            <th>DESIGNATION</th>
            <th>DEPARTMENT</th>
            <th>ROSTER DATE</th>
            <th>IN TIME</th>
            <th>OUT TIME</th>
            <th>WORK HOURS</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $key => $val)
            <tr class="">
                <td>
                    <a href="/pmis#/employee-profile/{{$val->emp_id}}" target="_blank">
                        {{$val->emp_code}}
                    </a>
                </td>
                <td>{{$val->emp_name}}</td>
                <td>{{$val->designation}}</td>
                <td>{{$val->department_name}}</td>
                <td>{{date("d/m/Y", strtotime($val->roster_date))}}</td>
                <td>{{date("h:i:sa", strtotime($val->in_time))}}</td>
                <td>{{date("h:i:sa", strtotime($val->out_time))}}</td>
                <td>{{$val->work_hours}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>