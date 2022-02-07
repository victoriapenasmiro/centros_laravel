<?php

namespace Database\Seeders;

use App\Models\Ambito;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmbitoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ambitos = [
            ['nombre' => 'infantil'],
            ['nombre' => 'primaria'],
            ['nombre' => 'eso'],
            ['nombre' => 'bachiller'],
            ['nombre' => 'fp'],
        ];

        //QueryBuilder
        DB::table('ambitos')->insert($ambitos);
    }
}
