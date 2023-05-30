<!-- Modal content-->
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">TODAY'S COLLECTION CONTAINER DETAILS</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
        <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th>SL</th>
                <th>Container No</th>
{{--                <th>Container Size</th>--}}
                <th>Bill No</th>
                <th>Bill Amount</th>
                <th>Paid Bill No</th>
                <th>Paid Bill Amount</th>
                <th>Bill Status</th>
                <th>Vessel Registration</th>
                <th>CNF Agent Code</th>
                <th>CNF Agent</th>
            </tr>
            @php $i = 1; @endphp
            @foreach($data as $val)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$val->container_no}}</td>
{{--                    <td>{{$val->container_size}}</td>--}}
                    <td>{{$val->bill_no}}</td>
                    <td>{{$val->bill_amount}}</td>
                    <td>{{$val->paid_bill_no}}</td>
                    <td>{{$val->paid_amount}}</td>
                    <td>{{$val->final_bill}}</td>
                    <td>{{$val->vessel_reg_no}}</td>
                    <td>{{$val->cnf_agent_code}}</td>
                    <td>{{$val->cnf_agent_name}}</td>
                </tr>
            @endforeach
        </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>
