@extends('layouts.app')

@section('css')
<link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
<!-- Data picker -->
<link href="{{ asset('css/plugins/datepicker/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
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
                <div class="ibox-content" style="min-height: 600px">
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
                                <div class="form-group" id="selectMonth">
                                    <label>选择月份</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" class="form-control" name="period" value="{{ \Carbon\Carbon::today()->year }}-{{ \Carbon\Carbon::today()->month }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="roleType" >上传数据分类 *</label>
                                    <select name="roleType" id="roleType" class="form-control" onchange="getLevel2(this)">
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
                                <p>4. 请不要随意修改模板列的排列顺序。</p>
                                <p>5. 系统上传支持 xls\xlsx 文件。</p>
                            </div>
                        </div>
                    </fieldset>

                    <h1>数据校验</h1>
                    <fieldset>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="checkbox checkbox-success">
                                    <input id="isChecked" name="isChecked" type="checkbox" class="required" disabled>
                                    <label for="isChecked">数据校验已通过，确认上传数据.</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 id="countNumber"></h4>
                            </div>
                        </div>
                        <hr>
                        <div style="overflow: auto; min-height: 550px;" class="pre-scrollable">
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th>姓名</th>
                                    <th>保险编号</th>
                                    <th>银行卡号</th>
                                    <th>部门</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="excelData"></tbody>
                            </table>
                        </div>
                    </fieldset>

                    <h1>上传完成</h1>
                    <fieldset>
                        <h2>请完善该流程的基本信息</h2>
                        <div style="margin-top: 60px">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label style="font-size: large">流程标题 *</label>
                                        <input id="title" name="title" type="text" class="form-control"
                                               placeholder="{{ \Carbon\Carbon::now()->toDateString() }}{{ Auth::user()->profile->department->name }}{{ Auth::user()->profile->userName }}发起关于">
                                        <input type="hidden" name="importData">
                                        <input type="hidden" name="targetTable">

                                    </div>
                                    <div class="form-group">
                                        <div class="checkbox checkbox-primary">
                                            <input id="statusCode" name="statusCode" type="checkbox" >
                                            <label for="statusCode" style="font-size: large">是否立即提交业务？</label>
                                        </div>
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
<!-- Date picker -->
<script src="{{ asset('js/plugins/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/datepicker/locales/bootstrap-datepicker.zh-CN.min.js') }}"></script>
<!-- SheetJs -->
<script src="{{ asset('js/plugins/Sheetjs/xlsx.core.min.js') }}"></script>

<script src="{{ asset('js/helper.js') }}"></script>

<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

    let filters = [];       //根据角色得到需要获取的列名
    let targetTable = '';   //角色对应表名
    let excel = [];
    let wb;                 //读取excel数据

    $("#form").steps({
        bodyTag: "fieldset",
        onStepChanging: function (event, currentIndex, newIndex)
        {
            if (currentIndex > newIndex) {
                return true;
            }

            // 数据校验正确并勾选checkbox
            var check = $("#isChecked").is(":checked");
            if (newIndex === 3 && check === false) {
                return false;
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
                targetTable = '';
                let roleType = $('#roleType').val();
                $.get({
                    url: '/getColumns/' + roleType,
                    success: function (data) {
                        console.log('分类信息获取成功');
                        $('input[name="targetTable"]').val(data.target_table);
                        for (let x of data.permissions) {
                            x = R.pick(['description'], x);
                            filters = R.append(x.description, filters);
                        }
                        var level2 = $('#level2Name').find('option:selected').text();
                        if (level2 !== '') {
                            filters = R.append(level2, filters);
                        }
                        // console.log(filters);  显示需要抽取的字段
                    }
                });
            }
            if (currentIndex === 2 && priorIndex === 1)
            {
                // loading start
                $('#wizardForm').children('.ibox-content').toggleClass('sk-loading');
                document.getElementById('countNumber').innerHTML = '记录数: ' + excel.length;
                // 从数据库获取需要验证的数据，与excel读取的数据做验证
                $.get('/getProfiles', function (data) {
                    // console.log(data);
                    let res = excelDataCheck(excel, data);
                    document.getElementById('excelData').innerHTML = excelData(res);
                    if (checkResult(res) === true) {
                        $("#isChecked").removeAttr("disabled");
                    }

                    // loading stop
                    $('#wizardForm').children('.ibox-content').toggleClass('sk-loading');
                });
                // console.log(excel);
            }
            if (currentIndex === 3 && priorIndex === 2)
            {
                let roleType = $('#roleType').val();
                let title = $('#title').attr('placeholder');
                title = title + $('#roleType').find('option:selected').text() +'的业务流程';
                $('#title').val(title);

                let jsonstr = JSON.stringify(excel);
                $('input[name="importData"]').val(jsonstr);
                // console.log('tempdata: ', jsonstr);
            }
        },
        onFinishing: function (event, currentIndex)
        {
            var form = $(this);

            // Disable validation on fields that are disabled.
            // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
            form.validate().settings.ignore = ":disabled";

            // Start validation; Prevent form submission if false
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            var form = $(this);
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
        $('#selectMonth .input-group.date').datepicker({
            language: "zh-CN",
            minViewMode: 1,
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            todayHighlight: true,
            format: "yyyy-mm"
        });
    });

</script>
@stop
