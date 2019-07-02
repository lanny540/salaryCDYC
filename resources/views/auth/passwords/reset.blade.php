@extends('auth.layouts')

@section('content')
    <div class="passwordBox animated fadeInDown">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox-content">
                    <h2 class="font-bold text-center">{{ __('重置密码') }}</h2>
                    <h4 class="text-center">请填写以下信息，然后点击重置密码。</h4>
                    {{ Form::open(['route' => 'password.reset', 'method' => 'POST', 'class' => 'm-t', 'role' => 'form']) }}
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">{{ __('相关信息') }}</label>

                            <div class="col-md-8">
                                <input type="email" placeholder="Email" class="form-control">
                                @if ($errors->has('email'))
                                    <span class="form-text m-b-none invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
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
