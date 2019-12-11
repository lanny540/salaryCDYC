<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\Bonus.
 *
 * @property int                             $id
 * @property string                          $policyNumber 保险编号
 * @property int                             $period_id    会计期ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float                           $month_bonus  月奖
 * @property float                           $special      专项奖
 * @property float                           $competition  劳动竞赛
 * @property float                           $class_reward 课酬
 * @property float                           $holiday      节日慰问费
 * @property float                           $party_reward 党员奖励
 * @property float                           $union_paying 工会发放
 * @property float                           $other_reward 其他奖励
 * @property float                           $bonus_total  奖金合计.奖金合计=月奖+工会发放+专项奖+课酬+劳动竞赛+节日慰问费+党员奖励+其他奖励
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereBonusTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereClassReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereCompetition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereHoliday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereMonthBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereOtherReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus wherePartyReward($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus wherePolicyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereSpecial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereUnionPaying($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Bonus extends Model
{
    protected $table = 'bonus';

    // 所有字段都可以批量赋值
    protected $guarded = [];
}
