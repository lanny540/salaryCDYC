<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Salary\SalarySummary
 *
 * @property int $id
 * @property int $period_id 会计期ID
 * @property string $username 人员姓名
 * @property string $policyNumber 保险编号
 * @property string $publish 发放时间
 * @property float $annual 年薪工资
 * @property float $post_wage 岗位工资
 * @property float $retained_wage 保留工资
 * @property float $compensation 套级补差
 * @property float $night_shift 中夜班费
 * @property float $overtime_wage 加班工资
 * @property float $seniority_wage 年功工资
 * @property float $total_wage 应发工资
 * @property float $bonus 月奖
 * @property float $special_bonus 专项奖
 * @property float $labor_bonus 劳动竞赛
 * @property float $course_bonus 课酬
 * @property float $festival_bonus 节日慰问费
 * @property float $party_bonus 党员奖励
 * @property float $union_bonus 工会发放
 * @property float $other_bonus 其他奖励
 * @property float $total_bonus 奖金合计
 * @property float $gjj_deduction 公积金补扣
 * @property float $gjj_person 公积金个人
 * @property float $gjj_enterprise 公积企业缴
 * @property float $annuity_deduction 年金补扣
 * @property float $annuity_person 年金个人
 * @property float $annuity_enterprise 年金企业缴
 * @property float $retire_deduction 退养金补扣
 * @property float $retire_person 退养金个人
 * @property float $retire_enterprise 退养企业缴
 * @property float $medical_deduction 医保金补扣
 * @property float $medical_person 医保金个人
 * @property float $medical_enterprise 医疗企业缴
 * @property float $unemployment_deduction 失业金补扣
 * @property float $unemployment_person 失业金个人
 * @property float $unemployment_enterprise 失业企业缴
 * @property float $injury_enterprise 工伤企业缴
 * @property float $birth_enterprise 生育企业缴
 * @property float $communication 通讯补贴
 * @property float $traffic 交通费
 * @property float $housing 住房补贴
 * @property float $single 独子费
 * @property float $subsidy 补贴合计
 * @property float $property 扣水电物管
 * @property float $deduction 扣欠款
 * @property float $union_deduction 扣工会会费
 * @property float $total_deduction 扣款合计
 * @property float $remuneration 稿酬
 * @property float $labor 劳务报酬
 * @property float $franchise 特许权费用
 * @property float $income 累计收入额
 * @property float $deduct_expenses 累减除费用
 * @property float $special_deduction 累计专项扣
 * @property float $tax_child 累专附子女
 * @property float $tax_old 累专附老人
 * @property float $tax_edu 累专附继教
 * @property float $tax_loan 累专附房利
 * @property float $tax_rent 累专附房租
 * @property float $tax_other_deduct 累其他扣除
 * @property float $deduct_donate 累计扣捐赠
 * @property float $tax_income 累税所得额
 * @property float $taxrate 税率
 * @property float $quick_deduction 速算扣除数
 * @property float $taxable 累计应纳税
 * @property float $tax_reliefs 累计减免税
 * @property float $should_deducted_tax 累计应扣税
 * @property float $have_deducted_tax 累计已扣税
 * @property float $total_income 收入合计
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereAnnual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereAnnuityDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereAnnuityEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereAnnuityPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereBirthEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereCommunication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereCompensation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereCourseBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereDeductDonate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereDeductExpenses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereFestivalBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereFranchise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereGjjDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereGjjEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereGjjPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereHaveDeductedTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereHousing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereInjuryEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereLabor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereLaborBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereMedicalDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereMedicalEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereMedicalPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereNightShift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereOtherBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereOvertimeWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary wherePartyBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary wherePolicyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary wherePostWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereProperty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary wherePublish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereQuickDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereRemuneration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereRetainedWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereRetireDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereRetireEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereRetirePerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereSeniorityWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereShouldDeductedTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereSingle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereSpecialBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereSpecialDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereSubsidy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereTaxChild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereTaxEdu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereTaxIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereTaxLoan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereTaxOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereTaxOtherDeduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereTaxReliefs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereTaxRent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereTaxable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereTaxrate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereTotalBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereTotalDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereTotalIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereTotalWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereTraffic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereUnemploymentDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereUnemploymentEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereUnemploymentPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereUnionBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereUnionDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereUsername($value)
 * @mixin \Eloquent
 * @property float $should_be_tax 累计应补税
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereShouldBeTax($value)
 */
class SalarySummary extends Model
{
    protected $table = 'statistics';

    protected $fillable = [
        'period_id', 'username', 'policyNumber', 'publish',
        // 工资
        'annual', 'post_wage', 'retained_wage', 'compensation', 'night_shift', 'overtime_wage', 'seniority_wage', 'total_wage',
        // 奖金
        'bonus', 'special_bonus', 'labor_bonus', 'course_bonus', 'festival_bonus', 'party_bonus', 'union_bonus', 'other_bonus', 'total_bonus',
        // 社保
        'gjj_deduction', 'gjj_person', 'gjj_enterprise', 'annuity_deduction', 'annuity_person', 'annuity_enterprise',
        'retire_deduction', 'retire_person', 'retire_enterprise', 'medical_deduction', 'medical_person', 'medical_enterprise',
        'unemployment_deduction', 'unemployment_person', 'unemployment_enterprise', 'injury_enterprise', 'birth_enterprise',
        // 补贴
        'communication', 'traffic', 'housing', 'single', 'subsidy',
        // 扣除
        'property', 'deduction', 'union_deduction', 'total_deduction',
        // 其他费用
        'remuneration', 'labor', 'franchise',
        // 专项税务
        'income', 'deduct_expenses', 'special_deduction',
        'tax_child', 'tax_old', 'tax_edu', 'tax_loan', 'tax_rent', 'tax_other_deduct',
        'deduct_donate', 'tax_income', 'taxrate', 'quick_deduction',
        'taxable', 'tax_reliefs', 'should_deducted_tax', 'have_deducted_tax',
        // 收入合计
        'total_income'
    ];
}
