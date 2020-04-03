@extends('layouts.app')

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>密码变更</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>密码修改</strong>
                </li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-content">
                    {{ Form::open(['route' => ['password.reset2'], 'method' => 'POST']) }}
                    <div class="panel-body">
                        <fieldset>
                            <div class="form-group row">
                                <label class="col-sm-2 offset-2 col-form-label text-center" for="oldpassword">旧密码:</label>
                                <div class="col-sm-6">
                                    <input type="password" name="oldpassword" class="form-control{{ $errors->has('oldpassword') ? ' is-invalid' : '' }}" id="oldpassword" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 offset-2 col-form-label text-center" for="password">新密码:</label>
                                <div class="col-sm-6">
                                    <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 offset-2 col-form-label text-center" for="password_confirmation">重复新密码:</label>
                                <div class="col-sm-6">
                                    <input type="password" name="password_confirmation" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" id="password_confirmation" required>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="user-button">
                        <button type="submit" class="btn btn-primary btn-lg btn-block col-md-4 offset-4"><i class="fa fa-envelope"></i> 确认修改</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
