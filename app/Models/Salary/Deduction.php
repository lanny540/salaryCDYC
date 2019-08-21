<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    protected $table = 'deduction';

    protected $fillable = [
        'username', 'policyNumber', 'period_id',
        'garage_water', 'garage_electric', 'garage_property', 'cc_water', 'cc_electric', 'cc_property',
        'xy_water', 'xy_electric', 'xy_property', 'back_water', 'back_electric', 'back_property',
        'water_electric', 'property_fee',
        'car_fee', 'fixed_deduction', 'other_deduction', 'temp_deduction', 'union_deduction', 'prior_deduction',
        'had_debt', 'debt', 'donate', 'tax_diff', 'personal_tax', 'deduction_total',
    ];
}
