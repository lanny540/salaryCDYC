<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\SalaryLog
 *
 * @property int $id
 * @property int $user_id 用户ID
 * @property string $content 薪酬变更日志
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryLog whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalaryLog whereUserId($value)
 * @mixin \Eloquent
 */
class SalaryLog extends Model
{
    protected $table = 'salaryLog';

    protected $fillable = [
        'user_id', 'content'
    ];
}
