@extends('layouts.master')

@section('page_header')
    Queue
@endsection

@section('content')
    <script src="{{asset('plugins/angularjs/angular.min.js')}}"></script>
    <script src="{{asset('js/services.js')}}"></script>
    <script src="{{asset('js/filters.js')}}"></script>
    <script src="{{asset('js/QueueController.js')}}"></script>

    <div class="box box-primary" ng-app="HIS" ng-controller="QueueController">

        <div class="box-header">

            {{--
            Check if the user have permissions to create a new queue.
            If yes, a confirmation is taken when creating a new queue
            --}}
            @can('create','App\Queue')
            <button class="btn btn-primary margin-left" onclick="createQueue()">
                <i class="fa fa-plus fa-lg"></i> Create New Queue
            </button>

            <script>
                function createQueue() {
                    if (window.confirm("Creating a new queue will discard all the existing queues. Are you sure?")) {
                        window.location = "{{route('createQueue')}}";
                    }
                }
            </script>
            @endcan

            @can('close',$queue)
            <button class="btn btn-danger pull-right" onclick="closeQueue()">
                <i class="fa fa-close fa-lg"></i> Close Queue
            </button>

            <script>
                function closeQueue() {
                    if (window.confirm("Are you sure you want to close this queue? " +
                                    "You won't be able to roll back this action.")) {
                        window.location = "{{route('closeQueue')}}";
                    }
                }
            </script>
            @endcan
        </div>

        <div class="box-body">
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


            {{-- Initialize the angular variables in a hidden field --}}
            <input type="hidden" ng-init="baseUrl='{{url("/")}}';token='{{csrf_token()}}';getQueue()">

            @if(empty($queue))

                {{-- Info message if there is no queue --}}
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i> Sorry!</h4>
                    No active queues at the moment! Please create a new queue to continue.
                </div>

            @else
                {{-- Info message if there are patients in the queue --}}
                <div class="alert alert-info" ng-if="patients.length==0" ng-cloak>
                    <h4><i class="icon fa fa-info"></i> Sorry!</h4>
                    No Patient in the queue at the moment.
                </div>

                <div class="alert alert-danger" ng-show="hasError" ng-cloak>
                    <h4><i class="icon fa fa-ban"></i> Oops!</h4>
                    [[error]]
                </div>

                {{--Queue--}}
                <table class="table table-hover table-condensed table-bordered text-center" ng-cloak>
                    <tr ng-repeat="patient in patients track by $index" class="info">
                        <td class="col-md-1">[[$index+1]]</td>
                        <td class="col-md-7">
                            <a href="[[baseUrl]]/patients/patient/[[patient.id]]">
                                [[patient.first_name]] [[patient.last_name]]
                            </a>
                        </td>
                        <td class="col-md-4">
                            <button class="btn btn-sm"
                                    ng-class="{'btn-default':patient.type==0,'btn-success':patient.type==1,'btn-danger':patient.type==2}"
                                    ng-mouseenter="enter([[$index]])" ng-mouseleave="leave([[$index]])"
                                    ng-click="updateQueue([[$index]])">
                                [[patient.status]]
                            </button>
                        </td>
                    </tr>
                </table>
            @endif

        </div>
    </div>

@endsection