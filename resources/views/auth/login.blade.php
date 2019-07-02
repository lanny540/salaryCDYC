@extends('auth.layouts')

@section('content')
    <div class="loginColumns animated fadeInDown">
        <div class="row">
            <div class="col-md-6">
                <h2 class="font-bold">员工薪酬核算系统</h2>
                <hr/>
                <p>
                    友情提示:
                </p>
                {{--TODO:友情提示信息--}}
                <p>
                    <small>1.It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</small>
                </p>
                <p>
                    <small>2.It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</small>
                </p>
                <p>
                    <small>3.It has survived not only five centuries.</small>
                </p>
            </div>
            <div class="col-md-6">
                <div class="ibox-content">
                    {{ Form::open(['method' => 'POST', 'route' => 'login', 'role' => 'form', 'class' => 'm-t']) }}
                    <div class="form-group">
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('用户名') }}" required autofocus>
                        @if ($errors->has('name'))
                            <span class="help-block" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('密码') }}" required>
                        @if ($errors->has('password'))
                            <span class="help-block" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary block full-width m-b">
                        {{ __('登录') }}
                    </button>

                    @if (Route::has('password.request'))
                        <p class="text-muted text-center">
                            <small>忘记密码了?</small>
                        </p>
                        <a class="btn btn-sm btn-white btn-block" href="{{ route('password.request') }}"> {{ __('重置密码') }}</a>
                    @endif
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                Copyright 成都印钞有限公司 - 企划信息部
            </div>
            <div class="col-md-6 text-right">
                <small>© 2019-2020</small>
            </div>
        </div>
    </div>
@endsection
