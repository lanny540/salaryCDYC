<?php

namespace App\Services;

use App\Models\Period;
use App\Models\Salary\SalaryInfo;
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

            if (0 === $info['roleId']) {
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
            sleep(1);   //避免两个周期首尾时间一致
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
     * 根据日期返回会计周期ID.
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
     * @param string $publishedAt 发放日期
     *
     * @return int 会计周期ID
     */
    public function newPeriod(string $publishedAt = ''): int
    {
        $period = Period::create([
            'published_at' => '' === $publishedAt ? date('Y.m') : $publishedAt,
            'startdate' => Carbon::now(),
        ]);

        return $period->id;
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
        $periodId = $this->getPeriodId();
        $date = Carbon::now();

        $data['username'] = $insertData['转储姓名'];
        $data['policyNumber'] = $insertData['保险编号'];
        $data['period_id'] = $periodId;
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
        $length = \count($insertData);

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
        $length = \count($insertData);

        // 如果额外读取列 没有对应字段，则跳过
        if (16 === $roleId) {
            $count = Permission::where('typeId', 11)->where('description', '<>', '')
                ->select(['name', 'description', 'typeId'])->count();
            if (0 === $count) {
                return false;
            }
        }

        $tableName = $this->getInsertTableName($roleId);
        $columns = $this->getInsertColumns($roleId);

        for ($i = 0; $i < $length; ++$i) {
            $data[$i] = $this->commonColumn($insertData[$i]);
            foreach ($columns as $column) {
                // 对应字段不为空，则字段有效
                if ('' !== $column->description) {
                    $data[$i][$column->name] = $insertData[$i][$column->description];
                }
            }
        }
        DB::table($tableName)->insert($data);

        return true;
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
}
