<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Users\UserRemitting.
 *
 * @property int                             $id
 * @property int                             $user_id        用户ID，外键
 * @property string                          $remit_card_no  代汇卡号
 * @property string                          $remit_name     代汇姓名
 * @property string                          $remit_bank     代汇开户行
 * @property string                          $remit_bank_no  代汇行号
 * @property string                          $remit_province 代汇省份
 * @property string                          $remit_city     代汇市
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserRemitting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserRemitting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserRemitting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserRemitting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserRemitting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserRemitting whereRemitBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserRemitting whereRemitBankNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserRemitting whereRemitCardNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserRemitting whereRemitCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserRemitting whereRemitName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserRemitting whereRemitProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserRemitting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Users\UserRemitting whereUserId($value)
 * @mixin \Eloquent
 */
class UserRemitting extends Model
{
    protected $table = 'card_info';

    protected $fillable = [
        'user_id', 'remit_card_no', 'remit_name', 'remit_bank', 'remit_bank_no',
        'remit_province', 'remit_city',
    ];
}
