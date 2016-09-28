<div class="modal fade" id="editDrugModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title">Edit Drug</h4>
            </div>

            <form class="form-horizontal" method="post" action="{{route('editDrug',['id'=>$drug->id])}}">

                <div class="box-body">

                    {{-- Warning when there's no quantity type pre entered --}}
                    @if($drug->clinic->quantityTypes()->count()==0)
                        <div class="alert alert-warning alert-dismissable container-fluid">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-warning"></i> No Quantity Types Available !</h4>
                            In order to add drugs, quantity types are required. Quantity Types are used to manage
                            stocks. Go to <a href="{{route('drugTypes')}}"><strong> Quantity Types</strong> </a> to add
                            quantity types.
                        </div>
                    @endif

                    {{-- General error message --}}
                    @if ($errors->has('general'))
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Oops!</h4>
                            {{ $errors->first('general') }}
                        </div>
                    @endif

                    {{csrf_field()}}

                    <div class="form-group{{ $errors->has('drugName') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Drug Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="drugName"
                                   value="{{ old('drugName')?:$drug->name }}" required>
                            @if ($errors->has('drugName'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('drugName') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('ingredient') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Ingredient</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="ingredient"
                                   value="{{ old('ingredient')?:$drug->ingredient }}" required>
                            @if ($errors->has('ingredient'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('ingredient') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('quantityType') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Quantity Type</label>
                        <div class="col-md-9">
                            <select name="quantityType" class="form-control">
                                @foreach($drug->clinic->quantityTypes as $quantityType)
                                    <option value="{{$quantityType->id}}"
                                            @if($quantityType->id === $drug->quantityType->id) selected @endif>
                                        {{$quantityType->drug_type}}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('quantityType'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('quantityType') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('manufacturer') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Manufacturer</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="manufacturer"
                                   value="{{ old('manufacturer')?: $drug->manufacturer }}" required>
                            @if ($errors->has('manufacturer'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('manufacturer') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary pull-right">Update</button>
                </div><!-- /.box-footer -->
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

@if(session('type') && session('type')==="drug" && $errors->any())
    <script>
        $(document).ready(function () {
            $('#editDrugModal').modal('show');
        });
    </script>
@endif