@extends('layouts.master')


@section('page_header')
    Patients
@endsection


@section('sub_header')
    Health Informatics System
@endsection

@section('content')

    <div class="box box-primary">
        <!--    Box Header  -->
        <div class="box-header with-border">
            <button class="btn btn-primary pull-left" data-toggle="modal" data-target="#addPatientModal">
                Add Patient
            </button>
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
        </div>

    </div>

    @include('patients.modals.addPatient')
@endsection
