<?php

namespace App\Http\ViewComposers;

use App\Repository\MessageRepository;
use Auth;
use Illuminate\View\View;

class MsgComposer
{
    protected $messages;

    public function __construct(MessageRepository $msg)
    {
        $this->messages = $msg;
    }

    public function compose(View $view)
    {
        $user_id = Auth::id();
        $view->with('messages', $this->messages->getMsg($user_id));
    }
}
