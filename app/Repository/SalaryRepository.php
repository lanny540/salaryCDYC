<?php

namespace App\Repository;

use App\Models\Salary\Bonus;
use App\Models\Salary\Deduction;
use App\Models\Salary\Insurances;
use App\Models\Salary\Other;
use App\Models\Salary\Reissue;
use App\Models\Salary\Subsidy;
use App\Models\Salary\TaxImport;
use App\Models\Salary\Wage;
use App\Models\Users\UserProfile;
use DB;

class SalaryRepository
{
    /**
     * 插入或更新数据.
     *
     * @param int   $periodId   会计期ID
     * @param int   $uploadType 数据上传类型
     * @param array $data       数据
     * @param int   $reset      是否重置数据
     */
    public function saveToTable($periodId, $uploadType, $data, $reset = 1)
    {
        switch ($uploadType) {
            case 7: //减免税率
                if (1 === $reset) {
                    $this->resetTaxRebates();
                }
                foreach ($data as $d) {
                    $this->taxRebates($d);
                }

                break;
            case 9: //职工工资在岗
                if (1 === $reset) {
                    $this->resetEmployeesWage($periodId);
                }
                foreach ($data as $d) {
                    $this->employeesWage($periodId, $d);
                }

                break;
            case 10: //离岗休养
                if (1 === $reset) {
                    $this->resetLgxy($periodId);
                }
                foreach ($data as $d) {
                    $this->lgxy($periodId, $d);
                }

                break;
            case 11: // 退休数据
                if (1 === $reset) {
                    $this->resetTxsj($periodId);
                }
                foreach ($data as $d) {
                    $this->txsj($periodId, $d);
                }

                break;
            case 12: //月奖
                if (1 === $reset) {
                    $this->resetMonthBonus($periodId);
                }
                foreach ($data as $d) {
                    $this->monthBonus($periodId, $d);
                }

                break;
            case 13: //专项奖
                if (1 === $reset) {
                    $this->resetSpecialBonus($periodId);
                }
                foreach ($data as $d) {
                    $this->specialBonus($periodId, $d);
                }

                break;
            case 14: //劳动竞赛
                if (1 === $reset) {
                    $this->resetCompetitionBonus($periodId);
                }
                foreach ($data as $d) {
                    $this->competitionBonus($periodId, $d);
                }

                break;
            case 15: //课酬
                if (1 === $reset) {
                    $this->resetClassRewardBonus($periodId);
                }
                foreach ($data as $d) {
                    $this->classRewardBonus($periodId, $d);
                }

                break;
            case 16: //节日慰问费
                if (1 === $reset) {
                    $this->resetHolidayBonus($periodId);
                }
                foreach ($data as $d) {
                    $this->holidayBonus($periodId, $d);
                }

                break;
            case 17: //党员奖励
                if (1 === $reset) {
                    $this->resetPartyRewardBonus($periodId);
                }
                foreach ($data as $d) {
                    $this->partyRewardBonus($periodId, $d);
                }

                break;
            case 18: //工会发放
                if (1 === $reset) {
                    $this->resetUnionPayingBonus($periodId);
                }
                foreach ($data as $d) {
                    $this->unionPayingBonus($periodId, $d);
                }

                break;
            case 19: //其他奖励
                if (1 === $reset) {
                    $this->resetOtherRewardBonus($periodId);
                }
                foreach ($data as $d) {
                    $this->otherRewardBonus($periodId, $d);
                }

                break;
            case 20: //住房补贴
                if (1 === $reset) {
                    $this->resHousing($periodId);
                }
                foreach ($data as $d) {
                    $this->housing($periodId, $d);
                }

                break;
            case 21: //独子费
                if (1 === $reset) {
                    $this->resetSingle($periodId);
                }
                foreach ($data as $d) {
                    $this->single($periodId, $d);
                }

                break;
            case 22: //公积金
                if (1 === $reset) {
                    $this->resetGjj($periodId);
                }
                foreach ($data as $d) {
                    $this->gjj($periodId, $d);
                }

                break;
            case 23: //社保
                if (1 === $reset) {
                    $this->resetInsurances($periodId);
                }
                foreach ($data as $d) {
                    $this->insurances($periodId, $d);
                }

                break;
            case 24: //车库
                if (1 === $reset) {
                    $this->resetGarage($periodId);
                }
                foreach ($data as $d) {
                    $this->garage($periodId, $d);
                }

                break;
            case 25: //成钞水电
                if (1 === $reset) {
                    $this->resetCcWater($periodId);
                }
                foreach ($data as $d) {
                    $this->ccWater($periodId, $d);
                }

                break;
            case 26: //成钞物管
                if (1 === $reset) {
                    $this->resetCcProperty($periodId);
                }
                foreach ($data as $d) {
                    $this->ccProperty($periodId, $d);
                }

                break;
            case 27: //鑫源
                if (1 === $reset) {
                    $this->resetXyDeduction($periodId);
                }
                foreach ($data as $d) {
                    $this->xyDeduction($periodId, $d);
                }

                break;
            case 28: //水电物管退补
                if (1 === $reset) {
                    $this->resetBackDeduction($periodId);
                }
                foreach ($data as $d) {
                    $this->backDeduction($periodId, $d);
                }

                break;
            case 29: //公车补扣除
                if (1 === $reset) {
                    $this->resetCarDeduction($periodId);
                }
                foreach ($data as $d) {
                    $this->carDeduction($periodId, $d);
                }

                break;
            case 30: //公车费用
                if (1 === $reset) {
                    $this->resetCarFee($periodId);
                }
                foreach ($data as $d) {
                    $this->carFee($periodId, $d);
                }

                break;
            case 31: //它项扣除
                if (1 === $reset) {
                    $this->resetRestDeduction($periodId);
                }
                foreach ($data as $d) {
                    $this->restDeduction($periodId, $d);
                }

                break;
            case 32: //固定扣款
                if (1 === $reset) {
                    $this->resetFixedDeduction($periodId);
                }
                foreach ($data as $d) {
                    $this->fixedDeduction($periodId, $d);
                }

                break;
            case 33: //临时扣款
                if (1 === $reset) {
                    $this->resetTempDeduction($periodId);
                }
                foreach ($data as $d) {
                    $this->tempDeduction($periodId, $d);
                }

                break;
            case 34: //其他扣款
                if (1 === $reset) {
                    $this->resetOtherDeduction($periodId);
                }
                foreach ($data as $d) {
                    $this->otherDeduction($periodId, $d);
                }

                break;
            case 35: //扣工会会费
                if (1 === $reset) {
                    $this->resetUnionDeduction($periodId);
                }
                foreach ($data as $d) {
                    $this->unionDeduction($periodId, $d);
                }

                break;
            case 36: //捐赠
                if (1 === $reset) {
                    $this->resetDonate($periodId);
                }
                foreach ($data as $d) {
                    $this->donate($periodId, $d);
                }

                break;
            case 37: //财务发稿酬
                if (1 === $reset) {
                    $this->resetFinanceArticle($periodId);
                }
                foreach ($data as $d) {
                    $this->financeArticle($periodId, $d);
                }

                break;
            case 38: //工会发稿酬
                if (1 === $reset) {
                    $this->resetUnionArticle($periodId);
                }
                foreach ($data as $d) {
                    $this->unionArticle($periodId, $d);
                }

                break;
            case 39: //特许使用权
                if (1 === $reset) {
                    $this->resetFranchise($periodId);
                }
                foreach ($data as $d) {
                    $this->franchise($periodId, $d);
                }

                break;
            case 40: //已销欠款
                if (1 === $reset) {
                    $this->resetHadDebt($periodId);
                }
                foreach ($data as $d) {
                    $this->hadDebt($periodId, $d);
                }

                break;
            case 41: //专项税务
                if (1 === $reset) {
                    $this->resetTaxImport($periodId);
                }
                foreach ($data as $d) {
                    $this->taxImport($periodId, $d);
                }

                break;
            case 48: // 专项计算——工资薪金导入
                if (1 === $reset) {
                    $this->resetSalaryImport($periodId);
                }
                foreach ($data as $d) {
                    $this->salaryImport($periodId, $d);
                }
                $this->calSalaryTax($periodId);

                break;
            case 49: // 专项计算——稿酬导入
                if (1 === $reset) {
                    $this->resetArticleImport($periodId);
                }
                foreach ($data as $d) {
                    $this->articleImport($periodId, $d);
                }
                $this->calArticeTax($periodId);

                break;
            case 50: // 专项计算——特许权导入
                if (1 === $reset) {
                    $this->resetFranchiseImport($periodId);
                }
                foreach ($data as $d) {
                    $this->franchiseImport($periodId, $d);
                }
                $this->calFranchiseTax($periodId);

                break;
            case 51: // 申报个税——薪金申报个税
                if (1 === $reset) {
                    $this->resetDeclareTaxSalary($periodId);
                }
                foreach ($data as $d) {
                    $this->declareTaxSalary($periodId, $d);
                }

                break;
            case 52: // 申报个税——稿酬申报个税
                if (1 === $reset) {
                    $this->resetDeclareTaxArticle($periodId);
                }
                foreach ($data as $d) {
                    $this->declareTaxArticle($periodId, $d);
                }

                break;
            case 53: // 申报个税——特权申报个税
                if (1 === $reset) {
                    $this->resetDeclareTaxFranchise($periodId);
                }
                foreach ($data as $d) {
                    $this->declareTaxFranchise($periodId, $d);
                }

                break;
            default:
                // 其余结果
        }
    }

