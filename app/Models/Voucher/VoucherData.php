<?php

namespace App\Models\Voucher;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Voucher\VoucherService.
 *
 * @property int                             $id
 * @property int                             $vid          凭证ID
 * @property int                             $period_id    会计期ID
 * @property string                          $vname        凭证名称
 * @property string                          $vcategory    凭证类别.手工转账、现金凭证、银行凭证
 * @property string                          $vuser        凭证创建人
 * @property string                          $cdate        凭证日期
 * @property string                          $period       会计周期
 * @property string                          $cgroup       凭证批组
 * @property string                          $vdescription 凭证描述
 * @property mixed                           $vdata        凭证数据
 * @property int                             $isUpload     上传成功标识. 失败 0 成功 1.
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherData query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherData whereCdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherData whereCgroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherData whereIsUpload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherData wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherData wherePeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherData whereVcategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherData whereVdata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherData whereVdescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherData whereVid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherData whereVname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherData whereVuser($value)
 * @mixin \Eloquent
 */
class VoucherData extends Model
{
    public $table = 'voucher_data';
}
