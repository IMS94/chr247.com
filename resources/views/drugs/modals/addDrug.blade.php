<div class="modal fade" id="addDrugModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add Patient</h4>
            </div>

            <form class="form-horizontal" method="post" action="{{route('addDrug')}}">

                <div class="box-body">

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
                            <input type="text" class="form-control" name="drugName" value="{{ old('drugName') }}"
                                   required>
                            @if ($errors->has('drugName'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('drugName') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('quantityType') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Quantity Type</label>
                        <div class="col-md-9">
                            <select name="quantityType" class="form-control">
                                @foreach(\App\DrugType::all() as $quantityType)
                                    <option value="{{$quantityType->id}}"
                                            @if($quantityType->id === old('quantityType')) selected @endif>
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
                                   value="{{ old('manufacturer') }}" required>
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
                    <button type="submit" class="btn btn-primary pull-right">Add</button>
                </div><!-- /.box-footer -->
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


@if(session('type') && session('type')==="drug" && $errors->any())
    <script>
        $(document).ready(function () {
            $('#addDrugModal').modal('show');
        });
    </script>
@endif