@extends('layouts.app')

@section('css')
<!-- Data picker -->
<link href="{{ asset('css/plugins/datepicker/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
<!-- DataTables -->
<link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@stop

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
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-content m-b-sm border-bottom">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group row" id="selectMonth">
                    <label class="col-md-4 col-form-label">选择月份</label>
                    <div class="col-md-8 input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" class="form-control" value="{{ \Carbon\Carbon::today()->year }}-{{ \Carbon\Carbon::today()->month }}">
                    </div>
                </div>
            </div>
            <div class="col-sm-3 offset-1">
{{--                <a class="btn btn-block btn-primary salarysubmit" href="/temp">确认选择</a>--}}
                <button class="btn btn-block btn-primary salarysubmit">确认选择</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <table id="staticsSalary" class="table table-striped table-hover text-center">
                        <thead>
                        <tr>
                            <th>保险编号</th>
                            <th>姓名</th>
                            <th>period_id</th>

                            <th>年薪工资</th>
                            <th>岗位工资</th>
                            <th>保留工资</th>
                            <th>套级补差</th>
                            <th>中夜班费</th>
                            <th>加班工资</th>
                            <th>年功工资</th>
{{--                            <th>应发工资</th>--}}

                            <th>月奖</th>
                            <th>专项奖</th>
                            <th>节日慰问费</th>
                            <th>工会发放</th>
                            <th>课酬</th>
                            <th>劳动竞赛</th>
                            <th>党员奖励</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
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
<!-- DataTables -->
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- ramda -->
<script src="{{ asset('js/plugins/ramda/ramda.min.js') }}"></script>

<script src="{{ asset('js/helper.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#selectMonth .input-group.date').datepicker({
            language: "zh-CN",
            minViewMode: 1,
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true,
            todayHighlight: true,
            format: "yyyy-mm"
        });

        $('.salarysubmit').click(function () {
            $.get('/temp', function (data) {
                console.log(data);
                // TODO: 数据 JS 合并处理
                const staticsSalary = mergeSalary(data);
                console.log(staticsSalary);

                let salaryTable = $('#staticsSalary').dataTable();
                if ($('#staticsSalary').hasClass('dataTable')) {
                    salaryTable.fnClearTable(); //清空一下table
                    salaryTable.fnDestroy(); //还原初始化了的datatable
                }

                $('#staticsSalary').dataTable({
                    processing: true,
                    scrollX: true,
                    data: staticsSalary,
                    columnDefs: [
                        { width: "10%" }
                    ],
                    columns: [
                        { data: "policyNumber", title: "保险编号" },
                        { data: "username", title: "姓名" },
                        { data: "period_id", title: "发放时间" },
                        // 工资
                        { data: "annual", title: "年薪工资" },
                        { data: "post_wage", title: "岗位工资" },
                        { data: "retained_wage", title: "保留工资" },
                        { data: "compensation", title: "套级补差" },
                        { data: "night_shift", title: "中夜班费" },
                        { data: "overtime_wage", title: "加班工资" },
                        { data: "seniority_wage", title: "年功工资" },
                        // { data: "total_wage", title: "应发工资", orderable: false },
                        // 奖金
                        { data: "月奖", title: "月奖" },
                        { data: "专项奖", title: "专项奖" },
                        { data: "节日慰问费", title: "节日慰问费" },
                        { data: "工会发放", title: "工会发放" },
                        { data: "课酬", title: "课酬" },
                        { data: "劳动竞赛", title: "劳动竞赛" },
                        { data: "党员奖励", title: "党员奖励" },
                    ]
                });
            });
        });
    });

</script>
@stop
