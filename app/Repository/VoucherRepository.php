<?php

namespace App\Repository;

use Carbon\Carbon;
use DB;

class VoucherRepository
{
    private const WATER_TAX = 0.09;         // 水销项税
    private const UNION_FEE = 0.02;         // 工会经费
    private const EDUCATION_FEE = 0.0174;   // 教育经费

    /**
     * 根据模板生成凭证数据.
     *
     * @param array $templates 凭证模板
     * @param int   $periodId  会计期间ID
     * @return array
     */
    public function getVoucherData($templates, $periodId): array
    {
        $data = [];
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;

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

            if (false === strpos($t->subject_method, 'select')) {
                $data[$k]['debit'] = 0.00;
                $data[$k]['credit'] = 0.00;
            } else {
                $sql = str_replace('period_id = ?', 'period_id = '.$periodId.' ', $t->subject_method);
                if (0 === $t->isLoan) {
                    $data[$k]['debit'] = DB::selectOne($sql)->money;
                    $data[$k]['credit'] = 0.00;
                } else {
                    $data[$k]['debit'] = 0.00;
                    $data[$k]['credit'] = DB::selectOne($sql)->money;
                }
            }

            if (1 === count($des)) {
                $data[$k]['detail_des'] = $des[0];
            } else {
                $data[$k]['detail_des'] = $des[0].$year.'年'.$month.'月'.$des[1];
            }
        }

