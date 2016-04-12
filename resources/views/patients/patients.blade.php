@extends('layouts.master')


@section('page_header')
    Patients
@endsection


@section('content')

    {{--Data Tables CSS--}}
    <link href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css">
    {{--//Data Tables CSS--}}

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

            <style>
                .tableRow {
                    cursor: pointer;
                }

                .tableRow:hover {
                    text-decoration: underline !important;
                }
            </style>

            <table class="table table-responsive table-condensed table-hover text-center" id="patientsTable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact No.</th>
                    <th>Address</th>
                    <th>Age</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($patients as $patient)
                    <tr class="tableRow"
                        onclick="window.location='{{route("patient",['id'=>$patient->id])}}'">
                        <td>{{$patient->first_name}} {{$patient->last_name?:''}}</td>
                        <td>{{$patient->phone}}</td>
                        <td>{{$patient->address}}</td>
                        <td>
                            {{Utils::getAge($patient->dob)}}
                        </td>
                        <td>
                            @can('delete',$patient)
                            <button class="btn btn-sm btn-danger"><i class="fa fa-recycle fa-lg"></i></button>
                            @endcan
                        </td>
                    </tr>
                @empty

                @endforelse
                </tbody>
            </table>
        </div>

    </div>

    @include('patients.modals.addPatient')

    {{--Data Tables Scripts--}}
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables/dataTables.bootstrap.js')}}"></script>
    <script>
        $(document).ready(function () {
            var tableFixed = $('#patientsTable').dataTable({
                'pageLength': 10
            });
        });
    </script>
    {{--//Data Tables--}}

@endsection
