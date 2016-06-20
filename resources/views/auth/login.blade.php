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
            <div class="col-md-7 col-xs-12 container-fluid bg-black-gradient">
                <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1">
                    <div id="carousel-generic" class="carousel slide wow zoomIn margin" data-ride="carousel">
                        <?php $files = Storage::disk('global_public')->allFiles("images");?>
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
                                    <img src="{{asset($file)}}" alt="...">
                                    <div class="carousel-caption text-black" style="font-size: 24px;">
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
