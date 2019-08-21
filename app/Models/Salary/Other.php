<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

class Other extends Model
{
    protected $table = 'other';

    protected $fillable = [
        'username', 'policyNumber', 'period_id',
        'finance_article', 'union_article', 'article_fee', 'article_add_tax', 'article_sub_tax',
        'franchise', 'franchise_add_tax', 'franchise_sub_tax',
        'labour', 'labour_add_tax', 'labour_sub_tax',
    ];
}
