@extends('layouts.login')
@section('title')
    Forgot Password
@endsection

@section('content')
<section class="row flexbox-container">
    <div class="col-xl-7 col-10">
      <div class="row m-0">
        <!-- left section-login -->
          <div class="col-md-6 col-12 px-0 bg-rgba-cblack">

           <form class="" method="POST" action="{{route('forget-password')}}">
               @csrf
              <div class="card-header pb-0">
                  <div class="card-title">
                      <img src="../../../app-assets/images/logo/cpa-logo.png" alt="users view avatar" class="img-fluid mx-auto d-block">
                      <h4 class="text-center mt-1 text-white">CPA Portal</h4>
                  </div>
              </div>
              <div class="card-content">
                  <div class="card-body pb-0">

                      <div class="divider">
                          <div class="divider-text text-uppercase text-light bg-transparent"><small>Forgot Password?</small></div>
                      </div>
                      <div class="form-group">
                          <label class="text-bold-600 text-white" for="Email">Email</label>
                          <input type="Email" class="form-control" name="email" id="email" placeholder="Email">
                          @if($errors->has("email"))
                              <span class="danger">{{$errors->first("email")}}</span
                          @endif
                      </div>
                      <p class="text-center text-white">OR</p>

                  </div>
                  <div class="row ml-0 mr-0 p-1 bg-rgba-cwhite">
                      <div class="col-md-12">
                          @if (session('success'))
                              <div class="form-group">
                                  <div class="alert alert-success alert-dismissible">
                                      <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times" aria-hidden="true"></i></a>
                                      {{ session('success') }}
                                  </div>
                              </div>
                          @endif
                          @if(session('fail'))
                              <div class="form-group">
                                  <div class="alert alert-danger alert-dismissible">
                                      <a href="#" class="close" data-dismiss="alert" aria-label="close"><i class="fa fa-times" aria-hidden="true"></i></a>
                                      {{ session('fail') }}
                                  </div>
                              </div>
                          @endif
                      </div>
                  </div>
              </div>

              <div class="row ml-0 mr-0 p-1 bg-rgba-cwhite">
                  <div class="col-md-12">
                      <p class="text-white">Please Contact to the call center on the following number for Password Reset-- Phone: 02-955622</p>
                  </div>
              </div>

              <div class="card-content">
                  <div class="card-body">
                      <button type="submit" class="btn btn-primary glow position-relative w-100">
                          SEND PASSWORD<!--i id="icon-arrow" class="bx bx-right-arrow-alt"></i-->
                      </button>
                      <hr>
                      <div class="text-center">
                          <a href="/" class="text-light"><small>Back To Login Page</small></a>
                      </div>

                  </div>
                  <div class="float-right text-light">
                      <small>Operation and Maintenance by</small>
                      <a class="text-primary font-weight-bold" href="https://site.cnsbd.com" target="_blank">
                          <img src="../../../app-assets/images/logo/cns-logo-w.png" alt="cns_logo" class="img-fluid mb-1"/>
                      </a>
                  </div>
              </div>

           </form>
          </div>
      </div>
    </div>
  </section>
@endsection
