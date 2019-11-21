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
@endsection

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
                                    <span class="h3 font-bold m-t block dash-text2" id="salary_total"></span>
                                </li>
                                <li>
                                    <h2 class="text-muted m-b block dash-text1">年缴个税</h2>
                                    <span class="h3 font-bold m-t block dash-text2" id="salary_tax"></span>
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
@endsection

@section('js')
<!-- Toastr -->
<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
<!-- ChartJS-->
<script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>

<script>
    let datas = <?php echo $salary; ?>;
    let chartTitle = getSalaryTitle(datas.salary);
    let chartData = getSalary(datas.salary);
    let barData = {
        labels: chartTitle,
        datasets: [
            {
                label: "月度收入",
                backgroundColor: 'rgba(32,75,255,0.5)',
                borderColor: "rgba(26,179,148,0.7)",
                pointBackgroundColor: "rgba(26,179,148,1)",
                pointBorderColor: "#fff",
                data: chartData,
            }
        ]
    };

    let barOptions = {
        responsive: true
    };

    let ctx2 = document.getElementById("dashboard-chart").getContext("2d");
    new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});

    $(document).ready(function() {
        setTimeout(function () {
            toastr.options = {
                progressBar: true,
                positionClass: 'toast-top-center',
                showMethod: 'slideDown',
                timeOut: 3000
            };
            toastr.success('{{ Auth::user()->profile->userName }} 欢迎进入{{ env('APP_NAME') }}');
        }, 1300);

        $("#salary_total").html('￥' + datas.total);
        $("#salary_tax").html('￥' + datas.tax);
    });

    // 输出图表纵坐标
    function getSalary(object) {
        let values = [];
        for (let property in object) {
            values.push(object[property].salary_total);
        }
        return values;
    }
    // 输出图表横坐标
    function getSalaryTitle(object) {
        let values = [];
        for (let property in object) {
            values.push(object[property].published_at);
        }
        return values;
    }
</script>
@endsection
