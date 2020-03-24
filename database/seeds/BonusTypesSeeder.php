<?php

use App\Models\Salary\BonusType;
use Illuminate\Database\Seeder;

class BonusTypesSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        BonusType::truncate();

        $types = [
            ['id' => 13, 'type' => '专项奖'],
            ['id' => 14, 'type' => '劳动竞赛'],
            ['id' => 15, 'type' => '课酬'],
            ['id' => 16, 'type' => '节日慰问费'],
            ['id' => 17, 'type' => '党员奖励'],
            ['id' => 18, 'type' => '工会发放'],
            ['id' => 19, 'type' => '其他奖励'],
            ['id' => 37, 'type' => '财务发稿酬'],
            ['id' => 38, 'type' => '工会发稿酬'],
        ];

        BonusType::insert($types);
    }
}
