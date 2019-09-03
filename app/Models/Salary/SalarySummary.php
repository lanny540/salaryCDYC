<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\SalarySummary.
 *
 * @property int                             $id
 * @property string                          $username             人员姓名
 * @property string                          $policyNumber         保险编号
 * @property int                             $period_id            会计期ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float                           $wage_total           应发工资.应发工资=年薪工资+岗位工资+保留工资+套级补差+中夜班费+加班工资+年功工资+基本养老金+增机+国家小计+地方小计+行业小计+企业小计+离退休补充+补偿
 * @property float                           $bonus_total          奖金合计.奖金合计=月奖+工会发放+专项奖+课酬+劳动竞赛+节日慰问费+党员奖励+其他奖励
 * @property float                           $subsidy_total        补贴合计.补贴合计=交通费+住房补贴+独子费
 * @property float                           $reissue_total        补发合计.补发合计=补发工资+补发补贴+补发其他
 * @property float                           $should_total         应发合计.应发合计=应发工资+应发辞退+应发内退+补贴合计+补发合计
 * @property float                           $enterprise_out_total 企业超合计.企业超合计=公积企超标+失业企超标+医保企超标+年金企超标+退养企超标
 * @property float                           $salary_total         工资薪金.工资薪金=应发合计+奖金合计+企业超合计
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereBonusTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereEnterpriseOutTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary wherePolicyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereReissueTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereSalaryTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereShouldTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereSubsidyTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\SalarySummary whereWageTotal($value)
 * @mixin \Eloquent
 */
class SalarySummary extends Model
{
    protected $table = 'summary';

    protected $fillable = [
        'username', 'policyNumber', 'period_id',
        'wage_total', 'bonus_total', 'subsidy_total', 'reissue_total',
        'should_total', 'enterprise_out_total', 'salary_total',
    ];
}
