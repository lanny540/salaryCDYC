<?php

namespace App\Models\Voucher;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Voucher\VoucherStatistic
 *
 * @property int $id
 * @property int $period_id 会计期ID
 * @property string $dwdm 部门编码
 * @property int $sum_number 人数
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereDwdm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereSumNumber($value)
 * @mixin \Eloquent
 * @property float $wage 岗位工资
 * @property float $retained_wage 保留工资
 * @property float $compensation 套级补差
 * @property float $night_shift 中夜班费
 * @property float $overtime_wage 加班工资
 * @property float $seniority_wage 年功工资
 * @property float $jbylj 基本养老金
 * @property float $zj 增机
 * @property float $gjxj 国家小计
 * @property float $dfxj 地方小计
 * @property float $hyxj 行业小计
 * @property float $qydzf 企业独子费
 * @property float $qyxj 企业小计
 * @property float $ltxbc 离退休补充
 * @property float $wage_total 应发工资
 * @property float $month_bonus 月奖
 * @property float $communication 通讯补贴
 * @property float $traffic 交通费
 * @property float $housing 住房补贴
 * @property float $single 独子费
 * @property float $reissue_wage 补发工资
 * @property float $reissue_subsidy 补发补贴
 * @property float $reissue_other 补发其他
 * @property float $reissue_total 补发合计
 * @property float $gjj_person 公积金个人
 * @property float $gjj_enterprise 公积企业缴
 * @property float $annuity_person 年金个人
 * @property float $annuity_enterprise 年金企业缴
 * @property float $retire_person 退养金个人
 * @property float $retire_enterprise 退养企业缴
 * @property float $medical_person 医保金个人
 * @property float $medical_enterprise 医疗企业缴
 * @property float $unemployment_person 失业金个人
 * @property float $unemployment_enterprise 失业企业缴
 * @property float $injury_enterprise 工伤企业缴
 * @property float $birth_enterprise 生育企业缴
 * @property float $cc_water 成钞水费
 * @property float $cc_electric 成钞电费
 * @property float $xy_water 鑫源水费
 * @property float $xy_electric 鑫源电费
 * @property float $garage_water 车库水费
 * @property float $garage_electric 车库电费
 * @property float $back_water 退补水费
 * @property float $back_electric 退补电费
 * @property float $water_electric 水电
 * @property float $property_fee 物管费
 * @property float $union_deduction 扣工会会费
 * @property float $car_fee 公车费用
 * @property float $fixed_deduction 固定扣款
 * @property float $temp_deduction 临时扣款
 * @property float $other_deduction 其他扣款
 * @property float $prior_deduction 上期余欠款
 * @property float $had_debt 已销欠款
 * @property float $debt 扣欠款
 * @property float $tax_diff 税差
 * @property float $personal_tax 个人所得税
 * @property float $instead_salary 代汇
 * @property float $bank_salary 银行发放
 * @property float $debt_salary 余欠款
 * @property float $court_salary 法院转提
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereAnnuityEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereAnnuityPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereBackElectric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereBackWater($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereBankSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereBirthEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereCarFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereCcElectric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereCcWater($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereCommunication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereCompensation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereCourtSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereDebt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereDebtSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereDfxj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereFixedDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereGarageElectric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereGarageWater($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereGjjEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereGjjPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereGjxj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereHadDebt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereHousing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereHyxj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereInjuryEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereInsteadSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereJbylj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereLtxbc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereMedicalEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereMedicalPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereMonthBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereNightShift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereOtherDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereOvertimeWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic wherePersonalTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic wherePriorDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic wherePropertyFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereQydzf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereQyxj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereReissueOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereReissueSubsidy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereReissueTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereReissueWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereRetainedWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereRetireEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereRetirePerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereSeniorityWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereSingle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereTaxDiff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereTempDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereTraffic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereUnemploymentEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereUnemploymentPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereUnionDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereWageTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereWaterElectric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereXyElectric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereXyWater($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereZj($value)
 */
class VoucherStatistic extends Model
{
    public $table = 'voucher_statistic';

    protected $fillable = [
        'period_id', 'dwdm', 'sum_number',
    ];
}
