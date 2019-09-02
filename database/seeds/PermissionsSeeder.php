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
            // typeId = 2 工资
            ['name' => 'annual_standard', 'description' => '年薪工资标', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'wage_standard', 'description' => '岗位工资标', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'wage_daily', 'description' => '岗位工资日', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'sick_sub', 'description' => '扣岗位工病', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'leave_sub', 'description' => '扣岗位工事', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'baby_sub', 'description' => '扣岗位工婴', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'annual', 'description' => '年薪工资', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'wage', 'description' => '岗位工资', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'retained_wage', 'description' => '保留工资', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'compensation', 'description' => '套级补差', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'night_shift', 'description' => '中夜班费', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'overtime_wage', 'description' => '加班工资', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'seniority_wage', 'description' => '年功工资', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'lggw', 'description' => '离岗岗位', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'lgbl', 'description' => '离岗保留', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'lgzj', 'description' => '离岗增加', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'lgng', 'description' => '离岗年功', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'jbylj', 'description' => '基本养老金', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'zj', 'description' => '增机', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'gjbt', 'description' => '国家补贴', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'gjsh', 'description' => '国家生活', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'gjxj', 'description' => '国家小计', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'dflc', 'description' => '地方粮差', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'dfqt', 'description' => '地方其他', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'dfwb', 'description' => '地方物补', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'dfsh', 'description' => '地方生活', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'dfxj', 'description' => '地方小计', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'hygl', 'description' => '行业工龄', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'hytb', 'description' => '行业退补', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'hyqt', 'description' => '行业其他', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'hyxj', 'description' => '行业小计', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tcxj', 'description' => '统筹小计', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qylc', 'description' => '企业粮差', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qygl', 'description' => '企业工龄', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qysb', 'description' => '企业书报', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qysd', 'description' => '企业水电', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qysh', 'description' => '企业生活', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qydzf', 'description' => '企业独子费', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qyhlf', 'description' => '企业护理费', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qytxf', 'description' => '企业通讯费', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qygfz', 'description' => '企业规范增', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qygl2', 'description' => '企业工龄02', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qyntb', 'description' => '企业内退补', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qybf', 'description' => '企业补发', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'qyxj', 'description' => '企业小计', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'ltxbc', 'description' => '离退休补充', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'bc', 'description' => '补偿', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'yfct', 'description' => '应发辞退', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'yfnt', 'description' => '应发内退', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'wage_total', 'description' => '应发工资', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 3 奖金
            ['name' => 'month_bonus', 'description' => '月奖', 'typeId' => 3, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'special', 'description' => '专项奖', 'typeId' => 3, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'competition', 'description' => '劳动竞赛', 'typeId' => 3, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'class_reward', 'description' => '课酬', 'typeId' => 3, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'holiday', 'description' => '节日慰问费', 'typeId' => 3, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'party_reward', 'description' => '党员奖励', 'typeId' => 3, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'union_paying', 'description' => '工会发放', 'typeId' => 3, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'other_reward', 'description' => '其他奖励', 'typeId' => 3, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'bonus_total', 'description' => '奖金合计', 'typeId' => 3, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 4 其他费用
            ['name' => 'finance_article', 'description' => '财务发稿酬', 'typeId' => 4, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'union_article', 'description' => '工会发稿酬', 'typeId' => 4, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'article_fee', 'description' => '稿酬', 'typeId' => 4, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'article_add_tax', 'description' => '稿酬应补税', 'typeId' => 4, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'article_sub_tax', 'description' => '稿酬减免税', 'typeId' => 4, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'franchise', 'description' => '特许使用权', 'typeId' => 4, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'franchise_add_tax', 'description' => '特许应补税', 'typeId' => 4, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'franchise_sub_tax', 'description' => '特许减免税', 'typeId' => 4, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'labour', 'description' => '劳务报酬', 'typeId' => 4, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'labour_add_tax', 'description' => '劳务应补税', 'typeId' => 4, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'labour_sub_tax', 'description' => '劳务减免税', 'typeId' => 4, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 5 社保
            ['name' => 'gjj_classic', 'description' => '公积金标准', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'gjj_add', 'description' => '公积金补扣', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'gjj_person', 'description' => '公积金个人', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'gjj_deduction', 'description' => '公积金扣除', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'gjj_enterprise', 'description' => '公积企业缴', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'gjj_out_range', 'description' => '公积企超标', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'annuity_classic', 'description' => '年金标准', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'annuity_add', 'description' => '年金补扣', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'annuity_person', 'description' => '年金个人', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'annuity_deduction', 'description' => '年金扣除', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'annuity_enterprise', 'description' => '年金企业缴', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'annuity_out_range', 'description' => '公积企超标', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'retire_classic', 'description' => '退养金标准', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'retire_add', 'description' => '退养金补扣', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'retire_person', 'description' => '退养金个人', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'retire_deduction', 'description' => '退养金扣除', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'retire_enterprise', 'description' => '退养企业缴', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'retire_out_range', 'description' => '退养企超标', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'medical_classic', 'description' => '医保金标准', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'medical_add', 'description' => '医保金补扣', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'medical_person', 'description' => '医保金个人', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'medical_deduction', 'description' => '医保金补扣', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'medical_enterprise', 'description' => '医疗企业缴', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'medical_out_range', 'description' => '医疗企超标', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'unemployment_classic', 'description' => '失业金标准', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'unemployment_add', 'description' => '失业金补扣', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'unemployment_person', 'description' => '失业金个人', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'unemployment_deduction', 'description' => '失业金扣除', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'unemployment_enterprise', 'description' => '失业企业缴', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'unemployment_out_range', 'description' => '失业企超标', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'injury_enterprise', 'description' => '工伤企业缴', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'birth_enterprise', 'description' => '生育企业缴', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],

            ['name' => 'enterprise_out_total', 'description' => '企业超合计', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'specail_deduction', 'description' => '专项扣除', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'car_deduction', 'description' => '公车补扣除', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'car_deduction_comment', 'description' => '公车扣备注', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'rest_deduction', 'description' => '它项扣除', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'rest_deduction_comment', 'description' => '它项扣备注', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'sum_deduction', 'description' => '其他扣除', 'typeId' => 5, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 6 补贴
            ['name' => 'communication', 'description' => '通讯补贴', 'typeId' => 6, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'traffic_standard', 'description' => '交通补贴标', 'typeId' => 6, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'traffic_add', 'description' => '交通补贴考', 'typeId' => 6, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'traffic', 'description' => '交通费', 'typeId' => 6, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'housing', 'description' => '住房补贴', 'typeId' => 6, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'single_standard', 'description' => '独子费标准', 'typeId' => 6, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'single_add', 'description' => '独子费补发', 'typeId' => 6, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'single', 'description' => '独子费', 'typeId' => 6, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'subsidy_total', 'description' => '补贴合计', 'typeId' => 6, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 7 补发
            ['name' => 'reissue_wage', 'description' => '补发工资', 'typeId' => 7, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'reissue_subsidy', 'description' => '补发补贴', 'typeId' => 7, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'reissue_other', 'description' => '补发其他', 'typeId' => 7, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'reissue_total', 'description' => '补发合计', 'typeId' => 7, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 8 扣款
            ['name' => 'garage_water', 'description' => '车库水费', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'garage_electric', 'description' => '车库电费', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'garage_property', 'description' => '车库物管', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'cc_water', 'description' => '成钞水费', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'cc_electric', 'description' => '成钞电费', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'cc_property', 'description' => '成钞物管', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'xy_water', 'description' => '鑫源水费', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'xy_electric', 'description' => '鑫源电费', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'xy_property', 'description' => '鑫源物管', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'back_water', 'description' => '退补水费', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'back_electric', 'description' => '退补电费', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'back_property', 'description' => '退补物管费', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'water_electric', 'description' => '水电', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'property_fee', 'description' => '物管费', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],

            ['name' => 'car_fee', 'description' => '公车费用', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'fixed_deduction', 'description' => '固定扣款', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'other_deduction', 'description' => '其他扣款', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'temp_deduction', 'description' => '临时扣款', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'union_deduction', 'description' => '扣工会会费', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'prior_deduction', 'description' => '上期余欠款', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'had_debt', 'description' => '已销欠款', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'debt', 'description' => '扣欠款', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'donate', 'description' => '捐赠', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_diff', 'description' => '税差', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'personal_tax', 'description' => '个人所得税', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'deduction_total', 'description' => '扣款合计', 'typeId' => 8, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 9 专项税务
            ['name' => 'income', 'description' => '累计收入额', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'deduct_expenses', 'description' => '累减除费用', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'special_deduction', 'description' => '累计专项扣', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_child', 'description' => '累专附子女', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_old', 'description' => '累专附老人', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_edu', 'description' => '累专附继教', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_loan', 'description' => '累专附房利', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_rent', 'description' => '累专附房租', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_other_deduct', 'description' => '累其他扣除', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'deduct_donate', 'description' => '累计扣捐赠', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_income', 'description' => '累税所得额', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'taxrate', 'description' => '税率', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'quick_deduction', 'description' => '速算扣除数', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'taxable', 'description' => '累计应纳税', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_reliefs', 'description' => '累计减免税', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'should_deducted_tax', 'description' => '累计应扣税', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'have_deducted_tax', 'description' => '累计申扣税', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'should_be_tax', 'description' => '累计应补税', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'reduce_tax', 'description' => '减免个税', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'prior_had_deducted_tax', 'description' => '上月已扣税', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'declare_tax', 'description' => '申报个税', 'typeId' => 9, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // type = 10 额外读取表
            ['name' => 'extra_column1', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column2', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column3', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column4', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column5', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column6', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column7', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column8', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column9', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column10', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column11', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column12', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column13', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column14', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column15', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column16', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column17', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column18', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column19', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'extra_column20', 'description' => '', 'typeId' => 10, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
        ];
        Permission::insert($permissions);

        $roles = [
            // typeId = 0
            ['name' => 'administrator', 'description' => '管理员', 'typeId' => 0, 'target_table' => '', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'financial_manager', 'description' => '财务管理员', 'typeId' => 0, 'target_table' => '', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'department_manager', 'description' => '部门管理员', 'typeId' => 0, 'target_table' => '', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'general_user', 'description' => '一般用户', 'typeId' => 0, 'target_table' => '', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId  = 1
            // 此类角色分别控制工资条、以及工资明细显示的字段
            ['name' => 'salary_list', 'description' => '工资条', 'typeId' => 1, 'target_table' => '', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'salary_detail', 'description' => '工资明细', 'typeId' => 1, 'target_table' => '', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 2
            // 工资
            ['name' => 'wage', 'description' => '工资', 'typeId' => 2, 'target_table' => 'wage', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 奖金
            ['name' => 'bonus', 'description' => '奖金', 'typeId' => 2, 'target_table' => 'bonus', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 其他费用
            ['name' => 'other', 'description' => '其他费用', 'typeId' => 2, 'target_table' => 'other', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 社保
            ['name' => 'insurances', 'description' => '社保', 'typeId' => 2, 'target_table' => 'insurances', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 补贴
            ['name' => 'subsidy', 'description' => '补贴', 'typeId' => 2, 'target_table' => 'subsidy', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 补发
            ['name' => 'reissue', 'description' => '补发', 'typeId' => 2, 'target_table' => 'reissue', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 扣款
            ['name' => 'deduction', 'description' => '扣款', 'typeId' => 2, 'target_table' => 'deduction', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 专项税务
            ['name' => 'taxImport', 'description' => '专项税务', 'typeId' => 2, 'target_table' => 'taxImport', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 额外读取
            ['name' => 'extra', 'description' => '额外读取', 'typeId' => 2, 'target_table' => 'extra', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ];
        Role::insert($roles);

        $role = Role::findOrFail(1);    //获取管理员角色
        $p_all = Permission::where('id', 1)->get();
        foreach ($p_all as $p) {
            $role->givePermissionTo($p);  //将权限分配给管理员
        }

        $role = Role::findOrFail(7);    // 工资
        $ps = Permission::whereBetween('id', [8, 57])->get();
        foreach ($ps as $p) {
            $role->givePermissionTo($p);
        }

        $role = Role::findOrFail(8);    // 奖金
        $ps = Permission::whereBetween('id', [58, 66])->get();
        foreach ($ps as $p) {
            $role->givePermissionTo($p);
        }

        $role = Role::findOrFail(9);    // 其他费用
        $ps = Permission::whereBetween('id', [67, 77])->get();
        foreach ($ps as $p) {
            $role->givePermissionTo($p);
        }

        $role = Role::findOrFail(10);    // 社保
        $ps = Permission::whereBetween('id', [78, 116])->get();
        foreach ($ps as $p) {
            $role->givePermissionTo($p);
        }

        $role = Role::findOrFail(11);    // 补贴
        $ps = Permission::whereBetween('id', [117, 125])->get();
        foreach ($ps as $p) {
            $role->givePermissionTo($p);
        }

        $role = Role::findOrFail(12);    // 补发
        $ps = Permission::whereBetween('id', [126, 129])->get();
        foreach ($ps as $p) {
            $role->givePermissionTo($p);
        }

        $role = Role::findOrFail(13);    // 扣款
        $ps = Permission::whereBetween('id', [130, 155])->get();
        foreach ($ps as $p) {
            $role->givePermissionTo($p);
        }

        $role = Role::findOrFail(14);    // 扣款
        $ps = Permission::whereBetween('id', [156, 176])->get();
        foreach ($ps as $p) {
            $role->givePermissionTo($p);
        }

        $role = Role::findOrFail(15);    // 额外
        $ps = Permission::whereBetween('id', [177, 196])->get();
        foreach ($ps as $p) {
            $role->givePermissionTo($p);
        }
    }
}