    /**
     * 减免税率.
     *
     * @param $data
     */
    private function taxRebates($data)
    {
        UserProfile::updateOrCreate(
            ['policyNumber' => $data['保险编号']],
            [
                'tax_rebates' => $data['减免税率'],
            ]
        );
    }

    /**
     * 重置减免税率.
     */
    private function resetTaxRebates()
    {
        UserProfile::update(['tax_rebates' => 0]);
    }

    /**
     * 在岗职工工资.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function employeesWage(int $period, $data)
    {
        Wage::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'annual_standard' => $data['标准预付年'],
                'wage_standard' => $data['标准岗位工'],
                'wage_daily' => $data['岗位工资日'],
                'sick_sub' => $data['岗位工资病'],
                'leave_sub' => $data['岗位工资事'],
                'baby_sub' => $data['岗位工资婴'],
                'retained_wage' => $data['保留工资'],
                'compensation' => $data['套级补差'],
                'night_shift' => $data['中夜班费'],
                'overtime_wage' => $data['加班工资'],
                'seniority_wage' => $data['年功工资'],
                // 计算字段
                'annual' => $data['年薪工资'],
                'wage' => $data['岗位工资'],
            ]
        );

        Reissue::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'reissue_wage' => $data['补发工资'],
                'reissue_subsidy' => $data['补发补贴'],
            ]
        );

        Subsidy::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'traffic_standard' => $data['标准交通补'],
                'traffic_add' => $data['交通补贴考'],
                'traffic' => $data['交通费'],
            ]
        );
    }

    /**
     * 重置在岗职工工资.
     *
     * @param int $period 会计期间ID
     */
    private function resetEmployeesWage(int $period)
    {
        Wage::where('period_id', $period)->update([
            'annual_standard' => 0,
            'wage_standard' => 0,
            'wage_daily' => 0,
            'sick_sub' => 0,
            'leave_sub' => 0,
            'baby_sub' => 0,
            'retained_wage' => 0,
            'compensation' => 0,
            'night_shift' => 0,
            'overtime_wage' => 0,
            'seniority_wage' => 0,
            // 计算字段
            'annual' => 0,
            'wage' => 0,
        ]);
        Reissue::where('period_id', $period)->update([
            'reissue_wage' => 0,
            'reissue_subsidy' => 0,
        ]);
        Subsidy::where('period_id', $period)->update([
            'traffic_standard' => 0,
            'traffic_add' => 0,
            'traffic' => 0,
        ]);
    }

