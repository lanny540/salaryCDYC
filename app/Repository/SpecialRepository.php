<?php

namespace App\Repository;

use App\Services\DataProcess;
use DB;

/**
 * Class SpecialRepository
 * 专项税务数据导出.
 */
class SpecialRepository
{
    private $dataProcess;

    public function __construct(DataProcess $dataProcess)
    {
        $this->dataProcess = $dataProcess;
    }

    /**
     * 根据导出类型，返回结果数据.
     * 包括数据，字段名，文件名.
     *
     * @param $exportType
     *
     * @return array|mixed
     */
    public function exportSpecialData($exportType)
    {
        $period = $this->dataProcess->getPeriodId();
        switch ($exportType) {
            case 42:
                $res = $this->salaryExport($period, 1);
                break;
            case 43:
                $res = $this->salaryExport($period, 2);
                break;
            case 44:
                $res = $this->articleExport($period, 1);
                break;
            case 45:
                $res = $this->articleExport($period, 2);
                break;
            case 46:
                $res = $this->franchiseExport($period, 1);
                break;
            case 47:
                $res = $this->franchiseExport($period, 2);
                break;
            default:
                $res = [];
        }

        return $res;
    }

    /**
     * 工资薪金数据导出.
     *
     * @param int $period 会计周期ID
     * @param int $type   标识第一次还是第二次导出
     *
     * @return mixed
     */
    private function salaryExport(int $period, int $type)
    {
        $res['headings'] = [
            '工号', '姓名', '证照类型', '证照号码',
            '本期收入', '本期免税收入',
            '基本养老保险费', '基本医疗保险费', '失业保险费', '住房公积金',
            '累计子女教育', '累计继续教育', '累计住房贷款利息', '累计住房租金', '累计赡养老人',
            '企业(职业)年金', '商业健康保险', '税延养老保险',
            '其他', '准予扣除的捐赠额', '减免税额', '备注',
        ];

        if (1 == $type) {
            $res['filename'] = date('Ym').'_工资薪金一次导出.xlsx';
            $res['data'] = $this->getSalaryData($period, 1);
        } else {
            $res['filename'] = date('Ym').'_工资薪金二次导出.xls';
            $res['data'] = $this->getSalaryData($period, 2);
        }

        return $res;
    }

    /**
     * 获取工资薪金导出数据.
     *
     * @param int $period 会计期ID
     * @param int $type   标识第一次还是第二次导出
     *
     * @return array
     */
    private function getSalaryData(int $period, int $type)
    {
        $sqlstring = "SELECT up.policyNumber as '工号', up.userName as '姓名', '居民身份证' as '证照类型', up.uid as '证照号码',";
        $sqlstring .= "IFNULL(s.salary_total, 0) as '本期收入', 0 as '本期免税收入',";
        $sqlstring .= "IFNULL(i.retire_deduction, 0) as '基本养老保险费', IFNULL(i.medical_deduction, 0) as '基本医疗保险费',";
        $sqlstring .= "IFNULL(i.unemployment_deduction, 0) as '失业保险费', IFNULL(i.gjj_deduction, 0) as '住房公积金',";
        $sqlstring .= "0 as '累计子女教育', 0 as '累计继续教育', 0 as '累计住房贷款利息', 0 as '累计住房租金', 0 as '累计赡养老人',";
        $sqlstring .= "IFNULL(i.annuity_deduction, 0) as '企业(职业)年金', 0 as '商业健康保险', 0 as '税延养老保险',";
        $sqlstring .= "IFNULL(d.sum_deduction, 0) as '其他', 0 as '准予扣除的捐赠额',";
        if (1 == $type) {
            $sqlstring .= "0 as '减免税额',";
        } else {
            $sqlstring .= "IFNULL(t.reduce_tax, 0) as '减免税额',";
        }

        $sqlstring .= "IFNULL(d.car_deduction_comment, '')as '备注'";
        $sqlstring .= ' FROM userprofile up';
        $sqlstring .= ' LEFT JOIN summary s ON up.policyNumber = s.policyNumber AND s.period_id = ? ';
        $sqlstring .= ' LEFT JOIN insurances i ON up.policyNumber = i.policyNumber AND i.period_id = ? ';
        $sqlstring .= ' LEFT JOIN deduction d ON up.policyNumber = d.policyNumber AND d.period_id = ?';
        $sqlstring .= ' LEFT JOIN taxImport t ON up.policyNumber = t.policyNumber AND t.period_id = ?';
        $data = DB::select($sqlstring, [$period, $period, $period, $period]);

        return $data;
    }

