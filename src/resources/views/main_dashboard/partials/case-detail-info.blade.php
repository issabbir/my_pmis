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
                                <th class="text-right">CASE NO</th>
                                <th class="text-right">CASE DATE</th>
                                <th class="text-right">CASE CATEGORY</th>
                                <th class="text-right">COURT</th>
                                <th class="text-right">CASE STATUS</th>
                                <th class="text-right">AUTHORISED OFFICER</th>
                            </tr>
                            </thead>
                            <tbody id="house-allotment-data">
                            @if(isset($data))
                                @foreach($data as $key=>$value)
                                    <tr role="row">
                                        <td aria-colindex="7" role="cell">
                                            @if($value->case_no!=null)
                                                {{$value->case_no}}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td aria-colindex="10" role="cell">
                                            @if($value->case_date!=null)
                                                {{date('Y-m-d', strtotime($value->case_date))}}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td aria-colindex="7" role="cell">
                                            @if($value->category_name!=null)
                                                {{$value->category_name}}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td aria-colindex="7" role="cell">
                                            @if($value->court_name!=null && $value->court_category_name)
                                                {{$value->court_name.' ('.$value->court_category_name.')'}}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td aria-colindex="7" role="cell">
                                            @if($value->case_status_name!=null)
                                                {{$value->case_status_name}}
                                            @else
                                                --
                                            @endif
                                        </td>
                                        <td aria-colindex="7" role="cell">
                                            @if($value->emp_name!=null && $value->department_name)
                                                {{$value->emp_name.' ('.$value->department_name.')'}}
                                            @else
                                                --
                                            @endif
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
