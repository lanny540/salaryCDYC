@extends('layouts.app')

@section('title', '系统BUG报告')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox-content m-b-sm border-bottom">
            <div class="text-center p-lg">
                <h2>如果您在使用该系统时出现了任何故障或错误，请在下方表单中详细描述此问题。</h2>
                <span>最好留下您的联系方式，以方便系统开发人员与您联系！ （业务问题请联系计划财务部）</span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h4>BUG报告</h4>
                    </div>
                    <div class="ibox-content">
                        {{ Form::open(['route' => 'report.post', 'files' => true, 'method' => 'POST']) }}
                        <div class="form-group row">
                            {{ Form::label('type', '分类', ['class' => 'col-sm-2 col-form-label text-center']) }}
                            {{ Form::select('type', ['1' => '错误报告', '2' => '建议', '3' => '其他'], '1', ['class' => 'col-sm-3']) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('content', '内容(*)', ['class' => 'col-sm-2 col-form-label text-center']) }}
                            {{ Form::textarea('content', '', ['class' => 'col-sm-6', 'placeholder' => '详细描述内容']) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('contact', '联系', ['class' => 'col-sm-2 col-form-label text-center']) }}
                            {{ Form::text('contact', '', ['class' => 'col-sm-6', 'placeholder' => '电话 或者 姓名']) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('image','截图', ['class' => 'col-sm-2 col-form-label text-center']) }}
                            {{ Form::file('image') }}
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-sm-4 offset-4">
                                {{ Form::submit('确定', ['class' => 'btn btn-info btn-lg btn-block']) }}
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
