<?php

namespace App\Services;

use App\Models\Period;
use App\Models\Salary\BonusType;
use App\Models\Salary\DeductionType;
use App\Models\Salary\OtherType;
use App\Models\Salary\Property;
use App\Models\Salary\SalarySummary;
use App\Models\WorkFlow\WorkFlowLog;
use Auth;
use Carbon\Carbon;
use DB;
use Spatie\Permission\Models\Permission;

class DataProcess
{
    /**
     * 初始化流程日志
     * 初始只有3种情况，不立即发布，立即发布，上传已审核数据不需要走流程.
     *
     * @param int $wf_id 流程ID
     * @param int $code  流程标识ID
     */
    public function initializeWorkFlowLog(int $wf_id, int $code): void
    {
        switch ($code) {
            case 0:
                $action = '待发起';

                break;
            case 1:
                $action = '发起';

                break;
            case 9:
                $action = '上传已审核数据';

                break;
            default:
                $action = '错误流程参数';
        }
        WorkFlowLog::create([
            'wf_id' => $wf_id,
            'user_id' => Auth::id(),
            'action' => $action,
            'content' => '',
        ]);
    }

    /**
     * 数据写入DB.
     *
     * @param string $targetTable
     * @param array  $insertData
     *
     * @throws \Exception
     *
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function dataToDb(string $targetTable, array $insertData)
    {
        $tableName = strtolower($targetTable);
        DB::beginTransaction();

        try {
            // 先清空表再插入数据
            if (('taximport' === $tableName) || ('insurances' === $tableName) || ('subsidy' === $tableName)) {
                DB::table($targetTable)->truncate();
            }
            //插入数据
            DB::table($targetTable)->insert($insertData);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
//            return false;
            // 调试用代码
            return redirect()->back()->withErrors($e->getMessage());
        }

        return true;
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
            $period = Period::create([
                'startdate' => date('Y-m-d'),
            ]);

            return $period->id;
        }

        return $period;
    }

    /**
     * 关闭当前会计周期
     *
     * @return null|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public function closePeriod()
    {
        $period = Period::latest('id')->first();

        $period->enddate = date('Y-m-d');
        $period->save();

        return $period;
    }

    /**
     * 新开会计周期
     *
     * @return \Illuminate\Database\Eloquent\Model|Period
     */
    public function newPeriod()
    {
        $old_period = Period::latest('id')->first();

        return Period::create([
            'startdate' => Carbon::createFromFormat('Y-m-d', $old_period->enddate)->addDay(),
        ]);
    }

