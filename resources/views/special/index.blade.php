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
                <label class="col-md-2 col-form-label text-center" for="uploadType">选择导入类型：</label>
                <div class="col-md-3 text-left">
                    <select class="form-control" id="uploadType">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                </div>
                <label class="col-md-2 col-form-label text-center">选择文件: </label>
                <div class="col-md-3 form-group custom-file text-left">
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
            <h3>{{ Carbon\Carbon::now()->year.Carbon\Carbon::now()->month.'_税款计算_工资薪金一次导出.xls' }}</h3>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/helper.js') }}"></script>

<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

    $(document).ready(function () {
        $(document).on("click", "button", function () {
            $('#ibox').children('.ibox-content').toggleClass('sk-loading');

            let exportTypeString = $(this)[0].getAttribute('id');
            let exportType = getExportType(exportTypeString);

            let params = {
                exportType: exportType,
                _token: '{{ csrf_token() }}',
            };

            setTimeout(function () {
                Post('taxExport', params);
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
</script>
@endsection
