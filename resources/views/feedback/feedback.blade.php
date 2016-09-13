@extends('layouts.master')

@section('page_header','Feedback')

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title">
                Give Us Your Feedback !
            </h4>
        </div>
        <div class="box-body">
            <div class="callout callout-warning">
                <h4>We will always be free !</h4>
                <p>
                    Our objective is to <strong>continue to provide this service for free</strong>. Your
                    <strong>complaints, suggestions and ideas are important to us</strong>. Please spend few minutes to
                    give us your feedback, so that we can provide you with a better service in the future.
                    <strong>Thank you in advance !</strong>
                </p>
            </div>

            {{--Success Message--}}
            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Success!</h4>
                    {{session('success')}}
                </div>
            @endif

            <form action="{{url('feedback')}}" method="POST">

                {{csrf_field()}}

                <div class="row form-group {{ $errors->has('feedback') ? 'has-error' : '' }}">
                    <label class="control-label col-md-12 col-sm-12">Complaints, Suggestions and Ideas</label>
                    <div class="col-md-12 col-sm-12">
                        <textarea class="form-control" rows="8" name="feedback"
                                  placeholder="Complaints, Suggestions and Ideas"
                                  required>{{old('feedback')}}</textarea>
                        @if ($errors->has('feedback'))
                            <span class="help-block">
                                <strong>{{ $errors->first('feedback') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-md-3 col-md-offset-9 col-sm-6 col-sm-offset-6">
                        <button class="btn btn-success pull-right" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection