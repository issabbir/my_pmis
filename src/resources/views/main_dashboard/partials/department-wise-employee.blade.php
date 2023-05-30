<div class="card" >
    <div class="card-header shadow-lg ">
        <h4 class="card-title float-left text-dark">Department Wise Total Employee</h4>
        <h4 class="card-title float-right text-dark">{{$data[0]->emp_type_name}}</h4>
    </div>
    <div class="card-content">
        <div class="card-body">
            <div class="row list-group list-group-horizontal mt-2">
                @foreach($data as $key => $val)
                    <div style="cursor: pointer" onclick="detail('/cdb/employee-details-list/{{$val->data_for}}/{{$val->emp_type_name}}/{{$val->department_id}}')" class="col-md-3 list-group-item d-flex justify-content-between align-items-center">
                        {{$val->department_name}}
                        <span class="badge badge-primary badge-pill">{{$val->total}}</span>
                    </div>
                @endforeach
            </div>
            <div id="table_content" class="mt-2"></div>
        </div>
    </div>
</div>
