@extends('layouts.app')

@section('css')
<!-- Toastr style -->
<link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
@stop

@section('title', '个税计算器')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox" id="taxForm">
                <div class="ibox-content">
                    <div class="sk-spinner sk-spinner-double-bounce">
                        <div class="sk-double-bounce1"></div>
                        <div class="sk-double-bounce2"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7 b-r">
                            <div class="form-group row">
                                <div class="col-sm-8">
                                    <input type="text" name="money" id="money" class="form-control input-lg" style="font-size: 20px" placeholder="请输入需要计算的金额">
                                </div>
                                <button id="taxCal" class="btn btn-primary col-sm-3" style="font-size: 22px">计算</button>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <h2 class="text-center" id="tax" style="margin-top: 10px;"> 应缴纳个税: ￥ 0.00</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr/>
    <div class="ibox-content m-b-sm">
        <div class="text-center">
            <h2>如果您对个税计算有任何疑问，请咨询 <strong>计划财务部</strong> ！</h2>
        </div>
    </div>
    <div class="faq-item">
        <div class="row">
            <div class="col-md-12">
                <a data-toggle="collapse" href="#faq1" class="faq-question">个人所得税是如何计算的 ?</a>
                <small>Added by <strong>计划财务部</strong> <i class="fa fa-clock-o"></i> 2020-02-15</small>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="faq1" class="panel-collapse collapse ">
                    <div class="faq-answer">
                        <p> 新个人所得税应纳税所得额的计算：</p>
                        <p> (一)居民个人的综合所得，以每一纳税年度的收入额减除费用六万元以及专项扣除、专项附加扣除和依法确定的其他扣除后的余额，为应纳税所得额。</p>
                        <p> (二)非居民个人的工资、薪金所得，以每月收入额减除费用五千元后的余额为应纳税所得额;劳务报酬所得、稿酬所得、特许权使用费所得，以每次收入额为应纳税所得额。</p>
                        <p> (三)经营所得，以每一纳税年度的收入总额减除成本、费用以及损失后的余额，为应纳税所得额。</p>
                        <p>(四)财产租赁所得，每次收入不超过四千元的，减除费用八百元;四千元以上的，减除百分之二十的费用，其余额为应纳税所得额。</p>
                        <p> (五)财产转让所得，以转让财产的收入额减除财产原值和合理费用后的余额，为应纳税所得额。</p>
                        <p> (六)利息、股息、红利所得和偶然所得，以每次收入额为应纳税所得额。</p>
                        <p>劳务报酬所得、稿酬所得、特许权使用费所得以收入减除百分之二十的费用后的余额为收入额。稿酬所得的收入额减按百分之七十计算。</p>
                        <p>个人将其所得对教育、扶贫、济困等公益慈善事业进行捐赠，捐赠额未超过纳税人申报的应纳税所得额百分之三十的部分，可以从其应纳税所得额中扣除;国务院规定对公益慈善事业捐赠实行全额税前扣除的，从其规定。
                        <p>本条第一款第一项规定的专项扣除，包括居民个人按照国家规定的范围和标准缴纳的基本养老保险、基本医疗保险、失业保险等社会保险费和住房公积金等;专项附加扣除，包括子女教育、继续教育、大病医疗、住房贷款利息或者住房租金、赡养老人等支出，具体范围、标准和实施步骤由国务院确定，并报全国人民代表大会常务委员会备案。</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="faq-item">
        <div class="row">
            <div class="col-md-12">
                <a data-toggle="collapse" href="#faq1" class="faq-question">为什么我的收入合计和其他地方统计的不一样 ?</a>
                <small>Added by <strong>计划财务部</strong> <i class="fa fa-clock-o"></i> 2019-05-15</small>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="faq1" class="panel-collapse collapse ">
                    <div class="faq-answer">
                        <p>
                            收入合计不一致的主要原因是计划财务部与其他部门的统计口径不一致所造成的。
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<!-- Toastr -->
<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>

<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')}});

    $('#taxCal').click(function () {
        var salary = $('#money').val();
        if (salary > 0) {
            $('#taxForm').children('.ibox-content').toggleClass('sk-loading');
            $.ajax({
                type: "POST",
                url: "/tax",
                data: {
                    money: salary
                },
                success: function (data) {
                    $('#tax').html('应缴纳个税: ￥ ' + data);
                    $('#taxForm').children('.ibox-content').toggleClass('sk-loading');
                }
            });
        } else {
            toastr.options = {
                progressBar: true,
                positionClass: 'toast-top-center',
                showMethod: 'slideDown',
                timeOut: 3000
            };
            toastr.error('请输入大于0的金额！');
            $('#money').focus().val('');
        }

    });
</script>
@stop
