<?php

namespace App\Http\Controllers;

use App\Models\Salary\BonusDetail;
use App\Models\Salary\BonusType;
use App\Models\Users\User;
use App\Models\Voucher\VoucherData;
use App\Models\WorkFlow\WorkFlow;
use App\Services\DataProcess;
use DB;
use File;
use Illuminate\Http\Request;
use Storage;
use Validator;

class SyncController extends Controller
{
    private $dataProcess;

    public function __construct(DataProcess $dataProcess)
    {
        $this->dataProcess = $dataProcess;
    }

    // 凭证同步至ERP
    public function erpSync($id)
    {
        $v = VoucherData::findOrFail($id);
        return $v;
    }

    public function xtSync(Request $request)
    {
        $rules = [
            'name' => 'required',
            'uid' => 'required',
            'record' => 'required | numeric | gte:1',
            'money' => 'required | numeric | gte:0.01',
            'upload_file' => 'required | file',
            'upload_data' => 'required | array'
        ];
        $messages = [
            'name.required' => '数据分类不能为空',
            'uid.required' => '同步人员的员工编号不能为空',
            'record.numeric' => '记录数必须是数字',
            'record.gte' => '记录数必须大于0',
            'money.numeric' => '发放金额必须是数字',
            'money.gte' => '发放金额合计必须大于0.01',
            'upload_file' => '附件没有上传',
            'upload_data.required' => '同步数据不能为空',
            'upload_data.array' => '同步数据必须是数组',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'messages' => $validator->errors()
            ], 412);
        }

        try {
            DB::beginTransaction();

            $user = User::where('name', $request->get('uid'))->firstOrFail();
            $period_id = $this->dataProcess->getPeriodId();
            // 保存文件至本地
            $file = $_FILES['upload_file'];
            $arr = explode('.', $file['name']);
            $fileName = uniqid('excel_', false).'.'.end($arr);
            $content = File::get($file['tmp_name']);
            Storage::disk('excelFiles')->put($fileName, $content);
            $uploadfile = asset('/storage/excelFiles/'.$fileName);

            $w = WorkFlow::create([
                'period_id' => $period_id,
                'name' => $request->get('name'),
                'uploader' => $user->id,
                'upload_file' => $uploadfile,
                'isconfirm' => 0,
                'record' => $request->get('record'),
                'money' => $request->get('money'),
            ]);

            $data = $request->get('upload_data');
            $type = BonusType::where('type', $request->get('name'))->firstOrFail();
            foreach ($data as $d) {
                BonusDetail::create([
                    'wf_id' => $w->id,
                    'type_id' => $type->id,
                    'policynumber' => $d['policynumber'],
                    'period_id' => $w->period_id,
                    'money' => $d['money'],
                    'card' => $d['card'],
                    'remarks' => $d['remarks'] ?? '',
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'data' => [],
                'messages' => '数据保存错误'
            ], 500);
        }

        return response()->json([
            'data' => $w->upload_file,
            'messages' => '数据同步完成'
        ], 201);
    }
}
