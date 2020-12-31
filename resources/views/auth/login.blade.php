@extends('auth.layouts')

@section('content')
    <div class="loginColumns animated fadeInDown">
        <div class="row">
            <div class="col-md-7">
                <h1 class="font-bold">员工薪酬核算系统</h2>
                <hr/>
                <div class="blockquote">
                    <p>1.&nbsp;&nbsp;本系统主要用于员工薪酬查询，数据源来源计划财务部。如发现数据异常，请及时主动联系计划财务部相关会计。</p>
                    <p>2.&nbsp;&nbsp;薪酬数据为个人重要隐私数据，请用户妥善保管密码，在查询结束后<strong>及时登出</strong>防止隐私泄露。</p>
                    <p>3.&nbsp;&nbsp;首次登录的用户名为个人的<strong>&nbsp;保险编号&nbsp;</strong>，密码为<strong>&nbsp;123qwe&nbsp;</strong>，请用户在首次登录后立刻修改密码。<strong>保险编号</strong>可通过工资条查询或者电话查询（计划财务部 曾伟航：5165）。</p>
                </div>
            </div>
            <div class="col-md-5">
                <div class="ibox-content">
                    {{ Form::open(['method' => 'POST', 'route' => 'login', 'role' => 'form', 'class' => 'm-t']) }}
                    <div class="form-group" style="margin: 30px 0px 40px 0px;">
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('用户名') }}" required autofocus>
                        @if ($errors->has('name'))
                            <span class="help-block" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group" style="margin: 40px 0px 40px 0px;">
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
                Copyright 成都印钞有限公司 - 计划财务部、信息技术部
            </div>
            <div class="col-md-6 text-right">
                <small>© 2019-2021</small>
            </div>
        </div>
    </div>
@endsection
