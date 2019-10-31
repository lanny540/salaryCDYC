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

class SalaryRepository
{
    /**
     * 插入或更新数据.
     * TODO: 考虑多次上传的情况:新增或更新.
     *
     * @param int   $periodId   会计期ID
     * @param int   $uploadType 数据上传类型
     * @param array $data       数据
     */
    public function saveToTable($periodId, $uploadType, $data)
    {
        switch ($uploadType) {
            case 7: //减免税率
                foreach ($data as $d) {
                    $this->taxRebates($d);
                }
                break;
            case 9: //职工工资在岗
                foreach ($data as $d) {
                    $this->employeesWage($periodId, $d);
                }
                break;
            case 10: //离岗休养
                foreach ($data as $d) {
                    $this->lgxy($periodId, $d);
                }
                break;
            case 11: // 退休数据
                foreach ($data as $d) {
                    $this->txsj($periodId, $d);
                }
                break;
            case 12: //月奖
                foreach ($data as $d) {
                    $this->monthBonus($periodId, $d);
                }
                break;
            case 13: //专项奖
                foreach ($data as $d) {
                    $this->specialBonus($periodId, $d);
                }
                break;
            case 14: //劳动竞赛
                foreach ($data as $d) {
                    $this->competitionBonus($periodId, $d);
                }
                break;
            case 15: //课酬
                foreach ($data as $d) {
                    $this->classRewardBonus($periodId, $d);
                }
                break;
            case 16: //节日慰问费
                foreach ($data as $d) {
                    $this->holidayBonus($periodId, $d);
                }
                break;
            case 17: //党员奖励
                foreach ($data as $d) {
                    $this->partyRewardBonus($periodId, $d);
                }
                break;
            case 18: //工会发放
                foreach ($data as $d) {
                    $this->unionPayingBonus($periodId, $d);
                }
                break;
            case 19: //其他奖励
                foreach ($data as $d) {
                    $this->otherRewardBonus($periodId, $d);
                }
                break;
            case 20: //住房补贴
                foreach ($data as $d) {
                    $this->housing($periodId, $d);
                }
                break;
            case 21: //独子费
                foreach ($data as $d) {
                    $this->single($periodId, $d);
                }
                break;
            case 22: //公积金
                foreach ($data as $d) {
                    $this->gjj($periodId, $d);
                }
                break;
            case 23: //社保
                foreach ($data as $d) {
                    $this->insurances($periodId, $d);
                }
                break;
            case 24: //车库
                foreach ($data as $d) {
                    $this->garage($periodId, $d);
                }
                break;
            case 25: //成钞水电
                foreach ($data as $d) {
                    $this->ccWater($periodId, $d);
                }
                break;
            case 26: //成钞物管
                foreach ($data as $d) {
                    $this->ccProperty($periodId, $d);
                }
                break;
            case 27: //鑫源
                foreach ($data as $d) {
                    $this->xyDeduction($periodId, $d);
                }
                break;
            case 28: //水电物管退补
                foreach ($data as $d) {
                    $this->backDeduction($periodId, $d);
                }
                break;
            case 29: //公车补扣除
                foreach ($data as $d) {
                    $this->carDeduction($periodId, $d);
                }
                break;
            case 30: //公车费用
                foreach ($data as $d) {
                    $this->carFee($periodId, $d);
                }
                break;
            case 31: //它项扣除
                foreach ($data as $d) {
                    $this->restDeduction($periodId, $d);
                }
                break;
            case 32: //固定扣款
                foreach ($data as $d) {
                    $this->fixedDeduction($periodId, $d);
                }
                break;
            case 33: //临时扣款
                foreach ($data as $d) {
                    $this->tempDeduction($periodId, $d);
                }
                break;
            case 34: //其他扣款
                foreach ($data as $d) {
                    $this->otherDeduction($periodId, $d);
                }
                break;
            case 35: //扣工会会费
                foreach ($data as $d) {
                    $this->unionDeduction($periodId, $d);
                }
                break;
            case 36: //捐赠
                foreach ($data as $d) {
                    $this->donate($periodId, $d);
                }
                break;
            case 37: //财务发稿酬
                foreach ($data as $d) {
                    $this->financeArticle($periodId, $d);
                }
                break;
            case 38: //工会发稿酬
                foreach ($data as $d) {
                    $this->unionArticle($periodId, $d);
                }
                break;
            case 39: //特许使用权
                foreach ($data as $d) {
                    $this->franchise($periodId, $d);
                }
                break;
            case 40: //已销欠款
                foreach ($data as $d) {
                    $this->hadDebt($periodId, $d);
                }
                break;
            case 41: //专项税务
                foreach ($data as $d) {
                    $this->taxImport($periodId, $d);
                }
                break;
            default:
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
     * 在岗职工工资.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function employeesWage($period, $data)
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
     * 离岗休养.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function lgxy($period, $data)
    {
        Wage::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'lggw' => $data['内岗位'],
                'lgbl' => $data['内保留'],
                'lgzj' => $data['内增加'],
                'lgng' => $data['年功工资'],
                // 计算字段
                'jbylj' => $data['基本养老金'],
            ]
        );
    }