    /**
     * 离岗休养.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function lgxy(int $period, $data)
    {
        Wage::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'lggw' => $data['内岗位'],
                'lgbl' => $data['内保留'],
                'lgzj' => $data['内增加'],
                'lgng' => $data['年功工资'],
                // 计算字段
                'jbylj' => 0,
            ]
        );
    }

    /**
     * 重置当期离岗休养.
     *
     * @param int $period 会计期间ID
     */
    private function resetLgxy(int $period)
    {
        Wage::where('period_id', $period)->update([
            'lggw' => 0,
            'lgbl' => 0,
            'lgzj' => 0,
            'lgng' => 0,
            'jbylj' => 0,
        ]);
    }

    /**
     * 退休数据.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function txsj(int $period, $data)
    {
        Wage::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'jbylj' => $data['基本养老金'],
                'zj' => $data['增机'],
                'gjbt' => $data['国家补贴'],
                'gjsh' => $data['国家生活'],
                'dflc' => $data['地方粮差'],
                'dfqt' => $data['地方其他'],
                'dfwb' => $data['地方物补'],
                'dfsh' => $data['地方生活'],
                'hygl' => $data['行业工龄'],
                'hytb' => $data['行业退补'],
                'hyqt' => $data['行业其他'],
                'qylc' => $data['企业粮差'],
                'qygl' => $data['企业工龄'],
                'qysb' => $data['企业书报'],
                'qysd' => $data['企业水电'],
                'qysh' => $data['企业生活'],
                'qydzf' => $data['企业独子费'],
                'qyhlf' => $data['企业护理费'],
                'qytxf' => $data['企业通讯费'],
                'qygfz' => $data['企业规范增'],
                'qygl2' => $data['企业工龄02'],
                'qyntb' => $data['企业内退补'],
                'qybf' => $data['企业补发'],
                'ltxbc' => $data['离退休补充'],
                'bc' => $data['补偿'],
                // 计算字段
                'gjxj' => $data['国家小计'],
                'dfxj' => $data['地方小计'],
                'hyxj' => $data['行业小计'],
                'tcxj' => $data['统筹小计'],
                'qyxj' => $data['企业小计'],
            ]
        );
    }

    /**
     * 重置当期退休数据.
     *
     * @param int $period 会计期间ID
     */
    private function resetTxsj(int $period)
    {
        Wage::where('period_id', $period)->update([
            'jbylj' => 0,
            'zj' => 0,
            'gjbt' => 0,
            'gjsh' => 0,
            'dflc' => 0,
            'dfqt' => 0,
            'dfwb' => 0,
            'dfsh' => 0,
            'hygl' => 0,
            'hytb' => 0,
            'hyqt' => 0,
            'qylc' => 0,
            'qygl' => 0,
            'qysb' => 0,
            'qysd' => 0,
            'qysh' => 0,
            'qydzf' => 0,
            'qyhlf' => 0,
            'qytxf' => 0,
            'qygfz' => 0,
            'qygl2' => 0,
            'qyntb' => 0,
            'qybf' => 0,
            'ltxbc' => 0,
            'bc' => 0,
            // 计算字段
            'gjxj' => 0,
            'dfxj' => 0,
            'hyxj' => 0,
            'tcxj' => 0,
            'qyxj' => 0,
        ]);
    }

    /**
     * 月奖.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function monthBonus(int $period, $data)
    {
        Bonus::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'month_bonus' => $data['金额'],
            ]
        );
    }

    /**
     * 重置当期月奖.
     *
     * @param int $period 会计期间ID
     */
    private function resetMonthBonus(int $period)
    {
        Bonus::where('period_id', $period)->update([
            'month_bonus' => 0,
        ]);
    }

    /**
     * 专项奖.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function specialBonus(int $period, $data)
    {
        $bonus = Bonus::where('period_id', $period)->where('policyNumber', $data['保险编号'])->count();

        if (0 == $bonus) {
            Bonus::create([
                'policyNumber' => $data['保险编号'],
                'period_id' => $period,
                'special' => $data['金额'],
            ]);
        } else {
            Bonus::where('period_id', $period)->where('policyNumber', $data['保险编号'])
                ->increment('special', $data['金额']);
        }
    }

    /**
     * 重置当前专项奖.
     *
     * @param int $period 会计期间ID
     */
    private function resetSpecialBonus(int $period)
    {
        Bonus::where('period_id', $period)->update([
            'special' => 0,
        ]);
    }

