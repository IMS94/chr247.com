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

            {{--Success Message--}}
            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Success!</h4>
                    {{session('success')}}
                </div>
            @endif

            {{--Error Message--}}
            @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Success!</h4>
                    {{session('error')}}
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
                    <tr class="tableRow">
                        <td onclick="window.location='{{route("patient",['id'=>$patient->id])}}'">
                            {{$patient->first_name}} {{$patient->last_name?:''}}
                        </td>
                        <td onclick="window.location='{{route("patient",['id'=>$patient->id])}}'">
                            {{$patient->phone}}
                        </td>
                        <td onclick="window.location='{{route("patient",['id'=>$patient->id])}}'">
                            {{$patient->address}}
                        </td>
                        <td onclick="window.location='{{route("patient",['id'=>$patient->id])}}'">
                            {{Utils::getAge($patient->dob)}}
                        </td>
                        <td>
                            @can('delete',$patient)
                            {{--
                            A modal is used to confirm the delete action.
                            One the modal popup, the url in the form changes according to the patient's id
                            --}}
                            <button class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#confirmDeletePatientModal"
                                    onclick="showConfirmDelete({{$patient->id}},'{{$patient->first_name}} {{$patient->last_name?:''}}')">
                                <i class="fa fa-recycle fa-lg"></i>
                            </button>
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

    {{--Add delete modal only if the user has previledges--}}
    @can('delete',$patient)
    @include('patients.modals.confirmDelete')
    <script>
        /**
         * Method to show delete patient modal.
         * Updates the modal title and the form's action
         * @param patientId
         */
        function showConfirmDelete(patientId, name) {
            $('#confirmDeletePatientModal .modal-title').html(name);
            $('#confirmDeletePatientModal form').prop("action", "{{url('patients/deletePatient')}}/" + patientId);
        }
    </script>
    @endcan


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
