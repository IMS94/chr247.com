@extends('layouts.master')


@section('page_header')
    Dosages
@endsection


@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{route('root')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('drugs')}}">Drugs</a></li>
        <li class="active" href="#">Dosages</li>
    </ol>
@endsection

@section('content')

    <div class="box box-primary">
        <!--    Box Header  -->
        <div class="box-header with-border">
            @can('add','App\Dosage')
                <button class="btn btn-primary margin" data-toggle="modal" data-target="#addDosageModal">
                    Add Dosage
                    <i class="fa fa-question-circle-o fa-lg" data-toggle="tooltip"
                       data-placement="bottom" title=""
                       data-original-title="The quantities of drugs to be taken at a time.
                       ex: 1 pill at a time, 1 table spoon at a time"></i>
                </button>

                <button class="btn btn-primary margin" data-toggle="modal" data-target="#addFrequencyModal">
                    Add Dosage Frequency
                    <i class="fa fa-question-circle-o fa-lg" data-toggle="tooltip"
                       data-placement="bottom" title=""
                       data-original-title="How often a drug is to be taken. ex: 3 times per day, per every 8 hours"></i>
                </button>

                <button class="btn btn-primary margin" data-toggle="modal" data-target="#addPeriodModal">
                    Add Dosage Period
                    <i class="fa fa-question-circle-o fa-lg" data-toggle="tooltip"
                       data-placement="bottom" title=""
                       data-original-title="For how long a drug is to be taken. ex: For 3 weeks, For 6 months"></i>
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
                        <h4><i class="icon fa fa-ban"></i> Error!</h4>
                        {{session('error')}}
                    </div>
                @endif
            </div>
        @endif
    </div>

    <div>
        {{-- Dosages --}}
        <div class="box box-success">
            <div class="box-header with-border">
                <h4 class="box-title">Dosages
                    <i class="fa fa-question-circle-o fa-lg pull-right" data-toggle="tooltip"
                       data-placement="bottom" title=""
                       data-original-title="The quantities of drugs to be taken at a time.
                       ex: 1 pill at a time, 1 table spoon at a time"></i>
                </h4>
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
                        <tr>
                            <td class="col-md-8">
                                {{$dosage->description}}
                                <form class="col-md-12" action="{{route('editDosage',['id'=>$dosage->id])}}"
                                      id="dosage{{$dosage->id}}" method="post" hidden>
                                    {{csrf_field()}}
                                    <div class="col-md-10 col-xs-12">
                                        <input class="form-control" type="text" name="dosage"
                                               value="{{$dosage->description}}">
                                    </div>
                                    <div class="col-md-2 col-xs-12">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>
                            <td class="col-md-4">
                                @can('edit',$dosage)
                                    <button class="btn btn-sm btn-primary"
                                            onclick="$('#dosage{{$dosage->id}}').slideToggle()">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                @endcan
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
                <h4 class="box-title">Dosage Frequencies
                    <i class="fa fa-question-circle-o fa-lg pull-right" data-toggle="tooltip"
                       data-placement="bottom" title=""
                       data-original-title="How often a drug is to be taken. ex: 3 times per day, per every 8 hours"></i>
                </h4>
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
                        <tr>
                            <td>
                                {{$frequency->description}}

                                <form action="{{route('editFrequency',['id'=>$frequency->id])}}"
                                      id="frequency{{$frequency->id}}" method="post" hidden>
                                    {{csrf_field()}}
                                    <div class="row col-md-12 col-xs-12">
                                        <div class="col-md-10 col-xs-12">
                                            <input class="form-control" type="text" name="frequency"
                                                   value="{{$frequency->description}}">
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                            <td>
                                @can('edit',$frequency)
                                    <button class="btn btn-sm btn-primary"
                                            onclick="$('#frequency{{$frequency->id}}').slideToggle()">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                @endcan
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
                <h4 class="box-title">Dosage Periods
                    <i class="fa fa-question-circle-o fa-lg pull-right" data-toggle="tooltip"
                       data-placement="bottom" title=""
                       data-original-title="For how long a drug is to be taken. ex: For 3 weeks, For 6 months"></i>
                </h4>
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
                        <tr>
                            <td>
                                {{$period->description}}

                                <form action="{{route('editPeriod',['id'=>$period->id])}}"
                                      id="period{{$period->id}}" method="post" hidden>
                                    {{csrf_field()}}
                                    <div class="row col-md-12 col-xs-12">
                                        <div class="col-md-10 col-xs-12">
                                            <input class="form-control" type="text" name="period"
                                                   value="{{$period->description}}">
                                        </div>
                                        <div class="col-md-2 col-xs-12">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                            <td>
                                @can('edit',$period)
                                    <button class="btn btn-sm btn-primary"
                                            onclick="$('#period{{$period->id}}').slideToggle()">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                @endcan
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
