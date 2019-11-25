<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Events\NewMessageEvent;
use App\Helpers\ResponseCodes;
use App\Helpers\ResponseHelper;
use App\Helpers\ResponseMessages;
use App\Http\Resources\ContinentResource;
use App\Http\Resources\ConversationResource;
use App\User;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    /**
     * Fetch all messages
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function fetchMessages()
    {
        return ConversationResource::collection(Conversation::orderBy('created_at', 'desc')->with('user')->paginate(20))
            ->additional(ResponseHelper::additionalInfo(ResponseMessages::ACTION_SUCCESSFUL, ResponseCodes::ACTION_SUCCESSFUL));
    }

    /**
     * Persist message to database
     *
     * @param  Request $request
     * @return ConversationResource
     */
    public function sendMessage()
    {
        $conversation = auth()->user()->conversations()->create([
            'message' => request('message'),
            'status' => 'Sent'
        ]);
        broadcast(new NewMessageEvent($conversation))->toOthers();
        return new ConversationResource($conversation);
    }
}
