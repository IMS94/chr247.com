@extends("layouts.website.layout")

@section("title",'chr247.com | Sign In')

@section("content")

    <!-- ========== PAGE TITLE ========== -->
    <header class="header page-title">
        <div class="container">
            <!-- For centering the content vertically -->
            <div class="outer">
                <div class="inner text-center">
                    <h1 class="">Please Sign in to Continue ...</h1>
                </div> <!-- end inner -->
            </div> <!-- end outer -->
        </div> <!-- end container -->
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2 form-wrap">
                <div class="text-center logo-wrap">
                    <a href="{{url("/")}}"><img src="{{asset('logo.png')}}" alt="CHR24x7" width="125"></a>
                </div> <!-- end text-center -->

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

                    <div class="form-group col-md-12 has-feedback {{ $errors->has('username') ? 'has-error' : '' }}">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username"
                               value="{{ old('username') }}">
                        @if ($errors->has('username'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                        @endif
                    </div> <!-- end form-group -->
                    <div class="form-group col-md-12 has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password"
                               value="{{old('password')}}">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div> <!-- end form-group -->

                    <div class="text-center col-md-12 mt10 mb20">
                        <button type="submit" class="btn se-btn btn-rounded">Login</button>
                    </div> <!-- end text-center -->
                </form> <!-- end form -->

                <div class="col-sm-6">
                    <p class="text-muted"><a href="{{ url('/password/reset') }}">Forgot Password?</a></p>
                </div>

                <div class="col-sm-6 text-right">
                    <p class="text-muted mbn">
                        Not registered yet? <a href="{{route('registerClinic')}}">Sign Up here!</a>
                    </p>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->

@endsection