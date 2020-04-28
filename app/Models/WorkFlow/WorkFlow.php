<?php

namespace App\Models\WorkFlow;

use App\Models\Salary\BonusDetail;
use App\Models\Users\UserProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\WorkFlow\WorkFlow
 *
 * @property int $id
 * @property string $name 流程名称
 * @property int $uploader 上传用户ID
 * @property string|null $upload_file 上传文件地址
 * @property int $isconfirm 上传数据是否被财务确认
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Salary\BonusDetail[] $details
 * @property-read int|null $details_count
 * @property-read \App\Models\Users\UserProfile $userprofile
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow whereIsconfirm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow whereUploadFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow whereUploader($value)
 * @mixin \Eloquent
 */
class WorkFlow extends Model
{
    use SoftDeletes;

    protected $table = 'workflows';

    // 所有字段都可以批量赋值
    protected $guarded = [];

    public function details()
    {
        return $this->hasMany(BonusDetail::class, 'wf_id', 'id');
    }

    public function userprofile()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'uploader');
    }
}
