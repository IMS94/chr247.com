@extends('layouts.app')


@section('title',"Admin | HIS")

@section('content')
    <div class="container-fluid">
        <div class="container-fluid">
            <a href="{{route('adminLogout')}}" class="btn btn-primary">Logout</a>
        </div>

        <br>
        <h4>Clinics To Be Accepted</h4>

        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                {{session('success')}}
            </div>
        @endif

        {{--Success Message--}}
        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                </button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                {{session('error')}}
            </div>
        @endif

        <table class="table table-hover table-condensed table-bordered text-center">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Country</th>
                <th>Currency</th>
                <th>Timezone</th>
                <th></th>
            </tr>

            <tbody>
            @foreach($clinics as $clinic)
                <tr>
                    <td>{{$clinic->name}}</td>
                    <td>{{$clinic->email}}</td>
                    <td>{{$clinic->address}}</td>
                    <td>{{$clinic->phone}}</td>
                    <td>{{$clinic->country}}</td>
                    <td>{{$clinic->currency}}</td>
                    <td>{{$clinic->timezone}}</td>
                    <td>
                        <a href="{{route('acceptClinic',['id'=>$clinic->id])}}" class="btn btn-sm btn-success">
                            Accept
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