    /**
     * 将导入数据转换成插入数据.
     *
     * @param array $type ['roleId'] 角色ID ['roleLevel'] 二级角色ID [2] 操作的表名
     * @param array $data 待转换的数据
     *
     * @return array
     */
    public function convertData(array $type, array $data): array
    {
        // 常规字段转换
        $r = $this->commonConvert($type, $data);

        // 特殊字段转换
        return $this->specialConvert($r, $type, $data);
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
     * 常规字段转换.
     *
     * @param array $type
     * @param array $data
     *
     * @return array
     */
    private function commonConvert(array $type, array $data): array
    {
        $res = [];
        $date = Carbon::now();
        $count = \count($data);
        for ($i = 0; $i < $count; ++$i) {
            $res[$i]['username'] = $data[$i]['姓名'];
            $res[$i]['policyNumber'] = $data[$i]['保险编号'];
            // 社保、补贴、税务导入 没有 会计期 字段
            if ((23 !== $type['roleId']) && (18 !== $type['roleId']) && (19 !== $type['roleId'])) {
                $res[$i]['period_id'] = $type['period'];
                $res[$i]['upload_files'] = $type['file'];
            }
            $res[$i]['user_id'] = \Auth::id();
            $res[$i]['created_at'] = $date;
            $res[$i]['updated_at'] = $date;
        }

        return $res;
    }

    /**
     * 特殊字段转换.
     *
     * @param array $res
     * @param array $type
     * @param array $data
     *
     * @return array
     */
    private function specialConvert(array $res, array $type, array $data): array
    {
        $id = $type['roleId'];    //角色ID
        $level = $type['roleLevel'];  //2级分类ID
        $count = \count($data);

        switch ($id) {
            // 工资
            case 9:
                $permissions = Permission::select('name', 'description')
                    ->whereHas('roles', function ($q) use ($id) {
                        $q->where('id', $id);
                    })->pluck('description', 'name');
                for ($i = 0; $i < $count; ++$i) {
                    foreach ($permissions as $k => $v) {
                        $res[$i][$k] = $data[$i][$v];
                    }
                }

                break;
            // 奖金
            case 10:case 11:case 12:
                $permissions = BonusType::select('id', 'name')
                    ->where('role_id', $id)
                    ->where('id', $level)->pluck('name', 'id');
                for ($i = 0; $i < $count; ++$i) {
                    foreach ($permissions as $k => $v) {
                        $res[$i]['bonus'] = $data[$i][$v];
                        $res[$i]['type_id'] = $level;
                    }
                    $res[$i]['comment'] = $data[$i]['备注'];
                }

                break;
            // 其他薪金
            case 13:case 14:case 15:case 16:
                $permissions = OtherType::select(['id', 'name'])
                    ->where('role_id', $id)
                    ->where('id', $level)->pluck('name', 'id');
                for ($i = 0; $i < $count; ++$i) {
                    foreach ($permissions as $k => $v) {
                        $res[$i]['otherSalary'] = $data[$i][$v];
                        $res[$i]['type_id'] = $level;
                    }
                    $res[$i]['comment'] = $data[$i]['备注'];
                }

                break;
            // 物管费
            case 17:
                $permissions = Permission::select(['name', 'description'])
                    ->whereHas('roles', function ($q) use ($id) {
                        $q->where('id', $id);
                    })->pluck('description', 'name');
                for ($i = 0; $i < $count; ++$i) {
                    foreach ($permissions as $k => $v) {
                        $res[$i][$k] = $data[$i][$v];
                    }
                    $res[$i]['total_property'] = $res[$i]['utilities'] + $res[$i]['property_fee'];
                }

                break;
            // 社保、补贴
            case 18: case 19:
                $permissions = Permission::select(['name', 'description'])
                    ->whereHas('roles', function ($q) use ($id) {
                        $q->where('id', $id);
                    })->pluck('description', 'name');
                for ($i = 0; $i < $count; ++$i) {
                    foreach ($permissions as $k => $v) {
                        $res[$i][$k] = $data[$i][$v];
                    }
                }

                break;
            // 扣款
            case 20:case 21:case 22:
                $permissions = DeductionType::select(['id', 'name'])
                    ->where('role_id', $id)
                    ->where('id', $level)->pluck('name', 'id');
                for ($i = 0; $i < $count; ++$i) {
                    foreach ($permissions as $k => $v) {
                        $res[$i]['deduction'] = $data[$i][$v];
                        $res[$i]['type_id'] = $level;
                    }
                    $res[$i]['comment'] = $data[$i]['备注'];
                }

                break;
            // 税务导入
            case 23:
                $permissions = Permission::select(['name', 'description'])
                    ->whereHas('roles', function ($q) use ($id) {
                        $q->where('id', $id);
                    })->pluck('description', 'name');
                for ($i = 0; $i < $count; ++$i) {
                    foreach ($permissions as $k => $v) {
                        $res[$i][$k] = $data[$i][$v];
                    }
                }

                break;
            default:
                $res = [];
        }

        return $res;
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

    /**
     * 查询所有人员当前奖金的SQL语句（行转列）
     * 1.先查询所有奖金分类，然后循环拼接.
     *
     * @param $periodId
     * @param string $policy
     *
     * @return string
     */
    private function BonusSql($periodId, $policy = ''): string
    {
        $sql = '';
        $sql .= 'SELECT bonus.policyNumber, bonus.username, bonus.period_id,';
        $types = BonusType::all();
        foreach ($types as $t) {
            $sql .= ' SUM(IF(bonus.type_id = '.$t->id.', bonus,0)) AS '.$t->name.',';
        }
        $sql = rtrim($sql, ',');
        $sql .= ' FROM bonus';
        $sql .= ' WHERE bonus.period_id = '.$periodId;
        if ('' !== $policy) {
            $sql .= ' AND bonus.policyNumber = '.$policy;
        }
        $sql .= ' GROUP BY bonus.policyNumber, bonus.username, bonus.period_id';

        return $sql;
    }

    /**
     * 查询所有人员扣款的SQL语句（行转列）.
     *
     * @param $periodId
     * @param string $policy
     *
     * @return string
     */
    private function DedutionSql($periodId, $policy = ''): string
    {
        $sql = '';
        $sql .= 'SELECT deductions.policyNumber, deductions.username, deductions.period_id,';
        $types = DeductionType::all();
        foreach ($types as $t) {
            $sql .= ' SUM(IF(deductions.type_id = '.$t->id.', deduction, 0)) AS '.$t->name.',';
        }
        $sql = rtrim($sql, ',');
        $sql .= ' FROM deductions';
        $sql .= ' WHERE deductions.period_id ='.$periodId;
        if ('' !== $policy) {
            $sql .= ' AND deductions.policyNumber = '.$policy;
        }
        $sql .= ' GROUP BY deductions.policyNumber, deductions.username, deductions.period_id';

        return $sql;
    }

    /**
     * 查询所有人员其他费用的SQL语句（行转列）.
     *
     * @param int    $periodId
     * @param string $policy
     *
     * @return string
     */
    private function OtherSql($periodId, $policy = ''): string
    {
        $sql = '';
        $sql .= 'SELECT othersalary.policyNumber, othersalary.username, othersalary.period_id,';
        $types = OtherType::all();
        foreach ($types as $t) {
            $sql .= ' SUM(IF(othersalary.type_id = '.$t->id.', otherSalary,0)) AS '.$t->name.',';
        }
        $sql = rtrim($sql, ',');
        $sql .= ' FROM othersalary';
        $sql .= ' WHERE othersalary.period_id ='.$periodId;
        if ('' !== $policy) {
            $sql .= ' AND othersalary.policyNumber = '.$policy;
        }
        $sql .= ' GROUP BY othersalary.policyNumber, othersalary.username, othersalary.period_id';

        return $sql;
    }
}
