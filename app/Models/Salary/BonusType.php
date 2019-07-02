<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\BonusType
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusType query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name 奖金类别名称
 * @property string $role_ids 允许使用此类别的角色
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusType whereRoleIds($value)
 * @property int $role_id 允许使用此类别的角色
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusType whereRoleId($value)
 */
class BonusType extends Model
{
    protected $table = 'bonus_types';

    protected $fillable = ['name', 'role_ids'];
}
