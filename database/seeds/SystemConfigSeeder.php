<?php

use App\Models\Config\SystemConfig;
use Illuminate\Database\Seeder;

class SystemConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        SystemConfig::truncate();

        $data = [
            // 社保相关
            ['config_key' => 'GJJ_PERSON_UPPER_LIMIT', 'config_value' => '2139', 'type' => 'insurances'],
            ['config_key' => 'GJJ_ENTERPRISE_UPPER_LIMIT', 'config_value' => '2139', 'type' => 'insurances'],
            ['config_key' => 'RETIRE_PERSON_UPPER_LIMIT', 'config_value' => '1294.32', 'type' => 'insurances'],
            ['config_key' => 'RETIRE_ENTERPRISE_UPPER_LIMIT', 'config_value' => '999999', 'type' => 'insurances'],
            ['config_key' => 'ANNUITY_PERSON_UPPER_LIMIT', 'config_value' => '713', 'type' => 'insurances'],
            ['config_key' => 'ANNUITY_ENTERPRISE_UPPER_LIMIT', 'config_value' => '999999', 'type' => 'insurances'],
            ['config_key' => 'MEDICAL_PERSON_UPPER_LIMIT', 'config_value' => '323.58', 'type' => 'insurances'],
            ['config_key' => 'MEDICAL_ENTERPRISE_UPPER_LIMIT', 'config_value' => '1213.43', 'type' => 'insurances'],
            ['config_key' => 'UNEMPLOYMENT_PERSON_UPPER_LIMIT', 'config_value' => '64.72', 'type' => 'insurances'],
            ['config_key' => 'UNEMPLOYMENT_ENTERPRISE_UPPER_LIMIT', 'config_value' => '97.07', 'type' => 'insurances'],
            // 系统查询字段
            ['config_key' => '工资', 'config_value' => 's1', 'type' => 'search'],
            ['config_key' => '月奖', 'config_value' => 's2', 'type' => 'search'],
            ['config_key' => '劳动竞赛', 'config_value' => 's3', 'type' => 'search'],
            ['config_key' => '其他奖励', 'config_value' => 's4', 'type' => 'search'],
            ['config_key' => '补贴', 'config_value' => 's5', 'type' => 'search'],
            ['config_key' => '四险一金', 'config_value' => 's6', 'type' => 'search'],
            ['config_key' => '个人所得税', 'config_value' => 's7', 'type' => 'search'],
        ];

        SystemConfig::insert($data);
    }
}
