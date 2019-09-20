<?php

namespace App\Models\Voucher;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoucherTemplate extends Model
{
    use SoftDeletes;

    public $table = 'voucher_template';
}
