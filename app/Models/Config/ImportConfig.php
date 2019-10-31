<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Config\ImportConfig
 *
 * @property int $id
 * @property int $role_id 角色ID
 * @property string $db_column 数据表中的字段
 * @property string $human_column 显示的字段
 * @property string $excel_column excel读取的字段
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\ImportConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\ImportConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\ImportConfig query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\ImportConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\ImportConfig whereDbColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\ImportConfig whereExcelColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\ImportConfig whereHumanColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\ImportConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\ImportConfig whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\ImportConfig whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ImportConfig extends Model
{
    protected $table = 'importconfig';

    // 所有字段都可以批量赋值
    protected $guarded = [];
}
