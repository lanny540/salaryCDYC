<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\Insurances
 *
 * @property int $id
 * @property string $username 人员姓名
 * @property string $policyNumber 保险编号
 * @property int $period_id 会计期ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float $gjj_classic 公积金标准
 * @property float $gjj_add 公积金补扣
 * @property float $gjj_person 公积金个人.个人=标准+补扣
 * @property float $gjj_deduction 公积金扣除
 * @property float $gjj_enterprise 公积企业缴
 * @property float $gjj_out_range 公积企超标.超标=企业缴-企业免税扣除
 * @property float $annuity_classic 年金标准
 * @property float $annuity_add 年金补扣
 * @property float $annuity_person 年金个人
 * @property float $annuity_deduction 年金扣除
 * @property float $annuity_enterprise 年金企业缴
 * @property float $annuity_out_range 年金企超标
 * @property float $retire_classic 退养金标准
 * @property float $retire_add 退养金补扣
 * @property float $retire_person 退养金个人
 * @property float $retire_deduction 退养金扣除
 * @property float $retire_enterprise 退养企业缴
 * @property float $retire_out_range 退养企超标
 * @property float $medical_classic 医保金标准
 * @property float $medical_add 医保金补扣
 * @property float $medical_person 医保金个人
 * @property float $medical_deduction 医保金补扣
 * @property float $medical_enterprise 医疗企业缴
 * @property float $medical_out_range 医疗企超标
 * @property float $unemployment_classic 失业金标准
 * @property float $unemployment_add 失业金补扣
 * @property float $unemployment_person 失业金个人
 * @property float $unemployment_deduction 失业金扣除
 * @property float $unemployment_enterprise 失业企业缴
 * @property float $unemployment_out_range 失业企超标
 * @property float $injury_enterprise 工伤企业缴
 * @property float $birth_enterprise 生育企业缴
 * @property float $enterprise_out_total 企业超合计.企业超合计=公积企超标+失业企超标+医保企超标+年金企超标+退养企超标
 * @property float $specail_deduction 专项扣除.专项扣除=退养金扣除+医保金扣除+失业金扣除+公积金扣除
 * @property float $car_deduction 公车补扣除
 * @property float $car_deduction_comment 公车扣备注
 * @property float $rest_deduction 它项扣除
 * @property float $rest_deduction_comment 它项扣备注
 * @property float $sum_deduction 其他扣除.其他扣除=公车补扣除+它项扣除
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereAnnuityAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereAnnuityClassic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereAnnuityDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereAnnuityEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereAnnuityOutRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereAnnuityPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereBirthEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereCarDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereCarDeductionComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereEnterpriseOutTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereGjjAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereGjjClassic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereGjjDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereGjjEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereGjjOutRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereGjjPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereInjuryEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereMedicalAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereMedicalClassic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereMedicalDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereMedicalEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereMedicalOutRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereMedicalPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances wherePolicyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereRestDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereRestDeductionComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereRetireAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereRetireClassic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereRetireDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereRetireEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereRetireOutRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereRetirePerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereSpecailDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereSumDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereUnemploymentAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereUnemploymentClassic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereUnemploymentDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereUnemploymentEnterprise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereUnemploymentOutRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereUnemploymentPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Insurances whereUsername($value)
 * @mixin \Eloquent
 */
class Insurances extends Model
{
    protected $table = 'insurances';

    protected $fillable = [
        'username', 'policyNumber', 'period_id',
        'gjj_classic', 'gjj_add', 'gjj_person', 'gjj_deduction', 'gjj_enterprise', 'gjj_out_range',
        'annuity_classic', 'annuity_add', 'annuity_person', 'annuity_deduction', 'annuity_enterprise', 'annuity_out_range',
        'retire_classic', 'retire_add', 'retire_person', 'retire_deduction', 'retire_enterprise', 'retire_out_range',
        'medical_classic', 'medical_add', 'medical_person', 'medical_deduction', 'medical_enterprise', 'medical_out_range',
        'unemployment_classic', 'unemployment_add', 'unemployment_person', 'unemployment_deduction', 'unemployment_enterprise', 'unemployment_out_range',
        'injury_enterprise', 'birth_enterprise', 'enterprise_out_total', 'specail_deduction',
        'car_deduction', 'car_deduction_comment', 'rest_deduction', 'rest_deduction_comment', 'sum_deduction',
    ];
}
