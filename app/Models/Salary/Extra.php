<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\Extra.
 *
 * @property int                             $id
 * @property string                          $username       人员姓名
 * @property string                          $policyNumber   保险编号
 * @property int                             $period_id      会计期ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float                           $extra_column1
 * @property float                           $extra_column2
 * @property float                           $extra_column3
 * @property float                           $extra_column4
 * @property float                           $extra_column5
 * @property float                           $extra_column6
 * @property float                           $extra_column7
 * @property float                           $extra_column8
 * @property float                           $extra_column9
 * @property float                           $extra_column10
 * @property float                           $extra_column11
 * @property float                           $extra_column12
 * @property float                           $extra_column13
 * @property float                           $extra_column14
 * @property float                           $extra_column15
 * @property float                           $extra_column16
 * @property float                           $extra_column17
 * @property float                           $extra_column18
 * @property float                           $extra_column19
 * @property float                           $extra_column20
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn11($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn12($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn13($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn14($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn15($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn16($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn17($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn18($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn19($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn20($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn8($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereExtraColumn9($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra wherePolicyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Extra whereUsername($value)
 * @mixin \Eloquent
 */
class Extra extends Model
{
    protected $table = 'extra';

    protected $fillable = [
        'username', 'policyNumber', 'period_id',
        'extra_column1', 'extra_column2', 'extra_column3', 'extra_column4', 'extra_column5',
        'extra_column6', 'extra_column7', 'extra_column8', 'extra_column9', 'extra_column10',
        'extra_column11', 'extra_column12', 'extra_column13', 'extra_column14', 'extra_column15',
        'extra_column16', 'extra_column17', 'extra_column18', 'extra_column19', 'extra_column20',
    ];
}
