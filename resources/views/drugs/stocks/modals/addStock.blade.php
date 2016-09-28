<div class="modal fade" id="addStockModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add Stock</h4>
            </div>

            <form class="form-horizontal" method="post" action="{{route('addStock',['drugId'=>$drug->id])}}">

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

                    <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Quantity (in {{$drug->getQuantityType()}})</label>
                        <div class="col-md-9">
                            <input type="number" min="0" step="0.01" class="form-control" name="quantity"
                                   value="{{ old('quantity') }}">
                            @if ($errors->has('quantity'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('quantity') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('manufacturedDate') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Manufactured Date</label>
                        <div class="col-md-9">
                            <input type="date" class="form-control" name="manufacturedDate"
                                   value="{{ old('manufacturedDate') }}">
                            @if ($errors->has('manufacturedDate'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('manufacturedDate') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('receivedDate') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Purchased Date</label>
                        <div class="col-md-9">
                            <input type="date" class="form-control" name="receivedDate"
                                   value="{{ old('receivedDate') }}">
                            @if ($errors->has('receivedDate'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('receivedDate') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('expiryDate') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Expiry Date</label>
                        <div class="col-md-9">
                            <input type="date" class="form-control" name="expiryDate"
                                   value="{{ old('expiryDate') }}">
                            @if ($errors->has('expiryDate'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('expiryDate') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('remarks') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Remarks</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="remarks" rows="2">{{old('remarks')}}</textarea>
                            @if ($errors->has('remarks'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('remarks') }}</strong>
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


@if(session('type') && session('type')==="stock" && $errors->any())
    <script>
        $(document).ready(function () {
            $('#addStockModal').modal('show');
        });
    </script>
@endif