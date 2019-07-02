<?php

namespace App\Models\WorkFlow;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WorkFlow\WorkFlow
 *
 * @property int $id
 * @property string $title 工作流程名称
 * @property int $category_id 流程对应的薪酬分类
 * @property int $statusCode 工作流程状态:详细见状态表
 * @property int $createdUser 工作流程创建人ID
 * @property string|null $fileUrl 流程对应文件存放的地址
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WorkFlow\WorkFlowLog[] $logs
 * @property-read \App\Models\WorkFlow\WorkFlowStatus $status
 * @property-read \App\Models\Category $type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Salary\VarSalary[] $varSalary
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow whereCreatedUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow whereFileUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow whereStatusCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkFlow\WorkFlow whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WorkFlow extends Model
{
    protected $table = 'workflows';

    protected $fillable = [
        'title', 'category_id', 'statusCode', 'createdUser', 'fileUrl'
    ];

    // 一对多。一个流程对应多个操作日志
    public function logs()
    {
        return $this->hasMany(WorkFlowLog::class, 'wf_id', 'id');
    }

    // 多对一。多个流程属于一个薪酬分类
    public function type()
    {
        return $this->belongsTo(Category::class, 'id', 'category_id');
    }

    // 一对一。一个流程对应一个状态
    public function status()
    {
        return $this->belongsTo(WorkFlowStatus::class, 'statusCode', 'statusCode');
    }
}
