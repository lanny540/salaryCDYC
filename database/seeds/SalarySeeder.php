<?php

use Illuminate\Database\Seeder;

class SalarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = \Carbon\Carbon::now();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $faker = Faker\factory::create('zh_CN');

        // 奖金类别
        \App\Models\Salary\BonusType::truncate();
        $bonus_types = [
            ['name' => '月奖', 'role_id' =>10],
            ['name' => '专项奖', 'role_id' => 12],
            ['name' => '节日慰问费', 'role_id' => 10],
            ['name' => '工会发放', 'role_id' => 11],
            ['name' => '课酬', 'role_id' => 11],
            ['name' => '劳动竞赛', 'role_id' => 12],
            ['name' => '党员奖励', 'role_id' => 11],
        ];
        \App\Models\Salary\BonusType::insert($bonus_types);

        // 扣款类别
        \App\Models\Salary\DeductionType::truncate();
        $deductions_types = [
            ['name' => '公车费用', 'role_id' => 20],
            ['name' => '固定扣款', 'role_id' => 22],
            ['name' => '其他扣款', 'role_id' => 22],
            ['name' => '临时扣款', 'role_id' => 22],
            ['name' => '扣工会会费', 'role_id' => 21],
            ['name' => '扣欠款', 'role_id' => 22],
            ['name' => '捐赠', 'role_id' => 22],
        ];
        \App\Models\Salary\DeductionType::insert($deductions_types);

        // 其他费用类别
        \App\Models\Salary\OtherType::truncate();
        $other_types = [
            ['name' => '财务发稿酬', 'role_id' => 13],
            ['name' => '工会发稿酬', 'role_id' => 14],
            ['name' => '劳务报酬', 'role_id' => 15],
            ['name' => '特许使用权', 'role_id' => 16],
        ];
        \App\Models\Salary\OtherType::insert($other_types);
    }
}
