<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class SpecailExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromCollection, WithHeadings, WithStrictNullComparison, WithCustomValueBinder
{
    use Exportable;

    private $data;
    private $headings;

    public function __construct($data, $headings)
    {
        $this->data = $data;
        $this->headings = $headings;
    }

    //实现FromCollection接口
    public function collection()
    {
        return collect($this->data);
    }

    //实现WithHeadings接口
    public function headings(): array
    {
        return $this->headings;
    }
}
