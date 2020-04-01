<?php

namespace App\Services;

use App\Models\Voucher\VoucherStatistic;
use App\Models\Voucher\VoucherTemplate;
use Carbon\Carbon;
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
    public function generateSheet($periodId): array
    {
        $sqlstring = 'SELECT d.dwdm, d.name, COUNT(up.user_id) AS sum_number,';
        $sqlstring .= 'IFNULL(sum(up.wage),0) as wage, IFNULL(sum(up.retained_wage),0) as retained_wage,';
        $sqlstring .= 'IFNULL(sum(up.compensation),0) as compensation, IFNULL(sum(up.night_shift),0) as night_shift,';
        $sqlstring .= 'IFNULL(sum(up.overtime_wage),0) as overtime_wage, IFNULL(sum(up.seniority_wage),0) as seniority_wage,';
        $sqlstring .= 'IFNULL(sum(up.jbylj),0) as jbylj, IFNULL(sum(up.zj),0) as zj,';
        $sqlstring .= 'IFNULL(sum(up.gjxj),0) as gjxj, IFNULL(sum(up.dfxj),0) as dfxj, IFNULL(sum(up.hyxj),0) as hyxj,';
        $sqlstring .= 'IFNULL(sum(up.qydzf),0) as qydzf, IFNULL(sum(up.qyxj),0) as qyxj,';
        $sqlstring .= 'IFNULL(sum(up.ltxbc),0) as ltxbc, IFNULL(sum(up.wage_total),0) as wage_total,';
        $sqlstring .= 'IFNULL(sum(up.month_bonus),0) as month_bonus,';
        $sqlstring .= 'IFNULL(sum(up.communication),0) as communication, IFNULL(sum(up.traffic),0) as traffic,';
        $sqlstring .= 'IFNULL(sum(up.housing),0) as housing, IFNULL(sum(up.single),0) as single,';
        $sqlstring .= 'IFNULL(sum(up.reissue_wage),0) as reissue_wage, IFNULL(sum(up.reissue_subsidy),0) as reissue_subsidy,';
        $sqlstring .= 'IFNULL(sum(up.reissue_other),0) as reissue_other, IFNULL(sum(up.reissue_total),0) as reissue_total,';
        $sqlstring .= 'IFNULL(sum(up.gjj_person),0) as gjj_person, IFNULL(sum(up.gjj_enterprise),0) as gjj_enterprise,';
        $sqlstring .= 'IFNULL(sum(up.annuity_person),0) as annuity_person, IFNULL(sum(up.annuity_enterprise),0) as annuity_enterprise,';
        $sqlstring .= 'IFNULL(sum(up.retire_person),0) as retire_person, IFNULL(sum(up.retire_enterprise),0) as retire_enterprise,';
        $sqlstring .= 'IFNULL(sum(up.medical_person),0) as medical_person, IFNULL(sum(up.medical_enterprise),0) as medical_enterprise,';
        $sqlstring .= 'IFNULL(sum(up.unemployment_person),0) as unemployment_person, IFNULL(sum(up.unemployment_enterprise),0) as unemployment_enterprise,';
        $sqlstring .= 'IFNULL(sum(up.injury_enterprise),0) as injury_enterprise, IFNULL(sum(up.birth_enterprise),0) as birth_enterprise,';
        $sqlstring .= 'IFNULL(sum(up.cc_water),0) as cc_water, IFNULL(sum(up.cc_electric),0) as cc_electric,';
        $sqlstring .= 'IFNULL(sum(up.xy_water),0) as xy_water, IFNULL(sum(up.xy_electric),0) as xy_electric,';
        $sqlstring .= 'IFNULL(sum(up.garage_water),0) as garage_water, IFNULL(sum(up.garage_electric),0) as garage_electric,';
        $sqlstring .= 'IFNULL(sum(up.back_water),0) as back_water, IFNULL(sum(up.back_electric),0) as back_electric,';
        $sqlstring .= 'IFNULL(sum(up.water_electric),0) as water_electric, IFNULL(sum(up.property_fee),0) as property_fee,';
        $sqlstring .= 'IFNULL(sum(up.union_deduction),0) as union_deduction, IFNULL(sum(up.car_fee),0) as car_fee,';
        $sqlstring .= 'IFNULL(sum(up.fixed_deduction),0) as fixed_deduction, IFNULL(sum(up.temp_deduction),0) as temp_deduction, IFNULL(sum(up.other_deduction),0) as other_deduction,';
        $sqlstring .= 'IFNULL(sum(up.prior_deduction),0) as prior_deduction, IFNULL(sum(up.had_debt),0) as had_debt, IFNULL(sum(up.debt),0) as debt,';
        $sqlstring .= 'IFNULL(sum(up.tax_diff),0) as tax_diff, IFNULL(sum(up.personal_tax),0) as personal_tax,';
        $sqlstring .= 'IFNULL(sum(up.instead_salary),0) as instead_salary, IFNULL(sum(up.bank_salary),0) as bank_salary,';
        $sqlstring .= 'IFNULL(sum(up.debt_salary),0) as debt_salary, IFNULL(sum(up.court_salary),0) as court_salary ';
        $sqlstring .= 'FROM departments d ';
        $sqlstring .= 'LEFT JOIN (';

        $sqlstring .= 'SELECT departments.dwdm, u.user_id,';
        $sqlstring .= 'IFNULL(sum(w.wage),0) as wage, IFNULL(sum(w.retained_wage),0) as retained_wage,';
        $sqlstring .= 'IFNULL(sum(w.compensation),0) as compensation, IFNULL(sum(w.night_shift),0) as night_shift,';
        $sqlstring .= 'IFNULL(sum(w.overtime_wage),0) as overtime_wage, IFNULL(sum(w.seniority_wage),0) as seniority_wage,';
        $sqlstring .= 'IFNULL(sum(w.jbylj),0) as jbylj, IFNULL(sum(w.zj),0) as zj,';
        $sqlstring .= 'IFNULL(sum(w.gjxj),0) as gjxj, IFNULL(sum(w.dfxj),0) as dfxj, IFNULL(sum(w.hyxj),0) as hyxj,';
        $sqlstring .= 'IFNULL(sum(w.qydzf),0) as qydzf, IFNULL(sum(w.qyxj),0) as qyxj,';
        $sqlstring .= 'IFNULL(sum(w.ltxbc),0) as ltxbc, IFNULL(sum(w.wage_total),0) as wage_total,';
        // 当月奖金，不是该会计期的奖金。需要上传当月奖金.
        $sqlstring .= 'IFNULL(sum(tb.month_bonus),0) as month_bonus,';
        $sqlstring .= 'IFNULL(sum(s.communication),0) as communication, IFNULL(sum(s.traffic),0) as traffic,';
        $sqlstring .= 'IFNULL(sum(s.housing),0) as housing, IFNULL(sum(s.single),0) as single,';
        $sqlstring .= 'IFNULL(sum(r.reissue_wage),0) as reissue_wage, IFNULL(sum(r.reissue_subsidy),0) as reissue_subsidy,';
        $sqlstring .= 'IFNULL(sum(r.reissue_other),0) as reissue_other, IFNULL(sum(r.reissue_total),0) as reissue_total,';
        $sqlstring .= 'IFNULL(sum(i.gjj_person),0) as gjj_person, IFNULL(sum(i.gjj_enterprise),0) as gjj_enterprise,';
        $sqlstring .= 'IFNULL(sum(i.annuity_person),0) as annuity_person, IFNULL(sum(i.annuity_enterprise),0) as annuity_enterprise,';
        $sqlstring .= 'IFNULL(sum(i.retire_person),0) as retire_person, IFNULL(sum(i.retire_enterprise),0) as retire_enterprise,';
        $sqlstring .= 'IFNULL(sum(i.medical_person),0) as medical_person, IFNULL(sum(i.medical_enterprise),0) as medical_enterprise,';
        $sqlstring .= 'IFNULL(sum(i.unemployment_person),0) as unemployment_person, IFNULL(sum(i.unemployment_enterprise),0) as unemployment_enterprise,';
        $sqlstring .= 'IFNULL(sum(i.injury_enterprise),0) as injury_enterprise, IFNULL(sum(i.birth_enterprise),0) as birth_enterprise,';
        $sqlstring .= 'IFNULL(sum(de.cc_water),0) as cc_water, IFNULL(sum(de.cc_electric),0) as cc_electric,';
        $sqlstring .= 'IFNULL(sum(de.xy_water),0) as xy_water, IFNULL(sum(de.xy_electric),0) as xy_electric,';
        $sqlstring .= 'IFNULL(sum(de.garage_water),0) as garage_water, IFNULL(sum(de.garage_electric),0) as garage_electric,';
        $sqlstring .= 'IFNULL(sum(de.back_water),0) as back_water, IFNULL(sum(de.back_electric),0) as back_electric,';
        $sqlstring .= 'IFNULL(sum(de.water_electric),0) as water_electric, IFNULL(sum(de.property_fee),0) as property_fee,';
        $sqlstring .= 'IFNULL(sum(de.union_deduction),0) as union_deduction, IFNULL(sum(de.car_fee),0) as car_fee,';
        $sqlstring .= 'IFNULL(sum(de.fixed_deduction),0) as fixed_deduction, IFNULL(sum(de.temp_deduction),0) as temp_deduction, IFNULL(sum(de.other_deduction),0) as other_deduction,';
        $sqlstring .= 'IFNULL(sum(de.prior_deduction),0) as prior_deduction, IFNULL(sum(de.had_debt),0) as had_debt, IFNULL(sum(de.debt),0) as debt,';
        $sqlstring .= 'IFNULL(sum(t.tax_diff),0) as tax_diff, IFNULL(sum(t.personal_tax),0) as personal_tax,';
        $sqlstring .= 'IFNULL(sum(sp.instead_salary),0) as instead_salary, IFNULL(sum(sp.bank_salary),0) as bank_salary,';
        $sqlstring .= 'IFNULL(sum(sp.debt_salary),0) as debt_salary, IFNULL(sum(sp.court_salary),0) as court_salary ';
        $sqlstring .= 'FROM userprofile u ';
        $sqlstring .= 'LEFT JOIN departments ON departments.id = u.department_id ';
        $sqlstring .= 'LEFT JOIN wage w ON u.policyNumber = w.policyNumber AND w.period_id = :pid1 ';
        $sqlstring .= 'LEFT JOIN subsidy s ON u.policyNumber = s.policyNumber AND s.period_id = :pid2 ';
        $sqlstring .= 'LEFT JOIN reissue r ON u.policyNumber = r.policyNumber AND r.period_id = :pid3 ';
        $sqlstring .= 'LEFT JOIN insurances i ON u.policyNumber = i.policyNumber AND i.period_id = :pid4 ';
        $sqlstring .= 'LEFT JOIN deduction de ON u.policyNumber = de.policyNumber AND de.period_id = :pid5 ';
        $sqlstring .= 'LEFT JOIN special sp ON u.policyNumber = sp.policyNumber AND sp.period_id = :pid6 ';
        $sqlstring .= 'LEFT JOIN taximport t ON u.policyNumber = t.policyNumber AND t.period_id = :pid7 ';
        $sqlstring .= 'LEFT JOIN tempbonus tb ON u.policyNumber = tb.policyNumber ';
        $sqlstring .= "WHERE departments.dwdm LIKE '01%' ";
        $sqlstring .= 'GROUP BY departments.dwdm, u.user_id ';
        $sqlstring .= ") up ON up.dwdm LIKE CONCAT(d.dwdm, '%') ";
        $sqlstring .= "WHERE d.dwdm LIKE '01%' ";
        $sqlstring .= 'GROUP BY d.id, d.dwdm, d.name ';
        $sqlstring .= 'ORDER BY d.id';

        $data = DB::select($sqlstring, [
            ':pid1' => $periodId,
            ':pid2' => $periodId,
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

    public function transformData($vid, $pid): array
    {
        $templates = VoucherTemplate::where('vid', $vid)->get();
        $statistics = VoucherStatistic::where('period_id', $pid)->get();

        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $data = [];
        foreach ($templates as $k => $t) {
            $segments = explode('.', $t['subject_no']);
            $des = explode(',', $t['subject_description']);

            $data[$k]['id'] = $t->id;
            $data[$k]['seg_des'] = $t->name;
            $data[$k]['seg0'] = $segments[0];
            $data[$k]['seg1'] = $segments[1];
            $data[$k]['seg2'] = $segments[2];
            $data[$k]['seg3'] = $segments[3];
            $data[$k]['seg4'] = $segments[4];
            $data[$k]['seg5'] = $segments[5];
            $data[$k]['debit'] = $this->calDebit(random_int(100, 1000));
            $data[$k]['credit'] = $this->calCredit(random_int(100, 1000));
            $data[$k]['detail_des'] = $des[0].$year.'年'.$month.'月'.$des[1];
        }

        return $data;
    }

    private function calDebit($value):float
    {
        return $value * 0.6;
    }

    private function calCredit($value):float
    {
        return $value * 0.8;
    }
}
