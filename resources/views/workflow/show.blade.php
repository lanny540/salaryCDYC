@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
@stop

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>流程处理</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('check.index') }}">流程列表</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>流程详情</strong>
                </li>
            </ol>
        </div>
    </div>
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInUp">
    <div class="row">
        <div class="col-lg-7">
            <div class="ibox">
                <div class="ibox-title">
                    <h3>流程名称: {{ $workflow->title }}</h3>
                </div>
                <div class="ibox-content">
                    <div class="form-group row">
                        <div class="col-sm-3 text-center">
                            <dt>流程文档查看</dt>
                        </div>
                        <div class="col-sm-9">
                            <dd class="mb-1">
                                <a href="{{ $workflow->fileUrl }}" class="text-navy">点此下载</a>
                            </dd>
                        </div>
                    </div>
                    @if($workflow->statusCode === 9)
                        <div class="form-group row">
                            <div class="col-sm-3 text-center">
                                <dt>办理结果</dt>
                            </div>
                            <div class="col-sm-9">
                                <dd>已办结</dd>
                            </div>
                        </div>
                    @elseif($workflow->statusCode === 0)
                        {{ Form::open(['route' => 'check.post', 'method' => 'POST', 'class' => 'm-t-md']) }}
                        {{ Form::hidden('wfId', $workflow->id) }}
                        <div class="form-group row">
                            <div class="col-sm-3 text-center">
                                <dt>办理结果</dt>
                            </div>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="radio radio-success">
                                            {{ Form::radio('action', '1', true, ['id' => 'wf_apply']) }}
                                            {{ Form::label('wf_apply', '发起流程') }}
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="radio radio-danger">
                                            {{ Form::radio('action', '-1', false, ['id' => 'wf_back']) }}
                                            {{ Form::label('wf_back', '删除') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 text-center">
                                <dt>办理意见</dt>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::textarea('content', '', ['id' => 'content', 'class' => 'form-control', 'rows' => '6', 'style' => 'resize:none;']) }}
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            {{ Form::submit('办理', ['class' => 'btn btn-lg btn-block btn-primary offset-3 col-6']) }}
                        </div>
                        {{ Form::close() }}
                    @else
                        {{ Form::open(['route' => 'check.post', 'method' => 'POST', 'class' => 'm-t-md']) }}
                        {{ Form::hidden('wfId', $workflow->id) }}
                        <div class="form-group row">
                            <div class="col-sm-3 text-center">
                                <dt>办理结果</dt>
                            </div>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="radio radio-success">
                                            {{ Form::radio('action', '1', true, ['id' => 'wf_apply']) }}
                                            {{ Form::label('wf_apply', '办理') }}
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="radio radio-danger">
                                            {{ Form::radio('action', '-1', false, ['id' => 'wf_back']) }}
                                            {{ Form::label('wf_back', '退回') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 text-center">
                                <dt>办理意见</dt>
                            </div>
                            <div class="col-sm-9">
                                {{ Form::textarea('content', '', ['id' => 'content', 'class' => 'form-control', 'rows' => '6', 'style' => 'resize:none;']) }}
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group row">
                            {{ Form::submit('办理', ['class' => 'btn btn-lg btn-block btn-primary offset-3 col-6']) }}
                        </div>
                        {{ Form::close() }}
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5 m-b-n-sm">
            <div class="ibox">
                <div class="ibox-title">
                    <h3>流程审批流程 <span class="label label-info float-right">{{ count($logs) }}</span></h3>
                </div>
                <div class="ibox-content pre-scrollable" style="overflow: auto; min-height: 550px;">
                    <div id="vertical-timeline" class="vertical-container light-timeline no-margins">
                        @foreach($logs as $v)
                            <div class="vertical-timeline-block">
                                <div class="vertical-timeline-icon blue-bg">
                                    <i class="fa fa-file-text"></i>
                                </div>
                                <div class="vertical-timeline-content">
                                    <div class="row">
                                        <span class="col-5 text-center"><strong>{{ $v->action }}</strong></span>
                                        <span class="col-4 text-center">{{ $v->userName }}</span>
                                    </div>
                                    <p>{{ $v->content }}</p>
                                    <span class="vertical-date"><small>{{ $v->updated_at }}</small></span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
