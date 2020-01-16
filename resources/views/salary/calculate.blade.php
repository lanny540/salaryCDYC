@extends('layouts.app')

@section('css')
<!-- Toastr style -->
<link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

<style>
    table tbody {
        display: block;
        height: 680px;
        overflow-y: scroll;
    }
    table tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }
</style>
@endsection

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>薪酬计算</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>薪酬计算</strong>
                </li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-content m-b-sm border-bottom">
        <div class="row">
            <div class="col-sm-3 offset-1">
                <button class="btn btn-lg btn-block btn-success salarysubmit">当期汇总计算</button>
            </div>
            <div class="col-sm-3 offset-1">
                <button class="btn btn-lg btn-block btn-success settleAccount">当前周期结束</button>
            </div>
            <div class="col-sm-3 offset-1">
                <button class="btn btn-lg btn-block btn-primary salaryExport">当期导出明细</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox" id="statistForm">
                <div class="ibox-content">
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                    <table class="table table-bordered invoice-table row mx-0">
                        <tbody class="w-100" id="summaryTable">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- Toastr script -->
<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
<!-- ramda -->
<script src="{{ asset('js/plugins/ramda/ramda.min.js') }}"></script>
<!-- sweetalert -->
<script src="{{ asset('js/plugins/sweetalert2/sweetalert.min.js') }}"></script>

<script src="{{ asset('js/helper.js') }}"></script>

<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

    toastr.options = {
        progressBar: true,
        positionClass: 'toast-top-right',
        showMethod: 'slideDown',
        timeOut: 30000,
    };

    $(document).ready(function() {
        // 计算
        $('.salarysubmit').on('click', (function () {
            toastr.info('计算中！');
            $('#statistForm').children('.ibox-content').toggleClass('sk-loading');
            $.get('/calSalary', function (data) {
                console.log(data);
                if (data.length === 0) {
                    toastr.error('计算错误!请联系管理员.');
                } else {
                    // 输出结果
                    let html = allColumnsHtml(data[0]);
                    $('#summaryTable').html(html);
                    toastr.success('汇总计算完成！');
                }
                $('#statistForm').children('.ibox-content').toggleClass('sk-loading');
            });
        }));

        // 导出数据
        $('.salaryExport').on('click', (function () {
            $('#statistForm').children('.ibox-content').toggleClass('sk-loading');
            toastr.info('正在导出！请耐心等待.');
            let params = {
                _token: '{{ csrf_token() }}',
            };
            Post('salaryExport', params);
            setTimeout(function () {
                $('#statistForm').children('.ibox-content').toggleClass('sk-loading');
            }, 30000);
        }));

        // 结束周期
        $('.settleAccount').on('click', (function () {
            let regex = /^(\d{4}.)?\d{2}$/;
            swal("请输入当期的发放时间:", {
                content: "input",
            }).then((value) => {
                if ('' === value) {
                    toastr.error('请输入发放时间！');
                } else {
                    let res = regex.test(value);
                    console.log(res);
                    if (res) {
                        swal(`You typed: ${value}`);
                        $.post({
                            url: '/settleAccount',
                            data: {
                                published_at: value,
                            },
                            success: function(data) {
                                swal("处理成功!", data.message, "success");
                                // console.log(data);
                            }
                        });
                    } else {
                        toastr.info('格式错误!请修改格式为 XXXX.XX');
                    }
                }
            });
        }));
    });

</script>
@endsection
