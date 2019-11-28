@extends('layouts.app')

@section('css')
<!-- Toastr style -->
<link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
<!-- Select2 -->
<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>薪酬查询</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">首页</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>薪酬查询</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="ibox-content m-b-sm border-bottom">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-form-label" for="columns">查询字段</label>
                    <select name="columns[]" id="columns" class="select2_columns form-control" multiple="multiple">
                        @foreach($dataTypes as $d)
                            <option value="{{ $d->config_value }}">{{ $d->config_key }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-3 offset-1">
                <div class="form-group">
                    <label class="col-form-label" for="published_at">发放日期</label>
                    <select name="published_at" id="published_at" class="select2_published form-control" multiple="multiple">
                        @foreach($periods as $p)
                            <option value="{{ $p->id }}">{{ $p->published_at }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-sm-6">
                <button class="btn btn-success btn-block search-submit" type="button">
                    <i class="fa fa-search"></i> 查询
                </button>
            </div>
            <div class="col-sm-5 offset-1">
                <label class="label-info form-text text-center" style="font-size: 14px;">
                    <i class="fa fa-question-circle"></i> 如果您还有想查询的字段，请联系管理员添加!
                </label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content" id="searchTable">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- Toastr -->
<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

<script src="{{ asset('js/helper.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $(".select2_columns").select2({
        maximumSelectionLength: 4,
        placeholder: "请选择需要查询的字段...",
        allowClear: true,
    });
    $(".select2_published").select2({
        maximumSelectionLength: 12,
        placeholder: "请选择发放日期...",
        allowClear: true,
    });

    toastr.options = {
        progressBar: true,
        positionClass: 'toast-top-center',
        showMethod: 'slideDown',
        timeOut: 2000
    };

    $(document).ready(function () {
        $(".search-submit").on('click', function() {
            let types = $("#columns").val();
            let periods = $("#published_at").val();
            if (types.length === 0) {
                toastr.error('没有选择查询字段!');
            }
            if (periods.length === 0) {
                toastr.error('没有选择查询时间!');
            }
            if (types.length > 0 && periods.length > 0) {
                $.post({
                    url: 'search',
                    data: {
                        types: types,
                        periods: periods,
                    },
                    dataType: "JSON",
                    success: function (data) {
                        // console.log(data);
                        // 将结果转化成html
                        let searchTable = $('#searchTable');
                        searchTable.html('');
                        let html = tranformDataToHtml(data);
                        searchTable.html(html);
                    }
                });
            }
        });
    });

    function tranformDataToHtml(data)
    {
        let html = '';
        for (let i = 0; i < data.length; ++i) {
            let name = getObjectKeys(data[i][0]);
            let pubs = [];
            for (let j = 0; j < data[i].length; ++j) {
                let temp = data[i][j];
                pubs.push(temp.published_at);
            }
            console.log(data[i]);
            let theadString = tranformThead(pubs);
            let tbodyString = tranformTbody(data[i], name[0]);
            html += `
                <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>类别</th>
                        ${theadString}
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>${name[0]}</td>
                        ${tbodyString}
                    </tr>
                </tbody>
                </table>
                <hr/>
            `;
        }
        return html;
    }

    function tranformThead(data)
    {
        let thead = '';
        for (let i = 0; i < data.length; ++i) {
            thead += `<th>${data[i]}</th>`;
        }
        return thead;
    }

    function tranformTbody(data, name)
    {
        let tbody = '';
        for (let i = 0; i< data.length; ++i) {
            let temp = data[i];
            tbody += `<td>${temp[name]}</td>`;
        }
        return tbody;
    }
</script>
@endsection