    /**
     * 劳动竞赛.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function competitionBonus(int $period, $data)
    {
        $bonus = Bonus::where('period_id', $period)->where('policyNumber', $data['保险编号'])->count();

        if (0 == $bonus) {
            Bonus::create([
                'policyNumber' => $data['保险编号'],
                'period_id' => $period,
                'competition' => $data['金额'],
            ]);
        } else {
            Bonus::where('period_id', $period)->where('policyNumber', $data['保险编号'])
                ->increment('competition', $data['金额']);
        }
    }

    /**
     * 重置当前劳动竞赛.
     *
     * @param int $period 会计期间ID
     */
    private function resetCompetitionBonus(int $period)
    {
        Bonus::where('period_id', $period)->update([
            'competition' => 0,
        ]);
    }

    /**
     * 课酬.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function classRewardBonus(int $period, $data)
    {
        $bonus = Bonus::where('period_id', $period)->where('policyNumber', $data['保险编号'])->count();

        if (0 == $bonus) {
            Bonus::create([
                'policyNumber' => $data['保险编号'],
                'period_id' => $period,
                'class_reward' => $data['金额'],
            ]);
        } else {
            Bonus::where('period_id', $period)->where('policyNumber', $data['保险编号'])
                ->increment('class_reward', $data['金额']);
        }
    }

    /**
     * 重置当期课酬.
     *
     * @param int $period 会计期间ID
     */
    private function resetClassRewardBonus(int $period)
    {
        Bonus::where('period_id', $period)->update([
            'class_reward' => 0,
        ]);
    }

    /**
     * 节日慰问费.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function holidayBonus(int $period, $data)
    {
        $bonus = Bonus::where('period_id', $period)->where('policyNumber', $data['保险编号'])->count();

        if (0 == $bonus) {
            Bonus::create([
                'policyNumber' => $data['保险编号'],
                'period_id' => $period,
                'holiday' => $data['金额'],
            ]);
        } else {
            Bonus::where('period_id', $period)->where('policyNumber', $data['保险编号'])
                ->increment('holiday', $data['金额']);
        }
    }

    /**
     * 重置当期课酬.
     *
     * @param int $period 会计期间ID
     */
    private function resetHolidayBonus(int $period)
    {
        Bonus::where('period_id', $period)->update([
            'holiday' => 0,
        ]);
    }

    /**
     * 党员奖励.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function partyRewardBonus(int $period, $data)
    {
        $bonus = Bonus::where('period_id', $period)->where('policyNumber', $data['保险编号'])->count();

        if (0 == $bonus) {
            Bonus::create([
                'policyNumber' => $data['保险编号'],
                'period_id' => $period,
                'party_reward' => $data['金额'],
            ]);
        } else {
            Bonus::where('period_id', $period)->where('policyNumber', $data['保险编号'])
                ->increment('party_reward', $data['金额']);
        }
    }

    /**
     * 重置当期党员奖励.
     *
     * @param int $period 会计期间ID
     */
    private function resetPartyRewardBonus(int $period)
    {
        Bonus::where('period_id', $period)->update([
            'party_reward' => 0,
        ]);
    }

    /**
     * 工会发放.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function unionPayingBonus(int $period, $data)
    {
        $bonus = Bonus::where('period_id', $period)->where('policyNumber', $data['保险编号'])->count();

        if (0 == $bonus) {
            Bonus::create([
                'policyNumber' => $data['保险编号'],
                'period_id' => $period,
                'union_paying' => $data['金额'],
            ]);
        } else {
            Bonus::where('period_id', $period)->where('policyNumber', $data['保险编号'])
                ->increment('union_paying', $data['金额']);
        }
    }

    /**
     * 重置当期工会发放.
     *
     * @param int $period 会计期间ID
     */
    private function resetUnionPayingBonus(int $period)
    {
        Bonus::where('period_id', $period)->update([
            'union_paying' => 0,
        ]);
    }

    /**
     * 其他奖励.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function otherRewardBonus(int $period, $data)
    {
        $bonus = Bonus::where('period_id', $period)->where('policyNumber', $data['保险编号'])->count();

        if (0 == $bonus) {
            Bonus::create([
                'policyNumber' => $data['保险编号'],
                'period_id' => $period,
                'other_reward' => $data['金额'],
            ]);
        } else {
            Bonus::where('period_id', $period)->where('policyNumber', $data['保险编号'])
                ->increment('other_reward', $data['金额']);
        }
    }

    /**
     * 重置当期其他奖励.
     *
     * @param int $period 会计期间ID
     */
    private function resetOtherRewardBonus(int $period)
    {
        Bonus::where('period_id', $period)->update([
            'other_reward' => 0,
        ]);
    }

    /**
     * 住房补贴.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function housing(int $period, $data)
    {
        Subsidy::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'housing' => $data['住房补贴'],
            ]
        );
    }

    /**
     * 重置当期住房补贴.
     *
     * @param int $period 会计期间ID
     */
    private function resHousing(int $period)
    {
        Subsidy::where('period_id', $period)->update([
            'housing' => 0,
        ]);
    }

    /**
     * 独子费.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function single(int $period, $data)
    {
        Subsidy::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'single_standard' => $data['独子费标准'],
                'single_add' => $data['独子费补发'],
                'single' => $data['独子费'],
            ]
        );
    }

    /**
     * 重置当期独子费.
     *
     * @param int $period 会计期间ID
     */
    private function resetSingle(int $period)
    {
        Subsidy::where('period_id', $period)->update([
            'single_standard' => 0,
            'single_add' => 0,
            'single' => 0,
        ]);
    }

