<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_name', 'country_alias', 'continent_id'
    ];


    /**
     * Relationship between country and continent
     */
    public function continent(){
        return $this->belongsTo(Continent::class);
    }

    /**
     * Relationship between country and state
     */
    public function states(){
        return $this->hasMany(State::class);
    }
}