    /**
     * 退休数据.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function txsj($period, $data)
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
     * 月奖.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function monthBonus($period, $data)
    {
        Bonus::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'month_bonus' => $data['金额'],
            ]
        );
    }

    /**
     * 专项奖.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function specialBonus($period, $data)
    {
        Bonus::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'special' => $data['金额'],
            ]
        );
    }

    /**
     * 劳动竞赛.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function competitionBonus($period, $data)
    {
        Bonus::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'competition' => $data['金额'],
            ]
        );
    }

    /**
     * 课酬.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function classRewardBonus($period, $data)
    {
        Bonus::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'class_reward' => $data['金额'],
            ]
        );
    }

    /**
     * 节日慰问费.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function holidayBonus($period, $data)
    {
        Bonus::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'holiday' => $data['节日慰问费'],
            ]
        );
    }

    /**
     * 党员奖励.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function partyRewardBonus($period, $data)
    {
        Bonus::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'party_reward' => $data['金额'],
            ]
        );
    }

    /**
     * 工会发放.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function unionPayingBonus($period, $data)
    {
        Bonus::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'union_paying' => $data['金额'],
            ]
        );
    }

    /**
     * 其他奖励.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function otherRewardBonus($period, $data)
    {
        Bonus::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'other_reward' => $data['金额'],
            ]
        );
    }

    /**
     * 住房补贴.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function housing($period, $data)
    {
        Subsidy::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'housing' => $data['住房补贴'],
            ]
        );
    }

    /**
     * 独子费.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function single($period, $data)
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
     * 公积金.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function gjj($period, $data)
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
     * 社保.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function insurances($period, $data)
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
     * 车库.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function garage($period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'garage_water' => $data['车库水费'],
                'garage_electric' => $data['车库电费'],
                'garage_property' => $data['车库物管'],
            ]
        );
    }

    /**
     * 成钞水电.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function ccWater($period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'cc_water' => $data['水费'],
                'cc_electric' => $data['电费'],
            ]
        );
    }

    /**
     * 成钞物管.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function ccProperty($period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'cc_property' => $data['合计'],
            ]
        );
    }

    /**
     * 鑫源费用.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function xyDeduction($period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'xy_water' => $data['水费'],
                'xy_electric' => $data['电费'],
                'xy_property' => $data['物管费'],
            ]
        );
    }

    /**
     * 退补费用.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function backDeduction($period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'back_water' => $data['水费'],
                'back_electric' => $data['电费'],
                'back_property' => $data['物管费'],
            ]
        );
    }

    /**
     * 公车补扣除.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function carDeduction($period, $data)
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
     * 公车费用.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function carFee($period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'car_fee' => $data['金额'],
            ]
        );
    }

    /**
     * 它项扣除.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function restDeduction($period, $data)
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
     * 固定扣款.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function fixedDeduction($period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'fixed_deduction' => $data['固定扣款'],
            ]
        );
    }

    /**
     * 临时扣款.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function tempDeduction($period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'temp_deduction' => $data['金额'],
            ]
        );
    }

    /**
     * 其他扣款.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function otherDeduction($period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'other_deduction' => $data['金额'],
            ]
        );
    }

    /**
     * 扣工会会费.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function unionDeduction($period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'union_deduction' => $data['工会会费'],
            ]
        );
    }

    /**
     * 捐赠.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function donate($period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'donate' => $data['金额'],
            ]
        );
    }

    /**
     * 财务发稿酬.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function financeArticle($period, $data)
    {
        Other::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'finance_article' => $data['金额'],
            ]
        );
    }

    /**
     * 工会发稿酬.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function unionArticle($period, $data)
    {
        Other::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'union_article' => $data['金额'],
            ]
        );
    }

    /**
     * 特许使用权.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function franchise($period, $data)
    {
        Other::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'franchise' => $data['金额'],
            ]
        );
    }

    /**
     * 已销欠款.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function hadDebt($period, $data)
    {
        Deduction::updateOrCreate(
            ['period_id' => $period, 'policyNumber' => $data['保险编号']],
            [
                'had_debt' => $data['已销欠款'],
            ]
        );
    }

    /**
     * 专项税务.
     *
     * @param int $period 会计期ID
     * @param $data
     */
    private function taxImport($period, $data)
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
}
