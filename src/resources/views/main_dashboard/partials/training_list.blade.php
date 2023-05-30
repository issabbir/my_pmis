<div class="table-responsive">
    <table id="table_training" class="table datatable mdl-data-table dataTable table-striped table-hover table-bordered table-sm mt-1">
        <thead  class="bg-success bg-light">
        <tr>
            <th>EMPLOYEE CODE</th>
            <th>EMPLOYEE NAME</th>
            <th>DESIGNATION</th>
            <th>DEPARTMENT</th>
            <th>TRAINING NAME</th>
            <th>INSTITUTE</th>
            <th>START DATE</th>
            <th>COMPLETION DATE</th>
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
                <td>{{$val->training_name}}</td>
                <td>{{$val->training_institute}}</td>
                <td>{{date("d/m/Y", strtotime($val->training_start_date))}}</td>
                <td>{{date("d/m/Y", strtotime($val->training_completion_date))}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>