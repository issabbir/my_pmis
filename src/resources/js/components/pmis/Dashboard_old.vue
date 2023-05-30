<template>
     <div class="content-wrapper">
        <div class="content-body">
            <!-- Dashboard Analytics Start -->
            <section id="dashboard-analytics">

                    <div class="row">
                        <div class="col-md-6">
                        <div class="card first_row">
                            <div class="card-header bg-rgba-primary p-1">
                                <h6 class="card-title">Employee</h6>
                            </div>
                            <div class="row">
                            <!-- Order Summary Starts -->
                            <div class="col-md-7 border-right pr-md-0">
                                <div class="card mb-0">
                                <div class="card-content">
                                    <div class="card-body p-0">
                                        <div class="d-flex justify-content-around align-items-center flex-wrap mt-1">
                                        <div class="user-analytics">
                                            <i class="bx bx-user mr-25 align-middle"></i>
                                            <span class="align-middle text-muted">Users</span>
                                            <div class="d-flex">
                                            <div id="radial-success-chart"></div>
                                            <h3 class="mt-1 ml-50">6000</h3>
                                            </div>
                                        </div>
                                        <div class="sessions-analytics">
                                            <i class="bx bx-trending-up align-middle mr-25"></i>
                                            <span class="align-middle text-muted">Officer</span>
                                            <div class="d-flex">
                                            <div id="radial-warning-chart"></div>
                                            <h3 class="mt-1 ml-50">960</h3>
                                            </div>
                                        </div>
                                        <div class="bounce-rate-analytics">
                                            <i class="bx bx-pie-chart-alt align-middle mr-25"></i>
                                            <span class="align-middle text-muted">Staff</span>
                                            <div class="d-flex">
                                            <div id="radial-danger-chart"></div>
                                            <h3 class="mt-1 ml-50">5060</h3>
                                            </div>
                                        </div>
                                        </div>
                                          <div class="card-content">
                                            <div class="card-body donut-chart-wrapper pt-0">
                                                <div id="donut-chart" class="d-flex justify-content-center"></div>
                                                <ul class="list-inline d-flex justify-content-around mb-0">
                                                <li> <span class="bullet bullet-xs bullet-primary mr-50"></span>Hired</li>
                                                <!--li> <span class="bullet bullet-xs bullet-warning mr-50"></span>Vacant</li-->
                                                <li> <span class="bullet bullet-xs bullet-info mr-50"></span>Vacant</li>
                                                </ul>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                     <!-- table start -->
                                                     <div class="table-responsive">
                                                        <table class="table table-striped table-bordered table-hover table-sm mt-1 mb-0">
                                                            <thead>
                                                                <tr>
                                                                <th>Type</th>
                                                                <th>Late Present</th>
                                                                <th>On Leave</th>
                                                                <th>Trining</th>
                                                                <th>Tour</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                <th>Total</th>
                                                                <td>12</td>
                                                                <td>50</td>
                                                                <td>10</td>
                                                                <td>17</td>
                                                                </tr>
                                                                <tr>
                                                                <th>Officer</th>
                                                                <td>90</td>
                                                                <td>45</td>
                                                                <td>10</td>
                                                                <td>07</td>
                                                                </tr>
                                                                <tr>
                                                                <th>Staff</th>
                                                                <td>10</td>
                                                                <td>05</td>
                                                                <td>0</td>
                                                                <td>10</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        </div>
                                                     <!-- table ends -->
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- Gender Ration Starts -->
                            <div class="col-md-5 col-12 pl-md-0">
                                <div class="card mb-0">
                                <div class="card-header pb-50">
                                    <h4 class="card-title">Gender Ratio</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body py-1">
                                        <div class="d-inline-block">
                                        <!-- chart-1   -->
                                        <div class="d-flex market-statistics-1">
                                            <!-- chart-statistics-1 -->
                                            <div id="donut-success-chart"></div>
                                            <!-- data -->
                                            <div class="statistics-data my-auto">
                                            <div class="statistics">
                                                <span class="font-medium-2 mr-50 text-bold-600">Male</span>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="d-inline-block">
                                        <!-- chart-2 -->
                                        <div class="d-flex mb-75 market-statistics-2">
                                            <!-- chart statistics-2 -->
                                            <div id="donut-danger-chart"></div>
                                            <!-- data-2 -->
                                            <div class="statistics-data my-auto">
                                            <div class="statistics">
                                                <span class="font-medium-2 mr-50 text-bold-600">Female</span>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="card-footer border-top pb-0">
                                    <h5>Today Present</h5>
                                    <div class="d-flex align-items-center mt-1">
                                        <div class="avatar bg-rgba-primary  p-25 mr-75 mr-xl-2">
                                        <div class="avatar-content">
                                            <i class="bx bx-user text-primary font-medium-2"></i>
                                        </div>
                                        </div>
                                        <div class="total-amount">
                                        <h5 class="mb-0">5,900</h5>
                                        <small class="text-muted">Total</small>
                                        </div>
                                    </div>


                                    <div class="d-flex align-items-center mt-1">
                                        <div class="avatar bg-rgba-warning  p-25 mr-75 mr-xl-2">
                                        <div class="avatar-content">
                                            <i class="bx bx-dollar text-warning font-medium-2"></i>
                                        </div>
                                        </div>
                                        <div class="total-amount">
                                        <h5 class="mb-0">900</h5>
                                        <small class="text-muted">Officer</small>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center mt-1">
                                        <div class="avatar bg-rgba-warning  p-25 mr-75 mr-xl-2">
                                        <div class="avatar-content">
                                            <i class="bx bx-dollar text-warning font-medium-2"></i>
                                        </div>
                                        </div>
                                        <div class="total-amount">
                                        <h5 class="mb-0">5,000</h5>
                                        <small class="text-muted">Staff</small>
                                        </div>
                                    </div>


                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        <!--Employee Part End--->

                        <!-- Acounts & Finance End -->
                        <div class="col-md-2">
                        <h4 class="border-bottom">Accounts & Finance</h4>

                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12">
                            <div class="card text-center mb-1">
                                <div class="card-content">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto my-1">
                                    <i class="bx bx-briefcase font-medium-5"></i>
                                    <h2 class="mb-0">&nbsp;502M</h2>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">Income</p>

                                </div>
                                </div>
                            </div>
                            </div>
                            <div class="col-xl-12 col-md-12 col-sm-12">
                            <div class="card text-center mb-1">
                                <div class="card-content">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto my-1">
                                    <i class="bx bx-money font-medium-5"></i>
                                    <h2 class="mb-0">&nbsp;200M</h2>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">Expenses</p>

                                </div>
                                </div>
                            </div>
                            </div>
                            <div class="col-xl-12 col-md-12 col-sm-12">
                            <div class="card text-center">
                                <div class="card-content">
                                <div class="card-body">
                                    <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto my-1">
                                    <i class="bx bx-dollar font-medium-5"></i>
                                    <h2 class="mb-0">&nbsp;298M</h2>
                                    </div>
                                    <p class="text-muted mb-0 line-ellipsis">Balance</p>

                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        <!-- Accounts & Finance End -->

                        <!-- Sales and training section Start -->
                        <div class="col-md-4">
                            <div class="row">
                            <!-----Salary-------->
                            <div class="col-md-12">
                                <section id="basic-tabs-components">
                                <div class="card mb-1">
                                    <div class="card-header bg-rgba-primary p-1">
                                        <h6 class="card-title">Salary</h6>
                                    </div>
                                    <div class="card-content mt-1">
                                    <div class="card-body">
                                        <div class="tab-content">
                                        <div class="tab-pane active table-responsive" id="home" aria-labelledby="home-tab" role="tabpanel">
                                            <table class="table table-borderless table-sm mb-0">
                                                <thead>
                                                    <tr>
                                                    <th>#</th>
                                                    <th>Aug-2019</th>
                                                    <th>Sep-2019</th>
                                                    <th>Change</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <td>Salary</td>
                                                    <td><span class="badge badge-light-warning">4750003/-</span></td>
                                                    <td><span class="badge badge-light-warning">4750003/-</span></td>
                                                    <td><i class="bx bx-trending-up text-warning align-middle mr-50"></i><span>3%</span></td>
                                                    </tr>
                                                    <tr>
                                                    <td>OT</td>
                                                    <td><span class="badge badge-light-success">1320495/-</span></td>
                                                    <td><span class="badge badge-light-success">1520546/-</span></td>
                                                    <td><i class="bx bx-trending-up text-success align-middle mr-50"></i><span>4.2%</span></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Night Allowance</td>
                                                    <td><span class="badge badge-light-primary">346500/-</span></td>
                                                    <td><span class="badge badge-light-primary">335890/-</span></td>
                                                    <td><i class="bx bx-trending-down text-primary align-middle mr-50"></i><span>1.3%</span></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Pension Amount</td>
                                                    <td><span class="badge badge-light-danger">25055364/-</span></td>
                                                    <td><span class="badge badge-light-danger">25055364/-</span></td>
                                                    <td><i class="bx bx-move-horizontal text-danger align-middle mr-50"></i><span>0%</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </section>
                            </div>
                            <!-----Sales & Inventory End-------->
                            <!-----Training Start-------->
                            <div class="col-md-12">
                                <div class="card">
                                <div class="card-header bg-rgba-primary p-1 mb-1">
                                    <h4 class="card-title">Training</h4>
                                </div>
                                    <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <a class="border-bottom-primary" href="#">Training Calender</a>
                                        <!-- table start -->
                                            <table class="table table-striped table-bordered table-hover table-sm mt-1 mb-0">
                                                <thead>
                                                    <tr>
                                                    <th>Type</th>
                                                    <th>Oct-19</th>
                                                    <th>Nov-19</th>
                                                    <th>Dec-19</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <td>In-House</td>
                                                    <td>5</td>
                                                    <td>1</td>
                                                    <td>0</td>
                                                    </tr>
                                                    <tr>
                                                    <td>External</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>1</td>
                                                    </tr>
                                                    <tr>
                                                    <td>Abroad</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        <!-- table ends -->
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <!-----Training End-------->
                            </div>
                        </div>
                        <!-- Sales and training section End -->
                    </div>

                    <div class="row">
                        <!-- Impression Radial Chart Starts-->
                        <div class="col-md-4">
                        <div class="card second_row">
                            <div class="card-header bg-rgba-primary p-1">
                            <h6 class="card-title">Inventory</h6>
                            <!--i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i-->
                            </div>
                            <!-- table start -->
                            <div class="card-content mt-1">
                                            <div class="card-body donut-chart-wrapper ">
                                                <table class="table table-striped table-hover table-sm mt-1">
                                                    <thead>
                                                        <tr>
                                                        <th>&nbsp;#</th>
                                                        <th>2016</th>
                                                        <th>2017</th>
                                                        <th>2018</th>
                                                        <th>2019</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                        <td>Current Asset</td>
                                                        <td>150</td>
                                                        <td>240</td>
                                                        <td>290</td>
                                                        <td>300</td>
                                                        </tr>
                                                        <tr>
                                                        <td>Fixed Asset</td>
                                                        <td>398</td>
                                                        <td>440</td>
                                                        <td>460</td>
                                                        <td>500</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <span class="align-middle border-bottom-dark">In BDT Million</span>
                                            <!-- table ends -->

                        </div>
                        </div>
                        </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card second_row">
                            <div class="card-header bg-rgba-primary p-1">
                                <h4 class="card-title">Security</h4>
                            </div>
                                <div class="card-content">
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <!-- table start -->
                                        <table class="table table-striped table-hover table-sm mt-1">
                                            <thead>
                                                <tr>
                                                <th>&nbsp;#</th>
                                                <th>Today</th>
                                                <th>As Of Today</th>
                                                <th>Last Month</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="">
                                                <td class="">Gate Pass</td>
                                                <td>9</td>
                                                <td>50</td>
                                                <td>60</td>
                                                </tr>
                                                <tr>
                                                <td class="">License</td>
                                                <td>1</td>
                                                <td>5</td>
                                                <td>8</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table class="table table-striped table-hover table-sm">
                                            <thead>
                                                <tr>
                                                <th>&nbsp;#</th>
                                                <th>Employee</th>
                                                <th>Visitor</th>
                                                <th>Agent</th>
                                                <th>Vehicle</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <td>No at Jetty</td>
                                                <td>2550</td>
                                                <td>113</td>
                                                <td>60</td>
                                                <td>119</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <!-- table ends -->
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card second_row">
                            <div class="card-header bg-rgba-primary p-1">
                                <h4 class="card-title">Audit</h4>
                            </div>
                                <div class="card-content">
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <!-- table start -->
                                        <table class="table table-striped table-bordered table-hover table-sm mt-1 text-center">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" class="align-middle">year</th>
                                                    <th rowspan="2" class="align-middle">Total</th>
                                                    <th colspan="3">Internal</th>
                                                    <th colspan="3">Govt.</th>
                                                </tr>
                                                <tr>
                                                    <th>Total</th>
                                                    <th>On Going</th>
                                                    <th>Close</th>
                                                    <th>Total</th>
                                                    <th>On Going</th>
                                                    <th>Close</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>2019</td>
                                                    <td>50</td>
                                                    <td>41</td>
                                                    <td>5</td>
                                                    <td>36</td>
                                                    <td>9</td>
                                                    <td>1</td>
                                                    <td>8</td>
                                                </tr>
                                                <tr>
                                                    <td>2018</td>
                                                    <td>30</td>
                                                    <td>27</td>
                                                    <td>1</td>
                                                    <td>26</td>
                                                    <td>3</td>
                                                    <td>0</td>
                                                    <td>3</td>
                                                </tr>
                                                <tr>
                                                    <td>2017</td>
                                                    <td>39</td>
                                                    <td>50</td>
                                                    <td>1</td>
                                                    <td>29</td>
                                                    <td>9</td>
                                                    <td>0</td>
                                                    <td>9</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <!-- table ends -->
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                        <div class="card">
                        <div class="card-header bg-rgba-primary p-1">
                            <h4 class="card-title">Traffic</h4>
                        </div>
                            <div class="card-content">
                            <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                    <!-- table start -->
                                        <table class="table table-striped table-bordered  table-hover table-sm mt-1">
                                            <thead class="thead-dark">
                                                <tr>
                                                <th>#</th>
                                                <th>Berthing</th>
                                                <th>Waiting</th>
                                                <th>Outer Anchorage Parking</th>
                                                <th>Outer Anchorage Entry</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <td class="font-weight-bold">Cargo</td>
                                                <td>5</td>
                                                <td><i class="bx bxs-circle warning font-small-1 mr-50"></i><span>5</span></td>
                                                <td>3</td>
                                                <td><i class="bx bxs-circle success font-small-1 mr-50"></i><span>15</span></td>
                                                </tr>
                                                <tr>
                                                <td class="font-weight-bold">Container</td>
                                                <td>11</td>
                                                <td><i class="bx bxs-circle warning font-small-1 mr-50"></i><span>12</span></td>
                                                <td>14</td>
                                                <td><i class="bx bxs-circle success font-small-1 mr-50"></i><span>20</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <!-- table ends -->
                                    </div>
                                    </div>
                                </div>
                                <div class="row ml-1 mr-1 mt-1 shadow-lg bg-white rounded p-2">
                                    <div class="col-md-6">
                                        <div class="col-md-12 border border-info ">
                                            <LineChart :chart-data="CargoContainerChart" :options="options"/>
                                            <!-- <canvas id="CargoContainerChart" width="300" height="300"></canvas> -->
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12 border border-info ">
                                            <LineChart :chart-data="vesselHandleChart" :options="options"/>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            </div>
                            </div>
                        </div>
                    </div>

                    <!-- Files Hydrography Starts -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card third_row">
                            <div class="card-header bg-rgba-primary p-1">
                                <h4 class="card-title">Estate</h4>
                            </div>
                                <div class="card-content">
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <!-- table start -->
                                        <table class="table table-striped table-hover table-sm mt-1">
                                            <thead>
                                                <tr>
                                                    <th>No Of Load</th>
                                                    <th>Commercial</th>
                                                    <th>Non-Commercial</th>
                                                    <th>Area</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>80</td>
                                                    <td>50</td>
                                                    <td>30</td>
                                                    <td>550 Acr</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <!-- table ends -->
                                    <!-- table start -->
                                        <table class="table table-striped table-hover table-sm mt-1">
                                            <thead>
                                                <tr>
                                                    <th>Status</th>
                                                    <th>Commercial</th>
                                                    <th>Non-Commercial</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Lease</td>
                                                    <td>20</td>
                                                    <td>10</td>
                                                </tr>
                                                <tr>
                                                    <td>Rent</td>
                                                    <td>30</td>
                                                    <td>20</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <!-- table ends -->
                                    <!-- table start -->
                                        <table class="table table-bordered table-sm mt-1">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                    <th>Commercial</th>
                                                    <th>Non-Commercial</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td rowspan="2">Income&nbsp;</td>
                                                    <td>Lease</td>
                                                    <td>15000000</td>
                                                    <td>3750390</td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>Rent</td>
                                                    <td>60000000</td>
                                                    <td>990000</td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td rowspan="2">Expenses</td>
                                                    <td>Lease</td>
                                                    <td>390000</td>
                                                    <td>50390</td>
                                                </tr><tr class="text-center">
                                                    <td>Rent</td>
                                                    <td>30000</td>
                                                    <td>9000</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <!-- table ends -->
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!--Case Start-->
                        <div class="col-md-4 ">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mb-1 third_row">
                                    <div class="card-header bg-rgba-primary p-1">
                                        <h4 class="card-title">Case</h4>
                                    </div>
                                        <div class="card-content">
                                        <div class="card-body pb-0">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="d-flex activity-content mt-1">
                                                    <div class="avatar bg-rgba-primary m-0 mr-75">
                                                        <div class="avatar-content">
                                                        <i class="bx bx-bar-chart-alt-2 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="activity-progress flex-grow-1">
                                                        <small class="text-muted d-inline-block mb-50">Total</small>
                                                        <small class="float-right">500</small>
                                                        <div class="progress progress-bar-primary progress-sm">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="100" style="width:100%"></div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="d-flex activity-content">
                                                    <div class="avatar bg-rgba-success m-0 mr-75">
                                                        <div class="avatar-content">
                                                        <i class="bx bx-check text-success"></i>
                                                        </div>
                                                    </div>
                                                    <div class="activity-progress flex-grow-1">
                                                        <small class="text-muted d-inline-block mb-50">Closed</small>
                                                        <small class="float-right">360</small>
                                                        <div class="progress progress-bar-success progress-sm">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="72" style="width:72%"></div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="d-flex activity-content">
                                                    <div class="avatar bg-rgba-warning m-0 mr-75">
                                                        <div class="avatar-content">
                                                        <i class="bx bx-stats text-warning"></i>
                                                        </div>
                                                    </div>
                                                    <div class="activity-progress flex-grow-1">
                                                        <small class="text-muted d-inline-block mb-50">Ongoing</small>
                                                        <small class="float-right">140</small>
                                                        <div class="progress progress-bar-warning progress-sm">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="28" style="width:28%"></div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="table-responsive ">
                                                    <!-- table start -->
                                                    <table class="table table-striped table-hover table-sm mt-3">
                                                        <thead>
                                                            <tr>
                                                            <th>Year</th>
                                                            <th>Total</th>
                                                            <th>Closed</th>
                                                            <th>Ongoing</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <tr>
                                                            <td>2019</td>
                                                            <td>45</td>
                                                            <td>5</td>
                                                            <td>40</td>
                                                            </tr>
                                                            <tr>
                                                            <td>2018</td>
                                                            <td>55</td>
                                                            <td>20</td>
                                                            <td>35</td>
                                                            </tr>
                                                            <tr>
                                                            <td>2017</td>
                                                            <td>25</td>
                                                            <td>15</td>
                                                            <td>10</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!-- table ends -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Case End-->

                        <!--House Allotment Start-->
                        <div class="col-md-4 ">
                            <div class="card third_row">
                            <div class="card-header bg-rgba-primary p-1">
                                <h4 class="card-title">House Allotment</h4>
                            </div>
                                <div class="card-content">
                                <div class="card-body">
                                    <div class="row mt-1">
                                        <div class="col-md-5">
                                            <table class="table table-borderless table-sm">
                                                <tbody>
                                                <tr>
                                                    <td>Res</td>
                                                    <td><span class="badge badge-light-success">700</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Non-Res</td>
                                                    <td><span class="badge badge-light-danger">250</span></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="table-responsive ">
                                                <table class="table table-striped table-bordered table-hover table-sm">
                                                <thead>
                                                    <tr>
                                                    <th>Available</th>
                                                    <th>Application</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <td>10</td>
                                                    <td>15</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- table start -->
                                            <div class="table-responsive ">
                                            <table class="table table-striped table-bordered table-hover table-sm mt-1">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" class="align-middle">Type</th>
                                                        <th rowspan="2" class="align-middle">Total</th>
                                                        <th rowspan="2" class="align-middle">Occupied</th>
                                                        <th rowspan="2" class="align-middle">Maintenance</th>
                                                        <th colspan="2">Next Month</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Ready</th>
                                                        <th>Vacant</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Bungalow</td>
                                                        <td>20</td>
                                                        <td>20</td>
                                                        <td>0</td>
                                                        <td>0</td>
                                                        <td>1</td>
                                                    </tr>
                                                    <tr>
                                                        <td>F</td>
                                                        <td>30</td>
                                                        <td>25</td>
                                                        <td>5</td>
                                                        <td>1</td>
                                                        <td>1</td>
                                                    </tr>
                                                    <tr>
                                                        <td>E</td>
                                                        <td>100</td>
                                                        <td>100</td>
                                                        <td>0</td>
                                                        <td>10</td>
                                                        <td>5</td>
                                                    </tr>
                                                    <tr>
                                                        <td>D</td>
                                                        <td>100</td>
                                                        <td>95</td>
                                                        <td>5</td>
                                                        <td>5</td>
                                                        <td>15</td>
                                                    </tr>
                                                    <tr>
                                                        <td>C</td>
                                                        <td>100</td>
                                                        <td>98</td>
                                                        <td>2</td>
                                                        <td>10</td>
                                                        <td>2</td>
                                                    </tr>
                                                    <tr>
                                                        <td>B</td>
                                                        <td>200</td>
                                                        <td>188</td>
                                                        <td>12</td>
                                                        <td>25</td>
                                                        <td>5</td>
                                                    </tr>
                                                    <tr>
                                                        <td>A</td>
                                                        <td>200</td>
                                                        <td>200</td>
                                                        <td>0</td>
                                                        <td>50</td>
                                                        <td>15</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        <!-- table ends -->
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!--House Allotment End-->
                    </div>
                    <!-- Hydrography End -->

                    <!-- Estate Section Start-->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card forth_row">
                            <div class="card-header bg-rgba-primary p-1">
                                <h4 class="card-title">Hydrography</h4>
                            </div>
                                <div class="card-content">
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <!-- table start -->
                                        <table class="table table-striped table-bordered table-hover table-sm mt-1">
                                            <thead>
                                                <tr class="text-center">
                                                    <th rowspan="2" class="align-middle">Name</th>
                                                    <th>Sep-19</th>
                                                    <th>Sep-19</th>
                                                    <th>Oct-19</th>
                                                    <th>Oct-19</th>
                                                </tr>
                                                <tr class="text-center">
                                                    <th>01 - 15</th>
                                                    <th>16 - 30</th>
                                                    <th>1 - 15</th>
                                                    <th>16 - 31</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td>Survey Schedule</td>
                                                    <td><a href="#"><i class="bx bx-download"></i></a></td>
                                                    <td><a href="#"><i class="bx bx-download"></i></a></td>
                                                    <td><a href="#"><i class="bx bx-download"></i></a></td>
                                                    <td><a href="#"><i class="bx bx-download"></i></a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <!-- table ends -->
                                    <!-- table start -->
                                        <table class="table table-striped table-bordered table-hover table-sm mt-1">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Name</th>
                                                    <th>Q1-19</th>
                                                    <th>Q2-19</th>
                                                    <th>Q3-19</th>
                                                    <th>Q4-19</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td>Survey Chart</td>
                                                    <td><a href="#"><i class="bx bx-download"></i></a></td>
                                                    <td><a href="#"><i class="bx bx-download"></i></a></td>
                                                    <td><a href="#"><i class="bx bx-download"></i></a></td>
                                                    <td><a href="#"><i class="bx bx-download"></i></a></td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>Sale Amount</td>
                                                    <td>30000</td>
                                                    <td>60000</td>
                                                    <td>45000</td>
                                                    <td>60000</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <!-- table ends -->
                                    <!-- table start -->
                                        <table class="table table-striped table-bordered table-hover table-sm mt-1">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Name</th>
                                                    <th>Q1-19</th>
                                                    <th>Q2-19</th>
                                                    <th>Q3-19</th>
                                                    <th>Q4-19</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center">
                                                    <td>Survey Chart</td>
                                                    <td><a href="#"><i class="bx bx-download"></i></a></td>
                                                    <td><a href="#"><i class="bx bx-download"></i></a></td>
                                                    <td><a href="#"><i class="bx bx-download"></i></a></td>
                                                    <td><a href="#"><i class="bx bx-download"></i></a></td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>Sale Amount</td>
                                                    <td>700000</td>
                                                    <td>850000</td>
                                                    <td>105000</td>
                                                    <td>900000</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <!-- table ends -->
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!----Start Civil Engineering-->
                        <div class="col-md-4">
                            <div class="card forth_row">
                            <div class="card-header bg-rgba-primary p-1">
                                <h4 class="card-title">Civil Engineering</h4>
                            </div>
                                <div class="card-content">
                                <div class="card-body">
                                    <div class="table-responsive">
                                    <!-- table start -->
                                        <table class="table table-hover table-sm mt-1">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Total</th>
                                                    <th>Ongoing</th>
                                                    <th>Completed</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>&nbsp;~</td>
                                                    <td>54</td>
                                                    <td>9</td>
                                                    <td>45</td>
                                                </tr><tr>
                                                    <td>Residential</td>
                                                    <td>30</td>
                                                    <td>5</td>
                                                    <td>25</td>
                                                </tr><tr>
                                                    <td>Jetty</td>
                                                    <td>15</td>
                                                    <td>3</td>
                                                    <td>12</td>
                                                </tr><tr>
                                                    <td>Shed</td>
                                                    <td>9</td>
                                                    <td>1</td>
                                                    <td>8</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <!-- table ends -->
                                    <!-- table start -->
                                        <table class="table table-striped table-bordered table-hover table-sm mt-1">
                                            <thead >
                                                <tr>
                                                    <th>Variation</th>
                                                    <th>Schedule</th>
                                                    <th>Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Residential</td>
                                                    <td>-5%</td>
                                                    <td>-12%</td>
                                                </tr>
                                                <tr>
                                                    <td>Jetty</td>
                                                    <td>1%</td>
                                                    <td>0.99%</td>
                                                </tr>
                                                <tr>
                                                    <td>Shed</td>
                                                    <td>2%</td>
                                                    <td>0.65%</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    <!-- table ends -->
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!---End Civil Engineering--->

                        <!---Start---->
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                    <div class="card-header bg-rgba-primary p-1">
                                        <h4 class="card-title">Mechanical Engineering</h4>
                                    </div>
                                        <div class="card-content">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                            <!-- table start -->
                                                <table class="table table-striped table-hover table-sm mt-1">
                                                    <thead >
                                                        <tr>
                                                            <th>Equipment</th>
                                                            <th>Running</th>
                                                            <th>Servicing</th>
                                                            <th>Out Of Order</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>18</td>
                                                            <td><i class="bx bxs-circle success font-small-1 mr-50"></i><span>15</span></td>
                                                            <td><i class="bx bxs-circle primary font-small-1 mr-50"></i><span>2</span></td>
                                                            <td><i class="bx bxs-circle danger font-small-1 mr-50"></i><span>1</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            <!-- table ends -->
                                            </div>
                                        </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="card">
                                    <div class="card-header bg-rgba-primary p-1">
                                        <h4 class="card-title">Electrical Engineering</h4>
                                    </div>
                                        <div class="card-content">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                            <!-- table start -->
                                                <table class="table table-striped table-bordered table-hover table-sm mt-1">
                                                    <thead >
                                                        <tr>
                                                            <th>~</th>
                                                            <th>~</th>
                                                            <th>~</th>
                                                            <th>~</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>~</td>
                                                            <td>~</td>
                                                            <td>~</td>
                                                            <td>~</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            <!-- table ends -->
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!----End--->


                    </div>
                    <!-- Estate Section End-->

                    <div class="row">
                        <div class="col-md-12">
                            <!-- swiper -->
                                <swiper :options="swiperOption">
                                    <swiper-slide>
                                        <b-card class="cardSlide">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5> <b>Asst System Analyst</b></h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <table style="width:100%">
                                                        <tr>
                                                            <th>Post</th>
                                                            <td>10</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Applied</th>
                                                            <td>120</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Short List</th>
                                                            <td>25</td>
                                                        </tr>
                                                    </table>
                                                 </div>
                                                 <div class="col-md-6">
                                                    <i data-v-41736377="" class="bx bxs-circle warning font-small-1 mr-50"></i> <span>Application</span>
                                                </div>
                                            </div>
                                        </b-card>
                                    </swiper-slide>
                                    <swiper-slide>
                                        <b-card class="cardSlide">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5> <b>Greezer</b></h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <table style="width:100%">
                                                        <tr>
                                                            <th>Post</th>
                                                            <td>180</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Applied</th>
                                                            <td>1120</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Short List</th>
                                                            <td>480</td>
                                                        </tr>
                                                    </table>
                                                 </div>
                                                 <div class="col-md-6">
                                                    <i data-v-41736377="" class="bx bxs-circle success font-small-1 mr-50"></i> <span>Written Test </span>
                                                </div>
                                            </div>
                                        </b-card>
                                    </swiper-slide>
                                    <swiper-slide>
                                        <b-card class="cardSlide">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5> <b>Asst System Analyst</b></h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <table style="width:100%">
                                                        <tr>
                                                            <th>Post</th>
                                                            <td>10</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Applied</th>
                                                            <td>120</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Short List</th>
                                                            <td>25</td>
                                                        </tr>
                                                    </table>
                                                 </div>
                                                 <div class="col-md-6">
                                                    <i data-v-41736377="" class="bx bxs-circle warning font-small-1 mr-50"></i> <span>Application</span>
                                                </div>
                                            </div>
                                        </b-card>
                                    </swiper-slide>
                                    <swiper-slide>
                                        <b-card class="cardSlide">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5> <b>Asst System Analyst</b></h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <table style="width:100%">
                                                        <tr>
                                                            <th>Post</th>
                                                            <td>10</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Applied</th>
                                                            <td>120</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Short List</th>
                                                            <td>25</td>
                                                        </tr>
                                                    </table>
                                                 </div>
                                                 <div class="col-md-6">
                                                    <i data-v-41736377="" class="bx bxs-circle warning font-small-1 mr-50"></i> <span>Application</span>
                                                </div>
                                            </div>
                                        </b-card>
                                    </swiper-slide>
                                    <swiper-slide>
                                        <b-card class="cardSlide">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5> <b>Asst System Analyst</b></h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <table style="width:100%">
                                                        <tr>
                                                            <th>Post</th>
                                                            <td>10</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Applied</th>
                                                            <td>120</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Short List</th>
                                                            <td>25</td>
                                                        </tr>
                                                    </table>
                                                 </div>
                                                 <div class="col-md-6">
                                                    <i data-v-41736377="" class="bx bxs-circle warning font-small-1 mr-50"></i> <span>Application</span>
                                                </div>
                                            </div>
                                        </b-card>
                                    </swiper-slide>
                                    <swiper-slide>
                                        <b-card class="cardSlide">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h5> <b>Asst System Analyst</b></h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <table style="width:100%">
                                                        <tr>
                                                            <th>Post</th>
                                                            <td>10</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Applied</th>
                                                            <td>120</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Short List</th>
                                                            <td>25</td>
                                                        </tr>
                                                    </table>
                                                 </div>
                                                 <div class="col-md-6">
                                                    <i data-v-41736377="" class="bx bxs-circle warning font-small-1 mr-50"></i> <span>Application</span>
                                                </div>
                                            </div>
                                        </b-card>
                                    </swiper-slide>
                                    <div class="swiper-button-prev" slot="button-prev"></div>
                                    <div class="swiper-button-next" slot="button-next"></div>
                                    <div class="swiper-pagination" slot="pagination"></div>

                                </swiper>
                        </div>
                    </div>
            </section>
			<!-- Dashboard Analytics end -->
        </div>
    </div>
