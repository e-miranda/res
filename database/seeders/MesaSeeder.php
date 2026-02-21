
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    Mesa::insert([
    ['numero' => 1, 'capacidad' => 4],
    ['numero' => 2, 'capacidad' => 2],
    ['numero' => 3, 'capacidad' => 6],
]);

    public function run(): void
    {
        //
    }
}
