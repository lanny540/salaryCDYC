<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
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
            // typeId = 2 业务权限————对应到每个字段

            // 工资
            ['name' => 'annual', 'description' => '年薪工资', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'post_wage', 'description' => '岗位工资', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'retained_wage', 'description' => '保留工资', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'compensation', 'description' => '套级补差', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'night_shift', 'description' => '中夜班费', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'overtime_wage', 'description' => '加班工资', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'seniority_wage', 'description' => '年功工资', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 奖金
            ['name' => 'bonus', 'description' => '奖金', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 社保
            ['name' => 'gjj_classic', 'description' => '公积金标准', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'gjj_deduction', 'description' => '公积金补扣', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'gjj_person', 'description' => '公积金个人', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'gjj_enterprise', 'description' => '公积企业缴', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'annuity_classic', 'description' => '年金标准', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'annuity_deduction', 'description' => '年金补扣', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'annuity_person', 'description' => '年金个人', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'annuity_enterprise', 'description' => '年金企业缴', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'retire_classic', 'description' => '退养金标准', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'retire_deduction', 'description' => '退养金补扣', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'retire_person', 'description' => '退养金个人', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'retire_enterprise', 'description' => '退养企业缴', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'medical_classic', 'description' => '医保金标准', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'medical_deduction', 'description' => '医保金补扣', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'medical_person', 'description' => '医保金个人', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'medical_enterprise', 'description' => '医疗企业缴', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'unemployment_classic', 'description' => '失业金标准', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'unemployment_deduction', 'description' => '失业金补扣', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'unemployment_person', 'description' => '失业金个人', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'unemployment_enterprise', 'description' => '失业企业缴', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'injury_enterprise', 'description' => '工伤企业缴', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'birth_enterprise', 'description' => '生育企业缴', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 补贴
            ['name' => 'communication', 'description' => '通讯补贴', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'traffic', 'description' => '交通费', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'housing', 'description' => '住房补贴', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'single_classic', 'description' => '独子费标准', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'single_add', 'description' => '独子费补发', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'single', 'description' => '独子费', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'subsidy', 'description' => '补贴合计', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 扣款
            ['name' => 'deduction', 'description' => '扣款相关', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 税务导入
            ['name' => 'income', 'description' => '累计收入额', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'deduct_expenses', 'description' => '累减除费用', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'special_deduction', 'description' => '累计专项扣', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_child', 'description' => '累专附子女', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_old', 'description' => '累专附老人', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_edu', 'description' => '累专附继教', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_loan', 'description' => '累专附房利', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_rent', 'description' => '累专附房租', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_other_deduct', 'description' => '累其他扣除', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'deduct_donate', 'description' => '累计扣捐赠', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_income', 'description' => '累税所得额', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'taxrate', 'description' => '税率(%)', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'quick_deduction', 'description' => '速算扣除数', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'taxable', 'description' => '累计应纳税', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'tax_reliefs', 'description' => '累计减免税', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'should_deducted_tax', 'description' => '累计应扣税', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'have_deducted_tax', 'description' => '累计已扣税', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'should_be_tax', 'description' => '累计已扣税', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 物业费
            ['name' => 'cc_water', 'description' => '成钞水量', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'cc_water_rate', 'description' => '成钞水费', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'cc_electricity', 'description' => '成钞电费', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'cc_property', 'description' => '成钞物管', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'xy_water', 'description' => '鑫源水量', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'xy_water_rate', 'description' => '鑫源水费', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'xy_electricity', 'description' => '鑫源电费', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'xy_property', 'description' => '鑫源物管', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'utilities', 'description' => '水电', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'property_fee', 'description' => '物管费', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'property_back', 'description' => '物业退补费', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 其他费用
            ['name' => 'other_salary', 'description' => '其他费用', 'typeId' => 2, 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // TODO: 流程相关的奖金、补发导入表
        ];
        Permission::insert($permissions);

        $roles = [
            // typeId = 0
            ['name' => 'administrator', 'description' => '管理员', 'typeId' => 0, 'target_table' => '', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'financial_manager', 'description' => '财务管理员', 'typeId' => 0, 'target_table' => '', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'department_manager', 'description' => '部门管理员', 'typeId' => 0, 'target_table' => '', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'general_user', 'description' => '一般用户', 'typeId' => 0, 'target_table' => '', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId  = 1
            ['name' => 'merchandiser', 'description' => '业务员', 'typeId' => 1, 'target_table' => '', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'department_audit', 'description' => '部门审核', 'typeId' => 1, 'target_table' => '', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'accountant', 'description' => '财务会计', 'typeId' => 1, 'target_table' => '', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'financial_affairs', 'description' => '财务审核 ', 'typeId' => 1, 'target_table' => '', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // typeId = 2
            // 工资
            ['name' => 'employeesWage', 'description' => '在职工资（含内退）', 'typeId' => 2, 'target_table' => 'wage', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 奖金
            ['name' => 'hr_Bonus', 'description' => '人力发放奖金', 'typeId' => 2, 'target_table' => 'bonus', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'labor_Bonus', 'description' => '工会发放奖金', 'typeId' => 2, 'target_table' => 'bonus', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'other_Bonus', 'description' => '其他部门发放奖金', 'typeId' => 2, 'target_table' => 'bonus', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 其他费用
            ['name' => 'financial_remuneration', 'description' => '财务发稿酬', 'typeId' => 2, 'target_table' => 'otherSalary', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'labor_remuneration', 'description' => '工会发稿酬', 'typeId' => 2, 'target_table' => 'otherSalary', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'services_remuneration', 'description' => '劳务报酬', 'typeId' => 2, 'target_table' => 'otherSalary', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'concession', 'description' => '特许使用权', 'typeId' => 2, 'target_table' => 'otherSalary', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 物业费
            ['name' => 'property', 'description' => '物管费', 'typeId' => 2, 'target_table' => 'property', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 社保&补贴
            ['name' => 'insurances', 'description' => '社保', 'typeId' => 2, 'target_table' => 'insurances', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'subsidy', 'description' => '补贴', 'typeId' => 2, 'target_table' => 'subsidy', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 扣欠款
            ['name' => 'cars_deduction', 'description' => '公车费用', 'typeId' => 2, 'target_table' => 'deductions', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'labor_union', 'description' => '扣工会会费', 'typeId' => 2, 'target_table' => 'deductions', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'deduction', 'description' => '财务扣款', 'typeId' => 2, 'target_table' => 'deductions', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // 税务导入
            ['name' => 'taxImport', 'description' => '税务导入', 'typeId' => 2, 'target_table' => 'taxImport', 'guard_name' => 'web', 'created_at' => $date, 'updated_at' => $date],
            // TODO：流程相关的奖金，补发相关
        ];
        Role::insert($roles);

        $role = Role::findOrFail(1);    //获取管理员角色
        $p_all = Permission::where('id', 1)->get();
        foreach ($p_all as $p) {
            $role->givePermissionTo($p);  //将权限分配给管理员
        }

        $role = Role::findOrFail(9);    // 工资
        $ps = Permission::whereBetween('id', [8, 14])->get();
        foreach ($ps as $p) {
            $role->givePermissionTo($p);
        }
    }
}
