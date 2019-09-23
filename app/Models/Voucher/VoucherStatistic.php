<?php

namespace App\Models\Voucher;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Voucher\VoucherStatistic
 *
 * @property int $id
 * @property int $period_id 会计期ID
 * @property string $dwdm 部门编码
 * @property int $sum_number 人数
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereDwdm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherStatistic whereSumNumber($value)
 * @mixin \Eloquent
 */
class VoucherStatistic extends Model
{
    public $table = 'voucher_statistic';

    protected $fillable = [
        'period_id', 'dwdm', 'sum_number',
    ];
}
