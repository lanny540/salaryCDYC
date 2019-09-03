<?php

namespace App\Services;

use App\Models\Period;
use App\Models\Salary\SalaryInfo;
use App\Models\Salary\SalarySummary;
use Auth;
use Carbon\Carbon;
use DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DataProcess
{
    /**
     * 数据写入DB.
     *
     * @param array  $info   表单提交数据
     * @param string $period 发放日期
     *
     * @return bool|\Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     */
    public function dataToDb(array $info, string $period)
    {
        DB::beginTransaction();

        try {
            // 将基础信息写入salary_info表
            SalaryInfo::create([
                'period_id' => $info['period'],
                'user_id' => Auth::id(),
                'upload_file' => $info['file'],
                'published_at' => $period,
            ]);

            if (0 == $info['roleId']) {
                // 将数据存入合计表
                $this->insertToSalarySummary($info['importData']);
                // 将数据存入各类分表
                for ($i = 7; $i <= 15; ++$i) {
                    $this->insertToTable($i, $info['importData']);
                }
            } else {
                $this->insertToTable($info['roleId'], $info['importData']);
            }

            $this->closePeriod();
            $this->newPeriod($period);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return false;
            // 调试用代码
//            return redirect()->back()->withErrors($e->getMessage());
        }

        return true;
    }

    /**
     * 处理常规字段.
     *
     * @param array $insertData 单行需要插入的数据
     *
     * @return array
     */
    private function commonColumn(array $insertData): array
    {
        $data = [];
        $period_id = $this->getPeriodId();
        $date = Carbon::now();

        $data['username'] = $insertData['转储姓名'];
        $data['policyNumber'] = $insertData['保险编号'];
        $data['period_id'] = $period_id;
        $data['created_at'] = $date;
        $data['updated_at'] = $date;

        return $data;
    }

    /**
     * 将数据写入汇总表.
     *
     * @param array $insertData
     *
     * @return bool
     */
    private function insertToSalarySummary(array $insertData)
    {
        $data = [];
        $length = count($insertData);

        for ($i = 0; $i < $length; ++$i) {
            $data[$i] = $this->commonColumn($insertData[$i]);
            $data[$i]['wage_total'] = $insertData[$i]['应发工资'];
            $data[$i]['bonus_total'] = $insertData[$i]['奖金合计'];
            $data[$i]['subsidy_total'] = $insertData[$i]['补贴合计'];
            $data[$i]['reissue_total'] = $insertData[$i]['补发合计'];
            $data[$i]['should_total'] = $insertData[$i]['应发合计'];
            $data[$i]['enterprise_out_total'] = $insertData[$i]['企业超合计'];
            $data[$i]['salary_total'] = $insertData[$i]['工资薪金'];
        }

        DB::table('summary')->insert($data);
        return true;
    }

    /**
     * 将数据写入各类分表.
     *
     * @param int $roleId 角色ID
     * @param array $insertData 插入数据
     *
     * @return bool
     */
    private function insertToTable(int $roleId, array $insertData)
    {
        $data = [];
        $length = count($insertData);

        // 如果额外读取列 没有对应字段，则跳过
        if (16 === $roleId) {
            $count = Permission::where('typeId', 11)->where('description', '<>', '')
                ->select(['name', 'description', 'typeId'])->count();
            if ($count == 0) {
                return false;
            }
        }

        $tableName = $this->getInsertTableName($roleId);
        $columns = $this->getInsertColumns($roleId);

        for ($i = 0; $i < $length; ++$i) {
            $data[$i] = $this->commonColumn($insertData[$i]);
            foreach ($columns as $column) {
                // 对应字段不为空，则字段有效
                if ('' != $column->description) {
                    $data[$i][$column->name] = $insertData[$i][$column->description];
                }
            }
        }
        DB::table($tableName)->insert($data);
        return true;
    }

    /**
     * 根据角色ID返回插入表名.
     *
     * @param int $roleId 角色ID
     *
     * @return string 插入表名
     */
    public function getInsertTableName(int $roleId): string
    {
        return Role::where('id', $roleId)->first()->target_table;
    }

    /**
     * 根据角色ID返回插入表的字段名.
     *
     * @param int $roleId
     *
     * @return mixed
     */
    private function getInsertColumns(int $roleId)
    {
        return Permission::where('typeId', $roleId - 5)->select(['name', 'description', 'typeId'])->get();
    }

    /**
     * 根据日期返回会计周期ID.
     *
     * @param $date
     *
     * @return int
     */
    public function getPeriodId(): int
    {
        $period = Period::max('id');

        if (empty($period)) {
            return $this->newPeriod();
        }

        return $period;
    }

    /**
     * 关闭当前会计周期
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function closePeriod()
    {
        $period = Period::latest('id')->first();

        $period->enddate = Carbon::now();
        $period->save();

        return $period;
    }

    /**
     * 新开会计周期
     *
     * @param string $published_at 发放日期
     *
     * @return int 会计周期ID
     */
    public function newPeriod(string $published_at = ''): int
    {
        $period = Period::create([
            'published_at' => '' == $published_at ? date('Y.m') : $published_at,
            'startdate' => Carbon::now(),
        ]);

        return $period->id;
    }

    /**
     * 根据用户ID、会计周期ID,查询收入总表，获取用户当期收入信息（对应工资条).
     *
     * @param $userId
     * @param $periodId
     *
     * @return mixed
     */
    public function personIncome($userId, $periodId)
    {
        return SalarySummary::where('user_id', $userId)
            ->where('period_id', $periodId)->get();
    }

    /**
     * 根据会计周期ID计算当期收入，生成月度收入数据，插入到收入总表.
     *
     * @param $periodId
     *
     * @return mixed
     */
    public function statmonthlyIncome($periodId)
    {
        // 工资
        $wage = $this->wageData($periodId);
        // 奖金
        $bonus = $this->bonuxData($periodId);
        // 社保
        $insurance = $this->insuranceData();
        // 补贴
        $subsidy = $this->subsidyData();
        // 税务
        $tax = $this->taxData();
        // 物管费
        $property = $this->propertyData($periodId);
        // 扣款
        $deduction = $this->deductionData($periodId);
        // 其他费用
        $other = $this->otherData($periodId);

        return response()->json([
            'wage' => $wage,
            'bonus' => $bonus,
            'insurance' => $insurance,
            'subsidy' => $subsidy,
            'tax' => $tax,
            'property' => $property,
            'deduction' => $deduction,
            'other' => $other,
        ]);
    }

    /**
     * 查询工资.
     *
     * @param int    $period_id 会计周期
     * @param string $policy    查询人保险编号（可缺失）
     *
     * @return array
     */
    private function wageData($period_id, $policy = ''): array
    {
        $columns = 'policyNumber, username, period_id, ';
        $columns .= 'annual, post_wage, retained_wage, ';
//        $columns .= 'annual AS 年薪工资, post_wage AS 岗位工资, retained_wage AS 保留工资, ';
//        $columns .= 'compensation AS 套级补差, night_shift AS 中夜班费, overtime_wage AS 加班工资, seniority_wage AS 年功工资';
        $columns .= 'compensation, night_shift, overtime_wage, seniority_wage';

        if ('' !== $policy) {
            return DB::select('select '.$columns.' from wage where period_id = ? AND policyNumber = ?', [$period_id, $policy]);
        }

        return DB::select('select '.$columns.' from wage where period_id = ?', [$period_id]);
    }

    /**
     * 查询奖金.
     *
     * @param int    $period_id 会计期ID
     * @param string $policy    查询人保险编号(可缺失)
     *
     * @return array
     */
    private function bonuxData($period_id, $policy = ''): array
    {
        return DB::select($this->BonusSql($period_id, $policy));
    }

    /**
     * 查询社保.
     *
     * @param string $policy 查询人保险编号(可缺失)
     *
     * @return array
     */
    private function insuranceData($policy = ''): array
    {
        $columns = 'policyNumber, username,';
//        $columns .= 'gjj_deduction AS 公积金补扣,gjj_person AS 公积金个人,gjj_enterprise AS 公积企业缴,';
//        $columns .= 'annuity_deduction AS 年金补扣,annuity_person AS 年金个人,annuity_enterprise AS 年金企业缴,';
//        $columns .= 'retire_deduction AS 退养金补扣,retire_person AS 退养金个人,retire_enterprise AS 退养企业缴,';
//        $columns .= 'medical_deduction AS 医保金补扣,medical_person AS 医保金个人,medical_enterprise AS 医疗企业缴,';
//        $columns .= 'unemployment_deduction AS 失业金补扣,unemployment_person AS 失业金个人,unemployment_enterprise AS 失业企业缴,';
//        $columns .= 'injury_enterprise AS 工伤企业缴,birth_enterprise AS 生育企业缴';
        $columns .= 'gjj_deduction,gjj_person,gjj_enterprise,';
        $columns .= 'annuity_deduction,annuity_person,annuity_enterprise,';
        $columns .= 'retire_deduction,retire_person,retire_enterprise,';
        $columns .= 'medical_deduction,medical_person,medical_enterprise,';
        $columns .= 'unemployment_deduction,unemployment_person,unemployment_enterprise,';
        $columns .= 'injury_enterprise,birth_enterprise';
        if ('' !== $policy) {
            return DB::select('select '.$columns.' from insurances where policyNumber = ?', [$policy]);
        }

        return DB::select('select '.$columns.' from insurances');
    }

    /**
     * 查询补贴.
     *
     * @param string $policy 查询人保险编号(可缺失)
     *
     * @return array
     */
    private function subsidyData($policy = ''): array
    {
        $columns = 'policyNumber, username,';
        $columns .= 'communication, traffic, housing, single, subsidy';
//        $columns .= 'communication AS 通讯补贴, traffic AS 交通费, housing AS 住房补贴, single AS 独子费, subsidy AS 补贴合计';
        if ('' !== $policy) {
            return DB::select('select '.$columns.' from subsidy where policyNumber = ?', [$policy]);
        }

        return DB::select('select '.$columns.' from subsidy');
    }

    /**
     * 查询专项税务
     *
     * @param string $policy 查询人保险编号(可缺失)
     *
     * @return array
     */
    private function taxData($policy = ''): array
    {
        $columns = 'policyNumber, username,';
        $columns .= 'income,deduct_expenses,special_deduction,';
        $columns .= 'tax_child,tax_old,tax_edu,tax_loan,tax_rent,';
        $columns .= 'tax_other_deduct,deduct_donate,tax_income,taxrate,';
        $columns .= 'quick_deduction,taxable,tax_reliefs,';
        $columns .= 'should_deducted_tax,have_deducted_tax,should_be_tax';
        if ('' !== $policy) {
            return DB::select('select '.$columns.' from taximport where policyNumber = ?', [$policy]);
        }

        return DB::select('select '.$columns.' from taximport');
    }

    /**
     * 查询物业费合计
     *
     * @param int    $period_id 会计周期
     * @param string $policy    查询人保险编号
     *
     * @return array
     */
    private function propertyData($period_id, $policy = ''): array
    {
        $t = '' !== $policy ? $policy : false;
        $data = [];
        $temp = Property::where('period_id', $period_id)
            ->when($t, function ($query) use ($policy) {
                return $query->where('policyNumber', $policy);
            })
            ->get()->toarray();
        $length = \count($temp);
        for ($i = 0; $i < $length; ++$i) {
            $data[$i]['policyNumber'] = $temp[$i]['policyNumber'];
            $data[$i]['username'] = $temp[$i]['username'];
            $data[$i]['period_id'] = $temp[$i]['period_id'];
            $data[$i]['total_property'] = $temp[$i]['total_property'];
        }

        return $data;
    }

    /**
     * 查询扣款.
     *
     * @param int    $period_id 会计期ID
     * @param string $policy    查询人保险编号(可缺失)
     *
     * @return array
     */
    private function deductionData($period_id, $policy = ''): array
    {
        return DB::select($this->DedutionSql($period_id, $policy));
    }

    /**
     * 查询其他费用.
     *
     * @param int    $period_id 会计期ID
     * @param string $policy    查询人保险编号(可缺失)
     *
     * @return array
     */
    private function otherData($period_id, $policy = ''): array
    {
        return DB::select($this->OtherSql($period_id, $policy));
    }
}
