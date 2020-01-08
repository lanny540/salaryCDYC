<?php

namespace App\Repository;

use App\Models\Message;

class MessageRepository
{
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
}
