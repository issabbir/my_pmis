    <div class="card" style="height: 95%">
        <div class="card-header bg-rgba-primary p-1">
            <h6 class="card-title float-left">Attendance</h6>
            <a href="#" class="float-right zoom-on"><i class="ficon bx bx-fullscreen"></i></a>
        </div>
        <div class="card-content mt-1 ">
            <div class="card-body pb-0 text-center">
                <div class="row">
                    <div class="d-flex justify-content-center align-items-center col-md-2 text-bold-700">
                        {{$emp_data['statistics']['attendance']['label']}}
                    </div>
                    <div class="d-flex justify-content-center align-items-center col-md-3">
                        <div class="avatar bg-rgba-primary  p-25 mr-75 mr-xl-2 ">
                            <div class="avatar-content">
                                <i class="bx bx-user text-primary font-medium-2"></i>
                            </div>
                        </div>
                        <div class="total-amount">
                            <h5 class="mb-0">@if(isset($emp_data['statistics']['attendance']['total'])) {{$emp_data['statistics']['attendance']['total']}} @else 0 @endif</h5>
                            <small class="text-muted"></small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center align-items-center col-md-4">
                        <div class="avatar  p-25 mr-75 mr-xl-2" style="background-color: #5A8DEE">
                            <div class="avatar-content">
                                <i class="bx bx-user text-warning font-medium-2"></i>
                            </div>
                        </div>
                        <div class="total-amount">
                            <h5 class="mb-0">@if(isset($emp_data['statistics']['attendance']['officer'])) {{$emp_data['statistics']['attendance']['officer']}} @else 0 @endif</h5>
                            <small class="text-muted"></small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center align-items-center col-md-3">
                        <div class="avatar  p-25 mr-75 mr-xl-2" style="background-color: #4BC0C0">
                            <div class="avatar-content">
                                <i class="bx bx-user text-warning font-medium-2"></i>
                            </div>
                        </div>
                        <div class="total-amount">
                            <h5 class="mb-0">@if(isset($emp_data['statistics']['attendance']['staff'])) {{$emp_data['statistics']['attendance']['staff']}} @else 0 @endif</h5>
                            <small class="text-muted"></small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex justify-content-center align-items-center col-md-2 text-bold-700">
                        {{$emp_data['statistics']['absent']['label']}}
                    </div>
                    <div class="d-flex justify-content-center align-items-center col-md-3">
                        <div class="avatar bg-rgba-primary  p-25 mr-75 mr-xl-2">
                            <div class="avatar-content">
                                <i class="bx bx-user text-primary font-medium-2"></i>
                            </div>
                        </div>
                        <div class="total-amount">
                            <h5 class="mb-0">@if(isset($emp_data['statistics']['absent']['total'])) {{$emp_data['statistics']['absent']['total']}} @else 0 @endif</h5>
                            <small class="text-muted">Total</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center align-items-center col-md-4">
                        <div class="avatar  p-25 mr-75 mr-xl-2" style="background-color: #5A8DEE">
                            <div class="avatar-content">
                                <i class="bx bx-user text-warning font-medium-2"></i>
                            </div>
                        </div>
                        <div class="total-amount">
                            <h5 class="mb-0">@if(isset($emp_data['statistics']['absent']['officer'])) {{$emp_data['statistics']['absent']['officer']}} @else 0 @endif</h5>
                            <small class="text-muted">Officer</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center align-items-center col-md-3">
                        <div class="avatar  p-25 mr-75 mr-xl-2" style="background-color: #4BC0C0">
                            <div class="avatar-content">
                                <i class="bx bx-user text-warning font-medium-2"></i>
                            </div>
                        </div>
                        <div class="total-amount">
                            <h5 class="mb-0">@if(isset($emp_data['statistics']['absent']['staff'])) {{$emp_data['statistics']['absent']['staff']}} @else 0 @endif</h5>
                            <small class="text-muted">Staff</small>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="pie-chart-wrapper" >
                    <canvas id="employee-details" class="d-flex justify-content-center" ></canvas>
                </div>
            </div>

        </div>
    </div>

