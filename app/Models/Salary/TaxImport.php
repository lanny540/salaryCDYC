<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

class TaxImport extends Model
{
    protected $table = 'taxImport';

    protected $fillable = [
        'username', 'policyNumber', 'period_id',
        'income', 'deduct_expenses', 'special_deduction',
        'tax_child', 'tax_old', 'tax_edu', 'tax_loan', 'tax_rent', 'tax_other_deduct',
        'deduct_donate', 'tax_income', 'taxrate', 'quick_deduction', 'taxable', 'tax_reliefs',
        'should_deducted_tax', 'have_deducted_tax', 'should_be_tax',
        'reduce_tax', 'prior_had_deducted_tax', 'declare_tax',
    ];
}
