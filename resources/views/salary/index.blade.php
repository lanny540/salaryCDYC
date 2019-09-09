@extends('layouts.app')

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>个人薪酬</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>个人薪酬信息</strong>
                </li>
            </ol>
        </div>
    </div>
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row p-w-md m-t-sm">
        <div class="col-md-5">
            <h2 style="margin-top: 0">{{ Auth::user()->profile->userName }}</h2>
            <h4>{{ Auth::user()->profile->department->name }}</h4>
            <a href="{{ route('user.edit', auth::id()) }}" class="btn btn-primary btn-block">查看或修改详细个人信息</a>
        </div>
        <div class="col-md-6">
            <table class="table m-b-xs">
                <tbody>
                <tr>
                    <td>
                        <strong>工号</strong>
                    </td>
                    <td>
                        <strong>{{ Auth::user()->name }}</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>身份证号</strong>
                    </td>
                    <td>
                        <strong>{{ Auth::user()->profile->uid }}</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>保险编号</strong>
                    </td>
                    <td>
                        <strong>{{ Auth::user()->profile->policyNumber }}</strong>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <hr/>
    <div class="p-w-md m-t-sm">
        <div class="row">
            <div class="col-lg-12">
                <div>
                    <canvas id="salary-chart" height="120"></canvas>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>发放日期</th>
                        <th>工资</th>
                        <th>奖金合计</th>
                        <th>工资薪金</th>
                        <th style='width: 5%'></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cursalary as $s)
                        <tr>
                            <td>{{ $s->published_at }}</td>
                            <td>{{ $s->wage_total }}</td>
                            <td>{{ $s->bonus_total }}</td>
                            <td>{{ $s->salary_total }}</td>
                            <td class="client-status"><a href="{{ route('salary.show', $s->period_id) }}"> <span class="label label-primary">查看明细</span></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<!-- ChartJS-->
<script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>
{{--<script src="{{ asset('js/plugins/chartJs/Chart.demo.js') }}"></script>--}}

<script>
    $(document).ready(function(){
        let datas = <?php echo $chartdata; ?>;
        let year = datas['cyear'];
        let perv;
        if (datas[year - 1] === undefined) {
            perv = [];
        } else {
            perv = datas[year - 1];
        }

        let Options = {
            responsive: true
        };
        let barData = {
            labels: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
            datasets: [
                {
                    label: datas['pyear'] + '月度收入',
                    data: perv,
                    backgroundColor: 'rgba(255, 163, 58, 0.5)',
                    pointBorderColor: "#fff",
                },
                {
                    label: datas['cyear'] + '月度收入',
                    data: datas[year],
                    backgroundColor: 'rgba(26,179,148,0.5)',
                    borderColor: "rgba(26,179,148,0.7)",
                    pointBackgroundColor: "rgba(26,179,148,1)",
                    pointBorderColor: "#fff",
                },
            ]
        };

        let salaryChart = document.getElementById("salary-chart").getContext("2d");
        new Chart(salaryChart, {type: 'bar', data: barData, options:Options});
    });
</script>
@stop
