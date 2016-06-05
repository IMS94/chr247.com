@extends('layouts.app')

@section('title',"HIS | Admin Login")

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-danger">
                    <div class="panel-heading">Admin Login</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('Admin/login') }}">
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

                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Username</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="username"
                                           value="{{ old('username') }}">
                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password"
                                           value="{{old('password')}}">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-btn fa-sign-in"></i>Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
