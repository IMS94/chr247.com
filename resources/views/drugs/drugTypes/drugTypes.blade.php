@extends('layouts.master')


@section('page_header')
    Quantity Types
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{route('root')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('drugs')}}">Drugs</a></li>
        <li class="active" href="#">Drug Types</li>
    </ol>
@endsection

@section('content')

    {{--Data Tables CSS--}}
    <link href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css">
    {{--//Data Tables CSS--}}

    <div class="box box-primary">
        <!--    Box Header  -->
        <div class="box-header with-border">

            @can('add','App\DrugType')
                <button class="btn btn-primary margin-left"
                        data-toggle="modal" data-target="#addDrugTypeModal">
                    Add Quantity Type
                    <i class="fa fa-question-circle-o fa-lg pull-right" data-toggle="tooltip"
                       data-placement="bottom" title=""
                       data-original-title="The measurements used to measure the available quantity(stock) of a drug.
                               ex: Number of 'Pills', number of 'Bottles', 'Litres'"></i>
                </button>
            @endcan
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

            <table class="table table-responsive table-condensed table-hover text-center" id="drugsTable">
                <thead>
                <tr>
                    <th>Quantity Type</th>
                    <th>Created By</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($drugTypes as $drugType)
                    <tr class="tableRow">
                        <td>
                            {{$drugType->drug_type}}
                        </td>
                        <td>
                            {{$drugType->creator->name}}
                        </td>
                        <td>
                            @can('delete',$drugType)
                                {{--
                                A modal is used to confirm the delete action.
                                One the modal popup, the url in the form changes according to the drug's id
                                --}}
                                <button class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#confirmDeleteDrugTypeModal" title=""
                                        onclick="showConfirmDelete({{$drugType->id}},'{{$drugType->drug_type}}')">
                                    <i class="fa fa-recycle fa-lg" data-toggle="tooltip"
                                       data-placement="bottom" title=""
                                       data-original-title="Delete this?"></i>
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

    @include('drugs.drugTypes.modals.addDrugType')

    @include('drugs.drugTypes.modals.confirmDelete')
    <script>
        /**
         * Method to show delete drug modal.
         * Updates the modal title and the form's action
         * @param drugId
         */
        function showConfirmDelete(drugTypeId, name) {
            $('#confirmDeleteDrugTypeModal .modal-title').html(name);
            $('#confirmDeleteDrugTypeModal form').prop("action",
                    "{{url('drugs/deleteDrugType')}}/" + drugTypeId);
        }
    </script>


    {{--Data Tables Scripts--}}
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables/dataTables.bootstrap.js')}}"></script>
    <script>
        $(document).ready(function () {
            var tableFixed = $('#drugsTable').dataTable({
                'pageLength': 10
            });
        });
    </script>
    {{--//Data Tables--}}

@endsection
