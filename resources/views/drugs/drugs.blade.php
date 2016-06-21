@extends('layouts.master')


@section('page_header')
    Drugs
@endsection


@section('content')
    <div ng-app="HIS" ng-controller="DrugController">
        {{-- Initialize the angular variables in a hidden field --}}
        <input type="hidden"
               ng-init="baseUrl='{{url("/")}}';token='{{csrf_token()}}';">

        <div class="box box-primary">
            <!--    Box Header  -->
            <div class="box-header with-border">

                @can('add','App\Drug')
                <button class="btn btn-primary margin"
                        data-toggle="modal" data-target="#addDrugModal">
                    Add Drug
                </button>
                @endcan

                <a class="btn btn-primary margin pull-right" href="{{route('drugTypes')}}">
                    Quantity Types
                </a>

                <a class="btn btn-primary margin pull-right" href="{{route('dosages')}}">
                    Dosages
                </a>

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
                        <h4><i class="icon fa fa-ban"></i> Error!</h4>
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

                <table class="table table-responsive table-condensed table-hover text-center" id="drugsTable">
                    <thead>
                    <tr>
                        <th>Drug Name</th>
                        <th>Quantity Type</th>
                        <th>Manufacturer</th>
                        <th>Quantity</th>
                        <th></th>
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
                            <td>
                                @can('delete',$drug)
                                {{--
                                A modal is used to confirm the delete action.
                                One the modal popup, the url in the form changes according to the drug's id
                                --}}
                                <button class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#confirmDeleteDrugModal"
                                        onclick="showConfirmDelete({{$drug->id}},'{{$drug->name}}')">
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

        @include('drugs.modals.addDrug')

        @include('drugs.modals.confirmDelete')

        <script>
            /**
             * Method to show delete drug modal.
             * Updates the modal title and the form's action
             * @param drugId
             */
            function showConfirmDelete(drugId, name) {
                $('#confirmDeleteDrugModal .modal-title').html(name);
                $('#confirmDeleteDrugModal form').prop("action", "{{url('drugs/deleteDrug')}}/" + drugId);
            }
        </script>


        {{--Data Tables Scripts--}}
        <script>
            $(document).ready(function () {
                var tableFixed = $('#drugsTable').dataTable({
                    'pageLength': 10
                });
            });
        </script>
        {{--//Data Tables--}}
    </div>

    {{--AngularJs Scripts--}}
    <script src="{{asset('plugins/angularjs/angular.min.js')}}"></script>
    <script src="{{asset('js/services.js')}}"></script>
    <script src="{{asset('js/DrugController.js')}}"></script>
@endsection
