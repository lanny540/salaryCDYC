@extends('layouts.app')

@section('css')
<!-- Steps -->
<link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">

<link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
@endsection

@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>凭证列表</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">首页</a>
            </li>
            <li class="breadcrumb-item">
                凭证相关
            </li>
            <li class="breadcrumb-item active">
                <strong>凭证列表</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox" id="wizardForm">
                <div class="ibox-content">
                    <h2>凭证数据向导</h2>
                    {{ Form::open(['route' => 'vdata.show', 'method' => 'post', 'id' => 'form', 'class' => 'wizard']) }}

                    <h1>选择凭证</h1>
                    <fieldset>
                        @foreach($types as $t)
                            <h3>
                                {{ $t->tname }}
                                <small><span class="badge badge-primary">{{ $t->vouchers->count() }}</span></small>
                                <small class="m-l-sm">{{ $t->tdescription }}</small>
                            </h3>
                            <div class="row">
                                @foreach($t->vouchers as $v)
                                    <div class="col-md-3">
                                        <div class="radio radio-danger">
                                            <input type="radio" name="vid" id="radio{{ $v->id }}" value="{{ $v->id }}" class="required">
                                            <label for="radio{{ $v->id }}">
                                                {{ $v->description }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr/>
                        @endforeach
                    </fieldset>

                    <h1>选择会计期</h1>
                    <fieldset>
                        <div class="row">
                            <label class="col-sm-2 col-form-label" for="periodId">发放日期 </label>
                            <div class="col-sm-4">
                                <select class="form-control" name="periodId" id="periodId" style="width: 300px;">
                                    @foreach($periods as $p)
                                        @if($p->published_at === '')
                                            <option value="{{ $p->id }}">当前周期</option>
                                        @else
                                            <option value="{{ $p->id }}">{{ $p->published_at }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    <h1>查询结果</h1>
                    <fieldset>
                        <div id="voucherText" class="text-center" style="margin-top: 100px"></div>
                    </fieldset>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- Steps -->
<script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>
<!-- Jquery Validate -->
<script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/plugins/validate/additional-methods.js') }}"></script>
<script src="{{ asset('js/plugins/validate/localization/messages_zh.min.js') }}"></script>

<script>
    $("#form").steps({
        bodyTag: "fieldset",
        onStepChanging: function (event, currentIndex, newIndex)
        {
            if (currentIndex > newIndex) {
                return true;
            }

            let form = $(this);

            if (currentIndex < newIndex) {
                // To remove error styles
                $(".body:eq(" + newIndex + ") label.error", form).remove();
                $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
            }

            form.validate().settings.ignore = ":disabled,:hidden";

            return form.valid();
        },
        onStepChanged: function (event, currentIndex, priorIndex)
        {
            if (currentIndex === 2 && priorIndex === 1)
            {
                let url = 'vdatahas?vid=' + $("input[name='vid']:checked").val() + '&periodId=' + $('#periodId').val();

                $.get({
                    url: url,
                    success: function (data) {
                        let msg = '<h2>'+data.msg+'</h2>';
                        msg += '<p>点击下方<strong>finish</strong>按钮'+data.status+'该凭证.</p>';
                        let voucherText = $('#voucherText');
                        voucherText.text("");
                        voucherText.append(msg);
                    }
                });
            }
        },
        onFinishing: function (event, currentIndex)
        {
            let form = $(this);
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            let form = $(this);

            form.submit();
        }
    }).validate({
        errorPlacement: function (error, element)
        {
            element.before(error);
        },
    });
</script>
@endsection
