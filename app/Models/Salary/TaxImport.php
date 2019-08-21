<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\TaxImport
 *
 * @property int $id
 * @property string $username 人员姓名
 * @property string $policyNumber 保险编号
 * @property int $period_id 会计期ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float $income 累计收入额
 * @property float $deduct_expenses 累减除费用
 * @property float $special_deduction 累计专项扣
 * @property float $tax_child 累专附子女
 * @property float $tax_old 累专附老人
 * @property float $tax_edu 累专附继教
 * @property float $tax_loan 累专附房利
 * @property float $tax_rent 累专附房租
 * @property float $tax_other_deduct 累其他扣除
 * @property float $deduct_donate 累计扣捐赠
 * @property float $tax_income 累税所得额
 * @property float $taxrate 税率
 * @property float $quick_deduction 速算扣除数
 * @property float $taxable 累计应纳税
 * @property float $tax_reliefs 累计减免税
 * @property float $should_deducted_tax 累计应扣税
 * @property float $have_deducted_tax 累计申扣税
 * @property float $should_be_tax 累计应补税
 * @property float $reduce_tax 减免个税
 * @property float $prior_had_deducted_tax 上月已扣税
 * @property float $declare_tax 申报个税
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereDeclareTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereDeductDonate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereDeductExpenses($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereHaveDeductedTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport wherePolicyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport wherePriorHadDeductedTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereQuickDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereReduceTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereShouldBeTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereShouldDeductedTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereSpecialDeduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereTaxChild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereTaxEdu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereTaxIncome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereTaxLoan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereTaxOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereTaxOtherDeduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereTaxReliefs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereTaxRent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereTaxable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereTaxrate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\TaxImport whereUsername($value)
 * @mixin \Eloquent
 */
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
