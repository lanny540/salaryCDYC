<?php

namespace App\Models\WorkFlow;

use App\Models\Users\UserProfile;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WorkFlow\WorkFlowLog
 *
 * @property int $id
 * @property int $wf_id 工作流程ID，外键
 * @property int $user_id 流程处理人ID
 * @property string $action 流程操作动作：审核、退回
 * @property string|null $content 流程处理意见
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Users\UserProfile $userprofile
 * @property-read \App\Models\WorkFlow\WorkFlow $workflow
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlowLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlowLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlowLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlowLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlowLog whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlowLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlowLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlowLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlowLog whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlowLog whereWfId($value)
 * @mixin \Eloquent
 */
class WorkFlowLog extends Model
{
    protected $table = 'workFlowLogs';

    protected $fillable = [
        'wf_id', 'user_id', 'action', 'content'
    ];

    // 一对多逆向。
    public function workflow()
    {
        return $this->belongsTo(WorkFlow::class);
    }

    //一对一。一条日志对应一个办理人员
    public function userprofile()
    {
        return $this->belongsTo(UserProfile::class, 'user_id', 'user_id');
    }
}
