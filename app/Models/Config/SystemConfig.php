<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Config\SystemConfig.
 *
 * @property int                             $id
 * @property string                          $config_key   系统常量设置key值
 * @property string                          $config_value 系统常量设置value值
 * @property string|null                     $type         常量类型
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\SystemConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\SystemConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\SystemConfig query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\SystemConfig whereConfigKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\SystemConfig whereConfigValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\SystemConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\SystemConfig whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\SystemConfig whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Config\SystemConfig whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SystemConfig extends Model
{
    protected $table = 'systemconfig';

    // 所有字段都可以批量赋值
    protected $guarded = [];
}