</template>

<script>
import VueCharts from 'vue-chartjs'
import { Bar, Line } from 'vue-chartjs'
 import LineChart from './partials/LineChart.js'

// require styles
import 'swiper/dist/css/swiper.css'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
     export default {
         extends: Line,
            components: {
                swiper,
                swiperSlide,
                LineChart,
             },
        name: 'carrousel',
        data() {
         return {
            swiperOption: {
            slidesPerView: 4,
            centeredSlides: false,
            spaceBetween: 30,
            grabCursor: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            }
        },
        CargoContainerChart: {
                labels: ['Jul-19', 'Aug-19', 'Sep-19', 'Oct-19'],
                datasets: [
                    {
                        label: 'Container Handle +5%',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        data: [12200,13200, 13250, 15540],
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Cargo Handle +3%',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        data: [47000,48000, 48500, 50000],
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                ]
            },

        vesselHandleChart: {
                labels: ['July-19', 'Aug-19', 'Sep-19', 'Oct-19'],
                datasets: [
                    {
                        label: 'Vessel Handle',
                        backgroundColor: 'rgba(0, 0, 0, 0.0)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        data: [365, 360, 330, 350],
                        borderWidth: 1
                    },
                ],
            },


            options: {
                responsive: true,
                maintainAspectRatio: false
            }
      }
    },
    computed: {
      swiper() {
        return this.$refs.mySwiper.swiper
      }
    },
        mounted() {
            //this.$store.commit("setBreadcrumbEmpty");
            this.$store.commit("setBreadcrumb", {link: "#", label: "PMIS"});
            this.$store.commit("setBreadcrumb", {link: "#", label: "Dahsboard"});
            this.renderChart(this.vesselHandleChart, this.options)
            this.renderChart(this.CargoContainerChart, this.options)
            console.log('this is current swiper instance object', this.swiper)
            this.swiper.slideTo(5, 1000, false)
          },


    }
