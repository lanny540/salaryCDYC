@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('breadcrumbs')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2>个人薪酬</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">首页</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>个人薪酬明细</strong>
                </li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox product-detail">
                    <div class="ibox-title">
                        <label class="font-bold m-b-xs" style="font-size: 22px;">
                            {{ $curPeriod->published_at }} 薪酬明细
                        </label>
                        <div class="ibox-tools">
                            <label>
                                <select name="periodId" class="form-control select2_periods" style="width: 200px;"
                                        onchange="window.location='/salary/'+this.value"
                                >
                                    @foreach($periods as $p)
                                        <option value="{{ $p->id }}" @if($p->id == $curPeriod->id) selected @endif>
                                            {{ $p->published_at }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-5">
                                <div>
                                    <a href="{{ route('sheet.index') }}" class="btn btn-primary float-right">打印工资条</a>
                                    <h1 class="product-main-price">￥ {{ $summary->salary_total }}</h1>
                                </div>
                                <hr>

                                <h3>应发工资: {{ $summary->wage_total }}</h3>
                                <div class="row">
                                    @foreach($detail['应发工资'][0] as $k => $v)
                                        @if($k !== '保险编号' && $k !== '应发工资')
                                            <div class="col-md-6">{{ $k }}: {{ $v }} </div>
                                        @endif
                                    @endforeach
                                </div>
                                <hr/>
                                <h3>补贴合计: {{ $summary->subsidy_total }}</h3>
                                <div class="row">
                                    @foreach($detail['补贴合计'][0] as $k => $v)
                                        @if($k !== '保险编号' && $k !== '补贴合计')
                                            <div class="col-md-6">{{ $k }}: {{ $v }} </div>
                                        @endif
                                    @endforeach
                                </div>
                                <hr/>
                                <h3>补发合计: {{ $summary->reissue_total }}</h3>
                                <div class="row">
                                    @foreach($detail['补发合计'][0] as $k => $v)
                                        @if($k !== '保险编号' && $k !== '补发合计')
                                            <div class="col-md-6">{{ $k }}: {{ $v }} </div>
                                        @endif
                                    @endforeach
                                </div>
                                <hr/>
                                <h3>奖金合计: {{ $summary->bonus_total }}</h3>
                                <div class="row">
                                    @foreach($detail['奖金合计'][0] as $k => $v)
                                        @if($k !== '保险编号' && $k !== '奖金合计')
                                            <div class="col-md-6">{{ $k }}: {{ $v }} </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-7">
                                <h3>双环形图</h3>
                                <div id="salaryDetail" style="height: 560px"></div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-sm-4 offset-5">
                                <button class="btn btn-info"><i class="fa fa-cart-plus"></i> 查看计算公式</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <!-- ramda -->
    <script src="{{ asset('js/plugins/ramda/ramda.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<!-- ECharts -->
<script src="{{ asset('js/plugins/echarts/echarts.min.js') }}"></script>

    <script>
        $(".select2_periods").select2();
        let chartdatas = <?php echo $chartdata; ?>;

        $(document).ready(function () {
            let dom = document.getElementById("salaryDetail");
            let myChart = echarts.init(dom);
            let app = {};
            let option = null;
            app.title = '工资薪金环形图';

            option = {
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b}: {c} ({d}%)"
                },
                legend: {
                    orient: 'horizontal',
                    x: 'left',
                    data: getTitles(chartdatas),
                },
                series: [
                    {
                        name: '工资薪金',
                        type: 'pie',
                        selectedMode: 'single',
                        radius: [0, '30%'],
                        label: {
                            normal: {
                                position: 'inner'
                            }
                        },
                        labelLine: {
                            normal: {
                                show: false
                            }
                        },
                        data: getInnerData(chartdatas),
                    },
                    {
                        name: '分类',
                        type: 'pie',
                        radius: ['40%', '55%'],
                        label: {
                            normal: {
                                backgroundColor: '#eee',
                                borderColor: '#aaa',
                                borderWidth: 1,
                                borderRadius: 4,
                                rich: {
                                    a: {
                                        color: '#999',
                                        lineHeight: 22,
                                        align: 'center'
                                    },
                                    hr: {
                                        borderColor: '#aaa',
                                        width: '100%',
                                        borderWidth: 0.5,
                                        height: 0
                                    },
                                    b: {
                                        fontSize: 16,
                                        lineHeight: 33
                                    },
                                    per: {
                                        color: '#eee',
                                        backgroundColor: '#334455',
                                        padding: [2, 4],
                                        borderRadius: 2
                                    }
                                }
                            }
                        },
                        data: getOutterData(chartdatas),
                    }
                ]
            };
            if (option && typeof option === "object") {
                myChart.setOption(option, true);
            }

        });

        // 获取图标数据的字段名
        function getTitles(chartdatas) {
            let titles = [];
            for (i in chartdatas) {
                titles.push(i);
            }
            return titles;
        }

        // 获取内环数据
        function getInnerData(chartdatas) {
            let datas = [];
            let p1 = {}, p2 = {}, p3 = {};
            p1.name = '应发合计';
            p1.value = chartdatas['应发合计'];
            p2.name = '奖金合计';
            p2.value = chartdatas['奖金合计'];
            p3.name = '企业超合计';
            p3.value = chartdatas['企业超合计'];
            datas.push(p1);
            datas.push(p2);
            datas.push(p3);
            return datas;
        }

        // 获取外环数据
        function getOutterData(chartdatas) {
            let allTitle = getTitles(chartdatas);
            let outterTitle = R.difference(allTitle, ['工资薪金', '应发合计', '奖金合计', '企业超合计']);
            let datas = [];
            for (let i in outterTitle) {
                let p = {};
                p.name = outterTitle[i];
                p.value = chartdatas[outterTitle[i]];
                datas.push(p);
            }
            return datas;
        }
    </script>
@stop
