<?php

namespace App\Imports;

use App\Game;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GameImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Game([
            'match_date' => $row['date'],
            'division' => $row['division'],
            'match' => $row['match'],
            'odd' => $row['odd'],
            'status_id' => $row['status'],
            'market_id' => $row['market'],
            'booking_number' => $row['booking_number']
        ]);
    }
}
