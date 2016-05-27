@extends('layouts.master')


@section('page_header')
    Dosages
@endsection


@section('content')

    <div class="box box-primary">
        <!--    Box Header  -->
        <div class="box-header with-border">
            @can('add','App\Dosage')
            <button class="btn btn-primary margin" data-toggle="modal" data-target="#addDosageModal">
                Add Dosage
            </button>

            <button class="btn btn-primary margin" data-toggle="modal" data-target="#addFrequencyModal">
                Add Dosage Frequency
            </button>

            <button class="btn btn-primary margin" data-toggle="modal" data-target="#addPeriodModal">
                Add Dosage Period
            </button>
            @endcan
        </div>


        @if(session()->has('success') || session()->has('error'))
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
            </div>
        @endif
    </div>


    {{-- Dosages --}}
    <div class="box box-success">
        <div class="box-header with-border">
            <h4 class="box-title">Dosages</h4>
        </div>
        <div class="box-body">
            <table class="table table-responsive table-condensed table-hover text-center" id="dosagesTable">
                <thead>
                <tr>
                    <th class="col-md-8">Dosage</th>
                    <th class="col-md-4"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($dosages as $dosage)
                    <tr class="tableRow">
                        <td>
                            {{$dosage->description}}
                        </td>
                        <td>
                            @can('delete',$dosage)
                            <a class="btn btn-sm btn-danger"
                               href="{{route('deleteDosage',['id'=>$dosage->id])}}">
                                <i class="fa fa-recycle"></i>
                            </a>
                            @endcan
                        </td>
                    </tr>
                @empty

                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Frequencies --}}
    <div class="box box-success">
        <div class="box-header with-border">
            <h4 class="box-title">Dosage Frequencies</h4>
        </div>
        <div class="box-body">
            <table class="table table-responsive table-condensed table-hover text-center"
                   id="frequenciesTable">
                <thead>
                <tr>
                    <th class="col-md-8">Frequency</th>
                    <th class="col-md-4"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($frequencies as $frequency)
                    <tr class="tableRow">
                        <td>
                            {{$frequency->description}}
                        </td>
                        <td>
                            @can('delete',$frequency)
                            <a class="btn btn-sm btn-danger"
                               href="{{route('deleteFrequency',['id'=>$frequency->id])}}">
                                <i class="fa fa-recycle"></i>
                            </a>
                            @endcan
                        </td>
                    </tr>
                @empty

                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Periods --}}
    <div class="box box-success">
        <div class="box-header with-border">
            <h4 class="box-title">Dosage Periods</h4>
        </div>
        <div class="box-body">
            <table class="table table-responsive table-condensed table-hover text-center" id="periodsTable">
                <thead>
                <tr>
                    <th class="col-md-8">Period</th>
                    <th class="col-md-4"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($periods as $period)
                    <tr class="tableRow">
                        <td>
                            {{$period->description}}
                        </td>
                        <td>
                            @can('delete',$period)
                            <a class="btn btn-sm btn-danger"
                               href="{{route('deletePeriod',['id'=>$period->id])}}">
                                <i class="fa fa-recycle"></i>
                            </a>
                            @endcan
                        </td>
                    </tr>
                @empty

                @endforelse
                </tbody>
            </table>
        </div>
    </div>


    @include('drugs.dosages.modals.addDosage')
    @include('drugs.dosages.modals.addFrequency')
    @include('drugs.dosages.modals.addPeriod')


    {{--Data Tables Scripts--}}
    <script>
        $(document).ready(function () {
            $('#dosagesTable').dataTable({
                'pageLength': 10
            });

            $('#periodsTable').dataTable({
                'pageLength': 10
            });

            $('#frequenciesTable').dataTable({
                'pageLength': 10
            });
        });
    </script>
    {{--//Data Tables--}}

@endsection
