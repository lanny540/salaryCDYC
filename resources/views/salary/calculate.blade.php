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
                <button class="btn btn-lg btn-block btn-primary salaryExport">当期导出明细</button>
            </div>
            <div class="col-sm-3 offset-1">
                <button class="btn btn-lg btn-block btn-success settleAccount">当前周期结束</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox" id="statistForm">
                <div class="ibox-content">
                    <div class="sk-spinner sk-spinner-cube-grid">
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
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

<script src="{{ asset('js/helper.js') }}"></script>

<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

    toastr.options = {
        progressBar: true,
        positionClass: 'toast-top-right',
        showMethod: 'slideDown',
        timeOut: 3000,
    };

    $(document).ready(function() {
        // 计算
        $('.salarysubmit').click(function () {
            toastr.info('计算中！');
            $('#statistForm').children('.ibox-content').toggleClass('sk-loading');
            $.get('/calSalary', function (data) {
                if (data.length === 0) {
                    toastr.error('没有权限计算!请联系管理员.');
                } else {
                    // 输出结果
                    let html = allColumnsHtml(data[0]);
                    $('#summaryTable').html(html);
                    toastr.success('当前汇总计算完成！');
                }
                $('#statistForm').children('.ibox-content').toggleClass('sk-loading');
            });
        });

        // 导出数据
        $('.salaryExport').click(function () {
            $('#statistForm').children('.ibox-content').toggleClass('sk-loading');
            toastr.options = {
                progressBar: true,
                positionClass: 'toast-top-right',
                showMethod: 'slideDown',
                timeOut: 30000,
            };
            toastr.info('正在导出！请耐心等待.');
            let params = {
                _token: '{{ csrf_token() }}',
            };
            Post('salaryExport', params);
            setTimeout(function () {
                $('#statistForm').children('.ibox-content').toggleClass('sk-loading');
            }, 30000);
        });

        // 结束周期
        $('.settleAccount').click(function () {
            let table = $('#staticsSalary').DataTable();

            if (! table.data().any()) {
                swal('错误!', '没有汇总数据.请点击左侧按钮计算当期数据.', 'error');
            } else {
                swal({
                    title: '是否结算当前会计周期？',
                    text: '确定结算会关闭当前周期，并自动开启新的会计周期。',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: "确定结算!",
                    closeOnConfirm: false,
                }, function () {
                    $.ajax({
                        type: 'POST',
                        url: '/settleAccount',
                        data: {
                            salary: staticsSalary,
                        },
                        success: function(data) {
                            swal({
                                title: data.title,
                                text: data.text,
                                type: data.type,
                            });
                        }
                    });
                });
            }
        });
    });

</script>
@endsection
