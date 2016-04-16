@extends('layouts.master')


@section('page_header')
    {{$patient->first_name}} {{$patient->last_name?:''}}
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{route('root')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('patients')}}">Patients</a></li>
        <li class="active" href="#">{{$patient->first_name}}</li>
    </ol>
@endsection


@section('content')

    <div class="box box-primary">

        <!--    Box Header  -->
        <div class="box-header with-border">

            {{--Check whether the user has permissions to access these tasks--}}
            @can('edit',$patient)
            <button class="btn btn-primary margin-left" data-toggle="modal" data-target="#editPatientModal">
                <i class="fa fa-edit fa-lg"></i> Edit Info
            </button>
            @endcan

            @can('issueMedical',$patient)
            <button class="btn btn-primary margin-left" data-toggle="modal" data-target="#addPatientModal">
                <i class="fa fa-stethoscope fa-lg"></i> Issue Medical
            </button>
            @endcan

            @can('issueID',$patient)
            <button class="btn btn-primary margin-left" data-toggle="modal" data-target="#addPatientModal">
                <i class="fa fa-tag fa-lg"></i> Issue ID
            </button>
            @endcan

        </div>

        <!--    Box Body  -->
        <div class="box-body">

            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Success!</h4>
                    {{session('success')}}
                </div>
            @endif

            {{--    Nav tabs    --}}
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#info" aria-controls="info" role="tab" data-toggle="tab">Info</a>
                </li>
                <li role="presentation">
                    <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Prescribe Medicine</a>
                </li>
                <li role="presentation">
                    <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Issue Medicine</a>
                </li>
                <li role="presentation">
                    <a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Medical Records</a>
                </li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="info">
                    @include('patients.tabs.patientInfo')
                </div>

                <div role="tabpanel" class="tab-pane fade" id="profile">...</div>
                <div role="tabpanel" class="tab-pane fade" id="messages">...</div>
                <div role="tabpanel" class="tab-pane fade" id="settings">...</div>
            </div>
        </div>
    </div>

    @can('edit',$patient)
    @include('patients.modals.editPatient')
    @endcan
@endsection