    /**
     * 稿酬数据导出.
     *
     * @param int $period 会计周期ID
     * @param int $type   标识第一次还是第二次导出
     * @return mixed
     */
    private function articleExport(int $period, int $type)
    {
        $res['headings'] = [
            '工号', '姓名', '证照类型', '证照号码',
            '本期收入', '本期免税收入',
            '其他', '准予扣除的捐赠额', '减免税额', '备注',
        ];

        if (1 == $type) {
            $res['data'] = $this->getArticleData($period, 1);
            $res['filename'] = date('Ym').'_稿酬一次导出.xls';
        } else {
            $res['data'] = $this->getArticleData($period, 2);
            $res['filename'] = date('Ym').'_稿酬二次导出.xls';
        }
        return $res;
    }

    /**
     * 获取稿酬导出数据.
     *
     * @param int $period 会计期ID
     * @param int $type   标识第一次还是第二次导出
     *
     * @return array
     */
    private function getArticleData(int $period, int $type)
    {
        $sqlstring = "SELECT up.policyNumber as '工号', up.userName as '姓名', '居民身份证' as '证照类型', up.uid as '证照号码',";
        $sqlstring .= "IFNULL(o.article_fee, 0) as '本期收入', 0 as '本期免税收入',";
        $sqlstring .= "0 as '其他', 0 as '准予扣除的捐赠额',";
        if (1 == $type) {
            $sqlstring .= "0 as '减免税额',";
        } else {
            $sqlstring .= "IFNULL(o.article_sub_tax, 0) as '减免税额',";
        }
        $sqlstring .= "' ' as '备注'";
        $sqlstring .= ' FROM userprofile up';
        $sqlstring .= ' LEFT JOIN other o ON up.policyNumber = o.policyNumber AND o.period_id = ? ';

        $data = DB::select($sqlstring, [$period]);
        return $data;
    }

    /**
     * 特许权数据导出.
     *
     * @param int $period 会计周期ID
     * @param int $type   标识第一次还是第二次导出
     * @return mixed
     */
    private function franchiseExport(int $period, int $type)
    {
        $res['headings'] = [
            '工号', '姓名', '证照类型', '证照号码',
            '本期收入', '本期免税收入',
            '其他', '准予扣除的捐赠额', '减免税额', '备注',
        ];
        if (1 == $type) {
            $res['data'] = $this->getFranchiseData($period, 1);
            $res['filename'] = date('Ym').'_特许权一次导出.xls';
        } else {
            $res['data'] = $this->getFranchiseData($period, 2);
            $res['filename'] = date('Ym').'_特许权二次导出.xls';
        }

        return $res;
    }

    /**
     * 获取特许权导出数据.
     *
     * @param int $period 会计期ID
     * @param int $type   标识第一次还是第二次导出
     *
     * @return array
     */
    private function getFranchiseData(int $period, int $type)
    {
        $sqlstring = "SELECT up.policyNumber as '工号', up.userName as '姓名', '居民身份证' as '证照类型', up.uid as '证照号码',";
        $sqlstring .= "IFNULL(o.franchise, 0) as '本期收入', 0 as '本期免税收入',";
        $sqlstring .= "0 as '其他', 0 as '准予扣除的捐赠额',";
        if (1 == $type) {
            $sqlstring .= "0 as '减免税额',";
        } else {
            $sqlstring .= "IFNULL(o.franchise_sub_tax, 0) as '减免税额',";
        }
        $sqlstring .= "' ' as '备注'";
        $sqlstring .= ' FROM userprofile up';
        $sqlstring .= ' LEFT JOIN other o ON up.policyNumber = o.policyNumber AND o.period_id = ? ';

        $data = DB::select($sqlstring, [$period]);
        return $data;
    }
}
