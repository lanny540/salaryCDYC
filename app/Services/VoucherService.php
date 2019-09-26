<?php

namespace App\Services;

use App\Models\Voucher\VoucherStatistic;
use DB;

class VoucherService
{
    /**
     * 计算当前凭证汇总数据.
     *
     * @param $periodId
     *
     * @return array
     */
    public function generateSheet($periodId)
    {
        // TODO: 字段需要改成英文，方便直接插入汇总表
        $sqlstring = 'select d.dwdm, d.name, count(u.user_id) as sum_number, count(u.user_id) as sum_number, ';
        // 工资部分
        $sqlstring .= 'IFNULL(sum(w.wage),0) as 岗位工资, IFNULL(sum(w.retained_wage),0) as 保留工资, IFNULL(sum(w.compensation),0) as 套级补差, ';
        $sqlstring .= 'IFNULL(sum(w.night_shift),0) as 中夜班费, IFNULL(sum(w.overtime_wage),0) as 加班工资, IFNULL(sum(w.seniority_wage),0) as 年功工资, ';
        $sqlstring .= 'IFNULL(sum(w.jbylj),0) as 基本养老金, IFNULL(sum(w.zj),0) as 增机, ';
        $sqlstring .= 'IFNULL(sum(w.gjxj),0) as 国家小计, IFNULL(sum(w.dfxj),0) as 地方小计, IFNULL(sum(w.hyxj),0) as 行业小计, ';
        $sqlstring .= 'IFNULL(sum(w.qydzf),0) as 企业独子费, IFNULL(sum(w.qyxj),0) as 企业小计, ';
        $sqlstring .= 'IFNULL(sum(w.ltxbc),0) as 离退休补充, IFNULL(sum(w.wage_total),0) as 应发工资, ';
        // 月奖（特殊情况）
        $sqlstring .= 'IFNULL(sum(tb.month_bonus),0) as 月奖, ';
        // 补贴
        $sqlstring .= 'IFNULL(sum(s.communication),0) as 通讯补贴, IFNULL(sum(s.traffic),0) as 交通费, ';
        $sqlstring .= 'IFNULL(sum(s.housing),0) as 住房补贴, IFNULL(sum(s.single),0) as 独子费, ';
        // 补发
        $sqlstring .= 'IFNULL(sum(r.reissue_wage),0) as 补发工资, IFNULL(sum(r.reissue_subsidy),0) as 补发补贴, ';
        $sqlstring .= 'IFNULL(sum(r.reissue_other),0) as 补发其他, IFNULL(sum(r.reissue_total),0) as 补发合计, ';
        // 社保
        $sqlstring .= 'IFNULL(sum(i.gjj_person),0) as 公积金个人, IFNULL(sum(i.gjj_enterprise),0) as 公积企业缴, ';
        $sqlstring .= 'IFNULL(sum(i.annuity_person),0) as 年金个人, IFNULL(sum(i.annuity_enterprise),0) as 年金企业缴, ';
        $sqlstring .= 'IFNULL(sum(i.retire_person),0) as 退养金个人, IFNULL(sum(i.retire_enterprise),0) as 退养企业缴, ';
        $sqlstring .= 'IFNULL(sum(i.medical_person),0) as 医保金个人, IFNULL(sum(i.medical_enterprise),0) as 医疗企业缴, ';
        $sqlstring .= 'IFNULL(sum(i.unemployment_person),0) as 失业金个人, IFNULL(sum(i.unemployment_enterprise),0) as 失业企业缴, ';
        $sqlstring .= 'IFNULL(sum(i.injury_enterprise),0) as 工伤企业缴, IFNULL(sum(i.birth_enterprise),0) as 生育企业缴, ';
        // 扣款
        $sqlstring .= 'IFNULL(sum(de.cc_water),0) as 成钞水费, IFNULL(sum(de.cc_electric),0) as 成钞电费, ';
        $sqlstring .= 'IFNULL(sum(de.xy_water),0) as 鑫源水费, IFNULL(sum(de.xy_electric),0) as 鑫源电费, ';
        $sqlstring .= 'IFNULL(sum(de.garage_water),0) as 车库水费, IFNULL(sum(de.garage_electric),0) as 车库电费, ';
        $sqlstring .= 'IFNULL(sum(de.back_water),0) as 退补水费, IFNULL(sum(de.back_electric),0) as 退补电费, ';
        $sqlstring .= 'IFNULL(sum(de.water_electric),0) as 水电, IFNULL(sum(de.property_fee),0) as 物管费, ';
        $sqlstring .= 'IFNULL(sum(de.union_deduction),0) as 扣工会会费, IFNULL(sum(de.car_fee),0) as 公车费用, ';
        $sqlstring .= 'IFNULL(sum(de.fixed_deduction),0) as 固定扣款, IFNULL(sum(de.temp_deduction),0) as 临时扣款, IFNULL(sum(de.other_deduction),0) as 其他扣款, ';
        $sqlstring .= 'IFNULL(sum(de.prior_deduction),0) as 上期余欠款, IFNULL(sum(de.had_debt),0) as 已销欠款, IFNULL(sum(de.debt),0) as 扣欠款, ';
        $sqlstring .= 'IFNULL(sum(de.tax_diff),0) as 税差, IFNULL(sum(de.personal_tax),0) as 个人所得税, ';
        // 特殊
        $sqlstring .= 'IFNULL(sum(sp.instead_salary),0) as 代汇, IFNULL(sum(sp.bank_salary),0) as 银行发放, ';
        $sqlstring .= 'IFNULL(sum(sp.debt_salary),0) as 余欠款, IFNULL(sum(sp.court_salary),0) as 法院转提 ';

        $sqlstring .= 'from departments d ';
        $sqlstring .= 'left join userprofile u on d.id = u.department_id ';
        $sqlstring .= 'left join wage w on u.policyNumber = w.policyNumber and w.period_id = :pid1 ';
        $sqlstring .= 'left join tempbonus tb on d.dwdm = tb.dwdm ';  // 临时奖金表没有会计期.dwdm可能会与基础数据不一致.
        $sqlstring .= 'left join subsidy s on u.policyNumber = s.policyNumber and s.period_id = :pid3 ';
        $sqlstring .= 'left join reissue r on u.policyNumber = r.policyNumber and r.period_id = :pid4 ';
        $sqlstring .= 'left join insurances i on u.policyNumber = i.policyNumber and i.period_id = :pid5 ';
        $sqlstring .= 'left join deduction de on u.policyNumber = de.policyNumber and de.period_id = :pid6 ';
        $sqlstring .= 'left join special sp on u.policyNumber = sp.policyNumber and sp.period_id = :pid7 ';
        $sqlstring .= 'where d.dwdm like "01%" ';
        $sqlstring .= 'group by d.dwdm, d.name';

        $data = DB::select($sqlstring, [
            ':pid1' => $periodId,
            ':pid3' => $periodId,
            ':pid4' => $periodId,
            ':pid5' => $periodId,
            ':pid6' => $periodId,
            ':pid7' => $periodId,
        ]);

        return $data;
    }

    /**
     * 删除该会计期的凭证汇总数据.
     *
     * @param $periodId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSheet($periodId)
    {
        $data = VoucherStatistic::where('period_id', $periodId)->delete();

        return response()->json([
            'status' => $data,
            'msg' => '所选会计期的凭证汇总表数据已删除!',
        ]);
    }
}
