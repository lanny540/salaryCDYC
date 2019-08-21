<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

class Reissue extends Model
{
    protected $table = 'reissue';

    protected $fillable = [
        'username', 'policyNumber', 'period_id',
        'communication', 'traffic_standard', 'traffic_add', 'traffic',
        'housing', 'single_standard', 'single_add', 'single', 'subsidy_total',
    ];
}
