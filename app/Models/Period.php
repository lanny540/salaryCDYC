<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Period.
 *
 * @property int         $id
 * @property string      $startdate 周期开始时间
 * @property string|null $enddate   周期结束时间
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Period newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Period newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Period query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Period whereEnddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Period whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Period whereStartdate($value)
 * @mixin \Eloquent
 *
 * @property string $published_at 发放日期
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Period wherePublishedAt($value)
 */
class Period extends Model
{
    public $timestamps = false;
    protected $table = 'periods';
    protected $fillable = [
        'published_at', 'startdate', 'enddate',
    ];
}
