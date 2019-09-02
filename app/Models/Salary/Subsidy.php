<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\Subsidy.
 *
 * @property int                             $id
 * @property string                          $username         人员姓名
 * @property string                          $policyNumber     保险编号
 * @property int                             $period_id        会计期ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float                           $communication    通讯补贴
 * @property float                           $traffic_standard 交通补贴标
 * @property float                           $traffic_add      交通补贴考
 * @property float                           $traffic          交通费.交通费=交通补贴标+交通补贴考
 * @property float                           $housing          住房补贴
 * @property float                           $single_standard  独子费标准
 * @property float                           $single_add       独子费补发
 * @property float                           $single           独子费.独子费=独子费标准+独子费补发
 * @property float                           $subsidy_total    补贴合计.补贴合计=交通费+住房补贴+独子费
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Subsidy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Subsidy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Subsidy query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Subsidy whereCommunication($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Subsidy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Subsidy whereHousing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Subsidy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Subsidy wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Subsidy wherePolicyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Subsidy whereSingle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Subsidy whereSingleAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Subsidy whereSingleStandard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Subsidy whereSubsidyTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Subsidy whereTraffic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Subsidy whereTrafficAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Subsidy whereTrafficStandard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Subsidy whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Subsidy whereUsername($value)
 * @mixin \Eloquent
 */
class Subsidy extends Model
{
    protected $table = 'subsidy';

    protected $fillable = [
        'username', 'policyNumber', 'period_id',
        'communication', 'traffic_standard', 'traffic_add', 'traffic',
        'housing', 'single_standard', 'single_add', 'single', 'subsidy_total',
    ];
}