    /**
     * 公积金.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function gjj(int $period, $data)
    {
        Insurances::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'gjj_classic' => $data['公积金标准'],
                'gjj_add' => $data['公积金补扣'],
                'gjj_enterprise' => $data['公积企业缴'],
                // 计算字段
                'gjj_person' => $data['公积金个人'],
                'gjj_deduction' => $data['公积金扣除'],
                'gjj_out_range' => $data['公积企超标'],
            ]
        );
    }

    /**
     * 重置当期公积金.
     *
     * @param int $period 会计期间ID
     */
    private function resetGjj(int $period)
    {
        Insurances::where('period_id', $period)->update([
            'gjj_classic' => 0,
            'gjj_add' => 0,
            'gjj_enterprise' => 0,
            'gjj_person' => 0,
            'gjj_deduction' => 0,
            'gjj_out_range' => 0,
        ]);
    }

    /**
     * 社保.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function insurances(int $period, $data)
    {
        Insurances::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'annuity_classic' => $data['年金标准'],
                'annuity_add' => $data['年金补扣'],
                'annuity_enterprise' => $data['年金企业缴'],
                'retire_classic' => $data['退养金标准'],
                'retire_add' => $data['退养金补扣'],
                'retire_enterprise' => $data['退养企业缴'],
                'medical_classic' => $data['医保金标准'],
                'medical_add' => $data['医保金补扣'],
                'medical_enterprise' => $data['医保企业缴'],
                'unemployment_classic' => $data['失业金标准'],
                'unemployment_add' => $data['失业金补扣'],
                'unemployment_enterprise' => $data['失业企业缴'],
                'injury_enterprise' => $data['工伤企业缴'],
                'birth_enterprise' => $data['生育企业缴'],
                // 计算字段
                'annuity_person' => $data['年金个人'],
                'annuity_deduction' => $data['年金扣除'],
                'annuity_out_range' => $data['年金企超标'],
                'retire_person' => $data['退养金个人'],
                'retire_deduction' => $data['退养金扣除'],
                'retire_out_range' => $data['退养企超标'],
                'medical_person' => $data['医保金个人'],
                'medical_deduction' => $data['医保金扣除'],
                'medical_out_range' => $data['医保企超标'],
                'unemployment_person' => $data['失业金个人'],
                'unemployment_deduction' => $data['失业金扣除'],
                'unemployment_out_range' => $data['失业企超标'],
            ]
        );
    }

    /**
     * 重置当期社保.
     *
     * @param int $period 会计期间ID
     */
    private function resetInsurances(int $period)
    {
        Insurances::where('period_id', $period)->update([
            'annuity_classic' => 0,
            'annuity_add' => 0,
            'annuity_enterprise' => 0,
            'retire_classic' => 0,
            'retire_add' => 0,
            'retire_enterprise' => 0,
            'medical_classic' => 0,
            'medical_add' => 0,
            'medical_enterprise' => 0,
            'unemployment_classic' => 0,
            'unemployment_add' => 0,
            'unemployment_enterprise' => 0,
            'injury_enterprise' => 0,
            'birth_enterprise' => 0,
            // 计算字段
            'annuity_person' => 0,
            'annuity_deduction' => 0,
            'annuity_out_range' => 0,
            'retire_person' => 0,
            'retire_deduction' => 0,
            'retire_out_range' => 0,
            'medical_person' => 0,
            'medical_deduction' => 0,
            'medical_out_range' => 0,
            'unemployment_person' => 0,
            'unemployment_deduction' => 0,
            'unemployment_out_range' => 0,
        ]);
    }

    /**
     * 车库.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function garage(int $period, $data)
    {
        $deduction = Deduction::where('period_id', $period)->where('policyNumber', $data['保险编号'])->count();

        if (0 == $deduction) {
            Deduction::create([
                'policyNumber' => $data['保险编号'],
                'period_id' => $period,
                'garage_water' => $data['车库水费'],
                'garage_electric' => $data['车库电费'],
                'garage_property' => $data['车库物管'],
            ]);
        } else {
            $sqlstring = 'UPDATE deduction d SET d.garage_water = d.garage_water + ? , d.garage_electric = d.garage_electric + ? , d.garage_property = d.garage_property + ?';
            $sqlstring .= ' WHERE d.period_id = ? AND d.policyNumber = ?';
            DB::update($sqlstring, [$data['车库水费'], $data['车库电费'], $data['车库物管'], $period, $data['保险编号']]);
        }
    }

    /**
     * 重置当期车库.
     *
     * @param int $period 会计期间ID
     */
    private function resetGarage(int $period)
    {
        Deduction::where('period_id', $period)->update([
            'garage_water' => 0,
            'garage_electric' => 0,
            'garage_property' => 0,
        ]);
    }

    /**
     * 成钞水电.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function ccWater(int $period, $data)
    {
        $deduction = Deduction::where('period_id', $period)->where('policyNumber', $data['保险编号'])->count();

        if (0 == $deduction) {
            Deduction::create([
                'policyNumber' => $data['保险编号'],
                'period_id' => $period,
                'cc_water' => $data['水费'],
                'cc_electric' => $data['电费'],
            ]);
        } else {
            $sqlstring = 'UPDATE deduction d SET d.cc_water = d.cc_water + ? , d.cc_electric = d.cc_electric + ? ';
            $sqlstring .= ' WHERE d.period_id = ? AND d.policyNumber = ?';
            DB::update($sqlstring, [$data['水费'], $data['电费'], $period, $data['保险编号']]);
        }
    }

    /**
     * 重置当期成钞水电.
     *
     * @param int $period 会计期间ID
     */
    private function resetCcWater(int $period)
    {
        Deduction::where('period_id', $period)->update([
            'cc_water' => 0,
            'cc_electric' => 0,
        ]);
    }

