<?php


namespace App\Repositries;

use App\State;

class StateRepository extends Repository
{
    /**
     * Specify Model class name
     * @return mixed
     */
    public function model()
    {
        return State::class;
    }
}
