<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'Pending'
    ];

    /**
     * Relationship between user and message
     */
    public function user(){
        return $this->BelongsTo(User::class);
    }
}
