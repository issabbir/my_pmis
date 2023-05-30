@extends('layouts.empty')

@section('title')
    Pension Settlement
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap.min.css">
    <style>
        .pagenum:before {
            content: counter(page);
        }
        table#nominee, th, td {
            border: 1px solid #000000;
        }
        table#nominee {
            border-collapse: collapse;
        }
        .container {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }
        @media (min-width: 768px) {
            .container {
                width: 750px;
            }
        }
        @media (min-width: 992px) {
            .container {
                width: 970px;
            }
        }
        @media (min-width: 1200px) {
            .container {
                width: 1170px;
            }
        }
        .row {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }
        .col-md-2 {
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 16.66667%;
            -ms-flex: 0 0 16.66667%;
            flex: 0 0 16.66667%;
            max-width: 16.66667%;
        }
        .col-md-7 {
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 58.33333%;
            -ms-flex: 0 0 58.33333%;
            flex: 0 0 58.33333%;
            max-width: 58.33333%;
        }
        .col-md-6 {
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 50%;
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%;
        }
        .col-md-12 {
            -webkit-box-flex: 0;
            -webkit-flex: 0 0 100%;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="container" style="margin-top: 0;padding-top: 0">
        <div class="row" style="font-family: Tahoma,serif;margin-top: 0; height: 120px;">
            <div class="col-md-2" style="float: left;font-size: 12px">
                 <img src="{{ $logo }}" alt="" width="80" height="80">
{{--                 <img src="{{ asset('images/cnsLogo.png') }}" alt="">--}}
            </div>
            <div class="col-md-7" style="text-align: center; margin-left: -40px;">
                <h3 style="font-weight: bold" align="center">CHITTAGONG PORT AUTHORITY</h3>
                <h4 align="center">Pension Settlement and Calculation</h4>
            </div>
            <hr style="margin-top: 0;padding-top: 0">
        </div>
        <div class="row" style="margin-top: 0;padding-top: 0">
            <div class="col-md-12" style="text-align: right;margin-top: -1rem;font-size: 12px">
                {{ $print_time }}
            </div>
            <div class="col-md-12 " style="margin-top: 1rem;font-weight: bold">
                Basic Information
            </div>
            <hr>
            <table style="font-size: .8rem">
                <tr style="font-size: .8rem">
                    <td style="font-size: .8rem;width: 6rem">Employee Code </td>
                    <td style="font-size: .8rem;">: {{ $basic_info[0]->emp_code }} </td>
                </tr>
                <tr style="font-size: .8rem">
                    <td style="font-size: .8rem;width: 5rem">Employee Name </td>
                    <td style="font-size: .8rem;">: {{ $basic_info[0]->emp_name }} </td>
                    <td style="font-size: .8rem;"></td>
                    <td style="font-size: .8rem;"></td>
                    <td style="font-size: .8rem;width: 7rem">Religion </td>
                    <td style="font-size: .8rem;">: {{ $basic_info[0]->emp_religion_name }} </td>
                </tr>
                <tr style="font-size: .8rem">
                    <td style="font-size: .8rem;width: 5rem">Father's Name </td>
                    <td style="font-size: .8rem;">: {{ $basic_info[0]->emp_father_name }} </td>
                    <td style="font-size: .8rem;"></td>
                    <td style="font-size: .8rem;"></td>
                    <td style="font-size: .8rem;width: 7rem">Gender </td>
                    <td style="font-size: .8rem;">: {{ $basic_info[0]->emp_gender_name }} </td>
                </tr>
                <tr style="font-size: .8rem">
                    <td style="font-size: .8rem;width: 5rem">Mother's Name </td>
                    <td style="font-size: .8rem;">: {{ $basic_info[0]->emp_mother_name }} </td>
                    <td style="font-size: .8rem;"></td>
                    <td style="font-size: .8rem;"></td>
                    <td style="font-size: .8rem;width: 7rem">National ID </td>
                    <td style="font-size: .8rem;">: {{ $basic_info[0]->nid_no }} </td>
                </tr>
                <tr style="font-size: .8rem">
                    <td style="font-size: .8rem;width: 5rem">Date Of Birth </td>
                    <td style="font-size: .8rem;">: {{ $basic_info[0]->emp_dob }} </td>
                    <td style="font-size: .8rem;"></td>
                    <td style="font-size: .8rem;"></td>
                    <td style="font-size: .8rem;width: 7rem">Contact No </td>
                    <td style="font-size: .8rem;">: {{ $basic_info[0]->contract }} </td>
                </tr>
                <tr style="font-size: .8rem">
                    <td style="font-size: .8rem;width: 5rem">Present Address </td>
                    <td style="font-size: .8rem;">: {{ $basic_info[0]->present_address }} </td>
                    <td style="font-size: .8rem;"></td>
                    <td style="font-size: .8rem;"></td>
                    <td style="font-size: .8rem;width: 7rem">Permanent Address </td>
                    <td style="font-size: .8rem;">: {{ $basic_info[0]->permanent_address }} </td>
                </tr>
            </table>
        </div>
        <div class="row">
            <div class="col-md-12 " style="margin-top: .8rem;font-weight: bold">
                Nominee Information
            </div>
            <hr>
            <table class="table table-bordered" id="nominee" style="width: 100%;border: 1px solid #000000;border-collapse: collapse;">
                <thead>
                    <tr style="font-size: .8rem;border: 1px solid #000000;border-collapse: collapse;">
                        <th style="font-size: .8rem;border: 1px solid #000000;border-collapse: collapse;">SL</th>
                        <th style="font-size: .8rem;border: 1px solid #000000;border-collapse: collapse;">NOMINEE NAME</th>
                        <th style="font-size: .8rem;border: 1px solid #000000;border-collapse: collapse;">NOMINEE DOB</th>
                        <th style="font-size: .8rem;border: 1px solid #000000;border-collapse: collapse;">RELATION TYPE</th>
                        <th style="font-size: .8rem;border: 1px solid #000000;border-collapse: collapse;">MARITAL STATUS</th>
                        <th style="font-size: .8rem;border: 1px solid #000000;border-collapse: collapse;">PERCENTAGE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nominee as $nominee_list)
                        <tr style="text-align: center;font-size: .8rem;border: 1px solid #000000;border-collapse: collapse;">
                            <td style="font-size: .8rem;text-align: center;border: 1px solid #000000;border-collapse: collapse;">{{$loop->iteration}}</td>
                            <td style="font-size: .8rem;text-align: center;border: 1px solid #000000;border-collapse: collapse;">{{$nominee_list->nominee_name}}</td>
                            <td style="font-size: .8rem;text-align: center;border: 1px solid #000000;border-collapse: collapse;">{{$nominee_list->nominee_dob}}</td>
                            <td style="font-size: .8rem;text-align: center;border: 1px solid #000000;border-collapse: collapse;">{{$nominee_list->relation_type}}</td>
                            <td style="font-size: .8rem;text-align: center;border: 1px solid #000000;border-collapse: collapse;">{{$nominee_list->maritial_status}}</td>
                            <td style="font-size: .8rem;text-align: center;border: 1px solid #000000;border-collapse: collapse;">{{$nominee_list->percentage}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-12 " style="margin-top: .8rem;font-weight: bold">
                Service Information
            </div>
            <hr>
            <table style="font-size: .8rem">
                <tr style="font-size: .8rem">
                    <td style="font-size: .8rem">Department </td>
                    <td style="font-size: .8rem">: {{$basic_info[0]->department_name}} </td>
                    <td style="font-size: .8rem;width: 6rem"></td>
                    <td style="font-size: .8rem;width: 6rem"></td>
                    <td style="font-size: .8rem">Employee Type  </td>
                    <td style="font-size: .8rem">: {{$basic_info[0]->emp_type}} </td>
                </tr>
                <tr style="font-size: .8rem">
                    <td style="font-size: .8rem">Designation  </td>
                    <td style="font-size: .8rem">: {{$basic_info[0]->designation}} </td>
                    <td style="font-size: .8rem;width: 6rem"></td>
                    <td style="font-size: .8rem;width: 6rem"></td>
                    <td style="font-size: .8rem">Employee Status </td>
                    <td style="font-size: .8rem">: {{$basic_info[0]->emp_status}} </td>
                </tr>
                <tr style="font-size: .8rem">
                    <td style="font-size: .8rem">Division &nbsp;</td>
                    <td style="font-size: .8rem">: {{$basic_info[0]->division_name}} </td>
                    <td style="font-size: .8rem;width: 6rem"></td>
                    <td style="font-size: .8rem;width: 6rem"></td>
                    <td style="font-size: .8rem">Bank Name </td>
                    <td style="font-size: .8rem">: {{$basic_info[0]->bank_name}} </td>
                </tr>
                <tr style="font-size: .8rem">
                    <td style="font-size: .8rem">Section  </td>
                    <td style="font-size: .8rem">: {{$basic_info[0]->dpt_section}} </td>
                    <td style="font-size: .8rem;width: 6rem"></td>
                    <td style="font-size: .8rem;width: 6rem"></td>
                    <td style="font-size: .8rem">Account No </td>
                    <td style="font-size: .8rem">: {{$basic_info[0]->bank_acc_no}} </td>
                </tr>
                <tr style="font-size: .8rem">
                    <td style="font-size: .8rem">Joining Date  &nbsp;&nbsp;</td>
                    <td style="font-size: .8rem">: {{$basic_info[0]->joining_date}} </td>
                    <td style="font-size: .8rem;width: 6rem"></td>
                    <td style="font-size: .8rem;width: 6rem"></td>
                    <td style="font-size: .8rem">Branch Name </td>
                    <td style="font-size: .8rem">: {{$basic_info[0]->branch_name}} </td>
                </tr>
                <tr style="font-size: .8rem">
                    <td style="font-size: .8rem">PRL Date </td>
                    <td style="font-size: .8rem">: {{$basic_info[0]->prl_date}} </td>
                    <td style="font-size: .8rem;width: 6rem"></td>
                    <td style="font-size: .8rem;width: 6rem"></td>
                    <td style="font-size: .8rem">Last Pay Grade &nbsp;&nbsp;</td>
                    <td style="font-size: .8rem">: {{$basic_info[0]->last_grade_id}} </td>
                </tr>
            </table>
        </div>

        <div class="row">
            <div class="col-md-12 " style="margin-top: .8rem;font-weight: bold">
                Leave Information
            </div>
            <hr>
            <table class="table table-bordered" id="nominee" style="width: 100%;border: 1px solid #000000;border-collapse: collapse;">
                <thead>
                    <tr style="font-size: .8rem;border: 1px solid #000000;border-collapse: collapse;">
                    <th style="font-size: .8rem;border: 1px solid #000000;border-collapse: collapse;">LEAVE TYPE</th>
                    <th style="font-size: .8rem;border: 1px solid #000000;border-collapse: collapse;">MONDAY</th>
                    <th style="font-size: .8rem;border: 1px solid #000000;border-collapse: collapse;">LEAVE ENJOY</th>
                    <th style="font-size: .8rem;border: 1px solid #000000;border-collapse: collapse;">REMAINING BALANCE</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($emp_leave as $leave_list)
                        <tr style="font-size: .8rem;text-align: center;border: 1px solid #000000;border-collapse: collapse;">
                            <td style="font-size: .8rem;text-align: center;border: 1px solid #000000;border-collapse: collapse;">{{ $leave_list->leave_type }}</td>
                            <td style="font-size: .8rem;text-align: center;border: 1px solid #000000;border-collapse: collapse;">{{ $leave_list->monday }}</td>
                            <td style="font-size: .8rem;text-align: center;border: 1px solid #000000;border-collapse: collapse;">{{ $leave_list->leave_enjoy }}</td>
                            <td style="font-size: .8rem;text-align: center;border: 1px solid #000000;border-collapse: collapse;">{{ $leave_list->remaining_balance }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-12 " style="margin-top: .8rem;font-weight: bold">
                Pension Settlement Information
            </div>
            <hr>
            <table style="font-size: .8rem">
                <tr style="font-size: .8rem">
                    <td style="font-size: .8rem">Last Pay Scale  </td>
                    <td style="font-size: .8rem">: {{ $basic_info[0]->last_payscale }} </td>
                    <td style="font-size: .8rem;width: 7rem"></td>
                    <td style="font-size: .8rem;width: 7rem"></td>
                    <td style="font-size: .8rem">{{ $basic_info[0]->pension_rate }} </td>
                    <td style="font-size: .8rem;">: <span style="margin-left: 3.5rem">{{ $basic_info[0]->proposed_basic_pension }}</span> </td>
                </tr >
                <tr style="font-size: .8rem">
                    <td style="font-size: .8rem">Last Basic </td>
                    <td style="font-size: .8rem">: {{ $basic_info[0]->last_basic }} </td>
                    <td style="font-size: .8rem;width: 7rem"></td>
                    <td style="font-size: .8rem;width: 7rem"></td>
                    <td style="font-size: .8rem">Proposed Monthly Pension </td>
                    <td style="font-size: .8rem;">: <span style="margin-left: 3.5rem">{{ $basic_info[0]->proposed_monthly_pension }}</span> </td>
                </tr>
                <tr style="font-size: .8rem">
                    <td style="font-size: .8rem">Gratuity Time </td>
                    <td style="font-size: .8rem">: {{ $basic_info[0]->gratuity_time }} </td>
                    <td style="font-size: .8rem;width: 7rem"></td>
                    <td style="font-size: .8rem;width: 7rem"></td>
                    <td style="font-size: .8rem">Surrender Value (50%) </td>
                    <td style="font-size: .8rem">: <span style="margin-left: 2.8rem">{{ $basic_info[0]->pension_amt }}</span> </td>
                </tr>
                <tr style="font-size: .8rem">
                    <td style="font-size: .8rem">Adjusted Amount  </td>
                    <td style="font-size: .8rem">: {{ $basic_info[0]->total_deduction }} </td>
                    <td style="font-size: .8rem;width: 7rem"></td>
                    <td style="font-size: .8rem;width: 7rem"></td>
                    <td style="font-size: .8rem">Medical Allowance </td>
                    <td style="font-size: .8rem;">: <span style="margin-left: 3.8rem">{{ $basic_info[0]->medical_allow }}</span> </td>
                </tr>
                <tr style="font-size: .8rem">
                    <td style="font-size: .8rem">Net Settlement </td>
                    <td style="font-size: .8rem">: {{ $basic_info[0]->net_settlement }} </td>
                </tr>
            </table>
        </div>
        <div class="row" style="margin-top: 8rem">
            @foreach ($file_content as $index => $item)
                <div class="col-md-6" style="font-size: .7rem;float: left;width: 33%;margin-right: .7rem;text-align: center">
                    <div class="">
                        <img src="{{ $item->file_content }}" height="50" width="100" alt="Image Preview" />
                    </div>


                    <hr style="border: 1px solid #000000;">
                    <p>{{ $item->designation }} </p>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('javascript')

@endsection
