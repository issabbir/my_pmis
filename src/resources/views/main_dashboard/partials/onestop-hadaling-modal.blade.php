<!-- Modal content-->
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">HANDLING OF CONTAINER</h4>
     </div>
    <div class="modal-body">
        <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th>Container No</th>
                <th>Container Size</th>
                <th>Container Height</th>
                <th>Number of Package</th>
                <th>Vessel Registration</th>
                <th>CNF Agent Code</th>
                <th>CNF Agent</th>
            </tr>
            @foreach($data as $val)
            <tr>
                <td>{{$val->container_no}}</td>
                <td>{{$val->container_size}}</td>
                <td>{{$val->container_height}}</td>
                <td>{{$val->number_of_packages}}</td>
                <td>{{$val->vessel_reg_no_id}}</td>
                <td>{{$val->cnf_agent_code}}</td>
                <td>{{$val->cnf_agent_name}}</td>
            </tr>
            @endforeach
        </table>
        </div>
    </div>
</div>
