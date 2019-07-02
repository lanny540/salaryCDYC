<?php

namespace App\Models\Users;

use App\Models\Salary\SalaryLog;
use App\Models\Salary\SalarySummary;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\Users\User
 *
 * @property int $id
 * @property string $name 登录名
 * @property string $password 登录密码
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \App\Models\Users\UserProfile $profile
 * @property-read \App\Models\Users\UserRemitting $remit
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Salary\SalaryLog[] $salaryLog
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Salary\SalarySummary[] $salarySummary
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    protected $fillable = [
        'name', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    //一对一。一个用户对应一个用户信息
    public function profile()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'id');
    }

    //一对一。一个用户对应一条代汇记录
    public function remit()
    {
        return $this->hasOne(UserRemitting::class, 'user_id', 'id');
    }

    //一对多。一个用户对应多条薪酬变更日志
    public function salaryLog()
    {
        return $this->hasMany(SalaryLog::class, 'user_id', 'id');
    }

    //一对多。一个用户对应多条薪酬汇总记录
    public function salarySummary()
    {
        return $this->hasMany(SalarySummary::class, 'user_id', 'id');
    }
}
