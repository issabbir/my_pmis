<div class="card " style="height: 95%">
    <div class="card-header bg-rgba-primary p-1 shadow-lg">
        <h4 class="card-title float-left">Audit</h4>
        <a href="#" class="float-right zoom-on"><i class="ficon bx bx-fullscreen"></i></a>
    </div>
    <div class="card-content mt-1">
        <div class="card-body">
            <ul class="nav nav-tabs mb-0" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="internal-tab" data-toggle="tab" href="#internal" aria-controls="internal" role="tab" aria-selected="true">
                        <span class="align-middle">Internal</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="gov-tab" data-toggle="tab" href="#gov" aria-controls="gov" role="tab" aria-selected="false">
                        <span class="align-middle">Government</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active table-responsive" id="internal" aria-labelledby="internal-tab" role="tabpanel">
                    <table class="table table-bordered table-hover table-striped table-sm mt-1 text-center">
                        <col>
                        <col>
                        <col>
                        <col>
                        <thead class="bg-success bg-light">
                        <tr>
                            <th>year</th>
                            <th>On Going</th>
                            <th>Close</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody id="internal_data">
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane table-responsive" id="gov" aria-labelledby="gov-tab" role="tabpanel">
                    <table class="table table-bordered table-hover table-striped table-sm mt-1 text-center">
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col class="bg-success bg-light">
                        <thead class="bg-success bg-light">
                        <tr>
                            <th>Year</th>
                            <th>Audit Entry</th>
                            <th>Submitted For Initial Approval</th>
                            <th>Initially Approved</th>
                            <th>Initially Rejected</th>
                            <th>Objections Entry</th>
                            <th>Submitted For Objections Approval</th>
                            <th>Objections Approved</th>
                            <th>Objections Rejected</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody id="gov_data">
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
