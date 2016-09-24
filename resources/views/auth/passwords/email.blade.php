@extends("layouts.website.layout")

@section("title",'chr247.com | Forgot Password')

@section("content")
    <!-- ========== PAGE TITLE ========== -->
    <header class="header page-title">
        <div class="container">
            <!-- For centering the content vertically -->
            <div class="outer">
                <div class="inner text-center">
                    <h1 class="">Forgot Your Password?</h1>
                    <h5 class="">
                        Only the password of The <strong>Admin Account</strong> of a clinic can be reset using email. To
                        reset passwords of the other types of accounts, please contact the clinic's admin.
                    </h5>
                </div> <!-- end inner -->
            </div> <!-- end outer -->
        </div> <!-- end container -->
    </header>

    <div class="container-fluid" xmlns="http://www.w3.org/1999/html">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 form-wrap">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                                </button>
                                <h4><i class="icon fa fa-check"></i> Done!</h4>
                                <p>{{ session('status') }}</p>
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Email Address</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block wow wobble" data-wow-delay="1s">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-envelope"></i> Send Password Reset Link
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