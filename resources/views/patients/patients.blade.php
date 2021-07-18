@extends('layouts.master')


@section('page_header')
    Patients
@endsection


@section('content')

    <div class="box box-primary">
        <!--    Box Header  -->
        <div class="box-header with-border">
            <button class="btn btn-primary pull-left" data-toggle="modal" data-target="#addPatientModal">
                <span data-toggle="tooltip"
                      data-placement="bottom" title="" style="margin-left: 10px"
                      data-original-title="Fill the basic information of a patient and add to the system.">Add Patient</span>
            </button>
        </div>

        <!--    Box Body  -->
        <div class="box-body container-fluid table-responsive">

            {{--Success Message--}}
            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Success!</h4>
                    <p>
                        {{session('success')}}
                    </p>
                </div>
            @endif

            {{--Error Message--}}
            @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    {{session('error')}}
                </div>
            @endif

            <style>
                .tableBoby tr {
                    cursor: pointer;
                }

                .tableBoby tr:hover {
                    text-decoration: underline !important;
                }

                .tableRow {
                    cursor: pointer;
                }

                .tableRow:hover {
                    text-decoration: underline !important;
                }
            </style>

            <table class="table table-condensed table-hover text-center" id="patientsTable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact No.</th>
                    <th>Address</th>
                    <th>Age</th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="tableBoby">
                {{-- Rows below will now be printed with data tables server side processing --}}
                @forelse($patients as $patient)
                    <tr class="tableRow">
                        <td>
                            {{$patient->id}}
                        </td>
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
                                    <i class="fa fa-recycle fa-lg" data-toggle="tooltip"
                                       data-placement="bottom" title=""
                                       data-original-title="Delete this patient?
                                       You won't be able to delete this patient if the patient has any records
                                       associated to him/her in the system."></i>
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

    {{--Data Tables Scripts--}}
    <script>
        $(document).ready(function () {
            var tableFixed = $('#patientsTable').DataTable({
                'pageLength': 10,
                'processing': true,
                'serverSide': true,
                'ajax': '{{route("listPatients")}}',
                'order': [[1, 'asc']],
                'columnDefs': [
                    {
                        'targets': [0],
                        'visible': false,
                        'searchable': false
                    }
                ]
            });

            $('#patientsTable tbody').on('click', 'tr', function(e) {
                var data = tableFixed.row(this).data();
                if ($(e.target).is('td')) {
                    window.location.replace("{{url('patients/patient')}}/"+data[0]);
                }
            });
        });
    </script>
    {{--//Data Tables--}}

@endsection
