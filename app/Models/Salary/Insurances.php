<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

class Insurances extends Model
{
    protected $table = 'insurances';

    protected $fillable = [
        'username', 'policyNumber', 'period_id',
        'gjj_classic', 'gjj_add', 'gjj_person', 'gjj_deduction', 'gjj_enterprise', 'gjj_out_range',
        'annuity_classic', 'annuity_add', 'annuity_person', 'annuity_deduction', 'annuity_enterprise', 'annuity_out_range',
        'retire_classic', 'retire_add', 'retire_person', 'retire_deduction', 'retire_enterprise', 'retire_out_range',
        'medical_classic', 'medical_add', 'medical_person', 'medical_deduction', 'medical_enterprise', 'medical_out_range',
        'unemployment_classic', 'unemployment_add', 'unemployment_person', 'unemployment_deduction', 'unemployment_enterprise', 'unemployment_out_range',
        'injury_enterprise', 'birth_enterprise', 'enterprise_out_total', 'specail_deduction',
        'car_deduction', 'car_deduction_comment', 'rest_deduction', 'rest_deduction_comment', 'sum_deduction',
    ];
}
