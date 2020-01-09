<?php

namespace App\Repository;

use App\Models\Message;
use App\Models\Users\UserProfile;
use Carbon\Carbon;

class MessageRepository
{
    /**
     * 获取用户的站内信信息.
     *
     * @param $user_id
     * @return array
     */
    public function getMsg($user_id)
    {
        $data = [];
        $data['count'] = Message::where('receiver', $user_id)->where('isread', 0)
            ->get()->count();
        $data['sysMsg'] = Message::where('receiver', $user_id)
            ->where('type_id', 0)
            ->where('isread', 0)
            ->selectRaw('count(*) as msgcount, max(updated_at) as lastdate')->first();
        $data['depMsg'] = Message::where('receiver', $user_id)
            ->where('type_id', 1)
            ->where('isread', 0)
            ->selectRaw('count(*) as msgcount, max(updated_at) as lastdate')->first();

        return $data;
    }

    /**
     * 将excel上传的内容转化成 数据库对应格式.
     *
     * @param int   $userId 发送者ID
     * @param array $import
     * @return mixed
     */
    public function transMsg($userId, $import)
    {
        $res = [];

        foreach ($import as $k => $item) {
            if (isset($item['保险编号']) && isset($item['发送内容'])) {
                $res[$k]['sender'] = $userId;
                $res[$k]['receiver'] = UserProfile::where('policyNumber', $item['保险编号'])->first()->user_id;
                $res[$k]['type_id'] = 0;
                $res[$k]['content'] = $item['发送内容'];
                $res[$k]['created_at'] = Carbon::now();
                $res[$k]['updated_at'] = Carbon::now();
            } else {
                continue;
            }
        }

        return $res;
    }
}
