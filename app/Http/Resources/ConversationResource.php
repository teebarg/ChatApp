<?php

namespace App\Http\Resources;

class ConversationResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'message' => $this->message,
            'status' => $this->status,
            'from' => $this->user->username,
            'time' => $this->created_at->diffForHumans()
        ];
    }
}
