<?php

namespace App\Http\Controllers;

use App\Models\Subject;

class TempController extends Controller
{
    public function test()
    {
//        error_reporting(E_ALL);
//        ini_set('display_errors', 'On');
//
//        $username = env('DB_ORACLE_USERNAME');
//        $password = env('DB_ORACLE_PASSWORD');
//        $database = env('DB_ORACLE_DATABASE');
//
//        $query = 'select * from subject ORDER BY ID';
//
//        $c = oci_connect($username, $password, $database, 'AL32UTF8');
//         if (!$c) {
//             $m = oci_error();
//             trigger_error('Could not connect to database: '.$m['message'], E_USER_ERROR);
//         }
//
//        $s = oci_parse($c, $query);
//         if (!$s) {
//             $m = oci_error($c);
//             trigger_error('Could not parse statement: '.$m['message'], E_USER_ERROR);
//         }
//
//        $r = oci_execute($s);
//        if (!$r) {
//            $m = oci_error($s);
//            trigger_error('Could not execute statement: '.$m['message'], E_USER_ERROR);
//        }
//
//        $temp = [];
//        $nrow = oci_fetch_all($s, $results);
//
//        if ($nrow > 0) {
//            for ($i = 0; $i < $nrow; ++$i) {
//                $temp[$i]['subject_no'] = $results['SUBJECT_NO'][$i];
//                $temp[$i]['subject_name'] = $results['SUBJECT_NAME'][$i];
//                $temp[$i]['subject_type'] = $results['SUBJECT_TYPE'][$i];
//            }
//        }
//
//        oci_free_statement($s);
//        oci_close($c);
//
//        Subject::insert($temp);
//
//        return $temp;
        return 'test';
    }
}
