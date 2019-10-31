<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\SalaryLog.
 *
 * @property int                             $id
 * @property int                             $period_id   会计期ID
 * @property int                             $user_id     上传人员ID
 * @property int                             $upload_type 上传数据的类型， 等于角色ID
 * @property string                          $upload_file 上传文件路径
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryLog wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryLog whereUploadFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryLog whereUploadType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryLog whereUserId($value)
 * @mixin \Eloquent
 */
class SalaryLog extends Model
{
    //指定表名：
    protected $table = 'salary_log';

    //所有字段都可以批量赋值
    protected $guarded = [];

    //自动维护时间戳：
    public $timestamps = true;
}