    /**
     * 成钞物管.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function ccProperty(int $period, $data)
    {
        $deduction = Deduction::where('period_id', $period)->where('policyNumber', $data['保险编号'])->count();

        if (0 == $deduction) {
            Deduction::create([
                'policyNumber' => $data['保险编号'],
                'period_id' => $period,
                'cc_property' => $data['合计'],
            ]);
        } else {
            $sqlstring = 'UPDATE deduction d SET d.cc_property = d.cc_property + ? ';
            $sqlstring .= ' WHERE d.period_id = ? AND d.policyNumber = ?';
            DB::update($sqlstring, [$data['合计'], $period, $data['保险编号']]);
        }
    }

    /**
     * 重置当期成钞物管.
     *
     * @param int $period 会计期间ID
     */
    private function resetCcProperty(int $period)
    {
        Deduction::where('period_id', $period)->update([
            'cc_property' => 0,
        ]);
    }

    /**
     * 鑫源费用.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function xyDeduction(int $period, $data)
    {
        $deduction = Deduction::where('period_id', $period)->where('policyNumber', $data['保险编号'])->count();

        if (0 == $deduction) {
            Deduction::create([
                'policyNumber' => $data['保险编号'],
                'period_id' => $period,
                'xy_water' => $data['水费'],
                'xy_electric' => $data['电费'],
                'xy_property' => $data['物管费'],
            ]);
        } else {
            $sqlstring = 'UPDATE deduction d SET d.xy_water = d.xy_water + ? , d.xy_electric = d.xy_electric + ? , d.xy_property = d.xy_property + ?';
            $sqlstring .= ' WHERE d.period_id = ? AND d.policyNumber = ?';
            DB::update($sqlstring, [$data['水费'], $data['电费'], $data['物管费'], $period, $data['保险编号']]);
        }
    }

    /**
     * 重置当期鑫源费用.
     *
     * @param int $period 会计期间ID
     */
    private function resetXyDeduction(int $period)
    {
        Deduction::where('period_id', $period)->update([
            'xy_water' => 0,
            'xy_electric' => 0,
            'xy_property' => 0,
        ]);
    }

    /**
     * 退补费用.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function backDeduction(int $period, $data)
    {
        $deduction = Deduction::where('period_id', $period)->where('policyNumber', $data['保险编号'])->count();

        if (0 == $deduction) {
            Deduction::create([
                'policyNumber' => $data['保险编号'],
                'period_id' => $period,
                'back_water' => $data['水费'],
                'back_electric' => $data['电费'],
                'back_property' => $data['物管费'],
            ]);
        } else {
            $sqlstring = 'UPDATE deduction d SET d.back_water = d.back_water + ? , d.back_electric = d.back_electric + ? , d.back_property = d.back_property + ?';
            $sqlstring .= ' WHERE d.period_id = ? AND d.policyNumber = ?';
            DB::update($sqlstring, [$data['水费'], $data['电费'], $data['物管费'], $period, $data['保险编号']]);
        }
    }

    /**
     * 重置当期退补费用.
     *
     * @param int $period 会计期间ID
     */
    private function resetBackDeduction(int $period)
    {
        Deduction::where('period_id', $period)->update([
            'back_water' => 0,
            'back_electric' => 0,
            'back_property' => 0,
        ]);
    }

    /**
     * 公车补扣除.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function carDeduction(int $period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'car_deduction' => $data['公车补扣除'],
                'car_deduction_comment' => $data['公车扣备注'],
            ]
        );
    }

    /**
     * 重置当期公车补扣除.
     *
     * @param int $period 会计期ID
     */
    private function resetCarDeduction(int $period)
    {
        Deduction::where('period_id', $period)->update([
            'car_deduction' => 0,
            'car_deduction_comment' => '',
        ]);
    }

    /**
     * 公车费用.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function carFee(int $period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'car_fee' => $data['金额'],
            ]
        );
    }

    /**
     * 重置当期公车费用.
     *
     * @param int $period 会计期ID
     */
    private function resetCarFee(int $period)
    {
        Deduction::where('period_id', $period)->update([
            'car_fee' => 0,
        ]);
    }

    /**
     * 它项扣除.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function restDeduction(int $period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'rest_deduction' => $data['金额'],
                'rest_deduction_comment' => $data['备注'],
            ]
        );
    }

    /**
     * 重置当期它项扣除.
     *
     * @param int $period 会计期ID
     */
    private function resetRestDeduction(int $period)
    {
        Deduction::where('period_id', $period)->update([
            'rest_deduction' => 0,
            'rest_deduction_comment' => '',
        ]);
    }

    /**
     * 固定扣款.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function fixedDeduction(int $period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'fixed_deduction' => $data['固定扣款'],
            ]
        );
    }

    /**
     * 重置当期固定扣款.
     *
     * @param int $period 会计期ID
     */
    private function resetFixedDeduction(int $period)
    {
        Deduction::where('period_id', $period)->update([
            'fixed_deduction' => 0,
        ]);
    }

