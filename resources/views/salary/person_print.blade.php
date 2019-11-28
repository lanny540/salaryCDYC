@extends('layouts.app')

@section('css')
<!-- Select2 -->
<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-3">
        <h2>个人薪酬打印</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">首页</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>个人薪酬打印</strong>
            </li>
        </ol>
    </div>

    <div class="col-lg-7">
        <div class="title-action form-group row">
            <div class="col-lg-3">
                <label class="col-form-label" for="published_at">发放日期</label>
            </div>
            <div class="col-lg-6">
                <select name="published_at" id="published_at" class="select2_published form-control" multiple="multiple">
                    @foreach($periods as $p)
                        <option value="{{ $p->id }}">{{ $p->published_at }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <button class="btn btn-white" id="searchBtn"><i class="fa fa-pencil"></i> 确定 </button>
            </div>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="title-action">
            <button class="btn btn-primary" id="printBtn"><i class="fa fa-print"></i> 打印工资条 </button>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl">

                @include('print._table')

                <div class="well m-t"><strong>说明：</strong>
                    收入清单属于个人隐私，请妥善保管！！ 如果数据有任何疑问，请通过系统相关功能查询或者点击 <a href="{{ route('contact') }}">联系我们</a>  页面 联系财务部。
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- Select2 -->
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

<script src="{{ asset('js/helper.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $(".select2_published").select2({
        maximumSelectionLength: 12,
        placeholder: "请选择发放日期...",
        allowClear: true,
    });

    $(document).ready(function () {
        $('#searchBtn').click(function () {
            document.getElementById("aaa").innerText = "adfasdf";
        });

        $('#printBtn').click(function () {
            window.open('/print');
        });
    });
</script>
@endsection
