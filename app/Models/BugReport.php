<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BugReport.
 *
 * @property int                             $id
 * @property string                          $reportType 报告分类
 * @property string                          $content    报告内容
 * @property string|null                     $contact    联系
 * @property string|null                     $screenShot 截图地址
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BugReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BugReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BugReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BugReport whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BugReport whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BugReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BugReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BugReport whereReportType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BugReport whereScreenShot($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BugReport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BugReport extends Model
{
    protected $table = 'bugReports';

    protected $fillable = ['reportType', 'content', 'contact', 'screenShot'];
}
