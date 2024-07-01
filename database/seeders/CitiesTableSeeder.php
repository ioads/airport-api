<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            ['name' => 'Recife', 'uf' => 'PE'],
            ['name' => 'Salvador', 'uf' => 'BA'],
            ['name' => 'Fortaleza', 'uf' => 'CE'],
            ['name' => 'Natal', 'uf' => 'RN'],
            ['name' => 'João Pessoa', 'uf' => 'PB'],
            ['name' => 'Maceió', 'uf' => 'AL'],
            ['name' => 'São Luís', 'uf' => 'MA'],
            ['name' => 'Teresina', 'uf' => 'PI'],
            ['name' => 'Aracaju', 'uf' => 'SE'],
            ['name' => 'São Paulo', 'uf' => 'SP'],
            ['name' => 'Rio de Janeiro', 'uf' => 'RJ'],
            ['name' => 'Belo Horizonte', 'uf' => 'MG'],
            ['name' => 'Vitória', 'uf' => 'ES'],
        ];

        $cityIds = DB::table('cities')->insert($cities);
    }
}
