@extends('layouts.app')

@section('title',"CHR247 | Login")

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="alert alert-success alert-dismissable wow bounceInDown" data-wow-delay="1s">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                </button>
                <h4><i class="icon fa fa-info"></i> We are Preparing Something Awesome!</h4>
                <p>
                    It is the most simple user friendly <strong>Cloud Health Records</strong> system you will
                    ever see. All functions to carry on day-to-day operation of your small scale clinic in one
                    place.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7 col-xs-12 container-fluid">
                <div class="box box-danger wow zoomIn" data-wow-delay="2s">
                    <div class="box-body" style="font-size: 18px !important">
                        <div class="callout callout-danger">
                            <p style="font-size: 18px !important">
                                Now you can manage all your private clinic's information with ease.
                            </p>
                            <ul>
                                <li>Manage patients</li>
                                <li>Issue prescriptions to patients</li>
                                <li>Print prescriptions</li>
                                <li>Manage medical records of patients</li>
                                <li>Manage drugs of your clinic</li>
                                <li>Manage drug stocks</li>
                                <li>Manage Patient Queues</li>
                                <li>Different access levels for doctors and nurses</li>
                                <li>Securely store your information and access from anywhere</li>
                            </ul>
                            <p style="font-size: 18px !important">Welcome to Cloud Health Records 24x7 !</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5 col-xs-12 container-fluid">
                <div class="login-box" style="font-size: 15px !important;">
                    <div class="login-box-body">
                        <p class="login-box-msg">Sign in to start your session</p>
                        <form action="{{url('login')}}" method="post">

                            {!! csrf_field() !!}

                            {{--Success Message--}}
                            @if(session()->has('success'))
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                                    </button>
                                    <h4><i class="icon fa fa-check"></i> Success!</h4>
                                    {{session('success')}}
                                </div>
                            @endif

                            {{-- General error message --}}
                            @if ($errors->has('general'))
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                                    </button>
                                    <h4><i class="icon fa fa-ban"></i> Oops!</h4>
                                    {{ $errors->first('general') }}
                                </div>
                            @endif


                            <div class="form-group has-feedback{{ $errors->has('username') ? ' has-error' : '' }}">
                                <input type="text" class="form-control" name="username" placeholder="Username"
                                       value="{{ old('username') }}">
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input type="password" class="form-control" name="password" placeholder="Password"
                                       value="{{old('password')}}">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-xs-8">
                                    <div class="checkbox icheck">
                                        <label>
                                            <input type="checkbox"> Remember Me
                                        </label>
                                    </div>
                                </div><!-- /.col -->
                                <div class="col-xs-4">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                                </div><!-- /.col -->
                            </div>
                        </form>
                        <a href="{{ url('/password/reset') }}">Forgot Your Password?</a><br>
                    </div>
                </div>

                <div class="col-md-12 col-xs-12">
                    <a href="{{route('registerClinic')}}" class="btn btn-primary btn-flat btn-lg pull-left">
                        Regsiter Now <i class="fa fa-arrow-right fa-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
