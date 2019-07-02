<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\Deduction
 *
 * @property int $id
 * @property string $username 人员姓名
 * @property string $policyNumber 保险编号
 * @property float $deduction 扣款金额
 * @property string $comment 扣款备注
 * @property int $type_id 扣款类别
 * @property int $period_id 会计期ID
 * @property string|null $upload_files 上传文件地址
 * @property int $user_id 上传人员ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Salary\DeductionType $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction wherePolicyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereUploadFiles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Deduction whereUsername($value)
 * @mixin \Eloquent
 */
class Deduction extends Model
{
    protected $table = 'deductions';

    protected $fillable = [
        'username', 'policyNumber',
        'deduction', 'comment', 'type_id',
        'period_id', 'upload_files', 'user_id'
    ];

    public function type()
    {
        return $this->belongsTo(DeductionType::class, 'type_id', 'id');
    }
}
