<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'continent_name', 'continent_alias'
    ];

    /**
     * Relationship between country and continent
     */
    public function countries(){
        return $this->hasMany(Country::class);
    }

    /**
     * Add a country
     */
    public function addCountry($input){
        // dd($input);
       return $this->countries()->create($input);
        // return $this->hasMany(Country::class);
    }
}
