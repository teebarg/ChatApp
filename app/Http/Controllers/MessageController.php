<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Events\NewMessageEvent;
use App\Events\NewPrivateMessage;
use App\Helpers\ResponseCodes;
use App\Helpers\ResponseHelper;
use App\Helpers\ResponseMessages;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\PrivateMessageResource;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends BaseController
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function send()
    {
        $data = $this->validate(request(), [
            'to' => 'required|exists:users,id',
            'message' => 'required|max:256',
        ]);

        $message = auth()->user()->messages()->create($data);
        broadcast(new NewPrivateMessage($message))->toOthers();
        return new PrivateMessageResource($message);
    }

    public function messages($id)
    {

        $message = Message::where(function ($query) use ($id) {
            $query->where([['user_id', '=', auth()->user()->id], ['to', '=', $id]])
                    ->orWhere([['user_id', '=', $id], ['to', '=', auth()->user()->id]]);
            })->orderBy('created_at', 'desc')->paginate(20);
        return PrivateMessageResource::collection($message)
            ->additional(ResponseHelper::additionalInfo());
    }
}
