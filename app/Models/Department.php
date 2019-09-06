<?php

namespace App\Models;

use App\Models\Users\UserProfile;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Department.
 *
 * @property int                                                                      $id
 * @property string                                                                   $name       部门名称
 * @property string                                                                   $dwdm       部门编码
 * @property int                                                                      $weight     排序
 * @property int                                                                      $level      层级
 * @property \Illuminate\Support\Carbon|null                                          $created_at
 * @property \Illuminate\Support\Carbon|null                                          $updated_at
 * @property \App\Models\Users\UserProfile[]|\Illuminate\Database\Eloquent\Collection $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereDwdm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereWeight($value)
 * @mixin \Eloquent
 * @property int $pid 父节点ID
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department wherePid($value)
 * @property-read int|null $users_count
 */
class Department extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'name', 'dwdm', 'weight', 'level', 'pid',
    ];

    public function users()
    {
        return $this->hasMany(UserProfile::class, 'department_id', 'id');
    }
}
