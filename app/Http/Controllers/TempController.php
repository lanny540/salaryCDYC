<?php

namespace App\Http\Controllers;

use App\Models\Voucher\VoucherData;
use DB;

class TempController extends Controller
{
    public function test()
    {
        $sqlstring = 'SELECT ROUND(a.money * b.rate * '. '0.02' .', 2) AS money FROM ';
        $sqlstring .= '(SELECT SUM(wage) AS money FROM view_fenpei_total WHERE period_id = '. '13' .') a, ';
        $sqlstring .= "(SELECT SUM(rate) AS rate FROM view_fenpei_total WHERE period_id = ". '13' ." AND dwdm = '". '0101010902' ."') b";

//        return DB::selectOne($sqlstring, [0.02, 13, 13, '0101010902'])->money;
        return DB::select($sqlstring);

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
