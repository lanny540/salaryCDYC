<style>
    .printTable-total > tbody > tr > td {
        border: 0 none;
    }

    .printTable-total > tbody > tr > td:nth-child(odd) {
        text-align: right;
    }

    .printTable-total > tbody > tr > td:nth-child(even) {
        border-bottom: 1px solid #DDDDDD;
        text-align: left;
        width: 15%;
    }
</style>

<div class="row">
    <div class="col-sm-6">
        <address>
            <strong>{{ Auth::user()->profile->userName }}</strong><br>
            <abbr title="部门">{{ Auth::user()->profile->department->name }}</abbr>
        </address>
    </div>
    <div class="col-sm-6 text-right">
        <address>
            <strong>保险编号</strong><br>
            <abbr title="保险编号" class="text-navy">{{ Auth::user()->profile->policyNumber }}</abbr>
        </address>
    </div>
</div>

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
            <td id="annual"></td>
            <td id="wage"></td>
            <td id="retained_wage"></td>
            <td id="compensation"></td>
            <td id="night_shift"></td>
            <td id="seniority_wage"></td>
            <td id="overtime_wage"></td>
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
            <td id="month_bonus"></td>
            <td id="special"></td>
            <td id="competition"></td>
            <td id="class_reward"></td>
            <td id="holiday"></td>
            <td id="party_reward"></td>
            <td id="other_reward"></td>
            <td id="union_paying"></td>
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
            <td id="communication"></td>
            <td id="housing"></td>
            <td id="single"></td>
            <td id="traffic"></td>
            <td id="reissue_wage"></td>
            <td id="reissue_subsidy"></td>
            <td id="reissue_other"></td>
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
            <td id="retire_person"></td>
            <td id="medical_person"></td>
            <td id="unemployment_person"></td>
            <td id="gjj_person"></td>
            <td id="annuity_person"></td>
            <td id="property"></td>
            <td id="debt"></td>
            <td id="union_deduction"></td>
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
            <td id="tax_child"></td>
            <td id="tax_old"></td>
            <td id="tax_edu"></td>
            <td id="tax_loan"></td>
            <td id="tax_rent"></td>
            <td id="tax_other_deduct"></td>
            <td id="deduct_donate"></td>
            <td id="personal_tax"></td>
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
            <td id="tax_income"></td>
            <td id="taxable"></td>
            <td id="tax_reliefs"></td>
            <td id="should_deducted_tax"></td>
            <td id="have_deducted_tax"></td>
            <td id="should_be_tax"></td>
            <td id="prior_had_deducted_tax"></td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>

<table class="table printTable-total">
    <tbody>
    <tr>
        <td><strong>发放时间 :</strong></td>
        <td id="published_at"></td>
        <td><strong>工资薪金 :</strong></td>
        <td id="salary_total"></td>
        <td><strong>应发工资 :</strong></td>
        <td id="wage_total"></td>
        <td><strong>奖金合计 :</strong></td>
        <td id="bonus_total"></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td><strong>补贴合计 :</strong></td>
        <td id="subsidy_total"></td>
        <td><strong>补发合计 :</strong></td>
        <td id="reissue_total"></td>
        <td><strong>扣款合计 :</strong></td>
        <td id="deduction_total"></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td><strong>累计收入 :</strong></td>
        <td id="income"></td>
        <td><strong>累计减除费用 :</strong></td>
        <td id="deduct_expenses"></td>
        <td><strong>累计专项扣除 :</strong></td>
        <td id="special_deduction"></td>
    </tr>
    </tbody>
</table>
