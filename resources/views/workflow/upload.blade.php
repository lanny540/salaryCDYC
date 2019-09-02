@extends('layouts.app')

@section('css')
<link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
@stop

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>上传数据</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    流程办理
                </li>
                <li class="breadcrumb-item active">
                    <strong>上传数据</strong>
                </li>
            </ol>
        </div>
    </div>
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox" id="wizardForm">
                <div class="ibox-content">
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>

                    <h2>流程向导</h2>
                    {{ Form::open(['route' => 'wizard.submit', 'method' => 'post', 'id' => 'form', 'class' => 'wizard-big', 'files' => true]) }}
                    <h1>选择分类</h1>
                    <fieldset>
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <label for="roleType" >上传数据分类 *</label>
                                    <select name="roleType" id="roleType" class="form-control" onchange="getLevel2(this)">
                                        <option value="0">薪酬汇总</option>
                                        @foreach($roles as $k => $r)
                                            <option value="{{ $k }}">{{ $r }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <a href="#" class="col-form-label">下载数据模板</a>
                                </div>
                                <div class="form-group">
                                    <div id="level2html"></div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <h1>Excel上传</h1>
                    <fieldset>
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <label>选择文件 *</label>
                                    <div class="custom-file">
                                        <input type="file" name="excel" class="custom-file-input required form-control onlyExcel" onchange="importf(this)">
                                        <label for="excel" class="custom-file-label">Choose file...</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center">
                                <h4>上传注意事项：</h4>
                                <p>1. 请按照模板格式上传数据。</p>
                                <p>2. 请不要在姓名中间加空格。</p>
                                <p>3. 请仔细检查金额。</p>
                                <p>4. 系统上传支持 xls\xlsx 文件。</p>
                            </div>
                        </div>
                    </fieldset>

                    <h1>上传完成</h1>
                    <fieldset>
                        <h2>请确认本次上传信息</h2>
                        <div style="margin-top: 60px">
                            <div class="row">
                                <input type="hidden" name="importData">
                                <input type="hidden" name="published_at">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label style="font-size: large">上传时间：</label>
                                    </div>
                                    <div class="form-group">
                                        <label style="font-size: large">所属会计期：</label>
                                    </div>
                                    <div class="form-group">
                                        <label style="font-size: large">上传记录数：</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-center">
                                        <div style="margin-top: 20px">
                                            <i class="fa fa-sign-in" style="font-size: 180px;color: #e5e5e5 "></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<!-- ramda -->
<script src="{{ asset('js/plugins/ramda/ramda.min.js') }}"></script>
<!-- Steps -->
<script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>
<!-- Jquery Validate -->
<script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/plugins/validate/additional-methods.js') }}"></script>
<script src="{{ asset('js/plugins/validate/localization/messages_zh.min.js') }}"></script>
<!-- SheetJs -->
<script src="{{ asset('js/plugins/Sheetjs/xlsx.core.min.js') }}"></script>

<script src="{{ asset('js/helper.js') }}"></script>

<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

    let filters = [];       //根据角色得到需要获取的列名
    let wb;                 //excel数据
    let excel = [];         //处理后的数据


    $("#form").steps({
        bodyTag: "fieldset",
        onStepChanging: function (event, currentIndex, newIndex)
        {
            if (currentIndex > newIndex) {
                return true;
            }

            var form = $(this);

            // Clean up if user went backward before
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
            if (currentIndex === 1 && priorIndex === 0)
            {
                filters = [];
                let roleType = $('#roleType').val();
                $.get({
                    url: '/getColumns/' + roleType,
                    success: function (data) {
                        // console.log(data);
                        console.log('分类信息获取成功');
                        for (let x of data.permissions) {
                            x = R.pick(['description'], x);
                            filters = R.append(x.description, filters);
                        }
                        let level2 = $('#level2Name').find('option:selected').text();
                        if (level2 !== '') {
                            filters = R.append(level2, filters);
                        }
                        // console.log(filters);  //显示需要抽取的字段
                    }
                });
            }
            if (currentIndex === 2 && priorIndex === 1)
            {
                console.log(excel);
                let jsonstr = JSON.stringify(excel);
                $('input[name="importData"]').val(jsonstr);
                $('input[name="published_at"]').val(excel[0]['发放日期']);
                // console.log('tempdata: ', jsonstr);
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
        rules: {
            excel: {
                onlyExcel: getFileExtension($('input[name="excel"]').val())
            }
        }
    });

    $(document).ready(function(){
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });

</script>
@stop
