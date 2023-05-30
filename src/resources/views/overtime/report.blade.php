@extends('layouts.empty')
@section('title')
    overtime
@endsection

@section('content')
    <div class="container-fluid mt-5 reports-overtime">
        <div class="row">
            <div class="col-md-12">
                <div class="heading text-center">
                    <h4>Chittagong Port Authority</h4>
                </div>
                <table class="table" cellpadding="0" cellspacing="0">
                    <tr>
                        <th class="tg-0lax">SL</th>
                        <th class="tg-0lax">Employee Name</th>
                        <th class="tg-0lax">Designation</th>
                        <th class="tg-0lax">Basic Salary</th>
                        <th class="tg-0lax">Friday</th>
                        <th class="tg-0lax">Saturday</th>
                        <th class="tg-0lax">Sunday</th>
                        <th class="tg-0lax">Monday</th>
                        <th class="tg-0lax">Tuesday</th>
                        <th class="tg-0lax">Wednesday</th>
                        <th class="tg-0lax">Thursday</th>
                        <th class="tg-0lax">Total Hr</th>
                        <th class="tg-0lax">Regular Hour</th>
                        <th class="tg-0lax">Offday Hour</th>
                        <th class="tg-0lax">Rate</th>
                        <th class="tg-0lax">Total Pay</th>
                        <th class="tg-0lax">Net Pay</th>
                    </tr>
                    <tr>
                        <td class="tg-0lax" rowspan="5"></td>
                        <td class="tg-0lax" rowspan="5"></td>
                        <td class="tg-0lax" rowspan="5"></td>
                        <td class="tg-0lax" rowspan="2"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax" rowspan="5"></td>
                        <td class="tg-0lax" rowspan="5"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax" rowspan="5"></td>
                    </tr>
                    <tr>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                    </tr>
                    <tr>
                        <td class="tg-0lax" rowspan="3"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax" rowspan="3"></td>
                        <td class="tg-0lax"></td>
                    </tr>
                    <tr>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax" rowspan="2"></td>
                    </tr>
                    <tr>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                        <td class="tg-0lax"></td>
                    </tr>
                </table>
         </div>
        </div>
    </div>
@endsection

@section('style')
    .table{
        width: 100%;
        height: 115px;
        padding: 5px
    }
   .table tr th, td {
        padding: 5px;
    border:1px solid gray;
    }
@endsection
