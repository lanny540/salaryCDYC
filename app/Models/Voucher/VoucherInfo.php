<?php

namespace App\Models\Voucher;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Voucher\VoucherInfo.
 *
 * @property int                             $id
 * @property string                          $name        凭证名称
 * @property int                             $type_id     凭证类型ID
 * @property string                          $description 凭证描述
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherInfo whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherInfo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherInfo whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherInfo whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Voucher\VoucherType $types
 */
class VoucherInfo extends Model
{
    public $table = 'voucher';

    public function types()
    {
        return $this->belongsTo(VoucherType::class, 'id', 'type_id');
    }
}
