@extends('print.layout')

@section('table')
    <div class="row">
        <div class="col-sm-6">
            <address style="font-size:20px;">
                <strong>{{ Auth::user()->profile->userName }}</strong><br>
                <abbr class="text-navy">{{ Auth::user()->profile->department->name }}</abbr>
            </address>
        </div>
        <div class="col-sm-6 text-right">
            <address style="font-size:20px;">
                <strong>保险编号</strong><br>
                <abbr class="text-navy">{{ Auth::user()->profile->policyNumber }}</abbr>
            </address>
        </div>
    </div>

    <div id="printTable" class="print-table" style="margin-top: 20px;">
        @foreach ($data as $k => $d)
            <div class="table-responsive" style="margin-top:40px;">
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
                        <td>{{ $d->annual }}</td>
                        <td>{{ $d->wage }}</td>
                        <td>{{ $d->retained_wage }}</td>
                        <td>{{ $d->compensation }}</td>
                        <td>{{ $d->night_shift }}</td>
                        <td>{{ $d->seniority_wage }}</td>
                        <td>{{ $d->overtime_wage }}</td>
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
                        <td>{{ $d->month_bonus }}</td>
                        <td>{{ $d->special }}</td>
                        <td>{{ $d->competition }}</td>
                        <td>{{ $d->class_reward }}</td>
                        <td>{{ $d->holiday }}</td>
                        <td>{{ $d->party_reward }}</td>
                        <td>{{ $d->other_reward }}</td>
                        <td>{{ $d->union_paying }}</td>
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
                        <td>{{ $d->communication }}</td>
                        <td>{{ $d->housing }}</td>
                        <td>{{ $d->single }}</td>
                        <td>{{ $d->traffic }}</td>
                        <td>{{ $d->reissue_wage }}</td>
                        <td>{{ $d->reissue_subsidy }}</td>
                        <td>{{ $d->reissue_other }}</td>
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
                        <td>{{ $d->retire_person }}</td>
                        <td>{{ $d->medical_person }}</td>
                        <td>{{ $d->unemployment_person }}</td>
                        <td>{{ $d->gjj_person }}</td>
                        <td>{{ $d->annuity_person }}</td>
                        <td>{{ $d->property }}</td>
                        <td>{{ $d->debt }}</td>
                        <td>{{ $d->union_deduction }}</td>
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
                        <td>{{ $d->tax_child }}</td>
                        <td>{{ $d->tax_old }}</td>
                        <td>{{ $d->tax_edu }}</td>
                        <td>{{ $d->tax_loan }}</td>
                        <td>{{ $d->tax_rent }}</td>
                        <td>{{ $d->tax_other_deduct }}</td>
                        <td>{{ $d->deduct_donate }}</td>
                        <td>{{ $d->personal_tax }}</td>
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
                        <td>{{ $d->tax_income }}</td>
                        <td>{{ $d->taxable }}</td>
                        <td>{{ $d->tax_reliefs }}</td>
                        <td>{{ $d->should_deducted_tax }}</td>
                        <td>{{ $d->have_deducted_tax }}</td>
                        <td>{{ $d->should_be_tax }}</td>
                        <td>{{ $d->prior_had_deducted_tax }}</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <table class="table printTable-total" style="margin-top:30px;margin-bottom:40px;">
                <tbody>
                <tr>
                    <td><strong>发放时间 :</strong></td>
                    <td>{{ $d->published_at }}</td>
                    <td><strong>工资薪金 :</strong></td>
                    <td>{{ $d->salary_total }}</td>
                    <td><strong>应发工资 :</strong></td>
                    <td>{{ $d->wage_total }}</td>
                    <td><strong>奖金合计 :</strong></td>
                    <td>{{ $d->bonus_total }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><strong>补贴合计 :</strong></td>
                    <td>{{ $d->subsidy_total }}</td>
                    <td><strong>补发合计 :</strong></td>
                    <td>{{ $d->reissue_total }}</td>
                    <td><strong>扣款合计 :</strong></td>
                    <td>{{ $d->deduction_total }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><strong>累计收入 :</strong></td>
                    <td>{{ $d->income }}</td>
                    <td><strong>累计减除费用 :</strong></td>
                    <td>{{ $d->deduct_expenses }}</td>
                    <td><strong>累计专项扣除 :</strong></td>
                    <td>{{ $d->special_deduction }}</td>
                </tr>
                </tbody>
            </table>
            <hr style='border: 8px solid grey;'/>
            @if (($k+1) % 2 == 0)
                <div style="page-break-before:always"></div>
            @endif
        @endforeach
    </div>

@endsection
