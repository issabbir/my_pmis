<div class="table-responsive">
    <table id="table_tour" class="table datatable mdl-data-table dataTable table-striped table-hover table-bordered table-sm mt-1">
        <thead  class="bg-success bg-light">
        <tr>
            <th>EMPLOYEE CODE</th>
            <th>EMPLOYEE NAME</th>
            <th>DESIGNATION</th>
            <th>DEPARTMENT</th>
            <th>TOUR NAME</th>
            <th>TOUR TYPE</th>
            <th>TRAVEL DATE</th>
            <th>RETURN DATE</th>
            <th>DURATION</th>
            <th>COUNTRY</th>
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
                <td>{{$val->tour_name}}</td>
                <td>{{$val->tour_type}}</td>
                <td>{{date("d/m/Y", strtotime($val->travel_date))}}</td>
                <td>{{date("d/m/Y", strtotime($val->travel_date))}}</td>
                <td>{{$val->tour_duration}}</td>
                <td>{{$val->country}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>