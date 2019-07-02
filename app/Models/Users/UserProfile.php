<?php

namespace App\Models\Users;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Users\UserProfile
 *
 * @property int $user_id 用户ID，外键
 * @property string $userName 姓名
 * @property string|null $sex 性别
 * @property int $department_id 部门ID
 * @property string $uid 身份证
 * @property string|null $mobile 手机
 * @property string|null $phone 电话
 * @property string|null $address 住址
 * @property string $policyNumber 保险编号
 * @property string $wageCard 工资卡
 * @property string $bonusCard 奖金卡
 * @property int $flag 非工行工资卡标识符. 0 工行卡 1 非工行卡
 * @property string $status 员工状态:在职、离职、行业内交流
 * @property string|null $hiredate 入职时间
 * @property string|null $departure 离职时间
 * @property int $handicapped 是否残疾人. 0 否 1 是
 * @property float $tax_rebates 减免税率
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Department $department
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile whereBonusCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile whereDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile whereHandicapped($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile whereHiredate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile wherePolicyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile whereTaxRebates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserProfile whereWageCard($value)
 * @mixin \Eloquent
 */
class UserProfile extends Model
{
    protected $table = 'userProfile';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id', 'userName', 'sex', 'department_id',
        'uid', 'mobile', 'phone', 'address',
        'policyNumber', 'wageCard', 'bonusCard',
        'flag', 'status', 'hiredate', 'departure',
        'handicapped', 'tax_rebates'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
