<div class="card" style="height: 95%">
    <div class="card-content">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <!-- table start -->
                        <table class="table table-striped table-bordered table-hover table-sm mt-1">
                            <thead>
                            <tr class="bg-light bg-success">
                                <th>AUDIT NAME</th>
                                <th>AUDIT NO.</th>
                                <th>MEMORANDUM NO.</th>
                                <th>FISCAL YEAR</th>
                                <th>ORDER DATE</th>
                                <th>REJECTED COMMENT</th>
                            </tr>
                            </thead>
                            <tbody id="house-allotment-data">
                            @if(isset($data))
                                @foreach($data as $key => $value)
                                    <tr role="row">
                                        <td>
                                            {{$value->audit_name}}
                                        </td>
                                        <td>
                                            {{$value->audit_no}}
                                        </td>
                                        <td>
                                            {{$value->memorandum_no}}
                                        </td>
                                        <td>
                                            {{$value->fiscal_year}}
                                        </td>
                                        <td aria-colindex="10" role="cell">
                                            {{date('Y-m-d', strtotime($value->audit_order_date))}}
                                        </td>
                                        <td>
                                            {{$value->rejected_comment}}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <!-- table ends -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
