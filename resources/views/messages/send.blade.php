@extends('layouts.app')

@section('css')
<link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
<!-- Select2 -->
<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>站内信</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">首页</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>消息发送</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" role="tablist">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1">固定消息群发</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-2">自定义消息群发</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            {{ Form::open(['route' => 'msg.send', 'method' => 'post', 'files' => true]) }}
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">发送对象(必选)</label>
                                <div class="col-sm-8">
                                    <label class="checkbox-inline i-checks" style="margin-right: 40px;"> <input type="radio" value='0' name="type_id" checked> 全站用户 </label>
                                    <label class="i-checks"> <input type="radio" value='1' name="type_id"> 部门用户 </label>
                                </div>
                            </div>
                            <div id="departments" class="form-group row" style="display: none">
                                <label class="col-sm-2 col-form-label text-right" for="depts">部门</label>
                                <div class="col-sm-8">
                                    <select class="form-control m-b select2_departments" id="depts" name="department[]" style="width: 100%;" multiple="multiple">
                                        @foreach($departments as $d)
                                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right" for="content">发送内容</label>
                                <div class="col-sm-8">
                                        <textarea name="content" id="content" placeholder="请输入发送内容。请注意发送字数！"
                                                  class="form-control" rows="3" style="resize:none"></textarea>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right" for="attachment">附件(可选)</label>
                                <div class="col-sm-4">
                                    <div class="custom-file">
                                        <input name="attachment" type="file" class="custom-file-input">
                                        <label for="attachment" class="custom-file-label">选择附件...</label>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <div class="col-sm-4 offset-4">
                                    {{ Form::submit('发送', ['class' => 'btn btn-lg btn-primary btn-block']) }}
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                    @hasanyrole('administrator|financial_manager|department_manager')
                    <div role="tabpanel" id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            {{ Form::open(['route' => 'customMsg.send', 'method' => 'post', 'id' => 'customMsgForm', 'files' => true]) }}
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right" for="excel">上传列表</label>
                                <div class="col-sm-4">
                                    <div class="custom-file">
                                        <input name="excel" type="file" class="custom-file-input" onchange="importf(this)">
                                        <label for="excel" class="custom-file-label">选择文件...</label>
                                    </div>
                                </div>
                                <div class="col-sm-2 offset-2">
                                    <a href="{{ asset('/storage/customMsg/messages.xls') }}">下载模板</a>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group row">
                                <div class="col-sm-4 offset-4">
                                    <button id="customSend" class="btn btn-lg btn-primary btn-block" type="button">发送</button>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                    @endhasanyrole
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- ramda -->
<script src="{{ asset('js/plugins/ramda/ramda.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<!-- SheetJs -->
<script src="{{ asset('js/plugins/Sheetjs/xlsx.core.min.js') }}"></script>

<script src="{{ asset('js/helper.js') }}"></script>

<script>
    let excel = [];
    let filters = ['保险编号', '发送内容'];

    $(".select2_departments").select2({
        language : 'zh-CN',
        minimumInputLength : 0,
        placeholder: "请选择部门...",
        allowClear: true,
    });

    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        $("input[name=type_id]").on('click', function(){
            let temp1 = document.getElementById("departments");

            if (0 != $(this).val()) {
                temp1.style.display='';
            } else {
                temp1.style.display="none";
            }
        });

        $('#customSend').on('click', function () {
            let form = $('#customMsgForm');

            let jsonstr = JSON.stringify(excel);
            let importData = document.createElement('input');
            importData.type = 'hidden';
            importData.name = 'importData';
            importData.value = jsonstr;
            form.append(importData);

            form.submit();
        });
    });
</script>
@endsection
