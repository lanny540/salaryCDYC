<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\OtherType
 *
 * @property int $id
 * @property string $name 其他费用类别名称
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\OtherType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\OtherType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\OtherType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\OtherType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\OtherType whereName($value)
 * @mixin \Eloquent
 * @property int $role_id 允许使用此类别的角色
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\OtherType whereRoleId($value)
 */
class OtherType extends Model
{
    protected $table = 'other_types';

    protected $fillable = ['name'];
}
