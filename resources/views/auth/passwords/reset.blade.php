@extends('auth.layouts')

@section('content')
<div class="passwordBox animated fadeInDown">
    @if (Session::has('success'))
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title blue-bg text-center">
                    <h4>{{ Session::get('success') }}</h4>
                    <div class="ibox-tools">
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($errors->any())
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title red-bg text-center">
                    @foreach ($errors->all() as $error)
                        <P>{{ $error }}</P>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="ibox-content">
                <h2 class="font-bold text-center">{{ __('重置密码') }}</h2>
                <h4 class="text-center">请填写以下信息，然后点击重置密码。</h4>
                {{ Form::open(['route' => 'password.reset', 'method' => 'POST', 'class' => 'm-t', 'role' => 'form']) }}
                <div class="form-group row">
                    <label class="col-md-4 col-form-label">{{ __('用户名') }}</label>
                    <div class="col-md-8">
                        <input type="text" value="{{ old('name') }}" placeholder="用户名" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required>
                        @if ($errors->has('name'))
                            <span class="form-text m-b-none invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label">{{ __('身份证号码') }}</label>
                    <div class="col-md-8">
                        <input type="text" value="{{ old('uid') }}" placeholder="身份证号码" name="uid" class="form-control{{ $errors->has('uid') ? ' is-invalid' : '' }}" required>
                        @if ($errors->has('uid'))
                            <span class="form-text m-b-none invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('uid') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label">{{ __('新密码') }}</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                        @if ($errors->has('password'))
                            <span class="form-text m-b-none invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-4 col-form-label">{{ __('确认新密码') }}</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary block full-width m-b">{{ __('重置密码') }}</button>

                {{ Form::close() }}
                <a class="btn btn-sm btn-white btn-block" href="{{ route('login') }}"> {{ __('返回登录') }}</a>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-6">
            Copyright 成都印钞有限公司
        </div>
        <div class="col-md-6 text-right">
            <small>© 2019-2020</small>
        </div>
    </div>
</div>
@endsection
