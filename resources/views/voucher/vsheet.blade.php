@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@stop

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>凭证基础表</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item">
                    凭证相关
                </li>
                <li class="breadcrumb-item active">
                    <strong>凭证基础表</strong>
                </li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label" for="period">发放日期 </label>
                            <div class="col-sm-6">
                                <select class="form-control select2_types" id="period" style="width: 300px;">
                                    <option></option>
                                    @foreach($periods as $p)
                                        <option value="{{ $p->id }}">{{ $p->published_at }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-block btn-primary" id="vsheetSubmit">生成</button>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <!-- Select2 -->
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- Sweet alert -->
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        $(".select2_types").select2({
            placeholder: "请选择发放日期...",
            allowClear: true
        });

        $(document).ready(function () {
            let sheets = <?php echo $sheets;?>;

            $('#vsheetSubmit').click(function () {
                let pid = $('#period').val();
                if (pid !== '') {
                    if (sheets[pid - 1] && sheets[pid - 1].id === parseInt(pid)) {
                        swal({
                            title: "你确定重新生成汇总表吗?",
                            text: "该会计期已存在汇总表!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "是的, 重新生成!",
                            cancelButtonText: "不, 立即查看!",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        }, function (isConfirm) {
                            if (isConfirm) {
                                calulateSheet(pid, 1);
                            } else {
                                calulateSheet(pid, 0);
                            }
                        });
                    } else {
                        calulateSheet(pid, 1);
                    }
                }
            });
        });

        function calulateSheet(pid, calculate) {
            let url = '/vsheet/' + pid + '?calculate=' + calculate;
            $.get(url, function (data) {
                if (parseInt(data.status) === 0) {
                    swal("已查询到数据", "查询到该会计期的凭证汇总表数据 :)", "info");
                } else {
                    swal("已计算!", "该会计期的凭证汇总表数据已计算.", "success");
                }
                console.log(data);
            });
        }
    </script>
@stop
