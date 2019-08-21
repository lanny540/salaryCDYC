<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

class SalarySummary extends Model
{
    protected $table = 'summary';

    protected $fillable = [
        'username', 'policyNumber', 'period_id',
        'wage_total', 'bonus_total', 'subsidy_total', 'reissue_total', 'should_total', 'enterprise_out_total', 'salary_total',
    ];
}