</script>
<style scoped>
.swiper-container {
    padding: 0px 130px;
 }
  .swiper-slide {
    width: 60%;
    min-height: 200px;
   }
  .swiper-slide:nth-child(2n) {
    width: 40%;
  }
  .swiper-slide:nth-child(3n) {
    width: 20%;
  }
  .card.cardSlide {
        min-height: 180px;
    }
    .first_row{
        min-height: 530px;
     }
    .second_row{
        min-height: 275px;
     }
    .third_row{
        min-height: 500px;
     }
    .forth_row{
        min-height: 410px;
     }

     @media only screen and (max-width: 1400px) {
            .swiper-container {
                padding: 0px !important;
            }
            .swiper-slide {
                width: 50%;
                min-height: 200px;
            }
            .swiper-slide:nth-child(2n) {
                width: 50%;
            }
            .swiper-slide:nth-child(3n) {
                width: 50%;
            }
            .swiper-slide h5{
                font-size: 15px !important;
            }
         #dashboard-analytics h2{
             font-size: 22px !important;
         }
            #dashboard-analytics h4, #dashboard-analytics h6{
                font-size: 15px !important;
            }
         #dashboard-analytics span{
             font-size:12px;
         }
         #dashboard-analytics table tr th{
             font-size:13px;
         }
        }
    @media only screen and (max-width: 640px) {
            .swiper-container {
                padding: 0px !important;
            }
            .swiper-slide {
                width: 100% !important;
                min-height: 200px;
            }
            .swiper-slide:nth-child(2n) {
                width: 100% !important;
            }
            .swiper-slide:nth-child(3n) {
                width: 100% !important;
            }

            .shadow-lg.p-2 {
                padding: 0!important;
            }
        }
</style>
