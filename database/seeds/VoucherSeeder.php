<?php

use App\Models\Voucher\VoucherData;
use App\Models\Voucher\VoucherInfo;
use App\Models\Voucher\VoucherTemplate;
use App\Models\Voucher\VoucherType;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $date = \Carbon\Carbon::now();
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        VoucherType::truncate();
        VoucherInfo::truncate();
        VoucherTemplate::truncate();
        VoucherData::truncate();

        $types = [
            ['tname' => '工资薪金凭证', 'tdescription' => '薪酬相关凭证'],
        ];

        VoucherType::insert($types);

        $vouchers = [
            ['name' => '工资发放', 'type_id' => 1, 'description' => '工资发放', 'created_at' => $date, 'updated_at' => $date],
            ['name' => '其他工资', 'type_id' => 1, 'description' => '其他工资', 'created_at' => $date, 'updated_at' => $date],
            ['name' => '关联方', 'type_id' => 1, 'description' => '关联方', 'created_at' => $date, 'updated_at' => $date],
            ['name' => '年金', 'type_id' => 1, 'description' => '年金', 'created_at' => $date, 'updated_at' => $date],
            ['name' => '退养金', 'type_id' => 1, 'description' => '退养金', 'created_at' => $date, 'updated_at' => $date],
            ['name' => '公积金', 'type_id' => 1, 'description' => '公积金', 'created_at' => $date, 'updated_at' => $date],
            ['name' => '保险费', 'type_id' => 1, 'description' => '保险费', 'created_at' => $date, 'updated_at' => $date],
            ['name' => '计提费用', 'type_id' => 1, 'description' => '计提费用', 'created_at' => $date, 'updated_at' => $date],
            ['name' => '分配表', 'type_id' => 1, 'description' => '分配表', 'created_at' => $date, 'updated_at' => $date],
        ];

        VoucherInfo::insert($vouchers);

//        $templates = [
//            ['vid' => 1, 'subject_name' => '', 'subject_no' => '', 'isLoan' => 1, 'subject_description' => '', 'created_at' => $date, 'updated_at' => $date],
//        ];
//
//        VoucherTemplate::insert($templates);
    }
}
