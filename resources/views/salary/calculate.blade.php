@extends('layouts.app')

@section('css')
<!-- DataTables -->
<link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
<!-- Sweet Alert -->
<link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
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
            <div class="col-sm-3 offset-1">
                <button class="btn btn-lg btn-block btn-primary salarysubmit">当前周期汇总计算</button>
            </div>
            <div class="col-sm-3 offset-3">
                <button class="btn btn-lg btn-block btn-success settleAccount">当前周期结算</button>
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
                            <th>应发工资</th>

                            <th>月奖</th>
                            <th>专项奖</th>
                            <th>节日慰问费</th>
                            <th>工会发放</th>
                            <th>课酬</th>
                            <th>劳动竞赛</th>
                            <th>党员奖励</th>
                            <th>其他奖励</th>
                            <th>奖金合计</th>

                            <th>养老保险</th>
                            <th>医疗保险</th>
                            <th>失业保险</th>
                            <th>公积金</th>
                            <th>年金个人</th>
                            <th>养老企业缴</th>
                            <th>医疗企业缴</th>
                            <th>失业企业缴</th>
                            <th>工伤企业缴</th>
                            <th>生育企业缴</th>
                            <th>公积金企业缴</th>
                            <th>年金企业缴</th>
                            <th>养老保险扣除</th>
                            <th>医疗保险扣除</th>
                            <th>失业保险扣除</th>
                            <th>公积金扣除</th>
{{--                            <th>专项扣除</th>--}}
                            <th>通讯补贴</th>
                            <th>交通费</th>
                            <th>住房补贴</th>
                            <th>独子费</th>
                            <th>补贴合计</th>

{{--                            <th>年金个人扣除</th>--}}
{{--                            <th>其他扣除</th>--}}
{{--                            <th>扣除合计</th>--}}

                            <th>扣水电物管</th>
{{--                            <th>扣欠款及工会会费</th>--}}
{{--                            <th>捐赠</th>--}}
{{--                            <th>税差</th>--}}
{{--                            <th>个人所得税</th>--}}
{{--                            <th>扣款合计</th>--}}

{{--                            <th>实发工资</th>--}}

                            <th>累计收入</th>
                            <th>累计减除费用</th>
                            <th>累计专项扣除</th>
                            <th>累专附子女</th>
                            <th>累专附老人</th>
                            <th>累专附继教</th>
                            <th>累专附房租</th>
                            <th>累专附房利</th>
                            <th>累其他扣除</th>
                            <th>累计扣捐赠</th>
                            <th>累计应纳税所得额</th>
                            <th>税率(%)</th>
                            <th>速算扣除数</th>
                            <th>累计应纳税</th>
                            <th>累计减免税</th>
                            <th>累计应扣税</th>
                            <th>累计已扣税</th>
                            <th>累计应补税</th>
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
<!-- Sweet alert -->
<script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/datatables.config.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- ramda -->
<script src="{{ asset('js/plugins/ramda/ramda.min.js') }}"></script>

<script src="{{ asset('js/helper.js') }}"></script>

