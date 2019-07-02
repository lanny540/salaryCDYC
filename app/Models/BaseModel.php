<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
 * 新创建了一个基类
 * 作用是 with 查询时直接传入需要查询的字段
 * 如果需要此功能，则继承此类
 * 使用方法：
 * $topics = Topic::limit(2)->withOnly('user', ['username'])->get();
 */
/**
 * App\Models\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withOnly($relation, $columns)
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    public function scopeWithOnly($query, $relation, Array $columns)
    {
        return $query->with([$relation => function($query) use ($columns) {
            $query->select(array_merge($columns));
        }]);
    }
}
