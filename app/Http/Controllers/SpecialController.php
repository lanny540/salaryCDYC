<?php

namespace App\Http\Controllers;

use App\Exports\SpecailExport;
use App\Repository\SpecialRepository;
use Excel;
use Illuminate\Http\Request;

class SpecialController extends Controller
{
    private $taxExport;

    public function __construct(SpecialRepository $specialRepository)
    {
        $this->taxExport = $specialRepository;
    }

    /**
     * 专项数据导入导出视图.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('special.index');
    }

    /**
     * 专项数据导出.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function taxExport(Request $request)
    {
        $exportType = $request->get('exportType');

        $res = $this->taxExport->exportSpecialData($exportType);

        if (0 == count($res['data'])) {
            return redirect()->route('special.index')->withErrors('导出错误或者无导出数据!');
        } else {
            return Excel::download(new SpecailExport($res['data'], $res['headings']), $res['filename']);
        }
    }
}
