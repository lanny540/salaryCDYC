<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\Other
 *
 * @property int $id
 * @property string $username 人员姓名
 * @property string $policyNumber 保险编号
 * @property float $otherSalary 其他费用金额
 * @property string $comment 其他费用备注
 * @property int $type_id 其他费用类别
 * @property int $period_id 会计期ID
 * @property string|null $upload_files 上传文件地址
 * @property int $user_id 上传人员ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Salary\OtherType $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereOtherSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other wherePolicyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereUploadFiles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereUsername($value)
 * @mixin \Eloquent
 */
class Other extends Model
{
    protected $table = 'othersalary';

    protected $fillable = [
        'username', 'policyNumber',
        'otherSalary', 'comment', 'type_id',
        'period_id', 'upload_files', 'user_id'
    ];

    public function type()
    {
        return $this->belongsTo(OtherType::class, 'type_id', 'id');
    }
}
