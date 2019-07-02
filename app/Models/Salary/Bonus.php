<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\Bonus
 *
 * @property int $id
 * @property string $username 人员姓名
 * @property string $policyNumber 保险编号
 * @property float $bonus 奖金金额
 * @property string $comment 奖金备注
 * @property int $type_id 奖金类别:1 月奖 2 专项奖 3节日慰问费
 * @property int $period_id 会计期ID
 * @property string|null $upload_files 上传文件地址
 * @property int $user_id 上传人员ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Salary\BonusType $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus wherePolicyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereUploadFiles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Bonus whereUsername($value)
 * @mixin \Eloquent
 */
class Bonus extends Model
{
    protected $table = 'bonus';

    protected $fillable = [
        'username', 'policyNumber',
        'bonus', 'comment', 'type_id',
        'period_id', 'upload_files', 'user_id'
    ];

    public function type()
    {
        return $this->belongsTo(BonusType::class, 'type_id', 'id');
    }
}
