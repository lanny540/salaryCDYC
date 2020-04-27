<?php

namespace App\Http\Controllers;


use App\Models\Voucher\VoucherData;

class TempController extends Controller
{
    public function test()
    {
        $data = VoucherData::where('vid', 4)
            ->where('period_id', 13)
            ->get()->toArray();

        return json_decode($data[0]['vdata'], true);
    }
}
