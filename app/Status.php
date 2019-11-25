<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $tables='statuses';
    protected $fillable=['status'];

    public static $rules=[
        'status'=>'required|string|unique:statuses',
    ];

    public function games() {
        $this->belongsToMany(Game::class);
    }
}
