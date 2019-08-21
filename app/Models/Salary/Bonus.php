<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    protected $table = 'bonus';

    protected $fillable = [
        'username', 'policyNumber', 'period_id',
        'month_bonus', 'special', 'competition', 'class_reward', 'holiday',
        'party_reward', 'union_paying', 'other_reward', 'bonus_total',
    ];
}
