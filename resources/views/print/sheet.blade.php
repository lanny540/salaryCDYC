@extends('layouts.app')

@section('css')
<!-- Data picker -->
<link href="{{ asset('css/plugins/datepicker/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
@stop

@section('title', '工资条打印')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row m-t-sm">
                    <div class="col-lg-12">
                        <div class="panel blank-panel">
                            <div class="panel-heading">
                                <div class="panel-options">
                                    <ul class="nav nav-tabs">
                                        <li><a class="nav-link active" href="#tab-1" data-toggle="tab">个人打印</a></li>
                                        <li><a class="nav-link" href="#tab-2" data-toggle="tab">部门打印</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab-1">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row" id="selectMonth">
                                                    <label class="col-lg-2 col-form-label">选择月份</label>
                                                    <div class="col-lg-10 input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::today()->year }}-{{ \Carbon\Carbon::today()->month }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <table class="table table-bordered invoice-table row mx-0">
                                                <tbody class="w-100">
                                                <tr class="row mx-0 bg-primary">
                                                    <td class="col-2 text-center"><strong>发放日期</strong></td>
                                                    <td class="col-3 text-center"><strong>保险编号</strong></td>
                                                    <td class="col-3 text-center"><strong>姓名</strong></td>
                                                    <td class="col-4 text-center"><strong>实发工资</strong></td>
                                                </tr>
                                                <tr class="row mx-0">
                                                    <td class="col-2 text-center">2018-01</td>
                                                    <td class="col-3 text-center">0500001</td>
                                                    <td class="col-3 text-center">李四</td>
                                                    <td class="col-4 text-center">6666.66</td>
                                                </tr>
                                                <tr class="row mx-0 bg-success">
                                                    <td class="col-1 text-center"><strong>岗位工资</strong></td>
                                                    <td class="col-1 text-center"><strong>中夜班费加班工资</strong></td>
                                                    <td class="col-1 text-center"><strong>年功工资</strong></td>
                                                    <td class="col-1 text-center"><strong>交通费补贴</strong></td>
                                                    <td class="col-1 text-center"><strong>通讯费补贴</strong></td>
                                                    <td class="col-1 text-center"><strong>住房补贴</strong></td>
                                                    <td class="col-1 text-center"><strong>独子费</strong></td>
                                                    <td class="col-1 text-center"><strong>补发</strong></td>
                                                    <td class="col-4 text-center"><strong>应发小计</strong></td>
                                                </tr>
                                                <tr class="row mx-0">
                                                    <td class="col-1 text-center">5555.00</td>
                                                    <td class="col-1 text-center">0</td>
                                                    <td class="col-1 text-center">345.00</td>
                                                    <td class="col-1 text-center">380.00</td>
                                                    <td class="col-1 text-center">100.00</td>
                                                    <td class="col-1 text-center">800.00</td>
                                                    <td class="col-1 text-center">0</td>
                                                    <td class="col-1 text-center">0</td>
                                                    <td class="col-4 text-center">6666.00</td>
                                                </tr>
                                                <tr class="row mx-0 bg-success">
                                                    <td class="col-1 text-center"><strong>扣病事婴假</strong></td>
                                                    <td class="col-1 text-center"><strong>扣养老保险</strong></td>
                                                    <td class="col-1 text-center"><strong>扣医疗保险</strong></td>
                                                    <td class="col-1 text-center"><strong>扣失业保险</strong></td>
                                                    <td class="col-1 text-center"><strong>扣住房公积金</strong></td>
                                                    <td class="col-1 text-center"><strong>扣企业年金</strong></td>
                                                    <td class="col-1 text-center"><strong>扣水电气扣物管费</strong></td>
                                                    <td class="col-1 text-center"><strong>扣欠款及工会会费</strong></td>
                                                    <td class="col-2 text-center"><strong>扣个人所得税</strong></td>
                                                    <td class="col-2 text-center"><strong>扣款小计</strong></td>
                                                </tr>
                                                <tr class="row mx-0">
                                                    <td class="col-1 text-center"></td>
                                                    <td class="col-1 text-center">1068.24</td>
                                                    <td class="col-1 text-center">250.66</td>
                                                    <td class="col-1 text-center">99.88</td>
                                                    <td class="col-1 text-center">1888.00</td>
                                                    <td class="col-1 text-center">432.11</td>
                                                    <td class="col-1 text-center">36.88</td>
                                                    <td class="col-1 text-center"></td>
                                                    <td class="col-2 text-center">25.00</td>
                                                    <td class="col-2 text-center">2981.67</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-2">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row" id="selectMonth">
                                                    <label class="col-lg-2 col-form-label">选择月份</label>
                                                    <div class="col-lg-10 input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        <input type="text" class="form-control" value="2018-01">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5 text-center">
                                    <button class="btn btn-lg btn-primary" id="printBtn"><i class="fa fa-print"></i> 打印工资条</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<!-- Date picker -->
<script src="{{ asset('js/plugins/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/plugins/datepicker/locales/bootstrap-datepicker.zh-CN.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#selectMonth .input-group.date').datepicker({
            language: "zh-CN",
            minViewMode: 1,
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            todayHighlight: true,
            format: "yyyy-mm"
        });

        $('#printBtn').click(function () {
            window.open('/sheetPrint?ids=6');
        });
    });
</script>    
@stop
