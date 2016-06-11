@extends('layouts.app')

@section('title',"HIS | Login")

@section('content')

    <div class="container-fluid">

        <div class="row container-fluid">
            <div class="alert alert-success alert-dismissable wow bounceInDown" data-wow-delay="1s">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                </button>
                <h4><i class="icon fa fa-info"></i> We are Preparing Something Awesome!</h4>
                <p>
                    It is the most simple user friendly <strong>Health Informatics System</strong> you will
                    ever see. All functions to carry on day-to-day operation of your small scale clinic in one
                    place.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-xs-12 container-fluid">
                <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1">
                    <div id="carousel-example-generic" class="carousel slide wow rotateIn" data-ride="carousel">
                        <?php $files = Storage::disk('public')->allFiles("images");?>
                                <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            @for($x=1;$x<count($files);$x++)
                                <li data-target="#carousel-example-generic" data-slide-to="{{$x}}"></li>
                            @endfor
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <?php $first = true; ?>
                            @foreach($files as $file)
                                <div class="item
                            @if($first)
                                        active
                                         <?php $first = false; ?>
                                @endif">
                                    <img src="{{asset("storage/".$file)}}" alt="...">
                                    <div class="carousel-caption" style="font-size: 24px;">
                                        Try Our New Beta ...
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" role="button"
                           data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button"
                           data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xs-12 container-fluid">
                <div class="box box-primary box-solid wow zoomIn">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            Login
                        </h4>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
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
                                        <span class="help-block wow wobble" data-wow-delay="1s">
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
                                        <span class="help-block wow wobble" data-wow-delay="1s">
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
                                    <button type="submit" class="btn btn-primary btn-flat">
                                        <i class="fa fa-btn fa-sign-in"></i>Login
                                    </button>

                                    <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-12 col-xs-12">
                    <a href="{{route('registerClinic')}}" class="btn btn-primary btn-flat btn-lg pull-left wow bounceIn"
                       data-wow-delay="2s">
                        RegsiterNow <i class="fa fa-hand-o-right fa-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
