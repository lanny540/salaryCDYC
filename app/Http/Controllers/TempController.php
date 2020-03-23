<?php

namespace App\Http\Controllers;

use App\Models\Voucher\VoucherData;

class TempController extends Controller
{
    public function test()
    {
        $res = VoucherData::where('vid', 1)->where('period_id', 9)
            ->select(['vdata'])->first();

        return $res['vdata'][0]['id'];
    }

    public function excel()
    {
        return response()->json([
            'id' => 1,
            'policynumber' => 54002669,
            'validate' => true,
        ]);
    }
}
