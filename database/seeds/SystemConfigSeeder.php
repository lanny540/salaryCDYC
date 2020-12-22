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
            ['config_key' => 'GJJ_PERSON_UPPER_LIMIT', 'config_value' => '2139', 'description' => '公积金个人缴纳上限', 'type' => 'insurances'],
            ['config_key' => 'GJJ_ENTERPRISE_UPPER_LIMIT', 'config_value' => '2139', 'description' => '公积金企业缴纳上限', 'type' => 'insurances'],
            ['config_key' => 'RETIRE_PERSON_UPPER_LIMIT', 'config_value' => '1294.32', 'description' => '退养金个人缴纳上限', 'type' => 'insurances'],
            ['config_key' => 'RETIRE_ENTERPRISE_UPPER_LIMIT', 'config_value' => '999999', 'description' => '退养金企业缴纳上限', 'type' => 'insurances'],
            ['config_key' => 'ANNUITY_PERSON_UPPER_LIMIT', 'config_value' => '713', 'description' => '年金个人缴纳上限', 'type' => 'insurances'],
            ['config_key' => 'ANNUITY_ENTERPRISE_UPPER_LIMIT', 'config_value' => '999999', 'description' => '年金企业缴纳上限', 'type' => 'insurances'],
            ['config_key' => 'MEDICAL_PERSON_UPPER_LIMIT', 'config_value' => '323.58', 'description' => '医疗保险个人缴纳上限', 'type' => 'insurances'],
            ['config_key' => 'MEDICAL_ENTERPRISE_UPPER_LIMIT', 'config_value' => '1213.43', 'description' => '医疗保险企业缴纳上限', 'type' => 'insurances'],
            ['config_key' => 'UNEMPLOYMENT_PERSON_UPPER_LIMIT', 'config_value' => '64.72', 'description' => '失业保险个人缴纳上限', 'type' => 'insurances'],
            ['config_key' => 'UNEMPLOYMENT_ENTERPRISE_UPPER_LIMIT', 'config_value' => '97.07', 'description' => '失业保险企业缴纳上限', 'type' => 'insurances'],
            // 系统查询字段
            ['config_key' => '工资', 'config_value' => 's1', 'description' => '薪金查询字段-工资', 'type' => 'search'],
            ['config_key' => '月奖', 'config_value' => 's2', 'description' => '薪金查询字段-月奖', 'type' => 'search'],
            ['config_key' => '劳动竞赛', 'config_value' => 's3', 'description' => '薪金查询字段-劳动竞赛', 'type' => 'search'],
            ['config_key' => '其他奖励', 'config_value' => 's4', 'description' => '薪金查询字段-其他奖励', 'type' => 'search'],
            ['config_key' => '补贴', 'config_value' => 's5', 'description' => '薪金查询字段-补贴', 'type' => 'search'],
            ['config_key' => '四险一金', 'config_value' => 's6', 'description' => '薪金查询字段-四险一金', 'type' => 'search'],
            ['config_key' => '个人所得税', 'config_value' => 's7', 'description' => '薪金查询字段-个人所得税', 'type' => 'search'],
        ];

        SystemConfig::insert($data);
    }
}
