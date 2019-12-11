<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\Reissue.
 *
 * @property int                             $id
 * @property string                          $policyNumber    保险编号
 * @property int                             $period_id       会计期ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float                           $reissue_wage    补发工资
 * @property float                           $reissue_subsidy 补发补贴
 * @property float                           $reissue_other   补发其他
 * @property float                           $reissue_total   补发合计.补发合计=补发工资+补发补贴+补发其他
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Reissue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Reissue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Reissue query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Reissue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Reissue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Reissue wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Reissue wherePolicyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Reissue whereReissueOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Reissue whereReissueSubsidy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Reissue whereReissueTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Reissue whereReissueWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Reissue whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Reissue extends Model
{
    protected $table = 'reissue';

    // 所有字段都可以批量赋值
    protected $guarded = [];
}