    /**
     * 临时扣款.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function tempDeduction(int $period, $data)
    {
        $deduction = Deduction::where('period_id', $period)->where('policyNumber', $data['保险编号'])->count();

        if (0 == $deduction) {
            Deduction::create([
                'policyNumber' => $data['保险编号'],
                'period_id' => $period,
                'temp_deduction' => $data['金额'],
            ]);
        } else {
            $sqlstring = 'UPDATE deduction d SET d.temp_deduction = d.temp_deduction + ? ';
            $sqlstring .= ' WHERE d.period_id = ? AND d.policyNumber = ?';
            DB::update($sqlstring, [$data['金额'], $period, $data['保险编号']]);
        }
    }

    /**
     * 重置当期临时扣款.
     *
     * @param int $period 会计期ID
     */
    private function resetTempDeduction(int $period)
    {
        Deduction::where('period_id', $period)->update([
            'temp_deduction' => 0,
        ]);
    }

    /**
     * 其他扣款.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function otherDeduction(int $period, $data)
    {
        $deduction = Deduction::where('period_id', $period)->where('policyNumber', $data['保险编号'])->count();

        if (0 == $deduction) {
            Deduction::create([
                'policyNumber' => $data['保险编号'],
                'period_id' => $period,
                'other_deduction' => $data['金额'],
            ]);
        } else {
            $sqlstring = 'UPDATE deduction d SET d.other_deduction = d.other_deduction + ? ';
            $sqlstring .= ' WHERE d.period_id = ? AND d.policyNumber = ?';
            DB::update($sqlstring, [$data['金额'], $period, $data['保险编号']]);
        }
    }

    /**
     * 重置当期其他扣款.
     *
     * @param int $period 会计期ID
     */
    private function resetOtherDeduction(int $period)
    {
        Deduction::where('period_id', $period)->update([
            'other_deduction' => 0,
        ]);
    }

    /**
     * 扣工会会费.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function unionDeduction(int $period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'union_deduction' => $data['工会会费'],
            ]
        );
    }

    /**
     * 重置当期扣工会会费.
     *
     * @param int $period 会计期ID
     */
    private function resetUnionDeduction(int $period)
    {
        Deduction::where('period_id', $period)->update([
            'union_deduction' => 0,
        ]);
    }

    /**
     * 捐赠.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function donate(int $period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'donate' => $data['金额'],
            ]
        );
    }

    /**
     * 重置当期捐赠.
     *
     * @param int $period 会计期ID
     */
    private function resetDonate(int $period)
    {
        Deduction::where('period_id', $period)->update([
            'donate' => 0,
        ]);
    }

    /**
     * 财务发稿酬.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function financeArticle(int $period, $data)
    {
        $other = Other::where('period_id', $period)->where('policyNumber', $data['保险编号'])->count();

        if (0 == $other) {
            Other::create([
                'policyNumber' => $data['保险编号'],
                'period_id' => $period,
                'finance_article' => $data['金额'],
            ]);
        } else {
            Other::where('period_id', $period)->where('policyNumber', $data['保险编号'])
                ->increment('finance_article', $data['金额']);
        }
    }

    /**
     * 重置当期财务发稿酬.
     *
     * @param int $period 会计期ID
     */
    private function resetFinanceArticle(int $period)
    {
        Other::where('period_id', $period)->update([
            'finance_article' => 0,
        ]);
    }

    /**
     * 工会发稿酬.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function unionArticle(int $period, $data)
    {
        $other = Other::where('period_id', $period)->where('policyNumber', $data['保险编号'])->count();

        if (0 == $other) {
            Other::create([
                'policyNumber' => $data['保险编号'],
                'period_id' => $period,
                'union_article' => $data['金额'],
            ]);
        } else {
            Other::where('period_id', $period)->where('policyNumber', $data['保险编号'])
                ->increment('union_article', $data['金额']);
        }
    }

    /**
     * 重置当期工会发稿酬.
     *
     * @param int $period 会计期ID
     */
    private function resetUnionArticle(int $period)
    {
        Other::where('period_id', $period)->update([
            'union_article' => 0,
        ]);
    }

    /**
     * 特许使用权.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function franchise(int $period, $data)
    {
        Other::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'franchise' => $data['金额'],
            ]
        );
    }

    /**
     * 重置当期特许使用权.
     *
     * @param int $period 会计期ID
     */
    private function resetFranchise(int $period)
    {
        Other::where('period_id', $period)->update([
            'franchise' => 0,
        ]);
    }

    /**
     * 已销欠款.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function hadDebt(int $period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'had_debt' => $data['已销欠款'],
            ]
        );
    }

    /**
     * 重置当期已销欠款.
     *
     * @param int $period 会计期ID
     */
    private function resetHadDebt(int $period)
    {
        Deduction::where('period_id', $period)->update([
            'had_debt' => 0,
        ]);
    }

    /**
     * 专项税务.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function taxImport(int $period, $data)
    {
        TaxImport::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'income' => $data['累计收入额'],
                'deduct_expenses' => $data['累计减除费用'],
                'special_deduction' => $data['累计专项扣除'],
                'tax_child' => $data['累计子女教育支出扣除'],
                'tax_old' => $data['累计赡养老人支出扣除'],
                'tax_edu' => $data['累计继续教育支出扣除'],
                'tax_loan' => $data['累计住房贷款利息支出扣除'],
                'tax_rent' => $data['累计住房租金支出扣除'],
                'tax_other_deduct' => $data['累计其他扣除'],
                'deduct_donate' => $data['累计准予扣除的捐赠'],
                'tax_income' => $data['累计应纳税所得额'],
                'taxrate' => $data['税率'],
                'quick_deduction' => $data['速算扣除数'],
                'taxable' => $data['累计应纳税额'],
                'tax_reliefs' => $data['累计减免税额'],
                'should_deducted_tax' => $data['累计应扣缴税额'],
                'have_deducted_tax' => $data['累计已预缴税额'],
                'should_be_tax' => $data['累计应补(退)税额'],
            ]
        );
    }

    /**
     * 重置当期专项税务.
     *
     * @param int $period 会计期ID
     */
    private function resetTaxImport(int $period)
    {
        TaxImport::where('period_id', $period)->update([
            'income' => 0,
            'deduct_expenses' => 0,
            'special_deduction' => 0,
            'tax_child' => 0,
            'tax_old' => 0,
            'tax_edu' => 0,
            'tax_loan' => 0,
            'tax_rent' => 0,
            'tax_other_deduct' => 0,
            'deduct_donate' => 0,
            'tax_income' => 0,
            'taxrate' => 0,
            'quick_deduction' => 0,
            'taxable' => 0,
            'tax_reliefs' => 0,
            'should_deducted_tax' => 0,
            'have_deducted_tax' => 0,
            'should_be_tax' => 0,
        ]);
    }

