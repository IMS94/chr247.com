@extends('layouts.master')

@section('title','HIS | Settings')

@section('page_header')
    Settings
@endsection

@section('content')

    {{--Success Message--}}
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            {{session('success')}}
        </div>
    @endif


    {{--Change Password--}}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title">Change Password</h4>
        </div>
        <div class="box-body">
            <form class="form-horizontal" method="post" action="{{route('changePassword')}}">
                {!! csrf_field() !!}

                <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">Current Password</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="current_password">
                        @if ($errors->has('current_password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('current_password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">New Password</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">New Password Confirmation</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password_confirmation">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-edit"></i> Change Password
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    {{--/Change Password--}}


    @can('register','App\User')
    {{--Create new User--}}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title">Create New User</h4>
        </div>
        <div class="box-body">
            <form class="form-horizontal" method="post" action="{{route('createAccount')}}">
                {!! csrf_field() !!}

                <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">Name</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="user_name" value="{{old('user_name')}}">
                        @if ($errors->has('user_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('user_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('user_username') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">Username</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="user_username"
                               value="{{old('user_username')}}">
                        @if ($errors->has('user_username'))
                            <span class="help-block">
                                <strong>{{ $errors->first('user_username') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('user_role') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">Role</label>
                    <div class="col-md-6">
                        <select name="user_role" class="form-control">
                            <option value="">N/A</option>
                            @foreach(\App\Role::where('role','<>','Admin')->get() as $role)
                                <option value="{{$role->id}}" @if(old('user_role')===$role->id) selected @endif>
                                    {{$role->role}}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('user_role'))
                            <span class="help-block">
                                <strong>{{ $errors->first('user_role') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('user_password') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">Password</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="user_password">
                        @if ($errors->has('user_password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('user_password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('user_password_confirmation') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">Password Confirmation</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="user_password_confirmation">
                        @if ($errors->has('user_password_confirmation'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('user_password_confirmation') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-plus"></i> Create User
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    {{--/Create new User--}}
    @endcan


    <div class="box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title">Clinic's Users</h4>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-condensed table-striped table-hover text-center">
                <thead>
                <tr>
                    <th class="col-md-4">Name</th>
                    <th class="col-md-3">Username</th>
                    <th class="col-md-3">Role</th>
                    <th class="col-md-2"></th>
                </tr>
                </thead>
                <tbody>
                @foreach(\App\Clinic::getCurrentClinic()->users as $user)
                    <tr @if(\App\User::getCurrentUser()->id===$user->id) class="success" @endif>
                        <td>{{$user->name}}</td>
                        <td>{{$user->username}}</td>
                        <td>{{$user->role->role}}</td>
                        <td></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection