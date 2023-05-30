    <div class="card" style="height: 95%">
        <div class="card-header bg-rgba-primary p-1 shadow-lg">
            <h6 class="card-title float-left">Employee</h6>
            <a href="#" class="float-right zoom-on"><i class="ficon bx bx-fullscreen"></i></a>
        </div>
        <div class="row mb-0">
            <!-- Order Summary Starts -->
            <div class="col-md-7 border-right pr-md-0 h-100">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-around align-items-center flex-wrap mt-1">
                                <div class="user-analytics">
                                    <i class="bx bx-user mr-25 align-middle"></i>
                                    <span class="align-middle text-muted">Total Employees</span>
                                    <div class="d-flex">
                                        <div id="radial-success-chart"></div>
                                        <h3 class="mt-1 ml-50">@if(isset($emp_data['total']['total'])) {{$emp_data['total']['total']}} @endif </h3>
                                    </div>
                                </div>
                                <div class="sessions-analytics">
                                    <i class="bx bx-trending-up align-middle mr-25"></i>
                                    <span class="align-middle text-muted">Officer</span>
                                    <div class="d-flex">
                                        <div id="radial-warning-chart"></div>
                                        <h3 class="mt-1 ml-50">@if(isset($emp_data['total']['officer'])) {{$emp_data['total']['officer']}} @endif</h3>
                                    </div>
                                </div>
                                <div class="bounce-rate-analytics">
                                    <i class="bx bx-pie-chart-alt align-middle mr-25"></i>
                                    <span class="align-middle text-muted">Staff</span>
                                    <div class="d-flex">
                                        <div id="radial-danger-chart"></div>
                                        <h3 class="mt-1 ml-50">@if(isset($emp_data['total']['staff'])) {{$emp_data['total']['staff']}} @endif</h3>
                                    </div>
                                </div>
                            </div>
                            <canvas id="authorized-position" class="d-flex justify-content-center" ></canvas>
                            {{--<div id="analytics-bar-chart"></div>--}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Gender Ration Starts -->
            <div class="col-md-5 col-12 pl-md-0 h-100">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="card-title text-center mb-0 mt-0">Gender Ratio</div>
                            <div class="pie-chart-wrapper border-top" >
                                <canvas id="male-gender-ratio"  width="250" height="150"></canvas>
                            </div>
                            <div class="pie-chart-wrapper ">
                                <canvas id="female-gender-ratio" width="250" height="150"></canvas>
                            </div>
                            {{--<div class="pie-chart-wrapper" >
                                <canvas id="others-gender-ratio"  width="250" height="150"></canvas>
                            </div>--}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

