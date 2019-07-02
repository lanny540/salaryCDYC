<?php

namespace App\Models\WorkFlow;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WorkFlow\WorkFlowStatus
 *
 * @property int $statusCode 工作流程状态:1未发起;2等待部门审核;3等待财务工资岗审核;4等待财务领导审核;9流程已办结
 * @property string $description 状态描述
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlowStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlowStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlowStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlowStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlowStatus whereStatusCode($value)
 * @mixin \Eloquent
 */
class WorkFlowStatus extends Model
{
    protected $table = 'workFlowStatus';

    protected $fillable = ['statusCode', 'description'];
}
