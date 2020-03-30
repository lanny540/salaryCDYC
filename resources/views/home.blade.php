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
                                    <h2 class="text-muted m-b block dash-text1">
                                        {{ $year }}年收入
                                        <span class="fa fa-exclamation-circle" data-toggle="popover" data-placement="top" data-content="年度工资薪金"></span>
                                    </h2>
                                    <span class="h3 font-bold m-t block dash-text2" id="salary_total"></span>
                                </li>
                                <li>
                                    <h2 class="text-muted m-b block dash-text1">
                                        年缴个税
                                        <span class="fa fa-exclamation-circle" data-toggle="popover" data-placement="top" data-content="年度累计申报已扣税"></span>
                                    </h2>
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
        <div class="col-lg-5">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>自助服务</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content text-center">
                    <h3><a href="{{ route('salary.index') }}">查看薪酬</a></h3>
                    <h3><a href="{{ route('person.print') }}">工资打印</a></h3>
                    <h3><a href="{{ route('mymsg.index') }}">我的消息</a></h3>
                </div>
            </div>
            @hasanyrole('administrator|financial_manager')
            <div class="ibox collapsed">
                <div class="ibox-title">
                    <h5>系统功能</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content text-center">
                    <h3><a href="{{ route('upload.index') }}">上传分表数据</a></h3>
                    <h3><a href="{{ route('special.index') }}">专项数据导出</a></h3>
                    <h3><a href="{{ route('vdata.index') }}">生成业务凭证</a></h3>
                </div>
            </div>
            @endhasanyrole
            <div class="ibox">
                <div class="ibox-title">
                    <h5>常见问题</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content text-center">
                    <h3><a href="{{ route('tax') }}">个税计算器</a></h3>
                    <h3><a href="{{ route('report') }}">系统BUG报告</a></h3>
                    <h3><a href="{{ route('contact') }}">系统意见建议</a></h3>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>日志</h5>
                    <span class="label label-primary">只显示最近的三次操作</span>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="ibox-content inspinia-timeline">
                    @foreach($logs as $log)
                    <div class="timeline-item">
                        <div class="row">
                            @if($log->upload_type !== 0)
                                <div class="col-3 date">
                                    <i class="fa fa-file-text"></i>
                                    {{ $log->updated_at }}
                                    <br/>
                                    <small class="text-navy">{{ $log->updated_at->diffForHumans() }}</small>
                                </div>
                                <div class="col-8 content">
                                    <p class="m-b-xs"><strong>上传</strong></p>
                                    <p>
                                        {{ Auth::user()->profile->userName }} 上传了 <b>{{ $log->description }}</b> 数据。
                                        <a href="{{ $log->upload_file }}" target="_blank">下载查看该数据。</a>
                                    </p>
                                </div>
                            @else
                                <div class="col-3 date">
                                    <i class="fa fa-briefcase"></i>
                                    {{ $log->updated_at }}
                                    <br/>
                                    <small class="text-navy">{{ $log->updated_at->diffForHumans() }}</small>
                                </div>
                                <div class="col-8 content">
                                    <p class="m-b-xs"><strong>修改</strong></p>
                                    <p>
                                        {{ $log->user_id->profile->userName }} 修改了 <b>{{ $log->upload_file }}</b> 数据。
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
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
    let chartTitle, chartData;
    if (datas.salary.length > 0) {
        chartTitle = getSalaryTitle(datas.salary);
        chartData = getSalary(datas.salary);
    } else {
        chartTitle = ['一月'];
        chartData = [0];
    }

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
            toastr.success('{{ Auth::id() }} 欢迎进入{{ env('APP_NAME') }}');
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
