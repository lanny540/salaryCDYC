@extends('layouts.app')

@section('css')

@endsection

@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>专项数据导入/导出</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">首页</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>专项导入/导出</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox" id="ibox">
        <div class="ibox-content">
            <div class="sk-spinner sk-spinner-double-bounce">
                <div class="sk-double-bounce1"></div>
                <div class="sk-double-bounce2"></div>
            </div>

            <h3>专项数据第一次导出</h3>
            <div class="form-group row">
                <div class="col-md-4 text-center">
                    <button class="btn btn-lg btn-success" id="salaryExport1">工资薪金导出</button>
                </div>
                <div class="col-md-4 text-center">
                    <button class="btn btn-lg btn-info" id="articleExport1">稿酬导出 </button>
                </div>
                <div class="col-md-4 text-center">
                    <button class="btn btn-lg btn-success" id="franchiseExport1">特许权导出 </button>
                </div>
            </div>
            <hr/>
            <h3>税务系统数据导入</h3>
            <div class="form-group row">
                <label class="col-md-1 col-form-label text-center" for="uploadType">导入类型</label>
                <div class="col-md-4 text-left">
                    <select class="form-control" id="uploadType" onchange="selectUploadType();">
                        <option value="0">请选择...</option>
                        <option value="48">税务计算_工资薪金导入</option>
                        <option value="49">税务计算_稿酬导入</option>
                        <option value="50">税务计算_特许权导入</option>
                    </select>
                </div>
                <label class="col-md-1 col-form-label text-center">上传文件</label>
                <div class="col-md-4 form-group custom-file text-left">
                        <input type="file" id="excel" class="custom-file-input form-control onlyExcel" onchange="importf(this)">
                        <label for="excel" class="custom-file-label">Choose file...</label>
                </div>
                <div class="col-md-2 text-center">
                    <button class="btn btn-success">导入</button>
                </div>
            </div>
            <hr/>
            <h3>专项数据第二次导出</h3>
            <div class="form-group row">
                <div class="col-md-4 text-center">
                    <button class="btn btn-lg btn-success" id="salaryExport2">工资薪金导出</button>
                </div>
                <div class="col-md-4 text-center">
                    <button class="btn btn-lg btn-info" id="articleExport2">稿酬导出 </button>
                </div>
                <div class="col-md-4 text-center">
                    <button class="btn btn-lg btn-success" id="franchiseExport2">特许权导出 </button>
                </div>
            </div>
            <hr/>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- ramda -->
<script src="{{ asset('js/plugins/ramda/ramda.min.js') }}"></script>
<!-- SheetJs -->
<script src="{{ asset('js/plugins/Sheetjs/xlsx.core.min.js') }}"></script>

<script src="{{ asset('js/helper.js') }}"></script>

<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

    let filters = [];
    let wb;                 //excel数据
    let excel = [];         //处理后的数据

    $(document).ready(function () {
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        $(document).on("click", "button", function () {
            $('#ibox').children('.ibox-content').toggleClass('sk-loading');

            let exportTypeString = $(this)[0].getAttribute('id');
            let exportType = getExportType(exportTypeString);

            if (exportType === 0) {
                // 导入处理

                //创建form表单
                let form = document.createElement("form");
                form.action = 'specialImport';
                //如需打开新窗口，form的target属性要设置为'_blank'
                form.target = "_self";
                form.method = "post";
                form.style.display = "none";

                let _token = document.createElement('input');
                _token.type = 'hidden';
                _token.name = '_token';
                _token.value = '{{ csrf_token() }}';
                form.append(_token);

                let uploadType = document.createElement('input');
                uploadType.type = 'hidden';
                uploadType.name = 'uploadType';
                uploadType.value = $("#uploadType option:selected").val();
                form.append(uploadType);

                let jsonstr = JSON.stringify(excel);
                let importData = document.createElement('input');
                importData.type = 'hidden';
                importData.name = 'importData';
                importData.value = jsonstr;
                form.append(importData);

                document.body.appendChild(form);
                form.submit();
            } else {
                // 导出处理
                let params = {
                    exportType: exportType,
                    _token: '{{ csrf_token() }}',
                };

                Post('specialExport', params);
            }

            setTimeout(function () {
                $('#ibox').children('.ibox-content').toggleClass('sk-loading');
            }, 2000);
        });
    });

    // 返回导出类型
    function getExportType (exportString) {
        let exportType;
        switch (exportString) {
            case 'salaryExport1':
                exportType = 42;
                break;
            case 'salaryExport2':
                exportType = 43;
                break;
            case 'articleExport1':
                exportType = 44;
                break;
            case 'articleExport2':
                exportType = 45;
                break;
            case 'franchiseExport1':
                exportType = 46;
                break;
            case 'franchiseExport2':
                exportType = 47;
                break;
            default:
                exportType = 0;
        }
        return exportType;
    }

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
                    }
                    filters = R.append('工号', filters);
                }
            });
        }

    }
</script>
@endsection
