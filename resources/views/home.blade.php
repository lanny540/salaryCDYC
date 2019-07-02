@extends('layouts.app')

@section('css')
    <!-- Toastr style -->
    <link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <style>
        @media (max-height: 768px) {
            .dash-text1 {
                font-size: 18px;
            }

            .dash-text2 {
                font-size: 16px;
            }
        }
    </style>
@stop

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>收入图表</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-9">
                                <div>
                                    <canvas id="dashboard-chart" height="80"></canvas>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <ul class="stat-list text-center">
                                    <li>
                                        <h2 class="text-muted m-b block dash-text1">{{ \Carbon\Carbon::now()->year }}年收入</h2>
                                        <span class="h3 font-bold m-t block dash-text2">￥ 255,346</span>
                                    </li>
                                    <li>
                                        <h2 class="text-muted m-b block dash-text1">预缴个税</h2>
                                        <span class="h3 font-bold m-t block dash-text2">￥ 46,100</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="panel panel-primary text-center">
                    <div class="panel-heading">
                        <h3>自助服务</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled m-t-md">

                            <li>
                                <h2><a href="{{ route('salary.index') }}">查看薪酬信息</a></h2>
                            </li>
                            <li>
                                <h2><a href="{{ route('sheet.index') }}">工资条打印</a></h2>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-success text-center">
                    <div class="panel-heading">
                        <h3>系统功能</h3>
                    </div>
                    <ul class="list-unstyled m-t-md">
                        <li>
                            <h2><a href="{{ route('upload.index') }}">上传数据</a></h2>
                        </li>
                        <li>
                            <h2><a href="{{ route('check.index') }}">审核数据</a></h2>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-danger text-center">
                    <div class="panel-heading">
                        <h3>常见问题</h3>
                    </div>
                    <ul class="list-unstyled m-t-md">
                        <li>
                            <h2><a href="{{ route('tax') }}">个税计算器</a></h2>
                        </li>
                        <li>
                            <h2><a href="{{ route('report') }}">系统BUG报告</a></h2>
                        </li>
                        <li>
                            <h2><a href="{{ route('contact') }}">系统意见建议</a></h2>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <!-- Toastr -->
    <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
    <!-- ChartJS-->
    <script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>

    <script>
        var barData = {
            labels: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
            datasets: [
                {
                    label: "月度收入",
                    backgroundColor: 'rgba(32,75,255,0.5)',
                    borderColor: "rgba(26,179,148,0.7)",
                    pointBackgroundColor: "rgba(26,179,148,1)",
                    pointBorderColor: "#fff",
                    data: [7222, 7456, 7540, 8054, 8631, 7813, 7523, 7129, 7923, 8310, 9512, 0]
                }
            ]
        };

        var barOptions = {
            responsive: true
        };

        var ctx2 = document.getElementById("dashboard-chart").getContext("2d");
        new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});

        $(document).ready(function() {
            setTimeout(function () {
                toastr.options = {
                    progressBar: true,
                    positionClass: 'toast-top-center',
                    showMethod: 'slideDown',
                    timeOut: 3000
                };
                toastr.success('欢迎 {{ Auth::user()->profile->userName }} 进入 {{ env('APP_NAME') }}');
            }, 1300);
        });
    </script>
@stop
