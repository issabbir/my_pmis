<div class="table-responsive">
    <table id="table_on_leave" class="table datatable mdl-data-table dataTable table-striped table-hover table-bordered table-sm mt-1">
        <thead  class="bg-success bg-light">
        <tr>
            <th>EMPLOYEE CODE</th>
            <th>EMPLOYEE NAME</th>
            <th>DESIGNATION</th>
            <th>DEPARTMENT</th>
            <th>LEAVE TYPE</th>
            <th>APPLICATION DATE</th>
            <th>LEAVE START DATE</th>
            <th>LEAVE END DATE</th>
            <th>LEAVE DAYS</th>
            <th>EMERGENCY NUMBER</th>
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
                <td>{{$val->leave_type}}</td>
                <td>{{date("d/m/Y", strtotime($val->application_date))}}</td>
                <td>{{date("d/m/Y", strtotime($val->leave_start_date))}}</td>
                <td>{{date("d/m/Y", strtotime($val->leave_end_date))}}</td>
                <td>{{$val->leave_days}}</td>
                <td>{{$val->emergency_num}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>