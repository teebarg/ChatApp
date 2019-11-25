<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\ResponseTrait;

class UserResource extends JsonResource
{
    use ResponseTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'fname' => $this->fname,
            'lname' => $this->lname,
            'mobile' => $this->mobile,
            'image' => $this->image->image ?? ''
        ];
    }
}
