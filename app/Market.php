<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    protected $tables='markets';
    protected $fillable=['market'];

    public static $rules=[
        'market'=>'required|string|unique:markets',
    ];

    public function games() {
        $this->belongsToMany(Game::class);
    }
}
