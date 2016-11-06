@extends('layouts.app')


@section('title',"Admin | HIS")

@section('content')
    <div class="container-fluid table-responsive">
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
                <th class="col-md-2">Name</th>
                <th class="col-md-1">Email</th>
                <th class="col-md-2">Address</th>
                <th class="col-md-1">Phone</th>
                <th class="col-md-1">Country</th>
                <th class="col-md-1">Currency</th>
                <th class="col-md-1">Timezone</th>
                <th class="col-md-1">Registered At (UTC)</th>
                <th class="col-md-2"></th>
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
                    <td>{{$clinic->created_at}}</td>
                    <td>
                        <a href="{{route('acceptClinic',['id'=>$clinic->id])}}" class="btn btn-sm btn-success">
                            Accept
                        </a>
                        <a href="{{route('deleteClinic',['id'=>$clinic->id])}}" class="btn btn-sm btn-danger">
                            Delete
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="container-fluid table-responsive">
        <h4>Accepted Clinics</h4>

        <table class="table table-hover table-condensed table-bordered text-center">
            <tr>
                <th class="col-md-2">Name</th>
                <th class="col-md-1">Email</th>
                <th class="col-md-2">Address</th>
                <th class="col-md-1">Phone</th>
                <th class="col-md-1">Country</th>
                <th class="col-md-1">Currency</th>
                <th class="col-md-1">Timezone</th>
                <th class="col-md-1">Registered At (UTC)</th>
                <th class="col-md-2">Patients Added</th>
            </tr>

            <tbody>
            @foreach($acceptedClinics as $clinic)
                <tr>
                    <td>{{$clinic->name}}</td>
                    <td>{{$clinic->email}}</td>
                    <td>{{$clinic->address}}</td>
                    <td>{{$clinic->phone}}</td>
                    <td>{{$clinic->country}}</td>
                    <td>{{$clinic->currency}}</td>
                    <td>{{$clinic->timezone}}</td>
                    <td>{{$clinic->created_at}}</td>
                    <td>{{$clinic->patients()->count()}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
