<?php

namespace App\Models\Voucher;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Voucher\VoucherType.
 *
 * @property int                                                                        $id
 * @property string                                                                     $tname          凭证类型名称
 * @property string                                                                     $tdescription   凭证类型描述
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Voucher\VoucherInfo[] $vouchers
 * @property int|null                                                                   $vouchers_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherType whereTdescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherType whereTname($value)
 * @mixin \Eloquent
 */
class VoucherType extends Model
{
    public $table = 'voucher_type';

    /**
     * 一对多。一个类型对应多个凭证
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vouchers()
    {
        return $this->hasMany(VoucherInfo::class, 'type_id', 'id');
    }
}
