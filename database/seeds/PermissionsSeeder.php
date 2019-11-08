<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $date = Carbon::now();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();
        Role::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $permissions = [
            // typeId = 0 系统权限
            ['name' => 'administer_permission', 'description' => '后台管理', 'typeId' => 0, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'department_manage ', 'description' => '部门管理', 'typeId' => 0, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'special_info_manage ', 'description' => '特殊信息管理', 'typeId' => 0, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'card_manage ', 'description' => '非工行卡维护', 'typeId' => 0, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 1 用户权限
            ['name' => 'show_all_salary', 'description' => '查看年收入', 'typeId' => 1, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'print_all_salary', 'description' => '打印年收入', 'typeId' => 1, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'show_charts', 'description' => '图表显示', 'typeId' => 1, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 业务权限
            // typeId = 10 基础数据
            ['name' => 'reduce_tax_rate', 'description' => '减免税率', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 11 工资
            ['name' => 'annual_standard', 'description' => '年薪工资标', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'wage_standard', 'description' => '岗位工资标', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'wage_daily', 'description' => '岗位工资日', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'sick_sub', 'description' => '扣岗位工病', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'leave_sub', 'description' => '扣岗位工事', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'baby_sub', 'description' => '扣岗位工婴', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'annual', 'description' => '年薪工资', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'wage', 'description' => '岗位工资', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'retained_wage', 'description' => '保留工资', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'compensation', 'description' => '套级补差', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'night_shift', 'description' => '中夜班费', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'overtime_wage', 'description' => '加班工资', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'seniority_wage', 'description' => '年功工资', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'lggw', 'description' => '离岗岗位', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'lgbl', 'description' => '离岗保留', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'lgzj', 'description' => '离岗增加', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'lgng', 'description' => '离岗年功', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'jbylj', 'description' => '基本养老金', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'zj', 'description' => '增机', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'gjbt', 'description' => '国家补贴', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'gjsh', 'description' => '国家生活', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'gjxj', 'description' => '国家小计', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'dflc', 'description' => '地方粮差', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'dfqt', 'description' => '地方其他', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'dfwb', 'description' => '地方物补', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'dfsh', 'description' => '地方生活', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'dfxj', 'description' => '地方小计', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'hygl', 'description' => '行业工龄', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'hytb', 'description' => '行业退补', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'hyqt', 'description' => '行业其他', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'hyxj', 'description' => '行业小计', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'tcxj', 'description' => '统筹小计', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qylc', 'description' => '企业粮差', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qygl', 'description' => '企业工龄', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qysb', 'description' => '企业书报', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qysd', 'description' => '企业水电', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qysh', 'description' => '企业生活', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qydzf', 'description' => '企业独子费', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qyhlf', 'description' => '企业护理费', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qytxf', 'description' => '企业通讯费', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qygfz', 'description' => '企业规范增', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qygl2', 'description' => '企业工龄02', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qyntb', 'description' => '企业内退补', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qybf', 'description' => '企业补发', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'qyxj', 'description' => '企业小计', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'ltxbc', 'description' => '离退休补充', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'bc', 'description' => '补偿', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'wage_total', 'description' => '应发工资', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'yfct', 'description' => '应发辞退', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'yfnt', 'description' => '应发内退', 'typeId' => 11, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 3 奖金
            ['name' => 'month_bonus', 'description' => '月奖', 'typeId' => 12, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'special', 'description' => '专项奖', 'typeId' => 12, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'competition', 'description' => '劳动竞赛', 'typeId' => 12, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'class_reward', 'description' => '课酬', 'typeId' => 12, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'holiday', 'description' => '节日慰问费', 'typeId' => 12, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'party_reward', 'description' => '党员奖励', 'typeId' => 12, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'union_paying', 'description' => '工会发放', 'typeId' => 12, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'other_reward', 'description' => '其他奖励', 'typeId' => 12, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'bonus_total', 'description' => '奖金合计', 'typeId' => 12, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 4 其他费用
            ['name' => 'finance_article', 'description' => '财务发稿酬', 'typeId' => 13, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'union_article', 'description' => '工会发稿酬', 'typeId' => 13, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'article_fee', 'description' => '稿酬', 'typeId' => 13, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'article_add_tax', 'description' => '稿酬应补税', 'typeId' => 13, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'article_sub_tax', 'description' => '稿酬减免税', 'typeId' => 13, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'franchise', 'description' => '特许使用权', 'typeId' => 13, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'franchise_add_tax', 'description' => '特权应补税', 'typeId' => 13, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'franchise_sub_tax', 'description' => '特权减免税', 'typeId' => 13, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 5 社保
            ['name' => 'gjj_classic', 'description' => '公积金标准', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'gjj_add', 'description' => '公积金补扣', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'gjj_person', 'description' => '公积金个人', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'gjj_deduction', 'description' => '公积金扣除', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'gjj_enterprise', 'description' => '公积企业缴', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'gjj_out_range', 'description' => '公积企超标', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'annuity_classic', 'description' => '年金标准', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'annuity_add', 'description' => '年金补扣', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'annuity_person', 'description' => '年金个人', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'annuity_deduction', 'description' => '年金扣除', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'annuity_enterprise', 'description' => '年金企业缴', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'annuity_out_range', 'description' => '年金企超标', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'retire_classic', 'description' => '退养金标准', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'retire_add', 'description' => '退养金补扣', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'retire_person', 'description' => '退养金个人', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'retire_deduction', 'description' => '退养金扣除', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'retire_enterprise', 'description' => '退养企业缴', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'retire_out_range', 'description' => '退养企超标', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'medical_classic', 'description' => '医保金标准', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'medical_add', 'description' => '医保金补扣', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'medical_person', 'description' => '医保金个人', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'medical_deduction', 'description' => '医保金补扣', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'medical_enterprise', 'description' => '医保企业缴', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'medical_out_range', 'description' => '医保企超标', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'unemployment_classic', 'description' => '失业金标准', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'unemployment_add', 'description' => '失业金补扣', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'unemployment_person', 'description' => '失业金个人', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'unemployment_deduction', 'description' => '失业金扣除', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'unemployment_enterprise', 'description' => '失业企业缴', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'unemployment_out_range', 'description' => '失业企超标', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'injury_enterprise', 'description' => '工伤企业缴', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'birth_enterprise', 'description' => '生育企业缴', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'enterprise_out_total', 'description' => '企业超合计', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'specail_deduction', 'description' => '专项扣除', 'typeId' => 14, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 6 补贴
            ['name' => 'communication', 'description' => '通讯补贴', 'typeId' => 15, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'housing', 'description' => '住房补贴', 'typeId' => 15, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'traffic_standard', 'description' => '交通补贴标', 'typeId' => 15, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'traffic_add', 'description' => '交通补贴考', 'typeId' => 15, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'traffic', 'description' => '交通费', 'typeId' => 15, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'single_standard', 'description' => '独子费标准', 'typeId' => 15, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'single_add', 'description' => '独子费补发', 'typeId' => 15, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'single', 'description' => '独子费', 'typeId' => 15, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'subsidy_total', 'description' => '补贴合计', 'typeId' => 15, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 7 补发
            ['name' => 'reissue_wage', 'description' => '补发工资', 'typeId' => 16, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'reissue_subsidy', 'description' => '补发补贴', 'typeId' => 16, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'reissue_other', 'description' => '补发其他', 'typeId' => 16, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'reissue_total', 'description' => '补发合计', 'typeId' => 16, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 8 扣款
            ['name' => 'garage_water', 'description' => '车库水费', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'garage_electric', 'description' => '车库电费', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'garage_property', 'description' => '车库物管', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'cc_water', 'description' => '成钞水费', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'cc_electric', 'description' => '成钞电费', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'cc_property', 'description' => '成钞物管', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'xy_water', 'description' => '鑫源水费', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'xy_electric', 'description' => '鑫源电费', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'xy_property', 'description' => '鑫源物管', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'back_water', 'description' => '退补水费', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'back_electric', 'description' => '退补电费', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'back_property', 'description' => '退补物管费', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'water_electric', 'description' => '水电', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'property_fee', 'description' => '物管费', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'car_fee', 'description' => '公车费用', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'car_deduction', 'description' => '公车补扣除', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'car_deduction_comment', 'description' => '公车扣备注', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'rest_deduction', 'description' => '它项扣除', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'rest_deduction_comment', 'description' => '它项扣备注', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'fixed_deduction', 'description' => '固定扣款', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'other_deduction', 'description' => '其他扣款', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'temp_deduction', 'description' => '临时扣款', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'union_deduction', 'description' => '扣工会会费', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'prior_deduction', 'description' => '上期余欠款', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'had_debt', 'description' => '已销欠款', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'debt', 'description' => '扣欠款', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'donate', 'description' => '捐赠', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'sum_deduction', 'description' => '其他扣除', 'typeId' => 17, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 9 专项税务
            ['name' => 'income', 'description' => '累计收入额', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'deduct_expenses', 'description' => '累减除费用', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'special_deduction', 'description' => '累计专项扣', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_child', 'description' => '累专附子女', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_old', 'description' => '累专附老人', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_edu', 'description' => '累专附继教', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_loan', 'description' => '累专附房利', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_rent', 'description' => '累专附房租', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_other_deduct', 'description' => '累其他扣除', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'deduct_donate', 'description' => '累计扣捐赠', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_income', 'description' => '累税所得额', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'taxrate', 'description' => '税率', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'quick_deduction', 'description' => '速算扣除数', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'taxable', 'description' => '累计应纳税', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_reliefs', 'description' => '累计减免税', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'should_deducted_tax', 'description' => '累计应扣税', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'have_deducted_tax', 'description' => '累计申扣税', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'should_be_tax', 'description' => '累计应补税', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'reduce_tax', 'description' => '减免个税', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'personal_tax', 'description' => '个人所得税', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'prior_had_deducted_tax', 'description' => '上月已扣税', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'declare_tax', 'description' => '申报个税', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
//            ['name' => 'tax_diff', 'description' => '税差', 'typeId' => 18, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // type = 10 特殊薪酬表
            ['name' => 'instead_salary', 'description' => '代汇', 'typeId' => 19, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'bank_salary', 'description' => '银行发放', 'typeId' => 19, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'actual_salary', 'description' => '实发工资', 'typeId' => 19, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'debt_salary', 'description' => '余欠款', 'typeId' => 19, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'court_salary', 'description' => '法院转提', 'typeId' => 19, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // type = 11 额外读取表
            ['name' => 'extra_column1', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column2', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column3', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column4', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column5', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column6', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column7', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column8', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column9', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column10', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column11', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column12', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column13', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column14', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column15', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column16', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column17', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column18', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column19', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column20', 'description' => '', 'typeId' => 20, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
        ];
        Permission::insert($permissions);

        $roles = [
            // typeId = 0
            ['name' => 'administrator', 'description' => '管理员', 'typeId' => 0, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'financial_manager', 'description' => '财务管理员', 'typeId' => 0, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'department_manager', 'description' => '部门管理员', 'typeId' => 0, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'general_user', 'description' => '一般用户', 'typeId' => 0, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId  = 1
            // 此类角色分别控制工资条、以及工资明细显示的字段
            ['name' => 'salary_list', 'description' => '工资条', 'typeId' => 1, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'salary_detail', 'description' => '工资明细', 'typeId' => 1, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 9
            // 基础数据
            ['name' => 'reduce_tax_rate', 'description' => '减免税率', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 上传分表数据角色
            ['name' => 'additional_column', 'description' => '新增字段', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 工资相关
            ['name' => 'employee_wage', 'description' => '在岗职工工资', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'recuperate', 'description' => '离岗休养', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'retire', 'description' => '退休数据', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 奖金相关
            ['name' => 'month_bonus', 'description' => '月奖', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'special', 'description' => '专项奖', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'competition', 'description' => '劳动竞赛', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'class_reward', 'description' => '课酬', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'holiday', 'description' => '节日慰问奖', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'party_reward', 'description' => '党员奖励', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'union_paying', 'description' => '工会发放', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'other_reward', 'description' => '其他奖励', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 补贴相关
            ['name' => 'housing', 'description' => '住房补贴', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'single', 'description' => '独子费', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 社保相关
            ['name' => 'gjj', 'description' => '公积金', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'insurances', 'description' => '社保', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 扣款相关
            ['name' => 'garage', 'description' => '车库费用', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'cc_utility', 'description' => '成钞水电', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'cc_property', 'description' => '成钞物管', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'xy_property', 'description' => '鑫源', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'back_property', 'description' => '物业退补款', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'car_subsidy', 'description' => '高管公车补贴', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'car_fee', 'description' => '公车费用', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'rest_deduction', 'description' => '它项扣除', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'fixed_deduction', 'description' => '固定扣款', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'temp_deduction', 'description' => '临时扣款', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'other_deduction', 'description' => '其他扣款', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'union_deduction', 'description' => '扣工会会费', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'donate', 'description' => '捐赠', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 其他费用相关
            ['name' => 'finance_article', 'description' => '财务发稿酬', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'union_article', 'description' => '工会发稿酬', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'franchise', 'description' => '特许使用权', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 特殊相关
            ['name' => 'had_debt', 'description' => '已销欠款', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_import', 'description' => '专项导入', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'salary_export_1', 'description' => '工资薪金导出1', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'salary_export_2', 'description' => '工资薪金导出2', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'article_export_1', 'description' => '稿费导出1', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'article_export_2', 'description' => '稿费导出2', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'franchise_export_1', 'description' => '特许权导出1', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'franchise_export_2', 'description' => '特许权导出2', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
        ];
        Role::insert($roles);

        $role = Role::findOrFail(1);    //获取管理员角色
        $p_all = Permission::where('id', 1)->get();
        foreach ($p_all as $p) {
            $role->givePermissionTo($p);  //将权限分配给管理员
        }

        $role = Role::findOrFail(8);    // 额外读取表——新增字段
        $ps = Permission::where('typeId', 20)->get();
        foreach ($ps as $p) {
            $role->givePermissionTo($p);
        }

        // 工资相关——职工工资在岗
        $columns9 = [
            '年薪工资标', '岗位工资标', '岗位工资日', '扣岗位工病', '扣岗位工事', '扣岗位工婴',
            '保留工资', '套级补差', '中夜班费', '加班工资', '年功工资',
            '补发工资', '补发补贴',
            '通讯补贴', '交通补贴标', '交通补贴考',
        ];
        // 工资相关——退休数据
        $columns11 = [
            '基本养老金', '增机',
            '国家补贴', '国家生活', '地方粮差', '地方其他', '地方物补', '地方生活', '行业工龄', '行业退补', '行业其他',
            '企业粮差', '企业工龄', '企业书报', '企业水电', '企业生活',
            '企业独子费', '企业护理费', '企业通讯费', '企业规范增', '企业工龄02', '企业内退补', '企业补发',
            '离退休补充', '补偿',
        ];
        // 社保相关——社保
        $columns23 = [
            '年金标准', '年金补扣', '年金企业缴', '退养金标准', '退养金补扣', '退养企业缴',
            '医保金标准', '医保金补扣', '医保企业缴', '失业金标准', '失业金补扣', '失业企业缴',
            '工伤企业缴', '生育企业缴',
        ];
        // 专项税务导入
        $columns41 = [
            '累计收入额', '累减除费用', '累计专项扣',
            '累专附子女', '累专附老人', '累专附继教', '累专附房利', '累专附房租', '累其他扣除',
            '累计扣捐赠', '累税所得额', '税率', '速算扣除数',
            '累计应纳税', '累计减免税', '累计应扣税', '累计申扣税', '累计应补税',
        ];

        $data = [
            ['id' => 7, 'columns' => ['减免税率']],
            ['id' => 9, 'columns' => $columns9],
            ['id' => 10, 'columns' => ['离岗岗位', '离岗保留', '离岗增加', '离岗年功']],
            ['id' => 11, 'columns' => $columns11],
            ['id' => 12, 'columns' => ['月奖']],
            ['id' => 13, 'columns' => ['专项奖']],
            ['id' => 14, 'columns' => ['劳动竞赛']],
            ['id' => 15, 'columns' => ['课酬']],
            ['id' => 16, 'columns' => ['节日慰问费']],
            ['id' => 17, 'columns' => ['党员奖励']],
            ['id' => 18, 'columns' => ['工会发放']],
            ['id' => 19, 'columns' => ['其他奖励']],
            ['id' => 20, 'columns' => ['住房补贴']],
            ['id' => 21, 'columns' => ['独子费标准', '独子费补发']],
            ['id' => 22, 'columns' => ['公积金标准', '公积金补扣', '公积企业缴']],
            ['id' => 23, 'columns' => $columns23],
            ['id' => 24, 'columns' => ['车库水费', '车库电费', '车库物管']],
            ['id' => 25, 'columns' => ['成钞水费', '成钞电费']],
            ['id' => 26, 'columns' => ['成钞物管']],
            ['id' => 27, 'columns' => ['鑫源水费', '鑫源电费', '鑫源物管']],
            ['id' => 28, 'columns' => ['退补水费', '退补电费', '退补物管']],
            ['id' => 29, 'columns' => ['公车补扣除', '公车扣备注']],
            ['id' => 30, 'columns' => ['公车费用']],
            ['id' => 31, 'columns' => ['它项扣除', '它项扣备注']],
            ['id' => 32, 'columns' => ['固定扣款']],
            ['id' => 33, 'columns' => ['临时扣款']],
            ['id' => 34, 'columns' => ['其他扣款']],
            ['id' => 35, 'columns' => ['扣工会会费']],
            ['id' => 36, 'columns' => ['捐赠']],
            ['id' => 37, 'columns' => ['财务发稿酬']],
            ['id' => 38, 'columns' => ['工会发稿酬']],
            ['id' => 39, 'columns' => ['特许使用权']],
            ['id' => 40, 'columns' => ['已销欠款']],
            ['id' => 41, 'columns' => $columns41],
        ];

        foreach ($data as $d) {
            $role = Role::findOrFail($d['id']);
            $ps = Permission::whereIn('description', $d['columns'])->get();
            foreach ($ps as $p) {
                $role->givePermissionTo($p);
            }
        }
    }
}
