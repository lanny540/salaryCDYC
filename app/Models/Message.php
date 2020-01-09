<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Message
 *
 * @property int $id
 * @property int $sender 发送者ID
 * @property int $receiver 接收者ID
 * @property int $type_id 消息类型：系统消息、部门消息
 * @property string $content 消息内容
 * @property string|null $attachment 附件地址
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereReceiver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereSender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message withoutTrashed()
 * @mixin \Eloquent
 * @property int $isread 是否已读.0否1是
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereIsread($value)
 */
class Message extends Model
{
    use SoftDeletes;

    public $table = 'messages';

    // 所有字段都可以批量赋值
    protected $guarded = [];
}
