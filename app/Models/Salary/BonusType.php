<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary\BonusType
 *
 * @property int|null $id 对应角色ID
 * @property string $type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Salary\BonusDetail[] $details
 * @property-read int|null $details_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Salary\BonusType whereType($value)
 * @mixin \Eloquent
 */
class BonusType extends Model
{
    protected $table = 'bonus_type';

    // 所有字段都可以批量赋值
    protected $guarded = [];

    public function details()
    {
        return $this->hasMany(BonusDetail::class, 'type_id', 'id');
    }
}
