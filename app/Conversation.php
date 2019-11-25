<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    //
    protected $fillable = [
        'message', 'status', 'user_id'
    ];

    /**
     * Relationship between user and conversation
     */
    public function user(){
        return $this->BelongsTo(User::class);
    }
}
