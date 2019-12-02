@extends('layouts.app')

@section('css')
<!-- Steps -->
<link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
@endsection

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
@endsection

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
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="uploadType"><strong>上传数据分类: *</strong></label>
                                    <select name="uploadType" id="uploadType" class="form-control" style="width: 80%;" onchange="selectUploadType();">
{{--                                        <option value="0">薪酬汇总</option>--}}
                                        <option value="">请选择一个分表</option>
                                        @foreach($roles as $k => $r)
                                            <option value="{{ $k }}">{{ $r }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label><strong>数据模板：</strong></label>
                                    <p><a href="#" class="col-form-label">点击下载</a></p>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <p style="color: red; font-size: 16px;"><strong>请确认下方字段是否包含在Excel文件字段中。系统将只会抽取下方列表字段的数据值！</strong></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><strong>Excel抽取字段: </strong></label>
                                    <div id="importColumns" style="font-size: 18px;"></div>
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
@endsection

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
                // console.log(filters);  //显示需要抽取的字段
            }
            if (currentIndex === 2 && priorIndex === 1)
            {
                let uploadType = $("#uploadType option:selected").val();
                // 计算部分合计字段
                let calData = calculationData(excel, filters, uploadType);
                // 表格初始化
                let sumSalary = countSalary(calData.excel, calData.filters);
                // console.log(calData);
                let html = sumHtml(sumSalary.sumColumn);
                let table = $('#sumInfo');
                table.html('');
                table.append(html);

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

    // 选择上传分类，显示读取的字段
    function selectUploadType() {
        let options=$("#uploadType option:selected");

        if(options.val() > 0) {
            filters = [];
            $.get({
                url: '/getColumns/' + options.val(),
                success: function (data) {
                    let arr = Object.keys(data);
                    if (arr.length > 0) {
                        filters = getObjectValues(data);
                        document.getElementById("importColumns").innerHTML = filters.join("——");
                    } else {
                        document.getElementById("importColumns").innerHTML = '字段列表获取失败！';
                    }
                    if (options.val() == 51 || options.val() == 52 || options.val() == 53) {
                        filters = R.append('工号', filters);
                    } else {
                        filters = R.append('保险编号', filters);
                    }
                    // console.log(filters);
                }
            });
        }
    }

</script>
@endsection
