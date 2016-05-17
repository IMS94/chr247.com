@extends('layouts.master')


@section('page_header')
Search Results for "{{$query}}"
@endsection


@section('content')

    <style>
        .tableRow {
            cursor: pointer;
        }

        .tableRow:hover {
            text-decoration: underline !important;
        }
    </style>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title">
                Results from Patients
            </h4>
        </div>

        <div class="box-body">
            <table class="table table-responsive table-condensed table-hover text-center" id="patientsTable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact No.</th>
                    <th>Address</th>
                    <th>Age</th>
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
                    </tr>
                @empty

                @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <div class="box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title">
                Results from Drugs
            </h4>
        </div>

        <div class="box-body">
            <table class="table table-responsive table-condensed table-hover text-center" id="drugsTable">
                <thead>
                <tr>
                    <th>Drug Name</th>
                    <th>Quantity Type</th>
                    <th>Manufacturer</th>
                    <th>Quantity</th>
                </tr>
                </thead>
                <tbody>
                @forelse($drugs as $drug)
                    <tr class="tableRow">
                        <td onclick="window.location='{{route("drug",['id'=>$drug->id])}}'">
                            {{$drug->name}}
                        </td>
                        <td onclick="window.location='{{route("drug",['id'=>$drug->id])}}'">
                            {{$drug->quantityType->drug_type}}
                        </td>
                        <td onclick="window.location='{{route("drug",['id'=>$drug->id])}}'">
                            {{$drug->manufacturer}}
                        </td>
                        <td onclick="window.location='{{route("drug",['id'=>$drug->id])}}'">
                            {{$drug->quantity}}
                        </td>
                    </tr>
                @empty

                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{--Data Tables Scripts--}}
    <script>
        $(document).ready(function () {
            $('#drugsTable').dataTable({
                'pageLength': 10
            });

            $('#patientsTable').dataTable({
                'pageLength': 10
            });
        });
    </script>
    {{--//Data Tables--}}

@endsection