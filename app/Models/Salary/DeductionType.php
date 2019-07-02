<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\DeductionType
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\DeductionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\DeductionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\DeductionType query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name 扣款类别名称
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\DeductionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\DeductionType whereName($value)
 * @property int $role_id 允许使用此类别的角色
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\DeductionType whereRoleId($value)
 */
class DeductionType extends Model
{
    protected $table = 'deductions_types';

    protected $fillable = ['name'];
}
