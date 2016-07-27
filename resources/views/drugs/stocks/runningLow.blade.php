@extends('layouts.master')


@section('page_header')
    Drugs with Stocks Running Low
@endsection


@section('content')

    <div class="box box-primary">
        <div class="box-header">
            <h4 class="box-title">Stocks with quantity less than 100 units</h4>
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

            <table class="table table-responsive table-condensed table-hover text-center" id="stocksTable">
                <thead>
                <tr>
                    <th>Drug Name</th>
                    <th>Manufacturer</th>
                    <th>Available Quantity</th>
                </tr>
                </thead>
                <tbody>
                @forelse($drugs as $drug)
                    <tr class="tableRow" onclick="window.location='{{route('drug',['id'=>$drug->id])}}'">
                        <td>{{$drug->name}}</td>
                        <td>{{$drug->manufacturer}}</td>
                        <td>{{$drug->quantity}} ({{$drug->quantityType->drug_type}})</td>
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
            var tableFixed = $('#stocksTable').dataTable({
                'pageLength': 10
            });
        });
    </script>
    {{--//Data Tables--}}
@endsection
