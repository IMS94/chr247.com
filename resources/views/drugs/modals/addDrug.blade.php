<div class="modal fade" id="addDrugModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add Patient</h4>
            </div>

            <form class="form-horizontal" method="post" action="{{route('addPatient')}}">

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

                    <div class="form-group{{ $errors->has('firstName') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">First Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="firstName" value="{{ old('firstName') }}"
                                   required>
                            @if ($errors->has('firstName'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('firstName') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('lastName') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Last Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="lastName" value="{{ old('lastName') }}">
                            @if ($errors->has('lastName'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('lastName') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Date of Birth</label>
                        <div class="col-md-9">
                            <input type="date" class="form-control" name="dob" value="{{ old('dob') }}"
                                   max="{{date('Y-m-d')}}"
                                   min="{{date('Y-m-d',strtotime(date('Y-m-d').' -150 year'))}}">
                            @if ($errors->has('dob'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('dob') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Address</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                            @if ($errors->has('address'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('nic') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">NIC</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="nic" value="{{ old('nic') }}"
                                   pattern="[0-9]{9}[vV]">
                            @if ($errors->has('nic'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('nic') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Contact No.</label>
                        <div class="col-md-9">
                            <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}">
                            @if ($errors->has('phone'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('postSurgicalHistory') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Post Surgical History</label>
                        <div class="col-md-9">
                            <textarea class="form-control" rows="2"
                                      name="postSurgicalHistory">{{old('postSurgicalHistory')}}</textarea>
                            @if ($errors->has('postSurgicalHistory'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('postSurgicalHistory') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('remarks') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label">Remarks</label>
                        <div class="col-md-9">
                            <textarea class="form-control" rows="2" name="remarks">{{old('remarks')}}</textarea>
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


@if(session('type') && session('type')==="drug" && $errors->any())
    <script>
        $(document).ready(function () {
            $('#addDrugModal').modal('show');
        });
    </script>
@endif