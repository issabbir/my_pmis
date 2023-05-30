@extends('layouts.chairman_dashboard')
@section('title')
    Chairman Dashboard
@endsection
@section('styles')
    .card : {
    border-radius: 25px;
    }
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body mt-1"><!-- Dashboard Analytics Start -->
            <section id="dashboard-analytics">
                <div class="row">
                    <div class="col-md-12" id="db_vessel-history">
                        <div class="zoom h-100">
                            <div class="dialog h-100" id="db_vessel_history">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.vessel-history')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2" id="db_container_handling">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.vessel-status')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2" id="db_incoming">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.incoming-desp')
                                </div>
                            </div>
                        </div>
                    </div>
                   {{-- <div class="col-md-6" id="db_traffic">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.vehicles-particulars')
                                </div>
                            </div>
                        </div>
                    </div>--}}

                    <div class="col-md-6" id="db_lying">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.container-lying-position')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="db_traffic">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.traffic')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="db_onestop">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.one-stop-service')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3" id="db_fixed_assets">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.fixed-asset')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3" id="db_accounts">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.accounts')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="db_salary">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.salary')
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6" id="db_position">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.position')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6" id="db_pims">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.pims')
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6" id="db_ha">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.ha')
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4" id="db_fas">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.fas')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4" id="db_fas_ar">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.fas_ar')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" id="db_fas_ap">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.fas_ap')
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4" id="db_recruitment">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.recruitment')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" id="db_case_manage">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.case')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" id="db_audit">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.audit')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4" id="db_board_decision">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100" id="div_board_decision">
                                    <div class="card" style="height: 95%;position: relative">
                                        <div class="card-header bg-rgba-primary p-1 shadow-lg">
                                            <h4 class="card-title float-left">Board Decision Statistics</h4>
                                            <a href="#" class="float-right zoom-on"><i
                                                    class="ficon bx bx-fullscreen"></i></a>
                                        </div>
                                        <div class="card-content modified_center">
                                            <div class="pl-5 "> Loading..</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4" id="db_training">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.training')
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4" id="db_hydrography">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.hydrography')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4" id="db_vehicles">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.vehicles')
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8" id="db_ce">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.ce')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" id="db_appointment">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100" id="div_appointment">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8" id="db_security">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.security')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" id="db_me">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.me')
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-8" id="db_backup-data">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.backup-data')
                                </div>
                            </div>
                        </div>
                    </div>
{{--                    <div class="col-md-4" id="db_vessel_bills">--}}
{{--                        <div class="zoom h-100">--}}
{{--                            <div class="dialog h-100">--}}
{{--                                <div class="m-content h-100">--}}
{{--                                    @include('main_dashboard.partials.vessel-bills')--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="col-md-12" id="db_estate">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.estate')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" id="db_marine_monthly_pilotage_service">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.marine_mon_pilotage_service')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="db_marine_daily">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.marine_daily')
                                </div>

                             </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="db_marine_monthly">
                        <div class="zoom h-100">
                            <div class="dialog h-100">
                                <div class="m-content h-100">
                                    @include('main_dashboard.partials.marine_monthly')
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </section>
        </div>
    </div>
    <div class="modal fade" id="second_pop_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="pop_content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@section('script')
    <script>
        $(window).on("load", function () {
            var e = "#5A8DEE", a = "#FF5B5C", t = "#FDAC41", r = "#00CFDD", o = "#828D99", s = {
                    chart: {
                        height: 240, type: "radialBar"
                    }
                    , colors: [e, a, t], series: [75, 80, 85], plotOptions: {
                        radialBar: {
                            offsetY: -10, hollow: {
                                size: "40%"
                            }
                            , track: {
                                margin: 10, background: "#fff"
                            }
                            , dataLabels: {
                                name: {
                                    fontSize: "15px", color: [o], fontFamily: "IBM Plex Sans", offsetY: 25
                                }
                                , value: {
                                    fontSize: "30px", fontFamily: "Rubik", offsetY: -15
                                }
                                , total: {
                                    show: !0, label: "Total Visits", color: o
                                }
                            }
                        }
                    }
                    , stroke: {
                        lineCap: "round"
                    }
                    , labels: ["Target", "Mart", "Ebay"]
                }
            ;
        });
    </script>
@endsection
@endsection
