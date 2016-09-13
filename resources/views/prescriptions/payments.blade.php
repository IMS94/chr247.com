@extends('layouts.master')


@section('page_header')
    Payments
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{route('root')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active" href="#">Payments</li>
    </ol>
@endsection

@section('content')

    <div class="box box-primary">
        <div class="box-header">
            <h4 class="box-title">Payments</h4>
        </div>
        <!--    Box Body  -->
        <div class="box-body">

            <style>
                .tableRow {
                    cursor: pointer;
                }

                .tableRow:hover {
                    text-decoration: underline !important;
                }
            </style>

            <table class="table table-responsive table-condensed table-hover text-center" id="paymentsTable">
                <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Amount Paid</th>
                    <th>Remarks</th>
                    <th>Issued At</th>
                </tr>
                </thead>
                <tbody>
                @forelse($prescriptions as $prescription)
                    @if($prescription->hasIssued())
                        <tr class="tableRow"
                            onclick="window.location='{{route("patient",['id'=>$prescription->patient->id])}}'">
                            <td>{{$prescription->patient->first_name}} {{$prescription->patient->last_name}}</td>
                            <td>{{$prescription->payment->amount}}</td>
                            <td>{{$prescription->payment->remarks}}</td>
                            <td>{{Utils::getTimestamp($prescription->issued_at)}}</td>
                        </tr>
                    @endif
                @empty
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{--Data Tables Scripts--}}
    <script>
        $(document).ready(function () {
            var tableFixed = $('#paymentsTable').dataTable({
                'pageLength': 10,
                'bSort': false
            });
        });
    </script>
    {{--//Data Tables--}}
@endsection
