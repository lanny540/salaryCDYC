<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Subject.
 *
 * @property int                             $id
 * @property string                          $subject_no   科目编码
 * @property string                          $subject_name 科目名称
 * @property int                             $subject_type 科目类别.ERP编码分为6段，即0-5
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subject query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subject whereSubjectName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subject whereSubjectNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subject whereSubjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subject whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Subject extends Model
{
    protected $table = 'subject';

    protected $fillable = [
        'subject_no', 'subject_name', 'subject_type',
    ];
}
