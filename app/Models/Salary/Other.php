<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\Other.
 *
 * @property int                             $id
 * @property string                          $policyNumber      保险编号
 * @property int                             $period_id         会计期ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float                           $finance_article   财务发稿酬
 * @property float                           $union_article     工会发稿酬
 * @property float                           $article_fee       稿酬.稿酬=财务发稿酬+工会发稿酬
 * @property float                           $article_add_tax   稿酬应补税
 * @property float                           $article_sub_tax   稿酬减免税
 * @property float                           $franchise         特许使用权
 * @property float                           $franchise_add_tax 特权应补税
 * @property float                           $franchise_sub_tax 特权减免税
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereArticleAddTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereArticleFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereArticleSubTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereFinanceArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereFranchise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereFranchiseAddTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereFranchiseSubTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other wherePolicyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereUnionArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\Other whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Other extends Model
{
    protected $table = 'other';

    // 所有字段都可以批量赋值
    protected $guarded = [];
}
