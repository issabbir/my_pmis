<div class="col-md-12">
    <section id="basic-tabs-components">
        <div class="card mb-1">
            <div class="card-header bg-rgba-primary p-1">
                <h6 class="card-title">Salary, Inventory and Training Tab</h6>
            </div>
            <div class="card-content mt-1">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="salary-tab" data-toggle="tab" href="#salary" aria-controls="salary" role="tab" aria-selected="true">
                                <!--i class="bx bx-home align-middle"></i-->
                                <span class="align-middle">Salary</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile" role="tab" aria-selected="false">
                                <!--i class="bx bx-user align-middle"></i-->
                                <span class="align-middle">Fixed Asset</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="training-tab" data-toggle="tab" href="#training" aria-controls="training" role="tab" aria-selected="false">
                                <!--i class="bx bx-user align-middle"></i-->
                                <span class="align-middle">Training</span>
                            </a>
                        </li>

                    </ul>
                    <div class="tab-content border">
                        <div class="tab-pane active table-responsive" id="salary" aria-labelledby="salary-tab" role="tabpanel">
                            <table class="table table-borderless table-sm mt-1 mb-1">
                                <thead id="salaries_label" class="bg-success bg-light"></thead>
                                <tbody id="salaries_data">
                               {{-- <tr>
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
                                </tr>--}}
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane table-responsive" id="profile" aria-labelledby="profile-tab" role="tabpanel">
                            <!-- table start -->
                            <table class="table table-striped table-sm mt-1 mb-1">
                                <thead class="bg-success bg-light">
                                <tr>
                                    <th>Fiscal Year</th>
                                    <th class="text-right">Fixed Asset</th>
                                </tr>
                                </thead>
                                <tbody id="assets_data">
                                </tbody>
                            </table>
                            <!-- table ends -->
                        </div>
                        <div class="tab-pane table-responsive" id="training" aria-labelledby="training-tab" role="tabpanel">
                          {{--  <a class="border-bottom-primary" href="#">Training Calender</a>--}}
                            <table class="table table-bordered table-sm mt-1 mb-1" >
                                <thead class="bg-success bg-light">
                                <tr >
                                    <th>Months</th>
                                    <th>general</th>
                                    <th>automation</th>
                                    <th>basic</th>
                                    <th>cpa automation</th>
                                    <th>directional</th>
                                    <th>financial</th>
                                    <th>it related</th>
                                    <th>operational</th>
                                    <th>system automation</th>
                                    <th>technical</th>
                                </tr>
                                </thead>
                                <tbody id="trainings_data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
