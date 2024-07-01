<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $flightClasses = [
            ['name' => 'Econômica'],
            ['name' => 'Executiva'],
            ['name' => 'Primeira Classe'],
        ];

        // Inserir os dados na tabela "flight_classes"
        DB::table('classes')->insert($flightClasses);
    }
}
