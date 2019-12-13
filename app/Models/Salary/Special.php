<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\Special.
 *
 * @property int                             $id
 * @property string                          $policyNumber   保险编号
 * @property int                             $period_id      会计期ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float                           $instead_salary 代汇
 * @property float                           $actual_salary  实发工资
 * @property float                           $bank_salary    银行发放
 * @property float                           $debt_salary    余欠款
 * @property float                           $court_salary   法院转提
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Special newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Special newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Special query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Special whereActualSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Special whereBankSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Special whereCourtSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Special whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Special whereDebtSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Special whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Special whereInsteadSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Special wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Special wherePolicyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Special whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Special extends Model
{
    protected $table = 'special';

    // 所有字段都可以批量赋值
    protected $guarded = [];
}
