<?php

namespace App\Exports;

use App\Game;
use Maatwebsite\Excel\Concerns\FromCollection;

class GameExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Game::all();
    }
}