        // 部分数据可以直接由其他数据计算获得
        return $this->extraRule($templates[0]->vid, $data, $periodId);
    }

    /**
     * 根据模板ID，计算部分字段（不由数据库获取的）.
     *
     * @param int   $tid  模板ID
     * @param array $data 凭证数据
     * @param int   $period_id 会计期间ID
     * @return mixed
     */
    public function extraRule($tid, $data, $period_id): array
    {
        switch ($tid) {
            case 1: // 工资发放凭证
                $data[7]['credit'] = $data[7]['credit'] - $data[6]['credit'] - $data[13]['credit'];
                $data[10]['debit'] -= $data[13]['debit'];
                $data[12]['debit'] = round(($data[10]['debit'] / (1 + self::WATER_TAX) * self::WATER_TAX), 2);
                $data[11]['debit'] = $data[10]['debit'] - $data[12]['debit'];
                break;
            case 2: // 其他工资凭证
                $data[21]['debit'] = $data[21]['debit'] - $data[20]['debit'] - $data[19]['debit'];
                $data[24]['debit'] = $data[24]['debit'] - $data[23]['debit'] - $data[22]['debit'];
                $data[28]['debit'] = $data[28]['debit'] - $data[15]['debit'] - $data[29]['debit'] - $data[30]['debit'] - $data[31]['debit'] - $data[32]['debit'] - $data[33]['debit'];
                $data[52]['debit'] = $data[52]['debit'] - $data[51]['debit'] - $data[50]['debit'];
                $data[55]['debit'] = $data[55]['debit'] - $data[54]['debit'] - $data[53]['debit'];
                $data[59]['debit'] = $data[59]['debit'] - $data[46]['debit'] - $data[60]['debit'] - $data[61]['debit'] - $data[62]['debit'] - $data[63]['debit'] - $data[64]['debit'];
                $data[83]['debit'] = $data[83]['debit'] - $data[82]['debit'] - $data[81]['debit'];
                $data[86]['debit'] = $data[86]['debit'] - $data[85]['debit'] - $data[84]['debit'];
                $data[90]['debit'] = $data[90]['debit'] - $data[77]['debit'] - $data[91]['debit'] - $data[92]['debit'] - $data[93]['debit'] - $data[94]['debit'] - $data[95]['debit'];
                break;
            case 3: // 关联方
                $data[0]['debit'] = 0;
                $data[18]['debit'] = 0;
                $data[36]['debit'] = 0;
                $data[54]['debit'] = 0;
                $data[72]['debit'] = 0;
                $data[79]['debit'] = 0;
                $data[97]['debit'] = 0;

                for ($i = 1; $i <= 17; ++$i) {
                    if (2 === $i) {
                        continue;
                    }
                    if (3 === $i) {
                        continue;
                    }

                    $data[0]['debit'] += $data[$i]['credit'];
                }

                for ($i = 19; $i <= 35; ++$i) {
                    if (20 === $i) {
                        continue;
                    }
                    if (21 === $i) {
                        continue;
                    }

                    $data[18]['debit'] += $data[$i]['credit'];
                }

                for ($i = 37; $i <= 53; ++$i) {
                    if (38 === $i) {
                        continue;
                    }
                    if (39 === $i) {
                        continue;
                    }

                    $data[36]['debit'] += $data[$i]['credit'];
                }

                for ($i = 55; $i <= 71; ++$i) {
                    if (57 === $i) {
                        continue;
                    }
                    if (56 === $i) {
                        continue;
                    }

                    $data[54]['debit'] += $data[$i]['credit'];
                }

                for ($i = 73; $i <= 78; ++$i) {
                    $data[72]['debit'] += $data[$i]['credit'];
                }

                for ($i = 80; $i <= 96; ++$i) {
                    if (81 === $i) {
                        continue;
                    }
                    if (82 === $i) {
                        continue;
                    }

                    $data[79]['debit'] += $data[$i]['credit'];
                }

                for ($i = 98; $i <= 107; ++$i) {
                    if (99 === $i) {
                        continue;
                    }
                    if (100 === $i) {
                        continue;
                    }

                    $data[97]['debit'] += $data[$i]['credit'];
                }

                $data[112]['credit'] = round(($data[110]['debit'] / (1 + self::WATER_TAX) * self::WATER_TAX), 2);
                $data[111]['credit'] = $data[112]['credit'] - $data[110]['debit'];

                break;
            case 4: // 年金
            case 5: // 退养金
                $data[2]['debit'] = 0;

                $data[22]['debit'] = $data[22]['debit'] - $data[21]['debit'] - $data[20]['debit'];
                $data[25]['debit'] = $data[25]['debit'] - $data[24]['debit'] - $data[23]['debit'];
                $data[29]['debit'] = $data[29]['debit'] - $data[34]['debit'] - $data[33]['debit'] - $data[32]['debit'] - $data[31]['debit'] - $data[30]['debit'] - $data[16]['debit'];

                for ($i = 4; $i <= 34; ++$i) {
                    $data[2]['debit'] += $data[$i]['debit'];
                }

                $data[3]['credit'] = $data[2]['debit'];
                $data[0]['credit'] = $data[1]['debit'] + $data[2]['debit'];
                break;
            case 6: // 公积金
                $data[0]['credit'] = 0;
                $data[12]['debit'] = 0;

                $data[32]['debit'] = $data[32]['debit'] - $data[31]['debit'] - $data[30]['debit'];
                $data[35]['debit'] = $data[35]['debit'] - $data[34]['debit'] - $data[33]['debit'];
                $data[39]['debit'] = $data[39]['debit'] - $data[44]['debit'] - $data[43]['debit'] - $data[42]['debit'] - $data[41]['debit'] - $data[40]['debit'] - $data[26]['debit'];

                for ($i = 14; $i <= 44; ++$i) {
                    $data[12]['debit'] += $data[$i]['debit'];
                }

                $data[13]['credit'] = $data[12]['debit'];

                for ($i = 1; $i <= 12; ++$i) {
                    if ($i <= 4) {
                        $data[0]['credit'] -= $data[$i]['credit'];
                    }
                    $data[0]['credit'] += $data[$i]['debit'];
                }

                break;
            case 7: // 保险费
                $data[6]['debit'] = 0;
                $data[7]['credit'] = 0;
                $data[19]['debit'] = 0;
                $data[20]['debit'] = 0;
                $data[21]['debit'] = 0;
                $data[22]['debit'] = 0;
                $data[23]['credit'] = 0;
                $data[24]['credit'] = 0;
                $data[25]['credit'] = 0;
                $data[26]['credit'] = 0;

                $data[45]['debit'] = $data[45]['debit'] - $data[44]['debit'] - $data[43]['debit'];
                $data[48]['debit'] = $data[48]['debit'] - $data[47]['debit'] - $data[46]['debit'];
                $data[52]['debit'] = $data[52]['debit'] - $data[57]['debit'] - $data[56]['debit'] - $data[55]['debit'] - $data[54]['debit'] - $data[53]['debit'] - $data[39]['debit'];

                $data[76]['debit'] = $data[76]['debit'] - $data[75]['debit'] - $data[74]['debit'];
                $data[79]['debit'] = $data[79]['debit'] - $data[78]['debit'] - $data[77]['debit'];
                $data[83]['debit'] = $data[83]['debit'] - $data[88]['debit'] - $data[87]['debit'] - $data[86]['debit'] - $data[85]['debit'] - $data[84]['debit'] - $data[70]['debit'];

                $data[107]['debit'] = $data[107]['debit'] - $data[106]['debit'] - $data[105]['debit'];
                $data[110]['debit'] = $data[110]['debit'] - $data[109]['debit'] - $data[108]['debit'];
                $data[114]['debit'] = $data[114]['debit'] - $data[119]['debit'] - $data[118]['debit'] - $data[117]['debit'] - $data[116]['debit'] - $data[115]['debit'] - $data[101]['debit'];

                $data[138]['debit'] = $data[138]['debit'] - $data[137]['debit'] - $data[136]['debit'];
                $data[141]['debit'] = $data[141]['debit'] - $data[140]['debit'] - $data[139]['debit'];
                $data[145]['debit'] = $data[145]['debit'] - $data[150]['debit'] - $data[149]['debit'] - $data[148]['debit'] - $data[147]['debit'] - $data[146]['debit'] - $data[132]['debit'];

                for ($i = 27; $i <= 57; ++$i) {
                    $data[19]['debit'] += $data[$i]['debit'];
                    $data[23]['credit'] += $data[$i]['debit'];
                }
                for ($i = 58; $i <= 88; ++$i) {
                    $data[20]['debit'] += $data[$i]['debit'];
                    $data[24]['credit'] += $data[$i]['debit'];
                }
                for ($i = 89; $i <= 119; ++$i) {
                    $data[21]['debit'] += $data[$i]['debit'];
                    $data[25]['credit'] += $data[$i]['debit'];
                }
                for ($i = 120; $i <= 150; ++$i) {
                    $data[22]['debit'] += $data[$i]['debit'];
                    $data[26]['credit'] += $data[$i]['debit'];
                }
                for ($i = 8; $i <= 22; ++$i) {
                    $data[6]['debit'] += $data[$i]['debit'];
                    $data[7]['credit'] += $data[$i]['debit'];
                }

                $data[0]['credit'] = $data[6]['debit'] - $data[5]['credit'] - $data[4]['credit'] - $data[3]['credit'] - $data[2]['credit'] - $data[1]['credit'];

                break;
            case 8: // 计提费用
                $data[16]['debit'] += $this->slowCal(self::UNION_FEE, $period_id, '0101010902');
                $data[20]['debit'] += $this->slowCal(self::UNION_FEE, $period_id, '0101010302');
                $data[21]['debit'] += $this->slowCal(self::UNION_FEE, $period_id, '0101010303');
                $data[22]['debit'] += $this->slowCal(self::UNION_FEE, $period_id, '0101010304');
                $data[23]['debit'] += $this->slowCal(self::UNION_FEE, $period_id, '0101010402');
                $data[24]['debit'] += $this->slowCal(self::UNION_FEE, $period_id, '0101010403');
                $data[25]['debit'] += $this->slowCal(self::UNION_FEE, $period_id, '0101010404');
                $data[29]['debit'] += $this->slowCal(self::UNION_FEE, $period_id, '0101010908');
                $data[30]['debit'] += $this->slowCal(self::UNION_FEE, $period_id, '0101010903');
                $data[31]['debit'] += $this->slowCal(self::UNION_FEE, $period_id, '0101010904');
                $data[32]['debit'] += $this->slowCal(self::UNION_FEE, $period_id, '0101010905');

                $data[47]['debit'] += $this->slowCal(self::EDUCATION_FEE, $period_id, '0101010902');
                $data[51]['debit'] += $this->slowCal(self::EDUCATION_FEE, $period_id, '0101010302');
                $data[52]['debit'] += $this->slowCal(self::EDUCATION_FEE, $period_id, '0101010303');
                $data[53]['debit'] += $this->slowCal(self::EDUCATION_FEE, $period_id, '0101010304');
                $data[54]['debit'] += $this->slowCal(self::EDUCATION_FEE, $period_id, '0101010402');
                $data[55]['debit'] += $this->slowCal(self::EDUCATION_FEE, $period_id, '0101010403');
                $data[56]['debit'] += $this->slowCal(self::EDUCATION_FEE, $period_id, '0101010404');
                $data[60]['debit'] += $this->slowCal(self::EDUCATION_FEE, $period_id, '0101010908');
                $data[61]['debit'] += $this->slowCal(self::EDUCATION_FEE, $period_id, '0101010903');
                $data[62]['debit'] += $this->slowCal(self::EDUCATION_FEE, $period_id, '0101010904');
                $data[63]['debit'] += $this->slowCal(self::EDUCATION_FEE, $period_id, '0101010905');

                for ($i = 5; $i <= 34; ++$i) {
                    $data[4]['debit'] -= $data[$i]['debit'];
                }
                for ($i = 36; $i <= 65; ++$i) {
                    $data[35]['debit'] -= $data[$i]['debit'];
                }
                break;
            case 9: // 分配表
                $data[26]['debit'] -= $data[24]['debit'];
                $data[33]['debit'] = $data[33]['debit'] - $data[31]['debit'] - $data[29]['debit'];
                $data[49]['debit'] = $data[49]['debit'] - $data[47]['debit'] - $data[45]['debit'] - $data[43]['debit'] - $data[41]['debit'];
                break;
            default:
                $data = [];
                break;
        }

        return $data;
    }

    /**
     * 解决计算耗时的问题。采取两段sql分别计算再相加的方式。能够大大减少sql查询时间。
     *
     * @param float  $rate          经费比例
     * @param int    $period_id     会计期间ID
     * @param string $dwdm          部门字符串
     * @return mixed
     */
    private function slowCal(float $rate, int $period_id, string $dwdm)
    {
        $sqlstring = 'SELECT ROUND(a.money * b.rate * '. $rate .', 2) AS money FROM ';
        $sqlstring .= '(SELECT SUM(wage) AS money FROM view_fenpei_total WHERE period_id = '. $period_id .') a, ';
        $sqlstring .= '(SELECT SUM(rate) AS rate FROM view_fenpei_total WHERE period_id = ' . $period_id ." AND dwdm = '". $dwdm ."') b";

        return DB::selectOne($sqlstring)->money;
    }
}
