<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\Deduction
 *
 * @property int $id
 * @property string $username 人员姓名
 * @property string $policyNumber 保险编号
 * @property int $period_id 会计期ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float $garage_water 车库水费
 * @property float $garage_electric 车库电费
 * @property float $garage_property 车库物管
 * @property float $cc_water 成钞水费
 * @property float $cc_electric 成钞电费
 * @property float $cc_property 成钞物管
 * @property float $xy_water 鑫源水费
 * @property float $xy_electric 鑫源电费
 * @property float $xy_property 鑫源物管
 * @property float $back_water 退补水费
 * @property float $back_electric 退补电费
 * @property float $back_property 退补物管费
 * @property float $water_electric 水电
 * @property float $property_fee 物管费
 * @property float $car_fee 公车费用
 * @property float $fixed_deduction 固定扣款
 * @property float $other_deduction 其他扣款
 * @property float $temp_deduction 临时扣款
 * @property float $union_deduction 扣工会会费
 * @property float $prior_deduction 上期余欠款
 * @property float $had_debt 已销欠款
 * @property float $debt 扣欠款
 * @property float $donate 捐赠
 * @property float $tax_diff 税差
 * @property float $personal_tax 个人所得税
 * @property float $deduction_total 扣款合计
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereBackElectric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereBackProperty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereBackWater($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereCarFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereCcElectric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereCcProperty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereCcWater($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereDebt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereDeductionTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereDonate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereFixedDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereGarageElectric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereGarageProperty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereGarageWater($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereHadDebt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereOtherDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction wherePersonalTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction wherePolicyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction wherePriorDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction wherePropertyFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereTaxDiff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereTempDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereUnionDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereWaterElectric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereXyElectric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereXyProperty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereXyWater($value)
 * @mixin \Eloquent
 */
class Deduction extends Model
{
    protected $table = 'deduction';

    protected $fillable = [
        'username', 'policyNumber', 'period_id',
        'garage_water', 'garage_electric', 'garage_property', 'cc_water', 'cc_electric', 'cc_property',
        'xy_water', 'xy_electric', 'xy_property', 'back_water', 'back_electric', 'back_property',
        'water_electric', 'property_fee',
        'car_fee', 'fixed_deduction', 'other_deduction', 'temp_deduction', 'union_deduction', 'prior_deduction',
        'had_debt', 'debt', 'donate', 'tax_diff', 'personal_tax', 'deduction_total',
    ];
}
