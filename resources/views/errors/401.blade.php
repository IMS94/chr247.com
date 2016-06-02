@extends(Auth::check()?'layouts.master':'layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="alert alert-danger container-fluid">
            Unauthorized! The requested action is unauthorized.
            <a class="btn btn-primary pull-right" href="{{url('/')}}">
                Home <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>
@endsection