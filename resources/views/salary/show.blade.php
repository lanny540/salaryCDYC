@extends('layouts.app')

@section('css')
<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">

<style>
    .salaryHeader {
        font-size: 22px;
    }

    .salaryDetail {
        font-size: 18px;
    }
</style>
@endsection

@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>个人薪酬</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">首页</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('salary.index') }}">薪酬统计</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>薪酬明细</strong>
            </li>
        </ol>
    </div>
</div>
@endsection

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
                                    <a href="{{ route('sheet.index') }}" class="btn btn-primary btn-lg float-right">打印工资条</a>
                                    <button class="btn btn-info btn-lg float-right" style="margin-right: 20px;" data-toggle="modal" data-target="#designFormulas" type="button">
                                        <i class="fa fa-cart-plus" ></i> 查看计算公式
                                    </button>
                                    <h1 class="product-main-price">￥ {{ $summary->salary_total }}</h1>
                                </div>
                                <hr>

                                <h3 class="salaryHeader">应发工资: {{ $summary->wage_total }}</h3>
                                <div class="row">
                                    @foreach($detail['应发工资'][0] as $k => $v)
                                        @if($k !== '保险编号' && $k !== '应发工资')
                                            <div class="col-md-6 salaryDetail">{{ $k }}: {{ $v }} </div>
                                        @endif
                                    @endforeach
                                </div>
                                <hr/>
                                <h3 class="salaryHeader">补贴合计: {{ $summary->subsidy_total }}</h3>
                                <div class="row">
                                    @foreach($detail['补贴合计'][0] as $k => $v)
                                        @if($k !== '保险编号' && $k !== '补贴合计')
                                            <div class="col-md-6 salaryDetail">{{ $k }}: {{ $v }} </div>
                                        @endif
                                    @endforeach
                                </div>
                                <hr/>
                                <h3 class="salaryHeader">补发合计: {{ $summary->reissue_total }}</h3>
                                <div class="row">
                                    @foreach($detail['补发合计'][0] as $k => $v)
                                        @if($k !== '保险编号' && $k !== '补发合计')
                                            <div class="col-md-6 salaryDetail">{{ $k }}: {{ $v }} </div>
                                        @endif
                                    @endforeach
                                </div>
                                <hr/>
                                <h3 class="salaryHeader">奖金合计: {{ $summary->bonus_total }}</h3>
                                <div class="row">
                                    @foreach($detail['奖金合计'][0] as $k => $v)
                                        @if($k !== '保险编号' && $k !== '奖金合计')
                                            <div class="col-md-6 salaryDetail">{{ $k }}: {{ $v }} </div>
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
                            <div class="col-md-12">
                                <h3 class="salaryHeader">扣款合计: {{ $detail['扣款合计'][0]->扣款合计 }}</h3>
                                <div class="row">
                                    @foreach($detail['扣款合计'][0] as $k => $v)
                                        @if($k !== '保险编号' && $k !== '扣款合计')
                                            <div class="col-md-3" style="font-size: 16px;">{{ $k }}: {{ $v }} </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top: 20px;">
                                <h3 class="salaryHeader">专项税务相关</h3>
                                <div class="row">
                                    @foreach($detail['专项相关'][0] as $k => $v)
                                        @if($k !== '保险编号')
                                            <div class="col-md-3" style="font-size: 16px;">{{ $k }}: {{ $v }} </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="modal inmodal fade" id="designFormulas" tabindex="-1" role="dialog"  aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <h4 class="modal-title">薪酬计算公式</h4>
                                        <small class="font-bold" style="font-size: 16px;">由计划财务部提供并提供解释</small>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>累计应纳税所得额</strong> = 累计收入 - 累计减除费用 - 累计专项扣除 - 累专附子女 - 累专附老人 - 累专附继教
                                            - 累专附房租 - 累专附房利 - 累其他扣除 - 累计扣捐赠
                                        </p>
                                        <p><strong>累计应纳税</strong> = 累计应纳税所得额 * 税率 - 速算扣除数</p>
                                        <p><strong>累计应扣税</strong> = 累计应纳税 - 累计减免税</p>
                                        <p><strong>累计应补税</strong> = 累计应扣税 - 累计申报已扣税</p>
                                        <p><strong>税差</strong> = 上期申报个税 - 上期已扣税</p>
                                        <p><strong>个人所得税</strong> = 累计应补税 + 稿酬扣税 + 特许权使用费扣税</p>
                                        <hr/>
                                        <p><strong>工资发放</strong> = 应发工资 + 补贴合计 + 补发合计 - 个人三险一金 - 年金个人 - 扣款合计 + 余欠款</p>
                                        <p><strong>企业超标合计</strong> = 医疗企超标 + 失业企超标 + 公积企超标 + 退养企超标 + 年金企超标</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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
@endsection
