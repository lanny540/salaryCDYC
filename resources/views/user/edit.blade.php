@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
@stop

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>人员信息变更</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    系统设置
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('users.index') }}">人员列表</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>信息变更</strong>
                </li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-md-6">
                <div class="ibox collapsed">
                    <div class="ibox-title">
                        <h5>基本信息<small class="m-l-sm">任何人都能修改</small> </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="tabs-container">
                            {{ Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'PUT']) }}
                            <ul class="nav nav-tabs">
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> 个人基本信息</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-2"> 薪酬相关信息</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        <fieldset>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label text-center">工号:</label>
                                                <div class="col-sm-9">{{ Form::text('name', $user->name, ['class' => 'form-control', 'disabled']) }}</div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label text-center">部门:</label>
                                                <div class="col-sm-9">
                                                    <select name="department_id" class="form-control">
                                                        @foreach($departments as $department)
                                                            <option value="{{ $department->id }}"
                                                                    id="{{ $department->id }}"
                                                                    @if($department->id === $user->profile->department_id)
                                                                    selected
                                                                @endif >
                                                                {{ $department->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label text-center">手机:</label>
                                                <div class="col-sm-9">{{ Form::text('mobile', $user->profile->mobile, ['class' => 'form-control']) }}</div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label text-center">电话:</label>
                                                <div class="col-sm-9">{{ Form::text('phone', $user->profile->phone, ['class' => 'form-control']) }}</div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label text-center">地址:</label>
                                                <div class="col-sm-9">{{ Form::text('address', $user->profile->address, ['class' => 'form-control']) }}</div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label text-center">状态:</label>
                                                <div class="col-sm-9">
                                                    {{ Form::select('status', ['在职' => '在职', '离职' => '离职', '行业内交流' => '行业内交流'], $user->profile->status, ['class' => 'form-control']) }}
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <fieldset>
                                            <div class="form-group row"><label class="col-sm-4 col-form-label text-center">身份证号:</label>
                                                <div class="col-sm-8">{{ Form::text('uid', $user->profile->uid, ['class' => 'form-control']) }}</div>
                                            </div>
                                            <div class="form-group row"><label class="col-sm-4 col-form-label text-center">保险编号:</label>
                                                <div class="col-sm-8">{{ Form::text('policyNumber', $user->profile->policyNumber, ['class' => 'form-control', 'disabled']) }}</div>
                                            </div>
                                            <div class="form-group row"><label class="col-sm-4 col-form-label text-center">工资卡号:</label>
                                                <div class="col-sm-8">{{ Form::text('wageCard', $user->profile->wageCard, ['class' => 'form-control']) }}</div>
                                            </div>
                                            <div class="form-group row"><label class="col-sm-4 col-form-label text-center">奖金卡号:</label>
                                                <div class="col-sm-8">{{ Form::text('bonusCard', $user->profile->bonusCard, ['class' => 'form-control']) }}</div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="user-button">
                                <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fa fa-envelope"></i> 确认修改</button>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="ibox collapsed">
                    <div class="ibox-title">
                        <h5>特殊信息<small class="m-l-sm">只有财务管理员能修改</small> </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <ul class="nav nav-tabs">
                            <li><a class="nav-link active" data-toggle="tab" href="#tab-3"> 特殊信息</a></li>
                            <li><a class="nav-link" data-toggle="tab" href="#tab-4"> 非工行卡信息</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-3" class="tab-pane active">
                                <div class="panel-body">
                                    {{ Form::model($user, ['route' => ['user.update.s', $user->id], 'method' => 'PUT']) }}
                                    <fieldset>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label text-center">入职时间</label>
                                            <div class="col-sm-8">
                                                {{ Form::text('hiredate', $user->profile->hiredate, ['class' => 'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label text-center">离职时间</label>
                                            <div class="col-sm-8">
                                                {{ Form::text('departure', $user->profile->departure, ['class' => 'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label text-center">是否残疾人</label>
                                            <div class="col-sm-8">
                                                <div class="i-checks">
                                                    <label>
                                                        {{ Form::checkbox('handicapped', $user->profile->handicapped, $user->profile->handicapped) }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label text-center">减免税率</label>
                                            <div class="col-sm-8">
                                                {{ Form::text('tax_rebates', $user->profile->tax_rebates, ['class' => 'form-control', 'disabled']) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fa fa-envelope"></i> 确认修改</button>
                                        </div>
                                    </fieldset>
                                    {{ Form::close() }}
                                </div>
                            </div>
                            <div id="tab-4" class="tab-pane">
                                <div class="panel-body">
                                    {{ Form::model($user, ['route' => ['user.remit', $user->id], 'method' => 'PUT']) }}
                                    <fieldset>
                                        {{ Form::hidden('flag', 1) }}
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label text-center">代汇卡号</label>
                                            <div class="col-sm-8">
                                                {{ Form::text('remit_card_no', isset($user->remit->remit_card_no) ? $user->remit->remit_card_no : '', ['class' => 'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label text-center">代汇姓名</label>
                                            <div class="col-sm-8">
                                                {{ Form::text('remit_name', isset($user->remit->remit_name) ? $user->remit->remit_name : '', ['class' => 'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label text-center">代汇开户行</label>
                                            <div class="col-sm-8">
                                                {{ Form::text('remit_bank', isset($user->remit->remit_bank) ? $user->remit->remit_bank : '', ['class' => 'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label text-center">代汇行号</label>
                                            <div class="col-sm-8">
                                                {{ Form::text('remit_bank_no', isset($user->remit->remit_bank_no) ? $user->remit->remit_bank_no : '', ['class' => 'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label text-center">代汇省份</label>
                                            <div class="col-sm-8">
                                                {{ Form::text('remit_province', isset($user->remit->remit_province) ? $user->remit->remit_province : '', ['class' => 'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label text-center">代汇市</label>
                                            <div class="col-sm-8">
                                                {{ Form::text('remit_city', isset($user->remit->remit_city) ? $user->remit->remit_city : '', ['class' => 'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fa fa-envelope"></i> 确认修改</button>
                                        </div>
                                    </fieldset>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="ibox">
                    {{ Form::model($user, ['route' => ['user.changeRole', $user->id], 'method' => 'PUT']) }}
                    <div class="ibox-title">
                        <h5>角色变更</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="forum-title">
                            <h3><i class="fa fa-gear"></i> 系统角色</h3>
                        </div>
                        <div class="forum-item">
                            <div class="row">
                                @foreach($roles as $r)
                                    @if($r->typeId === 0)
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="checkbox checkbox-primary">
                                                    {{ Form::checkbox('roles[]', $r->id, $user->roles, ['id' => 'role'.$r->id]) }}
                                                    <label for="role{{ $r->id }}">{{ $r->description }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="forum-title">
                            <h3><i class="fa fa-cloud"></i> 流程角色</h3>
                        </div>
                        <div class="forum-item">
                            <div class="row">
                                @foreach($roles as $r)
                                    @if($r->typeId === 1)
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="checkbox checkbox-primary">
                                                    {{ Form::checkbox('roles[]', $r->id, $user->roles, ['id' => 'role'.$r->id]) }}
                                                    <label for="role{{ $r->id }}">{{ $r->description }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="forum-title">
                            <h3><i class="fa fa-shield"></i> 业务角色</h3>
                        </div>
                        <div class="forum-item">
                            <div class="row">
                                @foreach($roles as $r)
                                    @if($r->typeId === 9)
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="checkbox checkbox-primary">
                                                    {{ Form::checkbox('roles[]', $r->id, $user->roles, ['id' => 'role'.$r->id]) }}
                                                    <label for="role{{ $r->id }}">{{ $r->description }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-4 offset-4">
                            {{ Form::submit('修改所属角色', ['class' => 'form-controll btn btn-lg btn-block btn-primary']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <!-- iCheck -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            let cb = $("input[name='handicapped']");
            let ischecked = cb.is(':checked');
            cb.click(function () {
                ischecked = !ischecked;
                cb.attr('checked', !ischecked);
                if (ischecked) {
                    cb.val(1);
                    $("input[name='tax_rebates']").removeAttr('disabled');
                } else {
                    $("input[name='tax_rebates']").attr('disabled', true);
                }
            });

        });
    </script>
@stop