<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});
    let staticsSalary;
    $('#staticsSalary').hide();
    $(document).ready(function() {
        $('.salarysubmit').click(function () {
            $('#statistForm').children('.ibox-content').toggleClass('sk-loading');
            $.get('/calSalary', function (data) {
                if (data === '') {
                    swal({
                        type: 'error',
                        title: '错误!',
                        text: '没有权限计算!请联系管理员.',
                    });
                } else {
                    staticsSalary = mergeSalary(data);
                    // console.log(staticsSalary);

                    let salaryTable = $('#staticsSalary').dataTable();
                    if ($('#staticsSalary').hasClass('dataTable')) {
                        salaryTable.fnClearTable(); //清空table
                        salaryTable.fnDestroy(); //还原初始化的datatable
                    }

                    salaryTable.show();
                    $('#staticsSalary').dataTable({
                        scrollX: true,
                        data: staticsSalary,
                        columns: [
                            { data: "policyNumber", title: "保险编号", width: "45px" },
                            { data: "username", title: "姓名", width: "45px" },
                            { data: "period_id", title: "发放时间", width: "45px" },
                            // 工资
                            { data: "annual", title: "年薪工资", width: "45px" },
                            { data: "post_wage", title: "岗位工资", width: "45px" },
                            { data: "retained_wage", title: "保留工资", width: "45px" },
                            { data: "compensation", title: "套级补差", width: "45px" },
                            { data: "night_shift", title: "中夜班费", width: "45px" },
                            { data: "overtime_wage", title: "加班工资", width: "45px" },
                            { data: "seniority_wage", title: "年功工资", width: "45px" },
                            { data: "total_wage", title: "应发工资", width: "45px" },
                            // 奖金
                            { data: "月奖", title: "月奖", width: "45px" },
                            { data: "专项奖", title: "专项奖", width: "45px" },
                            { data: "节日慰问费", title: "节日慰问费", width: "45px" },
                            { data: "工会发放", title: "工会发放", width: "45px" },
                            { data: "课酬", title: "课酬", width: "45px" },
                            { data: "劳动竞赛", title: "劳动竞赛", width: "45px" },
                            { data: "党员奖励", title: "党员奖励", width: "45px" },
                            { data: "其他奖励", title: "其他奖励", width: "45px" },
                            { data: "奖金合计", title: "奖金合计", width: "45px" },
                            // 社保
                            { data: "retire_person", title: "养老保险", width: "45px" },
                            { data: "medical_person", title: "医疗保险", width: "45px" },
                            { data: "unemployment_person", title: "失业保险", width: "45px" },
                            { data: "gjj_person", title: "公积金", width: "45px" },
                            { data: "annuity_person", title: "年金个人", width: "45px" },
                            { data: "retire_enterprise", title: "养老企业缴", width: "45px" },
                            { data: "medical_enterprise", title: "医疗企业缴", width: "45px" },
                            { data: "unemployment_enterprise", title: "失业企业缴", width: "45px" },
                            { data: "injury_enterprise", title: "工伤企业缴", width: "45px" },
                            { data: "birth_enterprise", title: "生育企业缴", width: "45px" },
                            { data: "gjj_enterprise", title: "公积金企业缴", width: "45px" },
                            { data: "annuity_enterprise", title: "年金企业缴", width: "45px" },
                            { data: "retire_deduction", title: "养老保险扣除", width: "45px" },
                            { data: "medical_deduction", title: "医疗保险扣除", width: "45px" },
                            { data: "unemployment_deduction", title: "失业保险扣除", width: "45px" },
                            { data: "gjj_deduction", title: "公积金扣除", width: "45px" },
                            // { data: "total_deduction", title: "专项扣除", width: "45px" },
                            // 补贴
                            { data: "communication", title: "通讯补贴", width: "45px" },
                            { data: "traffic", title: "交通费", width: "45px" },
                            { data: "housing", title: "住房补贴", width: "45px" },
                            { data: "single", title: "独子费", width: "45px" },
                            { data: "subsidy", title: "补贴合计", width: "45px" },
                            // 扣款
                            // 物管费
                            { data: "total_property", title: "扣水电物管", width: "45px" },
                            // 其他费用
                            // 税务
                            { data: "income", title: "累计收入额", width: "45px" },
                            { data: "deduct_expenses", title: "累减除费用", width: "45px" },
                            { data: "special_deduction", title: "累计专项扣", width: "45px" },
                            { data: "tax_child", title: "累专附子女", width: "45px" },
                            { data: "tax_old", title: "累专附老人", width: "45px" },
                            { data: "tax_edu", title: "累专附继教", width: "45px" },
                            { data: "tax_loan", title: "累专附房利", width: "45px" },
                            { data: "tax_rent", title: "累专附房租", width: "45px" },
                            { data: "tax_other_deduct", title: "累其他扣除", width: "45px" },
                            { data: "deduct_donate", title: "累计扣捐赠", width: "45px" },
                            { data: "tax_income", title: "累税所得额", width: "45px" },
                            { data: "taxrate", title: "税率(%)", width: "45px" },
                            { data: "quick_deduction", title: "速算扣除数", width: "45px" },
                            { data: "taxable", title: "累计应纳税", width: "45px" },
                            { data: "tax_reliefs", title: "累计减免税", width: "45px" },
                            { data: "should_deducted_tax", title: "累计应扣税", width: "45px" },
                            { data: "have_deducted_tax", title: "累计已扣税", width: "45px" },
                            { data: "should_be_tax", title: "累计应补税", width: "45px" },
                        ]
                    });
                }
                $('#statistForm').children('.ibox-content').toggleClass('sk-loading');
            });
        });

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
@stop
