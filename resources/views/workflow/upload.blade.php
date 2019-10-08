@extends('layouts.app')

@section('css')
<!-- Steps -->
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

                    <h2>流程向导</h2>
                    {{ Form::open(['route' => 'wizard.submit', 'method' => 'post', 'id' => 'form', 'class' => 'wizard', 'files' => true]) }}
                    <h1>选择分类</h1>
                    <fieldset>
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <label for="roleType" >上传数据分类 *</label>
                                    <select name="roleType" id="roleType" class="form-control">
                                        <option value="0">薪酬汇总</option>
                                        @foreach($roles as $k => $r)
                                            <option value="{{ $k }}">{{ $r }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <a href="#" class="col-form-label">下载数据模板</a>
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
                        <div style="margin-top: 30px">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-md-2" style="font-size: large">上传时间: </label>
                                        <label class="col-md-10" style="font-size: large">{{ Carbon\Carbon::now() }}</label>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2" style="font-size: large">发放日期: </label>
                                        <label class="col-md-10" style="font-size: large" id="published_date"></label>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2" style="font-size: large">记录条数: </label>
                                        <label class="col-md-10" style="font-size: large" id="countSalary"></label>
                                    </div>
                                    <div class="form-group">
                                        <label style="font-size: large">验证信息：</label>
                                    </div>
                                    <div class="form-group" style="overflow:scroll;margin-top: 20px;">
                                        <table id="sumInfo" class="table table-bordered table-striped text-center">
                                        </table>
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

            let form = $(this);

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
                        console.log('分类信息获取成功');
                        for (let x of data.permissions) {
                            x = R.pick(['description'], x);
                            filters = R.append(x.description, filters);
                        }
                        // console.log(filters);  //显示需要抽取的字段
                    }
                });
            }
            if (currentIndex === 2 && priorIndex === 1)
            {
                // 表格初始化
                let sumSalary = countSalary(excel, filters);
                let html = sumHtml(sumSalary.sumColumn);
                $('#sumInfo').append(html);

                $('label[id="published_date"]').text(excel[0]['发放日期']);
                $('label[id="countSalary"]').text(sumSalary.count);
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
            // 模拟提交
            let published = document.createElement('input');
            published.type = 'hidden';
            published.name = 'published_at';
            published.value = excel[0]['发放日期'];
            form.append(published);

            let jsonstr = JSON.stringify(excel);
            let importData = document.createElement('input');
            importData.type = 'hidden';
            importData.name = 'importData';
            importData.value = jsonstr;
            form.append(importData);

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
