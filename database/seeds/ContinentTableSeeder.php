<?php

use Illuminate\Database\Seeder;
use App\Continent;
use Illuminate\Support\Str;

class ContinentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['Africa', 'Asia', 'Europe', 'North America', 'South America'];
        for ($i=0; $i<count($data); $i++){
            Continent::create([
                'continent_name' => $data[$i],
                'continent_alias' => Str::random(4),
            ]);
        }
    }
}
