<?php

namespace App\Models\Salary;

use App\Models\Users\UserProfile;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\Wage.
 *
 * @property int                             $id
 * @property string                          $policyNumber    保险编号
 * @property int                             $period_id       会计期ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float                           $annual_standard 年薪工资标
 * @property float                           $wage_standard   岗位工资标
 * @property float                           $wage_daily      岗位工资日
 * @property float                           $sick_sub        扣岗位工病
 * @property float                           $leave_sub       扣岗位工事
 * @property float                           $baby_sub        扣岗位工婴
 * @property float                           $annual          年薪工资.年薪工资=年薪工资标-扣岗位工病-扣岗位工事-扣岗位工婴
 * @property float                           $wage            岗位工资.岗位工资=岗位工资标-扣岗位工病-扣岗位工事-扣岗位工婴
 * @property float                           $retained_wage   保留工资
 * @property float                           $compensation    套级补差
 * @property float                           $night_shift     中夜班费
 * @property float                           $overtime_wage   加班工资
 * @property float                           $seniority_wage  年功工资
 * @property float                           $lggw            离岗岗位
 * @property float                           $lgbl            离岗保留
 * @property float                           $lgzj            离岗增加
 * @property float                           $lgng            离岗年功
 * @property float                           $jbylj           基本养老金.1、离岗休养人员，基本养老金=离岗岗位+离岗保留+离岗增加+离岗年功;2、其他退休人员，基本养老金直接取数
 * @property float                           $zj              增机
 * @property float                           $gjbt            国家补贴
 * @property float                           $gjsh            国家生活
 * @property float                           $gjxj            国家小计.国家小计=国家补贴+国家生活
 * @property float                           $dflc            地方粮差
 * @property float                           $dfqt            地方其他
 * @property float                           $dfwb            地方物补
 * @property float                           $dfsh            地方生活
 * @property float                           $dfxj            地方小计.地方小计=地方粮差+地方其他+地方物补+地方生活
 * @property float                           $hygl            行业工龄
 * @property float                           $hytb            行业退补
 * @property float                           $hyqt            行业其他
 * @property float                           $hyxj            行业小计.行业小计=行业工龄+行业退补+行业其他
 * @property float                           $tcxj            统筹小计.统筹小计=基本养老金+增机+国家小计+地方小计+行业小计
 * @property float                           $qylc            企业粮差
 * @property float                           $qygl            企业工龄
 * @property float                           $qysb            企业书报
 * @property float                           $qysd            企业水电
 * @property float                           $qysh            企业生活
 * @property float                           $qydzf           企业独子费
 * @property float                           $qyhlf           企业护理费
 * @property float                           $qytxf           企业通讯费
 * @property float                           $qygfz           企业规范增
 * @property float                           $qygl2           企业工龄02
 * @property float                           $qyntb           企业内退补
 * @property float                           $qybf            企业补发
 * @property float                           $qyxj            企业小计.企业小计=企业粮差+企业工龄+企业书报+企业水电+企业生活+企业独子费+企业护理费+企业工龄02+企业通讯费+企业内退补+企业规范增+企业补发
 * @property float                           $ltxbc           离退休补充
 * @property float                           $bc              补偿
 * @property float                           $wage_total      应发工资.应发工资=年薪工资+岗位工资+保留工资+套级补差+中夜班费+加班工资+年功工资+基本养老金+增机+国家小计+地方小计+行业小计+企业小计+离退休补充+补偿
 * @property float                           $yfct            应发辞退.如果dwdm="01020201",应发辞退=应发工资,应发工资=0
 * @property float                           $yfnt            应发内退.如果dwdm="01020202",应发辞退=应发工资,应发工资=0
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereAnnual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereAnnualStandard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereBabySub($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereBc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereCompensation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereDflc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereDfqt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereDfsh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereDfwb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereDfxj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereGjbt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereGjsh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereGjxj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereHygl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereHyqt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereHytb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereHyxj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereJbylj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereLeaveSub($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereLgbl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereLggw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereLgng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereLgzj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereLtxbc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereNightShift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereOvertimeWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage wherePolicyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereQybf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereQydzf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereQygfz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereQygl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereQygl2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereQyhlf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereQylc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereQyntb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereQysb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereQysd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereQysh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereQytxf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereQyxj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereRetainedWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereSeniorityWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereSickSub($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereTcxj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereWage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereWageDaily($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereWageStandard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereWageTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereYfct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereYfnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Wage whereZj($value)
 * @mixin \Eloquent
 */
class Wage extends Model
{
    protected $table = 'wage';

    // 所有字段都可以批量赋值
    protected $guarded = [];

    public function setJbyljAttribute($value)
    {
        if (0 == $value) {
            $lggw = $this->attributes['lggw'];
            $lgbl = $this->attributes['lgbl'];
            $lgzj = $this->attributes['lgzj'];
            $lgng = $this->attributes['lgng'];

            $jbylj = ($lggw * 100 + $lgbl * 100 + $lgzj * 100 + $lgng * 100) / 100;
            $this->attributes['jbylj'] = $jbylj;
        } else {
            $this->attributes['jbylj'] = $value;
        }
    }

    /**
     * 应发工资=年薪工资+岗位工资+保留工资+套级补差+中夜班费+加班工资+年功工资+统筹小计+企业小计+离退休补充+补偿.
     */
    public function setWageTotalAttribute()
    {
        $annual = $this->attributes['annual'];
        $wage = $this->attributes['wage'];
        $retained_wage = $this->attributes['retained_wage'];
        $compensation = $this->attributes['compensation'];
        $night_shift = $this->attributes['night_shift'];
        $overtime_wage = $this->attributes['overtime_wage'];
        $seniority_wage = $this->attributes['seniority_wage'];
        $tcxj = $this->attributes['tcxj'];
        $qyxj = $this->attributes['qyxj'];
        $ltxbc = $this->attributes['ltxbc'];
        $bc = $this->attributes['bc'];

        $wage_total = $annual * 100 + $wage * 100 + $retained_wage * 100 + $compensation * 100 + $night_shift * 100;
        $wage_total += $overtime_wage * 100 + $seniority_wage * 100 + $tcxj * 100 + $qyxj * 100;
        $wage_total += $ltxbc * 100 + $bc * 100;
        $wage_total = $wage_total / 100;

        $this->attributes['wage_total'] = $wage_total;
    }

    /**
     * 应发辞退.
     * 如果dwdm="01020201",应发辞退=应发工资,应发工资=0.
     */
    public function setYfctAttribute()
    {
        $policy = $this->attributes['policyNumber'];

        $department = UserProfile::where('policyNumber', $policy)->first()->department;
        $dwdm = isset($department->dwdm) ? $department->dwdm : '0101';

        if ('01020201' == $dwdm) {
            $this->attributes['yfct'] = $this->attributes['wage_total'];
            $this->attributes['wage_total'] = 0;
        } else {
            $this->attributes['yfct'] = 0;
        }
    }

    /**
     * 应发内退.
     * 如果dwdm="01020202",应发辞退=应发工资,应发工资=0.
     */
    public function setYfntAttribute()
    {
        $policy = $this->attributes['policyNumber'];

        $department = UserProfile::where('policyNumber', $policy)->first()->department;
        $dwdm = isset($department->dwdm) ? $department->dwdm : '0101';

        if ('01020202' == $dwdm) {
            $this->attributes['yfnt'] = $this->attributes['wage_total'];
            $this->attributes['wage_total'] = 0;
        } else {
            $this->attributes['yfnt'] = 0;
        }
    }
}
