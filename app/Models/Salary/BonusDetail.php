<?php

namespace App\Models\Salary;

use App\Models\Users\UserProfile;
use App\Models\WorkFlow\WorkFlow;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\BonusDetail
 *
 * @property int $id
 * @property int $wf_id 流程ID
 * @property int $type_id 类型ID
 * @property string $policynumber 保险编号
 * @property int $period_id 会计期ID
 * @property float $money 金额
 * @property string $remarks 备注
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Salary\BonusType $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusDetail whereMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusDetail wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusDetail wherePolicynumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusDetail whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusDetail whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusDetail whereWfId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Users\UserProfile $userprofile
 * @property-read \App\Models\WorkFlow\WorkFlow $workflow
 * @property string|null $card 卡号
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusDetail whereCard($value)
 */
class BonusDetail extends Model
{
    protected $table = 'bonus_detail';

    // 所有字段都可以批量赋值
    protected $guarded = [];

    public function type()
    {
        return $this->hasOne(BonusType::class, 'id', 'type_id');
    }

    public function userprofile()
    {
        return $this->hasOne(UserProfile::class, 'policyNumber', 'policynumber');
    }

    public function workflow()
    {
        return $this->hasOne(WorkFlow::class, 'id', 'wf_id');
    }
}
