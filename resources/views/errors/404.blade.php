@extends(\Illuminate\Support\Facades\Auth::check()?'layouts.master':'layouts.app')
    

@section('content')
    <div class="alert alert-danger">
        Error occurred! Requested resource not available!
    </div>
@endsection