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
        $sqlstring = 'select d.dwdm, d.name, count(u.user_id) as sum_number, count(u.user_id) as sum_number, ';
        // 工资部分
        $sqlstring .= 'IFNULL(sum(w.wage),0) as wage, IFNULL(sum(w.retained_wage),0) as retained_wage, ';
        $sqlstring .= 'IFNULL(sum(w.compensation),0) as compensation, IFNULL(sum(w.night_shift),0) as night_shift, ';
        $sqlstring .= 'IFNULL(sum(w.overtime_wage),0) as overtime_wage, IFNULL(sum(w.seniority_wage),0) as seniority_wage, ';
        $sqlstring .= 'IFNULL(sum(w.jbylj),0) as jbylj, IFNULL(sum(w.zj),0) as zj, ';
        $sqlstring .= 'IFNULL(sum(w.gjxj),0) as gjxj, IFNULL(sum(w.dfxj),0) as dfxj, IFNULL(sum(w.hyxj),0) as hyxj, ';
        $sqlstring .= 'IFNULL(sum(w.qydzf),0) as qydzf, IFNULL(sum(w.qyxj),0) as qyxj, ';
        $sqlstring .= 'IFNULL(sum(w.ltxbc),0) as ltxbc, IFNULL(sum(w.wage_total),0) as wage_total, ';
        // 月奖（特殊情况）
        $sqlstring .= 'IFNULL(sum(tb.month_bonus),0) as month_bonus, ';
        // 补贴
        $sqlstring .= 'IFNULL(sum(s.communication),0) as communication, IFNULL(sum(s.traffic),0) as traffic, ';
        $sqlstring .= 'IFNULL(sum(s.housing),0) as housing, IFNULL(sum(s.single),0) as single, ';
        // 补发
        $sqlstring .= 'IFNULL(sum(r.reissue_wage),0) as reissue_wage, IFNULL(sum(r.reissue_subsidy),0) as reissue_subsidy, ';
        $sqlstring .= 'IFNULL(sum(r.reissue_other),0) as reissue_other, IFNULL(sum(r.reissue_total),0) as reissue_total, ';
        // 社保
        $sqlstring .= 'IFNULL(sum(i.gjj_person),0) as gjj_person, IFNULL(sum(i.gjj_enterprise),0) as gjj_enterprise, ';
        $sqlstring .= 'IFNULL(sum(i.annuity_person),0) as annuity_person, IFNULL(sum(i.annuity_enterprise),0) as annuity_enterprise, ';
        $sqlstring .= 'IFNULL(sum(i.retire_person),0) as retire_person, IFNULL(sum(i.retire_enterprise),0) as retire_enterprise, ';
        $sqlstring .= 'IFNULL(sum(i.medical_person),0) as medical_person, IFNULL(sum(i.medical_enterprise),0) as medical_enterprise, ';
        $sqlstring .= 'IFNULL(sum(i.unemployment_person),0) as unemployment_person, IFNULL(sum(i.unemployment_enterprise),0) as unemployment_enterprise, ';
        $sqlstring .= 'IFNULL(sum(i.injury_enterprise),0) as injury_enterprise, IFNULL(sum(i.birth_enterprise),0) as birth_enterprise, ';
        // 扣款
        $sqlstring .= 'IFNULL(sum(de.cc_water),0) as cc_water, IFNULL(sum(de.cc_electric),0) as cc_electric, ';
        $sqlstring .= 'IFNULL(sum(de.xy_water),0) as xy_water, IFNULL(sum(de.xy_electric),0) as xy_electric, ';
        $sqlstring .= 'IFNULL(sum(de.garage_water),0) as garage_water, IFNULL(sum(de.garage_electric),0) as garage_electric, ';
        $sqlstring .= 'IFNULL(sum(de.back_water),0) as back_water, IFNULL(sum(de.back_electric),0) as back_electric, ';
        $sqlstring .= 'IFNULL(sum(de.water_electric),0) as water_electric, IFNULL(sum(de.property_fee),0) as property_fee, ';
        $sqlstring .= 'IFNULL(sum(de.union_deduction),0) as union_deduction, IFNULL(sum(de.car_fee),0) as car_fee, ';
        $sqlstring .= 'IFNULL(sum(de.fixed_deduction),0) as fixed_deduction, IFNULL(sum(de.temp_deduction),0) as temp_deduction, IFNULL(sum(de.other_deduction),0) as other_deduction, ';
        $sqlstring .= 'IFNULL(sum(de.prior_deduction),0) as prior_deduction, IFNULL(sum(de.had_debt),0) as had_debt, IFNULL(sum(de.debt),0) as debt, ';
        $sqlstring .= 'IFNULL(sum(de.tax_diff),0) as tax_diff, IFNULL(sum(de.personal_tax),0) as personal_tax, ';
        // 特殊
        $sqlstring .= 'IFNULL(sum(sp.instead_salary),0) as instead_salary, IFNULL(sum(sp.bank_salary),0) as bank_salary, ';
        $sqlstring .= 'IFNULL(sum(sp.debt_salary),0) as debt_salary, IFNULL(sum(sp.court_salary),0) as court_salary ';

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

    public function transformData($data, $pid)
    {
        $statistic = VoucherStatistic::where('period_id', $pid)->get()->toArray();
        return $data;
    }
}
