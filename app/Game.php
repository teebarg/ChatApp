<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table='games';
    protected $fillable=['match_date','division','match','odd','result','status_id','market_id','booking_number','close'];

    public static $rules=[
        'game_status_id'=>'required|int|exists:statuses,id',
        'market_id'=>'required|int|exists:markets,id',
        'booking_number'=>'required|string|unique:games',
        'game_date'=>'required|string',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'result' => '0-0'
    ];

    public function statuses() {
        $this->hasOne(Status::class);
    }
    public function markets() {
        $this->hasOne(Market::class);
    }
}
