<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

class Wage extends Model
{
    protected $table = 'wage';

    protected $fillable = [
        'username', 'policyNumber', 'period_id',
        'annual_standard', 'wage_standard', 'wage_daily', 'sick_sub', 'leave_sub', 'baby_sub',
        'annual', 'wage', 'retained_wage', 'compensation', 'night_shift', 'overtime_wage', 'seniority_wage',
        'lggw', 'lgbl', 'lgzj', 'lgng', 'jbylj', 'zj',
        'gjbt', 'gjsh', 'gjxj', 'dflc', 'dfqt', 'dfwb', 'dfsh', 'dfxj',
        'hygl', 'hytb', 'hyqt', 'hyxj', 'tcxj', 'qylc', 'qygl', 'qysb', 'qysd', 'qysh',
        'qydzf', 'qyhlf', 'qytxf', 'qygfz', 'qygl2', 'qyntb', 'qybf', 'qyxj',
        'ltxbc', 'bc', 'yfct', 'yfnt', 'wage_total',
    ];
}
