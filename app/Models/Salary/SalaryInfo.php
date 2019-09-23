<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\SalaryInfo.
 *
 * @property int $id
 * @property int $period_id    会计期ID
 * @property int $user_id      上传人员ID
 * @property string $upload_file  上传文件路径
 * @property string $published_at 发放时间
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryInfo wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryInfo wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryInfo whereUploadFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryInfo whereUserId($value)
 * @mixin \Eloquent
 */
class SalaryInfo extends Model
{
    protected $table = 'salary_info';

    protected $fillable = [
        'period_id', 'user_id', 'upload_file', 'published_at',
    ];
}
