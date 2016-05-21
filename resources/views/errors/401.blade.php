@extends(\Illuminate\Support\Facades\Auth::check()?'layouts.master':'layouts.app')

@section('content')
    <div class="alert alert-danger">
        Unauthorized! The requested action is unauthorized.
    </div>
@endsection