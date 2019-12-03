@extends('layouts.app')

@section('css')
<!-- Select2 -->
<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('breadcrumbs')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-3">
        <h2>个人薪酬打印</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">首页</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>个人薪酬打印</strong>
            </li>
        </ol>
    </div>

    <div class="col-lg-7">
        <div class="title-action form-group row">
            <div class="col-lg-3">
                <label class="col-form-label" for="published_at">发放日期</label>
            </div>
            <div class="col-lg-6">
                <select name="published_at" id="published_at" class="select2_published form-control" multiple="multiple">
                    @foreach($periods as $p)
                        <option value="{{ $p->id }}">{{ $p->published_at }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3">
                <button class="btn btn-white" id="searchBtn"><i class="fa fa-pencil"></i> 确定 </button>
            </div>
        </div>
    </div>

    <div class="col-lg-2">
        <div class="title-action">
            <button class="btn btn-primary" id="printBtn"><i class="fa fa-print"></i> 打印工资条 </button>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl">

                @include('print._table')

                <div class="well m-t"><strong>说明：</strong>
                    收入清单属于个人隐私，请妥善保管！！ 如果数据有任何疑问，请通过系统相关功能查询或者点击 <a href="{{ route('contact') }}">联系我们</a>  页面 联系财务部。
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- Select2 -->
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

<script src="{{ asset('js/helper.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $(".select2_published").select2({
        maximumSelectionLength: 12,
        placeholder: "请选择发放日期...",
        allowClear: true,
    });

    $(document).ready(function () {
        $('#searchBtn').on('click', function() {
            let params = {
                periods: $("#published_at").val(),
                policy: {{ Auth::user()->profile->policyNumber }},
            };
            $.post({
                url: 'personprint',
                data: params,
                success: function (data) {
                    console.log(data);
                    let printHtml = getPrintHtml(data);
                    let printTable = $('#printTable');
                    printTable.html('');
                    printTable.html(printHtml);
                }
            });

        });

        $('#printBtn').click(function () {
            window.open('/print');
        });
    });

    function getPrintHtml(data)
    {
        let html = '';
        for (let i = 0; i < data.length; ++i) {
            let tableHtml = getPrintTable(data[i]);
            let totalHtml = getPrintTotal(data[i]);
            html += tableHtml + totalHtml + '<hr/>';
        }

        return html;
    }

    function getPrintTable(d)
    {
        return `
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>年薪工资</th>
                            <th>岗位工资</th>
                            <th>保留工资</th>
                            <th>套级补差</th>
                            <th>中夜班费</th>
                            <th>年功工资</th>
                            <th>加班工资</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>${d.annual}</td>
                            <td>${d.wage}</td>
                            <td>${d.retained_wage}</td>
                            <td>${d.compensation}</td>
                            <td>${d.night_shift}</td>
                            <td>${d.seniority_wage}</td>
                            <td>${d.overtime_wage}</td>
                            <td></td>
                        </tr>

                        <tr>
                            <th>月奖</th>
                            <th>专项奖</th>
                            <th>劳动竞赛</th>
                            <th>课酬</th>
                            <th>节日慰问费</th>
                            <th>党员奖励</th>
                            <th>其他奖励</th>
                            <th>工会发放</th>
                        </tr>
                        <tr>
                            <td>${d.month_bonus}</td>
                            <td>${d.special}</td>
                            <td>${d.competition}</td>
                            <td>${d.class_reward}</td>
                            <td>${d.holiday}</td>
                            <td>${d.party_reward}</td>
                            <td>${d.other_reward}</td>
                            <td>${d.union_paying}</td>
                        </tr>

                        <tr>
                            <th>通讯补贴</th>
                            <th>住房补贴</th>
                            <th>独子费</th>
                            <th>交通补贴</th>
                            <th>补发工资</th>
                            <th>补发补贴</th>
                            <th>补发其他</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>${d.communication}</td>
                            <td>${d.housing}</td>
                            <td>${d.single}</td>
                            <td>${d.traffic}</td>
                            <td>${d.reissue_wage}</td>
                            <td>${d.reissue_subsidy}</td>
                            <td>${d.reissue_other}</td>
                            <td></td>
                        </tr>

                        <tr>
                            <th>养老保险个人</th>
                            <th>医疗保险个人</th>
                            <th>失业保险个人</th>
                            <th>公积金个人</th>
                            <th>年金个人</th>
                            <th>扣水电物管</th>
                            <th>扣欠款及捐赠</th>
                            <th>工会会费</th>
                        </tr>
                        <tr>
                            <td>${d.retire_person}</td>
                            <td>${d.medical_person}</td>
                            <td>${d.unemployment_person}</td>
                            <td>${d.gjj_person}</td>
                            <td>${d.annuity_person}</td>
                            <td>${d.property}</td>
                            <td>${d.debt}</td>
                            <td>${d.union_deduction}</td>
                        </tr>

                        <tr>
                            <th>累专附子女</th>
                            <th>累专附老人</th>
                            <th>累专附继教</th>
                            <th>累专附房租</th>
                            <th>累专附房利</th>
                            <th>累其他扣除</th>
                            <th>累计扣捐赠</th>
                            <th>个人所得税</th>
                        </tr>
                        <tr>
                            <td>${d.tax_child}</td>
                            <td>${d.tax_old}</td>
                            <td>${d.tax_edu}</td>
                            <td>${d.tax_loan}</td>
                            <td>${d.tax_rent}</td>
                            <td>${d.tax_other_deduct}</td>
                            <td>${d.deduct_donate}</td>
                            <td>${d.personal_tax}</td>
                        </tr>

                        <tr>
                            <th>累计应纳税所得额</th>
                            <th>累计应纳税</th>
                            <th>累计减免税</th>
                            <th>累计应扣税</th>
                            <th>累计申报已扣税</th>
                            <th>累计应补税</th>
                            <th>上期已扣税</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>${d.tax_income}</td>
                            <td>${d.taxable}</td>
                            <td>${d.tax_reliefs}</td>
                            <td>${d.should_deducted_tax}</td>
                            <td>${d.have_deducted_tax}</td>
                            <td>${d.should_be_tax}</td>
                            <td>${d.prior_had_deducted_tax}</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;
    }

    function getPrintTotal(d)
    {
        return `
            <table class="table printTable-total">
            <tbody>
            <tr>
                <td><strong>发放时间 :</strong></td>
                <td>${d.published_at}</td>
                <td><strong>工资薪金 :</strong></td>
                <td>${d.salary_total}</td>
                <td><strong>应发工资 :</strong></td>
                <td>${d.wage_total}</td>
                <td><strong>奖金合计 :</strong></td>
                <td>${d.bonus_total}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><strong>补贴合计 :</strong></td>
                <td>${d.subsidy_total}</td>
                <td><strong>补发合计 :</strong></td>
                <td>${d.reissue_total}</td>
                <td><strong>扣款合计 :</strong></td>
                <td>${d.deduction_total}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><strong>累计收入 :</strong></td>
                <td>${d.income}</td>
                <td><strong>累计减除费用 :</strong></td>
                <td>${d.deduct_expenses}</td>
                <td><strong>累计专项扣除 :</strong></td>
                <td>${d.special_deduction}</td>
            </tr>
            </tbody>
            </table>
        `;
    }
</script>
@endsection