    /**
     * 税务计算_工资薪金导入.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function salaryImport(int $period, $data)
    {
        taxImport::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['工号']],
            [
                'should_be_tax' => 0,
            ]
        );
    }

    /**
     * 重置当期工资薪金导入.
     *
     * @param int $period 会计期ID
     */
    private function resetSalaryImport(int $period)
    {
        taxImport::where('period_id', $period)->update([
            'should_be_tax' => 0,
            'reduce_tax' => 0,
        ]);
    }

    /**
     * 计算当期减免个税.
     *
     * @param int $period 会计期ID
     */
    private function calSalaryTax(int $period)
    {
        $sqlstring = 'UPDATE taxImport t';
        $sqlstring .= ' LEFT JOIN userprofile up ON t.policyNumber = up.policyNumber ';
        $sqlstring .= ' AND t.period_id = ?';
        $sqlstring .= ' SET t.reduce_tax = t.should_be_tax * up.tax_rebates';
        $sqlstring .= ' WHERE t.policyNumber = up.policyNumber';
        DB::update($sqlstring, [$period]);
    }

    /**
     * 税务计算_稿酬导入.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function articleImport(int $period, $data)
    {
        Other::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['工号']],
            [
                'article_add_tax' => $data['累计应补(退)税额'],
            ]
        );
    }

    /**
     * 重置当期稿酬导入.
     *
     * @param int $period 会计期ID
     */
    private function resetArticleImport(int $period)
    {
        Other::where('period_id', $period)->update([
            'article_add_tax' => 0,
            'article_sub_tax' => 0,
        ]);
    }

    /**
     * 计算当期稿酬减免税.
     *
     * @param int $period 会计期ID
     */
    private function calArticeTax(int $period)
    {
        $sqlstring = 'UPDATE other o';
        $sqlstring .= ' LEFT JOIN userprofile up ON o.policyNumber = up.policyNumber ';
        $sqlstring .= ' AND o.period_id = ?';
        $sqlstring .= ' SET o.article_sub_tax = o.article_add_tax * up.tax_rebates';
        $sqlstring .= ' WHERE o.policyNumber = up.policyNumber';
        DB::update($sqlstring, [$period]);
    }

    /**
     * 税务计算_特许权导入.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function franchiseImport(int $period, $data)
    {
        Other::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['工号']],
            [
                'franchise_add_tax' => $data['累计应补(退)税额'],
            ]
        );
    }

    /**
     * 重置当期特许权导入.
     *
     * @param int $period 会计期ID
     */
    private function resetFranchiseImport(int $period)
    {
        Other::where('period_id', $period)->update([
            'franchise_add_tax' => 0,
            'franchise_sub_tax' => 0,
        ]);
    }

    /**
     * 计算当期特权减免税.
     *
     * @param int $period 会计期ID
     */
    private function calFranchiseTax(int $period)
    {
        $sqlstring = 'UPDATE other o';
        $sqlstring .= ' LEFT JOIN userprofile up ON o.policyNumber = up.policyNumber ';
        $sqlstring .= ' AND o.period_id = ?';
        $sqlstring .= ' SET o.franchise_sub_tax = o.franchise_add_tax * up.tax_rebates';
        $sqlstring .= ' WHERE o.policyNumber = up.policyNumber';
        DB::update($sqlstring, [$period]);
    }

    /**
     * 薪金申报个税导入.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function declareTaxSalary(int $period, $data)
    {
        taxImport::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['工号']],
            [
                'declare_tax_salary' => 0,
            ]
        );
    }

    /**
     * 重置当期薪金申报个税.
     *
     * @param int $period 会计期ID
     */
    private function resetDeclareTaxSalary(int $period)
    {
        taxImport::where('period_id', $period)->update([
            'declare_tax_salary' => 0,
        ]);
    }

    /**
     * 稿酬申报个税导入.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function declareTaxArticle(int $period, $data)
    {
        taxImport::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['工号']],
            [
                'declare_tax_article' => 0,
            ]
        );
    }

    /**
     * 重置当期稿酬申报个税.
     *
     * @param int $period 会计期ID
     */
    private function resetDeclareTaxArticle(int $period)
    {
        taxImport::where('period_id', $period)->update([
            'declare_tax_article' => 0,
        ]);
    }

    /**
     * 特权申报个税导入.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function declareTaxFranchise(int $period, $data)
    {
        taxImport::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['工号']],
            [
                'declare_tax_franchise' => 0,
            ]
        );
    }

    /**
     * 重置当期特权申报个税.
     *
     * @param int $period 会计期ID
     */
    private function resetDeclareTaxFranchise(int $period)
    {
        taxImport::where('period_id', $period)->update([
            'declare_tax_franchise' => 0,
        ]);
    }
}
