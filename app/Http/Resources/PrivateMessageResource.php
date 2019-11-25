<?php

namespace App\Http\Resources;

use App\User;

class PrivateMessageResource extends BaseResource
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
            'from' => new UserResource($this->user),
            'time' => $this->created_at->diffForHumans()
        ];
    }
}
