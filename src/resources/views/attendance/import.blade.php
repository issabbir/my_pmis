@extends('layouts.attendance')
@section('title')
    Attendance import
@endsection

@section('content')
    <div class="col-md-12 p-5">
        @if($success)
            <div class="alert alert-dismissible alert-success">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong></strong> You successfully imported.
            </div>
        @else
            <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong></strong> {{$message}}
            </div>
        @endif
            <button type="button" class="btn btn-primary" onclick="history.go(-1)">Go back</button>
    </div>
@endsection
