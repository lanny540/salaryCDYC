<?php

namespace App\Models\Voucher;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Voucher\VoucherTemplate.
 *
 * @property int                             $id
 * @property int                             $vid                 凭证ID
 * @property string                          $subject_name        科目名称
 * @property string                          $subject_no          科目编码
 * @property int                             $isLoan              借贷标识.借 0 贷 1.
 * @property string                          $subject_description 科目描述
 * @property string                          $subject_method      计算方法.暂时不用
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherTemplate newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Voucher\VoucherTemplate onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherTemplate query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherTemplate whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherTemplate whereIsLoan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherTemplate whereSubjectDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherTemplate whereSubjectMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherTemplate whereSubjectName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherTemplate whereSubjectNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherTemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Voucher\VoucherTemplate whereVid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Voucher\VoucherTemplate withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Voucher\VoucherTemplate withoutTrashed()
 * @mixin \Eloquent
 */
class VoucherTemplate extends Model
{
    use SoftDeletes;

    public $table = 'voucher_template';
}
