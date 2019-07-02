<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\Property
 *
 * @property int $id
 * @property string $username 人员姓名
 * @property string $policyNumber 保险编号
 * @property float $cc_water 成钞水量
 * @property float $cc_water_rate 成钞水费
 * @property float $cc_electricity 成钞电费
 * @property float $cc_property 成钞物管
 * @property float $xy_water 鑫源水量
 * @property float $xy_water_rate 鑫源水费
 * @property float $xy_electricity 鑫源电费
 * @property float $xy_property 鑫源物管
 * @property float $utilities 水电
 * @property float $property_fee 物管费
 * @property float $property_back 物业退补费
 * @property int $period_id 会计期ID
 * @property string|null $upload_files 上传文件地址
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id 上传人员ID
 * @property-read mixed $sum_property
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property whereCcElectricity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property whereCcProperty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property whereCcWater($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property whereCcWaterRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property wherePolicyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property wherePropertyBack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property wherePropertyFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property whereUploadFiles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property whereUtilities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property whereXyElectricity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property whereXyProperty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property whereXyWater($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Property whereXyWaterRate($value)
 * @mixin \Eloquent
 */
class Property extends Model
{
    protected $table = 'property';

//    protected $fillable = [
//        'username', 'policyNumber',
//        'cc_water', 'cc_water_rate', 'cc_electricity', 'cc_property',
//        'xy_water', 'xy_water_rate', 'xy_electricity', 'xy_property',
//        'utilities', 'property_fee', 'property_back',
//        'period_id', 'upload_files', 'user_id'
//    ];

    // 追加物业费合计属性
    protected $appends = ['sum_property'];

    public function getSumPropertyAttribute()
    {
        $sum['cc_water'] = $this->attributes['cc_water'];
        $sum['cc_water_rate'] = $this->attributes['cc_water_rate'];
        $sum['cc_electricity'] = $this->attributes['cc_electricity'];
        $sum['cc_property'] = $this->attributes['cc_property'];

        $sum['xy_water'] = $this->attributes['xy_water'];
        $sum['xy_water_rate'] = $this->attributes['xy_water_rate'];
        $sum['xy_electricity'] = $this->attributes['xy_electricity'];
        $sum['xy_property'] = $this->attributes['xy_property'];

        $sum['utilities'] = $this->attributes['utilities'];
        $sum['property_fee'] = $this->attributes['property_fee'];
        $sum['property_back'] = $this->attributes['property_back'];

        return array_sum($sum);
    }

}
